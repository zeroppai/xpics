<?
dispHeader();
?>
    <div id="main">
      
      <div id="ads">
      </div> <!-- #ads -->
      
      <div class="redStripe">
        <strong>NEW PICTURES</strong> - These pictures are uploaded from beluga.fm.
      </div>
      <div id="content">
        <div class="mozaique">
        <?
          foreach ($items as $item) {
            dispImageThumbnail($item);
          }
        ?>
        </div> <!-- .mozaique -->
        
        <div class="pagination">
          <ul>
          <?
            if(isset($_GET['page']) && $_GET['page']>=0){
              if($_GET['page']>1) echo '<li><a class="nP" href="index.php?page='.($_GET['page']-1).'">Prev</a></li>';
              foreach (range(max($_GET['page']-7,0),min($page_max-$_GET['page'],14)) as $i) {
                echo '<li><a '.($_GET['page']==$i?'class="sel" ':'').'href="index.php?page='.$i.'">'.($i+1).'</a></li>';
              }
              echo '<li><a class="nP" href="">/</a></li>';
              echo '<li><a href="index.php?page='.count($page_max).'">'.(count($page_max)+1).'</a></li>';
              if($_GET['page']<count($page_max)) echo '<li><a class="nP" href="index.php?page='.($_GET['page']+1).'">Next</a></li>';
            }else{
              foreach (range(0,min($page_max,20)) as $i) {
                echo '<li><a href="index.php?page='.$i.'">'.($i+1).'</a></li>';
              }
            }
          ?>
          </ul>
        </div>
        
      </div> <!-- #content -->      
    </div> <!-- #main -->

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
dispFooter();
?>