<?php require_once("common/header.php");?>
    <div class="fullcontent right clear">
<?php 
	$uID = isset($_GET['jid']) ? $job[0]->uID 	: 0;
	$link = isset($_GET['jid']) ? 'edit_job_submit' 	: 'add_job_submit';
	$edit = isset($_GET['jid']) ? 'Edit' 		: 'Add New';
	$jType = isset($_GET['jid']) ? $job[0]->jType 	: 0;
	$jTitle = isset($_GET['jid']) ? $job[0]->jTitle 	: '';
	$jDepartment = isset($_GET['jid']) ? $job[0]->jDepartment 	: 0;
	$cID = isset($_GET['jid']) ? $job[0]->cID 	: 0;
	$jCareerLevel = isset($_GET['jid']) ? $job[0]->jCareerLevel 	: 0;
	$jExpLevel = isset($_GET['jid']) ? $job[0]->jExpLevel 	: '';
	$jVacancy = isset($_GET['jid']) ? $job[0]->jVacancy 	: '';
	$jDescription = isset($_GET['jid']) ? $job[0]->jDescription 	: '';
	$jRequiredSkills = isset($_GET['jid']) ? $job[0]->jRequiredSkills 	: '';
	$jQualification = isset($_GET['jid']) ? $job[0]->jQualification 	: '';
	$jNature = isset($_GET['jid']) ? $job[0]->jNature 	: 'Full-Time';
	$jShift = isset($_GET['jid']) ? $job[0]->jShift 	: 'Morning Shift';
	$jRequiredTravel = isset($_GET['jid']) ? $job[0]->jRequiredTravel 	: 0;
	$jGender = isset($_GET['jid']) ? $job[0]->jGender 	: '';
	$jStartSalary = isset($_GET['jid']) ? $job[0]->jStartSalary 	: 0;
	$jEndSalary = isset($_GET['jid']) ? $job[0]->jEndSalary 	: 0;
	$jBenefits = isset($_GET['jid']) ? $job[0]->jBenefits 	: '';
	$jStateCity = isset($_GET['jid']) ? $job[0]->jStateCity 	: '';
	$jExpiry = isset($_GET['jid']) ? $job[0]->jExpiry 	: '';
	$jAfterExpiry = isset($_GET['jid']) ? $job[0]->jAfterExpiry 	: 1;
	$jEmailNotify = isset($_GET['jid']) ? $job[0]->jEmailNotify 	: 1;
	$jJobStatus = isset($_GET['jid']) ? $job[0]->jJobStatus 	: 1;
	$jID = isset($_GET['jid']) ? $job[0]->jID 	: '';
