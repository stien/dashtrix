<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <link rel="shortcut icon" href="assets/img/favicon.svg">
    <title><?php  echo TITLEWEB; ?> - Login</title>
 	<?php require("common/css_include.php"); require("common/favicon.php"); ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>

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

    <div class="panel-heading text-center m-b-15 right-style">
        <?php if(!am_i('yanu')){ ?>
        <h2 class="logInTl">Dashboard Login</h2>
    <?php } ?>
        <img class="logo-sign" src="<?php echo base_url();?>resources/frontend/images/logo.png?time=<?php echo time(); ?>" alt="<?php  echo TITLEWEB; ?>"/>

    <?php if(am_i('yanu')){ ?>

    <div class="row">

        <div class="col-sm-12 text-center">
            <p style="margin-top: 30px;" class="<?php if(strpos(strtolower($color_bg),'fff') !== false || strpos(strtolower($color_bg),'fffff') !== false) { } else { ?>text-white <?php } ?>">
                Create an account to participate in Yanu token sale <br> <a href="<?php echo base_url();?>signup/step"
                                                 class="text-primary m-l-5">Sign Up <i
                            class="fa fa-angle-right"></i></a>
            </p>
        </div>
    </div>
    <?php } ?>

    </div>

    <div class="card-box loginpage left-style">
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

            <form method="POST" action="<?php echo base_url();?>do/login" accept-charset="UTF-8" role="form">

            <div class="col-md-12">
                <div class="form-group">
                    <!-- <label>Email Address: <sup>*</sup></label> -->
                    <input name="username" class="form-control uname" type="text" required="" value="" placeholder="Email Address">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <!-- <label>Password: <sup>*</sup></label> -->
                    <input name="password" class="form-control pss" type="password" required="" placeholder="Password">
                </div>
            </div>
            <?php if(CAPTCHA==1){ ?>
                <div class="col-md-12">
                                        <div class="form-group">
                                                <div class="g-recaptcha" data-sitekey="<?php echo CAPTCHA_KEY; ?>"></div>
                                        </div>
                                    </div>
<?php } ?>

            <div class="col-md-12 m-t-20">
                <div class="form-group">
                    <button class="btn btn-default btn-block btn-lg" type="submit">
                        LOG IN
                    </button>
                </div>
            </div>

<?php if(!am_i('yanu')){ ?>
            <div class="form-group m-t-20 m-b-0">
                <div class="col-sm-12">

                               <!-- <div class="text-dark midLoginText">OR</div> -->

                    <a href="<?php echo base_url();?>signup/step" class="text-dark btn btn-default btn-block btn-lg orangeButt">CREATE NEW ACCOUNT</a>

                </div>
            </div>
 <?php }else{ ?>
 <!--    <div class="form-group m-t-20 m-b-0">
                <div class="col-sm-12 text-center">
                    <a href="<?php echo base_url();?>forgot-password" class="text-dark"><i
                                class="fa fa-lock m-r-5"></i> Forgot Password?</a>
                </div>
            </div> -->
 <?php } ?>

            </form>

        </div>
    </div>


  <div class="row">
        <div class="col-sm-12 text-center">
         
                
                    <a href="<?php echo base_url();?>forgot-password" class="text-dark"><i
                                class="fa fa-help m-r-5"></i> Forgot Credentials?</a>
           
        </div>
    </div> 

    <?php if(!am_i('yanu')){ ?>
<!--     <div class="row">
        <div class="col-sm-12 text-center">
            <p class="">
                <a href="<?php echo base_url();?>privacy-policy" class="text-primary m-l-5">
                    <i class="fa fa-book m-r-5"></i> Privacy Policy</a>
            </p>
        </div>
    </div> -->
    <?php } ?>

</div>

<script>
    var resizefunc = [];
</script>
<div class="loginFooter">
<?php require("common/footer.php"); ?>
</div>

<script>
    jQuery(document).ready(function(){

        $("form").validate({
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

            rules: {"username":{"laravelValidation":[["Required",[],"The username field is required.",true],["String",[],"The username must be a string.",false]]},"password":{"laravelValidation":[["Required",[],"The password field is required.",true],["String",[],"The password must be a string.",false]]}},
            onfocusout: false
          })

        })

</script>

<?php unset($_SESSION['thankyou']); unset($_SESSION['error']);?>
<?php if(!$pdf_view && !am_i('lib')){ ?>
<p style="font-size: 10px; color: #ffffff; opacity:0;" class="flt_right clr_white">Developed by Stien</p>
<?php } ?>

<div id="page">
  <div id="phrase_box">
  <svg width="100%" height="100%">
    <defs>
      <!--<style type="text/css">
        @font-face {
          font-family: "Proxima";
          src: url('');
        }
      </style>-->
      <mask id="mask" maskUnits="userSpaceOnUse" maskContentUnits="userSpaceOnUse">
        <linearGradient id="linearGradient" gradientUnits="objectBoundingBox" x2="0" y2="1">
          <stop stop-color="white" stop-opacity="0" offset="0%"/>
          <stop stop-color="white" stop-opacity="1" offset="30%"/>
          <stop stop-color="white" stop-opacity="1" offset="70%"/>
          <stop stop-color="white" stop-opacity="0" offset="100%"/>
        </linearGradient>
        <rect width="100%" height="100%" fill="url(#linearGradient)"/>
      </mask>
    </defs>
    <g width="100%" height="100%" style="mask: url(#mask);">
      <g id="phrases"></g>
    </g>
  </svg>
  </div>

</div>
</body>

</html>
