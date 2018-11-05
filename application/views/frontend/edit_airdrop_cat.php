<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php 

						$title = "EDIT BOUNTIES LANDING PAGE ITEM - ADMIN";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">


                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Title <sup>*</sup></label>

                                            <input name="title" type="text" class="form-control" required value="<?php echo  $cat->title; ?>">

                                        </div>

                                    </div>

                                    
                   

                                 

                                   

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Description </label>

                                            <textarea name="description" class="form-control " required ><?php echo  $cat->description; ?></textarea>

                                        </div>

                                    </div>

                               
                               

                                    
                                   
                               
                                   

                                   


                                    

                                      <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Image <sup>Only 150x150</sup> </label>

                                            <input name="inputfile" type="file" accept="image/*" class="form-control"  value="" id="inputfile">
                                            <label class="msg"></label>


                                            <img src="<?php echo base_url().'resources/uploads/campaigns/landing/'.$cat->image; ?>" class="uploading_image ">

                                        </div>

                                    </div>



                               

                                   

                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                               Update Bounty Category
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
    url: '<?php echo base_url().'ico/take_image_airdrop_cat'; ?>',
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
var clone_me = '<div class="clone_me">  <div class="col-md-12">    <div class="form-group">   <label>Enter your question</label>    <input name="custom[]" type="text" class="form-control" required value=""><label><input type="checkbox" name="required[]"> Required</label> </div>  </div><button class="btn btn-danger in_clone_me" type="button" onclick="removeMe(this)"><i class="fa fa-times"></i></button>  </div>';
function addClone(that)
{
    console.log(clone_me);

    $(that).parent().parent().before(clone_me);
}
function removeMe(that)
{
    $(that).parent().remove();
}
</script>



</body>

</html>

