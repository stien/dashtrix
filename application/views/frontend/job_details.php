<?php require_once("common/header.php");?>

<?php 

require_once('libraries/Google/autoload.php');

//Insert your cient ID and secret 

//You can get it from : https://console.developers.google.com/

$client_id = '980689377071-1cudibmmbakn23938evatv4j6eg78d0c.apps.googleusercontent.com'; 

$client_secret = 'cTLKPf936p0gj7BIEyXA3MDL';

$redirect_uri = base_url().'oathgoogle/login';

$client = new Google_Client();

$client->setClientId($client_id);

$client->setClientSecret($client_secret);

$client->setRedirectUri($redirect_uri);

//$client->addScope("email");

//$client->addScope("profile");

$client->setScopes(array(

 'https://www.googleapis.com/auth/plus.login',

 'profile',

 'email',

 'openid',

));

$service = new Google_Service_Oauth2($client);

if (isset($_GET['code'])) {

  $client->authenticate($_GET['code']);

  $_SESSION['access_token'] = $client->getAccessToken();

  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));

  exit;

}

/************************************************

  If we have an access token, we can make

  requests, else we generate an authentication URL.

 ************************************************/

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {

  $client->setAccessToken($_SESSION['access_token']);

} else {

  $authUrl = $client->createAuthUrl();

}

?>

<?php

$arr = array('jURL' => $this->uri->segment(2),'jJobStatus' => 1);

$jconfig	= $this->front_model->get_query_simple('*','dev_web_jobs',$arr);

$jobs 	   = $jconfig->result_object();

$data = array(

	'jview'	=> $jobs[0]->jview + 1,

);

$condition = array('jID' => $jobs[0]->jID);

$this->front_model->update_query('dev_web_jobs',$data,$condition);



$compconup	   = array('uID' => $jobs[0]->uID);

$jconcomnup	= $this->front_model->get_query_simple('*','dev_web_user',$compconup);

$compnaup  = $jconcomnup->result_object();

?>

<?php 

