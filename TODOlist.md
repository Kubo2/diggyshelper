# TODO list

 United structured and well-formed list of pending todos.

## Abstract

 After finishing your work on some todo, please check out it here and mark it with `[x]`. It will be later removed from list by repository admin after merging your code review/pull request.

 All todos are clearly cathegorized.

## Structure

 Conventionall structure of this file can be known from our [GitHub wiki](/Kubo2/diggyshelper/wiki/TODO-list-structure); anyway, this file is rendered by Flavored Markdown on GitHub, and may be rendered by Markdown parser anywhere used.

## TODOS
### Todos for developers and repository admin(s)

  - [ ] vytvoriť **GitHub wiki** repozitára s informáciami pre developerov

### Todos about application internalls

  - [ ] lepsie nakodovat button "Späť"

#### BBCode implementation

  - [ ] BBCode parsing in posts
  - [x] Inserting BBCode into textarea ({web/diggyshelper.js})

#### Posts

  - [ ] Posts editing/deleting(?; or hiding) functionality
  - [x] príspevky zobrazovat od najnovsieho
  - [ ] Po nahratí obrázku _na pozadí_ automaticky vložiť do príspevku za kurzor značku `[img][/img]` s URL adresou nahraného obrázku (#ref/JS)

#### Users implementation
##### Login form

  - [ ] functionality of "Zapamätať heslo" button
  - [ ] functionality of "Zapamätať si ma" button
  - [ ] functionality of "Zabudli ste heslo?" button

##### User profile

  - [ ] Functionality of "Zmena osobných informácii" & "Pridať priateľa buttons"

##### USers sections

  - [ ] dorobit moderatorov fora
    - [ ] rozlíšiť práva moderátorov a administrátorov
    - [ ] vyriešiť organizovanie interných záležitostí

#### Image upload

  - [ ] after upload resize image to 350x250px or simply 3:1

### Todos about application form/design
#### Page header

  - [ ] buttons "Zapamätať heslo" and "Zabudli ste heslo?" in header_user-box

##### :After login

  - [ ] medzi "Prihlaseny pouzivatel" a buttony vlozit pocet pridanych tem

#### Forum (topics/threads, cathegories etc.)

  - [ ] Každý príspevok musí mať na výšku minimálne dva riadky (asi nastavením height na 2*`line-height` v {css/style.css})
  - [ ] odkazy v príspevkoch by mali byť bez dekorácií modrou farbou akou sú teraz odkazy vo {web/index.php}
  - [ ] naprogramovat pocet 20tich blokov s nadpismy na  jednu stranku
  - [x] spravit s mena Pridal/a: <MENO> odkaz s presmerovanim na profil

#### Profilová stránka

  - [ ] informácie
    - [x] meno
    - [x] datum registracie
    - [x] email
    - [ ] pocet prispevkou vo fore
  - [ ] pridať buttony: zmena osobných informácií, pridat priatela, 

### URL addresses

  - [ ] upravit link na nieco/MENOUZIVATELA
