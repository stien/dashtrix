<?php require_once("common/header.php");?>



    

	<?php if(ACTYPE == "2"){?>

  	<div class="row">

  		  	<div class="col-sm-12 m-b-30">

				<h4 class="page-title">Bounty Campaigns</h4>
				
			</div>

			

			<div class="row">


                <?php 

                $camps_ = $this->front_model->get_query_simple('*','dev_web_airdrop_cats',array('active'=>1))->result_object();

                foreach($camps_ as $ky=>$camp_){
                 ?>
                

				<a href="<?php echo base_url().'bounties/'.$camp_->slug; ?>">

				<div class="col-sm-3 m-b-30">

					<div class="card-box widget-box-1 boxdisplay min-ht-250">

						<span class="img-ht-100px">

							<img src="<?php echo base_url();?>resources/uploads/campaigns/landing/<?php echo $camp_->image; ?>" height="100" alt="">

						</span>

						<p><strong>
          
                           <?php  echo $camp_->title;
                             ?>
                          

                        </strong></p>

                        <p title="<?php echo substr($camp_->description, 0,1000); ?>">
                            <?php echo substr($camp_->description, 0,60); ?>
                        </p>

					</div>	

				</div>

				</a>

                <?php } ?>

				


			</div>

			

	</div>



    <?php } ?>



<?php require_once("common/footer.php");?>


