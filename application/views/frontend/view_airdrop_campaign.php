<?php require_once("common/header.php");?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
               <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
            </div>
            <h4 class="page-title">Airdrop</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
          

            <div class="pre-box-bounty">
                <div class="b-1">
                    <p><?php echo number_format($bounty->bounty_qty/$bounty->bounty_persons,decimals_());; ?></p>
                    <small>Tokens</small>
                </div>
                <div class="b-2">
                    <p><?php  $submitted = $this->db->where('camp_id',$bounty->id)->where('status',1)->count_all_results('dev_web_airdrop_submissions');

                                        $raw_ = $bounty->bounty_qty/$bounty->bounty_persons;
                                        $submitted_2 = $raw_*$submitted;
                                        echo number_format($bounty->bounty_qty-$submitted_2,decimals_()); ?></p>
                    <small>Available</small>
                </div>
            </div>
            <div class="card-box widget-box-1">

                <h2><?php echo $bounty->name; ?> 


                   
                </h2>
                <?php /* ?>
                <div class="box-bounty">
                    <div class="box-bounty-inner box-bounty-inner-1">
                        <p><?php echo number_format($bounty->bounty_qty/$bounty->bounty_persons); ?></p>
                        <span> Tokens</span>
                    </div>
                    <div class=" box-bounty-inner box-bounty-inner-2">
                         <p><?php  $submitted = $this->db->where('camp_id',$bounty->id)->where('status',1)->count_all_results('dev_web_airdrop_submissions');

                                        $raw_ = $bounty->bounty_qty/$bounty->bounty_persons;
                                        $submitted_2 = $raw_*$submitted;
                                        echo number_format($bounty->bounty_qty-$submitted_2);; ?></p>
                        <span> Total Available</span>
                    </div>
                    <div class=" box-bounty-inner box-bounty-inner-3">
                         <p><?php echo $submitted; ?></p>
                        <span> Completed</span>
                    </div>
                </div>

                <?php */ ?>


                <div class="m-15 w100" >

                    <?php if($bounty->details){ ?>
                  

                    <p><?php echo $bounty->details; ?></p>
                    <?php } ?>
                </div>

                
                
            </div>
              <?php if($bounty->rules){ ?>

            <div class="card-box widget-box-1">

                <h2>
                        Instructions

                         <?php
                                        $already_submitted = $this->front_model->get_query_simple('*','dev_web_airdrop_submissions',array('uID'=>UID,'camp_id'=>$bounty->id))->num_rows();

                                        if($already_submitted==0){

                                         ?>
                    <a href="<?php echo base_url().'submit-airdrop-campaign/'.$bounty->id; ?>">
                        <button class="pull-right btn btn-default">Submit</button>
                    </a>

                    <?php } ?>


                    </h2>
                    <hr>
               <div class="m-15 w100">



                   
                    

                    <p ><?php echo $bounty->rules; ?></p>
                    
                </div>
            </div>
            <?php } ?>

          
        </div>
        <!-- end col -->

        <div class="col-md-3">

           

                    <div class="card-box widget-box-1 boxdisplay m-t-45">

                        <span>

                            <img src="<?php echo base_url();?>resources/uploads/campaigns/landing/<?php echo $camp_type->image; ?>" width="150" alt="">

                        </span>

                        <p><strong>
          
                           <?php  echo $camp_type->title;
                             ?>
                          

                        </strong></p>

                        <p title="<?php echo substr($camp_type->description, 0,1000); ?>">
                            <?php echo substr($camp_type->description, 0,6000); ?>
                        </p>

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