if(isset($_SESSION['JobsSessions'])){ ?>

<div class="fixedpop" style="display:none;">

    	<div class="col-xs-6 nopad">

        	<h2>

				<?php echo substr($jobs[0]->jTitle,0,65);?><br>

                <small style="text-transform: capitalize;font-weight: normal;">Posted By: <?php if($jobs[0]->jCDisclose == 0){echo "Confidential";} else {echo $compnaup[0]->uCompany;}?></small>

            

            </h2>

        </div>

        <div class="col-xs-6 nopad" style="padding-top: 4px;">

        	  <!--OTHER BUTTONS-->

       		 <div class="right" style="margin-left:30px;">

        <?php if(!isset($_SESSION['JobsSessions'])){ ?>

        <?php if($jobs[0]->jDirect == 1){?>

        <a href="<?php echo addhttp($jobs[0]->jDirectLink);?>" target="_blank" title="External Link for Apply Job">

        <?php }  else { ?>

        	<a href="javascript:;" onClick="showloginboxapply('<?php echo $jobs[0]->jID;?>')">

        <?php } ?>

            <button name="signup" class="btn red"><?php if($jobs[0]->jDirect == 1){?><i class="fa fa-external-link"></i><?php } ?> Apply Now</button>

            </a>

        <?php }  else { ?>

        <?php if(ACTYPE == 1){?>

		<?php

			

			if($appcount > 0){

				echo '<button name="applied" class="btn red" style=" background:#2a2a2a;">Already Applied</button>';

			} else {

		?>

        <?php if($job[0]->jDirect == 1){?>

        <a href="<?php echo addhttp($job[0]->jDirectLink);?>" target="_blank" title="External Link for Apply Job">

        <?php }  else { ?>

        	<a href="<?php echo current_url(); ?>?apply=yes">

        <?php } ?>

        

            	<button name="signup" class="btn red"><?php if($jobs[0]->jDirect == 1){?><i class="fa fa-external-link"></i><?php } ?> Apply Now</button>

            </a>

            <?php }} ?>

        <?php } ?>    

        </div>

             <div class="right">

        	<?php if(isset($_SESSION['JobsSessions'])){

					$ar = array('jID' => $jobs[0]->jID,'uID' => UID,);

					$c = $this->front_model->get_query_simple('*','dev_web_saved',$ar);

					$count = $c->num_rows();

					if($count > 0) {

						echo '<button name="postjob" class="btn blue" style="background:#2a2a2a">Already Saved</button>';

					} else { ?>

                    <a href="<?php echo base_url(); ?>savejob/<?php echo $jobs[0]->jID;?>">

                    	<button name="postjob" class="btn pink"><i class="fa fa-save"></i> Save</button>

                     </a>

                    <?php } ?>

                    <?php

				} else { ?>

                 <a href="javascript:;" onClick="showloginbox('<?php echo $jobs[0]->jID;?>')">

                 <button name="postjob" class="btn pink"><i class="fa fa-save"></i> Save</button></a>

                 <?php } ?>

                <button name="postjob" class="btn pink" onClick="sharejobbyemail()">

                	<i class="fa fa-envelope-o"></i> Share Job by Email

                </button>

        </div>

        	

    

        </div>

    </div>

<?php } ?>

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

	

    <?php

		if(count($jobs) > 0){

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

					$covecnt   = $ucover->num_rows();

                    foreach($coverlt as $coverletter):

                ?>

                    <option value="<?php echo $coverletter->cvID;?>"><?php echo $coverletter->cvTitle;?></option>

                <?php endforeach;?>

                </select>

                <?php if($covecnt == 0){ ?>

                <p style="margin-top:7px; color:#f00">

                    <a href="javascript:;" onClick="coverltterboxshow()">

                    	<button class="btn red" type="button" style="margin-top:0">No Cover letter? Click to <strong>Create </strong> Coverletter</button></a> 

                    

                </p>

                <?php } ?>

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

                    <a href="javascript:;" onClick="resumeboxshow()">

                    	<button class="btn red" type="button" style="margin-top:0">No Cv Found! Click to <strong>Upload/Create</strong> Your CV</button></a> 

                    

                </p>

                <?php } ?>

              </div>

              <div class="col-xs-12 nopad pr0 labelclass">

                <h2>Authorised to work in location (<?php if($jobs[0]->jStateCity != ""){echo $jobs[0]->jStateCity.", ";}?><?php echo $jobs[0]->jCoutry;?>) specified?</h2>

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

      <?php /*?><h2>Apply Now for Job

          	<span class="right"><a href="<?php echo base_url(); ?>job/<?php echo $jobs[0]->jURL;?>">View Job Vacancy</a></span>

          </h2><?php */?>

      <div class="col-xs-12 bxlogin nopad" style="  text-align: center;

  margin-top: 13px;

  color: #f00;">

      	<h2>Please login to apply for this job</h2>

      <?php /*?><div class="login-inner left">

      

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

       

      </div><?php */?>

    </div>

      <?php } ?>

    </div>

	<?php  }} else { ?>

    <?php

			

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

    

    <div class="col-xs-12 nopad locdata" style="margin-bottom:5px; margin-top:-7px;">

       	<div class="col-xs-6 left nopad">

        <div class="left">

        <?php if(isset($_SESSION['JobsSessions']) && ACTYPE == 1){

			if($appcount == 0){

				$cvd2 = array('uID' => UID);

				$uscv =  $this->front_model->get_query_simple('*','dev_web_cv',$cvd2);

				$usercv = $uscv->num_rows();

				if($usercv > 0){

			 ?>

        <div class="left">

        	<button name="signup" class="btn blue" onClick="show1click()" style="margin-right:3px;"><i class="fa fa-star"></i> 1-Click Apply</button>

        </div>

        <?php }}} ?>

        </div>

        <!--OTHER BUTTONS-->

        <div class="left">

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

                 <a href="javascript:;" onClick="showloginbox('<?php echo $job->jID;?>')"><button name="postjob" class="btn blue"><i class="fa fa-save"></i> Save</button></a>

                 <?php } ?>

                <button name="postjob" class="btn pink" onClick="sharejobbyemail()">

                	<i class="fa fa-envelope-o"></i> Share Job by Email

                </button>

        </div>

        

        </div>

        	<div class="col-xs-6 nopad">

        

    <div class="right">

        <?php if(!isset($_SESSION['JobsSessions'])){ ?>

        <?php if($job->jDirect == 1){?>

        <a href="<?php echo addhttp($job->jDirectLink);?>" target="_blank" title="External Link for Apply Job">

        <?php }  else { ?>

        	<a href="javascript:;" onClick="showloginboxapply('<?php echo $jobs[0]->jID;?>')">

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

        <?php } ?>    

        </div>

        </div>

        </div>

      <div class="col-xs-12 nopad login-inner">



        <h2>

      		<?php echo $job->jTitle;?>

            <?php /*?><div class="showbuttons right" style="display:block;" id="jb_<?php echo $job->jID;?>">

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

            </div><?php */?>

      </h2>

      	<span class="company left" <?php if($company[0]->uPhone != ""){ ?> style="margin-bottom:6px;"<?php } ?>>Posted By: <?php if($job->jCDisclose == 0){echo "Confidential";} else {echo $company[0]->uCompany;}?></span>

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

                 <?php echo $job->jExpLevel;?> - <?php echo $job->jExpLevelmax;?> Years

            </div>

            <div class="col-xs-3 borleft">

            	<div class="text-muted">Salary</div>

                

				<?php 

				if($job->jStartSalary == "0" || $job->jEndSalary == "0"){echo "Not Disclosed";} else {

				if($job->jSalHidden == "1"){ echo "Not Disclosed"; } else {?>

				<?php echo $job->jCurrency;?><?php echo number_format($job->jStartSalary);?> - <?php echo $job->jCurrency;?><?php echo number_format($job->jEndSalary);?> <?php if($job->jsalType != ""){ echo "Per ".$job->jsalType;}}?>

                <?php } ?>

            </div>

        </div>

        

        <div class="col-xs-12 nopad margbottom">

        	

            <div class="col-xs-3 pr0">

            	<div class="text-muted">Number of Vacancies</div>

               	<?php 

					if($job->jNotDislosed == 1 || $job->jVacancy == "0"){ echo "Not Disclosed";} else {?>

                <?php echo $job->jVacancy;?>

            	<?php } ?>

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

            <div class="col-xs-<?php if($job->jQualification == ""){echo '6';} else{echo '3';}?> borleft">

            	<div class="text-muted">Career Level</div>

                <?php 

					$replace = array("1","2","3","4","5","6","7");

					$replacewith = array("Entry Level","Executive (SVP, VP, HOD)","Experienced (Non-Managerial)","Manager/Supervisor","Sr. Executive (CEO/President)","Student (School/College)","Student (Undergrad./Grad.)");

					echo str_replace($replace,$replacewith,$job->jCareerLevel);

				?>

            </div>

        </div>

        <div class="col-xs-12 nopad <?php if($job->jStateCity != ""){?>margbottom<?php } ?>">

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

            <?php if($job->jSkillKeyword != ""){?>

            <div class="col-xs-3 borleft">

            	<div class="text-muted">Skill/Keywords</div>

                <?php echo $job->jSkillKeyword;?>

            </div>

            <?php } ?>

            <div class="col-xs-3 borleft">

            	<div class="text-muted">Posted Date</div>

                <?php echo date("M, d Y",strtotime($job->jPostedDate));?>

            </div>

            

            <div class="col-xs-3 borleft">

            	<div class="text-muted">Country</div>

                <?php echo $job->jCoutry;?>

            </div>

            

        </div>

        

        <div class="col-xs-12 nopad">

            <?php if($job->jStateCity != ""){?>

            <div class="col-xs-3 borleft">

            	<div class="text-muted">City</div>

                <?php echo str_replace(",",", ",$job->jStateCity);?>

            </div>

            <?php } ?>

            <?php if($job->jSpecialization != ""){?>

            <div class="col-xs-3 borleft">

            	<div class="text-muted">Specialization</div>

                <?php echo str_replace(",",", ",$job->jSpecialization);?>

            </div>

            <?php } ?>

        </div>

        

        <div class="col-xs-12 nopad jobdesp">

        <h2>Job Description</h2>

        

		<?php if($company[0]->uImage != ""){?>

        <a href="<?php echo base_url(); ?>company/<?php echo $company[0]->uUsername;?>">

        <img src="<?php echo base_url(); ?>resources/uploads/profile/<?php echo $company[0]->uImage; ?>" alt="" class="pullright" style="width: 120px;height: 120px;"></a>

        <?php }  else { ?>

        <div class="postedby pullright">

        	<p>Posted BY</p>

            <span>

				<?php if($job->jCDisclose == 0){echo "Confidential";} else {

					?>

                    <a href="<?php echo base_url(); ?>company/<?php echo $company[0]->uUsername;?>">

                    <?php if($company[0]->uCompany == ""){echo $company[0]->uFname." ".$company[0]->uLname;} else {echo $company[0]->uCompany;}}?>

                   	</a>

            </span>

        </div>

        <?php } ?>

        

        	<?php echo $job->jDescription;?>

            

        </div>

       <?php if($job->jRequiredSkills != ""){?>

        <div class="col-xs-12 nopad jobdesp">

        <h2>Extra Information/Requirements</h2>

        <?php echo $job->jRequiredSkills;?>

        </div>

        <?php } ?>

         <?php if($job->jBenefits != ""){?>

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

        <?php } ?>

        <div class="col-xs-12 nopad jobdesp locdata" id="socialshareicon">

       		<div class="col-xs-6 nopad">

            	<!-- Go to www.addthis.com/dashboard to customize your tools --> 

                <div class="addthis_inline_share_toolbox"></div>

            </div>

            

            

        </div>

        

        

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

      <!--COMPANY INFO-->

      <?php if($job->jCName != ""){?>

     <div class="col-xs-12 nopad locdata clear">

     	<div class="col-xs-12 nopad login-inner" style="margin:0 0 10px 0;">

     		<h2 style="margin-bottom:10px;">About Company</h2>

            <h2 style="font-size:12px;color: #EF7268;"><?php echo $job->jCName;?></h2>

            <?php if($job->jCPerson != ""){?>

            <h2 style="margin-bottom:10px; font-size:12px;">Contact Person</h2>

            <h2 style="font-size:12px;color: #EF7268;"><?php echo $job->jCPerson;?></h2>

            <?php } ?>

			<?php if($job->jCWeb != ""){?>

            <h2 style="margin-bottom:10px; font-size:12px;">Company Website</h2>

            <h2 style="font-size:12px;color: #EF7268;"><?php 

				$replaced = array("http://","https://");

				$replwith = array("","");

				echo str_replace($replaced,$replwith,$job->jCWeb);

			?></h2>

            <?php } ?>

            <?php if($job->jCPhone != ""){?>

            <h2 style="margin-bottom:10px; font-size:12px;">Company Phone</h2>

            <h2 style="font-size:12px;color: #EF7268;"><?php echo $job->jCPhone;?></h2>

            <?php } ?>

            <?php if($job->jCAddress != ""){?>

            <h2 style="margin-bottom:10px; font-size:12px;">Company Address</h2>

            <h2 style="font-size:12px;color: #EF7268;"><?php echo $job->jCAddress;?></h2>

            <?php } ?>

            <h2 style="margin-bottom:10px; font-size:12px;">Company Histroy/Background</h2>

            <p style="text-align:justify; line-height:18px;margin-left:0px;">

            <?php echo $job->jCInfo;?>

            

            </p>

        </div>

     </div>

     <?php } ?>

    <?php

	endforeach;

		}

		}

		else {

			require_once("404_error.php");

		}

	

	?>

    <?php if(!isset($_SESSION['JobsSessions'])){?>

      

     <?php  } ?>

     

     <?php if(count($jobs) > 0){?>

	      <div class="col-xs-12 nopad locdata clear">

     	<!--OTHER JOBS-->

        <?php

		$compcon	   = array('uID' => $jobs[0]->uID);

		$jconcomn	= $this->front_model->get_query_simple('*','dev_web_user',$compcon);

		$compnamed  = $jconcomn->result_object();

		?>

     	<div class="col-xs-6 nopad">

        <div class="col-xs-12 nopad login-inner" style="margin:0 0 10px 0;min-height: 327px;">

    	<h2>OTHER JOBS AT <span style="color:#"><?php if($jobs[0]->jCDisclose == 0){echo "Confidential";} else {echo $compnamed[0]->uCompany;}?></span></h2>

        <?php

		$arroth 	   = array('uID' => $compnamed[0]->uID,'jJobStatus' => 1);

		$jconfigot	= $this->front_model->get_query_orderby_limit('*','dev_web_jobs',$arroth,"jID", 'DESC',5,0);

		$jobsothers   = $jconfigot->result_object();

		$i=1;

		foreach($jobsothers as $joboth):

		?>

        <div class="jobslayer" id="bxother_<?php echo $i;?>">

        	<a href="<?php echo base_url(); ?>job/<?php echo $joboth->jURL;?>"><?php echo substr($joboth->jTitle,0,70)."...";?></a>

            <small><span style="color:#0098CC"><?php echo $joboth->jNature;?></span>, <?php if($job->jStartSalary == "0" || $job->jEndSalary == "0"){echo "Not Disclosed";} else { if($joboth->jSalHidden == "1"){ echo "Not Disclosed"; } else {?><?php echo $joboth->jCurrency;?><?php echo number_format($joboth->jStartSalary);?> - <?php echo $joboth->jCurrency;?><?php echo number_format($joboth->jEndSalary);?>

			<?php if($joboth->jsalType != ""){ echo "Per ".$joboth->jsalType;}?> <?php }} ?></small>

        </div>

        <?php $i++; endforeach; ?>

        </div>

        </div>

        <!--SIMILAR JOBS-->

        <div class="col-xs-6 nopad">

        <div class="col-xs-12 nopad login-inner" style="margin:0 0 10px 0; min-height:327px;">

    	<h2>SIMILAR JOBS</h2>

        <?php		



		$datarec = $this->uri->segment(2);

		$exp = explode("-",$datarec);

		for($i=0;$i<=count($exp)-1;$i++){

			if(count($exp) > 1){$or = "OR";} else {$or = "";}

			$jti .= "`jTitle` LIKE '%".$exp[$i]."%' ".$or." ";

		}

		//$query = $jti;

		$qury =  substr($jti,0,-3);

		$similarjob =  $this->front_model->simillarjobs($qury);

		$j=1;

		foreach($similarjob as $similar):

		?>

        <div class="jobslayer" id="bxother_<?php echo $j;?>">

        	<a href="<?php echo base_url(); ?>job/<?php echo $similar->jURL;?>"><?php echo substr($similar->jTitle,0,70)."...";?></a>

            <small><span style="color:#0098CC"><?php echo $similar->jNature;?></span>, <?php if($similar->jStartSalary == "0" || $similar->jEndSalary == "0"){echo "Not Disclosed";} else {if($similar->jSalHidden == "1"){ echo "Not Disclosed"; } else {?><?php echo $similar->jCurrency;?><?php echo number_format($similar->jStartSalary);?> - <?php echo $similar->jCurrency;?>

			<?php echo number_format($similar->jEndSalary);?> <?php if($similar->jsalType != ""){ echo "Per ".$similar->jsalType;}?><?php }} ?></small>

        </div>

        <?php $j++; endforeach; ?>

        </div>

        </div>

    </div>

    	<?php } ?>

    </div>

    <?php if(count($jobs) > 0){?>

    <div class="col-xs-12 jobdesp locdata nopad" style="margin-top:0;" id="jobsnotifybox">

        	<div class="notifybg">

            	<h2 style="  text-transform: uppercase;

  font-size: 14px;

  margin-bottom: 10px;">Email me jobs like this</h2>

                <div class="inputbxnotify"> 

                	<form name="subscribe" id="subscribe" method="post" action="<?php echo base_url(); ?>jobsite/subscribe_list">

                	<div class="col-xs-10 nopad">

                    	<input type="email" name="notifyemail" id="notifyemail" required class="notifycalss" placeholder="Provide your email address">

                        <input type="hidden" value="<?php echo $jobs[0]->jTitle;?>" name="jobtitlesub" id="jobtitlesub">

                    </div>

                    <div class="col-xs-2 nopad">

                    	<button type="submit" class="btn btnsearch subcalass pink">Submit</button>

                    </div>

                    </form>

                </div>

                <p><small>By clicking Submit, you accept our <a href="<?php echo base_url(); ?>terms" style="color:#ef7268">Terms & Conditions</a>.</small></p>

            </div>

        </div>

    <?php } ?>

  

  

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

