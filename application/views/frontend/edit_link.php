<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php 

						$title = "EDIT LINK - ADMIN";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">


                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Text <sup>*</sup> </label>

                                            <input name="text" type="text" class="form-control" value="<?php  echo $link->text; ?>" required autofocus>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Link <sup>*</sup> </label>

                                            <input name="link" type="text" class="form-control" value="<?php  echo $link->link; ?>" required autofocus>

                                        </div>

                                    </div>

                                    

                                    

                                   

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Open In New Tab </label>

                                            

                                            <input <?php if($link->new_tab==1) echo "checked";  ?>  value="1" type="checkbox" name="new_tab" value="<?php if($link->new_tab==1) echo 1; else echo 0; ?>">

                                        </div>

                                    </div>

                                    

                                 


                                 
                                    

                                    


                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                               Update Link

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



<script>

    $(document).ready(function() {



        $('#birth_date').datepicker({

            format: 'yyyy-mm-dd',

            endDate: '-0d'

        });

    });

</script>





</body>

</html>

