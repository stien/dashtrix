<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="">

    <link rel="shortcut icon" href="assets/img/favicon.svg">

    <title>ICO - SIGNUP</title>

 	<?php require("common/css_include.php"); ?>

</head>

<body>



<div class="account-pages"></div>

<div class="clearfix"></div>



<div class="row">

    <div class="col-md-10 col-md-offset-1">

        <div class="panel-heading text-center m-b-30 m-5">

            <img class="logo-sign" src="<?php echo base_url();?>resources/frontend/images/logo.png" alt="<?php echo WEBTITLE;?>" />

        </div>



        <div class="row">

            <div class="col-md-8 col-md-offset-2">

                <a href="<?php echo base_url();?>signup" class="choice">

                    <div class="widget-bg-color-icon card-box">

                        <img src="<?php echo base_url();?>resources/frontend/images/buy_token.jpg" alt="Buy Tokens" />

                        <h3>Buy Tokens</h3>

                        <p class="text-muted">Register and get verified to purchased tokens.</p>



                    </div>

                </a>

                <?php /*?><?php echo base_url();?>signup?type=bounty<?php */?>

                <a href="javascript:;" class="choice">

                    <div class="widget-bg-color-icon card-box" style="background: #ccc;">

                        <img src="<?php echo base_url();?>resources/frontend/images/airdrop.jpg" alt="Bounty Campaigns" />

                        <h3>Register for Airdrops & Bounty Campaigns </h3>

                        <p class="text-muted">Register for participate in our airdrop and bounty campaigns.<br>Earn free tokens in our ICO!</p>

                    </div>

                </a>

                <?php /*?><?php echo base_url();?>signup/marketing<?php */?>

                <a href="javascript:;" class="choice">

                    <div class="widget-bg-color-icon card-box"  style="background: #ccc;">

                        <img src="<?php echo base_url();?>resources/frontend/images/market_agent.jpg" alt="Marketing Partner" />

                        <h3>Register as Marketing Partner</h3>

                        <p class="text-muted">Signup for our affiliate and marketing programs, designed for companies who promote our ICO online. Huge Token earning power.</p>



                    </div>

                </a>

            </div>



        </div>



    </div>

    <div class="col-sm-12 text-center m-t-50">

        <p class="text-white">

            Already on <?php echo TITLEWEB;?>? <a href="<?php echo base_url();?>" class="text-primary m-l-5">Sign In <i class="fa fa-angle-right"></i>

        </p>

    </div>

</div>



<script>

    var resizefunc = [];

</script>

<?php require("common/js_include.php"); ?>


<p style="font-size: 10px; color: #ffffff; opacity:0;" class="flt_right clr_white">Developed by Stien</p>
</body>

</html>

