<?php include("common/header.php");?>


<?php 

function value_help($verification,$user,$key)
{

 
    if($verification->$key){
        echo $verification->$key;
    
    return;
    }
    if($user->$key)
        echo $user->$key;
    
}


 ?>
<div class="wrapper-page widht-800">

   

                   

<form method="POST" action="" accept-charset="UTF-8" id="personal-info" onsubmit="return PleaseWait();">

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

                   <?php $title = "Verify Yourself"; ?>

                      <span class="signupformd"><?php echo $title;?></span>



                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name <sup>*</sup></label>
                                            <input name="uFname" type="text" class="form-control" required value="<?php echo value_help($verification,$user,'uFname'); ?>" autofocus
                                            placeholder="Enter your First Name"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name <sup>*</sup></label>
                                            <input 
                                            name="uLname" 
                                            type="text" 
                                            class="form-control" 
                                            required 
                                            value="<?php echo value_help($verification,$user,'uLname'); ?>"
                                            placeholder="Enter your Last Name"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Middle Name</label>
                                            <input 
                                            name="uMname" 
                                            type="text" 
                                            class="form-control" 
                                             
                                            value="<?php echo value_help($verification,$user,'uMname'); ?>"
                                            placeholder="Enter your Middle Name"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date of Birth <sup>*</sup></label>
                                            <input 
                                            name="uDOB" 
                                            type="text" 
                                            class="form-control birth_date" 
                                            required
                                            value="<?php echo value_help($verification,$user,'uDOB'); ?>"
                                            placeholder="YYYY-MM-DD"
                                            >
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last 4 Digits of you Credit/Debit Card <sup>*</sup></label>
                                            <input 
                                            name="card_last_4_digits" 
                                            type="text" 
                                            class="form-control" 
                                            required
                                            value="<?php echo value_help($verification,$user,'card_last_4_digits'); ?>"
                                            placeholder="XXXX"
                                            >
                                        </div>
                                    </div>
                                   
                              
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone Number with country code <small>e.g +440000000000</small> <sup>*</sup></label>
                                            <input 
                                            name="uPhone" 
                                            type="text" 
                                            class="form-control" 
                                            required
                                            value="<?php echo value_help($verification,$user,'uPhone'); ?>"
                                            placeholder="Number"
                                            >
                                        </div>
                                    </div>
                                 

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Source of income <sup>*</sup></label>
                                            <input 
                                            name="uEmployment" 
                                            type="text" 
                                            class="form-control" 
                                            required
                                            value="<?php echo value_help($verification,$user,'uEmployment'); ?>"
                                            placeholder="Enter your source of income"
                                            >
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Approx. Annual Gross Income (USD)<sup>*</sup></label>
                                            <input 
                                            name="uGross" 
                                            type="number" 
                                            step="1"
                                            class="form-control" 
                                            required
                                            value="<?php echo value_help($verification,$user,'uGross'); ?>"
                                            placeholder="Enter your Annual Gross Income"
                                            >
                                        </div>
                                    </div>

                                    


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>How many tokens are you planning to purchase(1SRXIO = 1 USD)?<sup>*</sup></label>
                                            <input 
                                            name="uContribute" 
                                            type="number" 
                                            step="1" 
                                            class="form-control" 
                                            required
                                            value="<?php echo value_help($verification,$user,'uContribute'); ?>"
                                            placeholder="$"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?php echo $kyc->ethereum_lable?$kyc->ethereum_lable:"Enter your Ethereum Address"; ?> <sup>*</sup></label>
                                            <small><?php echo $kyc->ethereum_text; ?></small>
                                            <input 
                                            name="uETH" 
                                            type="text"
                                            class="form-control" 
                                            required
                                            value="<?php echo value_help($verification,$user,'uETH'); ?>"
                                            placeholder="<?php echo $kyc->ethereum_lable; ?>"
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

 <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php $title = "Address"; ?>

                      <span class="signupformd"><?php echo $title;?></span>

                               
                                 

                                <div class="row">
                                   <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Country <sup>*</sup></label>
                                            <?php //$x___ =value_help($verification,$user,'uCountry');




                                        
                                           ?>
                                            <select class="form-control" required name="uCountry">
                                                <?php 

                                                $countries = $this->front_model->get_query_simple('*','dev_web_countries',array())->result_object();
                                                foreach($countries as $country)
                                                {
                                                ?>
                                                    <option value="<?php echo $country->id; ?>" 
                                                        <?php if(value_help($verification,$user,'uCountry')==number_format($country->id))
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
                                            <label>Zip Code <sup>*</sup></label>
                                            <input 
                                            name="uZip" 
                                            type="text" 
                                            class="form-control" 
                                            required
                                            value="<?php echo value_help($verification,$user,'uZip'); ?>"
                                            placeholder="Enter Zip Code"
                                            >
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City <sup>*</sup></label>
                                            <input 
                                            name="uCity" 
                                            type="text" 
                                            class="form-control" 
                                            required
                                            value="<?php echo value_help($verification,$user,'uCity'); ?>"
                                            placeholder="Enter City"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>State/Province <sup>*</sup></label>
                                            <input 
                                            name="uState" 
                                            type="text" 
                                            class="form-control" 
                                            required
                                            value="<?php echo value_help($verification,$user,'uState'); ?>"
                                            placeholder="Enter State/Province"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Street <sup>*</sup></label>
                                            <input 
                                            name="uStreet" 
                                            type="text" 
                                            class="form-control" 
                                            required
                                            value="<?php echo value_help($verification,$user,'uStreet'); ?>"
                                            placeholder="Enter Street"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Apartment</label>
                                            <input 
                                            name="uApartment" 
                                            type="text" 
                                            class="form-control" 
                                            
                                            value="<?php echo value_help($verification,$user,'uApartment'); ?>"
                                            placeholder="Enter Apartment"
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php $title = "Upload Documents"; ?>

                      <span class="signupformd"><?php echo $title;?></span>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Document Type <sup>*</sup></label>
                                            <select required name="document_type" class="form-control">
                                                <option <?php if($verification_document->type==1)
                                                echo "selected";
                                                 ?>
                                                 value="1"
                                                 >National ID Card
                                                </option>
                                                <option <?php if($verification_document->type==2)
                                                echo "selected";
                                                 ?>
                                                 value="2"
                                                 >Passport
                                                </option> <?php /* ?>
                                                <option <?php if($verification_document->type==3)
                                                echo "selected";
                                                 ?>
                                                 value="3"
                                                 >Driving Licence
                                                </option>
                                                <?php */ ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Including Country <sup>*</sup></label>
                                            <select class="form-control" required name="including_country">
                                                <?php
                                                foreach($countries as $country)
                                                {
                                                ?>
                                                    <option value="<?php echo $country->id; ?>" 
                                                        <?php if($verification_document->including_country==$country->id)
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
                                            <label>ID Card/Passport Number <sup>*</sup></label>
                                            <input 
                                            name="id_card_passport_number" 
                                            type="text" 
                                            class="form-control" 
                                            required
                                            value="<?php echo value_help($verification,$user,'id_card_passport_number'); ?>"
                                            placeholder="Please enter ID Card/Passport Number"
                                            >
                                        </div>
                                    </div>

                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Expiry Date <sup>*</sup></label>
                                            <input 
                                            name="expiry_date" 
                                            type="text" 
                                            class="form-control birth_date" 
                                            required
                                            value="<?php echo value_help($verification,$user,'expiry_date'); ?>"
                                            placeholder="YYYY-MM-DD"
                                            >
                                        </div>
                                    </div>



                                    
                                    
                                    <div class="col-md-12">
                                        <div class="form-group taking_image">
                                            <label>Document Front <sup>*</sup>  </label>
                                            <input name="inputfile[]" type="file" accept="application/pdf, image/*" class="form-control inputfile"  value="" data-name="front" required="">
                                            <label class="msg"></label>
                                            <img data-id="front" src="" class="display_none">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group taking_image">
                                            <label>Document Back <sup>*</sup>  </label>
                                            <input name="inputfile[]" type="file" accept="application/pdf, image/*" class="form-control inputfile"  value="" data-name="back" required="">
                                            <label class="msg"></label>
                                            <img data-id="back" src="" class="display_none">
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <hr>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group taking_image">
                                            <label>Selfie <sup>*</sup>  </label>
                                                <?php echo selfie_doc(1); ?>
                                                <?php //echo selfie_doc(); ?>
                                              <?php /* ?>  <a href="javascript:;" onclick="moreSelfie(this);" class="btn btn-xs btn-default easy w-auto">+ More</a>
                                               <?php */ ?>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <hr>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group taking_image">
                                            <label>Proof of your address e.g Utility Bills or Driving Licence <sup>*</sup>  </label>
                                                <?php echo bill_doc(1); ?>
                                               <?php /* ?>
                                                <a href="javascript:;" onclick="moreBill(this);" class="btn btn-xs btn-default  easy w-auto">+ More</a>
                                                <?php */ ?>
                                        </div>
                                    </div>
 <div class="col-md-12">
                                        <hr>
                                    </div>

                                     <div class="col-md-12 " style="margin-top: 20px;" >
                                        <div class="form-group ">
                                            <ul>
                                                <li>Acceptable file formate: JPG, JPEG, PNG & PDF;</li>
                                                <li>Not acceptable photos of screen or photocopies etc;</li>
                                                <li>All sides of the document should be seen in the photo;</li>
                                                <li>Document should take over 50% or more of the frame;</li>
                                                <li>The picture should be clear without the blur or glare;</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                                   



 <div class="col-md-8 col-md-offset-2 text-center">
 <small>
    <?php echo $kyc_data->footer_text_1; ?>
</small>
 </div>

                                        
                                    
                                    

                                   

                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button  id="verification" class="btn btn-default btn-block btn-lg" type="submit">

                                               Send To Verification

                                            </button>

                                        </div>

                                    </div>

                                   

                              

</form>

             

</div>



<script>

    var resizefunc = [];

</script>

<?php include("common/footer.php");?>


<script type="text/javascript">
    function PleaseWait()
    {
        $("body").append('<div class="loading">Loading&#8230;<br>Please wait, your information is beign processed. It may take several minutes</div>');
        return true;
    }
</script>
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
</style>


</body>

</html>

