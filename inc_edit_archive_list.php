<? dispHeader(); ?>
    <div id="main">
      
      <div id="ads">
      </div> <!-- #ads -->
      
      <div class="redStripe">
        <strong>EDIT ARCHIVE</strong>
      </div>
      <div id="content">
        <div class="mozaique">
        <? foreach ($items as $item) { ?>
          <div class="thumbBlock" id="archive_<?=$item['archive_id']?>">
            <div class="thumbInside">
              <div class="thumb">
                <a href="index.php?action=editArchive&archive_id=<?=$item['archive_id']?>" ><img src="<?=$item['thumbnail_url']?>" id="pic_<?=$item['archive_id']?>"></a>
              </div>

              <p class="metadata">
                <span class="bg">
                  <p><a href="index.php?action=editArchive&archive_id=<?=$item['archive_id']?>" ><?=$item['title']?></a></p>
                  <span class="duration">Quality:<?=$item['rate']?></span>
                </span>
              </p>
            </div>
          </div>
        <? } ?>
        </div> <!-- .mozaique -->
        
        <div class="pagination">
          <ul>
          <?
            if(isset($_GET['page']) && $_GET['page']>=0){
              if($_GET['page']>0) echo '<li><a class="nP" href="index.php?action=editArchive&page='.($_GET['page']-1).'">Prev</a></li>';
              foreach (range(max($_GET['page']-7,0),min($page_max,14)) as $i) {
                echo '<li><a '.($_GET['page']==$i?'class="sel" ':'').'href="index.php?action=editArchive&page='.$i.'">'.($i+1).'</a></li>';
              }
              echo '<li><a class="nP" href="">/</a></li>';
              echo '<li><a href="index.php?action=editArchive&page='.$page_max.'">'.($page_max+1).'</a></li>';
              if($_GET['page']<$page_max) echo '<li><a class="nP" href="index.php?action=editArchive&page='.($_GET['page']+1).'">Next</a></li>';
            }else{
              foreach (range(0,min($page_max,20)) as $i) {
                echo '<li><a href="index.php?action=editArchive&page='.$i.'">'.($i+1).'</a></li>';
              }
            }
          ?>
          </ul>
        </div>
        
      </div> <!-- #content -->      
    </div> <!-- #main -->

    <? dispPopCategory(); ?>
    
<? dispFooter(); ?>