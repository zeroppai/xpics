<?
function beluga(){
	return new Beluga();
}
function getImageItemsFromBeluga($since_id='0',$max_id='',$count=0){
	$items = array();
	$i = 0;
	foreach (beluga()->home($since_id,$max_id) as $timeline) {
		if(preg_match_all('/(?:^|[\s　]+)((?:https?|ftp):\/\/[^\s　]+)\.(png|jpg|gif)/',$timeline['text'],$matches)){
			foreach ($matches[0] as $val) {
				$item['tl_id'] = $timeline['id'];
				$item['id'] = $i++;
				$item['image_url'] = $val;

				$p_url = pathinfo($val);
				$item['thumbnail_url'] = $p_url['dirname'].'/'.$p_url['filename'].'x100.'.$p_url['extension'];
				$item['title'] = $p_url['filename'].'.'.$p_url['extension'];
				$item['rate'] = 1.0;

				$items[] = $item;
			}
		}
		$max_id = $timeline['id'];
	}
	if($count+$i<50){
		$items = array_merge($items,getImageItemsFromBeluga($since_id,$max_id,$count+$i));
	}
	return $items;
}

function dispHeader(){
?>
<!DOCTYPE html>
<!-- saved from url=(0023)http://www.xvideos.com/ -->
<html class=" js no-flexbox canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" lang="en">
<!--<![endif]--><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8"> 
  <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->

  <title>Free Porn Pictures - XVPICTS.NET</title>
  <meta name="keywords" content="xpicts,xpicts.net, x pictures,x picture,porn,picture,pictures,">
  <meta name="description" content="XPICTS Free Porn Images free">
  
  <link rel="search" type="application/opensearchdescription+xml" title="XPicts" href="http://beluga.fm"/>
  <link rel="shortcut icon" href="http://static.xvideos.com/img/favicon_xvideos.ico"/>
  <link rel="stylesheet" href="./js/xv-styles.css"/>
  <link rel="stylesheet" href="./js/xv-account-styles.css"/>
  <link rel="stylesheet" type="text/css" media="all" href="./js/html5_styles.css" />

  <script src="./js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="http://static.xvideos.com/v2/js/libs/jquery-1.7.2.min.js"><\/script>')</script>

  <script src="./js/modernizr-2.5.3.min.js"></script>
  <script src="./js/script-head.js"></script>
  <script src="./js/mobile.js"></script>
</head>
<body>
  <div id="page">
    <header>
      <div class="whiteStripe clearfix">
        <div id="social">
          <a href="#" target="_blank"><img src="./js/xv-rss.png" alt="XML RSS feed"></a>
          <a href="http://beluga.fm/" target="_blank"><img src="./js/xv-red-twitter.png" alt="XVideos on Twitter"></a>
        </div>
        <a href="./index.php"><img src="./js/xvideos.gif" alt="XPicts Home" id="siteLogo"></a>
        <h1 class="hidden">XPICTS.NET</h1>
        <form action="./js/Free Porn Videos - XVIDEOS.COM.html" method="get" id="searchForm">
          <input type="text" name="k" value="" id="q" maxlength="2048" size="30">
          <input type="submit" value="Search" id="searchSubmit">
        </form>
        <h2>THE BEST <span class="redText">FREE PORN</span> SITE</h2>
      </div>
      
      <div class="redStripe clearfix" id="mainMenu">
        <p>YOUR UPLOAD / DAY</p>
        <ul>
          <li><a href="./index.php">Best Pictures</a></li>
          <li><a href="./index.php">Hits</a></li>
          <li><a href="./index.php">Tags</a></li>
          <li><a href="./index.php">Archives</a></li>
        </ul>
      </div>
      
      <div class="blackStripe clearfix" id="secondaryMenu">
        <p>
          <a href="index.php?action=upload"><b>Upload Picture</b></a> | <a href="http://upload.xvideos.com/account"><b>Log in</b></a>
        </p>
        <ul>
          <li><strong><a href="#">Real Amateur Porn Pictures</a></strong></li>
          <li>||</li>
          <li><a href="#">Best Of Today</a></li>
          <li>|</li>
          <li><a href="#">Best Of 7 Days</a></li>
          <li>|</li>
          <li><a href="#">Best Of 30 Days</a></li>
          <li>|</li>
        </ul>
      </div>
<!--
      <div class="redStripe redStripeBordered">
			</div>
 -->
    </header>
<?
}

function dispFooter(){
?>
    <div id="ad-bottom">
    </div>
    
    <footer>
      <div class="terms">
        <p>
          XPicts.net is a <strong>free hosting service for porn picts</strong>.
        </p>
        <div class="botLinks">
          <a href="http://beluga.fm">beluga.fm</a> - 
          <a href="http://beluga.fm/room/85V9p+nfRr51E">【18禁】エロ画像を貼るアレ</a> ...
        </div>
      </div>
      <p class="slogan">XPicts.com - the best free porn videos on internet, 100% free.</p>
    </footer>
    
  </div> <!-- #page  -->
</body></html>
<?
}

/*
   $item
 	$item['id']
 	$item['image_url']
	$item['thumbnail_url']
	$item['title']
	$item['rate']
 */
function dispImageThumbnail($item){
?>
<div class="thumbBlock" id="iamge_<?=$item['id']?>">
	<div class="thumbInside">
		<div class="thumb">
			<a href="<?=$item['image_url']?>" target="_blank"><img src="<?=$item['thumbnail_url']?>" id="pic_<?=$item['id']?>"></a>
		</div>
		<p><a href="<?=$item['image_url']?>" target="_blank"><?=$item['title']?></a></p>

		<p class="metadata">
			<span class="bg">
				<span class="duration">Quality:<?=$item['rate']?></span>
			</span>
		</p>
	</div>
</div>
<?
}