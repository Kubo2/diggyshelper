# CHANGELOG

This changelog contains all major and minor changes done in united versions.

# Features

For more information about _planned features_, please [see TODO list](TODOlist.md).

## Proposed to v1.5, release date: 2017-02-28

(not available)

## Proposed to v1.5-beta2, release date: 2017-02-21

* Frontend looks dark-theme fixes (~WladinQ)
* Fix XSS hole in `post_reply.php`: passing raw `$_GET` (non-escaped) to the output

## v1.5-beta1, release date: 2017-02-14

* **Complete new frontend looks**, introducing the dark theme (~WladinQ)
+ Bulletin Board (BB) codes parsing in user-written posts. (~Kubo2)
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
* Rewritten sitemaps from scratch (~Kubo2)
  + Add a sitemap listing of the topics on the forum

# Previous versions

We're sorry, previous versions aren't recorded here.
