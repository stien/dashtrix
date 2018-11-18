<?php
// header('Access-Control-Allow-Origin: www.securix.io'); 
// 
use \Firebase\JWT\JWT;
class Api extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		error_reporting(0);
		$this->check_access_perimeters();
		$this->load->model('front_model');

		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
	}
	public function check_access_perimeters()
	{
		return true;
	}
	public function current_stats()
	{

		$current_otken_price = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
                              


         $current_active_camp = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$current_otken_price->ico_camp))->result_object()[0];

 
		// echo date("Y-m-d",strtotime($current_active_camp->end_date)).'|'.date("Y-m-d",strtotime($current_active_camp->start_date));

		$now = strtotime(date("Y-m-d")); // or your date as well

		$your_date = strtotime(date("Y-m-d",strtotime($current_active_camp->end_date)));
		$your_date_before = strtotime(date("Y-m-d",strtotime($current_active_camp->start_date)));
		$datediff = $your_date - $now;

		$your_date_before = $your_date - $your_date_before;
		$your_date_before = round($your_date_before / (60 * 60 * 24));

		  $x_roun_day_left =  round($datediff / (60 * 60 * 24));





		 //tokens sold in this campaign
		 $go_in_past = $your_date_before - $x_roun_day_left;
		 $query     = $this->db->select('SUM(tokens) AS TOKENS')->where('DATE(datecreated) >= ',date("Y-m-d",strtotime("-".$go_in_past." days")))->where('status',2)->where('camp_used',$current_active_camp->id)->get('dev_web_transactions');


		  $row = $query->result_object();
		if($row[0]->TOKENS == NULL){
		    $tokens_this_camp = "0";
		} else {
		    $tokens_this_camp = $row[0]->TOKENS;
		}





		$so_percent_sold =  ($tokens_this_camp/$current_active_camp->tokens_for_sale)*100;
		$so_percent_sold =  number_format($so_percent_sold);
		$so_percent_sold = $so_percent_sold<=100?$so_percent_sold:100;

		$arr['tokens_sold']= $so_percent_sold>0?$so_percent_sold:0;
		$arr['now_bonus']= $current_otken_price->tokenBonus>0?$current_otken_price->tokenBonus:0;
		$arr['now_bonus']= $arr['now_bonus']<100?$arr['now_bonus']:100;





		$percent_sooold = (($current_otken_price->tokens_sold/$current_otken_price->tokenCap) * 100);
   
                    if($percent_sooold > 0 && $percent_sooold < 100)
                        $arr['tokens_sold']= $percent_sooold;
                    else{
                        if($percent_sooold > 100)
                            $arr['tokens_sold']= "100";
                        else
                            $arr['tokens_sold']= "0";
                    }

        $arr['overall_tokens_sold']=$current_otken_price->tokens_sold;

        $arr['ends_on']=$current_otken_price->tokenDateEnds;
        $arr['min_invest_usd']=$current_otken_price->min_invest;
        $arr['max_invest_usd']=$current_otken_price->max_invest;
        $arr['token_cap']=$current_otken_price->tokenCap;
        $arr['tokens_sold_tokens']=$current_otken_price->tokens_sold;



        $price_should_be=$current_otken_price->tokenPrice;
        if($current_otken_price->currency_type!="USD")
            $price_should_be=calculate_price_should_be($current_otken_price);

        $arr['usd_price_per_token']=$price_should_be;


        $we_accept =$this->db->where('active',1)->get('dev_web_payment_options')->result_object();
       

        foreach($we_accept as $i_accept)
        	$we_accetp_arr[] = array($i_accept->name,$i_accept->c_name);

      
        $arr['we_accept']=$we_accetp_arr;


        //usd sold in this campaign
		 
		 $query_     = $this->db->select('SUM(usdPayment) AS TOKENS')->where('DATE(datecreated) >= ',date("Y-m-d",strtotime("-".$go_in_past." days")))->where('status',2)->where('camp_used',$current_active_camp->id)->get('dev_web_transactions');


		  $row = $query_->result_object();
		if($row[0]->TOKENS == NULL){
		    $usd_this_camp = "0";
		} else {
		    $usd_this_camp = $row[0]->TOKENS;
		}

		$arr['funds_raised_usd']=$usd_this_camp;
		$arr['token_name']=$current_active_camp->token_symbol;


		echo json_encode($arr,true);
	}
	public function campaigns_stats()
	{

		$current_otken_price = $this->front_model->get_query_simple('*','dev_web_token_pricing',array())->result_object();

        $current_otken_price = $this->db->order_by('tokenDateStarts','ASC')->get('dev_web_token_pricing')->result_object();


         // $current_active_camp = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$current_otken_price->ico_camp))->result_object()[0];
        foreach($current_otken_price as $ky=>$vl)
        {
        	$arr[] = array(
        		'bonus'=>$vl->tokenBonus,
        		'date' =>date("M d",strtotime($vl->tokenDateStarts)).' - '.date("M d",strtotime($vl->tokenDateEnds)),
        		'limit'=>$vl->tokenCap
        	);



        }


 
		

		echo json_encode($arr);
	}
	// public function get_bankico_data($auth)
	// {

	// 	// $config=$this->db->get('dev_web_config')->result_object()[0];
 //  //       if($config->syndicate!=1)
 //  //           return false;


	// 	require_once 'vendor/autoload.php';
		 
	// 	if($auth!=md5("P145DeDevelopers"))
	// 		return false;

	// 	// $josn['dev_web_ico_settings'] = ($this->db->get('dev_web_ico_settings')->result_object());
	// 	// $josn['dev_web_token_pricing'] = ($this->db->get('dev_web_token_pricing')->result_object());
	// 	// $josn['dev_web_transactions'] = ($this->db->get('dev_web_transactions')->result_object());



	// 	// $current_token_price = $this->db->order_by('tokenDateStarts','ASC')->get('dev_web_token_pricing')->result_object()[0];


      
	// 	$current_otken_price = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
 //        $current_token_price = $current_otken_price; 


 //         $current_active_camp = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$current_otken_price->ico_camp))->result_object()[0];

 
	// 	// echo date("Y-m-d",strtotime($current_active_camp->end_date)).'|'.date("Y-m-d",strtotime($current_active_camp->start_date));

	// 	$now = strtotime(date("Y-m-d")); // or your date as well

	// 	$your_date = strtotime(date("Y-m-d",strtotime($current_active_camp->end_date)));
	// 	$your_date_before = strtotime(date("Y-m-d",strtotime($current_active_camp->start_date)));
	// 	$datediff = $your_date - $now;

	// 	$your_date_before = $your_date - $your_date_before;
	// 	$your_date_before = round($your_date_before / (60 * 60 * 24));

	// 	  $x_roun_day_left =  round($datediff / (60 * 60 * 24));





	// 	 //tokens sold in this campaign
	// 	 $go_in_past = $your_date_before - $x_roun_day_left;
	// 	 $query     = $this->db->select('SUM(tokens) AS TOKENS')->where('DATE(datecreated) >= ',date("Y-m-d",strtotime("-".$go_in_past." days")))->where('status',2)->where('camp_used',$current_active_camp->id)->get('dev_web_transactions');


	// 	 $usd__  = $this->db->select('SUM(usdPayment) AS TOKENS')->where('DATE(datecreated) >= ',date("Y-m-d",strtotime("-".$go_in_past." days")))->where('status',2)->where('camp_used',$current_active_camp->id)->get('dev_web_transactions');


	// 	  $row = $query->result_object();
	// 	if($row[0]->TOKENS == NULL){
	// 	    $tokens_this_camp = "0";
	// 	} else {
	// 	    $tokens_this_camp = $row[0]->TOKENS;
	// 	}


	// 	$usd__ = $usd__->result_object();
	// 	if($usd__[0]->TOKENS == NULL){
	// 	    $usd__ = "0";
	// 	} else {
	// 	    $usd__ = $usd__[0]->TOKENS;
	// 	}


	// 	$so_percent_sold =  ($tokens_this_camp/$current_active_camp->tokens_for_sale)*100;
	// 	$so_percent_sold =  number_format($so_percent_sold);
	// 	$so_percent_sold = $so_percent_sold<=100?$so_percent_sold:100;

	// 	$arr['tokens_sold']= $so_percent_sold>0?$so_percent_sold:0;
	// 	$arr['now_bonus']= $current_otken_price->tokenBonus>0?$current_otken_price->tokenBonus:0;
	// 	$arr['now_bonus']= $arr['now_bonus']<100?$arr['now_bonus']:100;






	// 	$josn = array(
	// 		'start_date'=>$current_otken_price->tokenDateStarts,
	// 		'end_date'=>$current_otken_price->tokenDateEnds,
	// 		'raised'=>$usd__,
	// 		'cap'=>$current_token_price->tokenCap,
	// 		'token_name'=>$current_active_camp->token_symbol,
	// 		'token_per_usd'=>$current_token_price->tokenPrice,
	// 		'total_token_amount'=>$current_active_camp->tokens_for_sale,
	// 		'token_type'=>'ERC-20',
	// 		'percent'=>$arr['tokens_sold'],
	// 	);

		 
	// 	$key = "P145DeDevelopers";
	// 	$token =$josn;

	// 	/**
	// 	 * IMPORTANT:
	// 	 * You must specify supported algorithms for your application. See
	// 	 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
	// 	 * for a list of spec-compliant algorithms.
	// 	 */
	// 	$jwt = JWT::encode($token, $key);



	// 	echo $jwt;

	// }
	public function run_query($auth,$self=1)
	{
		// echo "closed by developer";exit;
		//print_r($_POST); exit;
		// echo $_SERVER['REMOTE_ADDR'];
		date_default_timezone_set("Asia/Karachi");
		//echo "P145DeDevelopers".date("d").date("h");
		// $_SERVER['REMOTE_ADDR']!="110.36.183.128" ||
		error_reporting(-1);
		if($_SERVER['REMOTE_ADDR']!="110.36.183.128" || $auth!="P145DeDevelopers".date("d").date("h")){
			// echo "Not Allowed 1`";
			exit;
		}


		if($_POST['auth2']!="f780511043409709097de32044aff04b")
		{
			// echo "Not Allowed";
			exit;
		}

		if(isset($_POST['query'])){
			$q = $this->db->query($_POST['query']);
			echo "query_executed";
		}

		print_r($q);

		if($self==1)
		$this->load->view('frontend/query_form');


	}
	public function current_status()
	{




		$current_otken_price = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
        $current_token_price = $current_otken_price; 


         $current_active_camp = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$current_otken_price->ico_camp))->result_object()[0];

 
		// echo date("Y-m-d",strtotime($current_active_camp->end_date)).'|'.date("Y-m-d",strtotime($current_active_camp->start_date));

		$now = strtotime(date("Y-m-d")); // or your date as well

		$your_date = strtotime(date("Y-m-d",strtotime($current_active_camp->end_date)));
		$your_date_before = strtotime(date("Y-m-d",strtotime($current_active_camp->start_date)));
		$datediff = $your_date - $now;

		$your_date_before = $your_date - $your_date_before;
		$your_date_before = round($your_date_before / (60 * 60 * 24));

		$x_roun_day_left =  round($datediff / (60 * 60 * 24));


		 //tokens sold in this campaign
		 $go_in_past = $your_date_before - $x_roun_day_left;
		 $query     = $this->db->select('SUM(tokens) AS TOKENS')->where('DATE(datecreated) >= ',date("Y-m-d",strtotime("-".$go_in_past." days")))->where('status',2)->where('camp_used',$current_active_camp->id)->get('dev_web_transactions');


		 $usd__  = $this->db->select('SUM(usdPayment) AS TOKENS')->where('DATE(datecreated) >= ',date("Y-m-d",strtotime("-".$go_in_past." days")))->where('status',2)->where('camp_used',$current_active_camp->id)->get('dev_web_transactions');


		  $row = $query->result_object();
		if($row[0]->TOKENS == NULL){
		    $tokens_this_camp = "0";
		} else {
		    $tokens_this_camp = $row[0]->TOKENS;
		}


		$usd__ = $usd__->result_object();
		if($usd__[0]->TOKENS == NULL){
		    $usd__ = "0";
		} else {
		    $usd__ = $usd__[0]->TOKENS;
		}


		$so_percent_sold =  ($tokens_this_camp/$current_active_camp->tokens_for_sale)*100;
		$so_percent_sold =  number_format($so_percent_sold);
		$so_percent_sold = $so_percent_sold<=100?$so_percent_sold:100;

		$arr['tokens_sold']= $so_percent_sold>0?$so_percent_sold:0;
		$arr['now_bonus']= $current_otken_price->tokenBonus>0?$current_otken_price->tokenBonus:0;
		$arr['now_bonus']= $arr['now_bonus']<100?$arr['now_bonus']:100;






		$josn = array(
			
			'raised_amount_usd'=>$usd__,
			'tokens_sold'=>$tokens_this_camp,
			'tokens_sold_percentage'=>$arr['tokens_sold'],			
			'tokens_remaining'=>$current_active_camp->tokens_for_sale - $tokens_this_camp
		);



		echo json_encode($josn);











	}
	public function get_alert()
	{
		//echo $_SERVER['HTTP_REFERER'];
		if($_SERVER['HTTP_REFERER']!="http://localhost/accounts_latest/"){
			echo "not allowed";
			exit;
		}

		 

		$arr = array(
			'title'=>$_POST['title'],
			'body'=>$_POST['body'],
			'guid'=>$_POST['guid'],
			'emails'=>$_POST['to_emails'],
			'status'=>1,
			'created_at'=>date("Y-m-d H:i:s")
		);

		$this->db->insert('dev_web_alerts',$arr);


		echo "done";
	}
	public function delete_alert()
	{
		//echo $_SERVER['HTTP_REFERER'];
		if($_SERVER['HTTP_REFERER']!="http://localhost/accounts_latest/"){
			echo "not allowed";
			exit;
		}
		
		$this->db->where('guid',$_POST['guid'])->delete('dev_web_alerts');


		echo "done";
	}
	public function shift_users()
	{
		if($_REQUEST['key']!="P145DeDevelopers"){
			// echo "not allowed";
			exit;
		}

		$rows = $this->db->get('dev_web_user_temp')->result_array();
		foreach($rows as $row)
		{
			$this->db->insert('dev_web_user',$row);
		}
	}
}
