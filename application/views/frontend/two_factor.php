<?php require_once("common/header.php");?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
               <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
            </div>
            <h4 class="page-title">Authy Settings</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="" accept-charset="UTF-8" id="form-profile">
            <input type="hidden" name="type" value="company">

            <div class="card-box widget-box-1">
                <h4 class="header-title m-t-0 m-b-30">Authy Settings</h4>
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


                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Authy Authentications required for users</label>
                           
                            <input class="checkbox2" name="required" value="1" type="checkbox" id="on" <?php if($setting->required==1) echo "checked"; ?>>
                            </label>
                           
                        </div>
                    </div>

                    <div class="others <?php if($setting->required==0) echo ""; ?>">
                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Twillio API Public Key</label>
                            <input class="form-control" name="sid" value="<?php echo $setting->sid; ?>" required type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Twillio API Secret Key</label>
                            <input class="form-control" name="skey" value="<?php echo $setting->skey; ?>" required type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Twillio API Phone Number <small>
                                <i class="fa fa-info"></i> Please provide complete number, e.g. +13325656565
                            </small></label>
                            <input class="form-control" name="from_number" value="<?php echo $setting->from_number; ?>" required type="text">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Require At</label>
                            <select class="form-control" name="after_type" id="after_type">
                                <option value="1" <?php echo $setting->after_type==1?"selected":""; ?> > After Specific Number of Logins</option>                                

                                <option value="2" <?php echo $setting->after_type==2?"selected":""; ?>>After Specific Days</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label id="after_label">After  <?php echo $setting->after_type==1?"logins":"days"; ?></label>
                            <select class="form-control" name="after_qty">
                            <?php for($i=1; $i<=30; $i++){ ?>

                                <option <?php echo $setting->after_qty==$i?"selected":""; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>

                            <?php } ?>

                            </select>
                        </div>
                    </div>

                    </div>
                     
            </div>
			 <div class="row" id="passwordrequest">
                <div class="col-sm-12 m-b-30">
                    <div class="button-list pull-right m-t-15">
                        <button class="btn btn-default submit-form" type="submit" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button>
                    </div>
                </div>
            </div>
        </div>
            </form>




           
        </div>

        <!-- end col -->

        <div class="col-md-4">
            <div class="col-md-12">
                <div class="card-box">
                    <img class="img-responsive" src="<?php echo base_url().'resources/frontend/images/authy.png'; ?>">
                </div>
            </div>
            <div class="col-md-12">            
                <div class="card-box easy">
                    <h4 class="header-title m-t-0 m-b-30">Authy For Admins</h4>
                    <div class="col-md-12">
                        <?php if($setting->for_admin!=1){ ?>
                        <a href="<?php echo base_url().'ico/activate_authy_for_admin'; ?>">
                            <button type="button" class="btn btn-default pull-right">Activate</button>
                        </a>
                        <?php }else{ ?>
                        <a href="<?php echo base_url().'ico/deactivate_authy_for_admin'; ?>">
                            <button type="button" class="btn btn-danger pull-right">De-activate</button>
                        </a>
                        <?php } ?>
                    </div>

                </div>
            </div>
          
        </div>
        <!-- end col -->

    </div>
<?php require_once("common/footer.php");?>


<script language="javascript">

$("#after_type").change(function(){
    var that = $(this);
    if($(that).val()==2)
        $("#after_label").html('After Days');
    else
        $("#after_label").html('After Logins');

});

$(".checkbox2").click(function(){
    var that = $(this);

    if($(that).is(':checked'))
    {
       // $('.others').show();
    }
    else
    {
         //$('.others').hide();
    }
});

</script>