<div class="container-popup" id="boxmesageemailjobshare" style=" <?php if(isset($_GET['link']) && $_GET['link'] == "sendasemail"){echo "display:block;";} else {echo "display:none;";}?>">

    <div class="rightpop">

    

    	<div id="messpopup" style="display:block;">

        	<h2>Email-A-Friend <i class="fa fa-close right" style="cursor:pointer;" onClick="hide1click_email()"></i></h2>

            <p style="margin:10px 0;">

            	Seen a job that would be perfect for a friend or relative? Simply fill in their email address and we'll send them a link to this job.

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

function coverltterboxshow()

{

	$("#coverltterboxshow").show();

}

function resumeboxshow()

{

	$("#resumeboxshow").show();

}

function hide1click_email()

{

	$("#boxmesageemailjobshare, #boxmesageemail, #boxloginpopup, #coverltterboxshow, #resumeboxshow").hide();

}

</script>



<div class="container-popup" id="coverltterboxshow" style="display:none;">

    <div class="rightpop">

    	<div class="col-xs-12 bxlogin nopad">

      <div class="login-inner left" style="border:none;">

        <h2>Add New Cover Letter <i class="fa fa-close right" style="cursor: pointer;

  position: absolute;

  right: -6px;

  margin-top: -24px;

  border: 1px solid #EF7268;

  border-radius: 70%;

  padding: 7px 8px;

  background-color: #EF7268;

  color: #fff;" onClick="hide1click_email()"></i></h2>

        <?php if(isset($_SESSION['msglogin'])){?>

        <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>

        <?php } ?>

        <form name="loginform" id="loginform" action="<?php echo base_url(); ?>jobsite/add_apply_coverletter" method="post">

        <div class="col-xs-12 nopad boxinput">

          <input type="text" name="covertitle" id="covertitle" required class="inputjob" placeholder="Cover Title">

        </div>

        <div class="col-xs-12 nopad boxinput">

        	<textarea style="height:100px" name="coverDescp" placeholder="Cover letter" id="coverDescp" class="textarea inputjob styletxtarea" required onblur="checkspaces('coverDescp')"></textarea>

        </div>

         <div class="col-xs-12 nopad boxinput">

          <button type="submit" name="signup" class="btn pink right">Submit</button>

        </div>

         </form>

      </div>

    </div>

    

    </div>

