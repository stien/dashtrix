<?php 
ob_start();
error_reporting(0);
require_once("common/header.php");
?>

<div id="loginbx">
  <div class="container">
    <div class="col-xs-9 bxlogin nopad">
      <div class="login-inner2 left col-xs-5" style="min-height:282px;">
        <h2>Recruiter Login
          <div id="logingbar" class="right"></div>
        </h2>
        <?php if(isset($_SESSION['msglogin'])){?>
        <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
        <?php } ?>
       <form name="signupform" id="signupform" action="<?php echo base_url(); ?>do/login/recruiter" method="post" onsubmit="return buttondisabled()">
          <div class="col-xs-12 nopad boxinput">
            <input type="email" name="emailadd" id="emailadd" required class="inputjob" placeholder="Email Address">
          </div>
          <div class="col-xs-12 nopad boxinput">
            <input type="password" name="passlogin" id="passlogin" required class="inputjob" placeholder="Password">
          </div>
          <div class="col-xs-12 nopad boxinput">
          	<div class="col-xs-5 nopad">
            <input type="text" name="secruityCode" id="secruityCode" required class="inputjob" placeholder="Security Code">
            </div>
            <div class="col-xs-5">
            	<i class="fa fa-question infoquestion" id="tooltip" style="cursor:pointer;" title="You would have been given a 4 digit security code in your email address during registration. In case you do not remember the security code details, it will be provided when you request for a password reset."></i>
            </div>
          </div>
          <div class="col-xs-12 nopad boxinput">
           <button type="submit" name="signup" id="signypbutton" class="btn pink left">Login</button> <div class="right loglnk"><a href="javascript:;" onclick="forgotpassword()">Forgot security code or password?</a></div>
          </div>
          </form>
          <!--FORGOT PASSWORD-->
          <div id="passforgot" style="display:none;">
          	<p class="parag" style="font-size:11px; padding-top:10px;">Enter your email address to request a new password.</p>
            <form name="signupform" id="signupform" action="<?php echo base_url(); ?>jobsite/jobsite_forgotpass_recruiter" method="post">
          	<div class="col-xs-12 nopad boxinput">
            <input type="email" name="forgotemail" id="forgotemail" required class="inputjob" placeholder="Enter your Email Address">
          	</div>
            <div class="col-xs-12 nopad boxinput">
           <button type="submit" name="signup" id="signupbtn" class="btn pink right">Reset Password</button> 
          </div>
          </form>
          </div>
      </div>
      
      <!--Sectors-->
      <div class="login-inner2 left col-xs-6">
        <div class="imagenotregistered">
        	<img src="<?php echo base_url(); ?>resources/frontend/images/not-registered.svg" alt="Not Logged In" />
        </div>
        <p style=" text-align:center;" class="parag partop">Not yet registered?</p>
        <p style=" text-align:center;" class="parag partop">
        	If you'd like to find out more about how jobsite cann help you with your recruitment needs, please complete this <a href="javscript:;" onclick="enquiryform()"><strong style="color:#0098cc">enquiry form</strong></a>.
        </p>
        <a href="<?php echo base_url(); ?>post-job"><button name="postjob" style="width:100%;" class="btn pink">POST JOB / SIGN UP</button></a>
        
      </div>
    </div>
  </div>
</div>

<?php require_once("common/footer.php");?>
<script language="javascript">
$('#secruityCode').keyup(function() {
   if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});
function checkspaces(val){
	if ( $.trim( $('#'+val).val() ) == '' )
    {
		$("#"+val).val('');
	}
}
function forgotpassword(){
	 var x = document.getElementById('passforgot');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
}
</script>
<style>
.infoquestion {  background: #f0f0f0;
  padding: 4px 7px;
  border-radius: 78%;
  margin-top: 8px;}
  #boxmesageemail { display:none;}
</style>

<style>
.enqinput label {float: left !important;  margin-top: 11px;

  width: 25% !important;}
.enqfr {width: 75% !important;
  float: left !important;}
  .rightpop {
  position: absolute !important;
  background: #fff;
  border: 3px solid #D2D2D2;
  z-index: 1;
  left: 47% !important;
  margin-left: -216px !important;
  top: 8% !important;
  right: 26% !important;
  padding: 15px;
}
 .ui-tooltip, .arrow:after {
    background: #2a2a2a !important;
    border: 2px solid white;
	color:#fff !important;
  }
  .ui-tooltip {
    padding: 10px 20px;
    color: #fff !important;
    border-radius: 5px;
	font-size:12px !important;
  }
  .arrow {
    width: 70px;
    height: 16px;
    overflow: hidden;
    position: absolute;
    left: 50%;
    margin-left: -35px;
    bottom: -16px;
  }
  .arrow.top {
    top: -16px;
    bottom: auto;
  }
  .arrow.left {
    left: 20%;
  }
  .arrow:after {
    content: "";
    position: absolute;
    left: 20px;
    top: -20px;
    width: 25px;
    height: 25px;
    box-shadow: 6px 5px 9px -9px black;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }
  .arrow.top:after {
    bottom: -20px;
    top: auto;
  }
</style>


<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $("#tooltip").tooltip({
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });
  } );
  function buttondisabled(){
	$("#signypbutton").attr("diabled",true);
	$("#signypbutton").html('Please wait...');
	
}
  </script>
