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



                                <div class="col-md-12 nopad">
                                    <label>
                                        <?php echo get_lang_msg("step_3_heading"); ?>
                                    </label>
                                </div>
                                <input type="hidden" name="document_type" value="1">
<?php /* ?>
                                 <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo get_lang_msg("document_type"); ?> <sup>*</sup></label>
                                            <select required name="document_type" class="form-control">
                                                <option <?php if($verification_document->type==1)
                                                echo "selected";
                                                 ?>
                                                 value="1"
                                                 ><?php echo get_lang_msg("national_id_card"); ?>
                                                </option>
                                                <option <?php if($verification_document->type==2)
                                                echo "selected";
                                                 ?>
                                                 value="2"
                                                 ><?php echo get_lang_msg("passport"); ?>
                                                </option> 
                                                <option <?php if($verification_document->type==3)
                                                echo "selected";
                                                 ?>
                                                 value="3"
                                                 ><?php echo get_lang_msg("driving_license"); ?>
                                                </option>
                                                
                                            </select>
                                        </div>
                                        
                                    </div>
                                  <?php */ ?>


                                    
                                    
                                    <div class="col-md-12">
                                        <div class="form-group taking_image">
                                            <label><?php echo get_lang_msg("document_front"); ?> <sup>*</sup>  </label>
                                            <input name="inputfile[]" type="file" accept="application/pdf, image/*" class="form-control inputfile"  value="" data-name="front" required="">
                                            <label class="msg"></label>
                                            <img data-id="front" src="" class="display_none">
                                        </div>
                                    </div>
<?php /* ?>
                                    <div class="col-md-12">
                                        <div class="form-group taking_image">
                                            <label><?php echo get_lang_msg("document_back"); ?>  </label>
                                            <input name="inputfile[]" type="file" accept="application/pdf, image/*" class="form-control inputfile"  value="" data-name="back" >
                                            <label class="msg"></label>
                                            <img data-id="back" src="" class="display_none">
                                        </div>
                                    </div>


                               
                                </div>
<?php */ ?>   
                                    
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
                            </div>
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
    
    $.post('<?php echo base_url().'ico/bill_doc/0'; ?>',{data:1},function(data){
      
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

