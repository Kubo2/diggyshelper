# CHANGELOG

This changelog contains all the changes released in major, minor and patch versions of the dh Forum.


# Features

For more information about the _planned features_, please check out our [TODO list](TODOlist.md).


## Proposed to v1.5.2

* Remove the dependency on support.diggysadventure.com for our hotlinked images in `whatandhow.php`, store the files locally instead (~ Kubo2)


## v1.5.1, release date: 2017-03-15

* Issue [#14](https://github.com/Kubo2/diggyshelper/issues/14) first point: let `connect.php` always return the mysql connection resource in case the connection is successfuly established (~ Kubo2)
* Fix column 'Autor posledného príspevku' in `index.php`: show last post date and author instead of self-related topic data (~ Kubo2)
* Replace HTTP 304 Not Modified with HTTP 503 Service Unavailable and an error message in `index.php` when no topics could be fetched or database unavailable (~ Kubo2)
+ In the `create.php`/`post_reply.php` form hide the bbcode snippet buttons when HTML is chosen as the form's markup (~ Kubo2)


## v1.5, release date: 2017-02-28

* (Supposedly) Fix issue [#8](https://github.com/Kubo2/diggyshelper/issues/8) where the mobile menu couldn't be opened in Android Browser 4.0 and older (~ Kubo2)


## v1.5-beta2, release date: 2017-02-21

* Frontend looks dark-theme fixes (~ WladinQ)
* Fix XSS hole in `post_reply.php`: passing raw `$_GET` (non-escaped) to the output (~ Kubo2)
* Fix having implemented admin markup-switch for new posts, but not for new topics (~ Kubo2)


## v1.5-beta1, release date: 2017-02-14

* **Complete new frontend looks**, introducing the dark theme (~ WladinQ)
+ Bulletin Board (BB) codes parsing in user-written posts. (~ Kubo2)
+ Introduced the basic support for responsive design - created responsive mobile menu (~ Kubo2)
+ Added user profiles support (one page per user) with some additional functionalities such as the ability to alter user informations (~ Kubo2)
  * There was new user-property added for user record - `description`.
+ Improved topic page (title of the topic is now only once there) (~ Kubo2)
+ Added authentization page template -- user can authorizate him/her wherever it is needed (~ Kubo2)
- Removed tracking of the "topic views" (~ Kubo2)
- Removal of the 'most viewed topic' in statistics (~ Kubo2)
+ Fixed some general minor bugs (~ Kubo2 + WladinQ)
+ The 'Back' ('Späť') button above on topic page now always links to the topic's category (~ Kubo2)
+ Add PHPT test-case (sucks) (~ Kubo2)
* Rewritten sitemaps from scratch (~ Kubo2)
  + Add a sitemap listing of the topics on the forum


# Previous versions

We're sorry, previous versions aren't recorded here.
