<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class jobsite extends CI_Controller {
	 
	private $data=array();	
	function __construct()
	{
		parent::__construct();
		ob_start();
		error_reporting(0);
		$this->load->library('form_validation');
		$this->load->helper('url');
		
		$this->load->database();
		$this->db->reconnect();
		$this->load->model('front_model'); //Load frontend model
		session_start();
		
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
	// HOME PAGE
	public function index()
	{
		// GET LATEST JOBS
		$jobs = $this->front_model->get_jobs_list(0,6);
		$this->data['jobs'] = $jobs->result_object();
		$this->load->view('frontend/home',$this->data);
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
		$arr = array(
			'uEmail'	=>	$this->input->post('emailadd'),
			'uPassword' =>	md5($this->input->post('passlogin')),
		);
		$datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);
		$count = $datashow->num_rows();
		if($count > 0){
			$row = $datashow->result_object();
			$_SESSION['JobsSessions'] 	= $row;
			$data = array(
				'uIP' 		   => $_SERVER['REMOTE_ADDR'],
				'uLoginLast' 	=> date("Y-m-d h:i:s"),
			);
			$condition = array('uID' => $_SESSION['JobsSessions'][0]->uID);
			
			$this->front_model->update_query('dev_web_user',$data,$condition);
			if(isset($_SESSION['saveid'])){
				$this->save_job_session();
				exit();
			}
			else if(isset($_SESSION['applyidsession'])){
				header ( "Location:" . $_SERVER['HTTP_REFERER']."?apply=yes");
			}
			else if($this->input->post('returl') != ""){
				//echo "bbb";
				header ( "Location:" . $this->input->post('returl'));
			}
			else {
				if($this->input->post('urlredirect') != ""){
					header ( "Location:" . $this->config->base_url ().$this->input->post('urlredirect'));
				}else {
					header ( "Location:" . $this->config->base_url ().'dashboard');
				}
			}
		}
		else
		{
			$_SESSION['msglogin'] = 'Invalid login credentials!';
			if($this->input->post('returl') != ""){
				//echo "ddd";
				header ( "Location:" . $this->input->post('returl'));
			}
			else {
				//echo "eee";
			header ( "Location:" . $this->config->base_url ().'login');
			}
		}
	
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
					try {
						$user_profile = $facebook->api('/me?fields=email,first_name,last_name');
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
							}else {
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
			
			***********************************************
			  If we have an access token, we can make
			  requests, else we generate an authentication URL.
			 ***********************************************
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
			else {
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
	// SIGNUP 
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
		$datashow = $this->front_model->check_email_user($this->input->post('emailadd'));
		if($datashow > 0)
		{	$_SESSION['wrongsignup'] = $_POST;
			 $_SESSION['msglogin'] = "Email address already exist!";
			 header ( "Location:" . $this->config->base_url ()."signup");
		}
		else
		{
			$sectors = '';
			$countv = $this->input->post('sectors');
			for($i=0;$i < count($this->input->post('sectors'));$i++){
				$sectors .= $countv[$i].",";
			}
			$sectoruser = substr($sectors,0,-1);
			
			$rendomcode = $this->generateRandomString();
			$data = array(
						'uFname' 	   => $this->input->post('fname'),
						'uLname' 	   => $this->input->post('lname'),
						'uEmail' 	   => $this->input->post('emailadd'),
						'uUsername' 	=> $this->input->post('username'),
						'uPassword' 	=> md5($this->input->post('passlogin')),
						'uGender' 	  => $this->input->post('gender'),
						'uCountry' 	 => $this->input->post('country'),
						'uActType' 	 => 1,
						'uStatus' 	  => 1,
						'joinDate' 	 => date('Y-m-d h:i:s'),
						'uCode' 		=> $rendomcode,
						'uSectors' 	 => $sectoruser,
						'uverifyemail' => 0,
					);
				$uID = $this->front_model->add_query('dev_web_user',$data);
				
				// SEND EMAIL FOR HELLO TO USER
				$edata = $this->front_model->get_emails_data('signup-hello-user');
				$this->load->library('email');
				$this->email->from($edata[0]->eEmail, TITLEWEB);
				$this->email->to($this->input->post('emailadd')); 
				$replace = array("[WEBURL]","[CODE]","[CVURL]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]");
				$replacewith = array(WEBURL, $rendomcode, $this->config->base_url()."login" ,TITLEWEB,$this->input->post('emailsinup'),$this->input->post('passsignup'));
				$str = str_replace($replace,$replacewith,$edata[0]->eContent);
				$message = $str;
				$this->email->subject($edata[0]->eName);
				$this->email->message($message);
				$this->email->set_mailtype("html");
				$send = $this->email->send();
				
				// SEND EMAIL CONFIRMATION
				$edata = $this->front_model->get_emails_data('user-signup-confirmation');
				$this->load->library('email');
				$this->email->from($edata[0]->eEmail, TITLEWEB);
				$this->email->to($this->input->post('emailadd')); 
				$replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]");
				$replacewith = array(WEBURL, $rendomcode, $this->input->post('fname'),TITLEWEB,$this->input->post('emailadd'),$this->input->post('passlogin'));
				$str = str_replace($replace,$replacewith,$edata[0]->eContent);
				$message = $str;
				$this->email->subject($edata[0]->eName);
				$this->email->message($message);
				$this->email->set_mailtype("html");
				$send = $this->email->send();
				
				// EMAIL TO USER FOR UPLOAD CV
					$edata = $this->front_model->get_emails_data('cv-upload-alert');
					$this->load->library('email');
					$this->email->from($edata[0]->eEmail, TITLEWEB);
					$this->email->to($this->input->post('emailadd')); 
					$replace = array("[WEBURL]","[CVURL]");
					$replacewith = array(WEBURL,$this->config->base_url()."create-cv");
					$str = str_replace($replace,$replacewith,$edata[0]->eContent);
					$message = $str;
					$this->email->subject($edata[0]->eName);
					$this->email->message($message);
					$this->email->set_mailtype("html");
					//$send = $this->email->send();
				
				unset($_SESSION['wrongsignup']);
				$_SESSION['userID'] = $uID;
				//die;
				header ( "Location:".$this->config->base_url().'signup/step/2');
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
		$this->email->to($this->input->post('emailadd')); 
		$replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]");
		$replacewith = array(WEBURL, $row[0]->uCode, $row[0]->uFname." ".$row[0]->uLname,TITLEWEB);
		$str = str_replace($replace,$replacewith,$edata[0]->eContent);
		$message = $str;
		$this->email->subject($edata[0]->eName);
		$this->email->message($message);
		$this->email->set_mailtype("html");
		$send = $this->email->send();
		header ( "Location:".$this->config->base_url().'dashboard');
		} else {
			header ( "Location:".$this->config->base_url().'login');
		}
	}
	// SIGNUP STEP 2
	public function singup_step_two()
	{
		if(!isset($_SESSION['userID'])){
			header ( "Location:" . $this->config->base_url ()."signup");
			exit();
		}
		else {
		$this->load->view('frontend/signup_step_2',$this->data);
		}
	}
	// ACCOUNT VERIFICATION
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
		header ( "Location:" . $this->config->base_url ()."dashboard");
	}
	// SIGNUP FINAL
	public function do_register_final()
	{
		if($this->input->post('jalert') == "1"){
				$data = array(
						'uID' 	  	 	=> $_SESSION['userID'],
						'jobTitle' 	   => str_replace(" ",",",$this->input->post('jobtitle')),
						'jobSkills' 	  => str_replace(" ",",",$this->input->post('skills')),
						'jobLocation' 	=> $this->input->post('desiredloc'),
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
					header ( "Location:" . $this->config->base_url ()."dashboard");				
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
		$ret = $this->front_model->check_frogot_password($this->input->post('emailforgot'));
		if($ret == 0)
		{
			$_SESSION['msglogin'] = 'Email Address not found!';
			header ( "Location:" . $this->config->base_url () . 'forgot-password');
		}
		else
		{
			$rendomcode = $this->generateRandomString();
			$this->front_model->update_password_checl($this->input->post('emailforgot'),md5($rendomcode));
			
				// SEND EMAIL CONFIRMATION
				$edata = $this->front_model->get_emails_data('forgot-password');
				
				$this->load->library('email');
				$this->email->from($edata[0]->eEmail, TITLEWEB);
				$this->email->to($_REQUEST['emailforgot']); 
				
				$replace = array("[WEBURL]","[CODE]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]");
				$replacewith = array(WEBURL, $rendomcode,TITLEWEB,$this->input->post('emailforgot'),$rendomcode);
				$str = str_replace($replace,$replacewith,$edata[0]->eContent);
				$message = $str;
				$this->email->subject($edata[0]->eName.' - : : - '.TITLEWEB);
				$this->email->message($message);
				$this->email->set_mailtype("html");
				$send = $this->email->send();
				
			$_SESSION['msglogin'] = 'Email with temporaray password has been sent!';
			header ( "Location:" . $this->config->base_url () . 'forgot-password');
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
	public function jobs_list(){
		$arr = array();
		$config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);
		$this->data['countries'] 	= $config->result_object();
		// GET COUNTRIES
		$config 	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);
		$this->data['categories'] 	= $config->result_object();
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
		//$this->data['page'] = $this->front_model->get_cms_page('thank-you');
		$this->load->view('frontend/dashboard', $this->data);
		}
	}
	
	// Profile
	public function profile_dashboard()
	{
		$this->load->view('frontend/profile_dashboard', $this->data);
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
		if($_GET['type'] == 2){
			$redi = "Location:".$this->config->base_url().'recruiter-login';
		}else { 
			$redi = "Location:".$this->config->base_url().'login';
		}
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
	public function remove_save_job()
	{
		$data = array(
				'sID' 		=> $this->uri->segment(2),
			);
		$this->front_model->delete_query('dev_web_saved',$data);
		$_SESSION['msglogin'] = "Saved job removed successfully!";
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
				'uFname' 			=> $this->input->post('firstName'),
				'uLname' 			=> $this->input->post('lastName'),
				'uUsername' 		 => $this->input->post('username'),
				'uGender' 		   => $this->input->post('gender'),
				'uCountry' 		  => $this->input->post('country'),
			);
			
			$condition = array('uID' => UID);
			$this->front_model->update_query('dev_web_user',$data,$condition);
			$_SESSION['msglogin'] = "Profile Information Updated Successfully!";
			header ( "Location:" . $this->config->base_url ()."dashboard/profile/");
	}
	// CHANGE PASSWORD
	public function do_change_password()
	{
		$arr2 = array('uPassword' => md5($this->input->post('oldpass')));
		$config2 = $this->front_model->get_query_simple('*','dev_web_user',$arr2);
		$count 	= $config2->num_rows();
		if($count > 0){
			$data = array(
				'uPassword' 	=> md5($this->input->post('newpass')),
			);
			$condition = array('uID' => UID);
			$this->front_model->update_query('dev_web_user',$data,$condition);
			
			$_SESSION['msgloginpass'] = "Password Information Updated Successfully!";
			header ( "Location:" . $this->config->base_url ()."dashboard/profile/");
		}
		else {
			$_SESSION['msgloginpass'] = "Old Password not match!";
			header ( "Location:" . $this->config->base_url ()."dashboard/profile/");
		}
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
	// CREATE CV SUBMIT
	public function do_create_cv_submit(){
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
				'uPhone' 		  => $this->input->post('contact'),
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
				'jobSector' 		   => $this->input->post('sectorindu'),
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
				'jobSector' 		   => $this->input->post('sectorindu'),
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
				if(isset($_SESSION['SESSIONAPPLIED'])){
					header ( "Location:" . $_SESSION['SESSIONAPPLIED']);
				} else {
					$_SESSION['msglogin'] = "Cv and profile information added successfully!";
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
					'jobSector' 		   => $this->input->post('sectorindu'),
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
					if(isset($_SESSION['SESSIONAPPLIED'])){
					header ( "Location:" . $_SESSION['SESSIONAPPLIED']);
					} else {
					$_SESSION['msglogin'] = "Cv and profile information added successfully!";
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
						'jobSector' 		   => $this->input->post('sectorindu'),
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
						'jobSector' 		   => $this->input->post('sectorindu'),
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
						'cvUpdated' 		  	=> date("Y-m-d"),
					);
					$condition2 = array('cvID' => $this->input->post('cvID'));
					$this->front_model->update_query('dev_web_cv',$data,$condition2);
					$_SESSION['msglogin'] = "Cv and profile information updated successfully!";
					header ( "Location:" . $this->config->base_url ()."cv-management");
				}
			}
				else {
						$data = array(
						'cvTitle' 		  	   => $this->input->post('cvtitle'),
						'cvView' 		  	   => $this->input->post('findcv'),
						'pJobtitle' 		    => $this->input->post('jobtitle'),
						'pjobskills' 		   => $this->input->post('skills'),
						'jobSector' 		   => $this->input->post('sectorindu'),
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
						'cvUpdated' 		  	=> date("Y-m-d"),
					);
					$condition2 = array('cvID' => $this->input->post('cvID'));
					$this->front_model->update_query('dev_web_cv',$data,$condition2);
			
					$_SESSION['msglogin'] = "Cv and profile information updated successfully!";
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
								'uCountry' 	 => $this->input->post('countryrecruit'),
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
	public function post_job_advert()
	{
		if(!isset($_SESSION['JobsSessions'])){
			header ("Location:" . $this->config->base_url()."recruiter-signup");
			//$this->load->view('frontend/job_advert_page', $this->data);
		}
		else {
			if(!isset($_GET['type'])){
			if(ADVERTS != 0 || CANDIDATE !=0){
				$arr2 = array('uID' => UID);
				$configco = $this->front_model->get_query_simple('*','dev_web_jobs',$arr2);
				$cout = $configco->num_rows();
				/*if($cout == ADVERTS){
					$data = array(
						'uAdverts' 		   => 0,
						'endDate' 			=> '',
						'uPayment'			=> 0,
					);
					$condition = array('uID' => UID);
					$this->front_model->update_query('dev_web_user',$data,$condition);

					$this->load->view('frontend/job_advert_page', $this->data);
				} 
				else */
				
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
				$subprice = $gprice/$_SESSION['coponcodeses'];
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
		// GET CITY		
		$ip=$_SERVER['REMOTE_ADDR'];
		$addr_details = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
		$city = stripslashes(ucfirst($addr_details['geoplugin_city']));
		$countrycode = stripslashes(ucfirst($addr_details['geoplugin_countryCode']));
		$countryip = stripslashes(ucfirst($addr_details['geoplugin_countryName']));
		$data = array(
					'uID' 				=> UID,
					'jTitle' 			 => $this->input->post('jTitle'),
					'jURL' 			   => $jurl,
					//'jDepartment' 		=> $this->input->post('department'),
					'cID' 				=> $this->input->post('industry'),
					'jCareerLevel' 	   => $this->input->post('careerlevel'),
					'jExpLevel' 		  => $this->input->post('explevel'),
					'jVacancy' 		   => $this->input->post('vacancies'),
					'jNotDislosed' 		=> $discl,
					'jDescription' 	   => nl2br($this->input->post('jobDescp')),
					'jRequiredSkills' 	=> nl2br($this->input->post('reqSkilled')),
					'jQualification' 	 => $this->input->post('qualification'),
					'jNature' 			=> $this->input->post('jobtype'),
					'jShift' 			 => $this->input->post('jobshift'),
					'jRequiredTravel' 	=> $this->input->post('jobtravel'),
					'jGender' 			=> $this->input->post('jobGender'),
					'jStartSalary' 	   => $this->input->post('startsalary'),
					'jEndSalary' 		 => $this->input->post('endsalary'),
					'jCurrency' 		  => $this->input->post('jCurrency'),
					'jBenefits' 		  => $benefit,
					'jCoutry' 		 	=> $this->input->post('jobLocation'),
					'jExpiry' 			=> date('Y-m-d', strtotime("+28 days")),
					//'jAfterExpiry' 	   => $this->input->post('jobAfterExpiry'),
					'jEmailNotify' 	   => $this->input->post('jobNotify'),
					'jPostedDate' 		=> $datetime,
					'jJobCode' 		   => $randomcode,
					'jJobStatus' 		 => 1,
					'jJobIP' 		 	 => $_SERVER['REMOTE_ADDR'],
					'jDirect' 		   => $direct,
					'jDirectLink' 		 => $applyurl,
				);
			$this->front_model->add_query('dev_web_jobs',$data);
			
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
				$replacewith = array(WEBURL, $userinfo[0]->uFname.' '.$userinfo[0]->uLname,"$".$this->input->post('startsalary')."-".$this->input->post('endsalary'),$this->input->post('jobtype'),$this->input->post('jobDescp'),$jurl."?apply=yes",$this->input->post('jTitle'));
				$str = str_replace($replace,$replacewith,$edata[0]->eContent);
				$message = $str;
				$this->email->subject($edata[0]->eSubject.$this->input->post('jTitle'));
				$this->email->message($message);
				$this->email->set_mailtype("html");
				$send = $this->email->send();
			endforeach;
		
		//$_SESSION['notify'] = 'New job added successfully!';
		header ( "Location:" . $this->config->base_url () . 'job/'.$jurl );
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
		$data = array(
					'jTitle' 			 => $this->input->post('jTitle'),
					'cID' 				=> $this->input->post('industry'),
					'jCareerLevel' 	   => $this->input->post('careerlevel'),
					'jExpLevel' 		  => $this->input->post('explevel'),
					'jVacancy' 		   => $this->input->post('vacancies'),
					'jNotDislosed' 		=> $discl,
					'jDescription' 	   => nl2br($this->input->post('jobDescp')),
					'jRequiredSkills' 	=> nl2br($this->input->post('reqSkilled')),
					'jQualification' 	 => $this->input->post('qualification'),
					'jNature' 			=> $this->input->post('jobtype'),
					'jShift' 			 => $this->input->post('jobshift'),
					'jRequiredTravel' 	=> $this->input->post('jobtravel'),
					'jGender' 			=> $this->input->post('jobGender'),
					'jStartSalary' 	   => $this->input->post('startsalary'),
					'jEndSalary' 		 => $this->input->post('endsalary'),
					'jCurrency' 		  => $this->input->post('jCurrency'),
					'jBenefits' 		  => $benefit,
					'jCoutry' 		 	=> $this->input->post('jobLocation'),
					//'jStateCity' 		 => '',
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
	// DELETE POSTED JOB
	public function delete_user_job()
	{
		$data = array('jID' => $this->uri->segment(3));
		$this->front_model->delete_query('dev_web_jobs',$data);
		$_SESSION['msglogin'] = 'Job Deleted Successfully!';
		header ( "Location:".$this->config->base_url().'recruiter-posted-jobs');
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
		$arr2 = array('uID' => UID);
		$config2 = $this->front_model->get_query_simple('*','dev_job_alerts',$arr2);
		$user 	= $config2->num_rows();
		if($user > 0){
				$data = array(
					'jobTitle' 	   => str_replace(" ",",",$this->input->post('jobtitle')),
					'jobSkills' 	  => str_replace(" ",",",$this->input->post('skills')),
					'jobNature' 	  => $this->input->post('jobType'),
					'jobStatus' 	  => 1,
					'jobInstant' 	 => $this->input->post('jobInstant'),
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
						'jobInstant' 	 => $this->input->post('jobInstant'),
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
		$replace = array("[WEBTITLE]","[WEBURL]","[LASTVISIT]","[CVDOWNLOAD]","[SAVED JOB]","[JOBPOSTED]","[APPLICATION]","[JOBALERT]","[CVVIEWS]","[USER]");
		$replacewith = array("JobsRope", WEBURL, $lastvisit-1, $countcvview,$countjobsaved,$countposted,$counapplicants,'1',$cvviews,$user->uFname);
		$str = str_replace($replace,$replacewith,$edata[0]->eContent);
		$message = $str;
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
			$_SESSION['coponcodeses'] = $corow[0]->cpPrice;
			$_SESSION['msglogin'] = "Discount applied successfully!";
			header ( "Location:" . $_SERVER['HTTP_REFERER']);
		}
		else {
			$_SESSION['msglogin'] = "Invalid Coupon Code!";
			header ( "Location:" . $_SERVER['HTTP_REFERER']);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */