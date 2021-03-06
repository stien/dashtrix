<?php 
ob_start();
error_reporting(0);
require_once("common/header.php");
?>
<?php 
if(isset($_GET['jid'])){
	$condition = array('JID' => $_GET['jid']);
	$usinfo =  $this->front_model->get_query_simple('*','dev_web_jobs',$condition);
	$job = $usinfo->result_object();
}
	$uID = isset($_GET['jid']) ? $job[0]->uID 	: 0;
	if($_GET['type'] == "previous"){
	$link = isset($_GET['jid']) ? 'do/post/job' 	: 'do/post/job';
	$edit = isset($_GET['jid']) ? 'Add New Job' 		: 'Add New Job';
	$jTitle = isset($_GET['jid']) ? '' 	: '';
	} else { 
	$link = isset($_GET['jid']) ? 'do/edit/job' 	: 'do/post/job';
	$edit = isset($_GET['jid']) ? 'Edit Job Information' 		: 'Add New Job';
	$jTitle = isset($_GET['jid']) ? $job[0]->jTitle 	: '';
	}
	
	$jType = isset($_GET['jid']) ? $job[0]->jType 	: 0;
	//$jTitle = isset($_GET['jid']) ? $job[0]->jTitle 	: '';
	$jDepartment = isset($_GET['jid']) ? $job[0]->jDepartment 	: 0;
	$cID = isset($_GET['jid']) ? $job[0]->cID 	: 0;
	$jCareerLevel = isset($_GET['jid']) ? $job[0]->jCareerLevel 	: 0;
	$jExpLevel = isset($_GET['jid']) ? $job[0]->jExpLevel 	: '';
	$jExpLevelmax = isset($_GET['jid']) ? $job[0]->jExpLevelmax 	: '';
	$jVacancy = isset($_GET['jid']) ? $job[0]->jVacancy 	: '';
	$jdisclose = isset($_GET['jid']) ? $job[0]->jNotDislosed 	: '1';
	$jDescription = isset($_GET['jid']) ? $job[0]->jDescription 	: '';
	$jRequiredSkills = isset($_GET['jid']) ? $job[0]->jRequiredSkills 	: '';
	$jQualification = isset($_GET['jid']) ? $job[0]->jQualification 	: '';
	$jSkillKeyword = isset($_GET['jid']) ? $job[0]->jSkillKeyword 	: '';
	$jNature = isset($_GET['jid']) ? $job[0]->jNature 	: 'Full-Time';
	$jShift = isset($_GET['jid']) ? $job[0]->jShift 	: 'Morning Shift';
	$jRequiredTravel = isset($_GET['jid']) ? $job[0]->jRequiredTravel 	: 0;
	$jGender = isset($_GET['jid']) ? $job[0]->jGender 	: '';
	$jCurrency = isset($_GET['jid']) ? $job[0]->jCurrency 	: '$';
	$jsalType = isset($_GET['jid']) ? $job[0]->jsalType 	: 'Anum';
	$jStartSalary = isset($_GET['jid']) ? $job[0]->jStartSalary 	: '';
	$jEndSalary = isset($_GET['jid']) ? $job[0]->jEndSalary 	: '';
	$salnotdis = isset($_GET['jid']) ? $job[0]->jSalHidden 	: '0';
	$jBenefits = isset($_GET['jid']) ? $job[0]->jBenefits 	: '';
	$jCountry = isset($_GET['jid']) ? $job[0]->jCoutry 	: '';
	$jCDisclose = isset($_GET['jid']) ? $job[0]->jCDisclose 	: '1';
	$jStateCity = isset($_GET['jid']) ? $job[0]->jStateCity 	: '';
	$jExpiry = isset($_GET['jid']) ? $job[0]->jExpiry 	: '';
	$jAfterExpiry = isset($_GET['jid']) ? $job[0]->jAfterExpiry 	: 1;
	$jEmailNotify = isset($_GET['jid']) ? $job[0]->jEmailNotify 	: 1;
	$jJobStatus = isset($_GET['jid']) ? $job[0]->jJobStatus 	: 1;
	$applyurl = isset($_GET['jid']) ? $job[0]->jDirectLink 	: '';
	$jID = isset($_GET['jid']) ? $job[0]->jID 	: '';

