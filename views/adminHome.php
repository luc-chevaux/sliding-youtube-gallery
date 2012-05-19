<?php if ($this->data['updated']) {?>
	<div class="updated"><p><strong>Settings saved.</strong></p></div>
<?php } ?>

<!-- css inclusion -->
<style type="text/css">
@import url('<?php echo $this->data['cssAdminUrl'] ?>');
</style>
<style type="text/css">
@import url('<?php echo $this->data['cssColorPicker'] ?>');
</style>
		
<div class="wrap">
	<div id="icon-options-general" class="icon32">
	<br/>
</div>
<h2 class="webengTitle">Sliding Youtube Gallery :: <a href="http://blog.webeng.it" target="_new" class="webengRed noDecoration">webEng</a></h2>
<hr/>
<p class="webengText">
	SygConstant::BE_WELCOME_MESSAGE;
</p>
SygConstant::BE_SUPPORT_PAGE.' | '.SygConstant::BE_DONATION_CODE;
<h3>Manage your gallery</h3>
<table cellspacing="0" id="galleries_table">
	<tr>
		<th class="id">
			<span>ID</span>
		</th>
		<th class="user_pic">
			<span>Avatar</span>
		</th>
		<th class="user">
			<span>Details</span>
		</th>
		<th class="type">
			<span>Type</span>
		</th>
		<th class="action">
			<span>Action</span>
		</th>
	</tr>
	foreach ($galleries as $gallery) {
	<tr>
		<td>
			echo $gallery->id;
		</td>
		<td>
			$user = $this->sygYouTube->getUserProfile($gallery->syg_youtube_username);
			<img src="'.$user->getThumbnail()->getUrl().'" class="user_pic"></img>';
		</td>
		<td>
			$gallery->syg_youtube_username;
		</td>
		<td>
			User Channel
		</td>
		<td>
			<a href="#" onclick="javascript: Preview('.$gallery->id.');">Preview</a> | <a href="?page=syg-administration-panel&id='.$gallery->id.'">Edit</a> | <a href="#" onclick="javascript: Delete('.$gallery->id.');">Delete</a>
		</td>
	</tr>
	}
	
	<tr>
		<th class="id">
			<span>ID</span>
		</th>
		<th class="user_pic">
			<span>Avatar</span>
		</th>
		<th class="user">
			<span>Details</span>
		</th>
		<th class="type">
			<span>Type</span>
		</th>
		<th class="action">
			<span>Action</span>
		</th>
	</tr>
</table>		
<br/>
<input type="submit" id="Submit" name="Submit" class="button-primary" value="Add new Gallery"/>
<h3>General Settings</h3>
<p>Here you can set the SlidingYoutubeGallery default behavior.</p>
<form name="form1" method="post" action="">
	<fieldset>
		<legend><strong>YouTube settings</strong></legend>
	
	</fieldset>
</form>