# CHANGELOG

This changelog contains all the changes released in major, minor and patch versions of the dh Forum.

<!-- committers -->
[0]: https://github.com/Kubo2
[1]: https://github.com/WladinQ

So far we are approaching the grand __v2.0__ step-by-step with minors and their patches, but that one will
mark the beginning of the real development instead of just rewriting each and every piece of code.


# Features

For more information about the _planned features_, please check out our [TODO list](TODOlist.md).


## Proposed to v1.6

- Remove `members.php` completely (after a period of serving it as 410 gone) ([@Kubo2][0])
* Finalize the [SSL issue #13](https://github.com/Kubo2/diggyshelper/issues/13) (--)
* Finalize the [Prechod na mysqli issue #14](https://github.com/Kubo2/diggyshelper/issues/14) (--)


## Proposed to v1.5.x

Sometime in one of the future v1.5 patches but before the full new v1.6 minor.


## Proposed to v1.5.3

* Make the footer links look more technical ([@Kubo2][0])
+ Povolený BB kód `[img]https://obrazok[/img]` do používateľských príspevkov ([@Kubo2][0])
* rel=canonical now points to the https: version ([@Kubo2][0])


## v1.5.2, release date: 2017-03-30

* Add reached DA levels into `attractions.php` instead of having them being posted in a regular topic ([@WladinQ][1])
* Remove the dependency on support.diggysadventure.com for our hotlinked images in `whatandhow.php`, store the files locally instead ([@Kubo2][0])
* Dark-theme improvements ([@WladinQ][1])
* Stick to our new [CSS Coding Standards (in slovak)](https://github.com/Kubo2/diggyshelper/wiki/CSS-%C5%A1tylistika-k%C3%B3du) in `css/style.css` ([@Kubo2][0])
* Flip the order of the footer links to FB and GitHub + forward fix the [window.opener](http://jecas.cz/noopener) vulnerability of theirs ([@Kubo2][0])


## v1.5.1, release date: 2017-03-15

* Issue [#14](https://github.com/Kubo2/diggyshelper/issues/14) first point: let `connect.php` always return the mysql connection resource in case the connection is successfuly established ([@Kubo2][0])
* Fix column 'Autor posledného príspevku' in `index.php`: show last post date and author instead of self-related topic data ([@Kubo2][0])
* Replace HTTP 304 Not Modified with HTTP 503 Service Unavailable and an error message in `index.php` when no topics could be fetched or database unavailable ([@Kubo2][0])
+ In the `create.php`/`post_reply.php` form hide the bbcode snippet buttons when HTML is chosen as the form's markup ([@Kubo2][0])


## v1.5, release date: 2017-02-28

* (Supposedly) Fix issue [#8](https://github.com/Kubo2/diggyshelper/issues/8) where the mobile menu couldn't be opened in Android Browser 4.0 and older ([@Kubo2][0])


## v1.5-beta2, release date: 2017-02-21

* Frontend looks dark-theme fixes ([@WladinQ][1])
* Fix XSS hole in `post_reply.php`: passing raw `$_GET` (non-escaped) to the output ([@Kubo2][0])
* Fix having implemented admin markup-switch for new posts, but not for new topics ([@Kubo2][0])


## v1.5-beta1, release date: 2017-02-14

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

We're sorry, previous versions aren't recorded here.
