<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php 

						$title = "EDIT USER VERIFICATION POPUP";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">

                                   

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label>Text <sup>*</sup> <i class="fa fa-info info-tip" title="This will be shown in body of popup"></i></label>

                                                <textarea name="verification_popup_text" class="form-control" required ><?php  echo $popup->verification_popup_text; ?></textarea>

                                            </div>

                                        </div>
                                        <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Image <sup>*</sup>

                                                <small class="text-danger">Please choose only 60px x 60px image for better performance</small>
                                             </label>

                                            <input name="inputfile" type="file" accept="image/*" class="form-control"  value="" id="inputfile">
                                            <label class="msg"></label>


                                            <img style="width: 60px; height: 60px" src="<?php echo base_url().'resources/uploads/verification/'.$popup->verification_popup_img; ?>" class="uploading_image ">

                                        </div>

                                    </div>





                                    </div>

                                    

                                 


                                    

                                    

                                    


                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                               Save Changes

                                            </button>

                                        </div>

                                    </div>

                                   

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>



        </div>

    </div>

</div>



<script>

    var resizefunc = [];

</script>

<?php include("common/footer.php");?>

<script>
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
    url: '<?php echo base_url().'ico/take_image_verification_popup'; ?>',
    data: formData,
    processData: false,
    contentType: false,
    type: 'POST',
  
    success: function (data) {

      data = JSON.parse(data);
       
      $('.msg').html(data.msg);


      if(data.status==1){
          $('.uploading_image').attr('src',data.src);
          $('.uploading_image').show();
         $('#submit_btn').prop('disabled', false);

        }
    }
  });
});
});
</script>



</body>

</html>

