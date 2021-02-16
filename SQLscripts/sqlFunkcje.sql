------------------------------------------------- funkcje --------------------------------------------------------------

-- funkcja proponujaca przepisy, argumentami jest zmienna liczba nazw skladnikow oraz poziom filtracji przepisow,
-- do znalezienia przepisow w zaleznosci od poziomu wyspecyfikowania uzywane jest polaczenie tabel klauzulą join wraz z instrukcją group by oraz having
-- zwracana jest tabela znalezionych przepisow

create or replace function proponuj(arguments TEXT, poziom_wyspecyfikowania varchar) returns
    table(idprzepis integer, nazwa varchar, zgodnosc real) as
    $$
    declare
        strTablica text[];
        str text;
        query text;
        query_counter text;
        index integer;
        rec RECORD;
    begin
        strTablica := (select string_to_array(arguments,','));

        if poziom_wyspecyfikowania = 'max' then
            query := 'select * from proj_v1.przepis p where p.idprzepis not in
                              ( select d.idprzepis from proj_v1.danie d where d.idskladnik not in
                                (select s.idskladnik from proj_v1.skladnik s where s.nazwa in (';
        elsif poziom_wyspecyfikowania = 'greater' then
            query := 'select p.nazwa, p.idprzepis from proj_v1.przepis p inner join proj_v1.danie d on d.idprzepis = p.idprzepis
                            join proj_v1.skladnik s on d.idskladnik = s.idskladnik where s.nazwa in (';
        elsif poziom_wyspecyfikowania = 'less' then
            query := 'select tmp.idprzepis, count(*), tmp.nazwa from (select p.nazwa, p.idprzepis
                                                    from proj_v1.przepis p inner join proj_v1.danie d on d.idprzepis = p.idprzepis
                                                        join proj_v1.skladnik s on d.idskladnik = s.idskladnik where s.nazwa in( ';
        end if;
        index := 0;
        foreach str in ARRAY strTablica
        loop
            query := query || '''' || str || '''';
            index := index + 1;
            if index < array_length(strTablica,1) then
                query := query || ', ';
            end if;
        end loop;

        if poziom_wyspecyfikowania = 'max' then
            query := query ||  ')) ) and (select count(*) from proj_v1.danie d2 where d2.idprzepis = p.idprzepis group by d2.idprzepis) = ' || array_length(strTablica,1);
        elsif poziom_wyspecyfikowania = 'greater' then
            query := query || ') group by p.nazwa, p.idprzepis having count (*) = ' || array_length(strTablica,1);
        elsif poziom_wyspecyfikowania = 'less' then
            query := query || ')) as tmp group by tmp.idprzepis, tmp.nazwa';
        end if;
        for rec in execute query
        loop
            idprzepis := rec.idprzepis;
            nazwa := rec.nazwa;
            if poziom_wyspecyfikowania = 'max' then
                zgodnosc := 100;
            elsif poziom_wyspecyfikowania = 'greater' then
                query_counter := 'select count(*) from proj_v1.danie d where d.idprzepis = $1 group by d.idprzepis';
                execute query_counter using rec.idprzepis into zgodnosc;
                zgodnosc := (array_length(strTablica,1)/zgodnosc) * 100;
            elsif poziom_wyspecyfikowania = 'less' then
                query_counter := 'select count(*) from proj_v1.danie d where d.idprzepis = $1 group by d.idprzepis';
                execute query_counter using rec.idprzepis into zgodnosc;
                zgodnosc := ((rec.count)/zgodnosc) * 100;
            end if;
            return next;
        end loop;
    end;
    $$language plpgsql;

--------------------------------------------------------------------------------------------------------
-- funkcja zwracajaca wynik zapytania czy mozna wykonac dany przepis ze skladnikow dostepnych w spizarni

create or replace function czyMogeWykonac(login_zm varchar, idprzepis integer)
returns table (idskladnik integer, nazwaskladnika varchar, aktualnailosc real, jednostka varchar, wymaganailosc real, rodzaj varchar, info text) as
$$
declare
    id_spizarnia integer;
    rec_result record;
    rec_loop record;
    query text;
begin
    id_spizarnia := proj_v1.getidspizarnia(login_zm);

    query := 'select tab2.idskladnik, tab2.nazwa, tab1.amount, tab2.rodzaj, tab2.jednostka, tab2.iloscdodana ,(tab1.amount >= tab2.iloscdodana) as warunek
    from (select s2.idskladnik, s2.amount, s3.nazwa from proj_v1.spizarnia s
            join proj_v1.skladnikspizarnia s2 on s.idspizarnia = s2.idspizarnia
            join proj_v1.skladnik s3 on s2.idskladnik = s3.idskladnik where s.idspizarnia = ' || id_spizarnia ||' ) as tab1
    full outer join (select s.idskladnik, d.iloscdodana, s.nazwa, k.rodzaj, k.jednostka from proj_v1.przepis p
            join proj_v1.danie d on p.idprzepis = d.idprzepis and p.idprzepis = ' || idprzepis ||
            ' join proj_v1.skladnik s on d.idskladnik = s.idskladnik
            join proj_v1.kategoriaskladnik k on s.idkategoriaskladnik = k.idkategoriaskladnik) as tab2 on tab1.idskladnik = tab2.idskladnik where tab2.idskladnik is not null;';

    for rec_loop in execute query
    loop
        if rec_loop.warunek in (true) then
            idskladnik := rec_loop.idskladnik;
            nazwaskladnika := rec_loop.nazwa;
            aktualnailosc := rec_loop.amount;
            jednostka := rec_loop.jednostka;
            wymaganailosc := rec_loop.iloscdodana;
            rodzaj := rec_loop.rodzaj;
            info := 'Masz odpowiednią ilość';
            return next;
        elsif rec_loop.warunek in (false) then
            idskladnik := rec_loop.idskladnik;
            nazwaskladnika := rec_loop.nazwa;
            aktualnailosc := rec_loop.amount;
            jednostka := rec_loop.jednostka;
            wymaganailosc := rec_loop.iloscdodana;
            rodzaj := rec_loop.rodzaj;
            info := 'Nie masz odpowiedniej ilości';
            return next;
        else
            idskladnik := rec_loop.idskladnik;
            nazwaskladnika := rec_loop.nazwa;
            aktualnailosc := 0;
            jednostka := rec_loop.jednostka;
            wymaganailosc := rec_loop.iloscdodana;
            rodzaj := rec_loop.rodzaj;
            info := 'Całkowity brak w spiżarni';
            return next;
        end if;
    end loop;
end$$language plpgsql;

-----------------------------------------------------
-- zwraca przepisy dla podanych parametrow sortowania

create or replace function getPrzepis(sort_type varchar, rodzaj_zm varchar, kategoria_zm varchar)
returns TABLE (id integer, nazwa varchar, czaswykonania time, kcal integer, rodzaj varchar, kategoria varchar) as
    $$
    declare
        rec record;
        query text;
        rodzaj_zm alias for rodzaj_zm;
        kategoria_zm alias for kategoria_zm;
        sort_type alias for sort_type;
    begin
        query := 'select ps.idprzepis, ps.nazwa, ps.czaswykonania, ps.kcal, ps.rodzaj, ps.kategoria from proj_v1.przepis_szczegoly ps';
        query := query || ' where ps.rodzaj =  ''' ||  rodzaj_zm || '''';
        query := query || ' and ps.kategoria = ''' || kategoria_zm || '''';
        if sort_type = 'kalorie_asc' then
            query := query || ' order by ps.kcal;';
        elsif sort_type = 'kalorie_dsc' then
            query := query || ' order by ps.kcal desc;';
        elsif sort_type = 'czas_asc' then
            query := query || ' order by ps.czaswykonania;';
        elsif sort_type = 'czas_dsc' then
            query := query || ' order by ps.czaswykonania desc;';
        elsif sort_type = 'alfabetycznie' then
            query := query || ' order by ps.nazwa;';
        end if;
        for rec in execute query
            loop
                id := rec.idprzepis;
                nazwa := rec.nazwa;
                czaswykonania := rec.czaswykonania;
                kcal := rec.kcal;
                rodzaj := rec.rodzaj;
                kategoria := rec.kategoria;
                return next;
            end loop;
    end
    $$ language plpgsql;


--------------------------------------------------------------------
-- tworzenie nowego przepisu wraz z walidacja wprowadzanych danych

create or replace function createPrzepis(rodzaj_zm varchar, kategoria_zm varchar, kcal_zm integer, wegl_zm integer,
                                        bialko_zm integer, tluszcze_zm integer, nazwa_zm varchar, czas_zm varchar, opis_zm varchar, link_zm varchar,
                                        idskladnik_zm text, amountskladnik_zm text)
returns text as $$
    declare
        strTablicaId text[];
        strTablicaAmount text[];
        tmp_idwartosci integer;
        tmp_idprzepis integer;
        id_kategoria integer;
        query text;
    begin
        query := 'select kd.idkategoriadania from proj_v1.kategoriadania kd where kd.rodzaj= ''' || rodzaj_zm || ''' and kd.kategoria = ''' || kategoria_zm || '''';
        if kcal_zm < 0 or wegl_zm <0 or bialko_zm <0 or tluszcze_zm <0 then
            return 'Niepoprawne wartości dla wartości odżywczych.';
        elsif (nazwa_zm IS NULL  OR CAST(nazwa_zm as text) = '' OR CAST(nazwa_zm as text) ~ '^ *$') then
            return 'Niepoprawna nazwa przepisu.';
        elsif czas_zm = '' then
            return 'Niepoprawny czas przygotowania przepisu';
        end if;

        execute query into id_kategoria;
        if id_kategoria is null then
            return 'Nie ma takiej kategori! Sprawdz wprowadzone parametry.';
        end if;
        strTablicaId := (select string_to_array(idskladnik_zm,','));
        strTablicaAmount := (select string_to_array(amountskladnik_zm,','));
        if array_length(strTablicaId, 1) < 1 or array_length(strTablicaId, 1) is null then
            return 'Nie podano żadnego składnika';
        end if;
        for k in 1..array_length(strTablicaAmount, 1)
        loop
            if cast(strTablicaAmount[k] as numeric(6,2)) <= 0 then
                return 'Podano ilość składnika nie większą od 0. Podano: ' || strTablicaAmount[k];
            end if;
            if cast(strTablicaId[k] as integer) not in (select s.idskladnik from proj_v1.skladnik s) then
                return 'Podany skladnik nie występuje w bazie danych. Podano id skladnika: ' || strTablicaId[k];
            end if;
        end loop;
        --tworze nowe wartosci odzywcze
        perform setval('proj_v1.wartosciodzywcze_idwartosci_seq', COALESCE((SELECT MAX(w.idwartosci)+1 FROM proj_v1.wartosciodzywcze w), 1), false);
        insert into proj_v1.wartosciodzywcze (kcal, weglowodany, bialko, tluszcze) values (kcal_zm, wegl_zm, bialko_zm, tluszcze_zm)
            returning idwartosci into tmp_idwartosci;
        --tworze nowy przepis
        perform setval('proj_v1.przepis_idprzepis_seq', COALESCE((SELECT MAX(p.idprzepis)+1 FROM proj_v1.przepis p), 1), false);
        insert into proj_v1.przepis (nazwa, opis, czaswykonania, idkategoriadania, idwartosci, image_link)
                    VALUES (nazwa_zm, opis_zm, (SELECT to_timestamp(czas_zm, 'HH24:MI:SS')::time AS col_overtime), id_kategoria, tmp_idwartosci, link_zm)
                    returning idprzepis into tmp_idprzepis;

        perform setval('proj_v1.danie_iddanie_seq', COALESCE((SELECT MAX(d.iddanie)+1 FROM proj_v1.danie d), 1), false);
        for k in 1..array_length(strTablicaId, 1)
        loop
            insert into proj_v1.danie (iloscdodana, idskladnik, idprzepis)
                values (cast(strTablicaAmount[k] as numeric(6,2)), cast(strTablicaId[k] as integer), tmp_idprzepis);
        end loop;

        return tmp_idprzepis;
    end;
    $$language plpgsql;
------------------------------------------------------------
-- zwraca skladniki dla danego przepisu o przekazanym id

create or replace function getSkladniki(idprzepis_zm integer)
returns table(nazwa varchar, iloscdodana real, jednostka varchar, rodzaj varchar) as
    $$
    declare
        rec record;
        query text;
        idprzepis_zm alias for idprzepis_zm;
    begin
        query := 'select s.nazwa, d.iloscdodana, k.jednostka, k.rodzaj from proj_v1.danie d join proj_v1.skladnik s on d.idskladnik = s.idskladnik join proj_v1.kategoriaskladnik k on s.idkategoriaskladnik = k.idkategoriaskladnik ';
        query := query || ' where d.idprzepis = ' || idprzepis_zm ;

        for rec in execute query
            loop
                nazwa := rec.nazwa;
                iloscdodana := rec.iloscdodana;
                jednostka := rec.jednostka;
                rodzaj := rec.rodzaj;
                return next;
            end loop;
    end
    $$ language plpgsql;

------------------------------------------------------------------
-- zwraca wartosci odzywcze danego przepisu podanego przez id

create or replace function getWartosci(idprzepis_zm integer)
returns table(kcal integer, weglowodany integer, bialko integer, tluszcze integer) as
    $$
    declare
        rec record;
        query text;
        idprzepis_zm alias for idprzepis_zm;
    begin
        query := 'select w.kcal, w.weglowodany, w.bialko, w.tluszcze from proj_v1.przepis p join proj_v1.wartosciodzywcze w on p.idwartosci = w.idwartosci ';
        query := query || ' where p.idprzepis = ' || idprzepis_zm ;

        for rec in execute query
            loop
                kcal := rec.kcal;
                weglowodany := rec.weglowodany;
                bialko := rec.bialko;
                tluszcze := rec.tluszcze;
                return next;
            end loop;
    end
    $$ language plpgsql;

-------------------------------------------------------------------------------------------------------------
-- tworzy nowa spizarnie, podajemy nazwe spizarni i login uzytkownika, funkcja sprawdza id uzytkownika i tworzy spizarnie

create or replace function createSpizarnia(nazwa varchar, login varchar)
returns bool as
    $$
    declare
        login_zm alias for login;
        nazwa_zm alias for nazwa;
        id integer;
        maxid integer;
    begin
        id := (select u.iduzytkownik from proj_v1.uzytkownik u where u.login = login_zm);
        if id is not null then
            if (select count(1) from proj_v1.spizarnia s join proj_v1.uzytkownik u on s.iduzytkownik = u.iduzytkownik where u.iduzytkownik = id) = 0 then
                maxid := (select max(s.idspizarnia) from proj_v1.spizarnia s);
                if maxid is null then
                    raise info 'null maxid: %',maxid;
                    ALTER SEQUENCE proj_v1.spizarnia_idspizarnia_seq RESTART WITH 1;
                else
                    raise info 'maxid: %',maxid;
                    perform setval('proj_v1.spizarnia_idspizarnia_seq', MAX(idspizarnia), true) FROM proj_v1.spizarnia;
                end if;

                insert into proj_v1.spizarnia (nazwa, iduzytkownik) values (nazwa_zm,id);
                return true;
            else
                raise info 'Uzytkownik posiada juz spizarnie!';
                return false;
            end if;
        else
            raise info 'Brak uzytkownika o podanym loginie!';
            return false;
        end if;
    end
    $$ language plpgsql;

----------------------------------------------------------------------------------
-- usuwa spizarnie o podanej nazwie, ktora nalezy do uzytkownika o podanym loginie

create or replace function deleteSpizarnia(nazwa varchar, login varchar) returns bool as
    $$
    declare
        login_zm alias for login;
        nazwa_zm alias for nazwa;
        id_user integer;
        id_spizarnia integer;
    begin
        id_user := (select u.iduzytkownik from proj_v1.uzytkownik u where u.login = login_zm);
        if id_user is not null then
            id_spizarnia := (select s.idspizarnia from proj_v1.spizarnia s join proj_v1.uzytkownik u on u.iduzytkownik = s.iduzytkownik where u.iduzytkownik = id_user and s.nazwa = nazwa_zm);
            if id_spizarnia is not null then
                    delete from proj_v1.spizarnia s where s.idspizarnia = id_spizarnia;
                return true;
            else
                raise info 'Brak spizarni o podanej nazwie!';
                return false;
            end if;
        else
            raise info 'Brak uzytkownika o podanym loginie!';
            return false;
        end if;

    end
    $$language plpgsql;

------------------------------------------------------------------------------------------------
-- funkcja zwraca zawartosc spizarni uzytkownika (nazwa skladnika, ilosc, jednostka, rodzaj)

create or replace function getSpizarnia(nazwa_zm varchar, login_zm varchar) returns
table(nazwaskladnika varchar, ilosc real, jednostka varchar, rodzaj varchar, idskladnik integer) as
    $$
    declare
        id_user integer;
        id_spizarnia integer;
        rec record;
        query text;
    BEGIN
        id_user := (select u.iduzytkownik from proj_v1.uzytkownik u where u.login = login_zm);
        if id_user is not null then
            id_spizarnia := (select s.idspizarnia from proj_v1.spizarnia s join proj_v1.uzytkownik u on u.iduzytkownik = s.iduzytkownik where u.iduzytkownik = id_user and s.nazwa = nazwa_zm);
            if id_spizarnia is not null then
                query := 'select * from proj_v1.skladniki_w_spizarni sws where sws.iduzytkownik = ';
                query := query || id_user;
                query := query || ' and sws.idspizarnia = ' || id_spizarnia || ' order by sws.nazwa';
                raise info 'Zmienna: %', query;
                for rec in execute query
                loop
                    nazwaskladnika := rec.nazwa;
                    ilosc := rec.amount;
                    jednostka := rec.jednostka;
                    rodzaj := rec.rodzaj;
                    idskladnik := rec.idskladnik;
                    return next;
                end loop;
            else
                raise info 'Brak spizarni o podanej nazwie!';
            end if;
        else
            raise info 'Brak uzytkownika o podanym loginie!';
        end if;

    end;
    $$language plpgsql;

---------------------------------------
-- wprowadza skladniki do spizarni

create or replace function insertSkladnikSpizarnia(login_zm varchar, idskladnik_zm integer, ilosc_zm real) returns bool
as $$
    declare
        id_spizarnia integer;
        query text;
        rec integer;
        begin
        if ilosc_zm > 0 then
                id_spizarnia := (select * from proj_v1.getidspizarnia(login_zm));
                if id_spizarnia > 0 then
                -- sprawdzam czy skladnik o podanym id juz sie znajduje w tabeli
                    query := 'select count(1) from proj_v1.skladnikspizarnia ss where ss.idskladnik = ' || idskladnik_zm || ' and ss.idspizarnia = ' || id_spizarnia;
                    execute query into rec;
                    if rec = 0 then
                        insert into proj_v1.skladnikspizarnia values (idSkladnik_zm,id_spizarnia,ilosc_zm);
                    else --jest, aktualizuje wiersz
                        update proj_v1.skladnikspizarnia set amount = amount + ilosc_zm where idspizarnia=id_spizarnia and idskladnik=idSkladnik_zm;
                    end if;
                    return true;
                else
                    raise info 'Brak spizarni o podanej nazwie!';
                    return false;
                end if;
        else
            raise exception 'Blędna ilość składnika [%]',ilosc_zm;
--             raise info 'Bledna ilosc skladnika!';
--             return false;
        end if;

        end;
        $$language plpgsql;

----------------------------------------------------------
-- funkcja pomocnicza, zwraca idspizarni dla danego loginu

create or replace function getIdSpizarnia(login varchar) returns integer
as $$
    declare
    login_zm alias for login;
    id_user integer;
    id_spizarnia integer;
    begin
        id_user := (select u.iduzytkownik from proj_v1.uzytkownik u where u.login = login_zm);
        if id_user is not null then
                id_spizarnia := (select s.idspizarnia from proj_v1.spizarnia s join proj_v1.uzytkownik u on u.iduzytkownik = s.iduzytkownik where u.iduzytkownik = id_user);
                if id_spizarnia is not null then
                    return id_spizarnia;
                else
                    raise info 'Brak spizarni o podanej nazwie!';
                    return -1;
                end if;
            else
                raise info 'Brak uzytkownika o podanym loginie!';
                return -1;
            end if;
    end;
    $$language plpgsql;

------------------------------------------
-- funkcja usuwajaca skladniki ze spizarni

create or replace function deleteSkladnikSpizarnia(login_zm varchar, idskladnik_zm integer, ilosc_zm real)returns bool
as $$
    declare
        maxilosc_zm real;
        id_spizarnia integer;
        query text;
        rec integer;
    begin
        id_spizarnia := (select * from proj_v1.getidspizarnia(login_zm));
        maxilosc_zm := (select ss.amount from proj_v1.skladnikspizarnia ss where ss.idspizarnia=id_spizarnia and ss.idskladnik=idskladnik_zm);
        if ilosc_zm >= 0 and ilosc_zm <= maxilosc_zm then
            if id_spizarnia > 0 then
                -- sprawdzam czy skladnik o podanym id sie znajduje w tabeli
                query := 'select count(1) from proj_v1.skladnikspizarnia ss where ss.idskladnik = ';
                query := query || idskladnik_zm;
                query := query || ' and ss.idspizarnia = ' || id_spizarnia;
                execute query into rec;
                if rec = 0 then
                    raise info 'Brak takiego skladnika!';
                    return false;
                else --jest, aktualizuje wiersz
                    update proj_v1.skladnikspizarnia set amount = amount - ilosc_zm where idspizarnia=id_spizarnia and idskladnik=idskladnik_zm;
                    return true;
                end if;
            else
                raise info 'Brak spizarni o podanej nazwie!';
                return false;
            end if;
        else
            raise info 'Bledna ilosc skladnika!';
            return false;
        end if;
    end;
    $$language plpgsql;

------------------------------------------
-- funkcja dodajaca przepis do ulubionych

create or replace function addUlubione(login varchar, idprzepis integer) returns varchar as
    $$
    declare
        login_zm alias for login;
        idprzepis_zm alias for idprzepis;
        id_user integer;
        checkFav bool;
    begin
        id_user := (select u.iduzytkownik from proj_v1.uzytkownik u where u.login = login_zm);
        if id_user is not null then
            checkFav := (select o.ulubione from proj_v1.uzytkownik u join proj_v1.ocena o on u.iduzytkownik=o.iduzytkownik where o.idprzepis=idprzepis_zm and u.iduzytkownik=id_user);
            if checkFav = true then
                return 'Podany przepis znajduje się juz w ulubionych!';
            else
                -- sprawdzam czy nie ma rekordu o podanych idprzepis i iduzytkownika
                if (select count(1) from proj_v1.uzytkownik u join proj_v1.ocena o on u.iduzytkownik=o.iduzytkownik where o.idprzepis=idprzepis_zm and u.iduzytkownik=id_user) = 1 then
                    raise info 'Rokord juz taki jest, zmieniam flage';
                    update proj_v1.ocena o set ulubione = true where o.iduzytkownik = id_user and o.idprzepis = idprzepis_zm;
                -- nie ma wiec tworze nowy wiersz, uprzednio aktualizujac sekwencje aby id nie rosly nie proporcionalnie do ilosc wpisow
                else
                    if (select max(o.idocena) from proj_v1.ocena o) is null then
                        raise info 'restart ocena seq with 1';
                        ALTER SEQUENCE proj_v1.ocena_idocena_seq RESTART WITH 1;
                    else
                        perform setval('proj_v1.ocena_idocena_seq', COALESCE((SELECT MAX(o.idocena)+1 FROM proj_v1.ocena o), 1), false);
                    end if;
                    insert into proj_v1.ocena (ocenaval, recenzja, ulubione, iduzytkownik, idprzepis) values (null,null,'true',id_user,idprzepis_zm);
                end if;
                return 'Pomyślnie dodano do ulubionych!';
            end if;
        else
            return 'Brak uzytkownika o podanym loginie!';
        end if;
    end;
    $$language plpgsql;

----------------------------------------
--funkcja usuwajaca rekord z ulubionych

create or replace function deleteUlubione(login varchar, idprzepis integer, wszystko bool) returns bool as
    $$
    declare
        login_zm alias for login;
        idprzepis_zm alias for idprzepis;
        id_user integer;
        wszystko_zm alias for wszystko;
    begin
        id_user := (select u.iduzytkownik from proj_v1.uzytkownik u where u.login = login_zm);
        if id_user is not null then
            if wszystko_zm = false then
                update proj_v1.ocena o set ulubione = false where o.iduzytkownik=id_user and o.idprzepis=idprzepis_zm;
                return true;
            else
                -- usuwam caly wpis o danym id
                delete from proj_v1.ocena o where o.iduzytkownik=id_user and o.idprzepis = idprzepis_zm;
                return true;
            end if;
        else
            raise info 'Brak uzytkownika o podanym loginie!';
            return false;
        end if;
    end;
    $$language plpgsql;

---------------------------------------------------------------------------
-- funkcja sprawdzajaca czy uzytkownik ma juz zapisana recenzje do przepisu

create or replace function isRecenzja(login varchar, idprzepis integer) returns
table (ocena integer, recenzja text, ulubione bool) as
    $$
    declare
        login_zm alias for login;
        idprzepis_zm alias for idprzepis;
        rec record;
        id_user integer;
        query text;
        count integer;
    begin
        id_user := (select u.iduzytkownik from proj_v1.uzytkownik u where u.login = login_zm);
        if id_user is not null then

            query := 'select count(1) from proj_v1.ocena o where o.iduzytkownik = ';
            query := query || id_user || 'and o.idprzepis = ' || idprzepis_zm;
            execute query into count;
            if (count = 0) then
                ocena := null;
                recenzja := null;
                ulubione := false;
                return next ;
            else
                query := 'select * from proj_v1.ocena o where o.iduzytkownik = ';
                query := query || id_user || 'and o.idprzepis = ' || idprzepis_zm;
                for rec in execute query
                loop
                    ocena := rec.ocenaval;
                    recenzja := rec.recenzja;
                    ulubione := rec.ulubione;
                    return next;
                end loop;
            end if;
        else
            raise exception 'Brak uzytkownika o podanym loginie!';
        end if;
    end;$$language plpgsql;

----------------------------------------
-- funkcja dodajaca recenzje do przepisu

create or replace function addRecenzja(login varchar, idprzepis integer, ocena_zm integer, recenzja_zm text) returns bool as
    $$
    declare
        login_zm alias for login;
        idprzepis_zm alias for idprzepis;
        ocena_zm alias for ocena_zm;
        recenzja_zm alias for recenzja_zm;
        id_user integer;
        query text;
        count integer;
    begin
        id_user := (select u.iduzytkownik from proj_v1.uzytkownik u where u.login = login_zm);
        if id_user is not null then
            if ocena_zm = -1 then
                ocena_zm = null;
            end if;
            if recenzja_zm = ''then
                recenzja_zm = null;
            end if;
            query := 'select count(1) from proj_v1.ocena o where o.iduzytkownik = ';
            query := query || id_user || 'and o.idprzepis = ' || idprzepis_zm;
            execute query into count;
--             tworzymy nowy wpis
            if (count = 0) then
                perform setval('proj_v1.ocena_idocena_seq', COALESCE((SELECT MAX(o.idocena)+1 FROM proj_v1.ocena o), 1), false);
                insert into proj_v1.ocena(ocenaval, recenzja, ulubione, data, iduzytkownik, idprzepis)
                                values (ocena_zm,recenzja_zm,false,now(),id_user,idprzepis_zm);
                return true;
--             aktualizujemy istniejacy wpis
            else
                update proj_v1.ocena o set ocenaval=ocena_zm, recenzja = recenzja_zm, data=now() where o.iduzytkownik=id_user and o.idprzepis=idprzepis_zm;
                return true;
            end if;
        else
            raise info 'Brak uzytkownika o podanym loginie!';
            return false;
        end if;
    end;$$language plpgsql;

---------------------------------------------------------------------
-- zwraca informacje na temat recenzji, oceny, dodania do ulubionych

create or replace function getRecenzja(login varchar, sort_type varchar)
returns table (id integer, idprzepis integer, nazwa varchar, ocena integer, recenzja text, data timestamp) as
    $$
    declare
        login_zm alias for login;
        sort_type alias for sort_type;
        id_user integer;
        rec record;
        query text;
    begin
        id_user := (select u.iduzytkownik from proj_v1.uzytkownik u where u.login = login_zm);
        if id_user is not null then
            query := 'select o.idocena, o.idprzepis, o.ocenaval, o.recenzja, to_char( o.data, ''DD-MM-YYYY HH24:MI:SS'' ) as data from proj_v1.ocena o where (o.ocenaval is not null or o.recenzja is not null) and o.iduzytkownik = ' || id_user || ' order by ';
            if sort_type = 'ocena_asc' then
                query := query || 'o.ocenaval asc NULLS LAST';
            elsif sort_type = 'ocena_dsc' then
                query := query || 'o.ocenaval desc NULLS LAST';
            elsif sort_type = 'data_dsc' then
                query := query || 'o.data desc NULLS LAST';
            elsif sort_type = 'data_asc' then
                query := query || 'o.data asc NULLS LAST';
            end if;
            raise info 'zapytanie: %',query;
            for rec in execute query
            loop
                id := rec.idocena;
                idprzepis := rec.idprzepis;
                nazwa := (select p.nazwa from proj_v1.przepis p where p.idprzepis = rec.idprzepis);
                ocena := rec.ocenaval;
                recenzja := rec.recenzja;
                data := rec.data;
                return next ;
            end loop;
        else
            raise exception 'Brak uzytkownika o podanym loginie!';
        end if;

    end;
    $$language plpgsql;

---------------------------------------------------------------------------------------
-- funkcja zwracajaca przepisy ktore są oznaczone jako ulubione wraz z ocena i recenzja

create or replace function getPrzepisUlubione(sort_type varchar, rodzaj_zm varchar, kategoria_zm varchar, login varchar)
returns TABLE (id integer, nazwa varchar, czaswykonania time, opis text, kcal integer, rodzaj varchar, kategoria varchar, ocena integer, recenzja text) as
    $$
    declare
        rec record;
        query text;
        rodzaj_zm alias for rodzaj_zm;
        kategoria_zm alias for kategoria_zm;
        sort_type alias for sort_type;
        login_zm alias for login;
    begin
        query := 'select * from proj_v1.ulubione_przepisy up ';
        query := query || ' where up.login = ''' || login_zm || '''';
        query := query || ' and up.rodzaj = ''' || rodzaj_zm || '''';
        query := query || ' and up.kategoria = ''' || kategoria_zm || '''';

        if sort_type = 'kalorie_asc' then
            query := query || ' order by up.kcal;';
        elsif sort_type = 'kalorie_dsc' then
            query := query || ' order by up.kcal desc;';
        elsif sort_type = 'czas_asc' then
            query := query || ' order by up.czaswykonania;';
        elsif sort_type = 'czas_dsc' then
            query := query || ' order by up.czaswykonania desc;';
        elsif sort_type = 'alfabetycznie' then
            query := query || ' order by up.nazwa;';
        end if;
        for rec in execute query
            loop
                id := rec.id;
                nazwa := rec.nazwa;
                czaswykonania := rec.czaswykonania;
                opis := rec.opis;
                kcal := rec.kcal;
                rodzaj := rec.rodzaj;
                kategoria := rec.kategoria;
                ocena := rec.ocena;
                recenzja := rec.recenzja;
                return next;
            end loop;
    end
    $$ language plpgsql;