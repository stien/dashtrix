<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
use \Firebase\JWT\JWT;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dna_idm extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->database();
        $this->db->reconnect();
		$this->load->model('front_model');
		ob_start();
        error_reporting(0);
        session_start();

	}
	public function try_kyc()
	{
		$curl = curl_init();
		$api_details = $this->db->where('type',"IDMINDPLUGIN")->get('dev_web_kyc_apis')->result_object()[0];

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
	public function try_kcy_response()
	{


		$api_details = $this->db->where('type',"IDMINDPLUGIN")->get('dev_web_kyc_apis')->result_object()[0];

		 
		require_once 'vendor/autoload.php';
		

$publicKey = $api_details->public_key;

/*
Replace $jwt with the post parameter
*/
$jwt = $_POST['res'];

$jwt = @file_get_contents("php://input");

// $jwt = "43890";
// $this->db->insert('hook_test',json_encode($r));

// exit;
$decoded = \Firebase\JWT\JWT::decode($jwt, $publicKey, array('RS256'));

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/

$decoded_array = (array) $decoded;
$this->db->insert('hook_test',array('resp'=>json_encode($decoded_array)));
exit;
// throw new Exception("Error Processing Request", 1);
// next_pelase

// $user_id = $decoded_array['uID'];
$user_id = $_SESSION['my_id'];
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
	$_SESSION['thankyou']="Verified Successfully!";
	$res['msg']="Verified Successfully!";
	$res['r']=1;
	$res['l']=base_url().'dashboard';
}
elseif($decoded_array['kyc_result']=="MANUAL_REVIEW")
{
	$res['msg']="Your information is being reviewed, it should be reviewd in next 72 (business) hours.";
	$res['r']=0;
	// $this->inform_admins();
	//$res['l']=base_url().'dashboard';
}
else{
	$res['msg']="Your information has been rejected!";
	$res['r']=0;
}
echo json_encode($res);









}
	public function inform_admins()
	{

		$admin_ids = $this->db->where('role','-1')->get('dev_web_admin_roles')->result_object();
		foreach($admin_ids as $_admin_ids)
			$admin_ids_[]=$_admin_ids->uID;

		if(empty($admin_ids_))
			return false;
		$admins = $this->db->where_in('uID',$admin_ids_)->where('uActType',1)->get('dev_web_user')->result_object();
		foreach($admins as $admin){
		
	       

	            $edata = $this->front_model->get_emails_data('alert-kyc-new');
	            $this->load->library('email');
	            $this->email->from($edata[0]->eEmail, TITLEWEB);
	            $this->email->to($admin->uEmail);
	            $replace = array("[WEBURL]","[CODE]","[USER]","[WEBTITLE]");
	            $replacewith = array(WEBURL, $rendomcode, $admin->uFname." ".$admin->uLname,TITLEWEB);
	            $str = str_replace($replace,$replacewith,$edata[0]->eContent);
	            $message = $str;
	            $this->email->subject($edata[0]->eName);
	            $this->email->message($message);
	            $this->email->set_mailtype("html");
	            // $send = $this->email->send();
	            
	            $this->sendgrid_mail(array($admin->uEmail,''),$message,$edata[0]->eName);
	        }

	}
	public function sendgrid_mail($to,$content,$subject,$from =WEBEMAIL)
    {
        error_reporting(-1);
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

}