$ip=$_SERVER['REMOTE_ADDR'];
$addr_details = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
$city = stripslashes(ucfirst($addr_details['geoplugin_city']));
$countrycode = stripslashes(ucfirst($addr_details['geoplugin_countryCode']));
$countryip = stripslashes(ucfirst($addr_details['geoplugin_countryName']));
//error_reporting(-1);
$arrdd = array('uID' => UID);
$configdata	= $this->front_model->get_query_simple('*','dev_web_jobs',$arrdd);
$jobscount 	= $configdata->num_rows();
?>

<div id="loginbx">
  <div class="container">
    <div class="col-xs-12 bxlogin nopad">
    <form name="jobform" id="jobform" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?><?php echo $link;?>" onsubmit="return validateurl()">
      <div class="col-xs-6 nopad">
      <div class="login-inner2 left jobpost" style="  min-height: <?php if($jobscount > 1){echo '798px';} else {echo '730px';}?>; margin-right:0;">
        <h2><?php echo $edit;?>
          <div id="logingbar" class="right" style="font-size:12px;">
          <input type="checkbox" <?php if($jCDisclose == 0){echo "CHECKED";}?> name="chkdisclose" value="0" id="chkdisclose" style="margin-right: 5px;
  margin-top: 0px;
  float: left;" />Check if you don't want to Disclose Company Name</div>
        </h2>
        <?php if(isset($_SESSION['msglogin'])){?>
        <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
        <?php } ?>
        
        <?php 
		
			if($jobscount > 1){
				$rowjobs = $configdata->result_object();
		?>
          <div class="col-xs-12 nopad boxinput">
              <label> Previous Jobs: </label>
              <select name="previousjob" id="previousjob" class="selectbox inputjob" onchange="jobdetails(this.value)">
                      <option value="0">--- Select Your Previous Job ---</option>
                      <?php foreach($rowjobs as $jobp):?>
                      <option value="<?php echo $jobp->jID;?>" <?php if($jobp->jID == $_GET['jid']){echo "SELECTED";}?>><?php echo $jobp->jTitle;?></option>
                      <?php endforeach;?>
              </select>
            </div>
            
         <?php } ?>
          
          <div class="col-xs-12 nopad boxinput">
              <label> Job Title: <sup>*</sup></label>
              <input type="text" value="<?php echo $jTitle;?>" required name="jTitle" id="jTitle" class="inputjob" onblur="checkspaces('jTitle')" />
              <input type="hidden" value="<?php echo $jID;?>" required name="jID" id="jID" />
            </div>
       
				<div class="col-xs-12 nopad boxinput">
                  <label> Industry: <sup>*</sup></label>
                  <select name="industry" id="industry" required  class="selectbox inputjob">
                    <option value="">--- Select Industry ---</option>
                    <?php foreach($industry as $industrydata): ?>
                    <option value="<?php echo $industrydata->cID;?>" <?php if($cID == $industrydata->cID){echo "SELECTED";}?>><?php echo $industrydata->catName;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
           
            <div class="col-xs-12 nopad boxinput">
              <label> Career Level: <sup>*</sup></label>
              <select name="careerlevel" id="careerlevel" required  class="selectbox inputjob">
                      <option value="">--- Select Career Level ---</option>
                      <option value="1" <?php if($jCareerLevel == 1){echo "SELECTED";}?>>Entry Level</option>
                      <option value="2" <?php if($jCareerLevel == 2){echo "SELECTED";}?>>Executive (SVP, VP, HOD)</option>
                      <option value="3" <?php if($jCareerLevel == 3){echo "SELECTED";}?>>Experienced (Non-Managerial)</option>
                      <option value="4" <?php if($jCareerLevel == 4){echo "SELECTED";}?>>Manager/Supervisor</option>
                      <option value="5" <?php if($jCareerLevel == 5){echo "SELECTED";}?>>Sr. Executive (CEO/President)</option>
                      <option value="6" <?php if($jCareerLevel == 6){echo "SELECTED";}?>>Student (School/College)</option>
                      <option value="7" <?php if($jCareerLevel == 7){echo "SELECTED";}?>>Student (Undergrad./Grad.)</option>
              </select>
            </div>
            <div class="col-xs-12 nopad boxinput">
              <label> Experience Level: <sup>*</sup></label>
              <div class="col-xs-6 nopad">
              	<select name="explevelmin" id="explevelmin" required class="selectbox inputjob">
                        <option value="">--- Minimum Experience Level ---</option>
                        <?php for($i=0;$i<=25;$i++): ?>
                        <option value="<?php echo $i;?>" <?php if(isset($_GET['type']) && $_GET['type'] == "edit"){if($jExpLevel == $i){echo "SELECTED";}}?>><?php if($i == 0){echo '< 1';}else {echo $i;}?></option>
                        <?php endfor; ?>
						<option value="26">&gt; 25 Years</option>
                    </select>
              </div>
              <div class="col-xs-6 nopad">
              	<select name="explevelmax" id="explevelmax" required class="selectbox inputjob">
                        <option value="">--- Maximum Experience Level ---</option>
                        <?php for($i=0;$i<=25;$i++): ?>
                        <option value="<?php echo $i;?>" <?php if(isset($_GET['type']) && $_GET['type'] == "edit"){if($jExpLevelmax == $i){echo "SELECTED";}}?>><?php if($i == 0){echo '< 1';}else {echo $i;}?></option>
                        <?php endfor; ?>
						<option value="26">&gt; 25 Years</option>
                    </select>
              </div>
                    
            </div>
            <div class="col-xs-12 nopad boxinput">
              <label> Qualification: </label>
              <select name="qualification" id="qualification" class="inputjob" required="">
                    <option value="">--- Select Qualification ---</option>
                    <option value="No Formal Qualifications" <?php if($jQualification == "No Formal Qualifications"){echo "SELECTED";}?>>No Formal Qualifications</option>
                    <option value="A-Level" <?php if($jQualification == "A-Level"){echo "SELECTED";}?>>School Qualification / A-Level</option>
                    <option value="Vocational" <?php if($jQualification == "Vocational"){echo "SELECTED";}?>>Vocational</option>
                    <option value="Apprenticeship" <?php if($jQualification == "Apprenticeship"){echo "SELECTED";}?>>Apprenticeship</option>
                    <option value="Trade certification" <?php if($jQualification == "Trade certification"){echo "SELECTED";}?>>Trade certification</option>
                    <option value="Diploma/Certificate" <?php if($jQualification == "Diploma/Certificate"){echo "SELECTED";}?>>Diploma/Certificate</option>
                    <option value="Bachelors" <?php if($jQualification == "Bachelors"){echo "SELECTED";}?>>Bachelors</option>
                    <option value="Honours Degree" <?php if($jQualification == "Honours Degree"){echo "SELECTED";}?>>Honours Degree</option>
                    <option value="Masters Degree" <?php if($jQualification == "Masters Degree"){echo "SELECTED";}?>>Masters Degree</option>
                    <option value="Professional/Chartered" <?php if($jQualification == "Professional/Chartered"){echo "SELECTED";}?>>Professional / Chartered</option>
                    <option value="MBA" <?php if($jQualification == "MBA"){echo "SELECTED";}?>>MBA</option>
                    <option value="Doctorate/PhD" <?php if($jQualification == "Doctorate/PhD"){echo "SELECTED";}?>>Doctorate / PhD</option>
                  </select>
              <?php /*?><input type="text" value="<?php echo $jQualification;?>" class="inputjob" name="qualification" id="qualification" onblur="checkspaces('qualification')" /><?php */?>
            </div>
             <div class="col-xs-12 nopad boxinput">
              <label> Skills/Keyword: <small>(Full words & seperated by comma)</small> </label>
              <?php /*?><select name="skills" multiple="multiple" id="profiles-thread" class="js-data-example-ajax" class="inputjob selectbox" >
                    <option value=""></option>
              </select><?php */?>
              <select class="productName inputjob" name="productName" multiple="multiple"></select>

              <input type="text" value="<?php echo $jSkillKeyword;?>" class="inputjob" required="required" name="skillkeyword" id="profilesthread" placeholder="Customer Executive, Project Manager, Oracle etc" />
            </div>
            <div class="col-xs-12 nopad boxinput">
              <label> Job Description: <sup>*</sup></label>
              <textarea style="height:123px" name="jobDescp" id="jobDescp" class="textarea inputjob styletxtarea" required="required" onblur="checkspaces('jobDescp')"><?php echo strip_tags(htmlspecialchars_decode($jDescription));?></textarea>
            </div>
            
            <div class="col-xs-12 nopad boxinput">
              <label> Other Requirements: </label>
              <textarea name="reqSkilled" style="height:98px" id="reqSkilled" class="textarea inputjob styletxtarea" onblur="checkspaces('reqSkilled')"><?php echo strip_tags(htmlspecialchars_decode($jRequiredSkills));?></textarea>
            </div>

      </div>
      </div>
      <!--Sectors-->
      <div class="col-xs-6 pright0">
      <div class="login-inner2 left jobpost minheightjob" style="margin-right:0;  min-height: <?php if($jobscount > 1){echo '798px';} else {echo '730px';}?>;">
       <h2>Additional Information</h2>
  			
            <div class="col-xs-12 nopad boxinput">
              <label> No Of Vacanies: <span class="right"><input type="checkbox" value="0" name="notdis" id="notdis" <?php if($jdisclose == "0"){echo "CHECKED";}?> /> Not Disclosed</span></label>
              <input type="text" value="<?php echo $jVacancy;?>" name="vacancies" onblur="checkspaces('vacancies')" class="inputjob" id="vacancies" />
            </div>
            
            <div class="col-xs-12 nopad boxinput">
              <label> Type Of Job: <sup>*</sup></label>
             <select name="jobtype" id="jobtype" required  class="selectbox inputjob">
                       <option value="">--- Select Job Type ---</option>
                       <option value="Any" <?php if($jNature == "Any"){echo "SELECTED";}?>>Any</option>
                       <option value="Full-Time" <?php if($jNature == "Full-Time"){echo "SELECTED";}?>>Full-Time</option>
                       <option value="Internship" <?php if($jNature == "Internship"){echo "SELECTED";}?>>Internship</option>
                       <option value="Part-Time" <?php if($jNature == "Part-Time"){echo "SELECTED";}?>>Part-Time</option>
                       <option value="Per Diem" <?php if($jNature == "Per Diem"){echo "SELECTED";}?>>Per Diem</option>
                       <option value="Seasonal" <?php if($jNature == "Seasonal"){echo "SELECTED";}?>>Seasonal</option>
                       <option value="Temporary/Contract" <?php if($jNature == "Temporary/Contract"){echo "SELECTED";}?>>Temporary/Contract</option>
                       <option value="Volunteer" <?php if($jNature == "Volunteer"){echo "SELECTED";}?>>Volunteer</option>
                       <option value="Work Study" <?php if($jNature == "Work Study"){echo "SELECTED";}?>>Work Study</option>
                    </select>
            </div>
            <div class="col-xs-12 nopad boxinput">
              <label> Job Shift: </label>
               <select name="jobshift" id="jobshift"  class="selectbox inputjob">
                        <option value="">--- Select Shift ---</option>
                        <option value="Evening Shift" <?php if($jShift == "Evening Shift"){echo "SELECTED";}?>>Evening Shift</option>
                        <option value="Morning Shift" <?php if($jShift == "Morning Shift"){echo "SELECTED";}?>>Morning Shift</option>
                        <option value="Night Shift" <?php if($jShift == "Night Shift"){echo "SELECTED";}?>>Night Shift</option>
                        <option value="On Rotation" <?php if($jShift == "On Rotation"){echo "SELECTED";}?>>On Rotation</option>
                    </select>
            </div>
            <div class="col-xs-12 nopad boxinput">
              <label> Travel Required Level: </label>
              <select name="jobtravel" id="jobtravel"  class="selectbox inputjob">
                      <option value="1" <?php if($jRequiredTravel == 1){echo "SELECTED";}?>>Yes</option>
                      <option value="0" <?php if($jRequiredTravel == 0){echo "SELECTED";}?>>No</option>
              </select>
            </div>
             <div class="col-xs-12 nopad boxinput">
              <label> Gender: </label>
              <select name="jobGender" id="jobGender"  class="selectbox inputjob">
              		<option value="">--- Select Gender ---</option>
                      <option value="1" <?php if($jGender == 1){echo "SELECTED";}?>>Male</option>
                      <option value="2" <?php if($jGender == 2){echo "SELECTED";}?>>Female</option>
                      <option value="3" <?php if($jGender == 3){echo "SELECTED";}?>>Not Preffered</option>
              </select>
            </div>
            <div class="col-xs-12 nopad boxinput">
              <label> Salary: <sup>*</sup></label>
              <input type="text" value="<?php echo $jStartSalary;?>" class="inputjob" placeholder="Starting Salary" onblur="checkspaces('startsalary')" name="startsalary" id="startsalary" style="width:30%; margin-right:1%;" />
              <input type="text" value="<?php echo $jEndSalary;?>" placeholder="Ending Salary" class="inputjob" name="endsalary" id="endsalary" onblur="checkspaces('endsalary')" style="width:30%;margin-right:1%;"/>
              <select name="jCurrency" id="jCurrency"  required class="selectbox inputjob" style="width:16%">
              		<option value="">--- Currency ---</option>
                      <option value="$" <?php if($jCurrency == '$'){echo "SELECTED";}?>>$</option>
                      <option value="£" <?php if($jCurrency == '£'){echo "SELECTED";}?>>£</option>
                      <option value="€" <?php if($jCurrency == '€'){echo "SELECTED";}?>>€</option>
              </select>
              <select name="jsalType" id="jsalType"  required class="selectbox inputjob" style="width:20%">
              		<option value="">--- Salary Per Anum/Month ---</option>
                      <option value="Anum" <?php if($jsalType == 'Anum'){echo "SELECTED";}?>>Per Anum</option>
                      <option value="Month" <?php if($jsalType == 'Month'){echo "SELECTED";}?>>Per Month</option>
              </select>
              
              <span class="left" style="margin-top: 7px;"><input type="checkbox" value="1" <?php if($salnotdis == 1){echo "CHECKED";}?> name="salnotdis" id="salnotdis"> Hide salary from jobseeker</span>
            </div>
            <div class="col-xs-12 nopad boxinput">
                  <label> Benefits: <sup>*</sup></label>
                  <select name="benefits[]" id="benefits" multiple  class="selectbox inputjob">
                    <option value="">--- Select Benefits ---</option>
                    <?php 
						foreach($benefits as $benefit):
						$exp = explode(",",$jBenefits);
						foreach($exp as $be){
					 ?>
                    <option value="<?php echo $benefit->bID;?>" <?php if($benefit->bID == $be){echo "SELECTED";}?>><?php echo $benefit->bName;?></option>
                    <?php }
					endforeach;?>
                  </select>
                </div>
            <div class="col-xs-12 nopad boxinput">
                  <label> Job Location: <sup>*</sup></label>
                  <select name="jobLocation" id="jobLocation" required  class="selectbox inputjob" onchange="getcitiesname(this.value)">
                    <option value="">--- Select Job Location ---</option>
                    <?php 
					  $arrcn = array();
						$configcn 	= $this->front_model->get_query_simple('*','dev_web_countries',$arrcn);
						$countries 	= $configcn->result_object();
					  foreach($countries as $city):?>
                    <option value="<?php echo $city->country_name;?>" 
					<?php if(isset($_GET['jid'])){if($city->country_name == $jCountry){echo "SELECTED";}} else {if($city->country_name == $countryip){echo "SELECTED";}}?>><?php echo $city->country_name;?></option>
                    <?php endforeach;?>
                  </select>
                          
                          <div class="col-xs-12 nopad boxinput" style="margin-top: 8px;">
              <label> City: </label>
              <div id="citiesgermany">
              <select name="cityname[]" id="citynamegermany" multiple="multiple" class="selectbox inputjob" disabled="disabled" >
                    <option value="">--- Select City ---</option>
                        <option value="Berlin">Berlin</option>
                        <option value="Munich">Munich</option>
                        <option value="Hamburg">Hamburg</option>
                        <option value="Frankfurt am Main">Frankfurt am Main</option>
                        <option value="Cologne">Cologne</option>
                        <option value="Stuttgart">Stuttgart</option>
                        <option value="Dusseldorf">Dusseldorf</option>
                        <option value="Hannover">Hannover</option>
                        <option value="Leipzig">Leipzig</option>
                        <option value="Nuremberg">Nuremberg</option>
                        <option value="Dresden">Dresden</option>
                        <option value="Bremen">Bremen</option>
                        <option value="Food">Food</option>
                        <option value="Dortmund">Dortmund</option>
                  </select>
              </div>
              <div id="defaultcity">
              <input type="text" value="<?php echo $jStateCity;?>" name="cityname" onblur="checkspaces('citynamedata')" multiple="multiple" class="inputjob" id="citynamedata" />
             </div>
            </div>
            <div class="col-xs-12 nopad boxinput">
              <label> Notify Through Email When Applied: <sup>*</sup></label>
              <select name="jobNotify" id="jobNotify" required  class="selectbox inputjob">
              		<option value="">--- Select Email Notification ---</option>
                      <option value="1" <?php if($jEmailNotify == 1){echo "SELECTED";}?>>Yes</option>
                      <option value="2" <?php if($jEmailNotify == 2){echo "SELECTED";}?>>No</option>
              </select>
            </div>
            <div class="col-xs-12 nopad boxinput">
              <label> Direct Apply: <small>(Please provide url of site where user will apply for job)</small> </label>
              <input type="text" value="<?php echo $applyurl;?>" name="applyurl" onkeyup="validateurl()" onblur="checkspaces('applyurl')" class="inputjob" id="applyurl" />
             <div id="urlvalidate" style="display:none;color: #f00;
  display: block;
  float: right;
  margin-top: 8px;"></div>
            </div>
          </div>
      </div>
      </div>
     <!--COMPANY DETAILS-->
     <div class="col-xs-12 login-inner2 nopad boxinput" style="padding-bottom:0">
        <h2>Company Information</h2>
        <div class="col-xs-12" style="margin-top:10px;  min-height: 535px;">
        	<div class="col-xs-6 nopad">
            	<?php
					$arrcinfo 		= array('uID' => UID);
					$configcinfo	 = $this->front_model->get_query_simple('*','dev_web_user',$arrcinfo);					
					$cinfo 		   = $configcinfo->result_object(); 
				?>
            	<h2> <input type="checkbox" value="1" name="sameinfo" id="sameinfo" checked="checked" /> Same as my company info</h2>
                <div class="boxcoinfo">
                    <p><strong style="text-transform:uppercase;">Company Name</strong></p>
                        <?php echo $cinfo[0]->uCompany;?>
                    <p><strong style="text-transform:uppercase; margin-top:10px;display: block;">Company Name</strong></p>
                        <span style="text-align:justify; float:left;"><?php echo $cinfo[0]->uAbout;?></span>
                         <p><strong style="text-transform:uppercase; float:left; margin-top:10px;display: block; width:100%;">Company Website</strong></p>
                        <span style="text-align:justify; float:left; clear:both; width:100%;"><?php echo $cinfo[0]->uWebsite;?></span>
                         <p><strong style="text-transform:uppercase;float:left; margin-top:10px;display: block;width:100%;">Contact Person</strong></p>
                        <span style="text-align:justify; float:left;width:100%;"><?php echo $cinfo[0]->uFname." ".$cinfo[0]->uLname;?></span>
                         <p><strong style="text-transform:uppercase;float:left; margin-top:10px;display: block;width:100%;">Phone Number</strong></p>
                        <span style="text-align:justify; float:left;width:100%;"><?php echo $cinfo[0]->uPhone;?></span>
                         <p><strong style="text-transform:uppercase;float:left; margin-top:10px;display: block;width:100%;">Company Address</strong></p>
                        <span style="text-align:justify; float:left;width:100%;"><?php echo $cinfo[0]->uAddress;?></span>
                </div>
            </div>
            <div class="col-xs-1 nopad" style="  text-align: center;  line-height: 193px;">
            	OR
            </div>
            <div class="col-xs-5 nopad">
            <h2> Write Abouy Hiring Company</h2>
                <div class="boxcoinfo" style="background:none; border:none; padding:0px;">
                    <p><strong style="text-transform:uppercase;">Company Name</strong></p>
                       <input type="text" name="companyNamenew" id="companyNamenew" placeholder="Enter Company Name" class="inputjob" />
                    <p><strong style="text-transform:uppercase; margin-top:10px;display: block;">Company Name</strong></p>
                        <textarea name="companydetailsnew" id="companydetailsnew" class="textarea inputjob styletxtarea" style="height:147px" placeholder="Provide About Company Information"></textarea>
                        <div id="urlvalidatecom" style="display:none;color: #f00;
  display: block;
  float: right;
  margin-top: 8px;"></div>
                        <p><strong style="text-transform:uppercase;margin-top:10px;display: block; float:left;">Company Website</strong></p>
                       <input type="text" name="comwebsite" id="comwebsite" placeholder="Enter Company Website" onkeyup="validatecompanyurl()" class="inputjob" />
                        
                        <p><strong style="text-transform:uppercase;margin-top:10px;display: block; float:left;">Contact Person</strong></p>
                       <input type="text" name="contactperson" id="contactperson" placeholder="Enter Contact Person" class="inputjob" />
                       <p><strong style="text-transform:uppercase;margin-top:10px;display: block; float:left;">Phone Number</strong></p>
                       <input type="text" name="phonecom" id="phonecom" placeholder="Enter Phone Number" class="inputjob" />
                       <p><strong style="text-transform:uppercase;margin-top:10px;display: block; float:left;">Company Address</strong></p>
                       <input type="text" name="comAddress" id="comAddress" placeholder="Enter Company Address" class="inputjob" />
                        
                </div>
            </div>
        </div>
     </div>
     
     <div class="col-xs-12 nopad boxinput">
          <span style="margin-top: 10px;
  display: block;
  float: left;
  color: #f00;
  text-transform: uppercase;">* fields are mandatory</span> <button type="submit" name="signup" id="signupbtn" class="btn pink right">
           	<?php if(isset($_GET['jid'])){echo "Update Job";} else {echo 'Post New Job';}?></button> 
            <?php if(!isset($_GET['jid'])){ ?>
            <button type="submit" name="draftjob" id="draftjob" class="btn green right" style="margin-right:10px;">
            	Save as Draft
           	</button> 
            <?php } ?>
     </div>
     
    </form>   
      </div>
    </div>
  </div>