</div>

<!--CREATE CV-->

<div class="container-popup" id="resumeboxshow" style="display:none;">

    <div class="rightpop">

    	<div class="col-xs-12 bxlogin nopad">

      <div class="login-inner left" style="border:none;">

        <h2>Add New Resume <i class="fa fa-close right" style="cursor: pointer;

  position: absolute;

  right: -6px;

  margin-top: -24px;

  border: 1px solid #EF7268;

  border-radius: 70%;

  padding: 7px 8px;

  background-color: #EF7268;

  color: #fff;" onClick="hide1click_email()"></i></h2>

        <?php if(isset($_SESSION['msglogin'])){?>

        <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>

        <?php } ?>

        <form name="loginform" id="loginform" action="<?php echo base_url(); ?>jobsite/upload_resume_step" method="post" enctype="multipart/form-data">

        <div class="col-xs-12 nopad boxinput">

                <input type="text" name="cvtitle" id="cvtitle" onBlur="checkspaces('cvtitle')" required class="inputjob" value="" placeholder="CV Title">

                 <input type="hidden" name="returl" id="returl" value="<?php echo current_url();?>?apply=yes">

              </div>

        <div class="col-xs-12 nopad boxinput">

                	

                  <input type="file" name="userfile" id="userfile" class="inputjob">

                  <br><span style="color:#f00;display: block;margin: 5px 0 0;  text-align: right;">Only (PDF,DOC) file allowed... 2MB max file size</span>

                  <input type="hidden" name="cvID" id="cvID" class="inputjob" value="<?php echo $cv[0]->cvID;?>">

            </div>

        <div class="col-xs-12 nopad boxinput">

              <select name="findcv" id="findcv" class="inputjob">

                <option value="1" selected>Let recruiters find your CV</option>

                <option value="0" >Hide your CV from recruiters</option>

              </select>

            </div>

            <button type="submit" name="signup" id="signypbutton" class="btn pink right" style="margin-top: 0;">Upload Resume</button>

       </form>

      </div>

    </div>

    

    </div>

