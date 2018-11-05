<?php require_once("common/header.php");?>
<form name="signupform" id="signupform" action="<?php echo base_url(); ?>do/signup/final" method="post" onSubmit="return validationform()">
<div id="loginbx">
  <div class="container">
    <div class="col-xs-9 bxlogin nopad">
      <div class="login-inner2 left col-xs-5" style=" min-height: 339px;">
        <h2>Job Alerts (Step 2 of 2)
          <div id="logingbar" class="right"></div>
        </h2>
        <p class="parag">Be the first to apply, get new jobs by email.</p>
        <?php if(isset($_SESSION['msglogin'])){?>
        <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
        <?php } ?>
       	  <div class="col-xs-12 nopad boxinput" style="border:1px solid #f0f0f0; background:#f0f0f0; border-radius:5px; padding:10px;">
            <input type="checkbox" name="jalert" id="jalert" checked value="1">
            Set up my job alert
          </div>
          <div class="col-xs-12 nopad boxinput">
            <input type="text" name="jobtitle" id="jobtitle" class="inputjob" required placeholder="Job Title" onBlur="checkspaces('jobtitle')">
          </div>
          <div class="col-xs-12 nopad boxinput">
            <input type="text" name="skills" id="skills" class="inputjob" placeholder="Skills" onBlur="checkspaces('skills')">
          </div>
          <div class="col-xs-12 nopad boxinput">
            <select name="desiredloc[]" id="desiredloc" multiple class="inputjob">
              <option value="">--- Desired Location ---</option>
              <?php 
				$arr = array();
				$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);
				$countries = $config->result_object();
			  foreach($countries as $country):?>
              <option value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-xs-12 nopad boxinput">
            <select name="jobType" id="jobType" class="inputjob">
		       <option value="">--- Job Type ---</option>
               <option value="Any">Any</option>
               <option value="Full-Time">Full-Time</option>
               <option value="Internship">Internship</option>
               <option value="Part-Time">Part-Time</option>
               <option value="Temporary/Contract">Temporary/Contract</option>
            </select>
          </div>
      </div>
      
      <!--Sectors-->
      <div class="login-inner2 left col-xs-6">
        <h2>Your CV</h2>
        <p class="parag">Get Found by recruiters, upload your CV on the next page.</p>
        
        <div class="col-xs-12 nopad boxinput" style="border:1px solid #f0f0f0; background:#f0f0f0; border-radius:5px; padding:10px;">
            <input type="checkbox" name="jCV" id="jCV" checked value="1">
            Yes, Upload my CV <span class="termsc" style="text-align:left; float:right; line-height:19px;">Your next step will be create CV</span></span>
          </div>
        
        <p class="termsc" style="text-align:left; line-height:19px;"> Don't have time? you can do it later. <br><span style="color:#f00;">(uncheck, if you don't want to upload your CV now.)</span></p>
      </div>
      <div class="login-inner2 left col-xs-6" style="min-height:143px">
        <p class="parag">
        By registering, you accept our terms or service and agree to receiving email information and promotional offers from time to time.</p>
       <div class="col-xs-12 nopad boxinput">
           <a href="<?php echo base_url(); ?>skip-signup">
           	<button type="button" name="signup" id="signupbtn" class="btn pink">Skip</button>
           </a>
           <button type="submit" name="signup" id="signupbtn" class="btn green right">Register</button>
          </div>
      </div>
      
    </div>
    
  </div>
</div>

</form>
<?php require_once("common/footer.php");?>
<script language="javascript">
function checkspaces(val){
	if ( $.trim( $('#'+val).val() ) == '' )
    {
		$("#"+val).val('');
	}
}
$('#jalert').click(function() {
    if(!$(this).is(':checked')) {
        $("#jobtitle").removeAttr("required");
    }
	else {
		$("#jobtitle").attr("required","true");
	}
});
function validationform() {
          var chkboxcount = $("[type='checkbox']:checked").length;
          if(chkboxcount > 4){
			alert("Please select 4 or fewer industry sectors.");
			return false;	  
		  }
		  else if(chkboxcount < 1){
			alert("Please select 1 or more sectors.");
			return false;
		  }
}
</script>
<script language="javascript">
 $(document).ready(function(e) {
   $('#desiredloc').select2({  placeholder: "Desired Location" }); 
});
</script>