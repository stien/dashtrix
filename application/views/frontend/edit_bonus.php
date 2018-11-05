<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">
                     

                   <?php 

						$title = "Edit BONUS - ADMIN";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

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

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>On Sale more than <sup>*</sup></label>

                                            <input name="more_than" value="<?php echo $bonus->more_than; ?>" type="number" step="1" class="form-control"  required autofocus>

                                        </div>

                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>On Sale less than <sup>*</sup></label>

                                            <input name="less_than" value="<?php echo $bonus->less_than; ?>" type="number" step="1" class="form-control"  required >

                                        </div>

                                    </div>
                                   

                                   <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Bonus(%) <sup>*</sup></label>

                                            <input name="bonus" value="<?php echo $bonus->bonus; ?>" type="number" step="0.5" class="form-control"  required >

                                        </div>

                                    </div>

                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                               Update Bonus

                                            </button>

                                        </div>

                                    </div>

                                   

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>



        </div>

    </div>

</div>



<script>

    var resizefunc = [];

</script>

<?php include("common/footer.php");?>



</body>

</html>

