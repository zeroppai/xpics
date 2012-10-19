<? dispHeader(); ?>
<link rel="stylesheet" href="http://static.xvideos.com/v2/css/xv-video-styles.css">
<div id="main">

      <h2><?=$item['title']?></h2>
    
      <ul id="video-tags">
        <li><em>Tags</em></li>
          <li><a href="/tags/facial">facial</a>, </li>
          <li>more <a href="/tags/"><strong>タグ</strong></a>.</li>
      </ul>
      
      <div id="content">
        <div id="video-ad">
        </div>
        <!-- PLAYER FLASH -->
        <!-- NEW VERSION -->
        <div id="player" style="font-size:18px; color:black; font-weight: bold; background-color: #000000;">
            <!--START JUICEBOX EMBED-->
            <script src="library/juicebox/jbcore/juicebox.js"></script>
            <script>
                new juicebox({
                    backgroundColor:'rgba(120,120,120,.9)',
                    xbackgroundColor:'fff',
                    containerid:'juicebox-container',
                    galleryWidth:'588',
                    galleryHeight:'476',
                    themeUrl:'library/juicebox/jbcore/classic/theme.css',
                    baseURL:'library/juicebox/'
                  });
            </script>
            <div id="juicebox-container"></div>
            <!--END JUICEBOX EMBED-->
        </div>
        <!-- END PLAYER FLASH -->
        
      </div> <!-- #content -->
      
      <? dispVoteTab(); ?>

    </div>

    <? dispPopCategory(); ?>

<? dispFooter(); ?>