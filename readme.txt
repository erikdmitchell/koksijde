=== MDW Theme ===
Contributors: Erik Mitchell, Miller Designworks
Tags: white, light, responsive-layout, featured-images, custom-menu, theme-options, translation-ready
Requires at least: 3.5
Tested up to: 4.4.2
Stable tag: 4.4.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A theme built on the Bootstrap framework. Designed to be a start theme ontop of which other themes can be built.

== Description ==

A theme built on the Bootstrap framework that can be built on top of, or used as a parent theme.

We recommend you create a child theme of this theme for further customizations as this theme will offer updates periodically.

== Installation ==

1. Upload `mdw-wp-theme` to the `/wp-content/theme/` directory
2. Activate the theme through the 'Themes' (Appearance) menu in WordPress

== Frequently Asked Questions ==

Coming soon...

== Screenshots ==

1. Theme backend image/icon.

== Hooks and Filters ==

Coming soon...

== Changelog ==

= 1.6.0 =

	* Updated Font Awesome to version 4.5.0
	* Added array_recursive_diff() for our legacy theme migration.
	* Cleaned up deprecated.php file.
	* Fixed major glitch in legacy migration. Essentially using POST instead of AJAX

= 1.5.3 =

	* Cleaned up some junk code.
	* Tweaked our gallery slider.
	* Minor structure changes.

= 1.5.2 =

 * Updated Bootstrap to version 3.3.6

= 1.5.1 =

 * Removed legacy.php because it was never being used.

= 1.5.0 =

 * Added legacy.php to handle functions that are removed or names changed.
 * Added deprecated.php for deprecated theme functions.

 * Text domain now "mdw-theme". The old (mdw-wp-theme) was semi redundant.

 * Theme renamed MDW Theme. Again, fixing the WP redundancy.

 * Updated/renamed a lot of functions. See inc/deprecated.php for more details.

= 1.4.4 =

 * Added tag.php, author.php, search.php, content-search.php, attachment.php

 * Removed posts.php

 * Fixed glyphicon font issue (bootstrap).
 * Fixed archive.php and category.php layout.

 * Tweaked content-none.php

= 1.4.3 =

 * Tweaked mobile navigation styling for sub menus (panels).

 * Back to top button is now an svg for better control and styling.

 * Footer now pulls in blog title.

= 1.4.2 =

 * Added jQuery Actual script to determine true height of the slider.
 * Added minor legacy support with Full Page Background classes and functions.

 * Reworked our mobile panel navigation so the entire panel is clickable. Layout and structure was also changed.

= 1.4.1 =

 * Fixed mobile menu duplication glitch when just primary menu is set.

= 1.4.0 =

 * Added secondary navigation menu.

= 1.3.9 =

 * Added "back to top" button.
 * Added mdw_mobile_navigation_setup() to handle control of our mobile menu.
 * Added mobile menu to theme.

 * Disable responsive functionality complete. Enabled/Disabled through Theme Options.

= 1.3.8 =

 * Included respond.js and html5shiv to our theme js folders.

 * Admin init file now uses get_template_part instead of an include.

= 1.3.7 =

 * Fixed add_query_arg() and remove_query_arg() usage due to security issue.

= 1.3.6 =

 * Added disable_responsive(), checked for in mdw_wp_theme_setup
 * Added apply_filters('mdw-wp-theme-slider-classes',$classes)

= 1.3.5 =

 * Renamed filter mdw-bootstrap-slider-image-size to mdw-wp-theme-slider-image-size

 * Added filter mdw-wp-theme-slider-image-width.
 * Added filter mdw-wp-theme-slider-image-height.
 * Added hooks/filter guide to our demo site.

= 1.3.4 =

 * Added filter mdw-bootstrap-slider-image-size to slider.php

 * Pulled out slider styles into components > slider.css

 * Making slider responsive including a height tweak via js

= 1.3.3 =

 * Reworked styling for background slider. We now only load that stylesheet if a bg slider is active.

 * Fixed multiple glitches regarding background slider (rotating and static) images.

 * Added class '' to pages with avia slider active.

= 1.3.2 =

 * Fixed glitch with background slider and theme options.

= 1.3.1 =

 * Minor tweaks to styling and cleaning up plugin.

= 1.3.0 =

 * Added content-none.php
 * Added archive and category page.
 * Added ids to our sidebars

 * Removed Sidebar title from sidebar.php

 * Changed text domain from wpbootstrap to mdw-wp-theme.

= 1.2.9 =

 * Full background slide now hooked into footer.

 * Removed colors and fonts in footer. This theme is designed to be as plain as possible.

= 1.2.8 =

 * Minor tweaks were updated, but not documented, for no real reason.

 * Integration of SASS. The sass folder will contain all of our css files.

 * Rearranged inc folder to separate admin stuff from user side.

 * Added ability for featured image to be background image.

= 1.2.7 =

 * Cleaned up css and js files and folders.

= 1.2.4 =

 * Add "menu flip" if the drop down is headed off the screen.

 * Fixed issues with theme options and logo upload.

 * Reworked a lot of theme for WordPress compatibility via Theme-Check.
 * Tweaked navbar to work better with logo.
 * Wrapped our navbar in a container for better overall look.
 * Home slider is now full width.

= 1.2.3 =

 * Added logo to theme options.
 * Added some more background slider options.

= 1.2.2 =

 * Tweaked some theme options glitches when there are no background images.

 * Removed junk code and place holders.

 * Updated theme options to include a tabbed layout and better organized structure.

 * Fixed full background slider glitch where css was looking at child theme.

= 1.2.1 =

 * Added full background slider.
 * Added theme options.

 * Tweaked functions and files structure for better layout and usage.

= 1.2.0 =

 * Utilized CDN hosted bootstrap css and js files.

 * Renamed several files since our theme name changed to MDW WP Theme.
 * Removed bootstrap folder and migrated everything over into our themes folder(s)

= 1.1.9 =

 * Moved theme-functions.php to functions.php

 * Reworked functions file to latest standards

= 1.1.8 =

 * Added theme updater. We must manually updated all themes to this version to allow auto update.
 * Note: the theme folder must remain "mdw-wp-theme", otherwise the updater will not work.

= 1.1.7 =

 * Added some minor css tweaks to bootstrap-theme.css
 * Added roles to nav walker to comply with WC3 Validation.

= 1.1.6 =

 * Added a function to help make better page titles for SEO stuff.
 * Added wp_bootstrap_widgets_init() to handle our sidebar registration.
 * Added "tags" to our theme style sheet
 * Added drop down menu functionality for small screens to go infinitely deep.

 * Fixed 767 media query. Glitch was cause by iPads a 768.

= 1.1.5 =

 * Added FontAwesome back up.
 * Added wp-bootstrap.js to help with our nav walker on xs screens
 * Added minor styling to bootstrap-theme.css

 * Updated bootstrap_post_thumbnail() to include a specified size
 * Updated bootstrap.css to 3.2.0

= 1.1.4 =

 * Everything is now WordPress compatible and this theme can stand on its own.

 * Fixed and IE8 glitch where respond.js was not working properly (thanks Marshal Oram)

== Upgrade Notice ==

None yet.
