-- typy ENUM
create type kategoria_enum as enum ('vege', 'bezglutenowe', 'normal');
create type rodzajSkladnik_enum as enum ('warzywa','nabial','mieso', 'przyprawy', 'zboze', 'orzechy', 'owoce', 'nasiona', 'ryby', 'olej', 'rosliny', 'pieczywo');
create type rodzajPrzepis_enum as enum ('sniadanie', 'obiad', 'kolacja', 'przekaska');
create type jednostka_enum as enum ('ml','g','szt');
------------------------------------------------------------------------------------------------------------------------------------------------------------------
-- tworzenie tabel

CREATE TABLE kategoriaSkladnik (
                idKategoriaSkladnik serial NOT NULL,
                rodzaj rodzajSkladnik_enum NOT NULL,
                jednostka jednostka_enum NOT NULL,
                CONSTRAINT kategoriaskladnik_pk PRIMARY KEY (idKategoriaSkladnik)
);


CREATE TABLE wartosciOdzywcze (
                idWartosci serial NOT NULL,
                kcal INTEGER NOT NULL constraint kcalRange check (kcal >= 0),
                weglowodany INTEGER NOT NULL constraint weglowodanyRange check (weglowodany >= 0),
                bialko INTEGER NOT NULL constraint bialkoRange check (bialko >= 0),
                tluszcze INTEGER NOT NULL constraint tluszczeRange check (tluszcze >= 0),
                CONSTRAINT wartosciodzywcze_pk PRIMARY KEY (idWartosci)
);


CREATE TABLE dostawca (
                idDostawca serial NOT NULL,
                nazwa VARCHAR(32) NOT NULL,
                adres_link VARCHAR(32) NOT NULL,
                CONSTRAINT dostawca_pk PRIMARY KEY (idDostawca)
);


CREATE TABLE skladnik (
                idSkladnik serial NOT NULL,
                nazwa VARCHAR(32) NOT NULL,
                idDostawca INTEGER,
                idKategoriaSkladnik INTEGER NOT NULL,
                CONSTRAINT skladnik_pk PRIMARY KEY (idSkladnik)
);


CREATE TABLE kategoriaDania (
                idKategoriaDania serial NOT NULL,
                rodzaj rodzajPrzepis_enum NOT NULL,
                kategoria kategoria_enum NOT NULL,
                CONSTRAINT kategoriadania_pk PRIMARY KEY (idKategoriaDania)
);


CREATE TABLE przepis (
                idPRzepis serial NOT NULL,
                nazwa VARCHAR(64) NOT NULL,
                opis TEXT NOT NULL,
                czasWykonania TIME NOT NULL,
                idKategoriaDania INTEGER NOT NULL,
                idWartosci INTEGER NOT NULL,
                CONSTRAINT przepis_pk PRIMARY KEY (idPRzepis)
);


CREATE TABLE danie (
                idDanie serial NOT NULL,
                iloscDodana numeric(6,2) NOT NULL constraint iloscDodanaRange check (iloscDodana > 0.0),
                idSkladnik INTEGER NOT NULL,
                idPRzepis INTEGER NOT NULL,
                CONSTRAINT danie_pk PRIMARY KEY (idDanie)
);


CREATE TABLE uzytkownik (
                idUzytkownik SERIAL NOT NULL,
                login VARCHAR(16) NOT NULL,
                pass VARCHAR(16) NOT NULL,
                imie VARCHAR(32) NOT NULL,
                nazwisko VARCHAR(32) NOT NULL,
		        isadmin boolean default false not null,
                CONSTRAINT uzytkownik_pk PRIMARY KEY (idUzytkownik)
);


CREATE TABLE spizarnia (
                idSpizarnia SERIAL NOT NULL,
                nazwa VARCHAR(32) NOT NULL,
                idUzytkownik INTEGER NOT NULL,
                CONSTRAINT spizarnia_pk PRIMARY KEY (idSpizarnia)
);


CREATE TABLE SkladnikSpizarnia (
                idSkladnik INTEGER NOT NULL,
                idSpizarnia INTEGER NOT NULL,
                amount real NOT NULL constraint amountRange check (amount >= 0),
                CONSTRAINT skladnikspizarnia_pk PRIMARY KEY (idSkladnik, idSpizarnia)
);


CREATE TABLE ocena (
                idOcena SERIAL NOT NULL,
                ocenaVal INTEGER constraint ocenaRange check (ocenaVal >= 0 and ocenaVal <=5),
                recenzja TEXT,
                ulubione BOOLEAN NOT NULL,
                data timestamp not null default now(),
                idUzytkownik INTEGER NOT NULL,
                idPRzepis INTEGER NOT NULL,
                CONSTRAINT ocena_pk PRIMARY KEY (idOcena)
);


alter table uzytkownik
    add constraint check_login check (char_length(login) >= 4 and char_length(login)<=16);

alter table uzytkownik
    add constraint check_password check (char_length(pass) >= 4 and char_length(pass)<=16);


ALTER TABLE skladnik ADD CONSTRAINT kategoriaskladnik_skladnik_fk
FOREIGN KEY (idKategoriaSkladnik)
REFERENCES kategoriaSkladnik (idKategoriaSkladnik)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE skladnik ADD CONSTRAINT dostawca_skladnik_fk
FOREIGN KEY (idDostawca)
REFERENCES dostawca (idDostawca)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE danie ADD CONSTRAINT skladnik_danie_fk
FOREIGN KEY (idSkladnik)
REFERENCES skladnik (idSkladnik)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE SkladnikSpizarnia ADD CONSTRAINT skladnik_skladnikspizarnia_fk
FOREIGN KEY (idSkladnik)
REFERENCES skladnik (idSkladnik)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE przepis ADD CONSTRAINT kategoria_dania_przepis_fk
FOREIGN KEY (idKategoriaDania)
REFERENCES kategoriaDania (idKategoriaDania)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE przepis ADD CONSTRAINT wartosciodzywcze_danie_fk
FOREIGN KEY (idWartosci)
REFERENCES wartosciOdzywcze (idWartosci)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

alter table proj_v1.przepis
	add image_link varchar default null;

ALTER TABLE ocena ADD CONSTRAINT przepis_ocena_fk
FOREIGN KEY (idPRzepis)
REFERENCES przepis (idPRzepis)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE danie ADD CONSTRAINT przepis_danie_fk
FOREIGN KEY (idPRzepis)
REFERENCES przepis (idPRzepis)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE ocena ADD CONSTRAINT uzytkownik_ocena_fk
FOREIGN KEY (idUzytkownik)
REFERENCES uzytkownik (idUzytkownik)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE spizarnia ADD CONSTRAINT uzytkownik_spizarnia_fk
FOREIGN KEY (idUzytkownik)
REFERENCES uzytkownik (idUzytkownik)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE SkladnikSpizarnia ADD CONSTRAINT spizarnia_skladnikspizarnia_fk
FOREIGN KEY (idSpizarnia)
REFERENCES spizarnia (idSpizarnia)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;