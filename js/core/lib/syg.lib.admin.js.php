jQuery.noConflict();

(function($){
	var methods = {
		/* function to display splash image */
		displayLoad : function () {
			$('#syg-loading td').fadeIn(900,0);
			$('#syg-loading td').html('<img src="' + syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/img/ui/bigLoader.gif" />');
		},
		
		/* function to hide splash image */
		hideLoad : function () {
			$('#syg-loading td').fadeOut('slow');
		},
		
		/* function to init colorpicker */
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
		
		/* function that apply aspect ratio */
		calculateNewWidth : function () {
			var height = $('#syg_thumbnail_height').val();
			var new_width = Math.round(height * 480 / 360);
			$('#syg_thumbnail_width').val(new_width);
			return true;
		},
		
		/* function that apply aspect ratio */
		calculateNewHeight : function () {
			var width = $('#syg_thumbnail_width').val();
			var new_height = Math.round(width * 360 / 480);
			$('#syg_thumbnail_height').val(new_height);
			return true;
		},
		
		/* function that delete a gallery (ajax) */
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
		
		/* function that delete a gallery (ajax) */
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
		
		/* function that cache a gallery (ajax) */
		cacheGallery : function (id) {
			var sure = confirm('Are you sure to re-cache this gallery?');
			if (sure) {
				var request = jQuery.ajax({
					  url: 'admin.php',
					  type: 'GET',
					  data: {page: 'syg-manage-galleries', id : id, action : 'cache'},
					  dataType: 'html',
					  complete: function () {
						  window.location.reload();
					  }
				});
			}
			return true;
		},
		
		loadingOn : function () {
			$('#loader').fadeIn(300);
		},
		
		loadingOff : function () {
		    $('#loader').fadeOut(300);
		},

		loadingToggle : function () {
		    $('#loader').fadeToggle(300);
		},
		
		/* function that loads the data in the table */ 
		loadData : function (data) {
			data = $.parseJSON(JSON.stringify(data));
			var page = methods.getQParam.call(this, 'page');
			
			var html;
			$('tr[id^=syg_row_]').remove();
			  
			switch (page) {
				case 'syg-manage-styles':
					var table = 'styles';
					methods.hideLoad.call(this);
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
						html = html + '<a href="?page=syg-manage-styles&action=edit&id=' + val.id + '"><img src="' + syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/img/ui/admin/edit.png" title="Edit style" class="syg_table_button" /></a>';
						
						if ($.cookie('syg-role') == 'Administrator' || $.cookie('syg-role') == 'Editor') {
							html = html + '<a href="#" onclick="javascript: jQuery.fn.sygadmin(\'deleteStyle\', \'' + val.id + '\');"><img src="' + syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/img/ui/admin/delete.png" class="syg_table_button" title="Delete style"/></a>';
						}
						
						html = html + '</td>';
						html = html + '</tr>';
						$('#galleries_table tr:last-child').after(html);
					});
					
					break;
				case 'syg-manage-galleries':
					var table = 'galleries';
					methods.hideLoad.call(this);
					$.each(data, function(key, val) {
						html = '<tr id="syg_row_' + key + '">';
						html = html + '<td>';
						html = html + val.id;
						html = html + '</td>';
						html = html + '<td>';
						html = html + '<img src="' + val.thumbUrl + '" class="user_pic"></img>';
						html = html + '</td>';
						html = html + '<td>';
						html = html + val.galleryName;
						html = html + '</td>';
						html = html + '<td>';
						html = html + val.galleryDetails;
						html = html + '</td>';
						html = html + '<td>';
						html = html + val.galleryType;
						html = html + '</td>';
						
						html = html + '<td class="' + val.cacheExists + '">';
						if (val.cacheOn == 1) {
							html = html + val.cacheExists;
						}
						html = html + '</td>';
						html = html + '<td>';
						html = html + '<a href="' + syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/views/admin/Preview.php?id=' + val.id + '" class="iframe_' + val.id + '"><img src="' + syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/img/ui/admin/preview.png" title="Preview gallery" class="syg_table_button"/></a>';
						html = html + '<a href="?page=syg-manage-galleries&action=edit&id=' + val.id + '"><img src="' + syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/img/ui/admin/edit.png" title="Edit gallery" class="syg_table_button"/></a>';

						if ($.cookie('syg-role') == 'Administrator' || $.cookie('syg-role') == 'Editor') {
							html = html + '<a href="#" onclick="javascript: jQuery.fn.sygadmin(\'deleteGallery\', \'' + val.id + '\');"><img src="' + syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/img/ui/admin/delete.png" title="Delete gallery" class="syg_table_button"/></a>';
						}
						
						if (val.cacheOn == 1) {
							html = html + '<a href="#" onclick="javascript: jQuery.fn.sygadmin(\'cacheGallery\', \'' + val.id + '\');"><img src="' + syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/img/ui/admin/cache.png" title="Cache gallery" class="syg_table_button"/></a>';
						}
						
						html = html + '</td>';
						html = html + '</tr>';
					
						$('#galleries_table tr:last-child').after(html);
						  
						var dHeight = parseInt(val.sygStyle.thumbHeight) + (parseInt(val.sygStyle.boxPadding)*2) ;
						var dWidth = parseInt(val.sygStyle.boxWidth) + (parseInt(val.sygStyle.boxPadding)*2) ;
						
						// set preview action
						$('.iframe_' + val.id).fancybox({ 
							'padding' : 30,
							'width' : dWidth,
							'height' : dHeight,
							'titlePosition' : 'inside',
							'titleFormat' : function() {
								return '<div id="gallery-title"><h3>' + val.galleryName + '</h3></div>';
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
			
			$('.syg_table_button').balloon({ 
				tipSize: 20, 
				css: {
					minWidth       : "20px",
					maxWidth	   : "350px",
					padding        : "10px",
					borderRadius   : "6px",
					border         : "solid 1px #777",
					boxShadow      : "0 8px 10px -10px black",
					color          : "#666",
					backgroundColor: "white",
					opacity        : 1,
					zIndex         : "32767",
					textAlign      : "left"
				}});
				
			$('.syg_page_submit').balloon({
				position: "top", 
				tipSize: 20, 
				css: {
					minWidth       : "20px",
					maxWidth	   : "350px",
					padding        : "10px",
					borderRadius   : "6px",
					border         : "solid 1px #777",
					boxShadow      : "0 8px 10px -10px black",
					color          : "#666",
					backgroundColor: "white",
					opacity        : 1,
					zIndex         : "32767",
					textAlign      : "left"
				}});
		},
		
		/* function that add pagination event per table */
		addPaginationClickEvent : function (table) {
			// add galleries pagination click event
			$('#syg-pagination-' + table + ' li').click(function(){
				methods.displayLoad.call(this);
				// css styles
				$('#syg-pagination-' + table + ' li')
					.attr({'class' : 'other_page'});
	
				$(this)
					.attr({'class' : 'current_page'});
	
				// loading data
				var pageNum = this.id;
				$.getJSON(syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/engine/data/admin.php?action=query&table=' + table + '&page_number=' + pageNum + '&syg_option_numrec=' + syg_option.syg_option_numrec, function (data) {methods.loadData.call(this, data);});
			});
		},
		
		/* function that init style ui */
		initStyleUi : function () {
			// add the aspect ratio function
			if ($('#syg_thumbnail_width').length) $('#syg_thumbnail_width').change($.calculateNewHeight);
			if ($('#syg_thumbnail_height').length) $('#syg_thumbnail_height').change($.calculateNewWidth);
			
			// init the color pickers
			methods.initColorPicker.call(this, 'thumb_bordercolor_selector', $('#syg_thumbnail_bordercolor'));
			methods.initColorPicker.call(this, 'box_backgroundcolor_selector', $('#syg_box_background'), '#efefef');
			methods.initColorPicker.call(this, 'desc_fontcolor_selector', $('#syg_description_fontcolor'), '#333333');
			
			$('.syg_page_submit').balloon({ 
				position: "top",
				tipSize: 20, 
				css: {
					minWidth       : "20px",
					maxWidth	   : "350px",
					padding        : "10px",
					borderRadius   : "6px",
					border         : "solid 1px #777",
					boxShadow      : "0 8px 10px -10px black",
					color          : "#666",
					backgroundColor: "white",
					opacity        : 1,
					zIndex         : "32767",
					textAlign      : "left"
				}});
		},
		
		/* function that init gallery ui */
		initGalleryUi : function () {
			$('input[name=syg_gallery_type]').each(function(){
				$(this).click(function () { methods.disableInput.call() });
			});
			
			methods.disableInput.call();
			
			$('.syg_help').balloon({ 
				tipSize: 20, 
				css: {
					minWidth       : "20px",
					maxWidth	   : "350px",
					padding        : "10px",
					borderRadius   : "6px",
					border         : "solid 1px #777",
					boxShadow      : "0 8px 10px -10px black",
					color          : "#666",
					backgroundColor: "white",
					opacity        : 1,
					zIndex         : "32767",
					textAlign      : "left"
				}});
			
			$('.syg_page_submit').balloon({ 
				position: "top",
				tipSize: 20, 
				css: {
					minWidth       : "20px",
					maxWidth	   : "350px",
					padding        : "10px",
					borderRadius   : "6px",
					border         : "solid 1px #777",
					boxShadow      : "0 8px 10px -10px black",
					color          : "#666",
					backgroundColor: "white",
					opacity        : 1,
					zIndex         : "32767",
					textAlign      : "left"
				}});
		},
		
		/* function that init settings ui */
		initSettingsUi: function () {
			// add event to fancybox2 inclusion button
			
			$('#syg_option_use_fb2').click(function () {				
				if ($('#syg_option_use_fb2_url').is(":visible")) {
		            // disabilita
		         	$('#syg_option_use_fb2_url').hide();
		         	$('#syg_option_use_fb2_desc').hide();
		        } else {
		        	// abilita
		        	$('#syg_option_use_fb2_url').show();
		        	$('#syg_option_use_fb2_desc').show();
		        }
			});
		
			// init the color pickers
			methods.initColorPicker.call(this, 'paginator_bordercolor_selector', $('#syg_option_paginator_bordercolor'));
			methods.initColorPicker.call(this, 'paginator_bgcolor_selector', $('#syg_option_paginator_bgcolor'), '#efefef');
			methods.initColorPicker.call(this, 'paginator_shadowcolor_selector', $('#syg_option_paginator_shadowcolor'), '#333333');
			methods.initColorPicker.call(this, 'paginator_fontcolor_selector', $('#syg_option_paginator_fontcolor'), '#333333');
			
			$('.syg_page_submit').balloon({ 
				position: "top",
				tipSize: 20, 
				css: {
					minWidth       : "20px",
					maxWidth	   : "350px",
					padding        : "10px",
					borderRadius   : "6px",
					border         : "solid 1px #777",
					boxShadow      : "0 8px 10px -10px black",
					color          : "#666",
					backgroundColor: "white",
					opacity        : 1,
					zIndex         : "32767",
					textAlign      : "left"
				}});
				
				$('.syg_help').balloon({ 
				tipSize: 20, 
				css: {
					minWidth       : "20px",
					maxWidth	   : "350px",
					padding        : "10px",
					borderRadius   : "6px",
					border         : "solid 1px #777",
					boxShadow      : "0 8px 10px -10px black",
					color          : "#666",
					backgroundColor: "white",
					opacity        : 1,
					zIndex         : "32767",
					textAlign      : "left"
				}});
		},
		
		/* function that update cache */
		updateCache: function () {
			var modified = methods.getQParam.call(this, 'modified');
			if ($.isNumeric(modified) && syg_option.syg_option_askcache == '1') {
				var answer = confirm('Your style has been changed. Cached content need to be updated. Update it now?');
				if (answer) {
					var request = jQuery.ajax({
						  url: 'admin.php',
						  type: 'GET',
						  data: {page: 'syg-manage-styles', id : modified, action : 'cache'},
						  dataType: 'html',
						  complete: function () {
							  alert ('Your server cache has been successfully updated.');
						  }
					});
				}
			} else if (modified == 'true' && syg_option.syg_option_askcache == '1') {
				var answer = confirm('Your settings has been updated. Cached content need to be updated. Update it now?');
				if (answer) {
					var request = jQuery.ajax({
						  url: 'admin.php',
						  type: 'GET',
						  data: {page: 'syg-manage-settings', action : 'cache'},
						  dataType: 'html',
						  complete: function () {
							  alert ('Your server cache has been successfully updated.');
						  }
					});
				}
			}
		},
		
		/* function that disable input */
		disableInput: function () {
		    var value = $('input[name=syg_gallery_type]:checked').val();
		    switch (value) {
		    	case 'feed':
		    		// enable and set visible feed
		    		$('#syg_youtube_username_panel').css({opacity: 0.0, visibility: "visible"}).animate({opacity: 1.0}).css('height','auto');
		    		$('#syg_youtube_username').removeAttr('disabled','disabled');
		    		
		    		// set list disabled and hidden
		    		$('#syg_youtube_list_panel').css({opacity: 1.0, visibility: "hidden"}).animate({opacity: 0.0}).css('height','0');
		    		$('#syg_youtube_videolist').attr('disabled','disabled');
		    		
		    		// set playlist disabled and hidden
		    		$('#syg_youtube_playlist_panel').css({opacity: 1.0, visibility: "hidden"}).animate({opacity: 0.0}).css('height','0');
		    		$('#syg_youtube_playlist').attr('disabled','disabled');
		    		
		    		break;
		    	case 'list':
		    		// set feed disabled and hidden
		    		$('#syg_youtube_username_panel').css({opacity: 1.0, visibility: "hidden"}).animate({opacity: 0.0}).css('height','0');
		    		$('#syg_youtube_username').attr('disabled','disabled');
		    		
		    		// enable and set visible list
		    		$('#syg_youtube_list_panel').css({opacity: 0.0, visibility: "visible"}).animate({opacity: 1.0}).css('height','auto');
		    		$('#syg_youtube_videolist').removeAttr('disabled','disabled');
		    		
		    		// set playlist disabled and hidden
		    		$('#syg_youtube_playlist_panel').css({opacity: 1.0, visibility: "hidden"}).animate({opacity: 0.0}).css('height','0');
		    		$('#syg_youtube_playlist').attr('disabled','disabled');
		    		
		    		break;
		    	case 'playlist':
			    	// set feed disabled and hidden
		    		$('#syg_youtube_username_panel').css({opacity: 1.0, visibility: "hidden"}).animate({opacity: 0.0}).css('height','0');
		    		$('#syg_youtube_username').attr('disabled','disabled');
		    		
		    		// set list disabled and hidden
		    		$('#syg_youtube_list_panel').css({opacity: 1.0, visibility: "hidden"}).animate({opacity: 0.0}).css('height','0');
		    		$('#syg_youtube_videolist').attr('disabled','disabled');
		    		
		    		// set playlist disabled and hidden
		    		$('#syg_youtube_playlist_panel').css({opacity: 0.0, visibility: "visible"}).animate({opacity: 1.0}).css('height','auto');
		    		$('#syg_youtube_playlist').removeAttr('disabled','disabled');
		    		
		    		break;
		    	default:
		    		break;
		    }
		},
		
		/* function that get parameter value */
		getQParam : function (name) {
			name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
			var regexS = "[\\?&]" + name + "=([^&#]*)";
			var regex = new RegExp(regexS);
			var results = regex.exec(window.location.search);
			if(results == null) {
				return "";
			} else {
				return decodeURIComponent(results[1].replace(/\+/g, " "));
			}
		}
	};
	
	$.fn.sygadmin = function( method ) {
    	// Method calling logic
    	if (methods[method]) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    	} else {
    		$.error( 'Method ' +  method + ' does not exist on jQuery.sygadmin' );
		}
    };
})(jQuery);

/************************************************
 # jQuery onready and onload function:			#
 # load colorpickers and update selected colors # 
 ************************************************/ 

jQuery(document).ready(function($) {
	// determine current url
	var action = $.fn.sygadmin('getQParam', 'action'); 
	var page = $.fn.sygadmin('getQParam', 'page');
	var id = $.fn.sygadmin('getQParam', 'id');
	
	$('#loader').ajaxStart(function() {
		  $(this).fadeIn(300);
	});
	
	$('#loader').ajaxStop(function() {
		  $(this).fadeOut(300);
	});
	
	// if we're doing some action init ui component
	if (action == 'add' || action =='edit') {
		if (page == 'syg-manage-galleries') {
			// init the user interface
			$.fn.sygadmin('initGalleryUi');
		} else if (page == 'syg-manage-styles') {
			// init the user interface
			$.fn.sygadmin('initStyleUi');
		}
	} else{
		switch (page) {
			case 'syg-manage-styles':
				// init pagination for styles
				var table = 'styles';
				$.fn.sygadmin('updateCache');
				break;
			case 'syg-manage-galleries':
				// init pagination for galleries
				var table = 'galleries';
				break;
			case 'syg-manage-settings':
				// init settings
				$.fn.sygadmin('initSettingsUi');
				$.fn.sygadmin('updateCache');
				return true;
			default:
				return false;
		}
	
		// loading images
		$.fn.sygadmin('displayLoad');
	
		// load if page contains a list
		if (!id){
			// get the data
			$.getJSON(syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/engine/data/admin.php?action=query&table='+ table + '&page_number=1&syg_option_numrec=' + syg_option.syg_option_numrec, function (data) {$.fn.sygadmin('loadData', data);});
		}
		
		// add pagination events
		$.fn.sygadmin('addPaginationClickEvent', table);
	}
});