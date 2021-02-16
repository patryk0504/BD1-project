------------------------------------- widoki ------------------------------------------------------

create view skladniki_w_spizarni as
select sk.nazwa, ss.amount, ks.jednostka, ks.rodzaj, u.iduzytkownik, s.idspizarnia, ss.idskladnik from proj_v1.uzytkownik u join proj_v1.spizarnia s on u.iduzytkownik = s.iduzytkownik
        join proj_v1.skladnikspizarnia ss on s.idspizarnia = ss.idspizarnia
        join proj_v1.skladnik sk on ss.idskladnik = sk.idskladnik
        join proj_v1.kategoriaskladnik ks on sk.idkategoriaskladnik = ks.idkategoriaskladnik;

create view ulubione_przepisy as
select p.idprzepis as id, p.nazwa, p.czaswykonania, p.opis, w.kcal,k.rodzaj, k.kategoria, o.ocenaval as ocena, o.recenzja, o.ulubione, u.login from proj_v1.uzytkownik u
        join proj_v1.ocena o on u.iduzytkownik = o.iduzytkownik
        join przepis p on o.idprzepis = p.idprzepis
        join proj_v1.kategoriadania k on k.idkategoriadania = p.idkategoriadania
        join proj_v1.wartosciodzywcze w on p.idwartosci = w.idwartosci;


create view przepis_szczegoly as
select p.idprzepis, p.nazwa, p.czaswykonania, p.opis, w.kcal, k.rodzaj, k.kategoria, p.image_link from proj_v1.przepis p
        join proj_v1.kategoriadania k on p.idkategoriadania = k.idkategoriadania
        join proj_v1.wartosciodzywcze w on w.idwartosci = p.idwartosci;


create view liczba_opini_uzytkownika as
select u.iduzytkownik, u.login, u.imie, u.nazwisko, count(o.iduzytkownik) as liczba_opinii
    from proj_v1.uzytkownik u join proj_v1.ocena o on u.iduzytkownik = o.iduzytkownik
        where o.ocenaval is not null or o.recenzja is not null group by u.iduzytkownik, u.login, u.imie, u.nazwisko;

create view liczba_polubien_uzytkownika as
select u.iduzytkownik, u.login, u.imie, u.nazwisko, count(o.iduzytkownik) as liczba_polubien
    from proj_v1.uzytkownik u join proj_v1.ocena o on u.iduzytkownik = o.iduzytkownik
        where o.ulubione = true group by u.iduzytkownik, u.login, u.imie, u.nazwisko;

create view dostawcySkladnika as
    select d.iddostawca, s.idskladnik, d.nazwa, d.adres_link from proj_v1.skladnik s join proj_v1.dostawca d using (iddostawca);