<? dispHeader(); ?>
<link rel="stylesheet" href="./js/xv-archive-styles.css"/>
<script>
  $(function() {
    // initialize scrollable
    $(".scrollable").scrollable();

    $('.items span').click(function(){
      var e = $(this);
      var m = $('.preview_form_id[name='+e.attr('class')+']');
      if(m.length>0){
        e.find('img').css('border','');
        m.remove();
      }else{
        e.find('img').css('border','medium solid #ff0000');
        $('<input type="hidden" class="preview_form_id" name="'+e.attr('class')+'" value="1"/>').appendTo('#preview_form');
      }
    });
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
        <strong>EDIT ARCHIVE</strong> - 基本情報設定
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
                </div>
              </div>
            </ul>
          </div>
        </div>

        <div class="formFields">
          <form action="./index.php?action=saveArchive&<?=$archive_params ?>" method="POST">
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
                <input name="archive_thumbnail" style="width: 300px;" id="archive_thumbnail" type="text" value="<?=$archive['thumbnail_url'] ?>" />
              </div>
            </div>
            <div class="formLine buttons" style="position: relative; overflow: visible; ">
              <div class="content">
                <input name="rate" type="hidden" value="<?=$archive['rate'] ?>"/>
                <input name="archive_id" type="hidden" value="<?=$archive['archive_id'] ?>"/>
                <button type="button" onclick="refresh()">サムネプレビュー</button>
                <button type="submit">変更保存</button>
              </div>
              <? if(isset($_SESSION['notice'])){ ?>
              <div class="content">
                <label style="color:#00aa00;"><?=$_SESSION['notice'];unset($_SESSION['notice']);?></label>
              </div>
              <? } ?>
            </div>
          </form>
        </div>
      </div> <!-- #content -->

      <div id="content_preview" class="preview" style="clear:left;">
        <div class="scrollPreview" style="clear:both;"> <!-- #scrollPreview -->
          <div class="redStripe">
            <strong>PREVIEW SLIDESHOW - 画像をクリックするとスライドショウから削除できます</strong>
          </div>

          <!-- "previous page" action -->
          <a class="prev browse left"></a>
           
          <!-- root element for scrollable -->
          <div class="scrollable" id="scrollable">
           
            <!-- root element for the items -->
            <div class="items">
            <?
            foreach($item_list as $i => $item){
              if($i%7===0) echo '<div>'.chr(10);
              echo '<span class="'.$item['page_id'].'"/>';
              echo '<a hoge="index.php?action=removePicture&page_id='.$item['page_id'].'&'.$archive_params.'"><img src="'.$item['thumbnail_url'].'"/></a>'.chr(10);            
              echo '</span>';
              if(($i+1)%7===0 || count($item_list)<=$i+1 ) echo '</div>'.chr(10);
            }
            ?>
            </div>

          </div>
          <!-- "next page" action -->
          <a class="next browse right"></a>
        </div><!-- #scrollPreview -->
        <div style="text-align:center;">
          <form id="preview_form" method="POST" action="index.php?action=removePicture&page_id='<?=$item['page_id'].'&'.$archive_params; ?>">
            <button type="submit">選択画像をアーカイブから削除する</button>
          <form>
        </div>
      </div>

      <div id="content_list" class="search" style="clear:left;">
        <div class="redStripe">
          <strong>ADD PICTURES - 画像をクリックしてファイルを追加します</strong>
        </div>
        <form action="./index.php?action=addPicture&<?=$archive_params ?>" method="POST">
          <? foreach ($items as $item) { ?>
          <div class="thumbBlock" id="picture_<?=$item['id']?>">
            <div class="thumbInside">
              <div class="thumb" onclick="$('input[name=picture_<?=$item['id']?>]').click();">
                <img src="<?=$item['thumbnail_url']?>" id="pic_<?=$item['id']?>">
              </div>

              <p class="metadata">
                <span class="bg">
                  <span class="duration">Quality:<?=$item['rate']?></span><br>
                  <input type="checkbox" name="picture_<?=$item['id']?>">
                  <label onclick="$('input[name=picture_<?=$item['id']?>]').click();">追加する</label>
                </span>
              </p>
            </div>
          </div>
        <? } ?>
        <div style="text-align:center;">
          <button type="submit">追加画像をアーカイブに保存する</button>
        </div>
      </form>

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