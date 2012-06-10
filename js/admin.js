jQuery.noConflict();

/**
 * function that apply aspect ratio
 */
function calculateNewWidth() {
	var height = jQuery('#syg_thumbnail_height').val();
	var new_width = Math.round(height * 480 / 360);
	jQuery('#syg_thumbnail_width').val(new_width);
	return true;
}

/**
 * function that apply aspect ratio
 */
function calculateNewHeight() {
	var width = jQuery('#syg_thumbnail_width').val();
	var new_height = Math.round(width * 360 / 480);
	jQuery('#syg_thumbnail_height').val(new_height);
	return true;
}

/**
 * function to init colorpicker 
 */
function initColorPicker(id, val, defaultColor) {
	jQuery('#' + id + ' div').css('backgroundColor', jQuery(val).val());
	
	jQuery('#' + id).ColorPicker({
		color: defaultColor,
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#' + id + ' div').css('backgroundColor', '#' + hex);
			val.val('#' + hex);
		}
	});
	return true;
}

/**
 * function that preview a gallery (ajax)
 */
function PreviewGallery (id) {
	return true;
}

/**
 * function that delete a gallery (ajax)
 */
function DeleteGallery (id) {
	var sure = confirm('Are you sure to delete this gallery?');
	if (sure) {
		var request = jQuery.ajax({
			  url: 'options-general.php',
			  type: 'GET',
			  data: {page: 'syg-administration-panel', id : id, action : "delete"},
			  dataType: 'html',
			  complete: function () {
				  window.location.reload();
			  }
		});
	}
	return true;
}

/**
 * function to display splash image
 */
function displayLoad() {
	jQuery('#syg-loading td').fadeIn(900,0);
	jQuery('#syg-loading td').html('<img src="../wp-content/plugins/sliding-youtube-gallery/img/ui/bigLoader.gif" />');
}

/**
 * function to hide splash image
 */
function hideLoad() {
	jQuery("#syg-loading td").fadeOut('slow');
}

/*
 * jQuery on ready function:
 * load colorpickers and update selected colors 
 */

jQuery(document).ready(function($) {	
  // init the color pickers
  initColorPicker('thumb_bordercolor_selector', $('#syg_thumbnail_bordercolor'));
  initColorPicker('box_backgroundcolor_selector', $('#syg_box_background'), '#efefef');
  initColorPicker('desc_fontcolor_selector', $('#syg_description_fontcolor'), '#333333');	

  // set default css for first element
  $("#syg-pagination li:first").css({'color' : '#FF0084'}).css({'border' : 'none'});
  
  // loading images
  displayLoad();
  
  // load data
  $.getJSON('../wp-content/plugins/sliding-youtube-gallery/engine/data/data.php?action=query&page_number=1', function(data){
	  var html;
	  $("tr[id^=syg_row_]").remove();
	  
	  $.each(data, function(key, val) {
		  html = '<tr id="syg_row_' + key + '">';
		  html = html + '<td>';
		  html = html + val.id;
		  html = html + '</td>';
		  html = html + '<td>';
		  html = html + '<img src="' + val.thumbUrl + '" class="user_pic"></img>';
		  html = html + '</td>';
		  html = html + '<td>';
		  html = html + val.ytUsername;
		  html = html + '</td>';
		  html = html + '<td>';
		  html = html + 'User Channel';
		  html = html + '</td>';
		  html = html + '<td>';
		  html = html + '<a href="../wp-content/plugins/sliding-youtube-gallery/views/preview.php?id=' + val.id + '" class="iframe_' + val.id + '">Preview</a> | <a href="?page=syg-administration-panel&action=edit&id=' + val.id + '">Edit</a> | <a href="#" onclick="javascript: DeleteGallery(\''+ val.id + '\');">Delete</a>';
		  html = html + '</td>';
		  html = html + '</tr>';
		  
		  $('#galleries_table tr:last-child').after(html);
		  
		  var dHeight     =  parseInt(val.thumbHeight);
		  var dWidth     =  parseInt(val.boxWidth) + (parseInt(val.boxPadding)*2) ;
		  
		  $(".iframe_" + val.id).fancybox({ 
			  'padding' : 30,
			  'width' : dWidth,
			  'centerOnScroll' : true,
			  'onComplete': function () { $.fancybox.resize(); },
			  'type' : 'iframe'
		  });
	  });
	  
	  hideLoad();
  });
  
  // pagination click event
  $("#syg-pagination li").click(function(){
	  displayLoad();

	  // css styles
	  $("#syg-pagination li")
	  	.css({'border' : 'solid #dddddd 1px'})
	  	.css({'color' : '#0063DC'});

	  $(this)
	  	.css({'color' : '#FF0084'})
	  	.css({'border' : 'none'});

	  // loading data
	  var pageNum = this.id;
	  $.getJSON('../wp-content/plugins/sliding-youtube-gallery/engine/data/data.php?action=query&page_number=' + pageNum, function(data) {
		  var html;
		  
		  $("tr[id^=syg_row_]").remove();
		  
		  $.each(data, function(key, val) {
			  html = '<tr id="syg_row_' + key + '">';
			  html = html + '<td>';
			  html = html + val.id;
			  html = html + '</td>';
			  html = html + '<td>';
			  html = html + '<img src="' + val.thumbUrl + '" class="user_pic"></img>';
			  html = html + '</td>';
			  html = html + '<td>';
			  html = html + val.ytUsername;
			  html = html + '</td>';
			  html = html + '<td>';
			  html = html + 'User Channel';
			  html = html + '</td>';
			  html = html + '<td>';
			  html = html + '<a href="../wp-content/plugins/sliding-youtube-gallery/views/preview.php?id=' + val.id + '" class="iframe">Preview</a> | <a href="?page=syg-administration-panel&action=edit&id=' + val.id + '">Edit</a> | <a href="#" onclick="javascript: DeleteGallery(\''+ val.id + '\');">Delete</a>';
			  html = html + '</td>';
			  html = html + '</tr>';
			  $('#galleries_table tr:last-child').after(html);
		  });
		  
		  hideLoad();
	  });
  });
});