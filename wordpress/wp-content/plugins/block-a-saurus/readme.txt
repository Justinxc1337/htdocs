=== Block-a-saurus ===
Contributors: kkoppenhaver
Tags: trex, game, block, gutenberg, blockasaurus
Requires at least: 5.0.0
Tested up to: 5.5.3
Requires PHP: 5.6
Stable tag: 1.0.2
License: GPL2+
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Block-a-saurus is a Gutenberg block that lets users play the jumping T-rex game right within a post!

== Description ==
With Block-a-saurus embedded in a post, your users will be able to click and play an embedded version of the jumping T-Rex game, originally popularized by Google Chrome. This block works on all screen sizes and even allows users to play on mobile using touch controls instead of a keyboard!

== Frequently Asked Questions ==
= Will the plugin add a bunch of Javascript and CSS to my site and make it slow? =

Block-a-saurus has been built to be very lightweight. If the dino block is not in use on a particular page or post, no additional Javascript or CSS is added.

= Is there a dark mode? =
Just like the original game, if you advance far enough, the game does turn into night mode, which is an inverted color scheme from traditional gameplay. This will be available as a toggle option in a future version.

= Can editors and authors play the game from within wp-admin? =
Support for playing the game within wp-admin is coming is coming in a future version, but for now, if you preview a post or publish it, you can still play on the front end. If you want only logged in users to be able to play, consider making a private post.

= How are high scores saved? =
Right now, high scores are only saved until you close the tab that you are playing in. In the future, we have planned support for automatically saving user\'s high scores if they are a logged in WordPress user.

== Screenshots ==
1. A view of the Block-a-saurus plugin from within the editor
2. A Block-a-saurus block on the front end before a game has been started
3. A Block-a-saurus game in progress!

== Changelog ==
= 1.0.2 =
* Bumping Tested with version

= 1.0.1 =
* Fixing incompatibility with Jetpack lazy loading images (c88013)
* Security updates to Javascript packages
* Bumping Tested with version

= 1.0 =
* Initial plugin general release

== Upgrade Notice ==
= 1.0.1 =
Fixed Jetpack lazy load issue. If you are using Jetpack, remove and then re-add any Block-a-saurus blocks.