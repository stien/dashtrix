<?php include("common/header.php");?>

<div class="wrapper-page widht-800" style=" margin-bottom: 100px;">

   

<form method="POST" action="" accept-charset="UTF-8" id="personal-info">

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



                                <div class="col-md-12">
                                    <h2 style="font-style: italic; text-align: center;">
                                        Better Luck Next Time!
                                    </h2>
                                </div>

                                
                                   
                                   
                                </div>
                            </div>
                        </div>
                    </div>
     


                <div class="col-md-12 nopad m-t-40">

                    <div class="form-group">
                        <input type="hidden" name="step_1_agree" value="1">
                        <a href="<?php echo base_url().'dashboard'; ?>">
                            <button id="i_agree" class="btn btn-default pull-right " type="button" name="submit" value="1">
                               Go To Dashboard
                            </button>
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

