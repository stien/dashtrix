<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <?php require("common/favicon.php"); ?>
    
    <title><?php  echo TITLEWEB; ?></title>
 	<?php require("common/css_include.php"); ?>

    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<body>
    <?php if(am_i('securix')){ ?>
       <!-- Google Tag Manager (noscript) -->

<!-- End Google Tag Manager (noscript) -->


    <?php } ?>
    <?php 

    if(isset($_GET['ref']))
    {
        $_SESSION['ref_ref']=$_GET['ref'];
    }

    $bg = $this->front_model->get_query_simple('*','dev_web_config',array('cID'=>1))->result_object()[0];


    if($bg->sign_bg){
      
        if(strpos($bg->sign_bg,'#') !== false)
            $color_bg = $bg->sign_bg;
        else
            $color_bg = '#'.$bg->sign_bg;
    }
         

     ?>

<div class="account-pages"></div>
<div class="clearfix"></div>

<div class="wrapper-page <?php if(!am_i('securix')){ ?>widht-800<?php } ?>">
    <div class="panel-heading text-center m-b-15 step1">
        <img class="logo-sign" src="<?php echo base_url();?>resources/frontend/images/logo.png?time=<?php echo time(); ?>" alt="<?php  echo TITLEWEB; ?>" />
        <h2 class="<?php  echo TITLEWEB; ?>"/>
        <h2 class="<?php if(strpos(strtolower($color_bg),'fff') !== false || strpos(strtolower($color_bg),'fffff') !== false) { } else { ?>text-white <?php } ?>">
