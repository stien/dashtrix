<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once './vendor/qrcode.php';

use \Stripe\Strip;
use \Stripe\Charge;
use \Stripe\Customer;
use \Twilio\Rest\Client;

class ico extends CI_Controller {

	 

	private $data=array();

	function __construct()

	{

		parent::__construct();

		ob_start();

		error_reporting(0);


		////// for cloudflare

		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
			  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
			}

		$this->load->library('form_validation');

		$this->load->helper('url');

		

		$this->load->database();

		$this->db->reconnect();

		$this->load->model('front_model'); //Load frontend model

		session_start();


		
		if(isset($_SESSION['unverified_otp']) && $_SESSION['unverified_otp']==1){
			$seg = $this->uri->segment(1);

			if($seg!="resend-otp" && $seg!="submit-otp" && $seg!="verify-otp" && $seg!="logout"){
				redirect(base_url().'verify-otp');
				exit;
			}
		}

		

		$arr = array();

		$config 	= $this->front_model->get_query_simple('*','dev_web_config',$arr);

		$rconfig 	= $config->result_object();

		foreach($rconfig as $confg):

			define("TITLEWEB",$confg->configWeb);

			define("WEBURL",$confg->configURL);

			define("WEBNAME",$confg->configTitle);

			define("WEBDESCP",$confg->configDescrip);

			define("WEBKEYS",$confg->configKeyword);

			define("WEBPHONE",$confg->configPhone);

			define("WEBEMAIL",$confg->configEmail);

			define("WEBADD",$confg->configAddress);

			define("WEBCOPY",$confg->configCopy);

			define("WEBFB",$confg->configFacebook);

			define("WEBTWT",$confg->configTwitter);

			define("WEBGOOGLE",$confg->webGoogle);

			define("WEBLKD",$confg->webLkndIn);

			define("WEBYT",$confg->webYouTube);

			define("WEBPNT",$confg->webPintrest);

		endforeach;

		if(isset($_SESSION['JobsSessions'])){

			//session_destroy();

//			print_r($_SESSION['JobsSessions']);

			$arrusercon = array('uID' => $_SESSION['JobsSessions'][0]->uID);

			$quserdat	= $this->front_model->get_query_simple('*','dev_web_user',$arrusercon);

			$user 	= $quserdat->result_object();

			define("UID",$user[0]->uID);

			define("FNAME",$user[0]->uFname);

			define("LNAME",$user[0]->uLname);

			define("EMAIL",$user[0]->uEmail);

			define("USERNAME",$user[0]->uUsername);

			define("CITY",$user[0]->uCountry);

			define("CITYMAIN",$user[0]->uCity);

			define("PHONE",$user[0]->uPhone);

			define("PROIMAGE",$user[0]->uImage);

			define("STATUS",$user[0]->uStatus);

			define("ABOUTME",$user[0]->uAbout);

			define("CODE",$user[0]->uCode);

			define("JOINDATE",$user[0]->joinDate);

			define("ACTYPE",$user[0]->uActType);

			define("ADDRESS",$user[0]->uAddress);

			define("ZIPCO",$user[0]->uZip);

			define("FB",$user[0]->ufb);

			define("VEMAIL",$user[0]->uverifyemail);

			if($user[0]->uActType == 2){

				define("ADVERTS",$user[0]->uAdverts);

				define("CANDIDATE",$user[0]->uCanSearch);

				define("COMPANY",$user[0]->uCompany);

				define("CANDIENDDATE",$user[0]->endDateCandidate);

				define("ENDDATE",$user[0]->endDate);

				//define("CVVIEW",$user[0]->ucView);

			}

		}

		else {}

		

		$sid = session_id();

		$arr = array('id'=>$sid);

		$chkv = $this->front_model->get_query_simple('COUNT(*) AS VISITORS','dev_web_visitors',$arr);

		$chkr 	= $chkv->result_object();

		if($chkr[0]->VISITORS == 0){

			$data = array('id' => session_id());

			$this->front_model->addvisitors($data);

		}

		else { }

		

		//$localIP = getHostByName(getHostName());

		$arr = array(

			'ipAdd'	=>	$_SERVER['REMOTE_ADDR'],

		);

		$ip = $this->front_model->get_query_simple('*','dev_web_ip',$arr);

		//$ip = $this->front_model->get_ip_data($_SERVER['REMOTE_ADDR']);

		$ipc = $ip->num_rows();

