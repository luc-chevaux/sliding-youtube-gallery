jQuery.noConflict();

/*
 * jQuery on ready function:
 * load colorpickers and update selected colors 
 */

jQuery(document).ready(function($) {
  
  updateColorPicker('thumb_bordercolor_selector', $('#syg_thumbnail_bordercolor'));
  updateColorPicker('box_backgroundcolor_selector', $('#syg_box_background'));
  updateColorPicker('desc_fontcolor_selector', $('#syg_description_fontcolor'));
  
  $('#thumb_bordercolor_selector').ColorPicker({
		color: '#333333',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#thumb_bordercolor_selector div').css('backgroundColor', '#' + hex);
			$('#syg_thumbnail_bordercolor').val('#' + hex);
		}
  });
  
  $('#box_backgroundcolor_selector').ColorPicker({
		color: '#efefef',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#box_backgroundcolor_selector div').css('backgroundColor', '#' + hex);
			$('#syg_box_background').val('#' + hex);
		}
  });
  
  $('#desc_fontcolor_selector').ColorPicker({
		color: '#333333',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#desc_fontcolor_selector div').css('backgroundColor', '#' + hex);
			$('#syg_description_fontcolor').val('#' + hex);
		}
});
});

/*
 * function to mantain the aspect ratio 
 * when height has been changed
 */
function calculateNewWidth() {
	var height = jQuery('#syg_thumbnail_height').val();
	var new_width = Math.round(height * 480 / 360);
	jQuery('#syg_thumbnail_width').val(new_width);
	return true;
}

/* function to mantain the aspect ratio 
 * when width has been changed
 */
function calculateNewHeight() {
	var width = jQuery('#syg_thumbnail_width').val();
	var new_height = Math.round(width * 360 / 480);
	jQuery('#syg_thumbnail_height').val(new_height);
	return true;
}

/* function to update colorpicker 
 * background when inserted manually
 */
function updateColorPicker(id, val) {
	jQuery('#' + id + ' div').css('backgroundColor', jQuery(val).val());
	return true;
}

function PreviewGallery (id) {
	
	return true;
}

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