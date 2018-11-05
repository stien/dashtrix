<?php
/**
 * Created by PhpStorm.
 * User: Mahev Stark
 * Date: 4/30/2018
 * Time: 2:43 PM
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <link rel="shortcut icon" href="assets/img/favicon.svg">
    <title>ICO - Verify Email Address</title>
    <?php require("common/css_include.php"); ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>

<div class="wrapper-page">
    <div class="panel-heading text-center m-b-15">
        <img src="<?php echo base_url();?>resources/frontend/images/logo.png" alt="ICO"/>
        <h2 class="text-white">Verify Email Address</h2>
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

            <form method="POST" action="" accept-charset="UTF-8" role="form">

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="successfull">
                            Your E-mail address isn't verified, please verify your E-mail address by clicking link in E-mail sent to you by us or you may request a new verification E-mail.
                        </div>
                    </div>
                </div>



                <div class="col-md-12 m-t-20">
                    <div class="form-group">
                        <a href="<?php echo base_url().'resend-verification-email'; ?>">
                            <button class="btn btn-default btn-block btn-lg" type="button">
                               Resend E-mail
                            </button>
                        </a>
                    </div>
                </div>

                 <div class="row">
        <div class="col-sm-12 text-center">
            <p >
                Not Received? <a href="<?php echo base_url().'logout'; ?>">Logout</a>
            </p>
        </div>
    </div>


            </form>

        </div>
    </div>
   


</div>

<script>
    var resizefunc = [];
</script>
<?php require("common/js_include.php"); ?>


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

<?php unset($_SESSION['thankyou']);

unset($_SESSION['error']);
?>
<p style="font-size: 10px; color: #ffffff; opacity:0;" class="flt_right clr_white">Developed by <a title="Website Development, Mobile Applications, Mobile Games, Logo Design & Web Design Company" class="hover_none" href="http://www.dedevelopers.com/" target="_blank">DeDevelopers</a></p>
</body>
</html>

