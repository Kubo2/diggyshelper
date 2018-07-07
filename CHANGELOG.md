# CHANGELOG

This changelog contains all the changes released in the major, minor and patch versions of dh Forum.

<!-- committers -->
[0]: https://github.com/Kubo2
[1]: https://github.com/WladinQ

So far we are approaching the grand __v2.0__, step-by-step, with several minors and their patches. But this release will
mark the beginning of real development, instead of the current rewriting of each and every piece of code.


# Features

For more information about _planned features_, please check out our [TODO list](TODOlist.md).


## Proposed to v1.6

Expected release date: within the next two years.


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
* rel=canonical now points to the https: version ([@Kubo2][0])
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

* (Supposedly) Fix issue [#8](https://github.com/Kubo2/diggyshelper/issues/8) where the mobile menu couldn't be opened in Android Browser 4.0 and older ([@Kubo2][0])


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
