<? dispHeader(); ?>
<link rel="stylesheet" href="./css/xv-viewer-styles.css"/>
<div id="main">

  <h2><?
  echo $item['title'];
  if(isset($_GET['archive_id']) && isset($_SESSION['user']) ){
    echo '&nbsp;<button style="font-size:70%;" onclick="location.href=\'index.php?action=editArchive&archive_id='.h($_GET['archive_id']).'\';">編集</button>';
  }
  ?></h2>

  <ul id="video-tags">
    <li><em>Tags</em></li>
    <?foreach (explode(',', $item['tags']) as $val) {?>
      <li><a href="./tags/<?=$val?>"><?=$val?></a>, </li>
    <?}?>
      <li>more <a href="./tags/"><strong>タグ</strong></a>.</li>
  </ul>
  
  <div id="content">
    <div id="video-ad">
    </div>
    <!-- PLAYER FLASH -->
    <!-- NEW VERSION -->
    <div id="player" style="font-size:18px; color:black; font-weight: bold; background-color: #000000;">
        <!--START JUICEBOX EMBED-->
        <script src="library/juicebox/jbcore/juicebox.js"></script>
        <script type="text/javascript">
          var box = new juicebox({
            backgroundColor:'rgba(120,120,120,.9)',
            xbackgroundColor:'fff',
            containerid:'juicebox-container',
            galleryWidth:'588',
            galleryHeight:'476',
            themeUrl:'library/juicebox/jbcore/classic/theme.css',
            baseURL:'library/juicebox/',
            configUrl:'config.php'
        });
        </script>

        <div id="juicebox-container"></div>
        <!--END JUICEBOX EMBED-->
    </div>
    <!-- END PLAYER FLASH -->
  </div> <!-- #content -->
</div>
<? dispVoteTab(); ?>
<? dispPopCategory(); ?>
<? dispFooter(); ?>