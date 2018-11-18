<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    
    <title><?php  echo TITLEWEB; ?> - FORGOT PASSWORD</title>
 	<?php require("common/favicon.php"); require("common/css_include.php");  ?>
</head>
<body>
    <?php if(am_i('securix')){ ?>
       <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KSTKNCH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


    <?php } ?>

    <?php 

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

<div class="wrapper-page">
    <div class="panel-heading text-center m-b-15">
        <img class="logo-sign" src="<?php echo base_url();?>resources/frontend/images/logo.png?time=<?php echo time(); ?>" alt="<?php  echo TITLEWEB; ?>"/>
        <h2 class="<?php  echo TITLEWEB; ?> <?php if(strpos(strtolower($color_bg),'fff') !== false || strpos(strtolower($color_bg),'fffff') !== false) { } else { ?>text-white <?php } ?> ">Forgot/Lost Credentials</h2>
    </div>
    <div class="card-box">
        <div class="panel-body">
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
            
            <form method="POST" action="<?php echo base_url();?>do/forgot" accept-charset="UTF-8" id="send-password-link" role="form">

                
                <div class="col-md-12">
                    <p class="text-center m-b-20">Enter your email address and we&#039;ll send you a temporary password on your email.</p>
                    <div class="form-group">
                        <label>E-mail address</label>
                        <input class="form-control" type="email"  name="email" value="">
                    </div>
                </div>

                <div class="col-md-12 m-t-20">
                    <div class="form-group">
                        <button class="btn btn-default btn-block btn-lg _t_p" type="submit">
                            Send temporary password
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <p class=" <?php if(strpos(strtolower($color_bg),'fff') !== false || strpos(strtolower($color_bg),'fffff') !== false) { } else { ?> text-white <?php } ?>">
                Already on <?php echo TITLEWEB;?>? <a href="<?php echo base_url();?>" class="text-primary m-l-5">Sign In <i class="fa fa-angle-right"></i>
            </p>
        </div>
    </div>

</div>

<script>
    var resizefunc = [];
</script>

<div class="loginFooter">
<?php require("common/footer.php"); ?>
</div>

<script>
    jQuery(document).ready(function(){

        $("#send-password-link").validate({
            errorElement: 'span',
            errorClass: 'help-block error-help-block',

            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length ||
                    element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                    error.insertAfter(element.parent());
                    // else just place the validation message immediatly after the input
                }
                else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error'); // add the Bootstrap error class to the control group
            },

            
            /*
             // Uncomment this to mark as validated non required fields
             unhighlight: function(element) {
             $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
             },
             */
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error'); //.addClass('has-success'); // remove the Boostrap error class from the control group
            },

            focusInvalid: false, // do not focus the last invalid input
            
            rules: {"email":{"laravelValidation":[["Required",[],"The email field is required.",true],["Email",[],"The email must be a valid email address.",false]]}},
            onfocusout: false
        })
    })
</script>
<?php unset($_SESSION['thankyou']);unset($_SESSION['error']);?>

<?php if(!$pdf_view && !am_i('lib')){ ?>
<p style="font-size: 10px; color: #ffffff; opacity:0;" class="flt_right clr_white">Developed by <a title="Website Development, Mobile Applications, Mobile Games, Logo Design & Web Design Company" class="hover_none" href="http://www.dedevelopers.com/" target="_blank">DeDevelopers</a></p>
<?php } ?>
</body>
</html>
