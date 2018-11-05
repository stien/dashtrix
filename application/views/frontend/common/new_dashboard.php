<div class="row">
  <?php  $current_otken_price = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
$ico_settings_ = $this->db->where('active',1)->get('dev_web_ico_settings')->result_object();

   ?>
  		  	<div class="col-sm-12 m-b-30" style="text-align: center;">

				<h4 class="page-title">
                    <?php if(am_i('securix')){

                        $text_to_here = $this->db->get('dev_web_config')->result_object()[0];

                        echo $text_to_here->welcome_heading;

                    }else{ ?>
                WELCOME TO OUR ICO
            <?php } ?>
            </h4>
            <?php if(am_i('securix') && $text_to_here->welcome_body){  ?>
                <p class="text-center"><?php echo $text_to_here->welcome_body; ?></p>
            <?php } ?>

			</div>

			<div class="row">

            <div class="col-md-6 col-sm-12 col-xs-12 m-b-30">
                <div class="card-box easy">
                    <div class="col-md-12 col-sm-12 nopad">
                        <h2 class="text-center bold-text "><?php if(am_i('securix')){

                            echo $web_settings->configTitle. ' - '.$current_otken_price->tokenBonus.'%'. ' Active Bonus';

                        } else {
                            echo $ico_settings_[0]->title . ' - Sale';
                        } ?></h2>
                        <span class="text-center easy clr_grey">Price 

                (<?php
                                                $ico_settings = $this->db->where('active',1)->get('dev_web_ico_settings')->result_object();
                                                if(!empty($ico_settings))
                                                {
                                                    $token_name = $ico_settings[0]->token_symbol;
                                                }
                                                else
                                                {
                                                    $token_name = "Token";
                                                }

                                                  $this->data['active_token']=$this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];

                                                $price_should_be=$this->data['active_token']->tokenPrice;
                    if($this->data['active_token']->currency_type=="USD")
                    echo 1 .' '. $token_name . ' = '. $price_should_be . ' USD';
                    else
                    echo 1 .' '. $token_name . ' = '. $price_should_be * 100 . '% of current '.$this->data['active_token']->currency_type.' price';
                //.$this->data['active_token']->currency_type




                                             ?>)

              <?php 
                                //echo '$'.number_format($current_otken_price->tokenPrice,decimals_());
                            //echo $token_symbol->token_symbol?$token_symbol->token_symbol:'Token'; 



 $current_active_camp = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$current_otken_price->ico_camp))->result_object()[0];

    
$now = time(); // or your date as well
// echo date("Y-m-d H:i:s",time());

$_collected_date = date("Y-m-d",strtotime($current_otken_price->tokenDateEnds)). ' '. $current_otken_price->end_time;


