<?php require_once("common/header.php");?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
               <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
            </div>
            <h4 class="page-title">Transaction Details</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <form method="POST" action="" accept-charset="UTF-8" id="form-profile">
            <input type="hidden" name="type" value="company">

            <div class="card-box widget-box-1">
                <h4 class="header-title m-t-0 m-b-30">Profile information</h4>
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
                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name</label>
                            <br>
                            <b><?php echo $user->uFname;?></b>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last Name</label>
                            <br>

                            <b><?php echo $user->uLname;?></b>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>E-mail</label>
                            <br>
                            
                            <b><?php echo $user->uEmail;?></b>
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                            <label>Username</label>
                            <br>
                            
                            <b><?php echo $user->uUsername;?></b>
                        </div>
                    </div>

                    
                   
                    
                </div>
            </div>







             <div class="card-box widget-box-1">
                <h4 class="header-title m-t-0 m-b-30">Transaction information</h4>
                <div class="row">
                   
                   
                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Transaction ID</label>
                            <br>
                            <b><?php echo $trans->transaction_id;?></b>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tokens</label>
                            <br>

                            <b><?php echo $trans->tokens;?></b>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Amount Paid</label>
                            <br>
                            
                            <b><?php echo $trans->amountPaid.' '; 
                                

                                $arrcur = array('id' => $trans->currency);
                                $cour = $this->front_model->get_query_simple('*','dev_web_payment_options',$arrcur);
                                $currency   = $cour->result_object();

                                echo $currency[0]->name;


                                ?>
                            </b>
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                            <label>Time</label>
                            <br>
                            
                            <b><?php echo date("m/d/y H:i:s",strtotime($trans->datecreated));?></b>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Hash</label>
                            <br>
                            
                            <b><?php echo $trans->hash;?></b>
                        </div>
                    </div>
                   

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Amount in USD</label>
                            <br>
                            
                            <b>$<?php echo $trans->usdPayment;?></b>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <br>
                            
                            <b>
                                <?php 
                                        if($trans->status == "1"){echo "<div class='status-pending'>Pending</div>";} 
                                        else if($trans->status == "2"){echo "<div class='status-confirm'>Confirmed</div>";} 
                                        else if($trans->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}
                                        else if($trans->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}
                                    ?>
                            </b>
                        </div>
                    </div>
                    
                </div>
            </div>




		
            </form>

 


        </div>
        <!-- end col -->

        <div class="col-md-2">
            <div class="card-box widget-box-1 text-center">

                <img width="150" src="<?php echo base_url().'resources/uploads/qr_codes/'.$trans->transaction_id.'.gif'; ?>" title="<?php echo $trans->transaction_id; ?>" />

            </div>
        </div>
        <!-- end col -->

    </div>
<?php require_once("common/footer.php");?>

<?php if(isset($_GET['type'])){?>
	<script language="javascript">
		 $("html, body").delay(400).animate({
        scrollTop: $('#passwordrequest').offset().top 
    }, 2000);
	</script>
<?php } ?>
<script language="javascript">
function confirmpassword_request(){
	if($("#newpass").val() != $("#confirmpass").val()){
		$("#upbtn").attr("disabled",true);
		$("#confirmerror").html('<div class="wrongerror">Password & New Password not matched!</div>');
	} else {
		$("#upbtn").attr("disabled",false);
		$("#confirmerror").html('');
	}
}
</script>
