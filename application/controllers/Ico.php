<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once './vendor/qrcode.php';
use \Stripe\Strip;
use \Stripe\Charge;
use \Stripe\Customer;
use \Twilio\Rest\Client;
use \Mpdf\Mpdf;
use \ModDev\Password\Scrypt;
// use \SendGrid\Email;
// use \SendGrid\Content;
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
        $this->data['accounts_url'] = 'http://accounts.icodashboard.io/';
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->database();
        $this->db->reconnect();
        $this->load->model('front_model'); //Load frontend model


        if(!isset($_SESSION['kyc_lang']))
            $_SESSION['kyc_lang']="en";
         



        session_start();
        if(isset($_SESSION['unverified_otp']) && $_SESSION['unverified_otp']==1 && $_SESSION['blocked_otp']!=1){
            $seg = $this->uri->segment(1);
            if($seg!="resend-otp" && $seg!="submit-otp" && $seg!="verify-otp" && $seg!="logout"){
                redirect(base_url().'verify-otp');
                exit;
            }
        }
        $arr = array();
        $config     = $this->front_model->get_query_simple('*','dev_web_config',$arr);
        $rconfig    = $config->result_object();
        $this->data['web_settings']=$rconfig[0];

        $timezone_ = $this->data['web_settings']->timezone?$this->data['web_settings']->timezone:'America/New_York';
        date_default_timezone_set($timezone_);


        $this->data['whitelist_'] = $this->front_model->get_query_simple('*','dev_web_whitelist',array())->result_object()[0];

        $shufti_details = $this->db->where('type',"SHUFTIPRO")->get('dev_web_kyc_apis')->result_object()[0];

        $this->data['shufti_url']        = $shufti_details->url;
        $this->data['shufti_client_id']  = $shufti_details->public_key;
        $this->data['shufti_secret_key'] = $shufti_details->private_key; //Replace with your secret key provided by the Shufti Pro.


        foreach($rconfig as $confg):
            define("TITLEWEB",$confg->configWeb);
            define("SUBDOMAIN__",$confg->subdomain);
            define("WEBURL",base_url());
            define("WEBNAME",$confg->configTitle);
            define("WEBDESCP",$confg->configDescrip);
            define("WEBKEYS",$confg->configKeyword);
            define("WEBPHONE",$confg->configPhone);
            define("WEBEMAIL",$confg->configEmail);
            define("WEBADD",$confg->configAddress);
            define("WEBCOPY",$confg->configCopy);
            define("GOOGLEANALYTICS",$confg->google_analytics);
            define("LIVECHAT",$confg->livechat);
            define("WEBFB",$confg->configFacebook);
            define("WEBTWT",$confg->configTwitter);
            define("WEBGOOGLE",$confg->webGoogle);
            define("WEBLKD",$confg->webLkndIn);
            define("WEBYT",$confg->webYouTube);
            define("WEBPNT",$confg->webPintrest);
            define("CAPTCHA",$confg->captcha);
            define("CAPTCHA_KEY",$confg->captcha_key);
            define("CAPTCHA_SECRET",$confg->captcha_secret);
            define("LOGO_WIDTH",$confg->logo_width);
            $_SESSION['DECIMALS__'] = $config->decimals;
        endforeach;
        if(isset($_SESSION['JobsSessions'])){
            $verification___data = $this->db->where('uID',$_SESSION['JobsSessions'][0]->uID)
            ->where('deleted',0)
            ->get('dev_web_user_verification')->result_object();
            $this->data['user_verified']=0;

            $kyc_enabled = $this->front_model->get_query_simple('*','dev_web_kyc_aml',array('id'=>1))->result_object()[0];
            $this->data['kyc_data']=$kyc_enabled;



            if(!empty($verification___data))
            {   
                $this->data['user_verified']=$verification___data[0]->uStatus;
            }



            $this->data['kyc_verification_enabled']= $kyc_enabled->kyc_verification;
            $this->data['kyc_verification_at']= $kyc_enabled->require_at;
            $this->data['kyc_verification_at_crypto']= $kyc_enabled->require_at_crypto;
            $this->data['kyc_verification_at_fiat']= $kyc_enabled->require_at_fiat;

            //session_destroy();
//          print_r($_SESSION['JobsSessions']);
            $arrusercon = array('uID' => $_SESSION['JobsSessions'][0]->uID);
            $quserdat   = $this->front_model->get_query_simple('*','dev_web_user',$arrusercon);
            $user   = $quserdat->result_object();
            $this->data['user_own_details']=$user[0];



            if($_SESSION['JobsSessions']['allowed_domain']!=base_url() && $this->uri->segment(1)!="logout")
            {
                 
                redirect(base_url().'logout');
                exit;
            }
            if($user[0]->uStatus==2)
            {
                $_SESSION['error']="Your account has been banned. Please contact administration.";
                unset($_SESSION['JobsSessions']);
                redirect(base_url());
            }
            // echo $user[0]->kyc_verified;exit;

            if($user[0]->kyc_verified==1)
                $this->data['user_verified'] = 1;
            $this->data['current_logged_user']=$user[0];


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
                $seg = $this->uri->segment(1);
                // if($seg!="resend-otp" && $seg!="submit-otp" && $seg!="verify-otp" && $seg!="logout" && $seg!="login" && $seg!="accept-terms"){
                //  //$this->accepted_terms();
                // }
                //define("CVVIEW",$user[0]->ucView);
            }
            if(ACTYPE!=1)
            {
                $this->if_from_banned_country();
            }

            $this->admin_authy();
            

            $this->kyc_verification_type_3();
            $this->whitelist_user_redirect();

            $roles=array();
             
            $roless = $this->db->where('admin_id',UID)->get('dev_web_admin_roles')->result_array();
            foreach($roless as $role)
                $roles[]=$role['role'];
            $_SESSION['RolesSession']['roles']=$roles;

            // print_r($_SESSION['RolesSession']['roles']);exit;
        }
        else {


       
        }
        $sid = session_id();
        $arr = array('id'=>$sid);
        $chkv = $this->front_model->get_query_simple('COUNT(*) AS VISITORS','dev_web_visitors',$arr);
        $chkr   = $chkv->result_object();
        if($chkr[0]->VISITORS == 0){
            $data = array('id' => session_id());
            $this->front_model->addvisitors($data);
        }
        else { }
        //$localIP = getHostByName(getHostName());
        $arr = array(
            'ip' =>  $_SERVER['REMOTE_ADDR'],
        );
        $ip = $this->front_model->get_query_simple('*','dev_web_banned_countries',$arr);
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
                Your IP address (<?php echo $_SERVER['REMOTE_ADDR'];?>) has been banned by Administration!</div>
            <?php
            die;
        }
    }
    private function admin_authy()
    {
        if(isset($_SESSION['JobsSessions']))
        {
            if(ACTYPE==1)
            {

                if(isset($_GET['change_phone_number']) && $_GET['change_phone_number']==1)
                {
                    $this->db->where('uID',UID)->update('dev_web_user',array('uPhone'=>'00'));
                    $_SESSION['blocked_otp']=1;
                    redirect(base_url().'dashboard');
                    exit;
                }
                $seg = $this->uri->segment(1);
                if($seg!="resend-otp" && $seg!="submit-otp" && $seg!="verify-otp" && $seg!="logout" && $seg!="login" && $seg!="accept-terms"){
                    $get_authy = $this->db->order_by('id','DESC')->limit(1)->get('dev_web_two_factor')->result_object()[0];

                    if($get_authy->for_admin==1 && $_SESSION['verified_otp']!=1)
                    {
                        $this->admin_authy_part_2();


                    }
                }
            }
        }

    }
    private function admin_authy_part_2()
    {


        if(isset($_POST['valid_phone']))
        {
            $this->db->where('uID',UID)->update('dev_web_user',array('uPhone'=>$this->input->post('valid_phone')));
        }

        $user = $this->db->where('uID',UID)->get('dev_web_user')->result_object()[0];


        $my_phone = $user->uPhone;
        $verified = $user->uvvPhone;

        $get_authy = $this->db->order_by('id','DESC')->limit(1)->get('dev_web_two_factor')->result_object()[0];

        if(!$my_phone || !strlen($my_phone) || substr($my_phone, 0, 1) !== '+')
        {
            if(isset($_POST['valid_phone']))
            {
                $_SESSION['error']="Invalid Phone Number";
            }
            $this->load->view('frontend/enter_valid_phone',$this->data);
            exit;
        }
        else
        {
            $_SESSION['unverified_otp']=1;
            $this->send_otp($_SESSION['JobsSessions'][0]->uID, /* settings:*/$get_authy);
            unset($_SESSION['blocked_otp']);
            redirect(base_url().'verify-otp');
            exit;
        }
    }
    public function whitelist_user_redirect()
    {
        if(isset($_SESSION['JobsSessions']))
        {
            if(ACTYPE==2)
            {
                if($this->data['current_logged_user']->whitelist==1)
                {
                    if(json_decode($this->data['current_logged_user']->whitelist_settings)->ability==3 && $this->uri->segment(1)!="please-wait" && $this->uri->segment(1)!="logout")
                    {
                        redirect(base_url().'please-wait');
                        exit;
                    }
                }
            }
        }
    }
    public function if_not_allowed()
    {

        if(isset($_SESSION['JobsSessions']))
        {
            if(ACTYPE==2)
            {
                if($this->data['current_logged_user']->whitelist==1)
                {
                    if(json_decode($this->data['current_logged_user']->whitelist_settings)->ability==2)
                    {
                        $_SESSION['error']="You can't buy tokens";
                        $this->redirect_back();
                        exit;
                    }
                }
            }
        }
    }
    // Random Code Generator
    public function accepted_terms()
    {
        $user = $this->front_model->get_query_simple('terms_accepted','dev_web_user',array('uID'=>UID))->result_object()[0]->terms_accepted;
        $this->data['terms'] =  $this->front_model->get_query_simple('*','dev_web_terms',array('id'=>1))->result_object()[0];
        if($user==0 && $this->data['terms']->active==1)
        {
            redirect(base_url().'accept-terms');
            exit;
        }
    }
    
    public function accept_terms($id=0)
    {
        $id = $id==0?UID:$id;
        $this->data['terms'] =  $this->front_model->get_query_simple('*','dev_web_terms',array('id'=>1))->result_object()[0];
        if(isset($_POST['terms']))
        {
            if(count($this->input->post('st')) == count(json_decode($this->data['terms']->c_statements))+1)
            {
                $this->front_model->update_query('dev_web_user',array('terms_accepted'=>1),array('uID'=>$id));
                unset($_SESSION['error']);
                $_SESSION['thankyou']="Terms Accepted";
                redirect(base_url().'dashboard');
            }
            else
            {
                $_SESSION['error']="Please accept all terms and conditions";
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
        else
        {
            $user = $this->front_model->get_query_simple('terms_accepted','dev_web_user',array('uID'=>$id))->result_object()[0]->terms_accepted;
            if($user==0 && $this->data['terms']->active==1)
            {
                $this->load->view('frontend/accept_terms',$this->data);
            }
            else
            {
                redirect(base_url());
            }
        }
    }
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
            'nSubject'      => $subject,
            'uID'           => UID,
            'nData'         => $data,
            'nDate'         => date('Y-m-d H:i:s'),
        );
        $this->front_model->add_query('dev_web_notfiications',$data);
    }
    public function notify_user($subject,$data,$id)
    {
        $data = array(
            'nSubject'      => $subject,
            'uID'           => $id,
            'nData'         => $data,
            'nDate'         => date('Y-m-d H:i:s'),
        );
        $this->front_model->add_query('dev_web_notfiications',$data);
    }
    // HOME PAGE
    public function index()
    {

        if(isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."dashboard");
        }
        else{


            if(am_i('securix'))

            {

                if($this->data['whitelist_']->active==1){

                    $cond = array('status'=>1,'id'=>$whitelist->registration_form);
                    $form = $this->front_model->get_query_simple('*','dev_web_registration_forms',$cond)->result_object()[0];
                    $this->data['form']=$form;
                }
                $arr = array();
                $config     = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
                $this->data['countries']    = $config->result_object();
                $this->load->view('frontend/signup',$this->data);
            }
            else{
                $arr = array();
                $config     = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
                $this->data['countries']    = $config->result_object();
                

                $whitelist = $this->front_model->get_query_simple('*','dev_web_whitelist',array())->result_object()[0];

                if($whitelist->active==1)
                {
                    $form = $this->front_model->get_query_simple('*','dev_web_registration_forms',array('id'=>$whitelist->registration_form))->result_object();
                    // if(empty($form))
                    // {
                    //     $form = $this->front_model->get_query_simple('*','dev_web_registration_forms',array('status'=>1))->result_object();
                    // }
                    $this->data['whitelist']=$whitelist;
                    $this->data['whitelist_active']=1;
                    $this->data['form']=$form[0];
                   
                    $this->load->view('frontend/signup',$this->data);
                }
                else
                {
                    if($this->data['whitelist_']->active==1)
                    $this->data['form']=$form[0];



                    $this->load->view('frontend/home',$this->data);
                }
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




        if($userpassword != $passwordvalidate){
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





        if(isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."dashboard");
        }
        else{
            // $arr = array();
            // $config     = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
            // $this->data['countries']    = $config->result_object();
            

            // $form = $this->front_model->get_query_simple('*','dev_web_registration_forms',array('status'=>1))->result_object();
            // $this->data['form']=$form[0];
            // $this->load->view('frontend/home',$this->data);

            $arr = array();
            $config     = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
            $this->data['countries']    = $config->result_object();
            

            $whitelist = $this->front_model->get_query_simple('*','dev_web_whitelist',array())->result_object()[0];

            if($whitelist->active==1 && 1==2)
            {
                $form = $this->front_model->get_query_simple('*','dev_web_registration_forms',array('id'=>$whitelist->registration_form))->result_object();
                // if(empty($form))
                // {
                //     $form = $this->front_model->get_query_simple('*','dev_web_registration_forms',array('status'=>1))->result_object();
                // }
                $this->data['whitelist']=$whitelist;
                $this->data['whitelist_active']=1;
                $this->data['form']=$form[0];
                $this->load->view('frontend/signup',$this->data);
            }
            else
            {
                if($this->data['whitelist_']->active==1)
                $this->data['form']=$form[0];
                $this->load->view('frontend/home',$this->data);
            }
            

        }       





    }
//	public function banned_countries()
//    {
//        if(!isset($_SESSION['JobsSessions'])){
//            header ( "Location:" . $this->config->base_url ());
//        }
//        else {
//            
//			$this->load->view('frontend/banned_countries',$this->data);
//        }
//    }
    // ACCOUNT LOGIN
    public function do_login_account()
    {
        if(CAPTCHA==1){
            if(!$this->verify_captcha())
            {
                $_SESSION['wrongsignup'] = $_POST;
                $_SESSION['msglogin'] = "Captcha Error!";
                redirect($_SERVER['HTTP_REFERER']);
                exit;
            }
        }

        //$this->input->post('password')
        $arr = array(
            'uEmail'    =>  $this->input->post('username')
        );



       echo $this->if_old_md5($arr['uEmail'])?"cov":"";


        // print_r($arr);exit;
        $datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);
        
        $count = $datashow->num_rows();
        if($count > 0 && $this->check_scrypt($datashow->result_object()[0]->uPassword, $this->input->post('password'))){
            $row = $datashow->result_object();
            $_SESSION['JobsSessions']   = $row;
            $_SESSION['JobsSessions']['allowed_domain']=base_url();
            if($_SESSION['JobsSessions'][0]->uBan == 1){
                unset($_SESSION['JobsSessions']);
                $_SESSION['error'] = 'Your account has been banned from administrator, please contact administrator to reactivate your account!';
                header ( "Location:" . $this->config->base_url ()."login");
            }else {
                ///// two factor
                $two_fact = $this->front_model->get_query_simple('*','dev_web_two_factor',array('id'=>1))->result_object()[0];

                // if($two_fact->required==1){
                //     $two_fact = $_SESSION['JobsSessions'][0]->enable_two_factor;
                // }

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
                    'uIP'          => $_SERVER['REMOTE_ADDR'],
                    'uLoginLast'    => date("Y-m-d H:i:s"),
                    'login_count' => $_SESSION['JobsSessions'][0]->login_count+1
                );
                $condition = array('uID' => $_SESSION['JobsSessions'][0]->uID);
                $this->front_model->update_query('dev_web_user',$data,$condition);
                $this->login_history();
                header ( "Location:" . $this->config->base_url ().'dashboard');
            }
        }
        else
        {
            $_SESSION['error'] = 'Invalid login credentials!';
            header ( "Location:" . $this->config->base_url ());
        }
    }
    private function if_old_md5($user)
    {

        $arr = array(
            'uEmail'    =>  $user,
            'uPassword' =>  md5($this->input->post('password')),
        );

        $datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);

        
        $count = $datashow->num_rows();

        if($count>0)
        {
            $new_password = $this->crypt_scrypt($this->input->post('password'));
            $this->db->where('uEmail',$user)->update('dev_web_user',array('uPassword'=>$new_password));

            return true;

        }
        return false;
       

    }
    public function login_history()
    {
        $login_history = array('time'=>date("Y-m-d H:i:s"),'ip'=>$_SERVER['REMOTE_ADDR'],'uID'=>$_SESSION['JobsSessions'][0]->uID);
        $this->front_model->add_query('dev_web_user_login_history',$login_history);
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
            $_SESSION['error']="Error! Error code: ".$e->getCode()." Error: ".$e->getMessage().".<br>Please contact with administration if you're receiving this error continuously";;
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
                $_SESSION['verified_otp']=1;
                $data = array(
                    'uIP'          => $_SERVER['REMOTE_ADDR'],
                    'uLoginLast'    => date("Y-m-d H:i:s"),
                    'login_count' => 0,
                    'uvvPhone'=>$this->data['user_own_details']->uPhone,
                    'uPhone'=>$this->data['user_own_details']->uPhone
                );
                $condition = array('uID' => $_SESSION['JobsSessions'][0]->uID);
                $this->front_model->update_query('dev_web_user',$data,$condition);
                $this->login_history();
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
    
    // Fcaeboook Login
    public function do_fb_login()
    {
        $action = $_REQUEST["page"];
        switch($action)
        {
            case "fblogin":
                include 'fblogin/facebook.php';
                $appid      = "1891590237740531";
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
                        'uEmail'    =>  $user_profile["email"],
                    );
                    $datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);
                    echo $rcoun = $datashow->num_rows();
                    if($rcoun > 0)
                    {
                        $arr = array(
                            'uEmail'    =>  $user_profile["email"],
                        );
                        $datid  = $this->front_model->get_query_simple('*','dev_web_user',$arr);
                        $row    = $datid->result_object();
                        $arru = array(
                            'uID'   =>  $row[0]->uID,
                        );
                        $datdddd = $this->front_model->get_query_simple('*','dev_web_user',$arru);
                        $dat = $datdddd->result_object();
                        $data = array(
                            'uIP'          => $_SERVER['REMOTE_ADDR'],
                            'uLoginLast'    => date("Y-m-d h:i:s"),
                        );
                        $this->front_model->update_query('dev_web_user',$data,$arru);
                    }
                    else
                    {
                        $exp = explode("@",$user_profile["email"]);
                        $rendomcode = $this->generateRandomString();
                        $data = array(
                            'uFname'        => $user_profile["first_name"],
                            'uLname'        => $user_profile["last_name"],
                            'uEmail'        => $user_profile["email"],
                            'uUsername'     => $exp[0],
                            'uPassword'     => $this->crypt_scrypt($rendomcode),
                            'uImage'        => "https://graph.facebook.com/".$fbuser."/picture?type=large",
                            'uActType'      => 1,
                            'uStatus'       => 1,
                            'joinDate'      => date('Y-m-d h:i:s'),
                            'uCode'         => $rendomcode,
                            'ufb'           => 1,
                            'uIP'          => $_SERVER['REMOTE_ADDR'],
                            'uLoginLast'    => date("Y-m-d h:i:s"),
                            //'ulogin'      => 1,
                        );
                        $uid = $this->front_model->add_user_new_fb($data);
                        $arru = array(
                            'uID'   =>  $uid,
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
                        'uEmail'    =>  $content->id,
                    );
                    $datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);
                    echo $rcoun = $datashow->num_rows();
                    if($rcoun > 0)
                    {
                        $arr = array(
                            'uEmail'    =>  $content->id,
                        );
                        $datid  = $this->front_model->get_query_simple('*','dev_web_user',$arr);
                        $row    = $datid->result_object();
                        $arru = array(
                            'uID'   =>  $row[0]->uID,
                        );
                        $datdddd = $this->front_model->get_query_simple('*','dev_web_user',$arru);
                        $dat = $datdddd->result_object();
                        $data = array(
                            'uIP'          => $_SERVER['REMOTE_ADDR'],
                            'uLoginLast'    => date("Y-m-d h:i:s"),
                        );
                        $this->front_model->update_query('dev_web_user',$data,$arru);
                    }
                    else
                    {
                        $rendomcode = $this->generateRandomString();
                        $data = array(
                            'uFname'        => $ex[0],
                            'uLname'        => $ex[1],
                            'uEmail'        => $content->id,
                            'uUsername'     => $content->id,
                            'uPassword'     => $this->crypt_scrypt($rendomcode),
                            'uImage'        => $content->profile_image_url,
                            'uActType'      => 1,
                            'uStatus'       => 1,
                            'joinDate'      => date('Y-m-d h:i:s'),
                            'uCode'         => $rendomcode,
                            'ufb'           => 1,
                            'uIP'          => $_SERVER['REMOTE_ADDR'],
                            'uLoginLast'    => date("Y-m-d h:i:s"),
                            //'ulogin'      => 1,
                        );
                        $uid = $this->front_model->add_user_new_fb($data);
                        $arru = array(
                            'uID'   =>  $uid,
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
        $CONSUMER_SECRET=   'RSWKqf4HWpQ78LtUszaa4mJo2jChRGArzIWhkxYq5QH2i3tbht';
        $OAUTH_CALLBACK=    $this->config->base_url().'oathtwitter/login';
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
            if( $request_token)
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
            'uEmail'    =>  $user->email,
        );
        $datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);
        $rcoun = $datashow->num_rows();
        if($rcoun > 0)
        {
            $arr = array(
                'uEmail'    =>  $user->email,
            );
            $datid  = $this->front_model->get_query_simple('*','dev_web_user',$arr);
            $row    = $datid->result_object();
            $arru = array(
                'uID'   =>  $row[0]->uID,
            );
            $datddd = $this->front_model->get_query_simple('*','dev_web_user',$arru);
            $dat = $datddd->result_object();
            $data = array(
                'uIP'          => $_SERVER['REMOTE_ADDR'],
                'uLoginLast'    => date("Y-m-d h:i:s"),
            );
            $this->front_model->update_query('dev_web_user',$data,$arru);
        }
        else
        {
            $exp = explode("@",$user->email);
            $rendomcode = $this->generateRandomString();
            $data = array(
                'uFname'        => $user->givenName,
                'uLname'        => $user->familyName,
                'uEmail'        => $user->email,
                'uUsername'     => $exp[0],
                'uPassword'     => $this->crypt_scrypt($rendomcode),
                'uImage'        => $user->picture,
                'uActType'      => 1,
                'uStatus'       => 1,
                'joinDate'      => date('Y-m-d h:i:s'),
                'uCode'         => $rendomcode,
                'ufb'           => 1,
                'uIP'          => $_SERVER['REMOTE_ADDR'],
                'uLoginLast'    => date("Y-m-d h:i:s"),
                //'ulogin'      => 1,
            );
            $uid = $this->front_model->add_user_new_fb($data);
            $arru = array(
                'uID'   =>  $uid,
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
                    'uEmail'    =>  $emailAddress,
                );
                $datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);
                $rcoun = $datashow->num_rows();
                if($rcoun > 0)
                {
                    $arr = array(
                        'uEmail'    =>  $emailAddress,
                    );
                    $datid  = $this->front_model->get_query_simple('*','dev_web_user',$arr);
                    $row    = $datid->result_object();
                    $arru = array(
                        'uID'   =>  $row[0]->uID,
                    );
                    $datddd = $this->front_model->get_query_simple('*','dev_web_user',$arru);
                    $dat = $datddd->result_object();
                    $data = array(
                        'uIP'          => $_SERVER['REMOTE_ADDR'],
                        'uLoginLast'    => date("Y-m-d h:i:s"),
                    );
                    $this->front_model->update_query('dev_web_user',$data,$arru);
                }
                else
                {
                    $exp = explode("@",$emailAddress);
                    $rendomcode = $this->generateRandomString();
                    $data = array(
                        'uFname'         => $firstName,
                        'uLname'         => $lastName,
                        'uEmail'         => $emailAddress,
                        'uUsername'       => $exp[0],
                        'uPassword'       => $this->crypt_scrypt($rendomcode),
                        'uImage'         => $pictureUrls,
                        'uActType'     => 1,
                        'uStatus'       => 1,
                        'joinDate'     => date('Y-m-d h:i:s'),
                        'uCode'           => $rendomcode,
                        'ufb'           => 1,
                        'uIP'           => $_SERVER['REMOTE_ADDR'],
                        'uLoginLast'    => date("Y-m-d h:i:s"),
                    );
                    $uid = $this->front_model->add_user_new_fb($data);
                    $arru = array(
                        'uID'   =>  $uid,
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
      redirect(base_url().'signup');
      exit;

        if(!isset($_SESSION['JobsSessions'])){
            $arr = array();
            $config     = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
            $this->data['countries']    = $config->result_object();
            $this->load->view('frontend/signup_step',$this->data);
        }
        else {
            header ( "Location:" . $this->config->base_url ()."dashboard");
        }
    }
    public function get_url_div()
    {
        $required=$_REQUEST['required']?$_REQUEST['required']:'';
        $cross=$_REQUEST['cross']?$_REQUEST['cross']:0;
        echo get_url_div($required,$cross);
    }
    public function signup_page()
    {
        if(!isset($_SESSION['JobsSessions'])){
            if($this->data['whitelist_']->active==1){
                $cond = array('status'=>1,'id'=>$this->data['whitelist_']->registration_form);
                $form = $this->front_model->get_query_simple('*','dev_web_registration_forms',$cond)->result_object()[0];
                $this->data['form']=$form;
            }
            $arr = array();
            $config     = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
            $this->data['countries']    = $config->result_object();
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
            $config     = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
            $this->data['countries']    = $config->result_object();
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
       // print_r($this->input->post('first_name'));exit;
        $datashow = $this->front_model->check_email_user($this->input->post('email'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email',"Email","valid_email");
        if($datashow > 0 || !$this->form_validation->run())
        {
            $_SESSION['wrongsignup'] = $this->input->post();
            $_SESSION['error'] = "Email address already exist!";
            header ( "Location:" . $this->config->base_url ()."signup");
        }
        else
        {

            // print_r($_POST);exit;


            $whitelist = $this->front_model->get_query_simple('*','dev_web_whitelist',array('active'=>1))->result_object()[0];

            $rendomcode = $this->generateRandomString();
            $ref_id = $this->front_model->get_query_simple('*','dev_web_user',array('uCode'=>$_SESSION['ref_ref']))->result_object();
            if(!empty($ref_id))
                $ref_id = $ref_id[0]->uID;
            else
                $ref_id = 0;
            $data = array(
                'uFname'        => $this->input->post('first_name'),
                'uLname'        => $this->input->post('last_name'),
                'uEmail'        => $this->input->post('email'),
                'uUsername'     => $this->input->post('username'),
                'uPassword'     => $this->crypt_scrypt($this->input->post('password')),
//                      'uDOB'          => $this->input->post('birth_date'),
                'uCountry'      => $this->input->post('country'),
//                      'uCity'         => $this->input->post('city'),
//                      'uAddress'      => $this->input->post('address'),
                'uPhone'        => $this->input->post('phone'),
                //'uZip'            => $this->input->post('postal_code'),
                'uActType'      => 2,
                'uStatus'       => 1,
                'joinDate'      => date('Y-m-d h:i:s'),
                'uIP'           => $_SERVER['REMOTE_ADDR'],
                'uCode'         => $rendomcode,
                'uSectors'      => $sectoruser,
                'referrer'=>$ref_id,
                'uverifyemail'  => 0,
                'whitelist'  => $this->input->post('whitelist')==1?1:0,
                'whitelist_settings'=>json_encode($whitelist),
            );
            if(CAPTCHA==1){
                if(!$this->verify_captcha())
                {
                    $_SESSION['wrongsignup'] = $this->input->post();
                    $_SESSION['msglogin'] = "Captcha Error!";
                    header ( "Location:" . $this->config->base_url ()."signup");
                    exit;
                }
            }
            $banned_countries=$this->front_model->get_query_simple('*','dev_web_banned_countries',array('cID'=>$data['uCountry']))->num_rows();
            if($banned_countries>0)
            {
                $_SESSION['wrongsignup'] = $this->input->post();
                $_SESSION['error'] = "Please Note at This Time Our ICO is Not Available in Your Area";
                header ( "Location:" . $this->config->base_url ()."signup");
                exit;
            }
            // echo $this->db->last_query();exit;
            $uID = $this->front_model->add_query('dev_web_user',$data);
            // $this->put_bonus($uID);
            $this->store_next_form_data_signup($uID);
            

            // SEND EMAIL CONFIRMATION
            $this->send_verification($uID,$rendomcode);
            unset($_SESSION['wrongsignup']);
            $_SESSION['userID'] = $uID;

            $datashow = $this->db->where('uID',$uID)->get('dev_web_user');
             $row = $datashow->result_object();
            $_SESSION['JobsSessions']   = $row;
            $_SESSION['JobsSessions']['allowed_domain']=base_url();


            $_SESSION['first_login'] = 1;
            if($whitelist->active==1 && $whitelist->kyc==2)
            {
                redirect(base_url().'kyc-verification');
                exit;
            }


            // redirect(base_url().'accept-terms/'.$uID);
            redirect(base_url().'dashboard');
            // header ( "Location:".$this->config->base_url());
        }
    }
    private function if_from_banned_country()
    {
        $banned_countries=$this->front_model->get_query_simple('*','dev_web_banned_countries',array('cID'=>$this->data['user_own_details']->uCountry))->num_rows();
            if($banned_countries>0 && $this->uri->segment(1)!="logout")
            {
                $_SESSION['error'] = "Please Note at This Time Our ICO is Not Available in Your Area";
                header ( "Location:" . $this->config->base_url ()."logout?set_msg=".$_SESSION['error']);
                exit;
            }
    }
    // private function put_bonus($uid)
    // {
    //     $user = $this->db->where('uID',$uid)->get('dev_web_user')->result_object()[0];
    //     // $this->
    // }
    public function store_next_form_data_signup($uID)
    {

            $cond = array('status'=>1);
            $form = $this->front_model->get_query_simple('*','dev_web_registration_forms',$cond)->result_object()[0];

            $jsondata = json_decode($form->form,true);

            $this->data['jsondata']=$jsondata;

            $custom_form_data = array();
             foreach($jsondata as $keyy=>$banner){
              
                $custom_form_data[$banner['name']]=$this->input->post('collect')[$keyy];
             }

             $next_form_data = array(
                'data'=>json_encode($custom_form_data),
                'uID'=>$uID,
                'created_at'=>date("Y-m-d H:i:s"),
                'ip'=>$_SERVER['REMOTE_ADDR'],
                'form_used'=>$form->id
            );
            $this->front_model->add_query('dev_web_registraton_forms_filled',$next_form_data);

    }
    public function send_verification($uID,$rendomcode)
    {

        $user = $this->front_model->get_query_simple('*','dev_web_user', array('uID'=>$uID))->result_object()[0];

        $edata = $this->front_model->get_emails_data('user-signup-confirmation');
        $this->load->library('email');
        $this->email->from($edata[0]->eEmail, TITLEWEB);
        $this->email->to($this->input->post('email'));
        $replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]");
        $replacewith = array(base_url(), $rendomcode, $user->uFname." ".$user->uLname,TITLEWEB,$user->uEmail,$this->input->post('password')?$this->input->post('password'):'******');
        $str = str_replace($replace,$replacewith,$edata[0]->eContent);
         $message = $str;
        $this->email->subject($edata[0]->eName);
        $this->email->message($message);
        $this->email->set_mailtype("html");
        // $send = $this->email->send();
        $this->sendgrid_mail(array($user->uEmail,''),$message,$edata[0]->eName);
    }
    public function do_register_admin()
    {
        $datashow = $this->front_model->check_email_user($this->input->post('email'));
        if($datashow > 0)
        {
            $_SESSION['wrongsignup'] = $_POST;
            $_SESSION['error'] = "Email address already exist!";
            header ( "Location:" . $this->config->base_url ()."admin/add/user");
        }
        else
        {
            if(isset($_SESSION['JobsSessions']))
             check_roles(2);
            $rendomcode = $this->generateRandomString();
            if($this->input->post('password')!="")
            {
                $pass=$this->input->post('password');
            }
            else
            {
                $pass = $rendomcode;
            }
            $data = array(
                'uFname'        => $this->input->post('first_name'),
                'uLname'        => $this->input->post('last_name'),
                'uEmail'        => $this->input->post('email'),
                'uUsername'     => $this->input->post('username'),
                'uPassword'     => $this->crypt_scrypt($pass),
                'uDOB'          => $this->input->post('birth_date'),
                'uCountry'      => $this->input->post('country')?$this->input->post('country'):1,
                'uCity'         => $this->input->post('city'),
                'uAddress'      => $this->input->post('address'),
                //'uZip'            => $this->input->post('postal_code'),
                'uActType'      => $this->input->post('type'),
                'uStatus'       => 1,
                'joinDate'      => date('Y-m-d h:i:s'),
                'uIP'           => $_SERVER['REMOTE_ADDR'],
                'uCode'         => $rendomcode,
                //'uSectors'        => $sectoruser,
                'uverifyemail'  => 0,
            );
           $uID = $this->front_model->add_query('dev_web_user',$data);
         //  print_r($_POST);

            foreach($_POST['admin_roles'] as $role_v)
            {
                $arr = array(
                    'admin_id'=>$uID,
                    'role'=>$role_v,
                    'assigned_on'=>date("Y-m-d H:i:s")
                );
               // print_r($arr);

                $this->db->insert('dev_web_admin_roles',$arr);
            }
            // echo $this->db->last_query();
           // exit;


            if($this->input->post('type') == "2"){
                $usetype = "Token Buyer";
            }
            else if($this->input->post('type') == "3"){
                $usetype = "Marketing Affiliate";
            }
            else if($this->input->post('type') == "1")
            {
                $usetype = "Admin";
            }
            else {
                $usetype = "Airdrop/Bounty";
            }
            // SEND EMAIL CONFIRMATION
            $edata = $this->front_model->get_emails_data('admin-signup');
            $this->load->library('email');
            $this->email->from($edata[0]->eEmail, TITLEWEB);
            $this->email->to($this->input->post('email'));
            $replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]","[USERTYPE]");
            $replacewith = array(WEBURL, $rendomcode, $this->input->post('first_name')." ".$this->input->post('last_name'),TITLEWEB,$this->input->post('email'),$pass,$usetype);
            $str = str_replace($replace,$replacewith,$edata[0]->eContent);
            $message = $str;
            $this->email->subject($edata[0]->eName);
            $this->email->message($message);
            $this->email->set_mailtype("html");
            // $send = $this->email->send();
            $this->sendgrid_mail(array($this->input->post('email'),''),$message,$edata[0]->eName);
            unset($_SESSION['wrongsignup']);
            $_SESSION['thankyou'] = "Account has been created successfully & Email has been sent with login details on provided email address.";
            if($this->input->post('to_admin_users')==1)
                header ( "Location:".$this->config->base_url().'admin/admin-users');
            else
                header ( "Location:".$this->config->base_url().'admin/user/reports');
        }
    }
    private function is_logged()
    {
        if(isset($_SESSION['JobsSessions']))
            return true;
        else
            return false;

    }
    private function is_admin()
    {
        if(ACTYPE==1)return true;
        return false;
    }
    public function add_token_new_price()
    {
        $this->is_logged();
        $this->is_admin();



        check_roles(1);
        $arr = array();
        $config     = $this->front_model->get_query_simple('*','dev_web_token_pricing',$arr);
        $status     = $config->num_rows();
        if($status == "0"){
            $status = "1";
        } else {
            $status = "0";
        }
        $data = array(
            'ico_camp'=>$this->input->post('ico_camp'),
            'tokenPrice'        => $this->input->post('price_token'),
            'tokenBonus'        => $this->input->post('bonus'),
            'tokenDateStarts'       => $this->input->post('start_date'),
            'tokenDateEnds'     => $this->input->post('end_date'),
            'tokenCap'          => $this->input->post('address'),
            'min_invest'          => $this->input->post('min_invest'),
            'max_invest'          => $this->input->post('max_invest'),
            'end_on_end_date'          => $this->input->post('end_on_end_date')?$this->input->post('end_on_end_date'):0,
            'end_on_end_token'          => $this->input->post('end_on_end_token')?$this->input->post('end_on_end_token'):0,
            'status'            => $status,
            'addedDate'         => date('Y-m-d h:i:s'),
            'c_type' => $this->input->post('c_type')=="multiple"?"2":"1",
            'end_type'=>$this->input->post('end_type')?$this->input->post('end_type'):3,
            'currency_type'=>$this->input->post('currency_type'),

            'timezone'          => $this->data['web_settings']->timezone,
            'start_time'          => $this->input->post('start_time')?$this->input->post('start_time'):'00:00:00',
            'end_time'          => $this->input->post('end_time')?$this->input->post('end_time'):'23:55:00',
        );



        if($this->input->post('count')=="2")
        {
            if(!isset($_SESSION['prev_tok_data']))
            {
                
                $_SESSION['error']="Your submission was interupted, please try again";
                redirect(base_url().'admin/add/token/pricing/multiple');
                exit;
            }

            $uID = $this->front_model->add_query('dev_web_token_pricing',$_SESSION['prev_tok_data']);
            $data['prev_token']=$uID;
            $uID = $this->front_model->add_query('dev_web_token_pricing',$data);
            $this->store_bonus_data($uID);

            $_SESSION['thankyou'] = "New Token Price Added successfully";
            header ( "Location:".$this->config->base_url().'admin/token/pricing');
            exit;

        }



        if($data['c_type']=="2")
        {
            $_SESSION['prev_tok_data']=$data;
            $_SESSION['error']="Your submitted data will be saved if you will create second template.";
            redirect(base_url().'admin/add/token/pricing/multiple/2');
            exit;
        }


        $uID = $this->front_model->add_query('dev_web_token_pricing',$data);
        $this->store_bonus_data($uID);
        $_SESSION['thankyou'] = "New Token Price Added successfully";
        header ( "Location:".$this->config->base_url().'admin/token/pricing');
    }
    private function store_bonus_data($id)
    {
        foreach($_SESSION['t']['bonus_data'] as $key=>$v)
        {
            $v['token_id']=$id;
            $this->db->insert('dev_web_bonuses',$v);
        }
    }
    public function charge_round($type)
    {
        $this->is_logged();
        $this->is_admin();



        check_roles(1);
        $type = $type==1?1:0;
        $this->db->update('dev_web_config',array('charge_round'=>$type));
         $_SESSION['thankyou'] = "Settings updated successfully";
        $this->redirect_back();

    }
    public function edit_token_pricing($id)
    {
        $this->is_logged();
        $this->is_admin();
        check_roles(1);

        $this->data['token']= $this->front_model->get_query_simple('*','dev_web_token_pricing',array('tkID'=>$id))->result_object()[0];

        if(isset($_POST['ico_camp']))
        {
            $start_date = date("Y-m-d",strtotime($this->input->post('start_date')));
            $end_date = date("Y-m-d",strtotime($this->input->post('end_date')));


            $data = array(
                'ico_camp'=>$this->input->post('ico_camp'),
                'tokenPrice'        => $this->input->post('price_token'),
                'tokenBonus'        => $this->input->post('bonus'),
                'tokenDateStarts'       => $start_date,
                'tokenDateEnds'     => $end_date,
                'tokenCap'          => $this->input->post('address'),
                'min_invest'          => $this->input->post('min_invest'),
                'max_invest'          => $this->input->post('max_invest'),
            'end_type'=>$this->input->post('end_type')?$this->input->post('end_type'):3,
            'currency_type'=>$this->input->post('currency_type'),

                'end_on_end_date'          => $this->input->post('end_on_end_date')?$this->input->post('end_on_end_date'):0,
                'end_on_end_token'          => $this->input->post('end_on_end_token')?$this->input->post('end_on_end_token'):0,

                
             'start_time'          => $this->input->post('start_time')?$this->input->post('start_time'):'00:00:00',
            'end_time'          => $this->input->post('end_time')?$this->input->post('end_time'):'23:55:00',
              
            );

           
            // print_r($data);exit;
            $uID = $this->front_model->update_query('dev_web_token_pricing',$data,array('tkID'=>$id));
            $_SESSION['thankyou'] = "Token Price updated successfully";
            header ( "Location:".$this->config->base_url().'admin/token/pricing');
        }

        $this->load->view('frontend/edit_token_pricing',$this->data);



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
                'uFname'        => $this->input->post('name'),
                'uCompany'      => $this->input->post('name'),
                'uEmail'        => $this->input->post('email'),
                'uUsername'     => $this->input->post('username'),
                'uPassword'     => $this->crypt_scrypt($this->input->post('password')),
                //'uDOB'            => $this->input->post('birth_date'),
                'uManager'      => $this->input->post('manager'),
                'uPhone'        => $this->input->post('phone'),
                'uCountry'      => $this->input->post('country'),
                'uCity'         => $this->input->post('city'),
                'uAddress'      => $this->input->post('address'),
                'uZip'          => $this->input->post('postal_code'),
                'id_company'    => $this->input->post('id_number'),
                'tax_number'    => $this->input->post('tax_number'),
                'uActType'      => 3,
                'uStatus'       => 1,
                'joinDate'      => date('Y-m-d h:i:s'),
                'uIP'           => $_SERVER['REMOTE_ADDR'],
                'uCode'         => $rendomcode,
                'uSectors'      => $sectoruser,
                'uverifyemail'  => 0,
            );
            if(CAPTCHA==1){
                if(!$this->verify_captcha())
                {
                    $_SESSION['wrongsignup'] = $_POST;
                    $_SESSION['msglogin'] = "Captcha Error!";
                    redirect($_SERVER['HTTP_REFERER']);
                    exit;
                }
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
            // $send = $this->email->send();
            $this->sendgrid_mail(array($this->input->post('email'),''),$message,$edata[0]->eName);
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
        else if($row[0]->status == "3"){


            $statusold = "Cancelled";

            
        }
        else if($row[0]->status == "4"){
            $statusold = "Refunded";

            

        }
        $data = array('status' => $this->uri->segment(5));
        $condition = array('tID' => $this->uri->segment(6));
        $this->front_model->update_query('dev_web_transactions',$data,$condition);


        if($data['status']==2)
        {
            $this->add_balance($row[0]->uID,$row[0]->tokens);
            $this->do_referrel_work(array('tokens'=>$row[0]->tokens),$row[0]->uID);
            if(am_i('securix'))
            $this->send_invoice($arr['tID']);           
        }


        if($this->uri->segment(5) == "1"){$statusnew = "Pending";}
        else if($this->uri->segment(5) == "2"){

            $statusnew = "Confirmed";
        }
        else if($this->uri->segment(5) == "3"){
            $statusnew = "Cancelled";
            $template_ = $row[0]->template_used;
            $camp_ = $row[0]->camp_used;

            $this->minus_camp_tokens($camp_,$row[0]->tokens);
            $this->minus_template_tokens($template_,$row[0]->tokens);

        }
        else if($this->uri->segment(5) == "4"){
            $statusnew = "Refunded";
            $template_ = $row[0]->template_used;
            $camp_ = $row[0]->camp_used;

            $this->minus_camp_tokens($camp_,$row[0]->tokens);
            $this->minus_template_tokens($template_,$row[0]->tokens);
        }
        $this->notification_users('Transaction Status Changed','Transaction status changed from <b>'.$statusold.'</b> to <b> '.$statusnew.'</b>');
        $_SESSION['thankyou'] = "Status information updated successfully!";
        header ( "Location:" . $_SERVER['HTTP_REFERER']);
    }
    private function minus_camp_tokens($id,$tokens)
    {
        
        $camp = $this->db->where('id',$id)->get('dev_web_ico_settings')->result_object();
        if(!empty($camp))
        {
            $olds = $camp[0]->tokens_sold;
            $new = $olds - $tokens;

            $this->db->where('id',$camp[0]->id)->update('dev_web_ico_settings',array('tokens_sold'=>$new));return true;
        }
        return false;
    }
    private function minus_template_tokens($id,$tokens)
    {
        $temp = $this->db->where('tkID',$id)->get('dev_web_token_pricing')->result_object();
        if(!empty($temp))
        {
            $olds = $temp[0]->tokens_sold;
            $new = $olds - $tokens;

            $this->db->where('tkID',$temp[0]->tkID)->update('dev_web_token_pricing',array('tokens_sold'=>$new));return true;
        }
        return false;
    }
    // ACCOUNT VERIFICATION
    public function admin_user_actions(){
        $data = array('uStatus' => $this->uri->segment(5));
        $condition = array('uID' => $this->uri->segment(6));
        $this->front_model->update_query('dev_web_user',$data,$condition);
        $_SESSION['thankyou'] = "Status information updated successfully!";
        header ( "Location:" . $_SERVER['HTTP_REFERER']);
    }
    public function unverify_me()
    {
         $data = array('uverifyemail' => 0,);
        $condition = array('uID' => UID);
        $this->front_model->update_query('dev_web_user',$data,$condition);
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
//          $edata = $this->front_model->get_emails_data('accountverified-email');
//
//
//
//
//
//
//
//          $this->load->library('email');
//
//
//
//
//
//
//
//          $this->email->from($edata[0]->eEmail, TITLEWEB);
//
//
//
//
//
//
//
//          $this->email->to($this->input->post('emailadd'));
//
//
//
//
//
//
//
//          $replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]");
//
//
//
//
//
//
//
//          $replacewith = array(WEBURL, $rendomcode, $row[0]->uFname,TITLEWEB,$this->input->post('emailadd'),$this->input->post('passlogin'));
//
//
//
//
//
//
//
//          $str = str_replace($replace,$replacewith,$edata[0]->eContent);
//
//
//
//
//
//
//
//          $message = $str;
//
//
//
//
//
//
//
//          $this->email->subject($edata[0]->eName);
//
//
//
//
//
//
//
//          $this->email->message($message);
//
//
//
//
//
//
//
//          $this->email->set_mailtype("html");
            
        //$this->login_history();
//          $send = $this->email->send();
//            $this->sendgrid_mail(array($this->input->post('email'),''),$message,$edata[0]->eName);
        $_SESSION['thankyou']="Your account has been verified successfully!";
        header ( "Location:".$this->config->base_url().'dashboard');
    }
    // SKIP SIGNUP
    public function singup_skip(){
        $arr = array('uID' => $_SESSION['userID']);
        $datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);
        $row = $datashow->result_object();
        $_SESSION['JobsSessions']   = $row;
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
                'uID'           => $_SESSION['userID'],
                'jobTitle'     => str_replace(" ",",",$this->input->post('jobtitle')),
                'jobSkills'       => str_replace(" ",",",$this->input->post('skills')),
                'jobLocation'   => $benefit,
                'jobNature'       => $this->input->post('jobType'),
                'jobStatus'       => 1,
                'jobInstant'     => 0,
            );
            $this->front_model->add_query('dev_job_alerts',$data);
        }
        if($this->input->post('jCV') == "1"){
            $arr = array('uID' => $_SESSION['userID']);
            $datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);
            $row = $datashow->result_object();
            $_SESSION['JobsSessions']   = $row;
            unset($_SESSION['userID']);
            header ( "Location:".$this->config->base_url()."create-cv");
        }
        else {
            $arr = array('uID' => $_SESSION['userID']);
            $datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);
            $row = $datashow->result_object();
            $_SESSION['JobsSessions']   = $row;
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
            $this->front_model->update_password_checl($this->input->post('email'),$this->crypt_scrypt($rendomcode));
            // SEND EMAIL CONFIRMATION
            $edata = $this->front_model->get_emails_data('forgot-password');
            $this->load->library('email');
            $this->email->from($edata[0]->eEmail, TITLEWEB);
            $this->email->to($this->input->post('email'));
            $replace = array("[WEBURL]","[CODE]","[WEBTITLE]","[USEREMAIL]","[USERPASSWORD]");
            $replacewith = array(WEBURL, $rendomcode,TITLEWEB,$this->input->post('email'),$rendomcode);
            $str = str_replace($replace,$replacewith,$edata[0]->eContent);
            $message = $str;
            $this->email->subject($edata[0]->eName.' - : : - '.TITLEWEB);
            $this->email->message($message);
            $this->email->set_mailtype("html");
            // $send = $this->email->send();
            $this->sendgrid_mail(array($this->input->post('email'),''),$message,$edata[0]->eName);
            $_SESSION['thankyou'] = 'Email with temporary password has been sent!';
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
    public function a_trans()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            $this->load->view('frontend/a_trans', $this->data);
        }
    }
    public function user_reports()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                 check_roles(4);
                $this->load->view('frontend/user_reports', $this->data);
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function admin_users()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                 check_roles(2);
                $this->load->view('frontend/admin_users', $this->data);
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function add_admin_admin()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){

                $this->load->view('frontend/add_admin_admin', $this->data);
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
                $config     = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
                $this->data['countries']    = $config->result_object();
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
                check_roles(1);
                $this->load->view('frontend/admin_token_pricing', $this->data);
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    
    public function add_token_pricing($type="individual",$count="1")
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(1);
                $this->data['c_type']=$type;
                $this->data['count']=$count;
                $this->load->view('frontend/add_token_pricing', $this->data);
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function add_token_pricing_type()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(1);

                if(isset($_POST['c_type']))
                {

                    $_SESSION['t']['c_type']=$this->input->post('c_type');
                    redirect(base_url().'admin/add/token/pricing/bonus/');
                    exit;
                }


                $this->load->view('frontend/add_token_pricing_type', $this->data);
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function add_token_pricing_bonus()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(1);

                if(isset($_POST['b_type']))
                {
                    $_SESSION['t']['b_type']=$this->input->post('b_type');

                    if($_SESSION['t']['b_type']==2)
                    {
                        redirect(base_url().'admin/add/token/pricing/'.$_SESSION['t']['c_type']);
                        exit;
                    }

                    redirect(base_url().'admin/add/token/pricing/bonus-level/');
                    exit;
                }


                $this->load->view('frontend/add_token_pricing_bonus', $this->data);
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function add_token_pricing_bonus_level()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(1);

                if(isset($_POST['submit']))
                {
                    foreach($_POST['bonus'] as $key=>$val)
                    {
                        $arr[]=array(
                            'type'=>$_SESSION['t']['b_type'],
                            'bonus'=>$_POST['bonus'][$key],
                            'more_than'=>$_POST['min_invest'][$key]?$_POST['min_invest'][$key]:0,
                     
                            'less_than'=>$_POST['max_invest'][$key]?$_POST['max_invest'][$key]:-1,
                            'method'=>$_POST['a_type'][$key]?$_POST['a_type'][$key]:1,
                            'from_date'=>$_POST['start_date'][$key],
                            'end_date'=>$_POST['end_date'][$key],
                        );
                    }
                    $_SESSION['t']['bonus_data']=$arr;


                  


                    redirect(base_url().'admin/add/token/pricing/'.$_SESSION['t']['c_type']);
                    exit;
                }


                $this->load->view('frontend/add_token_pricing_bonus_level', $this->data);
            } else {
                $this->load->view('frontend/home', $this->data);
            }
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
            $this->data['users']    = $config->result_array()[0];
            $arr = array();
            $config     = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
            $this->data['countries']    = $config->result_object();
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
            $this->data['users']    = $config->result_array()[0];
            $arr = array();
            $config     = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
            $this->data['countries']    = $config->result_object();
            $this->load->view('frontend/change_password', $this->data);
        }
    }
    //CMS PAGES
    public function pages_cms()
    {
        $arr = array('pLink' => $this->uri->segment(1),'pStatus'=>1);
        $config     = $this->front_model->get_query_simple('*','dev_web_pages',$arr);


        $this->data['pages']    = $config->result_object();

        if($this->data['pages'][0]->type==1){
          redirect($this->data['pages'][0]->pElink);
          exit;
        }
        $this->load->view('frontend/pages', $this->data);
    }
    //CMS PAGES
    public function faq_page()
    {
        $arr = array('fStatus' => 1);
        $config     = $this->front_model->get_query_simple('*','dev_web_faq',$arr);
        $this->data['pages']    = $config->result_object();
        $this->load->view('frontend/faq_page', $this->data);
    }
    //CMS PAGES
    public function faq_page_secruity()
    {
        $arr = array('fStatus' => 2);
        $config     = $this->front_model->get_query_simple('*','dev_web_faq',$arr);
        $this->data['pages']    = $config->result_object();
        $this->load->view('frontend/faq_page', $this->data);
    }
    public function logout()
    {


        $this->logout_history();

        $redi = "Location:".$this->config->base_url();
        unset($_SESSION['sessionCart']);
        unset($_SESSION['sessionCartCandidate']);
        unset($_SESSION['JobsSessions']);
        unset($_SESSION['vf_popup_shown']);
        session_destroy();
        ob_start();
        error_reporting(0);
        session_start();
        $_SESSION['msglogin'] = 'You have logged out successfully!';
        if(isset($_GET['set_msg']))
            $_SESSION['error']=$_GET['set_msg'];
        header($redi);
        //header("Location:".$this->config->base_url().'login');
    }
    public function logout_history()
    {
        $login_history = $this->db->where(array('uID'=>UID))->order_by('id','DESC')->limit(1)->get('dev_web_user_login_history')->result_object()[0];

        $this->front_model->update_query('dev_web_user_login_history',array('logged_out'=>1,'logout_time'=>date("Y-m-d H:i:s")),array('id'=>$login_history->id));

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
                'jID'       => $this->uri->segment(2),
                'uID'       => UID,
                'sDate'     => date('Y-m-d'),
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
            'jID'       => $_SESSION['saveid'],
            'uID'       => $_SESSION['JobsSessions'][0]->uID,
            'sDate'     => date('Y-m-d'),
        );
        $this->front_model->add_query('dev_web_saved',$data);
        unset($_SESSION['saveid']);
        $_SESSION['msglogin'] = "Job saved successfully!";
        header ( "Location:" . $this->config->base_url ()."saved-jobs");
    }
    // REMOVE SAVED
    public function remove_token_price()
    {

        $this->is_logged();
        $this->is_admin();
        check_roles(1);

        $data = array(
            'tkID'      => $this->uri->segment(3),
        );
        $this->front_model->delete_query('dev_web_token_pricing',$data);
        $_SESSION['msglogin'] = "Token Price Removed successfully!";
        header ( "Location:" . $_SERVER['HTTP_REFERER']);
    }
    public function active_token_price()
    {
        $this->is_logged();
        $this->is_admin();
        check_roles(1);
        // UPDATE ALL
        $data = array('status'      => 0);
        $condition = array();
        $this->front_model->update_query('dev_web_token_pricing',$data,$condition);
        // UPDATE SELECTED ONE
        $data = array('status'      => 1);
        $condition = array( 'tkID'  => $this->uri->segment(3));
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
            'cvTitle'       => $this->input->post('coverTitle'),
            'cvText'        => nl2br($this->input->post('coverlettertext')),
            'uID'           => UID,
            'cvDate'        => date('Y-m-d'),
        );
        $this->front_model->add_query('dev_wev_coverletters',$data);
        $_SESSION['msglogin'] = "Cover letter submitted successfully!";
        header ("Location:" . $_SERVER['HTTP_REFERER']);
    }
    // SUBMIT COVER LETTER APPLY
    public function add_apply_coverletter()
    {
        $data = array(
            'cvTitle'       => $this->input->post('covertitle'),
            'cvText'        => nl2br($this->input->post('coverDescp')),
            'uID'           => UID,
            'cvDate'        => date('Y-m-d'),
        );
        $this->front_model->add_query('dev_wev_coverletters',$data);
        //$_SESSION['msglogin'] = "Cover letter submitted successfully!";
        header ("Location:" . $_SERVER['HTTP_REFERER']);
    }
    // EDIT COVER LETTER
    public function cover_letter_edit()
    {
        $data = array(
            'cvTitle'   => $this->input->post('coverTitle'),
            'cvText'     => nl2br($this->input->post('coverlettertext')),
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
    public function delete_admin($uid)
    {
         $this->is_logged();
         $this->is_admin();
         check_roles(2);
        $data = array('uID' => $uid);
        $this->front_model->delete_query('dev_web_user',$data);
        $_SESSION['thankyou'] = "Admin removed successfully!";
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
       // echo ($this->input->post('first_name'));exit;
        $data = array(
            'uFname'                => $this->input->post('first_name'),
            'uLname'                => $this->input->post('last_name'),
            //'uUsername'           => $this->input->post('username'),
            'uPhone'                => $this->input->post('phone'),
            'uCountry'              => $this->input->post('country'),
            'uAddress'              => $this->input->post('address'),
            'uCity'                 => $this->input->post('city'),
            'uTelegram'                 => $this->input->post('telegram'),
            'uZip'      => $this->input->post('postal_code'),
            //'uExperience'             => $this->input->post('explevel'),
            //'uMaritial'           => $this->input->post('maritial'),
        );
       // print_r($data);exit;
        $condition = array('uID' => UID);
        $this->front_model->update_query('dev_web_user',$data,$condition);
        $_SESSION['thankyou'] = "Your account information has been updated Successfully!";
        header ( "Location:" . $this->config->base_url ()."account/details");
    }
    // CHANGE PASSWORD
    public function do_change_password()
    {
        $arr2 = array('uID'=>UID);
        $config2 = $this->front_model->get_query_simple('*','dev_web_user',$arr2);
        
        $count  = $config2->num_rows();
        if($count > 0 && $this->check_scrypt($config2->result_object()[0]->uPassword, $this->input->post('oldpass'))){
            $data = array(
                'uPassword'     => $this->crypt_scrypt($this->input->post('password_new')),
            );
            $condition = array('uID' => UID);
            $this->front_model->update_query('dev_web_user',$data,$condition);
            
            // ADD NoTIFICATIONS
            $this->notification_users('Password Changed','Password has been changed successfully!');
            $_SESSION['thankyou'] = "Password Information Updated Successfully!";
            header ( "Location:" . $this->config->base_url ()."change-password");
        }
        else {
            //$_SESSION['change_div'] = 'change';
            $_SESSION['error'] = "Old Password not match!";
            header ( "Location:" . $this->config->base_url ()."change-password");
        }
    }

    public function do_update_wallet()
    {
        $data = array(
            'uWallet'   => $this->input->post('ethaddress'),
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
        $config2    = $this->front_model->get_query_simple('*','dev_web_cv',$arr);
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
                            'uID'                 => UID,
                            'cvTitle'             => $this->input->post('cvtitle'),
                            'cvView'               => $this->input->post('findcv'),
                            'cvStatus'           => 1,
                            'cvPosted'           => date("Y-m-d"),
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
                        'uID'                 => UID,
                        'cvTitle'              => $this->input->post('cvtitle'),
                        'cvFile'               => $imgname,
                        'cvView'               => $this->input->post('findcv'),
                        'cvStatus'           => 1,
                        'cvPosted'           => date("Y-m-d"),
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
                    'uID'                 => UID,
                    'cvTitle'              => $this->input->post('cvtitle'),
                    'cvView'               => $this->input->post('findcv'),
                    'cvStatus'           => 1,
                    'cvPosted'           => date("Y-m-d"),
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
                        'cvView'               => $this->input->post('findcv'),
                        'cvTitle'              => $this->input->post('cvtitle'),
                        'cvUpdated'             => date("Y-m-d"),
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
                        'cvFile'               => $imgname,
                        'cvTitle'              => $this->input->post('cvtitle'),
                        'cvView'               => $this->input->post('findcv'),
                        'cvUpdated'             => date("Y-m-d"),
                    );
                    $condition2 = array('cvID' => $this->input->post('cvID'));
                    $this->front_model->update_query('dev_web_cv',$data,$condition2);
                    $_SESSION['msglogin'] = "CV and profile information updated successfully!";
                    header ( "Location:" . $this->config->base_url ()."create-cv?page=preferred");
                }
            }
            else {
                $data = array(
                    'cvTitle'              => $this->input->post('cvtitle'),
                    'cvView'               => $this->input->post('findcv'),
                    'cvUpdated'             => date("Y-m-d"),
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
        $config2    = $this->front_model->get_query_simple('*','dev_web_cv',$arr);
        $row = $config2->result_object();
        $data = array(
            'pJobtitle'             => $this->input->post('jobtitle'),
            'pjobskills'           => $this->input->post('skills'),
            'jobSector'             => $benefit,
            'pjoblocation'       => $loca,
            'prelocate'             => $this->input->post('relocate'),
            'pjobtype'           => $this->input->post('jobtype'),
            'psalaryfrom'         => $this->input->post('salaryfrom'),
            'psalaryto'             => $this->input->post('salaryto'),
            'pcurrency'             => $this->input->post('currency'),
            //'cvUpdated'           => date("Y-m-d"),
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
            'uFname'          => $this->input->post('fname'),
            'uLname'          => $this->input->post('lname'),
            'uDOB'          => $this->input->post('dob'),
            'uCountry'      => $this->input->post('country'),
            'uAddress'      => $this->input->post('address'),
            'uCity'            => $this->input->post('city'),
            'uZip'          => $this->input->post('zip'),
            'uPhone'          => $this->input->post('country_code')."-".$this->input->post('contact'),
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
        $config2    = $this->front_model->get_query_simple('*','dev_web_cv',$arr);
        $row = $config2->result_object();
        $data = array(
            'anoticeperiod'         => $this->input->post('notice'),
            'alanguage'             => $this->input->post('languages'),
            'aeducationlevel'     => $this->input->post('leveleducation'),
            'ayear'                 => $this->input->post('graduation'),
            'ajobsummary'         => $this->input->post('jobsummary'),
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
        $config2    = $this->front_model->get_query_simple('*','dev_web_cv',$arr);
        $count = $config2->num_rows();
        if($count == 0)
        {
            // Add data in table
            $data = array(
                'uFname'          => $this->input->post('fname'),
                'uLname'          => $this->input->post('lname'),
                'uDOB'          => $this->input->post('dob'),
                'uCountry'      => $this->input->post('country'),
                'uAddress'      => $this->input->post('address'),
                'uCity'            => $this->input->post('city'),
                'uZip'          => $this->input->post('zip'),
                'uPhone'          => $this->input->post('country_code').$this->input->post('contact'),
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
                        'uID'                 => UID,
                        'cvTitle'             => $this->input->post('cvtitle'),
                        'cvView'               => $this->input->post('findcv'),
                        'pJobtitle'             => $this->input->post('jobtitle'),
                        'pjobskills'           => $this->input->post('skills'),
                        'jobSector'            =>  $benefit,
                        'pjoblocation'       => $loca,
                        'prelocate'             => $this->input->post('relocate'),
                        'pjobtype'           => $this->input->post('jobtype'),
                        'psalaryfrom'         => $this->input->post('salaryfrom'),
                        'psalaryto'             => $this->input->post('salaryto'),
                        'pcurrency'             => $this->input->post('currency'),
                        'anoticeperiod'         => $this->input->post('notice'),
                        'alanguage'             => $this->input->post('languages'),
                        'aeducationlevel'     => $this->input->post('leveleducation'),
                        'ayear'                 => $this->input->post('graduation'),
                        'ajobsummary'         => $this->input->post('jobsummary'),
                        'cvStatus'           => 1,
                        'cvPosted'           => date("Y-m-d"),
                    );
                    $this->front_model->add_query('dev_web_cv',$data);
                    $_SESSION['msglogin'] = "Error while uploading CV, but other information update successfully!";
                    header ( "Location:" . $this->config->base_url ()."cv-management");
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());
                    $data = array(
                        'uID'                 => UID,
                        'cvTitle'              => $this->input->post('cvtitle'),
                        'cvFile'               => $imgname,
                        'cvView'               => $this->input->post('findcv'),
                        'pJobtitle'             => $this->input->post('jobtitle'),
                        'pjobskills'           => $this->input->post('skills'),
                        'jobSector'            =>  $benefit,
                        'pjoblocation'       => $loca,
                        'prelocate'             => $this->input->post('relocate'),
                        'pjobtype'           => $this->input->post('jobtype'),
                        'psalaryfrom'         => $this->input->post('salaryfrom'),
                        'psalaryto'             => $this->input->post('salaryto'),
                        'pcurrency'             => $this->input->post('currency'),
                        'anoticeperiod'         => $this->input->post('notice'),
                        'alanguage'             => $this->input->post('languages'),
                        'aeducationlevel'     => $this->input->post('leveleducation'),
                        'ayear'                 => $this->input->post('graduation'),
                        'ajobsummary'         => $this->input->post('jobsummary'),
                        'cvStatus'           => 1,
                        'cvPosted'           => date("Y-m-d"),
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
                    'uID'                 => UID,
                    'cvTitle'              => $this->input->post('cvtitle'),
                    'cvView'               => $this->input->post('findcv'),
                    'pJobtitle'             => $this->input->post('jobtitle'),
                    'pjobskills'           => $this->input->post('skills'),
                    'jobSector'            => $benefit,
                    'pjoblocation'       => $loca,
                    'prelocate'             => $this->input->post('relocate'),
                    'pjobtype'           => $this->input->post('jobtype'),
                    'psalaryfrom'         => $this->input->post('salaryfrom'),
                    'psalaryto'             => $this->input->post('salaryto'),
                    'pcurrency'             => $this->input->post('currency'),
                    'anoticeperiod'         => $this->input->post('notice'),
                    'alanguage'             => $this->input->post('languages'),
                    'aeducationlevel'     => $this->input->post('leveleducation'),
                    'ayear'                 => $this->input->post('graduation'),
                    'ajobsummary'         => $this->input->post('jobsummary'),
                    'cvStatus'           => 1,
                    'cvPosted'           => date("Y-m-d"),
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
                'uFname'          => $this->input->post('fname'),
                'uLname'          => $this->input->post('lname'),
                'uDOB'          => $this->input->post('dob'),
                'uCountry'      => $this->input->post('country'),
                'uAddress'      => $this->input->post('address'),
                'uCity'            => $this->input->post('city'),
                'uZip'          => $this->input->post('zip'),
                'uPhone'          => $this->input->post('contact'),
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
                        'cvView'               => $this->input->post('findcv'),
                        'cvTitle'              => $this->input->post('cvtitle'),
                        'pJobtitle'             => $this->input->post('jobtitle'),
                        'pjobskills'           => $this->input->post('skills'),
                        'jobSector'            =>  $benefit,
                        'pjoblocation'       => $loca,
                        'prelocate'             => $this->input->post('relocate'),
                        'pjobtype'           => $this->input->post('jobtype'),
                        'psalaryfrom'         => $this->input->post('salaryfrom'),
                        'psalaryto'             => $this->input->post('salaryto'),
                        'pcurrency'             => $this->input->post('currency'),
                        'anoticeperiod'         => $this->input->post('notice'),
                        'alanguage'             => $this->input->post('languages'),
                        'aeducationlevel'     => $this->input->post('leveleducation'),
                        'ayear'                 => $this->input->post('graduation'),
                        'ajobsummary'         => $this->input->post('jobsummary'),
                        'cvUpdated'             => date("Y-m-d"),
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
                        'cvFile'               => $imgname,
                        'cvTitle'              => $this->input->post('cvtitle'),
                        'cvView'               => $this->input->post('findcv'),
                        'pJobtitle'             => $this->input->post('jobtitle'),
                        'pjobskills'           => $this->input->post('skills'),
                        'jobSector'            => $benefit,
                        'pjoblocation'       => $loca,
                        'prelocate'             => $this->input->post('relocate'),
                        'pjobtype'           => $this->input->post('jobtype'),
                        'psalaryfrom'         => $this->input->post('salaryfrom'),
                        'psalaryto'             => $this->input->post('salaryto'),
                        'pcurrency'             => $this->input->post('currency'),
                        'anoticeperiod'         => $this->input->post('notice'),
                        'alanguage'             => $this->input->post('languages'),
                        'aeducationlevel'     => $this->input->post('leveleducation'),
                        'ayear'                 => $this->input->post('graduation'),
                        'ajobsummary'         => $this->input->post('jobsummary'),
                        'cvUpdated'             => date("Y-m-d"),
                    );
                    $condition2 = array('cvID' => $this->input->post('cvID'));
                    $this->front_model->update_query('dev_web_cv',$data,$condition2);
                    $_SESSION['msglogin'] = "CV and profile information updated successfully!";
                    header ( "Location:" . $this->config->base_url ()."cv-management");
                }
            }
            else {
                $data = array(
                    'cvTitle'              => $this->input->post('cvtitle'),
                    'cvView'               => $this->input->post('findcv'),
                    'pJobtitle'             => $this->input->post('jobtitle'),
                    'pjobskills'           => $this->input->post('skills'),
                    'jobSector'            => $benefit,
                    'pjoblocation'       => $loca,
                    'prelocate'             => $this->input->post('relocate'),
                    'pjobtype'           => $this->input->post('jobtype'),
                    'psalaryfrom'         => $this->input->post('salaryfrom'),
                    'psalaryto'             => $this->input->post('salaryto'),
                    'pcurrency'             => $this->input->post('currency'),
                    'anoticeperiod'         => $this->input->post('notice'),
                    'alanguage'             => $this->input->post('languages'),
                    'aeducationlevel'     => $this->input->post('leveleducation'),
                    'ayear'                 => $this->input->post('graduation'),
                    'ajobsummary'         => $this->input->post('jobsummary'),
                    'cvUpdated'             => date("Y-m-d"),
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
            'jID'                 => $this->input->post('jID'),
            'uID'                 => UID,
            'cvID'               => $this->input->post('cv'),
            'cvrID'                 => $this->input->post('coverletter'),
            'aAuthorized'         => $this->input->post('authorized'),
            'appliedDate'         => date("Y-m-d"),
            'refrenceApplied'     => $ref,
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
            'uFname'          => $this->input->post('fname'),
            'uLname'          => $this->input->post('lname'),
            'uDOB'          => $this->input->post('dob'),
            'uCountry'      => $this->input->post('country'),
            'uAddress'      => $this->input->post('address'),
            'uCity'            => $this->input->post('city'),
            'uZip'          => $this->input->post('zip'),
            'uPhone'          => $this->input->post('contact'),
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
                    'uID'                 => $_SESSION['userID'],
                    'cvFile'               => $imgname,
                    'cvView'               => $this->input->post('findcv'),
                    'pJobtitle'             => $this->input->post('jobtitle'),
                    'pjobskills'           => $this->input->post('skills'),
                    'pjoblocation'       => $this->input->post('location'),
                    'prelocate'             => $this->input->post('relocate'),
                    'pjobtype'           => $this->input->post('jobtype'),
                    'psalaryfrom'         => $this->input->post('salaryfrom'),
                    'psalaryto'             => $this->input->post('salaryto'),
                    'anoticeperiod'         => $this->input->post('notice'),
                    'alanguage'             => $this->input->post('languages'),
                    'aeducationlevel'     => $this->input->post('leveleducation'),
                    'ayear'                 => $this->input->post('graduation'),
                    'ajobsummary'         => $this->input->post('jobsummary'),
                    'cvStatus'           => 1,
                    'cvPosted'           => date("Y-m-d"),
                );
                $this->front_model->add_query('dev_web_cv',$data);
                $arr = array('uID' => $_SESSION['userID']);
                $datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);
                $row = $datashow->result_object();
                $_SESSION['JobsSessions']   = $row;
                unset($_SESSION['userID']);
                $_SESSION['msglogin'] = "Cv and profile information added successfully!";
                header ( "Location:" . $this->config->base_url ()."thank-you");
            }
        }
        else {
            $data = array(
                'uID'                 => $_SESSION['userID'],
                'cvView'               => $this->input->post('findcv'),
                'pJobtitle'             => $this->input->post('jobtitle'),
                'pjobskills'           => $this->input->post('skills'),
                'pjoblocation'       => $this->input->post('location'),
                'prelocate'             => $this->input->post('relocate'),
                'pjobtype'           => $this->input->post('jobtype'),
                'psalaryfrom'         => $this->input->post('salaryfrom'),
                'psalaryto'             => $this->input->post('salaryto'),
                'anoticeperiod'         => $this->input->post('notice'),
                'alanguage'             => $this->input->post('languages'),
                'aeducationlevel'     => $this->input->post('leveleducation'),
                'ayear'                 => $this->input->post('graduation'),
                'ajobsummary'         => $this->input->post('jobsummary'),
                'cvStatus'           => 1,
                'cvPosted'           => date("Y-m-d"),
            );
            $this->front_model->add_query('dev_web_cv',$data);
            $arr = array('uID' => $_SESSION['userID']);
            $datashow = $this->front_model->get_query_simple('*','dev_web_user',$arr);
            $row = $datashow->result_object();
            $_SESSION['JobsSessions']   = $row;
            unset($_SESSION['userID']);
            $_SESSION['msglogin'] = "Cv and profile information added successfully!";
            header ( "Location:" . $this->config->base_url ()."thank-you");
        }
    }
    public function change_status()
    {
        $data = array(
            'aStatus'   => $this->uri->segment(4),
        );
        $condition = array(
            'aID'   => $this->uri->segment(3),
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
            'sID'          => UID,
            'sMessage'    => $_REQUEST['message'],
            'uID'          => $_REQUEST['sid'],
            'mdID'         => $msgid,
            'mPosted'      => date("Y-m-d h:i:s"),
            'mFirst'        => $cfirst,
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
            'sID'          => UID,
            'sMessage'    => $_REQUEST['message'],
            'uID'          => $_REQUEST['sid'],
            'mdID'         => $_REQUEST['mid'],
            'mPosted'      => date("Y-m-d h:i:s"),
            'mFirst'        => 0,
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
    
    
    /* Function to change profile picture */
    public function changeProfilePic() {
        $post = isset($_POST) ? $_POST: array();
        $max_width = "500";
        $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
        $path = 'resources/uploads/profile/';
        $valid_formats = array("jpg", "png", "gif", "bmp","jpeg","JPG", "PNG", "GIF", "BMP","JPEG");
        $name = $_FILES['profile-pic']['name'];
        $size = $_FILES['profile-pic']['size'];
        if(strlen($name)) {
            list($txt, $ext) = explode(".", $name);

            $nw_cond_ext = explode('.',$name)[count(explode('.',$name))-1];

            if(in_array($nw_cond_ext,$valid_formats)) {
                if($size<(1024*1024)) {
                    $actual_image_name = "resize_".date("ymdhis").'_avatar'.'_'.$userId.'.'.$nw_cond_ext;
                    $filePath = $path .'/'.$actual_image_name;
                    $tmp = $_FILES['profile-pic']['tmp_name'];
                    if(move_uploaded_file($tmp, $filePath)) {
                        $width = $this->getWidth($filePath);
                        $height = $this->getHeight($filePath);
                        //Scale the image if it is greater than the width set above
                        if ($width > $max_width){
                            $scale = $max_width/$width;
                            $uploaded = $this->resizeImage($filePath,$width,$height,$scale,$nw_cond_ext);
                        } else {
                            $scale = 1;
                            $uploaded = $this->resizeImage($filePath,$width,$height,$scale,$nw_cond_ext);
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
    
    public function get_json_data()
    {
        $ind = $this->front_model->checkselect2skills($_REQUEST['q']);
        $industry = $ind->result_object();
        echo  json_encode($industry);
    }
    public function cancel_draft_job()
    {
        $data = array(
            'jID'       => $this->uri->segment(3),
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
             check_roles(1);



            $arr = array();
            $config     = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
            $this->data['countries']    = $config->result_object();
            if(ACTYPE == "1"){
                
             
                    $this->data['options']=$this->front_model->get_query_simple('*','dev_web_payment_options',array())->result_object();
                    $this->data['options']=$this->db->order_by('type','ASC')->get('dev_web_payment_options')->result_object();
                    $this->load->view('frontend/payment_options', $this->data);
                
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    function inactive_payment_option()
    {
         $this->is_logged();
         $this->is_admin();
         check_roles(1);
        $id = $this->input->post('id');
        $condition = array("id" => $this->input->post('id'));
        $this->front_model->update_query('dev_web_payment_options',array('active'=>0),$condition);
    }
    public function buy_tokens_0()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "2"){


                $this->if_not_allowed();
            
                
                $this->data['verified_or_not'] = $this->only_check_if_verified();
                





                if(!am_i('securix'))
                {


                    if(am_i('tib'))
                    {


                        if(isset($_POST['submit']))
                        {
                            $type  = $this->input->post('type');

                           
                            $_SESSION['buy_tokens_tib']['type']=$type;
                            redirect(base_url('buy-tokens/enter-amount'));
                               
                        }
                        else
                        {
                            $this->data['options']=$this->front_model->get_query_simple('*','dev_web_payment_options',array('active'=>1))->result_object();
                           
                            $con = array();
                            

                            $this->data['options']=$this->db->where($con)->where('active',1)->order_by('type','ASC')->get('dev_web_payment_options')->result_object();
                            
                            $this->load->view('frontend/buy_tokens_tib', $this->data);
                        }



                    }
                    else
                    {
                        if(isset($_POST['option']))
                        {
                            $condition = array("id" => $this->input->post('option'));
                           
                            $payment_option = $this->front_model->get_query_simple('*','dev_web_payment_options',$condition)->result_object()[0];
                            
                            //  print_r($payment_option);exit;
                            $_SESSION['buy_step_1'] = $_POST;
                            redirect(base_url().'buy-tokens/'.url_title(strtolower($payment_option->name)));
                        }
                        else
                        {
                            $this->data['options']=$this->front_model->get_query_simple('*','dev_web_payment_options',array('active'=>1))->result_object();
                           
                            $con = array();
                            

                            $this->data['options']=$this->db->where($con)->where('active',1)->order_by('type','ASC')->get('dev_web_payment_options')->result_object();
                            $this->load->view('frontend/buy_tokens_securix', $this->data);
                        }

                    }





                    









                }

                else
                {

                

                    if(isset($_POST['c_type']))
                    {
                        $condition = array("id" => $this->input->post('option'));
                        $payment_option = $this->front_model->get_query_simple('*','dev_web_payment_options',$condition)->result_object()[0];
                        $_SESSION['c_type'] = $this->input->post('c_type');
                        redirect(base_url().'buy-tokens/'.$_SESSION['c_type']);
                    }
                    else
                    {
                       
                        $this->load->view('frontend/buy_tokens_step_0', $this->data);
                    }
                }
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function buy_tokens_enter_amount()
    {
        if(!isset($_SESSION['buy_tokens_tib']['type']))
        {
            redirect(base_url('buy-tokens'));
            exit;
        }
        $this->data['on_verification_page']=true;
        $_SESSION['vf_popup_shown']=true;


        if(isset($_POST['submit']))
        {
            $_SESSION['buy_tokens_tib']['step_2']=$_POST;
            $_SESSION['buy_time']=time();
            redirect(base_url().'buy-tokens/general-terms');
            exit;
        }
        else
        {
            $this->data['type'] = $_SESSION['buy_tokens_tib']['type'];
            $this->load->view('frontend/buy_tokens_enter_amount',$this->data);
        }
    }
    public function buy_tokens_1()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "2"){

                $this->if_not_allowed();
                

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
                    if($_SESSION['c_type']=="crypto"){
                        $con = array('type'=>1);
                    }
                    elseif($_SESSION['c_type']=="fiat"){
                        $con = array('type !='=>1);
                    }
                    else{
                        $con = array('type'=>11111111);
                    }

                    $this->data['options']=$this->db->where($con)->where('active',1)->order_by('type','ASC')->get('dev_web_payment_options')->result_object();
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
                    if($_SESSION['c_type']=="crypto"){
                        $arr_con = array('type'=>1,'id'=>$_SESSION['buy_step_1']['option'],'active'=>1);
                    }
                    elseif($_SESSION['c_type']=="fiat"){
                        $arr_con = array('type !='=>1,'id'=>$_SESSION['buy_step_1']['option'],'active'=>1);
                    }
                    else{
                        $arr_con = array('type'=>11111111,'id'=>$_SESSION['buy_step_1']['option'],'active'=>1);
                    }
                    $this->data['option']=$this->front_model->get_query_simple('*','dev_web_payment_options',$arr_con)->result_object()[0];
                    $this->data['active_token']=$this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
                    $price_should_be = $this->data['active_token']->tokenPrice;
                    if($this->data['active_token']->currency_type!="USD")
                        $price_should_be=calculate_price_should_be($this->data['active_token']);
                    $this->data['price_should_be']=$price_should_be;
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

                    $this->dont_let_same_hash_go();


                    // $_SESSION['buy_step_2']=$_POST;
                    if($_SESSION['c_type']=="crypto"){
                        $arr_con = array('type'=>1,'id'=>$_SESSION['buy_step_1']['option'],'active'=>1);
                    }
                    elseif($_SESSION['c_type']=="fiat"){
                        $arr_con = array('type !='=>1,'id'=>$_SESSION['buy_step_1']['option'],'active'=>1);
                    }
                    else{
                        $arr_con = array('type'=>11111111,'id'=>$_SESSION['buy_step_1']['option'],'active'=>1);
                    }

                    if(!am_i('securix'))
                    {
                        $arr_con = array('id'=>$_SESSION['buy_step_1']['option'],'active'=>1);
                    }




                    $this->data['option']=$this->front_model->get_query_simple('*','dev_web_payment_options',$arr_con)->result_object()[0];

                    $this->data['active_token']=$this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
                    $price_should_be = $this->data['active_token']->tokenPrice;
                    if($this->data['active_token']->currency_type!="USD")
                        $price_should_be=calculate_price_should_be($this->data['active_token']);
                    $this->data['active_camp_']=$this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$this->data['active_token']->ico_camp))->result_object()[0];
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



                    
                    $total_tokens = $_SESSION['buy_step_2']['amount'];


                    $two_payments = false;


                     if($this->data['active_token']->c_type==2){

                    if($total_tokens > ($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold ))
                    {
                        $from_first = ($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold);

                         $from_first_w = $from_first;



                        $from_second =$total_tokens - $from_first;

                         $from_second_w = $from_second;


                        if(next_token($this->data['active_token']->tkID))
                        {



                            $next_token = next_token($this->data['active_token']->tkID);

                             
                            if(!empty($next_token)){


                                $percent_ = ($this->get_version_2_bonus_part_2($from_first,$this->data['active_token']->tkID)/100);
                                $total_tokens___b = $percent_ * $from_first;
                                // $from_first_bonus = $total_tokens___ + $from_first;

                                $percent_ = ($this->get_version_2_bonus_part_2($from_second,$next_token->tkID)/100);
                                $total_tokens___ = $percent_ * $from_second;
                                $from_second = $total_tokens___ + $from_second;

                                $from_second = $from_second + $total_tokens___b;

                                $total_tokens = $from_first + $from_second;



                                $price_first = $from_first_w * $price_should_be;


                                $price_should_be_second = $next_token->tokenPrice;
                                    if($next_token->currency_type!="USD")
                                        $price_should_be_second=calculate_price_should_be($next_token);

                                if($this->data['web_settings']->charge_round==1){
                                    $second_price = $from_second * $price_should_be_second;
                                }
                                else
                                {
                                    $second_price = $from_second * $price_should_be;
                                }


                                $second_price = $from_second_w * $price_should_be_second;
                                $without_volitility = $price_first + $second_price;
                                $price_first = $this->add_volitility($price_first,$this->data['option']->volatility);
                                $second_price = $this->add_volitility($second_price,$this->data['option']->volatility);



                                $total_price = $price_first + $second_price;
                                $two_payments = true;
                            }

                            

                        }
                    }
                    else
                    {



                      $percent = ($this->get_version_2_bonus_part_2($_SESSION['buy_step_2']['amount'],$this->data['active_token']->tkID)/100); 
                        $total_tokens = $percent * $_SESSION['buy_step_2']['amount'];
                        $total_tokens = $total_tokens + $_SESSION['buy_step_2']['amount'];



                        // echo $total_tokens;exit;
                        $total_price = $_SESSION['buy_step_2']['amount']*$price_should_be;
                        $without_volitility = $total_price;
                        $total_price = $this->add_volitility($total_price,$this->data['option']->volatility);

                    }
                }
                    else{

                        

                    // print_r($this->data['option']);

                         $percent = ($this->get_version_2_bonus_part_2($_SESSION['buy_step_2']['amount'],$this->data['active_token']->tkID)/100);
                         // echo $percent;exit;
                        $total_tokens = $percent * $_SESSION['buy_step_2']['amount'];
                         $total_tokens = $total_tokens + $_SESSION['buy_step_2']['amount'];



                        // echo $total_tokens;exit;
                        $total_price = $_SESSION['buy_step_2']['amount']*$price_should_be;
                        $without_volitility = $total_price;
                        $total_price = $this->add_volitility($total_price,$this->data['option']->volatility);

                    }




                   

                    

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
                            $_SESSION['error']="Some error occured while processing your payment, please try again";
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
                    
                    

                    if(!$two_payments)
                    {

                        

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
                            'transaction_id'=>$_SESSION['trans_id'],
                            'template_used'=>$this->data['active_token']->tkID,//
                            'conversion_rate'=>$_SESSION['by']['conversion_rate'],
                            'without_volitility_usd'=>$without_volitility,
                            'volitility_percent'=>$this->data['option']->volatility,
                            'tokenPrice'=>$price_should_be,
                            'without_bonus_tokens'=>$_SESSION['buy_step_2']['amount'],
                            'camp_used'=>$this->data['active_token']->ico_camp,
                        );

                      

                        if($arr['status']==2){

                            $this->add_balance(UID,$total_tokens);
                            $this->do_referrel_work($arr,$arr['uID']);
                            

                        }
                        
                        $id_trans = $this->front_model->add_query('dev_web_transactions',$arr);
                        $this->tokens_sold($this->data['active_token']->ico_camp,$total_tokens,$this->data['active_token']->tkID);


                        if($pre_paid==1)
                        {
                            if(am_i('securix'))
                           $this->send_invoice($id_trans);
                        }
                        if($this->data['option']->address!=$_SESSION['transaction_address'])
                        {
                            $arr = array('used'=>1,'used_on'=>date("Y-m-d H:i:s"),'used_in'=>$id_trans);
                            $this->db->where('address',$_SESSION['transaction_address'])
                            ->where('option_id',$this->data['option']->id)
                            ->update('dev_web_wallet_addresses',$arr);
                        }
                    }
                    else{



                        // $percent = (get_calculated_bonus($this->data['active_token']->tkID,$_SESSION['buy_step_2']['amount'],am_i('scia'))/100);
                        // $total_tokens = $percent * $_SESSION['buy_step_2']['amount'];
                        // 
                        // 
                        if($price_first>$second_price){

                            $percent_for_f_n_t = $second_price / $price_first;

                            $crypt_for_first = $_SESSION['crypto_required']*$percent_for_f_n_t;
                            $crypt_for_second = $_SESSION['crypto_required'] - $crypt_for_first;

                        }
                        else{
                            $percent_for_f_n_t =   $price_first / $second_price;
                            $crypt_for_first = $_SESSION['crypto_required']*$percent_for_f_n_t;
                            $crypt_for_second = $_SESSION['crypto_required'] - $crypt_for_first;

                        }

                       



                        $arr = array(
                            'tokens'=>$from_first,
                            'currency'=>$_SESSION['buy_step_1']['option'],
                            'amountPaid'=>$crypt_for_first,
                            'amtType'=>$this->data['option']->name,
                            'usdPayment'=>$price_first,
                            'hash'=>$pre_hash,
                            'status'=>$pre_paid==0?1:2,
                            'datecreated'=>date("Y-m-d H:i:s"),
                            'uIP'=>$_SERVER['REMOTE_ADDR'],
                            'uID'=>UID,
                            'transaction_id'=>$_SESSION['trans_id'],
                            'template_used'=>$this->data['active_token']->tkID,//
                            'conversion_rate'=>$_SESSION['by']['conversion_rate'],
                            'without_volitility_usd'=>$without_volitility,
                            'volitility_percent'=>$this->data['option']->volatility,
                            'tokenPrice'=>$price_should_be,
                            'without_bonus_tokens'=>$from_first_w,
                            'camp_used'=>$this->data['active_token']->ico_camp,
                        );
                        
                        if($arr['status']==2){

                            $this->add_balance(UID,$from_first);
                            $this->do_referrel_work($arr,$arr['uID']);

                        }
                        
                        $id_trans = $this->front_model->add_query('dev_web_transactions',$arr);
                        $this->tokens_sold($this->data['active_token']->ico_camp,$from_first,$this->data['active_token']->tkID);

                        if($pre_paid==1)
                        {
                            if(am_i('securix'))
                           $this->send_invoice($id_trans);
                        }
                        if($this->data['option']->address!=$_SESSION['transaction_address'])
                        {
                            $arr = array('used'=>1,'used_on'=>date("Y-m-d H:i:s"),'used_in'=>$id_trans);
                            $this->db->where('address',$_SESSION['transaction_address'])
                            ->where('option_id',$this->data['option']->id)
                            ->update('dev_web_wallet_addresses',$arr);
                        }


                        //two
                        $arr = array(
                            'tokens'=>$from_second,
                            'currency'=>$_SESSION['buy_step_1']['option'],
                            'amountPaid'=>$crypt_for_second,
                            'amtType'=>$this->data['option']->name,
                            'usdPayment'=>$second_price,
                            'hash'=>$pre_hash,
                            'status'=>$pre_paid==0?1:2,
                            'datecreated'=>date("Y-m-d H:i:s"),
                            'uIP'=>$_SERVER['REMOTE_ADDR'],
                            'uID'=>UID,
                            'transaction_id'=>$_SESSION['trans_id'],
                            'template_used'=>$next_token->tkID,//
                            'conversion_rate'=>$_SESSION['by']['conversion_rate'],
                            'without_volitility_usd'=>$without_volitility,
                            'volitility_percent'=>$this->data['option']->volatility,
                            'tokenPrice'=>$price_should_be_second,
                            'without_bonus_tokens'=>$from_second_w,
                            'camp_used'=>$next_token->ico_camp,
                            // 'token_template_used'=>
                        );



                        if($arr['status']==2){

                            $this->add_balance(UID,$from_second);
                            $this->do_referrel_work($arr,$arr['uID']);

                        }
                        
                        $id_trans = $this->front_model->add_query('dev_web_transactions',$arr);
                        $this->tokens_sold($next_token->ico_camp,$from_second,$next_token->tkID);


                        if($pre_paid==1)
                        {
                            if(am_i('securix'))
                           $this->send_invoice($id_trans);
                        }
                        if($this->data['option']->address!=$_SESSION['transaction_address'])
                        {
                            $arr = array('used'=>1,'used_on'=>date("Y-m-d H:i:s"),'used_in'=>$id_trans);
                            $this->db->where('address',$_SESSION['transaction_address'])
                            ->where('option_id',$this->data['option']->id)
                            ->update('dev_web_wallet_addresses',$arr);
                        }



                        $this->active_new_camp_new_tok($next_camp->id,$next_token->tkID);



                    }







                    unset($_SESSION['buy_step_1']);
                    unset($_SESSION['buy_step_2']);
                    unset($_SESSION['buy_time']);
                    unset($_SESSION['trans_id']);
                    unset($_SESSION['crypto_required']);
                    unset($_SESSION['by']);




                    if(!am_i('securix'))
                    {

                        if($this->data['user_verified']!=1 && $this->data['kyc_verification_enabled']==1 && $this->data['kyc_verification_at']==3)
                        {

                            redirect(base_url().'kyc-verification');
                        }
                        else
                        {
                            $_SESSION['thankyou']="Thank you for the purchasing the tokens";
                            redirect(base_url().'tranasctions');

                        }
                    }
                    else{




                        if($this->data['user_verified']!=1 && $this->data['kyc_verification_enabled']==1 && $this->data['kyc_verification_at']==2 && ($this->data['kyc_verification_at_crypto']==2 || $this->data['kyc_verification_at_fiat']==2))
                        {
                            $_SESSION['needs_kyc']=1;

                            //redirect(base_url().'kyc-verification');
                        }
                        else
                        {
                            $_SESSION['needs_kyc']=0;
                            

                        }
                        //$_SESSION['thankyou']="Thank you for the purchasing the tokens";
                        redirect(base_url().'thank-you-for-your-purchase');

                    }




                    

                }
                else
                {
                    $trans_id = guid();
                    $this->data['trans_id']=$trans_id;
                    $_SESSION['trans_id']=$trans_id;
                    $this->data['option']=$this->front_model->get_query_simple('*','dev_web_payment_options',array('id'=>$_SESSION['buy_step_1']['option']))->result_object()[0];


                    $address = $this->get_latest_address($this->data['option']->id);
                    $_SESSION['transaction_address']=$address;
                    $this->data['address']=$address;




                    $this->data['active_token']=$this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
                    $this->data['active_camp_']=$this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$this->data['active_token']->ico_camp))->result_object()[0];


                    $price_should_be=$this->data['active_token']->tokenPrice;
                    if($this->data['active_token']->currency_type!="USD")
                        $price_should_be=calculate_price_should_be($this->data['active_token']);
                    $this->data['price_should_be']=$price_should_be;
                    

                    $converting = convert_curr($this->data['option']->c_name);
                    $converting = json_decode($converting,true);
                    foreach($converting as $cc)
                        $converting = $cc;
                    // print_r($converting);exit;
                    $_SESSION['by']['conversion_rate']=$converting;
                    
                    $arr = array(
                        'transaction_id'=>$trans_id,
                        'address'=>$address,
                        'currency'=>$this->data['option']->name,
                        'price_per_token'=>$price_should_be,
                        'total_tokens'=>$_SESSION['buy_step_2']['amount'],
                        'amount_paid'=>$_SESSION['buy_step_2']['amount']*$price_should_be
                    );





                   
                    $arr['amount_paid'] = $this->add_volitility($arr['amount_paid'],$this->data['option']->volatility);




                    ////if tokens ended
                    $two_payments = false;
                    $total_tokens = $arr['total_tokens'];


                    if($total_tokens > ($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold ) && $this->data['active_token']->c_type==1)
                    {
                         $_SESSION['error']="Sorry, we don't have sufficient tokens. You can only purchase ".($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold)." tokens for now. Please contact administration at ".WEBEMAIL." for further details";
                            $this->redirect_back();
                    }
                    if($total_tokens > ($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold ) && !am_i('lib'))
                    {
                         $_SESSION['error']="Sorry, we don't have sufficient tokens. You can only purchase ".($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold)." tokens for now. Please contact administration at ".WEBEMAIL." for further details";
                            $this->redirect_back();
                    }


                   

                    if($total_tokens > ($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold ) && $this->data['active_token']->c_type==2)
                    {

                    
                        $from_first = ($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold);

                        $from_second =$total_tokens - $from_first;

                        if(next_token($this->data['active_token']->tkID))
                        {


                            $next_token = next_token($this->data['active_token']->tkID);
                            if(!empty($next_token)){
                                $price_first = $from_first * $price_should_be;



                                $price_should_be_second=$next_token->tokenPrice;
                                if($next_token->currency_type!="USD")
                                    $price_should_be_second=calculate_price_should_be($next_token);
                                $this->data['price_should_be_second']=$price_should_be_second;

                                if($this->data['web_settings']->charge_round==1){
                                    $second_price = $from_second * $price_should_be_second;
                                }
                                else
                                {
                                    $second_price = $from_second * $price_should_be;
                                }

                                

                                $price_first = $this->add_volitility($price_first,$this->data['option']->volatility);
                                $second_price = $this->add_volitility($second_price,$this->data['option']->volatility);

                                $total_price = $price_first + $second_price;
                                $arr['amount_paid'] = $total_price;
                                $two_payments = true;
                            }
                            else{
                                $_SESSION['error']="Sorry, we don't have sufficient tokens. Please contact administration at ".WEBEMAIL." for further details";
                                $this->redirect_back();
                            }

                            

                        }
                        else{
                            $_SESSION['error']="Sorry, we don't have sufficient tokens. Please contact administration at ".WEBEMAIL." for further details";
                            $this->redirect_back();
                        }

                    }

                   

                    

              






                 
                    // echo $arr['amount_paid']; exit;
                    $this->data['__usd_required']=$arr['amount_paid'];
                     $crypto_required = $arr['amount_paid']*$converting;
                    $_SESSION['crypto_required']=$crypto_required;
                    $this->data['crypto_required']=$crypto_required;
                    $string = json_encode($arr);
                    // $string = "transaction_id: $trans_id \n "
                    foreach($arr_2 as $key=>$val)
                    {
                        $str .= str_replace('_', ' ', strtoupper($key)).': '.$val;
                        if($key!=count($arr)-1)
                            $str.=' | ';
                    }
                    $str_2 = strtolower($this->data['option']->name).":".$address.'?amount='.$this->data['crypto_required'];
                    $qr = QRCode::getMinimumQRCode($str_2, QR_ERROR_CORRECT_LEVEL_L);
                    // ƒCƒ[ƒWì¬(ˆø”:ƒTƒCƒY,ƒ}[ƒWƒ“)
                    // 
                     
                    
                  
                    if($this->data['option']->max_amount && $this->data['option']->max_amount>0 && $arr['amount_paid']>$this->data['option']->max_amount)
                    {
                        $_s_temp =  $this->data['option']->max_amount / $price_should_be;

                        $_s_temp = number_format($_s_temp,decimals_());
                         $_SESSION['error']="You can't purchase more than "  .  $_s_temp . " tokens. Equals ".$this->data['option']->max_amount.' (USD). ';




                        
                        redirect($_SERVER["HTTP_REFERER"]);
                        exit;
                    }
                    if($this->data['option']->min_amount && $this->data['option']->min_amount>0 && $arr['amount_paid']<$this->data['option']->min_amount)
                    {
                        $_s_temp =  $this->data['option']->min_amount / $price_should_be;
                        $_s_temp = number_format($_s_temp,decimals_());
                         $_SESSION['error']="You can't purchase less than "  .  $_s_temp . " tokens. Equals ".$this->data['option']->min_amount.' (USD). ';
                     
                        redirect($_SERVER["HTTP_REFERER"]);
                        exit;
                    }






                    if($this->data['active_token']->min_invest && $this->data['active_token']->min_invest>0 && $arr['amount_paid']<$this->data['active_token']->min_invest)
                    {
                        $_s_temp = $this->data['active_token']->min_invest /  $price_should_be ;
                        $_s_temp = number_format($_s_temp,decimals_());

                        $_SESSION['error']="You can't invest less than $".$this->data['active_token']->min_invest." (USD). Equals ".$_s_temp." tokens";
                       
                        redirect($_SERVER["HTTP_REFERER"]);
                        exit;
                    }
                    if($this->data['active_token']->max_invest && $this->data['active_token']->max_invest>0 && $arr['amount_paid']>$this->data['active_token']->max_invest)
                    {

                         $_s_temp = $this->data['active_token']->max_invest /  $price_should_be ;
                        $_s_temp = number_format($_s_temp,decimals_());

                        $_SESSION['error']="You can't invest more than $".$this->data['active_token']->max_invest." (USD). Equals ".$_s_temp." tokens";
                      
                        
                        redirect($_SERVER["HTTP_REFERER"]);
                        exit;
                    }






















                    $disabled = 0;
                    $option = $this->data['option'];

                    if(!empty(explode(',',$option->allowed_country)) && $option->allowed_country){
                        // echo $option->allowed_country;
                        // echo 1;exit;

                        $ip = $_SERVER['REMOTE_ADDR'];
                        // $ip = "72.229.28.185";
                        // $ip = "110.36.183.128";
                        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));

                        if($query['countryCode'])
                        {
                            $country_id = $this->front_model->get_query_simple('id','dev_web_countries',array('iso'=>$query['countryCode']))->result_object();
                            if(!empty($country_id))
                            {

                                if(in_array($country_id[0]->id,explode(',',$option->allowed_country)))
                                {
                                    $disabled = 3;
                                }
                                else
                                {
                                    $disabled = 0;
                                }
                            }
                            else
                            {
                                $disabled = 2; 
                            }


                        }
                        else
                        {
                            $disabled=1;
                        }
                    }
                    if($disabled!=0)
                    {
                        $_SESSION['error']="Your country isn't allowed to use this payment method. ";
                        redirect($_SERVER['HTTP_REFERER']);
                        exit;
                    }




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
    private function dont_let_same_hash_go()
    {
        $i=$this->db->where('hash',$this->input->post('hash'))->count_all_results('dev_web_transactions');
        if($i>0){
            $_SESSION['error']="Sorry, a tranasction with this hash already exists";
            $this->redirect_back();
            exit;
        }

    }
    private function active_new_camp_new_tok($camp,$token)
    {
        // $this->db->update('dev_web_ico_settings',array('active'=>0));
        // $this->db->where('id',$camp)->update('dev_web_ico_settings',array('active'=>1));

        $this->db->update('dev_web_token_pricing',array('status'=>0));
        $this->db->where('tkID',$token)->update('dev_web_token_pricing',array('status'=>1));
    }
    private function tokens_sold($id,$tokens,$tkid)
    {
        $old = $this->db->where('id',$id)->get('dev_web_ico_settings')->result_object()[0];

        $new  = $old->tokens_sold + $tokens;

        $this->db->where('id',$id)->update('dev_web_ico_settings',array('tokens_sold'=>$new));



        $old = $this->db->where('tkID',$tkid)->get('dev_web_token_pricing')->result_object()[0];

        $new  = $old->tokens_sold + $tokens;

        $this->db->where('tkID',$tkid)->update('dev_web_token_pricing',array('tokens_sold'=>$new));



        return $new;
    }
   
    
    private function add_volitility($amount,$vol)
    {
        $vol = number_format($vol,5)/100;
        $vol = $vol*$amount;
        return $vol+$amount;
    }
    public function get_latest_address($id)
    {
        $option=$this->front_model->get_query_simple('*','dev_web_payment_options',array('id'=>$id))->result_object()[0];

        if($option->one_per_trans==0 || $option->one_per_trans=="0")
            return $option->address;
        $nested = $this->db->where('option_id',$id)->where('used',0)->order_by('id','ASC')->limit(1)->get('dev_web_wallet_addresses')->result_object();
        if(empty($nested))
            return $option->address;

        $timeFirst  = strtotime($nested->on_hold);
        $timeSecond = strtotime(date('Y-m-d H:i:s'));
        $differenceInSeconds = $timeSecond - $timeFirst;

        $twenty_min = ($differenceInSeconds/60);

        if($twenty_min<=30)
            return $option->address;

        $this->db->where('id',$nested[0]->id)->update('dev_web_wallet_addresses',array('on_hold'=>date("Y-m-d H:i:s")));
        return $nested[0]->address;
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
    private function shutdown(){
        redirect($_SERVER['HTTP_REFERER']);
        exit;
    }
    public function new_payment_option()
    {

        // shut down
        $this->shutdown();
        // shut down




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
         check_roles(5);
        $this->load->view('frontend/sponsored_predictions', $this->data);
    }
    public function user_onboarding_compaigns()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(1);
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
                check_roles(1);

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
                check_roles(1);

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
                check_roles(1);

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
                check_roles(1);

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
                check_roles(1);

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
                check_roles(1);

                $arr = array();
                // $config  = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
                // $this->data['countries']     = $config->result_object();
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
                check_roles(1);

                $rendomcode = $this->generateRandomString();
                $data = array(
                    'title'         => $this->input->post('title'),
                    'description'       => $this->input->post('description'),
                    'user_type'         => $this->input->post('type'),
                    'award_tokens'  => $this->input->post('award_tokens')?$this->input->post('award_tokens'):0,
                    'active'        => 0,
                    'created_at'        => date('Y-m-d h:i:s'),
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
                check_roles(1);

                if(isset($_POST['title']))
                {
                    $data = array(
                        'title'         => $this->input->post('title'),
                        'description'       => $this->input->post('description'),
                        'user_type'         => $this->input->post('type'),
                        'award_tokens'  => $this->input->post('award_tokens')?$this->input->post('award_tokens'):0,
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
                check_roles(1);

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
                check_roles(1);

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



                $does_sort = $this->db->where('camp_id',$id)->where('position !=',0)->count_all_results('dev_web_camp_slides');
               
                if($does_sort>0)
                {
                    $order_by ='position';
                }
                else
                {
                    $order_by = 'id';
                }


                $this->data['slides']=$this->db->where('camp_id',$id)->order_by($order_by,'ASC')->get('dev_web_camp_slides')->result_object();
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
                check_roles(1);

                if(isset($_POST['q']))
                {
                    $array = array(
                        'q'=>$this->input->post('q'),
                        'required'=>$this->input->post('q')?1:0,
                        'attachment'=>$this->input->post('attachment')?1:0,
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
                check_roles(1);

                if(isset($_POST['q']))
                {
                    $array = array(
                        'q'=>$this->input->post('q'),
                        'required'=>$this->input->post('q')?1:0,
                        'attachment'=>$this->input->post('attachment')?1:0,
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
                check_roles(1);

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
                check_roles(1);

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
                check_roles(1);

                $arr = array();
                // $config  = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
                // $this->data['countries']     = $config->result_object();
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
                check_roles(1);

                $arr = array();
                // $config  = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
                // $this->data['countries']     = $config->result_object();
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
                check_roles(1);

                $arr = array();
                // $config  = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
                // $this->data['countries']     = $config->result_object();
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
                check_roles(1);

                $rendomcode = $this->generateRandomString();

                $does_sort = $this->db->where('camp_id',$this->input->post('camp_id'))->where('position !=',0)->count_all_results('dev_web_camp_slides');
                $this_sort=0;
                if($does_sort>0)
                {
                    $this_sort = $this->db->where('camp_id',$this->input->post('camp_id'))->order_by('position','DESC')->limit(1)->get('dev_web_camp_slides')->result_object()[0];
                    $this_sort=$this_sort->position+1;
                }

                $array = array(
                    'title'=>$this->input->post('title'),
                    'type'=>$this->input->post('type'),
                    'camp_id'=>$this->input->post('camp_id'),
                    'image'=>$_SESSION['c']['last_img']?$_SESSION['c']['last_img']:'dummy_image.png',
                    'finish_description'=>$this->input->post('description'),
                    'position'=>$this_sort
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
        $valid_formats = array("jpg", "png", "gif", "bmp","jpeg","JPG", "PNG", "GIF", "BMP","JPEG");
        $name = $_FILES['inputfile']['name'];
        $size = $_FILES['inputfile']['size'];
        if(strlen($name)) {
            list($txt, $ext) = explode(".", $name);
            $nw_cond_ext = explode('.',$name)[count(explode('.',$name))-1];
            if(in_array($nw_cond_ext,$valid_formats)) {
                if(1==1) {
                    $actual_image_name = "c_".date("ymdhis").'_camp'.'_'.'.'.$nw_cond_ext;
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
        $valid_formats = array("jpg", "png", "gif", "bmp","jpeg","JPG", "PNG", "GIF", "BMP","JPEG");
        $name = $_FILES['inputfile']['name'];
        $size = $_FILES['inputfile']['size'];
        if(strlen($name)) {
            list($txt, $ext) = explode(".", $name);
            $nw_cond_ext = explode('.',$name)[count(explode('.',$name))-1];
            if(in_array($nw_cond_ext,$valid_formats)) {
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
    public function take_campaign_image()
    {

        $post = isset($_POST) ? $_POST: array();
        $max_width = "500";
        $return = array('status'=>0,'msg'=>"try again");
        $valid_formats = array("jpg", "png", "gif", "bmp","jpeg","doc","DOC","docx","DOCX","pdf","PDF",'rtf','RTF',"JPG", "PNG", "GIF", "BMP","JPEG");


        $files_to = $_FILES['inputfile'];
        $path = 'resources/uploads/campaigns/';

        foreach($files_to['name'] as $key=>$name){
            // $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
            $name = $_FILES['inputfile']['name'];
            $size = $_FILES['inputfile']['size'];


            $files = $_FILES['inputfile'];

            $name = $files['name'][$key]; //get the name of the file
            $size = $files['size'][$key]; //get the size of the file



            if(strlen($name)) {
                list($txt, $ext) = explode(".", $name);
                $nw_cond_ext = explode('.',$name)[count(explode('.',$name))-1];
                if(in_array($nw_cond_ext,$valid_formats)) {
                    if(1==1) {
                        $actual_image_name = "c_".date("ymdhis").'_camp'.'_'.'.'.$nw_cond_ext;
                        $filePath = $path .'/'.$actual_image_name;
                        $tmp = $files['tmp_name'][$key];
                        if(move_uploaded_file($tmp, $filePath)) {
                            $return = array('status'=>1,'msg'=>"<span style='color:green;'>File(s) Uploaded Successfully</span>", 'src'=>base_url().'resources/uploads/campaigns/'.$actual_image_name);
                            $id = $_POST['id'];
                            $_SESSION['attachments_of_camp'][]=$actual_image_name.'|'.$_POST['id'];


                            if($key == count($files_to['name'])-1)
                                eas_creation__();


                            // echo json_encode($return); exit;
                        }
                        else
                          echo "failed";
                    }
                    else
                         echo "File size max 8 MB";
                }
                else
                   echo "Invalid file format...";
            }
            else
                echo "Please select a file..!";
           
        }
    }
    public function submit_campaign()
    {
        $campaign_id  = $this->input->post('campaign_id');
        $campaign = $this->front_model->get_query_simple('*','dev_web_campaigns',array('id'=>$campaign_id))->result_object()[0];
        $slides = $this->front_model->get_query_simple('*','dev_web_camp_slides',array('camp_id'=>$campaign->id))->result_object();
        $qi = 0;
        foreach($slides as $key=>$slide){
            if($slide->type==1){
                $arr = array(       
                    'question_1'=>$slide->question_1,
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

                        $queston_data_for_file = $this->front_model->get_query_simple('*','dev_web_slide_qs',array('id'=>$arr[$var_a]))->result_object()[0];



                       

                        $qi++;
                        $id___=$this->front_model->add_query('dev_web_camp_ans',$array);

                        foreach($_SESSION['attachments_of_camp'] as $key___=>$val___)
                        {
                            $___id = explode('|',$val___)[count(explode('|',$val___))-1];
                            $___file = str_replace('|'.$___id,'',$val___);
                            if($___id==$arr[$var_a]){
                                $this->db->insert('dev_web_camp_ans_files',array('ref_id'=>$id___,'file'=>$___file));
                            }
                        }
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
        if($campaign->award_tokens>0){
            $arr = array(
                'tokens'=>$campaign->award_tokens,
               
                'hash'=>guid(),
                'status'=>2,
                'datecreated'=>date("Y-m-d H:i:s"),
                'uIP'=>$_SERVER['REMOTE_ADDR'],
                'uID'=>UID,
                'transaction_id'=>guid(),
                't_type'=>2
            );
            $this->front_model->add_query('dev_web_transactions',$arr);
        }
        $_SESSION['thankyou'] = "Submitted Successfully!";

        unset($_SESSION['attachments_of_camp']);

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
        $valid_formats = array("jpg", "png", "gif", "bmp","jpeg","JPG", "PNG", "GIF", "BMP","JPEG");
        $name = $_FILES['inputfile']['name'];
        $size = $_FILES['inputfile']['size'];
        if(strlen($name)) {
            list($txt, $ext) = explode(".", $name);
            $nw_cond_ext = explode('.',$name)[count(explode('.',$name))-1];

            if(in_array($nw_cond_ext,$valid_formats)) {
                if(1==1) {
                    $actual_image_name = "c_".date("ymdhis").'_camp'.'_'.'.'.$nw_cond_ext;
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
        $valid_formats = array("jpg", "png", "gif", "bmp","jpeg","JPG", "PNG", "GIF", "BMP","JPEG");
        $name = $_FILES['inputfile']['name'];
        $size = $_FILES['inputfile']['size'];
        if(strlen($name)) {
            list($txt, $ext) = explode(".", $name);
            $nw_cond_ext = explode('.',$name)[count(explode('.',$name))-1];
            if(in_array($nw_cond_ext,$valid_formats)) {
                if(1==1) {
                    $actual_image_name = "c_".date("ymdhis").'_camp'.'_'.'.'.$nw_cond_ext;
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
                check_roles(1);

                if($s==1){
                    $this->front_model->update_query('dev_web_ico_settings',array('active'=>0),array());
                    $this->front_model->update_query('dev_web_ico_settings',array('active'=>1),array('id'=>$v));
                }
                else
                {
                    $this->front_model->update_query('dev_web_ico_settings',array('active'=>0),array('id'=>$v));
                }
                $this->active_inactive_milstones();
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
                 check_roles(3);
                if($s==1){
                    $this->front_model->update_query('dev_web_airdrop_submissions',array('status'=>1),array('id'=>$v));
                    $submission = $this->front_model->get_query_simple('*','dev_web_airdrop_submissions',array('id'=>$v))->result_object()[0];
                    $campaign = $this->front_model->get_query_simple('*','dev_web_airdrop_campaigns',array('id'=>$submission->camp_id))->result_object()[0];
                    // $tokens = $this->front_model->get_query_simple('*','dev_web_user',array('uID'=>UID))->result_object()[0]->tokens;
                    // $this->front_model->update_query('dev_web_user',array('tokens'=>$tokens+$campaign->award_tokens),array('uID'=>UID));
//           print_r($campaign);
                    $arr = array(
                        'tokens'=>($campaign->bounty_qty/$campaign->bounty_persons),
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
                 check_roles(3);
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
                 check_roles(3);
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
                 check_roles(3);
                $this->front_model->delete_query('dev_web_airdrop_submissions',array('id'=>$v));
                $_SESSION['thankyou']="Action performed successfully!";
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function delete_ico_setting()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(1);


                if($this->input->post('delete')==1){
                    $v = $this->input->post('id');
                    $this->front_model->delete_query('dev_web_ico_settings',array('id'=>$v));
                    $this->front_model->delete_query('dev_web_token_pricing',array('ico_camp'=>$v));

                    $_SESSION['thankyou']="Action performed successfully!";
                }
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
                 check_roles(3);
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
                 check_roles(3);
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
                check_roles(1);
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
                check_roles(1);

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
                        'end_on_end_date'=>$this->input->post('end_on_end_date')?$this->input->post('end_on_end_date'):0,
                        'end_on_end_token'=>$this->input->post('end_on_end_token')?$this->input->post('end_on_end_token'):0,
                        'active'=>0,
            'multiple'=>$this->input->post('multiple')==1?1:0,

                        'timezone'          => $this->data['web_settings']->timezone,
                        'start_time' => $this->input->post('start_time')?$this->input->post('start_time'):'00:00:00',
                        'end_time'  => $this->input->post('end_time')?$this->input->post('end_time'):'23:55:00',
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
                check_roles(1);

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
                        'end_on_end_date'=>$this->input->post('end_on_end_date')?$this->input->post('end_on_end_date'):0,
                        'end_on_end_token'=>$this->input->post('end_on_end_token')?$this->input->post('end_on_end_token'):0,
                       
                        'start_time' => $this->input->post('start_time')?$this->input->post('start_time'):'00:00:00',
                        'end_time'  => $this->input->post('end_time')?$this->input->post('end_time'):'23:55:00',
            'multiple'=>$this->input->post('multiple')==1?1:0,

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
                 check_roles(3);
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
                 check_roles(3);
                $this->load->view('frontend/airdrop_submissions', $this->data);
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function airdrop_submissions_user()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "2"){
                $this->load->view('frontend/airdrop_submissions_user', $this->data);
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
                 check_roles(3);
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
                        'created_at'=>date("Y-m-d H:i:s"),
                        'active'=>0
                    );
                    foreach($this->input->post('custom') as $key=>$custom)
                    {
                        $arr_[] = array('q'=>$custom,'r'=>$this->input->post('required')[$key]==1?1:0);
                    }
                    $arr['costum_form']=json_encode($arr_);
                    // if(isset($_SESSION['c']['last_img_settings']))
                    // {
                    //  $arr['image']=$_SESSION['c']['last_img_settings'];
                    //  unset($_SESSION['c']['last_img_settings']);
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
                 check_roles(3);
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
                    //  $arr['image']=$_SESSION['c']['last_img_settings'];
                    //  unset($_SESSION['c']['last_img_settings']);
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
        $valid_formats = array("jpg", "png", "gif", "bmp","jpeg","JPG", "PNG", "GIF", "BMP","JPEG");
        $name = $_FILES['inputfile']['name'];
        $size = $_FILES['inputfile']['size'];
        if(strlen($name)) {
            list($txt, $ext) = explode(".", $name);
            $nw_cond_ext = explode('.',$name)[count(explode('.',$name))-1];
            if(in_array($nw_cond_ext,$valid_formats)) {
                if(1==1) {
                    $actual_image_name = "c_".date("ymdhis").'_camp'.'_'.'.'.$nw_cond_ext;
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
        $valid_formats = array("jpg","JPG","jpeg","png","PNG", "gif","GIF", "bmp","BMP","pdf","PDF","doc","DOC","DOCX","docx", "JPEG");
        $name = $_FILES['inputfile']['name'];
        $size = $_FILES['inputfile']['size'];
        if(strlen($name)) {
            list($txt, $ext) = explode(".", $name);
            $nw_cond_ext = explode('.',$name)[count(explode('.',$name))-1];
            if(in_array($nw_cond_ext,$valid_formats)) {
                if(1==1) {
                    $actual_image_name = "c_".date("ymdhis").'_camp'.'_'.'.'.$nw_cond_ext;
                    $filePath = $path .'/'.$actual_image_name;
                    $tmp = $_FILES['inputfile']['tmp_name'];
                    if(move_uploaded_file($tmp, $filePath)) {
                        $return = array('status'=>1,'msg'=>"", 'src'=>base_url().'resources/uploads/airdrops/'.$actual_image_name,'type'=>1);
                        $_SESSION['c']['last_proof_file']=$actual_image_name;
                        if(in_array($nw_cond_ext, array("pdf","PDF","doc","DOC","DOCX","docx")))
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
                 check_roles(3);
                $this->data['submission']=$this->front_model->get_query_simple('*','dev_web_airdrop_submissions',array('id'=>$id))->result_object()[0];
                $this->load->view('frontend/view_airdrop_submission', $this->data);
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function view_airdrop_submission_user($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "2"){
                $this->data['submission']=$this->front_model->get_query_simple('*','dev_web_airdrop_submissions',array('id'=>$id))->result_object()[0];
                $this->load->view('frontend/view_airdrop_submission_user', $this->data);
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
                 check_roles(2);
                if(isset($_POST['configAddress']))
                {
                    $arr = array(
                        'configWeb'=>$this->input->post('configWeb'),
                        'configTitle'=>$this->input->post('configTitle'),
                        'configURL'=>$this->input->post('configURL'),
                        'configPhone'=>$this->input->post('configPhone')?$this->input->post('configPhone'):123,
                        'configEmail'=>$this->input->post('configEmail'),
                        'configAddress'=>$this->input->post('configAddress'),
                        'configCopy'=>$this->input->post('configCopy'),
                        'configFacebook'=>$this->input->post('configFacebook'),
                        'webGoogle'=>$this->input->post('webGoogle'),
                        'webYouTube'=>$this->input->post('webYouTube'),
                        'instagram'=>$this->input->post('instagram'),
                        'tumbler'=>$this->input->post('tumbler'),
                        'timezone'=>$this->input->post('timezone'),
                        'subdomain'=>$this->input->post('subdomain'),
                        'decimals'=>$this->input->post('decimals'),




                        'telegram'=>$this->input->post('telegram'),
                        'bitcointalk'=>$this->input->post('bitcointalk'),
                        'reddit'=>$this->input->post('reddit'),
                        'steemit'=>$this->input->post('steemit'),
                        'github'=>$this->input->post('github'),
                        'webLkndIn'=>$this->input->post('webLkndIn'),

                        'configTwitter'=>$this->input->post('configTwitter'),
                        'color'=>$this->input->post('color'),
                        'google_analytics'=>$this->input->post('google_analytics'),
                        'logo_bg'=>$this->input->post('logo_bg'),
                        'sign_bg'=>$this->input->post('sign_bg'),
                        'page_bg'=>$this->input->post('page_bg'),
                    );
                    if(isset($_SESSION['c']['logo']))
                    {
                        $arr['logo']=$_SESSION['c']['logo'];
                        unset($_SESSION['c']['logo']);
                    }
                    if(am_i('hydro'))
                        $arr['discord']=$this->input->post('discord');
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
            header ( "Location:" . $this->config->base_url ());
        }
        else {
            if(ACTYPE == "1"){
                 check_roles(2);
                  $this->data['options']=$this->front_model->get_query_simple('*','dev_web_kyc_apis',array())->result_object();
                if(isset($_POST['require_at']))
                {
                    $arr = array('require_at'=>$this->input->post('require_at')?$this->input->post('require_at'):2,
                        'require_at_crypto'=>$this->input->post('require_at_crypto')?$this->input->post('require_at_crypto'):2,
                        'require_at_fiat'=>$this->input->post('require_at_fiat')?$this->input->post('require_at_fiat'):1,
                );
                    $this->front_model->update_query('dev_web_kyc_aml',$arr,array('id'=>1));
                    $_SESSION['thankyou']="Settings updated successfully!";
                    redirect($_SERVER['HTTP_REFERER']);
                    exit;
                }

                if(isset($_POST['url']))
                {
                    $this->db->update('dev_web_kyc_apis',array('active'=>0));

                    $array = array(
                        'url'=>$this->input->post('url'),
                        'active'=>1,
                        'public_key'=>$this->input->post('public_key'),
                        'private_key'=>$this->input->post('private_key'),
                        'form_id'=>$this->input->post('form_id'),
                       
                    );
                    
                    $condition = array("id" => $this->input->post('option_id'));

                    
                        $this->front_model->update_query('dev_web_kyc_apis',$array,$condition);
                        $_SESSION['thankyou'] = "Information updated successfully!";
                  
                    
                    $this->redirect_back();
                }
                

                $this->load->view('frontend/kyc_aml', $this->data);
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
	public function gdpr_settings()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ());
        }
        else {
            if(ACTYPE == "1"){
                 check_roles(2);
                $this->load->view('frontend/gdpr_settings', $this->data);
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
                 check_roles(3);
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
                        'image'=>isset($_SESSION['c']['last_cat_img'])?$_SESSION['c']['last_cat_img']:'dummy_image.png'
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
                 check_roles(3);
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
        //return true;
        #
        # Verify captcha
        $post_data = http_build_query(
            array(

                'secret' => CAPTCHA_SECRET,
                //'response' => $_POST['g-recaptcha-response'],
                'response' => $_POST['g-recaptcha-response']?$_POST['g-recaptcha-response']:$_POST['captcha'],
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
                 check_roles(2);
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
//              if(isset($_POST['submit']))
//                {
//                    $arr = array(
//                        'passport'=>$this->input->post('passport')==1?1:0,
//                        'user_holding_passport_image'=>$this->input->post('user_holding_passport_image')==1?1:0,
//                        'utility_bill'=>$this->input->post('utility_bill')==1?1:0,
//                        'bank_statement'=>$this->input->post('bank_statement')==1?1:0,
//                        'last_four_digits_of_ssn'=>$this->input->post('last_four_digits_of_ssn')==1?1:0,
//                        'birthday'=>$this->input->post('birthday')==1?1:0,
//                        'employer'=>$this->input->post('employer')==1?1:0
//                    );
//
//
//                    $this->front_model->update_query('dev_web_kyc_aml',$arr,array('id'=>1));
//                }
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
                 check_roles(5);
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
        // $this->load->library('email');
        // $this->email->from($edata[0]->eEmail, TITLEWEB);
        // $this->email->to('bjosic@gmail.com');
        $replace = array("[WEBURL]","[CODE]","[NAME]","[WEBTITLE]","[USEREMAIL]","[COMPANY]","[WEBSITE]");
        $replacewith = array(WEBURL, $rendomcode, $this->input->post('namesender'),TITLEWEB,$this->input->post('emailsend'),$this->input->post('companysend'),$this->input->post('urlsend'));
        $str = str_replace($replace,$replacewith,$edata[0]->eContent);
        $message = $str;
        $this->sendgrid_mail(array('bjosic@gmail.com',''),$message,$edata[0]->eName);
        // $this->email->subject($edata[0]->eName);
        // $this->email->message($message);
        // $this->email->set_mailtype("html");
        // $send = $this->email->send();
        // SEND TO USER
        // $config = Array(
        //  'protocol' => 'smtp',
        //  'smtp_host' => 'ssl://smtp.googlemail.com',
        //  'smtp_port' => 465,
        //  'smtp_user' => 'cloudingedge@gmail.com',
        //  'smtp_pass' => 'kooldude@143',
        //  'mailtype'  => 'html',
        //  'charset'   => 'iso-8859-1'
        // );
        // $this->load->library('email', $config);
        // $this->email->set_newline("\r\n");
        $edata = $this->front_model->get_emails_data('access-password-ico-user');
        // $this->load->library('email');
        // $this->email->from($edata[0]->eEmail, TITLEWEB);
        // $this->email->to($this->input->post('emailsend'));
        $replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]","[URL]");
        $replacewith = array(WEBURL, $rendomcode, $this->input->post('namesender'),TITLEWEB,WEBURL);
        $str = str_replace($replace,$replacewith,$edata[0]->eContent);
        $message = $str;
        // $this->email->subject($edata[0]->eName);
        // $this->email->message($message);
        // $this->email->set_mailtype("html");
        // $send = $this->email->send();
        //$r = $this->sendgrid_mail(array($this->input->post('emailsend'),$this->input->post('namesender')),$message,$edata[0]->eName);
        // print_r($r);exit;
        $_SESSION['thankyou'] = "Your request has been received successfully!, you'll be contacted shortly.";
        header ( "Location:".$_SERVER['HTTP_REFERER']);
    }
    public function sendgrid_mail($to,$content,$subject,$from =WEBEMAIL,$att="no")
    {
        
        // You need to install the sendgrid client library so run: composer require sendgrid/sendgrid
        require  APPPATH.'../vendor/autoload.php';
        // contains a variable called: $API_KEY that is the API Key.
        // You need this API_KEY created on the Sendgrid website.
        // include_once('./credentials.php');
        $FROM_EMAIL = $from;
        // they dont like when it comes from @gmail, prefers business emails
        // Try to be nice. Take a look at the anti spam laws. In most cases, you must
        // have an unsubscribe. You also cannot be misleading.
        $from = new SendGrid\Email(TITLEWEB, $FROM_EMAIL);
        $to = new SendGrid\Email($to[1], $to[0]);
        $htmlContent = $content;
        // Create Sendgrid content
        $content = new SendGrid\Content("text/html",$htmlContent);
        // Create a mail object
        $mail = new SendGrid\Mail($from, $subject, $to, $content);






        if($att!="no"){
            $filename = basename($att);
            $file_encoded = base64_encode(file_get_contents($att));
            $attachment = new SendGrid\Attachment();
            $attachment->setContent( $file_encoded );
            $attachment->setType("application/pdf");
            $attachment->setDisposition("attachment");
            $attachment->setFilename($filename);
            $mail->addAttachment($attachment);
        }

        //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

        $key = "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";
       
        $sg = new \SendGrid($key);
        $response = $sg->client->mail()->send()->post($mail);
         
         if ($response->statusCode() == 202) {
            // Successfully sent
           
            return true;
        } else {
            return false;
        }
    }
    public function enable_terms()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                // $this->front_model->update_query('dev_web_campaigns',array('active'=>0),array());
                $this->front_model->update_query('dev_web_terms',array('active'=>1),array('id'=>1));
                $_SESSION['thankyou'] = "Terms & conditions are now active!";
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function disable_terms()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                // $this->front_model->update_query('dev_web_campaigns',array('active'=>0),array());
                $this->front_model->update_query('dev_web_terms',array('active'=>0),array('id'=>1));
                $_SESSION['thankyou'] = "Terms & conditions are now in-active!";
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function edit_terms()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                if(isset($_POST['terms_text']))
                {
                    $arr = array(
                        'text'=>$this->input->post('terms_text'),
                        'c_statements'=>json_encode($this->input->post('statement'))
                    );
                    $payment_option = $this->front_model->update_query('dev_web_terms',$arr,array('id'=>1));
                    $_SESSION['thankyou']="Terms updated successfully!";
                    redirect($_SERVER['HTTP_REFERER']);
                }
                else
                {
                    $this->data['terms']=$this->front_model->get_query_simple('*','dev_web_terms',array('id'=>1))->result_object()[0];
                    $this->load->view('frontend/admin_terms', $this->data);
                }
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function get_terms_div()
    {
        echo get_terms_div();
    }
    public function remove_user(){
        $condition = array('uID' => $this->uri->segment(3));
        $this->front_model->delete_query('dev_web_user',$condition);
        // REMOVE BOUNTIES
        /*          $condition = array('uID' => $this->uri->segment(3));
            $this->front_model->delete_query('dev_web_bounties',$condition);
            // REMOVE BOUNTY INFORMATION
            $condition = array('uID' => $this->uri->segment(3));
            $this->front_model->delete_query('dev_web_bounty_information',$condition);
            // REMOVE SUBMISSIONS INFORMATION
            $condition = array('uID' => $this->uri->segment(3));
            $this->front_model->delete_query('dev_web_submissions',$condition);*/
        $_SESSION['thankyou'] = "User & all its data removed successfully!";
        header ( "Location:" . $this->config->base_url ()."admin/user/reports");
    }
    public function account_status($v,$s)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "1") {
                $data = array('account_status' => $v==1?1:0);
                $condition = array('uID' => $s);
                $this->front_model->update_query('dev_web_user', $data, $condition);
                $_SESSION['thankyou'] = "Status information updated successfully!";
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function account_status_verification($v,$s)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "1") {
                $uID = $v;
                $v_id = $s;


                if($s!=-1)
                $this->db->where('id',$v_id)->update('dev_web_user_verification',array('uStatus'=>1));
                $this->db->where('uID',$uID)->update('dev_web_user',array('uStatus'=>1,'kyc_verified'=>1));

                $_SESSION['thankyou'] = "Status information updated successfully!";
                redirect(base_url().'admin/user/reports');
            }
        }
    }
    public function query()
    {
        error_reporting(-1);
        $this->db->query('ALTER TABLE `dev_web_user` ADD `account_status` INT(1) NOT NULL DEFAULT \'0\' AFTER `del`;');
    }
    public function user_details($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "1") {
                $this->data['user_details'] = $this->front_model->get_query_simple('*','dev_web_user',array('uID'=>$id))->result_object()[0];
                $this->load->view('frontend/user_details',$this->data);
            }
        }
    }
    public function enable_uf_email()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "1") {
                 check_roles(2);
                $this->front_model->update_query('dev_web_kyc_aml',array('force_verification'=>1),array('id'=>1));
                $_SESSION['thankyou'] = "Information updated successfully!";
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function disable_uf_email()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "1") {
                 check_roles(2);
                $this->front_model->update_query('dev_web_kyc_aml',array('force_verification'=>0),array('id'=>1));
                $_SESSION['thankyou'] = "Information updated successfully!";
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function enable_captcha()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "1") {
                $this->front_model->update_query('dev_web_config',array('captcha'=>1),array('cID'=>1));
                $_SESSION['thankyou'] = "Information updated successfully!";
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function disable_captcha()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "1") {
                $this->front_model->update_query('dev_web_config',array('captcha'=>0),array('cID'=>1));
                $_SESSION['thankyou'] = "Information updated successfully!";
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function enable_uf_kyc()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "1") {
                 check_roles(2);
                $this->front_model->update_query('dev_web_kyc_aml',array('kyc_verification'=>1),array('id'=>1));
                $_SESSION['thankyou'] = "Information updated successfully!";
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function disable_uf_kyc()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "1") {
                 check_roles(2);
                $this->front_model->update_query('dev_web_kyc_aml',array('kyc_verification'=>0),array('id'=>1));
                $_SESSION['thankyou'] = "Information updated successfully!";
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function enable_cb()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ());
        }
        else {
            if (ACTYPE == "1") {
                 check_roles(2);
                $this->front_model->update_query('dev_web_kyc_aml',array('ban_country'=>1),array('id'=>1));
                $_SESSION['thankyou'] = "Information updated successfully!";
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function disable_cb()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ());
        }
        else {
            if (ACTYPE == "1") {
                 check_roles(2);
                $this->front_model->update_query('dev_web_kyc_aml',array('ban_country'=>0),array('id'=>1));
                $_SESSION['thankyou'] = "Information updated successfully!";
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    }
	 public function enable_cookie()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ());
        }
        else {
            if (ACTYPE == "1") {
                 check_roles(2);

                $this->front_model->update_query('dev_web_kyc_aml',array('gdpr_cookies'=>1),array('id'=>1));
                $_SESSION['thankyou'] = "Information updated successfully!";
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function disable_cookie()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ());
        }
        else {
            if (ACTYPE == "1") {
                 check_roles(2);

                $this->front_model->update_query('dev_web_kyc_aml',array('gdpr_cookies'=>0),array('id'=>1));
                $_SESSION['thankyou'] = "Information updated successfully!";
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function banned_countries()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                 check_roles(2);
                if(isset($_POST['submit']))
                {
                    $arr = array(
                        'cID'=>$this->input->post('country')?$this->input->post('country'):0,
                        'type'=>$this->input->post('type'),
                        'ip'=>$this->input->post('ip'),

                    );
                    $this->front_model->add_query('dev_web_banned_countries',$arr);
                    $_SESSION['thankyou']="New Country added to banned list successfully!";
                    redirect(base_url().'admin/banned-countries');
                }
                else
                {
                    $this->data['banned_countries']=$this->front_model->get_query_simple('*','dev_web_banned_countries',array())->result_object();
                    $this->load->view('frontend/banned_countries', $this->data);
                }
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function remove_banned_country($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "1") {
                 check_roles(2);
                $this->front_model->delete_query('dev_web_banned_countries',array('id'=>$id));
                $_SESSION['thankyou'] = "Country removed successfully!";
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    }
    
    public function check_if_verified()
    {
        $force_verification = $this->front_model->get_query_simple('*','dev_web_kyc_aml',array('id'=>1))->result_object()[0];
        if($force_verification->force_verification==1)
        {
            if(VEMAIL!=1 && $this->uri->segment(3)!='account')
            {
                $this->load->view('frontend/verify_email',$this->data);
                exit;
            }
        }
    }
    public function only_check_if_verified()
    {
        $force_verification = $this->front_model->get_query_simple('*','dev_web_kyc_aml',array('id'=>1))->result_object()[0];
        if($force_verification->force_verification==1)
        {
            if(VEMAIL!=1)
            {
                return false;
            }

        }

        return true;
    }
    public function resend_vf()
    {
        $rand = $this->generateRandomString();
        $this->front_model->update_query('dev_web_user',array('uCode'=>$rand),array('uID'=>UID));
        $this->send_verification(UID,$rand);
        $_SESSION['thankyou']="Email sent!";
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function paid_content_placement_()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "2" || ACTYPE == "3") {
                if(isset($_POST['post'])) {
                    $_SESSION['place']['step1']=$_POST;
                    redirect(base_url().'paid-content-placement/step-2');
                }
                else
                {
                    $this->data['publications']=$this->front_model->get_query_simple('*','dev_web_publications',array('status'=>1))->result_object();
                    $this->load->view('frontend/paid_content_placement',$this->data);
                }
            }
        }
    }
    public function upload_paid_creation_file(){
        //error_reporting(0);
        $path = "resources/uploads/marketing/"; //set your folder path
        //set the valid file extensions
        $valid_formats = array("jpg", "jpeg", "png", "JPG", "JPEG", "PNG",'doc','DOCX','docx','DOC','pdf','PDF','rtf','RTF'); //add the formats you want to upload
        $name = $_FILES['inputfile']['name']; //get the name of the file
        $size = $_FILES['inputfile']['size']; //get the size of the file
        if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
            //list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
            $ext =  pathinfo($path.$name, PATHINFO_EXTENSION);
            $nw_cond_ext = explode('.',$name)[count(explode('.',$name))-1];
            if (in_array($nw_cond_ext, $valid_formats)) { //if the file is valid go on.
                if ($size < 8388608) { // check if the file size is more than 2 mb
                    $file_name = date("ymdhis")."_".str_replace(" ","_",$name); //get the file name
                    $tmp = $_FILES['inputfile']['tmp_name'];
                    if(move_uploaded_file($tmp, $path . $file_name)) {
                      $_SESSION['CreationContentFile'] = $file_name;
                        if(in_array(explode('.',$file_name)[count(explode('.',$file_name))-1],array('pdf','PDF')))
                            $img_to_return = base_url().'resources/frontend/images/'."pdf_small.png";
                        else if(in_array(explode('.',$file_name)[count(explode('.',$file_name))-1],array('doc','DOCX','docx','DOC','rtf','RTF')))
                            $img_to_return = base_url().'resources/frontend/images/'."doc_small.png";
                        else
                            $img_to_return = base_url().'resources/uploads/marketing/'.$file_name;
                        $return = array('status'=>1,'msg'=>"", 'src'=>$img_to_return);
                        echo json_encode($return);exit;
                        //check if it the file move successfully.
//                        unset($_SESSION['CreationBountyFile']);
//                        eas_creation__();
                    } else {
                        echo "failed";
                    }
                } else {
                    echo "File size max 8 MB";
                }
            } else {
                echo "Invalid file format...";
            }
        } else {
            echo "Please select a file..!";
        }
        exit;
    }
    public function paid_content_placement_step_2()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "2" || ACTYPE == "3") {
                if(isset($_POST['post'])) {
                    $arr = array(
                        'subject'=>$this->input->post('subject'),
                        'content'=>$this->input->post('content'),
                        'keywords'=>$this->input->post('keywords'),
                        'time'=>date("Y-m-d H:i:s"),
                        'ip'=>$_SERVER['REMOTE_ADDR'],
                        'publications'=>implode(',',$_SESSION['place']['step1']['publication']),
                        'uID'=>UID
                    );
                    if(isset($_SESSION['CreationContentFile']))
                    {
                        $arr['file']= $_SESSION['CreationContentFile'];
                        unset($_SESSION['CreationContentFile']);
                    }
                    $id = $this->front_model->add_query('dev_web_paid_content',$arr);
                    $my_balane = $this->front_model->get_query_simple('*','dev_web_user',array('uID'=>UID))->result_object()[0]->balance;
                    // price
                    $price = 0;
                    foreach($_SESSION['place']['step1']['publication'] as $pub){
                        $price_ = $this->front_model->get_query_simple('*','dev_web_publications',array('id'=>$pub))->result_object()[0]->price;
                        $price +=$price_;
                    }
                    if($my_balane >= $price)
                    {
                        $this->front_model->update_query('dev_web_user',array('balance'=>$my_balane-$price),array('uID'=>UID));
                        $this->front_model->update_query('dev_web_paid_content',array('status'=>1),array('id'=>$id));
                        $_SESSION['thankyou']="Your content has been received successfully, we'll publish it as soon as we can.";
                        $arr = array(
                            'tokens'=>0,
                            'currency'=>0,
                            'amountPaid'=>$price,
                            'amtType'=>'USD',
                            'usdPayment'=>$price,
                            'hash'=>guid(),
                            'status'=>2,
                            'datecreated'=>date("Y-m-d H:i:s"),
                            'uIP'=>$_SERVER['REMOTE_ADDR'],
                            'uID'=>UID,
                            'transaction_id'=>guid()
                        );
                        $this->front_model->add_query('dev_web_transactions',$arr);
                        redirect(base_url().'my-paid-contents');
                    }
                    else
                    {
                        $_SESSION['error']="Please deposit money to publish your draft.";
                        redirect(base_url().'dashboard');
                        exit;
                    }
//                    redirect(base_url().'paid-content-placement/step-3');
                }
                else
                {
//                    $this->data['publications']=$this->front_model->get_query_simple('*','dev_web_publications',array('status'=>1))->result_object();
                    $this->load->view('frontend/paid_content_placement_step_2',$this->data);
                }
            }
        }
    }
    public function my_paid_contents()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "2" || ACTYPE == "3") {
                $this->data['paid_contents']=$this->front_model->get_query_simple('*','dev_web_paid_content',array('uID'=>UID))->result_object();
                $this->load->view('frontend/my_placements',$this->data);
            }
        }
    }
    public function update_paid_content_status($id)
    {
        if (!isset($_SESSION['JobsSessions'])) {
            header("Location:" . $this->config->base_url() . "login");
        } else {
            if (ACTYPE == "1") {
                $this->front_model->update_query('dev_web_paid_content', array('status' => 2), array('id' => $id));
                $_SESSION['thankyou'] = "Done!";
                redirect($_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    }
    public function update_paid_content_payment($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "2" || ACTYPE == "3") {
                $my_balane = $this->front_model->get_query_simple('*','dev_web_user',array('uID'=>UID))->result_object()[0]->balance;
                $paid_content = $this->front_model->get_query_simple('*','dev_web_paid_content',array('id'=>$id))->result_object()[0];
                // price
                $price = 0;
                foreach(explode(',',$paid_content->publications) as $pub){
                    $price_ = $this->front_model->get_query_simple('*','dev_web_publications',array('id'=>$pub))->result_object()[0]->price;
                    $price +=$price_;
                }
                if($my_balane >= $price)
                {
                    $this->front_model->update_query('dev_web_user',array('balance'=>$my_balane-$price),array('uID'=>UID));
                    $this->front_model->update_query('dev_web_paid_content',array('status'=>1),array('id'=>$id));
                    $_SESSION['thankyou']="Your content has been received successfully, we'll publish it as soon as we can.";
                    $arr = array(
                        'tokens'=>0,
                        'currency'=>0,
                        'amountPaid'=>$price,
                        'amtType'=>'USD',
                        'usdPayment'=>$price,
                        'hash'=>guid(),
                        'status'=>2,
                        'datecreated'=>date("Y-m-d H:i:s"),
                        'uIP'=>$_SERVER['REMOTE_ADDR'],
                        'uID'=>UID,
                        'transaction_id'=>guid()
                    );
                    $this->front_model->add_query('dev_web_transactions',$arr);
                    redirect(base_url().'my-paid-contents');
                }
                else
                {
                    $_SESSION['error']="Please deposit money to publish your draft.";
                    redirect(base_url().'dashboard');
                    exit;
                }
            }
        }
    }
    public function paid_content_placement_admin()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "1") {


                 $this->data['publications']=$this->front_model->get_query_simple('*','dev_web_publications',array('status'=>1))->result_object();
                $this->load->view('frontend/paid_content_placement',$this->data);
            }
        }
    }
    public function view_paid_content($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (1== 1) {
                $this->data['paid_content']=$this->front_model->get_query_simple('*','dev_web_paid_content',array('id'=>$id))->result_object()[0];
                $this->load->view('frontend/view_paid_content',$this->data);
            }
        }
    }
    public function _manage_content_promotions()
      {
            if(!isset($_SESSION['JobsSessions'])){
              header ( "Location:" . $this->config->base_url ()."login");
          }
          else {
              if(ACTYPE==1)
              {
                  $this->data['contents']=$this->front_model->get_query_simple('*','dev_web_publications',array())->result_object();
                  $this->load->view('frontend/manage_content_promotions',$this->data);
              }
          }
      } 
	public function add_kyc_aml()
      {
            if(!isset($_SESSION['JobsSessions'])){
              header ( "Location:" . $this->config->base_url ());
          }
          else {
              if(ACTYPE==1)
              {
                 check_roles(2);
                  $this->load->view('frontend/add_kyc_aml',$this->data);
              }
          }
      }
      public function delete_publication($id)
      {
            if(!isset($_SESSION['JobsSessions'])){
              header ( "Location:" . $this->config->base_url ()."login");
          }
          else {
              if(ACTYPE==1)
              {
                  $this->front_model->delete_query('dev_web_publications',array('id'=>$id));
                  $_SESSION['thankyou']="Delete successfully!";
                  redirect($_SERVER['HTTP_REFERER']);
              }
          }
      }
      public function update_publication_status($val,$id){
          $data = array(
              'status'    =>0,
          );
          $condition = array('uID'=>UID);
          //$this->front_model->update_query('dev_web_withdraw_methods',$data,$condition);
          $data = array(
              'status'    => $val,
          );
          $condition = array('id' => $id);
          $this->front_model->update_query('dev_web_publications',$data,$condition);
          $_SESSION['thankyou'] = "Status Information Updated Successfully!";
          redirect($_SERVER['HTTP_REFERER']);
      }
      public function add_publication()
      {
            if(!isset($_SESSION['JobsSessions'])){
              header ( "Location:" . $this->config->base_url ()."login");
          }
          else {
              if(ACTYPE==1)
              {
                  if(isset($_POST['price']))
                  {
                      //last_logo_marketing_img
                      $arr = array(
                          'price'=>$this->input->post('price'),
                          'link'=>$this->input->post('link'),
                      );
                      if(isset($_SESSION['c']['last_logo_marketing_img']))
                      {
                          $arr['logo']=$_SESSION['c']['last_logo_marketing_img'];
                          unset($_SESSION['c']['last_logo_marketing_img']);
                      }
                      $this->front_model->add_query('dev_web_publications',$arr);
                      $_SESSION['thankyou']="SUCCESS!";
                      redirect(base_url().'admin/manage-content-promotions');
                  }
                  else
                  {
                      $this->load->view('frontend/add_publication',$this->data);
                  }
              }
          }
      }
      public function edit_publication($id)
      {
            if(!isset($_SESSION['JobsSessions'])){
              header ( "Location:" . $this->config->base_url ()."login");
          }
          else {
              if(ACTYPE==1)
              {
                  $this->data['content']=$this->front_model->get_query_simple('*','dev_web_publications',array('id'=>$id))->result_object()[0];
                  if(isset($_POST['price']))
                  {
                      //last_logo_marketing_img
                      $arr = array(
                          'price'=>$this->input->post('price'),
                          'link'=>$this->input->post('link'),
                      );
                      if(isset($_SESSION['c']['last_logo_marketing_img']))
                      {
                          $arr['logo']=$_SESSION['c']['last_logo_marketing_img'];
                          unset($_SESSION['c']['last_logo_marketing_img']);
                      }
                      $this->front_model->update_query('dev_web_publications',$arr,array('id'=>$id));
                      $_SESSION['thankyou']="SUCCESS!";
                      redirect(base_url().'admin/manage-content-promotions');
                  }
                  else
                  {
                      $this->load->view('frontend/edit_publication',$this->data);
                  }
              }
          }
      }
      public function take_publication_image()
      {
          $post = isset($_POST) ? $_POST: array();
          $max_width = "500";
          $return = array('status'=>0,'msg'=>"try again");
          // $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
          $path = 'resources/uploads/marketing/';
          $valid_formats = array("jpg", "png", "gif", "bmp","jpeg","JPG", "PNG", "GIF", "BMP","JPEG");
          $name = $_FILES['inputfile']['name'];
          $size = $_FILES['inputfile']['size'];
          if(strlen($name)) {
              list($txt, $ext) = explode(".", $name);
              $nw_cond_ext = explode('.',$name)[count(explode('.',$name))-1];
              if(in_array($nw_cond_ext,$valid_formats)) {
                  if(1==1) {
                      $actual_image_name = "c_".date("ymdhis").'_camp'.'_'.'.'.$nw_cond_ext;
                      $filePath = $path .'/'.$actual_image_name;
                      $tmp = $_FILES['inputfile']['tmp_name'];
                      if(move_uploaded_file($tmp, $filePath)) {
                          $return = array('status'=>1,'msg'=>"", 'src'=>base_url().'resources/uploads/marketing/'.$actual_image_name);
                          $_SESSION['c']['last_logo_marketing_img']=$actual_image_name;
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
      public function reject_paid_content($id)
      {
          if(!isset($_SESSION['JobsSessions'])){
              header ( "Location:" . $this->config->base_url ()."login");
          }
          else {
              if(ACTYPE==1)
              {
                  $content = $this->front_model->get_query_simple('*','dev_web_paid_content',array('id'=>$id))->result_object()[0];
                   if(!empty(explode(',',$row->publications))){
                              $all_amounts = $this->db->where_in('id',explode(',',$row->publications))->where('status',1)->get('dev_web_publications')->result_object();
                              if(!empty($all_amounts)){
                              foreach($all_amounts as $one_amount)
                                  $total_amount += $one_amount->price;
                          }
                          else
                          {
                              $total_amount = 0;
                          }
                  $this->add_balance($content->uID,$total_amount);
                  $this->front_model->update_query('dev_web_paid_content',array('status'=>3),array('id'=>$id));
                  $_SESSION['thankyou']="Rejected and refunded Successfully!";
              }
               redirect($_SERVER['HTTP_REFERER']);
          }
          }
      }
      private function add_balance($uid,$balance)
      {
        $old_balance = $this->db->where('uID',$uid)->get('dev_web_user')->result_object()[0];
        $old_balance = $old_balance->tokens;

        $new_balance = $old_balance + $balance;

        $this->db->where('uID',$uid)->update('dev_web_user',array('tokens'=>$new_balance));
        return true;
      }
      private function sub_balance($uid,$balance)
      {
        $old_balance = $this->db->where('uID',$uid)->get('dev_web_user')->result_object()[0];
        $old_balance = $old_balance->tokens;

        $new_balance = $old_balance - $balance;

        $this->db->where('uID',$uid)->update('dev_web_user',array('tokens'=>$new_balance));
        return true;
      }
      public function download_paid_content($id,$type="admin")
      {
          if(!isset($_SESSION['JobsSessions'])){
              header ( "Location:" . $this->config->base_url ()."login");
          }
          else {
              if(1==1)
              {
                  if($type=="admin")
                  {
                      $arr = array('id'=>$id);
                  }
                  else
                  {
                      $arr = array('id'=>$id,'uID'=>UID);
                  }
                  $content = $this->front_model->get_query_simple('*','dev_web_paid_content',$arr)->result_object()[0];
                  $txt = "Subject: ".$content->subject."\n";
                  $txt .= "Keywords: ".$content->keywords."\n";
                  $txt .= "Content: ".$content->content."\n";
                  $this->load->helper('download');
                  force_download($content->subject.'_'.date("d-m-y H:i:s").'.doc',$txt);
              }
          }
      }
      public function ico_directory()
      {
         check_roles(5);
        $this->load->view('frontend/ico_directory_page',$this->data);
      }

    public function paid_content_placement()

    {

        if(!isset($_SESSION['JobsSessions'])){

            header ( "Location:" . $this->config->base_url ()."login");

        }

        else {

            if (ACTYPE == 1) {

                 check_roles(5);



                    $this->data['publications']=$this->front_model->get_query_simple('*','dev_web_publications',array('status'=>1))->result_object();

                    $this->load->view('frontend/paid_content_placement',$this->data);

                }

            }



    }

    public function edit_admin($uid)
    {



         if(!isset($_SESSION['JobsSessions'])){

            header ( "Location:" . $this->config->base_url ()."login");

        }

        else {



            if (ACTYPE == 1) {
                check_roles(2);
                $this->data['admin']=$this->front_model->get_query_simple('*','dev_web_user',array('uID'=>$uid))->result_object()[0];

                $this->data['roless'] = $this->db->where('admin_id',$uid)->get('dev_web_admin_roles')->result_object();
               
                foreach($this->data['roless'] as $role_d)
                {
                    $this->data['roles_edit'][]=$role_d->role;
                }

                if(isset($_POST['first_name'])){




            $rendomcode = $this->generateRandomString();
            $data = array(
                'uFname'        => $this->input->post('first_name'),
                'uLname'        => $this->input->post('last_name'),
                'uEmail'        => $this->input->post('email'),

            );
            $uID = $this->front_model->update_query('dev_web_user',$data,array('uID'=>$uid));

            $submitted_roles = $this->input->post('admin_roles');
            $roless = $this->db->where('admin_id',$uid)->get('dev_web_admin_roles')->result_object();
            foreach($roless as $role)
            {
                $roles[]=$role->role;
            }

            foreach($roles as $role_r)
            {
                if(in_array($role_r,$submitted_roles)) continue;
                $this->db->where('role',$role_r)->where('admin_id',$uid)->delete('dev_web_admin_roles');
            }

            foreach($submitted_roles as $role_v)
            {
                if(in_array($role_v,$roles)) continue;
                $arr = array(
                    'admin_id'=>$uid,
                    'role'=>$role_v,
                    'assigned_on'=>date("Y-m-d H:i:s")
                );

                $this->db->insert('dev_web_admin_roles',$arr);
            }


            unset($_SESSION['wrongsignup']);
            $_SESSION['thankyou'] = "Account has been updated successfully!";

                header ( "Location:".$this->config->base_url().'admin/admin-users');



        }
        else
        {
            $this->load->view('frontend/edit_admin',$this->data);
        }


        }
    }


    }
    public function privacy_policy()
    {



        $this->load->view('frontend/privacy_policy',$this->data);
    }
    public function create_smart_contract_page()
    {
      $this->load->view('frontend/create_smart_contract_page',$this->data);

    }
    public function delete_user_data(){
     $this->is_logged();
     $this->is_admin();
     check_roles(2);

	$user = $this->front_model->get_query_simple('uID','dev_web_user',array('uUsername'=>$this->input->post('username')));
	$count = $user->num_rows();
	if($count > 0){
		$row = $user->result_object();
		$this->front_model->delete_query('dev_web_transactions',array('uID'=>$row[0]->uID));
        $this->front_model->delete_query('dev_web_airdrop_submissions',array('uID'=>$row[0]->uID));
        $this->front_model->delete_query('dev_web_user',array('uID'=>$row[0]->uID));
		
		$_SESSION['thankyou'] = "Your Selected username and all its data has been removed!";
		header ( "Location:".$this->config->base_url().'admin/gdpr-settings');
	}
	else {
		$_SESSION['error'] = "Username not found!";
		header ( "Location:".$this->config->base_url().'admin/gdpr-settings');
	}

}
	
public function admin_kyc_settings($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ());
        }
        else {
            if (ACTYPE == "1") {
                    $arr = array(
                        'uID'=>UID,
                        'title'=>$this->input->post('company_name'),
                        'url'=>$this->input->post('comp_url'),
                        'apisetting'=>$this->input->post('settings'),
                        'status'=>1,
                    );
                    $this->front_model->add_query('dev_web_kyc_ml_user',$arr);
                    $_SESSION['error'] = "Settings Added Successfully";
					header ( "Location:".$this->config->base_url().'KYC/AML');
               
            }
        }
    }	
public function admin_kyc_settings_edit()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ());
        }
        else {
            if (ACTYPE == "1") {
                    $arr = array(
                        'title'=>$this->input->post('company_name'),
                        'url'=>$this->input->post('comp_url'),
                        'apisetting'=>$this->input->post('settings'),
                    );
                    $this->front_model->update_query('dev_web_kyc_ml_user',$arr,array('kycID'=>$this->input->post('id')));
				
                    $_SESSION['error'] = "Settings Added Successfully";
					header ( "Location:".$this->config->base_url().'KYC/AML');
               
            }
        }
    }	
	
	public function update_kyc_settings(){
        $data = array('status' => $this->uri->segment(3));
        $condition = array('kycID' => $this->uri->segment(4));
        $this->front_model->update_query('dev_web_kyc_ml_user',$data,$condition);
//		echo $this->db->last_query();
//		die;
        $_SESSION['thankyou'] = "Status information updated successfully!";
        header ( "Location:" . $_SERVER['HTTP_REFERER']);
    }
	public function delete_kyc_aml_data(){
      	$data = array('kycID' => $this->uri->segment(3));
        $this->front_model->delete_query('dev_web_kyc_ml_user',$data);
        $_SESSION['thankyou'] = "Status information updated successfully!";
        header ( "Location:" . $_SERVER['HTTP_REFERER']);
    }
public function edit_kyc_aml()

{
	if(!isset($_SESSION['JobsSessions'])){
		header ( "Location:" . $this->config->base_url ());
	}
	else {
		if (ACTYPE == 1) {
             check_roles(2);
				$this->load->view('frontend/edit_kyc_aml',$this->data);
			}
		}
}
    public function registration_form()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                 check_roles(2);
                if(isset($_POST['submit']))
                {
                    $arr = array('required'=>$this->input->post('required')==1?1:0,'field_name'=>$this->input->post('field'));
                    $this->front_model->add_query('dev_web_registration_forms',$arr);
                    $_SESSION['thankyou']="New field added successfully!";
                    redirect(base_url().'admin/registration-form');
                }
                else
                {
                    $this->data['registration_form']=$this->front_model->get_query_simple('*','dev_web_registration_forms',array())->result_object();
                    $this->load->view('frontend/registration_form', $this->data);
                }
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function remove_form_field($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if (ACTYPE == "1") {
                 check_roles(2);

                $this->front_model->delete_query('dev_web_registration_forms',array('id'=>$id));
                $_SESSION['thankyou'] = "Country removed successfully!";
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function new_reg_form()
    {
         if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                 check_roles(2);

                if(isset($_POST['formname']))
                {
                    

                    $dataform = json_encode($_SESSION['t']['jsondata']);
                    $data = array(
                        'form'  => $dataform,
                        'title' => $this->input->post('formname'),
                        'status'    =>0,
                        'dateCreated'   => date("Y-m-d H:i:s"),
                    );


                    $this->front_model->add_query('dev_web_registration_forms',$data);

                    
                    unset($_SESSION['FORMSUBMISSIONID']);
                    unset($_SESSION['t']['jsondata']);
                    

                    $_SESSION['thankyou']="New form added successfully!";
                    redirect(base_url().'admin/registration-form');
                    
                }
                else
                {
                   
                    $this->load->view('frontend/new_registration_form', $this->data);
                }
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function admin_edit_reg_form($id)
    {
         if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                 check_roles(2);

                $this->data['id']=$id;
                $this->data['edit']=true;
                if(isset($_POST['formname']))
                {
                    

                    $dataform = json_encode($_SESSION['t']['jsondata']);
                    $data = array(
                        'form'  => $dataform,
                        'title' => $this->input->post('formname'),
                    );
                    $this->front_model->update_query('dev_web_registration_forms',$data,array('id'=>$id));

                    
                    unset($_SESSION['FORMSUBMISSIONID']);
                    unset($_SESSION['t']['jsondata']);
                    

                    $_SESSION['thankyou']="Form updated successfully!";
                    redirect(base_url().'admin/registration-form');
                    
                }
                else
                {
                   
                    $this->load->view('frontend/new_registration_form', $this->data);
                }
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function revert_form_edit()
    {
        unset($_SESSION['t']);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_form_data(){
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            $_SESSION['form_create'][] = $_POST;
            header ( "Location:" . $_SERVER['HTTP_REFERER']);
        }
    }
    public function activate_form($id)
    {
         if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {

                 check_roles(2);

            
            $this->front_model->update_query('dev_web_registration_forms',array('status'=>0),array());
            $this->front_model->update_query('dev_web_registration_forms',array('status'=>1),array('id'=>$id));
            $_SESSION['thankyou']="Activated!";
            header ( "Location:" . $_SERVER['HTTP_REFERER']);
        }
    }
    public function remove_page($id)
    {
         if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            
            $this->front_model->delete_query('dev_web_pages',array('pID'=>$id));
            $_SESSION['thankyou']="Removed!";
            header ( "Location:" . $_SERVER['HTTP_REFERER']);
        }
    }
    public function activate_page($id,$type)
    {
         if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            


            if($type=="privacy")
            {
                 $data = array('pStatus'=>0);

                 $cond = array("privacy"=>1);
            }
            elseif($type=="terms")
            {
              $data = array('pStatus'=>0);

                 $cond = array("terms"=>1);
            }
            else
            {
                $data = array();

                 $cond = array();
            }

            $this->front_model->update_query('dev_web_pages', $data,$cond);
            $this->front_model->update_query('dev_web_pages',array('pStatus'=>1),array('pID'=>$id));
            $_SESSION['thankyou']="Activated!";
           $this->redirect_back();
        }
    }
    public function inactivate_page($id)
    {
         if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            


           
             $data = array('pStatus'=>0);

             $cond = array("pID"=>$id);
           

            $this->front_model->update_query('dev_web_pages', $data,$cond);
           
            $_SESSION['thankyou']="In-Activated!";
            $this->redirect_back();
        }
    }

    public function add_form_data_edit_one(){
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            $jsondata = $_SESSION['t']['jsondata'][] = $_POST;
            header ( "Location:" . $_SERVER['HTTP_REFERER']);
        }
    }

    public function edit_form_data(){
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {




            $id = $this->input->post('fid');
            $kkey = $this->input->post('key');


//            $arr = array('fID'=>$id);
//            $config = $this->front_model->get_query_simple('*','dev_web_cat_forms',$arr);
//            $form     = $config->result_object();


            $jsondata = $_SESSION['t']['jsondata'];

            $this->data['not_update']=1;



            foreach($jsondata as $b_key=>$banner)
            {


                if($b_key==$kkey)
                {
                   // echo "yahan aya ta";
                    unset($_POST['id']);
                    unset($_POST['key']);
                    $jsondata[$b_key]=$_POST;

                }
                else
                {
                    $jsondata[$b_key]=$banner;
                }


            }



            $this->data['jsondata']=$jsondata;

           $_SESSION['t']['jsondata']=$jsondata;




            header ( "Location:" . $_SERVER['HTTP_REFERER']);
        }
    }
    public function remove_form_data(){
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {

            $id = $this->input->post('fid');
            $kkey = $this->input->post('key');


//            $arr = array('fID'=>$id);
//            $config = $this->front_model->get_query_simple('*','dev_web_cat_forms',$arr);
//            $form     = $config->result_object();


            $jsondata = $_SESSION['t']['jsondata'];

            $jsondata_ = $jsondata;

            $this->data['not_update']=1;




            foreach($jsondata_ as $b_key=>$banner)
            {


                if($b_key==$kkey)
                {

                    unset($jsondata_[$b_key]);

                }
            }



            $this->data['jsondata']=$jsondata_;

            $_SESSION['t']['jsondata']=$jsondata_;




            header ( "Location:" . $_SERVER['HTTP_REFERER']);
        }
    }
   
    
    public function delete_form_data(){
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {



            
            /*$data = array('fID' => $this->input->post('category'));
            $condition = array('cID' => $this->input->post('cID'));
            $this->front_model->update_query('dev_web_categories',$data,$condition);*/
            
            $condition = array('fID' => $this->uri->segment(3));
            $this->front_model->delete_query('dev_web_cat_forms',$condition);
            
            //$_SESSION['change_div'] = 'change';
            $_SESSION['thankyou'] = "Form Information Deleted Successfully!";
            header ( "Location:" . $this->config->base_url ()."admin/manage/form");
        }
    }
    public function edit_pages($type="0")
    {


         $this->is_logged();
         $this->is_admin();
         check_roles(2);
     
        if($type=="0")
            $arr = array();
        else
            $arr = array($type=>1);

        $this->data['type']=$type;
        $config     = $this->front_model->get_query_simple('*','dev_web_pages',$arr);
        
        $this->data['pages']    = $config->result_object();
        $this->load->view('frontend/edit_pages', $this->data);
    }
    
    public function new_page($type="0")
    {
         if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){

         check_roles(2);
                $this->data['type']=$type;
                $this->data['edit']=false;
                if(isset($_POST['pHeading']))
                {

                    if($type=="privacy")
                        $link = "privacy-policy";
                    elseif($type=="terms")
                        $link = "terms";
                    else
                        $link ="";

                 
                    $data = array(
                        'pHeading'  => $this->input->post('pHeading'),
                        'pTitle'  => $this->input->post('pTitle'),
                        'pDescp'  => $this->input->post('pDescp'),
                        'pKeyword'  => $this->input->post('pKeyword'),
                        'pContent'  => $this->input->post('pContent'),
                        'pLink'  => $link,
                        'type'=>$this->input->post('type')==1?1:0,
                        'pElink'=>$this->input->post('pElink'),
                        'pStatus'=>0
                    );
                    $data[$type]=1;
                    $this->front_model->add_query('dev_web_pages',$data);

                    $_SESSION['thankyou']="Page add successfully!";
                    redirect(base_url().'admin/'.$type.'-pages');
                    
                }
                else
                {
                   
                    $this->load->view('frontend/new_page', $this->data);
                }
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function edit_page($id)
    {
         if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){


         check_roles(2);


                $page = $this->front_model->get_query_simple('*','dev_web_pages',array('pID'=>$id))->result_object();
                if(empty($page))
                {
                    redirect(base_url());
                    exit;
                }

                $page = $page[0];
                $type = $page->privacy==1?'privacy':'terms';

                if($page->terms==0 && $type=="terms")
                {
                    $type="";
                }
                $this->data['page']=$page;

                $this->data['type']=$type;
                $this->data['edit']=true;
                if(isset($_POST['pHeading']))
                {

                 
                    $data = array(
                        'pName'  => $this->input->post('pName'),
                        'pHeading'  => $this->input->post('pHeading'),
                        'pTitle'  => $this->input->post('pTitle'),
                        'pDescp'  => $this->input->post('pDescp'),
                        'pKeyword'  => $this->input->post('pKeyword'),
                        'pContent'  => $this->input->post('pContent'),
                        'type'=>$this->input->post('type')==1?1:0,
                        'pElink'=>$this->input->post('pElink'),
                        
                    );
                    $data[$type]=1;
                    $this->front_model->update_query('dev_web_pages',$data,array('pID'=>$id));

                    $_SESSION['thankyou']="Page updated successfully!";

                    if($type=="")
                    {
                    redirect(base_url().'admin/pages');
                     exit; 
                    }

                    redirect(base_url().'admin/'.$type.'-pages');
                    
                }
                else
                {
                   
                    $this->load->view('frontend/new_page', $this->data);
                }
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function export_users($type="csv",$most_type="all")
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {

            switch ($most_type) {
                    case 'all':
                        $cond_ = array();
                        break;
                    case 'active':
                        $cond_ = array('uStatus'=>1);
                        break;
                    case 'inactive':
                        $cond_ = array('uStatus'=>0);
                        break;
                    case 'rejected':
                        $cond_ = array('uStatus'=>2);
                        break;
                    case 'buyers':
                        $cond_ = array('uActType'=>2);
                        break;
                    case 'admins':
                        $cond_ = array('uActType'=>1);
                        break;
                    
                    default:
                        $cond_ = array();
                        break;
                }

       

       


            if(ACTYPE == "1"){
        $data = $this->db->where('del',0)
        ->where($cond_)
        ->select('uID as ID')
        ->select('uFname as FirstName')
        ->select('uLname as LastName')
        ->select('uEmail as Email')
        ->select('uUsername as Username')
        ->select('uCompany as Company')
        ->select('uCountry as Country')
        ->select('uCity as City')
        ->select('uZip as Zipcode')
        ->select('uPhone as Phone')
        ->select('uDOB as DOB')
        ->select('uAddress as Address')
        ->select('uActType as Type')
        ->select('uStatus as Status')
        ->select('joinDate as JoinDate')
        ->select('uIP as IP')
        ->select('id_company as IDCompany')
        ->select('tax_number as TaxNumber')
        ->select('uManager as Manager')
        ->select('uWallet as Wallet')
        ->select('uTelegram as Telegram')
        ->select('tokens as Tokens')
        ->get('dev_web_user')
        ->result_array();

        if(empty($data))
        {
            $_SESSION['error']="There no data in selected filter.";
            redirect($_SERVER['HTTP_REFERER']);
            exit;
        }



        foreach($data as $key=>$value)
        {
            foreach($value as $ky=>$vlue)
            {
                if($ky=="Country")
                {
                    $country = $this->db->where('id',$vlue)->select('nicename')->get('dev_web_countries')->result_object()[0]->nicename;
                    $data[$key][$ky]=$country;
                }
                if($ky=="Type")
                {
                    if($vlue==1)
                        $type = "Admin";
                  
                    elseif($vlue==2)
                        $type="Buyer";

                    $data[$key][$ky]=$type;

                }
                if($ky=="Status")
                {
                    if($vlue==1)
                        $status = "Active";

                    elseif($vlue==0)
                        $status="In-Active";

                    $data[$key][$ky]=$status;
                    break;
                }
            }
        }


        if($type=="csv")
            $type="";
        if($type=="comma")
            $type=",";
        if($type=="tab")
            $type=chr(9);

        
        $this->array2csv($data,"users_csv",$type);
            }
        }
    }
    public function export_emails($type="users")
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {

            switch ($type) {
                    case 'all':
                        $cond_ = array();
                        break;
                    case 'active':
                        $cond_ = array('uStatus'=>1);
                        break;
                    case 'inactive':
                        $cond_ = array('uStatus'=>0);
                        break;
                    case 'rejected':
                        $cond_ = array('uStatus'=>2);
                        break;
                    case 'buyers':
                        $cond_ = array('uActType'=>2);
                        break;
                    case 'admins':
                        $cond_ = array('uActType'=>1);
                        break;
                    
                    default:
                        $cond_ = array();
                        break;
                }

       

       


            if(ACTYPE == "1"){
        $data = $this->db->where('del',0)
        ->where($cond_)        
        ->select('uEmail as Email')
        
        ->get('dev_web_user')
        ->result_array();

        if(empty($data))
        {
            $_SESSION['error']="There no data in selected filter.";
            redirect($_SERVER['HTTP_REFERER']);
            exit;
        }



        foreach($data as $key=>$value)
        {
            foreach($value as $ky=>$vlue)
            {
                if($ky=="Country")
                {
                    $country = $this->db->where('id',$vlue)->select('nicename')->get('dev_web_countries')->result_object()[0]->nicename;
                    $data[$key][$ky]=$country;
                }
                if($ky=="Type")
                {
                    if($vlue==1)
                        $type = "Admin";
                  
                    elseif($vlue==2)
                        $type="Buyer";

                    $data[$key][$ky]=$type;

                }
                if($ky=="Status")
                {
                    if($vlue==1)
                        $status = "Active";

                    elseif($vlue==0)
                        $status="In-Active";

                    $data[$key][$ky]=$status;
                    break;
                }
            }
        }


        if($type=="csv")
            $type="";
        if($type=="comma")
            $type=",";
        if($type=="tab")
            $type=chr(9);

        
        $this->array2csv($data,"emails_csv",$type,0);
            }
        }
    }
    private function array2csv($list,$name="file",$type,$put_header=1)
    {
        $this->load->helper('download');
        $name = $name.'_'.date("Y_m_d_H_i_s").'.csv';
        $file_name = './resources/uploads/private_files/'.$name;
        $fp = fopen($file_name, 'w');
    
        foreach ($list[0] as $key=>$fields)
            $keys[]=$key;
        if($put_header==1)
        fputcsv($fp, $keys);

      
        foreach ($list as $fields) 
            fputcsv($fp, $fields);
        fclose($fp);

        force_download($file_name,NULL);
    }
    public function export_transactions($type="csv")
    {
        $data = $this->db->select('tID as ID')
        ->select('usdPayment as USDPayment')
        ->select('status as Status')
        ->select('datecreated as DateCreated')
        ->select('amtType as AmountType')
        ->select('uID as User')
        ->select('uIP as IP')
        ->select('hash as Hash')
        ->select('transaction_id as TransactionID')
        ->select('t_type as TransactionType')
        ->get('dev_web_transactions')
        ->result_array();



        foreach($data as $key=>$value)
        {
            foreach($value as $ky=>$vlue)
            {
                if($ky=="User")
                {
                    $country = $this->db->where('uID',$vlue)->select('uFname')->select('uLname')->get('dev_web_user')->result_object()[0];
                    $data[$key][$ky]=$country->uFname.' '.$country->uLname;
                }
                if($ky=="TransactionType")
                {
                    if($vlue==1)
                        $type = "TransA";
                  
                    elseif($vlue==2)
                        $type = "TransB";

                    $data[$key][$ky]=$type;

                }
                if($ky=="Status")
                {
                    if($vlue==1)
                        $status = "Pending";

                    elseif($vlue==2)
                        $status="Completed";
                     elseif($vlue==3)
                        $status="Rejected";

                    $data[$key][$ky]=$status;
                    break;
                }
            }
        }


        if($type=="csv")
            $type="";
        if($type=="comma")
            $type=",";
        if($type=="tab")
            $type=chr(9);

        
        $this->array2csv($data,"transactions_csv",$type);
    }
    public function manage_payment_option_countries($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                $this->data['countries'] = $this->front_model->get_query_simple('*','dev_web_payment_option_countries',array());
                $this->load->view('frontend/manage_payment_option_countries',$this->data);
            }
        }
    }
    public function ico_milestones()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(1);
                $this->data['ico_milestones'] = $this->front_model->get_query_simple('*','dev_web_ico_milestones',array('uID'=>UID))->result_object();
                $this->load->view('frontend/ico_milestones',$this->data);
            }
        }
    }
    public function delete_ico_milestone($id)
    {
         if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(1);

               $this->front_model->delete_query('dev_web_ico_milestones',array('id'=>$id));
               $_SESSION['success']="Deleted";
               redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function milestone_status($type,$id)
    {
         if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(1);

               $this->front_model->update_query('dev_web_ico_milestones',array('status'=>$type),array('id'=>$id));
               $_SESSION['success']="Updated";
               redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function add_ico_milestone_step_1()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(1);


                if(isset($_POST['campaign']))
                {
                    $_SESSION['new_milestone']=$_POST;
                    redirect(base_url().'admin/add-ico-milestone/step-2');
                    exit;
                }

                $this->data['campaigns'] = $this->front_model->get_query_simple('*','dev_web_ico_settings',array())->result_object();
                $this->load->view('frontend/add_ico_milestone_step_1',$this->data);
            }
        }
    }
    public function add_ico_milestone_step_2()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(1);
                $campaign_data = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$_SESSION['new_milestone']['campaign']))->result_object()[0];


                if(isset($_POST['total_funding']))
                {
                    $arr = array(
                        'uID'=>UID,
                        'total_funding'=>$this->input->post('total_funding'),
                        'min_funding'=>$this->input->post('min_funding'),
                        'tokens_sold'=>$this->input->post('tokens_sold'),
                        'campaign'=>$_SESSION['new_milestone']['campaign'],
                        'datecreated'=>date("Y-m-d H:i:s"),
                        'status'=>$campaign_data->active==1?1:0
                    );
                    unset($_SESSION['new_milestone']);
                    $this->front_model->add_query('dev_web_ico_milestones',$arr);
                    $_SESSION['success']="Done";
                    redirect(base_url().'admin/ico-milestones');
                    exit;
                }
                $this->load->view('frontend/add_ico_milestone_step_2',$this->data);
            }
        }
    }
    public function edit_ico_milestone($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(1);


                if(isset($_POST['total_funding']))
                {
                    $arr = array(
                        
                        'total_funding'=>$this->input->post('total_funding'),
                        'min_funding'=>$this->input->post('min_funding'),
                        'tokens_sold'=>$this->input->post('tokens_sold'),
                        'campaign'=>$this->input->post('campaign'),
                        
                    );
                   
                    $this->front_model->update_query('dev_web_ico_milestones',$arr,array('id'=>$id));
                    $_SESSION['success']="Done";
                    redirect(base_url().'admin/ico-milestones');
                    exit;
                }

                $this->data['campaigns'] = $this->front_model->get_query_simple('*','dev_web_ico_settings',array())->result_object();
                $this->data['milestone'] = $this->front_model->get_query_simple('*','dev_web_ico_milestones',array('id'=>$id))->result_object()[0];
                $this->load->view('frontend/edit_milestone',$this->data);
            }
        }
    }
    public function wallet_addresses($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                $this->data['addresses']=$this->front_model->get_query_simple('*','dev_web_wallet_addresses',array('option_id'=>$id))->result_object();
                $this->load->view('frontend/wallet_addresses',$this->data);
            }
        }
    }
    public function delete_wallet_address($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
               $this->db->delete('dev_web_wallet_addresses',array('id'=>$id));
               $_SESSION['thankyou']="Wallet Address removed successfully!";
               redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function add_wallet_address($id)
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
                        'option_id'=>$id,
                        'created_at'=>date("Y-m-d H:i:s")
                    );
                    $this->front_model->add_query('dev_web_wallet_addresses',$array);
                    $_SESSION['thankyou']="Address added successfully!";
                    redirect($_SERVER['HTTP_REFERER']);
               }
            }
        }
    }
    public function update_wallet_address()
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
                    );
                    $this->front_model->update_query('dev_web_wallet_addresses',$array,array('id'=>$this->input->post('id')));
                    $_SESSION['thankyou']="Address updated successfully!";
                    redirect($_SERVER['HTTP_REFERER']);
               }
            }
        }
    }
    public function upload_wallet_addresses($id)
    {

        $post = isset($_POST) ? $_POST: array();
        $max_width = "500";
        $return = array('status'=>0,'msg'=>"try again");
        $valid_formats = array("csv");


        $files_to = $_FILES['csv'];
        $path = 'resources/uploads/private_files/';
        print_r($_FILES);
        echo 1;
        foreach($files_to['name'] as $key=>$name){
            // $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
            $name = $_FILES['csv']['name'];
            $size = $_FILES['csv']['size'];


            $files = $_FILES['csv'];

            $name = $files['name'][$key]; //get the name of the file
            $size = $files['size'][$key]; //get the size of the file



            if(strlen($name)) {
                list($txt, $ext) = explode(".", $name);
              $nw_cond_ext = explode('.',$name)[count(explode('.',$name))-1];

                if(in_array($nw_cond_ext,$valid_formats)) {
                    if(1==1) {
                        $actual_image_name = "c_".GUID().'_camp'.'_'.'.'.$nw_cond_ext;
                        $filePath = $path .'/'.$actual_image_name;
                        $tmp = $files['tmp_name'][$key];
                        if(move_uploaded_file($tmp, $filePath)) {
                          

                            $file = $path.$actual_image_name;


                                $row = 1;
                                if (($handle = fopen($file, "r")) !== FALSE) {
                                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                        $row++;
                                        if($data[0] && strlen($data[0])>5){
                                            $arr=array(
                                                'address'=>$data[0],
                                                'option_id'=>$id,
                                                'created_at'=>date("Y-m-d H:i:s")
                                            );
                                            $this->db->insert('dev_web_wallet_addresses',$arr);
                                        }
                                    }
                                    fclose($handle);

                                    $_SESSION['thankyou']=$row." addresses added successfully!";
                                    redirect($_SERVER['HTTP_REFERER']);
                                    exit;
                                }

                                $_SESSION['error']="Error occured";

                                redirect($_SERVER['HTTP_REFERER']);
                                exit;
                            // echo json_encode($return); exit;
                        }
                        else

                          $_SESSION['error']= "failed";
                    }
                    else
                         $_SESSION['error']= "File size max 8 MB";
                }
                else
                   $_SESSION['error']= "Invalid file format...";
            }
            else
                $_SESSION['error']= "Please select a file..!";

            redirect($_SERVER['HTTP_REFERER']);
           
        }

    }

    public function change_payment_option_one_per_trans($id,$val)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){

                if($val==1)
                {
                    $count = $this->db->where('option_id',$id)->count_all_results('dev_web_wallet_addresses');
                    $count_unused = $this->db->where('option_id',$id)->where('used',0)->count_all_results('dev_web_wallet_addresses');

                    if($count_unused==0 && $count>0)
                    {
                        $_SESSION['error']="Please add some new addresses in order to use this feature.";
                        redirect($_SERVER['HTTP_REFERER']);
                        exit;
                    }
                    elseif($count_unused==0 && $count==0)
                    {
                        $_SESSION['error']="Please add some addresses in order to use this feature.";
                        redirect($_SERVER['HTTP_REFERER']);
                        exit;                       
                    }


                }


               $this->db->where(array('id'=>$id))->update('dev_web_payment_options',array('one_per_trans'=>$val));
               $_SESSION['thankyou']="Updated successfully!";
               redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    
    public function update_warning($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){

               $this->db->where(array('id'=>$id))->update('dev_web_payment_options',array('warning_before'=>$this->input->post('warning')));
               $_SESSION['thankyou']="Updated successfully!";
               redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function email_settings()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                 check_roles(2);

                $this->data['emails']=$this->front_model->get_query_simple('*','dev_web_emails',array())->result_object();
                $this->load->view('frontend/email_settings',$this->data);
            }
        }
    }

    public function edit_email($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                 check_roles(2);

            $this->data['email']=$this->front_model->get_query_simple('*','dev_web_emails',array('eID'=>$id))->result_object()[0];

               if(isset($_POST['eName']))
               {
                    $array = array(
                        'eName'=>$this->input->post('eName'),
                        'eSubject'=>$this->input->post('eSubject'),
                        'eContent'=>$this->input->post('eContent'),
                        'eEmail'=>$this->input->post('eEmail'),
                    );
                    $this->front_model->update_query('dev_web_emails',$array,array('eID'=>$id));
                    $_SESSION['thankyou']="Email updated successfully!";
                    redirect(base_url().'admin/email-settings');
               }


                $this->load->view('frontend/edit_email',$this->data);

            }
        }
    }
    public function end_expired_camps()
    {
        echo "This function has been shutdown; <br> consider using /ico/each_5_manage_token_n_camps";
        exit;
        //$this->db->where('DATE(tokenDateEnds)',date("Y-m-d"))->where('end_on_end_date',1)->update('dev_web_token_pricing',array('status'=>0));
    }
    public function start_new_camps()
    {
        echo "This function has been shutdown; <br> consider using /ico/each_5_manage_token_n_camps";
        exit;
        //$this->db->where('DATE(tokenDateEnds)',date("Y-m-d"))->where('end_on_end_date',1)->update('dev_web_token_pricing',array('status'=>1));
    }

    public function each_5_manage_token_n_camps()
    {

        $current_cmp = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('active'=>1))->result_object()[0];

        if($current_cmp->multiple==1)
        {
            echo "Sorry, system is not allowed to change the state of 'multiple' type campaign. So, exiting...";
            exit;
        }



        $de_activated = $this->each_5_do_inactive_camp();
        if($de_activated)
        {
            $this->each_5_do_activate_camp();
        }
        $this->__each_5_do_activate_camp();


        $this->each_5_do_shutdown_invalid_tokens();


        $de_activated = $this->each_5_do_inactive_template();
        if($de_activated)
        {
            $this->each_5_do_activate_template();
        }
        $this->__each_5_do_activate_template();



        $this->active_inactive_milstones();
    }
    private function active_inactive_milstones()
    {
        $this->db->update('dev_web_ico_milestones',array('status'=>0));
        $active_camp = $this->db->where('active',1)->get('dev_web_ico_settings')->result_object()[0];
         
        $this->db->where('campaign',$active_camp->id)->update('dev_web_ico_milestones',array('status'=>1));
      

    }
    private function each_5_do_shutdown_invalid_tokens()
    {
        $current_camp = $this->db->where('active',1)->get('dev_web_ico_settings')->result_object()[0];

        $this->db->where('ico_camp !=',$current_camp->id)->update('dev_web_token_pricing',array('status'=>0));

    }
    private function each_5_do_inactive_camp()
    {
        $current_camp = $this->db->where('active',1)->get('dev_web_ico_settings')->result_object();
        if(!empty($current_camp))
        {
            $current_camp=$current_camp[0];
            date_default_timezone_set($current_camp->timezone);

            $end_date_str = strtotime(date("Y-m-d",strtotime($current_camp->end_date)));
            $today_date_str = strtotime(date("Y-m-d",time()));


            if($end_date_str<=$today_date_str)
            {

                $end_time = strtotime(date("H:i",strtotime($current_camp->end_time)));
                $now_time = strtotime(date("H:i",time()));

                if($end_time<=$now_time)
                {
                    $this->db->where('id',$current_camp->id)->update('dev_web_ico_settings',array('active'=>0));

                    return true;

                }
                elseif($end_date_str<$today_date_str)
                {
                    $this->db->where('id',$current_camp->id)->update('dev_web_ico_settings',array('active'=>0));

                    return true;
                }
            }
        }
        return false;
    }
    private function each_5_do_activate_camp($type=1)
    {
        $inactive_camps = $this->db->where('active',0)->get('dev_web_ico_settings')->result_object();
        foreach($inactive_camps as $inactive_camp){

            date_default_timezone_set($inactive_camp->timezone);

            $should_be = $this->db->group_start()
            ->where('active',0)
            ->group_end()
            ->group_start()
            ->where("DATE(start_date) <",date("Y-m-d"))
            ->where("DATE(end_date) >",date("Y-m-d"))            
            ->group_end()
            ->or_group_start()
                ->group_start()
                    ->where("DATE(start_date)",date("Y-m-d"))
                    ->where("TIME(start_time) <=",date("H:i"))
                    ->where("DATE(end_date) >",date("Y-m-d"))                  
                ->group_end()
                ->or_group_start()
                    ->where("DATE(start_date)",date("Y-m-d"))
                    ->where("TIME(start_time) <=",date("H:i"))
                    ->where("DATE(end_date)",date("Y-m-d"))  
                    ->where("TIME(end_time) >",date("H:i"))
                ->group_end()

                ->or_group_start()
                    ->where("DATE(start_date) <",date("Y-m-d"))
                    ->where("DATE(end_date)",date("Y-m-d"))
                    ->where("TIME(end_time) >=",date("H:i"))
                ->group_end()               
                
            ->group_end()

            
            ->get('dev_web_ico_settings')->result_object();
            if(!empty($should_be)){
                $this->db->where('id',$should_be[0]->id)->update('dev_web_ico_settings',array('active'=>1));
                return true;
            }
        }
        return false;
    }
    private function __each_5_do_activate_camp()
    {
        $current_time_zone = $this->db->get('dev_web_config')->result_object()[0];
        date_default_timezone_set($current_time_zone->timezone);


        $no_one_active = $this->db->where('active',1)->count_all_results('dev_web_ico_settings');
        if($no_one_active==0){

            $should_be = $this->db->group_start()
            ->where('active',0)
            ->group_end()
            ->group_start()

            ->where("DATE(start_date) <",date("Y-m-d"))
            ->where("DATE(end_date) >",date("Y-m-d"))            
            ->group_end()
            ->or_group_start()
                ->group_start()
                    ->where("DATE(start_date)",date("Y-m-d"))
                    ->where("TIME(start_time) <=",date("H:i"))
                    ->where("DATE(end_date) >",date("Y-m-d"))                  
                ->group_end()
                ->or_group_start()
                    ->where("DATE(start_date)",date("Y-m-d"))
                    ->where("TIME(start_time) <=",date("H:i"))
                    ->where("DATE(end_date)",date("Y-m-d"))  
                    ->where("TIME(end_time) >",date("H:i"))
                ->group_end()

                ->or_group_start()
                    ->where("DATE(start_date) <",date("Y-m-d"))
                    ->where("DATE(end_date)",date("Y-m-d"))
                    ->where("TIME(end_time) >=",date("H:i"))
                ->group_end()               
                
            ->group_end()
            ->get('dev_web_ico_settings')->result_object();
           
            
            if(!empty($should_be)){

                $this->db->where('id',$should_be[0]->id)->update('dev_web_ico_settings',array('active'=>1));
                return true;
            }
        }
        return false;
    }
    private function each_5_do_inactive_template()
    {

        $current_camp = $this->db->where('active',1)->get('dev_web_ico_settings')->result_object();
        if(!empty($current_camp)){

            $current_token = $this->db->where('status',1)->where('ico_camp',$current_camp[0]->id)->get('dev_web_token_pricing')->result_object();
            if(!empty($current_token))
            {
                $current_token=$current_token[0];
                date_default_timezone_set($current_token->timezone);

                
                 $end_date_str = strtotime(date("Y-m-d",strtotime($current_token->tokenDateEnds)));
                // echo $current_token->tokenDateEnds;
                // echo '|';
                // echo date("Y-m-d",time());
                
                 $today_date_str = strtotime(date("Y-m-d",time()));
                

                if($end_date_str<=$today_date_str && ($current_token->end_type!=2))
                {
                    

                    $end_time = strtotime(date("H:i",strtotime($current_token->end_time)));
                   

                     $now_time = strtotime(date("H:i",time()));
                   
                    if($end_time<=$now_time)
                    {
                        
                        $this->db->where('tkID',$current_token->tkID)->update('dev_web_token_pricing',array('status'=>0));
                        return true;
                    }
                    elseif($end_date_str<$today_date_str)
                    {
                        $this->db->where('tkID',$current_token->tkID)->update('dev_web_token_pricing',array('status'=>0));
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function each_5_do_activate_template()
    {
        $current_camp = $this->db->where('active',1)->get('dev_web_ico_settings')->result_object();
        if(!empty($current_camp)){
            $inactive_templates = $this->db->where('status',0)->where('ico_camp',$current_camp[0]->id)->get('dev_web_token_pricing')->result_object();
            foreach($inactive_templates as $inactive_template){
                date_default_timezone_set($inactive_template->timezone);



                $should_be = $this->db->group_start()
                ->where('ico_camp',$current_camp[0]->id)                
                ->where('status',0)
                ->group_end()
                ->group_start()

                ->where("DATE(tokenDateStarts) <",date("Y-m-d"))
                ->where("DATE(tokenDateEnds) >",date("Y-m-d"))            
                ->group_end()
                ->or_group_start()
                    ->group_start()
                        ->where("DATE(tokenDateStarts)",date("Y-m-d"))
                        ->where("TIME(start_time) <=",date("H:i"))
                        ->where("DATE(tokenDateEnds) >",date("Y-m-d"))                  
                    ->group_end()
                    ->or_group_start()
                        ->where("DATE(tokenDateStarts)",date("Y-m-d"))
                        ->where("TIME(start_time) <=",date("H:i"))
                        ->where("DATE(tokenDateEnds)",date("Y-m-d"))  
                        ->where("TIME(end_time) >",date("H:i"))
                    ->group_end()

                    ->or_group_start()
                        ->where("DATE(tokenDateStarts) <",date("Y-m-d"))
                        ->where("DATE(tokenDateEnds)",date("Y-m-d"))
                        ->where("TIME(end_time) >=",date("H:i"))
                    ->group_end()               
                    
                ->group_end()

                ->get('dev_web_token_pricing')->result_object();
                if(!empty($should_be)){
                    $this->db->where('tkID',$should_be[0]->tkID)->update('dev_web_token_pricing',array('status'=>1));
                    return true;
                }
            }
        }
        return false;
    }
    private function __each_5_do_activate_template()
    {
         $current_camp = $this->db->where('active',1)->get('dev_web_ico_settings')->result_object();
        if(!empty($current_camp)){
        $current_time_zone = $this->db->get('dev_web_config')->result_object()[0];
        date_default_timezone_set($current_time_zone->timezone);
        $no_one_active = $this->db->where('status',1)->count_all_results('dev_web_token_pricing');
        if($no_one_active==0){

            $should_be = $this->db->group_start()
                   ->where('ico_camp',$current_camp[0]->id)
                   ->where('status',0)
                ->group_end()
                ->group_start() 
                ->where("DATE(tokenDateStarts) <",date("Y-m-d"))
                ->where("DATE(tokenDateEnds) >",date("Y-m-d"))            
                ->group_end()
                ->or_group_start()
                    ->group_start()
                        ->where("DATE(tokenDateStarts)",date("Y-m-d"))
                        ->where("TIME(start_time) <=",date("H:i"))
                        ->where("DATE(tokenDateEnds) >",date("Y-m-d"))                  
                    ->group_end()
                    ->or_group_start()
                        ->where("DATE(tokenDateStarts)",date("Y-m-d"))
                        ->where("TIME(start_time) <=",date("H:i"))
                        ->where("DATE(tokenDateEnds)",date("Y-m-d"))  
                        ->where("TIME(end_time) >",date("H:i"))
                    ->group_end()

                    ->or_group_start()
                        ->where("DATE(tokenDateStarts) <",date("Y-m-d"))
                        ->where("DATE(tokenDateEnds)",date("Y-m-d"))
                        ->where("TIME(end_time) >=",date("H:i"))
                    ->group_end()               
                    
                ->group_end()
            ->get('dev_web_token_pricing')->result_object();
            if(!empty($should_be)){
                
                $this->db->where('tkID',$should_be[0]->tkID)->update('dev_web_token_pricing',array('status'=>1));
                return true;
            }
        }}
        return false;
    }
    public function alert_completed_tokens()
    {

        $active_camp = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object();
        if(!empty($active_camp))
        {
            $active_camp = $active_camp[0];
            $tokens_limit = $active_camp->tokenCap;

            echo $active_camp->tkID;
            $start_date = date("Y-m-d",strtotime($active_camp->tokenDateStarts));
            $end_date = date("Y-m-d",strtotime($active_camp->tokenDateEnds));

            $total_sold_token = $this->db->where('DATE(datecreated) >=',$start_date)
            ->where('DATE(datecreated) <=',$end_date)
            ->where('template_used',$active_camp->tkID)
            ->get('dev_web_transactions')
            ->result_object();

           

            if(!empty($total_sold_token)){
                $total_sold_ =0;
                foreach($total_sold_token as $_total_sold_token){
                    $total_sold_ += $_total_sold_token->tokens;
                }

                if($tokens_limit<=$total_sold_)
                {
                    $this->alert_admin_about_campaign($active_camp->tkID,$tokens_limit,$total_sold_);
                }

               
            }


        }

    }
    public function alert_admin_about_campaign($id,$limit=10,$sold=10)
    {

        $users = $this->front_model->get_query_simple('*','dev_web_user', array('uActType'=>1,'uStatus'=>1))->result_object();

        foreach($users as $user){

            $edata = $this->front_model->get_emails_data('alert-token-end');
            $this->load->library('email');
            $this->email->from($edata[0]->eEmail, TITLEWEB);
            $this->email->to($user->uEmail);
            $replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]","[CAP]","[SOLD]");
            $replacewith = array(WEBURL, $rendomcode, $user->uFname." ".$user->uLname,TITLEWEB,$limit,$sold);
            $str = str_replace($replace,$replacewith,$edata[0]->eContent);
            $message = $str;
            $this->email->subject($edata[0]->eName);
            $this->email->message($message);
            $this->email->set_mailtype("html");
            // $send = $this->email->send();
            
            $this->sendgrid_mail(array($user->uEmail,''),$message,$edata[0]->eName);
        }
       

    }
    
    private function remove_verification_docs($id)
    {
        $its_id = $this->db->where('v_id',$id)->get('dev_web_verification_docs')->result_object();
        if(!empty($its_id)){
            $this->db->where('v_id',$id)->or_where('parent',$its_id->id)->delete('dev_web_verification_docs');
            $_SESSION['thankyou']="Removed!";
        }
    }
    private function insert_verification_docs($id)
    {

        if(isset($_SESSION['v']))
        {
            $arr = array(
                'parent'=>0,
                'v_id'=>$id,
                'type'=>'parent',
                'document_type'=>$this->input->post('document_type'),
                'including_country'=>$this->input->post('including_country'),
                'datecreated'=>date("Y-m-d H:i:s"),

            );
            $v_id = $this->front_model->add_query('dev_web_verification_docs',$arr);
        }
        foreach($_SESSION['v'] as $key=>$val)
        {
            if($key=='front' || $key=='back')
            {
                $arr_ = array(
                    'doc_'.$key => $val
                );
                $this->db->where('id',$v_id)->update('dev_web_verification_docs',$arr_);
            }
            else
            {
                foreach($val as $key__ => $val__){

                    $arr__ = array(
                    'parent'=>$v_id,
                    'type'=>$key,
                    'document_type'=>0,
                    'including_country'=>0,
                    'datecreated'=>date("Y-m-d H:i:s"),
                    $key=>$val__
                    );

                    $this->db->insert('dev_web_verification_docs',$arr__);

                }
            }
        }
        unset($_SESSION['v']);
        return true;
    }
    public function selfie_doc($r=0)
    {
        echo selfie_doc($r);
    }
    public function any_type_doc($r=0)
    {
        echo any_type_doc($r);
    }
    public function bill_doc($r=0)
    {
        echo bill_doc($r);
    }
    public function take_verification_docs()
    {
        $post = isset($_POST) ? $_POST: array();
        $max_width = "500";
        $return = array('status'=>0,'msg'=>"try again");
        // $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
        $path = 'resources/uploads/verification/';
        $valid_formats = array("jpg", "png", "jpeg", "JPG","PNG","JPEG","pdf","PDf");
        $name = $_FILES['inputfile']['name'];
        $size = $_FILES['inputfile']['size'];
        if(strlen($name)) {
            list($txt, $ext) = explode(".", $name);
            $nw_cond_ext = explode('.',$name)[count(explode('.',$name))-1];

            if(in_array($nw_cond_ext,$valid_formats)) {
                if(1==1) {
                    $post_name = $this->input->post("name");
                    $actual_image_name = "verification_".$post_name.'_'.date("y_m_d_h_i_s").'_'.UID.'.'.$nw_cond_ext;
                    $filePath = $path .'/'.$actual_image_name;
                    $tmp = $_FILES['inputfile']['tmp_name'];
                    if(move_uploaded_file($tmp, $filePath)) {

                        if(strtolower($nw_cond_ext)!="pdf")
                        $return = array('status'=>1,'msg'=>"", 'src'=>base_url().$path.$actual_image_name);
                        else
                        $return = array('status'=>1,'msg'=>"", 'src'=>base_url().'resources/frontend/images/pdf_small.png');


                        if($post_name!="front" && $post_name!="back"){
                            $_SESSION['v'][$post_name][]=$actual_image_name;
                        }
                        else
                        {
                             $_SESSION['v'][$post_name]=$actual_image_name;
                        }
                        echo json_encode($return); exit;
                    }
                    else
                        $return['msg']= "failed";
                }
                else
                    $return['msg']= "Image file size max 1 MB";
            }
            else
                $return['msg']= "Invalid file format...";
        }
        else
            $return['msg']= "Please select image..!";
        echo json_encode($return);
        exit;
    }
    public function verification_reports()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                $this->load->view('frontend/verification_reports', $this->data);
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function approve_user_verification($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
            check_roles(4);
            $old_data = $this->front_model->get_query_simple('*','dev_web_user_verification',array('id'=>$id))->result_object()[0];

            $array =array(

                'uStatus'=>1,
                'verified_at'=>date("Y-m-d H:i:s"),
                'action_taker_ids'=>$old_data->action_taker_ids.','.UID,
                'action_taker_emails'=>$old_data->action_taker_emails.','.EMAIL,
            );


              $this->db->where('id',$id)->update('dev_web_user_verification',$array);
              $this->db->where('uID',$old_data->uID)->update('dev_web_user',array('uStatus'=>1,'kyc_verified'=>1));

              $_SESSION['thankyou']="Status updated successfully!";
              redirect($_SERVER['HTTP_REFERER']);
            } 
        }
    }

    public function reject_user_verification($id=0)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                 check_roles(4);
                $id = $id==0?$this->input->post('id'):$id;


            $old_data = $this->front_model->get_query_simple('*','dev_web_user_verification',array('id'=>$id))->result_object()[0];

            $array =array(

                'uStatus'=>2,
                'last_reason'=>$this->input->post('reason'),

                'rejected_at'=>date("Y-m-d H:i:s"),
                'action_taker_ids'=>$old_data->action_taker_ids.','.UID,
                'action_taker_emails'=>$old_data->action_taker_emails.','.EMAIL,
            );

              $this->db->where('id',$id)->update('dev_web_user_verification',$array);
              $this->db->where('uID',$old_data->uID)->update('dev_web_user',array('uStatus'=>2));
              $this->inform_user_about_rejecttion($old_data->uID);
              $_SESSION['thankyou']="Status updated successfully!";
              redirect($_SERVER['HTTP_REFERER']);
            } 
        }
    }
    public function inform_user_about_rejecttion($uid)
    {
         $user = $this->front_model->get_query_simple('*','dev_web_user', array('uID'=>$uid))->result_object()[0];

       

            $edata = $this->front_model->get_emails_data('alert-account-rejected');
            $this->load->library('email');
            $this->email->from($edata[0]->eEmail, TITLEWEB);
            $this->email->to($user->uEmail);
            $replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]");
            $replacewith = array(WEBURL, $rendomcode, $user->uFname." ".$user->uLname,TITLEWEB);
            $str = str_replace($replace,$replacewith,$edata[0]->eContent);
            $message = $str;
            $this->email->subject($edata[0]->eName);
            $this->email->message($message);
            $this->email->set_mailtype("html");
            // $send = $this->email->send();
            
            $this->sendgrid_mail(array($user->uEmail,''),$message,$edata[0]->eName);
       
    }
    public function remove_user_verification($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                 check_roles(4);

            $old_data = $this->front_model->get_query_simple('*','dev_web_user_verification',array('id'=>$id))->result_object()[0];

            $array =array(
                'deleted'=>1,
                'deleted_at'=>date("Y-m-d H:i:s"),
                'action_taker_ids'=>$old_data->action_taker_ids.','.UID,
                'action_taker_emails'=>$old_data->action_taker_emails.','.EMAIL,
            );

              $this->db->where('id',$id)->update('dev_web_user_verification',$array);
              $_SESSION['thankyou']="Removed successfully!";
              redirect($_SERVER['HTTP_REFERER']);
            } 
        }
    }
    public function view_user_verification($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                 check_roles(4);
            $this->data['pdf_view']=false;

            $this->data['verification'] = $this->front_model->get_query_simple('*','dev_web_user_verification',array('id'=>$id,'deleted'=>0))->result_object()[0];
            $this->load->view('frontend/view_user_verification',$this->data);
            } 
        }
    }
    public function edit_user_verification_text()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){


                if(isset($_POST['footer_text_1']))
                {
                    $arr = array(
                        'footer_text_1'=>$this->input->post('footer_text_1')
                    );
                    $this->db->where('id',1)->update('dev_web_kyc_aml',$arr);
                    $_SESSION['thankyou']="Text updated successfully!";
                    redirect(base_url().'KYC/AML');
                    exit;
                }
                else
                {

                    $this->data['text'] = $this->front_model->get_query_simple('*','dev_web_kyc_aml',array('id'=>1))->result_object()[0];
                     $this->load->view('frontend/edit_user_verification_text',$this->data);

                }


            
            } 
        }
    }
    public function export_verifications($type="all")
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                 check_roles(4);

                switch ($type) {
                    case 'all':
                        $cond_ = array();
                        break;
                    case 'pending':
                        $cond_ = array('uStatus'=>0);
                        break;
                    case 'accepted':
                        $cond_ = array('uStatus'=>1);
                        break;
                    case 'rejected':
                        $cond_ = array('uStatus'=>2);
                        break;
                    
                    default:
                        $cond_ = array();
                        break;
                }

        $data = $this->db->where($cond_)
        ->where('deleted',0)
        ->select('id as ID')
        ->select('uID as UserID')
        ->select('uFname as FirstName')
        ->select('uMname as MiddleName')
        ->select('uLname as LastName')
        ->select('uDOB as DOB')
        ->select('uPhone as Phone')
        ->select('uEmployment as Employment')
        ->select('uGross as GrossIncome')
        ->select('uContribute as WannaContribute')
        ->select('uETH as EthereumAddress')
        ->select('uCountry as Country')
        ->select('uState as State')
        ->select('uCity as City')        
        ->select('uZip as Zipcode')
        ->select('uStreet as Street')
        ->select('uApartment as Apartment')
        ->select('uStatus as Status')

        ->select('verified_at as AcceptedAt')
        ->select('rejected_at as RejectedAt')
        ->select('last_reason as RejectionReason')

        ->get('dev_web_user_verification')
        ->result_array();

        if(empty($data))
        {
            $_SESSION['error']="There no data in selected filter.";
            redirect($_SERVER['HTTP_REFERER']);
            exit;
        }



        foreach($data as $key=>$value)
        {
            foreach($value as $ky=>$vlue)
            {
                if($ky=="Country")
                {
                    $country = $this->db->where('id',$vlue)->select('nicename')->get('dev_web_countries')->result_object()[0]->nicename;
                    $data[$key][$ky]=$country;
                }
                
                if($ky=="Status")
                {
                    if($vlue==1)
                        $status = "Accepted";

                    elseif($vlue==0)
                        $status="Pending";
                     elseif($vlue==2)
                        $status="Rejected";

                    $data[$key][$ky]=$status;
                    break;
                }
                if($ky=="GrossIncome")
                {
                    $status = "$".$vlue;
                    $data[$key][$ky]=$status;
                   
                }
                if($ky=="WannaContribute")
                {
                    $status = "$".$vlue;
                    $data[$key][$ky]=$status;
                   
                }
            }
        }


            if($type=="csv")
                $type="";
            if($type=="comma")
                $type=",";
            if($type=="tab")
                $type=chr(9);

            
            $this->array2csv($data,"users_csv",$type);
            }
        }
    }
    public function fix_tokens()
    {
        $users = $this->db->get('dev_web_user')->result_object();
        foreach($users as $user)
        {
            $tokens = get_my_tokens($user->uID);
            $this->db->where('uID',$user->uID)->update('dev_web_user',array('tokens'=>$tokens));
        }
        echo "<h1>Fixed</h1>";
    }
    public function edit_user_verification_popup()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
 check_roles(2);

                if(isset($_POST['verification_popup_text']))
                {
                    $arr = array(
                        'verification_popup_text'=>$this->input->post('verification_popup_text')
                    );

                    if(isset($_SESSION['p']['popup_img']))
                    {
                        $arr['verification_popup_img']=$_SESSION['p']['popup_img'];

                    }

                    $this->db->where('id',1)->update('dev_web_kyc_aml',$arr);
                    $_SESSION['thankyou']="Popup updated successfully!";
                    unset($_SESSION['p']['popup_img']);
                    redirect(base_url().'KYC/AML');
                    exit;
                }
                else
                {

                    $this->data['popup'] = $this->front_model->get_query_simple('*','dev_web_kyc_aml',array('id'=>1))->result_object()[0];
                     $this->load->view('frontend/edit_user_verification_popup',$this->data);

                }


            
            } 
        }
    }

    public function take_image_verification_popup()
    {
        $post = isset($_POST) ? $_POST: array();
        $max_width = "500";
        $return = array('status'=>0,'msg'=>"try again");
        // $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
        $path = 'resources/uploads/verification/';
        $valid_formats = array("jpg", "png", "gif", "bmp","jpeg",  "JPG", "PNG", "GIF", "BMP","JPEG");
        $name = $_FILES['inputfile']['name'];
        $size = $_FILES['inputfile']['size'];
        if(strlen($name)) {
            list($txt, $ext) = explode(".", $name);
            $nw_cond_ext = explode('.',$name)[count(explode('.',$name))-1];
            if(in_array($nw_cond_ext,$valid_formats)) {
                if(1==1) {
                    $actual_image_name = "p_".date("ymdhis").'_popup'.'_'.'.'.$nw_cond_ext;
                    $filePath = $path .'/'.$actual_image_name;
                    $tmp = $_FILES['inputfile']['tmp_name'];
                    if(move_uploaded_file($tmp, $filePath)) {
                        $return = array('status'=>1,'msg'=>"", 'src'=>base_url().$path.$actual_image_name);
                        $_SESSION['p']['popup_img']=$actual_image_name;
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
    // public fuc
    public function view_user_verification_pdf($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else 
        {
            if(ACTYPE == "1")
            {
                 check_roles(4);
                $this->data['pdf_view']=true;

                $this->data['verification'] = $this->front_model->get_query_simple('*','dev_web_user_verification',array('id'=>$id,'deleted'=>0))->result_object()[0];
                $html = $this->load->view('frontend/view_user_verification',$this->data,true);

                require_once 'vendor/autoload.php';


                $mpdf = new \Mpdf\Mpdf();
                $mpdf->falseBoldWeight = 10;

                $mpdf->WriteHTML($html);
                $file = './resources/uploads/private_files/pdf_file_'.$id.'_'.time().'.pdf';
                $mpdf->Output($file);
                $this->load->helper('download');
                force_download($file,NULL);
            } 
        }
    }
    public function export_for_accounts($type="all")
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){

                if(strpos(current_url(),'demo.icodashboard.io') === false){
                    $_SESSION['error']="Please don't";
                    redirect(base_url());
                }

               $cond_ = array('del'=>0);

                $data = $this->db->where($cond_)
                ->get('dev_web_user')
                ->result_array();

                if(empty($data))
                {
                    $_SESSION['error']="There no data in selected option.";
                    redirect($_SERVER['HTTP_REFERER']);
                    exit;
                }
           
                if($type=="csv")
                    $type="";
                if($type=="comma")
                    $type=",";
                if($type=="tab")
                    $type=chr(9);

            
                $this->array2csv($data,"users_csv_for_accounts",$type);
            }
        }
    }
    
    public function manually_verify_email($uid)
    {
         if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                if($uid)
                $this->front_model->update_query('dev_web_user',array('uverifyemail'=>1),array('uID'=>$uid));

                $_SESSION['thankyou']="Status updated successfully!";
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function kyc_verification()
    {
        $this->data['kyc_verification']=true;
        $this->load->view('frontend/dashboard', $this->data);
    }
   
    public function kyc_verification_type_3()
    {


        if(am_i('securix'))
        {

             if($this->data['user_verified']!=1 && $this->data['kyc_verification_enabled']==1 && $this->data['kyc_verification_at']==2 && ($this->data['kyc_verification_at_crypto']==2 || $this->data['kyc_verification_at_fiat']==2))            
            {
                $transacions_ = $this->front_model->get_query_simple('*','dev_web_transactions',array('uID'=>UID))->result_object();
                if(!empty($transacions_)){
                    if($this->uri->segment(1)=="buy-tokens")
                    {
                        redirect(base_url().'kyc-verification');
                    }
                }
            }
        }
        else
        {
            if($this->data['user_verified']!=1 && $this->data['kyc_verification_enabled']==1 && $this->data['kyc_verification_at']==3)
            {
                $transacions_ = $this->front_model->get_query_simple('*','dev_web_transactions',array('uID'=>UID))->result_object();
                if(!empty($transacions_)){
                    if($this->uri->segment(1)=="buy-tokens")
                    {
                        redirect(base_url().'kyc-verification');
                    }
                }
            }

        }



        
    }
    public function add_tokens()
    {
         if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                $uid = $this->input->post('id');
                $balance = $this->input->post('balance');

                $this->add_balance($uid,$balance);

                $subject="Tokens added!";
                $data = "Admin has added ".$balance." tokens in your account";
                $this->notify_user($subject,$data,$uid);

                $_SESSION['thankyou']="Tokens added successfully!";
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function delete_transaction()
    {

        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                $id = $this->input->post('id');
                $trans = $this->db->where('tID',$id)->get('dev_web_transactions')->result_object()[0];

                // $user_balance = get_my_tokens($trans->uID);
                $this->sub_balance($trans->uID,$trans->tokens);

                $array = array(
                    'table_name'=>'dev_web_transactions',
                    'time'=>date("Y-m-d H:i:s"),
                    'by'=>UID,
                    'data'=>json_encode($trans)
                );

                $this->db->insert('dev_web_trash', $array);
                $this->db->where('tID',$id)->delete('dev_web_transactions');
                

                $_SESSION['thankyou']="Transaction removed successfully!";
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function run_query()
    {
        $arr = array(
            "ALTER TABLE `dev_web_config` ADD `subdomain` VARCHAR(255) NULL AFTER `ref_helping_txt`;",
            "ALTER TABLE `dev_web_kyc_aml` CHANGE `require_at` `require_at` INT(1) NOT NULL DEFAULT '1' COMMENT '1=after each login; 2=at token purchase;';",
            "ALTER TABLE `dev_web_kyc_aml` ADD `require_at_crypto` INT(1) NOT NULL DEFAULT '1' COMMENT '1=before; 2=after;' AFTER `require_at`;",
            "ALTER TABLE `dev_web_kyc_aml` ADD `require_at_fiat` INT(1) NOT NULL DEFAULT '1' COMMENT '1=before; 2=after;' AFTER `require_at_crypto`;",
            "ALTER TABLE `dev_web_token_pricing` ADD `timezone` VARCHAR(255) NOT NULL DEFAULT '0' AFTER `end_on_end_token`;",
            "ALTER TABLE `dev_web_ico_settings` ADD `timezone` VARCHAR(255) NOT NULL DEFAULT '0' AFTER `end_on_end_token`",
            "ALTER TABLE `dev_web_token_pricing` ADD `start_time` TIME NULL AFTER `timezone`, ADD `end_time` TIME NULL AFTER `start_time`;",
            "ALTER TABLE `dev_web_ico_settings` ADD `start_time` TIME NULL AFTER `timezone`, ADD `end_time` TIME NULL AFTER `start_time`;",
            "ALTER TABLE `dev_web_config` ADD `timezone` VARCHAR(255) NULL AFTER `subdomain`;",

        );
        $arr = array("ALTER TABLE `dev_web_user` ADD `whitelist` INT(1) NOT NULL DEFAULT '0' AFTER `kyc_mind`;","ALTER TABLE `dev_web_user` ADD `whitelist_settings` TEXT NULL AFTER `whitelist`;");
        $arr = array("ALTER TABLE `dev_web_config` ADD `import_export_feature` INT(1) NOT NULL DEFAULT '0' AFTER `configCopy`;");
        $arr = array("ALTER TABLE `dev_web_transactions` CHANGE `amtType` `amtType` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0';");
        foreach($arr as $ar)
        $this->db->query($ar);
    }
    //gekkk
    public function update_meta()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                foreach($this->input->post() as $key=>$value)
                {
                    $this->db->where('type',$key)->update('dev_web_meta',array('value'=>$value));

                }

                $_SESSION['thankyou']="You settings have been saved!";
                redirect($_SERVER['HTTP_REFERER']);
                // exit;
            }
        }
    }
    public function my_referral_code()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "2"){
                 $arr = array('uID' => UID);
            $config = $this->front_model->get_query_simple('*','dev_web_user',$arr);
            $this->data['users']    = $config->result_array()[0];
               $this->load->view('frontend/view_ref_page',$this->data);
            }
        }
    }
    public function arrange_slides($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(1);

                $this->data['slides'] = $this->db->where('camp_id',$id)->get('dev_web_camp_slides')->result_object();

                if(isset($_POST['submit']))
                {
                    if(empty($this->input->post('sorted')) || !$_POST['sorted'])
                    {
                        redirect(base_url().'admin/campaign-slides/'.$id);
                        exit;
                    }


                    echo "<pre>";
                     $post_  = '&'.$this->input->post('sorted');

                    foreach(explode('&set[]=',$post_) as $key=>$val)
                    {
                        if($key==0)
                            continue;

                        $order[]=$val;
                       
                        
                    }
                    foreach(explode(',',$this->input->post('ids')) as $key=>$slide)
                       {
                        $this->db->where('id',$slide)->update('dev_web_camp_slides',array('position'=>$key+1));
                       }
                    $_SESSION['thankyou']="Order has been changed";
                    redirect(base_url().'admin/campaign-slides/'.$id);
                    exit;
                }

                $does_sort = $this->db->where('camp_id',$id)->where('position !=',0)->count_all_results('dev_web_camp_slides');
               
                if($does_sort>0)
                {
                    $order_by = 'position';
                }
                else
                {
                    $order_by = 'id';
                }


                $this->data['slides']=$this->db->where('camp_id',$id)->order_by($order_by,'ASC')->get('dev_web_camp_slides')->result_object();
               

                $arr = array();
                // $config  = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
                // $this->data['countries']     = $config->result_object();
                $this->data['id']=$id;
                $this->load->view('frontend/arrange_slides', $this->data);
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function enable_ask_eth()
    {

        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(2);
                $this->db->update('dev_web_config',array('ask_eth'=>1));
                $_SESSION['thankyou']="Setting saved!";
                redirect($_SERVER['HTTP_REFERER']);
            }
        }

    }
    public function disable_ask_eth()
    {

        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(2);
                $this->db->update('dev_web_config',array('ask_eth'=>0));
                $_SESSION['thankyou']="Setting saved!";
                redirect($_SERVER['HTTP_REFERER']);
            }
        }

    }
    public function spring_role()
    {
        $this->load->view('frontend/spring_role',$this->data);
    }
    // public function
    public function v_telegram()
    {
        $this->load->view('frontend/v_telegram',$this->data);
    }
