jQuery.noConflict();

(function($){
	var methods = {
		/* function to display splash image */
		displayLoad : function (gid) {
			$('table[class^=video_entry_table-' + gid +']').remove();
			$('#syg_video_container-' + gid).css('height', '100px');
			$('#syg_video_container-' + gid + ' #hook').fadeIn(900,0);			
		},
		
		/* function to hide splash image */
		hideLoad : function (gid) {
			$('#syg_video_container-' + gid + ' #hook').fadeOut('fast');
			$('#syg_video_container-' + gid ).css('height', 'auto');
		},
		
		/* word truncation function */
		wordTruncate : function (str, limit) {
			var bits, i; 
			if ("string" !== typeof str) { 
				return ''; 
			} 
			bits = str.split(''); 
			if (bits.length > limit) { 
				for (i = bits.length - 1; i > -1; --i) { 
					if (i > limit) { bits.length = i; } else if (' ' === bits[i]) { bits.length = i; break; } 
				} 
				bits.push('...'); 
			} 
			return bits.join(''); 
		},

        /* escape html like htmlspecialchars */
        escapeHtml: function (text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        },

		/* function that loads the data in the table */ 
		loadData : function (data, gid, options) {
			data = $.parseJSON(JSON.stringify(data));
			var html;
			
			$('table[class^=video_entry_table-' + gid + ']').remove();
			
			methods.hideLoad.call(this, gid);
			$.each(data, function(key, val) {
				
				html = '<table class="video_entry_table-' + gid + '">';
				html = html + '<tr>';
				
				html = html + '<td class="syg_video_page_thumb-' + gid + '">';
				html = html + '<a class="sygVideo-' + gid + '" href="http://www.youtube.com/watch?v=' + val.video_id + '" title="'+ methods.escapeHtml.call(this, val.video_title) +'">';
				if (options['description_show']) {
					html = html + '<img src="' + val.video_thumbshot + '" class="thumbnail-image-' + gid + '" alt="' + methods.escapeHtml.call(this, val.video_description) + '" title="' + methods.escapeHtml.call(this, val.video_description) + '"/>';
				} else {
					html = html + '<img src="' + val.video_thumbshot + '" class="thumbnail-image-' + gid + '" alt="play" title="play"/>';
				}
				
				if (val.video_cached == false) {
					thumbImage = options['thumbnail_image'];
					if ($.isNumeric(thumbImage)) {
						overlayButtonSrc = options['img_root'] + '/button/play-the-video_' + thumbImage + '.png';
					} else {
						overlayButtonSrc = options['img_root'] + '/button/play-the-video_1.png';
					}
					html = html + '<img class="play-icon-' + gid + '" src="' + overlayButtonSrc + '" alt="play">';
				}
				
				if (options['description_showduration']) {
					html = html + '<span class="video_duration-' + gid + '">' + val.video_duration + '</span>';
				}
				html = html + '</a>';
				html = html + '</td>';
				
				html = html + '<td class="syg_video_page_description">';
				html = html + '<h4 class="video_title-' + gid + '"><a href="' + val.video_watch_page_url + '" target="_blank">' + methods.escapeHtml.call(this, val.video_title) + '</a></h4>';
				
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
				
				if (options['description_showtags']) {
					html = html + '<span class="video_tags"><i>Tags:</i>&nbsp;';
					var taglist = val.video_tags;
					tags = String(taglist).split('|');
					for(var i in tags) {
    					html = html + tags[i] + ' | '; 
					}
					html = html + '</span>';
				}
				
				if (options['description_showcategories']) {
					html = html + '<span class="video_categories"><i>Category:</i>&nbsp;' + val.video_category + '</span>';
				}
				
				if (options['description_show']) {
					html = html + '<p class="textual_video_description">' + methods.escapeHtml.call(this, methods.wordTruncate.call(this, val.video_description, options['description_length'])) + '</p>';
				}
				
				html = html + '</td>';
				html = html + '</tr>';
				html = html + '</table>';
				
				$('#syg_video_container-' + gid + ' #hook').after(html);
			});
			
			// add fancybox
			methods.addFancyBoxSupport.call(this, gid, options);
		},

        shadeColor : function (color, percent) {
            var num = parseInt(color.slice(1),16),
                amt = Math.round(2.55 * percent),
                R = (num >> 16) + amt,
                B = (num >> 8 & 0x00FF) + amt,
                G = (num & 0x0000FF) + amt;
                return "#" + (0x1000000 + (R<255?R<1?0:R:255)*0x10000 + (B<255?B<1?0:B:255)*0x100 + (G<255?G<1?0:G:255)).toString(16).slice(1);
        },

		/* function that add pagination event per table */
		addPaginationClickEvent : function (gid, options) {
			// add galleries pagination click event
			
			/* top pagination */
			$('#pagination-top-' + gid + ' li').click(function(){
				methods.displayLoad.call(this, gid);
				
				// css styles
				$('#pagination-top-' + gid + ' li').attr({'class' : 'other_page'});
				$('#pagination-bottom-' + gid + ' li').attr({'class' : 'other_page'});
				
				var buttonPressed = $(this).attr('id');
				var button =  buttonPressed.replace('top-','');
				
				$('#top-' + button).attr({'class' : 'current_page'});
				$('#bottom-' + button).attr({'class' : 'current_page'});
				
				// loading data
				var pageNum = button;
				
				if (options['cache'] == 'on') {
                    $('#syg_video_page-' + gid).animate({ "opacity": "0.25" }, "fast");
					$.getJSON(options['jsonUrl'] + pageNum + '.json', function (data) {methods.loadData.call(this, data, gid, options); $('#syg_video_page-' + gid).animate({ "opacity": "1" }, "fast");});
				} else {
                    $('#syg_video_page-' + gid).animate({ "opacity": "0.25" }, "fast");
					$.getJSON(options['json_query_if_url'] + '?query=videos&page_number=' + pageNum + '&id=' + gid + '&syg_option_which_thumb=' + syg_option.syg_option_which_thumb + '&syg_option_pagenumrec=' + syg_option.syg_option_pagenumrec, function (data) {methods.loadData.call(this, data, gid, options); $('#syg_video_page-' + gid).animate({ "opacity": "1" }, "fast");});
				}				
			});
			
			/* bottom pagination */
			$('#pagination-bottom-' + gid + ' li').click(function(){
				methods.displayLoad.call(this, gid);
				
				// css styles
				$('#pagination-bottom-' + gid + ' li').attr({'class' : 'other_page'});
				$('#pagination-top-' + gid + ' li').attr({'class' : 'other_page'});
				
				var buttonPressed = $(this).attr('id');
				var button =  buttonPressed.replace('bottom-','');
				
				$('#bottom-' + button).attr({'class' : 'current_page'});
				$('#top-' + button).attr({'class' : 'current_page'});
				
				// loading data
				var pageNum = button;
				
				if (options['cache'] == 'on') {
					$.getJSON(options['jsonUrl'] + pageNum + '.json', function (data) {methods.loadData.call(this, data, gid, options);});
				} else {
					$.getJSON(options['json_query_if_url'] + '?query=videos&page_number=' + pageNum + '&id=' + gid + '&syg_option_which_thumb=' + syg_option.syg_option_which_thumb + '&syg_option_pagenumrec=' + syg_option.syg_option_pagenumrec, function (data) {methods.loadData.call(this, data, gid, options);});
				}
			});
		},
		
		/* function that add pagination event per table */
		addFancyBoxSupport : function (gid, options) {
			if (syg_option.syg_option_use_fb2 == '1') {
				// add fancybox to each sygVideo css class
				$(".sygVideo-" + gid).click(function() {
					$.fancybox({
						'padding' : 0,
						'beforeShow' : function(){
	  						$(".fancybox-skin").css("backgroundColor","black");
	 					},
						'transitionIn' : 'none',
						'transitionOut'	: 'none',
						'title' : this.title,
						'width'	: options['video_width'],
						'height' : options['video_height'],
						'href' : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
						'fitToView' : true,
						'type' : 'swf',
						'swf' : {
							'wmode'	: 'transparent',
							'allowfullscreen' : 'true',
							'allowscriptaccess' : 'always'
						}
					});
					return false;
				});
			} else {
				$(".sygVideo-" + gid).click(function() {
					var rez = this.href.match(/(youtube\.com|youtu\.be)\/(watch\?v=|v\/|u\/|embed\/?)?(videoseries\?list=(.*)|[\w-]{11}|\?listType=(.*)&list=(.*)).*/i);
					$.fancybox({
						'padding' : 0,
						'autoScale' : false,
						'transitionIn' : 'none',
						'transitionOut'	: 'none',
						'title' : this.title,
						'width'	: options['width'],
						'height' : options['height'],
						'href'   : 'http://www.youtube.com/embed/' + rez[3] + syg_option.syg_option_fancybox_url_suffix,
						'fitToView' : true,
						'type' : 'iframe'
					});
					return false;
				});
			}
		},
		
		isAndroid: function() {
			return navigator.userAgent.match(/Android/i);
		},
		
		isBlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		
		isIOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		
		isOpera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		
		isWindows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		
		isMobileBrowser: function() {
			return (methods.isAndroid.call(this) || methods.isBlackBerry.call(this) || methods.isIOS.call(this) || methods.isOpera.call(this) || methods.isWindows.call(this));
		},
		
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
	
	$.fn.sygclient = function( method ) {
        $.cssHooks.backgroundColor = {
            get: function(elem) {
                if (elem.currentStyle)
                    var bg = elem.currentStyle["backgroundColor"];
                else if (window.getComputedStyle)
                    var bg = document.defaultView.getComputedStyle(elem,null).getPropertyValue("background-color");

                if (bg.search("rgb") == -1) {
                    return bg;
                } else {
                    bg = bg.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
                    function hex(x) {
                        return ("0" + parseInt(x).toString(16)).slice(-2);
                    }
                    return "#" + hex(bg[1]) + hex(bg[2]) + hex(bg[3]);
                }
            }
        }

    	// Method calling logic
    	if (methods[method]) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    	} else {
    		$.error( 'Method ' +  method + ' does not exist on jQuery.sygclient' );
		}
    };
})(jQuery);