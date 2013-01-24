<!-- Php Inclusion -->

<!-- Extra Php Code -->

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/it_IT/all.js#xfbml=1&appId=163842223712966";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Css Inclusion -->
<style type="text/css">
@import url('<?php echo $this->data['cssAdminUrl']; ?>');
</style>

<!-- Title Page -->
<div class="wrap">
	<?php require_once 'inc/header.inc.php'; ?>
	<div id="syg-plugin-area">
		
		<!-- User Message -->
		<?php include 'inc/statusBar.inc.php'; ?>
	
		<table width="100%">
			<tr>
				<td style="vertical-align: top;">
					<img src="http://s-plugins.wordpress.org/sliding-youtube-gallery/assets/banner-772x250.png" class="splashpage" style="border: 1px #333 solid; box-shadow: 0 0 8px #888;"/>
					<table cellspacing="10" style="box-shadow: 0 0 8px #888; margin-top: 15px;">
						<tr valign="top">
							<td width="278">
								<h3>Project philosophy</h3>
								<p>SYG is a nice plugin that gives you a fast way, to add multiple and fully customizable ajax video galleries from different sources in your blog!</p>
								<p>You can add video from different sources such as user's channel, youtube playlist or by adding video url manually.</p><p>You may choose to display the videos in a fully customizable horizontal sliding gallery or if you prefer, you can get displayed as a paginated table-based component.</p><p>From version 1.4.0 you can display your gallery with a nice 3d cloud carousel. Users can get the video played as a nice fancybox player.</p>
								<table>
									<tr style="vertical-align: top;">
										<td><img style="width: 100px; float: left;" src="<?php echo WP_PLUGIN_URL . SygConstant::WP_IMG_PATH . 'ui/admin/opensource-logo.png'; ?>"></img></td>
										<td><i>If programmers deserve to be rewarded for creating innovative programs, by the same token they deserve to be punished if they restrict the use of these programs.</i><br/> (Richard Stallman)</td>
									</tr>
								</table>
							</td>
							<td width="250">
								<h3>What you can do?</h3>
								<ul class="">
									<li>If you like the plugin, please consider donating with paypal. Your help is much appreciated especially in these hard times.</li>
									<li>Do you report a problem with this plugin? Please, submit your issue to my <a href="http://mantis.webeng.it">bug database</a>.</li>
									<li>If you want to propose me something, please consider to post your idea on <a href="http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/">my blog</a>.</li>
									<li>If you have a blog, please write an article on this plugin.</li>
									<li>If you miss something, please feel free to request features over <a href="http://blog.webeng.it/how-to/cms/wordpress/sliding-youtube-gallery-wordpress-plugin/">my blog</a>. Each good idea will be considered.</li>
									<li>Are you a developer? Join the plugin development process. Contact me over my networks.</li>
									<li>A good rating is the best motivation to continue develop and mantain this project, I ask you to leave your rating in the <a href="http://wordpress.org/extend/plugins/sliding-youtube-gallery/">wordpress plugin page</a>.</li>
								</ul>
							</td>
							<td width="200">
								<h3>Project roadmap</h3>
								<ul>
									<li>Widget support (ver 1.5.0)</li>
									<li>Seo Video Gallery (ver 2.0.0)</li>
									<li>Category Video (ver 2.0.0)</li>
								</ul>
								<h3>Help & Support</h3>
								<p>If you have problems during the update, please read UPGRADE NOTICE @ Sliding YouTube Gallery support forum.</p>
								<h3>Special thanks</h3>
								<p>This plugin were also released thanks to this free and open source library. Thanks to all the authors.<br/>
								<a href="https://github.com/Emerson/Sanity-Wordpress-Plugin-Framework">Sanity framework</a> | <a href="http://www.eyecon.ro/colorpicker/">Eyecon colorpicker</a> | <a href="http://www.professorcloud.com/mainsite/carousel.htm">3d Cloud Carousel</a> | <a href="http://fancybox.net/">Fancybox</a></p>
							</td>
						</tr>
					</table>
				</td>
				<td style="vertical-align: top; float: right; vertical-align: top;">
					<div style="background-color: #cccccc; border: 1px #333 solid; padding: 10px; margin-bottom: 15px; border-radius: 10px; width: 350px; box-shadow: 0 0 8px #888;">
						<h4>Quick resources</h4>
						<ul>
							<li><a href="">Project homepage</a></li>
							<li><a href="http://wordpress.org/extend/plugins/sliding-youtube-gallery/">Plugin homepage</a></li>
							<li><a href="">Bug database</a></li>
							<li><a href="">Support forum</a></li>
						</ul>
					</div>
					<div style="background-color: #cccccc; border: 1px #333 solid; padding: 10px; margin-bottom: 15px; border-radius: 10px; width: 350px; box-shadow: 0 0 8px #888;">
						<h4>If you like, please donate.</h4>
						<p>This helps me to mantain and develop the plugin well. I don't become rich and you don't become poor. This plugin is gratis, free and open source.</p>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="FRXA5225YQMUU">
						<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
						<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
						</form>
					</div>
					<div style="background-color: #cccccc; border: 1px #333 solid; padding: 10px; margin-bottom: 15px; border-radius: 10px; width: 350px; box-shadow: 0 0 8px #888;">
						<h4>Social activities</h4>
						<p>Please socialize this plugin by clicking on your favourite social network. More people means more features.</p>
						<div class="fb-like" data-href="http://wordpress.org/extend/plugins/sliding-youtube-gallery/" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-font="verdana" data-colorscheme="dark"></div>
					
						<br/>	
						<!-- Inserisci questo tag nel punto in cui vuoi che sia visualizzato l'elemento pulsante +1. -->
						<div class="g-plusone" data-href="http://wordpress.org/extend/plugins/sliding-youtube-gallery/"></div>
						
						<!-- Inserisci questo tag dopo l'ultimo tag di pulsante +1. -->
						<script type="text/javascript">
						  window.___gcfg = {lang: 'en-GB'};
						
						  (function() {
						    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
						    po.src = 'https://apis.google.com/js/plusone.js';
						    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
						  })();
						</script>
						<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://wordpress.org/extend/plugins/sliding-youtube-gallery/" data-text="Sliding YouTube Gallery">Tweet</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
						<a href="http://it.linkedin.com/in/lucamartini1980">
						<img src="http://www.linkedin.com/img/webpromo/btn_viewmy_160x33_it_IT.png?locale=" width="160" height="33" border="0" alt="Visualizza il profilo di Luca Martini su LinkedIn">
						</a>
						<br/>
						<!-- Facebook Badge START --><a href="http://www.facebook.com/webeng.it" target="_TOP" style="font-family: &quot;lucida grande&quot;,tahoma,verdana,arial,sans-serif; font-size: 11px; font-variant: normal; font-style: normal; font-weight: normal; color: #3B5998; text-decoration: none;" title="WebEng WebEng">WebEng WebEng</a><span style="font-family: &quot;lucida grande&quot;,tahoma,verdana,arial,sans-serif; font-size: 11px; line-height: 16px; font-variant: normal; font-style: normal; font-weight: normal; color: #555555; text-decoration: none;">&nbsp;|&nbsp;</span><a href="http://www.facebook.com/badges/" target="_TOP" style="font-family: &quot;lucida grande&quot;,tahoma,verdana,arial,sans-serif; font-size: 11px; font-variant: normal; font-style: normal; font-weight: normal; color: #3B5998; text-decoration: none;" title="Crea il tuo badge!">Crea il tuo badge</a><br/><a href="http://www.facebook.com/webeng.it" target="_TOP" title="WebEng WebEng"><img src="http://badge.facebook.com/badge/100001946264903.494.976246179.png" style="border: 0px;" /></a><!-- Facebook Badge END -->
					</div>
				</td>
			</tr>
		</table>
		<?php require_once 'inc/contextMenu.inc.php'; ?>
	</div>
</div>
