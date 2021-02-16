----------------------------------------------------------------------------------------------------------
-- insert kategoriadania

insert into kategoriadania (rodzaj, kategoria) VALUES ('sniadanie','vege');
insert into kategoriadania (rodzaj, kategoria) VALUES ('sniadanie','bezglutenowe');
insert into kategoriadania (rodzaj, kategoria) VALUES ('sniadanie','normal');

insert into kategoriadania (rodzaj, kategoria) VALUES ('obiad','vege');
insert into kategoriadania (rodzaj, kategoria) VALUES ('obiad','bezglutenowe');
insert into kategoriadania (rodzaj, kategoria) VALUES ('obiad','normal');

insert into kategoriadania (rodzaj, kategoria) VALUES ('kolacja','vege');
insert into kategoriadania (rodzaj, kategoria) VALUES ('kolacja','bezglutenowe');
insert into kategoriadania (rodzaj, kategoria) VALUES ('kolacja','normal');

insert into kategoriadania (rodzaj, kategoria) VALUES ('przekaska','vege');
insert into kategoriadania (rodzaj, kategoria) VALUES ('przekaska','bezglutenowe');
insert into kategoriadania (rodzaj, kategoria) VALUES ('przekaska','normal');


------------------------------------------------------------------------------------------------------------
-- insert kategoriaskladnik

insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('warzywa', 'szt');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('warzywa', 'g');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('nabial', 'szt');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('nabial', 'g');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('nabial', 'ml');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('mieso', 'g');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('przyprawy', 'g');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('przyprawy', 'szt');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('przyprawy', 'ml');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('zboze', 'g');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('orzechy', 'g');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('owoce', 'g');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('owoce', 'szt');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('nasiona', 'g');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('ryby', 'szt');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('ryby', 'g');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('olej', 'ml');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('mieso', 'szt');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('rosliny', 'szt');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('rosliny', 'g');
insert into kategoriaskladnik (rodzaj, jednostka) VALUES ('pieczywo', 'szt');




----------------------------------------------------------------------------------------------------------

-- insert wartosci

insert into wartosciodzywcze values (1, 92, 8, 3, 5);
insert into wartosciodzywcze values (2, 208, 25, 8, 8);
insert into wartosciodzywcze values (3, 264, 13, 7, 20);
insert into wartosciodzywcze values (4, 154, 7, 3, 12);
insert into wartosciodzywcze values (5, 163, 8, 11, 10);
insert into wartosciodzywcze values (6, 178, 24, 13, 3);
insert into wartosciodzywcze values (7, 130, 20, 9, 3);
insert into wartosciodzywcze values (8, 120, 10, 12, 10);
insert into wartosciodzywcze values (9, 62, 9, 4, 6);
insert into wartosciodzywcze values (10, 120, 12, 6, 9);
insert into wartosciodzywcze values (11, 120, 2, 8, 10);
insert into wartosciodzywcze values (12, 140, 16, 10, 6);
insert into wartosciodzywcze values (13, 170, 8, 14, 12);
insert into wartosciodzywcze values (14, 90, 10, 4, 4);
insert into wartosciodzywcze values (15, 80, 12, 13, 6);
insert into wartosciodzywcze values (16, 60, 7, 3, 6);
insert into wartosciodzywcze values (17, 241, 23, 14, 11);
insert into wartosciodzywcze values (18, 160, 20, 8, 9);
insert into wartosciodzywcze values (19, 200, 20, 3, 11);
insert into wartosciodzywcze values (20, 180, 38, 5, 4);
insert into wartosciodzywcze values (21, 173, 28, 4, 4);
insert into wartosciodzywcze values (22, 321, 38, 5, 17);
insert into wartosciodzywcze values (23, 120, 3, 9, 8);
insert into wartosciodzywcze values (24, 100, 7, 4, 7);
insert into wartosciodzywcze values (25, 128, 20, 7, 3);
insert into wartosciodzywcze values (26, 169, 36, 4, 1);
insert into wartosciodzywcze values (27, 126, 2, 8, 9);
insert into wartosciodzywcze values (28, 60, 10, 2, 2);


------------------------------------------------------------------------------------------------------------------

-- insert przepis

-- glutenFree -- sniadanie
insert into przepis values (1,'Omlet z truskawkami', 'Do miski wsypać mąkę, dodać mleko i wymieszać rózgą na jednolitą masę. Dodać żółtka (białka zachować) oraz cukier i ponownie wymieszać.
Białka ubić oddzielnie z małą szczyptą soli na sztywną pianę. Dodać ją do masy z żółtkami i delikatnie wymieszać łyżką. Rozgrzać patelnię z masłem. Gdy masło zacznie skwierczeć, sklarować je (usunąć pianę). Rozprowadzić masło po całej powierzchni patelni, wlać masę na omlet, wyrównać powierzchnię. Smażyć na mały ogniu przez ok. 5 minut lub do czasu aż omlet będzie od spodu ładnie zrumieniony. Wówczas przewrócić go na drugą stronę, ale nie w całości, tylko odwracać go po kawałku - omlet ma się porozrywać. Po przewróceniu, po ok. 2 minutach smażenia, pokroić te większe kawałki na mniejsze części za pomocą np. silikonowej łopatki. Kawałki omletu poprzewracać jeszcze i obsmażyć z innych stron (niezbyt długo, do ścięcia się surowego ciasta, w sumie przez ok. 2 minuty). Przełożyć na talerz, posypać cukrem pudrem oraz kawałkami truskawek. Część truskawek zmiksować z cukrem i użyć jako sos truskawkowy do omletu. Można też podawać z serkiem waniliowym - homogenizowanym.',
                            '00:30',2,1);


insert into przepis values (2,'Owsianka z masłem orzechowym i owocami','Mleko zagotować w rondelku, zmniejszyć ogień i dodać płatki owsiane oraz siemię lniane. Dokładnie zamieszać i gotować na małym ogniu ok. 5 minut. Zestawić z palnika, dodać pokrojone w plasterki banany oraz masło orzechowe, wymieszać i pozostawić pod przykryciem na 3-4 minuty. Przełożyć do miseczek i posypać świeżymi lub rozmrożonymi owocami leśnymi, orzechami i nasionami.',
                            '00:15',2,2);

