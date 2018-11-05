<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">
        <div class="button-list pull-right m-t-15">
            <a class="btn btn-default" href="<?php echo base_url();?>admin/add/token/pricing/type"><i class="fa fa-plus"></i> Pricing Template</a>
        </div>

        <?php 
        $c_p_link = 'token-pricing';
        require_once 'common/import_export.php'; ?>

        <h4 class="page-title">Token Pricing Templates</h4>
    </div>
    <?php if(am_i("lib")){ ?>
<div class="col-sm-12 ">
<div class="card-box m-b-50" style="clear: both;"> 
    <div class="col-md-12">
        <p>
            How would you like to charge the tokens purchased from two rounds? According to each pricing template price, or according to current/first template price?

            <label style="font-style: italic;">
                <i class="fa fa-info"></i> Currently it's being charged as: <?php if($web_settings->charge_round==1){ echo " According to each pricing template price"; } else {

                    echo "According to current/first template price";
                }; ?>
            </label>
        </p>
    </div>
        <?php


           
            
            if($web_settings->charge_round==1){
                ?>


                <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Make Charge According To Current Template Only </strong></label>
                    <a href="<?php  echo base_url().'ico/charge_round/0'; ?>">
                        <button  type="button" class="btn btn-primary right">Update</button>
                    </a>
                </div>

            <?php }else{ ?>


                <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Make Charge According To Each Template </strong></label>
                    <a href="<?php  echo base_url().'ico/charge_round/1'; ?>">
                        <button type="button"  class="btn btn-primary right">Enable</button>
                    </a>
                </div>

            <?php } ?>
        </div>
    </div>
<?php } ?>
    </div>
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

            <?php
                $arrcount = array('status'=>1);
                $configcount = $this->front_model->get_query_orderby('*','dev_web_token_pricing',$arrcount,'status','DESC');
                $countqry   = $configcount->result_object();
            ?>
            <?php if(count($countqry) == "0"){?>
            <div class="col-md-12">
                <div class="form-group">
                    <div class="errornotification">
                        No token status is active. Atleast one token should be active.
                    </div>
                </div>
            </div>
            <?php } ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box m-b-50">
               
            
            <div class="table-responsive">
                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">
                    	<thead>
                    	<tr>
                    	
                        <th >Campaign</th>
                    	<th >Token Price</th>
                    	<th >Start at</th>
                    	<th >End at</th>
                        <th >Timezone</th>

                        <th >Min. Invest. Amount</th>
                        <th >Max. Invest. Amount</th>
                        <th >Token Cap</th>
                    	<th >Tokens Sold</th>
                    	<th >Created Date</th>
                        <th >Status </th>
                      
                    	<th >Action</th></tr>
                    	</thead>
                    	<?php
							$arr = array();
							$config = $this->front_model->get_query_orderby('*','dev_web_token_pricing',$arr,'status','DESC');
							$transctions 	= $config->result_object();
						?>
                    	<tbody>
                    	<?php 
							foreach($transctions AS $row){
								$arucon = array('id' => $row->uCountry);
								$conqry = $this->front_model->get_query_simple('*','dev_web_countries',$arucon);
								$countries 	= $conqry->result_object();	
								
								$arusr = array('uID' => $row->uID);
								$usrqry = $this->front_model->get_query_simple('*','dev_web_transactions',$arusr);
								$user 	= $usrqry->result_object();



                                $ico_camp = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$row->ico_camp))->result_object()[0];
						?>
                    		<tr>
                                <td><?php echo $ico_camp->title;?></td>

                    			
                    			<td>
                                    <?php if($row->currency_type=="USD"){ ?>

                                    $<?php echo $row->tokenPrice;?> (per Token)
                                <?php }else{ ?>
                                    1 Token per <?php echo $row->tokenPrice * 100; ?>% of current <?php echo $row->currency_type; ?> price
                                <?php } ?>

                                </td>
                    			<td><?php if($row->tokenDateStarts != ""){echo date("m/d/y",strtotime($row->tokenDateStarts));}
                                    echo ' '.date("h:i A",strtotime($row->start_time));
                                ?>
                            

                                </td>
                    			<td><?php if($row->tokenDateEnds != ""){echo date("m/d/y",strtotime($row->tokenDateEnds));}
                                    echo ' '.date("h:i A",strtotime($row->end_time));
                                ?></td>
                                <td><?php echo $row->timezone?$row->timezone:'--';?></td>
                                <td>$<?php echo $row->min_invest;?></td>
                                <td>$<?php echo $row->max_invest;?></td>
                                <td><?php echo $row->tokenCap;?></td>
                    			<td><?php echo $row->tokens_sold;?></td>
                    			<td><?php echo date("m/d/y",strtotime($row->addedDate));?></td>
                    			
                    			<td><?php 
										if($row->status == "0"){echo "<div class='status-pending'>In-Active</div>";} 
										else if($row->status == "1"){echo "<div class='status-confirm'>Active</div>";} 
										//else if($row->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}
										//else if($row->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}
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
									  <?php if($row->status == "0"){ ?>
									  	<li>
											<a href="javascript:;" onClick="btnstatusactive(<?php echo $row->tkID;?>);">Active</a>
										</li>
										<?php } ?>
                                        <li>
                                            <a href="<?php echo base_url().'admin/manage-bonuses/'.$row->tkID; ?>" >Bonuses</a>
                                        </li>
										<li>
											<a href="javascript:;" onClick="btnstatusupdate(<?php echo $row->tkID;?>);">Delete</a>
										</li>
                                        <li>
                                            <a href="<?php echo base_url().'admin/edit-token-pricing/'.$row->tkID ?>">Edit</a>
                                        </li>
										
										<?php /*?><li><a href="javascript:;" onClick="btnstatusdelete(<?php echo $row->uID;?>);">Delete</a></li><?php */?>
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
<?php require_once("common/footer.php");?>
<script language="javascript">
<?php if(ACTYPE == "1"){?>
function btnstatusupdate(val){
	var x = confirm("Are you sure you want to perform this action?");
	if (x){
		window.location='<?php echo base_url(); ?>ico/remove_token_price/'+val;
		return true;
	}
	else {
		return false;
	}
}
function btnstatusactive(val){
	var x = confirm("Are you sure you want to activate this token price? Others will automatically will be marked as In-Active");
	if (x){
		window.location='<?php echo base_url(); ?>ico/active_token_price/'+val;
		return true;
	}
	else {
		return false;
	}
}
<?php } ?>
</script>
