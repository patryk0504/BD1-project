----------------------------------------- wyzwalacze ---------------------------------------------------------------------
-- wyzwalacz pozwala na bezproblemowe usuniecie przpisu

create or replace function przepis_ondelete_fun() returns trigger language plpgsql as
    $$
    declare
        id_oceny record;
        wartosci_count integer;
    begin
        --sprawdzamy polaczenie przepisu z tabela ocena
        delete from proj_v1.ocena o where o.idprzepis = old.idprzepis;
        --usuwamy wpisy w tabeli danie
        delete from proj_v1.danie d where d.idprzepis = old.idprzepis;
        return old;
    end;
    $$;

create trigger przepis_ondelete before delete on proj_v1.przepis
    for each row execute procedure przepis_ondelete_fun();

-------------------------------------------------------------------------------------------------------------------------
-- wyzwalacz usuwa zbedne rekordy wartosci odzywczych, zbedne to takie, ktore nie posiadaja zadnego powiazana z przepisem

create or replace function przepis_afterdelete_fun() returns trigger language plpgsql as
    $$
    declare
        wartosci_count integer;
    begin
        --sprawdzamy czy wpis na temat wartosci nie jest powiazany z innym przepisem
        wartosci_count := (select count(*) from proj_v1.przepis p where p.idwartosci = old.idwartosci group by p.idwartosci);
        if wartosci_count is null then -- jezeli nie ma powiazania rekord jest zbedny
            delete from proj_v1.wartosciodzywcze w where w.idwartosci = old.idwartosci;
        end if;
        return new;
    end;
    $$;


create trigger przepis_afterdelete after delete on proj_v1.przepis
    for each row execute procedure przepis_afterdelete_fun();

-----------------------------------------------------------------------------
-- wyzwalacz sprawdza czy nazwa nowego dostawcy nie znajduje sie juz w tabeli

create or replace function checkdostawca_before_insert() returns trigger language plpgsql as
    $$
    declare
    begin
        if lower( new.nazwa ) in (select lower(d.nazwa) from proj_v1.dostawca d) then
            perform setval('proj_v1.dostawca_iddostawca_seq', COALESCE((SELECT MAX(d.iddostawca)+1 FROM proj_v1.dostawca d), 1), false);
            raise exception 'Dostawca o takiej nazwie już istnieje!';
        end if;
        return new;
    end;
    $$;


create trigger checkdostawca_before_insert before insert on proj_v1.dostawca
    for each row execute procedure checkdostawca_before_insert();

--------------------------------------------------------------------------
-- wyzwalacz umozliwia bezpieczne usuniecie uzytkownika wraz z jego danymi

create or replace function uzytkownik_ondelete_fun() returns trigger language plpgsql as
    $$
    declare
        id_spizarnia integer;
        id_oceny record;
    begin
        --sprawdzamy czy nie usuwamy admina
        if(select u.isadmin from proj_v1.uzytkownik u where u.iduzytkownik = old.iduzytkownik) is true then
            raise exception 'Nie możesz usuwać administratora z poziomu formularza!';
        end if;
        --sprawdzamy czy uzytkownik mial spizarnie
        id_spizarnia := (select s.idspizarnia from proj_v1.spizarnia s where s.iduzytkownik = old.iduzytkownik);
        --usuwmy tablice assocjacyjna skladnikspizarnia
        if(id_spizarnia is not null) then
            delete from proj_v1.skladnikspizarnia ss where ss.idspizarnia = id_spizarnia;
            delete from proj_v1.spizarnia s where s.idspizarnia = id_spizarnia;
        end if;
        delete from proj_v1.ocena o where o.iduzytkownik = old.iduzytkownik;
        return old;
    end;$$;

create trigger uzytkownik_ondelete before delete on proj_v1.uzytkownik
    for each row execute procedure uzytkownik_ondelete_fun();

---------------------------------------------------------------------------------------------------------------------------
-- wyzwalacz zapobiega dodawaniu nadmiarowych skladnikow o tej samej nazwie i tych samych parametrach (jednostka, kategoria)

create or replace function checkskladnikbeforeinsert() returns trigger
    language plpgsql
as
$$
declare
        name_zm record;
        query text;
    begin
        query := 'select s.nazwa from proj_v1.skladnik s where s.idkategoriaskladnik = ' || new.idkategoriaskladnik;
        for name_zm in execute query
        loop
            if lower(new.nazwa) = lower(name_zm.nazwa) then
                raise info 'Taki skladnik znajdje sie juz w tabeli';
                perform setval('proj_v1.skladnik_idskladnik_seq', COALESCE((SELECT MAX(s.idskladnik)+1 FROM proj_v1.skladnik s), 1), false);
                return null;
            end if;
        end loop;
        return new;
    end;
$$;

create trigger checkSkladnikBeforeInsert before insert on proj_v1.skladnik
    for each row execute procedure checkSkladnikBeforeInsert();

