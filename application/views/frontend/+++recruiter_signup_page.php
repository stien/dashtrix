<?php 
ob_start();
error_reporting(0);
require_once("common/header.php");
?>

<div id="loginbx">
  <div class="container">
    <div class="col-xs-10 bxlogin nopad">
      <div class="login-inner2 left col-xs-6" style="min-height: 410px;">
        <h2>Recruiter Sign up
          <div id="logingbar" class="right"></div>
        </h2>
        <?php if(isset($_SESSION['msglogin'])){?>
        <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
        <?php } ?>
       <form name="signupform" id="signupform" action="<?php echo base_url(); ?>jobsite/signup_recruiter_submit" method="post" onsubmit="return checksubmitdata()">
      	  <div class="col-xs-12 nopad boxinput">
            <input type="text" name="companyurl" id="companyurl" required class="inputjob" onBlur="domainchecker()" placeholder="Company Website" value="<?php if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['companyurl'];} else {echo "www.";}?>" autocomplete="off">
            <div id="companystatus" class="weak-password" style="display:none;"></div>
          </div>
          <div class="col-xs-12 nopad boxinput">
            <input type="text" name="companyName" id="companyName" onBlur="checkspaces('companyName')" required class="inputjob" placeholder="Company Name" value="<?php if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['companyName'];} else {echo "";}?>">
          </div>
          <div class="col-xs-12 nopad boxinput">
            <div class="col-xs-7 nopad">
            	<input type="text" name="emailaddpay" id="emailaddpay" onBlur="checkspaces('emailaddpay')" required class="inputjob" placeholder="Email Address">
            </div>
            <div class="col-xs-5 nopad">
            <input type="text" readonly="readonly" style="background:#f0f0f0;" name="domainname" id="domainname" required class="inputjob">
            </div>
           
          </div>
          <div class="col-xs-12 nopad boxinput">
            <div class="col-xs-10 nopad"><input type="password" name="passwordlogin" onKeyUp="passwordcheckerjobsite()" onfocus="showboxpassinfo()" id="passwordlogin" onBlur="checkspaces('passwordlogin')" required class="inputjob" placeholder="Create Password">
            <div id="passinfobx" style="display:none;">
                	<h2>Your password must</h2>
                	<div id="minlength" class="caseletter"><i class="fa fa-check-circle-o"></i> Be Atleast 6 characters</div>
                    <div id="upcase"  class="caseletter"><i class="fa fa-check-circle-o"></i> Include an uppercase letter</div>
                    <div id="lowcase"  class="caseletter"><i class="fa fa-check-circle-o"></i> Include a lower letter</div>
                    <div id="numberlength" class="caseletter"><i class="fa fa-check-circle-o"></i> Include a number</div>
                    <div id="specialcase" class="caseletter"><i class="fa fa-check-circle-o"></i> Include a Special Character</div>
                </div>
            </div>
            <div class="col-xs-2">
            <i class="fa fa-question infoquestion" id="tooltip" style="cursor:pointer;" title="Please create a password that is a combination of letters, numbers and special characters."></i>
            </div>
            <div id="password-strength-status"></div>
          </div>
          <div class="col-xs-12 nopad boxinput">
            <div class="col-xs-3 nopad">
            	<select class="inputjob" id="id_std_code" maxlength="3" style="  padding: 9px;" name="country_code" required >
                	<option value="">- Code -</option>
                <?php
					$arrcode = array();
					$configcode	= $this->front_model->get_query_simple('*','country_codes',$arrcode);
					$cacode 	= $configcode->result_object();
					foreach($cacode as $concode):
				?>
				  <option value="<?php echo $concode->phonecode;?>" <?php if($concode->phonecode == $countrycode){echo "SELECTED";}?>><?php echo $concode->iso;?> - <?php echo $concode->phonecode;?></option>
                <?php
					endforeach;
				?>
				</select>
            </div>
            <div class="col-xs-9 nopad">
            <input type="text" name="contactnumber" id="contactnumber" onBlur="checkspaces('contactnumber')" required class="inputjob" placeholder="Mobile/Landline Number" value="<?php if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['contactnumber'];} else {echo "";}?>">
            </div>
          </div>
          <div class="col-xs-12 nopad boxinput">
                <select name="sectorindustry[]" id="sectorindustry" class="inputjob" required multiple="multiple">
                  <option value="">--- Select Sector/Industry ---</option>
                  <?php
				  	$arrset3      = array('catStatus' => 1);
					$configset3   = $this->front_model->get_query_simple('*','dev_web_categories',$arrset3);
					$set		= $configset3->result_object();
					foreach($set as $sects):
				  ?>
                  <option value="<?php echo $sects->cID;?>"><?php echo $sects->catName;?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-xs-12 nopad boxinput">
              <select name="countryrecruit" id="countryrecruit" multiple="multiple" required class="searchin">
              <option value="">--- Select Country ---</option>
              <?php 
			  	$arrcn = array();
				$configcn 	= $this->front_model->get_query_simple('*','dev_web_countries',$arrcn);
				$countries 	= $configcn->result_object();
			  	foreach($countries as $country):?>
              		<option value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
              	<?php endforeach; ?>
          		</select>
              </div>
          <div class="col-xs-12 nopad boxinput">
           <button type="submit" name="signup" id="signupbtn" class="btn pink left">Sign up</button>
          </div>
          </form>
         
      </div>
      
      <!--Sectors-->
      <div class="login-inner2 left col-xs-5" style="min-height: 410px;">
      	<h2>Already Registered? Login here
          <div id="logingbar" class="right"></div>
        </h2>
        <form name="signupform" id="signupform" action="<?php echo base_url(); ?>do/login/recruiter" method="post">
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
           <button type="submit" name="signup" id="signupbtn" class="btn pink left">Login</button> <div class="right loglnk"><a href="javascript:;" onclick="forgotpassword()">Forgot security code or password?</a></div>
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
       <button type="submit" name="signup" id="signupbtn" class="btn pink left">Reset Password</button> 
      </div>
      </form>
      </div>
      </div>
    </div>
  </div>