-- vege -- sniadanie

insert into przepis values (3,'Hummus z burakiem i chrzanem', 'Bardzo dokładnie zmiksować ciecierzycę z chrzanem i burakami. Dodać czosnek, sok z cytryny, kmin i tahini i ponownie dokładnie zmiksować. Doprawić do smaku solą. Wyłożyć na talerz. Posypać kolendrą, zatarem lub kminem i polać oliwą.',
                            '00:10',1,3);

insert into przepis values (4,'Pasta z cukinii', 'Cebulę kroimy w drobną w kosteczkę i szklimy na niewielkiej ilości oleju. Cukinię obieramy i ścieramy na tarce, dodajemy do cebuli i dusimy aż wszystko będzie miękkie, sok odparuje a całość nabierze konsystencji pasty. Doprawiamy do smaku.',
                            '00:25',1,4);


-- normal -- sniadanie

insert into przepis values (5,'Jajecznica z szynką i szpinakiem', 'Szynkę kroję w drobną kostkę. W garnku wylewam odrobinę oleju, rozgrzewam. Dodaję szynkę a następnie dodaję szpinak świeży i natkę. W miseczce wbijam jajka i rozbijam widelcem. Doprawiam solą i pieprzem do smaku. Wlewam do szynki. Mieszam i smażę ok 4 minut. Można podać z chlebem z masłem.',
                            '00:15',3,5);

insert into przepis values (6, 'Muffiny z kurczakiem i szpinakiem', 'Pierś z kurczaka oczyszczamy, płuczemy i kroimy na dwa kotlety. Doprawiamy odrobiną soli i pieprzu. Każdy kotlet zawijamy w papier do pieczenia i gotowania. Smażymy około 7-8 minut z każdej strony na rozgrzanej patelni bez dodatku tłuszczu, studzimy. Szpinak rozmrażamy, smażymy 2-3 minuty podlewając odrobiną wody. Doprawiamy szczyptą soli, studzimy. Ser kroimy w drobną kostkę. Mąkę mieszamy z proszkiem do pieczenia i 1/2 łyżeczki soli. Do mleka dodajemy jogurt naturalny, olej i jajka, dokładnie miksujemy. Do mąki dodajemy płynne składniki i niezbyt dokładnie mieszamy. Dorzucamy pokrojoną w drobną kostkę pierś z kurczaka, szpinak i ser, ponownie mieszamy. Masę wkładamy do 3/4 wysokości foremek do muffinek (jeśli nie macie nieprzywieralnej formy, posmarujcie ją odrobiną masła i obsypcie bułką tartą). Muffiny pieczemy 20-22 minuty w piekarniku nagrzanym do 180 stopni.',
                            '00:30',3,6);


-- glutenFree -- obiad

insert into przepis values (7, 'Ryż z kurczakiem po meksykańsku','Filet kurczaka pokroić w kostkę, doprawić solą, pieprzem, przyprawami oraz startym czosnkiem. Ugotować ryż w osolonej wodzie, odcedzić, wyłożyć na duży talerz i całkowicie ostudzić. Na patelni rozgrzać oliwę, włożyć mięso i obsmażyć z każdej strony, w sumie przez ok. 3 - 4 minuty. Dodać połowę pokrojonej cebuli oraz paprykę pokrojoną w kostkę. Smażyć mieszając przez ok. 2 minuty. Dodać odcedzoną kukurydzę z fasolką i wymieszać. Wsypać ugotowany ryż, dodać resztę cebuli, wymieszać i smażyć przez ok. 2 minuty. Zdjąć z ognia, dodać obranego i pokrojonego w kostkę pomidora i wymieszać. Wyłożyć na talerz, dodać obrane i pokrojone awokado, skropić limonką, posypać posiekaną papryczką chili i listkami świeżej kolendry.',
                            '00:30',5,7);

insert into przepis values (8, 'Kartoflanka z łososiem', 'Ziemniaki obrać, pokroić w kostkę. Marchewki i pietruszki obrać, pokroić w plasterki lub półksiężyce. Cebulę obrać, drobno posiekać. Na dnie garnka rozgrzać kilka łyżek oliwy, dodać wszystkie przygotowane warzywa, delikatnie podsmażyć. Podsmażone warzywa zalać bulionem warzywnym i gotować do miękkości. Pod koniec gotowania zupę zabielić: śmietanę rozmieszać z kilkoma chochlami wywaru, dodać wszystkie zioła i przyprawy, dokładnie wymieszać (tak, aby nie powstały grudki) i dolać do zupy. Łososia podzielić na mniejsze kawałki i dodać do zupy. Po dodaniu ryby zupy nie przegotowywać, aby ryba pozostała w kawałkach. Kartoflankę z łososiem podawać udekorowaną świeżą lub suszoną natką pietruszki.',
                            '00:40',5,8);

-- vege -- obiad

insert into przepis values (9, 'Zupa krem z soczewicy', 'W garnku na oliwie zeszklić pokrojoną w kosteczkę cebulę, po chwili dodać pokrojone w kosteczkę ząbki czosnku a następnie pokrojonego na małe kawałki pora (białą część). Dodać kminek lub kmin oraz nasiona kolendry (można je wcześniej trochę porozgniatać na desce lub w moździerzu). Smażyć na umiarkowanym ogniu przez około 2 minuty, co chwilę mieszając. Dodać obraną i startą na tarce marchewkę, obrane i pokrojone w małą kosteczkę ziemniaki oraz wsypać suchą soczewicę. Doprawić solą, świeżo zmielonym pieprzem, dodać kurkumę, paprykę w proszku, listek i ziele angielskie. Wymieszać, zalać gorącym bulionem, przykryć i gotować przez ok. 15 minut aż składniki będą bardzo miękkie. Na koniec dodać mleko i podgrzać. Rozgnieść praską do ziemniaków pozostawiając drobne cząsteczki składników. Można też użyć blendera i zmiksować zupę w 2 - 3 miejscach. Podawać z kolendrą lub natką, oliwą, przyprawami.',
                            '00:50',4,9);

insert into przepis values (10, 'Klopsiki z kalafiora w sosie pomidorowym', 'Ryż ugotować w osolonej wodzie zgodnie z przepisem na opakowaniu. Kalafiora umyć, podzielić na różyczki i również ugotować w osolonej wodzie do miękkości, a następnie odcedzić. Cebulę i czosnek drobno pokroić. Na patelni rozgrzać łyżkę oleju, przełożyć cebulę i podsmażyć do zeszklenia, następnie dodać czosnek i smażyć jeszcze ok. minuty. Do miski przełożyć ugotowany ryż, kalafiora, dodać usmażoną cebulkę z czosnkiem i blenderem zmiksować na gładką masę. Następnie dodać jajko, doprawić solą, pieprzem, oregano, ostrą papryką, dodać posiekany koperek i wymieszać podsypując w czasie mieszania bułką tartą do odpowiedniej konsystencji. Z kalafiorowego ciasta uformować klopsiki. Na patelni rozgrzałam olej, przełożyłam klopsiki i smażyć z obu stron do zarumienienia. Gdy klopsiki były już usmażone, wlać na patelnię passatę pomidorową, doprawić oregano i bazylią, wymieszać i podgrzewać jeszcze kilka minut.',
                            '00:40',4,10);

-- normal -- obiad

insert into przepis values (11, 'Tajska zupa z kurczakiem i warzywami', 'Makaron włożyć do garnka, zalać zimną wodą i odstawić na 10 - 15 minut do namoczenia. W garnku na oleju podsmażyć pastę curry (oraz ewentualnie dodać całą trawę cytrynową), dodać pokrojoną na małe kawałeczki pierś kurczaka i podsmażać co chwilę mieszając przez ok. 3 minuty. Dodać drobno pokrojoną cebulę i razem podsmażać ok. 2 minuty. Dodać cienko pokrojoną paprykę i znów smażyć ok. 2 minuty. Wlać gorący bulion i zagotować. Pieczarki pokroić na cienkie plasterki i dodać do zupy. Dodać odcedzony i pokrojony na mniejsze części makaron oraz kukurydzę i gotować całość przez ok. 5 minut. Doprawić sosem rybnym, dodać mleko kokosowe i dokładnie wymieszać je z zupą. Odstawić z ognia, dodać posiekany szczypiorek i skropić limonką. Przed podaniem podgrzać w razie potrzeby oraz posypać listkami kolendry.',
                            '00:25',6,11);

insert into przepis values (12, 'Tortille zapiekane po meksykańsku', 'Na dużej patelni na 2 łyżkach oleju zeszklić pokrojoną w kosteczkę cebulę (ok. 7 minut). Dodać zmielone mięso, posypać przyprawami i mieszając obsmażyć aż zmieni kolor. Przykryć i smażyć dalej na małym ogniu przez 15 minut. Dodać koncentrat pomidorowy, odcedzoną fasolkę i kukurydzę oraz (opcjonalnie) pokrojone suszone pomidory. Wymieszać i gotować wszystko jeszcze przez ok. 5 minut. Farsz wyłożyć na tortille, posypać serem (zachować ok. 1/3 ilości sera na wierzch) i zwinąć w rulony, ułożyć w naczyniu żaroodpornym. Krojone pomidory doprawić solą, pieprzem, szczyptą cukru i gotować przez ok. 10 minut bez przykrycia. Polać po tortillach i posypać pozostałym serem. Piec w piekarniku nagrzanym do 180 stopni C przez ok. 20 minut. Posypać listkami kolendry i podawać.',
                            '00:40',6,12);


-- gluten free -- kolacja

insert into przepis values (13, 'Kokosowy kurczak w słodkim sosie chili', 'Mięso oczyścić z błonek i kostek, pokroić w kostkę. Doprawić solą oraz przyprawami, wymieszać. Następnie obtoczyć w 1 łyżce oleju. Na jednym głębokim talerzu wymieszać skrobię ziemniaczaną i wiórki kokosowe. Do drugiego wbić jajko i roztrzepać, doprawić delikatnie solą. Rozgrzać wok lub głęboką większą patelnię, wlać olej. Kawałki kurczaka najpierw obtoczyć w roztrzepanym jajku, następnie w mieszance skrobi i wiórków kokosowych. Kłaść partiami na rozgrzany tłuszcz i smażyć przez około 2 minuty, przewrócić na drugą stronę i powtórzyć smażenie. Przemieszać i jeszcze przez chwilę podsmażać. Wyłożyć łyżką cedzakową na ręczniki papierowe. Dodać tłuszcz i usmażyć kolejną partię. Wytrzeć naczynie ręcznikiem papierowym z resztek smażenia, włożyć z powrotem całe obsmażone mięso. Podgrzewać przez 1 - 2 minuty, następnie przesunąć mięso na bok a w wolne miejsce wlać wodę i ją zagotować. Dodać słodki sos chili oraz ketchup, wymieszać i zagotować. Połączyć z mięsem i co chwilę mieszając podgrzać wszystko razem oraz zagotować. Podawać z ryżem opcjonalnie posypując listkami kolendry.',
                            '00:45',8,13);

insert into przepis values (14, 'Włoska sałatka ziemniaczana', 'Ziemniaki obrać i ugotować w osolonej wodzie, odcedzić, pokroić. Układać w salaterkach gdy są jeszcze ciepłe lub gorące, przekładając rukolą. Dodać cienko posiekaną czerwoną cebulę, pokrojone suszone pomidory, odcedzone kapary. Polać oliwą i sokiem z cytryny, doprawić zmielonym pieprzem.',
                            '00:20',8, 14);