		if($ipc > 0){

		?>

        <style>

		.ipbanned { padding: 100px;

		  display: block;

		  border-radius:5px;    line-height: 23px;

    text-transform: uppercase;

		  box-sizing: border-box;

		  border:1px solid #ccc;

		  font-family:Arial, Helvetica, sans-serif; font-size:12px;

		  text-align:center;

		  margin-bottom: 10px;

		  background: #FF9;

		  margin:20px auto;

		  width: 50%;}

		</style>

        <title>IP Banned</title>

        <div class="ipbanned">Dear User<br />

        		Your IP address (<?php echo $_SERVER['REMOTE_ADDR'];?>) has been banned by jobsrope!</div>

        <?php

		die;	

		}

		

		

	}

	// Random Code Generator

	public function generateRandomString($length = 10) 

	{

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $charactersLength = strlen($characters);

    $randomString = '';

		for ($i = 0; $i < $length; $i++) {

			$randomString .= $characters[rand(0, $charactersLength - 1)];

		}

    return $randomString;

	}

	public function generateSecurityCode($length = 5) {

    $characters = '0123456789';

    $charactersLength = strlen($characters);

    $randomString = '';

		for ($i = 0; $i < $length; $i++) {

			$randomString .= $characters[rand(0, $charactersLength - 1)];

		}

    return $randomString;

	}
	
	public function notification_users($subject,$data)
	{
		$data = array(
				'nSubject' 		=> $subject,
				'uID' 			=> UID,
				'nData' 		=> $data,
				'nDate' 		=> date('Y-m-d H:i:s'),
			);
			$this->front_model->add_query('dev_web_notfiications',$data);
	}

	public function notify_user($subject,$data,$id)
	{
		$data = array(
				'nSubject' 		=> $subject,
				'uID' 			=> $id,
				'nData' 		=> $data,
				'nDate' 		=> date('Y-m-d H:i:s'),
			);
			$this->front_model->add_query('dev_web_notfiications',$data);
	}


	// HOME PAGE

	public function index()

	{

		if(ACTYPE == "0"){

				$arr = array();

				$cat 	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);

				$this->data['industry']	= $cat->result_object();

				$ben 	= $this->front_model->get_query_simple('*','dev_web_benefits',$arr);

				$this->data['benefits']	= $ben->result_object();

				$dep	= $this->front_model->get_query_simple('*','dev_web_departments',$arr);

				$this->data['departments']	= $dep->result_object();

				$citi 		= $this->front_model->get_query_simple('*','dev_web_cities',$arr);

				$this->data['cities']	= $citi->result_object();

				$this->load->view('frontend/advert_post_page_agent', $this->data);

				//header ( "Location:" . $this->config->base_url ()."job-post-agent");

			} else {

				// GET LATEST JOBS
				if(!isset($_SESSION['passwordprotected'])){
					header ( "Location:" . $this->config->base_url ()."password/protect");
				} else {
					$jobs = $this->front_model->get_jobs_list_home(0,9);
					$this->data['jobs'] = $jobs->result_object();
					$this->load->view('frontend/home',$this->data);
				}
			}

	}
	
	public function password_protected(){
		//echo $_SESSION['passwordprotected'];
		$this->load->view('frontend/password_protected',$this->data);
	}
	
	public function check_password_validate(){
		$passwordvalidate = "y52^YW*z";
		$userpassword = $this->input->post('passwordprotected');
		if(md5($userpassword) != md5($passwordvalidate)){
			header ( "Location:" . $this->config->base_url ()."password/protect");
		} else {
			$_SESSION['passwordprotected'] = $passwordvalidate;
			header ( "Location:" . $this->config->base_url ());
		}
	}

	// TIME ELASPED

	public function time_elapsed_string($datetime, $full = false) 

	{

		

    $now = new DateTime;

    $ago = new DateTime($datetime);

    $diff = $now->diff($ago);



    $diff->w = floor($diff->d / 7);

    $diff->d -= $diff->w * 7;



    $string = array(

        'y' => 'year',

        'm' => 'month',

        'w' => 'week',

        'd' => 'day',

        'h' => 'hour',

        'i' => 'minute',

        's' => 'second',

    );

    foreach ($string as $k => &$v) {

        if ($diff->$k) {

            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');

        } else {

            unset($string[$k]);

        }

    }



    if (!$full) $string = array_slice($string, 0, 1);

    return $string ? implode(', ', $string) . ' ago' : 'just now';

	}

	// LOGIN 

	public function login_page()

	{

		if(!isset($_SESSION['JobsSessions'])){

			$this->load->view('frontend/login',$this->data);

		}

		else {

			header ( "Location:" . $this->config->base_url ()."dashboard");

		}

		

	}

	// ACCOUNT LOGIN

	public function do_login_account()

	{


		if(!$this->verify_captcha())
				{

					$_SESSION['wrongsignup'] = $_POST;
				 	$_SESSION['msglogin'] = "Captcha Error!";
					redirect($_SERVER['HTTP_REFERER']);
					exit;
				}


		$arr = array(
			'uEmail'	=>	$this->input->post('username'),
			'uPassword' =>	md5($this->input->post('password')),
		);
		$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

		$count = $datashow->num_rows();

		if($count > 0){

			$row = $datashow->result_object();

			$_SESSION['JobsSessions'] 	= $row;

			if($_SESSION['JobsSessions'][0]->uBan == 1){

				unset($_SESSION['JobsSessions']);

				$_SESSION['error'] = 'Your account has been banned from administrator, please contact administrator to reactivate your account!';

				header ( "Location:" . $this->config->base_url ()."login");

			}else {


				///// two factor



				$two_fact = $this->front_model->get_query_simple('*','dev_web_two_factor',array('id'=>1))->result_object()[0];

				if($two_fact->required==1 && $_SESSION['JobsSessions'][0]->uActType!=1){

					if($two_fact->after_type==1)
					{
						if($_SESSION['JobsSessions'][0]->login_count>=$two_fact->after_qty || $two_fact->after_qty==1){

							$_SESSION['unverified_otp']=1;


							$this->send_otp($_SESSION['JobsSessions'][0]->uID, /* settings:*/$two_fact);


							redirect(base_url().'verify-otp');
							exit;
						}
					}
					else if($two_fact->after_type==2)
					{


						$_SESSION['unverified_otp']=1;


						$diff = strtotime("+".$two_fact->after_qty." days");


						$last_login = strtotime($_SESSION['JobsSessions'][0]->uLoginLast);


						$now = strtotime(date("Y-m-d H:i:s"));

						if(($last_login+$diff)<$now){

							$this->send_otp($_SESSION['JobsSessions'][0]->uID, /* settings:*/$two_fact);						

							redirect(base_url().'verify-otp');
							
							exit;

						}
					}

				}






			$data = array(
				'uIP' 		   => $_SERVER['REMOTE_ADDR'],
				'uLoginLast' 	=> date("Y-m-d H:i:s"),
				'login_count' => $_SESSION['JobsSessions'][0]->login_count+1
			);
			$condition = array('uID' => $_SESSION['JobsSessions'][0]->uID);
			$this->front_model->update_query('dev_web_user',$data,$condition);
				header ( "Location:" . $this->config->base_url ().'dashboard');
			}
		}
		else
		{
			$_SESSION['error'] = 'Invalid login credentials!';
			header ( "Location:" . $this->config->base_url ());
		}
	}
	public function send_otp($uid,$settings)
	{


		require APPPATH.'../twilio-php-master/Twilio/autoload.php';
		// Use the REST API Client to make requests to the Twilio REST API
			
			// Your Account SID and Auth Token from twilio.com/console
			$sid =$settings->sid;
			$token = $settings->skey;
			$client = new Client($sid, $token);


			$user = $this->front_model->get_query_simple('*','dev_web_user',array('uID'=>$uid))->result_object()[0];


			$code = $this->generateSecurityCode();
			$_SESSION['two_fact']=$code;


			$to_phone = preg_replace("/[^0-9]/", "",$user->uPhone);

			if (strpos($to_phone, '+') == false) 
				$to_phone = '+'.$to_phone;

			// $to_phone = str_replace(' ', array('',''), $to_phone);


			// echo $to_phone;exit;
			try{

			// Use the client to do fun stuff like send text messages!
			$response = $client->messages->create(
				// the number you'd like to send the message to
				$to_phone,
				array(
					// A Twilio phone number you purchased at twilio.com/console
					'from' => $settings->from_number,
					// the body of the text message you'd like to send

					'body' => 'Your '.TITLEWEB.' authorization code is: '.$code
				)
			);

		}



			catch(Exception $e){	

				unset($_SESSION['JobsSessions']);
				unset($_SESSION['unverified_otp']);


				$_SESSION['error']="Error! Error code: ".$e->getCode()." Error: ".$e->getMessage().".<br>Please contact with administration if you're receiving thsi error continuously";;

				 

				redirect(base_url());

			}

	}

	public function resend_otp()
	{

		$two_fact = $this->front_model->get_query_simple('*','dev_web_two_factor',array('id'=>1))->result_object()[0];

		$this->send_otp($_SESSION['JobsSessions'][0]->uID, /* settings:*/$two_fact);						

		$this->load->view('frontend/send_two_fact',$this->data);
	}

	public function submit_otp()
	{

		if(isset($_POST['otp']))
		{
			if($this->input->post('otp')==$_SESSION['two_fact'])
			{

				$_SESSION['unverified_otp']=0;

					$data = array(
					'uIP' 		   => $_SERVER['REMOTE_ADDR'],
					'uLoginLast' 	=> date("Y-m-d H:i:s"),
					'login_count' => 0
				);
				$condition = array('uID' => $_SESSION['JobsSessions'][0]->uID);
				$this->front_model->update_query('dev_web_user',$data,$condition);
					header ( "Location:" . $this->config->base_url ().'dashboard');
				
			}
			else
			{
				$_SESSION['error']="Invalid OTP.";
				redirect(base_url().'verify-otp');
			}

		}
		else
		{
			redirect(base_url().'verify-otp');
		}
	}
	public function verify_top()
	{

		$_SESSION['unverified_otp']=1;

		$this->load->view('frontend/send_two_fact',$this->data);
	}

	// ACCOUNT LOGIN RECRUITER

	public function do_login_recruiter()

	{

		$arr = array(

			'uEmail'	=>	$this->input->post('emailadd'),

			'uPassword' =>	md5($this->input->post('passlogin')),

			'uReCode'   =>	$this->input->post('secruityCode'),

		);

		$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

		$count = $datashow->num_rows();

		if($count > 0){

			unset($_SESSION['JobsSessions']);

			$row = $datashow->result_object();

			$_SESSION['JobsSessions'] = $row;

			$data = array(

				'uIP' 		   => $_SERVER['REMOTE_ADDR'],

				'uLoginLast' 	=> date("Y-m-d h:i:s"),

			);

			$condition = array('uID' => $_SESSION['JobsSessions'][0]->uID);

			

			$this->front_model->update_query('dev_web_user',$data,$condition);

			if($this->input->post('returl') != ""){

				header ( "Location:" . $this->config->base_url ().$this->input->post('returl'));

			}

			else {

				header ( "Location:" . $this->config->base_url ().'dashboard');

			}

		}

		else

		{

			$_SESSION['msglogin'] = 'Invalid login credentials or seccurity code!';

			header ( "Location:" . $this->config->base_url ().'recruiter-login');

		}

	

	}

	// Fcaeboook Login

	public function do_fb_login()

	{

		$action = $_REQUEST["page"];

		switch($action)

			{

				case "fblogin":

				include 'fblogin/facebook.php';

				$appid 		= "1891590237740531";

				$appsecret  = "ce0ba66c9e2406244b9c957ee963e148";

				$facebook   = new Facebook(array(

					'appId' => $appid,

					'secret' => $appsecret,

					'cookie' => TRUE,

				));

				$fbuser = $facebook->getUser();

				if ($fbuser) {

					$access_token = $facebook->getAccessToken();
   				 	$facebook->setAccessToken($access_token);
					try {
						$user_profile =  $facebook->api('/'. $fbuser."?fields=email,first_name,last_name",'GET');
					}
					catch (Exception $e) {

						echo $e->getMessage();

						exit();

					}

					$arr = array(

						'uEmail'	=>	$user_profile["email"],

					);

					$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

					echo $rcoun = $datashow->num_rows();

					if($rcoun > 0)

					{

						$arr = array(

							'uEmail'	=>	$user_profile["email"],

						);

						$datid 	= $this->front_model->get_query_simple('*','dev_web_user',$arr);

						$row 	= $datid->result_object();

						$arru = array(

							'uID'	=>	$row[0]->uID,

						);

						$datdddd = $this->front_model->get_query_simple('*','dev_web_user',$arru);

						$dat = $datdddd->result_object();

						$data = array(

						'uIP' 		   => $_SERVER['REMOTE_ADDR'],

						'uLoginLast' 	=> date("Y-m-d h:i:s"),

						);

						$this->front_model->update_query('dev_web_user',$data,$arru);

					}

					else

					{

						$exp = explode("@",$user_profile["email"]);

						$rendomcode = $this->generateRandomString();

						$data = array(

									'uFname' 		=> $user_profile["first_name"],

									'uLname' 		=> $user_profile["last_name"],

									'uEmail' 		=> $user_profile["email"],

									'uUsername' 	=> $exp[0],

									'uPassword' 	=> md5($rendomcode),

									'uImage' 		=> "https://graph.facebook.com/".$fbuser."/picture?type=large",

									'uActType' 		=> 1,

									'uStatus' 		=> 1,

									'joinDate' 		=> date('Y-m-d h:i:s'),

									'uCode' 		=> $rendomcode,

									'ufb'	 		=> 1,

									'uIP' 		   => $_SERVER['REMOTE_ADDR'],

									'uLoginLast' 	=> date("Y-m-d h:i:s"),

									//'ulogin' 		=> 1,

								);

							$uid = $this->front_model->add_user_new_fb($data);

							

							$arru = array(

								'uID'	=>	$uid,

							);

							$datddd = $this->front_model->get_query_simple('*','dev_web_user',$arru);

							$dat = $datddd->result_object();

					}

					//die;

					// Do login

					$_SESSION['JobsSessions'] = $dat;

					if(isset($_SESSION['saveid'])){

						$this->save_job_session();

						exit();

					}

					else if(isset($_SESSION['applyidsession'])){

						header ( "Location:" . $_SERVER['HTTP_REFERER']."?apply=yes");

					} else if(isset($_SESSION['redirectidsession'])){

							$arrjob = array('jID' => $_SESSION['redirectidsession']);

							$datashowjob = $this->front_model->get_query_simple('*','dev_web_jobs',$arrjob);

							$rowjob = $datashowjob->result_object();

							unset($_SESSION['redirectidsession']);

							header ( "Location:" . $this->config->base_url ()."job/".$rowjob[0]->jURL);

						} else {

						header ( "Location:" . $this->config->base_url ()."dashboard");

					}

				}

				break;

			}

	}

	// TWITTER LOGIN

	public function do_twitter_login_validate()

	{

		require_once('twitteroauth/twitteroauth.php');

		$CONSUMER_KEY='V2wV7YIHzuntauGmr82yKKpk7';

		$CONSUMER_SECRET='RSWKqf4HWpQ78LtUszaa4mJo2jChRGArzIWhkxYq5QH2i3tbht';

		$OAUTH_CALLBACK= $this->config->base_url().'oathtwitter/login';

		if(isset($_GET['oauth_token']))

		{

			$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $_SESSION['request_token'], $_SESSION['request_token_secret']);

			$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

			if($access_token)

			{

					$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

					$params =array();

					$params['include_entities']='false';

					$content = $connection->get('account/verify_credentials',$params);		

					if($content && isset($content->screen_name) && isset($content->name))

					{

						$ex = explode(" ",$content->name);

						

							$arr = array(

								'uEmail'	=>	$content->id,

							);

							$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

							echo $rcoun = $datashow->num_rows();

							if($rcoun > 0)

							{

								$arr = array(

									'uEmail'	=>	$content->id,

								);

								$datid 	= $this->front_model->get_query_simple('*','dev_web_user',$arr);

								$row 	= $datid->result_object();

								$arru = array(

									'uID'	=>	$row[0]->uID,

								);

								$datdddd = $this->front_model->get_query_simple('*','dev_web_user',$arru);

								$dat = $datdddd->result_object();

	

								$data = array(

								'uIP' 		   => $_SERVER['REMOTE_ADDR'],

								'uLoginLast' 	=> date("Y-m-d h:i:s"),

								);

								$this->front_model->update_query('dev_web_user',$data,$arru);

							}

							else

							{

								$rendomcode = $this->generateRandomString();

								$data = array(

											'uFname' 		=> $ex[0],

											'uLname' 		=> $ex[1],

											'uEmail' 		=> $content->id,

											'uUsername' 	=> $content->id,

											'uPassword' 	=> md5($rendomcode),

											'uImage' 		=> $content->profile_image_url,

											'uActType' 		=> 1,

											'uStatus' 		=> 1,

											'joinDate' 		=> date('Y-m-d h:i:s'),

											'uCode' 		=> $rendomcode,

											'ufb'	 		=> 1,

											'uIP' 		   => $_SERVER['REMOTE_ADDR'],

											'uLoginLast' 	=> date("Y-m-d h:i:s"),

											//'ulogin' 		=> 1,

										);

										

									$uid = $this->front_model->add_user_new_fb($data);

									$arru = array(

										'uID'	=>	$uid,

									);

									$datddd = $this->front_model->get_query_simple('*','dev_web_user',$arru);

									$dat = $datddd->result_object();

							}

							$_SESSION['JobsSessions'] = $dat;

							if(isset($_SESSION['saveid'])){

								$this->save_job_session();

								exit();

							} 

							

							else if(isset($_SESSION['applyidsession'])){

								header ( "Location:" . $_SERVER['HTTP_REFERER']."?apply=yes");

							}else if(isset($_SESSION['redirectidsession'])){

			$arrjob = array('jID' => $_SESSION['redirectidsession']);

			$datashowjob = $this->front_model->get_query_simple('*','dev_web_jobs',$arrjob);

			$rowjob = $datashowjob->result_object();

			unset($_SESSION['redirectidsession']);

			header ( "Location:" . $this->config->base_url ()."job/".$rowjob[0]->jURL);

		} else {

							header ( "Location:" . $this->config->base_url ()."dashboard");

							}

					}

					else

					{

						$_SESSION['msglogin'] = 'Error while login, please try again!';

						header ( "Location:" . $this->config->base_url()."login");

					}

			}		

			else

			{

				$_SESSION['msglogin'] = 'Error while login, please try again!';

				header ( "Location:" . $this->config->base_url()."login");

			}

		}

		else //Error. redirect to Login Page.

		{

			$_SESSION['msglogin'] = 'Error while login, please try again!';

			header ( "Location:" . $this->config->base_url()."login");

		}

	}

	public function do_twitter_login()

	{

		require_once('twitteroauth/twitteroauth.php');

		$CONSUMER_KEY='V2wV7YIHzuntauGmr82yKKpk7';

		$CONSUMER_SECRET=	'RSWKqf4HWpQ78LtUszaa4mJo2jChRGArzIWhkxYq5QH2i3tbht';

		$OAUTH_CALLBACK=	$this->config->base_url().'oathtwitter/login';

		if(isset($_SESSION['name']) && isset($_SESSION['twitter_id'])) //check whether user already logged in with twitter

		{

			$uid = $this->front_model->check_user_login_details_twitter($_SESSION['twitter_id']);

			if($uid == "1"){

				header ( "Location:" . $this->config->base_url ());	

			}

			else

			{

				//session_destroy();

				$_SESSION['msglogin'] = 'Please authenticate with twitter again!';

				header ( "Location:" . $this->config->base_url());

			}

			

		}

		else // Not logged in

		{

			$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET);

			$request_token = $connection->getRequestToken($OAUTH_CALLBACK); //get Request Token

					if(	$request_token)

					{

						$token = $request_token['oauth_token'];

						$_SESSION['request_token'] = $token ;

						$_SESSION['request_token_secret'] = $request_token['oauth_token_secret'];

						

						switch ($connection->http_code) 

						{

							case 200:

								$url = $connection->getAuthorizeURL($token);

								//redirect to Twitter .

								header('Location: ' . $url); 

								break;

							default:

								$_SESSION['msglogin'] = 'Coonection with twitter Failed, Please try later!';

								header ( "Location:" . $this->config->base_url()."login");

								break;

						}

				

					}

					else //error receiving request token

					{

						$_SESSION['msglogin'] = 'Error Receiving Request Toke, Please try later!';

						header ( "Location:" . $this->config->base_url()."login");

					}

			

		

		}

	}

	

	// GOOGLE PLUS LOGIN

	public function do_google_login_validate()

	{

			require_once('libraries/Google/autoload.php');

			$client_id = '980689377071-1cudibmmbakn23938evatv4j6eg78d0c.apps.googleusercontent.com'; 

			$client_secret = 'cTLKPf936p0gj7BIEyXA3MDL';

			$redirect_uri = $this->config->base_url().'oathgoogle/login';

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

			if (isset($_GET['error'])) {

				header("Location:".$this->config->base_url());

			  exit;

			}

			

			/***********************************************

			  If we have an access token, we can make

			  requests, else we generate an authentication URL.

			 ***********************************************/

			if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {

			  $client->setAccessToken($_SESSION['access_token']);

			} else {

			  $authUrl = $client->createAuthUrl();

			}

			$user = $service->userinfo->get();	



			$arr = array(

				'uEmail'	=>	$user->email,

			);

			$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

			$rcoun = $datashow->num_rows();

			if($rcoun > 0)

			{

				$arr = array(

					'uEmail'	=>	$user->email,

				);

				$datid 	= $this->front_model->get_query_simple('*','dev_web_user',$arr);

				$row 	= $datid->result_object();

				$arru = array(

					'uID'	=>	$row[0]->uID,

				);

				$datddd = $this->front_model->get_query_simple('*','dev_web_user',$arru);

				$dat = $datddd->result_object();

					$data = array(

					'uIP' 		   => $_SERVER['REMOTE_ADDR'],

					'uLoginLast' 	=> date("Y-m-d h:i:s"),

					);

					$this->front_model->update_query('dev_web_user',$data,$arru);

				

			}

			

			else

			{

				$exp = explode("@",$user->email);

				$rendomcode = $this->generateRandomString();

				$data = array(

							'uFname' 		=> $user->givenName,

							'uLname' 		=> $user->familyName,

							'uEmail' 		=> $user->email,

							'uUsername' 	=> $exp[0],

							'uPassword' 	=> md5($rendomcode),

							'uImage' 		=> $user->picture,

							'uActType' 		=> 1,

							'uStatus' 		=> 1,

							'joinDate' 		=> date('Y-m-d h:i:s'),

							'uCode' 		=> $rendomcode,

							'ufb'	 		=> 1,

							'uIP' 		   => $_SERVER['REMOTE_ADDR'],

							'uLoginLast' 	=> date("Y-m-d h:i:s"),

							//'ulogin' 		=> 1,

						);

					$uid = $this->front_model->add_user_new_fb($data);

					$arru = array(

						'uID'	=>	$uid,

					);

					$datdd = $this->front_model->get_query_simple('*','dev_web_user',$arru);

					$dat = $datdd->result_object();

			}

			$_SESSION['JobsSessions'] = $dat;

			if(isset($_SESSION['saveid'])){

				$this->save_job_session();

				exit();

			}

			

			else if(isset($_SESSION['applyidsession'])){

				header ( "Location:" . $_SERVER['HTTP_REFERER']."?apply=yes");

			}

			else if(isset($_SESSION['redirectidsession'])){

			$arrjob = array('jID' => $_SESSION['redirectidsession']);

			$datashowjob = $this->front_model->get_query_simple('*','dev_web_jobs',$arrjob);

			$rowjob = $datashowjob->result_object();

			unset($_SESSION['redirectidsession']);

			header ( "Location:" . $this->config->base_url ()."job/".$rowjob[0]->jURL);

				} else {

			header("Location:".$this->config->base_url()."dashboard");

			}

	}

	

	// LINKEDIN LOGIN

	public function do_linkedin_login_validate()

	{

		//error_reporting(-1);

		// TWITTER LOGIN

			$config['callback_url']     =   base_url().'oathlinkedin/login'; //Your callback URL

			$config['Client_ID']        =   '81xlcdfwsbjoky'; // Your LinkedIn Application Client ID

			$config['Client_Secret']    =   'RQEmaYOlngQ0vRlY'; // Your LinkedIn Application Client Secret

		if(isset($_GET['code']))

		{

			$url    = 'https://www.linkedin.com/uas/oauth2/accessToken';

			$param  = 'grant_type=authorization_code&code='.$_GET['code'].'&redirect_uri='.$config['callback_url'].'&client_id='.$config['Client_ID'].'&client_secret='.$config['Client_Secret'];

			$return = (json_decode($this->post_curl($url,$param),true));

			if($return['error'])

			{

				$_SESSION['msglogin'] = 'Some error occured while connecting with linkedin, Please Try again!';

				header ( "Location:" . $this->config->base_url()."login");

			}

			else   

			{

				$url    = 'https://api.linkedin.com/v1/people/~:(id,firstName,lastName,pictureUrls::(original),headline,publicProfileUrl,location,industry,positions,email-address)?format=json&oauth2_access_token='.$return['access_token'];

				$User   = json_decode($this->post_curl($url));

				//echo "<pre>";

				//print_r($User);

				//die;

				$id             = isset($User->id) ? $User->id : '';

				$firstName      = isset($User->firstName) ? $User->firstName : '';

				$lastName       = isset($User->lastName) ? $User->lastName : '';

				$emailAddress   = isset($User->emailAddress) ? $User->emailAddress : '';

				$headline       = isset($User->headline) ? $User->headline : '';

				$pictureUrls    = isset($User->pictureUrls->values[0]) ? $User->pictureUrls->values[0] : '';

				$location       = isset($User->location->name) ? $User->location->name : '';

				$positions      = isset($User->positions->values[0]->company->name) ? $User->positions->values[0]->company->name : '';

				$positionstitle = isset($User->positions->values[0]->title) ? $User->positions->values[0]->title : '';

				$publicProfileUrl = isset($User->publicProfileUrl) ? $User->publicProfileUrl : '';

				// CHECK USER RECORDS			   

				$arr = array(

				'uEmail'	=>	$emailAddress,

				);

				$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

				$rcoun = $datashow->num_rows();

				if($rcoun > 0)

				{

					$arr = array(

						'uEmail'	=>	$emailAddress,

					);

					$datid 	= $this->front_model->get_query_simple('*','dev_web_user',$arr);

					$row 	= $datid->result_object();

					$arru = array(

						'uID'	=>	$row[0]->uID,

					);

					$datddd = $this->front_model->get_query_simple('*','dev_web_user',$arru);

					$dat = $datddd->result_object();

						$data = array(

						'uIP' 		   => $_SERVER['REMOTE_ADDR'],

						'uLoginLast' 	=> date("Y-m-d h:i:s"),

						);

						$this->front_model->update_query('dev_web_user',$data,$arru);

				}

				else

				{

					$exp = explode("@",$emailAddress);

					$rendomcode = $this->generateRandomString();

					$data = array(

							'uFname' 		 => $firstName,

							'uLname' 		 => $lastName,

							'uEmail' 		 => $emailAddress,

							'uUsername' 	  => $exp[0],

							'uPassword' 	  => md5($rendomcode),

							'uImage' 		 => $pictureUrls,

							'uActType' 	   => 1,

							'uStatus' 		=> 1,

							'joinDate' 	   => date('Y-m-d h:i:s'),

							'uCode' 		  => $rendomcode,

							'ufb'	 		=> 1,

							'uIP' 		    => $_SERVER['REMOTE_ADDR'],

							'uLoginLast' 	=> date("Y-m-d h:i:s"),

						);

					$uid = $this->front_model->add_user_new_fb($data);

					$arru = array(

						'uID'	=>	$uid,

					);

					$datdd = $this->front_model->get_query_simple('*','dev_web_user',$arru);

					$dat = $datdd->result_object();

				}

			$_SESSION['JobsSessions'] = $dat;

			if(isset($_SESSION['saveid'])){

				$this->save_job_session();

				exit();

			}

			else if(isset($_SESSION['applyidsession'])){

				header ( "Location:" . $_SERVER['HTTP_REFERER']."?apply=yes");

			}else {

				header("Location:".$this->config->base_url()."dashboard");

			}

			}

		}

		elseif(isset($_GET['error']))

		{

			$_SESSION['msglogin'] = 'Some error occured while connecting with linkedin, Please Try again!';

			header ( "Location:" . $this->config->base_url()."login");

		}

	}

	// CURL FUNCTION 

	public function post_curl($url,$param="")

	{

		

		$ch = curl_init();

		curl_setopt($ch,CURLOPT_URL,$url);

		if($param!="")

			curl_setopt($ch,CURLOPT_POSTFIELDS,$param);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		$result = curl_exec($ch);

		curl_close($ch);

		return $result;

	}
	
	public function notification_page()

	{
		if(isset($_SESSION['JobsSessions'])){
			
			$this->load->view('frontend/notification_page',$this->data);
		}
		else {
			header ( "Location:" . $this->config->base_url ()."dashboard");
		}
	}

	// SIGNUP 
	
	public function signup_step()

	{

		if(!isset($_SESSION['JobsSessions'])){

			$arr = array();

			$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);

			$this->data['countries'] 	= $config->result_object();

			$this->load->view('frontend/signup_step',$this->data);

		}

		else {

			header ( "Location:" . $this->config->base_url ()."dashboard");

		}

	}
	
	public function signup_page()

	{

		if(!isset($_SESSION['JobsSessions'])){

			$arr = array();

			$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);

			$this->data['countries'] 	= $config->result_object();

			$this->load->view('frontend/signup',$this->data);

		}

		else {

			header ( "Location:" . $this->config->base_url ()."dashboard");

		}

	}
	
	public function signup_page_marketing()
	{
		if(!isset($_SESSION['JobsSessions'])){
			$arr = array();
			$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);
			$this->data['countries'] 	= $config->result_object();
			$this->load->view('frontend/signup_marketing',$this->data);
		}
		else {
			header ( "Location:" . $this->config->base_url ()."dashboard");
		}
	}

	// FORGOT PASSWORD 

	public function forgot_password()
	{
		if(!isset($_SESSION['JobsSessions'])){
			$this->load->view('frontend/forgot_password',$this->data);
		}
		else {
			header ( "Location:" . $this->config->base_url ()."dashboard");
		}
	}

	// DO SIGNUP SUBMIT

	public function do_register()

	{
		$datashow = $this->front_model->check_email_user($this->input->post('email'));
		if($datashow > 0)
		{	
			$_SESSION['wrongsignup'] = $_POST;
		 	$_SESSION['msglogin'] = "Email address already exist!";
			header ( "Location:" . $this->config->base_url ()."signup");
		}
		else
		{
			$rendomcode = $this->generateRandomString();
			$data = array(
						'uFname' 	  	=> $this->input->post('first_name'),
						'uLname' 	   	=> $this->input->post('last_name'),
						'uEmail' 	   	=> $this->input->post('email'),
						'uUsername' 	=> $this->input->post('username'),
						'uPassword' 	=> md5($this->input->post('password')),
						'uDOB' 	  		=> $this->input->post('birth_date'),
						'uCountry' 	 	=> $this->input->post('country'),
						'uCity' 	 	=> $this->input->post('city'),
						'uAddress' 	 	=> $this->input->post('address'),
						//'uZip' 	 		=> $this->input->post('postal_code'),
						'uActType' 	 	=> $this->input->post('type'),
						'uStatus' 	  	=> 1,
						'joinDate' 	 	=> date('Y-m-d h:i:s'),
						'uIP' 		  	=> $_SERVER['REMOTE_ADDR'],
						'uCode' 		=> $rendomcode,
						'uSectors' 	 	=> $sectoruser,
						'uverifyemail' 	=> 0,
					);

				if(!$this->verify_captcha())
				{

					$_SESSION['wrongsignup'] = $_POST;
				 	$_SESSION['msglogin'] = "Captcha Error!";
					header ( "Location:" . $this->config->base_url ()."signup");
					exit;
				}

				$uID = $this->front_model->add_query('dev_web_user',$data);
				// SEND EMAIL CONFIRMATION
				$edata = $this->front_model->get_emails_data('user-signup-confirmation');
				$this->load->library('email');
				$this->email->from($edata[0]->eEmail, TITLEWEB);
				$this->email->to($this->input->post('email')); 
				$replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]");
				$replacewith = array(WEBURL, $rendomcode, $this->input->post('first_name')." ".$this->input->post('last_name'),TITLEWEB,$this->input->post('email'),$this->input->post('password'));
				$str = str_replace($replace,$replacewith,$edata[0]->eContent);
				$message = $str;
				$this->email->subject($edata[0]->eName);
				$this->email->message($message);
				$this->email->set_mailtype("html");
				$send = $this->email->send();
				unset($_SESSION['wrongsignup']);
		
				$_SESSION['userID'] = $uID;
				$_SESSION['thankyou'] = "Your account has been created successfully. Please visit your email to verify your email address.";
				header ( "Location:".$this->config->base_url());
		}

	}
	
	public function do_register_admin()

	{
		$datashow = $this->front_model->check_email_user($this->input->post('email'));
		if($datashow > 0)
		{	
			$_SESSION['wrongsignup'] = $_POST;
		 	$_SESSION['msglogin'] = "Email address already exist!";
			header ( "Location:" . $this->config->base_url ()."admin/add/user");
		}
		else
		{
			$rendomcode = $this->generateRandomString();
			$data = array(
						'uFname' 	  	=> $this->input->post('first_name'),
						'uLname' 	   	=> $this->input->post('last_name'),
						'uEmail' 	   	=> $this->input->post('email'),
						'uUsername' 	=> $this->input->post('username'),
						'uPassword' 	=> md5($rendomcode),
						'uDOB' 	  		=> $this->input->post('birth_date'),
						'uCountry' 	 	=> $this->input->post('country'),
						'uCity' 	 	=> $this->input->post('city'),
						'uAddress' 	 	=> $this->input->post('address'),
						//'uZip' 	 		=> $this->input->post('postal_code'),
						'uActType' 	 	=> $this->input->post('type'),
						'uStatus' 	  	=> 1,
						'joinDate' 	 	=> date('Y-m-d h:i:s'),
						'uIP' 		  	=> $_SERVER['REMOTE_ADDR'],
						'uCode' 		=> $rendomcode,
						//'uSectors' 	 	=> $sectoruser,
						'uverifyemail' 	=> 0,
					);
				
				$uID = $this->front_model->add_query('dev_web_user',$data);
				
				if($this->input->post('type') == "2"){
					$usetype = "Token Buyer";	
				}
				else if($this->input->post('type') == "3"){
					$usetype = "Marketing Affiliate";	
				} else {
					$usetype = "Airdrop/Bounty";
				}
				
				// SEND EMAIL CONFIRMATION
				$edata = $this->front_model->get_emails_data('admin-signup');
				$this->load->library('email');
				$this->email->from($edata[0]->eEmail, TITLEWEB);
				$this->email->to($this->input->post('email')); 
				$replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]","[USERTYPE]");
				$replacewith = array(WEBURL, $rendomcode, $this->input->post('first_name')." ".$this->input->post('last_name'),TITLEWEB,$this->input->post('email'),$rendomcode,$usetype);
				$str = str_replace($replace,$replacewith,$edata[0]->eContent);
				$message = $str;
				$this->email->subject($edata[0]->eName);
				$this->email->message($message);
				$this->email->set_mailtype("html");
				$send = $this->email->send();
				unset($_SESSION['wrongsignup']);
				
				$_SESSION['thankyou'] = "Account has been created successfully & Email has been sent with login details on provided email address.";
				header ( "Location:".$this->config->base_url().'admin/user/reports');
		}

	}
	
	public function add_token_new_price()

	{
			$arr = array();
			$config 	= $this->front_model->get_query_simple('*','dev_web_token_pricing',$arr);
			$status 	= $config->num_rows();
			if($status == "0"){
				$status = "1";
			} else {
				$status = "0";
			}
			$data = array(
						'ico_camp'=>$this->input->post('ico_camp'),
						'tokenPrice' 	  	=> $this->input->post('price_token'),
						'tokenBonus' 	   	=> $this->input->post('bonus'),
						'tokenDateStarts' 	   	=> $this->input->post('start_date'),
						'tokenDateEnds' 	=> $this->input->post('end_date'),
						'tokenCap' 	  		=> $this->input->post('address'),
						'status' 	 		=> $status,
						'addedDate' 	 	=> date('Y-m-d h:i:s'),
					);
				
				$uID = $this->front_model->add_query('dev_web_token_pricing',$data);
				
				$_SESSION['thankyou'] = "New Token Price Added successfully";
				header ( "Location:".$this->config->base_url().'admin/token/pricing');

	}
	
	
	// DO SIGNUP SUBMIT

	public function do_register_marketing()
	{
		$datashow = $this->front_model->check_email_user($this->input->post('email'));
		if($datashow > 0)
		{	
			$_SESSION['wrongsignup'] = $_POST;
		 	$_SESSION['msglogin'] = "Email address already exist!";
			header ( "Location:" . $this->config->base_url ()."signup");
		}
		else
		{
			$rendomcode = $this->generateRandomString();
			$data = array(
						'uFname' 	  	=> $this->input->post('name'),
						'uCompany' 	   	=> $this->input->post('name'),
						'uEmail' 	   	=> $this->input->post('email'),
						'uUsername' 	=> $this->input->post('username'),
						'uPassword' 	=> md5($this->input->post('password')),
						//'uDOB' 	  		=> $this->input->post('birth_date'),
						'uManager' 	  	=> $this->input->post('manager'),
						'uPhone' 	  	=> $this->input->post('phone'),
						'uCountry' 	 	=> $this->input->post('country'),
						'uCity' 	 	=> $this->input->post('city'),
						'uAddress' 	 	=> $this->input->post('address'),
						'uZip' 	 		=> $this->input->post('postal_code'),
						'id_company' 	=> $this->input->post('id_number'),
						'tax_number' 	=> $this->input->post('tax_number'),
						'uActType' 	 	=> 3,
						'uStatus' 	  	=> 1,
						'joinDate' 	 	=> date('Y-m-d h:i:s'),
						'uIP' 		  	=> $_SERVER['REMOTE_ADDR'],
						'uCode' 		=> $rendomcode,
						'uSectors' 	 	=> $sectoruser,
						'uverifyemail' 	=> 0,
					);

			if(!$this->verify_captcha())
				{
					
					$_SESSION['wrongsignup'] = $_POST;
				 	$_SESSION['msglogin'] = "Captcha Error!";
					redirect($_SERVER['HTTP_REFERER']);
					exit;
				}

				$uID = $this->front_model->add_query('dev_web_user',$data);
				// SEND EMAIL CONFIRMATION
				$edata = $this->front_model->get_emails_data('user-signup-confirmation');
				$this->load->library('email');
				$this->email->from($edata[0]->eEmail, TITLEWEB);
				$this->email->to($this->input->post('email')); 
				$replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]");
				$replacewith = array(WEBURL, $rendomcode, $this->input->post('name'),TITLEWEB,$this->input->post('email'),$this->input->post('password'));
				$str = str_replace($replace,$replacewith,$edata[0]->eContent);
				$message = $str;
				$this->email->subject($edata[0]->eName);
				$this->email->message($message);
				$this->email->set_mailtype("html");
				$send = $this->email->send();
				unset($_SESSION['wrongsignup']);
		
				$_SESSION['userID'] = $uID;
				$_SESSION['thankyou'] = "Your account has been created successfully. Please visit your email to verify your email address.";
				header ( "Location:".$this->config->base_url());
		}

	}

	// RSENT VERIFICATION EMAIL

	public function resend_verified_email()

	{

		if(isset($_SESSION['JobsSessions'])){

		$arr = array('uID' => UID);

		$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

		$row = $datashow->result_object();

		// SEND EMAIL CONFIRMATION

		$edata = $this->front_model->get_emails_data('user-signup-confirmation-resend');

		$this->load->library('email');

		$this->email->from($edata[0]->eEmail, TITLEWEB);

		$this->email->to(EMAIL);

		$replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]");

		$replacewith = array(WEBURL, $row[0]->uCode, $row[0]->uFname." ".$row[0]->uLname,TITLEWEB);

		$str = str_replace($replace,$replacewith,$edata[0]->eContent);

		$message = $str;

		$this->email->subject($edata[0]->eName);

		$this->email->message($message);

		$this->email->set_mailtype("html");

		$send = $this->email->send();

		//die;

		header ( "Location:" . $_SERVER['HTTP_REFERER']);

		//header ( "Location:".$this->config->base_url().'dashboard');

		} else {

			header ( "Location:".$this->config->base_url().'login');

		}

	}

	// ACCOUNT VERIFICATION
	public function admin_tranaction_actions(){
		
		$arr = array('tID' => $this->uri->segment(6));
		$datashow = $this->front_model->get_query_simple('*','dev_web_transactions',$arr);
		$row = $datashow->result_object();
		
		if($row[0]->status == "1"){$statusold = "Pending";}
		else if($row[0]->status == "2"){$statusold = "Confirmed";}
		else if($row[0]->status == "3"){$statusold = "Cancelled";}
		else if($row[0]->status == "4"){$statusold = "Refunded";}
		
		$data = array('status' => $this->uri->segment(5));
		$condition = array('tID' => $this->uri->segment(6));
		$this->front_model->update_query('dev_web_transactions',$data,$condition);
		
		if($this->uri->segment(5) == "1"){$statusnew = "Pending";}
		else if($this->uri->segment(5) == "2"){$statusnew = "Confirmed";}
		else if($this->uri->segment(5) == "3"){$statusnew = "Cancelled";}
		else if($this->uri->segment(5) == "4"){$statusnew = "Refunded";}
		
		$this->notification_users('Transaction Status Changed','Transaction status changed from <b>'.$statusold.'</b> to <b> '.$statusnew.'</b>');
		
		$_SESSION['thankyou'] = "Status information updated successfully!";
		header ( "Location:" . $_SERVER['HTTP_REFERER']);
	}
	
	// ACCOUNT VERIFICATION
	public function admin_user_actions(){
		
		
		$data = array('uStatus' => $this->uri->segment(5));
		$condition = array('uID' => $this->uri->segment(6));
		$this->front_model->update_query('dev_web_user',$data,$condition);
		
		$_SESSION['thankyou'] = "Status information updated successfully!";
		header ( "Location:" . $_SERVER['HTTP_REFERER']);
	}
	public function confirm_account(){

			$arr = array('uCode' => $this->uri->segment(4));

			$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

			$row = $datashow->result_object();

			

			// UPDATE USER TO VERIFY

			$data = array('uverifyemail' => 1,);

			$condition = array('uID' => $row[0]->uID);

			$this->front_model->update_query('dev_web_user',$data,$condition);

			// SEND EMAIL CONFIRMATION

			$edata = $this->front_model->get_emails_data('accountverified-email');

			$this->load->library('email');

			$this->email->from($edata[0]->eEmail, TITLEWEB);

			$this->email->to($this->input->post('emailadd')); 

			$replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]");

			$replacewith = array(WEBURL, $rendomcode, $row[0]->uFname,TITLEWEB,$this->input->post('emailadd'),$this->input->post('passlogin'));

			$str = str_replace($replace,$replacewith,$edata[0]->eContent);

			$message = $str;

			$this->email->subject($edata[0]->eName);

			$this->email->message($message);

			$this->email->set_mailtype("html");

			$send = $this->email->send();

			header ( "Location:".$this->config->base_url().'thank-you');

	}

	// SKIP SIGNUP

	public function singup_skip(){



		$arr = array('uID' => $_SESSION['userID']);

		$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

		$row = $datashow->result_object();

		$_SESSION['JobsSessions'] 	= $row;

		unset($_SESSION['userID']);

		if(isset($_SESSION['applyidsession'])){

			$arrjob = array('jID' => $_SESSION['applyidsession']);

			$datashowjob = $this->front_model->get_query_simple('*','dev_web_jobs',$arrjob);

			$rowjob = $datashowjob->result_object();

			unset($_SESSION['applyidsession']);

			header ( "Location:" . $this->config->base_url ()."job/".$rowjob[0]->jURL."?apply=yes");

		}else if(isset($_SESSION['redirectidsession'])){

			$arrjob = array('jID' => $_SESSION['redirectidsession']);

			$datashowjob = $this->front_model->get_query_simple('*','dev_web_jobs',$arrjob);

			$rowjob = $datashowjob->result_object();

			unset($_SESSION['redirectidsession']);

			header ( "Location:" . $this->config->base_url ()."job/".$rowjob[0]->jURL);

		} else {

			header ( "Location:" . $this->config->base_url ()."dashboard");

		}

		

	}

	// SIGNUP FINAL

	public function do_register_final()

	{

		

		if($this->input->post('jalert') == "1"){

			//print_r($this->input->post('desiredloc'));

			$ben = count($this->input->post('desiredloc'));

			$bid = $this->input->post('desiredloc');

			if($ben > 0){

			for($i=0;$i<$ben;$i++):

				$bent .= $bid[$i].",";

			endfor;

			$benefit = substr($bent,0,-1);

			}

			else { $benefit= '';}

			

				$data = array(

						'uID' 	  	 	=> $_SESSION['userID'],

						'jobTitle' 	   => str_replace(" ",",",$this->input->post('jobtitle')),

						'jobSkills' 	  => str_replace(" ",",",$this->input->post('skills')),

						'jobLocation' 	=> $benefit,

						'jobNature' 	  => $this->input->post('jobType'),

						'jobStatus' 	  => 1,

						'jobInstant' 	 => 0,

					);

				$this->front_model->add_query('dev_job_alerts',$data);

		}

				if($this->input->post('jCV') == "1"){

					$arr = array('uID' => $_SESSION['userID']);

					$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

					$row = $datashow->result_object();

					$_SESSION['JobsSessions'] 	= $row;

					unset($_SESSION['userID']);

					header ( "Location:".$this->config->base_url()."create-cv");				

				}

				else {

					$arr = array('uID' => $_SESSION['userID']);

					$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

					$row = $datashow->result_object();

					$_SESSION['JobsSessions'] 	= $row;

					unset($_SESSION['userID']);

					

					// EMAIL TO USER

					$edata = $this->front_model->get_emails_data('cv-upload-alert');

					$this->load->library('email');

					$this->email->from($edata[0]->eEmail, TITLEWEB);

					$this->email->to($row[0]->uEmail); 

					$replace = array("[WEBURL]","[CVURL]");

					$replacewith = array(WEBURL,$this->config->base_url()."create-cv");

					$str = str_replace($replace,$replacewith,$edata[0]->eContent);

					$message = $str;

					$this->email->subject($edata[0]->eName);

					$this->email->message($message);

					$this->email->set_mailtype("html");

					$send = $this->email->send();

					if(isset($_SESSION['applyidsession'])){

						$arrjob = array('jID' => $_SESSION['applyidsession']);

						$datashowjob = $this->front_model->get_query_simple('*','dev_web_jobs',$arrjob);

						$rowjob = $datashowjob->result_object();

						unset($_SESSION['applyidsession']);

						header ( "Location:" . $this->config->base_url ()."job/".$rowjob[0]->jURL."?apply=yes");

					} else if(isset($_SESSION['redirectidsession'])){

						$arrjob = array('jID' => $_SESSION['redirectidsession']);

						$datashowjob = $this->front_model->get_query_simple('*','dev_web_jobs',$arrjob);

						$rowjob = $datashowjob->result_object();

						unset($_SESSION['redirectidsession']);

						header ( "Location:" . $this->config->base_url ()."job/".$rowjob[0]->jURL);

					} else {

						header ( "Location:" . $this->config->base_url ()."dashboard");				

					}

				}

	}

	

	// UPLOAD CV

	public function signup_cv_upload(){

		$this->load->view('frontend/create_cv_signup', $this->data);

	}

	// CHECK USERNAME EXIST OR NOT

	public function check_username() {

		$arr = array("uUsername" => $_REQUEST['username']);

		$config = $this->front_model->get_query_simple('*','dev_web_user',$arr);

		$count = $config->num_rows();

		if($count > 0){

			echo 1;

		}

		else {

			echo 0;

		}

	}

	//FORGOT PASSWORD

	public function forgot_password_email()

	{

		$ret = $this->front_model->check_frogot_password($this->input->post('email'));

		if($ret == 0)

		{

			$_SESSION['error'] = 'Email Address not found!';

			header ( "Location:" . $this->config->base_url () . 'forgot-password');

		}

		else

		{

			$rendomcode = $this->generateRandomString();

			$this->front_model->update_password_checl($this->input->post('email'),md5($rendomcode));

			

				// SEND EMAIL CONFIRMATION

				$edata = $this->front_model->get_emails_data('forgot-password');

				

				$this->load->library('email');

				$this->email->from($edata[0]->eEmail, TITLEWEB);

				$this->email->to($_REQUEST['email']); 

				

				$replace = array("[WEBURL]","[CODE]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]");

				$replacewith = array(WEBURL, $rendomcode,TITLEWEB,$this->input->post('email'),$rendomcode);

				$str = str_replace($replace,$replacewith,$edata[0]->eContent);

				$message = $str;

				$this->email->subject($edata[0]->eName.' - : : - '.TITLEWEB);

				$this->email->message($message);

				$this->email->set_mailtype("html");

				$send = $this->email->send();
				

			$_SESSION['thankyou'] = 'Email with temporaray password has been sent!';

			header ( "Location:" . $this->config->base_url ());

		}

	}

	// Thankyou page

	public function thank_you(){

		if(isset($_SESSION['JobsSessions'])){

			if($this->uri->segment(1) != "thank-you"){

			header ( "Location:" . $this->config->base_url ()."dashboard");

			}

			else {

				$this->data['page'] = $this->front_model->get_cms_page('thank-you');

				$this->load->view('frontend/thank_you', $this->data);				

			}

		}

		else {

			$this->data['page'] = $this->front_model->get_cms_page('thank-you');

			$this->load->view('frontend/thank_you', $this->data);

		}

	}

	

	// JOB LISTING BY CATEGORY

	public function job_details(){

		$arr = array();

		$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);

		$this->data['countries'] 	= $config->result_object();

		// GET COUNTRIES

		$config 	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);

		$this->data['categories'] 	= $config->result_object();

		$this->load->view('frontend/job_details',$this->data);

	}

	

	// JOB Details

	/*public function jobs_list(){

		$arr = array();

		$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);

		$this->data['countries'] 	= $config->result_object();

		// GET COUNTRIES

		$config 	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);

		$this->data['categories'] 	= $config->result_object();

		$this->load->view('frontend/job_listig',$this->data);

	}*/

	public function jobs_list(){
		/*$config 	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);

		$this->data['categories'] 	= $config->result_object();*/

		

		//error_reporting(-1);

		if($this->uri->segment(1) == "country"){
			$u = str_replace("-"," ",$this->uri->segment(2));
			$arr  = array('jCoutry' => $u,'jJobStatus' => 1);
		}else {
			
		$arr = array('catLink' => $this->uri->segment(2));
		$config	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);
		$catid 	= $config->result_object();

			$arr = array('cID' => $catid[0]->cID,'jJobStatus' => 1);
		}
		$jconfig	= $this->front_model->get_query_simple('*','dev_web_jobs',$arr);

		//$jobs 		= $jconfig->result_object();

		$jobscount 		= $jconfig->num_rows();

		

		$this->load->library("pagination");

		$config = array();

        $config["base_url"] = base_url()."jobs/".$this->uri->segment(2)."/";

        $config["total_rows"] = $jobscount;

        $config["per_page"] = 10;

        $config["uri_segment"] = 3;

		

		$config['cur_tag_open'] = '&nbsp;<a class="current">';

		$config['cur_tag_close'] = '</a>';

		$config['next_link'] = 'Next';

		$config['prev_link'] = 'Previous';

		$this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		if($this->uri->segment(1) == "country"){
			$u = str_replace("-"," ",$this->uri->segment(2));
			$arr  = array('jCoutry' => $u,'jJobStatus' => 1);
		}else {
			$arrdata = array('catLink' => $this->uri->segment(2));
			$configda	= $this->front_model->get_query_simple('*','dev_web_categories',$arrdata);
			$catidd 	= $configda->result_object();
			$arr  = array('cID' => $catidd[0]->cID,'jJobStatus' => 1);
		}
		$comp = $this->front_model->get_query_orderby_limit('*','dev_web_jobs',$arr,'jID','DESC',$config["per_page"],$page);
		$row = $comp->result_object();
		//echo $this->db->last_query();
		$this->data['jobs'] = $row;

		$this->data["links"] = $this->pagination->create_links();

		

		$this->load->view('frontend/job_listig',$this->data);

	}

	

	// JOB LISTING BY COUNTRY

	public function countries_job_list(){

		$arr = array();

		$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);

		$this->data['countries'] 	= $config->result_object();

		// GET COUNTRIES

		$config 	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);

		$this->data['categories'] 	= $config->result_object();

		$this->load->view('frontend/country_job_listig',$this->data);

	}

	// JOB LISTING BY CITY

	public function cities_job_list(){

		$arr = array();

		$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);

		$this->data['countries'] 	= $config->result_object();

		// GET COUNTRIES

		$config 	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);

		$this->data['categories'] 	= $config->result_object();

		$this->load->view('frontend/cities_job_listig',$this->data);

	}

	// Dashboard

	public function dashboard()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			$this->load->view('frontend/dashboard', $this->data);
		}
	}	

	public function user_reports()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
				$this->load->view('frontend/user_reports', $this->data);
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}
	}	
	public function add_admin_user()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
				$arr = array();
				$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);
				$this->data['countries'] 	= $config->result_object();
				$this->load->view('frontend/add_admin_user', $this->data);
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}
	}	
	
	public function admin_token_pricing()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
				$this->load->view('frontend/admin_token_pricing', $this->data);
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}
	}	
	public function add_token_pricing()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
				$this->load->view('frontend/add_token_pricing', $this->data);
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}
	}	
	
	public function admin_affiliates()
		{
			if(!isset($_SESSION['JobsSessions'])){
				header ( "Location:" . $this->config->base_url ()."login");
			}
			else {
				if(ACTYPE == "1"){
					$this->load->view('frontend/admin_affiliates', $this->data);
				} else {
					$this->load->view('frontend/home', $this->data);
				}
			}
		}	
			
	public function referral_program()
		{
			if(!isset($_SESSION['JobsSessions'])){
				header ( "Location:" . $this->config->base_url ()."login");
			}
			else {
				$this->load->view('frontend/referral_program', $this->data);
			}
		}	
	// Profile

	public function profile_dashboard()

	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			$arr = array('uID' => UID);
			$config = $this->front_model->get_query_simple('*','dev_web_user',$arr);
			$this->data['users'] 	= $config->result_array()[0];
			$arr = array();

			$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);

			$this->data['countries'] 	= $config->result_object();
			$this->load->view('frontend/profile_dashboard', $this->data);
		}
	}

	public function change_password()

	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			$arr = array('uID' => UID);
			$config = $this->front_model->get_query_simple('*','dev_web_user',$arr);
			$this->data['users'] 	= $config->result_array()[0];
			$arr = array();

			$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);

			$this->data['countries'] 	= $config->result_object();
			$this->load->view('frontend/change_password', $this->data);
		}
	}

	

	//CMS PAGES

	public function pages_cms()

	{

		$arr = array('pLink' => $this->uri->segment(1));

		$config 	= $this->front_model->get_query_simple('*','dev_web_pages',$arr);

		$this->data['pages'] 	= $config->result_object();

		$this->load->view('frontend/pages', $this->data);

	}

	//CMS PAGES

	public function faq_page()

	{

		$arr = array('fStatus' => 1);

		$config 	= $this->front_model->get_query_simple('*','dev_web_faq',$arr);

		$this->data['pages'] 	= $config->result_object();

		$this->load->view('frontend/faq_page', $this->data);

	}

	//CMS PAGES

	public function faq_page_secruity()

	{

		$arr = array('fStatus' => 2);

		$config 	= $this->front_model->get_query_simple('*','dev_web_faq',$arr);

		$this->data['pages'] 	= $config->result_object();

		$this->load->view('frontend/faq_page', $this->data);

	}

	public function logout()

	{

		$redi = "Location:".$this->config->base_url();
		unset($_SESSION['sessionCart']);

		unset($_SESSION['sessionCartCandidate']);

		unset($_SESSION['JobsSessions']);

		session_destroy();

		ob_start();

		error_reporting(0);

		session_start();

		$_SESSION['msglogin'] = 'You have logged out successfully!';

		header($redi);

		//header("Location:".$this->config->base_url().'login');

	}

	public function contact_email()

	{

		// SEND EMAIL CONFIRMATION

		$edata = $this->front_model->get_emails_data('contact-us');

		$this->load->library('email');

		$this->email->from($edata[0]->eEmail, TITLEWEB);

		$this->email->to($this->input->post('emailadd')); 

		$replace = array("[WEBURL]","[FULLNAME]","[WEBTITLE]","[EMAILADD]","[TYPE]","[MESSAGE]");

		$replacewith = array(WEBURL, $this->input->post('fname').' '.$this->input->post('lname'),TITLEWEB,$this->input->post('emailadd'),$this->input->post('type'),$this->input->post('messagequery'));

		$str = str_replace($replace,$replacewith,$edata[0]->eContent);

		$message = $str;

		$this->email->subject($edata[0]->eName);

		$this->email->message($message);

		$this->email->set_mailtype("html");

		$send = $this->email->send();

		$_SESSION['msglogin'] = 'Your message has been sent successfully!';

		header ( "Location:" . $this->config->base_url ().'contact-us');

	}

	// SAVE JOB

	public function save_job()

	{

		if(!isset($_SESSION['JobsSessions'])){

			$_SESSION['saveid'] = $this->uri->segment(2);

			$_SESSION['msglogin'] = "Please Login to save Job";

			header("Location:".$this->config->base_url()."login");

		}

		else {

			$data = array(

				'jID' 		=> $this->uri->segment(2),

				'uID' 		=> UID,

				'sDate' 	=> date('Y-m-d'),

			);

			$this->front_model->add_query('dev_web_saved',$data);

			unset($_SESSION['saveid']);

			$_SESSION['msglogin'] = "Job saved successfully!";

			header ( "Location:" . $this->config->base_url ()."saved-jobs");

		}

	}

	public function save_job_session()

	{

			$data = array(

				'jID' 		=> $_SESSION['saveid'],

				'uID' 		=> $_SESSION['JobsSessions'][0]->uID,

				'sDate' 	=> date('Y-m-d'),

			);

			$this->front_model->add_query('dev_web_saved',$data);

			unset($_SESSION['saveid']);

			$_SESSION['msglogin'] = "Job saved successfully!";

			header ( "Location:" . $this->config->base_url ()."saved-jobs");

	}

	// REMOVE SAVED

	public function remove_token_price()
	{
		$data = array(
				'tkID' 		=> $this->uri->segment(3),
		);
		$this->front_model->delete_query('dev_web_token_pricing',$data);
		$_SESSION['msglogin'] = "Token Price Removed successfully!";
		header ( "Location:" . $_SERVER['HTTP_REFERER']);
	}
	public function active_token_price()
		{
			// UPDATE ALL 
			$data = array('status' 		=> 0);
			$condition = array();
			$this->front_model->update_query('dev_web_token_pricing',$data,$condition);
			// UPDATE SELECTED ONE
			$data = array('status' 		=> 1);
			$condition = array(	'tkID' 	=> $this->uri->segment(3));
			$this->front_model->update_query('dev_web_token_pricing',$data,$condition);
			$_SESSION['msglogin'] = "Token Price Status updated successfully!";
			header ( "Location:" . $_SERVER['HTTP_REFERER']);
		}
	// SHOW USER SAVED JOBS

	public function saved_job_user()

	{

		if(!isset($_SESSION['JobsSessions'])){

			$_SESSION['msglogin'] = "Please Login to save Job";

			header ( "Location:" . $this->config->base_url ()."login");

		}

		else {

				$this->load->view('frontend/saved_jobs', $this->data);

		}

	}

	// SHOW Cover Letters

	public function cover_letters()

	{

		if(!isset($_SESSION['JobsSessions'])){

			$_SESSION['msglogin'] = "Please Login to Write a cover letter";

			header ( "Location:" . $this->config->base_url ()."login");

		}

		else{

			$this->load->view('frontend/cover_letters', $this->data);

		}

	}

	

	// SUBMIT COVER LETTER

	public function cover_letter_submit()

	{

		$data = array(

				'cvTitle' 		=> $this->input->post('coverTitle'),

				'cvText' 		=> nl2br($this->input->post('coverlettertext')),

				'uID' 			=> UID,

				'cvDate' 		=> date('Y-m-d'),

			);

			$this->front_model->add_query('dev_wev_coverletters',$data);

			$_SESSION['msglogin'] = "Cover letter submitted successfully!";

			header ("Location:" . $_SERVER['HTTP_REFERER']);

	}

	// SUBMIT COVER LETTER APPLY

	public function add_apply_coverletter()

	{

		$data = array(

				'cvTitle' 		=> $this->input->post('covertitle'),

				'cvText' 		=> nl2br($this->input->post('coverDescp')),

				'uID' 			=> UID,

				'cvDate' 		=> date('Y-m-d'),

			);

			$this->front_model->add_query('dev_wev_coverletters',$data);

			//$_SESSION['msglogin'] = "Cover letter submitted successfully!";

			header ("Location:" . $_SERVER['HTTP_REFERER']);

	}

	// EDIT COVER LETTER

	public function cover_letter_edit()

	{

			$data = array(

				'cvTitle' 	=> $this->input->post('coverTitle'),

				'cvText' 	 => nl2br($this->input->post('coverlettertext')),

			);



			$condition = array('cvID' => $this->input->post('cvID'));

			$this->front_model->update_query('dev_wev_coverletters',$data,$condition);

			$_SESSION['msglogin'] = "Cover Letter Information Updated Successfully!";

			header ( "Location:" . $this->config->base_url ()."cover-letters");

	}

	// Remove Cover letter

	public function cover_letter_remove()

	{

		$data = array('cvID' => $this->uri->segment(3),);

		$this->front_model->delete_query('dev_wev_coverletters',$data);

		$_SESSION['msglogin'] = "Cover Letter Removed successfully!";

		header ("Location:" . $_SERVER['HTTP_REFERER']);

	}

	// Edit cover letters

	public function cover_letters_edit()

	{

		if(!isset($_SESSION['JobsSessions'])){

			$_SESSION['msglogin'] = "Please Login to edit cover letter";

			header ( "Location:" . $this->config->base_url ()."login");

		}

		else {

				$this->load->view('frontend/cover_letters', $this->data);

		}

	}

	// UPDATE PROFILE INFORMATION

	public function profile_dashboard_update()

	{

			$data = array(

				'uFname' 				=> $this->input->post('first_name'),

				'uLname' 				=> $this->input->post('last_name'),

				//'uUsername' 		 	=> $this->input->post('username'),

				'uPhone' 		   		=> $this->input->post('phone'),

				'uCountry' 		  		=> $this->input->post('country'),

				'uAddress' 	  			=> $this->input->post('address'),

				'uCity' 	  			=> $this->input->post('city'),
				
				'uTelegram' 	  			=> $this->input->post('telegram'),

				'uZip'  	=> $this->input->post('postal_code'),

				//'uExperience'  			=> $this->input->post('explevel'),

				//'uMaritial'  			=> $this->input->post('maritial'),

			);

			

			$condition = array('uID' => UID);

			$this->front_model->update_query('dev_web_user',$data,$condition);

			$_SESSION['thankyou'] = "Your account information has been updated Successfully!";

			header ( "Location:" . $this->config->base_url ()."account/details");

	}

	// CHANGE PASSWORD

	public function do_change_password()
	{
		$arr2 = array('uPassword' => md5($this->input->post('oldpass')));
		$config2 = $this->front_model->get_query_simple('*','dev_web_user',$arr2);
		$count 	= $config2->num_rows();
		if($count > 0){
			$data = array(
				'uPassword' 	=> md5($this->input->post('password_new')),
			);
			$condition = array('uID' => UID);
			$this->front_model->update_query('dev_web_user',$data,$condition);
			
			// ADD NoTIFICATIONS
			$this->notification_users('Password Changed','Password has been changed successfully!');
			
			$_SESSION['thankyou_change'] = "Password Information Updated Successfully!";
			header ( "Location:" . $this->config->base_url ()."account/details?type=password");
		}
		else {
			//$_SESSION['change_div'] = 'change';
			$_SESSION['error_change'] = "Old Password not match!";
			header ( "Location:" . $this->config->base_url ()."account/details?type=password");
		}
	}
	
	public function do_referrel_settings()
	{
			$data = array(
				'tokenawarded' 	=> $this->input->post('tokenreward'),
				'tokenTitle' 	=> $this->input->post('refpagetitle'),
				'tokenText' 	=> nl2br($this->input->post('desctiptitle')),
			);
			$condition = array();
			$this->front_model->update_query('dev_web_ref_setting',$data,$condition);
			
			$_SESSION['thankyou_change'] = "Referrel Information Updated Successfully!";
			header ( "Location:" . $this->config->base_url ()."admin/affiliates");
	}
	
	public function do_update_wallet()
	{
			$data = array(
				'uWallet' 	=> $this->input->post('ethaddress'),
			);
			$condition = array('uID' => UID);
			$this->front_model->update_query('dev_web_user',$data,$condition);
			//$_SESSION['change_div'] = 'change';
			$_SESSION['thankyou_wallet'] = "ETH Valid Information Updated Successfully!";
			header ( "Location:" . $this->config->base_url ()."account/details");
	}

	// View ALL APPLIED JOBS

	public function applied_jobs()

	{

		if(!isset($_SESSION['JobsSessions'])){

			$_SESSION['msglogin'] = "Please Login to view your applications";

			header ( "Location:" . $this->config->base_url ()."login");

		}

		else{

			$this->load->view('frontend/jobs_applied', $this->data);

		}

	}

	// CV PAGE

	public function resume_management()

	{

		if(!isset($_SESSION['JobsSessions'])){

			$_SESSION['msglogin'] = "Please Login to view your resume";

			header ( "Location:" . $this->config->base_url ()."login");

		}

		else {

			if(ACTYPE == 1){

					$this->load->view('frontend/resume_management', $this->data);

				} else {

					header("Location: ".$this->config->base_url()."dashboard");

				}

		}

	}

	

	// CREATE RESUME

	public function resume_create_management()

	{

		if(!isset($_SESSION['JobsSessions'])){

			$_SESSION['msglogin'] = "Please Login to create or update your resume";

			header ( "Location:" . $this->config->base_url ()."login?redirect=create-cv");

		}

		else {

				if(ACTYPE == 1){

				$this->load->view('frontend/create_cv', $this->data);

				} else {

					header("Location: ".$this->config->base_url()."dashboard");

				}

		}

	}

	public function upload_resume_step(){

		$arr = array('uID' => UID);

		$config2 	= $this->front_model->get_query_simple('*','dev_web_cv',$arr);

		$count = $config2->num_rows();

		if($count == 0)

		{

			// ADD CV table

			if (!empty($_FILES['userfile']['name'])) {

			$rendomid = $this->generateRandomString();

			$imgname = strtolower(date("ymdhis").'_'.$rendomid.'_'.str_replace(" ","_",$_FILES["userfile"]['name']));

			$config['file_name'] = $imgname;

			$config['upload_path'] = 'resources/uploads/resume/';

			$config['allowed_types'] = 'pdf|doc|docx|PDF|DOC|DOCX';

			$config['max_size'] = '2048';

			$config['max_width']  = '';

			$config['max_height']  = '';

			$config['overwrite'] = TRUE;

			$config['remove_spaces'] = TRUE;

		

			$this->load->library('upload', $config);

		

			if ( ! $this->upload->do_upload())

			{

				if($this->input->post('returl') != ""){

					$_SESSION['msglogin'] = "Error while uploading CV, Please try again!";

					header ( "Location:" . $this->input->post('returl'));

				}

				else 

				{

					$data = array(

					'uID' 		  	   	  => UID,

					'cvTitle' 		  	  => $this->input->post('cvtitle'),

					'cvView' 		  	   => $this->input->post('findcv'),

					'cvStatus' 		  	 => 1,

					'cvPosted' 		  	 => date("Y-m-d"),

					);

				$this->front_model->add_query('dev_web_cv',$data);			

				$_SESSION['msglogin'] = "Error while uploading CV, but other information update successfully!";

				header ( "Location:" . $this->config->base_url ()."create-cv");

				}

			}

			else

			{

				$data = array('upload_data' => $this->upload->data());

				$data = array(

				'uID' 		  	   	  => UID,

				'cvTitle' 		  	   => $this->input->post('cvtitle'),

				'cvFile' 		  	   => $imgname,

				'cvView' 		  	   => $this->input->post('findcv'),

				'cvStatus' 		  	 => 1,

				'cvPosted' 		  	 => date("Y-m-d"),

			);

				$this->front_model->add_query('dev_web_cv',$data);			

				if(isset($_SESSION['SESSIONAPPLIED'])){

					header ( "Location:" . $_SESSION['SESSIONAPPLIED']);

				} else {

					//$_SESSION['msglogin'] = "CV and profile information added successfully!";

					if($this->input->post('returl') != ""){

					//$_SESSION['msglogin'] = "Error while uploading CV, Please try again!";

					header ( "Location:" . $this->input->post('returl'));

				}

				else 

				{

					header ( "Location:" . $this->config->base_url ()."create-cv?page=preferred");

				}

				}

			}

		}

			else {

					$data = array(

					'uID' 		  	   	  => UID,

					'cvTitle' 		  	   => $this->input->post('cvtitle'),

					'cvView' 		  	   => $this->input->post('findcv'),

					'cvStatus' 		  	 => 1,

					'cvPosted' 		  	 => date("Y-m-d"),

					);

					$this->front_model->add_query('dev_web_cv',$data);			

					if(isset($_SESSION['SESSIONAPPLIED'])){

					header ( "Location:" . $_SESSION['SESSIONAPPLIED']);

					} else {

					//$_SESSION['msglogin'] = "CV and profile information added successfully!";

						if($this->input->post('returl') != ""){

					//$_SESSION['msglogin'] = "Error while uploading CV, Please try again!";

					header ( "Location:" . $this->input->post('returl'));

				}

				else 

				{

						header ( "Location:" . $this->config->base_url ()."create-cv?page=preferred");

				}

					}

				}

		}

		else

		{

			if (!empty($_FILES['userfile']['name'])) {

				$rendomid = $this->generateRandomString();

				$imgname = strtolower(date("ymdhis").'_'.$rendomid.'_'.str_replace(" ","_",$_FILES["userfile"]['name']));

				$config['file_name'] = $imgname;

				$config['upload_path'] = 'resources/uploads/resume/';

				$config['allowed_types'] = 'pdf|doc|docx|PDF|DOC|DOCX';

				$config['max_size'] = '2048';

				$config['max_width']  = '';

				$config['max_height']  = '';

				$config['overwrite'] = TRUE;

				$config['remove_spaces'] = TRUE;

				$this->load->library('upload', $config);

			

				if ( ! $this->upload->do_upload())

				{

					$data = array(

						'cvView' 		  	   => $this->input->post('findcv'),

						'cvTitle' 		  	   => $this->input->post('cvtitle'),

						'cvUpdated' 		  	=> date("Y-m-d"),

					);

					$condition2 = array('cvID' => $this->input->post('cvID'));

					$this->front_model->update_query('dev_web_cv',$data,$condition2);

					$_SESSION['msglogin'] = "Error while uploading CV, but other information update successfully!";

					header ( "Location:" . $this->config->base_url ()."create-cv");

				}

				else

				{

					$countrow = $config2->result_object();

					unlink("resources/uploads/resume/".$countrow[0]->cvFile);

					$data = array('upload_data' => $this->upload->data());

					$data = array(

						'cvFile' 		  	   => $imgname,

						'cvTitle' 		  	   => $this->input->post('cvtitle'),

						'cvView' 		  	   => $this->input->post('findcv'),

						'cvUpdated' 		  	=> date("Y-m-d"),

					);

					$condition2 = array('cvID' => $this->input->post('cvID'));

					$this->front_model->update_query('dev_web_cv',$data,$condition2);

					$_SESSION['msglogin'] = "CV and profile information updated successfully!";

					header ( "Location:" . $this->config->base_url ()."create-cv?page=preferred");

				}

			}

				else {

						$data = array(

						'cvTitle' 		  	   => $this->input->post('cvtitle'),

						'cvView' 		  	   => $this->input->post('findcv'),

						'cvUpdated' 		  	=> date("Y-m-d"),

					);

					$condition2 = array('cvID' => $this->input->post('cvID'));

					$this->front_model->update_query('dev_web_cv',$data,$condition2);

			

					//$_SESSION['msglogin'] = "CV and profile information updated successfully!";

					if($this->input->post('returl') != ""){

					//$_SESSION['msglogin'] = "Error while uploading CV, Please try again!";

					header ( "Location:" . $this->input->post('returl'));

				}

				else 

				{

					header ( "Location:" . $this->config->base_url ()."create-cv?page=preferred");

				}

				}

		}

	}

	// PREFERRED STEP

	public function upload_preferred_step()

	{

		$ben = count($this->input->post('sectorindu'));

		$bid = $this->input->post('sectorindu');

		if($ben > 0){

		for($i=0;$i<$ben;$i++):

			$bent .= $bid[$i].",";

		endfor;

		$benefit = substr($bent,0,-1);

		}

		else { $benefit= '';}

		$benloc = count($this->input->post('location'));

		$bidloc = $this->input->post('location');

		if($ben > 0){

		for($i=0;$i<$benloc;$i++):

			$bentloc .= $bidloc[$i].",";

		endfor;

		$loca = substr($bentloc,0,-1);

		}

		else { $loca= '';}

		

		$arr = array('uID' => UID);

		$config2 	= $this->front_model->get_query_simple('*','dev_web_cv',$arr);

		$row = $config2->result_object();

		$data = array(

			'pJobtitle' 		    => $this->input->post('jobtitle'),

			'pjobskills' 		   => $this->input->post('skills'),

			'jobSector' 		    => $benefit,

			'pjoblocation' 		 => $loca,

			'prelocate' 			=> $this->input->post('relocate'),

			'pjobtype' 		   	 => $this->input->post('jobtype'),

			'psalaryfrom' 		  => $this->input->post('salaryfrom'),

			'psalaryto' 		  	=> $this->input->post('salaryto'),

			'pcurrency' 		  	=> $this->input->post('currency'),

			//'cvUpdated' 		  	=> date("Y-m-d"),

		);

		$condition2 = array('cvID' => $row[0]->cvID);

		$this->front_model->update_query('dev_web_cv',$data,$condition2);

		$_SESSION['msglogin'] = "Preferred Job Details information updated successfully!";

		header ( "Location:" . $this->config->base_url ()."create-cv?page=personal");

	}

	// PERSONAL DETAILS

	public function upload_perosnal_step()

	{

			// Update user table

			$data = array(

				'uFname' 		  => $this->input->post('fname'),

				'uLname' 		  => $this->input->post('lname'),

				'uDOB' 		 	=> $this->input->post('dob'),

				'uCountry' 		=> $this->input->post('country'),

				'uAddress' 		=> $this->input->post('address'),

				'uCity' 		   => $this->input->post('city'),

				'uZip' 		  	=> $this->input->post('zip'),

				'uPhone' 		  => $this->input->post('country_code')."-".$this->input->post('contact'),

			);

			$condition2 = array('uID' => UID);

			$this->front_model->update_query('dev_web_user',$data,$condition2);

			$_SESSION['msglogin'] = "Personal information updated successfully!";

			header ( "Location:" . $this->config->base_url ()."create-cv?page=relevant");				

	}

	

	// Relevant DETAILS

	public function upload_relevant_step()

	{

		$arr = array('uID' => UID);

		$config2 	= $this->front_model->get_query_simple('*','dev_web_cv',$arr);

		$row = $config2->result_object();

			$data = array(

						'anoticeperiod' 		=> $this->input->post('notice'),

						'alanguage' 		  	=> $this->input->post('languages'),

						'aeducationlevel' 	  => $this->input->post('leveleducation'),

						'ayear' 		 		=> $this->input->post('graduation'),

						'ajobsummary' 		  => $this->input->post('jobsummary'),

					);

					$condition2 = array('cvID' => $row[0]->cvID);

					$this->front_model->update_query('dev_web_cv',$data,$condition2);

					$_SESSION['msglogin'] = "Resume information updated successfully";

					header ( "Location:" . $this->config->base_url ()."cv-management");

	}

	// CREATE CV SUBMIT

	public function do_create_cv_submit(){

		

		$ben = count($this->input->post('sectorindu'));

			$bid = $this->input->post('sectorindu');

			if($ben > 0){

			for($i=0;$i<$ben;$i++):

				$bent .= $bid[$i].",";

			endfor;

			$benefit = substr($bent,0,-1);

			}

			else { $benefit= '';}

			$benloc = count($this->input->post('location'));

			$bidloc = $this->input->post('location');

			if($ben > 0){

			for($i=0;$i<$benloc;$i++):

				$bentloc .= $bidloc[$i].",";

			endfor;

			$loca = substr($bentloc,0,-1);

			}

			else { $loca= '';}

			

		$arr = array('uID' => UID);

		$config2 	= $this->front_model->get_query_simple('*','dev_web_cv',$arr);

		$count = $config2->num_rows();

		if($count == 0)

		{

			// Add data in table

			$data = array(

				'uFname' 		  => $this->input->post('fname'),

				'uLname' 		  => $this->input->post('lname'),

				'uDOB' 		 	=> $this->input->post('dob'),

				'uCountry' 		=> $this->input->post('country'),

				'uAddress' 		=> $this->input->post('address'),

				'uCity' 		   => $this->input->post('city'),

				'uZip' 		  	=> $this->input->post('zip'),

				'uPhone' 		  => $this->input->post('country_code').$this->input->post('contact'),

			);

			

			$condition = array('uID' => UID);

			$this->front_model->update_query('dev_web_user',$data,$condition);

			

			// ADD CV table

			if (!empty($_FILES['userfile']['name'])) {

			$rendomid = $this->generateRandomString();

			$imgname = strtolower(date("ymdhis").'_'.$rendomid.'_'.str_replace(" ","_",$_FILES["userfile"]['name']));

			$config['file_name'] = $imgname;

			$config['upload_path'] = 'resources/uploads/resume/';

			$config['allowed_types'] = 'pdf|doc|docx|PDF|DOC|DOCX';

			$config['max_size'] = '2048';

			$config['max_width']  = '';

			$config['max_height']  = '';

			$config['overwrite'] = TRUE;

			$config['remove_spaces'] = TRUE;

		

			$this->load->library('upload', $config);

		

			if ( ! $this->upload->do_upload())

			{

				$data = array(

				'uID' 		  	   	  => UID,

				'cvTitle' 		  	  => $this->input->post('cvtitle'),

				'cvView' 		  	   => $this->input->post('findcv'),

				'pJobtitle' 		    => $this->input->post('jobtitle'),

				'pjobskills' 		   => $this->input->post('skills'),

				'jobSector' 		   =>  $benefit,

				'pjoblocation' 		 => $loca,

				'prelocate' 			=> $this->input->post('relocate'),

				'pjobtype' 		   	 => $this->input->post('jobtype'),

				'psalaryfrom' 		  => $this->input->post('salaryfrom'),

				'psalaryto' 		  	=> $this->input->post('salaryto'),

				'pcurrency' 		  	=> $this->input->post('currency'),

				'anoticeperiod' 		=> $this->input->post('notice'),

				'alanguage' 		  	=> $this->input->post('languages'),

				'aeducationlevel' 	  => $this->input->post('leveleducation'),

				'ayear' 		 		=> $this->input->post('graduation'),

				'ajobsummary' 		  => $this->input->post('jobsummary'),

				'cvStatus' 		  	 => 1,

				'cvPosted' 		  	 => date("Y-m-d"),

			);

				$this->front_model->add_query('dev_web_cv',$data);			

				$_SESSION['msglogin'] = "Error while uploading CV, but other information update successfully!";

				header ( "Location:" . $this->config->base_url ()."cv-management");

			}

			else

			{

				$data = array('upload_data' => $this->upload->data());

				$data = array(

				'uID' 		  	   	  => UID,

				'cvTitle' 		  	   => $this->input->post('cvtitle'),

				'cvFile' 		  	   => $imgname,

				'cvView' 		  	   => $this->input->post('findcv'),

				'pJobtitle' 		    => $this->input->post('jobtitle'),

				'pjobskills' 		   => $this->input->post('skills'),

				'jobSector' 		   =>  $benefit,

				'pjoblocation' 		 => $loca,

				'prelocate' 			=> $this->input->post('relocate'),

				'pjobtype' 		   	 => $this->input->post('jobtype'),

				'psalaryfrom' 		  => $this->input->post('salaryfrom'),

				'psalaryto' 		  	=> $this->input->post('salaryto'),

				'pcurrency' 		  	=> $this->input->post('currency'),

				'anoticeperiod' 		=> $this->input->post('notice'),

				'alanguage' 		  	=> $this->input->post('languages'),

				'aeducationlevel' 	  => $this->input->post('leveleducation'),

				'ayear' 		 		=> $this->input->post('graduation'),

				'ajobsummary' 		  => $this->input->post('jobsummary'),

				'cvStatus' 		  	 => 1,

				'cvPosted' 		  	 => date("Y-m-d"),

			);

				$this->front_model->add_query('dev_web_cv',$data);			

				if(isset($_SESSION['SESSIONAPPLIED'])){

					header ( "Location:" . $_SESSION['SESSIONAPPLIED']);

				} else {

					$_SESSION['msglogin'] = "CV and profile information added successfully!";

					header ( "Location:" . $this->config->base_url ()."cv-management");

				}

			}

		}

			else {

					$data = array(

					'uID' 		  	   	  => UID,

					'cvTitle' 		  	   => $this->input->post('cvtitle'),

					'cvView' 		  	   => $this->input->post('findcv'),

					'pJobtitle' 		    => $this->input->post('jobtitle'),

					'pjobskills' 		   => $this->input->post('skills'),

					'jobSector' 		   => $benefit,

					'pjoblocation' 		 => $loca,

					'prelocate' 			=> $this->input->post('relocate'),

					'pjobtype' 		   	 => $this->input->post('jobtype'),

					'psalaryfrom' 		  => $this->input->post('salaryfrom'),

					'psalaryto' 		  	=> $this->input->post('salaryto'),

					'pcurrency' 		  	=> $this->input->post('currency'),

					'anoticeperiod' 		=> $this->input->post('notice'),

					'alanguage' 		  	=> $this->input->post('languages'),

					'aeducationlevel' 	  => $this->input->post('leveleducation'),

					'ayear' 		 		=> $this->input->post('graduation'),

					'ajobsummary' 		  => $this->input->post('jobsummary'),

					'cvStatus' 		  	 => 1,

					'cvPosted' 		  	 => date("Y-m-d"),

					);

					$this->front_model->add_query('dev_web_cv',$data);			

					if(isset($_SESSION['SESSIONAPPLIED'])){

					header ( "Location:" . $_SESSION['SESSIONAPPLIED']);

					} else {

					$_SESSION['msglogin'] = "CV and profile information added successfully!";

					header ( "Location:" . $this->config->base_url ()."cv-management");

					}

				}

		}

		else 

		{

			// Update user table

				$data = array(

					'uFname' 		  => $this->input->post('fname'),

					'uLname' 		  => $this->input->post('lname'),

					'uDOB' 		 	=> $this->input->post('dob'),

					'uCountry' 		=> $this->input->post('country'),

					'uAddress' 		=> $this->input->post('address'),

					'uCity' 		   => $this->input->post('city'),

					'uZip' 		  	=> $this->input->post('zip'),

					'uPhone' 		  => $this->input->post('contact'),

				);

				

				$condition2 = array('uID' => UID);

				$this->front_model->update_query('dev_web_user',$data,$condition2);

				

				// Update CV table

				

				if (!empty($_FILES['userfile']['name'])) {

				$rendomid = $this->generateRandomString();

				$imgname = strtolower(date("ymdhis").'_'.$rendomid.'_'.str_replace(" ","_",$_FILES["userfile"]['name']));

				$config['file_name'] = $imgname;

				$config['upload_path'] = 'resources/uploads/resume/';

				$config['allowed_types'] = 'pdf|doc|docx|PDF|DOC|DOCX';

				$config['max_size'] = '2048';

				$config['max_width']  = '';

				$config['max_height']  = '';

				$config['overwrite'] = TRUE;

				$config['remove_spaces'] = TRUE;

				$this->load->library('upload', $config);

			

				if ( ! $this->upload->do_upload())

				{

					$data = array(

						'cvView' 		  	   => $this->input->post('findcv'),

						'cvTitle' 		  	   => $this->input->post('cvtitle'),

						'pJobtitle' 		    => $this->input->post('jobtitle'),

						'pjobskills' 		   => $this->input->post('skills'),

						'jobSector' 		   =>  $benefit,

						'pjoblocation' 		 => $loca,

						'prelocate' 			=> $this->input->post('relocate'),

						'pjobtype' 		   	 => $this->input->post('jobtype'),

						'psalaryfrom' 		  => $this->input->post('salaryfrom'),

						'psalaryto' 		  	=> $this->input->post('salaryto'),

						'pcurrency' 		  	=> $this->input->post('currency'),

						'anoticeperiod' 		=> $this->input->post('notice'),

						'alanguage' 		  	=> $this->input->post('languages'),

						'aeducationlevel' 	  => $this->input->post('leveleducation'),

						'ayear' 		 		=> $this->input->post('graduation'),

						'ajobsummary' 		  => $this->input->post('jobsummary'),

						'cvUpdated' 		  	=> date("Y-m-d"),

					);

					$condition2 = array('cvID' => $this->input->post('cvID'));

					$this->front_model->update_query('dev_web_cv',$data,$condition2);

					$_SESSION['msglogin'] = "Error while uploading CV, but other information update successfully!";

					header ( "Location:" . $this->config->base_url ()."cv-management");

				}

				else

				{

					$countrow = $config2->result_object();

					unlink("resources/uploads/resume/".$countrow[0]->cvFile);

					$data = array('upload_data' => $this->upload->data());

					$data = array(

						'cvFile' 		  	   => $imgname,

						'cvTitle' 		  	   => $this->input->post('cvtitle'),

						'cvView' 		  	   => $this->input->post('findcv'),

						'pJobtitle' 		    => $this->input->post('jobtitle'),

						'pjobskills' 		   => $this->input->post('skills'),

						'jobSector' 		   => $benefit,

						'pjoblocation' 		 => $loca,

						'prelocate' 			=> $this->input->post('relocate'),

						'pjobtype' 		   	 => $this->input->post('jobtype'),

						'psalaryfrom' 		  => $this->input->post('salaryfrom'),

						'psalaryto' 		  	=> $this->input->post('salaryto'),

						'pcurrency' 		  	=> $this->input->post('currency'),

						'anoticeperiod' 		=> $this->input->post('notice'),

						'alanguage' 		  	=> $this->input->post('languages'),

						'aeducationlevel' 	  => $this->input->post('leveleducation'),

						'ayear' 		 		=> $this->input->post('graduation'),

						'ajobsummary' 		  => $this->input->post('jobsummary'),

						'cvUpdated' 		  	=> date("Y-m-d"),

					);

					$condition2 = array('cvID' => $this->input->post('cvID'));

					$this->front_model->update_query('dev_web_cv',$data,$condition2);

					$_SESSION['msglogin'] = "CV and profile information updated successfully!";

					header ( "Location:" . $this->config->base_url ()."cv-management");

				}

			}

				else {

						$data = array(

						'cvTitle' 		  	   => $this->input->post('cvtitle'),

						'cvView' 		  	   => $this->input->post('findcv'),

						'pJobtitle' 		    => $this->input->post('jobtitle'),

						'pjobskills' 		   => $this->input->post('skills'),

						'jobSector' 		   => $benefit,

						'pjoblocation' 		 => $loca,

						'prelocate' 			=> $this->input->post('relocate'),

						'pjobtype' 		   	 => $this->input->post('jobtype'),

						'psalaryfrom' 		  => $this->input->post('salaryfrom'),

						'psalaryto' 		  	=> $this->input->post('salaryto'),

						'pcurrency' 		  	=> $this->input->post('currency'),

						'anoticeperiod' 		=> $this->input->post('notice'),

						'alanguage' 		  	=> $this->input->post('languages'),

						'aeducationlevel' 	  => $this->input->post('leveleducation'),

						'ayear' 		 		=> $this->input->post('graduation'),

						'ajobsummary' 		  => $this->input->post('jobsummary'),

						'cvUpdated' 		  	=> date("Y-m-d"),

					);

					$condition2 = array('cvID' => $this->input->post('cvID'));

					$this->front_model->update_query('dev_web_cv',$data,$condition2);

			

					$_SESSION['msglogin'] = "CV and profile information updated successfully!";

					header ( "Location:" . $this->config->base_url ()."cv-management");

				}

			

		}

	}

	// APPLY JOB SUBMIT

	public function job_Applied_submit()

	{

		$ref = $this->generateRandomString()."-".$this->generateRandomString();

		$data = array(

						'jID' 		  	   	  => $this->input->post('jID'),

						'uID' 		  	   	  => UID,

						'cvID' 		   		 => $this->input->post('cv'),

						'cvrID' 		   		=> $this->input->post('coverletter'),

						'aAuthorized' 		  => $this->input->post('authorized'),

						'appliedDate' 		  => date("Y-m-d"),

						'refrenceApplied' 	  => $ref,

					);

					$this->front_model->add_query('dev_web_applied',$data);

					

		$c2 = array('uID' => UID);

		$us =  $this->front_model->get_query_simple('*','dev_web_user',$c2);

		$user = $us->result_object();

		// JOB DETAILS

		$condition4 = array('jID' => $this->input->post('jID'));

		$ind4 = $this->front_model->get_query_simple('*','dev_web_jobs',$condition4);

		$jobs = $ind4->result_object();

		

		$c2dd = array('uID' => $jobs[0]->uID);

		$usdcom =  $this->front_model->get_query_simple('*','dev_web_user',$c2dd);

		$comp = $usdcom->result_object();

// EMAIL TO USER

				$edata = $this->front_model->get_emails_data('job-confirmation-notification');

				$this->load->library('email');

				$this->email->from($edata[0]->eEmail, TITLEWEB);

				$this->email->to($user[0]->uEmail); 

				$replace = array("[WEBURL]","[USER]","[JOB]","[REFERENCE]","[COMPANY]");

				$replacewith = array(WEBURL, $user[0]->uFname." ".$user[0]->uLname,$jobs[0]->jTitle,$ref,$comp[0]->uFname." ".$comp[0]->uLname);

				$str = str_replace($replace,$replacewith,$edata[0]->eContent);

				$message = $str;

				$this->email->subject($edata[0]->eName);

				$this->email->message($message);

				$this->email->set_mailtype("html");

				$send = $this->email->send();

				// EMAIL to COMPANY

				if($jobs[0]->jEmailNotify == 1){

					$edata = $this->front_model->get_emails_data('job-app-notification');

					$this->load->library('email');

					$this->email->from($edata[0]->eEmail, TITLEWEB);

					$this->email->to($comp[0]->uEmail); 

					//echo $comp[0]->uEmail;

					$replace = array("[WEBURL]","[USER]","[JOB]","[REFERENCE]","[COMPANY]");

					$replacewith = array(WEBURL, $user[0]->uFname." ".$user[0]->uLname,$jobs[0]->jTitle,$ref,$comp[0]->uFname." ".$comp[0]->uLname);

					$str = str_replace($replace,$replacewith,$edata[0]->eContent);

					$message = $str;

					$this->email->subject($edata[0]->eName);

					$this->email->message($message);

					$this->email->set_mailtype("html");

					$send = $this->email->send();

				}

				//die;

					$_SESSION['msglogin'] = "You have applied for this job successfully!";

					header ( "Location:" . $this->config->base_url ().$this->input->post('retURL'));

	}

	

	// CREATE CV SUBMIT at UPLOAD TIME

	public function do_create_cv_submit_upload(){

		

			// Add data in table

			$data = array(

				'uFname' 		  => $this->input->post('fname'),

				'uLname' 		  => $this->input->post('lname'),

				'uDOB' 		 	=> $this->input->post('dob'),

				'uCountry' 		=> $this->input->post('country'),

				'uAddress' 		=> $this->input->post('address'),

				'uCity' 		   => $this->input->post('city'),

				'uZip' 		  	=> $this->input->post('zip'),

				'uPhone' 		  => $this->input->post('contact'),

			);

			

			$condition = array('uID' => $_SESSION['userID']);

			$this->front_model->update_query('dev_web_user',$data,$condition);

			

			// ADD CV table

			if (!empty($_FILES['userfile']['name'])) {

			$rendomid = $this->generateRandomString();

			$imgname = strtolower(date("ymdhis").'_'.$rendomid.'_'.str_replace(" ","_",$_FILES["userfile"]['name']));

			$config['file_name'] = $imgname;

			$config['upload_path'] = 'resources/uploads/resume/';

			$config['allowed_types'] = 'pdf|doc|docx|PDF|DOC|DOCX';

			$config['max_size'] = '2048';

			$config['max_width']  = '';

			$config['max_height']  = '';

			$config['overwrite'] = TRUE;

			$config['remove_spaces'] = TRUE;

		

			$this->load->library('upload', $config);

		

			if (!$this->upload->do_upload())

			{

				$_SESSION['msglogin'] = "Error while uploading CV, Invalid CV format!";

				header ( "Location:" . $this->config->base_url ()."signup/cv/upload");

			}

			else

			{

				$data = array('upload_data' => $this->upload->data());

				$data = array(

				'uID' 		  	   	  => $_SESSION['userID'],

				'cvFile' 		  	   => $imgname,

				'cvView' 		  	   => $this->input->post('findcv'),

				'pJobtitle' 		    => $this->input->post('jobtitle'),

				'pjobskills' 		   => $this->input->post('skills'),

				'pjoblocation' 		 => $this->input->post('location'),

				'prelocate' 			=> $this->input->post('relocate'),

				'pjobtype' 		   	 => $this->input->post('jobtype'),

				'psalaryfrom' 		  => $this->input->post('salaryfrom'),

				'psalaryto' 		  	=> $this->input->post('salaryto'),

				'anoticeperiod' 		=> $this->input->post('notice'),

				'alanguage' 		  	=> $this->input->post('languages'),

				'aeducationlevel' 	  => $this->input->post('leveleducation'),

				'ayear' 		 		=> $this->input->post('graduation'),

				'ajobsummary' 		  => $this->input->post('jobsummary'),

				'cvStatus' 		  	 => 1,

				'cvPosted' 		  	 => date("Y-m-d"),

			);

				$this->front_model->add_query('dev_web_cv',$data);	

				

					$arr = array('uID' => $_SESSION['userID']);

					$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

					$row = $datashow->result_object();

					$_SESSION['JobsSessions'] 	= $row;

					unset($_SESSION['userID']);

							

				$_SESSION['msglogin'] = "Cv and profile information added successfully!";

				header ( "Location:" . $this->config->base_url ()."thank-you");

			}

		}

			else {

					$data = array(

					'uID' 		  	   	  => $_SESSION['userID'],

					'cvView' 		  	   => $this->input->post('findcv'),

					'pJobtitle' 		    => $this->input->post('jobtitle'),

					'pjobskills' 		   => $this->input->post('skills'),

					'pjoblocation' 		 => $this->input->post('location'),

					'prelocate' 			=> $this->input->post('relocate'),

					'pjobtype' 		   	 => $this->input->post('jobtype'),

					'psalaryfrom' 		  => $this->input->post('salaryfrom'),

					'psalaryto' 		  	=> $this->input->post('salaryto'),

					'anoticeperiod' 		=> $this->input->post('notice'),

					'alanguage' 		  	=> $this->input->post('languages'),

					'aeducationlevel' 	  => $this->input->post('leveleducation'),

					'ayear' 		 		=> $this->input->post('graduation'),

					'ajobsummary' 		  => $this->input->post('jobsummary'),

					'cvStatus' 		  	 => 1,

					'cvPosted' 		  	 => date("Y-m-d"),

					);

					$this->front_model->add_query('dev_web_cv',$data);			

					

					$arr = array('uID' => $_SESSION['userID']);

					$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

					$row = $datashow->result_object();

					$_SESSION['JobsSessions'] 	= $row;

					unset($_SESSION['userID']);

					

					$_SESSION['msglogin'] = "Cv and profile information added successfully!";

					header ( "Location:" . $this->config->base_url ()."thank-you");

				}

		

		

	}

	// RECRUITER SIGNUP

	public function recruiter_signup()

	{

		if(isset($_SESSION['JobsSessions']) && $_SESSION['JobsSessions'][0]->uActType == "2"){

		header ( "Location:" . $this->config->base_url ()."dashboard");

		}

		else {

		$this->load->view('frontend/recruiter_signup_page', $this->data);

		}

	}

	public function signup_recruiter_submit()

	{

		$emaildata = $this->input->post('emailaddpay').$this->input->post('domainname');

		$datashow = $this->front_model->check_email_user($emaildata);

		if($datashow > 0)

		{	

			 $_SESSION['wrongsignup'] = $_POST;

			 $_SESSION['msglogin'] = "Email address already exist!";

			 header ( "Location:" . $_SERVER['HTTP_REFERER']);

		}

		else

		{  

				$sectors = '';

				$countv = $this->input->post('sectorindustry');

				for($i=0;$i < count($this->input->post('sectorindustry'));$i++){

					$sectors .= $countv[$i].",";

				}

				$sectoruser = substr($sectors,0,-1);

$reccount = $this->input->post('countryrecruit');

				for($j=0;$j < count($this->input->post('countryrecruit'));$j++){

					$country .= $reccount[$j].",";

				}

				$countryuser = substr($country,0,-1);



				$securitycode = $this->generateSecurityCode();

				$rendomcode = $this->generateRandomString();

				$name = explode(" ",$this->input->post('companyName'));

				$data = array(

								'uFname' 	   => $name[0],

								'uSectors' 	 => $sectoruser,

								'uLname' 	   => $name[1],

								'uEmail' 	   => $emaildata,

								'uUsername' 	=> $this->input->post('emailaddpay').$this->generateSecurityCode(),

								'uPassword' 	=> md5($this->input->post('passwordlogin')),

								'uCompany' 	 => $this->input->post('companyName'),

								'uPhone' 	   => $this->input->post('country_code').$this->input->post('contactnumber'),

								'uWebsite' 	 => $this->input->post('companyurl'),

								'uCountry' 	 => $countryuser,

								'uGender' 	  => "Male",

								'uActType' 	 => 2,

								'uStatus' 	  => 1,

								'uPayment' 	 => 0,

								'joinDate' 	 => date('Y-m-d h:i:s'),

								'uCode' 		=> $rendomcode,

								'uReCode' 	  => $securitycode,

								'uIP' 		  => $_SERVER['REMOTE_ADDR'],

								'uLoginLast'   => date("Y-m-d h:i:s"),

							);

						$uID = $this->front_model->add_query('dev_web_user',$data);

						

						// SEND EMAIL CONFIRMATION

						$edata = $this->front_model->get_emails_data('account-confirmation-recruiter');

						$this->load->library('email');

						$this->email->from($edata[0]->eEmail, TITLEWEB);

						$this->email->to($emaildata); 

						$replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]","[SECURITYCODE]","[USERTYPE]");

						$replacewith = array(WEBURL, $rendomcode, $this->input->post('companyName'),TITLEWEB,$emaildata,$this->input->post('passwordlogin'),$securitycode,"RECRUITER");

						$str = str_replace($replace,$replacewith,$edata[0]->eContent);

						$message = $str;

						$this->email->subject($edata[0]->eName);

						$this->email->message($message);

						$this->email->set_mailtype("html");

						$send = $this->email->send();

						

						// SEND EMAIL CONFIRMATION

						$edata = $this->front_model->get_emails_data('user-signup-confirmation-resend');

						$this->load->library('email');

						$this->email->from($edata[0]->eEmail, TITLEWEB);

						$this->email->to($emaildata); 

						$replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]");

						$replacewith = array(WEBURL, $rendomcode, $this->input->post('companyName'),TITLEWEB);

						$str = str_replace($replace,$replacewith,$edata[0]->eContent);

						$message2 = $str;

						$this->email->subject($edata[0]->eName);

						$this->email->message($message2);

						$this->email->set_mailtype("html");

						$send = $this->email->send();

						// DO LOGIN			

						$arr = array(

							'uEmail'	=>	$emaildata,

							'uPassword' =>	md5($this->input->post('passwordlogin')),

							'uReCode'   =>	$securitycode,

						);

						$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

						$count = $datashow->num_rows();

						unset($_SESSION['JobsSessions']);

						$row = $datashow->result_object();

						$_SESSION['JobsSessions'] = $row;

			header ("Location:" . $this->config->base_url()."post-job");			

		}

	

	}

	// JOB ADVERT

	/*public function post_job_advert()

	{

		if(!isset($_SESSION['JobsSessions'])){

			header ("Location:" . $this->config->base_url()."recruiter-signup");
		}

		else {

			if(!isset($_GET['type'])){

			if(ADVERTS != 0 || CANDIDATE !=0){

				$arr2 = array('uID' => UID);

				$configco = $this->front_model->get_query_simple('*','dev_web_jobs',$arr2);

				$cout = $configco->num_rows();

				if(ADVERTS == 0){ 

					$this->load->view('frontend/job_advert_page', $this->data);

				}

				else {

				$arr = array();

				$cat 	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);

				$this->data['industry']	= $cat->result_object();

				$ben 	= $this->front_model->get_query_simple('*','dev_web_benefits',$arr);

				$this->data['benefits']	= $ben->result_object();

				$dep	= $this->front_model->get_query_simple('*','dev_web_departments',$arr);

				$this->data['departments']	= $dep->result_object();

				$citi 		= $this->front_model->get_query_simple('*','dev_web_cities',$arr);

				$this->data['cities']	= $citi->result_object();

				

				$this->load->view('frontend/advert_post_page', $this->data);

				}

				

			}

			else {

				$this->load->view('frontend/job_advert_page', $this->data);

			}

			}

			else {

				$arr = array();

				$cat 	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);

				$this->data['industry']	= $cat->result_object();

				$ben 	= $this->front_model->get_query_simple('*','dev_web_benefits',$arr);

				$this->data['benefits']	= $ben->result_object();

				$dep	= $this->front_model->get_query_simple('*','dev_web_departments',$arr);

				$this->data['departments']	= $dep->result_object();

				$citi 		= $this->front_model->get_query_simple('*','dev_web_cities',$arr);

				$this->data['cities']	= $citi->result_object();

				$this->load->view('frontend/advert_post_page', $this->data);

			}

		}

	}*/

