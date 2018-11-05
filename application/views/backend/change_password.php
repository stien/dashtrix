<?php require_once("common/header.php");?>
    <div class="fullcontent right clear">
      <form name="category" id="category" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/change_password_submit/">
        <div class="dev-col-1 colbg left">
          <div class="ContentDiv">
            <h1>Change Password</h1>
            
            <div class="formwrap">
              <label> Old Password: </label>
              <input type="password" value="" placeholder="Old Password" required name="oldpass" id="oldpass" />
            </div>
            <div class="formwrap">
              <label> New Password: </label>
              <input type="password" value="" required name="newpass" id="newpass" />
            </div>
         
            
            <div class="formwrap">
              <input type="reset" value="Reset" name="submit" id="submit" class="btn btn-lg btn-red right" style="margin:0" />
             
              <input type="submit" value="Update Password" name="submit" id="submit" class="btn btn-lg btn-green right"  style="margin:0; margin-right:5px;" />
            </div>
          </div>
        </div>
      </form>
    </div>
    <?php require_once("common/footer.php"); ?>
