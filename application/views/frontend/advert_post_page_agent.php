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

	$link = isset($_GET['jid']) ? 'jobsite/edit_post_job_as_agent' 	: 'jobsite/post_job_as_agent';

	$edit = isset($_GET['jid']) ? 'Edit Job Information' 		: 'Add New Job';

	$jTitle = isset($_GET['jid']) ? $job[0]->jTitle 	: '';

	

	

	$jCName = isset($_GET['jid']) ? $job[0]->jCName 	: '';

	$jCInfo = isset($_GET['jid']) ? $job[0]->jCInfo 	: '';

	$jCWeb = isset($_GET['jid']) ? $job[0]->jCWeb 	: '';

	$jCPerson = isset($_GET['jid']) ? $job[0]->jCPerson 	: '';

	$jCPhone = isset($_GET['jid']) ? $job[0]->jCPhone 	: '';

	$jCAddress = isset($_GET['jid']) ? $job[0]->jCAddress 	: '';

	

	$jType = isset($_GET['jid']) ? $job[0]->jType 	: 0;

	//$jTitle = isset($_GET['jid']) ? $job[0]->jTitle 	: '';

	$jDepartment = isset($_GET['jid']) ? $job[0]->jDepartment 	: 0;

	$jSpecialization = isset($_GET['jid']) ? $job[0]->jSpecialization 	: "";

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

	$sourceurl = isset($_GET['jid']) ? $job[0]->jSource 	: '';

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



