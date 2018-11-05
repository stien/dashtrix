<?php include("common/header.php");?>

<div class="wrapper-page widht-800" style=" margin-bottom: 100px;">

   

   <h2><?php echo get_lang_msg("kyc_verification"); ?></h2>
                   

<form method="POST" action="" accept-charset="UTF-8" id="personal-info">
<?php require 'common/change_lang_kyc_tib.php'; ?>

 <div class="card-box">


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


        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">





                                <div class="row">

                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?php echo get_question_kcy("step_4_q_1"); ?></label>
                                            <textarea name="step_4_q_1" class="form-control" rows="5"><?php echo $old_data->step_4_q_1?$old_data->step_4_q_1:$_SESSION['kyc_tib']['step_4']['step_4_q_1']; ?></textarea>
                                        </div>
                                       
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="step_4_q_2"
                                                required=""
                                                value="1"
                                                <?php
                                                if($old_data->step_4_q_2=="1" || $_SESSION['kyc_tib']['step_4']['step_4_q_2']=="1") echo "checked";
                                                 ?>
                                                >
                                                <?php echo get_question_kcy("step_4_q_2"); ?>

                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="step_4_q_3"
                                                required=""
                                                value="1"
                                                <?php
                                                if($old_data->step_4_q_3=="1" || $_SESSION['kyc_tib']['step_4']['step_4_q_3']=="1") echo "checked";
                                                 ?>
                                                >
                                                <?php echo get_question_kcy("step_4_q_3"); ?>

                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="step_4_q_4"
                                                required=""
                                                value="1"
                                                <?php
                                                if($old_data->step_4_q_4=="1" || $_SESSION['kyc_tib']['step_4']['step_4_q_4']=="1") echo "checked";
                                                 ?>
                                                >
                                                <?php echo get_question_kcy("step_4_q_4"); ?>

                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="step_4_q_5"
                                                required=""
                                                value="1"
                                                <?php
                                                if($old_data->step_4_q_5=="1" || $_SESSION['kyc_tib']['step_4']['step_4_q_5']=="1") echo "checked";
                                                 ?>
                                                >
                                                <?php echo get_question_kcy("step_4_q_5"); ?>

                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="step_4_q_6"
                                                required=""
                                                value="1"
                                                <?php
                                                if($old_data->step_4_q_6=="1" || $_SESSION['kyc_tib']['step_4']['step_4_q_6']=="1") echo "checked";
                                                 ?>
                                                >
                                                <?php echo get_question_kcy("step_4_q_6"); ?>

                                            </label>
                                        </div>
                                    </div>
                                    
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-md-12 nopad m-t-40">

                    <div class="form-group">
                        <input type="hidden" name="step_1_agree" value="1">

                        <button id="i_agree" class="btn btn-default pull-right " type="submit" name="submit" value="1">
                           <?php echo get_lang_msg("confirm"); ?>
                        </button>
                        <a href="<?php echo base_url().'better-luck-next-time'; ?>">
                            <button class="btn btn-danger pull-right m-r-10" type="button"><?php echo get_lang_msg("cancel"); ?></button>
                        </a>

                    </div>

                </div>         
</div>
                         
                
                   

                                   

                              

</form>

             

</div>



<script>

    var resizefunc = [];

</script>

<?php include("common/footer.php");?>



<script>

    $(document).ready(function() {



        $('.birth_date_pre').datepicker({

            format: 'yyyy-mm-dd',
            endDate: '-0d'
        });
         $('.birth_date').datepicker({

            format: 'yyyy-mm-dd',

        });

    });

</script>

<script>

$(document).on('change','.inputfile',function () {
    var that = $(this);
    var this_name = $(that).attr("data-name");
    $(that).next().text('Please wait...');
    $(that).next().next().hide();
     
  $('#verification').prop('disabled', true);

  var myfile = $(that).val();
  var formData = new FormData();
  formData.append('inputfile', $(that)[0].files[0]);
  formData.append('name', this_name);
  $.ajax({
    url: '<?php echo base_url().'ico/take_verification_docs'; ?>',
    data: formData,
    processData: false,
    contentType: false,
    type: 'POST',
  
    success: function (data) {

      data = JSON.parse(data);
       
      $(that).next().text(data.msg);


      if(data.status==1){
          $(that).next().next().attr('src',data.src);
          $(that).next().next().show();
         $('#verification').prop('disabled', false);

        }
    }
  });
});


function moreSelfie(that)
{
   
    $(that).html('Please wait...');
    $(that).prop('disabled',true);
    
    $.post('<?php echo base_url().'ico/any_type_doc/0'; ?>',{data:1},function(data){
      
        $(that).before(data);
        $(that).html('+ More');
        $(that).prop('disabled',false);
    });
}


</script>
<style type="text/css">
    .taking_image img{
      float: left;
    width: 200px;
    margin: 10px;
    padding: 2px;
    border:1px solid;
}
.easy{
    float: left;
    width: 100%;
}
.mt-10{
    margin-top: 10px;
}
.w-auto{
    width: auto !important;
}
.on_kyc_margin_bottom_100{
    margin-bottom: 100px;
}
</style>


</body>

</html>

