<?
dispHeader();
?>
<script>
  $(function() {
    // initialize scrollable
    $(".scrollable").scrollable();
  });
  function refresh(){
    $('#thumbnail_title').html($('#archive_title').attr('value'));
    $('#preview_thumbnail').attr('src',$('#archive_thumbnail').attr('value'));
  };
</script>
    <div id="main">
      <div id="content" class="signInUp">
        <div class="rightCol">
          <div class="tabHeaderForm">
            <ul>
              <div class="mozaique">
              <div class="thumbBlock" style="width:300px;">
              <strong>サムネイルプレビュー</strong>
                <div class="thumbInside">
                  <div class="thumb">
                    <img src="./img/none.jpeg" id="preview_thumbnail"/>
                  </div>

                  <p class="metadata">
                    <span class="bg">
                      <p id="thumbnail_title"></p>
                      <span class="duration" id="thumbnail_rate">Quality:1.0</span>
                    </span>
                  </p>
                </div>
              </div>
            </ul>
          </div>
        </div>

        <div class="formFields">
          <form action="./index.php?action=saveNewArchive" method="POST">
          <div class="formLine titlr" style="position: relative; overflow: visible; ">
            <label for="archive_title">Archive Title:</label>
            <div class="content">
              <input name="archive_title" style="width: 300px;" id="archive_title" type="text" value="" >
            </div>
          </div>
          <div class="formLine tags" style="position: relative; overflow: visible; ">
            <label for="archive_tags">Archive Tags:</label>
            <div class="content">
              <input name="archive_tags" style="width: 300px;" id="archive_tags" type="text" value="" >
            </div>
          </div>
          <div class="formLine thumbnail" style="position: relative; overflow: visible; ">
            <label for="archive_thumbnail">Archive Thumbnail:</label>
            <div class="content">
              <input name="archive_thumbnail" style="width: 300px;" id="archive_thumbnail" type="text" value="./img/none.jpeg" />
            </div>
          </div>
          <div class="formLine buttons" style="position: relative; overflow: visible; ">
            <div class="content">
              <button type="button" onclick="refresh()">サムネプレビュー</button>
              <button type="submit">変更保存</button>
            </div>
          </div>
          </form>
        </div>

      </div> <!-- #content -->
    </div> <!-- #main -->
<?
dispFooter();
?>