</div>



<div class="container-popup" id="boxloginpopup" style="display:none; background:rgba(0,0,0,1);">

    <div class="rightpop" style="top:11% !important">

    	<div class="col-xs-12 bxlogin nopad">

      <div class="login-inner left" style="border:none;">

        <h2>Login 

        <?php if(isset($_SESSION['JobsSessions'])){?><i class="fa fa-close right" style="cursor: pointer;

  position: absolute;

  right: -6px;

  margin-top: -24px;

  border: 1px solid #EF7268;

  border-radius: 70%;

  padding: 7px 8px;

  background-color: #EF7268;

  color: #fff;" onClick="hide1click_email()"></i>

  <?php } ?>

  </h2>

        <?php if(isset($_SESSION['msglogin'])){?>

        <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>

        <?php } ?>

        <form name="loginform" id="loginform" action="<?php echo base_url(); ?>do/login" method="post">

        <div class="col-xs-12 nopad boxinput">

          <input type="email" name="emailadd" id="emailadd" required class="inputjob" placeholder="Email Address">

        </div>

        <div class="col-xs-12 nopad boxinput">

          <input type="password" name="passlogin" id="passlogin" required class="inputjob" placeholder="Password">

        </div>

        <input type="hidden" value="<?php if(isset($_GET['redirect'])){echo $_GET['redirect'];}?>" name="urlredirect" id="urlredirect">

         <div class="col-xs-12 nopad boxinput">

          <button type="submit" name="signup" class="btn pink right">Login</button>

        </div>

         </form>

       <div class="sociallogin clear left">

        Not a registered User? <br>

        <a href="<?php echo base_url(); ?>signup"><button type="button" name="signup" class="btn green">Sign-Up</button></a>

       </div>

       <div class="sociallogin clear left">

        OR <br>

        Login using

        <br>

        <a href="javascript:;" onclick="FBLogin();" class="btnsocial fbbg">Facebook</a>

        <a href="<?php echo base_url(); ?>twitter/login" class="btnsocial fblnkd">Twitter</a>

        <?php if (isset($authUrl)){ ?>

        <a href="<?php echo $authUrl; ?>" class="btnsocial fbgoogle">Google</a>

        <?php } ?>

    

       </div>

      </div>

    </div>

    

    </div>

