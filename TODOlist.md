# Zoznam úloh

 Zjednotený štruktúrovaný a formátovaný zoznam čakajúcich úloh.

## Preambula

 Po dokončení vašej práce na jednej z úloh, prosím nájdite ju v tomto zozname a označte ju sekvenciou `[x]`. Následne bude riešenie úlohy prezreté niektorým z administrátorov repozitára projektu a po začlenení bude úloha zo zoznamu odstránená.

 Všetky úlohy by mali byť jednoznačne kategorizované. (V prípade neexistencie príslušnej kategórie je samozrejmosťou jej zavedenie.)

## Štruktúra

 Dohodnútá štruktúra tohoto súboru je popísaná našej [GitHub wiki](https://github.com/Kubo2/diggyshelper/wiki/Zoznam-úloh); predovšetkým je však potrebné vedieť, že tento súbor je písaný v tzv. _Flavored Markdown_, ale mal by byť spracovateľný akýmkoľvek Markdownovým parserom.

## Do ďalšej @stable
### Pre administrátorov

  - [ ] zaregistrovať/objednať hosting pre skladovanie dát na serveroch Amazon SSS (S3) — http://djpw.cz/158727
  - [ ] vytvoriť **GitHub wiki** repozitára s informáciami pre developerov
  - [ ] skonvertovať `database-state.xml` z CRLF na LF

### Pre vývojárov

  - [ ]  (!) Upload obrázkov do `images/profilefoto` namiesto Amazon S3 (dočasne)

#### Príspevky

  - [ ]  (!) Poďakovanie za hodnotný príspevok (členovia aj návštevníci)
  - [ ] Upravovanie príspevkov
  - [ ] Po nahratí obrázku _na pozadí_ automaticky vložiť do príspevku za kurzor značku `[img][/img]` s URL adresou nahraného obrázku (#ref/JS)

#### Prihlasovanie

Implementovať:

  - [ ] prihlasovanie pomocou facebook account
  - [ ] funkciu "Zapamätať si ma"
  - [ ] mechanizmus "Zabudli ste heslo?"

#### Používatelia
##### skupiny používateľov (`admin`, `moderator`, `member`)

  - [ ] dorobit moderatorov fora
    - [ ] rozlíšiť práva moderátorov a administrátorov
      - [x] partially in forum posts

#### upload obrázkov

  - [ ] implementovať Gravatar
  - [ ] implementovať nahrávanie obrázkov do DB
  - [ ] prepojenie so servermi Amazon S3 za pomoci REST API
  - [ ] after upload resize image to 350x250px or simply 3:1

### Frontend
#### Hlavička stráky

  - [ ] **tlačítka "Zapamätať heslo" a "Zabudli ste heslo?" v *userbox*e**

#### Fórum (príspevky, kategórie, vlákna atď.)

  - [ ] odkazy v príspevkoch by mali byť bez dekorácií modrou farbou akou sú teraz odkazy vo {web/index.php}
  - [ ] naprogramovat pocet 20tich blokov s príspevkami na  jednu stranku

### Obsah
#### Stránky: Čo a ako

  - [ ] Zotriediť otázky-odpovede podľa kategórií
  - [ ] Rozlíšiť medzi `about-game.php` a `whatandhow.php` (alebo začleniť jednu do druhej)

#### Duplicitné titulky

  - [ ] `about-game.php`: nemá vlastný &lt;title>
  - [x] `view.php`: všetky kategórie majú ten istý &lt;title> (adresované)