public function post_job_advert()

	{

		if(!isset($_SESSION['JobsSessions'])){

			header ("Location:" . $this->config->base_url()."recruiter-signup");

			//$this->load->view('frontend/job_advert_page', $this->data);

		}
			else {

				$arr = array();

				$cat 	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);

				$this->data['industry']	= $cat->result_object();

				$ben 	= $this->front_model->get_query_simple('*','dev_web_benefits',$arr);

				$this->data['benefits']	= $ben->result_object();

				$dep	= $this->front_model->get_query_simple('*','dev_web_departments',$arr);

				$this->data['departments']	= $dep->result_object();

				$citi 		= $this->front_model->get_query_simple('*','dev_web_cities',$arr);

				$this->data['cities']	= $citi->result_object();

				$this->load->view('frontend/advert_post_page', $this->data);

			}

}
	

	// JOB ADVERT

	public function candidate_search_recruiter()

	{

		//echo CANDIENDDATE;

			if(isset($_SESSION['JobsSessions'])){

				if(CANDIDATE != 0){

					if(CANDIENDDATE < date("Y-m-d")){

						$data = array(

						'uCanSearch' 		  => 0,

						'endDateCandidate' 	=> '',

						);

						$condition = array('uID' => UID);

						$this->front_model->update_query('dev_web_user',$data,$condition);

						$this->load->view('frontend/candidate_search_page', $this->data);

						//header("Location:");

					}

					else {

						$this->load->view('frontend/search_candidate_page', $this->data);

					}

				}else {

					$this->load->view('frontend/candidate_search_page', $this->data);

				}

			}

			else {

				$this->load->view('frontend/candidate_search_page', $this->data);

			}

	}

	

	// PROCESS CART

	public function cart_process()

	{

		if(!isset($_SESSION['sessionCart'])){

			$_SESSION['sessionCart']['val'] = $_REQUEST['val'];

		}

		else {

			$_SESSION['sessionCart']['val'] = $_REQUEST['val'];

		}

	}

	public function cart_process_candidate()

	{

		if(!isset($_SESSION['sessionCartCandidate'])){

			$_SESSION['sessionCartCandidate']['val'] = $_REQUEST['val'];

		}

		else {

			$_SESSION['sessionCartCandidate']['val'] = $_REQUEST['val'];

		}

	}

	public function cart_process_box()

	{

		error_reporting(0);

	?>

    <?php if(isset($_SESSION['sessionCart'])){?>

    <p style="text-transform:uppercase; margin-bottom:10px; text-align:center;">Job advert</p>

    <div class="boxcartshow">

    

    <?php if($_SESSION['sessionCart']['val'] == 1){$pricecart = '149';} else if($_SESSION['sessionCart']['val'] == 2){$pricecart = '140';} else if($_SESSION['sessionCart']['val'] == 3){$pricecart = '130';} else if($_SESSION['sessionCart']['val'] == 4){$pricecart = '120';} else if($_SESSION['sessionCart']['val'] >= 5){$pricecart = '110';}?>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="carttable">

  <tr>

    <th>Type/Quantity</th>

    <th>Price</th>

    <th>Delete</th>

  </tr>

  <tr>

    <td><input type="text" onkeyup="updatecart()" value="<?php echo $_SESSION['sessionCart']['val'];?>" class="jinput" name="qtycartup" id="qtycartup" style="padding: 4px;

  width: 53px;"></td>

    <td>$<?php echo $pricecart.".00";?></td>

    <td align="center"><i class="fa fa-trash-o" style="font-size:14px; cursor:pointer" title="Remove" onclick="cartdelete('adv')"></i></td>

  </tr>

</table>

<h2>Total Price : $<?php echo $_SESSION['sessionCart']['val']*$pricecart.".00";?></h2>

</div>

	<?php } ?>

    

    <?php if(isset($_SESSION['sessionCartCandidate'])){?>

	<p style="text-transform:uppercase; margin-bottom:10px; text-align:center; margin-top:10px;">Candidate Search</p>

	<div class="boxcartshow">

    <?php if($_SESSION['sessionCartCandidate']['val'] == 1){$pricecartcand = '190';$day ='1 Day';} else if($_SESSION['sessionCartCandidate']['val'] == 7){$pricecartcand = '250';$day ='7 Days';} else if($_SESSION['sessionCartCandidate']['val'] == 28){$pricecartcand = '750';

	$day ='1 Month';}?>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="carttable">

  <tr>

    <th>Type/Quantity</th>

    <th>Price</th>

    <th>Delete</th>

  </tr>

  <tr>

    <td><?php echo $day;?></td>

    <td>$<?php echo $pricecartcand.".00";?></td>

    <td><i class="fa fa-trash-o" style="font-size:14px; cursor:pointer" title="Remove" onclick="cartdelete('candi')"</td>

  </tr>

</table>

<h2>Total Price : $<?php echo $pricecartcand.".00";?></h2>



</div>

	<?php } ?>

    <?php ?>

    		<?php if(isset($_SESSION['coponcodeses'])){

			$gprice = ($pricecartcand)+($_SESSION['sessionCart']['val']*$pricecart);

				$subprice = $gprice*$_SESSION['coponcodeses']/100;

				$grndprice = $gprice - $subprice;

			?>

            	<small class="right" style="margin-bottom: 10px;

  color: #f00; text-transform:uppercase;">Discount: <?php echo $_SESSION['coponcodeses'];?>%</small>

            <?php } else {

				$grndprice = ($pricecartcand)+($_SESSION['sessionCart']['val']*$pricecart).".00";

			}?>

    		<h1 style="float: left;

  width: 100%;

  box-sizing: border-box;">Grand Price: $<?php echo($grndprice);?></h1>

    	<a href="<?php echo base_url(); ?>checkout" id="checboxout"><button name="postjob" class="btn pink">Checkout</button></a>

    <?php if(!isset($_SESSION['sessionCart']) && !isset($_SESSION['sessionCartCandidate'])){?>

    	<div class="nocart">Your cart is currently empty :(</div>

    <?php } ?>

    <?php

	}

	// DLETE SESSION CART

	public function cart_delete_recruiter()

	{

		if($_REQUEST['type'] = 'adv'){

			unset($_SESSION['sessionCart']);

			echo "1";

		}

		else {

			unset($_SESSION['sessionCartCandidate']);

			echo "2";

		}

		

		

	}

	

	// RECRUITER LOGIN

	public function recruiter_login_page()

	{

		$this->load->view('frontend/login_recruiter',$this->data);	

	}

	// POST JOB SUBMIT

	public function job_post_form_submit()

	{

		$randomcode = $this->generateRandomString();

		$timezone = date_default_timezone_get();

		$datetime = date('Y-m-d H:i:s', time());

		$id = $this->input->post('benefits');

		$ben = count($this->input->post('benefits'));

		if($ben > 0){

		for($i=0;$i<$ben;$i++):

			$bent .= $id[$i].",";

		endfor;

		$benefit = substr($bent,0,-1);

		}

		else { $benefit= '';}

		if($this->input->post('applyurl') != ""){

			$applyurl = $this->input->post('applyurl');

			$direct = 1; 

		}

		else { 

			$applyurl = "";

			$direct = 0; 

		}

		$pt = str_replace(","," ",$this->input->post('jTitle'));

		$jurl = strtolower(url_title($pt))."-".$randomcode;

		if($this->input->post('notdis') == "0"){

			$discl = $this->input->post('notdis');

		}

		else { $discl = "1";}

		$v = $this->input->post('sameinfo');

		if(isset($v)){

			$arrcinfo 		= array('uID' => UID);

			$configcinfo	 = $this->front_model->get_query_simple('*','dev_web_user',$arrcinfo);					

			$cinfo 		   = $configcinfo->result_object(); 

			$compname = $cinfo[0]->uCompany;

			$compinfo = $cinfo[0]->uAbout;

			$compweb = $cinfo[0]->uWebsite;

			$compcperson = $cinfo[0]->uFname." ".$cinfo[0]->uLname;

			$compphone = $cinfo[0]->uPhone;

			$compaddress = $cinfo[0]->uAddress;

		}

		else {

			$compname = $this->input->post('companyNamenew');

			$compinfo = $this->input->post('companydetailsnew');

			$compweb = $this->input->post('comwebsite');

			$compcperson = $this->input->post('contactperson');

			$compphone = $this->input->post('phonecom');

			$compaddress = $this->input->post('comAddress');

			

		}

		if($this->input->post('chkdisclose') == "0"){

			$cdsi = $this->input->post('chkdisclose');

		}

		else {

			$cdsi = '1';

		}

		

		if($this->input->post('salnotdis') == "1"){

			$saldsi = $this->input->post('salnotdis');

		}

		else {

			$saldsi = '0';

		}

				// GET CITY		

		$ip=$_SERVER['REMOTE_ADDR'];

		$addr_details = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));

		$city = stripslashes(ucfirst($addr_details['geoplugin_city']));

		$countrycode = stripslashes(ucfirst($addr_details['geoplugin_countryCode']));

		$countryip = stripslashes(ucfirst($addr_details['geoplugin_countryName']));

		$cityid = $this->input->post('cityname');

		$bencity = count($this->input->post('cityname'));

		if($bencity > 1){

		for($id=0;$id<$bencity;$id++):

			$bentcity .= $cityid[$id].",";

		endfor;

			$bentcity = substr($bentcity,0,-1);

		}

		else { $bentcity= $cityid[0];}

		if(isset($_POST['draftjob'])){

			$jobstatus = "0";

			$jdraft	= "1";

		}

		else {

			$jobstatus = "1";

			$jdraft	= "0";

		}

		$specia = $this->input->post('specialization');

		$speciac = count($this->input->post('specialization'));

		if($speciac > 1){

		for($id=0;$id<$speciac;$id++):

			$bspec .= $specia[$id].",";

		endfor;

			$bspec = substr($bspec,0,-1);

		}

		else { $bspec= $specia[0];}

		

		$data = array(

					'uID' 				=> UID,

					'jTitle' 			 => $this->input->post('jTitle'),

					'jURL' 			   => $jurl,

					'jCName' 			   => $compname,

					'jCInfo' 			   => $compinfo,

					'jCWeb' 			    => $compweb,

					'jCPerson' 			   => $compcperson,

					'jCPhone' 			   => $compphone,

					'jCAddress' 			   => $compaddress,

					//'jDepartment' 		=> $this->input->post('department'),

					'cID' 				=> $this->input->post('industry'),

					'jCareerLevel' 	   => $this->input->post('careerlevel'),

					'jExpLevel' 		  => $this->input->post('explevelmin'),

					'jExpLevelmax' 	   => $this->input->post('explevelmax'),

					'jVacancy' 		   => $this->input->post('vacancies'),

					'jNotDislosed' 		=> $discl,

					'jDescription' 	   => nl2br($this->input->post('jobDescp')),

					'jRequiredSkills' 	=> nl2br($this->input->post('reqSkilled')),

					'jQualification' 	 => $this->input->post('qualification'),

					'jSpecialization' 	 => $bspec,

					'jSkillKeyword' 	 => $this->input->post('skillkeyword'),

					'jNature' 			=> $this->input->post('jobtype'),

					'jShift' 			 => $this->input->post('jobshift'),

					'jRequiredTravel' 	=> $this->input->post('jobtravel'),

					'jGender' 			=> $this->input->post('jobGender'),

					'jStartSalary' 	   => $this->input->post('startsalary'),

					'jEndSalary' 		 => $this->input->post('endsalary'),

					'jCurrency' 		  => $this->input->post('jCurrency'),

					'jsalType' 		  => $this->input->post('jsalType'),

					'jSalHidden' 		  => $saldsi,

					'jBenefits' 		  => $benefit,

					'jCoutry' 		 	=> $this->input->post('jobLocation'),

					'jStateCity' 		 => $bentcity,

					//'jExpiry' 		 => date('Y-m-d', strtotime("+28 days")),

					'jExpiry' 			=> $this->input->post('jexpiry'),

					//'jAfterExpiry' 	 => $this->input->post('jobAfterExpiry'),

					'jCDisclose' 	     => $cdsi,

					'jEmailNotify' 	   => $this->input->post('jobNotify'),

					'jPostedDate' 		=> $datetime,

					'jJobCode' 		   => $randomcode,

					'jJobStatus' 		 => $jobstatus,

					'jDraft' 		  	 => $jdraft,

					'jJobIP' 		 	 => $_SERVER['REMOTE_ADDR'],

					'jDirect' 		    => $direct,

					'jDirectLink' 		=> $applyurl,

				);

			$this->front_model->add_query('dev_web_jobs',$data);

			

			if(isset($_POST['draftjob'])){

			} else {

				$condition22 = array('uID' => UID);

			$newadverts = ADVERTS-1;

			$data = array("uAdverts" => $newadverts);

			$this->front_model->update_query('dev_web_user',$data,$condition22);

			// SEND EMAIL TO USER

			$edata = $this->front_model->get_emails_data('job-posted-notification');

			$condition = array('uID' => UID);

			$usinfo =  $this->front_model->get_query_simple('*','dev_web_user',$condition);

			$userinfo = $usinfo->result_object();

			$this->load->library('email');

			$this->email->from($edata[0]->eEmail, TITLEWEB);

			$this->email->to($userinfo[0]->uEmail); 

									

			$replace = array("[WEBURL]","[JOBURL]","[USER]","[WEBTITLE]","[JOBTITLE]");

			$replacewith = array(WEBURL, $jurl, $userinfo[0]->uFname.' '.$userinfo[0]->uLname,TITLEWEB,$this->input->post('jTitle'));

			$str = str_replace($replace,$replacewith,$edata[0]->eContent);

			$message = $str;

			$this->email->subject($edata[0]->eName.' - : : - '.TITLEWEB);

			$this->email->message($message);

			$this->email->set_mailtype("html");

			$send = $this->email->send();



				// SEND EMAIL TO ALERTS INSTANT

			

			$jtitle = $this->input->post('jTitle');

			$til = str_replace(" ",",",$jtitle);

			$exp = explode(",",$til);

			for($t=0;$t<=count($exp)-1;$t++){

				$var .= "`jobTitle` LIKE '%".$exp[$t]."%' OR ";

				$var .= "`jobSkills` LIKE '%".$exp[$t]."%' OR ";

			}

				$query = substr($var,0,-3);

			$recommendedjob =  $this->front_model->sendInstantAlerts($query);

			foreach($recommendedjob as $alert):		

				$condition = array('uID' => $alert->uID);

				$usinfo =  $this->front_model->get_query_simple('*','dev_web_user',$condition);

				$userinfo = $usinfo->result_object();

				// SEND EMAIL TO USER

				$edata = $this->front_model->get_emails_data('instant-alerts-user');

				$this->load->library('email');

				$this->email->from($edata[0]->eEmail, TITLEWEB);

				$this->email->to($userinfo[0]->uEmail); 

										

				$replace = array("[WEBURL]","[USER]","[SALARY]","[JOBTYPE]","[JOBDETAILS]","[JOBAPPLYURL]","[JOBTITLE]");
				if($this->input->post('startsalary') == "0" || $this->input->post('startsalary') == ""){
					$asal = "$".$this->input->post('startsalary')."-".$this->input->post('endsalary');
				} else {
					$asal = "Not Disclosed";
				}
				
				$replacewith = array(WEBURL, $userinfo[0]->uFname.' '.$userinfo[0]->uLname,$asal,$this->input->post('jobtype'),$this->input->post('jobDescp'),"job/".$jurl."?apply=yes",$this->input->post('jTitle'));

				$str = str_replace($replace,$replacewith,$edata[0]->eContent);

				$message = $str;

				$this->email->subject($edata[0]->eSubject." ".$this->input->post('jTitle'));

				$this->email->message($message);

				$this->email->set_mailtype("html");

				$send = $this->email->send();

			endforeach;

			}

		if(isset($_POST['draftjob'])){

			$_SESSION['msglogin'] = 'Your job has been saved as draft!';

			header ( "Location:" . $this->config->base_url () . 'recruiter-posted-jobs' );

		} else {

			//$_SESSION['notify'] = 'New job added successfully!';

			header ( "Location:" . $this->config->base_url () . 'job/'.$jurl );

		}

	}

	

	public function post_draft_job_active()

	{

			$condition = array('jID' => $this->uri->segment(3));

			$usinfo =  $this->front_model->get_query_simple('*','dev_web_jobs',$condition);

			$jobsdata = $usinfo->result_object();

		

			$condition22 = array('uID' => $jobsdata[0]->uID);

			$newadverts = ADVERTS-1;

			$data = array("uAdverts" => $newadverts);

			$this->front_model->update_query('dev_web_user',$data,$condition22);

			

			$data = array("jDraft" => "0", "jJobStatus" => "1","jPostedDate" => date("Y-m-d"));

			$this->front_model->update_query('dev_web_jobs',$data,$condition);

			

			

			// SEND EMAIL TO USER

			$edata = $this->front_model->get_emails_data('job-posted-notification');

			$condition = array('uID' => UID);

			$usinfo =  $this->front_model->get_query_simple('*','dev_web_user',$condition);

			$userinfo = $usinfo->result_object();

			$this->load->library('email');

			$this->email->from($edata[0]->eEmail, TITLEWEB);

			$this->email->to($userinfo[0]->uEmail); 

									

			$replace = array("[WEBURL]","[JOBURL]","[USER]","[WEBTITLE]","[JOBTITLE]");

			$replacewith = array(WEBURL, $jurl, $userinfo[0]->uFname.' '.$userinfo[0]->uLname,TITLEWEB,$jobsdata[0]->jTitle);

			$str = str_replace($replace,$replacewith,$edata[0]->eContent);

			$message = $str;

			$this->email->subject($edata[0]->eName.' - : : - '.TITLEWEB);

			$this->email->message($message);

			$this->email->set_mailtype("html");

			$send = $this->email->send();



				// SEND EMAIL TO ALERTS INSTANT

			

			$jtitle = $jobsdata[0]->jTitle;

			$til = str_replace(" ",",",$jtitle);

			$exp = explode(",",$til);

			for($t=0;$t<=count($exp)-1;$t++){

				$var .= "`jobTitle` LIKE '%".$exp[$t]."%' OR ";

				$var .= "`jobSkills` LIKE '%".$exp[$t]."%' OR ";

			}

				$query = substr($var,0,-3);

			$recommendedjob =  $this->front_model->sendInstantAlerts($query);

			foreach($recommendedjob as $alert):		

				$condition = array('uID' => $alert->uID);

				$usinfo =  $this->front_model->get_query_simple('*','dev_web_user',$condition);

				$userinfo = $usinfo->result_object();

				// SEND EMAIL TO USER

				$edata = $this->front_model->get_emails_data('instant-alerts-user');

				$this->load->library('email');

				$this->email->from($edata[0]->eEmail, TITLEWEB);

				$this->email->to($userinfo[0]->uEmail); 

										

				$replace = array("[WEBURL]","[USER]","[SALARY]","[JOBTYPE]","[JOBDETAILS]","[JOBAPPLYURL]","[JOBTITLE]");

				$replacewith = array(WEBURL, $userinfo[0]->uFname.' '.$userinfo[0]->uLname,$jobsdata[0]->jCurrency.$jobsdata[0]->jStartSalary."-".$jobsdata[0]->jEndSalary,$jobsdata[0]->jNature,$jobsdata[0]->jDescription,"job/".$jobsdata[0]->jURL."?apply=yes",$jobsdata[0]->jTitle);

				$str = str_replace($replace,$replacewith,$edata[0]->eContent);

				$message = $str;

				$this->email->subject($edata[0]->eSubject." ".$jobsdata[0]->jTitle);

				$this->email->message($message);

				$this->email->set_mailtype("html");

				$send = $this->email->send();

			endforeach;

			header ( "Location:" . $this->config->base_url () . 'job/'.$jobsdata[0]->jURL );

	}

	// EDIT JOB

	

	public function edit_job_post_form_submit()

	{

		$randomcode = $this->generateRandomString();

		//$timezone = date_default_timezone_get();

		$datetime = date('Y-m-d');

		$id = $this->input->post('benefits');

		$ben = count($this->input->post('benefits'));

		if($ben > 0){

		for($i=0;$i<$ben;$i++):

			$bent .= $id[$i].",";

		endfor;

		$benefit = substr($bent,0,-1);

		}

		else { $benefit= '';}

		if($this->input->post('applyurl') != ""){

			$applyurl = $this->input->post('applyurl');

			$direct = 1; 

		}

		else { 

			$applyurl = "";

			$direct = 0; 

		}

		if($this->input->post('notdis') == "0"){

			$discl = $this->input->post('notdis');

		}

		else { $discl = "1";}

		$v = $this->input->post('sameinfo');

		if(isset($v)){

			$arrcinfo 		= array('uID' => UID);

			$configcinfo	 = $this->front_model->get_query_simple('*','dev_web_user',$arrcinfo);					

			$cinfo 		   = $configcinfo->result_object(); 

			$compname = $cinfo[0]->uCompany;

			$compinfo = $cinfo[0]->uAbout;

			$compweb = $cinfo[0]->uWebsite;

			$compcperson = $cinfo[0]->uFname." ".$cinfo[0]->uLname;

			$compphone = $cinfo[0]->uPhone;

			$compaddress = $cinfo[0]->uAddress;

		}

		else {

			$compname = $this->input->post('companyNamenew');

			$compinfo = $this->input->post('companydetailsnew');

			$compweb = $this->input->post('comwebsite');

			$compcperson = $this->input->post('contactperson');

			$compphone = $this->input->post('phonecom');

			$compaddress = $this->input->post('comAddress');

			

		}

		if($this->input->post('chkdisclose') == "0"){

			$cdsi = $this->input->post('chkdisclose');

		}

		else {

			$cdsi = '1';

		}

		if($this->input->post('salnotdis') == "1"){

			$saldsi = $this->input->post('salnotdis');

		}

		else {

			$saldsi = '0';

		}

		$cityid = $this->input->post('cityname');

		$bencity = count($this->input->post('cityname'));

		if($bencity > 1){

		for($id=0;$id<$bencity;$id++):

			$bentcity .= $cityid[$id].",";

		endfor;

			$bentcity = substr($bentcity,0,-1);

		}

		else { $bentcity= $this->input->post('cityname');}

		$specia = $this->input->post('specialization');

		$speciac = count($this->input->post('specialization'));

		if($speciac > 1){

		for($id=0;$id<$speciac;$id++):

			$bspec .= $specia[$id].",";

		endfor;

			$bspec = substr($bspec,0,-1);

		}

		else {$bspec= $specia[0];}

		$data = array(

					'jTitle' 			 => $this->input->post('jTitle'),

					'cID' 				=> $this->input->post('industry'),

					'jCName' 			   => $compname,

					'jCInfo' 			   => $compinfo,

					'jCWeb' 			    => $compweb,

					'jCPerson' 			   => $compcperson,

					'jCPhone' 			   => $compphone,

					'jCAddress' 			   => $compaddress,

					'jCareerLevel' 	   => $this->input->post('careerlevel'),

					'jExpLevel' 		  => $this->input->post('explevelmin'),

					'jExpLevelmax' 	   => $this->input->post('explevelmax'),

					'jVacancy' 		   => $this->input->post('vacancies'),

					'jNotDislosed' 		=> $discl,

					'jDescription' 	   => nl2br($this->input->post('jobDescp')),

					'jRequiredSkills' 	=> nl2br($this->input->post('reqSkilled')),

					'jQualification' 	 => $this->input->post('qualification'),

					'jSpecialization' 	 => $bspec,

					'jSkillKeyword' 	 => $this->input->post('skillkeyword'),

					'jNature' 			=> $this->input->post('jobtype'),

					'jShift' 			 => $this->input->post('jobshift'),

					'jRequiredTravel' 	=> $this->input->post('jobtravel'),

					'jGender' 			=> $this->input->post('jobGender'),

					'jStartSalary' 	   => $this->input->post('startsalary'),

					'jEndSalary' 		 => $this->input->post('endsalary'),

					'jCurrency' 		  => $this->input->post('jCurrency'),

					'jsalType' 		  => $this->input->post('jsalType'),

					'jSalHidden' 		  => $saldsi,

					'jBenefits' 		  => $benefit,

					'jCoutry' 		 	=> $this->input->post('jobLocation'),

					'jStateCity' 		 	=> $bentcity,

					//'jStateCity' 		 => '',

					'jCDisclose' 	     => $cdsi,

					'jEmailNotify' 	   => $this->input->post('jobNotify'),

					'jJobUpdated' 		=> $datetime,

					'jJobIP' 		 	=> $_SERVER['REMOTE_ADDR'],

					'jUpdate' 		 	=> 1,

					'jDirect' 		   => $direct,

					'jDirectLink' 		 => $applyurl,

				);

			$condition = array('jID' => $this->input->post('jID'));

			$this->front_model->update_query('dev_web_jobs',$data,$condition);

		

			$condition = array('jID' => $this->input->post('jID'));

			$usinfo =  $this->front_model->get_query_simple('jURL','dev_web_jobs',$condition);

			$jobs_list = $usinfo->result_object();

			header ( "Location:".$this->config->base_url().'job/'.$jobs_list[0]->jURL);

	}

	// RECRUITER POSTED JOBS

	public function recruiter_posted_jobs(){

		$this->load->view('frontend/recruiter_posted_jobs',$this->data);

	}

	// RECRUITER POSTED JOBS

	public function today_jobs_agents(){

		$this->load->view('frontend/today_jobs_agents',$this->data);

	}

	// DELETE POSTED JOB

	public function delete_user_job()

	{

		$data = array('jID' => $this->uri->segment(3));

		$this->front_model->delete_query('dev_web_jobs',$data);

		$_SESSION['msglogin'] = 'Job Deleted Successfully!';

		header ( "Location:" . $_SERVER['HTTP_REFERER']);

		//header ( "Location:".$this->config->base_url().'recruiter-posted-jobs');

	}

	// CHECKOUT PAGE

	public function checkout_page()

	{

		if(isset($_SESSION['JobsSessions']) && $_SESSION['JobsSessions'][0]->uActType == 1){

			unset($_SESSION['JobsSessions']);

			header ( "Location:".$this->config->base_url().'checkout');

		}

		else {

		$this->load->view('frontend/checkout_page',$this->data);

		}

	}

	

	// JOB APPLICANTS

	public function jobs_applicants()

	{

		if(!isset($_SESSION['JobsSessions'])){

			$this->load->view('frontend/login',$this->data);

		}

		else {

			if($_SESSION['JobsSessions'][0]->uActType == 2){

				$this->load->view('frontend/job_applicants_page',$this->data);

			}

			else {

				header ( "Location:".$this->config->base_url());

			}

		}

	}

	

	// CHNAGE STATUS

	public function change_status()

	{

		$data = array(

				'aStatus' 	=> $this->uri->segment(4),

			);

		$condition = array(

				'aID' 	=> $this->uri->segment(3),

			);

		$this->front_model->update_query('dev_web_applied',$data,$condition);

		

		$condition = array('aID' => $this->uri->segment(3));

		$usinfo =  $this->front_model->get_query_simple('*','dev_web_applied',$condition);

		$valuecat = $usinfo->result_object();



		$c2 = array('uID' => $valuecat[0]->uID);

		$us =  $this->front_model->get_query_simple('*','dev_web_user',$c2);

		$user = $us->result_object();

		

		$condition2 = array('cvID' => $valuecat[0]->cvID);

		$cv = $this->front_model->get_query_simple('*','dev_web_cv',$condition2);

		$cvd = $cv->result_object();

		// JOB DETAILS

		$condition4 = array('jID' => $valuecat[0]->jID);

		$ind4 = $this->front_model->get_query_simple('*','dev_web_jobs',$condition4);

		$jobs = $ind4->result_object();

		

		// IF SHORTLISTED

		if($this->uri->segment(4) == 1){

				$edata = $this->front_model->get_emails_data('job-shortlisted');

				$this->load->library('email');

				$this->email->from($edata[0]->eEmail, TITLEWEB);

				$this->email->to($user[0]->uEmail); 

				//echo $user[0]->uEmail; 

				$replace = array("[WEBURL]","[USER]","[JOB]");

				$replacewith = array(WEBURL, $user[0]->uFname." ".$user[0]->uLname,$jobs[0]->jTitle);

				$str = str_replace($replace,$replacewith,$edata[0]->eContent);

				$message = $str;

				$this->email->subject($edata[0]->eName);

				$this->email->message($message);

				$this->email->set_mailtype("html");

				$send = $this->email->send();

		}

		else if($this->uri->segment(4) == 2){

				$edata = $this->front_model->get_emails_data('job-rejection');

				$this->load->library('email');

				$this->email->from($edata[0]->eEmail, TITLEWEB);

				$this->email->to($user[0]->uEmail);

				

				$replace = array("[WEBURL]","[USER]","[JOB]");

				$replacewith = array(WEBURL, $user[0]->uFname." ".$user[0]->uLname,$jobs[0]->jTitle);

				$str = str_replace($replace,$replacewith,$edata[0]->eContent);

				$message = $str;

				$this->email->subject($edata[0]->eName);

				$this->email->message($message);

				$this->email->set_mailtype("html");

				$send = $this->email->send();

		}

		

		$_SESSION['msglogin'] = 'Job Applicant status updated successfully!';

		header ( "Location:" . $_SERVER['HTTP_REFERER']);

	}

	

	// MESSAGE POPUP BOX

	public function getmessage_box(){

		$c2 = array('uID' => $_REQUEST['val']);

		$us =  $this->front_model->get_query_simple('*','dev_web_user',$c2);

		$user = $us->result_object();

		

	?>

            <div class="sendto col-xs-12 nopad">

                        <span class="col-xs-2 nopad">Send To: </span> <p class="col-xs-8 nopad"><?php echo $user[0]->uFname; ?> <?php echo $user[0]->uLname; ?></p>

                            <input type="hidden" value="<?php echo $user[0]->uID; ?>" name="senderid" id="senderid" />

                            <div class="right">

                            <i class="fa fa-close left crossbx" id="closebx" onclick="closemsgbox()"></i>

                            </div>

                    </div>

            <div class="sendto col-xs-12 nopad">

            	<span class="col-xs-2 nopad">Message: </span> 

                	<p class="col-xs-10 nopad">

                    	<textarea name="messagesender" id="messagesender" class="textarea inputjob" placeholder="Please write your message here."></textarea>

                    </p>

                	

            </div>

            <div class="col-xs-12 nopad boxinput">

           		<button type="submit" name="signup" id="signupbtn" class="btn pink left" onclick="submitmessage()">Send Message</button>

          </div>

    <?php

	}

	

	public function sendmessage_sender(){

				$c2d = array('uID' => $_REQUEST['sid'],'sID' => UID,);

					$usdd =  $this->front_model->get_query_simple('*','dev_web_messages',$c2d);

					$chk = $usdd->num_rows();

					if($chk > 0){

						$msgd = $usdd->result_object();

						$cfirst = '0';$msgid = $msgd[0]->mID;} else { $cfirst = '1';$msgid = 0;} 

				$data = array(

						'sID' 	  	   => UID,

						'sMessage' 	  => $_REQUEST['message'],

						'uID' 	  	   => $_REQUEST['sid'],

						'mdID' 	  	   => $msgid,

						'mPosted' 	   => date("Y-m-d h:i:s"),

						'mFirst' 	  	=> $cfirst,

					);

					$this->front_model->add_query('dev_web_messages',$data);

					

					$c2 = array('uID' => $_REQUEST['sid']);

					$us =  $this->front_model->get_query_simple('*','dev_web_user',$c2);

					$user = $us->result_object();

					

					$edata = $this->front_model->get_emails_data('message-notification');

					$this->load->library('email');

					$this->email->from($edata[0]->eEmail, TITLEWEB);

					$this->email->to($user[0]->uEmail); 

					$replace = array("[WEBURL]","[USER]","[MESSAGE]","[COMPANY]");

					$replacewith = array(WEBURL, $user[0]->uFname." ".$user[0]->uLname,$_REQUEST['message'],FNAME." ".LNAME);

					$str = str_replace($replace,$replacewith,$edata[0]->eContent);

					$message = $str;

					$this->email->subject($edata[0]->eName);

					$this->email->message($message);

					$this->email->set_mailtype("html");

					$send = $this->email->send();

					echo '<div class="errormsg">Your message has been sent successfully!</div>';

			

	}

	

	// MESSAGE PAGE

	public function messages_page()

	{

		if(!isset($_SESSION['JobsSessions'])){

			$this->load->view('frontend/login',$this->data);

		}

		else {

			$this->load->view('frontend/message_page',$this->data);

		}

	}

	// MESSAGE DETAILS PAGE

	public function messages_details()

	{

		if(!isset($_SESSION['JobsSessions'])){

			$this->load->view('frontend/login',$this->data);

		}

		else {

			$this->load->view('frontend/message_detail_page',$this->data);

		}

	}

	// MESSAGE ALL GET

	public function message_get_data()

	{

		error_reporting(0);

		$condition2 = array('mID' => $_REQUEST['mID']);

		$msgrow2 = $this->front_model->get_query_simple('*','dev_web_messages',$condition2);

		$messages2 = $msgrow2->result_object();

		if($messages2[0]->sID == UID){$class2='right arrow_box';}else {$class2='left arrow_left'; }

		

		$condition = array('mdID' => $_REQUEST['mID']);

		$msgrow = $this->front_model->get_query_simple('*','dev_web_messages',$condition);

		$messages = $msgrow->result_object();		

		?>

        	<div class="msg">

            <div class="<?php echo $class2;?>">

            	<?php echo $messages2[0]->sMessage;?>

                <?php //echo '<small>'.$messages2[0]->mPosted.'</small>';?>

               </div>

            </div>   

            	<?php   foreach($messages as $msg):

							if($msg->sID == UID){$class='right arrow_box';}else {$class='left arrow_left'; }

							echo '<div class="msg">';

							echo '<div class="'.$class.'">';

							echo $msg->sMessage;

							//echo '<small>'.$msg->mPosted.'</small>';

							echo '</div>';

							echo '</div>';

						endforeach;

	}

	public function sendmessage_inbox(){

				$data = array(

						'sID' 	  	   => UID,

						'sMessage' 	  => $_REQUEST['message'],

						'uID' 	  	   => $_REQUEST['sid'],

						'mdID' 	  	   => $_REQUEST['mid'],

						'mPosted' 	   => date("Y-m-d h:i:s"),

						'mFirst' 	  	=> 0,

					);

					$this->front_model->add_query('dev_web_messages',$data);

					

					$c2 = array('uID' => $_REQUEST['sid']);

					$us =  $this->front_model->get_query_simple('*','dev_web_user',$c2);

					$user = $us->result_object();

					

					$edata = $this->front_model->get_emails_data('message-notification');

					$this->load->library('email');

					$this->email->from($edata[0]->eEmail, TITLEWEB);

					$this->email->to($user[0]->uEmail);

					//$user[0]->uEmail; 

					$replace = array("[WEBURL]","[USER]","[MESSAGE]","[COMPANY]");

					$replacewith = array(WEBURL, $user[0]->uFname." ".$user[0]->uLname,$_REQUEST['message'],FNAME." ".LNAME);

					$str = str_replace($replace,$replacewith,$edata[0]->eContent);

					$message = $str;

					$this->email->subject($edata[0]->eName);

					$this->email->message($message);

					$this->email->set_mailtype("html");

					$send = $this->email->send();

	}

	// REMOVE CV

	public function removeCv()

	{

		if(isset($_SESSION['JobsSessions'])){

		$c2 = array('uID' => UID);

		$us =  $this->front_model->get_query_simple('*','dev_web_user',$c2);

		$user = $us->result_object();



		if(md5($this->input->post('userpass')) == $user[0]->uPassword){

		$c2 = array('cvID' => $this->input->post('cvID'));

		$this->front_model->delete_query('dev_web_cv',$c2);

		//$_SESSION['msglogin'] = 'Your Cv & information has been removed successfully!';

		header ( "Location:" . $_SERVER['HTTP_REFERER']);

		}

		else {

			$_SESSION['msglogin'] = 'Invalid Password! Please provide correct password to delete your cv';

			header ( "Location:" . $_SERVER['HTTP_REFERER']);

		}

		} else {

			header ( "Location:" . $this->config->base_url () ."login");

		}

	}

	// PROCESS ON REGISTRATION

	public function process_order_payment(){

		require_once('PPBootStrap.php');

		$p_price = $_REQUEST['price'];

		$p_currency = 'USD';

		$p_name = $_REQUEST['productname'];

		$firstName = $_REQUEST['firstname'];

		$lastName = $_REQUEST['lastname'];



		$address = new AddressType();

		$address->Name = $_REQUEST['firstname']." ".$_REQUEST['lastname'];

		$address->Street1 = $_REQUEST['address1'];

		$address->Street2 = $_REQUEST['street'];

		$address->CityName = $_REQUEST['citystate'];

		$address->StateOrProvince = "";

		$address->PostalCode = $_REQUEST['zipcode'];

		$address->Country = $_REQUEST['country'];

		$address->Phone = "";



		$orderTotal = new BasicAmountType();

		$orderTotal->currencyID = $p_currency;

		$orderTotal->value = $p_price;

		

		$paymentDetails = new PaymentDetailsType();

		$paymentDetails->ShipToAddress = $address;

		

		$itemDetails = new PaymentDetailsItemType();

		$itemDetails->Name = $p_name;

		

		$itemDetails->Amount = $orderTotal;

		$itemDetails->Quantity = '1';



		$itemDetails->ItemCategory = 'Physical';

		

		$paymentDetails->PaymentDetailsItem[0] = $itemDetails;

		$paymentDetails->OrderTotal = $orderTotal;

		if (isset($_REQUEST['notifyURL'])) {

			$paymentDetails->NotifyURL = $_REQUEST['notifyURL'];

		}



		$personName = new PersonNameType();

		$personName->FirstName = $firstName;

		$personName->LastName = $lastName;



		$payer = new PayerInfoType();

		$payer->PayerName = $_REQUEST['creditname'];

		$payer->Address = $address;

		$payer->PayerCountry = $_REQUEST['country'];



		$cardDetails = new CreditCardDetailsType();

		$cardDetails->CreditCardNumber = $_REQUEST['cardNumber'];

		$cardDetails->CreditCardType = "Visa";

		$cardDetails->ExpMonth = $_REQUEST['month'];

		$cardDetails->ExpYear = $_REQUEST['year'];

		$cardDetails->CVV2 = $_REQUEST['cvcode'];

		$cardDetails->CardOwner = $payer;

		

		$ddReqDetails = new DoDirectPaymentRequestDetailsType();

		$ddReqDetails->CreditCard = $cardDetails;

		$ddReqDetails->PaymentDetails = $paymentDetails;

		$ddReqDetails->PaymentAction = "Sale";



		$doDirectPaymentReq = new DoDirectPaymentReq();

		$doDirectPaymentReq->DoDirectPaymentRequest = new DoDirectPaymentRequestType($ddReqDetails);

		$paypalService = new PayPalAPIInterfaceServiceService(Configuration::getAcctAndConfig());

		try {

			$datashow = $this->front_model->check_email_user($this->input->post('emailaddpay'));

			if($datashow > 0)

			{	

				echo "0";

				die;

			}

			else

			{

					$doDirectPaymentResponse = $paypalService->DoDirectPayment($doDirectPaymentReq);

					if ($doDirectPaymentResponse->Ack == 'Success' || $doDirectPaymentResponse->Ack == 'SuccessWithWarning') {		

						

					$securitycode = $this->generateSecurityCode();

					$username = explode("@",$_REQUEST['emailaddpay']);

					$rendomcode = $this->generateRandomString();

					if(isset($_SESSION['sessionCart'])){

						$enddate = date('Y-m-d', strtotime("+28 days"));

					} 

					else {

						$enddate = '';

					}

					if(isset($_SESSION['sessionCartCandidate']))

					{

						$enddatecandi = date('Y-m-d', strtotime("+".$_REQUEST['candidatesearbox']." days"));

					}

					else {

						$enddatecandi = '';

					}

					$data = array(

								'uFname' 	   => $_REQUEST['firstname'],

								'uLname' 	   => $_REQUEST['lastname'],

								'uEmail' 	   => $_REQUEST['emailaddpay'],

								'uUsername' 	=> $username[0].$this->generateSecurityCode(),

								'uPassword' 	=> md5($_REQUEST['passwordlogin']),

								'uCompany' 	 => $_REQUEST['companyName'],

								'uGender' 	  => "Male",

								'uCountry' 	 => $_REQUEST['country'],

								'uAddress' 	 => $_REQUEST['address1']." ".$_REQUEST['street'],

								'uCity' 		=> $_REQUEST['citystate'],

								'uZip' 	 	 => $_REQUEST['zipcode'],

								'uAdverts' 	 => $_REQUEST['advertsbox'],

								'uCanSearch'   => $_REQUEST['candidatesearbox'],

								'uActType' 	 => 2,

								'uStatus' 	  => 1,

								'uPayment' 	 => 1,

								'joinDate' 	 => date('Y-m-d h:i:s'),

								'endDate' 	  => $enddate,

								'uCode' 		=> $rendomcode,

								'uReCode' 	  => $securitycode,

								'uIP' 		  => $_SERVER['REMOTE_ADDR'],

								'uLoginLast'   => date("Y-m-d h:i:s"),

								'endDateCandidate' => $enddatecandi,

							);

						$uID = $this->front_model->add_query('dev_web_user',$data);

						// INSERT RECORD INTO ORDERS

						$data = array(

						'uID' 		   => $uID,

						'uAdverts' 	  => $_REQUEST['advertsbox'],

						'uCandi' 		=> $_REQUEST['candidatesearbox'],

						'uPrice' 		=> $_REQUEST['price'],

						'transActionID' => $doDirectPaymentResponse->TransactionID,

						'uStatus' 	   => 1,

						);

						$this->front_model->add_query('dev_web_order',$data);

						

						// SEND EMAIL CONFIRMATION

						$edata = $this->front_model->get_emails_data('account-confirmation-recruiter');

						$this->load->library('email');

						$this->email->from($edata[0]->eEmail, TITLEWEB);

						$this->email->to($_REQUEST['emailaddpay']); 

						$replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]","[SECURITYCODE]","[USERTYPE]");

						$replacewith = array(WEBURL, $rendomcode, $_REQUEST['firstname']." ".$_REQUEST['lastname'],TITLEWEB,$_REQUEST['emailaddpay'],$_REQUEST['passwordlogin'],$securitycode,"RECRUITER");

						$str = str_replace($replace,$replacewith,$edata[0]->eContent);

						$message = $str;

						$this->email->subject($edata[0]->eName);

						$this->email->message($message);

						$this->email->set_mailtype("html");

						$send = $this->email->send();

						// DO LOGIN			

						$arr = array(

							'uEmail'	=>	$_REQUEST['emailaddpay'],

							'uPassword' =>	md5($_REQUEST['passwordlogin']),

							'uReCode'   =>	$securitycode,

						);

						$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

						$count = $datashow->num_rows();

						unset($_SESSION['JobsSessions']);

						$row = $datashow->result_object();

						$_SESSION['JobsSessions'] = $row;

					

					echo "<div class='successmessage'>";

					echo "<h3 id='success'>Payment Successful</h3>";

					echo "<P>Amount -" . $doDirectPaymentResponse->Amount->value . 

					     	"(".$doDirectPaymentResponse->Amount->currencyID.")

						 </P>";

					echo "<P>Transaction ID -" . $doDirectPaymentResponse->TransactionID . "</P>";

					

					echo '<a href="'.base_url().'dashboard"><button name="signup" class="btn green" style="border-radius: 23px;">Go to Dashboard</button></a>';

					echo '</div>';

					unset($_SESSION['sessionCart']);

					unset($_SESSION['sessionCartCandidate']);

					}

					else 

					{

						

					echo "<div class='successmessage'>";

					echo "<h3 id='fail'>Payment - Failed</h3>";

					echo '<p>Error msg - This transaction cannot be processed. 

						  <br>Please enter a valid credit card number & type.</p>';

					echo '<a href="'.base_url().'dashboard"><button name="signup" class="btn green" style="border-radius: 23px;">Go to Dashboard</button></a>';

					echo '</div>';

				

					}

			}

			

		} catch (Exception $ex) {

			include_once("Error.php");

			exit;

		}

	}

	

	// PROCESS IF LOGGEIN ALREADY THERE

	public function process_order_payment_login_after(){

		//error_reporting(-1);

		ini_set('max_execution_time', 0);

		

		require_once('PPBootStrap.php');

		$p_price = $_REQUEST['price'];

		$p_currency = 'USD';

		$p_name = $_REQUEST['productname'];

		$firstName = $_REQUEST['firstname'];

		$lastName = $_REQUEST['lastname'];



		$address = new AddressType();

		$address->Name = $_REQUEST['firstname']." ".$_REQUEST['lastname'];

		$address->Street1 = $_REQUEST['address1'];

		$address->Street2 = $_REQUEST['street'];

		$address->CityName = $_REQUEST['citystate'];

		$address->StateOrProvince = "";

		$address->PostalCode = $_REQUEST['zipcode'];

		$address->Country = $_REQUEST['countrybilling'];

		$address->Phone = "";



		$orderTotal = new BasicAmountType();

		$orderTotal->currencyID = $p_currency;

		$orderTotal->value = $p_price;

		

		$paymentDetails = new PaymentDetailsType();

		$paymentDetails->ShipToAddress = $address;

		

		$itemDetails = new PaymentDetailsItemType();

		$itemDetails->Name = $p_name;

		

		$itemDetails->Amount = $orderTotal;

		$itemDetails->Quantity = '1';



		$itemDetails->ItemCategory = 'Physical';

		

		$paymentDetails->PaymentDetailsItem[0] = $itemDetails;

		$paymentDetails->OrderTotal = $orderTotal;

		if (isset($_REQUEST['notifyURL'])) {

			$paymentDetails->NotifyURL = $_REQUEST['notifyURL'];

		}



		$personName = new PersonNameType();

		$personName->FirstName = $firstName;

		$personName->LastName = $lastName;



		$payer = new PayerInfoType();

		$payer->PayerName = $_REQUEST['creditname'];

		$payer->Address = $address;

		$payer->PayerCountry = $_REQUEST['country'];



		$cardDetails = new CreditCardDetailsType();

		$cardDetails->CreditCardNumber = $_REQUEST['cardNumber'];

		$cardDetails->CreditCardType = "Visa";

		$cardDetails->ExpMonth = $_REQUEST['month'];

		$cardDetails->ExpYear = $_REQUEST['year'];

		$cardDetails->CVV2 = $_REQUEST['cvcode'];

		$cardDetails->CardOwner = $payer;

		

		$ddReqDetails = new DoDirectPaymentRequestDetailsType();

		$ddReqDetails->CreditCard = $cardDetails;

		$ddReqDetails->PaymentDetails = $paymentDetails;

		$ddReqDetails->PaymentAction = "Sale";



		$doDirectPaymentReq = new DoDirectPaymentReq();

		$doDirectPaymentReq->DoDirectPaymentRequest = new DoDirectPaymentRequestType($ddReqDetails);

		$paypalService = new PayPalAPIInterfaceServiceService(Configuration::getAcctAndConfig());

		try {

					$doDirectPaymentResponse = $paypalService->DoDirectPayment($doDirectPaymentReq);

					if ($doDirectPaymentResponse->Ack == 'Success' || $doDirectPaymentResponse->Ack == 'SuccessWithWarning') {		

						

						$_SESSION['datapayment']['adverts'] = $_REQUEST['advertsbox'];

						$_SESSION['datapayment']['candidate'] = $_REQUEST['candidatesearbox'];

						$_SESSION['datapayment']['price'] = $_REQUEST['price'];

						$_SESSION['datapayment']['transaction'] =$doDirectPaymentResponse->TransactionID;

						unset($_SESSION['coponcodeses']);

						echo "1";	

					}

					else 

					{

					echo "<div class='successmessage'>";

					echo "<h3 id='fail'>Payment - Failed</h3>";

					echo '<p>Error msg - This transaction cannot be processed. 

						  <br>Please enter a valid credit card number & type.</p>';

						  echo '<a href="'.base_url().'dashboard"><button name="signup" class="btn green" style="border-radius: 23px;">Go to Dashboard</button></a>';

					echo '</div>';

				

					}

			

		} catch (Exception $ex) {

			include_once("Error.php");

			exit;

		}

	

	}

	// AFTER SUCCESS OF PAYMENT ADD RECORDS IN DATABASE

	public function payment_success_action(){

			$securitycode = $this->generateSecurityCode();

			$rendomcode = $this->generateRandomString();

			if(isset($_SESSION['sessionCart'])){

				$enddate = date('Y-m-d', strtotime("+28 days"));

			} 

			else {

				$enddate = ENDATE;

			}

			if(isset($_SESSION['sessionCartCandidate']))

			{

				$enddatecandi = date('Y-m-d', strtotime("+".$_SESSION['datapayment']['candidate']." days"));

			}

			else {

				$enddatecandi = CANDIENDDATE;

			}

			

			$data = array(

				'uAdverts' 	 => ADVERTS + $_SESSION['datapayment']['adverts'],

				'uCanSearch'   => CANDIDATE + $_SESSION['datapayment']['candidate'],

				'endDate' 	  => $enddate,

				'endDateCandidate' => $enddatecandi,

			);

			$condition = array(

				'uID' 	 => UID,

			);

			$uID = $this->front_model->update_query('dev_web_user',$data,$condition);

			// INSERT RECORD INTO ORDERS

			$data = array(

			'uID' 		   => UID,

			'uAdverts' 	  => $_SESSION['datapayment']['adverts'],

			'uCandi' 		=> $_SESSION['datapayment']['candidate'],

			'uPrice' 		=> $_SESSION['datapayment']['price'],

			'transActionID' => $_SESSION['datapayment']['transaction'],

			'uStatus' 	   => 1,

			);

			$this->front_model->add_query('dev_web_order',$data);

			

			// SEND PAYMENT CONFIRMATION

			$edata = $this->front_model->get_emails_data('payment-confirmation-success');			

			$this->load->library('email');

			$this->email->from($edata[0]->eEmail, TITLEWEB);

			$this->email->to(EMAIL); 

			

			$replace = array("[WEBURL]","[TRANSACTION]","[WEBTITLE]","[PRICE]","[USER]");

			$replacewith = array(WEBURL, $_SESSION['datapayment']['transaction'],TITLEWEB,"$".$_SESSION['datapayment']['price'],FNAME);

			$str = str_replace($replace,$replacewith,$edata[0]->eContent);

			$message = $str;

			$this->email->subject($edata[0]->eName.' - : : - '.TITLEWEB);

			$this->email->message($message);

			$this->email->set_mailtype("html");

			$send = $this->email->send();

			

			unset($_SESSION['datapayment']);	

			unset($_SESSION['sessionCart']);

			unset($_SESSION['sessionCartCandidate']);

			

			// DELETE DISCOUNT COUPON

			$data = array(

				'cpCode' 		=> $_SESSION['copondata'],

			);

			$this->front_model->delete_query('dev_web_coupon',$data);

			unset($_SESSION['copondata']);

			$_SESSION['msglogin'] = 'Payment confirmation email has been sent on your registered email address!';

			header ( "Location:" . $this->config->base_url () ."dashboard");

	}

	// FORGOT PASWOR AND SECRUITY RECRUITER

	public function jobsite_forgotpass_recruiter()

	{

		$arr = array('uEmail' => $this->input->post('forgotemail'), 'uActType' => '2');

		$config 	= $this->front_model->get_query_simple('*','dev_web_user',$arr);

		$ret = $config->num_rows();

		//$ret = $this->front_model->check_frogot_password($this->input->post('forgotemail'));

		if($ret == 0)

		{

			$_SESSION['msglogin'] = 'Your provided email address is not valid!';

			header ( "Location:" . $_SERVER['HTTP_REFERER']);

			//header ( "Location:" . $this->config->base_url () . 'recruiter-login?error=forgot');

		}

		else

		{

			$userrec = $config->result_object();

			$rendomcode = $this->generateRandomString();

			$this->front_model->update_password_checl($this->input->post('forgotemail'),md5($rendomcode));

				// SEND EMAIL CONFIRMATION

				$edata = $this->front_model->get_emails_data('forgot-password-recruiter');

				

				$this->load->library('email');

				$this->email->from($edata[0]->eEmail, TITLEWEB);

				$this->email->to($_REQUEST['forgotemail']); 

				

				$replace = array("[WEBURL]","[CODE]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]","[SECURITY]","[USER]");

				$replacewith = array(WEBURL, $rendomcode,TITLEWEB,$this->input->post('forgotemail'),$rendomcode,$userrec[0]->uReCode,$userrec[0]->uFname." ".$userrec[0]->uLname);

				$str = str_replace($replace,$replacewith,$edata[0]->eContent);

				$message = $str;

				$this->email->subject($edata[0]->eName.' - : : - '.TITLEWEB);

				$this->email->message($message);

				$this->email->set_mailtype("html");

				$send = $this->email->send();

				$_SESSION['msglogin'] = 'Your temporaray password and secruity code has been sent to your registered email address!';

				//header ( "Location:" . $this->config->base_url () . 'recruiter-login');

				header ( "Location:" . $_SERVER['HTTP_REFERER']);

		}

	}

	

	// 1-APPLY 

	public function oneclick_apply()

	{

		$cvd2 = array('uID' => UID);

		$uscv =  $this->front_model->get_query_simple('*','dev_web_cv',$cvd2);

		$usercv = $uscv->num_rows();

		if($usercv == 0){

				$_SESSION['msglogin'] = "Please upload your cv first to apply for job!";

				header ( "Location:" . $this->input->post('retURL'));

		}

		else {

				$cvid = $uscv->result_object();

				$ref = $this->generateRandomString()."-".$this->generateRandomString();

				$data = array(

						'jID' 		  	   	  => $this->input->post('jID'),

						'uID' 		  	   	  => UID,

						'cvID' 		   		 => $cvid[0]->cvID,

						'cvrID' 		   		=> 0,

						'aAuthorized' 		  => "Yes",

						'appliedDate' 		  => date("Y-m-d"),

						'refrenceApplied' 	  => $ref,

					);

					$this->front_model->add_query('dev_web_applied',$data);

					

				$c2 = array('uID' => UID);

				$us =  $this->front_model->get_query_simple('*','dev_web_user',$c2);

				$user = $us->result_object();

				// JOB DETAILS

				$condition4 = array('jID' => $this->input->post('jID'));

				$ind4 = $this->front_model->get_query_simple('*','dev_web_jobs',$condition4);

				$jobs = $ind4->result_object();

				

				$c2dd = array('uID' => $jobs[0]->uID);

				$usdcom =  $this->front_model->get_query_simple('*','dev_web_user',$c2dd);

				$comp = $usdcom->result_object();

				// EMAIL TO USER

				$edata = $this->front_model->get_emails_data('job-confirmation-notification');

				$this->load->library('email');

				$this->email->from($edata[0]->eEmail, TITLEWEB);

				$this->email->to($user[0]->uEmail); 

				$replace = array("[WEBURL]","[USER]","[JOB]","[REFERENCE]","[COMPANY]");

				$replacewith = array(WEBURL, $user[0]->uFname." ".$user[0]->uLname,$jobs[0]->jTitle,$ref,$comp[0]->uFname." ".$comp[0]->uLname);

				$str = str_replace($replace,$replacewith,$edata[0]->eContent);

				$message = $str;

				$this->email->subject($edata[0]->eName);

				$this->email->message($message);

				$this->email->set_mailtype("html");

				$send = $this->email->send();

				// EMAIL to COMPANY

				if($jobs[0]->jEmailNotify == 1){

					$edata = $this->front_model->get_emails_data('job-app-notification');

					$this->load->library('email');

					$this->email->from($edata[0]->eEmail, TITLEWEB);

					$this->email->to($comp[0]->uEmail); 

					//echo $comp[0]->uEmail;

					$replace = array("[WEBURL]","[USER]","[JOB]","[REFERENCE]","[COMPANY]");

					$replacewith = array(WEBURL, $user[0]->uFname." ".$user[0]->uLname,$jobs[0]->jTitle,$ref,$comp[0]->uFname." ".$comp[0]->uLname);

					$str = str_replace($replace,$replacewith,$edata[0]->eContent);

					$message = $str;

					$this->email->subject($edata[0]->eName);

					$this->email->message($message);

					$this->email->set_mailtype("html");

					$send = $this->email->send();

				}

				//die;

					$_SESSION['msglogin'] = "You have applied for this job successfully!";

					header ( "Location:" . $this->input->post('retURL'));

		}

	

	}

	// REFINE SEARCH

	public function refine_search_advance()

	{

		$_SESSION['refinesearch'] = $_POST;

		header ( "Location:" . $this->config->base_url () ."advance-job-search");

	}

	

	// ADVANCE JOB SEARCH

	public function advance_job_search()

	{

		$this->data['jobsadvance'] = $this->front_model->search_job_advance($_SESSION['refinesearch']['category'],$_SESSION['refinesearch']['experience'],$_SESSION['refinesearch']['minsalary'],$_SESSION['refinesearch']['maxsalary'],$_SESSION['refinesearch']['jobType']);

		$this->load->view('frontend/advance_search_page',$this->data);

	}

	// SEARCH CANDIDATE ACTION

	public function search_canidate_action() {

		//$_SESSION['cansearchsession']

		$records = $this->front_model->search_candidate_cvs($this->input->post('searchbyname'),$this->input->post('searchbyjobtile'),$this->input->post('searchbylocation'),$this->input->post('searchbyjobtype'),$this->input->post('searchbysalary'));

		$_SESSION['cansearchsession'] = $records;

		header ( "Location:" . $this->config->base_url () ."candidate-search");

	}

	// DOWNLOAD CV

	public function cv_download_action_redirect()

	{

		header ( "Location:" . $this->config->base_url () ."candidate-search");

		die;	

	}

	public function cv_download_action()

	{

		if($this->uri->segment(2) == ""){

			header ( "Location:" . $this->config->base_url () ."candidate-search");

		} else {

			if(CANDIDATE == 0){

				header ( "Location:" . $this->config->base_url () ."candidate-search");

			}

			else {

					$data = array(

						'uID' 		=> UID,

						'ucView' 	 => 1,

						'cvviewDate' 	 => date("Y-m-d"),

						'cvID' 		=> $this->uri->segment(2),

					);

					$this->front_model->add_query('dev_cv_viewed',$data);

					

					$arr = array('cvID'	=>	$this->uri->segment(2),);

					$cvdatadd = $this->front_model->get_query_simple('*','dev_web_cv',$arr);

					$cvdata 	= $cvdatadd->result_object();

					// Fetch the file info.

					$filePath = 'resources/uploads/resume/'.$cvdata[0]->cvFile;

				

					if(file_exists($filePath)) {

						$fileName = basename($filePath);

						$fileSize = filesize($filePath);

				

						// Output headers.

						header("Cache-Control: private");

						header("Content-Type: application/stream");

						header("Content-Length: ".$fileSize);

						header("Content-Disposition: attachment; filename=".$fileName);

						// Output file.

						readfile ($filePath);                   

						exit();

					}

					else {

						die('The provided file path is not valid.');

					}

					

			}

		}

	}

	

	// COMPANY PROFILE PAGE

	public function company_profile_page()

	{

		if(isset($_SESSION['JobsSessions']) && $_SESSION['JobsSessions'][0]->uActType == "2"){

		$this->load->view('frontend/company_profile',$this->data);

		}

		else {

			$this->load->view('frontend/login_recruiter',$this->data);

		}

	}

	// COMPANY PROFILE

	public function company_profile_user_null()

	{

		header( "Location:" . $_SERVER['HTTP_REFERER']);

	}

	// UPDATE COMPANY PROFILE

	public function update_company()

	{

			$data = array(

				'uPhone' 		  => trim($this->input->post('phone')),

				'uNoEmp' 		  => trim($this->input->post('employesnum')),

				'uAddress' 		=> trim($this->input->post('address')),

				'uWebsite' 		=> $this->input->post('website'),

				'uAbout' 		  => $this->input->post('companyinfo'),

				'SICCODE' 	 	 => $this->input->post('compsic'),

				'uBusinessType'   => $this->input->post('compbustype'),

				'uFax' 		    => $this->input->post('compfax'),

			);

			

			$condition = array('uID' => UID);

			$this->front_model->update_query('dev_web_user',$data,$condition);

			$_SESSION['msglogin'] = "Company Information Updated Successfully!";

			header ( "Location:" . $this->config->base_url ()."company-profile");

	}

	// COMPANY PROFILE FOR USER TO DISPLAY

	public function company_profile_user()

	{

		$this->load->view('frontend/company_profile_user',$this->data);

	}

	// CV VIEWED

	public function recruiter_viewed_cv()

	{

		if(isset($_SESSION['JobsSessions']) && $_SESSION['JobsSessions'][0]->uActType == "2"){

		$this->load->view('frontend/cv_viewed',$this->data);

		}

		else {

			$this->load->view('frontend/login_recruiter',$this->data);

		}

	}

	// SHARE JOB BY EMAIL

	public function share_job_email()

	{

		// SEND EMAIL CONFIRMATION

		$edata = $this->front_model->get_emails_data('share-job-email');

		$this->load->library('email');

		$this->email->from($this->input->post('myemailadd'), TITLEWEB);

		$this->email->to($this->input->post('friendemail')); 

		$replace = array("[WEBURL]","[EMAILFRIEND]","[MESSAGE]","[JOBLINK]");

		$replacewith = array(WEBURL, $this->input->post('friendemail'), $this->input->post('messagefriend'),$this->input->post('retURL'));

		$str = str_replace($replace,$replacewith,$edata[0]->eContent);

		$message = $str;

		$this->email->subject($edata[0]->eName);

		$this->email->message($message);

		$this->email->set_mailtype("html");

		$send = $this->email->send();



		$_SESSION['msglogin'] = "Email to your friend has been sent successfully!";

		header ( "Location:" . $this->input->post('retURL'));		

	}

	

	// MANAGE JOB ALERTS

	public function manage_job_alerts()

	{

		if(isset($_SESSION['JobsSessions']) && $_SESSION['JobsSessions'][0]->uActType == "1"){

		$this->load->view('frontend/job_alerts_jobseeker',$this->data);

		}

		else {

		$this->load->view('frontend/login',$this->data);

		}

	}

	// ALERTS SUBMIT

	public function alerts_submit()
	{

		if($this->input->post('jobInstant') == "1"){

			$discl = $this->input->post('jobInstant');

		}

		else { $discl = "0";}

		$arr2 = array('uID' => UID);

		$config2 = $this->front_model->get_query_simple('*','dev_job_alerts',$arr2);

		$user 	= $config2->num_rows();

		if($user > 0){

				$data = array(

					'jobTitle' 	   => str_replace(" ",",",$this->input->post('jobtitle')),

					'jobSkills' 	  => str_replace(" ",",",$this->input->post('skills')),

					'jobNature' 	  => $this->input->post('jobType'),

					'jobStatus' 	  => 1,

					'jobInstant' 	 => $discl,

				);

				$condition = array('jaID' => $this->input->post('aID'));

				$this->front_model->update_query('dev_job_alerts',$data,$condition);

		} else {

				$data = array(

						'uID' 	  	 	=> UID,

						'jobTitle' 	   => str_replace(" ",",",$this->input->post('jobtitle')),

						'jobSkills' 	  => str_replace(" ",",",$this->input->post('skills')),

						//'jobLocation' 	=> $this->input->post('desiredloc'),

						'jobNature' 	  => $this->input->post('jobType'),

						'jobStatus' 	  => 1,

						'jobInstant' 	 => $discl,

					);

				$this->front_model->add_query('dev_job_alerts',$data);

		}

		$_SESSION['msglogin'] = "Information updated successfully!";

		header ( "Location:" . $_SERVER['HTTP_REFERER']);

	}

	

	// Jobsite Weekly Job Alert

	public function weekly_job_hunting()

	{

		$arr2 = array('uActType' => 2);

		$config2 = $this->front_model->get_query_simple('*','dev_web_user',$arr2);

		$userun 	= $config2->result_object();

		foreach($userun as $user):

			$today = date("Y-m-d");

			$lastvisit = date("d",(strtotime(date("Y-m-d"))-strtotime(date("Y-m-d",strtotime($user->uLoginLast)))));

			// CV DOWNLOADS

			$lastdate = date('Y-m-d', strtotime("-6 days"));

			$countcvview = $this->front_model->last7dayalerts($lastdate,$today,$user->uID);

			$countjobsaved = $this->front_model->last7savedjobs($lastdate,$today,$user->uID);

			$countposted = $this->front_model->last7jobsposted($lastdate,$today,$user->uID);

			

			$cond = array('uID' => $user->uID);

			$jobs = $this->front_model->get_query_simple('*','dev_web_jobs',$cond);

			$jobsdata = $jobs->result_object();

			foreach($jobsdata as $jdata):

			$counapplicants += $this->front_model->last7applicants($lastdate,$today,$jdata->jID);

			endforeach;

		// SEND EMAIL CONFIRMATION

		$edata = $this->front_model->get_emails_data('weekly-job-hunting');

		$this->load->library('email');

		$this->email->from("info@jobsrope.com", TITLEWEB);

		$this->email->to($user->uEmail); 

		$replace = array("[WEBTITLE]","[WEBURL]","[LASTVISIT]","[CVDOWNLOAD]","[SAVED JOB]","[JOBPOSTED]","[APPLICATION]");

		$replacewith = array("JobsRope", WEBURL, $lastvisit-1, $countcvview,$countjobsaved,$countposted,$counapplicants);

		$str = str_replace($replace,$replacewith,$edata[0]->eContent);

		$message = $str;

		$this->email->subject($user->uFname.", ".$edata[0]->eName);

		$this->email->message($message);

		$this->email->set_mailtype("html");

		$send = $this->email->send();

		endforeach;

	

		echo "Email Sent";

	}

	

	// JOBSITE WEEKLY HUNTING JOBSEEKER

	public function weekly_job_hunting_jobseeker()

	{

		$arr2 = array('uActType' => 1);

		$config2 = $this->front_model->get_query_simple('*','dev_web_user',$arr2);

		$userun 	= $config2->result_object();

		foreach($userun as $user):

			//echo $user->uSectors;

			$expsec = explode(",",$user->uSectors);

			//print_r($expsec);

			$sectdd = "";

			foreach($expsec as $sec):

				$arrsec = array('cID' => $sec);

				$csec = $this->front_model->get_query_simple('*','dev_web_categories',$arrsec);

				$sectd = $csec->result_object();

				$sectdd .= $sectd[0]->catName.", ";

			endforeach;

			//echo $this->db->last_query();

			$sectosmail = substr($sectdd,0,-2); 

			$today = date("Y-m-d");

			$lastvisit = date("d",(strtotime(date("Y-m-d"))-strtotime(date("Y-m-d",strtotime($user->uLoginLast)))));

			// CV DOWNLOADS

			$lastdate = date('Y-m-d', strtotime("-6 days"));

			$countcvview = $this->front_model->last7dayalerts($lastdate,$today,$user->uID);

			$countjobsaved = $this->front_model->last7savedjobs($lastdate,$today,$user->uID);

			$countposted = $this->front_model->last7jobsposted($lastdate,$today,$user->uID);

		

			$counapplicants = $this->front_model->last7applicantsapplied($lastdate,$today,$user->uID);

			

			$cond = array('uID' => $user->uID);

			$jobs = $this->front_model->get_query_simple('*','dev_web_cv',$cond);

			$jobsdata = $jobs->result_object();

			$cvviews = $this->front_model->last7cvViewjobs($lastdate,$today,$jobsdata[0]->cvID);

		// SEND EMAIL CONFIRMATION

		$edata = $this->front_model->get_emails_data('weekly-job-hunting-job');

		$this->load->library('email');

		$this->email->from("info@jobsrope.com", TITLEWEB);

		$this->email->to($user->uEmail); 

		$replace = array("[WEBTITLE]","[WEBURL]","[LASTVISIT]","[CVDOWNLOAD]","[SAVED JOB]","[JOBPOSTED]","[APPLICATION]","[JOBALERT]","[CVVIEWS]","[USER]","[SECTORS]");

		$replacewith = array("JobsRope", WEBURL, $lastvisit-1, $countcvview,$countjobsaved,$countposted,$counapplicants,'1',$cvviews,$user->uFname,$sectosmail);

		$str = str_replace($replace,$replacewith,$edata[0]->eContent);

		echo $message = $str;

		$this->email->subject($user->uFname.", ".$edata[0]->eName);

		$this->email->message($message);

		$this->email->set_mailtype("html");

		$send = $this->email->send();

		endforeach;

	

		echo "Email Sent";

	}

	// DAILY JOB HUNTING

	public function daily_job_alerts()

	{

		$arr2 = array();

		$config2 = $this->front_model->get_query_simple('*','dev_job_alerts',$arr2);

		$userdd 	= $config2->result_object();

		foreach($userdd as $alert):

			// USER DETAILS

			$cond = array('uID' => $alert->uID);

			$us = $this->front_model->get_query_simple('*','dev_web_user',$cond);

			$userinfo 	= $us->result_object();



			$up = $alert->jobTitle.",".$alert->jobSkills.",";

			$sub = substr($up,0,-1);

			$exp = explode(",",$sub);

			$qrydd = '';

			for($i=0;$i<=count($exp)-1;$i++):

				$qrydd .= "`jTitle` LIKE '%".$exp[$i]."%' OR ";

			endfor;

			//echo $qrydd;

			$todaydat = date("Y-m-d");

			$queryddy = substr($qrydd,0,-3);

			$jobsquote = $this->front_model->dailyjobalertscrone($queryddy,$todaydat);

			$jobslisting = '';

			if(count($jobsquote) > 0){

			foreach($jobsquote as $jobemail):

				$jobslisting .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background:#fdfdfd; padding:5px; border:1px solid #ccc;">

  <tr>

    <td width="5%">&nbsp;</td>

    <td width="90%" height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;"><a href="'.$this->config->base_url ().'job/'.$jobemail->jURL.'" target="_blank" style="color:#66F; font-weight:bold; text-decoration:none;">'.$jobemail->jTitle.'</a></td>

    <td width="5%">&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">$'.$jobemail->jStartSalary.' - $'.$jobemail->jEndSalary.', '.$jobemail->jNature.'</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px;">'.substr(strip_tags(htmlspecialchars_decode($jobemail->jDescription)),0,350).'...</td>

    <td>&nbsp;</td>

  </tr>

</table><div style=" margin:5px 0 0 0; ">&nbsp;&nbsp;</div>';

			endforeach;



			// SEND EMAIL TO USER

			$edata = $this->front_model->get_emails_data('daily-job-alerts-user');

			$this->load->library('email');

			$this->email->from($edata[0]->eEmail, TITLEWEB);

			$this->email->to($userinfo[0]->uEmail); 

									

			$replace = array("[WEBURL]","[USER]","[JOBSLIST]");

			$replacewith = array(WEBURL, $userinfo[0]->uFname.' '.$userinfo[0]->uLname, $jobslisting);

			$str = str_replace($replace,$replacewith,$edata[0]->eContent);

			$message = $str;

			$this->email->subject($edata[0]->eSubject.' -::- JobsRope');

			$this->email->message($message);

			$this->email->set_mailtype("html");

			$send = $this->email->send();

			}

		endforeach;

		

		echo 'Emails sent successfully';

	}

	// EMAIL RESUME TO MYSELF

	public function email_resume()

	{

		if(isset($_SESSION['JobsSessions']) && $_SESSION['JobsSessions'][0]->uActType == "1"){

			// SEND EMAIL FOR CV

			//$edata = $this->front_model->get_emails_data('daily-job-alerts-user');

			$this->load->library('email');

			$this->email->from("info@jobsrope.com", TITLEWEB);

			$this->email->to(EMAIL);

						

			$arr2 = array('uID' => UID);

			$uconfig	= $this->front_model->get_query_simple('*','dev_web_cv',$arr2);

			$user 	= $uconfig->result_object();	

			//print_r($user);

			$message = '<table align="center" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; border:2px solid #f0f0f0" width="800">

	<tbody>

		<tr>

		  <td>&nbsp;</td>

		  <td height="25"><table width="100%" border="0" cellspacing="0" cellpadding="0">

		    <tr>

		      <td height="25" align="center" style="padding:10px"><a href="http://www.jobsrope.com/" target="_blank"><img border="0" src="http://www.jobsrope.com/resources/frontend/images/logo.png" alt="JobsRope.com"></a></td>

	        </tr>

	      </table></td>

		  <td>&nbsp;</td>

	  </tr>

		<tr>

			<td width="10">&nbsp;

				</td>

			<td>&nbsp;

				</td>

			<td width="10">&nbsp;

				</td>

		</tr>

		<tr>

			<td>&nbsp;

				</td>

			<td height="25">

				<table border="0" cellpadding="0" cellspacing="0" width="100%">

					<tbody>

						<tr>

							<td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;" width="150">

								Preferred Job Title</td>

							<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;" width="20">

								:</td>

							<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">

								'.$user[0]->pJobtitle.'</td>

						</tr>

						<tr>

							<td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">

								Preferred Job Skills</td>

							<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">

								:</td>

							<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">

								'.$user[0]->pjobskills.'</td>

						</tr>

						<tr>

						  <td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">Preferred Location</td>

						  <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">:</td>

						  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">'.$user[0]->pjoblocation.'</td>

					  </tr>

						<tr>

						  <td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">Relocate</td>

						  <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">:</td>

						  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">'.$user[0]->prelocate.'</td>

					  </tr>

						<tr>

						  <td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">Job Type</td>

						  <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">:</td>

						  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">'.$user[0]->pjobtype.'</td>

					  </tr>

						<tr>

						  <td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">Salary</td>

						  <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">:</td>

						  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">'.$user[0]->psalaryfrom.'-'.$user[0]->psalaryto.'</td>

					  </tr>

						<tr>

						  <td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;"><strong>Relevant Job Info</strong></td>

						  <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">&nbsp;</td>

						  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">&nbsp;</td>

					  </tr>

						<tr>

						  <td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">Notice Period</td>

						  <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">:</td>

						  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">'.$user[0]->anoticeperiod.'</td>

					  </tr>

						<tr>

						  <td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">Language</td>

						  <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">:</td>

						  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">'.$user[0]->alanguage.'</td>

					  </tr>

						<tr>

						  <td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">Qualification</td>

						  <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">:</td>

						  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">'.$user[0]->aeducationlevel.'</td>

					  </tr>

						<tr>

						  <td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">Year</td>

						  <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">:</td>

						  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">'.$user[0]->ayear.'</td>

					  </tr>

						<tr>

						  <td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">Job Looking For</td>

						  <td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">:</td>

						  <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">'.$user[0]->ajobsummary.'</td>

					  </tr>

					</tbody>

				</table>

			</td>

			<td>&nbsp;

				</td>

		</tr>

		<tr>

		  <td>&nbsp;</td>

		  <td height="25" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;"><a href="'.$this->config->base_url ().'resources/uploads/resume/'.$user[0]->cvFile.'" style="text-transform:uppercase; text-decoration:none; letter-spacing:2px; border:1px solid #ccc; border-radius:4px;color: #fff; background: #ef7268; padding:20px 25px; display:block; width:45%; text-align:center; cursor:pointer;" targer="_blank">Download CV</a></td>

		  <td>&nbsp;</td>

	  </tr>

		<tr>

			<td>&nbsp;

				</td>

			<td>&nbsp;

				</td>

			<td>&nbsp;

				</td>

		</tr>

		<tr>

			<td>&nbsp;

				</td>

			<td height="25" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">

				Regards,</td>

			<td>&nbsp;

				</td>

		</tr>

		<tr>

			<td>&nbsp;

				</td>

			<td height="25" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">

				JobsRope Team,</td>

			<td>&nbsp;

				</td>

		</tr>

		<tr>

			<td>&nbsp;

				</td>

			<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:2a2a2a; line-height:18px;">&nbsp;

				</td>

			<td>&nbsp;

				</td>

		</tr>

	</tbody>

</table>

<br />

';

		

			$this->email->subject(FNAME." ".LNAME. 'CV -::- JobsRope');

			$this->email->message($message);

			$this->email->set_mailtype("html");

			$send = $this->email->send();

			$_SESSION['msglogin'] = 'Your CV has been emailed to your email address!';

			header ( "Location:" . $_SERVER['HTTP_REFERER']);

		}

		else {

			header ( "Location:" . $this->config->base_url () ."login");

		}

	}

	// ENRUIRY FORM SUBMIT

	public function enquiryform_submit()

	{

		// SEND EMAIL CONFIRMATION

		$edata = $this->front_model->get_emails_data('rec-enquiry-from');

		$this->load->library('email');

		$this->email->from($this->input->post('myemailadd'), TITLEWEB);

		$this->email->to($this->input->post('friendemail')); 

		$replace = array("[WEBURL]","[FULLNAME]","[USEREMAIL]","[COMPANY]","[MESSAGE]","[CONTACT]","[CTYPE]","[EMP]","[SECTOR]");

		$replacewith = array(WEBURL, $this->input->post('fullname'), $this->input->post('emailaddenq'), $this->input->post('company'),$this->input->post('elseknow'),$this->input->post('contactnum'),$this->input->post('ctype'),$this->input->post('numemp'),$this->input->post('sector'));

		$str = str_replace($replace,$replacewith,$edata[0]->eContent);

		$message = $str;

		$this->email->subject($edata[0]->eName);

		$this->email->message($message);

		$this->email->set_mailtype("html");

		$send = $this->email->send();



		$_SESSION['msglogin'] = "Enquiry been sent successfully!";

		header ( "Location:" . $this->config->base_url () . "recruiter-login");		

	}

	// SAVE SESSION SAVED<br />

	public function save_session_job(){

		$_SESSION['saveid'] = $_REQUEST['id'];

	}

	// APPLY SESSION SAVED<br />

	public function apply_session_job(){

		$_SESSION['applyidsession'] = $_REQUEST['id'];

	}

	// APPLY SESSION SAVED<br />

	public function session_job_redirect(){

		$_SESSION['redirectidsession'] = $_REQUEST['id'];

	}

	public function subscribe_list() {

					$data = array(

						'subEmail' 	   => $this->input->post('notifyemail'),

						'subkeywords' 	=> str_replace(" ",",",$this->input->post('jobtitlesub')),

					 );

				$this->front_model->add_query('dev_web_subscribers',$data);

				$_SESSION['msglogin'] = "You have been subscribed successfully!";

				header ( "Location:" . $_SERVER['HTTP_REFERER']);		

	}

	

	// DAILY JOB HUNTING SUBSCRIBERS

	public function daily_job_alerts_subscribers()

	{

		$arr2 = array();

		$config2 = $this->front_model->get_query_simple('*','dev_web_subscribers',$arr2);

		$userdd 	= $config2->result_object();

		foreach($userdd as $alert):

			

			$up = $alert->subkeywords;

			$exp = explode(",",$up);

			$qrydd = '';

			for($i=0;$i<=count($exp)-1;$i++):

				$qrydd .= "`jTitle` LIKE '%".$exp[$i]."%' OR ";

			endfor;

			//echo $qrydd;

			$todaydat = date("Y-m-d");

			$queryddy = substr($qrydd,0,-3);

			$jobsquote = $this->front_model->dailyjobalertscrone($queryddy,$todaydat);

			$jobslisting = '';

			if(count($jobsquote) > 0){

			foreach($jobsquote as $jobemail):

				$jobslisting .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background:#fdfdfd; padding:5px; border:1px solid #ccc;">

  <tr>

    <td width="5%">&nbsp;</td>

    <td width="90%" height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;"><a href="'.$this->config->base_url ().'job/'.$jobemail->jURL.'" target="_blank" style="color:#66F; font-weight:bold; text-decoration:none;">'.$jobemail->jTitle.'</a></td>

    <td width="5%">&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">$'.$jobemail->jStartSalary.' - $'.$jobemail->jEndSalary.', '.$jobemail->jNature.'</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td height="30" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px;">'.substr(strip_tags(htmlspecialchars_decode($jobemail->jDescription)),0,350).'...</td>

    <td>&nbsp;</td>

  </tr>

</table><div style=" margin:5px 0 0 0; ">&nbsp;&nbsp;</div>';

			endforeach;



			// SEND EMAIL TO USER

			$edata = $this->front_model->get_emails_data('daily-job-alerts-subscriber');

			$this->load->library('email');

			$this->email->from($edata[0]->eEmail, TITLEWEB);

			$this->email->to($alert->subEmail); 

					

			$replace = array("[WEBURL]","[USER]","[JOBSLIST]");

			$replacewith = array(WEBURL, $alert->subEmail, $jobslisting);

			$str = str_replace($replace,$replacewith,$edata[0]->eContent);

			$message = $str;

			$this->email->subject($edata[0]->eSubject.' -::- JobsRope');

			$this->email->message($message);

			$this->email->set_mailtype("html");

			$send = $this->email->send();

			}

		endforeach;

		

		echo 'Emails sent successfully';

	}

	

	// COupon COde

	public function coupon_discount()

	{

		$arr2 		= array('cpCode' => $this->input->post('coupouncode'),'cpStatus' => 1);

		$config2 	 = $this->front_model->get_query_simple('*','dev_web_coupon',$arr2);

		$userun 	  = $config2->num_rows();

		if($userun > 0){

			$corow = $config2->result_object();

			$_SESSION['copondata'] = $corow[0]->cpCode;

			$_SESSION['coponcodeses'] = $corow[0]->cpPrice;

			$_SESSION['msglogin'] = "Discount applied successfully!";

			header ( "Location:" . $_SERVER['HTTP_REFERER']);

		}

		else {

			$_SESSION['msglogin'] = "Invalid Coupon Code!";

			header ( "Location:" . $_SERVER['HTTP_REFERER']);

		}

	}

	

	public function remove_company_photo(){

		

		$arr = array('uID' => UID);

		$config 	= $this->front_model->get_query_simple('*','dev_web_user',$arr);

		$rconfig 	= $config->result_object();

		unlink("resources/uploads/profile/thumbnail_".$rconfig[0]->uImage);

		unlink("resources/uploads/profile/resize_".$rconfig[0]->uImage);

		$data = array(

				'uImage' 		   => "",

			);

			$condition = array('uID' => UID);

			$this->front_model->update_query('dev_web_user',$data,$condition);

			$_SESSION['msglogin'] = 'Company logo removed successfully!';

			header ( "Location:" . $_SERVER['HTTP_REFERER']);

	}

	

	/* Function to change profile picture */

	public function changeProfilePic() {

		$post = isset($_POST) ? $_POST: array();

		$max_width = "500"; 

		$userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;

		$path = 'resources/uploads/profile/';

		$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");

		$name = $_FILES['profile-pic']['name'];

		$size = $_FILES['profile-pic']['size'];

		if(strlen($name)) {

			list($txt, $ext) = explode(".", $name);

			if(in_array($ext,$valid_formats)) {

				if($size<(1024*1024)) {

					$actual_image_name = "resize_".date("ymdhis").'_avatar'.'_'.$userId.'.'.$ext;

					$filePath = $path .'/'.$actual_image_name;

					$tmp = $_FILES['profile-pic']['tmp_name'];

					if(move_uploaded_file($tmp, $filePath)) {

						$width = $this->getWidth($filePath);

						$height = $this->getHeight($filePath);

						//Scale the image if it is greater than the width set above

						if ($width > $max_width){

							$scale = $max_width/$width;

							$uploaded = $this->resizeImage($filePath,$width,$height,$scale,$ext);

						} else {

							$scale = 1;

							$uploaded = $this->resizeImage($filePath,$width,$height,$scale,$ext);

						}

						$res = $this->saveProfilePic(array(

						'userId' => isset($userId) ? intval($userId) : 0,

						'avatar' => isset($actual_image_name) ? $actual_image_name : '',

						));

						

						echo "<img id='photo' file-name='".$actual_image_name."' class='' src='".$filePath.'?'.time()."' class='preview'/>";

					}

					else

					echo "failed";

				}

				else

				echo "Image file size max 1 MB"; 

			}

			else

			echo "Invalid file format.."; 

		}

		else

		echo "Please select image..!";

		exit;

	}

	/* Function to handle save profile pic */

	public function saveProfilePic($options){

		$this->front_model->updateuserprofilepic($options['avatar'],UID);

	}

		

	/* Function to update image */

	 public function saveProfilePicTmp() {

		$post = isset($_POST) ? $_POST: array();

		$userId = isset($post['id']) ? intval($post['id']) : 0;

		$path ='\\resources\uploads\profile';

		$t_width = 300; // Maximum thumbnail width

		$t_height = 300;    // Maximum thumbnail height	

		if(isset($_POST['t']) and $_POST['t'] == "ajax") {

			extract($_POST);		

			$imagePath = 'resources/uploads/profile/'.$_POST['image_name'];

			$ratio = ($t_width/$w1); 

			$nw = ceil($w1 * $ratio);

			$nh = ceil($h1 * $ratio);

			$nimg = imagecreatetruecolor($nw,$nh);

			$im_src = imagecreatefromjpeg($imagePath);

			imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w1,$h1);

			imagejpeg($nimg,$imagePath,90);		

		}

		echo $imagePath.'?'.time();;

		exit(0);    

	}    

	/* Function  to resize image */

	public function resizeImage($image,$width,$height,$scale,$ext) {

		$newImageWidth = ceil($width * $scale);

		$newImageHeight = ceil($height * $scale);

		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);

		if ($ext == "jpg" || $ext == "jpeg")

		{

			$source = imagecreatefromjpeg($image);

		}

		else

		if ($ext == "png")

		{

			$source = imagecreatefrompng($image);

		}

		else

		{

			$source = imagecreatefromgif($image);

		}

		$tmp = imagecreatetruecolor($width,$height);

		imagefilledrectangle($newImage, 0, 0, $width, $height, imagecolorallocate($tmp, 255, 255, 255));

		imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);

		imagejpeg($newImage,$image,90);

		chmod($image, 0777);

		return $image;

	}

	/*  Function to get image height. */

	public function getHeight($image) {

		$sizes = getimagesize($image);

		$height = $sizes[1];

		return $height;

	}

	/* Function to get image width */

	public function getWidth($image) {

		$sizes = getimagesize($image);

		$width = $sizes[0];

		return $width;

	}

	// CHNAGE PIC

	public function change_pic(){

		$post = isset($_POST) ? $_POST: array();

		switch($post['action']) {

			case 'save' :

			$this->saveProfilePicTmp();

			break;

			default:

			$this->changeProfilePic();

		}

	}

	

	// WEBSITE FOUND OR NOT

	public function check_website_found(){

		$chk = $this->front_model->checkifurlfound($_REQUEST['url']);

		if($chk > 0){

			echo "1";

		} else {

			echo "2";

		}

	}

	

	// POST JOB AS AGENT

	public function post_job_as_agent()

	{

		$chk = $this->front_model->checkifurlfound($this->input->post('jweburl'));

		if($chk > 0){

			//echo "found";

			$cinfo = $this->front_model->checkifurlfounddbadd($this->input->post('jweburl'));

			$compname = $cinfo[0]->uCompany;

			$compinfo = $cinfo[0]->uAbout;

			$compweb = $cinfo[0]->uWebsite;

			$compcperson = $cinfo[0]->uFname." ".$cinfo[0]->uLname;

			$compphone = $cinfo[0]->uPhone;

			$compaddress = $cinfo[0]->uAddress;

			$uID = $cinfo[0]->uID;

		} else {

			//echo "nofound";

			$securitycode = $this->generateSecurityCode();

			$rendomcode = $this->generateRandomString();

			$data = array(

					'uFname' 	   => $this->input->post('contactperson'),

					'uEmail' 	   => $this->input->post('companyemailAdd'),

					'uPassword' 	=> md5($rendomcode),

					'uCompany' 	 => $this->input->post('companyNamenew'),

					'uPhone' 	   => $this->input->post('phonecom'),

					'uWebsite' 	 => $this->input->post('jweburl'),

					//'uWebsite' 	 => $this->input->post('jweburl'),

					'uAbout' 	   => $this->input->post('companydetailsnew'),

					'uGender' 	  => "Male",

					'uActType' 	 => 2,

					'uStatus' 	  => 1,

					'uPayment' 	 => 0,

					'joinDate' 	 => date('Y-m-d h:i:s'),

					'uCode' 		=> $rendomcode,

					'uReCode' 	  => $securitycode,

					'uIP' 		  => $_SERVER['REMOTE_ADDR'],

					//'uLoginLast'   => date("Y-m-d h:i:s"),

				);

			$uID = $this->front_model->add_query('dev_web_user',$data);

			

			$compname = $this->input->post('companyNamenew');

			$compinfo = $this->input->post('companydetailsnew');

			$compweb = $this->input->post('jweburl');

			$compcperson = $this->input->post('contactperson');

			$compphone = $this->input->post('phonecom');

			$compaddress = $this->input->post('comAddress');

		}

		$randomcode = $this->generateRandomString();

		$timezone = date_default_timezone_get();

		$datetime = date('Y-m-d H:i:s', time());

		$id = $this->input->post('benefits');

		$ben = count($this->input->post('benefits'));

		if($ben > 0){

		for($i=0;$i<$ben;$i++):

			$bent .= $id[$i].",";

		endfor;

		$benefit = substr($bent,0,-1);

		}

		else { $benefit= '';}

		if($this->input->post('applyurl') != ""){

			$applyurl = $this->input->post('applyurl');

			$direct = 1; 

		}

		else { 

			$applyurl = "";

			$direct = 0; 

		}

		$pt = str_replace(","," ",$this->input->post('jTitle'));

		$jurl = strtolower(url_title($pt))."-".$randomcode;

		if($this->input->post('notdis') == "0"){

			$discl = $this->input->post('notdis');

		}

		else { $discl = "1";}

		if($this->input->post('chkdisclose') == "0"){

			$cdsi = $this->input->post('chkdisclose');

		}

		else {

			$cdsi = '1';

		}

		

		if($this->input->post('salnotdis') == "1"){

			$saldsi = $this->input->post('salnotdis');

		}

		else {

			$saldsi = '0';

		}

				// GET CITY		

		$ip=$_SERVER['REMOTE_ADDR'];

		$addr_details = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));

		$city = stripslashes(ucfirst($addr_details['geoplugin_city']));

		$countrycode = stripslashes(ucfirst($addr_details['geoplugin_countryCode']));

		$countryip = stripslashes(ucfirst($addr_details['geoplugin_countryName']));

		$cityid = $this->input->post('cityname');

		$bencity = count($this->input->post('cityname'));

		if($bencity > 1){

		for($id=0;$id<$bencity;$id++):

			$bentcity .= $cityid[$id].",";

		endfor;

			$bentcity = substr($bentcity,0,-1);

		}

		else { $bentcity= $cityid[0];}

		$specia = $this->input->post('specialization');

		$speciac = count($this->input->post('specialization'));

		if($speciac > 1){

		for($idt=0;$idt<$speciac;$idt++):

			$bspec .= $specia[$idt].",";

		endfor;

			$bspec = substr($bspec,0,-1);

		}

		else { $bspec= $specia[0]; }

		//echo $bspec;

		$data = array(

					'uID' 				=> $uID,

					'jTitle' 			 => $this->input->post('jTitle'),

					'jURL' 			   => $jurl,

					'jCName' 			   => $compname,

					'jCInfo' 			   => $compinfo,

					'jCWeb' 			    => $compweb,

					'jCPerson' 			   => $compcperson,

					'jCPhone' 			   => $compphone,

					'jCAddress' 			   => $compaddress,

					//'jDepartment' 		=> $this->input->post('department'),

					'cID' 				=> $this->input->post('industry'),

					'jCareerLevel' 	   => $this->input->post('careerlevel'),

					'jExpLevel' 		  => $this->input->post('explevelmin'),

					'jExpLevelmax' 	   => $this->input->post('explevelmax'),

					'jVacancy' 		   => $this->input->post('vacancies'),

					'jNotDislosed' 		=> $discl,

					'jDescription' 	   => nl2br($this->input->post('jobDescp')),

					'jRequiredSkills' 	=> nl2br($this->input->post('reqSkilled')),

					'jQualification' 	 => $this->input->post('qualification'),

					'jSpecialization' 	 => $bspec,

					'jSkillKeyword' 	 => $this->input->post('skillkeyword'),

					'jNature' 			=> $this->input->post('jobtype'),

					'jShift' 			 => $this->input->post('jobshift'),

					'jRequiredTravel' 	=> $this->input->post('jobtravel'),

					'jGender' 			=> $this->input->post('jobGender'),

					'jStartSalary' 	   => $this->input->post('startsalary'),

					'jEndSalary' 		 => $this->input->post('endsalary'),

					'jCurrency' 		  => $this->input->post('jCurrency'),

					'jsalType' 		  => $this->input->post('jsalType'),

					'jSalHidden' 		  => $saldsi,

					'jBenefits' 		  => $benefit,

					'jCoutry' 		 	=> $this->input->post('jobLocation'),

					'jStateCity' 		 	=> $bentcity,

					//'jExpiry' 			=> date('Y-m-d', strtotime("+28 days")),

					//'jAfterExpiry' 	   => $this->input->post('jobAfterExpiry'),

					'jCDisclose' 	     => $cdsi,

					'jEmailNotify' 	   => $this->input->post('jobNotify'),

					'jPostedDate' 		=> $datetime,

					'jJobCode' 		   => $randomcode,

					'jJobStatus' 		 => 1,

					'jJobIP' 		 	 => $_SERVER['REMOTE_ADDR'],

					'jDirect' 		    => $direct,

					'jDirectLink' 		 => $applyurl,

					'jSource' 		     => $this->input->post('sourcewebsite'),

					'jPostedUser' 		 => 0,

					'agtID' 		        => UID,

				);

			$this->front_model->add_query('dev_web_jobs',$data);

			

			// SEND EMAIL TO ALERTS INSTANT

			$jtitle = $this->input->post('jTitle');

			$til = str_replace(" ",",",$jtitle);

			$exp = explode(",",$til);

			for($t=0;$t<=count($exp)-1;$t++){

				$var .= "`jobTitle` LIKE '%".$exp[$t]."%' OR ";

				$var .= "`jobSkills` LIKE '%".$exp[$t]."%' OR ";

			}

			$query = substr($var,0,-3);

			$recommendedjob =  $this->front_model->sendInstantAlerts($query);

			foreach($recommendedjob as $alert):		

				$condition = array('uID' => $alert->uID);

				$usinfo =  $this->front_model->get_query_simple('*','dev_web_user',$condition);

				$userinfo = $usinfo->result_object();

				// SEND EMAIL TO USER

				$edata = $this->front_model->get_emails_data('instant-alerts-user');

				$this->load->library('email');

				$this->email->from($edata[0]->eEmail, TITLEWEB);

				$this->email->to($userinfo[0]->uEmail); 

										

				$replace = array("[WEBURL]","[USER]","[SALARY]","[JOBTYPE]","[JOBDETAILS]","[JOBAPPLYURL]","[JOBTITLE]");

				$replacewith = array(WEBURL, $userinfo[0]->uFname.' '.$userinfo[0]->uLname,"$".$this->input->post('startsalary')."-".$this->input->post('endsalary'),$this->input->post('jobtype'),$this->input->post('jobDescp'),"job/".$jurl."?apply=yes",$this->input->post('jTitle'));

				$str = str_replace($replace,$replacewith,$edata[0]->eContent);

				$message = $str;

				$this->email->subject($edata[0]->eSubject." ".$this->input->post('jTitle'));

				$this->email->message($message);

				$this->email->set_mailtype("html");

				$send = $this->email->send();

			endforeach;

		

		$_SESSION['msglogin'] = 'New job added successfully!';

		header ( "Location:" . $this->config->base_url ());

	}

	

	// EDIT JOB AS AGENT

	public function edit_post_job_as_agent()

	{

		

		$compname = $this->input->post('companyNamenew');

		$compinfo = $this->input->post('companydetailsnew');

		$compweb = $this->input->post('jweburl');

		$compcperson = $this->input->post('contactperson');

		$compphone = $this->input->post('phonecom');

		$compaddress = $this->input->post('comAddress');

				

		$randomcode = $this->generateRandomString();

		$timezone = date_default_timezone_get();

		$datetime = date('Y-m-d H:i:s', time());

		$id = $this->input->post('benefits');

		$ben = count($this->input->post('benefits'));

		if($ben > 0){

		for($i=0;$i<$ben;$i++):

			$bent .= $id[$i].",";

		endfor;

		$benefit = substr($bent,0,-1);

		}

		else { $benefit= '';}

		if($this->input->post('applyurl') != ""){

			$applyurl = $this->input->post('applyurl');

			$direct = 1; 

		}

		else { 

			$applyurl = "";

			$direct = 0; 

		}

		$pt = str_replace(","," ",$this->input->post('jTitle'));

		$jurl = strtolower(url_title($pt))."-".$randomcode;

		if($this->input->post('notdis') == "0"){

			$discl = $this->input->post('notdis');

		}

		else { $discl = "1";}

		if($this->input->post('chkdisclose') == "0"){

			$cdsi = $this->input->post('chkdisclose');

		}

		else {

			$cdsi = '1';

		}

		

		if($this->input->post('salnotdis') == "1"){

			$saldsi = $this->input->post('salnotdis');

		}

		else {

			$saldsi = '0';

		}

				// GET CITY		

		$ip=$_SERVER['REMOTE_ADDR'];

		$addr_details = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));

		$city = stripslashes(ucfirst($addr_details['geoplugin_city']));

		$countrycode = stripslashes(ucfirst($addr_details['geoplugin_countryCode']));

		$countryip = stripslashes(ucfirst($addr_details['geoplugin_countryName']));

		$cityid = $this->input->post('cityname');

		$bencity = count($this->input->post('cityname'));

		if($bencity > 1){

		for($id=0;$id<$bencity;$id++):

			$bentcity .= $cityid[$id].",";

		endfor;

			$bentcity = substr($bentcity,0,-1);

		}

		else { $bentcity= $cityid[0];}

		$specia = $this->input->post('specialization');

		$speciac = count($this->input->post('specialization'));

		if($speciac > 1){

		for($idt=0;$idt<$speciac;$idt++):

			$bspec .= $specia[$idt].",";

		endfor;

			$bspec = substr($bspec,0,-1);

		}

		else { $bspec= $specia[0]; }

		//echo $bspec;

		$data = array(

					//'uID' 				=> $uID,

					'jTitle' 			 => $this->input->post('jTitle'),

					//'jURL' 			   => $jurl,

					'jCName' 			   => $compname,

					'jCInfo' 			   => $compinfo,

					//'jCWeb' 			    => $compweb,

					'jCPerson' 			   => $compcperson,

					'jCPhone' 			   => $compphone,

					'jCAddress' 			   => $compaddress,

					//'jDepartment' 		=> $this->input->post('department'),

					'cID' 				=> $this->input->post('industry'),

					'jCareerLevel' 	   => $this->input->post('careerlevel'),

					'jExpLevel' 		  => $this->input->post('explevelmin'),

					'jExpLevelmax' 	   => $this->input->post('explevelmax'),

					'jVacancy' 		   => $this->input->post('vacancies'),

					'jNotDislosed' 		=> $discl,

					'jDescription' 	   => nl2br($this->input->post('jobDescp')),

					'jRequiredSkills' 	=> nl2br($this->input->post('reqSkilled')),

					'jQualification' 	 => $this->input->post('qualification'),

					'jSpecialization' 	 => $bspec,

					'jSkillKeyword' 	 => $this->input->post('skillkeyword'),

					'jNature' 			=> $this->input->post('jobtype'),

					'jShift' 			 => $this->input->post('jobshift'),

					'jRequiredTravel' 	=> $this->input->post('jobtravel'),

					'jGender' 			=> $this->input->post('jobGender'),

					'jStartSalary' 	   => $this->input->post('startsalary'),

					'jEndSalary' 		 => $this->input->post('endsalary'),

					'jCurrency' 		  => $this->input->post('jCurrency'),

					'jsalType' 		  => $this->input->post('jsalType'),

					'jSalHidden' 		  => $saldsi,

					'jBenefits' 		  => $benefit,

					'jCoutry' 		 	=> $this->input->post('jobLocation'),

					'jStateCity' 		 	=> $bentcity,

					//'jExpiry' 			=> date('Y-m-d', strtotime("+28 days")),

					//'jAfterExpiry' 	   => $this->input->post('jobAfterExpiry'),

					'jCDisclose' 	     => $cdsi,

					'jEmailNotify' 	   => $this->input->post('jobNotify'),

					//'jPostedDate' 		=> $datetime,

					'jJobCode' 		   => $randomcode,

					//'jJobStatus' 		 => 1,

					'jJobIP' 		 	 => $_SERVER['REMOTE_ADDR'],

					'jDirect' 		    => $direct,

					'jDirectLink' 		 => $applyurl,

					'jSource' 		     => $this->input->post('sourcewebsite'),

					//'jPostedUser' 		 => 0,

					//'agtID' 		        => UID,

				);

			$condition = array("jID" => $this->input->post('jID'));

			$this->front_model->update_query('dev_web_jobs',$data,$condition);

			

		$_SESSION['msglogin'] = 'Job information updated successfully!';

		header ( "Location:" . $this->config->base_url ());

	}

	

	public function get_json_data()

	{

			$ind = $this->front_model->checkselect2skills($_REQUEST['q']);

			$industry = $ind->result_object();

			echo  json_encode($industry);

	}

	

	public function cancel_draft_job()

	{

		$data = array(

				'jID' 		=> $this->uri->segment(3),

			);

		$this->front_model->delete_query('dev_web_jobs',$data);

		$_SESSION['msglogin'] = 'Drafted job removed successfully!';

		header ( "Location:" . $_SERVER['HTTP_REFERER']);

	}

	

	// EXPIRE JOBS

	


	public function payment_options()
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){




				if(isset($_POST['type']))
				{
					$array = array(
						'address'=>$this->input->post('address'),
						'active'=>1,
						'time_active'=>$this->input->post('active_time'),
						'count_down'=>$this->input->post('time'),
						'icon'=>$this->input->post('icon'),


					);


					if($this->input->post('type')==2)
					{
						$array = array(
							'icon'=>$this->input->post('icon'),
							'name'=>$this->input->post('name'),
							'api_key'=>$this->input->post('api_key'),
							'secret_key'=>$this->input->post('api_secret'),
							'active'=>1
						);
					}


					if($this->input->post('type')==3)
					{
						$array = array(
							'icon'=>$this->input->post('icon'),
							'name'=>$this->input->post('name'),
							'bank_name'=>$this->input->post('bank_name'),
							'bank_address'=>$this->input->post('bank_address'),
							'account_name'=>$this->input->post('account_name'),
							'account_number'=>$this->input->post('account_number'),
							'routing_number'=>$this->input->post('routing_number'),
							'active'=>1
						);
					}



					$condition = array("id" => $this->input->post('option_id'));

					$this->front_model->update_query('dev_web_payment_options',$array,$condition);
					$_SESSION['thankyou'] = "Information updated successfully!";

					redirect($_SERVER['HTTP_REFERER']);



				}
				else
				{
					$this->data['options']=$this->front_model->get_query_simple('*','dev_web_payment_options',array())->result_object();
					$this->load->view('frontend/payment_options', $this->data);
				}







				
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

		

	}
	function inactive_payment_option()
	{
		$id = $this->input->post('id');

		$condition = array("id" => $this->input->post('id'));

		$this->front_model->update_query('dev_web_payment_options',array('active'=>0),$condition);
	}


	public function buy_tokens()
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "2"){


				if(isset($_POST['option']))
				{
				



					$condition = array("id" => $this->input->post('option'));

					$payment_option = $this->front_model->get_query_simple('*','dev_web_payment_options',$condition)->result_object()[0];

					 $_SESSION['buy_step_1'] = $_POST;

					 

					redirect(base_url().'buy-tokens/'.url_title(strtolower($payment_option->name)));



				}
				else
				{
			
					$this->data['options']=$this->front_model->get_query_simple('*','dev_web_payment_options',array('active'=>1))->result_object();
					$this->load->view('frontend/buy_tokens', $this->data);


				}
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

		

	}

	public function buy_tokens_step_2()
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "2"){




				if(isset($_POST['amount']))
				{
					$_SESSION['buy_step_2']=$_POST;



					// $condition = array("id" => $this->input->post('option_id'));

					// $this->front_model->update_query('dev_web_payment_options',$array,$condition);
					// $_SESSION['thankyou'] = "Information updated successfully!";

					$_SESSION['buy_time']=time();


					redirect(current_url().'/hash');



				}
				else
				{
					$this->data['option']=$this->front_model->get_query_simple('*','dev_web_payment_options',array('id'=>$_SESSION['buy_step_1']['option']))->result_object()[0];

					$this->data['active_token']=$this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
					$this->load->view('frontend/buy_tokens_step_2', $this->data);
				}







				
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

		

	}


	public function buy_tokens_step_3()
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "2"){




				if(isset($_POST['hash']))
				{
					// $_SESSION['buy_step_2']=$_POST;






					$this->data['option']=$this->front_model->get_query_simple('*','dev_web_payment_options',array('id'=>$_SESSION['buy_step_1']['option']))->result_object()[0];

					$this->data['active_token']=$this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];




















					if($this->data['option']->time_active==1){

					 $time_db = (explode(':', $this->data['option']->count_down)[0]*60)+explode(':', $this->data['option']->count_down)[1];
					    $time = time()-$_SESSION['buy_time'];

					    if($time_db>$time){
					        $time = $time_db-$time;
					    }
					    else
					    {
					        $time = 0;
					    }

					    if($time<=0)
					    {
					    	redirect(base_url().'ico/clear_buy_token');
					    	exit;
					    }

					}







					$percent = ($this->data['active_token']->tokenBonus/100);

					$total_tokens = $percent * $_SESSION['buy_step_2']['amount'];
					$total_tokens = $total_tokens + $_SESSION['buy_step_2']['amount'];
					// echo $total_tokens;exit;
					$total_price = $_SESSION['buy_step_2']['amount']*$this->data['active_token']->tokenPrice;


					$pre_paid = 0;
					$pre_hash = $this->input->post('hash');

					if(isset($_POST['paid_stripe'])){
					////////////////stripe

						$token = $_POST['stripeToken'];
						$src_token = $_REQUEST['source'];
						try{
							$stripe_charge = $total_price;
							require_once 'vendor/autoload.php';
							\Stripe\Stripe::SetApiKey($this->data['option']->secret_key);
							
							
							$stripe_arr_charge=array(
									'amount'=>round($stripe_charge,2)*100,
									'currency'=>'USD',
									'source'=>$token,
									'description'=>"transaction_id: ".$_SESSION['trans_id']
								);
							$payment_via="stripe";

							
							



							$charge = Charge::Create(
								$stripe_arr_charge
							);

							$pre_paid = 1;

							$pre_hash = $charge->id;

							 

							
						}
						catch(\Stripe\Error\Card $e)
						{
							$_SESSION['msglogin']="Some error occured while processing your payment, please try again";
							redirect($_SERVER['HTTP_REFERER']);
							exit;
							$error = $e->getMessage();
							echo $error->Message;
						}


						////////////////stripe

					}





					// $condition = array("id" => $this->input->post('option_id'));

					// $this->front_model->update_query('dev_web_payment_options',$array,$condition);
					// $_SESSION['thankyou'] = "Information updated successfully!";


					

					$arr = array(
						'tokens'=>$total_tokens,
						'currency'=>$_SESSION['buy_step_1']['option'],
						'amountPaid'=>$_SESSION['crypto_required'],
						'amtType'=>$this->data['option']->name,
						'usdPayment'=>$total_price,
						'hash'=>$pre_hash,
						'status'=>$pre_paid==0?1:2,
						'datecreated'=>date("Y-m-d H:i:s"),
						'uIP'=>$_SERVER['REMOTE_ADDR'],
						'uID'=>UID,
						'transaction_id'=>$_SESSION['trans_id']
					);

					$this->front_model->add_query('dev_web_transactions',$arr);



					unset($_SESSION['buy_step_1']);
					unset($_SESSION['buy_step_2']);
					unset($_SESSION['buy_time']);
					unset($_SESSION['trans_id']);
					unset($_SESSION['crypto_required']);



					redirect(base_url().'/dashboard');



				}
				else
				{

					$trans_id = guid();

					$this->data['trans_id']=$trans_id;

					$_SESSION['trans_id']=$trans_id;


					$this->data['option']=$this->front_model->get_query_simple('*','dev_web_payment_options',array('id'=>$_SESSION['buy_step_1']['option']))->result_object()[0];

					$this->data['active_token']=$this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];


					$converting = convert_curr($this->data['option']->c_name);

					$converting = json_decode($converting,true);

					foreach($converting as $cc)
						$converting = $cc;

					// print_r($converting);exit;

				 

					



					$arr = array(
						'transaction_id'=>$trans_id,
						'address'=>$this->data['option']->address,
						'currency'=>$this->data['option']->name,
						'price_per_token'=>$this->data['active_token']->tokenPrice,
						'total_tokens'=>$_SESSION['buy_step_2']['amount'],
						'amount_paid'=>$_SESSION['buy_step_2']['amount']*$this->data['active_token']->tokenPrice
					);


					$crypto_required = $arr['amount_paid']*$converting;
					$_SESSION['crypto_required']=$crypto_required;
					$this->data['crypto_required']=$crypto_required;


					$string = json_encode($arr);

					// $string = "transaction_id: $trans_id \n "

					foreach($arr as $key=>$val)
					{
						$str .= str_replace('_', ' ', strtoupper($key)).': '.$val;

						if($key!=count($arr)-1)
							$str.=' | ';
					}


					$qr = QRCode::getMinimumQRCode($str, QR_ERROR_CORRECT_LEVEL_L);

					// ƒCƒ[ƒWì¬(ˆø”:ƒTƒCƒY,ƒ}[ƒWƒ“)
					$im = $qr->createImage(6, 12);



					$im_name = './resources/uploads/qr_codes/'.$trans_id.'.gif';

					// header("Content-type: image/gif");
					$image = imagegif($im,$im_name);





					if($this->data['option']->time_active==1){

					 $time_db = (explode(':', $this->data['option']->count_down)[0]*60)+explode(':', $this->data['option']->count_down)[1];
					    $time = time()-$_SESSION['buy_time'];

					    if($time_db>$time){
					        $time = $time_db-$time;
					    }
					    else
					    {
					        $time = 0;
					    }

					    if($time<=0)
					    {
					    	redirect(base_url().'ico/clear_buy_token');
					    	exit;
					    }

					}

					

					$this->load->view('frontend/buy_tokens_step_3', $this->data);
				}







				
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

		

	}
	public function clear_buy_token()
	{
		unset($_SESSION['buy_step_1']);
		unset($_SESSION['buy_step_2']);
		unset($_SESSION['buy_time']);
		unset($_SESSION['trans_id']);
		unset($_SESSION['crypto_required']);


		$_SESSION['thank_you']="Your transaction couldn't be progressed as you didn't verify your hash";


		redirect(base_url().'buy-tokens');
	}
	public function transaction_details($id)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "2" || ACTYPE=="1"){

				if(ACTYPE == "2")
				{
					$condition=array('tID'=>$id,'uID'=>UID);
				}
				else
				{
					$condition=array('tID'=>$id);

				}


				$this->data['trans']=$this->front_model->get_query_simple('*','dev_web_transactions',$condition)->result_object()[0];

				$this->data['user']=$this->front_model->get_query_simple('*','dev_web_user',array('uID'=>$this->data['trans']->uID))->result_object()[0];

				 


				$this->load->view('frontend/transaction_details', $this->data);
			}
		}


	}
	public function new_payment_option()
	{
		$arr = array(
			'name'=>$this->input->post('name'),
			'type'=>$this->input->post('type'),
			'address'=>$this->input->post('address'),
			'c_name'=>$this->input->post('short_name'),
			'api_key'=>$this->input->post('api_key'),
			'secret_key'=>$this->input->post('api_secret'),
			'bank_name'=>$this->input->post('bank_name'),
			'bank_address'=>$this->input->post('bank_address'),
			'account_name'=>$this->input->post('account_name'),
			'account_number'=>$this->input->post('account_number'),
			'routing_number'=>$this->input->post('routing_number'),
			'icon'=>$this->input->post('icon'),
			'active'=>0
		);



		if($arr['type']!=1)
			$arr['c_name']="USD";

		$this->front_model->add_query('dev_web_payment_options',$arr);
		$_SESSION['thankyou']="Information updated successfully!";
		redirect($_SERVER['HTTP_REFERER']);

	}

	function update_transactions()
	{
		$all_pending = $this->front_model->get_query_simple('*','dev_web_transactions',array('status'=>1))->result_object();





		foreach($all_pending as $one_pending)
		{

			$payment_option = $this->front_model->get_query_simple('*','dev_web_payment_options',array('id'=>$one_pending->currency))->result_object()[0];

			if($payment_option->type!=1) continue;



			 if(strtolower($payment_option->c_name)==strtolower("ETH"))
			 {


			 	////////////////////////////


			 	// echo $one_pending->hash;

					$response = is_confirmed_eth($one_pending->hash);

					$response = json_decode($response);

					 

					if($response->result->isError=="0"){

						
							$this->front_model->update_query('dev_web_transactions',array('success_tries'=>$one_pending->success_tries+1),array('tID'=>$one_pending->tID));

							if($one_pending->success_tries+1>=6)
							{

								
									$this->front_model->update_query('dev_web_transactions',array('status'=>2),array('tID'=>$one_pending->tID));



									$subject="Transaction Confirmed!";
									$data = "Your transaction #".$one_pending->transaction_id." has been confirmed.";
									$this->notify_user($subject,$data,$one_pending->uID);


									$subject="Transaction Confirmed!";
									$data = "Transaction #".$one_pending->transaction_id." has been confirmed.";
									$this->notify_user($subject,$data,0);

								

							}
						}
						else
						{

							$this->front_model->update_query('dev_web_transactions',array('failed_tries'=>$one_pending->failed_tries+1),array('tID'=>$one_pending->tID));


							if($one_pending->failed_tries+1>=6){
								$this->front_model->update_query('dev_web_transactions',array('status'=>3),array('tID'=>$one_pending->tID));


								$subject="Transaction Cancelled!";
								$data = "Your transaction #".$one_pending->transaction_id." has been cancelled.";
								$this->notify_user($subject,$data,$one_pending->uID);


								$subject="Transaction Cancelled!";
								$data = "Transaction #".$one_pending->transaction_id." has been cancelled.";
								$this->notify_user($subject,$data,0);
							}

						}


					

			 }
			 else
			 {



			 	////////////////////////


			 	// echo $one_pending->hash;

				$response = is_confirmed($payment_option->c_name,$one_pending->hash);

				$response = json_decode($response);

				// print_r($response);exit;

				if($response->status=="success"){

					if($response->data->is_confirmed==1)
					{
						$this->front_model->update_query('dev_web_transactions',array('success_tries'=>$one_pending->success_tries+1),array('tID'=>$one_pending->tID));

						if($one_pending->success_tries+1>=6)
						{

							if($response->data->confirmations>=6)
							{
								$this->front_model->update_query('dev_web_transactions',array('status'=>2),array('tID'=>$one_pending->tID));

									$subject="Transaction Confirmed!";
									$data = "Your transaction #".$one_pending->transaction_id." has been confirmed.";
									$this->notify_user($subject,$data,$one_pending->uID);


									$subject="Transaction Confirmed!";
									$data = "Transaction #".$one_pending->transaction_id." has been confirmed.";
									$this->notify_user($subject,$data,0);




							}

						}
					}
					else
					{

						$this->front_model->update_query('dev_web_transactions',array('failed_tries'=>$one_pending->failed_tries+1),array('tID'=>$one_pending->tID));


						if($one_pending->failed_tries+1>=6){
							$this->front_model->update_query('dev_web_transactions',array('status'=>3),array('tID'=>$one_pending->tID));

								$subject="Transaction Cancelled!";
								$data = "Your transaction #".$one_pending->transaction_id." has been cancelled.";
								$this->notify_user($subject,$data,$one_pending->uID);


								$subject="Transaction Cancelled!";
								$data = "Transaction #".$one_pending->transaction_id." has been cancelled.";
								$this->notify_user($subject,$data,0);
						}

					}


				}
				else
				{
					$this->front_model->update_query('dev_web_transactions',array('failed_tries'=>$one_pending->failed_tries+1),array('tID'=>$one_pending->tID));
					if($one_pending->failed_tries+1>=6){
							$this->front_model->update_query('dev_web_transactions',array('status'=>3),array('tID'=>$one_pending->tID));


								$subject="Transaction Cancelled!";
								$data = "Your transaction #".$one_pending->transaction_id." has been cancelled.";
								$this->notify_user($subject,$data,$one_pending->uID);


								$subject="Transaction Cancelled!";
								$data = "Transaction #".$one_pending->transaction_id." has been cancelled.";
								$this->notify_user($subject,$data,0);
						}
				}

			 }

			



		}
	}
	public function sponsored_predictions()
	{
		$this->load->view('frontend/sponsored_predictions', $this->data);

	}

	public function user_onboarding_compaigns()
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){




				if(isset($_POST['address']))
				{
					$array = array(
						'address'=>$this->input->post('address'),
						'active'=>1,
						'time_active'=>$this->input->post('active_time'),
						'count_down'=>$this->input->post('time'),
						'icon'=>$this->input->post('icon')
					);



					$condition = array("id" => $this->input->post('option_id'));

					$this->front_model->update_query('dev_web_payment_options',$array,$condition);
					$_SESSION['thankyou'] = "Information updated successfully!";

					redirect($_SERVER['HTTP_REFERER']);



				}
				else
				{
					$this->data['camps']=$this->front_model->get_query_simple('*','dev_web_campaigns',array())->result_object();
					$this->load->view('frontend/user_onboarding_compaigns', $this->data);
				}







				
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}
	public function activate_camp($id)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){


				$u_type = $this->front_model->get_query_simple('*','dev_web_campaigns',array('id'=>$id))->result_object[0]->user_type;



				$this->front_model->update_query('dev_web_campaigns',array('active'=>0),array('user_type'=>$u_type));
				$this->front_model->update_query('dev_web_campaigns',array('active'=>1),array('id'=>$id));
				$_SESSION['thankyou'] = "Campaign Activated Successfully!";
				redirect($_SERVER['HTTP_REFERER']);
			}
		}

	}

	public function deactivate_camp($id)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

				// $this->front_model->update_query('dev_web_campaigns',array('active'=>0),array());
				$this->front_model->update_query('dev_web_campaigns',array('active'=>0),array('id'=>$id));
				$_SESSION['thankyou'] = "Campaign De-activated Successfully!";

				redirect($_SERVER['HTTP_REFERER']);

			}
		}

	}
	public function delete_camp($id)
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

				// $this->front_model->update_query('dev_web_campaigns',array('active'=>0),array());
				$this->front_model->delete_query('dev_web_campaigns',array('id'=>$id));
				$_SESSION['thankyou'] = "Campaign Deleted Successfully!";

				redirect($_SERVER['HTTP_REFERER']);

			}
		}
	}

	public function delete_question($id)
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

				// $this->front_model->update_query('dev_web_campaigns',array('active'=>0),array());
				$this->front_model->delete_query('dev_web_slide_qs',array('id'=>$id));
				$_SESSION['thankyou'] = "Question Deleted Successfully!";

				redirect($_SERVER['HTTP_REFERER']);

			}
		}
	}
	public function delete_camp_slide($id)
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

				// $this->front_model->update_query('dev_web_campaigns',array('active'=>0),array());
				$this->front_model->delete_query('dev_web_camp_slides',array('id'=>$id));
				$_SESSION['thankyou'] = "Slide Deleted Successfully!";

				redirect($_SERVER['HTTP_REFERER']);

			}
		}
	}

	public function add_campaign()
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
				$arr = array();
				// $config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);
				// $this->data['countries'] 	= $config->result_object();
				$this->load->view('frontend/add_campaign', $this->data);
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}

	public function do_add_campaign()

	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
		
			$rendomcode = $this->generateRandomString();
			$data = array(
						'title' 	  	=> $this->input->post('title'),
						'description' 	   	=> $this->input->post('description'),
						'user_type' 	   	=> $this->input->post('type'),
						'award_tokens' 	=> $this->input->post('award_tokens'),
						
						'active' 	  	=> 0,
						'created_at' 	 	=> date('Y-m-d h:i:s'),
						'image'=>$_SESSION['c']['last_img']
						 
						
					);

				unset($_SESSION['c']['last_img']);
				
				$uID = $this->front_model->add_query('dev_web_campaigns',$data);
				
				
				$_SESSION['thankyou']="Campaign created!";

				redirect(base_url().'admin/user-onboarding-compaigns');
		}
	}

	}

	public function edit_campaign($id)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){




				if(isset($_POST['title']))
				{
					$data = array(
						'title' 	  	=> $this->input->post('title'),
						'description' 	   	=> $this->input->post('description'),
						'user_type' 	   	=> $this->input->post('type'),
						'award_tokens' 	=> $this->input->post('award_tokens')
					);

					if(isset($_SESSION['c']['last_img'])){
						$data['image']=$_SESSION['c']['last_img'];
						unset($_SESSION['c']['last_img']);
					}





					$condition = array("id" => $id);

					$this->front_model->update_query('dev_web_campaigns',$data,$condition);
					$_SESSION['thankyou'] = "Information updated successfully!";

					 redirect(base_url().'admin/user-onboarding-compaigns');



				}
				else
				{
					$this->data['camp']=$this->front_model->get_query_simple('*','dev_web_campaigns',array('id'=>$id))->result_object()[0];
					$this->load->view('frontend/edit_campaign', $this->data);
				}







				
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}


	}

	public function edit_slide($id)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){




				if(isset($_POST['title']))
				{
					$array = array(
								'title'=>$this->input->post('title'),
								'type'=>$this->input->post('type'),
								'finish_description'=>$this->input->post('description')
								 
								);


							$finish_q = explode('|', $this->input->post('finish_question'))[0];

							if($finish_q!="none")
							{
								$array['finish_question']=explode('|', $this->input->post('finish_question'))[1];
							}



							if(isset($_SESSION['c']['last_img'])){
								$array['image']=$_SESSION['c']['last_img'];
								unset($_SESSION['c']['last_img']);

							}

							



							foreach($this->input->post('section') as $key=>$section)
							{
								$var_ = $key+1;
								$sec_type = explode('|', $section)[0];
								$sec_val =  explode('|', $section)[1];

								if($sec_type=='q')
								{
									
									$var = 'question_'.$var_;

									$array[$var]  = $sec_val;
								}

								if($sec_type=='link')
								{
									
									$var = 'link_'.$var_;

									$array[$var]  = $sec_val;
								}

							}


							
							$uID = $this->front_model->update_query('dev_web_camp_slides',$array,array('id'=>$id));
							
							$_SESSION['thankyou']="Campaign Slide updated created!";

							redirect(base_url().'admin/campaign-slides/'.$this->input->post('camp_id'));
					}


				
				else
				{
					$this->data['slide']=$this->front_model->get_query_simple('*','dev_web_camp_slides',array('id'=>$id))->result_object()[0];
					$this->load->view('frontend/edit_slide', $this->data);
				}







				
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}


	}

	public function campaign_slides($id)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){




				if(isset($_POST['address']))
				{
					$array = array(
						'address'=>$this->input->post('address'),
						'active'=>1,
						'time_active'=>$this->input->post('active_time'),
						'count_down'=>$this->input->post('time'),
						'icon'=>$this->input->post('icon')
					);



					$condition = array("id" => $this->input->post('option_id'));

					$this->front_model->update_query('dev_web_payment_options',$array,$condition);
					$_SESSION['thankyou'] = "Information updated successfully!";

					redirect($_SERVER['HTTP_REFERER']);



				}
				else
				{
					echo $this->data['id']=$id;
					$this->data['slides']=$this->front_model->get_query_simple('*','dev_web_camp_slides',array('camp_id'=>$id))->result_object();
					$this->load->view('frontend/campaign_slides', $this->data);
				}







				
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}



	public function questions()
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){




				if(isset($_POST['q']))
				{
					$array = array(
						'q'=>$this->input->post('q'),
						'required'=>$this->input->post('q')?1:0,
						'placeholder'=>$this->input->post('placeholder')
						
					);



					 

					$this->front_model->add_query('dev_web_slide_qs',$array);
					$_SESSION['thankyou'] = "Question added successfully!";

					redirect(base_url().'admin/questions');



				}
				else
				{
					$this->data['qs']=$this->front_model->get_query_simple('*','dev_web_slide_qs',array())->result_object();
					$this->load->view('frontend/questions', $this->data);
				}







				
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}

	public function edit_question($id)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){




				if(isset($_POST['q']))
				{
					$array = array(
						'q'=>$this->input->post('q'),
						'required'=>$this->input->post('q')?1:0,
						'placeholder'=>$this->input->post('placeholder')
						
					);



					 

					$this->front_model->update_query('dev_web_slide_qs',$array,array('id'=>$id));
					$_SESSION['thankyou'] = "Question added successfully!";

					redirect(base_url().'admin/questions');



				}
				else
				{
					$this->data['q']=$this->front_model->get_query_simple('*','dev_web_slide_qs',array('id'=>$id))->result_object()[0];
					$this->load->view('frontend/edit_question', $this->data);
				}







				
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}



	public function links()
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){




				if(isset($_POST['link']))
				{
					$array = array(
						'link'=>$this->input->post('link'),
						'new_tab'=>$this->input->post('new_tab')==1?1:0,
						'text'=>$this->input->post('text')
						
					);



					 

					$this->front_model->add_query('dev_web_slide_links',$array);
					$_SESSION['thankyou'] = "Link added successfully!";

					redirect(base_url().'admin/links');



				}
				else
				{
					$this->data['links']=$this->front_model->get_query_simple('*','dev_web_slide_links',array())->result_object();
					$this->load->view('frontend/links', $this->data);
				}







				
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}

	public function edit_link($id)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){




				if(isset($_POST['link']))
				{
					$array = array(
						'link'=>$this->input->post('link'),
						'new_tab'=>$this->input->post('new_tab')==1?1:0,
						'text'=>$this->input->post('text')
						
					);



					 

					$this->front_model->update_query('dev_web_slide_links',$array,array('id'=>$id));
					$_SESSION['thankyou'] = "Link added successfully!";

					redirect(base_url().'admin/links');



				}
				else
				{
					$this->data['link']=$this->front_model->get_query_simple('*','dev_web_slide_links',array('id'=>$id))->result_object()[0];
					$this->load->view('frontend/edit_link', $this->data);
				}







				
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}


	public function add_slide($id)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
				$arr = array();
				// $config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);
				// $this->data['countries'] 	= $config->result_object();

				$this->data['id']=$id;
				$this->load->view('frontend/add_slide', $this->data);
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}

	public function add_question()
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
				$arr = array();
				// $config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);
				// $this->data['countries'] 	= $config->result_object();
				$this->load->view('frontend/add_question', $this->data);
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}

	public function add_link()
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
				$arr = array();
				// $config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);
				// $this->data['countries'] 	= $config->result_object();
				$this->load->view('frontend/add_link', $this->data);
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}

	public function do_add_slide()

	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
		
			$rendomcode = $this->generateRandomString();

				$array = array(
					'title'=>$this->input->post('title'),
					'type'=>$this->input->post('type'),
					'camp_id'=>$this->input->post('camp_id'),
					'image'=>$_SESSION['c']['last_img'],
					'finish_description'=>$this->input->post('description')
				);

				$finish_q = explode('|', $this->input->post('finish_question'))[0];

							if($finish_q!="none")
							{
								$array['finish_question']=explode('|', $this->input->post('finish_question'))[1];
							}

				
				unset($_SESSION['c']['last_img']);



				foreach($this->input->post('section') as $key=>$section)
				{
					$var_ = $key+1;
					$sec_type = explode('|', $section)[0];
					$sec_val =  explode('|', $section)[1];

					if($sec_type=='q')
					{
						
						$var = 'question_'.$var_;

						$array[$var]  = $sec_val;
					}

					if($sec_type=='link')
					{
						
						$var = 'link_'.$var_;

						$array[$var]  = $sec_val;
					}

				}


				
				$uID = $this->front_model->add_query('dev_web_camp_slides',$array);
				
				$_SESSION['thankyou']="Campaign Slide created!";

				redirect(base_url().'admin/campaign-slides/'.$array['camp_id']);
		}
	}

	}

	public function take_image_airdrop_cat()
	{


		$post = isset($_POST) ? $_POST: array();

		$max_width = "500"; 

		$return = array('status'=>0,'msg'=>"try again");

		// $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;

		$path = 'resources/uploads/campaigns/landing/';

		$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");

		$name = $_FILES['inputfile']['name'];

		$size = $_FILES['inputfile']['size'];

		if(strlen($name)) {

			list($txt, $ext) = explode(".", $name);

			if(in_array($ext,$valid_formats)) {

				if(1==1) {

					$actual_image_name = "c_".date("ymdhis").'_camp'.'_'.'.'.$ext;

					$filePath = $path .'/'.$actual_image_name;

					$tmp = $_FILES['inputfile']['tmp_name'];

					if(move_uploaded_file($tmp, $filePath)) {

						$return = array('status'=>1,'msg'=>"", 'src'=>base_url().'resources/uploads/campaigns/landing/'.$actual_image_name);

						$_SESSION['c']['last_cat_img']=$actual_image_name;
						
						

						echo json_encode($return); exit;

					}	

					else

					$return['msg']= "failed";

				}

				else

				$return['msg']= "Image file size max 1 MB"; 

			}

			else

			$return['msg']= "Invalid file format.."; 

		}

		else

		$return['msg']= "Please select image..!";


		echo json_encode($return);

		exit;
	}
	public function take_image_camp()
	{


		$post = isset($_POST) ? $_POST: array();

		$max_width = "500"; 

		$return = array('status'=>0,'msg'=>"try again");

		// $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;

		$path = 'resources/uploads/campaigns/';

		$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");

		$name = $_FILES['inputfile']['name'];

		$size = $_FILES['inputfile']['size'];

		if(strlen($name)) {

			list($txt, $ext) = explode(".", $name);

			if(in_array($ext,$valid_formats)) {

				if(1==1) {

					$actual_image_name = "c_".date("ymdhis").'_camp'.'_'.'.'.$ext;

					$filePath = $path .'/'.$actual_image_name;

					$tmp = $_FILES['inputfile']['tmp_name'];

					if(move_uploaded_file($tmp, $filePath)) {

						$return = array('status'=>1,'msg'=>"", 'src'=>base_url().'resources/uploads/campaigns/'.$actual_image_name);

						$_SESSION['c']['last_img']=$actual_image_name;
						
						

						echo json_encode($return); exit;

					}	

					else

					$return['msg']= "failed";

				}

				else

				$return['msg']= "Image file size max 1 MB"; 

			}

			else

			$return['msg']= "Invalid file format.."; 

		}

		else

		$return['msg']= "Please select image..!";


		echo json_encode($return);

		exit;
	}
	public function submit_campaign()
	{

		$campaign_id  = $this->input->post('campaign_id');

		$campaign = $this->front_model->get_query_simple('*','dev_web_campaigns',array('id'=>$campaign_id))->result_object()[0];

 

		$slides = $this->front_model->get_query_simple('*','dev_web_camp_slides',array('camp_id'=>$campaign->id))->result_object();


		$qi = 0;

		foreach($slides as $key=>$slide){



			if($slide->type==1){


				 $arr = array(   	'question_1'=>$slide->question_1,
                                	'question_2'=>$slide->question_2,
                                	'question_3'=>$slide->question_3,
                                	'question_4'=>$slide->question_4
                            );


				 for ($i=1; $i<=4; $i++) {

                                        $var_a = 'question_'.$i;


                                        if($arr[$var_a]!=0)
                    					{

                    						echo $this->input->post('questions')[$qi];
                    						

                    						$array = array();
                    						

                    						$array = array(
                    							'q_id'=>$arr[$var_a],
                    							'ans'=>$this->input->post('questions')[$qi],
                    							'camp_id'=>$campaign_id,
                    							'q_type'=>1,
                    							'uIP'=>$_SERVER['REMOTE_ADDR'],
                    							'created_at'=>date("Y-m-d H:i:s"),
                    							'uID'=>UID

                    						);

                    						$qi++;


                    						$this->front_model->add_query('dev_web_camp_ans',$array);



                    					 


                    					}
                                       


                                    }


			}
			else
			{


				if(isset($_POST['finish_question'])){
					$array = array(
						'q_id'=>$slide->finish_question,
						'ans'=>$this->input->post('finish_question'),
						'camp_id'=>$campaign_id,
						'q_type'=>2,
						'uIP'=>$_SERVER['REMOTE_ADDR'],
						'created_at'=>date("Y-m-d H:i:s"),
                    	'uID'=>UID


					);



					if($slide->finish_question==3){
						$this->front_model->update_query('dev_web_user',array('uWallet'=>$array['ans']),array('uID'=>UID));
					}
// 1multi
// 2delete
// 3uid

					$this->front_model->add_query('dev_web_camp_ans',$array);
				}

			}
		}

		










		




		$_SESSION['thankyou'] = "Submitted Successfully!";
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function skip_intro()
	{
		$_SESSION['snooze_intro']=1;
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function unskip_intro()
	{
		unset($_SESSION['snooze_intro']);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function  take_image_setting()
	{
		$post = isset($_POST) ? $_POST: array();

		$max_width = "500"; 

		$return = array('status'=>0,'msg'=>"try again");

		// $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;

		$path = 'resources/uploads/settings/';

		$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");

		$name = $_FILES['inputfile']['name'];

		$size = $_FILES['inputfile']['size'];

		if(strlen($name)) {

			list($txt, $ext) = explode(".", $name);

			if(in_array($ext,$valid_formats)) {

				if(1==1) {

					$actual_image_name = "c_".date("ymdhis").'_camp'.'_'.'.'.$ext;

					$filePath = $path .'/'.$actual_image_name;

					$tmp = $_FILES['inputfile']['tmp_name'];

					if(move_uploaded_file($tmp, $filePath)) {

						$return = array('status'=>1,'msg'=>"", 'src'=>base_url().'resources/uploads/settings/'.$actual_image_name);

						$_SESSION['c']['last_img_settings']=$actual_image_name;
						
						

						echo json_encode($return); exit;

					}	

					else

					$return['msg']= "failed";

				}

				else

				$return['msg']= "Image file size max 1 MB"; 

			}

			else

			$return['msg']= "Invalid file format.."; 

		}

		else

		$return['msg']= "Please select image..!";


		echo json_encode($return);

		exit;
	}

	public function  take_image_profile()
	{
		$post = isset($_POST) ? $_POST: array();

		$max_width = "500"; 

		$return = array('status'=>0,'msg'=>"try again");

		// $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;

		$path = 'resources/uploads/profile/';

		$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");

		$name = $_FILES['inputfile']['name'];

		$size = $_FILES['inputfile']['size'];

		if(strlen($name)) {

			list($txt, $ext) = explode(".", $name);

			if(in_array($ext,$valid_formats)) {

				if(1==1) {

					$actual_image_name = "c_".date("ymdhis").'_camp'.'_'.'.'.$ext;

					$filePath = $path .'/'.$actual_image_name;

					$tmp = $_FILES['inputfile']['tmp_name'];

					if(move_uploaded_file($tmp, $filePath)) {

						$return = array('status'=>1,'msg'=>"", 'src'=>base_url().'resources/uploads/profile/'.$actual_image_name);

						$_SESSION['c']['last_img_profile']=$actual_image_name;
						
						

						echo json_encode($return); exit;

					}	

					else

					$return['msg']= "failed";

				}

				else

				$return['msg']= "Image file size max 1 MB"; 

			}

			else

			$return['msg']= "Invalid file format.."; 

		}

		else

		$return['msg']= "Please select image..!";


		echo json_encode($return);

		exit;
	}
	public function update_profile_pic()
	{
		if(isset($_SESSION['c']['last_img_profile']))
		{
			$this->front_model->update_query('dev_web_user',array('uImage'=>$_SESSION['c']['last_img_profile']),array('uID'=>UID));

		}
		$_SESSION['thankyou']="Profile image updated successfully!";
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function remove_profile_pic()
	{


		

			$this->front_model->update_query('dev_web_user',array('uImage'=>'default.svg'),array('uID'=>UID));

		
		$_SESSION['thankyou']="Profile image removed successfully!";
		redirect($_SERVER['HTTP_REFERER']);


		
	}
	public function ico_setting_status($s,$v)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

		if($s==1){

			$this->front_model->update_query('dev_web_ico_settings',array('active'=>0),array());
			$this->front_model->update_query('dev_web_ico_settings',array('active'=>1),array('id'=>$v));
		}
		else
		{
			$this->front_model->update_query('dev_web_ico_settings',array('active'=>0),array('id'=>$v));
		}

		$_SESSION['thankyou']="Action performed successfully!";
		redirect($_SERVER['HTTP_REFERER']);

		}
		}
	}
	public function ico_airdrop_submission_status($s,$v)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

		if($s==1){

			$this->front_model->update_query('dev_web_airdrop_submissions',array('status'=>1),array('id'=>$v));


			$submission = $this->front_model->get_query_simple('*','dev_web_airdrop_submissions',array('id'=>$v))->result_object()[0];


			$campaign = $this->front_model->get_query_simple('*','dev_web_airdrop_campaigns',array('id'=>$submission->camp_id))->result_object()[0];





			// $tokens = $this->front_model->get_query_simple('*','dev_web_user',array('uID'=>UID))->result_object()[0]->tokens;

			// $this->front_model->update_query('dev_web_user',array('tokens'=>$tokens+$campaign->award_tokens),array('uID'=>UID));

			// print_r($campaign);exit;

			$arr = array(
						'tokens'=>get_my_tokens($submission->uID)+$campaign->award_tokens,
						// 'currency'=>$_SESSION['buy_step_1']['option'],
						// 'amountPaid'=>$_SESSION['crypto_required'],
						// 'amtType'=>$this->data['option']->name,
						// 'usdPayment'=>$total_price,
						'hash'=>guid(),
						'status'=>2,
						'datecreated'=>date("Y-m-d H:i:s"),
						'uIP'=>$_SERVER['REMOTE_ADDR'],
						'uID'=>$submission->uID,
						'transaction_id'=>guid(),
						't_type'=>2
					);

			$this->front_model->add_query('dev_web_transactions',$arr);

		}
		else
		{
			$this->front_model->update_query('dev_web_airdrop_submissions',array('status'=>2),array('id'=>$v));
		}

		$_SESSION['thankyou']="Action performed successfully!";
		redirect($_SERVER['HTTP_REFERER']);

		}
		}
	}
	public function ico_airdrop_camp_status($s,$v)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

		

			$this->front_model->update_query('dev_web_airdrop_campaigns',array('active'=>$s),array('id'=>$v));
	
		

		$_SESSION['thankyou']="Action performed successfully!";
		redirect($_SERVER['HTTP_REFERER']);

		}
		}
	}
	public function ico_airdrop_cat_status($s,$v)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

		

			$this->front_model->update_query('dev_web_airdrop_cats',array('active'=>$s),array('id'=>$v));
	
		

		$_SESSION['thankyou']="Action performed successfully!";
		redirect($_SERVER['HTTP_REFERER']);

		}
		}
	}
	public function delete_airdrop_submission($v)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
		$this->front_model->delete_query('dev_web_airdrop_submissions',array('id'=>$v));

		$_SESSION['thankyou']="Action performed successfully!";
		redirect($_SERVER['HTTP_REFERER']);

		}
		}
	}
	public function delete_ico_setting($v)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
		$this->front_model->delete_query('dev_web_ico_settings',array('id'=>$v));

		$_SESSION['thankyou']="Action performed successfully!";
		redirect($_SERVER['HTTP_REFERER']);

		}
		}
	}

	public function delete_ico_airdrop_cat($v)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
		$this->front_model->delete_query('dev_web_airdrop_cats',array('id'=>$v));

		$_SESSION['thankyou']="Action performed successfully!";
		redirect($_SERVER['HTTP_REFERER']);

		}
		}
	}

	
	public function ico_airdrop_camp_delete($v)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
			$this->front_model->delete_query('dev_web_airdrop_campaigns',array('id'=>$v));

			$_SESSION['thankyou']="Action performed successfully!";
			redirect($_SERVER['HTTP_REFERER']);

		}
		}
	}


	public function ico_settings()
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
					$this->load->view('frontend/ico_settings', $this->data);
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

		

	}

	public function add_ico_setting()
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){


				if(isset($_POST['camp_type']))
				{

					$arr = array(
						'camp_type'=>$this->input->post('camp_type'),
						'title'=>$this->input->post('title'),
						'start_date'=>$this->input->post('start_date'),
						'end_date'=>$this->input->post('end_date'),
						'token_symbol'=>$this->input->post('token_symbol'),
						'total_tokens_issued'=>$this->input->post('total_tokens_issued'),
						'tokens_for_sale'=>$this->input->post('tokens_for_sale'),
						'min_raise_amount'=>$this->input->post('min_raise_amount'),
						'max_raise_amount'=>$this->input->post('max_raise_amount'),

						
						'active'=>0
					);

					if(isset($_SESSION['c']['last_img_settings']))
					{
						$arr['image']=$_SESSION['c']['last_img_settings'];
						unset($_SESSION['c']['last_img_settings']);
					}
				




					$payment_option = $this->front_model->add_query('dev_web_ico_settings',$arr);
					$_SESSION['thankyou']="ICO Setting added successfully!";


					redirect(base_url().'admin/ico-settings');



				}
				else
				{
			
					$this->load->view('frontend/add_ico_setting', $this->data);


				}
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

		

	}

	public function edit_ico_setting($id)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){


				if(isset($_POST['camp_type']))
				{

					$arr = array(
						'title'=>$this->input->post('title'),
						'camp_type'=>$this->input->post('camp_type'),
						'start_date'=>$this->input->post('start_date'),
						'end_date'=>$this->input->post('end_date'),
						'token_symbol'=>$this->input->post('token_symbol'),
						'total_tokens_issued'=>$this->input->post('total_tokens_issued'),
						'tokens_for_sale'=>$this->input->post('tokens_for_sale'),
						'min_raise_amount'=>$this->input->post('min_raise_amount'),
						'max_raise_amount'=>$this->input->post('max_raise_amount'),
						 
					);

					if(isset($_SESSION['c']['last_img_settings']))
					{
						$arr['image']=$_SESSION['c']['last_img_settings'];
						unset($_SESSION['c']['last_img_settings']);
					}
				




					$payment_option = $this->front_model->update_query('dev_web_ico_settings',$arr,array('id'=>$id));
					$_SESSION['thankyou']="ICO Setting updated successfully!";

					redirect(base_url().'admin/ico-settings');



				}
				else
				{
					$this->data['setting']=$this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$id))->result_object()[0];
			
					$this->load->view('frontend/edit_ico_setting', $this->data);


				}
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

		

	}
	public function airdrop_campaigns()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
					$this->load->view('frontend/airdrop_campaigns', $this->data);
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}
	public function airdrop_landing_page()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
					$this->load->view('frontend/airdrop_cats', $this->data);
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}
	
	public function airdrop_submissions()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){
					$this->load->view('frontend/airdrop_submissions', $this->data);
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}
	public function bounties()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "2"){
					$this->load->view('frontend/bounties_landing', $this->data);
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}
	public function bounties_list($slug)
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "2"){
				$this->data['slug']=$slug;
					$this->load->view('frontend/bounties', $this->data);
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}
	public function tranasctions()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "2"){
					$this->load->view('frontend/tranasctions', $this->data);
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}
	}
	public function add_airdrop_campaign()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){


				if(isset($_POST['camp_type']))
				{

					$arr = array(
						'name'=>$this->input->post('name'),
						'camp_type'=>$this->input->post('camp_type'),
						'start_date'=>$this->input->post('start_date'),
						'end_date'=>$this->input->post('end_date'),
						'what_to_do'=>$this->input->post('what_to_do'),
						'bounty_qty'=>$this->input->post('bounty_qty'),
						'bounty_persons'=>$this->input->post('bounty_persons'),
						'proof_type'=>$this->input->post('proof_type'),
						'details'=>$this->input->post('details'),
						'rules'=>$this->input->post('rules'),
						
						'active'=>0
					);


					foreach($this->input->post('custom') as $key=>$custom)
					{
						$arr_[] = array('q'=>$custom,'r'=>$this->input->post('required')[$key]==1?1:0);
					}

					$arr['costum_form']=json_encode($arr_);


					// if(isset($_SESSION['c']['last_img_settings']))
					// {
					// 	$arr['image']=$_SESSION['c']['last_img_settings'];
					// 	unset($_SESSION['c']['last_img_settings']);
					// }
				




					$payment_option = $this->front_model->add_query('dev_web_airdrop_campaigns',$arr);
					$_SESSION['thankyou']="Airdrop Campaign added successfully!";


					redirect(base_url().'admin/bounty-campaigns');



				}
				else
				{
			
					$this->load->view('frontend/add_airdrop_campaign', $this->data);


				}
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}
	}

	public function edit_airdrop_campaign($id)
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){


				if(isset($_POST['camp_type']))
				{

					$arr = array(
						'name'=>$this->input->post('name'),
						'camp_type'=>$this->input->post('camp_type'),
						'start_date'=>$this->input->post('start_date'),
						'end_date'=>$this->input->post('end_date'),
						'what_to_do'=>$this->input->post('what_to_do'),
						'bounty_qty'=>$this->input->post('bounty_qty'),
						'bounty_persons'=>$this->input->post('bounty_persons'),
						'proof_type'=>$this->input->post('proof_type'),
						'details'=>$this->input->post('details'),
						'rules'=>$this->input->post('rules'),
						
						 
					);


					foreach($this->input->post('custom') as $key=>$custom)
					{
						$arr_[] = array('q'=>$custom,'r'=>$this->input->post('required')[$key]==1?1:0);
					}

					$arr['costum_form']=json_encode($arr_);


					// if(isset($_SESSION['c']['last_img_settings']))
					// {
					// 	$arr['image']=$_SESSION['c']['last_img_settings'];
					// 	unset($_SESSION['c']['last_img_settings']);
					// }
				




					$payment_option = $this->front_model->update_query('dev_web_airdrop_campaigns',$arr,array('id'=>$id));
					$_SESSION['thankyou']="Airdrop Campaign added successfully!";


					redirect(base_url().'admin/bounty-campaigns');



				}
				else
				{

					$this->data['camp']=$this->front_model->get_query_simple('*','dev_web_airdrop_campaigns',array('id'=>$id))->result_object()[0];
			
					$this->load->view('frontend/edit_airdrop_campaign', $this->data);


				}
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}
	}
	public function submit_airdrop_campaign($id)
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "2"){

                                       $already_submitted = $this->front_model->get_query_simple('*','dev_web_airdrop_submissions',array('uID'=>UID,'id'=>$id))->num_rows();

                                        if($already_submitted!=0)
                                        {
                                        	redirect(base_url());
                                        	exit;
                                        }

                                    





				if(isset($_POST['camp_id']))
				{

					$arr = array(
						'url'=>$this->input->post('url'),
						'camp_id'=>$id,
						'uID'=>UID,
						'created_at'=>date("Y-m-d H:i:s")
					);


					$this->data['bounty']=$this->front_model->get_query_simple('*','dev_web_airdrop_campaigns',array('id'=>$id))->result_object()[0];


					$qs = json_decode($this->data['bounty']->costum_form);




					foreach($this->input->post('custom') as $key=>$custom)
					{
						$arr_[] = array('q'=>$qs[$key]->q,'a'=>$custom);
					}

					$arr['ans']=json_encode($arr_);




					if(isset($_SESSION['c']['last_proof_file']))
					{
						$arr['file']=$_SESSION['c']['last_proof_file'];
						unset($_SESSION['c']['last_proof_file']);
					}
				




					$payment_option = $this->front_model->add_query('dev_web_airdrop_submissions',$arr);
					$_SESSION['thankyou']="Bounty Campaign submitted successfully!";


					redirect(base_url().'bounties');



				}
				else
				{

					$this->data['bounty']=$this->front_model->get_query_simple('*','dev_web_airdrop_campaigns',array('id'=>$id))->result_object()[0];

			
					$this->load->view('frontend/submit_airdrop_campaign', $this->data);


				}
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}
	}
	public function view_airdrop_campaign($id)
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "2"){

					$this->data['bounty']=$this->front_model->get_query_simple('*','dev_web_airdrop_campaigns',array('id'=>$id))->result_object()[0];

					$this->data['camp_type']=$this->front_model->get_query_simple('*','dev_web_airdrop_cats',array('id'=>$this->data['bounty']->camp_type))->result_object()[0];


					$this->load->view('frontend/view_airdrop_campaign', $this->data);
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}
	}