-- vege -- kolacja

insert into przepis values (15, 'Pudding chia', 'Nasiona chia zalać mlekiem (lekko podgrzanym jeśli chcemy aby pudding był szybciej gotowy), dodać cukier i dokładnie wymieszać (należy mieszać energicznie przez pierwsze kilka minut, wówczas znikną grudki). Wstawić do lodówki na około 1 - 2 godziny, a najlepiej na całą noc. Od czasu do czasu zamieszać, szczególnie w początkowej fazie namaczania. Im chia dłużej namaka tym bardziej pęcznieje. Zgęstniały deser przełożyć do dwóch pucharków lub szklanek i dodać świeże owoce.',
                            '00:10',7, 15);

insert into przepis values (16, 'Boczek z bakłażana', 'Piekarnik nagrzać do 200 stopni C. Bakłażana pokroić na ok. 1/2 cm plasterki. Ułożyć na blaszce do pieczenia wyłożonej papierem do pieczenia. W miseczce wymieszać składniki marynaty, następnie za pomocą pędzelka posmarować bakłażana z jednej strony, następnie przełożyć na drugą stronę i ponownie posmarować marynatą. Znów przewrócić i nasączać bakłażana aż do wyczerpania marynaty. Wstawić do piekarnika i piec przez ok. 25 minut. W ten sposób przygotowanego bakłażana można traktować jako dodatek do kanapek np. z pomidorem, sałatą lub/i awokado oraz majonezem lub hummusem.',
                            '00:40',7, 16);

-- normal -- kolacja

insert into przepis values (17, 'Kanapka z szynką parmeńską, pomidorem i serem brie', 'Pieczywo przekroić wzdłuż na pół i posmarować masłem. Na jednej połówce ułożyć rukolę, następnie szynkę parmeńską oraz pokrojony na plasterki ser i pomidor. Doprawić solą i pieprzem. Kanapkę złożyć i opiec na chrupiąco w opiekaczu do kanapek. Podawać opcjonalnie z oliwą ekstra vergine oraz mini sałatką np. z listków roszponki i plasterków pomidora.',
                            '00:15',9, 17);

insert into przepis values (18, 'Kaszotto botwinkowe z chorizo', 'Odciąć buraczki z botwinki, umyć je i obrać, następnie zetrzeć na tarce o dużych oczkach. Łodyżki z liśćmi botwinki umyć i drobno posiekać. Na dużą i głęboką patelnię (która ma pokrywę) włożyć obrane z błonki i pokrojone w półplasterki chorizo. Na małym ogniu wytapiać przez ok. 3 minuty, w międzyczasie zamieszać. Dodać opłukanego i pokrojonego na cienkie półplasterki pora (biała i jasnozielona część). Wymieszać i smażyć na umiarkowanym ogniu przez ok. 2 minuty. Gdy por będzie miękki dodać opłukaną kaszę i wymieszać. Smażyć przez ok. 3 minuty. Dodać bulion, wymieszać, przykryć i gotować przez 10 minut. Dodać starte buraczki oraz łodyżki (liście zachować na później), wymieszać, uklepać i przykryć pokrywą. Gotować przez ok. 15 minut. Dodać na wierzch liście botwinki, przykryć i gotować przez 10 minut. W międzyczasie wymieszać. Na koniec doprawić solą i pieprzem i odstawić z ognia.',
                            '00:45',9, 18);

-- gluten free -- przekaska

insert into przepis values (19, 'Owoce zapiekane pod kruszonką', 'Piekarnik nagrzać do 200 stopni C. Owoce pozbawić pestek i szypułek, większe pokroić na kawałki. Ułożyć w naczyniu żaroodpornym i polać 3 łyżkami syropu klonowego. W mini melakserze lub rozdrabniaczu chwilę pomiksować płatki owsiane z dodatkiem reszty syropu klonowego, soku z cytryny i oleju kokosowego lub masła, rozdrabniając płatki na mniejsze kawałeczki i łącząc je z dodatkami. Powstałą kruszonkę ułożyć na owocach i wstawić do nagrzanego piekarnika. Piec przez 25 minut na złoty kolor (lub ok. 30 minut w przypadku owoców mrożonych).',
                            '00:50',11, 19);

insert into przepis values (20, 'Domowe nachosy', 'Mąki mieszamy z przyprawami. Dodajemy do nich olej i wrzątek. Intensywnie mieszamy widelcem, a następnie zagniatamy. Odstawiamy na pół godziny. Następnie cienko rozwałkowujemy ciasto i kroimy je na niewielkie trójkąty. Układamy je na blasze wyłożonej papierem do pieczenia i pieczemy w temperaturze 200 stopni przez ok. 10 min. Sos pomidorowy: cebulę pokrojoną w kostkę i posiekany czosnek szklimy na odrobinie oliwy. Dodajemy na patelnię cukier, rozpuszczamy go i dolewamy przecier pomidorowy. Doprawiamy do smaku. Gotujemy na dużym ogniu intensywnie mieszając aż sos zgęstnieje.',
                            '00:30',11, 20);

-- vege -- przekaska

insert into przepis values (21, 'Bruschetta', 'Pieczywo pokroić na kromki, natrzeć przekrojonym na pół ząbkiem czosnku (jeśli lubimy intensywny smak czosnku można użyć  startego). Skropić oliwą extra vergine. Pomidory sparzyć i obrać ze skórki. Pokroić w kostkę, odsączyć z nadmiaru soku. Ułożyć na kromkach pieczywa, opcjonalnie dodać cieniutko pokrojoną dymkę i ser (w małych kawałkach lub starty). Zapiekać w piekarniku pod grillem ok. 5 minut aż grzanki się zrumienią a ser roztopi. Posypać listkami bazylii, doprawić solą i świeżo mielonym pieprzem.',
                            '00:15',10, 21);

