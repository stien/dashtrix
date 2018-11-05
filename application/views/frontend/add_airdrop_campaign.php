<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php 

						$title = "ADD NEW Bounty CAMPAIGN - ADMIN";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">


                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Name <sup>*</sup></label>

                                            <input name="name" type="text" class="form-control" required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['name'];}?>">

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Campaign Type <sup>*</sup>
                                                <small>Add New <a target="_blank" href="<?php echo base_url().'admin/add-bounty-cat'; ?>">here</a></small>
                                            </label>

                                            <?php


                                            $camp_types = $this->front_model->get_query_simple('*','dev_web_airdrop_cats',array('active'=>1))->result_object();
                                             ?>

                                            

                                            <select class="form-control" name="camp_type" required>

                                            <option selected="selected" disabled="disabled" hidden="hidden" value="">Choose</option>


                                            <?php foreach($camp_types as $camp_type_){ ?>

                                            <option value="<?php  echo $camp_type_->id; ?>" <?php if(isset($_SESSION['wrongsignup'])){if($_SESSION['wrongsignup']['type'] == $camp_type_->id){echo "SELECTED";}}?>><?php echo $camp_type_->title; ?></option>

                                            <?php } ?>

                                          

                                            

                                            </select>

                                        


                                            

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>What do they need to do to earn the bounty <sup>*</sup></label>

                                            <input name="what_to_do" type="text" class="form-control" required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['what_to_do'];}?>">

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>How much is the bounty <sup>*</sup>
                                                <small>e.g. This price will be divided equally among all users. If you set 10,000 tokens and you say that 5 users can earn it. It means each user (of 5) will earn (10,000/5) = 2,000 Tokens</small>
                                            </label>

                                            <input name="bounty_qty" type="number" class="form-control " required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['bounty_qty'];}?>">

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>How many different users can earn this bounty <sup>*</sup></label>

                                            <input name="bounty_persons" type="number" class="form-control " required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['bounty_persons'];}?>">

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>How will they submit proof <sup>*</sup></label>


                                            <select class="form-control" name="proof_type" required>

                                            <option selected="selected" disabled="disabled" hidden="hidden" value="">Choose</option>

                                            <option value="1" <?php if(isset($_SESSION['wrongsignup'])){if($_SESSION['wrongsignup']['proof_type'] == "1"){echo "SELECTED";}}?>>Enter URL</option>

                                            <option value="2" <?php if(isset($_SESSION['wrongsignup'])){if($_SESSION['wrongsignup']['proof_type'] == "2"){echo "SELECTED";}}?>>Screenshot</option>
                                            <option value="3" <?php if(isset($_SESSION['wrongsignup'])){if($_SESSION['wrongsignup']['proof_type'] == "3"){echo "SELECTED";}}?>>Upload File</option>
                                           

                                            

                                            </select>


                                            

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Start Date <sup>*</sup></label>

                                            <input name="start_date" type="date" class="form-control birth_date" required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['start_date'];}?>">

                                        </div>

                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>End Date <sup>*</sup></label>

                                            <input name="end_date" type="date" class="form-control birth_date" required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['end_date'];}?>">

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Details </label>

                                            <textarea name="details" class="form-control " required value="<?php if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['details'];}?>"></textarea>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Rules <sup></sup></label>

                                            <textarea name="rules" class="form-control " required value="<?php if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['rules'];}?>"></textarea>

                                        </div>

                                    </div>

                               

                                    
                                    <!-- <div class="clone_me">
                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label>Enter your question</label>

                                                <input name="custom[]" type="text" class="form-control" required value="">

                                                <input type="checkbox" name="required[]">

                                            </div>

                                        </div>
                                        <button class="btn btn-danger in_clone_me" type="button" onclick="removeMe(this)"><i class="fa fa-times"></i></button>

                                        
                                    </div> -->
                                    <div class="col-md-12">

                                        <div class="form-group">

                                           <button onclick="addClone(this)" type="button" class="btn btn-default">Click to add custom field</button>

                                           

                                        </div>

                                    </div>

                               
                                   

                                   


                                    
<!-- 
                                      <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Image  </label>

                                            <input name="inputfile" type="file" accept="image/*" class="form-control"  value="" id="inputfile">
                                            <label class="msg"></label>


                                            <img src="" class="uploading_image display_none">

                                        </div>

                                    </div>
 -->


                               

                                   

                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                               Add Bounty Campaign
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

