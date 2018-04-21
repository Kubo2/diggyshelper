# TODO (do ďalšej @stable)


## Funkcionalita _obnoviť heslo_

- [ ] hotovo?
* zaviesť samostatný formulár alebo nejaký iný spôsob pre používateľov, aby si mohli obnoviť zabudnuté heslá k svojim účtom


## Notifikácie o nových príspevkoch

- [ ] hotovo?
* Emailové notifikácie
* Webové notifikácie
* Messenger notifikácie


## Upload používateľských obrázkov _k príspevkom_

- [ ] hotovo?
* využiť [api.tinify.com](https://tinypng.com/developers) pre kompresiu obrázkov pred nahratím na server (šetrí miesto)

### jednoduché riešenie

- [ ] hotovo?
* využiť neoficiálne API servera [img.djpw.cz](http://img.djpw.cz)
* upload na endpoint `http://img.djpw.cz/upload-data` a získanie URL obrázka z JSON odpovede servera

### dlhodobé riešenie

- [ ] hotovo?
* naprogramovať upload používateľských obrázkov cez webové rozhranie do databázového úložiska na serveri
* vytvoriť lokálny API endpoint pre jednoduché programatické nahrávanie používateľských obrázkov na server
* napísať klientské rozhranie pre nahrávanie obrázkov priamo integrované do rozhrania formulára pre napísanie príspevku, v jazyku JavaScript
  * toto rozhranie musí spĺňať podmienku, že po nahratí obrázka vloží do textarey s príspevkom bb text `[img]url-obrazka[/img]`


## Upload používateľských obrázkov _k profilu_

- [ ] hotovo?
* implementovať Gravatar
* implementovať prevzatie facebook profile picture


## Polymorfné prihlasovanie

- [ ] hotovo?
* implementovať [OAuth 2.0](https://oauth.net/2/)
* implementovať prihlasovanie použitím používateľských účtov od iných ručiteľov identity než lokálna databáza
* umožniť naviac prihlasovanie použitím účtu od [Google](https://www.google.com) alebo [Facebooku](http://fb.com), nasledujúc vzor [Pixelu](https://pixelfederation.com)


## Poďakovanie za príspevok

- [ ] hotovo?
* implementovať možnosť používateľov z radov členov aj používateľov z radov okoloidúcich návšteníkov _**poďakovať za hodnotný príspevok**_, ktorý obsahuje kvalitné informácie a/alebo svojím obsahom nejakým spôsob bol nápomocný týmto používateľom
* inšpirovať sa _Claps_ funkcionalitou zo siete webov [Medium](https://medium.com)


## Upravovanie príspevkov

- [ ] hotovo?
* umožniť moderátorom i nemoderátorom upraviť obsah príspevkov po ich odoslaní


## Problém s _Čo a ako_

- [ ] hotovo?
* rozdeliť neprehľadnú a obsahovo bohatú stránku na jednotlivé body
  * každý bod by mal mať svoju vlastnú URL adresu, a samozrejme _Čo a ako_ by si malo zachovať svoju URL adresu
  * JavaScriptové klientské rozhranie by malo zabezpečiť zmenu URL adresy bez prechodu na odkazovanú stránku a zobrazenie odpovede akoby pod daným bodom, či odkazom, na ktorý bolo kliknuté, pričom ktorýkoľvek iný „zobrazený“ bod sa zatvorí
* obsah _Čo a ako_ nahradiť „rozcestníkom“ – súhrnom otázkových odkazov odkazujúcich na jednotlivé odpovede
  * obsah _Čo a ako_ (`whatandhow.php`) mimo vlastných otázok rozumne zlúčiť s obsahom _O hre Diggy's Adventure_ (`about-game.php`) a to posledné odstrániť
* rozumne roztriediť otázky (body) do tematických kategórií (vedľajší efekt, kvôli návrhom v rôznych kategóriách na fóre)


## Stránkovanie dlhých tém

- [ ] hotovo?
* rozdeliť veľmi dlhé a stredne dlhé témy na stránky o určitom množstve príspevkov
* umožniť _konfigurovať_ vlastnosti stránkovania
