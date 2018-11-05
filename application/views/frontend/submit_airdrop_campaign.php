<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php 

						$title = "Submit Bounty Campaign";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">

                                    <h2>Please complete following tasks and upload proof

                                    </h2>

                                    <h4>
                                        <?php  echo $bounty->what_to_do; ?>
                                    </h4>

                                        
                                    <input type="hidden" name="camp_id" value="<?php echo $bounty->id; ?>">

                                    <?php


                                     foreach(json_decode($bounty->costum_form) as $c_form){ ?>
                                     
                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label><?php echo $c_form->q; ?></label>

                                                <input name="custom[]" type="text" class="form-control"   <?php echo $c_form->q==1?"required":""; ?>>


                                            </div>

                                        </div>

                                        
                                    

                                    <?php } ?>

                                    <?php 


                                    if($bounty->proof_type==1){
                                        ?>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Please enter URL of your completed task</label>
                                                    <input type="url" name="url" value="" class="form-control" required="">
                                                </div>
                                            </div>

                                        <?php 
                                    }else{
                                     ?>


                                  

                                    

                                      <div class="col-md-12">

                                        <div class="form-group">

                                            <label>File/Screenshot  </label>

                                            <input name="inputfile" type="file" accept="*" class="form-control"  value="" id="inputfile">
                                            <label class="msg"></label>


                                            <img src="" class="uploading_image display_none">

                                        </div>

                                    </div>

                                    <?php } ?>



                               

                                   

                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                               Submit

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

    $(document).ready(function() {



        $('.birth_date').datepicker({

            format: 'yyyy-mm-dd'
        });

    });

</script>

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
    url: '<?php echo base_url().'ico/take_proof_file'; ?>',
    data: formData,
    processData: false,
    contentType: false,
    type: 'POST',
  
    success: function (data) {

      data = JSON.parse(data);
       
      $('.msg').html(data.msg);


      if(data.status==1){

        if(data.type==1){
          $('.uploading_image').attr('src',data.src);
          $('.uploading_image').show();

      }else{
          $('.uploading_image').hide();

            $('.msg').html("Your file uploaded successfully!");


      }
         $('#submit_btn').prop('disabled', false);
      

        }
    }
  });
});
});
</script>



</body>

</html>