public function  take_image_logo()
	{
		$post = isset($_POST) ? $_POST: array();

		$max_width = "500"; 

		$return = array('status'=>0,'msg'=>"try again");

		// $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;

		$path = 'resources/frontend/images/';

		$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");

		$name = $_FILES['inputfile']['name'];

		$size = $_FILES['inputfile']['size'];

		if(strlen($name)) {

			list($txt, $ext) = explode(".", $name);

			if(in_array($ext,$valid_formats)) {

				if(1==1) {

					$actual_image_name = "c_".date("ymdhis").'_camp'.'_'.'.'.$ext;

					$filePath = $path .'/'.$actual_image_name;

					$tmp = $_FILES['inputfile']['tmp_name'];

					if(move_uploaded_file($tmp, $filePath)) {

						$return = array('status'=>1,'msg'=>"", 'src'=>base_url().'resources/frontend/images/'.$actual_image_name);

						$_SESSION['c']['logo']=$actual_image_name;
						


						
						

						echo json_encode($return); exit;

					}	

					else

					$return['msg']= "failed";

				}

				else

				$return['msg']= "Image file size max 1 MB"; 

			}

			else

			$return['msg']= "Invalid file format.."; 

		}

		else

		$return['msg']= "Please select image..!";


		echo json_encode($return);

		exit;
	}
	public function  take_proof_file()
	{
		$post = isset($_POST) ? $_POST: array();

		$max_width = "500"; 

		$return = array('status'=>0,'msg'=>"try again");

		// $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;

		$path = 'resources/uploads/airdrops/';

		$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","pdf","PDF","doc","DOC","DOCX","docx");

		$name = $_FILES['inputfile']['name'];

		$size = $_FILES['inputfile']['size'];

		if(strlen($name)) {

			list($txt, $ext) = explode(".", $name);

			if(in_array($ext,$valid_formats)) {

				if(1==1) {

					$actual_image_name = "c_".date("ymdhis").'_camp'.'_'.'.'.$ext;

					$filePath = $path .'/'.$actual_image_name;

					$tmp = $_FILES['inputfile']['tmp_name'];

					if(move_uploaded_file($tmp, $filePath)) {

						$return = array('status'=>1,'msg'=>"", 'src'=>base_url().'resources/uploads/airdrops/'.$actual_image_name,'type'=>1);

						$_SESSION['c']['last_proof_file']=$actual_image_name;
						if(in_array($ext, array("pdf","PDF","doc","DOC","DOCX","docx")))
							$return['type']=2;


						
						

						echo json_encode($return); exit;

					}	

					else

					$return['msg']= "failed";

				}

				else

				$return['msg']= "Image file size max 1 MB"; 

			}

			else

			$return['msg']= "Invalid file format.."; 

		}

		else

		$return['msg']= "Please select image..!";


		echo json_encode($return);

		exit;
	}
	
	public function view_airdrop_submission($id)
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

					$this->data['submission']=$this->front_model->get_query_simple('*','dev_web_airdrop_submissions',array('id'=>$id))->result_object()[0];

					$this->load->view('frontend/view_airdrop_submission', $this->data);
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}
	}

	public function settings()
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){


				if(isset($_POST['configAddress']))
				{

					$arr = array(
						'configWeb'=>$this->input->post('configWeb'),
						'configTitle'=>$this->input->post('configTitle'),
						'configURL'=>$this->input->post('configURL'),
						'configPhone'=>$this->input->post('configPhone'),
						'configEmail'=>$this->input->post('configEmail'),
						'configAddress'=>$this->input->post('configAddress'),
						'configCopy'=>$this->input->post('configCopy'),
						'configFacebook'=>$this->input->post('configFacebook'),
						'webGoogle'=>$this->input->post('webGoogle'),
						'webLkndIn'=>$this->input->post('webLkndIn'),
						'configTwitter'=>$this->input->post('configTwitter'),
						'color'=>$this->input->post('color'),
						'google_analytics'=>$this->input->post('google_analytics'),

						
						 
					);

					if(isset($_SESSION['c']['logo']))
					{
						$arr['logo']=$_SESSION['c']['logo'];
						unset($_SESSION['c']['logo']);
					}
				




					$payment_option = $this->front_model->update_query('dev_web_config',$arr,array('cID'=>1));
					$_SESSION['thankyou']="Setting updated successfully!";

					redirect(base_url().'admin/settings');



				}
				else
				{
					$this->data['setting']=$this->front_model->get_query_simple('*','dev_web_config',array('cID'=>1))->result_object()[0];
			
					$this->load->view('frontend/settings', $this->data);


				}
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

		

	}
	public function support()
	{
		if(!isset($_SESSION['JobsSessions'])){
				header ( "Location:" . $this->config->base_url ()."login");
			}
			else {
				if(ACTYPE == "1"){


						$this->load->view('frontend/support', $this->data);
				
				} else {
					$this->load->view('frontend/home', $this->data);
				}
			}
	}
	public function marketing_suites()
	{
		if(!isset($_SESSION['JobsSessions'])){
				header ( "Location:" . $this->config->base_url ()."login");
			}
			else {
				if(ACTYPE == "1"){
						$this->load->view('frontend/marketing_suites', $this->data);
				
				} else {
					$this->load->view('frontend/home', $this->data);
				}
			}
	}
	public function kyc_aml()
	{
		if(!isset($_SESSION['JobsSessions'])){
				header ( "Location:" . $this->config->base_url ()."login");
			}
			else {
				if(ACTYPE == "1"){
						$this->load->view('frontend/kyc_aml', $this->data);
				
				} else {
					$this->load->view('frontend/home', $this->data);
				}
			}
	}
	public function add_airdrop_cat()
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){



				if(isset($_POST['title']))
				{
				// echo $_SESSION['last_cat_img'];exit;


					$slug=$this->get_slug($this->input->post('title'),'dev_web_airdrop_cats',array('do'=>'add','id'=>0));
				


					$arr = array(
						'title'=>$this->input->post('title'),
						'slug'=>$slug,
						'description'=>$this->input->post('description'),
						'active'=>1,
						'created_at'=>date("Y-m-d H:i:s"),
						'image'=>$_SESSION['c']['last_cat_img']

					);
					unset($_SESSION['c']['last_cat_img']);

					$this->front_model->add_query('dev_web_airdrop_cats',$arr);
					$_SESSION['thankyou']="Item added successfully!";
					 

					redirect(base_url().'admin/bounty-landing-page');



				}
				else
				{
			
					
					$this->load->view('frontend/add_airdrop_cat', $this->data);


				}
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

		
// last_cat_img
	}

	public function edit_airdrop_cat($id)
	{

		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){


				if(isset($_POST['title']))
				{


					$slug=$this->get_slug($this->input->post('title'),'dev_web_airdrop_cats',array('do'=>'add','id'=>0));
				


					$arr = array(
						'title'=>$this->input->post('title'),
						'slug'=>$slug,
						'description'=>$this->input->post('description'),
						// 'active'=>1,
						// 'created_at'=>date("Y-m-d H:i:s"),

					);

					// echo $_SESSION['last_cat_img'];exit;

					if(isset($_SESSION['c']['last_cat_img'])){
						$arr['image']=$_SESSION['c']['last_cat_img'];
						unset($_SESSION['c']['last_cat_img']);
					}

					$this->front_model->update_query('dev_web_airdrop_cats',$arr,array('id'=>$id));
					$_SESSION['thankyou']="Item updated successfully!";
					 

					redirect(base_url().'admin/bounty-landing-page');



				}
				else
				{
			
					$this->data['cat']=$this->front_model->get_query_simple('*','dev_web_airdrop_cats',array('id'=>$id))->result_object()[0];
					$this->load->view('frontend/edit_airdrop_cat', $this->data);


				}
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

		
// last_cat_img
	}

	function get_slug($title,$table,$type)
	{


		if($type['do']=="add")
		{
			$con_1 = array('slug'=>$slug_);
			$con_2  = array('slug'=>$slug_.'-'.$i+2);
		}
		else
		{
			$con_1 = array('slug'=>$slug_,'id !='=>$type['id']);
			$con_2  = array('slug'=>$slug_.'-'.$i+2,'id !='=>$type['id']);
		}

		$slug_ = url_title(strtolower( preg_replace("/[^a-zA-Z0-9 ]+/", "", $title)));


		$old = $this->front_model->get_query_simple('*',$table,array('slug'=>$slug_))->num_rows();

		if($old==0) return $slug_;


		$i = 0; 

		for($i=0; $i<=20; $i++)
		{
			$old = $this->front_model->get_query_simple('*',$table,array())->num_rows();

			if($old==0) return $slug_.'-'.$i+2;


		}

		return $slug_.'-'.$this->generateRandomString(5);

	}

	public function verify_captcha()
	{


		#
		# Verify captcha
		$post_data = http_build_query(
		    array(
		        'secret' => '6LfwclQUAAAAAPXZPH6utIL4eI3lHXpyZQ_n-zo4',
		        'response' => $_POST['g-recaptcha-response'],
		        'remoteip' => $_SERVER['REMOTE_ADDR']
		    )
		);
		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/x-www-form-urlencoded',
		        'content' => $post_data
		    )
		);
		$context  = stream_context_create($opts);
		$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
		$result = json_decode($response);

		return $result->success;
	}

	// SEND SMS
	public function send_sms_verification(){
			error_reporting(-1);		
		require APPPATH.'../twilio-php-master/Twilio/autoload.php';
		// Use the REST API Client to make requests to the Twilio REST API
			
			// Your Account SID and Auth Token from twilio.com/console
			$sid = 'AC0243089e90d309713e3a3047e5584905';
			$token = '53f6d6faacb3476ff90a57f4a095d0ce';
			$client = new Client($sid, $token);

			// Use the client to do fun stuff like send text messages!

			try{
			$response = $client->messages->create(
				// the number you'd like to send the message to
				'923009550284',
				array(
					// A Twilio phone number you purchased at twilio.com/console
					'from' => '+12488142017',
					// the body of the text message you'd like to send
					'body' => 'Hey Jenny! Good luck on the bar exam!'
				)
			);

			}
			catch(Exception $e){	

				session_destroy();


				$_SESSION['error']="Error! Error code: ".$e->getCode()." Error: ".$e->getMessage().".<br>Please contact with administration if you're receiving thsi error continuously";;

				 

				redirect(base_url().'login');

			}

			echo "<pre>";
		
		print_r($response);
	}

	public function two_factor_settings()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){


				if(isset($_POST['sid']))
				{

					$arr = array(
						'sid'=>$this->input->post('sid'),
						'skey'=>$this->input->post('skey'),
						'after_type'=>$this->input->post('after_type'),
						'after_qty'=>$this->input->post('after_qty'),
						'from_number'=>$this->input->post('from_number'),
						'required'=>$this->input->post('required')?1:0
						 
						  
					);



					$payment_option = $this->front_model->update_query('dev_web_two_factor',$arr,array('id'=>1));
					$_SESSION['thankyou']="Setting updated successfully!";

					redirect($_SERVER['HTTP_REFERER']);



				}
				else
				{
					$this->data['setting']=$this->front_model->get_query_simple('*','dev_web_two_factor',array('id'=>1))->result_object()[0];
			
					$this->load->view('frontend/two_factor', $this->data);


				}
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}

	}
	public function disable_uf($id)
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){


				// $u_type = $this->front_model->get_query_simple('*','dev_web_campaigns',array('id'=>$id))->result_object[0]->user_type;



				// $this->front_model->update_query('dev_web_campaigns',array('active'=>0),array('user_type'=>$u_type));
				$this->front_model->update_query('dev_web_campaigns',array('active'=>0),array('id'=>$id));
				$_SESSION['thankyou'] = "User Verifications are now in-active";
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}
	public function enable_uf($id)
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){


				$u_type = $this->front_model->get_query_simple('*','dev_web_campaigns',array('id'=>$id))->result_object[0]->user_type;



				$this->front_model->update_query('dev_web_campaigns',array('active'=>0),array('user_type'=>$u_type));
				$this->front_model->update_query('dev_web_campaigns',array('active'=>1),array('id'=>$id));
				$_SESSION['thankyou'] = "User Verifications are now active. Make sure to <a href='".base_url().'admin/edit-campaign/'.$id."'>click here</a> to view/edit the on-boarding slides";
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}

	public function create_smart_contract()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

				if(isset($_POST['token_name']))
				{
					$_SESSION['contract']['step1']=$_POST;

					redirect(base_url().'admin/create-smart-contract/step-2');

					exit;

				}
				else
				{
					$this->data['step']=1;
					$this->load->view('frontend/create_smart_contract',$this->data);
				}

			}
		}
	}


	public function create_smart_contract_step_2()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

				if(isset($_POST['phase_name']))
				{
					$_SESSION['contract']['step2']=$_POST;

					redirect(base_url().'admin/create-smart-contract/step-3');

					exit;

				}
				else
				{
					$this->data['step']=2;
					$this->load->view('frontend/create_smart_contract',$this->data);
				}

			}
		}
	}

	public function create_smart_contract_step_3()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

				if(isset($_POST['owner_ethereum_address']))
				{

					$arr = array(
						'token_name'=>$_SESSION['contract']['step1']['token_name'],
						'token_symbol'=>$_SESSION['contract']['step1']['token_symbol'],
						'ico_start_date'=>$_SESSION['contract']['step1']['ico_start_date'],
						'ico_end_date'=>$_SESSION['contract']['step1']['ico_end_date'],
						'min_cpa_in_eth'=>$_SESSION['contract']['step1']['min_cpa_in_eth'],
						'tokens_per_eth'=>$_SESSION['contract']['step1']['tokens_per_eth'],
						'max_token_supply'=>$_SESSION['contract']['step1']['max_token_supply'],
						'phase_name'=>$_SESSION['contract']['step2']['phase_name'],
						'start_date'=>$_SESSION['contract']['step2']['start_date'],
						'end_date'=>$_SESSION['contract']['step2']['end_date'],
						'max_token_supply_2'=>$_SESSION['contract']['step2']['max_token_supply_2'],
						'contract_address'=>$_SESSION['contract']['step2']['contract_address'],
						'notifier_private_key'=>$_SESSION['contract']['step2']['notifier_private_key'],
						'owner_ethereum_address'=>$this->input->post('owner_ethereum_address'),
						'created_at'=>date("Y-m-d H:i:s"),
						'created_by'=>UID
					
					);


					unset($_SESSION['contract']);


					$this->front_model->add_query('dev_web_smart_contracts',$arr);

					$_SESSION['thankyou']="Smart Contract created successfully!";
					 
// 
					redirect(base_url().'admin/create-smart-contract');

					exit;

				}
				else
				{
					$this->data['step']=3;
					$this->load->view('frontend/create_smart_contract',$this->data);
				}

			}
		}
	}

	public function submitted_smart_contracts()
	{
		if(!isset($_SESSION['JobsSessions'])){
				header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

					$this->data['contracts']=$this->front_model->get_query_simple('*','dev_web_smart_contracts',array())->result_object();
					$this->load->view('frontend/submitted_smart_contracts', $this->data);
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}
	}
	public function ico_delete_smart_contract($id)
	{
		if(!isset($_SESSION['JobsSessions'])){
				header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

				$this->front_model->delete_query('dev_web_smart_contracts',array('id'=>$id));
				$_SESSION['thankyou']="Smart Contract deleted successfully!";
				redirect($_SERVER['HTTP_REFERER']);
					
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}
	}

	public function view_smart_contract($id)
	{
		if(!isset($_SESSION['JobsSessions'])){
				header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

				$this->data['contract']=$this->front_model->get_query_simple('*','dev_web_smart_contracts',array('id'=>$id))->result_object()[0];
				$this->load->view('frontend/view_smart_contract',$this->data);					
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}
	}
	public function bounty_missions()
	{
		if(!isset($_SESSION['JobsSessions'])){
				header ( "Location:" . $this->config->base_url ()."login");
		}
		else {
			if(ACTYPE == "1"){

				$this->load->view('frontend/bounty_missions',$this->data);					
			
			} else {
				$this->load->view('frontend/home', $this->data);
			}
		}
	}


