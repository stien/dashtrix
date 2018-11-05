<?php require_once("common/header.php");?>
<div class="row">

         <div class="col-sm-12 m-b-30">


            <h4 class="page-title">Receipts


            </h4>

        </div>

    </div>
    <div class="row">



    </div>
  
    
<div class="row">

         <div class="col-sm-12 m-b-30">

            <h4 class="page-title">All Receipts


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

                <div class="table-responsive">

                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">

                    	<thead>

                    	<tr>



                    	<th >Username</th>

                    	<th >Tokens</th>

                    	<th >Currency</th>

                    	<th >Amount Paid</th>

                    	<th >Date</th>

                    	

                    	<th >Action</th>
                    </tr>

                    	</thead>

                    	

                    	<tbody>

                    	<?php 

							foreach($receipts AS $row){

								$arrcur = array('curID' => $row->currency);

								$cour = $this->front_model->get_query_simple('*','dev_web_currency',$arrcur);

								$currency 	= $cour->result_object();

								//echo $row->datecreated;

								$arusr = array('uID' => $row->uID);

								$usrqry = $this->front_model->get_query_simple('*','dev_web_user',$arusr);

								$user 	= $usrqry->result_object();

						?>

                    		<tr>


                                


                    			<td><?php echo $user[0]->uUsername;?></td>

                    			<td><?php echo $row->tokens;?></td>

                    			<td><?php echo $currency[0]->currencyName;?></td>

                    			<td><?php echo $row->amountPaid;?> <?php echo $row->amtType;?></td>

                    			<td><?php echo date("m/d/y",strtotime($row->datecreated));?></td>

                    			

                    			<td>

                    				

                    				<a  download href="<?php echo base_url().'resources/uploads/private_files/'.$row->receipt_name; ?>">
                                        <button type="button" class="btn btn-default" > <i class="fa fa-download"></i>
                                    Download
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


<?php require_once("common/footer.php");?>


