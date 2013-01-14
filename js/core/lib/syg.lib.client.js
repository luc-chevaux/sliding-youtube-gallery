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
		displayLoad : function (gid) {
			$('table[class^=video_entry_table-' + gid +']').remove();
			$('#syg_video_container-' + gid).css('height', '100px');
			$('#syg_video_container-' + gid + ' #hook').fadeIn(900,0);			
		},
	
		/**
		 * function to hide splash image
		 */
		hideLoad : function (gid) {
			$('#syg_video_container-' + gid + ' #hook').fadeOut('fast');
			$('#syg_video_container-' + gid ).css('height', 'auto');
		},
		
		/* 
		 * function that loads the data in the table
		 */ 
		loadData : function (data, gid, options) {
			data = $.parseJSON(JSON.stringify(data));
			var html;
			
			$('table[class^=video_entry_table-]').remove();
			
			$.hideLoad(gid);
			$.each(data, function(key, val) {
				
				html = '<table class="video_entry_table-' + gid + '">';
				html = html + '<tr>';
				
				html = html + '<td class="syg_video_page_thumb-' + gid + '">';
				html = html + '<a class="sygVideo" href="' + options['plugin_root'] + 'views/player.php?id=' + gid + '&video=' + val.video_id + '">';
				if (options['description_show']) {
					html = html + '<img src="' + val.video_thumbshot + '" class="thumbnail-image-' + gid + '" alt="' + val.video_description + '" title="' + val.video_description + '"/>';
				} else {
					html = html + '<img src="' + val.video_thumbshot + '" class="thumbnail-image-' + gid + '" alt="play" title="play"/>';
				}
				
				 
				thumbImage = options['thumbnail_image'];
				if (!thumbImage) {
					overlayButtonSrc = options['img_root'] + '/button/play-the-video_' + thumbImage + '.png';
				} else {
					overlayButtonSrc = options['img_root'] + '/button/play-the-video_1.png';
				}				
				
				html = html + '<img class="play-icon-' + gid + '" src="' + overlayButtonSrc + '" alt="play">';
				
				if (options['description_showduration']) {
					html = html + '<span class="video_duration-' + gid + '">' + val.video_duration + '</span>';
				}
				html = html + '</a>';
				html = html + '</td>';
				
				html = html + '<td class="syg_video_page_description">';
				html = html + '<h4 class="video_title-' + gid + '"><a href="' + val.video_watch_page_url + '" target="_blank">' + val.video_title + '</a></h4>';
				if (options['description_show']) {
					html = html + '<p>' + val.video_description + '</p>';
				}
					
				if (options['description_showcategories']) {
					html = html + '<span class="video_categories"><i>Category:</i>&nbsp;&nbsp; ' + val.video_category + '</span>';
				}
				
				if (options['description_showtags']) {
					html = html + '<span class="video_tags"><i>Tags:</i>&nbsp;&nbsp;';
					tags = val.video_tags;
					for(var i in tags) {
    					html = html + tags[i] + ' | '; 
					}
					html = html + '</span>';
				}
				
				if (options['description_showratings']) {
						rating = val.video_ratings;
						if (rating) {
							html = html + '<span class="video_ratings">';
							html = html + '<i>Average:</i>&nbsp;&nbsp;' + rating['average'];
							html = html + '&nbsp;&nbsp;';
							html = html + '<i>Raters:</i>&nbsp;&nbsp;' + rating['numraters'];
							html = html + '</span>';
						} else {
							html = html + '<span class="video_ratings">';
							html = html + '<i>Rating not available</i>';
							html = html + '</span>';
						}
				}
				html = html + '</td>';
				html = html + '</tr>';
				html = html + '</table>';
				
				$('#syg_video_container-' + gid + ' #hook').after(html);
			});
			
			// add fancybox
			$.addFancyBoxSupport(gid, options);
		},
		  
		/**
		 * function that add pagination event per table
		 */
		addPaginationClickEvent : function (gid, options) {
			// add galleries pagination click event
			
			/* top pagination */
			$('#pagination-top-' + gid + ' li').click(function(){
				
				$.displayLoad(gid);
				// css styles
				$('#pagination-top-' + gid + ' li')
					.attr({'class' : 'other_page'});
				$('#pagination-bottom-' + gid + ' li')
				.attr({'class' : 'other_page'});
				
				var buttonPressed = $(this).attr('id');
				var button =  buttonPressed.replace('top-','');
				
				$('#top-' + button).attr({'class' : 'current_page'});
				$('#bottom-' + button).attr({'class' : 'current_page'});
				
				// loading data
				var pageNum = button;
				
				if (options['cache'] == 'on') {
					$.getJSON(options['jsonUrl'] + pageNum + '.json', function (data) {$.loadData(data, gid, options);});
				} else {
					$.getJSON(options['json_query_if_url'] + '?query=videos&page_number=' + pageNum + '&id=' + gid, function (data) {$.loadData(data, gid, options);});
				}				
			});
			
			/* bottom pagination */
			$('#pagination-bottom-' + gid + ' li').click(function(){
				
				$.displayLoad(gid);
				// css styles
				$('#pagination-bottom-' + gid + ' li')
					.attr({'class' : 'other_page'});
				$('#pagination-top-' + gid + ' li')
				.attr({'class' : 'other_page'});
				
				var buttonPressed = $(this).attr('id');
				var button =  buttonPressed.replace('bottom-','');
				
				$('#bottom-' + button).attr({'class' : 'current_page'});
				$('#top-' + button).attr({'class' : 'current_page'});
				
				// loading data
				var pageNum = button;
				
				if (options['cache'] == 'on') {
					$.getJSON(options['jsonUrl'] + pageNum + '.json', function (data) {$.loadData(data, gid, options);});
				} else {
					$.getJSON(options['json_query_if_url'] + '?query=videos&page_number=' + pageNum + '&id=' + gid, function (data) {$.loadData(data, gid, options);});
				}
			});
		},
		
		/**
		 * function that add pagination event per table
		 */
		addFancyBoxSupport : function (gid, options) {
			// add fancybox to each sygVideo css class
			/*$(".sygVideo").fancybox({
				'width' : options['width'],
				'height' : options['height'],
				'autoScale' : true,
				'transitionIn' : 'none',  
				'transitionOut' : 'none',
				'type' : 'iframe',
				'hideOnOverlayClick' : false,
				'autoDimensions' : false,
				'padding' : 0
			});*/
			
			$(".sygVideo").click(function() {
				$.fancybox({
					'padding' : 0,
					'autoScale' : false,
					'transitionIn' : 'none',
					'transitionOut'	: 'none',
					'title' : this.title,
					'width'	: options['width'],
					'height' : options['height'],
					'href' : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
					'type' : 'swf',
					'swf' : {
						'wmode'	: 'transparent',
						'allowfullscreen' : 'true'
					}
			});

				return false;
			});
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