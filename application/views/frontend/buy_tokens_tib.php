<?php require_once("common/header.php");
$_SESSION['kyc_lang']="en";
?>

	
   
    	<div class="row">
         <div class="col-sm-12 m-b-30">
        	<h4 class="page-title">Deposit Method</h4>
    	</div>
    	</div>
    	<div class="row">



    		<div class="col-md-2"></div>
    		<div class="col-md-8">

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
                    <div class="errornotification">
                        <?php echo $_SESSION['error'];?>
                    </div>
                </div>
            </div>
            <?php } ?>

    			<div class="box-buy-tokens-old">
    			<form method="post" action="">
    				<h3 class="text-center">
              <?php if($verified_or_not){ ?>
            Deposit Method
          <?php }else{ ?>
           Verify your E-mail first
          <?php } ?>
          </h3>
    				

            <?php







            if($verified_or_not){





            $currency_chosen=1;


            $work_or_not = 1;


            if($user_verified!=1){
              $work_or_not = 0;
            }

            if($kyc_verification_at!=2)
            {
              $work_or_not = 1;
            }



            if($kyc_verification_enabled==0)
              $work_or_not = 1;

            if(am_i('tib'))
               $work_or_not = 1;

           
           

            if(1==1){


              $__check_qs_accepted = $this->front_model->get_query_simple('*','dev_web_user_verification',array('uID'=>UID,'deleted'=>0))->result_object()[0];
              
              if(am_i('tib'))
              {
                if($__check_qs_accepted->accepted_qs!=1)
                  $work_or_not=0;
                if($__check_qs_accepted->verify_email!=1)                  
                  $work_or_not=0;
              }

            if($work_or_not==1)
                {
                    
              ?>


                <div class="col-md-12">
                  <div class="form-group">
                    <label class="easy" style="border: 1px solid #dedede; padding:5px; margin-bottom: 10px;">
                        <input required type="radio" name="type" value="1"> <?php echo get_lang_msg("cryptocurrency"); ?>


                    </label>
                  </div>
                  <div class="form-group">
                    <label class="easy" style="border: 1px solid #dedede; padding:5px; margin-bottom: 10px;">
                        <input required type="radio" name="type" value="2"> <?php echo get_lang_msg("wire_transfer"); ?>


                    </label>
                  </div>
                  <div class="form-group">
                    <label class="easy" style="border: 1px solid #dedede; padding:5px; margin-bottom: 10px;">
                        <input required type="radio" name="type" value="3"> <?php echo get_lang_msg("debit_credit_card"); ?>


                    </label>
                  </div>
                </div>




              <?php   
              }
            else{

             $show_popup_verification = true;
              } }else{ ?>
                <div class="" style="background: orange; text-align: center; padding: 10px 13px;">
              No currency type chosen. Please choose a currency type by click <a href="<?php echo base_url().'buy-tokens'; ?>">this link</a>
             </div>
              <?php }
            }
            else{

              ?>


<div class="card-box widget-box-1 boxdisplay">
  Your E-mail address isn't verified yet, please verify your E-mail by clicking "Verify" button in a E-mail sent to your provided E-mail address on time of signup with us.
  <br>
   <div class="form-group">
                        <a href="<?php echo base_url().'resend-verification-email'; ?>">
                            <button class="btn btn-default btn-block btn-lg" type="button" style="width: auto;
    float: none;
    margin: 0 auto;
    margin-top: 20px;">
                               Resend E-mail
                            </button>
                        </a>
                    </div>
</div>











              <?php 
            }





            if(empty($options)){
             ?>
            
             <div class="" style="background: orange; text-align: center; padding: 10px 13px;">
              No payment method(s) added. Please contact with administrator to proceed further.
             </div>
            <?php } ?>




          <div class="col-md-12">

            <div class="form-group">
                        <input type="hidden" name="step_1_agree" value="1">

                        <button id="i_agree" class="btn btn-default pull-right " type="submit" name="submit" value="1">
                            <?php echo get_lang_msg("confirm"); ?>
                        
                        </button>
                        <a href="<?php echo base_url().'better-luck-next-time'; ?>">
                            <button class="btn btn-danger pull-right m-r-10" type="button">
                            <?php echo get_lang_msg("cancel");
                             ?>

                            </button>
                        </a>

                    </div>
            

            
</div>
        
   			
   			
   			</form>	
   			
    	</div>

    	</div>

    	<div class="col-md-2"></div>


    	</div>

    
<?php require_once("common/footer.php");?>
<script language="javascript">
<?php if(ACTYPE == "1"){?>
function btnstatusupdate(val,id){
	var x = confirm("Are you sure you want to perform this action?");
	if (x){
		window.location='<?php echo base_url(); ?>admin/do/action/tranasctions/'+val+'/'+id;
		return true;
	}
	else {
		return false;
	}
}
<?php } ?>


function href(loc,that)
{
	$("#submit_btn").prop('disabled',false);
	$("#option_id").val(loc);

	$('.card-box').removeClass('hovered-card-box');
	$(that).find('.card-box').addClass('hovered-card-box');
	
}
</script>
