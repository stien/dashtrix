<?php include("common/header.php");?>

<div class="wrapper-page widht-800" style=" margin-bottom: 100px;">

   
<h2><?php

    echo get_lang_msg("KYC_successfully_submitted");
 ?></h2>
                   

<form method="POST" action="" accept-charset="UTF-8" id="personal-info">
<?php //require 'common/change_lang_kyc_tib.php'; ?>

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


                                <div class="col-md-12 nopad">
                                    <label>Your KYC information has been submitted, our team will review and inform you shortly, meanwhile you may purchase tokens but all the transactions will be cancelled/refunded in case your KYC infromation is rejected</label>
                                </div>

                                 <div class="row">
                                   
                                </div>

                                    
                                   
                                   
                                </div>
                            </div>
                        </div>
                    </div>
          
                <div class="col-md-12 nopad m-t-40">

                    <div class="form-group">
                        <input type="hidden" name="step_1_agree" value="1">
                        <a href="<?php echo base_url().'buy-tokens'; ?>">
                            <button id="i_agree" class="btn btn-default pull-right " type="button" name="submit" value="1">
                               Buy Tokens
                            </button>
                        </a>
                        <a href="<?php echo base_url().'dashboard'; ?>">
                            <button class="btn btn-danger pull-right m-r-10" type="button">Go to Dashboard</button>
                        </a>

                    </div>

                </div>         
</div>
                         
                
                   

                                   

                              

</form>

             

</div>



<script>

    var resizefunc = [];

</script>

<?php include("common/footer.php");?>


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
.on_kyc_margin_bottom_100{
    margin-bottom: 100px;
}
</style>


</body>

</html>

