<?php require_once("common/header.php");?>
<?php 
error_reporting(0);
$ip=$_SERVER['REMOTE_ADDR'];
//$ip = "39.55.222.243";
$addr_details = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
$city = stripslashes(ucfirst($addr_details['geoplugin_city']));
$countrycode = stripslashes(ucfirst($addr_details['geoplugin_countryCode']));
$countryip = stripslashes(ucfirst($addr_details['geoplugin_countryName']));
if(!isset($_SESSION['sessionCart']) && !isset($_SESSION['sessionCartCandidate'])){
	echo "";
	ob_start();
	header ( "Location:" . $this->config->base_url () . 'post-job/');
die;
}
?>
<div id="jobsectors" class="rightop clear left wd100">
  <div class="container">
    <div class="col-xs-12 nopad">
      <div class="col-xs-8 pr0 navleftbar">
        <div class="boxbar login-inner2 left wd100">
          <div class="boxpayment"> <a href="javascript:;" class="paybox bgbx" id="tab_register">Register or log in</a> <a href="javascript:;" class="paybox" id="tab_address">Address details</a> <a href="javascript:;" class="paybox" id="tab_payment">Payment details</a> </div>
         	
            <div id="paymentstatus">
            </div> 
         
          <?php if(isset($_SESSION['JobsSessions'])){ ?>
          <div id="paymentform">
            <div id="register">
              <div class="col-xs-12 nopad">
                <div class="login-inner2 left col-xs-12" style="min-height:134px;">
                  <h2>Company Information</h2>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="firstname" id="firstname" required class="inputjob" readonly value="<?php echo FNAME;?>" onBlur="checkspaces('firstname')" placeholder="First Name">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="lastname" id="lastname" onBlur="checkspaces('lastname')" <?php if(LNAME != ""){?>readonly required<?php }?> value="<?php echo LNAME;?>"  class="inputjob" placeholder="Last Name">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="companyName" id="companyName" onBlur="checkspaces('companyName')" readonly value="<?php echo COMPANY;?>" required class="inputjob" placeholder="Company Name">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="email" name="emailadd" id="emailadd" readonly onBlur="checkspaces('emailadd')" required value="<?php echo EMAIL;?>" class="inputjob" placeholder="Email Address">
                  </div>
                  
                  <div class="col-xs-12 nopad boxinput">
                    <button type="button" name="signup" id="signupbtn" class="btn pink left" onClick="next_form('register','address')">Continue</button>
                  </div>
                </div>
              </div>
              
            </div>
            <!--Address-->
            <div id="address">
              <div class="col-xs-12 nopad">
                <div class="login-inner2 left col-xs-12" style="min-height:134px;">
                  <h2>Billing Address/Billing Address</h2>
                  <?php /*if(isset($_SESSION['msglogin'])){?>
                  <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
                  <?php }*/ ?>
                  <div class="col-xs-12 nopad boxinput">
                    <select name="countrybilling" id="countrybilling" required class="inputjob">
                      <option value="">--- Select Country ---</option>
                      <?php 
					$arr = array();
					$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);
					$countries = $config->result_object();
				  	foreach($countries as $country):

				?>
                      <option value="<?php echo $country->country_code;?>" <?php if($country->country_code == $countrycode){echo "SELECTED";}?>><?php echo $country->country_name;?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="address1" id="address1" required class="inputjob" value="<?php echo ADDRESS;?>" onBlur="checkspaces('address1')"  placeholder="Address Line 1" value="">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="street" id="street" class="inputjob" onBlur="checkspaces('street')"  placeholder="Address Line 2">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="citystate" id="citystate" required class="inputjob" value="<?php echo CITYMAIN;?>" onBlur="checkspaces('citystate')"  placeholder="City">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="zipcode" id="zipcode" required class="inputjob" value="<?php echo ZIPCO;?>" onBlur="checkspaces('zipcode')"  placeholder="Zip Code">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <button type="submit" name="signup" id="signupbtn" class="btn pink left" onClick="next_form('address','payment')">Continue</button>
                  </div>
                </div>
              </div>
            </div>
            <!--Payment-->
            <div id="payment">
              <div class="col-xs-12 nopad">
                <div class="login-inner2 left col-xs-12" style="min-height:134px;">
                  <h2>Payment Details</h2>
                  <?php /*if(isset($_SESSION['msglogin'])){?>
                  <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
                  <?php }*/ ?>
                  <div class="col-xs-12 nopad boxinput">
                    <label>Name on Card</label>
                    <input type="text" name="creditname" onBlur="checkspaces('creditname')" value="<?php echo FNAME." ".LNAME;?>" id="creditname" required class="inputjob" placeholder="Name on Credit Card">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <label>Card Number</label>
                    <input type="text" name="cardNumber" onBlur="checkspaces('cardNumber')" id="cardNumber" required class="inputjob" placeholder="Card Number">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <div class="col-xs-6 nopad">
                      <label>Expiration Month</label>
                      <select name="month" id="month" required class="inputjob">
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                      </select>
                    </div>
                    <div class="col-xs-6 nopad">
                      <label>Expiration Year</label>
                      <select name="year" id="year" required class="inputjob">
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <label>CVC</label>
                    <input type="text" name="cvcode" onBlur="checkspaces('cvcode')" id="cvcode" required class="inputjob" placeholder="123">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <button type="submit" name="signup" id="signupbtn" class="btn pink left" onClick="next_form('payment','final')">Process Order</button>
                  </div>
                </div>
              </div>
            </div>
            <?php if($_SESSION['sessionCart']['val'] == 1){$pricecart = '149';$adv = '1 Advert';} else if($_SESSION['sessionCart']['val'] == 2){$pricecart = '140';$adv = '2 Adverts';} else if($_SESSION['sessionCart']['val'] == 3){$pricecart = '130';$adv = '3 Adverts';} else if($_SESSION['sessionCart']['val'] == 4){$pricecart = '120';$adv = '4 Adverts';} else if($_SESSION['sessionCart']['val'] >= 5){$pricecart = '110';
			$adv = '5+ Adverts';}?>
            <?php if($_SESSION['sessionCartCandidate']['val'] == 1){$pricecartcand = '190';$day =' + 1 Day';} else if($_SESSION['sessionCartCandidate']['val'] == 7){$pricecartcand = '250';$day =' + 7 Days';} else if($_SESSION['sessionCartCandidate']['val'] == 28){$pricecartcand = '750';
	$day =' + 1 Month';}?>
            <input type="hidden" name="productname" id="productname" value="<?php echo $adv;?> <?php echo $day;?>">
            <input type="hidden" name="price" id="price" value="<?php echo ($_SESSION['sessionCart']['val']*$pricecart)+($pricecartcand).".00";?>">
            <input type="hidden" name="advertsbox" id="advertsbox" value="<?php echo $_SESSION['sessionCart']['val'];?>">
            <input type="hidden" name="candidatesearbox" id="candidatesearbox" value="<?php echo $_SESSION['sessionCartCandidate']['val'];?>">
            <input type="hidden" value="<?php echo $_SESSION['sessionCart']['val']+$_SESSION['sessionCartCandidate']['val'];?>" name="qty" id="qty">
          </div>
          <?php } else {?>
          <div id="paymentform">
            <div id="register">
              <div class="col-xs-6 nopad">
                <div class="login-inner2 left col-xs-12" style="min-height:134px;">
                  <h2>New customer sign up</h2>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="firstname" id="firstname" required class="inputjob" onBlur="checkspaces('firstname')" placeholder="First Name">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="lastname" id="lastname" onBlur="checkspaces('lastname')" required class="inputjob" placeholder="Last Name">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="companyName" id="companyName" onBlur="checkspaces('companyName')" required class="inputjob" placeholder="Company Name">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="email" name="emailaddpay" id="emailaddpay" onKeyUp="isEmail()" onBlur="checkspaces('emailaddpay')" required class="inputjob" placeholder="Email Address">
                    <div id="email-strength-status"></div>
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <div class="col-xs-10 nopad"><input type="password" name="passwordlogin" onKeyUp="checkPasswordStrength()" id="passwordlogin" onBlur="checkspaces('passwordlogin')" required class="inputjob" placeholder="Password">
                    </div>
                    <div class="col-xs-2">
                    <i class="fa fa-question infoquestion" id="tooltip" style="cursor:pointer;" title="Please create a password that is a combination of letters, numbers and special characters."></i>
                    </div>
                    <div id="password-strength-status"></div>
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <button type="button" name="signup" id="signupbtn" class="btn pink left" onClick="next_form('register','address')">Continue</button>
                  </div>
                </div>
              </div>
              <div class="col-xs-6 pright0">
                <div class="login-inner2 left col-xs-12" style="min-height:315px;">
                  <h2>Already have an account? </h2>
                  <?php /*if(isset($_SESSION['msglogin'])){?>
                  <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
                  <?php }*/ ?>
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
                        <input type="hidden" name="returl" class="inputjob" id="returl" value="<?php echo $this->uri->segment(1);?>">
                      </div>
                       <div class="col-xs-5">
                            <i class="fa fa-question infoquestion" id="tooltip" style="cursor:pointer;" title="You would have been given a 4 digit security code in your email address during registration. In case you do not remember the security code details, it will be provided when you request for a password reset."></i>
                        </div>
                    </div>
                    <div class="col-xs-12 nopad boxinput">
                      <button type="submit" name="signup" id="signupbtn" class="btn pink left">Login</button>
                      <div class="right loglnk"><a href="javascript:;" onclick="forgotpassword()">Forgot security code or password?</a></div>
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
            <!--Address-->
            <div id="address">
              <div class="col-xs-12 nopad">
                <div class="login-inner2 left col-xs-12" style="min-height:134px;">
                  <h2>Billing Address/Billing Address</h2>
                  <?php if(isset($_SESSION['msglogin'])){?>
                  <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
                  <?php } ?>
                  <div class="col-xs-12 nopad boxinput">
                    <select name="country" id="country" required class="inputjob">
                      <option value="">--- Select Country ---</option>
                      <?php 
					$arr = array();
					$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);
					$countries = $config->result_object();
				  	foreach($countries as $country):
				?>
                      <option value="<?php echo $country->country_code;?>" <?php if($country->country_code == $countrycode){echo "SELECTED";}?>><?php echo $country->country_name;?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="address1" id="address1" required class="inputjob" onBlur="checkspaces('address1')"  placeholder="Address Line 1">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="street" id="street" class="inputjob" onBlur="checkspaces('street')"  placeholder="Address Line 2">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="citystate" id="citystate" required class="inputjob" onBlur="checkspaces('citystate')"  placeholder="City">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="zipcode" id="zipcode" required class="inputjob" onBlur="checkspaces('zipcode')"  placeholder="Zip Code">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <button type="submit" name="signup" id="signupbtn" class="btn pink left" onClick="next_form('address','payment')">Continue</button>
                  </div>
                </div>
              </div>
            </div>
            <!--Payment-->
            <div id="payment">
              <div class="col-xs-12 nopad">
                <div class="login-inner2 left col-xs-12" style="min-height:134px;">
                  <h2>Payment Details</h2>
                  <?php if(isset($_SESSION['msglogin'])){?>
                  <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
                  <?php } ?>
                  <div class="col-xs-12 nopad boxinput">
                    <label>Name on Card</label>
                    <input type="text" name="creditname" onBlur="checkspaces('creditname')" id="creditname" required class="inputjob" placeholder="Name on Credit Card">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <label>Card Number</label>
                    <input type="text" name="cardNumber" onBlur="checkspaces('cardNumber')" id="cardNumber" required class="inputjob" placeholder="Card Number">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <div class="col-xs-6 nopad">
                      <label>Expiration Month</label>
                      <select name="month" id="month" required class="inputjob">
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                      </select>
                    </div>
                    <div class="col-xs-6 nopad">
                      <label>Expiration Year</label>
                      <select name="year" id="year" required class="inputjob">
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <label>CVC</label>
                    <input type="text" name="cvcode" onBlur="checkspaces('cvcode')" id="cvcode" required class="inputjob" placeholder="123">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <button type="submit" name="signup" id="signupbtn" class="btn pink left" onClick="next_form('payment','final')">Process Order</button>
                  </div>
                </div>
              </div>
            </div>
             <?php if($_SESSION['sessionCart']['val'] == 1){$pricecart = '149';$adv = '1 Advert';} else if($_SESSION['sessionCart']['val'] == 2){$pricecart = '140';$adv = '2 Adverts';} else if($_SESSION['sessionCart']['val'] == 3){$pricecart = '130';$adv = '3 Adverts';} else if($_SESSION['sessionCart']['val'] == 4){$pricecart = '120';$adv = '4 Adverts';} else if($_SESSION['sessionCart']['val'] >= 5){$pricecart = '110';
			$adv = '5+ Adverts';}?>
            <?php if($_SESSION['sessionCartCandidate']['val'] == 1){$pricecartcand = '190';$day =' + 1 Day';} else if($_SESSION['sessionCartCandidate']['val'] == 7){$pricecartcand = '250';$day =' + 7 Days';} else if($_SESSION['sessionCartCandidate']['val'] == 28){$pricecartcand = '750';
	$day =' + 1 Month';}?>
            <input type="hidden" name="productname" id="productname" value="<?php echo $adv;?> <?php echo $day;?>">
            <input type="hidden" name="price" id="price" value="<?php echo ($_SESSION['sessionCart']['val']*$pricecart)+($pricecartcand).".00";?>">
            <input type="hidden" name="advertsbox" id="advertsbox" value="<?php echo $_SESSION['sessionCart']['val'];?>">
            <input type="hidden" name="candidatesearbox" id="candidatesearbox" value="<?php echo $_SESSION['sessionCartCandidate']['val'];?>">
            <input type="hidden" value="<?php echo $_SESSION['sessionCart']['val']+$_SESSION['sessionCartCandidate']['val'];?>" name="qty" id="qty">
          </div>
          <?php } ?>
        </div>
      </div>
      <div class="col-xs-4 nopad">
        <div id="cartdatashow"> 
        </div>
        <?php
		$arrcop2 		= array('cpActive' => 1);
		$configcop2 	 = $this->front_model->get_query_simple('*','dev_web_coupon_active',$arrcop2);
		$copstatusd 	  = $configcop2->num_rows();
		if($copstatusd > 0){
			$cprowsd = $configcop2->result_object();
			if($cprowsd[0]->cpCountry == "0" || $cprowsd[0]->cpCountry == $countryip){
		?>
        <div class="col-xs-12 nopad">
                <div class="login-inner2 left col-xs-12" style="min-height:134px;">
                  <h2>Coupon Discount</h2>
                  <form name="signupform" id="signupform" action="<?php echo base_url(); ?>jobsite/coupon_discount" method="post" onSubmit="return validationform()">
                  <?php if(isset($_SESSION['msglogin'])){?>
                    <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
                    <?php } ?>
                  <div class="col-xs-12 nopad boxinput">
                    <input type="text" name="coupouncode" id="coupouncode" required class="inputjob" placeholder="Enter Coupon Code">
                  </div>
                  <div class="col-xs-12 nopad boxinput">
                    <button type="submit" name="signup" id="signupbtn" class="btn green left">Discount</button>
                  </div>
                  </form>
                </div>
              </div>
        <?php 
			}
		}else {unset($_SESSION['coponcodeses']);}?>
		
      </div>
    </div>
    
    <!--MESSAGE-->
    <div class="container-popup" id="boxmesage">
    <div class="rightpop">
    
    	<div id="messpopup">
        	
        </div>
    </div>
