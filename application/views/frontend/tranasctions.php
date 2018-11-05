
<?php require_once("common/header.php");?>





<?php /*?>        <!-- Page-Title -->

<div class="row">

    <div class="col-sm-12 m-b-30">

        <div class="button-list pull-right m-t-15">

            <a class="btn btn-white" href="requests-group.html">Join group request</a>

            <a class="btn btn-default" href="requests-draft-create.html">Create request</a>

        </div>



        <h4 class="page-title">Dashboard</h4>

        <p class="text-muted">Hello <b>Inspiron Trade</b>!</p>

    </div>

</div>

<div class="row">

    <div class="col-md-8">



        <div class="card-box widget-box-1">

            <h4 class="header-title m-t-0">Requests</h4>



        </div>



    </div>

    <!-- end col -->



    <div class="col-md-3 col-md-offset-1">

        <div class="widget-box-2">

            <h4 class="header-title m-t-0">Account</h4>

            <p class="text-muted font-13">

                You are currently on starter plan.

            </p>

            <a href="packages.html" type="button" class="btn btn-white waves-effect">Upgrade package</a>

            <hr>

            <h4 class="header-title m-t-0 m-b-15">Help</h4>

            <a href="#" class="font-13">Energy Premier guide</a>

            <br />

            <a href="#" class="font-13">Get started</a>

            <hr>

            <h4 class="header-title m-t-0 m-b-15">Blog</h4>

            <a href="#" class="font-13">Blog article name</a>

            <br />

            <a href="#" class="font-13">Blog sample</a>

            <br />

            <a href="#" class="font-13">Sample article</a>

        </div>

    </div>

    <!-- end col -->

</div><?php */?>







    

	<?php if(ACTYPE == "2"){?>

  	

   <div class="row">

         <div class="col-sm-12 m-b-30">

        <div class="button-list pull-right m-t-15">

            <a class="btn btn-default" href="<?php echo base_url().'buy-tokens'; ?>">Buy Tokens</a>

        </div>



        <h4 class="page-title">Transactions</h4>

    </div>

    </div>

    <div class="row">

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

    <?php } ?>



<?php require_once("common/footer.php");?>

