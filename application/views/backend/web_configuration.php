<?php require_once("common/header.php");?>
<div class="fullcontent right clear">
    <div class="dev-col-1 colbg left">
            <div class="ContentDiv">
              <h1>Website Configuration</h1>
              <form name="category" id="category" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/configuration/">
              <?php foreach($web_config as $valconfig):?>
                <div class="formwrap">
                  <label> Website Title: </label>
                  <input type="text" value="<?php echo $valconfig->configTitle; ?>" required name="webTitle" id="webTitle" />
                </div>
                <div class="formwrap">
                  <label> Meta Description: </label>
                  <input type="text" value="<?php echo $valconfig->configDescrip; ?>" required name="webDescp" id="webDescp" />
                </div>
                <div class="formwrap">
                  <label> Meta keywords: </label>
                  <input type="text" value="<?php echo $valconfig->configKeyword; ?>" required name="webKeys" id="webKeys" />
                </div>
                <div class="formwrap">
                  <label> Phone: </label>
                  <input type="text" value="<?php echo $valconfig->configPhone; ?>" required name="webPhone" id="webPhone" />
                </div>
                <div class="formwrap">
                  <label> Email Address: </label>
                  <input type="email" value="<?php echo $valconfig->configEmail; ?>" required name="webEmail" id="webEmail" />
                </div>
                <div class="formwrap">
                  <label>Address: </label>
                  <input type="text" value="<?php echo $valconfig->configAddress; ?>" required name="webAddress" id="webAddress" />
                </div>
                <div class="formwrap">
                  <label>Copyright Information: </label>
                  <input type="text" value="<?php echo $valconfig->configCopy; ?>" required name="webCopy" id="webCopy" />
                </div>
                <div class="formwrap">
                  <label>Facebook: </label>
                  <input type="text" value="<?php echo $valconfig->configFacebook; ?>" name="webFacebook" id="webFacebook" />
                </div>
                <div class="formwrap">
                  <label>Twitter: </label>
                  <input type="text" value="<?php echo $valconfig->configTwitter; ?>" name="webTwitter" id="webTwitter" />
                </div>
                <div class="formwrap">
                  <label>Google+: </label>
                  <input type="text" value="<?php echo $valconfig->webGoogle; ?>" name="webGoogle" id="webGoogle" />
                </div>
                <div class="formwrap">
                  <label>LinkedIn: </label>
                  <input type="text" value="<?php echo $valconfig->webLkndIn; ?>" name="webLkndIn" id="webLkndIn" />
                </div>
                <div class="formwrap">
                  <label>Youtube: </label>
                  <input type="text" value="<?php echo $valconfig->webYouTube; ?>" name="webYouTube" id="webYouTube" />
                </div>
                <div class="formwrap">
                  <label>Pintrest: </label>
                  <input type="text" value="<?php echo $valconfig->webPintrest; ?>" name="webPintrest" id="webPintrest" />
                </div>
                <div class="formwrap">
                  <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-lg btn-green right" />
                </div>
               <?php endforeach;?>
              </form>
            </div>
          </div> 
</div>      
<?php require_once("common/footer.php"); ?>