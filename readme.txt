=== Plugin Name ===
Contributors: webeng
Donate link: http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/
Tags: youtube, video, gallery, sliding gallery, youtube channel, display video, youtube playlist, videogallery
Requires at least: 2.7 or higher
Tested up to: 3.5.1
Stable tag: 1.5.1
License: GPLv3

SYG is a nice plugin that gives you a fast way, to add multiple and fully customizable ajax video galleries from different sources in your blog! 

== Description ==
Sliding YouTube Gallery is a nice plugin, that gives you a fast way, to add multiple and fully customizable ajax video galleries, directly in your blog! You can add video from different sources such as user's channel, youtube playlist or by adding video url manually.
You may choose to display the videos in a fully customizable horizontal sliding gallery or if you prefer, you can get displayed as a paginated table-based component.
Users can get the video played as a nice fancybox player. If you have problems during the update, please read UPGRADE NOTICE @ [Sliding YouTube Gallery support forum](http://wordpress.org/support/plugin/sliding-youtube-gallery "Sliding YouTube Gallery support forum").  

= Sliding YouTube Gallery demo =
[Sliding Gallery Demo](http://blog.webeng.it/how-to/cms/wordpress/sliding-video-gallery-demo/ "Sliding Gallery Demo")

[Video Page Demo](http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-video-page-demo/ "Video Page Demo")

[3d Cloud Carousel Demo](http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-3d-cloud-carousel-demo/ "3d Cloud Carousel Demo")

[Elastislide Demo](http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-elastislide-demo/ "Elastislide Demo (Experimental)")

== Installation ==
- Using the WordPress dashboard
	- Login to your wordpress blog
	- Navigate trough to Plugins
	- Click on Add New button
	- Search for YouTube Gallery
	- Click on Install Button
	- Activate the plugin
- Manual installation
	- Download and extract the archive
	- Upload extracted folder to the /wp-content/plugins/ directory
	- Activate the plugin through the ‘Plugins’ menu in wordpress

== Frequently Asked Questions ==

= Components does not work or your admin area is broken, what should you do? =

It could be a bug or not. To ensure yourself that you discover a bug, before contacting me, please use a developer console (firebug, chrome, explorer, firefox console etc..) and look if you have javascript errors that could be related to this plugin. Sometimes, other third party plugin or simply your custom theme could cause general plugin malfunction. Before contacting me, please do a little investigation on your console and fix eventually javascript errors.

= Where do I find support forum? =

You could find more information about bugs and issues at [Sliding YouTube Gallery support forum](http://wordpress.org/support/plugin/sliding-youtube-gallery "Sliding YouTube Gallery support forum"). 

= Where could I have more information about this plugin? =

For more information about this plugin, please visit [webEng blog](http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/ "webEng blog") and post comments, questions and advices in order to make this plugin better.

= How do I setup youtube sources? =

If you want to display user's channel feed, you have to insert only the username. If you want to display a YouTube playlist, you have to specify the full playlist url. If you want to specify manually a video list, you must insert videos url separated by a new line.

= How do I display a Sliding YouTube Gallery in a page or post? =

To display a Sliding YouTube Gallery in a page or post, you must use the short code [syg_gallery id=your_gallery_id] .

= How do I display a Sliding YouTube Gallery in a Template? =

To display a Sliding YouTube Gallery within a template you must call the getGallery function, for example `<?php echo getGallery(array('id' => 1)); ?>`.

= How do I display a simple video page in a page or post? =

To display a video page in a page or post, you must use the short code [syg_page id=your_gallery_id] .

= How do I display a simple video page in a Template? =

To display a video page within a template you must use the getPage function, for example `<?php echo getPage(array('id' => 1)); ?>`.

= How do I display a 3d carousel in a page or post? =

To display a 3d carousel in a page or post, you must use the short code [syg_carousel id=your_gallery_id] .

= How do I display a 3d carousel in a Template? =

To display a 3d carousel within a template you must use the getCarousel function, for example `<?php echo getCarousel(array('id' => 1)); ?>`.

= How do I display an Elastislide in a page or post? =

To display an Elastislide in a page or post, you must use the short code [syg_elastislide id=your_gallery_id] .

= How do I display an Elastislide in a Template? =

To display an Elastislide within a template you must use the getElastislide function, for example `<?php echo getElastislide(array('id' => 1)); ?>`.

= How can I override css settings? =

Sometimes, some theme could override gallery css settings making your component rendered bad. To customize your galleries you have to use the theme administration page, but if something goes wrong, you can try to fix possible css errors by looking in firebug console for selectors that has been overridden from your theme css. If so, or if you need to customize something specific, you can do using in your css attribute the !important directive.

== Screenshots ==

1. Galleries List
2. Gallery Administration
3. Styles List
4. Style Administration
5. Settings Page

== Changelog ==

= 1.5.1 =
* Fixed bug Cannot redeclare class Mobile_Detect

= 1.5.0 =
* Fixed IE bug
* Rebuild cache optimized to use wp-cron
* Added more video embed option
* Added theme preview
* Ajax validation (form not resetting anymore)
* Fixed some minor bugs
* Added Elastislide component (experimental and not fully customizable at the moment)

= 1.4.4 =
* Fixed minor bugs with mobile browser
* Mobile browser supported (tested with android)
* A fews modification to enforce the plugin structure and license policies
* Resolves minor bugfix
* Enforce themes compatibility
* Fixed fancybox version when registering the script (in some themes that redistribute fancybox this may be an issue)
* Fixed headers already sent when embedding
* Fixed unexpected T_FUNCTION bug on php < 5.3
* Scheduled cache rebuild
* Wordpress best pratices fixes
* Enable/Disable cache alerts option
* Performance improvements
* New 3d Cloud Carousel Component
* Performance improvement with content caching and minified javascript
* Multiple galleries in one page better support
* User and roles compliant
* General interface improvements
* YouTube thumbnail quality selector
* Security update

= 1.3.6 =
* Gallery and video validation
* Style validation
* Admin alerts and notices
* User alerts
* Support for multiple gallery in one page
* Multiple gallery styles
* Creation of gallery from a YouTube playlist
* Creation of gallery from a explicit YouTube video url list
* Disable related videos option
* Pagination in video page
* New and dedicated plugin menu

= 1.2.5 =
* Multiple youtube user
* Multiple gallery styles
* Gallery loader
* Preview mode in gallery list
* oO compliant plugin
* Some Bugs was fixed. A very special thanks to Adriana.
* Fixed missing redirect after saving a gallery
* Fixed blank page in some configuration
* Fixed gallery position inside post
* Fixed javascript and css problems in certain template
* Fixed problem when calling functions in template
* Fixed path problems with css and js when wordpress is installed on a sub-directory

= 1.0.1 =
* Initial Release, beta.*
* Video count setting bug, was fixed.

== Upgrade Notice ==

= 1.5.1 =
- Fixed bug Cannot redeclare class Mobile_Detect

= 1.5.0 =
- Fixed IE bug
- Rebuild cache optimized to use wp-cron
- Added more video embed option
- Added theme preview
- Ajax validation (form not resetting anymore)
- Fixed some minor bugs
- Added Elastislide component (experimental and not fully customizable at the moment)

= 1.4.4 =
- Fixed minor bugs with mobile browser
- Mobile browser supported (tested with android)
- A fews modification to enforce the plugin structure and license policies
- Resolves minor bugfix
- Enforce themes compatibility
- Fixed fancybox version when registering the script (in some themes that redistribute fancybox this may be an issue)
- Fixed unexpected T_FUNCTION bug on php < 5.3
- Fixed headers already sent when embedding
- Scheduled cache rebuild
- Wordpress best pratices fixes
- Enable/Disable cache alerts option
- Performance improvements
- New 3d Cloud Carousel Component
- Performance improvement with content caching and minified javascript
- Multiple galleries in one page better support
- User and roles compliant
- Added new carousel 3d component
- General interface improvements
- YouTube thumbnail quality selector
- Security fixes

= 1.3.6 =
- Gallery and video validation
- Style validation
- Admin alerts and notices
- User alerts 
- For problems during update please see UPGRADE TROUBLESHOOTING
- UPGRADE TROUBLESHOOTING
If you experience some problem in the update please let me know. You can however restore the old version (1.2.5) as the following :
- Deactivate the plugin if active
- Delete sliding-youtube-gallery in wp-content/plugins
- Log on into your mysql database with phpmyadmin
- Delete wp_syg, wp_syg_styles (wp_ is assumed as generic wordpress table prefix)
- Click on wp_syg_OLD_V12X (wp_ is assumed as generic wordpress table prefix)
- Go to operation menu and rename table wp_syg_OLD_V12X to wp_syg (wp_ is assumed as generic wordpress table prefix)
- Execute the query: DELETE FROM `wp_options` WHERE `option_name` like '%syg%'
- Execute the query: INSERT INTO `wp_options` (`option_name`, `option_value`, `autoload`) VALUES ('syg_db_version', '1.3.0', 'yes')
- Manually download previous version of the plugin and extract into wp-content/plugins
- Reactivate the plugin

= 1.2.5 =
- Fix Missing redirect to plugin homepage after successful savings
- Fix blank page in some configuration
- Fix gallery position inside post
- Fix javascript and css problems in certain template
- Fix problem when calling functions in template
- Fix path problems with css and js when wordpress is installed on a sub-directory

= 1.0.1 =
- Initial Release, beta.
- Video count setting bug, was fixed.
