<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <link rel="shortcut icon" href="assets/img/favicon.svg">
    <title>ICO - AIRDROP SIGN UP</title>
 	<?php require("common/css_include.php"); ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>

<div class="wrapper-page widht-800">
    <div class="panel-heading text-center m-b-15">
        <img class="logo-sign" src="<?php echo base_url();?>resources/frontend/images/logo.png" alt="ICO" />
        <h2 class="text-white">Get started</h2>
    </div>
    <div class="card-box">

        <div class="panel-body">

            <div class="row">
                <div class="col-lg-12">
                   
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal">
                            <form method="POST" action="<?php echo base_url();?>do/signup/marketing" accept-charset="UTF-8" id="company-info">
                            <input type="hidden" name="type" value="4" />                            
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="m-t-0 header-title"><b>Company information</b></h4>
                                        <p class="text-muted font-13 m-b-30">Enter your company information in the form bellow.</p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Company name <sup>*</sup></label>
                                            <input name="name" type="text" required class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address <sup>*</sup></label>
                                            <input name="address" type="text" required class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Postal code <sup>*</sup></label>
                                            <input name="postal_code" type="text" required class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City <sup>*</sup></label>
                                            <input name="city" type="text" required class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Country <sup>*</sup></label>
                                            
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
                                            <label>Company ID number <sup>*</sup></label>
                                            <input name="id_number" type="text" class="form-control" required value="">
                                            <p class="text-muted font-13">ID - unique number of company</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tax number <sup>*</sup></label>
                                            <input name="tax_number" type="text" class="form-control" required value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone number <sup>*</sup></label>
                                            <input name="phone" type="text" class="form-control" required value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>E-mail <sup>*</sup></label>
                                            <input name="email" type="email" class="form-control" required value="">
                                            <p class="text-muted font-13">Official company e-mail address.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>General manager <sup>*</sup></label>
                                            <input name="manager" type="text" class="form-control" required value="">
                                            <p class="text-muted font-13">Full name of the official general manager.</p>
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
                                            <label>Password <sup>*</sup></label>
                                            <input name="password" type="password" required class="form-control">
                                            <p class="text-muted font-13">Minimum 8 characters.</p>
                                        </div>
                                    </div>
                                    <?php /* ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <div class="g-recaptcha" data-sitekey="6LfwclQUAAAAAHN1mXuB6NG2Q3gecwB1l0HfT5k5"></div>
                                        </div>
                                    </div>
                                   
								   		<div class="col-md-6">
                                        <div class="form-group">
                                            <label>Confirm password</label>
                                            <input name="password_confirmation" type="password" required class="form-control">
                                        </div>
                                    </div>
								<?php */ ?>
                                </div>
                                <div class="col-md-6 col-md-offset-3 m-t-40">
                                        <div class="form-group">
                                            <button class="btn btn-default btn-block btn-lg" type="submit">
                                                Create account
                                            </button>
                                        </div>
                                    </div>
                                <hr>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <p class="text-white">
                Already on <?php echo TITLEWEB;?>? <a href="<?php echo base_url();?>" class="text-primary m-l-5">Sign In <i class="fa fa-angle-right"></i></a>
            </p>
        </div>
    </div>

</div>

<script>
    var resizefunc = [];
</script>
<?php require("common/js_include.php"); ?>

<script>
    $(document).ready(function() {

        $('#birth_date').datepicker({
            format: 'yyyy-mm-dd',
            endDate: '-0d'
        });
    });
</script>

<p style="font-size: 10px; color: #ffffff; opacity:0;" class="flt_right clr_white">Developed by <a title="Website Development, Mobile Applications, Mobile Games, Logo Design & Web Design Company" class="hover_none" href="http://www.dedevelopers.com/" target="_blank">DeDevelopers</a></p>
<SCRIPT type="text/javascript">
    function onHuman(response) {
        document.getElementById('captcha').value = response;
    }
</SCRIPT>
</body>
</html>
