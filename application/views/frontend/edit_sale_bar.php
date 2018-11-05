<?php require_once("common/header.php");?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
               
            </div>
            <h4 class="page-title">Edit Sale-Bar</h4>
        </div>
    </div>

    <div class="row">
        <form method="POST" action="" accept-charset="UTF-8" id="form-profile">
            <input type="hidden" name="save" value="1">
        <div class="col-md-8">
            

            <div class="card-box widget-box-1">
                <h4 class="header-title m-t-0 m-b-30">Activate custom sale-bar statistics
                    <input type="checkbox" id="on_me_change" name="sale_active" value="1" <?php if($sale_bar->sale_active==1) echo "checked"; ?>>
                </h4>
                <div class="row" id="show_on_check" style="display: <?php if($sale_bar->sale_active!=1) echo "none"; ?>;">

                   
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
                            <label>
                               1. Max. Cap
                           </label>     
                           <input class="form-control" type="number" name="max_cap" step="0.1" value="<?php echo $sale_bar->max_cap; ?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                              2. Total Tokens Sold <small>Please enter the amount of tokens, NOT the percentage</small>
                           </label>     
                           <input class="form-control" type="number" name="tokens_sold" step="0.1" value="<?php echo $sale_bar->tokens_sold; ?>">
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
                <h4 class="header-title m-t-0 m-b-30">
                    Where it will reflect?:
                </h4>
                <div class="row">
                   <div class="col-md-12">
                    <img class="easy" src="<?php echo base_url().'resources/frontend/images/arrow.jpg'; ?>">
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

