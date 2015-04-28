# Zoznam úloh

 Zjednotený štruktúrovaný a formátovaný zoznam čakajúcich úloh.

## Preambula

 Po dokončení vašej práce na jednej z úloh, prosím nájdite ju v tomto zozname a označte ju sekvenciou `[x]`. Následne bude riešenie úlohy prezreté niektorým z administrátorov repozitára projektu a po začlenení bude úloha zo zoznamu odstránená.

 Všetky úlohy by mali byť jednoznačne kategorizované. (V prípade neexistencie príslušnej kategórie je samozrejmosťou jej zavedenie.)

## Štruktúra

 Dohodnútá štruktúra tohoto súboru je popísaná našej [GitHub wiki](https://github.com/Kubo2/diggyshelper/wiki/Zoznam-úloh); predovšetkým je však potrebné vedieť, že tento súbor je písaný v tzv. _Flavored Markdown_, ale mal by byť spracovateľný akýmkoľvek Markdownovým parserom.

## ÚLOHY
### Úlohy špecifické administrátorom repozitára

  - [ ] zaregistrovať/objednať hosting pre skladovanie dát na serveroch Amazon SSS (S3) — http://djpw.cz/158727
  - [ ] vytvoriť **GitHub wiki** repozitára s informáciami pre developerov

### Úlohy pre vývojárov serverovej aplikácie

  - [ ]  (!) Upload obrázkov do `images/profilefoto` namiesto Amazon S3 (dočasne)

#### Príspevky

  - [ ] Upravovanie príspevkov
  - [ ] Po nahratí obrázku _na pozadí_ automaticky vložiť do príspevku za kurzor značku `[img][/img]` s URL adresou nahraného obrázku (#ref/JS)

#### implementácia užívateľov
##### Login form

  - [ ] functionality of "Zapamätať heslo" button
  - [ ] functionality of "Zapamätať si ma" button
  - [ ] functionality of "Zabudli ste heslo?" button

##### skupiny používateľov (plus rozdeľovanie na špecifické skupiny: admin, moderator, member)

  - [ ] dorobit moderatorov fora
    - [ ] rozlíšiť práva moderátorov a administrátorov
      - [x] partially in forum posts

#### upload obrázkov

  - [ ] prepojenie so servermi Amazon S3 za pomoci REST API
  - [ ] after upload resize image to 350x250px or simply 3:1

### úlohy týkajúce sa designu a textov (obsah/forma)
#### Hlavička stráky

  - [ ] buttons "Zapamätať heslo" and "Zabudli ste heslo?" v user-boxe

#### Fórum (príspevky, kategórie, vlákna atď.)

  - [ ] odkazy v príspevkoch by mali byť bez dekorácií modrou farbou akou sú teraz odkazy vo {web/index.php}
  - [ ] naprogramovat pocet 20tich blokov s príspevkami na  jednu stranku
