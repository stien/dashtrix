<?php require_once("common/header.php");?>
<?php
error_reporting(0);
	if(isset($_SESSION['userID'])){
	$arr2      = array('uID' => $_SESSION['userID']);
	$config2   = $this->front_model->get_query_simple('*','dev_web_cv',$arr2);
	$cv		= $config2->result_object();
	// USER INFO
	$arr3      = array('uID' => $_SESSION['userID']);
	$config3   = $this->front_model->get_query_simple('*','dev_web_user',$arr3);
	$user	  = $config3->result_object();
?>
<div id="jobsectors" class="rightop clear left wd100">
  <div class="container">
   	<?php if(isset($_SESSION['msglogin'])){?>
    	<div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
    <?php } ?>
    <form name="loginform" id="loginform" action="<?php echo base_url(); ?>jobsite/do_create_cv_submit_upload" method="post" enctype="multipart/form-data">
      <div class="col-xs-12 nopad">
        <div class="col-xs-5 pr0 nopad">
          <div class="media left cv-inner wd100">
            <h4>Resume Management</h4>
            <div class="media-body  nopad coverletterbox col-xs-12">
              <p>Your current account information:</p>
              <div class="media-body nopad coverletterbox col-xs-12">
               
                <div class="col-xs-12 nopad boxinput">
                	
                  <input type="file" name="userfile" id="userfile" class="inputjob">
                  <br><span style="color:#f00;display: block;margin: 5px 0 0;">Only (PDF,DOC) file allowed... 2MB max file size</span>
                  <input type="hidden" name="cvID" id="cvID" class="inputjob" value="">
                </div>
               
                <div class="col-xs-12 nopad boxinput">
                  <select name="findcv" id="findcv" class="inputjob">
                    <option value="1" <?php if($cv[0]->cvView == 1){echo "SELECTED";}?>>Let recruiters find your CV</option>
                    <option value="0" <?php if($cv[0]->cvView == 1){echo "SELECTED";}?>>Hide your CV from recruiters</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="media left cv-inner wd100" style="min-height: 241px;">
            <h4>Preffered Job Details</h4>
            <div class="media-body nopad coverletterbox col-xs-12">
              <p>Please provide your preferred job details</p>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="jobtitle" id="jobtitle" required class="inputjob" value="<?php echo $cv[0]->pJobtitle;?>" placeholder="Job Title">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="skills" id="skills" required class="inputjob" value="<?php echo $cv[0]->pjobskills;?>" placeholder="Skills">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="location" id="location" required class="inputjob" value="<?php echo $cv[0]->pjoblocation;?>" placeholder="Location">
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
                  <option value="Any" <?php if($cv[0]->pjobtype == "Any"){echo "SELECTED";}?>>Any</option>
                  <option value="Permanent" <?php if($cv[0]->pjobtype == "Permanent"){echo "SELECTED";}?>>Permanent</option>
                  <option value="Contract" <?php if($cv[0]->pjobtype == "Contract"){echo "SELECTED";}?>>Contract</option>
                  <option value="Part Time" <?php if($cv[0]->pjobtype == "Part Time"){echo "SELECTED";}?>>Part Time</option>
                  <option value="Seasonal" <?php if($cv[0]->pjobtype == "Seasonal"){echo "SELECTED";}?>>Seasonal</option>
                </select>
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="number" name="salaryfrom" id="salaryfrom" required class="inputjob" value="<?php echo $cv[0]->psalaryfrom;?>" placeholder="Salary From">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="number" name="salaryto" id="salaryto" required class="inputjob" value="<?php echo $cv[0]->psalaryto;?>" placeholder="Salary To">
              </div>
            </div>
          </div>
          <div class="col-xs-12 nopad boxinput">
            <button type="submit" name="signup" class="btn pink">Save Profile & CV</button>
          </div>
        </div>
        <div class="col-xs-7">
          <div class="media cv-inner left wd100" style="min-height: 241px;">
            <h4>Your Details</h4>
            <div class="media-body nopad coverletterbox col-xs-12">
              <p>Please Update your cv information below</p>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="fname" id="fname" required class="inputjob" value="<?php echo $user[0]->uFname;?>" placeholder="First Name">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="lname" id="lname" required class="inputjob" value="<?php echo $user[0]->uLname;?>" placeholder="Last Name">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="date" name="dob" id="dob" required class="inputjob" value="<?php echo $user[0]->uDOB;?>" placeholder="Date of Birth">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <select name="country" id="country" class="inputjob" required>
                  <option value="">--- Select Country ---</option>
                  <?php 
				$arr3 = array();
				$config3 = $this->front_model->get_query_simple('*','dev_web_countries',$arr3);
				$countries 	= $config3->result_object();
				  foreach($countries as $country):?>
                  <option value="<?php echo $country->country_name;?>" <?php if($country->country_name == $user[0]->uCountry){ echo "SELECTED";}?>><?php echo $country->country_name;?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="address" id="address" required class="inputjob" value="<?php echo $user[0]->uAddress;?>" placeholder="Address">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="city" id="city" required class="inputjob" value="<?php echo $user[0]->uCity;?>" placeholder="City">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="zip" id="zip" required class="inputjob" value="<?php echo $user[0]->uZip;?>" placeholder="Zip Code">
              </div>
              <div class="col-xs-12 nopad boxinput">
                <input type="text" name="contact" id="contact" required class="inputjob" value="<?php echo $user[0]->uPhone;?>" placeholder="Contact Details">
              </div>
            </div>
          </div>
          <div class="media cv-inner left wd100">
            <h4>About You</h4>
            <div class="media-body nopad coverletterbox col-xs-12">
              <p>Please share information about you relevant to job</p>
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
                  <input type="number" name="graduation" id="graduation" class="inputjob" value="<?php echo $cv[0]->ayear;?>" placeholder="Year of Graduation (Optional)">
                </div>
                <div class="col-xs-12 nopad boxinput">
                  <textarea name="jobsummary" id="jobsummary" class="inputjob textarea" placeholder="Please summarise the kind of job you are looking for..."><?php echo $cv[0]->ajobsummary;?></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php }  else {
	header ( "Location:" . $this->config->base_url ()."signup");
	exit();
}?>
<?php require_once("common/footer.php");?>