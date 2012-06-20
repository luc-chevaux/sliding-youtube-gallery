=== Plugin Name ===
Contributors: webeng
Donate link: http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/
Tags: youtube, video, gallery, sliding gallery, youtube channel, display video
Requires at least: 2.7 or higher
Tested up to: 3.3.1
Stable tag: 1.0.1
License: GPLv3

Sliding YouTube Gallery is a nice plugin, that gives you a fast way, to add video galleries in your blog directly from a youtube user's channel!

== Description ==
Sliding YouTube Gallery is a nice plugin, that gives you a fast way, to add video galleries in your blog directly from a youtube user's channel!
You can choose to display the videos in a fully customizable sliding gallery or if you prefer, you may display it as an ordered list table.
Users can get the video played as a nice fancybox player.

== Installation ==
- Using the WordPress dashboard
	- Login to your wordpress blog
	- Navigate trough to Plugins
	- Click on Add New button
	- Search for Sliding YouTube Gallery
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

To display a Sliding YouTube Gallery in a page or post, you must use the short code [syg_gallery id=<your_gallery_id>] .

= How do I display a Sliding YouTube Gallery in a Template? =

To display a Sliding YouTube Gallery within a template you must call the getGallery(array("id" => <your_gallery_id>)) function.

= How do I display a simple video page in a page or post? =

To display a video page in a page or post, you must use the short code [syg_page id=<your_gallery_id>] .

= How do I display a simple video page in a Template? =

To display a video page within a template you must call the getVideoPage(array("id" => <your_gallery_id>)) function.

= How can I override css settings? =

To customize your galleries you can use the plugin administration page. If you need to customize something specific, you can override standard css by adding your css manually.

= Can I display something else than simply user’s channel? =

Not at the moment. Future versions of this plugin will give more ways to integrate your blog with YouTube datas. Stay tuned!

== Screenshots ==

1. Administration page
2. Sliding YouTube Gallery
3. Sliding YouTube Gallery video page

== Changelog ==

= 1.2.0 =
* Multiple youtube user
* Multiple gallery styles
* Gallery loader
* Preview mode in gallery list
* oO compliant plugin

= 1.0.1 =
* Video count setting bug, was fixed.

= 1.0.0.beta =
* Initial Release, beta.

== Upgrade Notice ==

= 1.0.1 =
Video count setting bug, was fixed.

= 1.0.0.beta =
Initial Release, beta.
