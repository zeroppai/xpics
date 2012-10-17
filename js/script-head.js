
function thumbcastDisplayRandomThumb(content, ret) {
	var thumb = Math.floor((Math.random() * 600)) % 30 + 1;
	content = content.replace(/\.[0-9]+.jpg/, "." + thumb + ".jpg");
	content = content.replace(/THUMBNUM/g, thumb);
	if(ret)
		return content;
	document.write(content);	
}

function videoPageWriteRelated(related) {
	if(related.length == 0)
		return;
	var content = '<div id="relatedVideosWithMore">';
	for(var p = 0; p < related.length; p++) {
		content += '<div class="page" id="related_page_'+p+'" '+(p == 0 ? 'style="top:0;" data-loaded="true"' : '')+'>';
		var page = related[p];
		for(var v = 0; v < page.length; v++) {
			var video = page[v];
			content += '<div class="thumbBlock" id="video_'+video.id+'"><div class="thumbInside">';
			if(p > 0) { content += '<!--'; }
			var casted = typeof(video.cu) == 'undefined';
			var url = casted ? video.u : video.cu;
			if(!casted) { content += "<script>thumbcastDisplayRandomThumb('"; }
			content += '<div class="thumb"><a href="'+url+'"><img src="'+video.i+'" id="pic_'+video.id+'" /></a></div><p><a href="'+url+'">'+video.t+'</a></p>';
			if(!casted) { content += "');</script>"; }
			content += '<p class="metadata"><span class="duration">'+video.d+'</span> Porn quality: '+video.r+'</p>';
			if(p > 0) { content += '-->'; }
			content += '</div></div>';
		}
		content += '</div>';
	}
	content += '</div>';
	if(related.length > 1) {
		content += '<div id="relatedVideosMoreLink"><a class="button">Show more videos</a></div>';
	}
	document.write(content);
}