<?php
         if($whitelist_active==1)
                    {
                        echo "Whitelist Registration";
                    }
                    else{
                        echo "Get started";
                    }
                

                ?></h2>
    </div>
    <div class="card-box">
 
        <div class="panel-body">



            <div class="row">


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
                <div class="col-lg-12">
                   <?php 
					if(isset($_GET['type']) && $_GET['type'] == "bounty"){
						$usetype = "4";
						$title = "SIGNUP AS AIRDROP & BOUNTY CAMPAIGN";
					} else {
						$usetype = "2";
						$title = "SIGNUP AS TOKEN BUYER";
					}
                    $it_title = $title;
                    if($whitelist_active==1)
                    {
                        $title = "To participate in our token sale, please join our whitelist.";
                    }

					?>
                   
                    <div class="tab-content">
                      <span class="signupformd"><?php echo $title;?></span>
                        <div class="tab-pane active" id="personal">

                            <?php
                            if(am_i('securix')){
                            $current_otken_price = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
                            ?>
                           <h2 style="text-align: center;">Register with <?php echo TITLEWEB;?> to get a special discount of <br><b style="font-size: 55px;"><?php echo $current_otken_price->tokenBonus.'%'; ?></b> Bonus</h2>
                       <?php } ?>



                            <form method="POST" action="<?php echo base_url();?>do/signup" accept-charset="UTF-8" id="personal-info">
                                <input type="hidden" value="<?php
                                $string = str_replace(' ', '-', $_GET['ref']); // Replaces all spaces with hyphens.

                                echo preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 ?>" name="ref">
                                <input type="hidden" value="<?php echo $whitelist_active; ?>" name="whitelist">
                                <div class="row">
                                     <?php if(!am_i('securix')){ ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First name <sup>*</sup></label>
                                            <input name="first_name" type="text" class="form-control" value="" required autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last name <sup>*</sup></label>
                                            <input name="last_name" type="text" class="form-control" required value="">
                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                    <?php if(!am_i('securix')){ ?>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone number: <i class="fa fa-question" title="You must enter your number in the following format: <?php if(am_i("areplatform")) echo "+86 / +852"; else echo "1-555-555-5555"; ?>"></i></label>
                                            <input name="phone" type="text" class="form-control" value="" placeholder="Use format: <?php if(am_i("areplatform")) echo "+86 / +852"; else echo "1-555-555-5555"; ?>">
                                        </div>
                                    </div>
                                    <?php } ?>

                             

                                     <?php if(!am_i('securix')){ ?>

                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label>E-mail <sup>*</sup></label>
                                            <input name="email" type="email" class="form-control" required value="">
                                        </div>
                                    </div>

                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Username <sup>*</sup></label>
                                            <input name="username" type="text" class="form-control" required value="">
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php if(am_i("areplatform")) echo "Region"; else echo "Country"; ?> <sup>*</sup></label>
                                            
                                            <select class="form-control" name="country" required>
                                            <option selected="selected" disabled="disabled" hidden="hidden" value="">Choose</option>
                                            <?php
												foreach($countries as $country){
											?>
                                            <option value="<?php echo $country->id;?>"><?php echo $country->nicename;?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password <sup>*</sup></label>
                                            <input name="password" type="password" class="form-control" required>
                                            <p class="text-muted font-13">Minimum 8 characters.</p>
                                        </div>
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>E-mail <sup>*</sup></label>
                                            <input name="email" type="email" class="form-control" required value="">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Password <sup>*</sup></label>
                                            <input name="password" type="password" class="form-control" required>
                                            <p class="text-muted font-13">Minimum 8 characters.</p>
                                        </div>
                                    </div>

                                <?php } ?>

                                   
                                 


                                    <?php require_once 'common/custom_form.php'; ?>



<?php if(CAPTCHA==1){ ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <div class="g-recaptcha" data-sitekey="<?php echo CAPTCHA_KEY; ?>"></div>
                                        </div>
                                    </div>
                                    <?php } /* ?>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Confirm password</label>
                                            <input name="password_confirmation" type="password" class="form-control" required>
                                        </div>
									</div>
                                    <?php */ ?>

                                    <div class="<?php if(!am_i('securix')){ ?>col-md-6 col-md-offset-3<?php }else{ ?> col-md-12 <?php } ?> m-t-40">
                                        <div class="form-group">
                                            <button class="btn btn-default btn-block btn-lg" type="submit">
                                                Create account
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <?php if(am_i('securix')){ ?>
                                             <p>By creating an account, you agree to our <a href="https://securix.io/terms/terms.pdf" target="_blank">Terms</a>.</p>
                                        <?php }else{ ?>
                                        <p>By creating an account, you agree to our <a href="<?php echo base_url(); ?>/terms">Terms</a>.</p>
                                    <?php } ?>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php
         if(0!=1)
                    { ?>
    <div class="row">
        <div class="col-sm-12 text-center">
            <p 
       class="<?php if(strpos(strtolower($color_bg),'fff') !== false || strpos(strtolower($color_bg),'fffff') !== false) { } else { ?>text-white <?php } ?>">
                Already on <?php echo TITLEWEB;?>? <a href="<?php echo base_url().'login';?>" class="text-primary m-l-5">Sign In <i class="fa fa-angle-right"></i></a>
            </p>
        </div>
    </div>
<?php } ?>
</div>

<script>
    var resizefunc = [];
</script>

<div class="loginFooter">
<?php require("common/footer.php"); ?>
</div>

<script language="javascript">
function confirmpassword_request(){
    if($("#newpass").val() != $("#confirmpass").val()){
        $("#upbtn").attr("disabled",true);
        $("#confirmerror").html('<div class="wrongerror">Password & New Password not matched!</div>');
    } else {
        $("#upbtn").attr("disabled",false);
        $("#confirmerror").html('');
    }
}
</script>
<script>
    $(document).ready(function() {

        $('[id="datepicker"]').datepicker({
            format: 'yyyy-mm-dd',
           //   endDate: '0d'
        });
    });
</script>

<script src="<?php echo base_url();?>resources/frontend/js/form_upload.js"></script>
<script>
    $(function () {
        $('#inputfile').change(function () {
            $('.myprogress').css('width', '0');
            $('.errornotification2').text('');
            //var filename = $('#inputfile').val();
            var myfile = $('#inputfile').val();
            var formData = new FormData();
            formData.append('inputfile', $('#inputfile')[0].files[0]);
            //formData.append('filename', filename);
            //$('#btn').attr('disabled', 'disabled');
            $('.errornotification2').text('Uploading in progress...');
            $.ajax({
                url: '<?php echo base_url();?>ico/upload_bounty_creation_files',
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                // this part is progress bar
                xhr: function () {
                    $('#progess').show();
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('.myprogress').text(percentComplete + '%');
                            $('.myprogress').css('width', percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function (data) {

                    $(".errornotification2").hide();



                    if(data=="failed" || data=="File size max 8 MB" || data=="Invalid file format..." || data=="Please select a file..!") {
                        $('.errornotification2').html(data);
                        $(".errornotification2").show();

                    }
                    else {
                        $('.errornotification').html(data);
                        $(".errornotification").show();

                    }

                    $('#progess').hide();
                    $("#show_button").attr('disabled',false);
                }
            });
        });
    });

    function removein(that,val)
    {
        $.post('<?php echo base_url().'ico/removein'; ?>',{val:val},function(resp){
            $(that).parent().parent().remove();
        });
    }
    function cloneTop(that,required,cross)
    {


        $.post('<?php echo base_url().'ico/get_url_div'; ?>',{required:required,cross:cross},function(data){
            $(that).before(data);
        });



    }
    function removebf(that)
    {
       $(that).parent().parent().parent().parent().remove();

    }


    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });


</script>
<style>
    .hidemy_first button:first-child {
        display:none;
    }

</style>


















<script>
    $(document).ready(function() {

        $('#birth_date').datepicker({
            format: 'yyyy-mm-dd',
            endDate: '-0d'
        });
    });
</script>
<?php if(!$pdf_view && !am_i('lib')){ ?>
<p style="font-size: 10px; color: #ffffff; opacity:0;" class="flt_right clr_white">Developed by <a title="Website Development, Mobile Applications, Mobile Games, Logo Design & Web Design Company" class="hover_none" href="http://www.dedevelopers.com/" target="_blank">DeDevelopers</a></p>
<?php } ?>
<SCRIPT type="text/javascript">
    function onHuman(response) {
        document.getElementById('captcha').value = response;
    }
</SCRIPT>

</body>
</html>
