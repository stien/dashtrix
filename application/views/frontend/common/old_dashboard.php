<div class="row">

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




				<div class="col-sm-3 m-b-30">

					<div class="card-box widget-box-1 boxdisplay">

						<span  style="font-size: 60px;" title="<?php $my_tokens__ = get_my_tokens(UID); echo number_format($my_tokens__,decimals_());  ?>">
							<?php echo custom_number_format($my_tokens__,decimals_()); ?>
						</span>

						<p><strong>
          
                           <?php  echo $token_symbol->token_symbol?$token_symbol->token_symbol:'Token';
                             ?>
                         Balance

                        </strong></p>

					</div>	

				</div>

                <div class="col-sm-3 m-b-30">

                    <div class="card-box widget-box-1 boxdisplay">

						<span  style="font-size: 60px;">

							<?php $current_otken_price = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
							    echo '$'.number_format($current_otken_price->tokenPrice,decimals_());
                            ?>
						</span>

                        <p><strong>

                                Current Price

                            </strong></p>

                    </div>

                </div>


				<a href="<?php echo base_url();?>buy-tokens">

				<div class="col-sm-3 m-b-30">

					<div class="card-box widget-box-1 boxdisplay">

						<span style="font-size: 60px;">
<?php  echo $token_symbol->token_symbol?$token_symbol->token_symbol:'Token';
                             ?>
							

						</span>

						<p><strong>Buy <?php  echo $token_symbol->token_symbol?$token_symbol->token_symbol:' '; ?> Tokens</strong></p>

					</div>	

				</div>

				</a>

				<a href="<?php echo base_url();?>bounties">

				<div class="col-sm-3 m-b-30">

					<div class="card-box widget-box-1 boxdisplay">

						<span>

							<img src="<?php echo base_url();?>resources/frontend/images/bounties-icon.png" width="85" alt="">

						</span>

						<p><strong>View Bounties</strong></p>

					</div>	

				</div>

				</a>


			</div>

            <div class="row">






                <div class="col-sm-3 m-b-30">

                    <div class="card-box widget-box-1 boxdisplay bg64cbe0 crlfff">

						<span  style="font-size: 60px;">

							<?php

 $current_active_camp = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$current_otken_price->ico_camp))->result_object()[0];

    


$now = time(); // or your date as well

$your_date = strtotime(date("Y-m-d",strtotime($current_active_camp->end_date)));
$datediff = $your_date - $now;

$x_roun_day_left =  round($datediff / (60 * 60 * 24));

echo $x_roun_day_left>0?$x_roun_day_left:'No';


$text_for_this_one_div = $this->db->where('type','campaign_user_dashboard_text')->get('dev_web_meta')->result_object()[0];
if($text_for_this_one_div->value)
    $text_for_this_one_div=$text_for_this_one_div->value;
else
    $text_for_this_one_div ='PRE-ICO Days Remaining';

?>
						</span>

                        <p><strong>
                            <?php

                            echo $text_for_this_one_div;
                             ?>
                                

                            </strong></p>

                    </div>

                </div>

            <div class="col-sm-3 m-b-30">

                <div class="card-box widget-box-1 boxdisplay bg5d6afc crlfff">

						<span  style="font-size: 60px;">

							<?php echo $current_otken_price->tokenBonus.'%'; ?>
						</span>

                    <p><strong>

                           Current Bonus

                        </strong></p>

                </div>

            </div>
            <?php
            $ask_eth = $this->front_model->get_query_simple('*','dev_web_config',array())->result_object()[0];
             if($ask_eth->ask_eth==1){ ?>
                <div class="col-sm-3 m-b-30">

                    <?php $ms_as_user = $this->front_model->get_query_simple('*','dev_web_user',array('uID'=>UID))->result_object()[0]; ?>
                    <?php if(!$ms_as_user->uWallet){ ?>
                        <a href="<?php echo base_url().'account/details'; ?>">
                    <?php } ?>
                    <div class="card-box widget-box-1 boxdisplay bg5d6afc crlfff <?php if($ms_as_user->uWallet) echo "bggreen"; else echo "bgred"; ?>">

						<span  style="font-size: 60px;">
                            <?php if($ms_as_user->uWallet) echo "Set"; else echo "Not Set"; ?>

						</span>

                        <p><strong>

                                Wallet Address

                            </strong></p>

                    </div>
                    <?php if(!$ms_as_user->uWallet){ ?>
                    </a>
                    <?php } ?>

                </div>
            <?php } ?>


                <div class="col-sm-3 m-b-30" style="min-height: 210px;">
                    <?php

                     if($user_verified==0){ ?>
                        <a href="<?php echo base_url().'verify'; ?>">
                     <?php } ?>
                    <div style="min-height: <?php if($user_verified==0) echo 190; else echo 189; ?>px;" class="card-box widget-box-1 boxdisplay bg5d6afc crlfff <?php if($user_verified==1) echo "bggreen"; else if($user_verified==2) echo "bgred"; else echo "bgorange";  ?>">

						<span  style="font-size: <?php if($user_verified==0) echo "30"; else echo "30"; ?>px;">
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

                <?php

                $conf_dash = $this->db->limit(1)->get('dev_web_config')->result_object()[0];
                if($conf_dash->telegram){
                 ?>
                
                <div class="col-sm-3 m-b-30" >
                 
                    <a target="_blank" href="<?php echo $conf_dash->telegram; ?>">                  
                        <div style="min-height: 189px;" class="card-box widget-box-1 boxdisplay">
                            <span  >
                            <img style="height: 84px;" src="<?php echo base_url().'resources/frontend/images/telegram.png'; ?>">
                            </span>
                            <p><strong>

                                Telegram
                            </strong></p>
                        </div>                   
                    </a>
                     
                   

                </div>
                <?php } ?>

                    <a href="<?php echo base_url();?>my-referral-url">

                <div class="col-sm-3 m-b-30">

                    <div class="card-box widget-box-1 boxdisplay" style="min-height: 190px;">

                        <span>

                            <img src="<?php echo base_url();?>resources/frontend/images/ref-url.png" width="85" alt="">

                        </span>

                        <p><strong>My Referral URL</strong></p>

                    </div>  

                </div>

                </a>




        </div>

			

	</div>

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
