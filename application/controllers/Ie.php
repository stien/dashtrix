<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ie extends CI_Controller {
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
        session_start();
        
        $arr = array();
        $config     = $this->front_model->get_query_simple('*','dev_web_config',$arr);
        $rconfig    = $config->result_object();
        $this->data['web_settings']=$rconfig[0];
      
        
        if(isset($_SESSION['JobsSessions'])){
           
           
            $arrusercon = array('uID' => $_SESSION['JobsSessions'][0]->uID);
            $quserdat   = $this->front_model->get_query_simple('*','dev_web_user',$arrusercon);
            $user   = $quserdat->result_object();
            $this->data['user_own_details']=$user[0];


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


      

            $roles=array();
             
            $roless = $this->db->where('admin_id',UID)->get('dev_web_admin_roles')->result_array();
            foreach($roless as $role)
                $roles[]=$role['role'];
            $_SESSION['RolesSession']['roles']=$roles;
        }

        if(isset($_SESSION['JobsSessions']) && $this->data['user_own_details']->uActType==1){

        }
        else
        {
        	redirect(base_url().'login');
        	exit;
        }
        
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
    private function upload_file($name,$loc)
    {
        $config['upload_path']          = $loc;
        $config['allowed_types']        = 'csv';
        $new_name = url_title($_FILES[$name]['name']).'-'.time();
        $config['file_name'] = $new_name;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload($name))
        {
                $error = array('error' => $this->upload->display_errors());

                return array(false,$error);
        }
        else
        {
                $data =  $this->upload->data();

                return array(true,$data);
        }
    }

    public function export($link)
    {
    	


    	$table = $this->ask_for_tablename($link);


















    	if(isset($_GET['where']) && isset($_GET['there']))
    		$data = $this->db->where($_GET['where'],$_GET['there'])->get($table)->result_array();
    	else
    		$data = $this->db->get($table)->result_array();

        if(empty($data))
        {
            $_SESSION['error']="There no data in selected filter.";
            redirect($_SERVER['HTTP_REFERER']);
            exit;
        }
      
        $type="";
        
        $this->array2csv($data,"users_csv",$type);
    }

    
    


    public function import($link)
    {

    	$table = $this->ask_for_tablename($link);

    	$file = $this->upload_file('csv', './resources/uploads/private_files/');
    	if(!$file[0])
    	{
    		$_SESSION['error']=$file[1]['error'];
            redirect($_SERVER['HTTP_REFERER']);
            exit;
    	}
    	 $arr_columns = array();

    	 $row = 1;
        if (($handle = fopen($file[1]['full_path'], "r")) !== FALSE) {
               

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            	
                $row++;
                if($row==2) {
    	 			$arr_columns = $data;


                	continue;

                }
                if(!empty($data)){
                

                	foreach($data as $count=>$_data)
                		$insert_able[$arr_columns[$count]] = $_data;
                	 
                    $this->db->where($arr_columns[0],$data[0])->delete($table);
                    $this->db->insert($table,$insert_able);
                  
                }
            }
        
            fclose($handle);

            $_SESSION['thankyou']=$row." records added successfully!";
            redirect($_SERVER['HTTP_REFERER']);
            exit;
        }
    }





    private function ask_for_tablename($link="")
    {
    	$table = "dev_web_user";
    	switch ($link) {
    		// ICO Settings
    		case 'ico-settings':
    			$table = "dev_web_ico_settings";
    			break;

    		// Token Pricing
    		case 'token-pricing':
    			$table = "dev_web_token_pricing";
    			break;

    		// Token Pricing
    		case 'payment-settings':
    			$table = "dev_web_payment_options";
    			break;

    		// User On-Boarding Campaigns
    		case 'user-onboarding':
    			$table = "dev_web_campaigns";
    			break;

    		// User On-Boarding Campaign Links
    		case 'links':
    			$table = "dev_web_slide_links";
    			break;

    		// User On-Boarding Campaign Questions
    		case 'questions':
    			$table = "dev_web_slide_qs";
    			break;

    		// User On-Boarding Campaign Slides
    		case 'questions':
    			$table = "dev_web_camp_slides";
    			break;

    		// ICO Milestones
    		case 'ico-milestones':
    			$table = "dev_web_ico_milestones";
    			break;

    		// Email Templates
    		case 'email-settings':
    			$table = "dev_web_emails";
    			break;
    		
    		// KYC/AML
    		case 'kyc-aml':
    			$table = "dev_web_kyc_ml_user";
    			break;

    		// Admin Users
    		case 'admin-users':
    			$table = "dev_web_user";
    			break;

    		// Banned Countries
    		case 'banned-countries':
    			$table = "dev_web_banned_countries";
    			break;

    		// User Registration
    		case 'user-registration':
    			$table = "dev_web_registration_forms";
    			break;

    		// Pages
    		case 'pages':
    			$table = "dev_web_pages";
    			break;

    		// Users
    		case 'users':
    			$table = "dev_web_user";
    			break;

    		// Verifications
    		case 'verifications':
    			$table = "dev_web_user_verification";
    			break;

    		// Tranasctions
    		case 'tranasctions':
    			$table = "dev_web_user_tranasctions";
    			break;

            // Bounties
            case 'bounties':
                $table = "dev_web_airdrop_campaigns";
                break;

            // Bounties Submissions
            case 'bounties-submissions':
                $table = "dev_web_airdrop_submissions";
                break;

            // Bounties Landing (Categories)
            case 'bounties-landing':
                $table = "dev_web_airdrop_cats";
                break;
    		
    		default:
    			$table=$table;
    			break;
    	}
    	return $table;
    }
// paste here
// bounties-landing
}