insert into przepis values (22, 'Muffiny z jabłkami', 'Jabłka pokroić na ćwiartki, usunąć gniazda nasienne. Pokroić w kosteczkę, wymieszać z sokiem z cytryny i cynamonem. Mąkę wsypać do miski, dodać cukier, sodę, sól, wymieszać. Mleko kokosowe z puszki wymieszać, odmierzyć potrzebną ilość, lekko podgrzać w celu uzyskania jednolitej konsystencji. Zrobić wgłębienie w mące, wlać w nie mleko kokosowe, olej (kokosowy należy roztopić), ocet oraz wanilię, delikatnie i krótko wymieszać łyżką łącząc składniki. Dodać jabłka i znów wymieszać. Wyłożyć do papilotek w formie na muffiny, posypać rodzynkami i brązowym cukrem, wstawić do piekarnika nagrzanego do 180 stopni C i piec przez 25 minut.',
                            '00:40',10, 22);

-- normal -- przekaska

insert into przepis values (23, 'Jajka faszerowane z suszonymi pomidorami', 'Ugotowane jajka przekroić na połówki, wyjąć żółtka i wyłożyć je na talerz, dodać fetę, majonez i rozgnieść widelcem. Dodać drobno posiekane suszone pomidory, doprawić solą oraz pieprzem i wymieszać, pod koniec dodać szczypiorek. Nałożyć w połówki białek. Wymieszać składniki sosu. Na półmisku ułożyć jajka, udekorować sosem i szczypiorkiem.',
                            '00:15',12, 23);

insert into przepis values (24, 'Placki z dyni', 'Dynię przed starciem obrać ze skóry i usunąć pestki. Zetrzeć na tarce na drobnych oczkach, włożyć do miski. Dodać jogurt naturalny, jajka oraz cukier i dokładnie wymieszać, np. rózgą. Do drugiej miski wsypać mąkę oraz proszek do pieczenia, wymieszać łyżką. Połączyć zawartość dwóch misek delikatnie i krótko mieszając łyżką. Rozgrzać patelnię naleśnikową (lub z powłoką teflonową) i posmarować ją olejem lub masłem klarowanym. Nakładać po 2 łyżki ciasta na 1 placka zachowując odstępy. Wyrównać powierzchnię łyżką. Placki smażyć na umiarkowanym ogniu, do czasu aż urosną i będą ładnie zrumienione (przez około 2 minuty). Następnie przewrócić na drugą stronę i smażyć do zrumienienia przez kolejne 2 minuty. Przed smażeniem następnej partii patelnię wyczyścić ręcznikiem papierowym i natłuścić ją.',
                            '00:20',12, 24);

-- vege -- przekaska

insert into przepis values (25, 'Brownie z fasoli', 'Fasolę odcedzić na sitku i przepłukać wodą, odsączyć. Włożyć do melaksera lub blendera i zacząć miksować z daktylami (bez pestek), kakao, miodem, syropem klonowym oraz proszkiem do pieczenia. Dodać jajka i zmiksować na gładką masę, pod koniec dodając olej kokosowy i banany. Dodać posiekane suszone śliwki i wymieszać. Otrzymaną masę przelać do foremki o wymiarach dna ok. 20 x 23 cm i piec przez ok. 40 minut w 170 stopniach C. Wyjąć z piekarnika i ostudzić. Ciasto opcjonalnie polać polewą czekoladową: do miseczki włożyć połamaną na kosteczki czekoladę, wlać mleko i roztopić w mikrofali lub kąpieli wodnej, wymieszać do uzyskania gładkiej konsystencji. Polać po cieście i udekorować pokrojonymi daktylami.',
                            '01:00',10, 25);

insert into przepis values (26, 'Kokosowy ryż z mango', 'Ryż dokładnie wypłukać kilkakrotnie zmieniając wodę, odsączyć. Zalać zimną wodą (1 szklanka), przykryć i gotować na małym ogniu przez ok. 10 minut. Odstawić z ognia i zostawić pod przykryciem na ok. 10 - 15 minut, aby ryż całkowicie wchłonął wodę. Mleko kokosowe zagotować w garnku z dodatkiem cukru i soli. 3/4 mleka wlać do ryżu i wymieszać. Resztę wymieszać z mąką ziemniaczaną (uprzednio rozprowadzić ją w 2 - 3 łyżkach zimnej wody) i zagotować. Otrzymaną polewę zachować do polania ryżu. Mango umyć, obrać i pokroić. Ułożyć na talerzych i skropić sokiem z limonki. Obok wyłożyć ryż (np. za pomocą filiżanki), polać sosem z mleka kokosowego i posypać sezamem. Udekorować listkami mięty.',
                            '00:40',10, 26);

-- normal -- przekaska

insert into przepis values (27, 'Rolada szpinakowa z łososiem', 'Świeży szpinak opłukać i bardzo dokładnie osuszyć. Włożyć na dużą patelnię z dodatkiem masła, dodać przeciśnięty przez praskę czosnek i mieszając podgrzewać aż szpinak zwiędnie. Zmiksować w rozdrabniaczu lub w melakserze na małe drobinki szpinaku, doprawiając solą, pieprzem i gałką muszkatołową. Dokładnie ostudzić. Mrożony szpinak należy dokładnie rozmrozić na sitku. Włożyć na patelnię z masłem i czosnkiem i smażyć mieszając przez ok. 2 minuty. Doprawić solą, pieprzem i gałką. Dokładnie ostudzić. Do ostudzonego szpinaku dodać roztrzepane widelcem żółtka oraz mąkę, wymieszać łyżką. Białka ubić na sztywną pianę i delikatnie wymieszać ze szpinakiem. Dno formy o wymiarach 20 x 30 cm posmarować masłem i położyć arkusz papieru do pieczenia. Otrzymaną masę szpinakową wyłożyć do formy i delikatnie rozpropwadzić po całej powierzchni dna. Wstawić do piekarnika nagrzanego do 175 stopni C i piec przez ok. 10 minut. Wyłożyć na ściereczkę i odkleić papier do pieczenia. Od razu po upieczeniu zawinąć roladkę w ściereczkę i w takiej postaci całkowicie ostudzić. Serek wymieszać z chrzanem i rozsmarować na wewnętrznej stronie rolady. Wzdłuż jednego boku ułożyć plasterki łososia i zawinąć roladkę. Owinąć folią spożywczą i włożyć do lodówki, lub też od razu pokroić na ok. 1,5 cm kawałki i podawać.',
                            '00:30',12, 27);

