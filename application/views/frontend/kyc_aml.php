<?php require_once("common/header.php");?>
<div class="row">
<div class="col-sm-12 m-b-30">
<h4 class="page-title">KYC/AML Partner Integration</h4>
</div>
</div>



<div class="card-box m-b-50" style="clear: both;"> 


    <?php if(isset($_SESSION['thankyou'])){?>
<div class="col-md-12">
<div class="form-group">
<div class="successfull">
    <?php echo $_SESSION['thankyou'];?>
</div>
</div>
</div>
<?php } ?>
        <?php


            $uf_id = 1;

            $kyc_aml = $this->front_model->get_query_simple('*','dev_web_kyc_aml',array('id'=>1))->result_object()[0];
            $kyc_style = $kyc_aml;

            
            if($kyc_aml->kyc_verification==1){
                ?>


                <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Deactivate "User KYC Verification" </strong></label>
                    <a href="<?php  echo base_url().'ico/disable_uf_kyc/'; ?>">
                        <button  type="button" class="btn btn-danger right">Deactivate</button>
                    </a>

                    <a  href="<?php echo base_url().'admin/edit-user-verification-text'; ?>">
                        <button style="margin-right: 10px;" type="button" class="btn btn-primary right">Edit Text</button>
                    </a>
                </div>

            <?php }else{ ?>


                <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Activate "User KYC Verification"</strong></label>
                    <a href="<?php  echo base_url().'ico/enable_uf_kyc'; ?>">
                        <button type="button"  class="btn btn-primary right">Activate</button>
                    </a>
                </div>

            <?php } ?>

            
        </div>


        <?php if(am_i('securix')){ ?>


        <div class="card-box m-b-50" style="clear: both;">
            <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Require "User KYC Verification"</strong></label>
                    <form method="post" action="">
                    <div class="custom_buttons" style="display: inline-block; width: 80%;">
                    <div class="con_1">
                        <label>
                            <input onclick="perfom_cons(this)" <?php if($kyc_aml->require_at==1) echo "checked"; ?> type="radio" name="require_at" value="1" required>
                            After Login
                        </label>
                   
                        <label>
                            <input id="at_token" onclick="perfom_cons(this)" <?php if($kyc_aml->require_at==2) echo "checked"; ?> type="radio" name="require_at" value="2" required>
                            At Token Purchase
                        </label>
                    </div>
                    <div class="con_2">
                        <label>
                            <input <?php if($kyc_aml->require_at_crypto==1) echo "checked"; ?> type="radio" name="require_at_crypto" value="1" required>
                            Before Crypto
                        </label>
                   
                        <label>
                            <input onclick="perfom_cons(this)" <?php if($kyc_aml->require_at_crypto==2) echo "checked"; ?> type="radio" name="require_at_crypto" value="2" required>
                            After Crypto
                        </label>
                    </div>
                    <div class="con_3">
                        <label>
                            <input <?php if($kyc_aml->require_at_fiat==1) echo "checked"; ?> type="radio" name="require_at_fiat" value="1" required>
                            Before FIAT
                        </label>
                   
                        <label>
                            <input onclick="perfom_cons(this)" <?php if($kyc_aml->require_at_fiat==2) echo "checked"; ?> type="radio" name="require_at_fiat" value="2" required>
                            After FIAT
                        </label>
                    </div>
                       

                    </div>
                    <button <?php  if($kyc_style->require_at==2){ ?> style="margin-top: 45px;" <?php } ?> class="btn btn-default right">Update</button>


                   
                        
                    
                    </form>

                    
                </div>
        </div>

    <?php }else{ ?>
        <div class="card-box m-b-50" style="clear: both;">
            <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Require "User KYC Verification"</strong></label>
                    <form method="post" action="">
                    <div class="custom_buttons" style="display: inline-block; width: 80%;">
                    <div class="con_1">
                        <label>
                            <input <?php if($kyc_aml->require_at==1) echo "checked"; ?> type="radio" name="require_at" value="1" required>
                            After Login
                        </label>
                   
                        <label>
                            <input id="at_token" <?php if($kyc_aml->require_at==2) echo "checked"; ?> type="radio" name="require_at" value="2" required>
                            Before Token Purchase
                        </label>
                        <label>
                            <input id="at_token" <?php if($kyc_aml->require_at==3) echo "checked"; ?> type="radio" name="require_at" value="3" required>
                            After Token Purchase
                        </label>
                    </div>
                   

                    </div>
                    <button class="btn btn-default right">Update</button>


                   
                        
                    
                    </form>

                    
                </div>
        </div>

    <?php } ?>

