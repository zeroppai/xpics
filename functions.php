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

function getURLParams($url){
  $param_string = explode('?',$url);
  foreach (explode('&',$param_string[1]) as $value) {
    $p = explode('=',$value);
    $result[$p[0]] = $p[1];
  }
  return $result;
}

function dispHeader(){
?>
<!DOCTYPE html>
<!-- saved from url=(0023)http://www.xvideos.com/ -->
<html class=" js no-flexbox canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" lang="ja">
<!--<![endif]--><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8"> 
  <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->

  <title>貴方の画像収集をサポートするWebサービス - XVPICTS.NET</title>
  <meta name="keywords" content="xpicts,xpicts.net, x pictures,x picture,porn,picture,pictures,">
  <meta name="description" content="XPICTS Free Porn Images free">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0" />
  
  <link rel="search" type="application/opensearchdescription+xml" title="XPicts" href="http://beluga.fm"/>
  <link rel="shortcut icon" href="./img/favicon_xvideos.ico"/>
  <link rel="stylesheet" href="./css/xv-styles.css"/>
  <link rel="stylesheet" href="./css/xv-styles-mobile.css"/>
  <link rel="stylesheet" href="./css/xv-account-styles.css"/>
  <link rel="stylesheet" type="text/css" media="all" href="./css/html5_styles.css" />

  <script src="./js/jquery.min.js"></script>

  <script src="./js/jquery.tools.min.js"></script>
  <script type="text/javascript" src="./js/jquery.blockUI.js"></script>
  <script src="./js/modernizr-2.5.3.min.js"></script>
  <script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-35824261-1']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>
</head>
<body>
  <div id="page">
    <header>
      <div class="whiteStripe clearfix">
        <div id="social">
          <a href="#" target="_blank"><img src="./img/xv-rss.png" alt="XML RSS feed"></a>
          <a href="http://beluga.fm/" target="_blank"><img src="./img/xv-red-twitter.png" alt="XVideos on Twitter"></a>
        </div>
        <a href="./index.php"><img src="./img/xpicts_logo.png" alt="XPicts Home" id="siteLogo"></a>
        <h1 class="hidden">XPICTS.NET</h1>
        <form action="#" method="get" id="searchForm">
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
          <li><a href="./index.php?action=archive">Archives</a></li>
        </ul>
      </div>
      
      <div class="blackStripe clearfix" id="secondaryMenu">
        <p>
        <? if(isset($_SESSION['user']['user_id']) && $_SESSION['user']['user_id']>0 ){ ?>
          <a href="index.php?action=newArchive"><b>New Archive</b></a> | 
          <a href="index.php?action=editArchive"><b>Edit Archive</b></a> | 
        <? } ?>
          <a href="index.php?action=upload"><b>Upload Picture</b></a> | 
        <? if(isset($_SESSION['user']['user_id']) && $_SESSION['user']['user_id']>0 ){ ?>
          <a href="index.php?action=logout"><b>Log out</b></a> | 
        <? }else{ ?>
          <a href="index.php?action=login"><b>Log in</b></a>
        <? } ?>
        </p>
      </div>
      <?if(!stristr($_SERVER['HTTP_USER_AGENT'],"WebKit")){?>
      <div class="redStripe redStripeBordered">
        このサイトはWebkit系のサポートのみしています。ChromeかSafari以外だとうまく表示されない場合があります。
			</div>
      <?}?>
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
          Xpicts.net は <strong>画像URLを共有し、スライドショーで閲覧出来る無料サイトです</strong>。
        </p>
        <div class="botLinks">
          <a href="http://beluga.fm">beluga.fm</a> - 
          <a href="http://beluga.fm/room/85V9p+nfRr51E">【18禁】エロ画像を貼るアレ</a> ...
        </div>
      </div>
      <p class="slogan">XPicts.com - 画像URL共有サイト</p>
    </footer>
    
  </div> <!-- #page  -->

  <?// out($_SESSION); ?>
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
			<a href="index.php?action=viewer&id=<?=$item['id']?>" ><img src="<?=$item['thumbnail_url']?>" id="pic_<?=$item['id']?>"></a>
		</div>

		<p class="metadata">
			<span class="bg">
				<span class="duration">Quality:<?=$item['rate']?></span>
			</span>
		</p>
	</div>
</div>
<?
}

function dispArchiveThumbnail($item){
?>
<div class="thumbBlock" id="archive_<?=$item['archive_id']?>">
  <div class="thumbInside">
    <div class="thumb">
      <a href="index.php?action=viewer&archive_id=<?=$item['archive_id']?>" ><img src="<?=$item['thumbnail_url']?>" id="pic_<?=$item['archive_id']?>"></a>
    </div>

    <p class="metadata">
      <span class="bg">
        <p><a href="index.php?action=viewer&archive_id=<?=$item['archive_id']?>" ><?=$item['title']?></a></p>
        <span class="duration">Quality:<?=$item['rate']?></span>
      </span>
    </p>
  </div>
</div>
<?
}

function dispTags(){
?>
      <ul id="video-tags">
        <li><em>Tags</em></li>
          <li><a href="/tags/facial">facial</a>, </li>
          <li>more <a href="/tags/"><strong>タグ</strong></a>.</li>
      </ul>
<?
}

function dispPopCategory(){
?>
    <div id="categories" class="pagination lighter">
      <ul>
        <li><a href="#"> muridana</a></li>
        <li><a href="#"> asd</a></li>
        <li><a href="#"> gagaga</a></li>
        <li><a href="#"> oppai</a></li>
        <li><a href="#"> homo</a></li>
      </ul>
    </div> <!-- #categories -->
<?
}

function dispVoteTab($y_num=1,$n_num=1){
  $rate = sprintf('%.2f',$y_num*100/($y_num+$n_num));
?>
      <div id="videoTabs" class="tabsContainer">
        <ul class="tabButtons">
          <li id="tabVote">
            <img src="./library/juicebox/thumbs/none.jpeg" height="24" width="32" class="thumb">
  
            <span class="voteActions">
              Did you like this picture ?
              <a id="voteYes" class="button btnVote withThumb">&nbsp;&nbsp;&nbsp;</a><a id="voteNo" class="button btnVote withThumb">&nbsp;&nbsp;&nbsp;</a>
            </span>
            
            <div class="ratingBarBlock">
              <div class="ratingBar">
                <div style="width:<?=$rate?>%;" id="ratingBarGood"></div>
              </div>
              <div class="ratingCounts">
                <span id="ratingGood"><?=$y_num?></span> Good, <span id="ratingBad"><?=$y_num?></span> Bad
              </div>
            </div>
            
            <span id="rating"><?=$rate?>%</span>
          </li>
        </ul>
      </div> <!-- #videoTabs -->
<?
}