</div>



<style>

.notifybg p {   margin-top: 10px;

  display: block;

  float: left;

  width: 100%;}

.subcalass {  width: 100%;

  padding: 16px 16px 17px;

  border-radius: 0 5px 5px 0;}

.notifycalss {  float: left;

  border: 1px solid #ccc;

  padding: 18px;

  width: 100%;

  box-sizing: border-box;

  border-radius: 5px 0 0 5px;}

.notifybg {  

  margin-bottom: 20px;

  background: #f5f7fa;

  padding: 40px;

  border-radius: 4px;

  border: 1px solid #ccc;

  text-align: center;

  float: left;

  width: 100%;

  box-sizing: border-box;}

.jobslayer {  line-height: 19px;

  margin-bottom: 10px;

  float: left; font-size:14px;

  width: 100%;}

  #bxother_5 { margin-bottom:0;}

.jobslayer small {   color: #A8A8A8;

  clear: both;

  float: left;

  width: 100%;}

#boxmesageemail { display:none;}

.fixedpop { position: fixed;

  top: 0;

  background: rgba(4, 148, 197,0.9);

  width: 100%;

  padding: 0px 30px;

  box-sizing: border-box;

  color: #fff;

  z-index:100;}

  .fixedpop h2 {font-size: 15px;

  padding: 11px;

  text-transform: uppercase;}

  .postedby {  border: 1px solid #ccc;

  padding: 16px;

  line-height: 23px;

  font-size: 13px;

  margin-left: 12px;

  border-radius: 5px;}

  .postedby p {font-size: 11px; text-align:center;

  text-transform: uppercase;}

  .postedby span {color: #7CA52F; font-weight:bold;}

</style>

<script language="javascript">

function showloginbox(id){

	$("#boxloginpopup").show();

	showpopupbox(id);

}

function showInformationbox(){

	$("#showInformationbox").show();

}

function showpopupbox(id) {      

        var strs = id;

        var autocompleteURL = "<?php echo base_url(); ?>jobsite/save_session_job?rnd=" + Math.random() +"&id="+ strs;

        $.ajax({

            url : autocompleteURL,

            async: true,

            cache: false,

            method : "POST",

            success : function(respd) {}

        });

    }

	

function showloginboxapply (id){

	$("#boxloginpopup").show();

	showpopupboxapply(id);

}

function showpopupboxapply(id) {      

        var strs = id;

        var autocompleteURL = "<?php echo base_url(); ?>jobsite/apply_session_job?rnd=" + Math.random() +"&id="+ strs;

        $.ajax({

            url : autocompleteURL,

            async: true,

            cache: false,

            method : "POST",

            success : function(respd) {}

        });

    }

function showloginboxshowjob (id){

	$("#boxloginpopup").show();

	showpopupboxnewjob(id);

}

function showpopupboxnewjob(id) {      

        var strs = id;

        var autocompleteURL = "<?php echo base_url(); ?>jobsite/session_job_redirect?rnd=" + Math.random() +"&id="+ strs;

        $.ajax({

            url : autocompleteURL,

            async: true,

            cache: false,

            method : "POST",

            success : function(respd) {}

        });

    }

</script>

<script language="javascript">

$(document).ready(function(e){

$(window).scroll(function(e){ 

  $el = $('.fixedpop'); 

  if ($(this).scrollTop() > 250){ 

    $el.slideDown('slow'); 

  } 

  else {

	  $el.slideUp(); 

  }

});

});

<?php 

if(!isset($_SESSION['JobsSessions'])){ 

if(isset($_GET['apply']) && $_GET['apply'] == "yes"){?>

showloginboxapply('<?php echo $jobs[0]->jID;?>');

<?php } else {

	?>

	showloginboxshowjob('<?php echo $jobs[0]->jID;?>');

	$(document).ready(function(e) {

    $("body").css("overflow", "hidden");

});

	<?php 

	}} ?>

	

<?php if(isset($_GET['link']) && $_GET['link'] == "broadcast"){?>

$(document).ready(function(e) {

	//alert($('#socialshareicon').offset().top);

	$('html, body').animate({

    scrollTop: ($('#socialshareicon').offset().top)-100}, 1000);

});

<?php } ?>

</script>

<?php 



if(isset($_GET['view']) && $_GET['view'] == "moderator" && isset($_SESSION['backendAdminSess'])){

	$arru = array(

		'jID'	=>	$jobs[0]->jID,

	);

	$data = array(

		'jViewed' 		   => 1,

	);

	$this->front_model->update_query('dev_web_jobs',$data,$arru);

}

unset($_SESSION['saveid']); unset($_SESSION['applyidsession']);unset($_SESSION['redirectidsession']);?>



<?php

if(isset($_SESSION['JobsSessions']) && $_SESSION['JobsSessions'][0]->uActType == "1"){

	$cv   	  = array('uID' => UID);

	$ucv     = $this->front_model->get_query_simple('*','dev_web_cv',$cv);

	$countcv = $ucv->num_rows();

	$cvuser   	  = array('uID' => UID);

	$userv     = $this->front_model->get_query_simple('*','dev_web_user',$cvuser);

	$usercv = $userv->result_object();

	//echo $usercv[0]->uverifyemail;

	if($countcv == 0 || $usercv[0]->uverifyemail == 0){



?>

<script language="javascript">

showInformationbox();

$(document).ready(function(e) {

    $("body").css("overflow", "hidden");

});

</script>

<div class="container-popup" id="showInformationbox" style="display:block;   background: rgba(0,0,0,1);">

    <div class="rightpop">

    	<div class="col-xs-12 bxlogin nopad">

      <div class="login-inner left" style="border:none;">

        <h2>Incomplete Profile <span class="right"><a href="<?php echo base_url();?>"><i class="fa fa-close"></i></a></span></h2>
				
        	<p style="padding-top: 14px;">Please complete below steps to view job details.</p>

            <div class="idverify">

            	<?php if($countcv == 0){?>

                	<p style="padding-top: 14px;

  "><i class="fa fa-arrow-right"></i> Upload Your Resume - <a href="<?php echo base_url();?>create-cv" style="color: #f00;"><strong>Create Resume</strong></a></p>

                <?php } ?>

                <?php if($usercv[0]->uverifyemail == 0){?>

                	<p style="padding-top: 14px;"><i class="fa fa-arrow-right"></i> Verify Your Email - <a href="<?php echo base_url();?>jobsite/resend_verified_email" style="color: #f00;"><strong>Resend Verification Email</strong></a></p>

                <?php } ?>

                <?php if($usercv[0]->uPhone == ""){?>

                	<p style="padding-top: 14px;"> <i class="fa fa-arrow-right"></i> Mobile Number not added -  <a href="<?php echo base_url();?>create-cv?page=personal" style="color: #f00;"><strong>Add Mobile Number</strong></a></p>

                <?php } ?>

            </div>

      </div>

    </div>

    

    </div>

</div>

<?php 

	}



}

?>