$your_date = strtotime(date("Y-m-d H:i:s",strtotime($_collected_date)));
$datediff_for_fooooter = $your_date - $now;


                             ?></span>
        </div>
        <div class="col-md-12 col-sm-12 nopad m-t-15">
            <div class="col-md-3">
                <div class="time_box easy">
                    <div class="time_box_main_text  bold-text" id="d_days">
                        00
                    </div>
                    <div class="time_box_sub_text">
                        Days
                    </div>
                </div>
            </div>

            <div class="col-md-3  col-sm-12">
            
                <div class="time_box easy">
                    <div class="time_box_main_text  bold-text" id="d_hours">
                        00
                    </div>
                    <div class="time_box_sub_text">
                        Hours
                    </div>
                </div>
            </div>
            <div class="col-md-3  col-sm-12">
                <div class="time_box easy">
                    <div class="time_box_main_text  bold-text" id="d_minutes">
                        00
                    </div>
                    <div class="time_box_sub_text">
                        Minutes
                    </div>
                </div>
            </div>
            <div class="col-md-3  col-sm-12">
           
                <div class="time_box easy">
                    <div class="time_box_main_text  bold-text" id="d_seconds">
                        00
                    </div>
                    <div class="time_box_sub_text">
                        Seconds
                    </div>
                </div>
            </div>
            </div>

            <div class="col-md-12  col-sm-12 m-t-30 text-center">
                <a href="<?php echo base_url().'buy-tokens'; ?>">
                    <button type="button" class="dashboard-buy-tokens">Buy Tokens</button>
                </a>

            </div>
            <div class="col-md-12  col-sm-12 text-center  m-t-20">
                <span class="text-center easy clr_grey">
                    We accept: <?php
                    $we_accepts = $this->db->where('active',1)->get('dev_web_payment_options')->result_object();
                    foreach($we_accepts as $k=>$we_accept){
                        echo $we_accept->c_name;
                        if($k!=count($we_accepts)-1)
                             echo ', ';
                    }

                     ?>
                </span>

              <hr>Currently raised: <h3>
                <?php 

            // let's get actual coin purchases (status 2)

            $sale_bar_duex = $this->db->get('dev_web_transactions')->result_object();
            $currentSales = 0;

            foreach($sale_bar_duex as $value)
                        {
                      if($value->status == '2')
                         $currentSales = $currentSales + $value->usdPayment;
                        }

                    setlocale(LC_MONETARY,"en_US");
                    echo '<strong>'.money_format("%n", $currentSales).' USD</strong>.';
                    //echo $currentSales; 
                    ?>
                </h3>

            </div>

            <?php

            $sale_bar_ = $this->db->get('dev_web_sale_bar')->result_object();

            if(empty($sale_bar_))
                $sale_bar_active = 0;
            else
                $sale_bar_active = $sale_bar_[0]->sale_active;
            $sale_bar_ = $sale_bar_[0];

             if(!am_i('securix')){
                 if($sale_bar_active==0){

              ?>

             <div class="col-md-12  col-sm-12 text-center m-t-20">
                <span class="clr_grey pull-right bold-text">
                    <?php
                    echo custom_number_format($current_otken_price->tokens_sold,0). " out of ".custom_number_format($current_otken_price->tokenCap,0);

                     ?>
                </span>
                
             </div>
             <div class="col-md-12 col-sm-12 text-center">
                <div class="progress-bar-dashboard-token-sale">
                    <div class="progress-bar-dashboard-token-sale-inner" style="width: <?php
                    $percent_sooold = (($current_otken_price->tokens_sold/$current_otken_price->tokenCap) * 100);
   
                    if($percent_sooold > 0 && $percent_sooold < 100)
                        echo $percent_sooold;
                    else{
                        if($percent_sooold > 100)
                            echo "100";
                        else
                            echo "0";
                    } ?>%;"></div>

                </div>
             </div>
           <div class="col-md-12 col-sm-12 text-center">
               <span class="clr_grey pull-left">SoftCap</span> 
               <span class="clr_grey pull-right">HardCap</span>
           </div>
            
           <div class="col-md-12 text-center m-t-20 clr_grey">
                Pre-Sale end on <?php echo date("F d, Y",strtotime($current_otken_price->tokenDateEnds)); ?>.
           </div>

       <?php }else{ ?>

        <div class="col-md-12  col-sm-12 text-center m-t-30">
                <hr />
             </div>

             <div class="col-md-12  col-sm-12 text-center m-t-20">
                <span class="clr_grey pull-right bold-text">
                    <?php
                    echo custom_number_format($sale_bar_->tokens_sold,0). " out of ".custom_number_format($sale_bar_->max_cap,0);

                     ?>
                </span>
                
             </div>
             <div class="col-md-12 col-sm-12 text-center">
                <div class="progress-bar-dashboard-token-sale">
                    <div class="progress-bar-dashboard-token-sale-inner" style="width: <?php
                    $percent_sooold =($sale_bar_->tokens_sold / $sale_bar_->max_cap)*100;
   
                    if($percent_sooold > 0 && $percent_sooold < 100)
                        echo $percent_sooold;
                    else{
                        if($percent_sooold > 100)
                            echo "100";
                        else
                            echo "0";
                    }


                     ?>%;"></div>

                </div>
             </div>
           <div class="col-md-12 col-sm-12 text-center">
               <span class="clr_grey pull-left">SoftCap</span> 
               <span class="clr_grey pull-right">HardCap</span>
           </div>
            
                <?php }  } ?>

            </div>

        </div>

				<div class="col-md-2   col-sm-12">

					<div class="card-box widget-box-1 boxdisplay fixed_db_box" >

						<span   title="<?php

                    $price_should_be_my_balance=$current_otken_price->tokenPrice;
                    if($current_otken_price->currency_type!="USD")
                        $price_should_be_my_balance=calculate_price_should_be($current_otken_price);

                         $my_tokens__ = get_my_tokens(UID); echo number_format($my_tokens__,decimals_());  ?>">
							<?php echo custom_number_format($my_tokens__,decimals_()); ?>
						</span>

						<p><strong>
          
                           <?php  echo $token_symbol->token_symbol?$token_symbol->token_symbol:'Token';
                             ?>
                         Balance

                        </strong>
                    </p>
                    <p style="color:red">
                        <?php echo "=" . ' ' . number_format($price_should_be_my_balance * $my_tokens__ ). " USD"; ?>
                    </p>  

					</div>	

				</div>

