<?php require_once("common/header.php");?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
               <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
            </div>
            <h4 class="page-title">CREATE SMART CONTRACT (ETH):</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="" accept-charset="UTF-8" id="form-profile">
            <input type="hidden" name="type" value="company">

            <div class="card-box widget-box-1">
                <h4 class="header-title m-t-0 m-b-30">CREATE SMART CONTRACT (ETH)</h4>
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


                    <?php if($step==1){ ?>
                   
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Token Name</label>
                            <input class="form-control" name="token_name" value="<?php echo $_SESSION['contract']['step1']['token_name']; ?>" required type="text">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Token Symbol</label>
                            <input class="form-control" name="token_symbol" value="<?php echo $_SESSION['contract']['step1']['token_symbol']; ?>" required type="text">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>ICO Start Date</label>
                            <input class="form-control birth_date" name="ico_start_date" value="<?php echo $_SESSION['contract']['step1']['ico_start_date']; ?>" required type="text">
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>ICO End Date</label>
                            <input class="form-control birth_date" name="ico_end_date" value="<?php echo $_SESSION['contract']['step1']['ico_end_date']; ?>" required type="text">
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Min CPA in ETH</label>
                            <input class="form-control" name="min_cpa_in_eth" value="<?php echo $_SESSION['contract']['step1']['min_cpa_in_eth']; ?>" required type="text">
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tokens per ETH</label>
                            <input class="form-control" name="tokens_per_eth" value="<?php echo $_SESSION['contract']['step1']['tokens_per_eth']; ?>" required type="text">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Max Token supply</label>
                            <input class="form-control" name="max_token_supply" value="<?php echo $_SESSION['contract']['step1']['max_token_supply']; ?>" required type="text">
                        </div>
                    </div>

                    <?php }elseif($step==2){ ?>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Phase Name</label>
                            <input class="form-control" name="phase_name" value="<?php echo $_SESSION['contract']['step1']['phase_name']; ?>" required type="text">
                        </div>
                    </div>

                     <div class="col-md-12">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input class="form-control birth_date" name="start_date" value="<?php echo $_SESSION['contract']['step1']['start_date']; ?>" required type="text">
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>End Date</label>
                            <input class="form-control birth_date" name="end_date" value="<?php echo $_SESSION['contract']['step1']['end_date']; ?>" required type="text">
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Max Token supply</label>
                            <input class="form-control" name="max_token_supply_2" value="<?php echo $_SESSION['contract']['step1']['max_token_supply_2']; ?>" required type="text">
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>ContractAddress</label>
                            <input class="form-control" name="contract_address" value="<?php echo $_SESSION['contract']['step1']['contract_address']; ?>" required type="text">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>NotifierPrivateKey</label>
                            <input class="form-control" name="notifier_private_key" value="<?php echo $_SESSION['contract']['step1']['notifier_private_key']; ?>" required type="text">
                        </div>
                    </div>


                    <?php }else{ ?>

                     <div class="col-md-12">
                        <div class="form-group">
                            <label>Owner Ethereum Address</label>
                            <input class="form-control" name="owner_ethereum_address" value="<?php echo $_SESSION['contract']['step1']['owner_ethereum_address']; ?>" required type="text">
                        </div>
                    </div>


                    <?php } ?>
                 
                  
                 
                    
                    
                    
                </div>
            </div>
			 <div class="row" >
                <div class="col-md-12 m-b-30">



                    <div class="button-list pull-right m-t-15 m-l-15">
                        <button class="btn btn-default submit-form" type="submit" >

                            <?php if($step!=3){ ?>
                            Next <span class="m-l-5"><i class="fa fa-arrow-right"></i></span>

                            <?php }else{ ?>
                            Submit
                            <?php } ?>
                        </button>
                    </div>

                    <?php if($step!=1){ ?>
               
                    <div class="button-list pull-right m-t-15 m-l-15">
                        <a href="<?php echo base_url().'admin/create-smart-contract'; ?>">
                            <button class="btn btn-danger" type="button" ><span class="m-r-5"><i class="fa fa-arrow-left"></i></span>Previous</button>
                        </a>
                    </div>

                    <?php } ?>
                </div>
            </div>
            </form>




           
        </div>
        <!-- end col -->

        <div class="col-md-4">
          
        </div>
        <!-- end col -->

    </div>
<?php require_once("common/footer.php");?>
<script>

    $(document).ready(function() {



        $('.birth_date').datepicker({

            format: 'yyyy-mm-dd'

           

        });

    });

</script>

