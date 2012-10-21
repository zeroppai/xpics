<? dispHeader(); ?>
<link rel="stylesheet" href="./js/xv-archive-styles.css"/>
<script>
  $(function() {
    // initialize scrollable
    $(".scrollable").scrollable();
  });
  function refresh(){
    $('#thumbnail_title').html($('#archive_title').attr('value'));
    $('#thumbnail_<?=$archive["archive_id"]?>').attr('src',$('#archive_thumbnail').attr('value'));
  };
</script>
    <div id="main">
      
      <div id="ads">
      </div> <!-- #ads -->
      
      <div class="redStripe">
        <strong>EDIT ARCHIVE</strong> - These pictures are uploaded from beluga.fm.
      </div>
      <div id="content" class="signInUp">
        <div class="rightCol">
          <div class="tabHeaderForm">
            <ul>
              <div class="mozaique">
              <div class="thumbBlock" style="width:300px;" id="archive_<?=$archive['archive_id']?>">
              <strong>サムネイルプレビュー</strong>
                <div class="thumbInside">
                  <div class="thumb">
                    <img src="<?=$archive['thumbnail_url']?>" id="thumbnail_<?=$archive['archive_id']?>"/>
                  </div>

                  <p class="metadata">
                    <span class="bg">
                      <p id="thumbnail_title"><?=$archive['title']?></p>
                      <span class="duration" id="thumbnail_rate">Quality:<?=$archive['rate']?></span>
                    </span>
                  </p>
                </div>
                <button onclick="refresh()">更新</button>
              </div>
            </ul>
          </div>
        </div>

        <div class="formFields" onchange="refresh()">
          <div class="formLine titlr" style="position: relative; overflow: visible; ">
            <label for="archive_title">Archive Title:</label>
            <div class="content">
              <input name="archive_title" style="width: 300px;" id="archive_title" type="text" value="<?=$archive['title'] ?>" >
            </div>
          </div>
          <div class="formLine tags" style="position: relative; overflow: visible; ">
            <label for="archive_tags">Archive Tags:</label>
            <div class="content">
              <input name="archive_tags" style="width: 300px;" id="archive_tags" type="text" value="<?=$archive['tags'] ?>" >
            </div>
          </div>
          <div class="formLine thumbnail" style="position: relative; overflow: visible; ">
            <label for="archive_thumbnail">Archive Thumbnail:</label>
            <div class="content">
              <input name="archive_thumbnail" style="width: 300px;" id="archive_thumbnail" type="text" value="<?=$archive['thumbnail_url'] ?>" >
            </div>
          </div>
        </div>

      </div> <!-- #content -->


      <div class="scrollPreview"> <!-- #scrollPreview -->
        <div class="redStripe">
          <strong>PREVIEW SLIDESHOW</strong>
        </div>

        <!-- "previous page" action -->
        <a class="prev browse left"></a>
         
        <!-- root element for scrollable -->
        <div class="scrollable" id="scrollable">
         
          <!-- root element for the items -->
          <div class="items">
         <?
         foreach($item_list as $i => $item){
            if($i%7===0){
              echo '<div>'.chr(10);
            }
            echo '<a href="index.php?action=removePicture&archive_id='.h($_GET['archive_id']).'&picture_id='.$item['id'].'&page='.h($_GET['page']).'" target="_blank"><img src="'.$item['thumbnail_url'].'"/></a>'.chr(10);
            if(($i+1)%7===0 || count($item_list)<=$i+1 ){
              echo '</div>'.chr(10);
            }
          }
          ?>
          </div>

        </div>
        <!-- "next page" action -->
        <a class="next browse right"></a>
      </div><!-- #scrollPreview -->

      <div id="content_list" class="search" style="margin-top: 120px; clear:left;">
        <div class="redStripe">
          <strong>ADD PICTURES</strong>
        </div>
          <? foreach ($items as $item) { ?>
          <div class="thumbBlock" id="picture_<?=$item['id']?>">
            <div class="thumbInside">
              <div class="thumb">
                <a href="index.php?action=addPicture&archive_id=<?=h($_GET['archive_id']).'&picture_id='.$item['id'].'&page='.h($_GET['page'])?>" ><img src="<?=$item['thumbnail_url']?>" id="pic_<?=$item['id']?>"></a>
              </div>

              <p class="metadata">
                <span class="bg">
                  <span class="duration">Quality:<?=$item['rate']?></span>
                </span>
              </p>
            </div>
          </div>
        <? } ?>

        <div class="pagination" style="clear:left;">
          <ul>
          <?
            if(isset($_GET['page']) && $_GET['page']>=0){
              if($_GET['page']>0) echo '<li><a class="nP" href="index.php?'.gu('action,archive_id').'&page='.($_GET['page']-1).'">Prev</a></li>';
              foreach (range(max($_GET['page']-7,0),min($page_max,14)) as $i) {
                echo '<li><a '.($_GET['page']==$i?'class="sel" ':'').'href="index.php?'.gu('action,archive_id').'&page='.$i.'">'.($i+1).'</a></li>';
              }
              echo '<li><a class="nP" href="">/</a></li>';
              echo '<li><a href="index.php?'.gu('action,archive_id').'&page='.$page_max.'">'.($page_max+1).'</a></li>';
              if($_GET['page']<$page_max) echo '<li><a class="nP" href="index.php?'.gu('action,archive_id').'&page='.($_GET['page']+1).'">Next</a></li>';
            }else{
              foreach (range(0,min($page_max,20)) as $i) {
                echo '<li><a href="index.php?'.gu('action,archive_id').'&page='.$i.'">'.($i+1).'</a></li>';
              }
            }
          ?>
          </ul>
        </div>
      </div> <!-- #content -->
    </div> <!-- #main -->

    <? dispPopCategory(); ?>
    
<? dispFooter(); ?>