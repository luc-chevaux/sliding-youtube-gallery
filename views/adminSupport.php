<!-- Php Inclusion -->

<!-- Extra Php Code -->

<!-- User Message -->
<?php include 'inc/statusBar.inc.php'; ?>

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
		<table>
			<tr>
				<td><img src="http://s-plugins.wordpress.org/sliding-youtube-gallery/assets/banner-772x250.png" height="150" style="border: 1px #333 solid;"/></td>
				<td>
					<div style="background-color: #cccccc; border: 1px #333 solid; padding: 10px; height: 130px;">
						<b>Quick resources</b>
						<ul>
							<li><a href="">Project homepage</a></li>
							<li><a href="http://wordpress.org/extend/plugins/sliding-youtube-gallery/">Plugin homepage</a></li>
							<li><a href="">Bug database</a></li>
							<li><a href="">Support forum</a></li>
						</ul>
					</div>
				</td>
				<td>
				<div style="background-color: #cccccc; border: 1px #333 solid; padding: 10px; height: 130px;">
					<b>Buy me a beer!</b>
					<p>Buy me a beer. Please consider to donate with paypal!</p>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="FRXA5225YQMUU">
					<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
					<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
					</form>
				</div>
				</td>
				<td>
					<div style="background-color: #cccccc; border: 1px #333 solid; padding: 10px; height: 130px;">
						<b>Social activities</b>
						<p>Please recomend this plugin over your social network.</p>
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
									<br/>	
				
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://wordpress.org/extend/plugins/sliding-youtube-gallery/" data-text="Sliding YouTube Gallery">Tweet</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</div>
				</td>
			</tr>
		</table>
		<h3>Project philosophy</h3>
		<p>Sliding YouTube Gallery is a plugin that allows you to generate custom web components basing on your youtube videos.</p>
		<h3>What you can do?</h3>
		<ul class="">
			<li>Buy me a beer. Please consider to donate with paypal!</li>
			<li>Submit a problem to our bug database</li>
			<li>Submit your idea on our blog</li>
			<li>Write an article on this plugin</li>
			<li>Submit a support request</li>
		</ul>
		
		<h3>Features request</h3>
		
		<h3>Join the plugin as developer</h3>
		<p>If you're a WP or PHP developer</strong> and you like the plugin idea, if you have some time you can contribute to this plugin! Sometimes two developer is better than one, right?</p>
				
		<h3>Project roadmap</h3>
		<hr/>
		<p class="webengText">Thank you for downloading! Enjoy WP and OpenSource!</p>
		<p class="webengText">Luca</p>
		
		<?php require_once 'inc/contextMenu.inc.php'; ?>
	</div>
</div>
