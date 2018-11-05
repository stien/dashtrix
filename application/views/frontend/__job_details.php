<?php require_once("common/header.php");?>
<?php
$arr = array('jURL' => $this->uri->segment(2),'jJobStatus' => 1);
$jconfig	= $this->front_model->get_query_simple('*','dev_web_jobs',$arr);
$jobs 	   = $jconfig->result_object();
$data = array(
	'jview'	=> $jobs[0]->jview + 1,
);
$condition = array('jID' => $jobs[0]->jID);
$this->front_model->update_query('dev_web_jobs',$data,$condition);
?>
<div id="loginbx">
  <div class="container">
  <div class="col-xs-3 pr0 navleftbar">
  	<?php //require_once("common/search_refine.php");?>
  	<?php require_once("common/categories.php");?>
  </div>
    <div class="col-xs-9 nopad">
    <?php if(isset($_SESSION['msglogin'])){?>
        <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
        <?php } ?>
    <?php 
		
		if(isset($_SESSION['JobsSessions'])){
		// CHECK APPLIED OR NOT
		$arapply = array('jID' => $jobs[0]->jID,'uID' => UID,);
		$app = $this->front_model->get_query_simple('*','dev_web_applied',$arapply);
		$appcount = $app->num_rows();
		}
    ?>
	<?php if(isset($_GET['apply']) && $_GET['apply'] == "yes"){
		if($jobs[0]->jDirect != 1){ ?>
    <div class="col-xs-12 login-inner nopad">
      <?php if(isset($_SESSION['JobsSessions'])){ ?>
          <h2>Apply Now for Job
          	<span class="right"><a href="<?php echo base_url(); ?>job/<?php echo $jobs[0]->jURL;?>">View Job Vacancy</a></span>
          </h2>
          <?php if(ACTYPE == 1){?>
          <div class="col-xs-12 nopad applyarea">
         <?php if($appcount == 0){?>
          <style>
          .applyarea h2 { font-weight:normal !important;}
          </style>
          <form action="<?php echo base_url(); ?>do/job/applied" method="post" name="applynow" id="applynow">
              <div class="col-xs-12 nopad pr0">
                <h2>Cover Letter:</h2>
                <select name="coverletter" id="coverletter" class="inputjob">
                <option value="">--- Select Cover Letter ---</option>
                <?php 
                    // GET COVER LETTER
                    $cover 	 = array('uID' => UID);
                    $ucover	= $this->front_model->get_query_simple('*','dev_wev_coverletters',$cover);
                    $coverlt   = $ucover->result_object();
                    foreach($coverlt as $coverletter):
                ?>
                    <option value="<?php echo $coverletter->cvID;?>"><?php echo $coverletter->cvTitle;?></option>
                <?php endforeach;?>
                </select>
              </div>
              <div class="col-xs-12 nopad pr0 labelclass">
                <h2>Choose CV:</h2>
                <select name="cv" id="cv" required class="inputjob">
                <option value="">--- Select CV ---</option>
                <?php 
                    // GET COVER LETTER
                    $cv 	 = array('uID' => UID);
                    $ucv	= $this->front_model->get_query_simple('*','dev_web_cv',$cv);
                    $countcv = $ucv->num_rows();
                
                    $cvlt = $ucv->result_object();
                    foreach($cvlt as $cvs):
                ?>
                    <option value="<?php echo $cvs->cvID;?>"><?php echo $cvs->cvFile;?></option>
                <?php endforeach;?>
                </select>
                <?php if($countcv == 0){ ?>
                <p style="margin-top:7px; color:#f00">
                    No Cv Found! Please <a href="<?php echo base_url(); ?>create-cv?ret=<?php echo current_url()."?apply=yes";?>"><strong>Upload/Create</strong></a> Your CV
                </p>
                <?php } ?>
              </div>
              <div class="col-xs-12 nopad pr0 labelclass">
                <h2>Authorised to work in location specified?</h2>
                <select name="authorized" id="authorized" required class="inputjob">
                <option value="">--- Select Authorised to work in location ---</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
             </div>
             
             <div class="col-xs-12 nopad labelclass">
                <input type="hidden" name="jID" id="jID" value="<?php echo $jobs[0]->jID;?>">
                <input type="hidden" name="retURL" id="retURL" value="<?php echo 'job/'.$this->uri->segment(2);?>">
                <button type="submit" name="postjob" class="btn green right"> Apply Now</button>
             </div>
          </form>
          <?php  } else { ?>
          <div class="errormsg">You have already applied for this job!</div>
          <?php } ?>
          </div>
          <?php } else { 
		  header("Location: ".base_url()."job/".$jobs[0]->jURL);
		  }?>
      <?php } else { ?>
      <h2>Apply Now for Job
          	<span class="right"><a href="<?php echo base_url(); ?>job/<?php echo $jobs[0]->jURL;?>">View Job Vacancy</a></span>
          </h2>
      <div class="col-xs-6 bxlogin nopad">
      
      <div class="login-inner left">
      
        <h2>Login</h2>
        
        <form name="loginform" id="loginform" action="<?php echo base_url(); ?>do/login" method="post">
        <p style="margin-bottom:10px;"> Please login to apply for this job</p>
        <div class="col-xs-12 nopad boxinput">
          <input type="email" name="emailadd" id="emailadd" required class="inputjob" placeholder="Email Address">
        </div>
        <div class="col-xs-12 nopad boxinput">
          <input type="password" name="passlogin" id="passlogin" required class="inputjob" placeholder="Password">
        </div>
         <div class="col-xs-12 nopad boxinput">
         <input type="hidden" value="<?php echo current_url();?>?apply=yes" name="returl" id="returl">
          <button type="submit" name="signup" class="btn pink">Login</button>
        </div>
         </form>
       
      </div>
    </div>
      <?php } ?>
    </div>
	<?php  }} else { ?>
    <?php
		
		if(count($jobs) > 0){
			foreach($jobs as $job):
			// GET COMPANY NAME
			$arr2 = array('uID' => $job->uID);
			$uconfig	= $this->front_model->get_query_simple('*','dev_web_user',$arr2);
			$company 	= $uconfig->result_object();
			// GET CITY NAME
			$arr3 = array('city_id' => $job->jStateCity);
			$cconfig	= $this->front_model->get_query_simple('*','dev_web_cities',$arr3);
			$city 	= $cconfig->result_object();
			// GET COUNTRY NAME
			$arr4 = array('id' => $job->jCoutry);
			$coconfig	= $this->front_model->get_query_simple('*','dev_web_countries',$arr4);
			$country 	= $coconfig->result_object();
	?>
      <div class="col-xs-12 nopad login-inner">
      <h2>
      		<?php echo $job->jTitle;?>
            <div class="showbuttons right" style="display:block;" id="jb_<?php echo $job->jID;?>">
                <?php if(isset($_SESSION['JobsSessions'])){
					$ar = array('jID' => $job->jID,'uID' => UID,);
					$c = $this->front_model->get_query_simple('*','dev_web_saved',$ar);
					$count = $c->num_rows();
					if($count > 0) {
						echo '<button name="postjob" class="btn blue" style="background:#2a2a2a">Already Saved</button>';
					} else { ?>
                    <a href="<?php echo base_url(); ?>savejob/<?php echo $job->jID;?>"><button name="postjob" class="btn blue"><i class="fa fa-save"></i> Save</button></a>
                    <?php } ?>
                     <?php
				} else { ?>
                 <a href="<?php echo base_url(); ?>savejob/<?php echo $job->jID;?>"><button name="postjob" class="btn blue"><i class="fa fa-save"></i> Save</button></a>
                 <?php } ?>
                <button name="postjob" class="btn pink" onClick="sharejobbyemail()">
                	<i class="fa fa-envelope-o"></i> Share job by email
                </button>
            </div>
      </h2>
      	<span class="company left" <?php if($company[0]->uPhone != ""){ ?> style="margin-bottom:6px;"<?php } ?>>Recruiter: <?php echo $company[0]->uFname;?> <?php echo $company[0]->uLname;?></span>
        <?php if($company[0]->uPhone != ""){ ?>
        <span class="company left">Call: <?php echo $company[0]->uPhone;?> </span>
        <?php } ?>
        <div class="col-xs-12 nopad margbottom">
        	<div class="col-xs-3 pr0">
            	<div class="text-muted">Job Type</div>
                <?php echo $job->jNature;?>
            </div>
            <div class="col-xs-3 borleft">
            	<div class="text-muted">Shift</div>
                <?php echo $job->jShift;?>
            </div>
            <div class="col-xs-3 borleft">
            	<div class="text-muted">Experience</div>
                 <?php echo $job->jExpLevel;?> Years
            </div>
            <div class="col-xs-3 borleft">
            	<div class="text-muted">Salary</div>
                <?php echo $job->jCurrency;?><?php echo number_format($job->jStartSalary);?> - <?php echo $job->jCurrency;?><?php echo number_format($job->jEndSalary);?>
            </div>
        </div>
        
        <div class="col-xs-12 nopad margbottom">
        	<div class="col-xs-3 pr0">
            	<div class="text-muted">Number of Vacancies</div>
                <?php echo $job->jVacancy;?>
            </div>
            <?php if($job->jQualification != ""){?>
            <div class="col-xs-3 borleft">
            	<div class="text-muted">Qualification</div>
                <?php echo $job->jQualification;?>
            </div>
            <?php } ?>
            <div class="col-xs-3 borleft">
            	<div class="text-muted">Gender</div>
                 <?php if($job->jGender ==  1){echo "Male";} else if($job->jGender ==  2){echo "Female";} else {echo "Not Preffered";}?>
            </div>
            <div class="col-xs-3 borleft">
            	<div class="text-muted">Career Level</div>
                <?php 
					$replace = array("1","2","3","4","5","6","7");
					$replacewith = array("Entry Level","Executive (SVP, VP, HOD)","Experienced (Non-Managerial)","Manager/Supervisor","Sr. Executive (CEO/President)","Student (School/College)","Student (Undergrad./Grad.)");
					echo str_replace($replace,$replacewith,$job->jCareerLevel);
				?>
            </div>
        </div>
        <div class="col-xs-12 nopad">
        	<div class="col-xs-3 pr0">
            	<div class="text-muted">Job Sector</div>
                <?php 
				// GET JOB SECTOR
					$arr6 = array('cID' => $job->cID);
					$uconfig6	= $this->front_model->get_query_simple('*','dev_web_categories',$arr6);
					$sector 	= $uconfig6->result_object();
					echo '<a href="'.base_url().'jobs/'.$sector[0]->catLink.'">'.$sector[0]->catName.'</a>';
				?>
            </div>
            <div class="col-xs-3 borleft">
            	<div class="text-muted">Posted Date</div>
                <?php echo date("M, d Y",strtotime($job->jPostedDate));?>
            </div>
            
        </div>
        <div class="col-xs-12 nopad jobdesp">
        <h2>Job Description</h2>
        <a href="<?php echo base_url(); ?>company/<?php echo $company[0]->uUsername;?>">
		<?php if($company[0]->uImage != ""){?>
        <img src="<?php echo base_url(); ?>resources/uploads/profile/thumbnail_<?php echo $company[0]->uImage; ?>" alt="<?php echo $company[0]->uFname;?> <?php echo $company[0]->uLname;?>" class="pullright" style="width: 120px;height: 120px;">
        <?php }  else { ?>
        <img src="<?php echo base_url(); ?>resources/frontend/images/no_photo.jpg" alt="<?php echo $company[0]->uFname;?> <?php echo $company[0]->uLname;?>" class="pullright" style="width: 120px;height: 120px;">
        <?php } ?>
        </a>
        	<?php echo $job->jDescription;?>
            
        </div>
        <div class="col-xs-12 nopad jobdesp">
        <h2>Extra Information/Requirements</h2>
        <?php echo $job->jRequiredSkills;?>
        </div>
        <div class="col-xs-12 nopad benefits jobdesp">
        	<h2>Rewards and Benefits</h2>
        	<ul>
        	<?php 
			$be = explode(",",$job->jBenefits);
			foreach($be as $ben):
			$arr5 = array('bID' => $ben);
			$coconfig5	= $this->front_model->get_query_simple('*','dev_web_benefits',$arr5);
			$benefits 	= $coconfig5->result_object();
			?>
            <?php echo '<li><i class="fa fa-check-square-o" style="color:#7ca52f"></i> '.$benefits[0]->bName.'</li>';?>
            <?php endforeach;?>
            </ul>
        </div>
        <div class="col-xs-12 nopad jobdesp locdata">
       		<div class="col-xs-6 nopad">
            <?php /*?><?php if($job->jStateCity !="0" || $job->jCoutry != "0"){?>
            <i class="fa fa-map-marker iconfont"></i>
            <?php if($job->jStateCity !="0"){?><a href="<?php echo base_url(); ?>city/<?php echo strtolower(str_replace(" ","-",$city[0]->city_name));?>"><?php echo $city[0]->city_name;?> , <?php echo $city[0]->city_state;?></a> - <?php } ?>
            <?php if($job->jCoutry != "0"){?><a href="<?php echo base_url(); ?>country/<?php echo strtolower(str_replace(" ","-",$country[0]->country_name));?>"><?php echo $country[0]->country_name;?></a><?php }?>
            <?php } ?><?php */?>
            </div>
            
            
        </div>
        
        <div class="right">
        <?php if(!isset($_SESSION['JobsSessions'])){ ?>
        <?php if($job->jDirect == 1){?>
        <a href="<?php echo addhttp($job->jDirectLink);?>" target="_blank" title="External Link for Apply Job">
        <?php }  else { ?>
        	<a href="<?php echo current_url(); ?>?apply=yes">
        <?php } ?>
            <button name="signup" class="btn red"><?php if($job->jDirect == 1){?><i class="fa fa-external-link"></i><?php } ?> Apply Now</button>
            </a>
        <?php }  else { ?>
        <?php if(ACTYPE == 1){?>
		<?php
			
			if($appcount > 0){
				echo '<button name="applied" class="btn red" style=" background:#2a2a2a;">Already Applied</button>';
			} else {
		?>
        <?php if($job->jDirect == 1){?>
        <a href="<?php echo addhttp($job->jDirectLink);?>" target="_blank" title="External Link for Apply Job">
        <?php }  else { ?>
        	<a href="<?php echo current_url(); ?>?apply=yes">
        <?php } ?>
        
            	<button name="signup" class="btn red"><?php if($job->jDirect == 1){?><i class="fa fa-external-link"></i><?php } ?> Apply Now</button>
            </a>
            <?php }} ?>
            
        </div>
        <?php } ?>
        <?php if(isset($_SESSION['JobsSessions']) && ACTYPE == 1){
			if($appcount == 0){
				$cvd2 = array('uID' => UID);
				$uscv =  $this->front_model->get_query_simple('*','dev_web_cv',$cvd2);
				$usercv = $uscv->num_rows();
				if($usercv > 0){
			 ?>
        <div class="left">
        	<button name="signup" class="btn blue" onClick="show1click()"><i class="fa fa-star"></i> 1-Click Apply</button>
        </div>
        <?php }}} ?>
        <?php if($job->jUpdate == 1){?>
        <div class="left col-xs-12 nopad" style="margin-top:10px;">
        	<div class="errormsg" style="border-radius:3px; width:100%; border:1px solid; text-transform:uppercase; font-size:11px; padding:10px; background:#A1A1A1;">
				Job Information updated from recruiter on "<?php echo date("F, d Y",strtotime($job->jJobUpdated))?>"
           </div>
        </div>
        <?php } ?>
      </div>
    <?php
	endforeach;
		} else {
			require_once("404_error.php");
			//echo '<div class="infomsg">Invalid Job Link!</div>';
		}
	}
	?>
      
     
    </div>
  </div>
