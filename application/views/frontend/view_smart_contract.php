<?php require_once("common/header.php");?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
               <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
            </div>
            <h4 class="page-title">View Smart Contract</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">


            <div class="card-box widget-box-1">
                <h4 class="header-title m-t-0 m-b-30">View Smart Contract</h4>
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
                            <label>Token Name</label>
                            <p><?php echo $contract->token_name; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ICO Start Date</label>
                            <p><?php echo $contract->ico_start_date; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ICO End Date</label>
                            <p><?php echo $contract->ico_end_date; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Min CPA in ETH</label>
                            <p><?php echo $contract->min_cpa_in_eth; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tokens per ETH</label>
                            <p><?php echo $contract->tokens_per_eth; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Max Token supply</label>
                            <p><?php echo $contract->max_token_supply; ?></p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phase Name</label>
                            <p><?php echo $contract->phase_name; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Start Date</label>
                            <p><?php echo $contract->start_date; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>End Date</label>
                            <p><?php echo $contract->end_date; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Max Token supply</label>
                            <p><?php echo $contract->max_token_supply_2; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ContractAddress</label>
                            <p><?php echo $contract->contract_address; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>NotifierPrivateKey</label>
                            <p><?php echo $contract->notifier_private_key; ?></p>
                        </div>
                    </div>

                     <div class="col-sm-12">
                        <hr>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Owner Ethereum Address</label>
                            <p><?php echo $contract->owner_ethereum_address; ?></p>
                        </div>
                    </div>





                    
                  
                 
                    
                    
                    
                </div>
            </div>






           
        </div>
        <!-- end col -->

        <div class="col-md-4">
          
        </div>
        <!-- end col -->

    </div>
<?php require_once("common/footer.php");?>

<style type="text/css">
   body div div label{
        font-weight: bold !important;
    }
</style>
<script>

    $(document).ready(function() {



        $('.birth_date').datepicker({

            format: 'yyyy-mm-dd'

           

        });

    });

</script>

