<?
dispHeader();
?>
    <div id="main">


    <div id="content" class="signInUp">
      <h2 class="blackTitle">Login to your xvideos.com account</h2>

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

        <div class="formFields">
          <input type="hidden" name="referer" value="http://info.xvideos.com/">
            <div class="formFields">
              <div class="formLine email" style="position: relative; overflow: visible; ">
                <label for="email_text">Your login (email):</label>
                <div class="content">
                  <input name="login" id="email_text" type="text" value="" data-validation="{&quot;parent&quot;:&quot;.formLine&quot;,&quot;events&quot;:[&quot;keyup&quot;,&quot;blur&quot;],&quot;rules&quot;:[{&quot;name&quot;:&quot;notblank&quot;},{&quot;name&quot;:&quot;email&quot;}]}">
                </div>
              <div class="formTooltip" style="left: 416px; top: 2px; display: none; "><div class="arrow"></div><div class="text">Test</div></div></div>
              <div class="formLine password" style="position: relative; overflow: visible; ">
            <label for="password_text">Password:</label>
            <div class="content">
              <input name="password" id="password_text" type="password" data-validation="{&quot;parent&quot;:&quot;.formLine&quot;,&quot;rules&quot;:[{&quot;name&quot;:&quot;min&quot;,&quot;min&quot;:5}]}">
            </div>
            <div class="formTooltip" style="left: 416px; top: 2px; display: none; "><div class="arrow"></div><div class="text">Test</div></div></div>
            <div class="formLine rememberme">
            <div class="content">
              <span>
                <input name="rememberme" id="rememberme_checkbox" type="checkbox">
                <label for="rememberme_checkbox">Remember me on this computer</label>
              </span>
            </div>
          </div>
            </div>
          <div class="formActions center">
            <p><input type="submit" value="Login to your account" name="log"></p>
            <p><a href="/account/lostpassword">Forgot your password ?</a></p>
          </div>    
        </div>
      </form>

  </div>


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