</div>
    
  </div>
</div>
<?php require_once("common/footer.php");?>
<script language="javascript">
function isEmail() {
	var emaildata = $("#emailaddpay").val();
	if(emaildata == ""){
		$("#email-strength-status").hide();
	}
	else {
  		  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		  if(!regex.test(emaildata)){
				$("#email-strength-status").fadeIn();
				$('#email-strength-status').removeClass();
				$('#email-strength-status').addClass('weak-password');
				$('#email-strength-status').html("Please provide a valid Email Address.");
		  }
		  else {
			  $("#email-strength-status").fadeOut();
		  }
	}
}
$(document).ready(function(e) {
    cartboxautoupdate();
});
$('#firstname').keyup(function() {
  if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
    this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
  } 
});
$('#lastname').keyup(function() {
  if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
    this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
  } 
});
$('#companyName').keyup(function() {
  if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
    this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
  } 
});
$('#address1').keyup(function() {
  if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
    this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
  } 
});
$('#street').keyup(function() {
  if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
    this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
  } 
});
$('#citystate').keyup(function() {
  if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
    this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
  } 
});
$('#zipcode').keyup(function() {
   if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});
$('#creditname').keyup(function() {
  if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
    this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
  } 
});
$('#cardNumber').keyup(function() {
   if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});
