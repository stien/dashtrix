<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php 

						$title = "EDIT USER VERIFICATION FOOTER TEXT";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">

                                   

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label>Text <sup>*</sup> <i class="fa fa-info info-tip" title="This will be shown at bottom of page where user submits the information"></i></label>

                                                <textarea name="footer_text_1" class="form-control" required ><?php  echo $text->footer_text_1; ?></textarea>

                                            </div>

                                        </div>
                                        <?php /* ?>
                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label>Text 2 <sup>*</sup> <i class="fa fa-info info-tip" title="This will be shown as congratulations text on final slide"></i></label>

                                                <textarea name="footer_text_2" class="form-control" required ><?php  echo $text->footer_text_2; ?></textarea>

                                            </div>

                                        </div>
                                        <?php */ ?>



                                       





                                    </div>

                                    

                                 


                                    

                                    

                                    


                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                               Save Changes

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

