# CHANGELOG

This changelog contains all the changes released in the major, minor and patch versions of dh Forum.

<!-- committers -->
[0]: https://github.com/Kubo2
[1]: https://github.com/WladinQ


# Release Cycle

So far we are approaching the grand __v2.0__, step-by-step, with several minors and their patches. But v2.0 is expected
to be the final milestone for this project to reach, at which point it should become an internally consistent, feature rich
and extensible community forum software, capable of competition on the market.

At the time, a new patch version with new features is released on every _third lunar quarter_, a few days after a full moon but
some more before the next new moon. A new minor is released twice a year:

* on _August 15th_ (India's Independence Day),
* on _February 28th_ (the second-to-last day of February every four years).

The minor releases feature backwards incompatible changes and other major changes to the codebase, that aren't necessarily one feature.

The inspiration for this is taken from the [Principia project](https://github.com/mockingbirdnest/Principia#readme). A lunar phase calendar can be found [here (in Slovak)](http://kalendar.azet.sk/lunarny/).


# New features

For more information about _planned features_, please check out our [TODO list](TODOlist.md). We also keep an internal
Board on Trello as well as a few GitHub Projects, which is to be frank, a _mess_, so we plan for this to change in the near future to simplify our workflow.


## Proposed to v1.6

Expected release date: within the next two years.


## Proposed to v1.5.x

Expected release date: as per the [release cycle](#release-cycle).

* Upraviť náš CHANGELOG.md, aby sa viac ponášal na štandardný formát „[Udržuj changelog](https://keepachangelog.com/sk/)“
+ Umiestniť na stránky okienko s odkazom na Google Forms, cez ktoré mienime istý čas zbierať spätnú väzbu od používateľov
+ V rámci plánovanej novej črty „tagy namiesto kategórií“ začať zobrazovať v téme lištu s nápisom „Týka sa: “ + názov kategórie
* Namiesto dátumu a času na hlavnej stránke začať zobrazovať frázy typu „pred minútou“, „pred 2 hodinami“ či „dávno“
+ [internal] Add `lib/urls.php` to decouple the real-world URLs from source code (no more hardcoding of URLs); this is not a router yet, just a `sprintf()` wrapper
* Ešte rýchlejšie načítavanie: preloaded font and perhaps also a HTTP/2 server push of `css/style.css` and `diggyshelper.js`
* Prívetivý jazyk: 1s a 2s, akoby to bol dialóg medzi mnou a tebou
* Lepšia štatistika: overhaul stránky `statistics.php`
+ Použiť composer autoload namiesto individuálneho `require`ovania jednotlivých súborov


## v1.5.6

Expected release date: 2018-10-02.

- Remove the deprecated data sanitization library which was a deadborn child: SanitizeLib


## v1.5.5

Released on 2018-09-03.

+ Setup continuous integration testing for unit tests with Travis CI ([@Kubo2][0])
+ [Feature] Add Schema.org structured content for better crawler-experience ([@Kubo2][0])
+ [Feature] Témy s novými príspevkami, predtým navštívené používateľom, sa na hlavnej stránke zvýraznia zelenou guľôčkou ● ([@Kubo2][0])
- Remove the .light style declarations from `css/style.css`: the _design toggle_ feature is not happening ([@Kubo2][0])


## v1.5.4

Released on 2018-08-14.

+ Port all tests from php-src's run-tests.php to [Codeception](https://codeception.com/), a powerful PHP testing framework ([@Kubo2][0])
+ Make all files use $dbContext returned by connect.php to explicitly describe their database dependency ([@Kubo2][0])
- Vyprostenie sa z _cid-pekla_: odstránená interná závislosť príspevkov a tém na kategóriách ([@Kubo2][0])
* Rewrite our TODOlist to make it significantly more readable + add README ([@Kubo2][0])
* Switch the live server definitively to HTTPS (a redirect from HTTP occurs): [SSL issue #13](https://github.com/Kubo2/diggyshelper/issues/13) ([@Kubo2][0])
* Fix buggy getUser() behavior on a non-existent user ([@Kubo2][0])
- Remove the explicit Google Search Console site verification via a HTML file ([@Kubo2][0])
- Instruct search engines not to index but simply follow the links on any view.php?cid=\d+ page ([@Kubo2][0])
- Remove `members.php` completely (after a period of serving it as 410 gone) ([@Kubo2][0])
* Other minor but important fixes (connect.php, typos, header comments, etc.)


## v1.5.3

Released on 2018-03-11.

* Make the footer links look more technical ([@Kubo2][0])
+ Povolený BB kód `[img]https://obrazok[/img]` do používateľských príspevkov ([@Kubo2][0])
* rel=canonical now points to the https:// version ([@Kubo2][0])
* Deprecate SanitizeLib


## v1.5.2

Released on 2017-03-30.

* Add reached DA levels into `attractions.php` instead of having them be posted in a regular topic ([@WladinQ][1])
* Remove the dependency on support.diggysadventure.com for our hotlinked images in `whatandhow.php`, store the files locally instead ([@Kubo2][0])
* Dark-theme improvements ([@WladinQ][1])
* Stick to our new [CSS Coding Standards (in slovak)](https://github.com/Kubo2/diggyshelper/wiki/CSS-%C5%A1tylistika-k%C3%B3du) in `css/style.css` ([@Kubo2][0])
* Flip the order of the footer links to FB and GitHub + forward fix the [window.opener](http://jecas.cz/noopener) vulnerability of theirs ([@Kubo2][0])


## v1.5.1

Released on 2017-03-15.

* Issue [#14](https://github.com/Kubo2/diggyshelper/issues/14) first point: let `connect.php` always return the mysql connection resource in case the connection is successfuly established ([@Kubo2][0])
* Fix column 'Autor posledného príspevku' in `index.php`: show last post date and author instead of self-related topic data ([@Kubo2][0])
* Replace HTTP 304 Not Modified with HTTP 503 Service Unavailable and an error message in `index.php` when no topics could be fetched or database unavailable ([@Kubo2][0])
+ In the `create.php`/`post_reply.php` form hide the bbcode snippet buttons when HTML is chosen as the form's markup ([@Kubo2][0])


## v1.5

Released on 2017-02-28.

* Fix issue [#8](https://github.com/Kubo2/diggyshelper/issues/8) where the mobile menu couldn't be opened in Android Browser 4.0 and older ([@Kubo2][0])


## v1.5-beta2

Released on 2017-02-21.

* Frontend looks dark-theme fixes ([@WladinQ][1])
* Fix XSS hole in `post_reply.php`: passing raw `$_GET` (non-escaped) to the output ([@Kubo2][0])
* Fix having implemented admin markup-switch for new posts, but not for new topics ([@Kubo2][0])


## v1.5-beta1

Released on 2017-02-14.

* **Complete new frontend looks**, introducing the dark theme ([@WladinQ][1])
+ Bulletin Board (BB) codes parsing in user-written posts. ([@Kubo2][0])
+ Introduced the basic support for responsive design - created responsive mobile menu ([@Kubo2][0])
+ Added user profiles support (one page per user) with some additional functionalities such as the ability to alter user informations ([@Kubo2][0])
  * There was new user-property added for user record - `description`.
+ Improved topic page (title of the topic is now only once there) ([@Kubo2][0])
+ Added authentization page template -- user can authorizate him/her wherever it is needed ([@Kubo2][0])
- Removed tracking of the "topic views" ([@Kubo2][0])
- Removal of the 'most viewed topic' in statistics ([@Kubo2][0])
+ Fixed some general minor bugs ([@Kubo2][0] + [@WladinQ][1])
+ The 'Back' ('Späť') button above on topic page now always links to the topic's category ([@Kubo2][0])
+ Add PHPT test-case (sucks) ([@Kubo2][0])
* Rewritten sitemaps from scratch ([@Kubo2][0])
  + Add a sitemap listing of the topics on the forum


# Previous versions

We're sorry, previous versions hadn't been recorded here.
