<div class="overlay___">
<div class="row">
<?php  $kyc_aml = $this->front_model->get_query_simple('*','dev_web_kyc_aml',array('id'=>1))->result_object()[0];

    $my_verificaiton_submission = $this->front_model->get_query_simple('*','dev_web_user_verification',array('uID'=>UID,'deleted'=>0))->result_object();
 ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="card-box widget-box-1 pop_user_verification" style="">
        <div class="pp_inner-top text-right" style="margin-bottom: 20px;">
            
        </div>
        <div class="pp_inner-body text-center">
            <div class="pp_img_">
                <img src="<?php echo base_url().'resources/uploads/verification/'.$kyc_aml->verification_popup_img; ?>">
            </div>
            <?php if(empty($my_verificaiton_submission) || am_i('tib')){ ?>
                


                    <div class="pp_text_">
                        <?php echo $kyc_aml->verification_popup_text; ?>
                    </div>
                    <div class="pp_button_">
                        <a href="<?php echo base_url().'verify'; ?>">
                            <button type="button" class="btn btn-primary">Go To Verification</button>
                        </a>
                    </div>
               
            <?php }else{
                $_SESSION['vf_popup_shown']=true;
             ?>
                <?php if($my_verificaiton_submission[0]->uStatus==0){ ?>
                    <div class="pp_text_" style="margin-bottom: 20px;">
                        Your information is under review. You will be notified via email once our review is complete and you are approved to purchase tokens.
                    </div>

                <?php }else{ ?>
                    <div class="pp_text_" style="margin-bottom: 20px;">
                        After reviewing your information, you do not meet the requirements to participate in our token sale. If you have further questions, please contact our support staff.
                    </div>
                <?php } ?>

                <div class="pp_button_">
                    <a href="<?php echo base_url().'dashboard'; ?>">
                        <button type="button" class="btn btn-primary">Go To Dashboard</button>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="col-md-2"></div>
</div>
</div>