</div>
<?php require_once("common/footer.php");?>
<?php if(isset($_SESSION['JobsSessions']) && ACTYPE == 1){
	if($appcount == 0){$cvd2 = array('uID' => UID);
				$uscv =  $this->front_model->get_query_simple('*','dev_web_cv',$cvd2);
				$usercv = $uscv->num_rows();
				if($usercv > 0){
?>
<div class="container-popup" id="boxmesage">
    <div class="rightpop">
    
    	<div id="messpopup" style="display:block;">
        	<h2>1-Click Apply <i class="fa fa-close right" style="cursor:pointer;" onClick="hide1click()"></i></h2>
            <p>
            	When using 1-Click Apply we will send the recruiter:
            </p>
            <p>
            	<i class="fa fa-check-square-o left"></i> Your stored CV
            </p>
            <p>
            	<i class="fa fa-check-square-o left"></i> The Jobsite default cover letter
            </p>
            <p>
            	<i class="fa fa-check-square-o left"></i> Your authorisation to work in the location
            </p>
            <div style="margin-bottom:0 !important;">
            	<form name="1apply" id="1apply" method="post" action="<?php echo base_url(); ?>jobsite/oneclick_apply">
            	<button name="signup" type="submit" class="btn blue">1-Click Apply</button>
                <input type="hidden" value="<?php echo $jobs[0]->jID;?>" name="jID" id="jID">
                <input type="hidden" value="<?php echo current_url();?>" name="retURL" id="retURL">
                <button name="signup" type="button" class="btn red" onClick="hide1click()">Cancel</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
<script language="javascript">
function hide1click(){
	$("#boxmesage").hide();
}
function show1click(){
	$("#boxmesage").fadeIn();
}
</script>
<style>
#messpopup h2{  text-transform: uppercase;
  margin-bottom: 10px;}
#messpopup p {  margin-bottom: 22px;}
#messpopup i {margin-right: 17px;
  color: #ef7268;}
</style>
<?php }}} ?>

