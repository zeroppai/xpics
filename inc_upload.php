<?
dispHeader();
?>
<script type="text/javascript">
  $(function(){
    var init = function(){
      $('#upload_tab').find('li').each(function(){
        var e = $(this);
        if(e.attr('class') != 'present' ){
          $(e.find('a').attr('href')).css('display','none');
        }
      });
    };

    $('#upload_tab').find('li').click(function(){
      var e = $(this);
      $('#upload_tab').find('li').removeClass('present');
      e.addClass('present');
      $(e.find('a').attr('href')).css('display','block');
      init();
    });
  });
</script>

<style>
#tab-wrapper div{
  width:500px;
}
#upload_tab li{
  width: 180px;
  float: left;
}
</style>
    <div id="main">


    <div id="content" class="signInUp">
      <form method="POST" id="signinForm">
        <div class="rightCol">
          <div class="tabHeaderForm notLoggedIn">
            <p>Beluga.fmと連携すると以下の機能がつかえます</p>
            <ul>
              <li>- アップロード制限</li>
              <li>- クォリティ評価</li>
              <li>- お気に入り追加</li>
              <li>- アーカイブ作成</li>
            </ul>
            <div class="formActions center signup">
              <a class="button" href="#">Belugaでアプリを認証する</a>
            </div>
          </div>
        </div>
      </form>

      <div id="tab-wrapper">
        <ul id="upload_tab" class="redStripe">
          <li class="present" ><a href="#uplaod1">Imgurl.comでアップロード</a></li>
          <li><a href="#uplaod2">Beluga.fmでアップロード</a></li>
        </ul>
        <div id="uplaod1">
          <form id="upload" method="POST" enctype="multipart/form-data">
            <fieldset>
              <legend>アップロード（上限は1ファイル2MB、1時間で50ファイルアップロード可能）</legend>
              <div class="formLine" style="margin-left:20px;">
                <input type="checkbox" id="make_archive" onchange="$('div.archive_form').toggle();"/><span class="check_label">同時にアーカイブを作成する</span>
                <div class="archive_form" style="display:none; margin-left:10px;">
                  <label>アーカイブ名</label>
                  <input type="text" id="archive_name" style="width:300px;" value=""/>
                </div>
                <div class="archive_form" style="display:none; margin-left:10px;">
                  <label>タグ(半角カンマで複数可能)</label>
                  <input type="text" id="archive_tags" style="width:200px;" value=""/>
                </div>
              </div>

              <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="300000" />
              <div>
                <label for="fileselect">Files to upload:</label>
                <input type="file" id="fileselect" name="fileselect[]" multiple="multiple" />
                <div id="filedrag">or drop files here</div>
              </div>

              <div id="submitbutton">
                <button type="button" id="uploadButton">Upload Files</button>
              </div>

            </fieldset>
          </form>
        </div>
        <div id="uplaod2">
        </div>
      <div id="uploadMessages"></div>
    </div>


    </div> <!-- #main -->
<script>
$('span.check_label').click(function(){
  var selected = $('#make_archive').attr('checked');
  $('#make_archive').attr('checked',!selected);
  $('div.archive_form').toggle();
});
<?
  if(isset($_GET['action'])&&$_GET['action']==='newArchive') echo "$('span.check_label').click()";
?>
</script>
<script src="./js/upload.js"></script>
<script src="./js/filedrag.js"></script>
<?
dispFooter();
?>