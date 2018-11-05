<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php $title = "ADD NEW ICO SETTING - ADMIN"; ?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">


                                     <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Campaign Title <sup>*</sup></label>

                                            <input name="title" type="text" class="form-control" required value="<?php  echo $_SESSION['wrongsignup']['title'];?>">

                                        </div>

                                    </div>
                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Campaign Type <sup>*</sup></label>



                                            

                                            <select class="form-control" name="camp_type" required>

                                            <option selected="selected" disabled="disabled" hidden="hidden" value="">Choose</option>

                                            <option value="1" <?php if(isset($_SESSION['wrongsignup'])){if($_SESSION['wrongsignup']['type'] == "1"){echo "SELECTED";}}?>>Pre-Sale</option>

                                            <option value="2" <?php if(isset($_SESSION['wrongsignup'])){if($_SESSION['wrongsignup']['type'] == "2"){echo "SELECTED";}}?>>ICO</option>

                                            

                                            </select>

                                        


                                            

                                        </div>

                                    </div>

                                    
                                    <div class="col-md-12" style="display: none;">
                                        <div class="form-group">
                                            <label>Timezone</label>

                                                <select  name="timezone" class="form-control">
                                                    <option value="America/New_York" selected>America/New_York</option>
                                                <?php /* $timezones = $this->db->order_by('zone_name','ASC')->get('dev_web_timezones')->result_object();
                                                foreach($timezones as $timezone){
                                                 ?>
                                                    <option <?php if($token->timezone==$timezone->zone_name) echo "selected"; ?> value="<?php echo $timezone->zone_name; ?>"><?php echo $timezone->zone_name; ?></option>

                                                <?php } */ ?>
                                                </select>
                                           
                                        </div>
                                    </div>

                                     <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12" style="font-style: italic;">
                                       <i class="fa fa-info"></i> <label>Please enter date and time according EST timezone</label>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Start Date</small><sup>*</sup></label>

                                            <input name="start_date" type="date" class="form-control birth_date" required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['start_date'];}?>">

                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Start Time <sup>*</sup></label>
                                            <div class="input-group">
                                                <input required name="start_time" type="time" class="form-control time_picker" value="<?php echo date("H:i",strtotime($_SESSION['wrongsignup']['start_time'])); ?>">
                                                <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                   
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>End Date <sup>*</sup></label>

                                            <input name="end_date" type="date" class="form-control birth_date" required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['end_date'];}?>">

                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>End Time <sup>*</sup></label>
                                            <div class="input-group">
                                                <input required name="end_time" type="time" class="form-control time_picker" value="<?php echo date("H:i",strtotime($_SESSION['wrongsignup']['end_time'])); ?>">
                                                <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="col-md-12">
                                        <hr>
                                    </div>

                                     <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Token Symbol <sup>*</sup></label>

                                            <input name="token_symbol" type="text" class="form-control" required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['token_symbol'];}?>">

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Total Tokens Issued <sup>*</sup></label>

                                            <input name="total_tokens_issued" type="number" class="form-control" required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['total_tokens_issued'];}?>">

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Tokens For Sale <sup>*</sup></label>

                                            <input name="tokens_for_sale" type="number" class="form-control" required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['tokens_for_sale'];}?>">

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Min. Raise Amount <sup>*</sup></label>

                                            <input name="min_raise_amount" type="number" class="form-control" required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['min_raise_amount'];}?>">

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Max. Raise Amount <sup>*</sup></label>

                                            <input name="max_raise_amount" type="number" class="form-control" required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['max_raise_amount'];}?>">

                                        </div>

                                    </div>

                                    <div class="col-md-12">
                                        <label>
                                            <input type="checkbox" name="end_on_end_date" value="1">
                                            End this campaign automatically when it reaches the campaign end date 
                                        </label>

                                    </div>
                                     <div class="col-md-12">
                                        <label>
                                            <input type="checkbox" name="end_on_end_token" value="1">
                                            End this campaign automatically if the number of tokens sold reaches the allocated number for sale above.
                                        </label>

                                    </div>

                                   <div class="col-md-12">
                                        <label>
                                            <input type="checkbox" name="multiple" value="1" checked>
                                            Multiple <small>This will be auto started if previous template runs out of tokens</small>
                                        </label>

                                    </div>


                                    
                                    <?php /* ?>
                                      <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Image  </label>

                                            <input name="inputfile" type="file" accept="image/*" class="form-control"  value="" id="inputfile">
                                            <label class="msg"></label>


                                            <img src="" class="uploading_image display_none">

                                        </div>

                                    </div>

                                    <?php */ ?>




                               

                                   

                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                               Add ICO Setting

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
    url: '<?php echo base_url().'ico/take_image_setting'; ?>',
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

