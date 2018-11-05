<?php require_once("common/header.php");?>
<div id="loginbx">
  <div class="container">
    <div class="col-md-12 bxlogin nopad">
      <div class="login-inner left">
        <h2><?php echo $pages[0]->pHeading;?></h2>
        <div class="pagecontent" style="text-align: justify;"> 
        	<?php echo $pages[0]->pContent;?>
        </div>
        <?php if($this->uri->segment(1) == "contact-us"){
		?>
        <?php if(isset($_SESSION['msglogin'])){?>
        <div class="errormsg clear"><?php echo $_SESSION['msglogin'];?></div>
        <?php } ?>
        <form name="signupform" id="signupform" action="<?php echo base_url(); ?>do/contact" method="post" class="clear left" style="margin-top:10px;">
          <div class="col-xs-12 nopad boxinput">
            <input type="text" name="fname" id="fname" required class="inputjob" placeholder="First Name">
          </div>
          <div class="col-xs-12 nopad boxinput">
            <input type="text" name="lname" id="lname" required class="inputjob" placeholder="Last Name">
          </div>
          <div class="col-xs-12 nopad boxinput">
            <input type="email" name="emailadd" id="emailadd" required class="inputjob" placeholder="Email Address">
          </div>
          <div class="col-xs-12 nopad boxinput">
            <select name="type" id="type" class="inputjob ">
              <option value="General" selected>General</option>
              <option value="Website">Website</option>
              <option value="Others">Others</option>
            </select>
          </div>
          <div class="col-xs-12 nopad boxinput">
            <textarea name="messagequery" id="messagequery" required class="inputjob textarea" placeholder="Type your query/message here"></textarea>
          </div>
         
          <div class="col-xs-12 nopad boxinput">
            <button type="submit" name="signup" id="signupbtn" class="btn pink">Contact Us</button>
            
          </div>
        </form>
        <?php
		}
		?>
      </div>
    </div>
  </div>
</div>
<?php require_once("common/footer.php");?>