?>
<style>
.fstChoiceItem {padding: 5px 16px !important;}
</style>
      <form name="category" id="category" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/<?php echo $link; ?>/">
        <div class="dev-col-2 colbg left">
          <div class="ContentDiv">
            <h1><?php echo $edit;?> Job</h1>
            <div class="formwrap">
              <label> Select Company: </label>
              <select name="company" id="company" required class="selectbox fastselect">
                <option value="">--- Select Company ---</option>
               <?php foreach($companies as $company): ?>
                <option value="<?php echo $company->uID;?>" <?php if($company->uID == $uID){echo "SELECTED";}?>><?php echo $company->uFname.' '.$company->uLname;?></option>
               <?php endforeach;?>
              </select>
            </div>
            <div class="formwrap">
              <label> Job Title: </label>
              <input type="text" value="<?php echo $jTitle;?>" required name="jTitle" id="jTitle" />
              <input type="hidden" value="<?php echo $jID;?>" required name="jID" id="jID" />
            </div>
            
                <div class="formwrap" id="industry">
                  <label> Department: </label>
                  <select name="department" id="department"  class="selectbox fastselect textarea">
                    <option value="">--- Select Department ---</option>
                    <?php foreach($departments as $department): ?>
                    <option value="<?php echo $department->dID;?>" <?php if($department->dID == $jDepartment){echo "SELECTED";}?>><?php echo $department->dName;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="formwrap" id="industry">
                  <label> Industry: </label>
                  <select name="industry" id="industry" required  class="selectbox fastselect textarea">
                    <option value="">--- Select Industry ---</option>
                    <?php foreach($industry as $industrydata): ?>
                    <option value="<?php echo $industrydata->cID;?>" <?php if($industrydata->cID == $cID){echo "SELECTED";}?>><?php echo $industrydata->catName;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
           
            <div class="formwrap">
              <label> Career Level: </label>
              <select name="careerlevel" id="careerlevel"  class="selectbox fastselect textarea">
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
            <div class="formwrap">
              <label> Experience Level: </label>
              <select name="explevel" id="explevel"  class="selectbox fastselect textarea">
                        <option value="">--- Select Experience Level ---</option>
                       	<option value="-2" <?php if($jExpLevel == '-2'){echo "SELECTED";}?>>Student</option>
                        <option value="-1" <?php if($jExpLevel == '-1'){echo "SELECTED";}?>>Fresh Graduate</option>
                        <?php for($i=0;$i<=25;$i++): ?>
                        <option value="<?php echo $i;?>" <?php if($i == $jExpLevel){echo "SELECTED";}?>><?php if($i == 0){echo '< 1';}else {echo $i;}?></option>
                        <?php endfor; ?>
						<option value="26">&gt; 25 Years</option>
                    </select>
            </div>
            
            <div class="formwrap">
              <label> No Of Vacanies: </label>
              <input type="number" value="<?php echo $jVacancy;?>" required name="vacancies" id="vacancies" />
            </div>
            <div class="formwrap">
              <label> Qualification: </label>
              <input type="text" value="<?php echo $jQualification;?>" name="qualification" id="qualification" />
            </div>
            <div class="formwrap">
              <label> Job Description: </label>
              <textarea name="jobDescp" id="jobDescp" class="textarea styletxtarea"><?php echo strip_tags(htmlspecialchars_decode($jDescription));?></textarea>
            </div>
            
            <div class="formwrap">
              <label> Required Skills: </label>
              <textarea name="reqSkilled" id="reqSkilled" class="textarea styletxtarea"><?php echo strip_tags(htmlspecialchars_decode($jRequiredSkills));?></textarea>
            </div>
          </div>
        </div>
        <!--Extra Information-->
        <div class="dev-col-2 colbg left" style="margin-left:1%;">
          <div class="ContentDiv">
            <h1>Job Additional Information</h1>
            
            
            <div class="formwrap">
              <label> Type Of Job: </label>
             <select name="jobtype" id="jobtype"  class="selectbox fastselect textarea">
                       <option value="">--- Select Job Type ---</option>
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
            <div class="formwrap">
              <label> Job Shift: </label>
               <select name="jobshift" id="jobshift"  class="selectbox fastselect textarea">
                        <option value="">--- Select Shift ---</option>
                        <option value="Evening Shift" <?php if($jShift == "Evening Shift"){echo "SELECTED";}?>>Evening Shift</option>
                        <option value="Morning Shift" <?php if($jShift == "Morning Shift"){echo "SELECTED";}?>>Morning Shift</option>
                        <option value="Night Shift" <?php if($jShift == "Night Shift"){echo "SELECTED";}?>>Night Shift</option>
                        <option value="On Rotation" <?php if($jShift == "On Rotation"){echo "SELECTED";}?>>On Rotation</option>
                    </select>
            </div>
            <div class="formwrap">
              <label> Travel Required Level: </label>
              <select name="jobtravel" id="jobtravel"  class="selectbox fastselect textarea">
                      <option value="1" <?php if($jRequiredTravel == 1){echo "SELECTED";}?>>Yes</option>
                      <option value="0" <?php if($jRequiredTravel == 0){echo "SELECTED";}?>>No</option>
              </select>
            </div>
             <div class="formwrap">
              <label> Gender: </label>
              <select name="jobGender" id="jobGender"  class="selectbox fastselect textarea">
              		<option value="">--- Select Gender ---</option>
                      <option value="1" <?php if($jGender == 1){echo "SELECTED";}?>>Male</option>
                      <option value="2" <?php if($jGender == 2){echo "SELECTED";}?>>FeMale</option>
                      <option value="3" <?php if($jGender == 3){echo "SELECTED";}?>>Not Preffered</option>
              </select>
            </div>
            <div class="formwrap">
              <label> Salary: </label>
              <input type="number" value="<?php echo $jStartSalary;?>" placeholder="Starting Salary" name="startsalary" id="startsalary" style="width:49%; margin-right:1%;" />
              <input type="number" value="<?php echo $jEndSalary;?>" placeholder="Ending Salary" name="endsalary" id="endsalary" style="width:49%;"/>
            </div>
            <div class="formwrap" id="industry">
                  <label> Benefits: </label>
                  <select name="benefits[]" id="benefits[]" multiple  class="selectbox fastselect textarea">
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
                
            <div class="formwrap" id="industry">
                  <label> Job Location: </label>
                  <select name="jobLocation" id="jobLocation"  class="selectbox fastselect textarea">
                    <option value="">--- Select Job Location ---</option>
                    <?php foreach($cities as $city): ?>
                    <option value="<?php echo $city->city_id;?>" <?php if($city->city_id == $jStateCity){echo "SELECTED";}?>><?php echo $city->city_name.', '.$city->city_state;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
            <div class="formwrap">
              <label> Job Expiry: </label>
              <input type="date" value="<?php echo $jExpiry;?>" name="jExpiry" id="jExpiry" />
            </div>
            <div class="formwrap">
              <label> After Job Expiry: </label>
              <select name="jobAfterExpiry" id="jobAfterExpiry"  class="selectbox fastselect textarea">
              			<option value="">--- Select Expiry Action ---</option>
                        <option value="1" <?php if($jAfterExpiry == 1){echo "SELECTED";}?>>Keep the job active</option>
                        <option value="2" <?php if($jAfterExpiry == 2){echo "SELECTED";}?>>Keep the job active but stop receiving resumes</option>
                        <option value="3" <?php if($jAfterExpiry == 3){echo "SELECTED";}?>>Remove job and stop receiving resumes</option>
             </select>
            </div>
            <div class="formwrap">
              <label> Notify Through Email When Applied: </label>
              <select name="jobNotify" id="jobNotify"  class="selectbox fastselect textarea">
              		<option value="">--- Select Email ---</option>
                      <option value="1" <?php if($jEmailNotify == 1){echo "SELECTED";}?>>Yes</option>
                      <option value="2" <?php if($jEmailNotify == 2){echo "SELECTED";}?>>No</option>
              </select>
            </div>
            <div class="formwrap">
              <label> Status: </label>
              <select name="status" id="status"  class="selectbox fastselect textarea">
              		<option value="">--- Select Status ---</option>
                      <option value="1" <?php if($jJobStatus == 1){echo "SELECTED";}?>>Active</option>
                      <option value="0" <?php if($jJobStatus == 0){echo "SELECTED";}?>>In-Active</option>
              </select>
            </div>
            <div class="formwrap">
              <input type="submit" value="POST JOB" name="submit" id="submit" class="btn btn-lg btn-green right" />
            </div>
          </div>
        </div>
      </form>
    </div>
    <?php require_once("common/footer.php"); ?>