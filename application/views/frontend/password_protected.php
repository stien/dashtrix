<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <link rel="shortcut icon" href="assets/img/favicon.svg">
    <title>ICO - Login</title>
 	<?php require("common/css_include.php"); ?>
</head>
<body style="background: #2a2a2a;">

<div class="account-pages"  style="background: #2a2a2a;"></div>
<div class="clearfix"></div>

<div class="wrapper-page" style="width: 80%;">
    <div class="panel-heading  m-b-15">
        <img src="<?php echo base_url();?>resources/frontend/images/logo.png" alt="ICO"/>
    </div>
    <div class="col-md-5">
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
            
            <form method="POST" action="<?php echo base_url();?>ico/check_password_validate" accept-charset="UTF-8" role="form">
            <div class="col-md-12">
               <p><strong>Please enter password to access the website.</strong></p>
                <div class="form-group">
                    <label>Password: <sup>*</sup></label>
                    <input name="passwordprotected" class="form-control" type="password" required="">
                </div>
            </div>

            <div class="col-md-12 m-t-20">
                <div class="form-group">
                    <button class="btn btn-default btn-block btn-lg" type="submit">
                        ACCESS WEBSITE
                    </button>
                </div>
            </div>

          
            </form>

        </div>
    </div>
    </div>
    
	<div class="col-md-1">&nbsp;</div>
   
    <div class="col-md-5 right">
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
            
            <form method="POST" action="<?php echo base_url();?>ico/send_email_password" accept-charset="UTF-8" role="form">
            <div class="col-md-12">
               <p><strong>Fill out the info below and a password will be automatically sent to you.</strong></p>
                <div class="form-group">
                  
                    <input name="namesender" class="form-control" placeholder="Name *" type="text" required="">
                </div>
                <div class="form-group">
                   
                    <input name="emailsend" class="form-control" type="email"placeholder="Email Address *" t required="">
                </div>
                <div class="form-group">
                   
                    <input name="companysend" class="form-control" type="text"placeholder="Company *" t required="">
                </div>
                <div class="form-group">
                    
                    <input name="urlsend" class="form-control" type="url"placeholder="URL *" t required="">
                </div>
            </div>

            <div class="col-md-12 m-t-20">
                <div class="form-group">
                    <button class="btn btn-default btn-block btn-lg" type="submit">
                        SUBMIT
                    </button>
                </div>
            </div>

          
            </form>

        </div>
    </div>
    </div>

</div>

<script>
    var resizefunc = [];
</script>
<?php require("common/js_include.php"); ?>

<?php unset($_SESSION['thankyou']); unset($_SESSION['error']);?>
</body>
</html>