insert into przepis values (28, 'Pudding ryżowym z cynamonem', 'W szerokim garnku roztopić masło. Dodać mleko, ryż, sól i laskę cynamonu. Zagotować, zmniejszyć ogień i gotować bez przykrycia na małym ogniu przez ok. 40 minut często mieszając drewnianą łyżką. Na samym końcu dodać cukier i mieszać aż się rozpuści. Zdjąć z ognia, podawać posypany mielonym cynamonem.',
                            '00:50',12, 28);

-------------------------------------------------------------------------------------------------------

-- insert skladnik

insert into skladnik values (1,'jajko',null,3);
insert into skladnik values (2,'sól',null,7);
insert into skladnik values (3,'cukier', null, 7);
insert into skladnik values (4, 'mąka owsiana', null, 10);
insert into skladnik values (5, 'kakao', null, 7);
insert into skladnik values (6, 'truskawka', null, 12);

insert into skladnik values (7, 'siemie lniane', null, 14);
insert into skladnik values (8, 'mleko krowie', null, 5);
insert into skladnik values (9, 'masło orzechowe', null, 11);
insert into skladnik values (10, 'banan', null, 13);

insert into skladnik values (11, 'ciecierzyca', null, 14);
insert into skladnik values (12, 'burak',null,1);
insert into skladnik values (13, 'chrzan', null, 7);
insert into skladnik values (14, 'czosnek', null, 8);
insert into skladnik values (15, 'tahini', null, 7);
insert into skladnik values (16, 'kmin rzymski', null, 7);
insert into skladnik values (17, 'oliwa', null, 17);

insert into skladnik values (18, 'cukinia', null, 1);
insert into skladnik values (19, 'cebula',null,1);
insert into skladnik values (20, 'pieprz', null, 7);
insert into skladnik values (21, 'koncentrat pomidorowy', null, 7);
insert into skladnik values (22, 'papryka', null, 1);

insert into skladnik values (23, 'szynka', null, 18);
insert into skladnik values (24, 'szpinak', null, 2);
insert into skladnik values (25, 'natka pietruszki', null, 7);

insert into skladnik values (26, 'pierś z kurzczaka', null, 18);
insert into skladnik values (27, 'ser feta', null, 4);
insert into skladnik values (28, 'mąka pszenna', null, 10);
insert into skladnik values (29, 'proszek do pieczenia', null, 7);
insert into skladnik values (30, 'jogurt naturalny', null, 5);
insert into skladnik values (31, 'olej rzepakowy', null, 17);


insert into skladnik values (32, 'oregano', null, 7);
-- insert into skladnik values (33, 'kmin rzymski', null, 7); -- tu cos dolozyc z id = 33
insert into skladnik values (33, 'owoce leśne', null, 12);

insert into skladnik values (34, 'papryka suszona', null, 7);
insert into skladnik values (35, 'ryż', null, 10);
insert into skladnik values (36, 'kukurydza', null, 20);
insert into skladnik values (37, 'pomidor', null, 1);
insert into skladnik values (38, 'awokado', null, 1);
insert into skladnik values (39, 'limonka', null, 13);

insert into skladnik values (40, 'bulion warzywny', null, 9);
insert into skladnik values (41, 'marchewka', null, 1);
insert into skladnik values (42, 'pietruszka', null, 1);
insert into skladnik values (43, 'ziemniak',null,1);
insert into skladnik values (44, 'łosoś', null, 16);
insert into skladnik values (45, 'śmietana', null, 4);
insert into skladnik values (46, 'majeranek', null, 7);
insert into skladnik values (47, 'kurkuma', null, 7);

insert into skladnik values (48, 'por', null, 1);
insert into skladnik values (49, 'czerwona soczewica', null, 20);
insert into skladnik values (50, 'kolendra', null, 7);
insert into skladnik values (51, 'liść laurowy', null, 8);
insert into skladnik values (52, 'mleko kokosowe', null, 9);

insert into skladnik values (53, 'kalafior', null, 1);
insert into skladnik values (54, 'koperek', null, 8);
insert into skladnik values (55, 'bułka tarta', null, 10);
insert into skladnik values (56, 'passata pomidorowa', null, 9);

insert into skladnik values (57, 'makaron ryżowy', null, 10);
insert into skladnik values (58, 'olej kokosowy', null, 17);
insert into skladnik values (59, 'pasta curry', null, 7);
insert into skladnik values (60, 'bulion drobiowy', null, 9);
insert into skladnik values (61, 'pieczarki', null, 20);
insert into skladnik values (62, 'sos rybny', null, 7);
insert into skladnik values (63, 'szczypiorek', null, 8);

insert into skladnik values (64, 'tortille', null, 21);
insert into skladnik values (65, 'mieso wołowe', null, 6);
insert into skladnik values (66, 'przyprawa kuchni meksykańskiej', null, 7);
insert into skladnik values (67, 'czerowna fasola', null, 20);
insert into skladnik values (68, 'puszka krojonych pomidorów', null, 1);
insert into skladnik values (69, 'ser żółty', null, 4);

insert into skladnik values (70, 'mielony imbir', null, 7);
insert into skladnik values (71, 'mąka ziemniaczana', null, 7);
insert into skladnik values (72, 'wiórka kokosowe', null, 7);
insert into skladnik values (73, 'słodki sos chili', null, 7);
insert into skladnik values (74, 'ketchup', null, 7);

insert into skladnik values (75, 'rukola', null, 20);
insert into skladnik values (76, 'kapary', null, 20);
insert into skladnik values (77, 'sok z cytryny', null, 7);