// SEND EMAIL 
	
public function send_email_password(){
		 // SEND TO ADMIN
				$edata = $this->front_model->get_emails_data('access-password-ico');
				$this->load->library('email');
				$this->email->from($edata[0]->eEmail, TITLEWEB);
				$this->email->to('bjosic@gmail.com'); 
				$replace = array("[WEBURL]","[CODE]","[NAME]","[WEBTITLE]","[USEREMAIL]","[COMPANY]","[WEBSITE]");
				$replacewith = array(WEBURL, $rendomcode, $this->input->post('namesender'),TITLEWEB,$this->input->post('emailsend'),$this->input->post('companysend'),$this->input->post('urlsend'));
				$str = str_replace($replace,$replacewith,$edata[0]->eContent);
				$message = $str;
				$this->email->subject($edata[0]->eName);
				$this->email->message($message);
				$this->email->set_mailtype("html");
				$send = $this->email->send();
		
			// SEND TO USER
				$edata = $this->front_model->get_emails_data('access-password-ico-user');
				$this->load->library('email');
				$this->email->from($edata[0]->eEmail, TITLEWEB);
				$this->email->to($this->input->post('emailsend')); 
				$replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]","[URL]");
				$replacewith = array(WEBURL, $rendomcode, $this->input->post('namesender'),TITLEWEB,WEBURL);
				$str = str_replace($replace,$replacewith,$edata[0]->eContent);
				$message = $str;
				$this->email->subject($edata[0]->eName);
				$this->email->message($message);
				$this->email->set_mailtype("html");
				$send = $this->email->send();
		
				$_SESSION['thankyou'] = "Requested password has been sent to your email address.";
				header ( "Location:".$_SERVER['HTTP_REFERER']);
	}


}



/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */