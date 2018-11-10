<?php 
require_once("common/header.php");
// error_reporting(E_ALL);
// show_error($message, $status_code, $heading = 'An Error Was Encountered');
// echo $message;
// echo $status_code;
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'resources/frontend/css/circle.css'; ?>">

    <?php if(isset($_SESSION['thankyou'])){?>

            <div class="col-md-12">

                <div class="form-group">

                    <div class="successfull">

                        <?php echo $_SESSION['thankyou'];?>

                    </div>

                </div>

            </div>

            <?php } ?>

            <?php if(isset($_SESSION['error'])){?>

            <div class="col-md-12">

                <div class="form-group">

                    <div class="wrongerror">

                        <?php echo $_SESSION['error'];?>

                    </div>

                </div>

            </div>

            <?php } ?>

    

	<?php if(ACTYPE == "2" && $this->uri->segment(1) == "dashboard"){ ?>


        <?php if("All Installations"=="All Installations") include_once 'common/new_dashboard.php';
              else include_once 'common/old_dashboard.php';
         ?>
  	
    <?php } else if(ACTYPE == "1" && $this->uri->segment(1) == "admin" && $this->uri->segment(2) == "tranasctions"){

        check_roles(4);
     ?>

    <div class="row">

         <div class="col-sm-12 m-b-30">

            <div class="button-list pull-right m-t-15">   
<a class="btn btn-default" href="<?php echo base_url();?>admin/export/tranasctions/csv"><i class="fa fa-download"></i> Export CSV</a> 
<?php /* ?>
<a class="btn btn-default" href="<?php echo base_url();?>admin/export/users/comma"><i class="fa fa-download"></i> Export Comma Seprated</a> 
<a class="btn btn-default" href="<?php echo base_url();?>admin/export/users/tab"><i class="fa fa-download"></i> Export Tab Seprated</a> 
<?php */ ?>
</div> 

        	<h4 class="page-title">Transactions


            </h4>

    	</div>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="card-box m-b-50">

               <?php if(isset($_SESSION['thankyou'])){?>

            <div class="col-md-12">

                <div class="form-group">

                    <div class="successfull">

                    	<?php echo $_SESSION['thankyou'];?>

                    </div>

                </div>

            </div>

            <?php } ?>

            <?php if(isset($_SESSION['error'])){?>

            <div class="col-md-12">

                <div class="form-group">

                    <div class="wrongerror">

                    	<?php echo $_SESSION['error'];?>

                    </div>

                </div>

            </div>

            <?php } ?>

                <div class="">

                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">

                    	<thead>

                    	<tr>

                            <th>Trans. Type</th>

                    	<th >Name</th>

                    	<th >Username</th>

                    	<th >Tokens</th>

                    	<th >Currency</th>

                    	<th >Amount Paid</th>

                    	<th >Date</th>

                    	

                    	<th >Status </th>

                    	<th >Action</th></tr>

                    	</thead>

                    	<?php

							$arr = array();

							$config = $this->front_model->get_query_simple('*','dev_web_transactions',$arr);

							$transctions 	= $config->result_object();

						?>

                    	<tbody>

                    	<?php 

							foreach($transctions AS $row){

								$arrcur = array('curID' => $row->currency);

								$cour = $this->front_model->get_query_simple('*','dev_web_currency',$arrcur);

								$currency 	= $cour->result_object();

								//echo $row->datecreated;

								$arusr = array('uID' => $row->uID);

								$usrqry = $this->front_model->get_query_simple('*','dev_web_user',$arusr);

								$user 	= $usrqry->result_object();

						?>

                    		<tr>


                                 <td>
                                <?php

                                if($row->t_type==2){
                                    echo "Completed A Survey";
                                }
                                else if($row->t_type==30){
                                    echo "Referral Bonus";
                                }
                                else
                                {
                                    echo "Purchased Token";
                                }

                                 ?>
                             </td>

                    			<td title="<?php echo $user[0]->uFname. " ".$user[0]->uLname;?>"><?php echo substr( $user[0]->uFname. " ".$user[0]->uLname,0,10)."...";?></td>

                    			<td><?php echo $user[0]->uUsername;?></td>

                    			<td><?php echo $row->tokens;?></td>

                    			<td><?php echo $currency[0]->currencyName;?></td>

                    			<td><?php echo $row->amountPaid;?> <?php echo $row->amtType;?></td>

                    			<td><?php echo date("m/d/y",strtotime($row->datecreated));?></td>

                    			

                    			<td><?php 

										if($row->status == "1"){echo "<div class='status-pending'>Pending</div>";} 

										else if($row->status == "2"){echo "<div class='status-confirm'>Confirmed</div>";} 

										else if($row->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}

										else if($row->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}

									?>

                   				</td>

                    			<td>

                    				

                    				<div class="btn-group">

									  <button type="button" class="btn btn-info">Actions</button>

									  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

										<span class="caret"></span>

										<span class="sr-only">Toggle Dropdown</span>

									  </button>

									  <ul class="dropdown-menu">




                                        <?php 

                                        if($row->status == "1"){ ?>

										<li><a href="javascript:;" onClick="btnstatusupdate(2,<?php echo $row->tID;?>);">Conﬁrmed</a></li>

										<!--<li><a href="javascript:;" onClick="btnstatusupdate(1);">Pending</a></li>-->

										<li><a href="javascript:;" onClick="btnstatusupdate(3,<?php echo $row->tID;?>);">Cancelled</a></li>

										<li><a href="javascript:;" onClick="btnstatusupdate(4,<?php echo $row->tID;?>);">Refunded</a></li>

                                        <?php } ?>

                                        <li><a href="javascript:;" onclick="deletecampaign(<?php echo $row->tID;?>);">Delete</a></li>


									  </ul>

									</div>

                    				

                    			</td>

                    		</tr>

                    	<?php } ?>

                    	</tbody>

                    </table>

                </div>

            </div>



        </div> <!-- end col -->

    </div>


    <div class="modal-cs display_none delete_transaction" >
    <div class="modal-box">
        <div class="modal-heading">
            <h4 class="left">Delete Transaction</h4>

            <button onclick="closeModel();" class="btn bt-danger right" >
                <i  class="fa fa-times"></i>
            </button>
        </div>

        <div class="modal-body">
            <form method="post" action="<?php echo base_url();?>ico/delete_transaction">
                <div class="row">

                    
                    <div class="col-md-12">
                        <div style="text-align: center; background: orange; color:#fff; padding: 10px;">
                           If you delete this transaction, the statistics on the dashboard will be also affected. Please make sure before deleting this transaction.
                        </div>
                    </div>
                    <div class="col-md-6 m-t-40">
                        <div class="form-group">
                            <button class="btn btn-danger btn-block btn-lg" type="button" onclick="closeModel()">
                                Cancel
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 m-t-40">
                        <div class="form-group">
                            <input type="hidden" name="id" id="delete_trans_id" value="">
                            <button class="btn btn-default btn-block btn-lg" type="submit">
                                Continue to delete
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>


<?php } else if(ACTYPE == "1" && $this->uri->segment(1) == "dashboard"){ ?>

    	<div class="row">

         <div class="col-sm-12 m-b-30">

        	<h4 class="page-title">WELCOME TO ADMIN DASHBOARD</h4>

    	</div>

    	</div>

    	<div class="row">

            <div class="col-md-12">
                <div class="col-md-12">

            <div class="col-sm-3 m-b-30">

                <div class="card-box widget-box-1 boxdisplay sales">

                    <span class="d-flip d-flip-all-time">$<?php echo custom_number_format($this->front_model->total_sales('all-time'),decimals_());?></span>
                    <span class="d-flip d-flip-today">$<?php echo custom_number_format($this->front_model->total_sales(),decimals_());?></span>
                    <span class="d-flip d-flip-week">$<?php echo custom_number_format($this->front_model->total_sales('week'),decimals_());?></span>
                    <span class="d-flip d-flip-month">$<?php echo custom_number_format($this->front_model->total_sales('month'),decimals_());?></span>
                    
                    

                    <p>Total Sales</p>
                    <span class="flip-control">
                        <a class="flip-all-time" href="javascript:dFlip('all-time','sales');">All</a> | 

                        <a class="flip-today" href="javascript:dFlip('today','sales');">Today</a> | 
                        <a class="flip-week" href="javascript:dFlip('week','sales');">Week</a> | 
                        <a class="flip-month" href="javascript:dFlip('month','sales');">Month</a>  
                    </span>

                </div>  

            </div>

			<div class="col-sm-3 m-b-30">

				<div class="card-box widget-box-1 boxdisplay token">
                    <span class="d-flip d-flip-all-time"><?php echo custom_number_format($this->front_model->totaltokensolds('all-time'),decimals_());?></span>
                    <span class="d-flip d-flip-today"><?php echo custom_number_format($this->front_model->totaltokensolds(),decimals_());?></span>
                    <span class="d-flip d-flip-week"><?php echo custom_number_format($this->front_model->totaltokensolds('week'),decimals_());?></span>
					<span class="d-flip d-flip-month"><?php echo custom_number_format($this->front_model->totaltokensolds('month'),decimals_());?></span>
                    

					<p>Tokens Sold</p>
                    <span class="flip-control">
                        <a class="flip-all-time" href="javascript:dFlip('all-time','token');">All</a>
                         | 
                        <a class="flip-today" href="javascript:dFlip('today','token');">Today</a> | 
                        <a class="flip-week" href="javascript:dFlip('week','token');">Week</a> | 
                        <a class="flip-month" href="javascript:dFlip('month','token');">Month</a> 
                    </span>

				</div>	

			</div>	
   <!--      </div>
        <div class="col-md-12"> -->


   			
            <?php /* ?>
   			<div class="col-sm-4 m-b-30">

				<div class="card-box widget-box-1 boxdisplay raised">

					<span class="d-flip d-flip-today">$200</span>
                    <span class="d-flip d-flip-week">$300</span>
                    <span class="d-flip d-flip-month">$5000</span>
                    <span class="d-flip d-flip-all-time">$700000</span>

					<p>Total Raised</p>
                    <span class="flip-control">
                        <a class="flip-today" href="javascript:dFlip('today','raised');">Today</a> | 
                        <a class="flip-week" href="javascript:dFlip('week','raised');">Week</a> | 
                        <a class="flip-month" href="javascript:dFlip('month','raised');">Month</a> | 
                        <a class="flip-all-time" href="javascript:dFlip('all-time','raised');">All</a>
                    </span>

				</div>	

			</div>	

            <?php */ ?>
  			

  			<div class="col-sm-3 m-b-30">

				<div class="card-box widget-box-1 boxdisplay trans">

                    <span  class="d-flip d-flip-all-time"><?php echo number_format($this->front_model->totaltransactions_2('all-time'));?></span>

                    <span  class="d-flip d-flip-today"><?php echo number_format($this->front_model->totaltransactions_2('today'));?></span>
                    <span  class="d-flip d-flip-week"><?php echo number_format($this->front_model->totaltransactions_2('week'));?></span>
                    <span  class="d-flip d-flip-month"><?php echo number_format($this->front_model->totaltransactions_2('month'));?></span>
					

					<p>Transactions</p>

                    <span class="flip-control">
                        <a class="flip-all-time" href="javascript:dFlip('all-time','trans');">All</a> | 

                        <a class="flip-today" href="javascript:dFlip('today','trans');">Today</a> | 
                        <a class="flip-week" href="javascript:dFlip('week','trans');">Week</a> | 
                        <a class="flip-month" href="javascript:dFlip('month','trans');">Month</a>
                    </span>

				</div>	
                

			</div>	


        </div>
                <div class="col-md-12">


  			
            <?php $current_otken_price = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
                              


         $current_active_camp = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$current_otken_price->ico_camp))->result_object()[0];

 
// echo date("Y-m-d",strtotime($current_active_camp->end_date)).'|'.date("Y-m-d",strtotime($current_active_camp->start_date));

$now = strtotime(date("Y-m-d")); // or your date as well

$your_date = strtotime(date("Y-m-d",strtotime($current_active_camp->end_date)));
$your_date_before = strtotime(date("Y-m-d",strtotime($current_active_camp->start_date)));
$datediff = $your_date - $now;

$your_date_before = $your_date - $your_date_before;
$your_date_before = round($your_date_before / (60 * 60 * 24));

  $x_roun_day_left =  round($datediff / (60 * 60 * 24));



  $days_percent = $x_roun_day_left>0?$x_roun_day_left:0;

 

 $days_percent = ($days_percent/$your_date_before)*100;
 $days_percent = number_format($days_percent);



 //tokens sold in this campaign
 $go_in_past = $your_date_before - $x_roun_day_left;
 $query     = $this->db->select('SUM(tokens) AS TOKENS')->where('DATE(datecreated) >= ',date("Y-m-d",strtotime("-".$go_in_past." days")))->where('status',2)->where('camp_used',$current_active_camp->id)->get('dev_web_transactions');


  $row = $query->result_object();
if($row[0]->TOKENS == NULL){
    $tokens_this_camp = "0";
} else {
    $tokens_this_camp = $row[0]->TOKENS;
}

 $query     = $this->db->select('SUM(usdPayment) AS TOKENS')->where('DATE(datecreated) >= ',date("Y-m-d",strtotime("-".$go_in_past." days")))->where('status',2)->where('camp_used',$current_active_camp->id)->get('dev_web_transactions');


  $row = $query->result_object();
if($row[0]->TOKENS == NULL){
    $usd_payment = "0";
} else {
    $usd_payment = $row[0]->TOKENS;
}
 // echo $usd_payment;

$total_token_buyers = $this->db->where('DATE(joinDate) >= ',date("Y-m-d",strtotime("-".$go_in_past." days")))->where('uStatus',1)->count_all_results('dev_web_user');

$total_token_buyers_2 = $this->db->where('DATE(datecreated) >= ',date("Y-m-d",strtotime("-".$go_in_past." days")))->where('status',2)->where('camp_used',$current_active_camp->id)->group_by('uID')->count_all_results('dev_web_transactions');


 

$so_percent_sold =  ($tokens_this_camp/$current_active_camp->tokens_for_sale)*100;
$so_percent_sold =  number_format($so_percent_sold);
$so_percent_sold = $so_percent_sold<=100?$so_percent_sold:100;


if($tokens_this_camp>0 && $your_date_before>0)
$average_token_sold = $tokens_this_camp/$your_date_before;
else
$average_token_sold = 0;

if($usd_payment>0 && $your_date_before>0)
$average_revenue = $usd_payment/$your_date_before;
else
$average_revenue = 0;


if($total_token_buyers>0 && $your_date_before>0)
$average_token_buyers = $total_token_buyers/$your_date_before;
else
$average_token_buyers = 0;

if($total_token_buyers_2>0 && $your_date_before>0)
$total_token_buyers_2 = $total_token_buyers_2/$your_date_before;
else
$total_token_buyers_2 = 0;



  $token_revenue = $current_active_camp->tokens_for_sale*$current_otken_price->tokenPrice;


if($usd_payment>0 && $token_revenue>0)
$token_revenue = ($usd_payment/$token_revenue)*100;
else
$token_revenue = 0;


$token_revenue = $token_revenue<=100?$token_revenue:100;
// echo $current_active_camp->max_raise_amount;
// 
if($usd_payment>0 && $current_active_camp->max_raise_amount>0)
$funds_raised_so_for = ($usd_payment/$current_active_camp->max_raise_amount)*100;
else
$funds_raised_so_for = 0;
$funds_raised_so_for = $funds_raised_so_for<=100?$funds_raised_so_for:100;



$days_percent = $days_percent<=100?$days_percent:100;

 ?>
            

            <div class="col-sm-6 m-b-30">

                    <div class="cm_miles easy" >CAMPAIGN MILESTONES</div>
                    
                <div class="card-box widget-box-1 boxdisplay easy" style="padding-bottom: 10px; padding-top:10px;">

                    <div class="cm_mile_under easy">
                        <div class="cm_mile_under_1 thirty_three text-center">
                            <div class="cm_mile_under_text  text-center">Days Left</div>
                            <div class="c100 p<?php echo number_format($days_percent,decimals_()); ?> big  force-center font-75">
                                <span><?php echo number_format($days_percent,decimals_()); ?>%</span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>

                        </div>
                        <div class="cm_mile_under_2 thirty_three text-center">
                            <div class="cm_mile_under_text  text-center">Tokens Sold</div>
                            <div class="c100 p<?php echo number_format($so_percent_sold,decimals_()); ?> big  force-center font-75">
                                <span><?php echo number_format($so_percent_sold,decimals_()); ?>%</span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>
                        </div>
                        <div class="cm_mile_under_3 thirty_three text-center">
                            <div class="cm_mile_under_text  text-center">Funds Raised</div>
                            <div class="c100 p<?php echo number_format($funds_raised_so_for,decimals_()); ?> big  force-center font-75">
                                <span><?php echo number_format($funds_raised_so_for,decimals_()); ?>%</span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>  

            </div>

  			<div class="col-sm-3 m-b-30">

				<div class="card-box widget-box-1 boxdisplay users">

					<span><?php echo number_format($this->front_model->totalusers());?></span>

					<p>Users</p>

				</div>	

			</div>	

            <div class="col-sm-3 m-b-30">

                <div class="card-box widget-box-1 boxdisplay visits">

                    <span><?php echo number_format($this->front_model->totalvisitors('today'));?></span>
                  

                    <p>Visitors</p>
                   

                </div>  

            </div>  

        </div>

        </div>

         <!--  <div class="col-md-4 nopad">
                <div class="col-md-12 nopad">
                    <div class="card-box easy">
                        <h4 class="text-center">ICODashboard Alerts</h4>
                        <div class="alerts___ easy" style="margin-top: 0px;">
                            <?php
                            $alerts = $this->db->order_by('id','DESC')->where('status !=',3)->get('dev_web_alerts')->result_object();
                            foreach($alerts as $alert)
                            {



                             ?>

                             <div class="col-md-12 m-t-10 <?php if($alert->status==0) echo "alert_grayed_out"; else echo "not_alert_grayed_out"; ?>">
                                <div class="alert_inner" <?php if($alert->status!=0){ ?> onclick="openAlert(<?php echo $alert->id; ?>)" <?php } ?>>
                                 <b><?php echo date("m-d-y",strtotime($alert->created_at)); ?> <span style="margin-left: 10px;"><?php echo $alert->title; ?></span></b>
                                </div>
                             <!-- </div> 



 <div class="modal-cs display_none " id="alert_modal<?php echo $alert->id; ?>">
    <div class="modal-box">
        <div class="modal-heading">
            <h4 class="left"><?php echo $alert->title; ?></h4>

            <button onclick="closeModel();" class="btn bt-danger right" >
                <i  class="fa fa-times"></i>
            </button>
        </div>

        <div class="modal-body">
            <form method="post" action="">
                <div class="row">

                  

                    <div class="col-md-12 p-break-all">
                        <?php echo $alert->body; ?>
                    </div>
                  

                    

                    <div class="col-md-6 col-md-offset-3 m-t-40">
                        <div class="form-group">
                            <button class="btn btn-primary btn-block btn-lg" type="button" onclick="__href('ico/dismiss_alert/<?php echo $alert->id; ?>')" name="submit">
                                Dismiss
                            </button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-default btn-block btn-lg"" type="button" onclick="__href('ico/interested_alert/<?php echo $alert->id; ?>')"  name="submit">
                                Interested
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>




                         <?php } ?>
                        </div>
                    </div>

                </div>
            </div>

            </div> -->

            <div class="row">	

            <div class="col-sm-6 m-b-30 under992left">
                <div class="card-box widget-box-1 easy">
                    <div class="col-md-12">
                        <div class="av_title">AVERAGE DAILY PERFORMANCE</div>
                    </div>
                    <div class="col-md-12 pd-10 f-20">
                        <div class="col-md-4 text-right">
                            <?php echo custom_number_format($average_token_sold,decimals_()); ?>
                        </div>
                        <div class="col-md-8">
                            Tokens Sold
                        </div>
                    </div>

                    <div class="col-md-12 pd-10 f-20">
                        <div class="col-md-4 text-right">
                            $<?php echo custom_number_format($average_revenue,decimals_()); ?>
                        </div>
                        <div class="col-md-8">
                            Total Revenue
                        </div>
                    </div>

                    <div class="col-md-12 pd-10 f-20">
                        <div class="col-md-4 text-right">
                            <?php echo custom_number_format($total_token_buyers_2,decimals_()); ?>
                        </div>
                        <div class="col-md-8">
                            Token Buyers
                        </div>
                    </div>


                    <div class="col-md-12 pd-10 f-20">
                        <div class="col-md-4 text-right">
                            <?php echo custom_number_format($average_token_buyers,decimals_()); ?>
                        </div>
                        <div class="col-md-8">
                            New Users
                        </div>
                    </div>

                </div>
            </div>

             <div class="col-sm-6 m-b-30 under992left">
                <div class="card-box widget-box-1 easy">
                    <div class="col-md-12">
                        <div class="av_title">CAMPAIGN METRICS</div>
                    </div>
                    <div class="col-md-12 pd-10 f-20">
                        <div class="col-md-4 text-right  m-t-10">
                            <?php echo number_format($so_percent_sold,decimals_()); ?>%
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-12 nopad">Tokens Sold</div>
                            <div style="float:left;height:18px; background: #f0f0f0; position: relative; width: 100%;">
                            <div  style="background:#77ffd3;position:absolute;top:0;left:0;float:left;height:18px; width: <?php echo number_format($so_percent_sold,decimals_()); ?>%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 pd-10 f-20">
                        <div class="col-md-4 text-right  m-t-10">
                            <?php echo number_format($token_revenue,decimals_()); ?>%
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-12 nopad">Token Revenue</div>
                            <div style="float:left;height:18px; background: #f0f0f0; position: relative; width: 100%;">

                            <div style="position:absolute;top:0;left:0;background:#77ffd3;float:left;height:18px; width: <?php echo number_format($token_revenue,decimals_()); ?>%;"></div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

   			

   			

    	</div>

    <?php } ?>


<?php require_once("common/footer.php");?>

<script language="javascript">

<?php if(ACTYPE == "1"){?>


    function openAlert(id)
{
    $(".cs-modal").hide();
    $("#alert_modal"+id).show();
}

function btnstatusupdate(val,id){

	var x = confirm("Are you sure you want to perform this action?");

	if (x){

		window.location='<?php echo base_url(); ?>admin/do/action/tranasctions/'+val+'/'+id;

		return true;

	}

	else {

		return false;

	}

}


function dFlip(period,cls)
{
    $('.'+cls).find(".d-flip").hide();
    $('.'+cls).find(".flip-control").find('a').css('color','#23527c');
    $('.'+cls).find(".d-flip-"+period).fadeIn();
    $('.'+cls).find(".flip-"+period).css('color','#000');

}
function __href(link)
{
    window.location = "<?php echo base_url(); ?>" + link;
}

 function closeModel()
{
    $(".modal-cs").hide();
}
function deletecampaign(id)
{
  $("#delete_trans_id").val(id);
  $(".delete_transaction").show();
  return; 
}

<?php } ?>




var upgradeTime = <?php echo $datediff_for_fooooter>0?$datediff_for_fooooter:0; ?>;
var seconds = upgradeTime;
function timer() {
    var days        = Math.floor(seconds/24/60/60);
    var hoursLeft   = Math.floor((seconds) - (days*86400));
    var hours       = Math.floor(hoursLeft/3600);
    var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
    var minutes     = Math.floor(minutesLeft/60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds; 
    }
    document.getElementById('d_days').innerHTML = days;
    document.getElementById('d_hours').innerHTML = hours;
    document.getElementById('d_minutes').innerHTML =  minutes;
    document.getElementById('d_seconds').innerHTML = remainingSeconds;
    if (seconds == 0) {
        clearInterval(countdownTimer);
        document.getElementById('d_days').innerHTML = "00";
    document.getElementById('d_hours').innerHTML ="00";
    document.getElementById('d_minutes').innerHTML = "00";
    document.getElementById('d_seconds').innerHTML = "00";
    } else {
        seconds--;
    }
}
var countdownTimer = setInterval('timer()', 1000);




</script>


<style type="text/css">
    .bgorange{
        background: orange;
    }
    .alert_inner
    {
        padding: 10px;
        float: left;
        width: 100%;
        }
    .not_alert_grayed_out .alert_inner{
        cursor: pointer;
    }
    .alert_grayed_out{
        color:grey;
    }
    .not_alert_grayed_out .alert_inner:hover{
        background:#dedede;

    }


</style>