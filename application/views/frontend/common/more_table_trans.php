<?php require_once 'css_include.php'; ?>

                    <h3>Transaction of <?php echo date("d F, Y",strtotime($date)); ?></h3>
                    <div class="table-responsive">
                    <table  class="table table-actions-bar" id="reequests-tablee" style="margin-bottom: 50px !important;">

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

                    	<th >Action</th>
                    </tr>

                    	</thead>

                    	<?php


							$transctions 	= $trans;

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


