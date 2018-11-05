<?php require_once("common/header.php");?>

<?php
$ip=$_SERVER['REMOTE_ADDR'];
$addr_details = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
$city = stripslashes(ucfirst($addr_details['geoplugin_city']));
$countrycode = stripslashes(ucfirst($addr_details['geoplugin_countryCode']));
$countryip = stripslashes(ucfirst($addr_details['geoplugin_countryName']));
if(isset($_REQUEST['ret']))
{
	$_SESSION['SESSIONAPPLIED'] = $_REQUEST['ret'];
}
	error_reporting(0);
	$arr2      = array('uID' => UID);
	$config2   = $this->front_model->get_query_simple('*','dev_web_cv',$arr2);
	$cv		= $config2->result_object();
	// USER INFO
	$arr3      = array('uID' => UID);
	$config3   = $this->front_model->get_query_simple('*','dev_web_user',$arr3);
	$user		= $config3->result_object();
?>
<div id="jobsectors" class="rightop clear left wd100">
  <div class="container">
   	
    <?php /*?><form name="loginform" id="loginform" action="<?php echo base_url(); ?>do/create/cv" method="post" enctype="multipart/form-data" onSubmit="return buttondisabled()"><?php */?>
      <div class="col-xs-12 nopad">
      <div id="loginbx">
       <div class="col-xs-5 bxlogin nopad">
       <?php if(isset($_SESSION['msglogin'])){?>
    	<div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
    <?php } ?>
       <?php if(!isset($_GET['page'])){?> 
       <form name="loginform" id="loginform" action="<?php echo base_url(); ?>jobsite/upload_resume_step" method="post" enctype="multipart/form-data" onSubmit="return buttondisabled()">
          <div class="media left cv-inner wd100">
            <h2>Resume Management</h2>
            <div class="media-body  nopad coverletterbox col-xs-12">
              <p style="margin-top:0;">Your current account information:</p>
              <div class="media-body nopad coverletterbox col-xs-12">
               <div class="col-xs-12 nopad boxinput">
                <input type="text" name="cvtitle" id="cvtitle" onBlur="checkspaces('cvtitle')" required class="inputjob" value="<?php echo $cv[0]->cvTitle;?>" placeholder="CV Title">
              </div>
                <div class="col-xs-12 nopad boxinput">
                	
                  <input type="file" name="userfile" id="userfile" class="inputjob">
                  <br><span style="color:#f00;display: block;margin: 5px 0 0;  text-align: right;">Only (PDF,DOC) file allowed... 2MB max file size</span>
                  <input type="hidden" name="cvID" id="cvID" class="inputjob" value="<?php echo $cv[0]->cvID;?>">
                </div>
                <div class="col-xs-12 nopad boxinput">
                  <select name="findcv" id="findcv" class="inputjob">
                    <option value="1" <?php if($cv[0]->cvView == 1){echo "SELECTED";}?>>Let recruiters find your CV</option>
                    <option value="0" <?php if($cv[0]->cvView == 0){echo "SELECTED";}?>>Hide your CV from recruiters</option>
                  </select>
                </div>
                 <?php if($cv[0]->cvFile != ""){?>
                    	<a href="<?php echo base_url(); ?>resources/uploads/resume/<?php echo $cv[0]->cvFile;?>" target="_blank" style="display:block;   margin: 10px 0;
  clear: both;
  float: left;"><strong>View uploaded CV</strong></a>
                    <?php } ?>
              </div>
            </div>
          </div>
          <button type="submit" name="signup" id="signypbutton" class="btn pink right" style="margin-top: 0;">Next Step</button>
  		</form>
       <?php } ?>
        <?php if(isset($_GET['page']) && $_GET['page'] == "preferred"){?> 
        <form name="loginform" id="loginform" action="<?php echo base_url(); ?>jobsite/upload_preferred_step" method="post" enctype="multipart/form-data" onSubmit="return buttondisabled()">
          <div class="media left cv-inner wd100" style="min-height: 521px;">
            <h2>Preffered Job Details</h2>
             <?php 
				$pfarr = array('uID' => UID);
				$pfconfig 	= $this->front_model->get_query_simple('*','dev_job_alerts',$pfarr);
				$pfrow = $pfconfig->result_object();
			  ?>
            <div class="media-body nopad coverletterbox col-xs-12">
              <p style="margin-top:0;">Please provide your preferred job details</p>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="jobtitle" id="jobtitle" onBlur="checkspaces('jobtitle')" required class="inputjob" 
                value="<?php if(count($cv)==0 || $cv[0]->pJobtitle == ""){echo $pfrow[0]->jobTitle;} else {echo $cv[0]->pJobtitle;}?>" placeholder="Job Title">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="skills" id="skills" required onBlur="checkspaces('skills')" class="inputjob" value="<?php if(count($cv)== 0 || $cv[0]->pjobskills == ""){echo $pfrow[0]->jobSkills;} else {echo $cv[0]->pjobskills;}?>" placeholder="Skills">
              </div>
              <div class="col-xs-12 nopad boxinput">
               <?php /*?> <input type="text" name="location" id="location" onBlur="checkspaces('location')" required class="inputjob" value="<?php echo $cv[0]->pjoblocation;?>" placeholder="Location"><?php */?>
                <select name="location[]" id="location" multiple class="inputjob">
              <option value="">--- Preferred Location ---</option>
              <?php 
				$arr = array();
				$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);
				$countries = $config->result_object();
			  foreach($countries as $country):
			  	$epx = explode(",",$cv[0]->pjoblocation);
				//for($ij=0; $ij<=count($epx)-1;$ij++){
					if(count($cv)== 0 || $cv[0]->pjoblocation == ""){$plc = explode(",",$pfrow[0]->jobLocation);}
			  ?>
              <option value="<?php echo $country->country_name;?>" 
				  <?php if(count($cv)== 0 || $cv[0]->pjoblocation == ""){
					  
					  foreach($plc as $locpx){if($country->country_name == $locpx){echo "SELECTED";}}
					  } else {foreach($epx as $locx){if($country->country_name == $locx){echo "SELECTED";}}}?>>
                  <?php echo $country->country_name;?>
              </option>
              <?php  endforeach; ?>
            </select>
              </div>
              <div class="col-xs-12 nopad boxinput">
                <select name="sectorindu[]" id="sectorindu" multiple class="inputjob" required>
                  <option value="">--- Preferred Sector/Industry ---</option>
                  <?php
				  	$arrset3      = array('catStatus' => 1);
					$configset3   = $this->front_model->get_query_simple('*','dev_web_categories',$arrset3);
					$set		= $configset3->result_object();
					foreach($set as $sects):
					$epxs = explode(",",$cv[0]->jobSector);
				  ?>
                  <option value="<?php echo $sects->cID;?>" <?php foreach($epxs as $indx){if($sects->cID == $indx){echo "SELECTED";}}?>><?php echo $sects->catName;?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-xs-12 nopad boxinput">
                <select name="relocate" id="relocate" class="inputjob" required>
                  <option value="">--- Select Would you relocate ---</option>
                  <option value="Yes" <?php if($cv[0]->prelocate == "Yes"){echo "SELECTED";}?>>Yes</option>
                  <option value="No" <?php if($cv[0]->prelocate == "No"){echo "SELECTED";}?>>No</option>
                  <option value="May Be" <?php if($cv[0]->prelocate == "May Be"){echo "SELECTED";}?>>May Be</option>
                </select>
              </div>
              <div class="col-xs-12 nopad boxinput">
                <select name="jobtype" id="jobtype" class="inputjob" required>
                  <option value="">--- Select Job Type ---</option>
                  <option value="Any" <?php if(count($cv)== 0 || $cv[0]->pjobtype == ""){if($pfrow[0]->jobNature == "Any"){echo "SELECTED";}} else {if($cv[0]->pjobtype == "Any"){echo "SELECTED";}}?>>Any</option>
                  <option value="Full-Time" <?php if(count($cv)== 0 || $cv[0]->pjobtype == ""){if($pfrow[0]->jobNature == "Full-Time"){echo "SELECTED";}} else {if($cv[0]->pjobtype == "Full-Time"){echo "SELECTED";}}?>>Permanent</option>
                  <option value="Contract" <?php if(count($cv)== 0 || $cv[0]->pjobtype == ""){if($pfrow[0]->jobNature == "Internship"){echo "SELECTED";}} else {if($cv[0]->pjobtype == "Internship"){echo "SELECTED";}}?>>Internship</option>
                  <option value="Part Time" <?php if(count($cv)== 0 || $cv[0]->pjobtype == ""){if($pfrow[0]->jobNature == "Part-Time"){echo "SELECTED";}} else {if($cv[0]->pjobtype == "Part-Time"){echo "SELECTED";}}?>>Part Time</option>
                  <option value="Temporary" <?php if(count($cv)== 0 || $cv[0]->pjobtype == ""){if($pfrow[0]->jobNature == "Temporary"){echo "SELECTED";}} else {if($cv[0]->pjobtype == "Temporary"){echo "SELECTED";}}?>>Temporary</option>
                </select>
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="salaryfrom" id="salaryfrom" required class="inputjob" value="<?php echo $cv[0]->psalaryfrom;?>" placeholder="Salary From">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="salaryto" id="salaryto" required class="inputjob" value="<?php echo $cv[0]->psalaryto;?>" placeholder="Salary To">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <select name="currency" id="currency" class="inputjob" required>
                  <option value="">--- Select Currency ---</option>
                  <option value="$" <?php if($cv[0]->pcurrency == "$"){echo "SELECTED";}?>>Dollar ($)</option>
                  <option value="£" <?php if($cv[0]->pcurrency == "£"){echo "SELECTED";}?>>Pound (£)</option>
                  <option value="€" <?php if($cv[0]->pcurrency == "€"){echo "SELECTED";}?>>Euro (€)</option>
                </select>
              </div>
            </div>
          </div>
          <button type="submit" name="signup" id="signypbutton" class="btn pink right" style="margin-top: 0;">Next Step</button>
          </form>
        <?php } ?> 
        <?php if(isset($_GET['page']) && $_GET['page'] == "personal"){?> 
			<form name="loginform" id="loginform" action="<?php echo base_url(); ?>jobsite/upload_perosnal_step" method="post" enctype="multipart/form-data" onSubmit="return buttondisabled()">
            <div class="media cv-inner left wd100" style="min-height: 241px;">
            <h2>Your Details</h2>
            <div class="media-body nopad coverletterbox col-xs-12">
              <p style="margin-top:0;">Please Update your cv information below</p>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="fname" id="fname" required class="inputjob" value="<?php echo $user[0]->uFname;?>" placeholder="First Name">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="lname" id="lname" required class="inputjob" value="<?php echo $user[0]->uLname;?>" placeholder="Last Name">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="date" name="dob" id="dob" required class="inputjob" value="<?php echo $user[0]->uDOB;?>" placeholder="Date of Birth">
                <div id="msgDOB"></div>
              </div>
              <div class="col-xs-12 nopad boxinput">
                <select name="country" id="countrysend" class="inputjob" required>
                  <option value="">--- Select Country ---</option>
                  <?php 
				$arr3 = array();
				$config3 = $this->front_model->get_query_simple('*','country_codes',$arr3);
				$countries 	= $config3->result_object();
				  foreach($countries as $country):?>
                  <option value="<?php echo $country->nicename;?>" <?php if($country->nicename == $user[0]->uCountry){ echo "SELECTED";}?>><?php echo $country->nicename;?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="address" id="address" onBlur="checkspaces('address')" required class="inputjob" value="<?php echo $user[0]->uAddress;?>" placeholder="Address">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="city" id="city" onBlur="checkspaces('city')" required class="inputjob" value="<?php echo $user[0]->uCity;?>" placeholder="City">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="zip" id="zip" required class="inputjob" value="<?php echo $user[0]->uZip;?>" placeholder="Zip Code">
              </div>
              <div class="col-xs-12 nopad boxinput">
              	<div class="col-xs-3 nopad">
                <select class="inputjob" id="id_std_code" maxlength="3" style="  padding: 9px;" name="country_code" required >
                	<option value="">- Code -</option>
                <?php
					$phoexp = explode("-",$user[0]->uPhone);
					$arrcode = array();
					$configcode	= $this->front_model->get_query_simple('*','country_codes',$arrcode);
					$cacode 	= $configcode->result_object();
					foreach($cacode as $concode):
				?>
				  <option value="<?php echo $concode->phonecode;?>" 
				  <?php if($user[0]->uPhone != ""){if($concode->phonecode == $phoexp[0]){echo "SELECTED";}} else {if($concode->iso == $countrycode){echo "SELECTED";}}?>><?php echo $concode->phonecode;?></option>
                <?php
					endforeach;
				?>
				</select>
                </div>
                <div class="col-xs-9 nopad">
                <input type="text" name="contact" id="contact" required class="inputjob" value="<?php if($user[0]->uPhone != ""){echo $phoexp[1];}?>" placeholder="Mobile/Landline Number">
                </div>
              </div>
            </div>
          </div>
          <button type="submit" name="signup" id="signypbutton" class="btn pink right" style="margin-top: 0;">Next Step</button>
            </form>        
        <?php } ?>
        
        <?php if(isset($_GET['page']) && $_GET['page'] == "relevant"){?> 
        <form name="loginform" id="loginform" action="<?php echo base_url(); ?>jobsite/upload_relevant_step" method="post" enctype="multipart/form-data" onSubmit="return buttondisabled()">
        <div class="media cv-inner left wd100">
            <h2>About You</h2>
            <div class="media-body nopad coverletterbox col-xs-12">
              <p style="margin-top:0;">Please share information about you relevant to job</p>
              <div>
                <div class="col-xs-12 nopad boxinput">
                  <select name="notice" id="notice" class="inputjob" required>
                    <option value="">--- Select Notice period ---</option>
                    <option value="Immediate" <?php if($cv[0]->anoticeperiod == "Immediate"){echo "SELECTED";}?>>Immediate</option>
                    <option value="1 week" <?php if($cv[0]->anoticeperiod == "1 week"){echo "SELECTED";}?>>1 week</option>
                    <option value="2 weeks" <?php if($cv[0]->anoticeperiod == "2 weeks"){echo "SELECTED";}?>>2 weeks</option>
                    <option value="3 weeks" <?php if($cv[0]->anoticeperiod == "3 weeks"){echo "SELECTED";}?>>3 weeks</option>
                    <option value="4 weeks" <?php if($cv[0]->anoticeperiod == "4 weeks"){echo "SELECTED";}?>>4 weeks</option>
                    <option value="6 weeks" <?php if($cv[0]->anoticeperiod == "6 weeks"){echo "SELECTED";}?>>6 weeks</option>
                    <option value="8 weeks" <?php if($cv[0]->anoticeperiod == "8 weeks"){echo "SELECTED";}?>>8 weeks</option>
                    <option value="16 weeks" <?php if($cv[0]->anoticeperiod == "16 weeks"){echo "SELECTED";}?>>16 weeks</option>
                    <option value="3 months +" <?php if($cv[0]->anoticeperiod == "3 months +"){echo "SELECTED";}?>>3 months +</option>
                  </select>
                </div>
                <div class="col-xs-12 nopad boxinput">
                  <input type="text" name="languages" id="languages" class="inputjob" value="<?php echo $cv[0]->alanguage;?>" placeholder="Languages (Optional)">
                </div>
                <div class="col-xs-12 nopad boxinput">
                  <select name="leveleducation" id="leveleducation" class="inputjob" required>
                    <option value="">--- Select Highest level of education ---</option>
                    <option value="No Formal Qualifications" <?php if($cv[0]->aeducationlevel == "No Formal Qualifications"){echo "SELECTED";}?>>No Formal Qualifications</option>
                    <option value="School Qualification / A-Level" <?php if($cv[0]->aeducationlevel == "School Qualification / A-Level"){echo "SELECTED";}?>>School Qualification / A-Level</option>
                    <option value="Vocational" <?php if($cv[0]->aeducationlevel == "Vocational"){echo "SELECTED";}?>>Vocational</option>
                    <option value="Apprenticeship" <?php if($cv[0]->aeducationlevel == "Apprenticeship"){echo "SELECTED";}?>>Apprenticeship</option>
                    <option value="Trade certification" <?php if($cv[0]->aeducationlevel == "Trade certification"){echo "SELECTED";}?>>Trade certification</option>
                    <option value="College Diploma / Certificate" <?php if($cv[0]->aeducationlevel == "College Diploma / Certificate"){echo "SELECTED";}?>>College Diploma / Certificate</option>
                    <option value="Pass Bachelors" <?php if($cv[0]->aeducationlevel == "Pass Bachelors"){echo "SELECTED";}?>>Pass Bachelors</option>
                    <option value="3rd Class Bachelors" <?php if($cv[0]->aeducationlevel == "3rd Class Bachelors"){echo "SELECTED";}?>>3rd Class Bachelors</option>
                    <option value="Lower 2nd Class Bachelors" <?php if($cv[0]->aeducationlevel == "Lower 2nd Class Bachelors"){echo "SELECTED";}?>>Lower 2nd Class Bachelors</option>
                    <option value="Upper 2nd Class Bachelors" <?php if($cv[0]->aeducationlevel == "Upper 2nd Class Bachelors"){echo "SELECTED";}?>>Upper 2nd Class Bachelors</option>
                    <option value="1st Class Bachelors" <?php if($cv[0]->aeducationlevel == "1st Class Bachelors"){echo "SELECTED";}?>>1st Class Bachelors</option>
                    <option value="Honours Degree" <?php if($cv[0]->aeducationlevel == "Honours Degree"){echo "SELECTED";}?>>Honours Degree</option>
                    <option value="Masters Degree" <?php if($cv[0]->aeducationlevel == "Masters Degree"){echo "SELECTED";}?>>Masters Degree</option>
                    <option value="Professional / Chartered" <?php if($cv[0]->aeducationlevel == "Professional / Chartered"){echo "SELECTED";}?>>Professional / Chartered</option>
                    <option value="MBA" <?php if($cv[0]->aeducationlevel == "MBA"){echo "SELECTED";}?>>MBA</option>
                    <option value="Doctorate / PhD" <?php if($cv[0]->aeducationlevel == "Doctorate / PhD"){echo "SELECTED";}?>>Doctorate / PhD</option>
                  </select>
                </div>
                <div class="col-xs-12 nopad boxinput">
                  <input type="text" name="graduation" id="graduation" class="inputjob" value="<?php echo $cv[0]->ayear;?>" placeholder="Year of Graduation (Optional)">
                </div>
                <div class="col-xs-12 nopad boxinput">
                  <textarea name="jobsummary" id="jobsummary" class="inputjob textarea" placeholder="Please summarise the kind of job you are looking for..."><?php echo $cv[0]->ajobsummary;?></textarea>
                </div>
              </div>
            </div>
          </div>
          <button type="submit" name="signup" id="signypbutton" class="btn pink right" style="margin-top: 0;">Submit Resume</button>
        </form>
        <?php } ?>
        </div>
        </div>
        
      </div>
    <?php /*?></form><?php */?>
  </div>
</div>
<?php require_once("common/footer.php");?>
<script language="javascript">
$('#contact').keyup(function() {
  if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
  if(this.value.length>= 15) 
  {
	alert('Maximum limit is 15'); return false;
  }
});
function checkspaces(val){
	if ( $.trim( $('#'+val).val() ) == '' )
    {
		$("#"+val).val('');
	}
}
$('#salaryfrom').keyup(function() {
  if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});
$('#cvtitle').keyup(function() {
  if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
    this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
  }
});
$('#zip').keyup(function() {
  if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});
$('#salaryto').keyup(function() {
  if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});
$('#graduation').keyup(function() {
  if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});

</script>
<script language="javascript">
 $(document).ready(function(e) {
   $('#sectorindu').select2({  placeholder: "Preferred Sector/Industry" }); 
   $('#location').select2({  placeholder: "Preferred Location" }); 
});
function buttondisabled(){
	$("#signypbutton").attr("diabled",true);
	$("#signypbutton").html('Please wait...');
	
}
</script>