<div id="loginbx" >

  <div class="container">

    <div class="col-xs-12 bxlogin nopad" style="margin-top:10px; float:left;">

    <form name="jobform" id="jobform" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?><?php echo $link;?>" onsubmit="return validateurl()">

      <div class="col-xs-6 nopad">

      <div class="login-inner2 left jobpost" style="  min-height: <?php if($jobscount > 1){echo '791px';} else {echo '869px';}?>; margin-right:0;">

        <h2><?php echo $edit;?>

          <div id="logingbar" class="right" style="font-size:12px;">

          <input type="checkbox" <?php if($jCDisclose == 0){echo "CHECKED";}?> name="chkdisclose" value="0" id="chkdisclose" style="margin-right: 5px;

  margin-top: 0px;

  float: left;" />Check if you don't want to Disclose Company Name</div>

        </h2>

        <?php if(isset($_SESSION['msglogin'])){?>

        <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>

        <?php } ?>

        <?php if(!isset($_GET['jid'])){ ?>

          <div class="col-xs-12 nopad boxinput">

              <label> Company Website URL: </label>

              <input type="text" value="" required name="jweburl" onkeyup="validatecompanyurl()" id="jweburl" class="inputjob" onblur="getcompanynamedb()" />

              <div id="urlcheckdb" style="display:none;color: #f00;

          display: block;

          float: right;

          margin-top: 8px;"></div>

            </div>

            <?php } ?>

            <div class="boxcompanyinfo" id="companynewinfo" style=" <?php if(isset($_GET['jid'])){echo 'display:block;';}else {echo 'display:none;';}?>">

           <?php if(!isset($_GET['jid'])){?> <p style="  text-align: center;

  color: #f00;

  margin-bottom: 12px;">Company information not found in records, please add new company information below!</p>

  <?php } ?>

            <div class="col-xs-12 nopad boxinput">

             <label>Company Name</label>

             <input type="text" name="companyNamenew" id="companyNamenew" placeholder="Enter Company Name" class="inputjob" onblur="checkspaces('companyNamenew')" <?php if(isset($_GET['jid'])){?>required value="<?php echo $jCName;?>"<?php }?> />

            </div>

            <?php if(!isset($_GET['jid'])){?>

            <div class="col-xs-12 nopad boxinput">

             <label>Company Email Address</label>

             <input type="email" name="companyemailAdd" id="companyemailAdd" placeholder="Enter Company Email Address" class="inputjob" onblur="checkspaces('companyemailAdd')" />

            </div>

            <?php } ?>

            <div class="col-xs-12 nopad boxinput">

               <label>About Company</label>

               <textarea name="companydetailsnew" <?php if(isset($_GET['jid'])){?>required <?php }?> id="companydetailsnew" class="textarea inputjob styletxtarea" style="height:100px; resize:vertical !important;" placeholder="Provide About Company Information" onblur="checkspaces('companydetailsnew')"><?php echo $jCInfo;?></textarea>

            </div>

            <div class="col-xs-12 nopad boxinput">     

                <label>Contact Person</label>

               <input type="text" name="contactperson" onblur="checkspaces('contactperson')" id="contactperson" <?php if(isset($_GET['jid'])){?>required value="<?php echo $jCPerson;?>"<?php }?> placeholder="Enter Contact Person" class="inputjob" />

            </div>

            <div class="col-xs-12 nopad boxinput">        

               <label>Phone Number</label>

               <input type="text" name="phonecom" onblur="checkspaces('phonecom')" id="phonecom" placeholder="Enter Phone Number" <?php if(isset($_GET['jid'])){?>required value="<?php echo $jCPhone;?>"<?php }?> class="inputjob" />

           	</div>

            <div class="col-xs-12 nopad boxinput">     

               <label>Company Address</label>

               <input type="text" name="comAddress" <?php if(isset($_GET['jid'])){?> value="<?php echo $jCAddress;?>"<?php }?> onblur="checkspaces('comAddress')" id="comAddress" placeholder="Enter Company Address" class="inputjob" />

              </div>

          </div>

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

              <label> Qualification: <sup>*</sup></label>

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

             <?php /*?> <input type="text" value="<?php echo $jQualification;?>" class="inputjob" name="qualification" id="qualification" onblur="checkspaces('qualification')" /><?php */?>

            </div>

            <div class="col-xs-12 nopad boxinput">

              <label> Specialization : </label>

              <select name="specialization[]" multiple="multiple" id="specialization" class="inputjob">

                    <option value="">--- Select specialization ---</option>

                   <optgroup label="Arts">

                        <option value="All - Arts" <?php if($jSpecialization == "All - Arts"){echo "SELECTED";}?>>All - Arts</option>

                        <option value="Anthropology" <?php if($jSpecialization == "Anthropology"){echo "SELECTED";}?>>Anthropology</option>

                        <option value="Archaeology" <?php if($jSpecialization == "Archaeology"){echo "SELECTED";}?>>Archaeology</option>

                        <option value="Arts" <?php if($jSpecialization == "Arts"){echo "SELECTED";}?>>Arts</option>

                        <option value="Communication - Advertising & PR" <?php if($jSpecialization == "Communication - Advertising & PR"){echo "SELECTED";}?>>Communication - Advertising & PR</option>

                        <option value="Communication - Journalism" <?php if($jSpecialization == "Communication - Journalism"){echo "SELECTED";}?>>Communication - Journalism</option>

                        <option value="Communication - Tech. Writing" <?php if($jSpecialization == "Communication - Tech. Writing"){echo "SELECTED";}?>>Communication - Tech. Writing</option>

                        <option value="Economics / Econometrics" <?php if($jSpecialization == "Economics / Econometrics"){echo "SELECTED";}?>>Economics / Econometrics</option>

                        <option value="Geography" <?php if($jSpecialization == "Geography"){echo "SELECTED";}?>>Geography</option>

                        <option value="Geology" <?php if($jSpecialization == "Geology"){echo "SELECTED";}?>>Geology</option>

                        <option value="History" <?php if($jSpecialization == "History"){echo "SELECTED";}?>>History</option>

                        <option value="Language & Literature - English" <?php if($jSpecialization == "Language & Literature - English"){echo "SELECTED";}?>>Language & Literature - English</option>

                        <option value="Language & Literature - French" <?php if($jSpecialization == "Language & Literature - French"){echo "SELECTED";}?>>Language & Literature - French</option>

                        <option value="Language & Literature - German" <?php if($jSpecialization == "Language & Literature - German"){echo "SELECTED";}?>>Language & Literature - German</option>

                        <option value="Language & Literature - Hindi" <?php if($jSpecialization == "Language & Literature - Hindi"){echo "SELECTED";}?>>Language & Literature - Hindi</option>

                        <option value="Language & Literature - Japanese" <?php if($jSpecialization == "Language & Literature - Japanese"){echo "SELECTED";}?>>Language & Literature - Japanese</option>

                        <option value="Language & Literature - Mandarin" <?php if($jSpecialization == "Language & Literature - Mandarin"){echo "SELECTED";}?>>Language & Literature - Mandarin</option>

                        <option value="Language & Literature - Sanskrit" <?php if($jSpecialization == "Language & Literature - Sanskrit"){echo "SELECTED";}?>>Language & Literature - Sanskrit</option>

                        <option value="Language & Literature - Spanish" <?php if($jSpecialization == "Language & Literature - Spanish"){echo "SELECTED";}?>>Language & Literature - Spanish</option>

                        <option value="Maths" <?php if($jSpecialization == "Maths"){echo "SELECTED";}?>>Maths</option>

                        <option value="Performing Arts - Dance" <?php if($jSpecialization == "Performing Arts - Dance"){echo "SELECTED";}?>>Performing Arts - Dance</option>

                        <option value="Performing Arts - Film & Television" <?php if($jSpecialization == "Performing Arts - Film & Television"){echo "SELECTED";}?>>Performing Arts - Film & Television</option>

                        <option value="Performing Arts - Music" <?php if($jSpecialization == "Performing Arts - Music"){echo "SELECTED";}?>>Performing Arts - Music</option>

                        <option value="Performing Arts - Theatre" <?php if($jSpecialization == "Performing Arts - Theatre"){echo "SELECTED";}?>>Performing Arts - Theatre</option>

                        <option value="Philosophy" <?php if($jSpecialization == "Philosophy"){echo "SELECTED";}?>>Philosophy</option>

                        <option value="Political Science" <?php if($jSpecialization == "Political Science"){echo "SELECTED";}?>>Political Science</option>

                        <option value="Psychology" <?php if($jSpecialization == "Psychology"){echo "SELECTED";}?>>Psychology</option>

                        <option value="Public Administration" <?php if($jSpecialization == "Public Administration"){echo "SELECTED";}?>>Public Administration</option>

                        <option value="Public Policy" <?php if($jSpecialization == "Public Policy"){echo "SELECTED";}?>>Public Policy</option>

                        <option value="Sociology" <?php if($jSpecialization == "Sociology"){echo "SELECTED";}?>>Sociology</option>

                        <option value="Visual Arts - Fine Arts" <?php if($jSpecialization == "Visual Arts - Fine Arts"){echo "SELECTED";}?>>Visual Arts - Fine Arts</option>

                        <option value="Visual Arts - Photography" <?php if($jSpecialization == "Visual Arts - Photography"){echo "SELECTED";}?>>Visual Arts - Photography</option>                        

                   </optgroup>

                   <optgroup label="Aviation">

                   <option value="All - Aviation" <?php if($jSpecialization == "All - Aviation"){echo "SELECTED";}?>>All - Aviation</option>

                   <option value="ALTP" <?php if($jSpecialization == "ALTP"){echo "SELECTED";}?>>ALTP</option>

                   <option value="CPL" <?php if($jSpecialization == "CPL"){echo "SELECTED";}?>>CPL</option>

                   </optgroup>

                   <optgroup label="Chartered Accountant / CFA / CWA">

                   <option value="All - Chartered Accountant / CFA / CWA" <?php if($jSpecialization == "All - Chartered Accountant / CFA / CWA"){echo "SELECTED";}?>>All - Chartered Accountant / CFA / CWA</option>

                   <option value="CA" <?php if($jSpecialization == "CA"){echo "SELECTED";}?>>CA</option>

                   <option value="CFA" <?php if($jSpecialization == "CFA"){echo "SELECTED";}?>>CFA</option>

                   <option value="CWA" <?php if($jSpecialization == "CWA"){echo "SELECTED";}?>>CWA</option>

                   </optgroup>

                   <optgroup label="Commerce">

                   <option value="All - Commerce" <?php if($jSpecialization == "All - Commerce"){echo "SELECTED";}?>>All - Commerce</option>

                   <option value="Commerce" <?php if($jSpecialization == "Commerce"){echo "SELECTED";}?>>Commerce</option>

                   </optgroup>

                   <optgroup label="Company Secretary">

                   <option value="All - Company Secretary" <?php if($jSpecialization == "All - Company Secretary"){echo "SELECTED";}?>>All - Company Secretary</option>

                   <option value="Company Secretary" <?php if($jSpecialization == "Company Secretary"){echo "SELECTED";}?>>Company Secretary</option>

                   </optgroup>

                   <optgroup label="Computer Application">

                   <option value="All - Computer Application" <?php if($jSpecialization == "All - Computer Application"){echo "SELECTED";}?>>All - Computer Application</option>

                   <option value="Computer Application" <?php if($jSpecialization == "Computer Application"){echo "SELECTED";}?>>Computer Application</option>

                   <option value="BCA /MCA" <?php if($jSpecialization == "BCA /MCA"){echo "SELECTED";}?>>BCA /MCA</option>

                   <option value="Computer / IT / Software Engineering" <?php if($jSpecialization == "Computer / IT / Software Engineering"){echo "SELECTED";}?>>Computer / IT / Software Engineering</option>

                   <option value="Computers / IT / Software - Science" <?php if($jSpecialization == "Computers / IT / Software - Science"){echo "SELECTED";}?>>Computers / IT / Software - Science</option>

                   </optgroup>

                   <optgroup label="Design">

                   <option value="All - Design" <?php if($jSpecialization == "All - Design"){echo "SELECTED";}?>>All - Design</option>

                   <option value="Fashion" <?php if($jSpecialization == "Fashion"){echo "SELECTED";}?>>Fashion</option>

                   <option value="Graphics" <?php if($jSpecialization == "Graphics"){echo "SELECTED";}?>>Graphics</option>

                   <option value="Industrial" <?php if($jSpecialization == "Industrial"){echo "SELECTED";}?>>Industrial</option>

                   </optgroup>

                   <optgroup label="Education">

                   <option value="All - Education" <?php if($jSpecialization == "All - Education"){echo "SELECTED";}?>>All - Education</option>

                   <option value="Education" <?php if($jSpecialization == "Education"){echo "SELECTED";}?>>Education</option>

                   </optgroup>

                   <optgroup label="Engineering">

                   <option value="All - Engineering">All - Engineering</option>

                   <option value="Education">Education</option>

                   <option value="Aeronautics Engineering">Aeronautics Engineering</option>

                   <option value="Agriculture / Dairy Engineering">Agriculture / Dairy Engineering</option>

                   <option value="Architecture Engineering">Architecture Engineering</option>

                   <option value="Biomedical Engineering">Biomedical Engineering</option>

                   <option value="Biotechnology Engineering">Biotechnology Engineering</option>

                   <option value="Chemical Engineering">Chemical Engineering</option>

                   <option value="Civil Engineering">Civil Engineering</option>

                   <option value="Computer / IT / Software Engineering">Computer / IT / Software Engineering</option>

                   <option value="Electrical Engineering">Electrical Engineering</option>

                   <option value="Electronics and Communication Engineering">Electronics and Communication Engineering</option>

                   <option value="Environmental Engineering">Environmental Engineering</option>

                   <option value="Food Technology Engineering">Food Technology Engineering</option>

                   <option value="Forestry Engineering">Forestry Engineering</option>

                   <option value="Industrial and Production Engineering">Industrial and Production Engineering</option>

                   <option value="Instrumentation Engineering">Instrumentation Engineering</option>

                   <option value="Marine Engineering">Marine Engineering</option>

                   <option value="Materials Engineering">Materials Engineering</option>

                   <option value="Mechanical Engineering">Mechanical Engineering</option>

                   <option value="Metallurgy Engineering">Metallurgy Engineering</option>

                   <option value="Mining Engineering">Mining Engineering</option>

                   <option value="Nuclear Engineering">Nuclear Engineering</option>

                   <option value="Optics Engineering">Optics Engineering</option>

                   <option value="Other Engineering">Other Engineering</option>

                   <option value="Textile Engineering">Textile Engineering</option>

                   </optgroup>

                   <optgroup label="Hospitality and Hotel Management">

                   <option value="All - Hospitality and Hotel Management" <?php if($jSpecialization == "All - Hospitality and Hotel Management"){echo "SELECTED";}?>>All - Hospitality and Hotel Management</option>

                   <option value="Hospitality and Hotel Management" <?php if($jSpecialization == "Hospitality and Hotel Management"){echo "SELECTED";}?>>Hospitality and Hotel Management</option>

                   </optgroup>

                   <optgroup label="Journalism / Communication">

                   <option value="All - Journalism / Communication" <?php if($jSpecialization == "All - Journalism / Communication"){echo "SELECTED";}?>>All - Journalism / Communication</option>

                   <option value="Communication - Advertising & PR" <?php if($jSpecialization == "Communication - Advertising & PR"){echo "SELECTED";}?>>Communication - Advertising & PR</option>

                   <option value="Communication - Journalism" <?php if($jSpecialization == "Communication - Journalism"){echo "SELECTED";}?>>Communication - Journalism</option>

                   <option value="Communication - Tech. Writing" <?php if($jSpecialization == "Communication - Tech. Writing"){echo "SELECTED";}?>>Communication - Tech. Writing</option>

                   </optgroup>

                   <optgroup label="Law">

                   <option value="All - Law" <?php if($jSpecialization == "All - Law"){echo "SELECTED";}?>>All - Law</option>

                   <option value="Law" <?php if($jSpecialization == "Law"){echo "SELECTED";}?>>Law</option>

                   </optgroup>

                   <optgroup label="Management">

                   <option value="All - Management" <?php if($jSpecialization == "All - Management"){echo "SELECTED";}?>>All - Management</option>

                   <option value="Finance" <?php if($jSpecialization == "Finance"){echo "SELECTED";}?>>Finance</option>

                   <option value="General" <?php if($jSpecialization == "General"){echo "SELECTED";}?>>General</option>

                   <option value="HR" <?php if($jSpecialization == "HR"){echo "SELECTED";}?>>HR</option>

                   <option value="International Trade" <?php if($jSpecialization == "International Trade"){echo "SELECTED";}?>>International Trade</option>

                   <option value="Marketing" <?php if($jSpecialization == "Marketing"){echo "SELECTED";}?>>Marketing</option>

                   <option value="MIS Management" <?php if($jSpecialization == "MIS Management"){echo "SELECTED";}?>>MIS Management</option>

                   <option value="Operations Management" <?php if($jSpecialization == "Operations Management"){echo "SELECTED";}?>>Operations Management</option>

                   <option value="Other Management" <?php if($jSpecialization == "Other Management"){echo "SELECTED";}?>>Other Management</option>

                   </optgroup>

                   <optgroup label="Medical">

                   <option value="All - Medical">All - Medical</option>

                   <option value="Anaesthesia">Anaesthesia</option>

                   <option value="Cardiology">Cardiology</option>

                   <option value="Dentistry">Dentistry</option>

                   <option value="Dentistry - Orthodontics">Dentistry - Orthodontics</option>

                   <option value="Dentistry - Periodontics">Dentistry - Periodontics</option>

                   <option value="Dentistry - Surgery">Dentistry - Surgery</option>

                   <option value="Gynaecology">Gynaecology</option>

                   <option value="Medicine">Medicine</option>

                   <option value="Neurology">Neurology</option>

                   <option value="Opthalmology">Opthalmology</option>

                   <option value="Orthopedics">Orthopedics</option>

                   <option value="Other Medical">Other Medical</option>

                   <option value="Pathology">Pathology</option>

                   <option value="Pediatrics">Pediatrics</option>

                   <option value="Psyciatry">Psyciatry</option>

                   <option value="Radiology">Radiology</option>

                   <option value="Sports Medicine">Sports Medicine</option>

                   <option value="Surgery">Surgery</option>

                   </optgroup>

                   <optgroup label="Pharmacy">

                   <option value="All - Pharmacy" <?php if($jSpecialization == "All - Pharmacy"){echo "SELECTED";}?>>All - Pharmacy</option>

                   <option value="Pharmacy" <?php if($jSpecialization == "Pharmacy"){echo "SELECTED";}?>>Pharmacy</option>

                   </optgroup>

                   <optgroup label="Science">

                   <option value="All - Science">All - Science</option>

                   <option value="Agriculture & Dairy">Agriculture & Dairy</option>

                   <option value="Biology">Biology</option>

                   <option value="Biology - Anatomy">Biology - Anatomy</option>

                   <option value="Biology - Biochemistry">Biology - Biochemistry</option>

                   <option value="Biology - Biophysics">Biology - Biophysics</option>

                   <option value="Biology - Botany">Biology - Botany</option>

                   <option value="Biology - Ecology">Biology - Ecology</option>

                   <option value="Biology - Forensics">Biology - Forensics</option>

                   <option value="Biology - Genetics">Biology - Genetics</option>

                   <option value="Biology - Microbiology">Biology - Microbiology</option>

                   <option value="Biology - Molecular Biology">Biology - Molecular Biology</option>

                   <option value="Biology - Neuroscience">Biology - Neuroscience</option>

                   <option value="Biology - Pathology">Biology - Pathology</option>

                   <option value="Biology - Physiology">Biology - Physiology</option>

                   <option value="Biology - Zoology">Biology - Zoology</option>

                   <option value="Chemistry">Chemistry</option>

                   <option value="Chemistry - Inorganic">Chemistry - Inorganic</option>

                   <option value="Chemistry - Organic">Chemistry - Organic</option>

                   <option value="Chemistry - Physical">Chemistry - Physical</option>

                   <option value="Computers / IT / Software - Science">Computers / IT / Software - Science</option>

                   <option value="Economics / Econometrics">Economics / Econometrics</option>

                   <option value="Biology">Biology</option>

                   <option value="Electronics / Communication / Instrumentation">Electronics / Communication / Instrumentation</option>

                   <option value="Environment">Environment</option>

                   <option value="Food Technology">Food Technology</option>

                   <option value="Forestry">Forestry</option>

                   <option value="Geography">Geography</option>

                   <option value="Geology">Geology</option>

                   <option value="Home Science">Home Science</option>

                   <option value="Maths">Maths</option>

                   <option value="Maths - Algebra">Maths - Algebra</option>

                   <option value="Maths - Geometry">Maths - Geometry</option>

                   <option value="Maths - Logic and Set Theory">Maths - Logic and Set Theory</option>

                   <option value="Maths - Number Theory">Maths - Number Theory</option>

                   <option value="Maths - Probability">Maths - Probability</option>

                   <option value="Maths - Statistics">BioMaths - Statistics</option>

                   <option value="Med. Allied - Nursing">Med. Allied - Nursing</option>

                   <option value="Maths - Algebra">Maths - Algebra</option>

                   <option value="Med. Allied - Nutrition & Dietetics">Med. Allied - Nutrition & Dietetics</option>

                   <option value="Med. Allied - Optometry">Med. Allied - Optometry</option>

                   <option value="Med. Allied - Physiotherapy">Med. Allied - Physiotherapy</option>

                   <option value="Med. Allied - Speech Therapy">Med. Allied - Speech Therapy</option>

                   <option value="Military Science">Military Science</option>

                   <option value="Other Science">Other Science</option>

                   <option value="Physics">Physics</option>

                   <option value="Physics - Applied Physics">Physics - Applied Physics</option>

                   <option value="Physics - Astronomy">Physics - Astronomy</option>

                   <option value="Physics - Astrophysics">Physics - Astrophysics</option>

                   <option value="Physics - Dynamics">Physics - Dynamics</option>

                   <option value="Physics - Mechanics">Physics - Mechanics</option>

                   <option value="Physics - Molecular Physics">Physics - Molecular Physics</option>

                   <option value="Physics - Nuclear Physics">Physics - Nuclear Physics</option>

                   <option value="Physics - Optics">Physics - Optics</option>

                   <option value="Science">Science</option>

                   <option value="Textile Design">Textile Design</option>

                   </optgroup>

                   <optgroup label="Veterinary Science">

                   <option value="All - Veterinary Science" <?php if($jSpecialization == "All - Veterinary Science"){echo "SELECTED";}?>>All - Veterinary Science</option>

                   <option value="Veterinary Science" <?php if($jSpecialization == "Veterinary Science"){echo "SELECTED";}?>>Veterinary Science</option>

                   </optgroup>

                   <optgroup label="Other">

                   <option value="All - Other" <?php if($jSpecialization == "All - Other"){echo "SELECTED";}?>>All - Other</option>

                   <option value="Other" <?php if($jSpecialization == "Other"){echo "SELECTED";}?>>Other</option>

                   </optgroup>

                   </select>

            </div>

             <div class="col-xs-12 nopad boxinput">

              <label> Skills/Keyword: <sup>*</sup> <small>(Full words & seperated by comma)</small> </label>

              <input type="text" value="<?php echo $jSkillKeyword;?>" class="inputjob" required="required" name="skillkeyword" id="skillkeyword" onblur="checkspaces('skillkeyword')" placeholder="Customer Executive, Project Manager, Oracle etc" />

            </div>

            <div class="col-xs-12 nopad boxinput">

              <label> Job Description: <sup>*</sup></label>

              <textarea style="height:123px;resize:vertical !important;" name="jobDescp" id="jobDescp" class="textarea inputjob styletxtarea" required="required" onblur="checkspaces('jobDescp')"><?php echo strip_tags(htmlspecialchars_decode($jDescription));?></textarea>

            </div>

            

            <div class="col-xs-12 nopad boxinput">

              <label> Other Requirements: </label>

              <textarea name="reqSkilled" style="height:98px;resize:vertical !important;" id="reqSkilled" class="textarea inputjob styletxtarea" onblur="checkspaces('reqSkilled')"><?php echo strip_tags(htmlspecialchars_decode($jRequiredSkills));?></textarea>

            </div>



      </div>

      </div>

      <!--Sectors-->

      <div class="col-xs-6 pright0">

      <div class="login-inner2 left jobpost minheightjob" style="margin-right:0;  min-height: <?php if($jobscount > 1){echo '791px';} else {echo '869px';}?>;">

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

              <label> Job Shift: <sup>*</sup></label>

               <select name="jobshift" id="jobshift"  required class="selectbox inputjob">

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

              <select name="jCurrency" id="jCurrency" class="selectbox inputjob" style="width:16%">

              		<option value="">--- Currency ---</option>

                      <option value="$" <?php if($jCurrency == '$'){echo "SELECTED";}?>>$</option>

                      <option value="£" <?php if($jCurrency == '£'){echo "SELECTED";}?>>£</option>

                      <option value="€" <?php if($jCurrency == '€'){echo "SELECTED";}?>>€</option>

              </select>

              <select name="jsalType" id="jsalType" class="selectbox inputjob" style="width:20%">

              		<option value="">--- Salary Per Annum/Month ---</option>

                      <option value="Anum" <?php if($jsalType == 'Annum'){echo "SELECTED";}?>>Per Annum</option>

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

                       <div class="col-xs-12 nopad boxinput" style="margin-top:8px;">

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

              <input type="text" value="<?php echo $jStateCity;?>" name="cityname[]" onblur="checkspaces('citynamedata')" multiple="multiple" class="inputjob" id="citynamedata" />

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

             

            </div>

            

            <div class="col-xs-12 nopad boxinput">

              <label> Source Website URL: (If Applicable) <small>(Please provide url of site from where you copy the job information)</small> </label>

              <input type="text" value="<?php echo $sourceurl;?>" required="required" name="sourcewebsite" onkeyup="validateurlsoruce()" onblur="checkspaces('sourcewebsite')" class="inputjob" id="sourcewebsite" />

             <div id="urlvalidate" style="display:none;color: #f00;

  display: block;

  float: right;

  margin-top: 8px;"></div>

            </div>

          </div>

      </div>

      </div>

     <!--COMPANY DETAILS-->

     

     

     <div class="col-xs-12 nopad boxinput">

          <span style="margin-top: 10px;

  display: block;

  float: left;

  color: #f00;

  text-transform: uppercase;">* fields are mandatory</span> <button type="submit" name="signup" id="signupbtn" class="btn pink right">

           	<?php if(isset($_GET['jid'])){echo "Update Job";} else {echo 'Post New Job';}?></button> 

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

  .boxcompanyinfo {  background: #f0f0f0;

  float: left;

  padding: 13px;

  border: 1px solid #ccc;

  margin-bottom: 5px;}

