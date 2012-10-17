
function WriteCookie(name, value) {
  var argv = WriteCookie.arguments;
  var argc = WriteCookie.arguments.length;
  var expires = (argc > 2) ? argv[2] : null;
  var path = (argc > 3) ? argv[3] : null;
  var domain = (argc > 4) ? argv[4] : null;
  var secure = (argc > 5) ? argv[5] : false;
  
  var expireDate = new Date();
  expireDate.setTime(expireDate.getTime() + 2 * 24 * 3600 * 1000); // Expire
																	// dans 2
																	// jours
  
  document.cookie = name + "=" + escape(value)+ "; expires=" + expireDate.toGMTString() +
  						((path == null) ? "" : ("; path="+path)) +
  						((domain == null) ? "" : ("; domain="+domain)) +
  						((secure == true) ? "; secure" : "");
}

function getCookieVal(offset) {
  var endstr = document.cookie.indexOf(";", offset);
  if (endstr == -1) {
    endstr = document.cookie.length;
  }
  return unescape(document.cookie.substring(offset, endstr));
}

function ReadCookie(name) {
  var arg = name + "=";
  var alen = arg.length;
  var clen = document.cookie.length;
  var i = 0;
  
  while (i < clen) {
    var j = i + alen;
    if (document.cookie.substring(i, j) == arg) {
      return getCookieVal(j);
    }
    i = document.cookie.indexOf(" ", i) + 1;
    if (i == 0) {
      break;
    }
  }
  
  return null;
}

function mobileCheckIsMobile() {

	if (navigator.userAgent.match(/(up.browser|up.link|mmp|symbian|ipad|iphone|ipod|android|smartphone|midp|wap|vodafone|windows ce|pocket|kindle|mobile|treo|ipaq|palm|nokia|blackberry|opera mini|lg\-|lge\-|htc|mot\-|mot |psp|sonyericsson|sgh|iemobile|bada|rx\-51 n900)/i)) {
		return true;
	}
	
	return false;
}

function mobileSupportH264() {
	if (navigator.userAgent.match(/(ipad|iphone|ipod|android|blackberry9|blackberry 98|blackberry 99|iemobile|bada|symbianos\/9\.3|symbianos\/9\.4|symbianos\/9\.5|symbian\/3|nokian95|rx\-51 n900|htc_hd2)/i)) {
		return true;
	}
	return false;
}

function isiPhonePhone() {
	if (navigator.userAgent.match(/(ipad|iphone|ipod)/i)) {
		return true;
	}
	return false;
}

function isFlashCompatible() {
	if (navigator.userAgent.match(/(android 2\.2|android 2\.3|android 3\.|symbian\/3|symbianos\/9\.5|rx\-51 n900)/i)) {
		return true;
	}
	return false;
}

function mobileRedirectIfMobile() {
	if (mobileCheckIsMobile() && !mobileSupportH264()) {
		if (ReadCookie("XVIDEOS_MOBILE") != "NO") {
			location.replace("http://mobile." + master_url + "/");
		}
	}
}

function mobileGoBackOnNormalSite() {
	WriteCookie("XVIDEOS_MOBILE", "NO", null, "/", master_url);
	location.replace("http://www." + master_url + "/");
}

function mobileVideoChangeForMobile(channel) {
	if (!mobileCheckIsMobile()) {
		return;
	}
	var channeldiv = document.getElementById("channel_text");
	if (channel && channeldiv) {
		var reg = new RegExp("(<a href=\").*(\" target)");
		channeldiv.innerHTML = channeldiv.innerHTML.replace(reg, "$1" + channel + "$2");
	}
	
	var player = document.getElementById("player");
	if (!player) {
		return;
	}
	var txt = player.innerHTML;
	var index = txt.indexOf("3GP||");
	if (!index) {
		return;
	}
	var index2 = txt.indexOf("||", index + 5);
	if (!index2) {
		return;
	}
	var url3gp = txt.substring(index + 5, index2);
	var expdomain = new RegExp("(porn[0-9]+)", "g");
	var expparams = new RegExp("(\\\?.*)", "");
	var urlthumb = url3gp.replace("xvideos.com_", "").replace(".mp4", ".5.jpg").replace("3gp", "thumbslll").replace(expdomain, "img100").replace(expparams, "");
	if (isiPhonePhone()) {
		mobileReplacePlayerDiv("iphone", url3gp, urlthumb, channel);
	} else {
		
		if (!mobileSupportH264()) {
			mobileReplacePlayerDiv("oldphone", url3gp, urlthumb, channel);
		} else {
			mobileReplacePlayerDiv("smartphone", url3gp, urlthumb, channel);
		}	
	}
}