<div class="container-popup" id="boxmesageemailjobshare" style="display:none;">
    <div class="rightpop">
    
    	<div id="messpopup" style="display:block;">
        	<h2>Email-A-Friend <i class="fa fa-close right" style="cursor:pointer;" onClick="hide1click_email()"></i></h2>
            <p style="margin:10px 0;">
            	Seen a job that would be perfect for a friend or relative? Simply fill in their email address and yours and we'll send them a link to this job.
            </p>
            <div style="margin-bottom:0 !important;">
            	<form name="1apply" id="1apply" method="post" action="<?php echo base_url(); ?>jobsite/share_job_email">
                <div class="col-xs-12 nopad boxinput">
                  <label> Frined Email Address: </label>
                  <input type="email" value="" class="inputjob" required name="friendemail" id="friendemail" />
                </div>
                <?php if(isset($_SESSION['JobsSessions'])){
					$email = EMAIL;
				} else {
					$email = '';
				}
				?>
            	<div class="col-xs-12 nopad boxinput">
                  <label> Your Email Address: </label>
                  <input type="email" value="<?php echo $email;?>" class="inputjob" required name="myemailadd" id="myemailadd" />
                </div>
            	<div class="col-xs-12 nopad boxinput">
              <label> Your Message: </label>
              <textarea name="messagefriend" id="messagefriend" class="textarea inputjob styletxtarea" required></textarea>
            </div>
            
            	<button name="signup" type="submit" class="btn blue">Send Email</button>
                <input type="hidden" value="<?php echo $jobs[0]->jID;?>" name="jID" id="jID">
                <input type="hidden" value="<?php echo current_url();?>" name="retURL" id="retURL">
                <button name="signup" type="button" class="btn red" onClick="hide1click_email()">Cancel</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
<script language="javascript">
function sharejobbyemail()
{
	$("#boxmesageemailjobshare").show();
	
}
function hide1click_email()
{
	$("#boxmesageemailjobshare, #boxmesageemail").hide();
}
</script>
<style>
#boxmesageemail { display:none;}
</style>
