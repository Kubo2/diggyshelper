TODO List
=========

Intro
-----

This is small simple list of things that should be created or fixed in next revisions.

When you add/fix some thing that is in this list, just mark it as solved with __+/__ (__plus sign__ followed by a __slash__).

When there is some thing, that has been already discussed and it should be done but it is not in the list, just add it please. You can do it by editing this file, adding newline in the following section *Stuff*, then typing \* (star symbol) and writing/describing thing to do.

Thanks for understanding.

Stuff
-----

 - odstrániť repo diggyshelper-2.0
 - premenovať repo diggyshelper-old -> diggyshelper na GitHube __+/__
 - vytvoriť dlhodobú vetvu diggyshelper/dev __+/__
 - opraviť bezpečnostné chyby (najmä diggyshelper/SQLInj-prevent) - @Kubo2
 - začleniť diggyshelper/SQLInj-prevent do diggyshelper/master a zmazať ju - @Kubo2 || __del__
 -- začleniť diggyshelper/SQLInj-prevent do diggyshelper/dev a zmazať - @Kubo2
 - Testovaciu verziu nahrať na server diggyshelper.php5.sk
 - po dôkladnom otestovaní (alebo hneď) nahrať poslednú revíziu fóra aj so stávajúcou DB na nový server diggyshelper.net
 - Na server diggyshelper.php5.sk umiestniť presmerovací skript na novú doménu a ostatný obsah premiestniť do adresára diggyshelper.php5.sk/beta/, kde bude odvtedy prebiehať testovanie nových verzií softwaru
 - na Google Webmasters Tools oznámiť Googlebotovi, že sa web presunul na novú doménu
 -- Novú revíziu, ktorá bude ako prvá nahraná na server diggyshelper.net označiť značkou a do prísliušného commitu/revízie zaradiť súbor, ktorý sa postará o parsovanie a presmerovanie starých adries na nové (ale až keď nové budú :D!)
 - Prevent these files from SQL Injection:
  * register.php __+/__
  * login.php __+/__
  * create.php & create_topic.php
  * post_reply.php & post_reply_parse.php
  * upload.php
  * view.php & view_topic.php
  * forum.php __+/__