<?
dispHeader();
?>
    <div id="main">


    <div id="content" class="signInUp">
      <h2 class="blackTitle">Upload your pictures</h2>

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

      <form id="upload" method="POST" enctype="multipart/form-data">
        <fieldset>
          <legend>File Upload（同時に大量にアップロードすると失敗することがあります）</legend>

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

      <div id="uploadMessages"></div>
    </div>


    </div> <!-- #main -->

<script src="./js/upload.js"></script>
<script src="./js/filedrag.js"></script>
<?
dispFooter();
?>