$('#cvcode').keyup(function() {
   if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});
$(document).ready(function(e) {
    $('#cardNumber').keydown(function() {
		 var value = $(this).val();
			if ( value.length == 16){return false;}else {return true;}
	});
	$('#zipcode').keydown(function() {
		 var value = $(this).val();
			if ( value.length == 5){return false;}else {return true;}
	});
	$('#cvcode').keydown(function() {
		 var value = $(this).val();
			if ( value.length == 4){return false;}else {return true;}
	});

});
function checkspaces(val){
	if ( $.trim( $('#'+val).val() ) == '' )
    {
		$("#"+val).val('');
	}
}
function next_form(val,next){
	if(val == 'register'){
		if($("#firstname").val() == ""){
			$("#firstname").addClass('redborder');
			return false;
		} else if($("#lastname").val() == ""){
			$("#lastname").addClass('redborder');
			return false;
		}
		else if($("#companyName").val() == ""){
			$("#companyName").addClass('redborder');
			return false;
		}
		else if($("#emailaddpay").val() == ""){
			$("#emailaddpay").addClass('redborder');
			$("#email-strength-status").hide();
			return false;
		}
		else if($("#passwordlogin").val() == ""){
			$("#passwordlogin").addClass('redborder');
			return false;
		}
		<?php /*?>else if($("#passwordlogin").val().length < 6){
			$("#passwordlogin").addClass('redborder');					

			$("#password-strength-status").fadeIn();
			$('#password-strength-status').removeClass();
			$('#password-strength-status').addClass('weak-password');
			$('#password-strength-status').html("Weak Password (should be atleast 6 characters.)");
			return false;
		}<?php */?>
		else {
		$("#"+val).slideUp();
		$("#"+next).show();
		$("#tab_"+val).removeClass('bgbx');
		$("#tab_"+next).addClass('bgbx');
		}
	}
	else if(val == 'address'){
		if($("#address1").val() == ""){
			$("#address1").addClass('redborder');
			return false;
		}
		else if($("#citystate").val() == ""){
			$("#citystate").addClass('redborder');
			return false;
		}
		else if($("#zipcode").val() == ""){
			$("#zipcode").addClass('redborder');
			return false;
		}
		else {
			$("#"+val).slideUp();
			$("#"+next).show();
			$("#tab_"+val).removeClass('bgbx');
			$("#tab_"+next).addClass('bgbx');
		}
	}
	else if(val == 'payment'){
		if($("#creditname").val() == ""){
			$("#creditname").addClass('redborder');
			return false;
		} else if($("#cardNumber").val() == ""){
			$("#cardNumber").addClass('redborder');
			return false;
		}
		else if($("#cvcode").val() == ""){
			$("#cvcode").addClass('redborder');
			return false;
		}
		else {
			var submitform = $("#paymentform").find("select,textarea, input").serialize();
			// SAVE RECORDS AND PAYMENT IN FORM
			$("#boxmesage").show();
			$("#messpopup").html('<span style="text-align:center;display: block;line-height: 30px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><br><br> Processing Payment....<br> Please wait for few seconds for the response.</span>');
			<?php if(isset($_SESSION['JobsSessions'])){ ?>
				var process = "<?php echo base_url(); ?>jobsite/process_order_payment_login_after?rnd="+Math.random()+"&"+submitform;
			<?php }  else { ?>
				var process = "<?php echo base_url(); ?>jobsite/process_order_payment?rnd="+Math.random()+"&"+submitform;
			<?php } ?>
			$.ajax({
				url : process,
				async: true,
				cache: false,
				method : "POST",
				success : function(response)
				{
					if(response == "0"){
						$("#paymentstatus").html(response);
						$("#paymentstatus").show();
						$("#emailaddpay").val('');
						$("#"+val).slideUp();
						$("#register").show();
						$("#tab_"+val).removeClass('bgbx');
						$("#tab_register").addClass('bgbx');
						$("#messpopup").html('Email Address already found!');
						setTimeout(function() {
							$('#boxmesage').fadeOut('fast');
						}, 1000);
					}
					else if(response == "1") {
						window.location = "<?php echo base_url(); ?>jobsite/payment_success_action";
					} 
					else 
					{
						$("#messpopup").html(response);
						$("#messpopup").show();
					}
				}
			});
			
		}
	}
}
$('#secruityCode').keyup(function() {
   if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});
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
</script>
<style>
#payment, #address {
	display: none;
}
#cartdatashow {
	border: 1px solid #ccc !important;
	padding: 5px !important;
	background: #fff !important;
	float:left;
	width:100%;
	box-sizing:border-box;
}
#cartdatashow p {
	margin-bottom: 0 !important;
	text-align: left !important;
	font-weight: bold;
	padding: 5px;
}
.boxcartshow {
	background: #fff !important;
	border: #fff !important;
}
.boxcartshow h2 {
	margin: 12px 0;
	font-size: 14px;
	text-align: right;
	text-transform: uppercase;
}
#jobsectors h1 {
	text-transform: uppercase;
	margin-bottom: 6px !important;
	font-size: 17px !important;
	border: 1px solid #f0f0f0 !important;
	padding: 10px !important;
	text-align: center !important;
	background: #FDFDFD !important;
}
#checboxout {
	display: none;
}
.carttable th {
	background: #f0f0f0;
	padding: 13px 5px;
	border: 1px solid #DFDFDF;
	text-transform: uppercase;
}
.carttable td {
	padding: 13px 5px;
	border: 1px solid #DFDFDF;
	text-transform: uppercase;
}
.paybox {
	border: 1px solid #ccc;
	width: 30.33%;
	padding: 13px 10px;
	text-align: center;
	text-transform: uppercase;
	background: #F2F2F2;
	margin-bottom: 10px;
	display: block;
	float: left;
}
.bgbx {
	background: #0098cc !important;
	color: #fff !important;
}
.nocart {
	padding: 84px;
	text-align: center;
	color: #f00;
	text-transform: uppercase;
	line-height: 22px;
}
#email-strength-status{  padding: 5px;
  color: #fff;
  text-align: center;
  margin-top: 5px;
  display:none;
  border-radius: 2px;}
  .infoquestion {  background: #f0f0f0;
  padding: 4px 7px;
  border-radius: 78%;
  margin-top: 8px;}
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
<link rel="stylesheet" href="/resources/demos/style.css">
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
  function forgotpassword(){
	 var x = document.getElementById('passforgot');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
	}
  </script>