</div>

<?php require_once("common/footer.php");?>
<style>
.boxcoinfo {  float: left;
  width: 100%;
  border: 1px solid #ccc;
  padding: 14px;
  box-sizing: border-box;
  background-color: #fafafa;}
  /*#citiesgermany{ display:none;}*/
  .select2-container .select2-selection--multiple .select2-selection__rendered { padding-left:0 !important;}
</style>
<script language="javascript">
$( ".productName" ).select2({        
    ajax: {
        url: "<?php echo base_url();?>/jobsite/get_json_data",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term // search term
            };
        },
        processResults: function (data) {
            // parse the results into the format expected by Select2.
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data
            return {
                results: data
            };
        },
        cache: true
    },
    minimumInputLength: 2
});
$(document).ready(function(e) {
    $("#citiesgermany").hide();
});
function checkspaces(val){
	if ( $.trim( $('#'+val).val() ) == '' )
    {
		$("#"+val).val('');
	}
}
//$('#jTitle').keyup(function() {
//  if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
//    this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
//  } 
//});
/*$('#qualification').keyup(function() {
  if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
	$("#qualification").show();
    this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
  } 
});*/
$('#vacancies').keyup(function() {
  if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});
$('#startsalary').keyup(function() {
  if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});
$('#endsalary').keyup(function() {
  if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});