insert into skladnik values (78, 'nasiona chia', null, 14);
insert into skladnik values (79, 'mango', null, 13);
insert into skladnik values (80, 'maliny', null, 12);

insert into skladnik values (81, 'bakłażan', null, 1);
insert into skladnik values (82, 'sos sojowy', null, 7);
insert into skladnik values (83, 'syrop klonowy', null, 7);
insert into skladnik values (84, 'wędzona papryka', null, 7);

insert into skladnik values (85, 'ciabatta', null, 21);
insert into skladnik values (86, 'masło', null,  4);
insert into skladnik values (87, 'ser brie', null, 4);

insert into skladnik values (88, 'botwinka', null, 19);
insert into skladnik values (89, 'chorizo', null, 6);
insert into skladnik values (90, 'kasza orkiszowa', null, 10);

insert into skladnik values (91, 'mąka kukurydziana', null, 10);
insert into skladnik values (92, 'tymianek', null, 7);
insert into skladnik values (93, 'cebulka dymka', null, 1);

insert into skladnik values (94, 'jabłka', null, 13);
insert into skladnik values (95, 'cynamon', null, 7);
insert into skladnik values (96, 'soda oczyszczona', null, 7);
insert into skladnik values (97, 'ocet winny', null, 7);
insert into skladnik values (98, 'ekstrakt z wanilii', null, 7);
insert into skladnik values (99, 'rodzynki', null, 12);

insert into skladnik values (100, 'majonez', null, 7);
insert into skladnik values (101, 'musztarda', null, 7);

insert into skladnik values (102, 'dynia', null, 2);

insert into skladnik values (103, 'daktyle', null, 13);
insert into skladnik values (104, 'miód', null, 7);
insert into skladnik values (105, 'suszone śliwki', null, 13);

insert into skladnik values (106, 'sezam', null, 14);

insert into skladnik values (107, 'gałka muszkatołowa', null, 7);
insert into skladnik values (108, 'serek Almette', null, 3);

insert into skladnik values (109, 'płatki owsiane', null, 10);
insert into skladnik values (110, 'ostra papryka', null, 2);
insert into skladnik values (111, 'pierś z kurzczaka', null, 6);
insert into skladnik values (112, 'ziele angielskie', null, 8);
insert into skladnik values (113, 'suszone pomidory', null, 1);
insert into skladnik values (114, 'mrożone owoce', null, 12);

------------------------------------------------------------------------------------------------------------------


-- inert danie

insert into danie values (1,125,28,1);
insert into danie values (2,125,8,1);
insert into danie values (3,3,1,1);
insert into danie values (4,12,3,1);
insert into danie values (5,1,2,1);
insert into danie values (6,40,86,1);
insert into danie values (7,50,6,1);

insert into danie values (8,10,109,2);
insert into danie values (9,10,7,2);
insert into danie values (10,500,8,2);
insert into danie values (11,30,9,2);
insert into danie values (12,2,10,2);
insert into danie values (13,50,33,2);

insert into danie values (14,340,11,3);
insert into danie values (15,2,12,3);
insert into danie values (16,10,13,3);
insert into danie values (17,2,14,3);
insert into danie values (18,36,15,3);
insert into danie values (19,3,16,3);

insert into danie values (20,1,18,4);
insert into danie values (21,3,19,4);
insert into danie values (22,5,110,4);
insert into danie values (23,25,21,4);
insert into danie values (24,6,3,4);

insert into danie values (25,60,23,5);
insert into danie values (26,25,24,5);
insert into danie values (27,6,25,5);
insert into danie values (28,8,31,5);

insert into danie values (29,1,26,6);
insert into danie values (30,150,24,6);
insert into danie values (31,100,27,6);
insert into danie values (32,340,28,6);
insert into danie values (33,3,2,6);
insert into danie values (34,6,29,6);
insert into danie values (35,2,1,6);
insert into danie values (36,200,8,6);
insert into danie values (37,80,30,6);
insert into danie values (38,80,31,6);

insert into danie values (39,300,111,7);
insert into danie values (40,5,32,7);
insert into danie values (41,5,34,7);
insert into danie values (42,5,16,7);
insert into danie values (43,2,14,7);
insert into danie values (44,100,35,7);
insert into danie values (45,20,17,7);
insert into danie values (46,1,19,7);
insert into danie values (47,1,22,7);
insert into danie values (48,200,36,7);
insert into danie values (49,1,37,7);

insert into danie values (50,1000,40,8);
insert into danie values (51,2,41,8);
insert into danie values (52,2,42,8);
insert into danie values (53,6,43,8);
insert into danie values (54,1,19,8);
insert into danie values (55,200,44,8);
insert into danie values (56,12,17,8);
insert into danie values (57,75,45,8);
insert into danie values (58,5,32,8);
insert into danie values (59,5,46,8);
insert into danie values (60,6,25,8);
insert into danie values (61,3,47,8);

insert into danie values (62,20,17,9);
insert into danie values (63,1,19,9);
insert into danie values (64,2,14,9);
insert into danie values (65,1,48,9);
insert into danie values (66,1,41,9);
insert into danie values (67,400,43,9);
insert into danie values (68,90,49,9);
insert into danie values (69,500,40,9);
insert into danie values (70,5,16,9);
insert into danie values (71,3,50,9);
insert into danie values (72,5,47,9);
insert into danie values (73,4,34,9);
insert into danie values (74,1,51,9);
insert into danie values (75,1,112,9);
insert into danie values (76,170,52,9);

insert into danie values (77,0.5,53,10);
insert into danie values (78,100,35,10);
insert into danie values (79,1,19,10);
insert into danie values (80,2,14,10);
insert into danie values (81,0.5,54,10);
insert into danie values (82,1,1,10);
insert into danie values (83,24,55,10);
insert into danie values (84,500,56,10);

