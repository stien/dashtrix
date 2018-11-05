<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php if($this->uri->segment(1) == "login"){ ?>
<title>Login - <?php echo TITLEWEB; ?></title>
<meta name="description" content="Login">
<meta name="keywords" content="Login">
<?php } else if($this->uri->segment(1) == "recruiter-login"){ ?>
<title>Recruiter Login - <?php echo TITLEWEB; ?></title>
<meta name="description" content="Login">
<meta name="keywords" content="Login">
<?php } else if($this->uri->segment(1) == "candidate-search"){ ?>
<title>Search Candidates - <?php echo TITLEWEB; ?></title>
<meta name="description" content="Login">
<meta name="keywords" content="Login">
<?php } else if($this->uri->segment(1) == "signup"){ ?>
<title>Sign Up - <?php echo TITLEWEB; ?></title>
<meta name="description" content="Signup">
<meta name="keywords" content="signup,register">
<?php } else if($this->uri->segment(1) == "checkout"){ ?>
<title>Checkout - <?php echo TITLEWEB; ?></title>
<meta name="description" content="Checkout page for payment">
<meta name="keywords" content="checkout, payment">
<?php } else if($this->uri->segment(1) == "post-job"){ ?>
<title>Job Recruitment - <?php echo TITLEWEB; ?></title>
<meta name="description" content="Checkout page for payment">
<meta name="keywords" content="checkout, payment">
<?php } else if($this->uri->segment(1) == "job-application"){ ?>
<title>Job Application - <?php echo TITLEWEB; ?></title>
<meta name="keywords" content="applied,applications, jobs, jobseeker, applied jobs">
<?php } else if($this->uri->segment(1) == "messages"){ ?>
<title>My Messages - <?php echo TITLEWEB; ?></title>
<meta name="keywords" content="applied,applications, jobs, jobseeker, applied jobs">
<?php } else if($this->uri->segment(1) == "job-application"){ ?>
<title>Job Application - <?php echo TITLEWEB; ?></title>
<meta name="keywords" content="applied,applications, jobs, jobseeker, applied jobs">
<?php } else if($this->uri->segment(1) == "cover-letters") {?>
<title>Covering Letters - <?php echo TITLEWEB; ?></title>
<meta name="keywords" content="cover, letters, jobs cover letters, cover letters">
<?php } else if($this->uri->segment(1) == "cv-management") {?>
<title>Resume Management - <?php echo TITLEWEB; ?></title>
<meta name="keywords" content="resume, cv, resume management">
<?php } else if($this->uri->segment(1) == "saved-jobs") {?>
<title>Saved Jobs - <?php echo TITLEWEB; ?></title>
<meta name="keywords" content="jobs, saved, saved jobs">
<?php } else if($this->uri->segment(1) == "dashboard") {?>
<title><?php echo FNAME;?> <?php echo LNAME;?> Dashboard</title>
<meta name="keywords" content="jobs, saved, saved jobs">
<?php } else if($this->uri->segment(1) == "recruiter-posted-jobs") {?>
<title>My Posted Jobs</title>
<meta name="keywords" content="jobs, saved, saved jobs">
<?php } else if($this->uri->segment(1) == "jobs") {
$arr = array('catLink' => $this->uri->segment(2));
$config	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);
$catid 	= $config->result_object();
?>
<title><?php echo $catid[0]->catTitle;?> Sector Jobs</title>
<meta name="description" content="<?php echo $catid[0]->catDesp;?>">
<meta name="keywords" content="<?php echo $catid[0]->catKeys;?>">
<?php }  else if($this->uri->segment(1) == "job") {
$arr = array('jURL' => $this->uri->segment(2),'jJobStatus' => 1);
$config	= $this->front_model->get_query_simple('*','dev_web_jobs',$arr);

$catid 	= $config->result_object();
if(count($catid) > 0){
?>
<title><?php echo $catid[0]->jTitle;?></title>
<meta name="description" content="<?php echo strip_tags(htmlspecialchars_decode($catid[0]->jDescription));?>">
<?php } else {?>
<title>404 Error</title>
<?php }} else if($this->uri->segment(1) == "job-applicants") {
$arr = array('jID' => $this->uri->segment(2));
$config	= $this->front_model->get_query_simple('*','dev_web_jobs',$arr);
$catid 	= $config->result_object();
?>
<title><?php echo $catid[0]->jTitle;?> Applicants</title>
<meta name="description" content="<?php echo substr(strip_tags(htmlspecialchars_decode($catid[0]->jDescription)),0,75);?>">
<?php } else if($this->uri->segment(1) == "about-us" || $this->uri->segment(1) == "contact-us" || $this->uri->segment(1) == "terms" || $this->uri->segment(1) == "privacy") {
$arr = array('pLink' => $this->uri->segment(1));
$config	= $this->front_model->get_query_simple('*','dev_web_pages',$arr);
$catid 	= $config->result_object();
?>
<title><?php echo $catid[0]->pTitle;?></title>
<meta name="description" content="<?php echo $catid[0]->pDescp;?>">
<meta name="keywords" content="<?php echo $catid[0]->pKeyword;?>">
<?php } else { ?>
<title><?php echo WEBNAME; ?></title>
<meta name="description" content="<?php echo WEBDESCP; ?>">
<meta name="keywords" content="<?php echo WEBKEYS; ?>">
<?php } ?>
<link href="<?php echo base_url(); ?>resources/frontend/css/style.css" rel="stylesheet" type="text/css" media="all">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
</head>