function createRequestObject() {
	var xhr;
	try {
		xhr = new XMLHttpRequest();
	}
	catch (e) {
		xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xhr;
}

/**
 * Adult Disclamer Message
 */

function displayDisclamer(site_name) {
	var display = hexatrade_getCookie("disclamer_display");
	if (display == "OK") {
		return; // Already displayed (and confirmed) for this user
	}
	var html = "<div id='disclamer_message' style='position: absolute; z-index: 80000;  width: 100%; text-align: center;'>" +
			"<div style='border: 3px solid red; font-size: 15px; margin-left: auto; margin-right: auto; color: black; display: block; padding-top: 5px; margin-top: 100px; text-align: center; width: 550px; padding-bottom: 10px; background-color: white; opacity: 1;filter : alpha(opacity=100);'>"
	html += "<span style='font-size: 30px; font-weight: bold;'>" + site_name + "</span>" +
			"<br /><br />" +
			"<textarea cols='60' rows='10' readonly='readonly'>I am at least 18 years of age and have the legal right to access and possess adult material in the community from which I am accessing these materials and in which I reside;\n" +
			"I will not permit any person(s) under the age of 18 (or who are otherwise not legally permitted) to have access to any of the materials contained on this website;\n" +
			"I acknowledge that I am voluntarily requesting and choosing to receive the materials described above for my own personal use, information and/or education and that in no way am I being sent any information without my permission;\n" +
			"I am not offended by materials of an adult nature, nor do I find such materials objectionable;\n" +
			"I will exit from the website immediately in the event that I am in any way offended by any material found on the website;\n" +
			"I am familiar with, understand and agree to comply with the standards and laws of the community in which I live and from which I am gaining access;\n" +
			"I agree that I will not hold the creators, owners or operators of this website, or their employees, responsible for any materials or links contained on these pages;\n" +
			"I understand that if I violate these terms or any provision of the Terms of Use, I may be in violation of federal, state, and/or local laws or regulations, and that I am solely responsible for my actions.\n" +
			"I hereby affirm, under the penalties of perjury pursuant to 28 U.S.C.§ 1746, that I was born on the following month, day, and year.\n" +
			"Providing a false declaration under penalty of perjury is a criminal offense. This document constitutes a sworn declaration under federal law, and is intended to be governed by the Electronic Signatures Act.\n" +
			"</textarea>" +
			"<br /><br />" +
			"<b>I agree</b><br /><br />" +
			"<div onClick='enterSiteDisclamer()' style='margin-left: auto; margin-right: auto; width: 200px; color: black; font-size: 19px; cursor:hand; cursor:pointer; border: 1px green solid; font-weight: bold; padding: 6px;'><span style='font-size: 30px;'>ENTER</span><br />" + site_name + "</div>" +
			"<br />" +
			"I disagree - <span onClick='leaveSiteDisclamer()' style='color: black; font-size: 15px; cursor:hand; cursor:pointer; padding: 6px; font-weight: bold; text-decoration: underline;'>Leave</span>";
	html += "</div>" +
			"</div>";
	html += "<div  id='disclamer_background' style='position: absolute; background-color: black; left: 0px; z-index: 79999; opacity: 0.85; display: block; top: 0px; height: 1000px; width: 100%; background-color: #000000; color: #000000; filter : alpha(opacity=85);'>";
	html += "<br /><br /><br />";
	
	html += "</div>";
	document.write(html);
}

function enterSiteDisclamer() {
	hideDisclamer();
}

function leaveSiteDisclamer() {
	document.location.href = "http://www.google.com/";
}

function hideDisclamer() {
	// Set cookie
	hexatrade_setCookie("disclamer_display", "OK", null, 3600 * 6);
	// Destroy Disclamer div
	document.getElementById("disclamer_message").style.display = "none";
	document.getElementById("disclamer_background").style.display = "none";
}

/**
 * End Adult Disclamer Message
 */

/**
 * Dynamic Advert Display
 */

function displayDynamicAdvert(url) {
	dynadvert = createRequestObject();
	dynadvert.onreadystatechange = displayDynamicAdvertHandler;
	dynadvert.open('GET', url, true);
	dynadvert.send(null);
}


function displayDynamicAdvertHandler() {
	if (this.stopped) {
		return;
	}
	if (this.readyState != 4) {
		return;
	}
	var doc = document.getElementById("adChannel");
	if (doc == null) {
		doc = document.getElementById("channel");
	}
	if (doc == null) {
		return;
	}
	
	if(this.status != 200) {
		//doc.innerHTML = "Network Error. Please try again.";
		return;
	}
	var text = this.responseText;
	if (typeof(text) == "undefined") {
		//doc.innerHTML = "Unknow error. Please try again.";
		return;
	}
	
	try {
		var avertInfo = eval('(' + text + ')');
		if (avertInfo.link && avertInfo.title && avertInfo.desc && avertInfo.bottom) {
			doc.innerHTML = avertInfo.title + ' ' + avertInfo.desc + ' <a href="' + avertInfo.link + '" target="_blank"><strong>' + avertInfo.bottom + '</strong></a>';
			doc.style.display = "block";
		}
	} catch(e) {
		//doc.innerHTML = "Unknow error. Please try again. " + e;
	}
	
}

/**
 * END Dynamic Advert Display
 */
 
 /**
 * Cookie functions
 */

function Set_Cookie( name, value, expires, path, domain, secure ) {
	var today = new Date();
	today.setTime( today.getTime() );
	
	if ( expires ) {
		expires = expires * 1000 * 60 * 60 * 24;
	}
	
	var expires_date = new Date( today.getTime() + (expires) );
	
	var toset = name + "=" +escape( value ) +
	( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
	( ( path ) ? ";path=" + path : "" ) +
	( ( domain ) ? ";domain=" + domain : "" ) +
	( ( secure ) ? ";secure" : "" )
	document.cookie = toset;
	
}


function hexatrade_setCookie(c_name,value,exdays)
{
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
    document.cookie = c_name + "=" + c_value;
}

function hexatrade_getCookie(c_name)
{
    var i, x, y, ARRcookies = document.cookie.split(";");
    for (i = 0; i < ARRcookies.length; i++)
    {
	x = ARRcookies[i] . substr(0,ARRcookies[i] . indexOf("="));
	y = ARRcookies[i] . substr(ARRcookies[i] . indexOf("=")+1);
	x = x.replace(/^\s+|\s+$/g,"");
	if (x == c_name)
	{
	    return unescape(y);
	}
    }
}

/**
 * END Cookie functions
 */


