<?php require_once("common/header.php");?>

	
   
    	<div class="row">
         <div class="col-sm-12 m-b-30">
        	<h4 class="page-title">Buy Tokens</h4>
    	</div>
    	</div>
    	<div class="row">

    		<div class="col-md-2"></div>
    		<div class="col-md-8">

    			<div class="box-buy-tokens-old">
    			<form method="post" action="">
    				<h3 class="text-center">Select Payment Method</h3>
    				

            <?php

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


            if($_SESSION['c_type']=="crypto")
            {
              if($kyc_verification_at_crypto!=1)
                $work_or_not = 1;
            }
            elseif($_SESSION['c_type']=="fiat")
            {
              if($kyc_verification_at_fiat!=1)
                $work_or_not = 1;
            }
            else{
              $currency_chosen=0;
            }

            if($currency_chosen==1){
            if($work_or_not==1)
                {
                    
                
             foreach($options as $key=>$option){
                $disabled = 0;



                // if($option->allowed_country!=0){
                if($option->allowed_country && !empty(explode(',',$option->allowed_country))){
                  // echo $option->allowed_country;
                  // echo 1;exit;
                // 


                    $allowed_in_country = $this->front_model->get_query_simple('*','dev_web_countries',array('id'=>$option->allowed_country))->result_object()[0];

                    $ip = $_SERVER['REMOTE_ADDR'];
                    // $ip = "110.36.183.128"; 
                    // united states
                    // $ip = "72.229.28.185";

                    $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));




                    if($query['countryCode'])
                    {
                        $country_id = $this->front_model->get_query_simple('id','dev_web_countries',array('iso'=>$query['countryCode']))->result_object();
                        if(!empty($country_id))
                        {
                            if(in_array($country_id[0]->id,explode(',',$option->allowed_country)))
                            {
                                $disabled = 3;
                            }
                            else
                            {
                                $disabled = 0;
                            }
                        }
                        else
                        {
                            $disabled = 2; 
                        }


                    }
                    else
                    {
                        $disabled=1;
                    }
                }
              ?>

             
			<div class="col-sm-3 m-b-30 pointer <?php echo $disabled!=0?"disabled-payment-method":""; ?>" 

                <?php if($disabled==0){ ?>
                onclick="href('<?php echo $option->id; ?>',this)"
            <?php  }else{
                if($disabled==1){
             ?>
                title="Sorry we are unable to detect your country." data-toggle="tooltip"

           <?php }elseif($disabled==2){ ?>

            title="Sorry your country (<?php echo $query['country']; ?>) doesn't exist in our database. " data-toggle="tooltip"

            <?php
           } elseif($disabled==3){
            ?>
title="Sorry this payment method is not allowed in your country (<?php echo $query['country']; ?>). " data-toggle="tooltip"
            <?php
           } } ?>
                >
				<div class="card-box widget-box-1 boxdisplay">
                    <span>
                         <?php if($option->imgType == "0"){?>
                        <i class="fa <?php echo $option->icon; ?>"></i>
                        <?php } else {?>
                        <img src="<?php echo base_url();?>resources/frontend/images/<?php echo $option->icon;?>" alt="<?php echo $option->name; ?>" width="50">
                        <?php } ?>
                        </span>
					<p><?php echo $option->name;
                     ?></p>
                    

				</div>	
			</div>

			


          


            <?php } }
            else{

             $show_popup_verification = true;
              } }else{ ?>
                <div class="" style="background: orange; text-align: center; padding: 10px 13px;">
              No currency type chosen. Please choose a currency type by click <a href="<?php echo base_url().'buy-tokens'; ?>">this link</a>
             </div>
              <?php }
            if(empty($options)){
             ?>
            
             <div class="" style="background: orange; text-align: center; padding: 10px 13px;">
              No payment method(s) added. Please contact with administrator to proceed further.
             </div>
            <?php } ?>

            <div class="col-md-12">
            

            

            <div class="col-md-3 right  m-t-40">
                 <div class="form-group">
					<input type="hidden" id="option_id" name="option" value="">
						<button id="submit_btn" class="btn btn-default btn-block btn-sm " disabled type="submit">
                              Next
                        </button>
                 </div>
            </div>
            <div class="col-md-3 right m-t-40">
                 <div class="form-group">
                    <a href="<?php echo base_url().'dashboard'; ?>">
                        <button class="btn btn-danger btn-block btn-sm "  type="button">
                              Cancel
                        </button>
                    </a>
                 </div>
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