public function verify_yourself($uID=0)
    {

         if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {


            $active_api = $this->db->where('active',1)->get('dev_web_kyc_apis')->result_object()[0];


            if(am_i('tib'))
            {
                $this->data['on_verification_page']=true;
            

                $_SESSION['vf_popup_shown']=true;
                $edit =false;

                $this->handle_tib_kyc();
                exit;
            }


            if($active_api->type=="IDMIND"){

                $uID = $uID==0?UID:$uID;

                $this->data['user']=$this->front_model->get_query_simple('*','dev_web_user',array('uID'=>$uID))->result_object()[0];
                $this->data['verification']=$this->front_model->get_query_simple('*','dev_web_user_verification',array('uID'=>$uID,'deleted'=>0))->result_object();
                //echo $this->data['verification']->uStatus;exit;

                if(!empty($this->data['verification']) && $this->data['verification'][0]->uStatus!=2)
                {
                    $_SESSION['error']="Sorry, you're not allowed to edit this data because this is being reviewed";
                    redirect(base_url().'dashboard');
                    exit;
                }

                $curl = curl_init();

                $api_details = $this->db->where('type',"IDMIND")->get('dev_web_kyc_apis')->result_object()[0];

                curl_setopt_array($curl, array(
                  CURLOPT_URL => $api_details->url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_HTTPHEADER => array(
                    "x-api-key: ".$api_details->private_key
                  ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                 echo "cURL Error #:" . $err;
                } else {
                  $data['token']=json_decode($response)->token;
                  $this->load->view('frontend/try_idm',$data);
                }
            }
            elseif($active_api->type=="IDMINDPLUGIN"){

                if($this->uri->segment(2)=="accepted" || $this->uri->segment(2)=="rejected" || $this->uri->segment(2)=="review")
                {
                    $arr = $this->db->order_by('id','DESC')->get('hook_test')->result_object()[0]->resp;
                    $this->try_kcy_response($arr);
                }


                $this->data['on_verification_page']=true;
            

                $_SESSION['vf_popup_shown']=true;
                $edit =false;

                $uID = $uID==0?UID:$uID;

                $this->data['user']=$this->front_model->get_query_simple('*','dev_web_user',array('uID'=>$uID))->result_object()[0];
                $this->data['verification']=$this->front_model->get_query_simple('*','dev_web_user_verification',array('uID'=>$uID,'deleted'=>0))->result_object();
                //echo $this->data['verification']->uStatus;exit;

                if(!empty($this->data['verification']) && $this->data['verification'][0]->uStatus!=2)
                {
                    $_SESSION['error']="Sorry, you're not allowed to edit this data because this is being reviewed";
                    redirect(base_url().'dashboard');
                    exit;
                }
                $this->data['verification'] = $this->data['verification'][0];
 
                
                $this->load->view('frontend/verify_dnatix',$this->data);
            }elseif($active_api->type=="SHUFTIPRO"){

                $this->handle_gbmstech_verification();

            }
            elseif($active_api->type=="OKVERIFY")
            {
                $this->handle_demo_verification();
            }
            elseif($active_api->type=="VERIFF")
            {
                $this->handle_veriff_verification();
            }
            else{


                $this->data['on_verification_page']=true;
            

            $_SESSION['vf_popup_shown']=true;
            $edit =false;

            $uID = $uID==0?UID:$uID;

            $this->data['user']=$this->front_model->get_query_simple('*','dev_web_user',array('uID'=>$uID))->result_object()[0];
            $this->data['verification']=$this->front_model->get_query_simple('*','dev_web_user_verification',array('uID'=>$uID,'deleted'=>0))->result_object();
            //echo $this->data['verification']->uStatus;exit;

            if(!empty($this->data['verification']) && $this->data['verification'][0]->uStatus!=2)
            {
                $_SESSION['error']="Sorry, you're not allowed to edit this data because this is being reviewed";
                redirect(base_url().'dashboard');
                exit;
            }
            $this->data['verification'] = $this->data['verification'][0];


            if($this->data['verification']->uStatus)
            {
                $edit=true;
            }

            if(isset($_POST['uFname']))
            {

                $verif = array(
                    'uID'=>$uID,
                    'uFname'=>$this->input->post('uFname'),
                    'uLname'=>$this->input->post('uLname'),
                    'uMname'=>$this->input->post('uMname'),
                    'uDOB'=>$this->input->post('uDOB'),
                    // 'uPhone'=>$this->input->post('uPhone'),
                    'uEmployment'=>$this->input->post('uEmployment'),
                    'uGross'=>$this->input->post('uGross'),
                    'uContribute'=>$this->input->post('uContribute'),
                    'uETH'=>$this->input->post('uETH'),
                    'uCountry'=>$this->input->post('uCountry'),
                    'uZip'=>$this->input->post('uZip'),
                    'uCity'=>$this->input->post('uCity'),
                    'uState'=>$this->input->post('uState'),
                    'uStreet'=>$this->input->post('uStreet'),
                    'uApartment'=>$this->input->post('uApartment'),
                    
                  
                );

                $this->save_basic_info_if_not_saved($verif);


                if(!$edit)
                {
                    $verif['uStatus']=0;
                    $verif['datecreated']=date("Y-m-d H:i:s");
                    $verif['ip']=$_SERVER['REMOTE_ADDR'];

                    $verification_id = $this->front_model->add_query('dev_web_user_verification',$verif);

                    $this->insert_verification_docs($verification_id);
                    $_SESSION['thankyou']="Your data has been submitted to verification.";
                    redirect(base_url().'dashboard');

                }
                else
                {
                    $this->remove_verification_docs($this->data['verification']->id);
                    $verif['uStatus']=0;
                    $this->db->where('id',$this->data['verification']->id)
                    ->update('dev_web_user_verification',$verif);
                    $this->insert_verification_docs($this->data['verification']->id);

                    $_SESSION['thankyou']="Your data has been updated.";
                    redirect(base_url().'/dashboard');

                }



            }
            else
            {
                $this->load->view('frontend/verify_yourself',$this->data);
            }
            }
            
            
        }
    }
    private function handle_veriff_verification()
    {
        $this->data['on_verification_page']=true;
        $_SESSION['vf_popup_shown']=true;
        $edit =false;
        $uID = $uID==0?UID:$uID;
        $this->data['user']=$this->front_model->get_query_simple('*','dev_web_user',array('uID'=>$uID))->result_object()[0];
        $this->data['verification']=$this->front_model->get_query_simple('*','dev_web_user_verification',array('uID'=>$uID,'deleted'=>0))->result_object();
        $api_details = $this->db->where('type',"VERIFF")->get('dev_web_kyc_apis')->result_object()[0];
        $this->data['api_details']=$api_details;
        if(isset($_POST['step']))
        {}
        else{
            $this->load->view('frontend/verify_yourself_veriff',$this->data);
        }

    }
    private function handle_demo_verification()
    {
        $this->data['on_verification_page']=true;
        $_SESSION['vf_popup_shown']=true;
        $edit =false;
        $uID = $uID==0?UID:$uID;
        $this->data['user']=$this->front_model->get_query_simple('*','dev_web_user',array('uID'=>$uID))->result_object()[0];
        $this->data['verification']=$this->front_model->get_query_simple('*','dev_web_user_verification',array('uID'=>$uID,'deleted'=>0))->result_object();
         $api_details = $this->db->where('type',"OKVERIFY")->get('dev_web_kyc_apis')->result_object()[0];

            if(isset($_POST['step']))
            {

                if($_POST['step']==1){


                    $verif = array(
                        'uID'=>$uID,
                        'uFname'=>$this->input->post('uFname'),
                        'uLname'=>$this->input->post('uLname'),
                        'uMname'=>$this->input->post('uMname'),
                        'uDOB'=>$this->input->post('uDOB'),
                        'uPhone'=>$this->input->post('uPhone'),
                        'uEmployment'=>$this->input->post('uEmployment'),
                        'uGross'=>$this->input->post('uGross'),
                        'uContribute'=>$this->input->post('uContribute'),
                        'uETH'=>$this->input->post('uETH'),
                        'uCountry'=>$this->input->post('uCountry'),
                        'uZip'=>$this->input->post('uZip'),
                        'uCity'=>$this->input->post('uCity'),
                        'uState'=>$this->input->post('uState'),
                        'uStreet'=>$this->input->post('uStreet'),
                        'uApartment'=>$this->input->post('uApartment'),
                        
                      
                    );
                    $country = $this->db->where('id',$verif['uCountry'])->get('dev_web_countries')->result_object()[0];
                    $country = $country->iso;
                    $address =  $verif['uApartment'].", ".$verif['uStreet'].", ".$verif['uCity'].", ".$verif['uState'].", ".$country;

                    $curl_post =array(
                        'first_name'=>$verif['uFname'],
                        'last_name'=>$verif['uLname'],
                        'email'=>$this->input->post('uEmail'),
                        'phone'=>$verif['uPhone'],
                        'address'=>$address,
                        'city'=>$verif['uCity'],
                        'region'=>$verif['uState'],
                        'zipcode'=>$verif['uZip'],
                        'ip'=>$_SERVER['REMOTE_ADDR'],
                        'country'=>$country,
                        'birthdate'=>$verif['uDOB'],
                        'nationalid'=>$country,
                        
                    );
                   

                    $url = $api_details->url."api/customer/create";
                    $response = $this->demo_post_curl($url,$curl_post);

                    if($response->success){



                        $_SESSION['verification']['customer_uuid']=$response->customer_uuid;
                        $arr = array(
                            "success"=>"1"
                        );
                    }
                    else
                    {
                        foreach($response as $k=>$r){
                            $string .= $k. ' '. $r . '';
                        }
                        $arr = array('success'=>"0",
                            'error'=>$string
                        );

                    }






                     if($response->success){

                        $this->save_basic_info_if_not_saved($verif);



                        if(!$edit)
                        {
                            $verif['uStatus']=0;
                            $verif['datecreated']=date("Y-m-d H:i:s");
                            $verif['ip']=$_SERVER['REMOTE_ADDR'];

                            $verification_id = $this->front_model->add_query('dev_web_user_verification',$verif);

                        }
                        else
                        {
                            $this->remove_verification_docs($this->data['verification']->id);
                            $verif['uStatus']=0;
                            $this->db->where('id',$this->data['verification']->id)
                            ->update('dev_web_user_verification',$verif);
                            $verification_id=$this->data['verification']->id;
                 
                        }
                        $_SESSION['verification']['verification_id']=$verification_id;


                        $arr['v_id']=$verification_id;
                    }

                    echo json_encode($arr);

                }else{

                    if(!isset($_SESSION['verification']['verification_id']))
                    {
                        $arr['success']="0";
                        $arr['error']="Please try again by starting over";
                        echo json_encode($arr);
                        exit;

                    }


                    $url = $api_details->url."api/process/create";


                    $post_curl = array(
                            "customer_uuid"=>$_SESSION['verification']['customer_uuid'],
                            "enable_photo"=>true,
                            "disable_datasource"=> true

                        );

                        $_p_res = $this->demo_post_curl($url,$post_curl);

                        if($_p_res->success)
                        {

                            $_SESSION['verification']['process_id']=$_p_res->process_uuid;

                        }



                    $v_id = $_SESSION['verification']['verification_id'];
                    $id = $v_id;
                    $u_uid = $_SESSION['verification']['customer_uuid'];
                    $process_idd = $_SESSION['verification']['process_id'];


                    $this->remove_verification_docs($v_id);
                    $this->insert_verification_docs($v_id);
                    

                    $document_type = $this->input->post('document_type');


                    $document_data = $this->db->where('id',$id)->get('dev_web_user_verification')->result_object()[0];
                    $document_doc_parent = $this->db->where('v_id',$id)->get('dev_web_verification_docs')->result_object()[0];
                    $document_docs = $this->db->where('parent',$document_doc_parent->id)->get('dev_web_verification_docs')->result_object();
                    $country = $this->db->where('id',$document_data->uCountry)->get('dev_web_countries')->result_object()[0];
                    $country = $country->iso;
                    $address =  $document_data->uApartment.", ".$document_data->uStreet.", ".$document_data->uCity.", ".$document_data->uState.", ".$country;



                    $verification_data["document_front_image"]=

                        'data:image/'
                        .$this->get_ext($document_doc_parent->doc_front)
                        .';base64,'
                        .base64_encode(
                        file_get_contents(base_url()
                        .'resources/uploads/verification/'
                        .$document_doc_parent->doc_front
                    ));
                    $verification_data["document_back_image"]=
                    'data:image/'
                        .$this->get_ext($document_doc_parent->doc_back)
                        .';base64,'
                        .base64_encode(

                        file_get_contents(base_url()
                        .'resources/uploads/verification/'
                        .$document_doc_parent->doc_back
                    ));

                    foreach($document_docs as $_document_doc)
                    {
                        if($_document_doc->type=="selfie")
                        {
                             $verification_data["face_image"]=

                                'data:image/'
                                .$this->get_ext($_document_doc->selfie)
                                .';base64,'
                                .base64_encode(
                                
                                file_get_contents(base_url()
                                .'resources/uploads/verification/'
                                .$_document_doc->selfie

                            ));
                        }
                        if($_document_doc->type=="bill")
                        {
                             $verification_data["document_address_image"]=
                                'data:image/'
                                .$this->get_ext($_document_doc->bill)
                                .';base64,'
                                .base64_encode(

                                file_get_contents(base_url()
                                .'resources/uploads/verification/'
                                .$_document_doc->bill


                               ));
                        }
                    }
                  
                   $verification_data_ = json_encode($verification_data);
                   $this->wait_for_process_to_be_ready($process_idd);

                   //id card
                   if($document_type==1){
                        //front
                        $post_curl = array(
                            "data"=>$verification_data["document_front_image"],
                            "document_country"=>$country,
                        );

                        $url = $api_details->url."api/identitycard/upload/".$process_idd;

                        $response = $this->demo_post_curl($url,$post_curl);
                        if($response->success==1)
                        {

                        }
                        else
                        {
                            
                                $r = implode(',', $response);

                                $string .= ' '. 'IDcard (front): '.$r. '';
                            
                            $arr = array('success'=>"0",
                                'error'=>$string,
                                'loc'=>1
                            );

                            echo json_encode($arr);exit;

                        }

                        $this->wait_for_process_to_be_ready($process_idd);

                        //back
                        $post_curl = array(
                            "data"=>$verification_data["document_back_image"],
                            "document_country"=>$country,

                        );

                        $url = $api_details->url."api/identitycardback/upload/".$process_idd;

                        $response = $this->demo_post_curl($url,$post_curl);

                        if($response->success==1)
                        {

                        }
                        else
                        {
                            $r = implode(',', $response);

                                $string .= ' '. 'IDcard (back):'.$r. '';
                            
                            $arr = array('success'=>"0",
                                'error'=>$string,
                                'loc'=>2

                            );

                            echo json_encode($arr);exit;

                        }



                    }

                    $this->wait_for_process_to_be_ready($process_idd);
                    //passport


                    if($document_type==2){
                        //front
                        $post_curl = array(
                            "data"=>$verification_data["document_front_image"],
                            "document_country"=>$country,

                        );

                        $url = $api_details->url."api/passport/upload/".$process_idd;

                        $response = $this->demo_post_curl($url,$post_curl);
                        if($response->success==1)
                        {

                        }
                        else
                        {
                           $r = implode(',', $response);

                                $string .= ' Passport: '. $r . '';
                            
                            $arr = array('success'=>"0",
                                'error'=>$string,
                                'loc'=>3

                            );

                            echo json_encode($arr);exit;

                        }

                    }

                    //diving license
                    $this->wait_for_process_to_be_ready($process_idd);
                    if($document_type==3){
                        //front
                        $post_curl = array(
                            "data"=>$verification_data["document_front_image"],
                            "document_country"=>$country,

                        );

                        $url = $api_details->url."api/driverslicense/upload/".$process_idd;

                        $response = $this->demo_post_curl($url,$post_curl);
                        // print_r($response);

                        if($response->success==1)
                        {

                        }
                        else
                        {
                           $r = implode(',', $response);

                                $string .= ' Driving License (front): '. $r . '';
                            
                            $arr = array('success'=>"0",
                                'error'=>$string,
                                'loc'=>4

                            );

                            echo json_encode($arr);exit;

                        }
                        //back
                        $this->wait_for_process_to_be_ready($process_idd);
                        $post_curl = array(
                            "data"=>$verification_data["document_back_image"],
                            "document_country"=>$country,

                        );

                        $url = $api_details->url."api/driverslicenseback/upload/".$process_idd;

                        $response = $this->demo_post_curl($url,$post_curl);
                        if($response->success==1)
                        {

                        }
                        else
                        {
                           $r = implode(',', $response);

                                $string .= ' Driving License (back) '. $r . '';
                           
                            $arr = array('success'=>"0",
                                'error'=>$string,
                                'loc'=>5

                            );
// 
                            echo json_encode($arr);
                            // exit;

                        }

                    }

                    $this->wait_for_process_to_be_ready($process_idd);
                    //selfie
                    $post_curl = array(
                            "data"=>$verification_data["face_image"],
                            // "document_country"=>$country,

                        );



                         $url = $api_details->url."api/photo/upload/".$process_idd;

                        $response = $this->demo_post_curl($url,$post_curl);
                     
                        if($response->success==1)
                        {

                        }
                        else
                        {
                           $r = implode(',', $response);
                                $string .= ' Selfie '. $r . '';
                            $arr = array('success'=>"0",
                                'error'=>$string
                            );
                            echo json_encode($arr);exit;
                        }
                            $post_curl = array();

                            $url = $api_details->url."api/process/status/".$process_idd;


                            $i = 1;

                            while($i!=-1){

                                $response = $this->demo_post_curl($url,$post_curl,"GET");
                                if($response->status!="working"){
                                    $i = -1;
                                    break;
                                }
                                else
                                    sleep(1);
                               
                            }

                            $url = $api_details->url."api/process/result/".$process_idd;
                            $response = $this->demo_post_curl($url,$post_curl,"GET");
                            if($response->status=="pass")
                            {

                                $uid = $this->db->where('id',$id)->get('dev_web_user_verification')->result_object()[0]->uID;
                                $this->db->where('id',$id)->update('dev_web_user_verification',array('uStatus'=>1));

                                $this->db->where('uID',$uid)->update('dev_web_user',array('kyc_verified'=>1));
                                $_SESSION['thankyou']="Verified Successfully!";
                                


                                $arr['success']=2;
                                echo json_encode($arr);
                                exit;
                            }
                            else
                            {

                                $arr['success']=0;
                                foreach($response as $k=>$r){

                                        if(is_array($r)) $r = implode(',', $r);

                                        $string .= $k. ' Final Process: '. $r . '';
                                    }
                                    $arr = array('success'=>"0",
                                'error'=>$string
                            );
                                echo json_encode($arr);
                                exit;
                            }
                }
            }
            else
            {
                $this->load->view('frontend/verify_yourself_demo',$this->data);
            }

    }
    private function wait_for_process_to_be_ready($id)
    {
        $api_details = $this->db->where('type',"OKVERIFY")->get('dev_web_kyc_apis')->result_object()[0];

        $i = 1;
        $drop = 0;
        while($i!=-1){

            $url = $api_details->url."api/process/status/".$id;
            $response = $this->demo_post_curl($url,$post_curl,"GET");

            if($response->status=="ready")
            {
                $i=-1;
               return true;
            }
            if($response->status=="error")
            {
                 $arr = array('success'=>"0",
                'error'=>$response->last_error,
                'loc'=>1
                );

                echo json_encode($arr);exit;
            }
           
            if($response->status!="working")
            {
                if($drop==30){
                     $arr = array('success'=>"0",
                    
                    'error'=>$response,
                    'loc'=>1
                    );

                    echo json_encode($arr);exit;
                }
                $drop++;
            }
            


            $i++;

            
            sleep(1);
        }
        return true;
    }
    private function demo_post_curl($url,$curl_post,$type="POST")
    {

        $api_details = $this->db->where('type',"OKVERIFY")->get('dev_web_kyc_apis')->result_object()[0];

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_POST => 1,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => $type,
          CURLOPT_POSTFIELDS =>json_encode($curl_post),


          CURLOPT_HTTPHEADER => array(
            "Authorization:Token ".$api_details->private_key,
            "Referer: ".base_url(),
            "accept: application/json",
            "Content-Type: application/json",
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return json_decode($response);
    }
    private function handle_gbmstech_verification()
    {
        $this->data['on_verification_page']=true;
            

            $_SESSION['vf_popup_shown']=true;
            $edit =false;

            $uID = $uID==0?UID:$uID;

            $this->data['user']=$this->front_model->get_query_simple('*','dev_web_user',array('uID'=>$uID))->result_object()[0];
            $this->data['verification']=$this->front_model->get_query_simple('*','dev_web_user_verification',array('uID'=>$uID,'deleted'=>0))->result_object();
            //echo $this->data['verification']->uStatus;exit;

            if(!empty($this->data['verification']) && $this->data['verification'][0]->uStatus!=2)
            {
                $_SESSION['error']="Sorry, you're not allowed to edit this data because this is being reviewed";
                redirect(base_url().'dashboard');
                exit;
            }
            $this->data['verification'] = $this->data['verification'][0];


            if($this->data['verification']->uStatus)
            {
                $edit=true;
            }

            if(isset($_POST['uFname']))
            {

                $verif = array(
                    'uID'=>$uID,
                    'uFname'=>$this->input->post('uFname'),
                    'uLname'=>$this->input->post('uLname'),
                    'uMname'=>$this->input->post('uMname'),
                    'uDOB'=>$this->input->post('uDOB'),
                    'uPhone'=>$this->input->post('uPhone'),
                    'uEmployment'=>$this->input->post('uEmployment'),
                    'uGross'=>$this->input->post('uGross'),
                    'uContribute'=>$this->input->post('uContribute'),
                    'uETH'=>$this->input->post('uETH'),
                    'uCountry'=>$this->input->post('uCountry'),
                    'uZip'=>$this->input->post('uZip'),
                    'uCity'=>$this->input->post('uCity'),
                    'uState'=>$this->input->post('uState'),
                    'uStreet'=>$this->input->post('uStreet'),
                    'uApartment'=>$this->input->post('uApartment'),
                    'card_last_4_digits'=>$this->input->post('card_last_4_digits'),
                    'id_card_passport_number'=>$this->input->post('id_card_passport_number'),
                    'expiry_date'=>$this->input->post('expiry_date'),
                    
                  
                );

                $this->save_basic_info_if_not_saved($verif);


                if(!$edit)
                {
                    $verif['uStatus']=0;
                    $verif['datecreated']=date("Y-m-d H:i:s");
                    $verif['ip']=$_SERVER['REMOTE_ADDR'];

                    $verification_id = $this->front_model->add_query('dev_web_user_verification',$verif);

                    $this->insert_verification_docs($verification_id);
                    //$_SESSION['thankyou']="Your data has been submitted to verification.";
                    

                }
                else
                {
                    $this->remove_verification_docs($this->data['verification']->id);
                    $verif['uStatus']=0;



                    $this->db->where('id',$this->data['verification']->id)
                    ->update('dev_web_user_verification',$verif);
                    $this->insert_verification_docs($this->data['verification']->id);

                    $verification_id = $this->data['verification']->id;

                   // $_SESSION['thankyou']="Your data has been updated.";
                    

                }

                



                $this->verify_gbmstech_api($verification_id);





                //redirect(base_url().'/dashboard');
            }
            else
            {
                $this->load->view('frontend/verify_yourself_gbmstech',$this->data);
            }
    }
    public function verify_gbmstech_api($id)
    {
        $url        = $this->data['shufti_url'];
        $client_id  = $this->data['shufti_client_id'];
        $secret_key = $this->data['shufti_secret_key']; //Replace with your secret key provided by the Shufti Pro.


        $document_data = $this->db->where('id',$id)->get('dev_web_user_verification')->result_object()[0];
        $document_doc_parent = $this->db->where('v_id',$id)->get('dev_web_verification_docs')->result_object()[0];
        $document_docs = $this->db->where('parent',$document_doc_parent->id)->get('dev_web_verification_docs')->result_object();
        $country = $this->db->where('id',$document_data->uCountry)->get('dev_web_countries')->result_object()[0];
        $country = $country->iso;
        $address =  $document_data->uApartment.", ".$document_data->uStreet.", ".$document_data->uCity.", ".$document_data->uState.", ".$country;



        $verification_data["document_front_image"]=

            'data:image/'
            .$this->get_ext($document_doc_parent->doc_front)
            .';base64,'
            .base64_encode(
            file_get_contents(base_url()
            .'resources/uploads/verification/'
            .$document_doc_parent->doc_front
        ));
        $verification_data["document_back_image"]=
        'data:image/'
            .$this->get_ext($document_doc_parent->doc_back)
            .';base64,'
            .base64_encode(

            file_get_contents(base_url()
            .'resources/uploads/verification/'
            .$document_doc_parent->doc_back
        ));

        foreach($document_docs as $_document_doc)
        {
            if($_document_doc->type=="selfie")
            {
                 $verification_data["face_image"]=

                    'data:image/'
                    .$this->get_ext($_document_doc->selfie)
                    .';base64,'
                    .base64_encode(
                    
                    file_get_contents(base_url()
                    .'resources/uploads/verification/'
                    .$_document_doc->selfie

                ));
            }
            if($_document_doc->type=="bill")
            {
                 $verification_data["document_address_image"]=
                    'data:image/'
                    .$this->get_ext($_document_doc->bill)
                    .';base64,'
                    .base64_encode(

                    file_get_contents(base_url()
                    .'resources/uploads/verification/'
                    .$_document_doc->bill


                   ));
            }
        }
       
       $verification_data = json_encode($verification_data);
         
         

        $verification_services = array(
            "document_type"        => $document_doc_parent->document_type==1?"id_card":"passport",
            "document_id_no"       => $document_data->id_card_passport_number,
            "document_expiry_date" => date("Y-m-d",strtotime($document_data->expiry_date)),
            "address"              => $address,
            "first_name"           => $document_data->uFname,
            "middle_name"           => $document_data->uMname,
            "last_name"            => $document_data->uLname,
            "dob"                  => date("Y-m-d",strtotime($document_data->uDOB)),
            "background_checks"    => "0"
        );
        //JSON encode the services array
        $verification_services = json_encode($verification_services);
        $post_data = array(
            "client_id"            => $this->data['shufti_client_id'],
            "reference"            => $document_data->id.'_'.time(),
            "phone_number"         => $document_data->uPhone,
            "country"              => $country,
            // "callback_url"         => "http://example.com",
            "redirect_url"         => base_url().'ico/success_gbmstech_callback',
            "verification_services" => $verification_services,
            "verification_data"=>$verification_data,
        );
        ksort($post_data);//Sort the all request parameter.
        $raw_data = implode("", $post_data) . $secret_key;
        $signature              = hash("sha256", $raw_data);
        $post_data["signature"] = $signature;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        #Parse Response body
        $response = json_decode($response);
        #Verify Response signature
        $my_signature = hash("SHA256", $response->status_code . $response->message . $response->reference . $secret_key);
        if($my_signature == $response->signature){
            
            // print_r($response);exit;
            //     # Response is valid. Now you can redirect your customer if you receive status code SP2
            //     if($response->status_code == "SP2"){
            //         header("Location: " . $response->message);
            //     }
            //     else{

                    

            //         echo $_SESSION['error']=$response->message;

            //         // $this->redirect_back();
            //     }
            //     
            $this->success_gbmstech_callback($response);
        }
        else{

            $this->db->where('id',$id)->delete('dev_web_verification_docs');

             $_SESSION['error']="Response signature is invalid";
           
                    // $this->redirect_back();

        }
    }
    private function get_ext($name)
    {
        return explode('.',$name)[count(explode('.',$name))-1];
    }
    private function success_gbmstech_callback($response)
    {

         
        $arr = array(
            'status_code'=>$response->status_code,
            'message'=>$response->message,
            'reference'=>$response->reference,
            'signature'=>$response->signature,
        );


        if($response->status_code == "SP2" || $response->status_code=="SP1"){

            $uid = $this->db->where('id',explode('_',$response->reference)[0])->get('dev_web_user_verification')->result_object()[0]->uID;

            
            $this->db->where('id',explode('_',$response->reference)[0])->update('dev_web_user_verification',array('uStatus'=>1));

            $this->db->where('uID',$user_id)->update('dev_web_user',array('kyc_verified'=>1));
            $_SESSION['thankyou']="Verified Successfully!";
            $res['msg']="Verified Successfully!";
            redirect(base_url().'dashboard');
        }

        else{

            $this->db->where('id',explode('_',$response->reference)[0])->update('dev_web_user_verification',array('uStatus'=>2));
            $_SESSION['rejected_kyc']=$response;

            redirect(base_url().'kyc-rejected');

        }

        


      


    }
    public function kyc_rejected()
    {
        $this->load->view('frontend/kyc_rejected',$this->data);
    }
    private function save_basic_info_if_not_saved($basic)
    {
        $already = $this->db->where('uID',UID)->get('dev_web_user')->result_object()[0];

        if(!$already->uFname)
        {
            $user = array(
                'uFname'=>$basic['uFname'],
                'uLname'=>$basic['uLname'],
                'uWallet'=>$basic['uETH'],
                'uFname'=>$basic['uFname'],
                'uFname'=>$basic['uFname'],
                'uFname'=>$basic['uFname'],

                'uCountry'=>$basic['uCountry'],
                    'uZip'=>$basic['uZip'],
                    'uCity'=>$basic['uCity'],
                    'uState'=>$basic['uState'],
                    'uAddress'=>$basic['uApartment'].' '.$basic['uStreet'],
            );

            $this->db->where('uID',UID)->update('dev_web_user',$user);
          
            return true;
        }
    }
    public function _verify_yourself($uID=0)
    {
         if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {

            $this->data['on_verification_page']=true;
            

            $_SESSION['vf_popup_shown']=true;
            $edit =false;

            $uID = $uID==0?UID:$uID;

            $this->data['user']=$this->front_model->get_query_simple('*','dev_web_user',array('uID'=>$uID))->result_object()[0];
            $this->data['verification']=$this->front_model->get_query_simple('*','dev_web_user_verification',array('uID'=>$uID,'deleted'=>0))->result_object();
            //echo $this->data['verification']->uStatus;exit;

            if(!empty($this->data['verification']) && $this->data['verification'][0]->uStatus!=2)
            {
                $_SESSION['error']="Sorry, you're not allowed to edit this data because this is being reviewed";
                redirect(base_url().'dashboard');
                exit;
            }
            $this->data['verification'] = $this->data['verification'][0];


            if($this->data['verification']->uStatus)
            {
                $edit=true;
            }

            if(isset($_POST['uFname']))
            {

                $verif = array(
                    'uID'=>$uID,
                    'uFname'=>$this->input->post('uFname'),
                    'uLname'=>$this->input->post('uLname'),
                    'uMname'=>$this->input->post('uMname'),
                    'uDOB'=>$this->input->post('uDOB'),
                    // 'uPhone'=>$this->input->post('uPhone'),
                    'uEmployment'=>$this->input->post('uEmployment'),
                    'uGross'=>$this->input->post('uGross'),
                    'uContribute'=>$this->input->post('uContribute'),
                    'uETH'=>$this->input->post('uETH'),
                    'uCountry'=>$this->input->post('uCountry'),
                    'uZip'=>$this->input->post('uZip'),
                    'uCity'=>$this->input->post('uCity'),
                    'uState'=>$this->input->post('uState'),
                    'uStreet'=>$this->input->post('uStreet'),
                    'uApartment'=>$this->input->post('uApartment'),
                    
                  
                );


                if(!$edit)
                {
                    $verif['uStatus']=0;
                    $verif['datecreated']=date("Y-m-d H:i:s");
                    $verif['ip']=$_SERVER['REMOTE_ADDR'];

                    $verification_id = $this->front_model->add_query('dev_web_user_verification',$verif);

                    $this->insert_verification_docs($verification_id);
                    $_SESSION['thankyou']="Your data has been submitted to verification.";
                    redirect(base_url().'dashboard');

                }
                else
                {
                    $this->remove_verification_docs($this->data['verification']->id);
                    $verif['uStatus']=0;
                    $this->db->where('id',$this->data['verification']->id)
                    ->update('dev_web_user_verification',$verif);
                    $this->insert_verification_docs($this->data['verification']->id);

                    $_SESSION['thankyou']="Your data has been updated.";
                    redirect(base_url().'/dashboard');

                }



            }
            else
            {
                $this->load->view('frontend/verify_yourself',$this->data);
            }
        }

    }
    public function get_relevant_more_transaction_data()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE==1)
            {
                $post_arr = array(
                            'type'=>$this->input->post('type'),
                            'x'=>$this->input->post('x'),
                            'y'=>$this->input->post('y'),
                            );
                
                $forged_ = explode('GMT',$post_arr['x'])[0];
                $forged_ = str_replace(' 00:00:00 ','',$forged_);
                $forged_ = substr($forged_,4);
                
                $forged_ = date("Y-m-d",strtotime($forged_));


                $date = date('Y-m-d',strtotime($forged_));
                $this->data['date'] = $date;
              
                $this->db->where('DATE(datecreated)', $date);
               
                $this->data['trans'] = $this->db->get('dev_web_transactions')->result_object();

                $r= $this->load->view('frontend/common/more_table_trans',$this->data,true);
                

                echo $r;


            }
        }
    }
    public function first_login(){
        unset($_SESSION['first_login']);
        redirect($_SERVER["HTTP_REFERER"]);
    }
    public function manage_bonuses($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE==1)
            {
              

                $this->data['id']=$id;

                $this->load->view('frontend/admin_manage_bonuses',$this->data);
            }
        }
    }
    private function redirect_back()
    {
        redirect($_SERVER['HTTP_REFERER']);
        exit;
    }
    public function remove_bonus($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE==1)
            {
                

                $this->db->where('id',$id)->delete('dev_web_bonuses');
                $_SESSION['thankyou']="Deleted";
                $this->redirect_back();
            }
        }
    }
    public function add_bonus($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE==1)
            {
                
                if(isset($_POST['b_type']))
                {
                    $_SESSION['t']['b_type']=$this->input->post('b_type');
                    if($_SESSION['t']['b_type']==2)
                    {
                        redirect(base_url().'admin/manage-bonuses/'.$id);
                        exit;
                    }
                    redirect(base_url().'admin/add-bonus-step-2/'.$id);
                }
                else
                {
                    $this->data['id']=$id;
                    $this->load->view('frontend/add_token_pricing_bonus',$this->data);
                }


               
            }
        }
    }
     public function add_bonus_step_2($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE==1)
            {
                
                if(isset($_POST['bonus']))
                {


                    foreach($_POST['bonus'] as $key=>$val)
                    {
                        $arr=array(
                            'type'=>$_SESSION['t']['b_type'],
                            'bonus'=>$_POST['bonus'][$key],
                            'more_than'=>$_POST['min_invest'][$key]?$_POST['min_invest'][$key]:0,
                            'less_than'=>$_POST['max_invest'][$key]?$_POST['max_invest'][$key]:-1,
                            
                            'method'=>$_POST['a_type'][$key]?$_POST['a_type'][$key]:1,
                            'from_date'=>$_POST['start_date'][$key],
                            'end_date'=>$_POST['end_date'][$key],
                            'token_id'=>$id
                        );
                        $this->db->insert('dev_web_bonuses',$arr);

                    }



                  
                    $_SESSION['thankyou']="Bonus added successfully!";
                    redirect(base_url().'admin/manage-bonuses/'.$id);
                }
                else
                {
                    $this->data['id']=$id;
                    $this->load->view('frontend/add_token_pricing_bonus_level',$this->data);
                }


               
            }
        }
    }
    public function edit_bonus($id)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE==1)
            {
                $this->data['bonus']=$this->db->where('id',$id)->get('dev_web_bonuses')->result_object()[0];

                if(isset($_POST['bonus']))
                {
                    $arr = array(
                        'more_than'=>$this->input->post('more_than')>0?$this->input->post('more_than'):0,
                        'less_than'=>$this->input->post('less_than')>0?$this->input->post('less_than'):-1,
                        'bonus'=>$this->input->post('bonus'),
                    );
                    $this->db->where('id',$id)->update('dev_web_bonuses',$arr);
                    $_SESSION['thankyou']="Bonus added successfully!";
                    redirect(base_url().'admin/manage-bonuses/'.$this->data['bonus']->token_id);
                }
                else
                {
                    $this->load->view('frontend/edit_bonus',$this->data);
                }


               
            }
        }
    }
    public function whitelist()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE==1)
            {
                if(isset($_POST['save']))
                {
                    $arr = array(
                        'active'=>$this->input->post('active')==1?1:0,
                        'kyc'=>$this->input->post('kyc')==1?1:2,
                        'ability'=>$this->input->post('ability')?$this->input->post('ability'):1,
                        'registration_form'=>$this->input->post('registration_form')?$this->input->post('registration_form'):0,
                    );
                    $this->front_model->update_query('dev_web_whitelist',$arr,array());
                    $_SESSION['thankyou']="Setttings saved!";
                    $this->redirect_back();
                }
                else
                {
                    $this->data['whitelist']=$this->front_model->get_query_simple('*','dev_web_whitelist',array())->result_object()[0];
                    $this->load->view('frontend/whitelist',$this->data);

                }
            }
        }
    }
    public function please_wait()
    {
                    $this->load->view('frontend/please_wait',$this->data);

    }
    
     public function change_access($lvl,$uid)
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE==1)
            {
                

                $old = $this->front_model->get_query_simple('*','dev_web_user',array('uID'=>$uid))->result_object()[0];
                $decoded = json_decode($old->whitelist_settings);
                $decoded->ability = $lvl;


                    $arr = array(
                        'whitelist_settings'=>json_encode($decoded)
                    );
                    $this->front_model->update_query('dev_web_user',$arr,array('uID'=>$uid));
                    $_SESSION['thankyou']="Access changed!";
                    $this->redirect_back();
               
            }
        }
    }
    public function update_welcome_text()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE==1)
            {
                

               


                    $arr = array(
                        'welcome_heading'=>$this->input->post('welcome_heading'),
                        'welcome_body'=>$this->input->post('welcome_body'),
                    );
                    $this->front_model->update_query('dev_web_config',$arr,array());
                    $_SESSION['thankyou']="Text changed!";
                    $this->redirect_back();
               
            }
        }
    }
    // public function enable_two_factor_user()
    // {
    //     if(!isset($_SESSION['JobsSessions'])){
    //         header ( "Location:" . $this->config->base_url ()."login");
    //     }
    //     else {
              

               


    //                 $arr = array(
    //                     'enable_two_factor'=>1,
                       
    //                 );
    //                 $this->front_model->update_query('dev_web_user',$arr,array('uID'=>UID));
    //                 $_SESSION['thankyou']="2FA Enabled!";
    //                 $this->redirect_back();
               
            
    //     }
    // }
    // public function disable_two_factor_user()
    // {
    //     if(!isset($_SESSION['JobsSessions'])){
    //         header ( "Location:" . $this->config->base_url ()."login");
    //     }
    //     else {

    //             $arr = array(
    //                 'enable_two_factor'=>0,
                   
    //             );
    //             $this->front_model->update_query('dev_web_user',$arr,array('uID'=>UID));
    //             $_SESSION['thankyou']="2FA Disabled!";
    //             $this->redirect_back();
    //     }
    // }
    public function send_invoice($tid)
    {

        // echo 1;exit;

        require_once './vendor/autoload.php';

        $mpdf = new \Mpdf\Mpdf(['default_font_size' => 9,
    'default_font' => 'dejavusans']);
        $mpdf->WriteHTML($this->view_invoice_pdf($tid));
        // $mpdf->Output();
        $this->data['r']=$this->db->get('dev_web_receipt_data')->result_object()[0];
        $mpdf->SetHTMLFooter($this->data['r']->footer_text);
        
        $name_of_file = 'token_receipt_'.time().'_'.guid().'.pdf';




         // $mpdf->Output();



        $this->data['t']=$this->db->where('tID',$tid)->get('dev_web_transactions')->result_object()[0];


        $this->db->where('tID',$tid)->update('dev_web_transactions',array('receipt_name'=>$name_of_file));

        $this->data['u']=$this->db->where('uID',$this->data['t']->uID)->get('dev_web_user')->result_object()[0];

        $path='./resources/uploads/private_files/';
        $mpdf->Output($path.$name_of_file,'F');
        // $mpdf->Output();
        // exit;
        $user =$this->data['u'];

        $edata = $this->front_model->get_emails_data('receipt-token');
       
        $replace = array("[WEBURL]","[USER]","[WEBTITLE]");
        $replacewith = array(base_url(),  $user->uFname." ".$user->uLname,TITLEWEB);
        $str = str_replace($replace,$replacewith,$edata[0]->eContent);
         $message = $str;

       $r= $this->sendgrid_mail(array($user->uEmail,''),$message,$edata[0]->eName,WEBEMAIL,base_url().'resources/uploads/private_files/'.$name_of_file);
        return $r;



    }
    public function view_invoice_pdf($tid=0)
    {
        $this->data['t']=$this->db->where('tID',$tid)->get('dev_web_transactions')->result_object()[0];
        $this->data['c']=$this->db->where('id',$this->data['t']->currency)->get('dev_web_payment_options')->result_object()[0];
        $this->data['config']=$this->db->get('dev_web_config')->result_object()[0];

        $this->data['r']=$this->db->get('dev_web_receipt_data')->result_object()[0];
        $this->data['u']=$this->db->where('uID',$this->data['t']->uID)->get('dev_web_user')->result_object()[0];

        return $this->load->view('frontend/token_receipt',$this->data,true);
    }
    public function turn_on_syndication()
    {
        $this->is_logged();
        $this->is_admin();

        $this->db->update('dev_web_config',array('syndicate'=>1));
        $_SESSION['thankyou']="Syndication turned on";
        $this->redirect_back();
    }
    public function turn_off_syndication()
    {
        $this->is_logged();
        $this->is_admin();

        $this->db->update('dev_web_config',array('syndicate'=>0));
        $_SESSION['thankyou']="Syndication turned off";
        $this->redirect_back();
    }
    public function try_kcy_response($decoded_array)
    {


$decoded_array = json_decode($decoded_array);
$decoded_array = (array) $decoded_array;

 
$user_id = UID;
$this->db->where('uID',$user_id)->update('dev_web_user',array('kyc_mind'=>json_encode($decoded_array)));


                    $data_api_form = $decoded_array['form_data'];
                    $data_api_form =(array) $data_api_form;
                   

 $verif = array(
                    'uID'=>$user_id,
                    'uFname'=>$data_api_form['full_name'],
                    'uLname'=>$data_api_form['last_name'],
                    // 'uEmail'=>$data_api_form['email'],
                    'uDOB'=>$data_api_form['dob'],


                );
if($decoded_array['kyc_result']=="ACCEPT")
$verif['uStatus']=1;
elseif($decoded_array['kyc_result']=="MANUAL_REVIEW")
$verif['uStatus']=0;
else
$verif['uStatus']=2;
$verif['datecreated']=date("Y-m-d H:i:s");
$verif['ip']=$_SERVER['REMOTE_ADDR'];


 $this->db->insert('dev_web_user_verification',$verif);








if($decoded_array['kyc_result']=="ACCEPT")
{
    $this->db->where('uID',$user_id)->update('dev_web_user',array('kyc_verified'=>1));
    
}










}
    public function receipts($id="0")
    {
        if($id=="0")
        {
            $this->redirect_back();
        }

        $this->is_logged();
        $this->is_admin();

        $this->data['receipts'] = $this->db->where('receipt_name !=',"")->where('uID',$id)->get('dev_web_transactions')->result_object();
        $this->load->view('frontend/receipts',$this->data);


    }
    public function request_delete_account()
    {
        $uID = UID;

        $user = $this->front_model->get_query_simple('*','dev_web_user', array('uID'=>$uID))->result_object()[0];

        $edata = $this->front_model->get_emails_data('request-account-deletion');
        $this->load->library('email');
        $this->email->from($edata[0]->eEmail, TITLEWEB);
        $this->email->to($this->input->post('email'));
        $replace = array("[WEBURL]","[USER]","[WEBTITLE]","[EMAIL]","[USERNAME]");
        $replacewith = array(base_url(),  $user->uFname." ".$user->uLname,TITLEWEB,$user->uEmail,$user->uUsername);
        $str = str_replace($replace,$replacewith,$edata[0]->eContent);
         $message = $str;
        $this->email->subject($edata[0]->eName);
        $this->email->message($message);
        $this->email->set_mailtype("html");
        // $send = $this->email->send();
        $this->sendgrid_mail(array(WEBEMAIL,''),$message,$edata[0]->eName);


        $_SESSION['thankyou']="Account removal has be requested, you'll be contacted shortly";
        $this->redirect_back();

    }
    public function account_deletion_page()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "2"){
                
               $this->load->view('frontend/account_deletion_page',$this->data);
            }
        }
    }
    public function crypt_scrypt($string = "12345678")
    {
        require './vendor/autoload.php';

        $scrypt = new Scrypt();
        $securePass = $scrypt->create($string);

        return $securePass;
    }
    public function check_scrypt($hash = "44",$string = '12345678')
    {
       require './vendor/autoload.php';

        $scrypt = new Scrypt();
        $securePass =$hash;
        $password = $string;


        if ($scrypt->verify($password, $securePass)) {
            
           
            return true;
        } else { 
            return false;
        }
    }
    // public function next_camp($id){
    //     print_r(next_camp($id));
    // }
    public function activate_authy_for_admin(){
        $this->is_logged();
        $this->is_admin();

        $get_authy = $this->db->order_by('id','DESC')->limit(1)->get('dev_web_two_factor')->result_object()[0];

        if($get_authy->sid && $get_authy->skey && $get_authy->from_number)
        {
            $this->db->update('dev_web_two_factor',array('for_admin'=>1));
            $_SESSION['thankyou']="Authy for admin has been activated";
        }
        else{
            $_SESSION['error']="Please enter authy credentials first";
        }
        $this->redirect_back();

    }
    public function deactivate_authy_for_admin(){
        $this->is_logged();
        $this->is_admin();

        
            $this->db->update('dev_web_two_factor',array('for_admin'=>0));
            $_SESSION['thankyou']="Authy for admin has been de-activated";
        
        $this->redirect_back();

    }
    public function admin_affiliates()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
            if(ACTYPE == "1"){
                check_roles(1);

                $mult_ref = $this->data['web_settings']->multi_level_bonus_feature;

                if($mult_ref==1){
                    $this->load->view('frontend/admin_affiliates_multi', $this->data);
                }
                else{
                    $this->load->view('frontend/admin_affiliates', $this->data);
                }
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }
    public function do_referrel_settings()
    {
         $this->is_logged();
         $this->is_admin();
         check_roles(1);


      
            $data = array(
                'tokenawarded'  => $this->input->post('tokenreward'),
                'tokenTitle'    => $this->input->post('refpagetitle'),
                'tokenText'     => nl2br($this->input->post('desctiptitle')),
            );
            $condition = array();
            $this->front_model->update_query('dev_web_ref_setting',$data,$condition);
            $set_2=array('ref_helping_txt'=>$this->input->post('ref_helping_txt'));
            $this->front_model->update_query('dev_web_config',$set_2,array());
      


        $_SESSION['thankyou'] = "Referrel Information Updated Successfully!";
        header ( "Location:" . $this->config->base_url ()."admin/referral-settings");
    }
    public function do_referrel_settings_multi()
    {
         $this->is_logged();
         $this->is_admin();
         check_roles(1);


         $mult_ref = $this->data['web_settings']->multi_level_bonus_feature;

         if($mult_ref==1){


            $data = array(
                'levels'  => json_encode($_POST['level']),
                'tokenTitle'    => $this->input->post('refpagetitle'),
                'tokenText'     => nl2br($this->input->post('desctiptitle')),
            );
            $condition = array();
            $this->front_model->update_query('dev_web_ref_setting',$data,$condition);
            $set_2=array('ref_helping_txt'=>$this->input->post('ref_helping_txt'));
            $this->front_model->update_query('dev_web_config',$set_2,array());

         }
         else{


            $_SESSION['error']="This feature is not available";
            $this->redirect_back();
        }


        $_SESSION['thankyou'] = "Referrel Information Updated Successfully!";
        header ( "Location:" . $this->config->base_url ()."admin/referral-settings");
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
    public function add_level()
    {
        echo add_level();
    }
    private function do_referrel_work($arr,$uid){

        $tokens = $arr['tokens'];
        $myself = $this->db->where('uID',$uid)->get('dev_web_user')->result_object();
        if(empty($myself)) return false;

        $myself=$myself[0];
        $my_referrer = $this->db->where('uID',$myself->referrer)->get('dev_web_user')->result_object();

        if(empty($my_referrer)) return false;
        $my_referrer=$my_referrer[0];

        $get_percentage = $this->db->order_by('refID','DESC')->limit(1)->get('dev_web_ref_setting')->result_object();
        if(empty($get_percentage)) return false;
       
        $get_percentage=$get_percentage[0];
        $bonues = $tokens * ( $get_percentage->tokenawarded/100 );
        

        if($bonues<=0) return false;




         $mult_ref = $this->data['web_settings']->multi_level_bonus_feature;

        if($mult_ref==1)
            $this->handle_do_work_levels_bonus($myself->uID,$tokens);
        else
        $this->plus_the_bonus_please($bonues,$my_referrer->uID);











        return true;


    }
    private function plus_the_bonus_please($bonues,$ref_id)
    {
        $arr__ = array(
                        'tokens'=>$bonues,
                        'amountPaid'=>0,
                        'usdPayment'=>0,
                        'hash'=>guid(),
                        'status'=>2,
                        'datecreated'=>date("Y-m-d H:i:s"),
                        'uIP'=>$_SERVER['REMOTE_ADDR'],
                        'uID'=>$ref_id,
                        'transaction_id'=>guid(),
                        't_type'=>30
                    );

        $this->db->insert('dev_web_transactions',$arr__);






        $this->add_balance($ref_id,$bonues);
    }
    private function handle_do_work_levels_bonus($uid,$tokens)
    {
        $ref_settings =  $this->db->order_by('refID','DESC')->limit(1)->get('dev_web_ref_setting')->result_object()[0];

        $levels = $ref_settings->levels;
        if(strlen($levels))
        {

            $levels = json_decode($levels);

            if(!empty($levels))
            {

                $buyer_user = $this->db->where('uID',$uid)->get('dev_web_user')->result_object()[0];

                // $for

                foreach($levels as $level)
                {
                   

                    $bonues = $tokens * ( $level/100 );
                    $refed_by = $this->db->where('uID',$buyer_user->referrer)->get('dev_web_user')->result_object();
                    if($bonues<1) continue;
                    if(!empty($refed_by))
                    {

                        $this->plus_the_bonus_please($bonues,$refed_by[0]->uID);
                    }
                    $buyer_user = $refed_by[0];


                }
            }
        }
    }
    public function get_leve_div()
    {
        echo print_leve(array());
    }
    
    public function price_should_be($tokens)
    {
       
       echo "|";
         $total_tokens = $tokens;


        
                    $arr_con = array('id'=>$_SESSION['buy_step_1']['option']);
                   
                    $this->data['option']=$this->front_model->get_query_simple('*','dev_web_payment_options',$arr_con)->result_object()[0];
                   



        $this->data['active_token'] = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];

       if($this->data['active_token']->c_type==2){

                    if($total_tokens > ($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold ))
                    {
                        $from_first = ($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold);

                         $from_first_w = $from_first;



                        $from_second =$total_tokens - $from_first;

                         $from_second_w = $from_second;


                        if(next_token($this->data['active_token']->tkID))
                        {



                            $next_token = next_token($this->data['active_token']->tkID);

                             
                            if(!empty($next_token)){


                                $percent_ = (get_calculated_bonus($this->data['active_token']->tkID,$from_first,am_i('scia'))/100);
                                $total_tokens___b = $percent_ * $from_first;
                                // $from_first_bonus = $total_tokens___ + $from_first;

                                $percent_ = (get_calculated_bonus($next_token->tkID,$from_second,am_i('scia'))/100);
                                $total_tokens___ = $percent_ * $from_second;
                                $from_second = $total_tokens___ + $from_second;

                                $from_second = $from_second + $total_tokens___b;

                                $total_tokens = $from_first + $from_second;



                                $price_first = $from_first_w * $price_should_be;


                                $price_should_be_second = $next_token->tokenPrice;
                                    if($next_token->currency_type!="USD")
                                        $price_should_be_second=calculate_price_should_be($next_token);

                                if($this->data['web_settings']->charge_round==1){
                                    $second_price = $from_second * $price_should_be_second;
                                }
                                else
                                {
                                    $second_price = $from_second * $price_should_be;
                                }


                                $second_price = $from_second_w * $price_should_be_second;
                                $without_volitility = $price_first + $second_price;
                                $price_first = $this->add_volitility($price_first,$this->data['option']->volatility);
                                $second_price = $this->add_volitility($second_price,$this->data['option']->volatility);



                                $total_price = $price_first + $second_price;
                                $two_payments = true;
                            }

                            

                        }
                    }
                    else
                    {

                        $percent = (get_calculated_bonus($this->data['active_token']->tkID,$tokens,am_i('scia'))/100);
                        $total_tokens = $percent * $tokens;
                        $total_tokens = $total_tokens + $tokens;



                        // echo $total_tokens;exit;
                        $total_price = $total_tokens*$price_should_be;
                        $without_volitility = $total_price;
                        $total_price = $this->add_volitility($total_price,$this->data['option']->volatility);
                        echo $total_price;

                    }
                }
                    else{

                         $percent = (get_calculated_bonus($this->data['active_token']->tkID,$tokens,am_i('scia'))/100);
                        $total_tokens = $percent * $tokens;
                        $total_tokens = $total_tokens + $tokens;



                        // echo $total_tokens;exit;
                        $total_price = $_SESSION['buy_step_2']['amount']*$price_should_be;
                        $without_volitility = $total_price;
                        $total_price = $this->add_volitility($total_price,$this->data['option']->volatility);

                    }


                    return $total_price;
    }
    public function get_version_2_bonus($a=0)
    {
        $tokens = $_POST['tokens']?$_POST['tokens']:$a;

        $bonus = $this->get_version_2_bonus_part_2($tokens);
         
        echo $tokens + ($tokens * ($bonus/100));
    }
    private function _get_price_should_be_calculator($tokens,$token_id)
    {
        $this->data['active_token']=$this->front_model->get_query_simple('*','dev_web_token_pricing',array('tkID'=>$token_id))->result_object()[0];


        $price_should_be=$this->data['active_token']->tokenPrice;
        if($this->data['active_token']->currency_type!="USD")
            $price_should_be=calculate_price_should_be($this->data['active_token']);
        return $price_should_be*$tokens;
        

    }
   
    private function get_version_2_bonus_part_2($tokens,$tok="0")
    {

        if($tok=="0")
        $active_token = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
        else
        $active_token = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('tkID'=>$tok))->result_object()[0];

        $price_should_be = $this->_get_price_should_be_calculator($tokens,$active_token->tkID);



        $all_bonuses = $this->db->where('token_id',$active_token->tkID)->order_by('type','ASC')->get('dev_web_bonuses')->result_object();
        if(empty($all_bonuses))
        {

           return 0;
        }


        
        foreach($all_bonuses as $bonus)
        {
            
                $now_date = time();

                $start_date = strtotime(date("Y-m-d H:i:s",strtotime($bonus->from_date)));
                $end_date = strtotime(date("Y-m-d H:i:s",strtotime($bonus->end_date)));


               
                    if(($now_time>=$start_date && $now_time<=$end_date) || !$bonus->start_date || $bonus->start_date == "0000-00-00")
                    {
                        
                        if($bonus->type==1){
                            $selected = $bonus;                           
                        }
                        else
                        {

                             if($bonus->method==1){
                                if($bonus->more_than<=$tokens && $bonus->less_than>=$tokens)
                                    $selected = $bonus;
                            }
                            else
                            {
                                if($bonus->more_than>=$price_should_be && $bonus->less_than<=$price_should_be)
                                    $selected = $bonus;
                            }
                            
                        }
                    }
                
                
            
        }


        return $selected->bonus;
        
        // if($tok=="0")
        // {
        //     $tok = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0]->tkID;
        // }

        // $price_should_be = $this->_get_price_should_be_calculator($tokens,$tok);
        // if($tok=="0")
        // $active_token = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
        // else
        // $active_token = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('tkID'=>$tok))->result_object()[0];


        // $all_bonuses = $this->db->where('token_id',$active_token->tkID)->order_by('type','ASC')->get('dev_web_bonuses')->result_object();
        // if(empty($all_bonuses))
        // {


        //    return 0;
        // }
       
        // $type_one = 0;
        // $type_two = 0;

        
        // foreach($all_bonuses as $k=>$bonus)
        // {

        //     $now_date = time();
        //     $now_time = $now_date;
            

        //     $start_date = strtotime(date("Y-m-d H:i:s",strtotime($bonus->from_date)));
        //     $end_date = strtotime(date("Y-m-d H:i:s",strtotime($bonus->end_date)));



        //         if(!$start_date || $start_date == "0000-00-00")
        //         {


                    
        //             if($bonus->type==1){

        //                 $type_one = $bonus->bonus;
                        
        //             }
        //             if($bonus->type==3){
                    

        //                 if($bonus->method==1){
        //                     if($bonus->more_than<=$tokens)
        //                     {
        //                         if($bonus->less_than<=0 || !$bonus->less_than || $bonus->less_than>=$tokens)
        //                         $type_two = $bonus->bonus;
        //                     }
        //                 }
        //                 else
        //                 {
        //                     if($bonus->more_than>=$price_should_be)
        //                         if($bonus->less_than<=$price_should_be || !$bonus->less_than || $bonus->less_than<=0)
        //                         $type_two = $bonus->bonus;
        //                 }
                        
        //             }
        //         }
              
        //         if(($now_time>=$start_date && $now_time<=$end_date) && ($start_date && $start_date != "0000-00-00"))
        //         {

                     
                    

        //             if($bonus->type==1){
                       
        //                 $type_one = $bonus->bonus;
        //             }
        //             if($bonus->type==3){


                    
                       
        //                 if($bonus->method==1){
        //                     if($bonus->more_than<=$tokens)
        //                     {
        //                         if($bonus->less_than<=0 || !$bonus->less_than || $bonus->less_than>=$tokens)
        //                         $type_two = $bonus->bonus;
        //                     }
        //                 }
        //                 else
        //                 {
        //                     if($bonus->more_than>=$price_should_be)
        //                         if($bonus->less_than<=$price_should_be || !$bonus->less_than || $bonus->less_than<=0)
        //                         $type_two = $bonus->bonus;
        //                 }
                        
        //             }
        //         }
               
                
                
            
        // }
        



        // return $type_one + $type_two;

        
    }
    public function kyc_options()
    {
        if(!isset($_SESSION['JobsSessions'])){
            header ( "Location:" . $this->config->base_url ()."login");
        }
        else {
             check_roles(1);



            $arr = array();
            $config     = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
            $this->data['countries']    = $config->result_object();
            if(ACTYPE == "1"){
                if(isset($_POST['url']))
                {
                    $this->db->update('dev_web_kyc_apis',array('active'=>0));

                    $array = array(
                        'url'=>$this->input->post('url'),
                        'active'=>1,
                        'public_key'=>$this->input->post('public_key'),
                        'private_key'=>$this->input->post('private_key'),
                        'form_id'=>$this->input->post('form_id'),
                       
                    );
                    
                    $condition = array("id" => $this->input->post('option_id'));

                    
                        $this->front_model->update_query('dev_web_kyc_apis',$array,$condition);
                        $_SESSION['thankyou'] = "Information updated successfully!";
                  
                    
                    $this->redirect_back();
                }
                else
                {
                    $this->data['options']=$this->front_model->get_query_simple('*','dev_web_kyc_apis',array())->result_object();
                   
                    $this->load->view('frontend/kyc_options', $this->data);
                }
            } else {
                $this->load->view('frontend/home', $this->data);
            }
        }
    }

    function inactive_kyc_option()
    {
         $this->is_logged();
         $this->is_admin();
         check_roles(1);
        $id = $this->input->post('id');
        $condition = array("id" => $this->input->post('id'));
        $this->front_model->update_query('dev_web_kyc_apis',array('active'=>0),$condition);
    }
    public function hide_bounties($do)
    {
        $this->is_logged();
         $this->is_admin();
         check_roles(1);
        $this->front_model->update_query('dev_web_config',array('hide_bounties'=>$do),array());
        $_SESSION['thankyou'] = "Information updated successfully!";
        $this->redirect_back();
    }
    public function hide_airdrop($do)
    {
        $this->is_logged();
         $this->is_admin();
         check_roles(1);
        $this->front_model->update_query('dev_web_config',array('hide_airdrop'=>$do),array());
        $_SESSION['thankyou'] = "Information updated successfully!";
        $this->redirect_back();
    }
    public function hide_ref($do)
    {
        $this->is_logged();
         $this->is_admin();
         check_roles(1);
        $this->front_model->update_query('dev_web_config',array('hide_ref'=>$do),array());
        $_SESSION['thankyou'] = "Information updated successfully!";
        $this->redirect_back();
    }
    public function converter_step_2()
    {
        $active_token=$this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];


        $price_should_be=$active_token->tokenPrice;
        if($active_token->currency_type!="USD")
            $price_should_be=calculate_price_should_be($active_token);
        $price_should_be=$price_should_be;

       //echo $price_should_be;exit;
        if($_POST['type']==1)
        {
            //tokens to usd
            echo $_POST['amount'] . " tokens = " . ($price_should_be*$_POST['amount']) . " USD";
            exit;
        }
        if($_POST['type']==2)
        {
            //usd to tokens
             echo $_POST['amount'] . " USD = " . ($_POST['amount']/$price_should_be) . " tokens";
            exit;
        }

    }
    public function dismiss_alert($id)
    {
         $this->is_logged();
         $this->is_admin();
         $this->db->where('id',$id)->update('dev_web_alerts',array('status'=>0));
         $this->redirect_back();
    }
    public function interested_alert($id)
    {
         $this->is_logged();
         $this->is_admin();



         $alert = $this->db->where('id',$id)->get('dev_web_alerts')->result_object()[0];

            $emails = explode(',',$alert->emails);

            foreach($emails as $email)
            {
                $this->trigger_team_email($email,$alert);
            }





         $this->db->where('id',$id)->update('dev_web_alerts',array('status'=>0));
         $this->redirect_back();
    }

    private function trigger_team_email($email,$alert)
    {

        $edata = $this->front_model->get_emails_data('dashboard-alerts');
        $this->load->library('email');
        $this->email->from($edata[0]->eEmail, TITLEWEB);
        $this->email->to($email);
        $replace = array("[WEBURL]","[WEBTITLE]","[IURL]","[TITLE]", "[TIME]","[ADMINEMAIL]");
        $replacewith = array(base_url(), TITLEWEB,base_url(). ' ' . TITLEWEB, $alert->title,$alert->created_at,WEBEMAIL);
        $str = str_replace($replace,$replacewith,$edata[0]->eContent);
         $message = $str;
        $this->email->subject($edata[0]->eName);
        $this->email->message($message);
        $this->email->set_mailtype("html");
        // $send = $this->email->send();
        $this->sendgrid_mail(array($email,''),$message,$edata[0]->eName);
    }
    public function save_eth()
    {
        $this->is_logged();
        $eth = $this->input->post('eth');
        $this->db->where('uID',UID)->update('dev_web_user',array('uWallet'=>$eth));
        $_SESSION['thankyou']="Updated!";
        $this->redirect_back();
    }
    public function language_settings()
    {
        $this->is_logged();
        $this->is_admin();
        if(isset($_POST['default_lang']))
        {
            $arr = array(
                'default_lang'=>$this->input->post('default_lang'),
                'allowed_langs'=>implode(',',$_POST['allowed_langs']),
            );

            $this->db->update('dev_web_config',$arr);
            $_SESSION['thankyou']="Changes Saved!";
            $this->redirect_back();
        }
        else
        {
            $this->load->view('frontend/language_settings',$this->data);
        }
    }
    public function edit_payment_option($id)
    {
        $this->is_logged();
        $this->is_admin();
        check_roles(1);

        $this->data['id']=$id;




            $arr = array();
            $config     = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
            $this->data['countries']    = $config->result_object();


        if(isset($_POST['type']))
        {
            $array = $this->process_payment_option();
            $condition = array("id" => $this->input->post('option_id'));

           
            $this->front_model->update_query('dev_web_payment_options',$array,$condition);
            $_SESSION['thankyou'] = "Information updated successfully!";
          

            
            redirect(base_url().'admin/payment-settings');
        }
        else
        {
            $this->load->view('frontend/edit_payment_option',$this->data);
        }
    }
    public function add_payment_option()
    {
        $this->is_logged();
        $this->is_admin();
        check_roles(1);
        if($this->data['web_settings']->allowed_to_add_payment!=1)
        {
           // $this->redirect_back();
           // exit;
        }

        $this->data['id']=$id;




            $arr = array();
            $config     = $this->front_model->get_query_simple('*','dev_web_countries',$arr);
            $this->data['countries']    = $config->result_object();


        if(isset($_POST['type']))
        {
            $array = $this->process_payment_option();            
            $array['type']=$this->input->post('type');
            
            $this->front_model->add_query('dev_web_payment_options',$array);
            $_SESSION['thankyou'] = "Information added successfully!";
           

            
            redirect(base_url().'admin/payment-settings');
        }
        else
        {
            $this->load->view('frontend/add_payment_option',$this->data);
        }
    }
    private function process_payment_option()
    {
        $array = array(
                'address'=>$this->input->post('address'),
                'name'=>$this->input->post('name'),
                'icon'=>$this->input->post('icon'),
                'active'=>1,
                'time_active'=>$this->input->post('active_time')==1?1:0,
                'count_down'=>$this->input->post('time'),
                'min_amount'=>$this->input->post('min_amount'),
                'max_amount'=>$this->input->post('max_amount'),
                'allowed_country'=>implode(',',$this->input->post('allowed_country')),
                'one_per_trans'=>$this->input->post('one_per_trans')?$this->input->post('one_per_trans'):0,
                'icon'=>$this->input->post('icon'),
            );
            if($this->input->post('type')==2)
            {
                $array = array(
                    'icon'=>$this->input->post('icon'),
                    'name'=>$this->input->post('name'),
                    'api_key'=>$this->input->post('api_key'),
                    'secret_key'=>$this->input->post('api_secret'),
                    'min_amount'=>$this->input->post('min_amount'),
                    'max_amount'=>$this->input->post('max_amount'),
                'allowed_country'=>implode(',',$this->input->post('allowed_country')),

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
                    'account__address'=>$this->input->post('account__address'),
                    'account__phone_number'=>$this->input->post('account__phone_number'),
                    'account_number'=>$this->input->post('account_number'),
                    'routing_number'=>$this->input->post('routing_number'),
                    'swift_code'=>$this->input->post('swift_code'),
                    'iban'=>$this->input->post('iban'),
                    'min_amount'=>$this->input->post('min_amount'),
                    'max_amount'=>$this->input->post('max_amount'),
                    'allowed_country'=>implode(',',$this->input->post('allowed_country')),

                    'active'=>1
                );
            }

            if($this->input->post('type')==4)
            {
                $array = array(
                    
                    'receiver_full_name'=>$this->input->post('receiver_full_name'),
                    'receiver_city'=>$this->input->post('receiver_city'),
                    'receiver_country'=>$this->input->post('receiver_country'),
                    'receiver_state'=>$this->input->post('receiver_state'),
                    'min_amount'=>$this->input->post('min_amount'),
                    'max_amount'=>$this->input->post('max_amount'),
                    'allowed_country'=>implode(',',$this->input->post('allowed_country')),
                    'active'=>1
                );
            }
            if($this->input->post('type')==5)
            {
                $array = array(
                    
                    'receiver_full_name'=>$this->input->post('receiver_full_name'),
                    'receiver_city'=>$this->input->post('receiver_city'),
                    'receiver_country'=>$this->input->post('receiver_country'),
                    'receiver_state'=>$this->input->post('receiver_state'),
                    
                    'min_amount'=>$this->input->post('min_amount'),
                    'max_amount'=>$this->input->post('max_amount'),
                    'allowed_country'=>$implode(',',$this->input->post('allowed_country')),
                    'active'=>1
                );
            }
            if($array['name']=="")
                unset($array['name']);
            $array['volatility']=$this->input->post('volatility');

            if(!$array['allowed_country'] || $array['allowed_country']=='')
                $array['allowed_country']=0;

            if(isset($_POST['type']))
                $array['type']=$this->input->post('type');

            return $array;
    }
    private function handle_tib_kyc()
    {
        if(!am_i('tib'))
        {
            redirect('/');
            exit;
        }
        $this->data['on_verification_page']=true;
    

        $_SESSION['vf_popup_shown']=true;
        $edit =false;

        if(isset($_POST['submit']))
        {
            $_SESSION['kyc_tib']['step_1']=$_POST;
            redirect(base_url().'verify-kyc/step-2');

        }
        else
        {
            $this->load->view('frontend/kyc_tib_step_1',$this->data);

        }
    }
    public function verify_kyc_2()
    {
        if(!am_i('tib') || $_SESSION['kyc_tib']['step_1']['step_1_agree']!=1)
        {
            redirect('/');
            exit;
        }
        $this->data['on_verification_page']=true;
        $_SESSION['vf_popup_shown']=true;

        if(isset($_POST['submit']))
        {
            $_SESSION['kyc_tib']['step_2']=$_POST;
            
            $arr = array(
                'uFname'=>$this->input->post('uFname'),
                'uLname'=>$this->input->post('uLname'),
                'uEmail'=>$this->input->post('uEmail'),
                'uDOB'=>date("Y-m-d",strtotime($this->input->post('uDOB'))),
                'uAddress'=>$this->input->post('uAddress'),
                'uZip'=>$this->input->post('uZip'),
                'uCity'=>$this->input->post('uCity'),
                'uState'=>$this->input->post('uState'),
                'uStreet'=>$this->input->post('uStreet'),
                'uApartment'=>$this->input->post('uApartment'),
                'uCountry'=>$this->input->post('uCountry'),
                'uNationality'=>$this->input->post('uNationality'),
                'uEmployment'=>$this->input->post('uEmployment'),
                'ip'=>$_SERVER['REMOTE_ADDR'],
                'uStatus'=>0,
                'datecreated'=>date("Y-m-d H:i:s"),
                'uID'=>UID,

            );
                // print_r($arr);exit;
            if($_SESSION['kyc_tib']['already_have']==0){
                $id = $this->db->insert('dev_web_user_verification',$arr);
                $id = $this->db->insert_id();
            }
            else
            {
                $id = $_SESSION['kyc_tib']['already_have_id'];


                $this->db->where('id',$id)->update('dev_web_user_verification',$arr);
            }

            $_SESSION['kyc_tib']['on_goin_kyc']=$id;

            $this->email_to_verify_verification_email($id);

            redirect(base_url().'kyc-enter-verification-code');
            exit;


        }
        else
        {
            $vf = $this->db->where('uID',UID)->get('dev_web_user_verification')->result_object();
            if(!empty($vf))
            {
                $_SESSION['kyc_tib']['already_have']=1;
                $_SESSION['kyc_tib']['already_have_id']=$vf[0]->id;
                $this->data['old_data']=$vf[0];
            }
            else
            {
                $_SESSION['kyc_tib']['already_have']=0;
            }
            


            $this->load->view('frontend/kyc_tib_step_2',$this->data);

        }
    }
    public function kyc_enter_verification_code()
    {
        if(!am_i('tib'))
        {
            redirect('/');
            exit;
        }
        $this->data['on_verification_page']=true;
        $_SESSION['vf_popup_shown']=true;

        if(isset($_POST['submit']))
        {
            $code = $this->input->post('code');

            $vf = $this->db->where('vCode',$code)->get('dev_web_user_verification')->result_object();

            if(!empty($vf))
            {
                $this->db->where('id',$vf[0]->id)->update('dev_web_user_verification',array('verify_email'=>1));
                $_SESSION['kyc_tib']['on_goin_kyc']=$vf[0]->id;

                redirect(base_url().'verify-kyc/step-3');
            }
            else
            {
                $_SESSION['error']="Invalid code, please try again";
                $this->redirect_back();
                exit;
            }


            // redirect(base_url().'verify-kyc/step-3');

        }
        else
        {
            $this->load->view('frontend/kyc_enter_verification_code',$this->data);

        }
    }
    public function verify_kyc_3()
    {
        if(!am_i('tib'))
        {
            redirect('/');
            exit;
        }
        $this->data['on_verification_page']=true;
        $_SESSION['vf_popup_shown']=true;

        if(isset($_POST['submit']))
        {
            $_SESSION['kyc_tib']['step_3']['docs']=$_SESSION['v'];

            $this->insert_verification_docs($_SESSION['kyc_tib']['on_goin_kyc']);
           
            redirect(base_url().'verify-kyc/step-4');

        }
        else
        {
            
            $this->load->view('frontend/kyc_tib_step_3',$this->data);
        }
    }
    private function email_to_verify_verification_email($id)
    {
        $this->data['on_verification_page']=true;
        $_SESSION['vf_popup_shown']=true;
        $vf = $this->db->where('id',$id)->get('dev_web_user_verification')->result_object()[0];
        $user = $this->front_model->get_query_simple('*','dev_web_user', array('uID'=>UID))->result_object()[0];

        $new_code = $this->generateRandomString(6);

        $this->db->where('id',$id)->update('dev_web_user_verification',array('vCode'=>$new_code));

        $edata = $this->front_model->get_emails_data('kyc-email-verification');
       
        $replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]","[VERIFYEMAILLINK]");
        $replacewith = array(base_url(), $new_code, $vf->uFname." ".$vf->uLname,TITLEWEB,base_url().'kyc-verify-email/'.$new_code);
        $str = str_replace($replace,$replacewith,$edata[0]->eContent);
         $message = $str;
       
        $this->sendgrid_mail(array($vf->uEmail,''),$message,$edata[0]->eName);

    }
    public function kyc_verify_email($code)
    {
        $this->data['on_verification_page']=true;
        $_SESSION['vf_popup_shown']=true;
        $vf = $this->db->where('vCode',$code)->get('dev_web_user_verification')->result_object();

        if(!empty($vf))
        {
            $this->db->where('id',$vf[0]->id)->update('dev_web_user_verification',array('verify_email'=>1));
            $_SESSION['kyc_tib']['on_goin_kyc']=$vf[0]->id;

            redirect(base_url().'verify-kyc/step-3');
        }
        else
        {
            redirect('/');
            exit;
        }
    }
    public function verify_kyc_4()
    {
        $this->data['on_verification_page']=true;
        $_SESSION['vf_popup_shown']=true;
        if(!am_i('tib'))
        {
            redirect('/');
            exit;
        }

        if(isset($_POST['submit']))
        {
           $arr = array(
       
            'step_4_answer'=>$this->input->post('step_4_q_1'),
           
           );
           $this->db->where('id',$_SESSION['kyc_tib']['on_goin_kyc'])->update('dev_web_user_verification',$arr);

           

           $arr = array(
            'q_id'=>'step_4_q_2',
            'accepted'=>$this->input->post('step_4_q_2')==1?1:0,
            'vf_id'=>$_SESSION['kyc_tib']['on_goin_kyc']
           );
           $this->db->insert('dev_web_user_vf_accepeted_qs_tib',$arr);

           $arr = array(
            'q_id'=>'step_4_q_3',
            'accepted'=>$this->input->post('step_4_q_3')==1?1:0,
            'vf_id'=>$_SESSION['kyc_tib']['on_goin_kyc']
           );
           $this->db->insert('dev_web_user_vf_accepeted_qs_tib',$arr);

           $arr = array(
            'q_id'=>'step_4_q_4',
            'accepted'=>$this->input->post('step_4_q_4')==1?1:0,
            'vf_id'=>$_SESSION['kyc_tib']['on_goin_kyc']
           );
           $this->db->insert('dev_web_user_vf_accepeted_qs_tib',$arr);

           $arr = array(
            'q_id'=>'step_4_q_5',
            'accepted'=>$this->input->post('step_4_q_5')==1?1:0,
            'vf_id'=>$_SESSION['kyc_tib']['on_goin_kyc']
           );
           $this->db->insert('dev_web_user_vf_accepeted_qs_tib',$arr);

           $arr = array(
            'q_id'=>'step_4_q_6',
            'accepted'=>$this->input->post('step_4_q_6')==1?1:0,
            'vf_id'=>$_SESSION['kyc_tib']['on_goin_kyc']
           );
           $this->db->insert('dev_web_user_vf_accepeted_qs_tib',$arr);

           $this->db->where('id',$_SESSION['kyc_tib']['on_goin_kyc'])->update('dev_web_user_verification',array('accepted_qs'=>1));






           unset($_SESSION['kyc_tib']);
           redirect(base_url().'kyc-recorded');
           exit;

        }
        else
        {
            $this->load->view('frontend/kyc_tib_step_4',$this->data);

        }
    }
    public function kyc_recorded()
    {
        $this->data['on_verification_page']=true;
        $_SESSION['vf_popup_shown']=true;
        if(!am_i('tib'))
        {
            redirect('/');
            exit;
        }

        $vf = $this->db->where('uID',UID)->get('dev_web_user_verification')->result_object();

        if(empty($vf) || $vf[0]->verify_email!=1 || $vf[0]->accepted_qs!=1)
        {
            redirect(base_url());
            exit;
        }




        $this->load->view('frontend/kyc_recorded',$this->data);
    }
    public function kyc_better_luck_next_time()
    {
        $this->data['on_verification_page']=true;
        $_SESSION['vf_popup_shown']=true;
       if(!am_i('tib'))
        {
            redirect('/');
            exit;
        }


        $this->load->view('frontend/kyc_better_luck_next_time',$this->data); 
    }
    public function set_kyc_lang($lang)
    {
        $this->data['on_verification_page']=true;
        $_SESSION['vf_popup_shown']=true;
        $_SESSION['kyc_lang']=$lang;
        $this->redirect_back();
    }
    public function buy_tokens_general_terms()
    {
        $this->data['on_verification_page']=true;
        $_SESSION['vf_popup_shown']=true;
        if(!am_i('tib'))
        {
            redirect('/');
            exit;
        }




                    $trans_id = guid();
                    $this->data['trans_id']=$trans_id;
                    $_SESSION['trans_id']=$trans_id;
                    $this->data['option']=$this->front_model->get_query_simple('*','dev_web_payment_options',array('id'=>$_SESSION['buy_tokens_tib']['step_2']['currency']))->result_object()[0];


                    $address = $this->get_latest_address($this->data['option']->id);
                    $_SESSION['transaction_address']=$address;
                    $this->data['address']=$address;




                    $this->data['active_token']=$this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
                    $this->data['active_camp_']=$this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$this->data['active_token']->ico_camp))->result_object()[0];

                    $price_should_be=$this->data['active_token']->tokenPrice;
                    if($this->data['active_token']->currency_type!="USD")
                        $price_should_be=calculate_price_should_be($this->data['active_token']);
                    $this->data['price_should_be']=$price_should_be;
                    

                    $converting = convert_curr($this->data['option']->c_name);
                    $converting = json_decode($converting,true);
                    foreach($converting as $cc)
                        $converting = $cc;
                    // print_r($converting);exit;
                    $_SESSION['by']['conversion_rate']=$converting;
                    
                    $arr = array(
                        'transaction_id'=>$trans_id,
                        'address'=>$address,
                        'currency'=>$this->data['option']->name,
                        'price_per_token'=>$price_should_be,
                        'total_tokens'=>$_SESSION['buy_tokens_tib']['step_2']['amount_of_tokens'],
                        'amount_paid'=>$_SESSION['buy_tokens_tib']['step_2']['amount_of_tokens']*$price_should_be
                    );





                   
                    $arr['amount_paid'] = $this->add_volitility($arr['amount_paid'],$this->data['option']->volatility);




                    ////if tokens ended
                    $two_payments = false;
                    $total_tokens = $arr['total_tokens'];


                    if($total_tokens > ($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold ) && $this->data['active_token']->c_type==1)
                    {
                         $_SESSION['error']="Sorry, we don't have sufficient tokens. You can only purchase ".($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold)." tokens for now. Please contact administration at ".WEBEMAIL." for further details";
                            $this->redirect_back();
                    }
                    if($total_tokens > ($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold ) && !am_i('lib'))
                    {
                         $_SESSION['error']="Sorry, we don't have sufficient tokens. You can only purchase ".($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold)." tokens for now. Please contact administration at ".WEBEMAIL." for further details";
                            $this->redirect_back();
                    }


                   

                    if($total_tokens > ($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold ) && $this->data['active_token']->c_type==2)
                    {

                    
                        $from_first = ($this->data['active_token']->tokenCap - $this->data['active_token']->tokens_sold);

                        $from_second =$total_tokens - $from_first;

                        if(next_token($this->data['active_token']->tkID))
                        {


                            $next_token = next_token($this->data['active_token']->tkID);
                            if(!empty($next_token)){
                                $price_first = $from_first * $price_should_be;



                                $price_should_be_second=$next_token->tokenPrice;
                                if($next_token->currency_type!="USD")
                                    $price_should_be_second=calculate_price_should_be($next_token);
                                $this->data['price_should_be_second']=$price_should_be_second;

                                if($this->data['web_settings']->charge_round==1){
                                    $second_price = $from_second * $price_should_be_second;
                                }
                                else
                                {
                                    $second_price = $from_second * $price_should_be;
                                }

                                

                                $price_first = $this->add_volitility($price_first,$this->data['option']->volatility);
                                $second_price = $this->add_volitility($second_price,$this->data['option']->volatility);

                                $total_price = $price_first + $second_price;
                                $arr['amount_paid'] = $total_price;
                                $two_payments = true;
                            }
                            else{
                                $_SESSION['error']="Sorry, we don't have sufficient tokens. Please contact administration at ".WEBEMAIL." for further details";
                                $this->redirect_back();
                            }

                            

                        }
                        else{
                            $_SESSION['error']="Sorry, we don't have sufficient tokens. Please contact administration at ".WEBEMAIL." for further details";
                            $this->redirect_back();
                        }

                    }

                   

                    

              






                 
                    // echo $arr['amount_paid']; exit;
                    $this->data['__usd_required']=$arr['amount_paid'];
                     $crypto_required = $arr['amount_paid']*$converting;
                    $_SESSION['crypto_required']=$crypto_required;
                    $this->data['crypto_required']=$crypto_required;












        $this->load->view('frontend/buy_tokens_general_terms',$this->data);
    }
    public function view_transaction($id)
    {
        $this->is_logged();
        $this->is_admin();
        check_roles(3);
        $this->data['trans']=$this->db->where('tID',$id)->get('dev_web_transactions')->result_object()[0];
        $this->data['trans_user']=$this->db->where('uID',$this->data['trans']->uID)->get('dev_web_user')->result_object()[0];
        $this->data['trans_template']=$this->db->where('tkID',$this->data['trans']->template_used)->get('dev_web_token_pricing')->result_object()[0];
        $this->data['trans_camp']=$this->db->where('id',$this->data['trans']->camp_used)->get('dev_web_ico_settings')->result_object()[0];
        // echo $this->db->last_query();

        // print_r($this->data['trans_camp']);exit;

        $this->load->view('frontend/view_transaction',$this->data);
    }
    public function edit_sale_bar()
    {
        $this->is_logged();
        $this->is_admin();



        if($this->data['web_settings']->allow_sale_bar!=1)
        {
            $_SESSION['error']="Sorry, you can't access this function";
            $this->redirect_back();
        }

        $sale_bar = $this->db->get('dev_web_sale_bar')->result_object()[0];

        $this->data['sale_bar']=$sale_bar;


        if(isset($_POST['max_cap'])){
            $ar = array(
                'sale_active'=>$this->input->post('sale_active')==1?1:0,
                'max_cap'=>$this->input->post('max_cap'),
                'tokens_sold'=>$this->input->post('tokens_sold')


            );
            $this->db->update('dev_web_sale_bar',$ar);
            $_SESSION['thankyou']="Settings saved successfully!";
            $this->redirect_back();

        }
        else
        {
            $this->load->view('frontend/edit_sale_bar',$this->data);
        }
    }
    public function save_veriff_resp()
    {
        $_SESSION['veriff_response']=$_REQUEST;
        echo ($_SESSION['veriff_response']['data']['verification']['url']);
    }
    public function veriff_callback()
    {
        $_SESSION['thankyou']="Your request is being reviewed";
        redirect(base_url().'dashboard');
    }
    public function veriff_callback_decision()
    {
        $r = (file_get_contents("php://input"));


        $data = json_decode($r);
         

        $verif = array(
                    'uID'=>$data->verification->person->idNumber,
                    'uFname'=>$data->verification->person->firstName,
                    'uLname'=>$data->verification->person->lastName,
                    'uCity'=>$data->verification->person->citizenship,
                   
                    
                  
                );
               
        $verif['uStatus']=$data->status=="approved"?1:0;
        $verif['datecreated']=date("Y-m-d H:i:s");
        $verif['ip']=$data->technicalData->ip;

        $this->front_model->add_query('dev_web_user_verification',$verif);
      
    }
    public function thank_you_for_your_purchase()
    {
         if(isset($_SESSION['JobsSessions']))
        {
            if(ACTYPE==2)
            {
                $this->load->view('frontend/thank_you_for_your_purchase',$this->data);
            }
        }

    }
    public function refer_a_friend()
    {
         if(isset($_SESSION['JobsSessions']))
        {
            if(ACTYPE==2)
            {
                $ar = array(
                    'name'=>$this->input->post('name'),
                    'email'=>$this->input->post('email'),
                    'msg'=>$this->input->post('msg'),
                );



                $edata = $this->front_model->get_emails_data('refer-a-friend');
            
                $replace = array("[WEBURL]","[USER]","[WEBTITLE]","[REFERRER]","[MSG]");
                $replacewith = array(base_url(), $ar['name'],TITLEWEB,$this->data['user_own_details']->uFname.' '.$this->data['user_own_details']->uLname,$ar['msg']);
                $str = str_replace($replace,$replacewith,$edata[0]->eContent);
                 $message = $str;
               
                $this->sendgrid_mail(array($ar['email'],$ar['name']),$message,$edata[0]->eName);

                $_SESSION['thankyou']="Your friend has been invited on your behalf";
                $this->redirect_back();

            }
        }
    }
    public function sample_res()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://demo.icodashboard.io"."/ico/veriff_callback_decision",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_POST=>1,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS=>'{"status":"success","verification":{"id":"a4c0a230-859a-4861-b99b-ac39e4a05bfd","status":"resubmission_requested","code":9103,"reason":"Photos are not from the same document.","acceptanceTime":"2017-09-26T12:27:55.000Z","person":{"firstName":"Morton","lastName":"Stracke","idNumber":"48002020011"},"document":{"number":"AA0052283","type":"ID_CARD","validFrom": "2017-02-27", "validUntil": "2022-02-27"},"comments":[{"type": "General Comment", "comment": "Person refuses to take off hat.", "timestamp": "2017-10-10T13:18:44.009Z"}],"additionalVerifiedData":{}},"technicalData":{"ip":"124.153.46.66"}}',
          CURLOPT_HTTPHEADER => array(
                "accept:application/json",
                "x-auth-client:8e4f7cd8-7a19-4d7d-971f-a076407ee03c",
                "x-signature:328b360ef2bd2d6b8aa19b41ec5840f3cae94754ac0cfc11484d4ca84a82d9fd",
                "content-type:application/json"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        print_r($response);

        curl_close($curl);

    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

