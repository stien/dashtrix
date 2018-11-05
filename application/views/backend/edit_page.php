<?php require_once("common/header.php");?>
<div class="fullcontent right clear">
    <div class="dev-col-1 colbg left">
            <div class="ContentDiv">
              <h1>Update Page Information</h1>
            <?php 
				if(isset($_GET['type']) && $_GET['type'] == 'edit' && isset($_GET['pID'])) {
			?>
              <form name="category" id="category" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/update_page/">
              <?php foreach($showpagecontent as $page): ?>
                <div class="formwrap">
                  <label> Page Heading: </label>
                  <input type="text" value="<?php echo $page->pHeading; ?>" required name="pageHeading" id="pageHeading" />
                  <input type="hidden" value="<?php echo $page->pID; ?>" required name="pID" id="pID" />
                </div>
                <div class="formwrap">
                  <label> Page Meta Title: </label>
                  <input type="text" value="<?php echo $page->pTitle; ?>" required name="pageMeta" id="pageMeta" />
                </div>
                <div class="formwrap">
                  <label> Page Meta Description: </label>
                  <input type="text" value="<?php echo $page->pDescp; ?>" required name="pageDescp" id="pageDescp" />
                </div>
                <div class="formwrap">
                  <label> Page Meta keywords: </label>
                  <input type="text" value="<?php echo $page->pKeyword; ?>" required name="pageKeys" id="pageKeys" />
                </div>
               <div class="formwrap" style="display:none;">
                  <label> Page Link: </label>
                  <input type="text" readonly value="<?php echo $page->pLink; ?>" required name="pageLink" id="pageLink" />
               </div>
               <div class="formwrap">
                  <label> Page Content: </label>
                  <textarea name="pageContent" id="texteditor" class="textarea"><?php echo $page->pContent; ?></textarea>
                </div>
             <div class="formwrap">
              <label> Status: </label>
              <input type="radio" name="catStatus" id="catStatus" <?php if($page->pStatus == 1){echo 'checked';} ?> value="1" />
              <span>Active</span>
              <input type="radio" name="catStatus" id="catStatus" <?php if($page->pStatus == 0){echo 'checked';} ?> value="0" />
              <span>In-Active</span> </div>
            <div class="formwrap">
                  <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-lg btn-green right" />
            </div>
           <?php endforeach; ?>
              </form>
        <?php } else { echo 'Invalid Url';} ?>
            </div>
          </div> 
</div>      
<?php require_once("common/footer.php"); ?>