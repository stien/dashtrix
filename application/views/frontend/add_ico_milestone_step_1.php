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
                    Select your ICO campaign

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
                                            <label>Select Campaign: </label>
                                            <?php if(empty($campaigns)){ ?>
                                                <span >No Campaign creatd, please consider creating a campaign first to set milestone(s). You may create it by <a href="<?php echo base_url().'admin/add-ico-setting'; ?>">clicking here</a></span>
                                            <?php } ?>
                                            <select  class="form-control" name="campaign" required="">
                                                <?php foreach($campaigns as $campaign){ ?>
                                                    <option value="<?php echo $campaign->id; ?>">
                                                        <?php echo $campaign->title; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                           
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