</div>
<?php unset($_SESSION['wrongsignup']);?>
<?php require_once("common/footer.php");?>
<script language="javascript">
function showboxpassinfo(){
	var number = /([0-9])/;
	var alphabetssmall = /([a-z])/;
	var alphabetsupper = /([A-Z])/;
	var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
	if($('#passwordlogin').val().length>6 && $('#passwordlogin').val().match(number) && $('#passwordlogin').val().match(alphabetssmall) && $('#passwordlogin').val().match(alphabetsupper) && $('#passwordlogin').val().match(special_characters)){} else {
	$("#passinfobx").show();
	}
}
function passwordcheckerjobsite()
{
	var number = /([0-9])/;
	var alphabetssmall = /([a-z])/;
	var alphabetsupper = /([A-Z])/;
	var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
	if($('#passwordlogin').val().length>6) {
		$("#minlength i").addClass('greentick');
		$("#minlength").fadeOut();
	}
	else {
		$("#minlength i").removeClass('greentick');
		$("#minlength").fadeIn();
	}
	if($('#passwordlogin').val().match(number)){
		$("#numberlength i").addClass('greentick');
		$("#numberlength").fadeOut();
	} else {
		$("#numberlength i").removeClass('greentick');
		$("#numberlength").fadeIn();
	}
	if($('#passwordlogin').val().match(alphabetssmall)){
		$("#lowcase i").addClass('greentick');
		$("#lowcase").fadeOut();
	}
	else {
		$("#lowcase i").removeClass('greentick');
		$("#lowcase").fadeIn();
	}
	if($('#passwordlogin').val().match(alphabetsupper)){
		$("#upcase i").addClass('greentick');
		$("#upcase").fadeOut();
	}
	else {
		$("#upcase i").removeClass('greentick');
		$("#upcase").fadeIn();
	}
	if($('#passwordlogin').val().match(special_characters)){
		$("#specialcase i").addClass('greentick');
		$("#specialcase").fadeOut();
	}
	else {
		$("#specialcase i").removeClass('greentick');
		$("#specialcase").fadeIn();
	}
	
	if($('#passwordlogin').val().length>6 && $('#passwordlogin').val().match(number) && $('#passwordlogin').val().match(alphabetssmall) && $('#passwordlogin').val().match(alphabetsupper) && $('#passwordlogin').val().match(special_characters)){
		$("#passinfobx").hide();
	}
	else {
			$("#passinfobx").show();
	}
}
$('#contactnumber').keyup(function() {
  if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});
