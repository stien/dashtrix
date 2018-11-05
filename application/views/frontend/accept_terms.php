<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <link rel="shortcut icon" href="assets/img/favicon.svg">
    <title>ICO - Accept Terms & Conditions</title>
 	<?php require("common/css_include.php"); ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>

<div class="wrapper-page">
    <div class="panel-heading text-center m-b-15">
        <img src="<?php echo base_url();?>resources/frontend/images/logo.png" alt="ICO"/>
        <h2 class="text-white">Accept Terms & Conditions to continue</h2>
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
            
            <form method="POST" action="<?php echo base_url();?>ico/accept_terms" accept-charset="UTF-8" role="form">


            <div class="col-md-12">
                 <div class="form-group">
                    <label>
                        <input name="st[]"  type="checkbox" required="" value="1">

                        <?php echo $terms->text; ?>

                    </label>
                </div>
            </div>



            <?php foreach(json_decode($terms->c_statements,true) as $st){ ?>
            <div class="col-md-12">
                <div class="form-group">
                    <label>
                        <input name="st[]"  type="checkbox" required="" value="1">

                        <?php echo $st; ?>

                    </label>
                </div>
            </div>

            <?php } ?>

           

            

            <div class="col-md-12 m-t-20">
                <div class="form-group">
                    <button class="btn btn-default btn-block btn-lg" type="submit" name="terms">
                        Submit
                    </button>
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

<?php unset($_SESSION['thankyou']);?>
</body>
</html>