</style>

<script language="javascript">

$(function () {
            $('input').blur(function () {                     
                $(this).val(
                    $.trim($(this).val())
                );
            });
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

</script>

<script language="javascript">

$('#benefits').select2({  placeholder: "Select Benefits" }); 

$('#jobLocation').select2({  placeholder: "Select Job Location" }); 

$('#citynamegermany').select2({  placeholder: "Type and select City" });

$('#specialization').select2({  placeholder: "Type and select Specialization" }); 

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



}}

function validateurlsoruce(){

if($("#sourcewebsite").val() != ""){

	var regex = new RegExp("^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?"); 

	var without_regex = new RegExp("^([0-9A-Za-z-\\.:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?");

	var str = $("#sourcewebsite").val();

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



}}

function validatecompanyurl(){

if($("#jweburl").val() != ""){

	var regex = new RegExp("^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?"); 

	var without_regex = new RegExp("^([0-9A-Za-z-\\.:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?");

	var str = $("#jweburl").val();

	if(regex.test(str) || without_regex.test(str)){

    $("#urlcheckdb").html('');

	$("#urlcheckdb").hide();

	return true;

	}

	else{

	$("#urlcheckdb").html('Please provide URL only e.g: (www.google.com)');

		$("#urlcheckdb").show();

		return false;

	}



}}



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

