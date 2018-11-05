
<?php require_once("common/header.php");?>
	<?php if(ACTYPE == "1"){?>
   <div class="row">
         <div class="col-sm-12 m-b-30">
        	<h4 class="page-title">MY DIRECTORY PURCHASES</h4>
    	</div>
    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="card-box m-b-50">

                <div class="table-responsive">

                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">

                    	<thead>

                    	<tr>
                        <th>Purchase Item</th>
                    	<th >Price</th>
                    	<th >Status </th>
                    	</tr>

                    	</thead>

                    	<?php
							$arr = array('uID' => UID);
							$config = $this->front_model->get_query_simple('*','dev_web_ico_directory_submissions',$arr);
							$transctions 	= $config->result_object();
						?>
                    	<tbody>

                    	<?php 
							foreach($transctions AS $row){
								$arrcur = array('sID' => $row->sID);
								$cour = $this->front_model->get_query_simple('*','dev_web_ico_directory_data_user',$arrcur);
								$currency 	= $cour->result_object();
								foreach($currency as $idm){
									$arrcurdd = array('dID' => $idm->iData);
									$courdd = $this->front_model->get_query_simple('*','dev_web_ico_directory',$arrcurdd);
									$currencydad 	= $courdd->result_object();
									$iddata .= $currencydad[0]->dTitle.", ";
								}
						?>
                    		<tr>
                                <td><?php echo substr($iddata,0,-2);?></td>
                    			<td><i class="fa fa-dollar"></i><?php echo $row->totalPrice;?></td>
                    			<td><?php 
										if($row->status == "1"){echo "<div class='status-pending'>Pending</div>";} 
										else if($row->status == "2"){echo "<div class='status-confirm'>Confirmed</div>";} 
										else if($row->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}
										else if($row->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}
									?>
                   				</td>
                    		</tr>

                    	<?php } ?>

                    	</tbody>

                    </table>

                </div>

            </div>



        </div> <!-- end col -->

    </div>

    <?php } ?>



<?php require_once("common/footer.php");?>

