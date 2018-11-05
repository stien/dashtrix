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
            <form method="POST" action="<?php echo base_url();?>do/update/profile" accept-charset="UTF-8" id="form-profile">
            <input type="hidden" name="type" value="company">

            <div class="card-box widget-box-1">
                <h4 class="header-title m-t-0 m-b-30">Profile information</h4>
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
                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name</label>
                            <input class="form-control" name="first_name" value="<?php echo $users['uFname'];?>" required type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input class="form-control" name="last_name" value="<?php echo $users['uLname'];?>" required type="text">
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input class="form-control" name="email" disabled value="<?php echo $users['uEmail'];?>" required type="email">
                        </div>
                    </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone number</label>
                            <input class="form-control" name="phone" value="<?php echo $users['uPhone'];?>"  type="number">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Address</label>
                            <input class="form-control" name="address" value="<?php echo $users['uAddress'];?>"  type="text">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Country</label>
                            
                            <select class="form-control" name="country" required>
                            	<?php
									foreach($countries as $country){
								?>
								<option value="<?php echo $country->id;?>" <?php if($users['uCountry'] == $country->id){echo "SELECTED";}?>><?php echo $country->nicename;?></option>
								<?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>City</label>
                            <input class="form-control" name="city" value="<?php echo $users['uCity'];?>"  required type="text">
                        </div>
                    </div>
                    
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Postal code</label>
                            <input class="form-control" name="postal_code" value="<?php echo $users['uZip'];?>"  type="text">
                        </div>
                    </div>
                 
                  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Username</label>
                            <input class="form-control" name="username" type="text" value="<?php echo $users['uUsername'];?>" disabled>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telegram Username</label>
                            <input class="form-control" name="telegram" type="text" value="<?php echo $users['uTelegram'];?>" >
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
            </form>


            <div class="card-box widget-box-1">
                <form method="POST" action="#" accept-charset="UTF-8" id="form-avatar"><input name="_method" type="hidden" value="PUT"><input name="_token" type="hidden" value="fhJkbvFEIT8vOUQT3osowj3p0su6L2h2TpwckvhB">
                <h4 class="header-title m-t-0 m-b-30">Change profile image</h4>
                <div class="row">
                    <div class="col-md-2">
                        <img id="img"  src="<?php echo base_url().'resources/uploads/profile/'.$users['uImage']; ?>" alt="image" class="img-responsive img thumb-lg">
                    </div>
                    <div class="col-md-4">

                        <div class="button-list pull-left m-t-20">
                            <p class="msg"></p>
                            <a id="remove-photo" href="">Delete photo</a>

                            
                                <input type="file" style="display: none; margin-bottom: 0px;"  class="btn btn-default"  name="inputfile" id="inputfile" >
                            
                            <button onclick="cclick()" id="photo-upload" type="button" class="btn btn-default" style="margin-bottom: 0px;">Change photo</button>
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                
                
                </form>
            </div>

            <div class="row">
                <div class="col-sm-12 m-b-30">
                    <div class="button-list pull-right m-t-15">
                        <a href="<?php echo base_url().'ico/update_profile_pic'; ?>">
                             <button id="submit_btn" class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button>
                         </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-md-4">
            <?php
            $ask_eth = $this->front_model->get_query_simple('*','dev_web_config',array())->result_object()[0];
             if($ask_eth->ask_eth==1){ ?>
            <div class="card-box widget-box-1">
                <form method="POST" action="<?php echo base_url();?>do/wallet" accept-charset="UTF-8" id="form-wallet" class="ui form">

                    <h4 class="header-title m-t-0 m-b-30">Wallet for Token Distribution</h4>
                    <div class="row">
                        <div id="confirmerror"></div>
                        <?php if(isset($_SESSION['thankyou_wallet'])){?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="successfull">
                                        <?php echo $_SESSION['thankyou_wallet'];?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(isset($_SESSION['error_wallet'])){?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="wrongerror">
                                        <?php echo $_SESSION['error_wallet'];?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>ETH Address <small>Please enter valid address</small></label>
                                <input <?php if(am_i('lib')){ ?> pattern="^(0x)?[0-9a-fA-F]{40}$" <?php } ?> name="ethaddress" type="text" value="<?php echo $users['uWallet'];?>" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 right">
                            <button class="btn btn-default m-t-20 right" type="submit"><span class="m-r-5"><i class="fa fa-lock"></i></span>Submit</button>
                        </div>
                    </div>
                </form>

            </div>
            <?php } ?>
            <div class="card-box widget-box-1">


                    <h4 class="header-title m-t-0 m-b-30">Referral URL</h4>
                    <div class="row">


                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Referral URL</label>
                                <input id="copyme" type="text" value="<?php echo base_url().'signup?ref='.$users['uCode'];?>" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 right">
                            <button class="btn btn-default m-t-20 right" type="button" onclick="copyMe('copyme',this)"><span class="m-r-5"><i class="fa fa-copy"></i></span>Copy</button>
                        </div>
                    </div>


            </div>
            <?php 

            if(am_i('hydro') && 2==3)
            {
            ///// two factor
                $two_fact = $this->front_model->get_query_simple('*','dev_web_two_factor',array('id'=>1))->result_object()[0];

                if($two_fact->required==1){
                    
             ?>


             <div class="card-box widget-box-1">


                    <h4 class="header-title m-t-0 m-b-30">2FA (Two-Factor) Authentication</h4>
                    <div class="row">


                        
                        <div class="col-md-12 right">
                            <?php if($users['enable_two_factor']==1){ ?>
                            <a href="<?php echo base_url().'ico/disable_two_factor_user'; ?>">
                                <button class="btn btn-danger m-t-20 right" type="button">Disable</button>
                            </a>
                            <?php }else{ ?>
                            <a href="<?php echo base_url().'ico/enable_two_factor_user'; ?>">
                                <button class="btn btn-default m-t-20 right" type="button">Enable</button>
                            </a>
                            <?php } ?>
                        </div>
                    </div>


            </div>

             



         <?php } } ?>
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

<script>

    function copyMe(id,that)
    {
        var copyText = document.getElementById(id);
        copyText.select();
        document.execCommand("Copy");

        $(that).html('<i class="fa fa-check"></i></span>Copied')
    }

    function cclick()
    {
        $("#inputfile").click();
    }
$(function () {
$('#inputfile').change(function () {

     $('.img').hide();

 
  $('.msg').text('Please Wait...');
  $('#submit_btn').prop('disabled', true);

  var myfile = $('#inputfile').val();
  var formData = new FormData();
  formData.append('inputfile', $('#inputfile')[0].files[0]);
   $('.msg').text('Uploading in progress...');
  $.ajax({
    url: '<?php echo base_url().'ico/take_image_profile'; ?>',
    data: formData,
    processData: false,
    contentType: false,
    type: 'POST',
  
    success: function (data) {

      data = JSON.parse(data);
       
      $('.msg').html(data.msg);


      if(data.status==1){
     

          $('.img').attr('src',data.src);
          $('.img').show();
         $('#submit_btn').prop('disabled', false);

        }
    }
  });
});
});

$("#remove-photo").click(function(){
    
    $.post('<?php echo base_url().'ico/remove_profile_pic'; ?>',{remove:true},function(){
         $('.img').attr('src','<?php echo base_url().'resources/uploads/profile/default.svg'; ?>');
          $('.img').show();
    });
});

</script>

