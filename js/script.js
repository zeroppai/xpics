xvideos = {
  
	/*
   * Tools
   */
	tools: {
		getUrlHash: function() {
			var sharppos = window.location.href.lastIndexOf("#");
			if(sharppos < 0)
				return false;
			return window.location.href.substr(sharppos+1);
		},
		setUrlHash: function(hash) {
			var url = window.location.href;
			var sharppos = url.lastIndexOf("#");
			if(sharppos < 0)
				url += "#" + hash;
			else
				url = window.location.href.substring(0, sharppos+1) + hash;
			window.location.href = url;
		},
		getFuncByName: function(name, context) {
			if(!context)
				context = window;
			var namespaces = name.split(".");
			var func = namespaces.pop();
			for(var i = 0; i < namespaces.length; i++) {
				context = context[namespaces[i]];
				if(!context)
					return null;
			}
			return $.isFunction(context[func]) ? context[func] : null;
		},
		encloseTextWithTag: function(text, tagname) {
			if(typeof(text) == "string" && (text.length == 0 || text[0] != "<"))
				return "<" + tagname + ">" + text + "</" + tagname + ">";
			return text;
		},
		preLoadPicture: function(url, pic) {
			var heavyImage = new Image();
			heavyImage.src = url + pic + ".jpg";
		},
		getInlineLoader: function(text, centered) {
			var loader = '';
			if(centered)
				loader += '<div style="text-align: center;">';
			loader += '<span class="inlineLoader"><span class="text">'+text+'</span><img src="http://static.xvideos.com/v2/img/xv-inline-ajax-loader.gif" /></span>';
			if(centered)
				loader += '</div>';
			return loader;
		},
		// Note that subject is used to position the message and must be in contener
		appendAjaxOverlay: function(contener, content, is_loader, closable, subject) {
			// Create message box
			var contentnode = $(document.createElement('span')).addClass('text').html(content);
			if(is_loader) {
				contentnode.append($(document.createElement('img')).addClass('loader').prop('src', 'http://static.xvideos.com/v2/img/xv-inline-ajax-loader.gif'));
			}
			var msgnode = $(document.createElement('div')).addClass('message').append(contentnode);
			if(closable) {
				msgnode.prepend($(document.createElement('div')).addClass('closeBox').text('x').click(xvideos.tools.closeAjaxOverlay));
			}
			var loader = $(document.createElement('div')).addClass('ajaxOverlay').append(msgnode);
			// Show box
			var c = $(contener).css("position", "relative").append(loader), subj = null;
			// Scroll to position
			var lh = loader.height(), msgh = msgnode.outerHeight() + parseInt(msgnode.css("margin-top"));
			if(lh < msgh + 10) {
				if(!c.data("prev-padding-bottom")) {
					c.data("prev-padding-bottom", c.css("padding-bottom"));
				}
				c.css("padding-bottom", (msgh + 10 - lh)+"px");
			}
			if(typeof(subject) != "undefined") {
				subj = $(subject);
			}
			if(subj !== null && subj.length > 0) {
				var subj_pos = subj.position().top;
				var mtop = Math.max(10, Math.min(subj_pos, (lh - msgh - 10)));
				msgnode.css("margin-top", mtop+"px");
			}
			else {
				msgnode.css("margin-top", Math.max(10, Math.round(Math.min(150, (lh - msgh)/2)))+"px");
				if(closable) {
					xvideos.tools.scrollTo(c, 10);
				}
			}
			return loader;
		},
		closeAjaxOverlay: function(overlayElement) {
			var element = $((typeof(overlayElement) == "object" && !overlayElement.target) ? overlayElement : this),
				overlay = element.parents(".ajaxOverlay");
			if(overlay.hasClass('captchaOverlay')) {
				xvideos.tools._openedCaptchaOverlay = null;
				Recaptcha.destroy();
			}
			var contener = overlay.parent();
			var prev_padding = contener.data("prev-padding-bottom");
			if(prev_padding) {
				contener.css("padding-bottom", prev_padding);
				contener.removeData("prev-padding-bottom")
			}
			overlay.remove();
			
		},
		replaceThumbcast: function(html) {
			var parts = html.split(/(<script>|<\/script>)/g);
			for(var i=0; i<parts.length; i++) {
				if(parts[i] == "<script>" || parts[i] == "</script>") {
					parts[i] = "";
				} else if(parts[i].substr(0, 28) == "thumbcastDisplayRandomThumb(") {
					parts[i] = thumbcastDisplayRandomThumb(parts[i].substring(29, parts[i].lastIndexOf(")")-1), true);
				}
			}
			return parts.join("");
		},
		scrollTo: function(node, marginTop) {
			if(!marginTop)
				marginTop = 0;
			$('html,body').animate({scrollTop: $(node).offset().top - 10});
		},
		// content: { title, text, buttontext, callback, footer }
		_openedCaptchaOverlay: null,
		showCaptchaOverlay: function(contener, content, subject) {
			if(xvideos.tools._openedCaptchaOverlay) {
				xvideos.tools._openedCaptchaOverlay.remove();
				xvideos.tools._openedCaptchaOverlay = null;
			}
			var id = "captcha_"+(new Date()).getTime();
			var contentnode = $(document.createElement('h3')).html(content.title)
				.add($(xvideos.tools.encloseTextWithTag(content.text, 'p')).addClass('formLine'))
				.add($(document.createElement('div')).prop('id', id))
				.add($(document.createElement('div')).addClass('formActions')
					.append($('<input type="button" />').addClass('btnRight captcha_form_submit').prop("value", content.buttontext).click(content.callback))
					.append($('<input type="button" />').prop("value", "Cancel").click(xvideos.tools.closeAjaxOverlay)))
				.add($(document.createElement('div')).addClass('footer').html(content.footer));
			var overlay = xvideos.tools.appendAjaxOverlay(contener, contentnode, false, true, subject).addClass('captchaOverlay');
			Recaptcha.create("6Leluc8SAAAAAElzN1CrcweqVxkUfmGa7QC40pUU", id, { theme: "red", callback: $.proxy(xvideos.tools._onOverlayCaptchaCreated, overlay) });
			xvideos.tools._openedCaptchaOverlay = overlay;
			return overlay;
		},
		_onOverlayCaptchaCreated: function() {
			var loader = $(this),
				c = loader.parent(),
				msgnode = loader.children('.message'),
				lh = loader.height(),
				msgh = msgnode.outerHeight() + parseInt(msgnode.css("margin-top"));
			if(lh < msgh + 10) {
				var pbottom = parseFloat(c.css("padding-bottom"));
				if(!c.data("prev-padding-bottom")) {
					c.data("prev-padding-bottom", c.css("padding-bottom"));
				}
				c.css("padding-bottom", (msgh + 10 + pbottom - lh)+"px");
			}
		}
	},
	converter: {
		units: {
			in_cm: 2.54,
			lbs_kg: 0.45359237
		},
		convertUnits: function(number, from, to, precision) {
			var conv_code = from+'_'+to;
			var invert = false;
			if(!xvideos.converter.units[conv_code]) {
				conv_code = to+'_'+from;
				if(!xvideos.converter.units[conv_code]) {
					return false;
				}
				invert = true;
			}
			var val;
			if(invert) {
				val = number / xvideos.converter.units[conv_code];
			} else {
				val = number * xvideos.converter.units[conv_code];
			}
			if(precision === 0) {
				return Math.round(val);
			}
			if(precision) {
				var mult = Math.pow(10, precision);
				val = Math.round(val * mult) / mult;
			}
			return val;
		}
	},
	popup: {
		openPaginatedList: function(url, formatter, props) {
			var p = $.extend({
				title: "",
				loadmsg: "Loading data...",
				modal: true,
				draggable: false,
				width: 740,
				position: "top",
				marginTop: 20,
				marginBottom: 20
			}, props);
			var dlg = $(document.createElement('div'))
				.dialog({
					title: p.title,
					modal: p.modal,
					draggable: p.draggable,
					width: p.width,
					position: p.position
				});
			dlg.parents(".ui-dialog").css("margin-top", p.marginTop).removeClass("ui-corner-all").find(".ui-corner-all").removeClass("ui-corner-all");
			xvideos.popup._setDialogMaxHeight(dlg, p.marginBottom);
			xvideos.popup.loadListPage(dlg, url, formatter, p.loadmsg);
			
			var timer = null;
			var onresize = function() {
				if(timer)
					window.clearTimeout(timer);
				timer = window.setTimeout(function() {
					timer = null;
					xvideos.popup._setDialogMaxHeight(dlg, p.marginBottom);
				}, 500);
			};
			$(window).on("resize", onresize);
			dlg.on("dialogclose", function() {$(window).off("resize", onresize);})
		},
		loadListPage: function(dlg, url, formatter, loadmsg) {
			var page = dlg.data("list-page");
			if(!page)
				page = 0;
			var show_more = dlg.children(".show-more").hide();
			var loader = $(xvideos.tools.getInlineLoader(loadmsg, true)).appendTo(dlg);
			$.ajax({
				url: url,
				type: 'post',
				data: {page: page},
				cache: false,
				success: function(data) {
					if(data.result) {
						formatter(dlg, data);
						if(data.page == 0 && !data.lastpage) {
							dlg.append($(document.createElement('div')).addClass("show-more")
								.append($(document.createElement('a')).addClass("button").text("Show next voters")
									.click(function() {
										xvideos.popup.loadListPage(dlg, url, formatter, loadmsg);
									})));
						}
						else if(data.page > 0 && data.lastpage) {
							dlg.children(".show-more").remove();
						}
						dlg.data("list-page", page + 1);
					} else {
						var ajax_loader = xvideos.tools.appendAjaxOverlay(dlg, 'An error occured while loading voters. Please <a class="retry">retry</a>.', false, false);
						ajax_loader.find(".retry").click(function() {
							xvideos.popup.loadListPage(dlg, url, formatter, loadmsg);
							ajax_loader.remove();
						});
					}
				},
				error: function() {
					var ajax_loader = xvideos.tools.appendAjaxOverlay(dlg, 'An error occured while loading voters. Please <a class="retry">retry</a>.', false, false);
					ajax_loader.find(".retry").click(function() {
						xvideos.popup.loadListPage(dlg, url, formatter, loadmsg);
						ajax_loader.remove();
					});
				},
				complete: function() {loader.remove();show_more.show();}
			});
		},
		_setDialogMaxHeight: function(dlg, marginbottom) {
			var ptop = parseFloat(dlg.css("paddingTop").replace(/px/g, ""));
			var pbottom = parseFloat(dlg.css("paddingBottom").replace(/px/g, ""));
			dlg.css("maxHeight", $(window).height() - dlg.offset().top - marginbottom - ptop - pbottom);
		}
	},
	/*
   * History
   */
	history: {
		nohashvalue: "##NOHASH##",
		_hashes: {},
		_blocks: {},
		init: function() {
			var _h = window.History;
			if(typeof(_h) !== 'undefined' && typeof(_h.Adapter) !== 'undefined') {
				_h.Adapter.bind(window, 'popstate', function() {
					var hash = _h.getHash();
					if(!hash)
						hash = xvideos.history.nohashvalue;
					if(!xvideos.history._blocks[hash]) {
						if(xvideos.history._hashes[hash]) {
							xvideos.history._hashes[hash](hash);
						}
					}
					xvideos.history._blocks[hash] = false;
				});
			}
		},
		registerHash: function(hash, callback) {
			if(!$.isFunction(callback))
				return false;
			if(!hash)
				hash = xvideos.history.nohashvalue;
			xvideos.history._hashes[hash] = callback;
			return true;
		},
		setUrlHash: function(hash) {
			xvideos.history._blocks[hash] = true;
			xvideos.tools.setUrlHash(hash);
		}
	},
	
	/*
   * Cookies
   */
	cookies: {
		set: function (name, value, expires, path, domain, secure) {
			var today = new Date();
			today.setTime(today.getTime());
			if (expires) {
				expires = expires * 1000 * 60 * 60 * 24;
			}
	
			var expires_date = new Date(today.getTime() + expires);
	
			var toset = name + "=" +escape( value ) +
			(expires ? ";expires=" + expires_date.toGMTString() : "") +
			(path ? ";path=" + path : "") +
			(domain ? ";domain=" + domain : "") +
			(secure ? ";secure" : "");
			document.cookie = toset;	
		}
	},
  
	/*
   * Thumb slide functions
   */
	thumbsSlide: {
		curVideo: 0,
		oriPicNum: 0,
		curPicNum: 0,
		curUrl: "",
		init: function(context) {
			if(typeof(context) == "undefined")
				$('.thumbBlock .thumb img[id]').mouseover(xvideos.thumbsSlide.startThumbSlide).mouseout(xvideos.thumbsSlide.stopThumbSlide);
			else
				$('.thumbBlock .thumb img[id]', context).mouseover(xvideos.thumbsSlide.startThumbSlide).mouseout(xvideos.thumbsSlide.stopThumbSlide);
		},
		getNextThumbNum: function(CurNum) {
			var thumbs = new Array(2,5,8,11,14,17,20,23,26,29);
			for (var i = 0; i < thumbs.length; i++) {
				if (thumbs[i] > CurNum) {
					return thumbs[i];
				}
			}
			return thumbs[0];
		},    
		nextThumbnail: function(idDoc) {
			if (xvideos.thumbsSlide.curVideo != 0 && idDoc == xvideos.thumbsSlide.curVideo) {
				$("#pic_" + xvideos.thumbsSlide.curVideo).attr('src', xvideos.thumbsSlide.curUrl + xvideos.thumbsSlide.curPicNum + ".jpg");
				var nextthumb = xvideos.thumbsSlide.getNextThumbNum(xvideos.thumbsSlide.curPicNum);
				xvideos.tools.preLoadPicture(xvideos.thumbsSlide.curUrl, nextthumb);
				xvideos.thumbsSlide.curPicNum = nextthumb;
				setTimeout("xvideos.thumbsSlide.nextThumbnail("+ xvideos.thumbsSlide.curVideo +")", 1000);
			}
		},
		startThumbSlide: function() {
			if (xvideos.thumbsSlide.curVideo == 0) {
				var img = $(this);
				xvideos.thumbsSlide.curVideo = img.attr('id').substring(4);
				var src = img.attr('src');
				src = src.substring(0, src.lastIndexOf('.'));
				var pos = src.lastIndexOf('.');
				xvideos.thumbsSlide.oriPicNum = parseInt(src.substring(pos + 1));
				xvideos.thumbsSlide.curUrl = src.substring(0, pos + 1);
				var nextthumb = xvideos.thumbsSlide.getNextThumbNum(xvideos.thumbsSlide.oriPicNum);
				xvideos.tools.preLoadPicture(xvideos.thumbsSlide.curUrl, nextthumb);
				xvideos.thumbsSlide.curPicNum = nextthumb;
				setTimeout("xvideos.thumbsSlide.nextThumbnail("+ xvideos.thumbsSlide.curVideo +")", 20);
			}
		},    
		stopThumbSlide: function() {
			var TmpDoc = xvideos.thumbsSlide.curVideo;
			xvideos.thumbsSlide.curVideo = 0;
			$("#pic_" + TmpDoc).attr('src', xvideos.thumbsSlide.curUrl + xvideos.thumbsSlide.oriPicNum + ".jpg");	
		}
	},
  
	/*
   * Tabs functions
   */
	tabs: {
		_loaded: false,
		init: function() {
			$('.tabsContainer').each(function(i, elt) {
				var cntr = $(elt);
				if(cntr.hasClass('nosetup'))
					return true;
				// Tab click action + close button
				$('ul.tabButtons li.headtab', cntr).each(function(i, tab) {
					xvideos.history.registerHash('_' + $(tab).click(xvideos.tabs.onClickTab).data("ref"), xvideos.tabs.onHashChanged);
					if(i == 0)
						xvideos.history.registerHash(false, xvideos.tabs.onHashChanged);
				})
				.filter(".closable").each(function(i, tab) {
					var close = $('<a class="closeBtn">X</a>');
					$(tab).append(close);
					close.click(xvideos.tabs.onClose);
				});
				// Hide panels
				$('.tabs div.tab', cntr).hide();
				// Check if a tab is asked in URL or open selected panel
				var hash = xvideos.tools.getUrlHash();
				var opened = false;
				if(hash) {
					if(hash[0] == '_')
						hash = hash.substr(1);
					var tabcontent = $("#"+hash);
					if(tabcontent.length > 0) {
						var tab = tabcontent.parents(".tabsContainer").find('li[data-ref="'+hash+'"]');
						if(tab.length > 0) {
							tab.click();
							opened = true;
						}
					}
				}
				if(!opened) {
					var sel = cntr.find('ul.tabButtons li.selected');
					if(sel.length > 0) {
						$(sel[0]).click();
						opened = true;
					}
				}
				if(!opened)
					xvideos.tabs._loaded = true;
			});
			$("a[tab-ref]").each(function(i, a){
				var tab = $('.tabsContainer .tabButtons li[data-ref="'+$(a).attr("tab-ref")+'"]');
				if(tab.length > 0) {
					$(a).click(function(event) {
						event.preventDefault();
						tab.click();            
					});
				}
			});
		},
		onHashChanged: function(hash) {
			if(hash != xvideos.history.nohashvalue) {
				$('.tabsContainer .tabButtons li[data-ref="'+hash.substr(1)+'"]').click();
			}
			else {
				xvideos.tabs._loaded = false;
				$('.tabsContainer .tabButtons li').first().click();
			}
		},
		onClickTab: function(event) {
			if($(event.target).hasClass('closeBtn'))
				return;
			
			event.preventDefault();
			
			var tab = $(this);
			var ref = tab.data('ref');
			if(xvideos.tabs._loaded) {
				xvideos.history.setUrlHash('_'+ref);
			} else {
				xvideos.tabs._loaded = true;
			}
			
			var href = tab.data('href');
			var contener = $("#"+ref);
			var cntr = tab.parents('.tabsContainer');
			$('.tabs div.tab', cntr).hide();
			$("ul.tabButtons li.selected", cntr).removeClass("selected");
			contener.show();
			tab.addClass("selected");
			if(typeof(href) != 'undefined' && !contener.data('loaded')) {
				contener.children(".tabLoadError").remove();
				contener
				.html(xvideos.tools.getInlineLoader("Loading...", false))
				.load(href, function(response, status, xhr) {
					if (status == "error") {
						var retry_id = 'tab_' + contener.attr('id').toLowerCase() + '_retry';
						contener.append('<div class="tabLoadError inlineError center">Sorry but an error occured ! Click <a id="' + retry_id + '">Here</a> to retry.</div>');
						$('#' + retry_id, contener).click(function() {
							tab.click();
						});
						return;
					}
					contener.data('loaded', true);
				});        
			}
			var onshow = tab.data('onshow');
			if(typeof(onshow) != 'undefined') {
				var f = xvideos.tools.getFuncByName(onshow);
				if(f)
					f(contener, tab);
			}
		},
		onClose: function(event) {
			var tab = $(this).parent();
			$("#"+tab.data('ref')).hide();
			tab.removeClass("selected");
		}
	},
	
	/**
	 * Search (profiles)
	 */
	search: {
		_fields: {},
		init: function() {
			var n = $("#age_min_select");
			if(!n.length)
				return;
			
			var _s = xvideos.search;
			_s._fields = {
				age_min: n.change(_s.checkRange),
				age_max: $("#age_max_select").change(_s.checkRange),
				height_min: $("#height_min_select").change(_s.checkRange),
				height_max: $("#height_max_select").change(_s.checkRange),
				weight_min: $("#weight_min_select").change(_s.checkRange),
				weight_max: $("#weight_max_select").change(_s.checkRange),
				body_unit: $("#search_body_unit")
			};
			$("#searchProfileShowAdvanced").click(_s.showAdvanced);
			$("#changeSearchBodyUnit").click(_s.changeBodyUnits);
		},
		showAdvanced: function() {
			var form = $("#searchProfileForm");
			form.children(".tabHeaderForm").remove();
			form.children(".column").show();
			form.removeClass();
			$(this).remove();
		},
		checkRange: function() {
			var val = parseInt($(this).val());
			if(val == 0)
				return;
			
			var id = $(this).attr("id");
			var basename = id.substring(0, id.indexOf("_"));
			var type = id.substring(id.indexOf("_") + 1, id.lastIndexOf("_"));
			
			var otherval = parseInt($("#"+basename+"_"+(type == "min" ? "max" : "min")+"_select").val());
			if(otherval == 0)
				return;
			
			if(type == "max") {
				if(val < otherval) {
					alert("The maximum "+basename+" must be greater than the minimum "+basename+" !");
					$(this).val(0);
				}
			} else {
				if(val > otherval) {
					alert("The minimum "+basename+" must be smaller than the maximum "+basename+" !");
					$(this).val(0);
				}
			}
		},
		changeBodyUnits: function() {
			var _s = xvideos.search;
			var old_unit = _s._fields.body_unit.val();
			_s._fields.body_unit.val(old_unit == "US" ? "EU" : "US");
			$(this).text(old_unit == "US" ? "Use US units (in and lbs)" : "Use EU units (cm and kg)");
			
			$.each([_s._fields.height_min, _s._fields.height_max], function(j, sel) {
				sel.children("option").each(function(i, opt) {
					var _opt = $(opt);
					var val = _opt.val();
					if(val == 0)
						return;
					if(old_unit == "US") {
						_opt.text(val+'cm');
					} else {
						_opt.text(xvideos.converter.convertUnits(val, 'cm', 'in', 1)+'in');
					}
				});
			});
			$.each([_s._fields.weight_min, _s._fields.weight_max], function(j, sel) {
				sel.children("option").each(function(i, opt) {
					var _opt = $(opt);
					var val = _opt.val();
					if(val == 0)
						return;
					if(old_unit == "US") {
						_opt.text(val+'kg');
					} else {
						_opt.text(xvideos.converter.convertUnits(val, 'kg', 'lbs', 1)+'lbs');
					}
				});
			});
		}
	}
};


// Init
$(document).ready(function() {
  
	xvideos.thumbsSlide.init();
	xvideos.tabs.init();
	xvideos.search.init();
	xvideos.history.init();
  
});