$('#explevelmin').change(

    function() {

        var val1 = $('#explevelmax option:selected').val();

        var val2 = $('#explevelmin option:selected').val();

	$("#explevelmax").val(parseInt(val2)+1);

        // Do something with val1 and val2 ...

    }

);

function getcompanynamedb(){		

		var autoURL = "<?php echo base_url(); ?>jobsite/check_website_found?rnd=" + Math.random()+"&url="+$("#jweburl").val();

		$.ajax({

				url : autoURL,

				async: true,

				cache: false,

				method : "POST",

				success : function(responseshow)

				{

					if(responseshow == 2){

						$("#companynewinfo").show();

						$("#companyNamenew").attr("required",true);

						$("#companyemailAdd").attr("required",true);

						$("#companydetailsnew").attr("required",true);

						$("#contactperson").attr("required",true);

						$("#phonecom").attr("required",true);

						$("#comAddress").attr("required",true);

					}else {

						$("#companynewinfo").hide();

						$("#companyNamenew").attr("required",false);

						$("#companyemailAdd").attr("required",false);

						$("#companydetailsnew").attr("required",false);

						$("#contactperson").attr("required",false);

						$("#phonecom").attr("required",false);

						$("#comAddress").attr("required",false);

					}

					

				}

			});

}

</script>

