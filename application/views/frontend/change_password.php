<?php require_once("common/header.php");?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
               <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
            </div>
            <h4 class="page-title">Account settings</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">


            

            <div class="card-box widget-box-1">
                <form method="POST" action="<?php echo base_url();?>do/password" accept-charset="UTF-8" id="form-password" class="ui form">

                <h4 class="header-title m-t-0 m-b-30">Change password</h4>
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

                    
                   <div id="confirmerror"></div>
                  	<?php if(isset($_SESSION['thankyou_change'])){?>
						<div class="col-md-12">
							<div class="form-group">
								<div class="successfull">
									<?php echo $_SESSION['thankyou_change'];?>
								</div>
							</div>
						</div>
						<?php } ?>
						<?php if(isset($_SESSION['error_change'])){?>
						<div class="col-md-12">
							<div class="form-group">
								<div class="wrongerror">
									<?php echo $_SESSION['error_change'];?>
								</div>
							</div>
						</div>
					<?php } ?> 
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Enter current password</label>
                            <input name="oldpass" type="password" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>New password</label>
                            <input name="password_new" type="password" id="newpass" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Confirm password</label>
                            <input name="password_confirmation" id="confirmpass" type="password" onKeyUp="confirmpassword_request()" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12 right">
                        <button class="btn btn-default m-t-20 right" type="submit" id="upbtn"><span class="m-r-5"><i class="fa fa-lock"></i></span>Update password</button>
                    </div>
                </div>
                </form>

            </div>

            <?php /*?><div class="card-box widget-box-1">
                <form method="POST" action="#" accept-charset="UTF-8" id="form-avatar"><input name="_method" type="hidden" value="PUT"><input name="_token" type="hidden" value="fhJkbvFEIT8vOUQT3osowj3p0su6L2h2TpwckvhB">
                <h4 class="header-title m-t-0 m-b-30">Change profile image</h4>
                <div class="row">
                    <div class="col-md-2">
                        <img id="avatarimg" src="" alt="image" class="img-responsive thumb-lg">
                    </div>
                    <div class="col-md-4">
                        <div class="button-list pull-left m-t-20">
                            <a id="remove-photo" href="">Delete photo</a>
                            <button data-url="someurl.com" id="photo-upload" type="button" class="btn btn-default" style="margin-bottom: 0px;">Change photo</button>
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                
                
                </form>
            </div><?php */?>

            <?php /*?><div class="row">
                <div class="col-sm-12 m-b-30">
                    <div class="button-list pull-right m-t-15">
                        <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button>
                    </div>
                </div>
            </div><?php */?>
        </div>
        <!-- end col -->

        <div class="col-md-4">
            
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
</script>
