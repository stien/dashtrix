<?php require_once("common/header.php");?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
               <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
            </div>
            <h4 class="page-title">Referral Settings</h4>
        </div>
    </div>
	<?php
		$c2 = array();
		$us =  $this->front_model->get_query_simple('*','dev_web_ref_setting',$c2);
		$referrel = $us->result_object();
	?>
   
   
    <div class="row">
        <div class="col-md-8">
            
            <div class="card-box widget-box-1">
                <form method="POST" action="<?php echo base_url();?>ico/do_referrel_settings_multi" accept-charset="UTF-8" id="form-password" class="ui form">
                <div class="row">
                   <div id="confirmerror"></div>
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Percentage (%) of tokens to reward for referrer on each purchase <sup>*</sup>
                            	<small>Add levels of bonus</small>
                            </label>
                            <div class="bonus_levels">
                            	<?php

                            	foreach(json_decode($referrel[0]->levels) as $v)
                            	 echo add_level($v); ?>
                            	<div class="col-md-12 add_div" style="padding: 0px !important; margin-bottom: 30px;">
                            		<a id="add_level_a" href="javascript:addLevel()" ><button type="button" class="btn btn-xs btn-primary">+ Add level</button></a>
                            	</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Title under Referral Program page title <sup>*</sup></label>
                            <input name="refpagetitle" type="text" id="newpass" value="<?php echo $referrel[0]->tokenTitle;?>" required class="form-control" max="100">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>General referral rules <sup>*</sup></label>
                            <textarea name="desctiptitle" id="desctiptitle" required class="form-control"><?php echo strip_tags(htmlspecialchars_decode($referrel[0]->tokenText));?></textarea>
                        </div>
                    </div>


                    <?php /* $setting = $this->db->get('dev_web_config')->result_object()[0]; ?>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>"My Refferal URL" helping text</label>
                            <textarea class="form-control" rows="5" name="ref_helping_txt" value="<?php echo $setting->ref_helping_txt; ?>" ><?php echo $setting->ref_helping_txt; ?></textarea>
                        </div>
                    </div>
                    <?php */ ?>


                    <div class="col-md-12 right">
                        <button class="btn btn-default m-t-20 right" type="submit" id="upbtn"><span class="m-r-5"><i class="fa fa-lock"></i></span>Update Referrel</button>
                    </div>
                </div>
                </form>

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
<script language="javascript">
function confirmpassword_request(){
	if($("#newpass").val() != $("#confirmpass").val()){
		$("#upbtn").attr("disabled",true);
		$("#confirmerror").html('<div class="wrongerror">Password & New Password not matched!</div>');
	} else {
		$("#upbtn").attr("disabled",false);
		$("#confirmerror").html('');
	}
}
function addLevel()
{
	$(".add_level_a").prop("disabled",true);
	$(".add_level_a").html("Please wait...");
	$.post("<?php echo base_url().'ico/add_level' ?>",{bring:true},function(data){
		$('.bonus_levels').find('.add_div').before(data);
		$(".add_level_a").prop("disabled",false);
		$(".add_level_a").html("+ Add level");
	});
}
function remove_level(that)
{
	$(that).parent().remove();
}
</script>
