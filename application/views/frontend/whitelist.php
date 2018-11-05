<?php require_once("common/header.php");?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
               
            </div>
            <h4 class="page-title">Whitelist Settings</h4>
        </div>
    </div>

    <div class="row">
        <form method="POST" action="" accept-charset="UTF-8" id="form-profile">
            <input type="hidden" name="save" value="1">
        <div class="col-md-8">
            

            <div class="card-box widget-box-1">
                <h4 class="header-title m-t-0 m-b-30">Activate user Whitelist mode 
                    <input type="checkbox" id="on_me_change" name="active" value="1" <?php if($whitelist->active==1) echo "checked"; ?>>
                </h4>
                <div class="row" id="show_on_check" style="display: <?php if($whitelist->active!=1) echo "none"; ?>;">

                   
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

                    <div class="col-md-12 text-center">
                        <h4 class="text-center">Whitelist registration options</h4>
                    </div>
                   
                    <div class="col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold !important;">WHITELIST + KYC <sup>*</sup></label>                           
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                            <input required type="radio" name="kyc" value="1" <?php if($whitelist->kyc==1) echo "checked"; ?>>
                            Activate Whitelist Registration without KYC</label>                           
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                            <input required type="radio" name="kyc" value="2" <?php if($whitelist->kyc==2) echo "checked"; ?>>
                            Activate Whitelist Registration with KYC</label>                            
                        </div>
                    </div>
                    <div class="col-md-12 m-t-15" >
                        <div class="form-group">
                                                
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label style="font-weight: bold !important;">USER ACCESS RIRGHTS <sup>*</sup></label>
                            <br>
                            <small>Once a user registers via whitelist registration, what do you want them to have access to?</small>          
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                            <input required type="radio" name="ability" value="1" <?php if($whitelist->ability==1) echo "checked"; ?>>
                            Full User Dashboard</label>                           
                        </div>
                    </div>
                   <div class="col-md-12">
                        <div class="form-group">
                            <label>
                            <input required type="radio" name="ability" value="2" <?php if($whitelist->ability==2) echo "checked"; ?>>
                            User Dashboard without token buying ability</label>                           
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                            <input required type="radio" name="ability" value="3" <?php if($whitelist->ability==3) echo "checked"; ?>>
                            No Access to user dashboard until invited later</label>                           
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
        <!-- end col -->

        <div class="col-md-4">
         

            <div class="card-box widget-box-1">
                <h4 class="header-title m-t-0 m-b-30">Whitelist form options
                    
                </h4>
                <div class="row">
                   
                  
                   
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Select form to use whitelist registration <sup>*</sup></label>
                            <select required class="form-control" name="registration_form" id="registration_form" onchange="changeForm(this.value)">
                                <option value="">--Please select--</option>
                                <option value="0" <?php if($whitelist->registration_form==0) echo "selected"; ?>>Only Default Form</option>
                                <?php
                                $forms = $this->front_model->get_query_simple('*','dev_web_registration_forms',array('status'=>1))->result_object();
                                foreach($forms as $form){
                                 ?>
                                 <option

                                 <?php if($whitelist->registration_form==$form->id) echo "selected"; ?>
                                  value="<?php echo $form->id; ?>"><?php echo $form->title; ?></option>
                                <?php  } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <p>To view your forms or create a new form, please visit the <a href="<?php echo base_url().'admin/user-registration'; ?>">User Registration</a> settings page</p>
                        </div>
                    </div>
                   
                    
                    
                </div>
            </div>
           
           
        </div>

         </form>


        <!-- end col -->

    </div>
<?php require_once("common/footer.php");?>
<script type="text/javascript" src="<?php echo base_url().'resources/frontend/js/jscolor.min.js' ?>"></script>

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
    url: '<?php echo base_url().'ico/take_image_logo'; ?>',
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
var sub_shown = true;
$("#on_me_change").click(function(){
    var that = $(this);
    if($(that).is(':checked')){
        sub_shown = true;
        $("#show_on_check").show();
    }
    else
    {
        sub_shown = false;
        $("#show_on_check").hide();

    }



});
</script>