$('#sameinfo').click(function() {
    if(!$(this).is(':checked')) {
        
		$("#companyNamenew").attr("required","true");
		$("#companydetailsnew").attr("required","true");
    }
	else {
		$("#companyNamenew").removeAttr("required");
		$("#companydetailsnew").removeAttr("required");
	}
});
$('#companyNamenew').keyup(function() {
 if($("#companyNamenew").val() != ""){
	 $('#sameinfo').attr('checked', false);
	 $("#companyNamenew").attr("required",true);
		$("#companydetailsnew").attr("required",true);
 }
 if($("#companyNamenew").val() == ""){
	 $('#sameinfo').attr('checked', "true");
	 $("#companyNamenew").attr("required",false);
		$("#companydetailsnew").attr("required",false);
 }
});
function jobdetails(jid)
{
	if(jid == "0"){
		window.location = '<?php echo base_url();?>post-job';
	}else {
		window.location = '<?php echo base_url();?>post-job?type=previous&jid='+jid;
	}
}
function getcitiesname(val)
{
	if(val == "Germany"){
		$("#citynamegermany").attr("disabled",false);
		$("#citiesgermany").show();
		$("#defaultcity").hide();
		$("#citynamedata").attr("disabled",true);
		return false;
	}else {
		$("#citynamegermany").attr("disabled",true);
		$("#citiesgermany").hide();
		$("#defaultcity").show();
		$("#citynamedata").attr("disabled",false);
	}
}
</script>
<script language="javascript">
$('#benefits').select2({  placeholder: "Select Benefits" }); 
$('#jobLocation').select2({  placeholder: "Select Job Location" }); 
$('#citynamegermany').select2({  placeholder: "Type and select City" }); 
function validateurl(){
if($("#applyurl").val() != ""){
	var regex = new RegExp("^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?"); 
	var without_regex = new RegExp("^([0-9A-Za-z-\\.:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?");
	var str = $("#applyurl").val();
	if(regex.test(str) || without_regex.test(str)){
    $("#urlvalidate").html('');
	$("#urlvalidate").hide();
	return true;
	}
	else{
	$("#urlvalidate").html('Please provide URL only e.g: (www.google.com)');
		$("#urlvalidate").show();
		return false;
	}

}
}

function validatecompanyurl(){
if($("#comwebsite").val() != ""){
	var regex = new RegExp("^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?"); 
	var without_regex = new RegExp("^([0-9A-Za-z-\\.:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?");
	var str = $("#comwebsite").val();
	if(regex.test(str) || without_regex.test(str)){
    $("#urlvalidatecom").html('');
	$("#urlvalidatecom").hide();
	return true;
	}
	else{
	$("#urlvalidatecom").html('Please provide URL only e.g: (www.google.com)');
		$("#urlvalidatecom").show();
		return false;
	}

}
}
</script>