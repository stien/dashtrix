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

                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo get_lang_msg("first_name"); ?> <sup>*</sup></label>
                                            <input name="uFname" type="text" class="form-control" required value="<?php 
                                            echo $old_data->uFname?$old_data->uFname:$_SESSION['kyc_tib']['step_2']['uFname'];

                                             ?>" autofocus
                                            placeholder="<?php echo get_lang_msg("enter_your"); ?> <?php echo get_lang_msg("first_name"); ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo get_lang_msg("last_name"); ?> <sup>*</sup></label>
                                            <input 
                                            name="uLname" 
                                            type="text" 
                                            class="form-control" 
                                            required 
                                            value="<?php 
                                            echo $old_data->uLname?$old_data->uLname:$_SESSION['kyc_tib']['step_2']['uLname'];

                                             ?>"
                                            placeholder="<?php echo get_lang_msg("enter_your"); ?> <?php echo get_lang_msg("last_name"); ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo get_lang_msg("email_address"); ?> <sup>*</sup></label>
                                            <input 
                                            name="uEmail" 
                                            type="text" 
                                            class="form-control" 
                                            required 
                                            value="<?php 
                                            echo $old_data->uEmail?$old_data->uEmail:$_SESSION['kyc_tib']['step_2']['uEmail'];

                                             ?>"
                                            placeholder="<?php echo get_lang_msg("enter_your"); ?> <?php echo get_lang_msg("email_address"); ?>"
                                            >
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo get_lang_msg("date_of_birth"); ?> <sup>*</sup></label>
                                            <input 
                                            name="uDOB" 
                                            type="text" 
                                            class="form-control birth_date" 
                                            required
                                            value="<?php 
                                            echo $old_data->uDOB?date("d-m-Y",strtotime($old_data->uDOB)):$_SESSION['kyc_tib']['step_2']['uDOB'];

                                             ?>"
                                            placeholder="DD-MM-YYYY"
                                            >
                                        </div>
                                    </div>
                                    <?php /* ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?php echo get_lang_msg("residential_address"); ?> <sup>*</sup></label>
                                            <textarea
                                            name="uAddress"
                                            class="form-control" 
                                            required                                           
                                            ><?php 
                                            echo $old_data->uAddress?$old_data->uAddress:$_SESSION['kyc_tib']['step_2']['uAddress'];

                                             ?></textarea>
                                        </div>
                                    </div>
                                    <?php */ ?>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo get_lang_msg("zip_code"); ?> <sup>*</sup></label>
                                            <input 
                                            name="uZip" 
                                            type="text" 
                                            class="form-control" 
                                            required
                                            value="<?php 
                                            echo $old_data->uZip?$old_data->uZip:$_SESSION['kyc_tib']['step_2']['uZip'];

                                             ?>"
                                            placeholder="<?php echo get_lang_msg("enter_your"); ?> <?php echo get_lang_msg("zip_code"); ?>"
                                            >
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo get_lang_msg("city"); ?> <sup>*</sup></label>
                                            <input 
                                            name="uCity" 
                                            type="text" 
                                            class="form-control" 
                                            required
                                            value="<?php 
                                            echo $old_data->uCity?$old_data->uCity:$_SESSION['kyc_tib']['step_2']['uCity'];

                                             ?>"
                                            placeholder="<?php echo get_lang_msg("enter_your"); ?> <?php echo get_lang_msg("city"); ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo get_lang_msg("state"); ?> <sup>*</sup></label>
                                            <input 
                                            name="uState" 
                                            type="text" 
                                            class="form-control" 
                                            required
                                            value="<?php 
                                            echo $old_data->uState?$old_data->uState:$_SESSION['kyc_tib']['step_2']['uState'];

                                             ?>"
                                            placeholder="<?php echo get_lang_msg("enter_your"); ?> <?php echo get_lang_msg("state"); ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo get_lang_msg("street"); ?> <sup>*</sup></label>
                                            <input 
                                            name="uStreet" 
                                            type="text" 
                                            class="form-control" 
                                            required
                                            value="<?php 
                                            echo $old_data->uStreet?$old_data->uStreet:$_SESSION['kyc_tib']['step_2']['uStreet'];

                                             ?>"
                                            placeholder="<?php echo get_lang_msg("enter_your"); ?> <?php echo get_lang_msg("street"); ?>"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo get_lang_msg("apartment"); ?></label>
                                            <input 
                                            name="uApartment" 
                                            type="text" 
                                            class="form-control" 
                                            
                                            value="<?php 
                                            echo $old_data->uApartment?$old_data->uApartment:$_SESSION['kyc_tib']['step_2']['uApartment'];

                                             ?>"
                                            placeholder="<?php echo get_lang_msg("enter_your"); ?> <?php echo get_lang_msg("apartment"); ?>"
                                            >
                                        </div>
                                    </div>
                                    

                                   
                                    


                                 
                                  <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo get_lang_msg("country_of_residence"); ?> <sup>*</sup></label>
                                           
                                            <select class="form-control" required name="uCountry">
                                                <?php 

                                                $countries = $this->front_model->get_query_simple('*','dev_web_countries',array())->result_object();
                                                foreach($countries as $country)
                                                {
                                                ?>
                                                    <option value="<?php echo $country->id; ?>" 
                                                        <?php if($old_data->uCountry==$country->id || $_SESSION['kyc_tib']['step_2']['uCountry'])
                                                                    echo "selected";
                                                        ?>
                                                    >
                                                        <?php echo $country->nicename; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo get_lang_msg("nationality"); ?> <sup>*</sup></label>
                                           
                                            <select class="form-control" required name="uNationality">
                                                <?php 

                                                $countries = $this->front_model->get_query_simple('*','dev_web_countries',array())->result_object();
                                                foreach($countries as $country)
                                                {
                                                ?>
                                                    <option value="<?php echo $country->id; ?>" 
                                                        <?php if($old_data->uNationality==$country->id || $_SESSION['kyc_tib']['step_2']['uNationality'])
                                                                    echo "selected";
                                                        ?>
                                                    >
                                                        <?php echo $country->nicename; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo get_lang_msg("profession"); ?></label>
                                            <select class="form-control" required="" name="uEmployment">
                                                <option
                                                <?php if($old_data->uEmployment=="Unemployed" || $_SESSION['kyc_tib']['step_2']['uEmployment']=="Unemployed") echo "selected"; ?>
                                                 value="Unemployed">Unemployed</option>
                                                 <option
                                                <?php if($old_data->uEmployment=="Employee" || $_SESSION['kyc_tib']['step_2']['uEmployment']=="Employee") echo "selected"; ?>
                                                 value="Employee">Employee</option>
                                                 <option
                                                <?php if($old_data->uEmployment=="Self-employed" || $_SESSION['kyc_tib']['step_2']['uEmployment']=="Self-employed") echo "selected"; ?>
                                                 value="Self-employed">Self-employed</option>
                                                 <option
                                                <?php if($old_data->uEmployment=="Government designee" || $_SESSION['kyc_tib']['step_2']['uEmployment']=="Government designee") echo "selected"; ?>
                                                 value="Government designee">Government designee</option>
                                            </select>
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
                            <button class="btn btn-danger pull-right m-r-10" type="button">
                                <?php echo get_lang_msg("cancel"); ?></button>
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

            format: 'dd-mm-yyyy',
            endDate: '-0d'
        });
         $('.birth_date').datepicker({

            format: 'dd-mm-yyyy',

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
    
    $.post('<?php echo base_url().'ico/selfie_doc/0'; ?>',{data:1},function(data){
      
        $(that).before(data);
        $(that).html('+ More');
        $(that).prop('disabled',false);
    });
}
function moreBill(that)
{
    $(that).html('Please wait...');
    $(that).prop('disabled',true);
    $.post('<?php echo base_url().'ico/bill_doc/0'; ?>',{data:1},function(data){
        $(that).before(data);
        $(that).html('+ More');
        $(that).prop('disabled',false);
    });
}
// removeBill(that)
// {

// }

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

