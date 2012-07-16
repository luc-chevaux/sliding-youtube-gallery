jQuery.noConflict();

(function($){
	/**
	 * function applied to selector
	 *
	 * $.fn.calculateNewWidth = function() {
	 * return true;
	 * };
	 */
	
	$.extend({
		
		/**
		 * function to display splash image
		 */
		displayLoad : function () {
			$('#syg-loading td').fadeIn(900,0);
			$('#syg-loading td').html('<img src="../wp-content/plugins/sliding-youtube-gallery/img/ui/bigLoader.gif" />');
		},
	
		/**
		 * function to hide splash image
		 */
		hideLoad : function () {
			$('#syg-loading td').fadeOut('slow');
		},
		
		/**
		 * function to init colorpicker 
		 */
		initColorPicker : function (id, val, defaultColor) {
			jQuery('#' + id + ' div').css('backgroundColor', jQuery(val).val());
			
			jQuery('#' + id).ColorPicker({
				color: defaultColor,
				onShow: function (colpkr) {
					jQuery(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					jQuery(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					jQuery('#' + id + ' div').css('backgroundColor', '#' + hex);
					val.val('#' + hex);
				}
			});
			return true;
		},
	
		/**
		 * function that apply aspect ratio
		 */
		calculateNewWidth : function () {
			var height = $('#syg_thumbnail_height').val();
			var new_width = Math.round(height * 480 / 360);
			$('#syg_thumbnail_width').val(new_width);
			return true;
		},
		
		/**
		 * function that apply aspect ratio
		 */
		calculateNewHeight : function () {
			var width = $('#syg_thumbnail_width').val();
			var new_height = Math.round(width * 360 / 480);
			$('#syg_thumbnail_height').val(new_height);
			return true;
		},
		
		/**
		 * function that delete a gallery (ajax)
		 */
		deleteStyle : function (id) {
			var sure = confirm('Are you sure to delete this style?');
			if (sure) {
				var request = jQuery.ajax({
					  url: 'admin.php',
					  type: 'GET',
					  data: {page: 'syg-manage-styles', id : id, action : 'delete'},
					  dataType: 'html',
					  complete: function () {
						  window.location.reload();
					  }
				});
			}
			return true;
		},
		
		/**
		 * function that delete a gallery (ajax)
		 */
		deleteGallery : function (id) {
			var sure = confirm('Are you sure to delete this gallery?');
			if (sure) {
				var request = jQuery.ajax({
					  url: 'admin.php',
					  type: 'GET',
					  data: {page: 'syg-manage-galleries', id : id, action : 'delete'},
					  dataType: 'html',
					  complete: function () {
						  window.location.reload();
					  }
				});
			}
			return true;
		},
		
		/* 
		 * function that loads the data in the table
		 */ 
		loadData : function (data) {
			var page = $.getQParam('page');
			
			var html;
			$('tr[id^=syg_row_]').remove();
			  
			switch (page) {
				case 'syg-manage-styles':
					var table = 'styles';
					$.hideLoad();
					$.each(data, function(key, val) {
						
						html = '<tr id="syg_row_' + key + '">';
						html = html + '<td>';
						html = html + val.id;
						html = html + '</td>';
						html = html + '<td>';
						html = html + val.styleName;
						html = html + '</td>';
						html = html + '<td>';
						html = html + val.styleDetails;
						html = html + '</td>';
						html = html + '<td>';
						html = html + '<a href="?page=syg-manage-styles&action=edit&id=' + val.id + '">Edit</a> | <a href="#" onclick="javascript: jQuery.deleteStyle(\''+ val.id + '\');">Delete</a>';
						html = html + '</td>';
						html = html + '</tr>';
						$('#galleries_table tr:last-child').after(html);
					});
					
					break;
				case 'syg-manage-galleries':
					var table = 'galleries';
					$.hideLoad();
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
						html = html + '<a href="../wp-content/plugins/sliding-youtube-gallery/views/preview.php?id=' + val.id + '" class="iframe_' + val.id + '">Preview</a> | <a href="?page=syg-manage-galleries&action=edit&id=' + val.id + '">Edit</a> | <a href="#" onclick="javascript: $.deleteGallery(\''+ val.id + '\');">Delete</a>';
						html = html + '</td>';
						html = html + '</tr>';
					
						$('#galleries_table tr:last-child').after(html);
						  
						var dHeight     =  parseInt(val.thumbHeight) + (parseInt(val.boxPadding)*2) ;
						var dWidth     =  parseInt(val.boxWidth) + (parseInt(val.boxPadding)*2) ;
						
						$('.iframe_' + val.id).fancybox({ 
							'padding' : 30,
							'width' : dWidth,
							'height' : dHeight,
							'titlePosition' : 'inside',
							'titleFormat' : function() {
								return '<div id="gallery-title"><h3>' + val.ytUsername + '</h3></div>';
							},
							'centerOnScroll' : true,
							'onComplete': function() {
								$('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
									$('#fancybox-content').height($(this).contents().find('body').height()+30);
								});
							},
							'type' : 'iframe'
						});
					});
					break;
				default:
					break;
					return null;
			}
		},
		  
		/**
		 * function that add pagination event per table
		 */
		addPaginationClickEvent : function (table) {
			// add galleries pagination click event
			$('#syg-pagination-' + table + ' li').click(function(){
				$.displayLoad();
				// css styles
				$('#syg-pagination-' + table + ' li')
					.css({'border' : 'solid #dddddd 1px'})
				  	.css({'color' : '#0063DC'});
	
				$(this)
					.css({'color' : '#FF0084'})
					.css({'border' : 'none'});
	
				// loading data
				var pageNum = this.id;
				$.getJSON('../wp-content/plugins/sliding-youtube-gallery/engine/data/data.php?action=query&table=' + table + '&page_number=' + pageNum, function (data) {$.loadData(data);});
			});
		},
		
		initUi : function () {
			// add the aspect ratio function
			if ($('#syg_thumbnail_width').length) $('#syg_thumbnail_width').change($.calculateNewHeight);
			if ($('#syg_thumbnail_height').length) $('#syg_thumbnail_height').change($.calculateNewWidth);

			// init the color pickers
			$.initColorPicker('thumb_bordercolor_selector', $('#syg_thumbnail_bordercolor'));
			$.initColorPicker('box_backgroundcolor_selector', $('#syg_box_background'), '#efefef');
			$.initColorPicker('desc_fontcolor_selector', $('#syg_description_fontcolor'), '#333333');
		},
		
		getQParam : function (name) {
			name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
			var regexS = "[\\?&]" + name + "=([^&#]*)";
			var regex = new RegExp(regexS);
			var results = regex.exec(window.location.search);
			if(results == null)
				return "";
			else
				return decodeURIComponent(results[1].replace(/\+/g, " "));
			}
		});
})(jQuery);

/************************************************
 # jQuery on ready function:					#
 # load colorpickers and update selected colors # 
 ************************************************/ 

jQuery(document).ready(function($) {
	// determine current url
	var action = $.getQParam('action'); 
	var page = $.getQParam('page');
	var id = $.getQParam('id');
	
	if (action == 'add' || action =='edit') {
		// init the user interface
		$.initUi();
	} else{
		switch (page) {
			case 'syg-manage-styles':
				var table = 'styles';
				break;
			case 'syg-manage-galleries':
				var table = 'galleries';
				break;
			default:
				break;
				return null;
		}
	
		// loading images
		$.displayLoad();
	
		// load if page contains a list
		if (!id){
			// get the data
			$.getJSON('../wp-content/plugins/sliding-youtube-gallery/engine/data/data.php?action=query&table='+ table + '&page_number=1', function (data) {$.loadData(data);});
		}
		
		// add pagination events
		$.addPaginationClickEvent(table);
	}
});