function mobileReplacePlayerDiv(type, mp4url, thumburl, channel) {
	mobileReplacePlayerDivTwoQual(type, mp4url, "", thumburl, channel);
}

function mobileReplacePlayerDivTwoQual(type, mp4urllow, mp4urlhigh, thumburl, channel, viddefaut) {
	var channeldiv = document.getElementById("channel_text");
	if (channel && channeldiv) {
		var reg = new RegExp("(<a href=\").*(\" target)");
		channeldiv.innerHTML = channeldiv.innerHTML.replace(reg, "$1" + channel + "$2");
	}
	
	var player = document.getElementById("player");
	if (!player) {
		return;
	}
	
	mp4url = mp4urllow;
	if (viddefaut == "high" && mp4urlhigh != "") {
		mp4url = mp4urlhigh;
	}
	
	if (type == "iphone" || type == "html5player") {
		text = "<video src=\"" + mp4url + "\" width=\"582\" height=\"400\" autobuffer controls></video><br />";
		text += "<div style='width: 570px; text-align: center; font-size: 18px; border: 2px #333 solid; margin: 3px; padding: 5px; display: block; background: #AAA;'>" +
				"<a href=\"" + mp4urllow + "\" style='margin: auto; width: 170px;'>" +
						"View Low Qual</a>";
		
		if (mp4urlhigh != "") {
			text += "<a href=\"" + mp4urlhigh + "\" style='margin-left: 80px; width: 170px;'>" +
						"View High Qual</a>";
		}
		text += "</div><br />";
		player.innerHTML = text;
		
	}
	if (type == "html5playerautoplay") {
		player.innerHTML = "<video src=\"" + mp4url + "\" width=\"600\" height=\"400\" autobuffer controls autoplay /><br />";
	}
	if (type == "tablet") {
		text = "<video src=\"" + mp4url + "\" width=\"582\" height=\"400\" autobuffer controls></video><br />";
		text += "<div style='width: 570px; text-align: center; font-size: 18px; border: 2px #333 solid; margin: 3px; padding: 5px; display: block; background: #AAA;'>" +
				"<a href=\"" + mp4urllow + "\" style='margin: auto; width: 170px;'>" +
						"View Low Qual</a>";
		
		if (mp4urlhigh != "") {
			text += "<a href=\"" + mp4urlhigh + "\" style='margin-left: 80px; width: 170px;'>" +
						"View High Qual</a>";
		}
		text += "</div><br />";
		player.innerHTML = text;
	}
	if (type == "smartphone") {
		text = '<div id="xvideos_pic" style="width: 100%; text-align: left;"><a href="' + mp4url +
								'"><img src="' + thumburl + '" height="400" width="600"><div style="display: block; width: 1px; height: 1px;"><img src="http://static.xvideos.com/img/button_play.png" style="position: relative; left: 236px; top: -264px; width: 128px; height: 128px;" border="0">' + 
								'</div></a></div>';
		text += "<div style='width: 570px; text-align: center; font-size: 18px; border: 2px #333 solid; margin: 3px; padding: 5px; display: block; background: #AAA;'>" +
				"<a href=\"" + mp4urllow + "\" style='margin: auto; width: 170px;'>" +
						"View Low Qual</a>";
		
		if (mp4urlhigh != "") {
			text += "<a href=\"" + mp4urlhigh + "\" style='margin-left: 80px; width: 170px;'>" +
						"View High Qual</a>";
		}
		text += "</div><br />";
		player.innerHTML = text;
	}
	if (type == "oldphone") {
		player.innerHTML = "<font color='#FFFFFF'><h2>Your phone seems to be not compatible with Xvideos.com.</h2></font>";
		player.innerHTML += "<center><a href=\"" + mp4urllow + "\" style='font-size: 18px; border: 2px #333 solid; margin: 3px; padding: 5px; display: block; background: #AAA;'>Download the video file</a></center><br />";
	}
}
