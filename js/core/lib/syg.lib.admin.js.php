jQuery.noConflict();

(function($){
	var methods = {
		/* function to display splash image */
		displayLoad : function () {
			$('#syg-loading td').fadeIn(900,0);
			/* $('#syg-loading td').html('<img src="' + syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/img/ui/bigLoader.gif" />'); */
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
		deleteStyle : function (id, pageNum) {
			var sure = confirm('Are you sure to delete this style?');
			if (sure) {
				var request = jQuery.ajax({
					  url: 'admin.php',
					  type: 'GET',
					  data: {page: 'syg-manage-styles', id : id, action : 'delete'},
					  dataType: 'html',
					  complete: function () {
						  var target_url = window.location.toString();
					  	  target_url = target_url.replace('#', '');
					  	  if (!pageNum) pageNum = 1;
					  	  var new_url = methods.replaceQueryString.call (this, target_url ,'pageNum', pageNum);
						  window.location.replace(target_url);
					  }
				});
			}
			return true;
		},

		/* function that delete a gallery (ajax) */
		deleteGallery : function (id, pageNum) {
			var sure = confirm('Are you sure to delete this gallery?');
			if (sure) {
				var request = jQuery.ajax({
					  url: 'admin.php',
					  type: 'GET',
					  data: {page: 'syg-manage-galleries', id : id, action : 'delete'},
					  dataType: 'html',
					  complete: function () {
						  var target_url = window.location.toString();
						  target_url = target_url.replace('#', '');
					  	  if (!pageNum) pageNum = 1;
					  	  var new_url = methods.replaceQueryString.call (this, target_url ,'pageNum', pageNum);
						  window.location.replace(new_url);
					  }
				});
			}
			return true;
		},
		
		/* function that cache a gallery (ajax) */
		cacheGallery : function (id, pageNum) {
			var sure = confirm('Are you sure to re-cache this gallery?');
			if (sure) {
				var request = jQuery.ajax({
					  url: 'admin.php',
					  type: 'GET',
					  data: {page: 'syg-manage-galleries', id : id, action : 'cache'},
					  dataType: 'html',
					  complete: function () {
					  	  var target_url = window.location.toString();
					  	  target_url = target_url.replace('#', '');
					  	  if (!pageNum) pageNum = 1;
						  var new_url = methods.replaceQueryString.call (this, target_url ,'pageNum', pageNum);
						  window.location.replace(target_url);
					  }
				});
			}
			return true;
		},
		
		/* function that loads exception in the page */
		loadException : function (data) {
			$('.syg_error').remove();
			data = $.parseJSON(JSON.stringify(data));
			var problemFound = data.exception_detail;
			html = '<div class="syg_error"><p><strong>An error was found while updating your style.</strong></p><ul>';
			$.each(problemFound, function(key, val) {
				html = html + '<li>' + val.field + ' - ' + val.msg + '</li>';
			});
			html = html + '</ul></div>';
			$('#syg_status_bar').prepend(html);
		},
		
		/* function that alert exception in the page */
		sygAlert : function (title, message, type) {
			$(".dialog-modal").attr("title", title);
			$(".dialog-modal").empty();
			$(".dialog-modal").prepend(message);
		
			 $(".dialog-modal").dialog({
				modal: true,
				draggable: false,
				resizable: false,
				buttons: {
					Ok: function() {
						$(this).dialog( "close" );
					}
				}
			});
		},
		
		/* function that alert exception in the page */
		alertException : function (data) {
			data = $.parseJSON(JSON.stringify(data));
			var problemFound = data.exception_detail;
			html = '<ul>';
			$.each(problemFound, function(key, val) {
				html = html + '<li><strong>' + val.field + '</strong> - ' + val.msg + '</li>';
			});
			html = html + '</ul>';
			
			$(".dialog-modal").attr("title", "Preview Errors:");
			$(".dialog-modal").empty();
			$(".dialog-modal").prepend(html);
		
			 $(".dialog-modal").dialog({
				modal: true,
				draggable: false,
				resizable: false,
				buttons: {
					Ok: function() {
						$(this).dialog( "close" );
					}
				}
			});
		},
		
		/* function that loads the data in the table */ 
		loadData : function (data, pageNum) {
			data = $.parseJSON(JSON.stringify(data));
			var page = methods.getQParam.call(this, 'page');
			
			var html;
			$('tr[id^=syg_row_]').remove();
			  
			switch (page) {
				case 'syg-manage-styles':
					var table = 'styles';
					methods.hideLoad.call(this);
					if (!jQuery.isEmptyObject(data)) {
						var rowsPrinted = 0;
						$.each(data, function(key, val) {
							if (val.styleDetails == null) {val.styleDetails = '<small><i>(No description)</i></small>';}
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
							html = html + '<a href="?page=syg-manage-styles&action=edit&id=' + val.id + '&pageNum=' + pageNum + '"><img src="' + syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/img/ui/admin/edit.png" title="Edit style" class="syg_table_button" /></a>';
							
							if ($.cookie('syg-role') == 'Administrator' || $.cookie('syg-role') == 'Editor') {
								html = html + '<a href="#" onclick="javascript: jQuery.fn.sygadmin(\'deleteStyle\', \'' + val.id + '\');"><img src="' + syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/img/ui/admin/delete.png" class="syg_table_button" title="Delete style"/></a>';
							}
							
							html = html + '</td>';
							html = html + '</tr>';
							$('#galleries_table tr:last-child').after(html);
							
							rowsPrinted++;
						});
						
						if (rowsPrinted < syg_option.syg_option_numrec) {
							var emptyRowsHtml;
							for (i=rowsPrinted; i < syg_option.syg_option_numrec; i++) {
								emptyRowsHtml = emptyRowsHtml + '<tr id="syg_row_' + i + '"><td colspan="4">&nbsp;</td></tr>';
							}
							$('#galleries_table tr:last-child').after(emptyRowsHtml);
						}
					} else {
						html = html + '<tr>';
						html = html + '<td colspan="4">';
						if (methods.getQParam.call(this, 'pageNum')>0) {
							html = html + 'No styles found in this page';
						} else {
							html = html + 'No styles found in database';
						}
						html = html + '</td>';
						html = html + '</tr>';
						$('#galleries_table tr:last-child').after(html);
					}
					break;
				case 'syg-manage-galleries':
					var table = 'galleries';
					methods.hideLoad.call(this);
					if (!jQuery.isEmptyObject(data)) {
						var rowsPrinted = 0;
						$.each(data, function(key, val) {
							if (val.galleryDetails == null) {val.galleryDetails = '<small><i>(No description)</i></small>';}
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
							html = html + '<a href="?page=syg-manage-galleries&action=edit&id=' + val.id + '&pageNum=' + pageNum + '"><img src="' + syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/img/ui/admin/edit.png" title="Edit gallery" class="syg_table_button"/></a>';
	
							if ($.cookie('syg-role') == 'Administrator' || $.cookie('syg-role') == 'Editor') {
								html = html + '<a href="#" onclick="javascript: jQuery.fn.sygadmin(\'deleteGallery\', \'' + val.id + '\', \'' + pageNum + '\');"><img src="' + syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/img/ui/admin/delete.png" title="Delete gallery" class="syg_table_button"/></a>';
							}
							
							if (val.cacheOn == 1) {
								html = html + '<a href="#" onclick="javascript: jQuery.fn.sygadmin(\'cacheGallery\', \'' + val.id + '\', \'' + pageNum + '\');"><img src="' + syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/img/ui/admin/cache.png" title="Cache gallery" class="syg_table_button"/></a>';
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
							rowsPrinted++;
						});
						
						if (rowsPrinted < syg_option.syg_option_numrec) {
							var emptyRowsHtml;
							for (i=rowsPrinted; i < syg_option.syg_option_numrec; i++) {
								emptyRowsHtml = emptyRowsHtml + '<tr id="syg_row_' + i + '"><td colspan="7">&nbsp;</td></tr>';
							}
							$('#galleries_table tr:last-child').after(emptyRowsHtml);
						}
					} else {
						html = html + '<tr>';
						html = html + '<td colspan="7">';
						if (methods.getQParam.call(this, 'pageNum')>0) {
							html = html + 'No galleries found in this page';
						} else {
							html = html + 'No galleries found in database';
						}
						html = html + '</td>';
						html = html + '</tr>';
						$('#galleries_table tr:last-child').after(html);
					}
					
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
				$.getJSON(syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/engine/data/admin.php?action=query&table=' + table + '&page_number=' + pageNum + '&syg_option_numrec=' + syg_option.syg_option_numrec, function (data) {methods.loadData.call(this, data, pageNum);});
			});
		},
		
		/* function that init style ui */
		initStyleUi : function () {
			// get style form
			var styleForm = $('#syg_style_form');
			
			// add the aspect ratio function
			if ($('#syg_thumbnail_width').length) $('#syg_thumbnail_width').change(function() {methods.calculateNewHeight.call(this)});
			if ($('#syg_thumbnail_height').length) $('#syg_thumbnail_height').change(function() { methods.calculateNewWidth.call(this) });
			
			// init the color pickers
			methods.initColorPicker.call(this, 'thumb_bordercolor_selector', $('#syg_thumbnail_bordercolor'));
			methods.initColorPicker.call(this, 'box_backgroundcolor_selector', $('#syg_box_background'), '#efefef');
			methods.initColorPicker.call(this, 'desc_fontcolor_selector', $('#syg_description_fontcolor'), '#333333');
			
			$('#syg_style_form').submit(function(event) {
				event.preventDefault();
				$.getJSON(syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/engine/data/validate.php?what=style&' + $(this).serialize(), function (data) { 
					if(!jQuery.isEmptyObject(data)) {
						$.fn.sygadmin('loadException', data);
					} else {
						$('#syg_style_form').unbind('submit').submit();
					}
				});
			});
			
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
							
			// set preview action
			$('.iframe_example').fancybox({ 
				'onStart' : function() {
					var formData = styleForm.find(":input:not(:hidden)").serialize();
					
					$.getJSON(syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/engine/data/validate.php?what=style&' + formData, function (data) { 
						if(!jQuery.isEmptyObject(data)) {
							$.fn.sygadmin('alertException', data);
							$.fancybox.close();
						} else {
							url = $('.syg_preview_theme').attr('href');
							var params = formData.toString();
							var params = params.replace(/&/g, "|");

							adjusted_url = url + '&mode=' + $('#syg_component_preview').val() + '&params=' + params;
							$('.syg_preview_theme').attr('href', adjusted_url);
							return true;
						}
					});
				},
				'padding' : 30,
				'width' : parseInt($('#syg_box_width').val()) + (parseInt($('#syg_box_padding').val())*2),
				'height' : parseInt($('#syg_thumbnail_height').val()) + (parseInt($('#syg_box_padding').val())*2),
				'titlePosition' : 'inside',
				'titleFormat' : function() {
					return '<div id="gallery-title"><h3>Demo Gallery</h3></div>';
				},
				'centerOnScroll' : true,
				'onComplete': function() {
					$('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
						$('#fancybox-content').height($(this).contents().find('body').height()+30);
					});
				},
				'type' : 'iframe'
			});
		},
		
		/* function that init gallery ui */
		initGalleryUi : function () {
			$('input[name=syg_gallery_type]').each(function(){
				$(this).click(function () { methods.disableInput.call(this); });
			});
			
			methods.disableInput.call();
			
			$('#syg_gallery_form').submit(function(event) {
				event.preventDefault();
				$.getJSON(syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/engine/data/validate.php?what=gallery&' + $(this).serialize(), function (data) { 
					if(!jQuery.isEmptyObject(data)) {
						$.fn.sygadmin('loadException', data);
					} else {
						$('#syg_gallery_form').unbind('submit').submit();
					}
				});
			});
			
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
		            // disable
		         	$('#syg_option_use_fb2_url').hide();
		         	$('#syg_option_use_fb2_desc').hide();
		        } else {
		        	// enable
		        	$('#syg_option_use_fb2_url').show();
		        	$('#syg_option_use_fb2_desc').show();
		        }
			});
		
			// init the color pickers
			methods.initColorPicker.call(this, 'paginator_bordercolor_selector', $('#syg_option_paginator_bordercolor'));
			methods.initColorPicker.call(this, 'paginator_bgcolor_selector', $('#syg_option_paginator_bgcolor'), '#efefef');
			methods.initColorPicker.call(this, 'paginator_shadowcolor_selector', $('#syg_option_paginator_shadowcolor'), '#333333');
			methods.initColorPicker.call(this, 'paginator_fontcolor_selector', $('#syg_option_paginator_fontcolor'), '#333333');
			
			$('#syg_settings_form').submit(function(event) {
				event.preventDefault();
				$.getJSON(syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/engine/data/validate.php?what=settings&' + $(this).serialize(), function (data) { 
					if(!jQuery.isEmptyObject(data)) {
						$.fn.sygadmin('loadException', data);
					} else {
						$('#syg_settings_form').unbind('submit').submit();
					}
				});
			});
			
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
			var page = methods.getQParam.call(this, 'page');
			if ($.isNumeric(modified) && page == 'syg-manage-styles' && syg_option.syg_option_askcache == '1') {
				var answer = confirm('Your style has been changed. Cached content need to be updated. Update it now?');
				if (answer) {
					var request = jQuery.ajax({
						  url: 'admin.php',
						  type: 'GET',
						  data: {page: 'syg-manage-styles', id : modified, action : 'cache'},
						  dataType: 'html',
						  complete: function () {
							  methods.sygAlert.call(this, 'Information', '<p>Your server cache has been successfully updated.</p>');
						  }
					});
				}
			} else if ($.isNumeric(modified) && page == 'syg-manage-galleries' && syg_option.syg_option_askcache == '1') {
				var answer = confirm('Your gallery has been changed. Cached content need to be updated. Update it now?');
				if (answer) {
					var request = jQuery.ajax({
						  url: 'admin.php',
						  type: 'GET',
						  data: {page: 'syg-manage-galleries', id : modified, action : 'cache'},
						  dataType: 'html',
						  complete: function () {
							  methods.sygAlert.call(this, 'Information', '<p>Your server cache has been successfully updated.</p>');
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
							  methods.sygAlert.call(this, 'Information', '<p>Your server cache has been successfully updated.</p>');
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
		},
		
		replaceQueryString : function (uri, key, value) {
			var re = new RegExp("([?|&])" + key + "=.*?(&|$)", "i");
			separator = uri.indexOf('?') !== -1 ? "&" : "?";
			if (uri.match(re)) {
				return uri.replace(re, '$1' + key + "=" + value + '$2');
			} else {
				return uri + separator + key + "=" + value;
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
	var pageNum = $.fn.sygadmin('getQParam', 'pageNum'); 
	
	$('#loader').ajaxStart(function() {
		  // $('.syg-wrap').fadeOut(700);
		  $(this).fadeIn(500);
	});
	
	$('#loader').ajaxStop(function() {
	      // $('.syg-wrap').fadeIn(700);
		  $(this).fadeOut(500);
	});
	
	switch (page) {
		case 'syg-manage-styles':
			if (action == 'add' || action =='edit') { $.fn.sygadmin('initStyleUi'); }
			// init pagination for styles
			var table = 'styles';
			$.fn.sygadmin('updateCache');
			break;
		case 'syg-manage-galleries':
			if (action == 'add' || action =='edit') { $.fn.sygadmin('initGalleryUi'); }
			// init pagination for galleries
			var table = 'galleries';
			break;
		case 'syg-manage-settings':
			// init settings
			$.fn.sygadmin('initSettingsUi');
			$.fn.sygadmin('updateCache');
			return true;
		case 'syg-contacts':
			return true;
		default:
			return false;
	}

	// loading images
	$.fn.sygadmin('displayLoad');

	// load if page contains a list
	if (!id){
		// get the data
		if (!pageNum) {
			var pageNum = 1;
		}
		$.getJSON(syg_option.syg_option_plugin_url + '/sliding-youtube-gallery/engine/data/admin.php?action=query&table='+ table + '&page_number=' + pageNum + '&syg_option_numrec=' + syg_option.syg_option_numrec, function (data) {$.fn.sygadmin('loadData', data, pageNum);});
	}
	
	// add pagination events
	$.fn.sygadmin('addPaginationClickEvent', table);
});