<!-- 
            <div class="col-md-2  col-sm-12">
 
                <div class="card-box widget-box-1 boxdisplay bg5d6afc crlfff fixed_db_box" >

                        <span  >

                            <?php echo $current_otken_price->tokenBonus.'%'; ?>
                        </span>

                    <p><strong>

                           Current Bonus

                        </strong></p>

                </div>

            </div> -->

                <div class="col-md-2  col-sm-12" >
                    <?php

                     if($user_verified==0){ ?>
                        <a href="<?php echo base_url().'verify'; ?>">
                     <?php } ?>
                    <div class="fixed_db_box card-box widget-box-1 boxdisplay bg5d6afc crlfff <?php if($user_verified==1) echo "bggreen"; else if($user_verified==2) echo "bgred"; else echo "bgorange";  ?>">

                        <span  >
                          <?php if($user_verified==1) echo "Verified"; else if($user_verified==2) echo "Rejected"; else echo "Not Verified";  ?>

                        </span>

                        <p><strong>

                                Account Status
                            </strong></p>

                    </div>
                     <?php if($user_verified==0){ ?>
                        </a>
                     <?php } ?>

                </div>

            
<!--     <div class="col-md-3  col-sm-12">
        <form method="post" action="<?php echo base_url(); ?>ico/save_eth" class="easy">
                    <div class="card-box widget-box-1 boxdisplay easy fixed_db_box"  >

                        <span style="padding-bottom: 7px;"> 

          <h4 class="text-center"  style="margin-bottom: 0px;">My ETH Address</h4>

                            <div class="form-group " style="margin-bottom: 0px;">
                                <input value="<?php echo $user_own_details->uWallet; ?>" type="text" name="eth" required="" class="form-control">
                                <input type="submit" name="save" value="Save" class="pull-right btn-sm m-t-10"  style="border:1px solid #cccccc;">
                            </div>
                            
                                
                            

                        </span>

                         

                    </div>  
</form>
                </div> -->


<div class="col-md-2  col-sm-12">
<a href="<?php echo base_url();?>bounties">
                    <div class="card-box widget-box-1 boxdisplay fixed_db_box"  >

                        <span>

                            <img src="<?php echo base_url();?>resources/frontend/images/bounties-icon.png" width="85" alt="">

                        </span>

                        <p><strong>View Bounties</strong></p>

                    </div>  
</a>
                </div>



        </div>

			

	</div>
































<style type="text/css">
    .fixed_db_box{
         height: 160px; 
         margin-bottom: 44px;
    }
</style>



























   <div class="row">

         <div class="col-sm-12 m-b-30">

        <div class="button-list pull-right m-t-15">

            <a class="btn btn-default" href="<?php echo base_url().'buy-tokens'; ?>">Buy Tokens</a>

        </div>



        <h4 class="page-title">Transactions</h4>

    </div>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="card-box m-b-50">

                <div class="table-responsive">

                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">

                    	<thead>

                    	<tr>
                        <th>Trans. Type</th>
                    	<th >Date</th>


                    	<th >Tokens</th>

                    	<th >Currency</th>

                    	<th >Amount Paid</th>

                    	<th >Status </th>

                    	<th >Action</th></tr>

                    	</thead>

                    	<?php

							$arr = array('uID' => UID);

							$config = $this->front_model->get_query_simple('*','dev_web_transactions',$arr);

							$transctions 	= $config->result_object();

                            // echo $this->db->last_query();

						?>

                    	<tbody>

                    	<?php 

							foreach($transctions AS $row){


								$arrcur = array('id' => $row->currency);

								$cour = $this->front_model->get_query_simple('*','dev_web_payment_options',$arrcur);

								$currency 	= $cour->result_object();

								//echo $row->datecreated;

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

                    			<td><?php echo date("m/d/y",strtotime($row->datecreated));?></td>

                    			<td><?php echo $row->tokens;?></td>

                    			<td><?php echo $currency[0]->name;?></td>

                    			<td><?php echo $row->amountPaid;?> <?php echo $row->amtType;?></td>

                    			<td><?php 

										if($row->status == "1"){echo "<div class='status-pending'>Pending</div>";} 

										else if($row->status == "2"){echo "<div class='status-confirm'>Confirmed</div>";} 

										else if($row->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}

										else if($row->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}

									?>

                   				</td>

                    			<td>

                                    <a href="<?php echo base_url().'transaction-details/'.$row->tID; ?>">

                                        <button class="btn btn-sm btn-default">

                                            View Details

                                        </button>

                                       

                                    </a>

                            </td>

                    		</tr>

                    	<?php } ?>

                    	</tbody>

                    </table>

                </div>

            </div>



        </div> <!-- end col -->

    </div>
