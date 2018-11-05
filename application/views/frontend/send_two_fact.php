<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <link rel="shortcut icon" href="assets/img/favicon.svg">
    <title>ICO - 2-Factor Authentication</title>
 	<?php require("common/css_include.php"); ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>

<div class="wrapper-page">
    <div class="panel-heading text-center m-b-15">
        <img src="<?php echo base_url();?>resources/frontend/images/logo.png" alt="ICO"/>
        <h2 class="text-white">Welcome back</h2>
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
            
            <form method="POST" action="<?php echo base_url();?>submit-otp" accept-charset="UTF-8" role="form">

            <div class="col-md-12">
                <div class="form-group">
                    <label>OTP: <sup>*</sup> <small>
                        <i class="fa fa-info"></i> If your provided phone number was correct, you'll receive OTP in 2 minutes.
                    </small></label>
                    <input name="otp" class="form-control" type="text" required="" value="">
                </div>
            </div>


            <div class="col-md-12 m-t-20">
                <div class="form-group">
                    <button class="btn btn-default btn-block btn-lg" type="submit">
                        Submit
                    </button>
                </div>
            </div>

            <div class="form-group m-t-20 m-b-0">
                <div class="col-md-6">
                    <a href="<?php echo base_url().'resend-otp'; ?>" class="text-dark"><i
                                class="fa fa-repeat m-r-5"></i> Resend OTP</a>
                </div>

                <div class="col-md-6 text-right">
                    <a href="<?php echo base_url().'logout'; ?>" class="text-dark"><i
                                class="fa fa-lock m-r-5"></i> Logout</a>
                </div>
                <div class="col-md-12">
                    <a href="<?php echo current_url().'?change_phone_number=1'; ?>" class="text-dark"><i
                                class="fa fa-edit m-r-5"></i> Change Phone Number</a>
                </div>
            </div>

            </form>

        </div>
    </div>


</div>

<script>
    var resizefunc = [];
</script>
<?php require("common/footer.php"); ?>




<?php unset($_SESSION['thankyou']);?>
</body>
</html>