function domainchecker()
{
	var url = $("#companyurl").val();
	if(url == "www."){} else {
	var urlAux = url.split('www.');
	var urlval = urlAux[1]
	$("#domainname").val("@"+urlval);
	}
}
$("#companyurl").on("keyup",function(e){
	if($("#companyurl").val() == ""){
		$("#companystatus").html('');
		$("#companystatus").hide();
	}
	 else {
		 	if(e.which === 32) {
			$("#companystatus").html('space are not allowed in URL!');
			$("#companystatus").show();
            var str = $(this).val();
            str = str.replace(/\s/g,'');
            $(this).val(str);            
    	}
		else if(e.which === 50) {
            var str = $(this).val();
            str = str.replace(/\@/g,'');
            $(this).val(str);  
		}
	else {
	var regex = new RegExp("^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?"); 
var without_regex = new RegExp("^(www\\.)([0-9A-Za-z-\\.:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?");
var str = $("#companyurl").val();
if(regex.test(str) || without_regex.test(str)){
    $("#companystatus").html('');
	$("#companystatus").hide();
}else{
	$("#companystatus").html('Please provide URL only e.g: (www.google.com or http://www.google.com)');
	$("#companystatus").show();
}
	}}
});
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
	$("#passinfobx").hide();
}
function forgotpassword(){
	 var x = document.getElementById('passforgot');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
}
function checkPasswordStrength() {
	if($("#passwordlogin").val() == ""){
		$("#password-strength-status").fadeOut();
	}
	else {
var number = /([0-9])/;
var alphabets = /([a-zA-Z])/;
var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
if($('#passwordlogin').val().length<6) {
	$("#password-strength-status").fadeIn();
$('#password-strength-status').removeClass();
$('#password-strength-status').addClass('weak-password');
$('#password-strength-status').html("Weak Password (should be atleast 6 characters.)");
} else {  	
if($('#passwordlogin').val().match(number) && $('#passwordlogin').val().match(alphabets) && $('#passwordlogin').val().match(special_characters)) {            
$("#password-strength-status").fadeIn();
$('#password-strength-status').removeClass();
$('#password-strength-status').addClass('strong-password');
$('#password-strength-status').html("Strong Password");
} else {
	$("#password-strength-status").fadeIn();
$('#password-strength-status').removeClass();
$('#password-strength-status').addClass('medium-password');
$('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
}}}}
$('#companyName').keyup(function() {
  if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
    this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
  } 
});
$('#emailaddpay').keyup(function(e) {
  if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
    this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
  }
  else if(e.which === 32) {
            var str = $(this).val();
            str = str.replace(/\s/g,'');
            $(this).val(str);            
    	} 
});
function checksubmitdata(){
	var number = /([0-9])/;
	var alphabetssmall = /([a-z])/;
	var alphabetsupper = /([A-Z])/;
	var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
	
	if($('#passwordlogin').val().length<6 || !$('#passwordlogin').val().match(number) || !$('#passwordlogin').val().match(alphabetssmall) || !$('#passwordlogin').val().match(alphabetsupper) || !$('#passwordlogin').val().match(special_characters)){
			 $("#passwordlogin").focus();
			 $("#passinfobx").show();
			 return false;	 
		 } else {
	var regex = new RegExp("^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?"); 
var without_regex = new RegExp("^(www\\.)([0-9A-Za-z-\\.:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?");
var str = $("#companyurl").val();
if(regex.test(str) || without_regex.test(str)){
  return true;
}else{
	$("#companystatus").html('Please provide URL only e.g: (www.google.com or http://www.google.com)');
	$("#companystatus").show();
	$("#companyurl").focus();
	return false;
}
		 }
	

}
</script>
<style>
#companystatus { display:none;clear: both;
  margin-top: 5px; width:100%; box-sizing:border-box;
  float: left; color:#fff; padding:5px; font-size:12px;}
#password-strength-status{clear: both;
  margin-top: 5px; width:100%; box-sizing:border-box;
  float: left;}
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
  .caseletter {  padding: 6px 0;
  border-bottom: 1px dotted #414040;}
		 #passinfobx {background-color: #2a2a2a;
  padding: 5px 15px;
  margin-top: 6px;
  color: #fff;}
		 #passinfobx h2{  font-size: 13px;
  text-transform: uppercase;
  font-weight: bold !important;}
</style>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $('[id="tooltip"]').tooltip({
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
  </script>
<script language="javascript">
$(document).ready(function(e) {
$('#sectorindustry').select2({  placeholder: "Select Sector/Industry" }); 
$('#countryrecruit').select2({  placeholder: "Select Country",maximumSelectionLength: 1 }); 
});
</script>