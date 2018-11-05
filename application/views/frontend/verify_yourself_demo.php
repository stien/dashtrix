<?php include("common/header.php");?>


<?php 

function value_help($verification,$user,$key)
{

 
    if($verification->$key)
        echo $verification->$key;
    if($user->$key)
        echo $user->$key;
    
}


 ?>
<div class="wrapper-page widht-800">

   

                   

<form method="POST" action="" accept-charset="UTF-8" id="personal-info">
    <div class="row">
        <div class="col-md-12">
            <div id="error_div" class="wrongerror" style="display: none;"></div>
        </div>
    </div>
<div class="step_1 easy">
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
                                            <label>Email</label>
                                            <input 
                                            name="uEmail" 
                                            type="text" 
                                            class="form-control" 
                                             
                                            value="<?php echo value_help($verification,$user,'uEmail'); ?>"
                                            placeholder="Enter your Email"
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
                                            <label>Phone Number <sup>*</sup></label>
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

 <div class="card-box ">

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
                                            <input type="hidden" name="step" value="1" class="step_selector">

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
            </div>
<div class="easy step_2 " style="display: none;">
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
                                            <select required name="document_type" class="form-control" onchange="take_care_of_doc_back(this.value)">
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
                                                </option>  
                                                <option <?php if($verification_document->type==3)
                                                echo "selected";
                                                 ?>
                                                 value="3"
                                                 >Driving Licence
                                                </option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Including Country <sup>*</sup></label>
                                            <input type="hidden" name="step" value="2" class="step_selector">

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



                                    
                                    
                                    <div class="col-md-12">
                                        <div class="form-group taking_image">
                                            <label>Document Front <sup>*</sup>  </label>
                                            <input name="inputfile[]" type="file" accept="application/pdf, image/*" class="form-control inputfile"  value="" data-name="front" required="">
                                            <label class="msg"></label>
                                            <img data-id="front" src="" class="display_none">
                                        </div>
                                    </div>

                                    <div class="col-md-12" id="doc_back">
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
                                            <label>Selfie  <sup>*</sup>  </label>
                                                <?php echo selfie_doc(1); ?>
                                               
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <hr>
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


                                   

</div>

 <div class="col-md-8 col-md-offset-2 text-center">
 <small>
    <?php echo $kyc_data->footer_text_1; ?>
</small>
 </div>

                                        
                                    
                                    

                                   

                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">
                                            <input type="hidden" name="step" value="1" class="step_selector">

                                            <button id="verification" class="btn btn-default btn-block btn-lg" type="button" onclick="submitForm();">

                                               Next

                                            </button>

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






$(".step_1 input").on('input',function(){
    if($(this).val()!="")
    {
        $(this).css('border-color','#E3E3E3');
        $(this).next('.f_r').remove();
    }
});
function submitForm()
{

    $(".f_r").remove();
    // step_1
    
    var x = true;

    var current_step = $(".step_selector").val();

    $(".step_"+current_step+" input").each(function(i,v){

        var attr = $(this).attr('required');

        // For some browsers, `attr` is undefined; for others,
        // `attr` is false.  Check for both.
        if (typeof attr !== typeof undefined && attr !== false) {

            if($(this).val()==""){
                $(this).css('border-color','red');
                // $(this).after('<span class="easy f_r">This field is required!</span>');
                $(this).focus();
                x = false;

                return false;
            }
            
        }




        
    });

setTimeout(function(){
    if(x){
    $("body").append('<div class="loading">Loading&#8230;</div>');

    var data = $(".step_"+current_step+" :input").serializeArray();
    $.post('<?php echo base_url().'ico/verify_yourself'; ?>',data,function(data){
        data = JSON.parse(data);

        if(data.success=="1")
        {
            open_step_2();
        }
        else if(data.success=="2"){
            window.location="<?php echo base_url().'dashboard'; ?>";

        }
        else{
            $(".loading").remove();

            $("#error_div").html(data.error);
            $("#error_div").show();
            $("#error_div").focus();

        }
    });
}
},10);

    // if(x)
    // {
    //     return true;
    // }
    // else
    // {
    //     alert("You need to fill one of them: Routing No., Swift Code, IBAN");
    //     return false;
    // }
}
function open_step_2()
{
    $("#error_div").hide();

    $("#error_div").html("Unknow Error");
    $(".step_1").hide();
    $(".step_2").show();
    $(".step_selector").val(2);
    $(".loading").remove();
    // $("#verification").html("Verify");
    


}
function take_care_of_doc_back(id)
{
    if(id==2)
    {
        $("#doc_back input").prop('required',false);
        $("#doc_back").hide();

    }
    else
    {
        $("#doc_back input").prop('required',true);
        $("#doc_back").show();        
    }
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
</style>


</body>

</html>