<body>
<?php 
function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}
?>
<script type="text/javascript">
window.fbAsyncInit = function() {
	FB.init({
	appId      : '1891590237740531', // replace your app id here
	channelUrl : '<?php echo base_url(); ?>channel.html', 
	status     : true, 
	cookie     : true, 
	xfbml      : true  
	});
};
(function(d){
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "https://connect.facebook.net/en_US/all.js";
	ref.parentNode.insertBefore(js, ref);
}(document));

function FBLogin(){
	FB.login(function(response){
		if(response.authResponse){
			window.location.href = "<?php echo base_url(); ?>fb/login?page=fblogin";
		}
	}, {scope: 'email,user_likes'});
}
</script>
<div id="headertop" class="left clear" style="min-height: 48px;">
  <div class="container">
    <div class="col-xs-12 nopad">
      <div class="col-xs-2 logo">
      	<a href="<?php echo base_url();?>">
        	<img src="<?php echo base_url(); ?>resources/frontend/images/logo.png" class="logotop" alt="<?php echo TITLEWEB;?>" />
        </a>
      </div>
      <div class="col-xs-10 navbar pright0">
        <ul>
        <?php if(isset($_SESSION['JobsSessions']) && ACTYPE == 2 || $this->uri->segment(1) == "checkout" || $this->uri->segment(1) == "post-job" || $this->uri->segment(1) == "recruiter-login" || $this->uri->segment(1) == "candidate-search"){ ?>
          	<li><a href="<?php echo base_url(); ?>post-job">Job Adverts</a></li>
            <li><a href="<?php echo base_url(); ?>candidate-search">Candidate Search</a></li>
            <?php /*?><li><a href="javascript:;"  onclick="enquiryform()">Contact Us</a></li><?php */?>
		<?php } else { ?> 
          <?php /*?><li><a href="<?php echo base_url(); ?>about-us">About Us</a></li><?php */?>
        <?php } ?>
        </ul>
        
        <div class="btnbox right">
        <?php if(!isset($_SESSION['JobsSessions'])){ ?>
        <?php if($this->uri->segment(1) == "checkout" || $this->uri->segment(1) == "post-job" || $this->uri->segment(1) == "recruiter-login" || $this->uri->segment(1) == "candidate-search"){ ?>
        <a href="<?php echo base_url(); ?>login"><button name="signup" class="btn green <?php if($this->uri->segment(1) == "signup"){echo 'btnhover';}?>" style="border-radius: 23px;">Jobseekers? Click Here</button></a>
        <?php } else { ?>
          <a href="<?php echo base_url(); ?>signup"><button name="signup" class="btn green <?php if($this->uri->segment(1) == "signup"){echo 'btnhover';}?>" style="border-radius: 23px;">Sign-Up</button></a>
          <?php } ?>
          <a href="<?php echo base_url(); ?>post-job"><button name="postjob" class="btn pink <?php if($this->uri->segment(1) == "post-job"){echo 'btnhover';}?>"  style="border-radius: 23px;">Post a Job</button></a>
          <?php if($this->uri->segment(1) == "checkout" || $this->uri->segment(1) == "post-job" || $this->uri->segment(1) == "recruiter-login" || $this->uri->segment(1) == "candidate-search"){ ?>
          <?php }  else { ?>
          <a href="<?php echo base_url(); ?>login"><button name="login" class="btn green <?php if($this->uri->segment(1) == "login"){echo 'btnhover';}?>"  style="border-radius: 23px;">Login</button></a>
          <?php } ?>
          <a href="<?php echo base_url(); ?>recruiter-login"><button name="recruiter" class="btn blue"  style="border-radius: 23px;">Recruiter Login</button></a>
          <?php } else {?>
          <?php if(ACTYPE != 0){?>
          <a href="<?php echo base_url(); ?>post-job"><button name="postjob" class="btn pink <?php if($this->uri->segment(1) == "post-job"){echo 'btnhover';}?>"  style="border-radius: 23px;">Post a Job</button></a>
           <a href="<?php echo base_url(); ?>dashboard"><button name="signup" class="btn green <?php if($this->uri->segment(1) == "dashboard"){echo 'btnhover';}?>"  style="border-radius: 23px;">Dashboard</button></a>
           <?php } ?>
           <?php if(ACTYPE == 1){?>
            <a href="<?php echo base_url(); ?>recruiter-login"><button name="recruiter" class="btn blue"  style="border-radius: 23px;">Recruiter Login</button></a>
            <?php } ?>
           <a href="<?php echo base_url(); ?>logout?type=<?php echo ACTYPE;?>"><button name="postjob" class="btn pink"  style="border-radius: 23px;">Logout</button></a>
           	
          <?php } ?> 
          <?php if(isset($_SESSION['sessionCart']) || isset($_SESSION['sessionCartCandidate'])){?>
          <a href="<?php echo base_url(); ?>checkout"><button name="postjob" id="cart"   style="border-radius: 23px;" class="btn pink"><i class="fa fa-shopping-bag"></i> <sup id="cartval"><?php echo $_SESSION['sessionCart']['val'];?></sup></button></a>
          <?php }?>
          
        </div>
      </div>
    </div>
  </div>
