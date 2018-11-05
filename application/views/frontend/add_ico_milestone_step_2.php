<?php require_once("common/header.php");?>

	
   
    	<div class="row">
         <div class="col-sm-12 m-b-30">
        	<h4 class="page-title">Add ICO Milestone</h4>
    	</div>
    	</div>
    	<div class="row">

    		<div class="col-md-3"></div>
    		<div class="col-md-6">

    			<div class="box-buy-tokens-old">
   			
   					<h2 class="text-center">
                    Enter and save your milestones for this campaign below.  You can edit these at any time during your campaign. 

                    </h2>
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

   					<form method="post" action="">
                            <div class="row">
                                  

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Total Funding (USD): </label>
                                            <input name="total_funding" type="number"  step='0.01' class="form-control" required  >
                                        </div>
                                    </div>
                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Minimum Funding (USD): </label>
                                            <input name="min_funding" type="number"  step='0.01' class="form-control" required  >
                                        </div>
                                    </div>
                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Tokens Sold: </label>
                                            <input name="tokens_sold" type="number"  step='0.01' class="form-control" required  >
                                        </div>
                                    </div>


                                 
                                  

                                   

                                   <div class="col-md-12">
						            

						            <div class="col-md-3 right  m-t-40">
						                 <div class="form-group">
											<input type="hidden" id="option_id" name="option" value="">
												<button id="submit_btn" class="btn btn-default btn-block btn-sm "  type="submit">
						                              Next
						                        </button>
						                 </div>
						            </div>

                                    <div class="col-md-3 right m-t-40">
                                         <div class="form-group">
                                            <a href="<?php echo base_url().'admin/ico-milestones'; ?>">
                                                <button class="btn btn-danger btn-block btn-sm "  type="button">
                                                      Cancel
                                                </button>
                                            </a>
                                         </div>
                                    </div>
						            </div>
                                </div>
                        </form>
    			</div>

    		</div>

    	<div class="col-md-3"></div>


    	</div>

    
<?php require_once("common/footer.php");?>

