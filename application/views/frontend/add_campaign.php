<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php 

						$title = "ADD NEW CAMPAIGN - ADMIN";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="<?php echo base_url();?>do/admin/add/campaign" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Title <sup>*</sup> <i class="fa fa-info info-tip" title="This will be shown on very first slide"></i></label>

                                            <input name="title" type="text" class="form-control" value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['title'];}?>" required autofocus>

                                        </div>

                                    </div>

                                    

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>User Type <sup>*</sup></label>

                                            

                                            <select class="form-control" name="type" required>

                                            <option selected="selected" disabled="disabled" hidden="hidden" value="">Choose</option>

                                            <option value="2" <?php if(isset($_SESSION['wrongsignup'])){if($_SESSION['wrongsignup']['type'] == "1"){echo "SELECTED";}}?>>Token Buyer</option>

                                            <option value="4" <?php if(isset($_SESSION['wrongsignup'])){if($_SESSION['wrongsignup']['type'] == "4"){echo "SELECTED";}}?>>Airdrop or Bounty</option>

                                            <option value="3" <?php if(isset($_SESSION['wrongsignup'])){if($_SESSION['wrongsignup']['type'] == "3"){echo "SELECTED";}}?>>Market Affiliate</option>

                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Award Tokens <small>Please leave empty or put 0 if you do not have anything to offer</small>  <i class="fa fa-info info-tip" title="Amount of tokens user will receive"></i></label>

                                            <input name="award_tokens" type="number" step="0.1" class="form-control" value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['award_tokens'];} else echo 0; ?>">

                                        </div>

                                    </div>

                                 


                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Description <sup>*</sup> <i class="fa fa-info info-tip" title="This will be shown on very first slide"></i></label>

                                            <textarea name="description" class="form-control" required value=""><?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['description'];}?></textarea>

                                        </div>

                                    </div>



                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Image <sup>*</sup> </label>

                                            <input name="inputfile" type="file" accept="image/*" class="form-control" required value="" id="inputfile">
                                            <label class="msg"></label>


                                            <img src="" class="uploading_image display_none">

                                        </div>

                                    </div>

                                    

                                    


                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button id="submit_btn" class="btn btn-default btn-block btn-lg" type="submit">

                                               Add New Campaign

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



        $('#birth_date').datepicker({

            format: 'yyyy-mm-dd',

            endDate: '-0d'

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
    url: '<?php echo base_url().'ico/take_image_camp'; ?>',
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