</div>
<?php if(ACTYPE != "0"){?>
<div id="slider-layout" class="clear" <?php if($this->uri->segment(1) == "dashboard" || $this->uri->segment(1) == "saved-jobs" || $this->uri->segment(1) == "cover-letters" || $this->uri->segment(1) == "job-application" || $this->uri->segment(1) == "cv-management" || $this->uri->segment(1) == "create-cv"  || $this->uri->segment(1) == "recruiter-posted-jobs"  || $this->uri->segment(1) == "messages"  || $this->uri->segment(1) == "job-applicants" || $this->uri->segment(1) == "view-message" || $this->uri->segment(1) == "social-profile" || $this->uri->segment(1) == "job-alerts" || $this->uri->segment(1) == "company-profile" || $this->uri->segment(1) == "cv-viewed"){?>style="padding-bottom: 35px;"<?php }?>>
  <div class="container">
    <div class="col-xs-12 nopad searchd">
    <?php 
	
	if($this->uri->segment(1) == "dashboard" || $this->uri->segment(1) == "saved-jobs" || $this->uri->segment(1) == "cover-letters" || $this->uri->segment(1) == "job-application"  || $this->uri->segment(1) == "cv-management"  || $this->uri->segment(1) == "create-cv" || $this->uri->segment(1) == "recruiter-posted-jobs"  || $this->uri->segment(1) == "messages"  || $this->uri->segment(1) == "job-applicants"  || $this->uri->segment(1) == "view-message"  || $this->uri->segment(1) == "job-alerts"  || $this->uri->segment(1) == "social-profile" || $this->uri->segment(1) == "company-profile" || $this->uri->segment(1) == "cv-viewed"){?>
    	<h1 class="center">Welcome "<?php echo FNAME;?> <?php echo LNAME;?>"</h1>
        <div class="navbox">
       	<?php if(ACTYPE == 1){ ?>
            <div class="col-xs-2">
            <a href="<?php echo base_url(); ?>dashboard/profile" class="boxnavlink <?php if($this->uri->segment(2) == "profile"){echo 'boxnavlinkhover';}?>">
            	<i class="fa fa-male fanav"></i>
                Profile
            </a>
           </div>
        	<div class="col-xs-2">
        	<a href="<?php echo base_url(); ?>cv-management" class="boxnavlink <?php if($this->uri->segment(1) == "cv-management"|| $this->uri->segment(1) == "create-cv"){echo 'boxnavlinkhover';}?>">
            	<i class="fa fa-mortar-board fanav"></i>
                Resume
            </a>
           </div>           
           	<div class="col-xs-2">
            <a href="<?php echo base_url(); ?>cover-letters" class="boxnavlink <?php if($this->uri->segment(1) == "cover-letters"){echo 'boxnavlinkhover';}?>">
            	<i class="fa fa-file-text-o fanav"></i>
                Cover Letters
            </a>
            </div>
           	<div class="col-xs-2">
            <a href="<?php echo base_url(); ?>job-application" class="boxnavlink <?php if($this->uri->segment(1) == "job-application"){echo 'boxnavlinkhover';}?>">
            	<i class="fa fa-clone fanav"></i>
                Applications
            </a>
           </div>
          	<div class="col-xs-2">
            <a href="<?php echo base_url(); ?>messages" class="boxnavlink">
            	<i class="fa fa-comments-o fanav"></i>
                Messages
            </a>
           </div>
          	<div class="col-xs-2">
            <a href="<?php echo base_url(); ?>saved-jobs" class="boxnavlink <?php if($this->uri->segment(1) == "saved-jobs"){echo 'boxnavlinkhover';}?>" >
            	<i class="fa fa-save fanav"></i>
                Saved Jobs
            </a>
           </div>
        <?php } else { ?>
       		<div class="col-xs-2">
            <a href="<?php echo base_url(); ?>dashboard/profile" class="boxnavlink <?php if($this->uri->segment(2) == "profile"){echo 'boxnavlinkhover';}?>">
            	<i class="fa fa-male fanav"></i>
                Profile
            </a>
           </div>
          	
            <div class="col-xs-2">
            <a href="<?php echo base_url(); ?>company-profile" class="boxnavlink <?php if($this->uri->segment(2) == "company-profile"){echo 'boxnavlinkhover';}?>">
            	<i class="fa fa-building fanav"></i>
               Company
            </a>
           </div>
            <div class="col-xs-2">
            <a href="<?php echo base_url(); ?>recruiter-posted-jobs" class="boxnavlink <?php if($this->uri->segment(1) == "recruiter-posted-jobs"){echo 'boxnavlinkhover';}?>" >
            	<i class="fa fa-save fanav"></i>
               		 Posted Jobs
            </a>
            </div>
            <div class="col-xs-2">
            <a href="<?php echo base_url(); ?>messages" class="boxnavlink <?php if($this->uri->segment(1) == "messages"){echo 'boxnavlinkhover';}?>">
            	<i class="fa fa-comments-o fanav"></i>
                Messages
            </a>
           </div>
           <div class="col-xs-2">
            <a href="<?php echo base_url(); ?>saved-jobs" class="boxnavlink <?php if($this->uri->segment(1) == "saved-jobs"){echo 'boxnavlinkhover';}?>" >
            	<i class="fa fa-save fanav"></i>
                Saved Jobs
            </a>
           </div>
           <div class="col-xs-2">
            <a href="<?php echo base_url(); ?>cv-viewed" class="boxnavlink <?php if($this->uri->segment(1) == "cv-viewed"){echo 'boxnavlinkhover';}?>" >
            	<i class="fa fa-eye fanav"></i>
                CV Viewed
            </a>
           </div>
        <?php } ?>
        </div>
    <?php } else {?>

	<?php if(isset($_SESSION['JobsSessions'])){if(ACTYPE == 2){?>
    	<h1 class="center">Access over 7.3 million candidates</h1>
		<div class="searchbox left" >
        <form name="searchform" id="searchform" method="post" action="<?php echo base_url(); ?>candidate-search-action">
        
        <div class="col-xs-2 pr0">
          <input type="text" name="searchbyjobtile" id="searchbyjobtile" class="searchincandi" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" placeholder="Preffered Job Title" required>
          </div>
        <div class="col-xs-2 pr0">
          <input type="text" name="searchbyname" id="searchbyname" class="searchincandi" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" placeholder="Search By CV Title">
          </div>
        
        <div class="col-xs-2 pr0">
          <input type="text" name="searchbylocation" id="searchbylocation" class="searchincandi" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" placeholder="Search By Location">
          </div>
        <div class="col-xs-2 pr0">
          <select name="searchbyjobtype" id="searchbyjobtype" class="searchincandi p11">
          <option value="">--- Job Type ---</option>
              <option value="Any">Any</option>
              <option value="Permanent">Permanent</option>
              <option value="Contract">Contract</option>
              <option value="Part Time">Part Time</option>
              <option value="Seasonal">Seasonal</option>
          </select>
          
          </div>
        <div class="col-xs-2 pr0">
          <input type="text" name="searchbysalary" id="searchbysalary" class="searchincandi" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" placeholder="Search By Salary" >
          </div>
          <div class="col-xs-2 pr0">
          <button type="submit" class="btn btnsearch pink wd100">Search</button>
          </div>
        </form>
      </div>
	<?php }}// else {?>
    <?php if(isset($_SESSION['JobsSessions'])){if(ACTYPE == 1){?>
      <h1 class="center">START YOUR European JOB SEARCH NOW...</h1>
      <div class="searchbox">
        <form name="searchform" id="searchform" method="get" action="<?php echo base_url(); ?>">
          <input type="text" name="search" id="search" class="searchin" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" placeholder="Job Title/Skill" required>
          
          <select name="country" id="country" multiple="multiple" required class="searchin p11" style="width:45%;display:none;">
              <option value="">--- Select Country ---</option>
              <?php 
			  $arrcn = array();
				$configcn 	= $this->front_model->get_query_simple('*','dev_web_countries',$arrcn);
				$countries 	= $configcn->result_object();
			  foreach($countries as $country):?>
              <option value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
              <?php endforeach; ?>
          </select>
          <button type="submit" class="btn btnsearch pink">Search</button>
        </form>
      </div>
    <?php }} ?>
     <?php if(!isset($_SESSION['JobsSessions'])){?>
      <h1 class="center">START YOUR European JOB SEARCH NOW...</h1>
      <div class="searchbox">
        <form name="searchform" id="searchform" method="get" action="<?php echo base_url(); ?>">
          <input type="text" name="search" id="search" class="searchin" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" placeholder="Job Title/Skill" required>
          <select name="country" id="country" required class="searchin p11" multiple="multiple" style="width:45%; display:none;">
              <option value="">--- Select Country ---</option>
              <?php 
			  	$arrcn = array();
				$configcn 	= $this->front_model->get_query_simple('*','dev_web_countries',$arrcn);
				$countries 	= $configcn->result_object();
			  foreach($countries as $country):?>
              <option value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
              <?php endforeach; ?>
          <?php /*?><option value="">--- Job Type ---</option>
              <option value="Full-Time">Full-Time</option>
              <option value="Contract">Contract</option>
              <option value="Part Time">Part Time</option>
              <option value="Seasonal">Seasonal</option><?php */?>
          </select>
          <button type="submit" class="btn btnsearch pink">Search</button>
        </form>
      </div>
    <?php } ?>
    <?php } ?>
    </div>
  </div>
</div>
<?php } ?>

<?php if(isset($_SESSION['JobsSessions'])){
	if($this->uri->segment(1) == "cover-letters" || $this->uri->segment(1) == "dashboard" || $this->uri->segment(1) == "cv-management"){
	?>
	<div class="container">
	<?php /*?><div class="errormsg" style="background: #FFFBB8; border:#FFFBB8; color:#2a2a2a;">Kindly check your spam folder as well, while checking emails for any verification/information alerts from JobsRope.</div><?php */?>
    <div class="col-xs-6 nopad">
    	<span style="background: #fafafa;
  border: 1px solid #ccc;
  display: block;
  float: left;
  padding: 11px;
  border-radius: 5px;">
    	<?php if(VEMAIL == 0){?>
            <i class="fa  fa-check-circle-o left" style="margin-right:10px;"></i>
            <span class="left">Email not verified - <a href="<?php echo base_url(); ?>jobsite/resend_verified_email" style="color:#f00;">Resend Verification Email</a></span>
        <?php }  else {?>
            <i class="fa fa-check-circle-o left" style="color:#093;margin-right:10px;"></i>
            <span class="left" style="color:#093;">Email verified</span>
        <?php } ?>
        </span>
        
    </div>
    </div>
<?php }} ?>