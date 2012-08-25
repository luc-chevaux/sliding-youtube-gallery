=== Plugin Name ===
Contributors: webeng
Donate link: http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/
Tags: youtube, video, gallery, sliding gallery, youtube channel, display video, youtube playlist, videogallery
Requires at least: 2.7 or higher
Tested up to: 3.4
Stable tag: 1.2.5
License: GPLv3

SYG is a nice plugin that gives you a fast way, to add multiple and fully customizable ajax video galleries from different sources in your blog! 

== Description ==
Sliding YouTube Gallery is a nice plugin, that gives you a fast way, to add multiple and fully customizable ajax video galleries, directly in your blog! You can add video from different sources such as user's channel, youtube playlist or by adding video url manually.
You may choose to display the videos in a fully customizable horizontal sliding gallery or if you prefer, you can get displayed as a paginated table-based component.
Users can get the video played as a nice fancybox player.

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

= Where could I have more information about this plugin? =

For more information about this plugin, please visit [webEng blog](http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/ "webEng blog") and post comments, questions and advices in order to make this plugin better.

= How do I display a Sliding YouTube Gallery in a page or post? =

To display a Sliding YouTube Gallery in a page or post, you must use the short code [syg_gallery id=your_gallery_id] .

= How do I display a Sliding YouTube Gallery in a Template? =

To display a Sliding YouTube Gallery within a template you must call the getGallery(array("id" => your_gallery_id)) function.

= How do I display a simple video page in a page or post? =

To display a video page in a page or post, you must use the short code [syg_page id=your_gallery_id] .

= How do I display a simple video page in a Template? =

To display a video page within a template you must call the getVideoPage(array("id" => your_gallery_id)) function.

= How can I override css settings? =

To customize your galleries you can use the plugin administration page. If you need to customize something specific, you can override standard css by adding your css manually and make the single directive !important .

== Screenshots ==

1. Galleries List
2. Gallery Administration
3. Styles List
4. Style Administration
5. Settings Page

== Changelog ==

= 1.3.0 =
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
* Initial Release, beta.
* Video count setting bug, was fixed.

== Upgrade Notice ==

= 1.3.0 =
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
 
- MAIN FEATURES
Support for multiple gallery in one page
Multiple gallery styles
Creation of gallery from a YouTube playlist
Creation of gallery from a explicit YouTube video url list
Disable related videos option
Pagination in video page
New and dedicated plugin menu 

= 1.2.5 =
Fix Missing redirect to plugin homepage after successful savings
Fix blank page in some configuration
Fix gallery position inside post
Fix javascript and css problems in certain template
Fix problem when calling functions in template
Fix path problems with css and js when wordpress is installed on a sub-directory

= 1.0.1 =
Initial Release, beta.
Video count setting bug, was fixed.