<div class="row">

<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="card-box widget-box-1 pop_user_verification" style="">
        <div class="pp_inner-top text-right">
            <a href="<?php echo base_url().'admin/edit-user-verification-popup'; ?>">
                <i class="fa fa-edit"></i> Edit
            </a>
        </div>
        <div class="pp_inner-body text-center">
            <div class="pp_img_">
                <img src="<?php echo base_url().'resources/uploads/verification/'.$kyc_aml->verification_popup_img; ?>">
            </div>
            <div class="pp_text_">
                <?php echo $kyc_aml->verification_popup_text; ?>
            </div>
            <div class="pp_button_">
                <button type="button" class="btn btn-primary">Go To Verification</button>
            </div>
        </div>
    </div>
</div>
<div class="col-md-2"></div>
</div>



<div class="card-box widget-box-1 boxdisplay">

<?php
$uf_id = 1;
$kyc_aml = $this->front_model->get_query_simple('*','dev_web_kyc_aml',array('id'=>1))->result_object()[0];
$user_verification = $this->front_model->get_query_simple('*','dev_web_campaigns',array('id'=>$uf_id))->result_object()[0];
?>




<p>
	We allow you to integrate with any 3rd party KYC or AML solution who offers an API or Token for 3rd party integrations. When selecting to use a service from the list below or adding your own, you will need to first create an account with them and come back here and enter your credentials.  
</p>

</div>


<div class="row">
    <div class="col-md-12">
        <?php require_once 'kyc_options.php'; ?>
    </div>
</div>

<?php require_once("common/footer.php");?>
<?php require_once("common/compaign.php"); ?>
<script language="javascript">

<?php if(ACTYPE == "1"){?>

function btnstatusupdate(val,id){

	var x = confirm("Are you sure you want to perform this action?");

	if (x){

		window.location='<?php echo base_url(); ?>ico/update_kyc_settings/'+val+'/'+id;

		return true;

	}

	else {

		return false;

	}

}
function btnstatusdelete(id){

	var x = confirm("Are you sure you want to perform this action?");

	if (x){

		window.location='<?php echo base_url(); ?>ico/delete_kyc_aml_data/'+id;

		return true;

	}

	else {

		return false;

	}

}


function dFlip(period,cls)
{
    $('.'+cls).find(".d-flip").hide();
    $('.'+cls).find(".flip-control").find('a').css('color','#23527c');
    $('.'+cls).find(".d-flip-"+period).fadeIn();
    $('.'+cls).find(".flip-"+period).css('color','#000');

}

<?php } ?>
function closeModel()
{
     $(".modal-cs").hide();
}

function openModal(id,that)
{
    if($(that).is(':checked')){
        openModal2(id);
        
    }
    else
    {
        $.post('<?php echo base_url().'ico/inactive_kyc_option' ?>',{id:id},function(data){});
    }
	

    


   
}
function openModal2(id)
{

    closeModel();
    $("#modal"+id).fadeIn();

}

function openModal3()
{
    $("#modal3").fadeIn();
}
function perfom_cons(that)
{
    n_that = $("#at_token");
    if($(n_that).is(":checked"))
    {
        $(".con_2").find("input").prop("required",true);
        $(".con_3").find("input").prop("required",true);
        $(".con_2").show();
        $(".con_3").show();

    }
    else
    {
        $(".con_2").find("input").prop("required",false);
        $(".con_3").find("input").prop("required",false);
        $(".con_2").hide();
        $(".con_3").hide();
    }
}
</script>
<style type="text/css">
<?php  if($kyc_style->require_at==1){ ?>
    .con_2, .con_3{
        display: none;
    }
<?php } ?>
</style>