insert into danie values (85, 25,57,11);
insert into danie values (86, 20,58,11);
insert into danie values (87, 25,59,11);
insert into danie values (88, 1,26,11);
insert into danie values (89, 0.5,19,11);
insert into danie values (90, 0.5,22,11);
insert into danie values (91, 1.5,60,11);
insert into danie values (92, 150,61,11);
insert into danie values (93, 65,36,11);
insert into danie values (94, 250,52,11);
insert into danie values (95, 12,62,11);

insert into danie values (96, 4,64,12);
insert into danie values (97, 1,19,12);
insert into danie values (98, 400,65,12);
insert into danie values (99, 8,66,12);
insert into danie values (100,25,64,21);
insert into danie values (101, 170,67,12);
insert into danie values (102, 170,36,12);
insert into danie values (103, 1,68,12);
insert into danie values (104, 300,69,12);

insert into danie values (105,600,111,13);
insert into danie values (106,100,71,13);
insert into danie values (107,24,72,13);
insert into danie values (108,1,1,13);
insert into danie values (109,100,73,13);
insert into danie values (110,80,74,13);
insert into danie values (111,200,35,13);

insert into danie values (112,1000,43,14);
insert into danie values (113,40,75,14);
insert into danie values (114,0.5,19,14);
insert into danie values (115,6,113,14);
insert into danie values (116,20,76,14);
insert into danie values (117,20,17,14);
insert into danie values (118,6,77,14);

insert into danie values (119,30,78,15);
insert into danie values (120,250,52,15);
insert into danie values (121,24,3,15);
insert into danie values (122,1,79,15);
insert into danie values (123,50,80,15);

insert into danie values (124,1,81,16);
insert into danie values (125,20,82,16);
insert into danie values (126,20,17,16);
insert into danie values (127,10,83,16);
insert into danie values (128,3,20,16);

insert into danie values (129,1,85,17);
insert into danie values (130,20,75,17);
insert into danie values (131,2,23,17);
insert into danie values (132,1,37,17);
insert into danie values (133,50,87,17);

insert into danie values (134,1,88,18);
insert into danie values (135,150,89,18);
insert into danie values (136,1,48,18);
insert into danie values (137,100,90,18);
insert into danie values (138,260,40,18);

insert into danie values (139,600,114,19);
insert into danie values (140,80,83,19);
insert into danie values (141,220,109,19);
insert into danie values (142,18,77,19);
insert into danie values (143,30,58,19);

insert into danie values (144,260,28,20);
insert into danie values (145,230,91,20);
insert into danie values (146,45,31,20);
insert into danie values (147,260,28,20);
insert into danie values (148,8,34,20);
insert into danie values (149,2,28,20);
insert into danie values (150,6,92,20);
insert into danie values (151,200,21,20);
insert into danie values (152,1,93,20);
insert into danie values (153,1,14,20);
insert into danie values (154,10,3,20);

insert into danie values (155,1,85,21);
insert into danie values (156,1,14,21);
insert into danie values (157,2,37,21);
insert into danie values (158,80,69,21);

insert into danie values (159,2,94,22);
insert into danie values (160,6,77,22);
insert into danie values (161,4,95,22);
insert into danie values (162,260,28,22);
insert into danie values (163,160,3,22);
insert into danie values (164,3,96,22);
insert into danie values (165,240,52,22);
insert into danie values (166,50,31,22);
insert into danie values (167,6,97,22);
insert into danie values (168,8,98,22);
insert into danie values (169,65,99,22);

insert into danie values (170,6,1,23);
insert into danie values (171,50,27,23);
insert into danie values (172,50,100,23);
insert into danie values (173,10,63,23);
insert into danie values (174,5,101,23);
insert into danie values (175,50,45,23);

insert into danie values (176,200,102,24);
insert into danie values (177,100,30,24);
insert into danie values (178,2,1,24);
insert into danie values (179,20,3,24);
insert into danie values (180,150,28,24);
insert into danie values (181,6,29,24);

insert into danie values (182,500,67,25);
insert into danie values (183,10,103,25);
insert into danie values (184,50,5,25);
insert into danie values (185,12,104,25);
insert into danie values (186,40,83,25);
insert into danie values (187,18,58,25);
insert into danie values (188,4,1,25);
insert into danie values (189,2,10,25);
insert into danie values (190,10,105,25);

insert into danie values (191,180,35,26);
insert into danie values (192,240,52,26);
insert into danie values (193,36,3,26);
insert into danie values (194,12,71,26);
insert into danie values (195,2,79,26);
insert into danie values (196,0.25,39,26);
insert into danie values (197,20,106,26);

insert into danie values (198,250,24,27);
insert into danie values (199,20,86,27);
insert into danie values (200,1,14,27);
insert into danie values (201,2,1,27);
insert into danie values (202,15,28,27);
insert into danie values (203,0.5,108,27);
insert into danie values (204,10,13,27);
insert into danie values (205,100,44,27);

insert into danie values (206,25,86,28);
insert into danie values (207,1000,8,28);
insert into danie values (208,100,35,28);
insert into danie values (209,3,95,28);
insert into danie values (210,30,3,28);


-- dodanie dostawcow

insert into dostawca (nazwa, adres_link) VALUES ('Biedronka','https://www.biedronka.pl/pl');
insert into dostawca (nazwa, adres_link) values ('Tesco','https://tesco.pl/');
insert into dostawca (nazwa, adres_link) values ('Lidl','https://www.lidl.pl/');

update skladnik set iddostawca = 1 where idskladnik <= 10;
update skladnik set iddostawca = 2 where idskladnik > 10 and idskladnik <= 40;
update skladnik set iddostawca = 3 where idskladnik > 40 and idskladnik <= 60;
update skladnik set iddostawca = 1 where idskladnik > 60 and idskladnik <= 80;
update skladnik set iddostawca = 3 where idskladnik > 80 and idskladnik <= 100;
update skladnik set iddostawca = 2 where idskladnik > 100 and idskladnik <= 114;


insert into uzytkownik (login, pass, imie, nazwisko, isadmin) values ('admin','admin','adminIMIE','adminNAZWISKO',true);