----------------------------------------------------------------------------------------------------------------------------------
-- wyzwalacz zapobiega dodaniu tego samego skladnika do danego przepisu, pierszy skladnik jest brany pod uwage, a drugi ignorowany

create or replace function checkSkladnikInDanie() returns trigger language plpgsql as
    $$
    declare
        query text;
        counter integer;
    begin
        query := 'select count(1) from proj_v1.danie d where d.idprzepis = ' || new.idprzepis || ' and d.idskladnik= ' || new.idskladnik;
        raise info 'Query: %',query;
        execute query into counter;
        if new.iloscdodana <= 0 then
            raise info 'Ilość składnika % nie jest większa od 0.',new.idskladnik;
            return null;
        elsif counter = 0 then
            return new;
        elsif counter = 1 then
            raise info 'Podany skladnik o id: % juz znajduje się w przepisie.',new.idskladnik;
            return null;
        end if;
    end;$$;


create trigger checkSkladnikInDanie before insert on proj_v1.danie
    for each row execute procedure checkSkladnikInDanie();

------------------------------------------------------------------------------------------------------------------------------------
-- wyzwalacz sprawdza czy po aktualizacji tablicy ocena można usunąć zbędny wiersz
-- zbedny wiersz jest to taki wiersz który nie jest w ulubionych (ulubione = false) oraz nie ma ustawionych pól ocenaval i recenzja

create or replace function ocena_update() returns trigger language plpgsql as
    $$
    declare
        rec record;
    begin
        for rec in (select * from proj_v1.ocena o)
        loop
            if rec.ulubione = false then
                if rec.ocenaval is null and rec.recenzja is null then
                    raise info 'usuwam rekord';
                    delete from proj_v1.ocena o where o.idocena = rec.idocena;
                end if;
            end if;
        end loop;
        return new;
    end;
    $$;

create trigger ocena_update after update on proj_v1.ocena
    for each row execute procedure ocena_update();

-------------------------------------------------------------------------------------------------------------
-- wyzwalacz do usuwania zbednych rekordow z tablicy skladnikspizarnia, zbedne rekordy to te gdzie amount = 0

create or replace function skladnikspizarnia_update() returns trigger language plpgsql as
    $$
    declare
        rec record;
    begin
        for rec in (select ss.amount, ss.idskladnik from proj_v1.skladnikspizarnia ss)
        loop
            if rec.amount = 0 then
                delete from proj_v1.skladnikspizarnia ss where ss.idskladnik = rec.idskladnik;
            end if;
        end loop;
        return new;
    end;
    $$;
create trigger skladnikspizarnia_update after update on proj_v1.skladnikspizarnia
    for each row execute procedure skladnikspizarnia_update();

-----------------------------------------------------------------------------------------------------------------
-- wyzawalacz do usuwania spizarni, skoro spizarnia jest usuwana nalezy usunac tabele asocjacyjną z nią powiązaną

create or replace function spizarnia_delete()
returns trigger language plpgsql
as $$
    declare
        tmp record;
    begin
        for tmp in (select s2.idskladnik from proj_v1.spizarnia s join proj_v1.skladnikspizarnia s2 on s.idspizarnia = s2.idspizarnia and s.idspizarnia=old.idspizarnia)
        loop
            delete from proj_v1.skladnikspizarnia s where s.idspizarnia = old.idspizarnia and s.idskladnik = tmp.idskladnik;
        end loop;
        delete from proj_v1.skladnikspizarnia ss where ss.idspizarnia = old.idspizarnia;
        return old;
    end;
    $$;


create trigger spizarnia_delete before delete on proj_v1.spizarnia
    for each row execute procedure spizarnia_delete();
---------------------------------------------------------------------------------------------------
-- wyzwalacz dla rejestracji uzytkownika, sprawdzanie czy uzytkownik o podanym loginie juz istnieje

create or replace function uzytkownik_valid_data()
returns trigger
language plpgsql
as $$
    declare
        rec RECORD;
        query text;
        flag bool;
        maxid integer;
    begin
        flag := true;
        query := 'select * from proj_v1.uzytkownik u where u.login = $1';
        execute query using (new.login) into rec;
        if rec is not null then
            raise exception 'Uzytkownik o podany loginie juz istnieje';
        end if;

        if (select max(u.iduzytkownik) from proj_v1.uzytkownik u) is null then
            raise info 'restart ocena seq with 1';
            ALTER SEQUENCE proj_v1.uzytkownik_iduzytkownik_seq RESTART WITH 1;
        else
            perform setval('proj_v1.uzytkownik_iduzytkownik_seq', COALESCE((SELECT MAX(u.iduzytkownik)+1 FROM proj_v1.uzytkownik u), 1), false);
        end if;
        return new;
    end;
    $$;

create trigger uzytkownik_valid before insert on proj_v1.uzytkownik
    for each row execute procedure uzytkownik_valid_data();
