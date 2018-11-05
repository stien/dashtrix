<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php 

						$title = "ADD NEW QUESTION - ADMIN";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="<?php echo base_url();?>admin/questions" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Question <sup>*</sup> </label>

                                            <input name="q" type="text" class="form-control" value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['q'];}?>" required autofocus>

                                        </div>

                                    </div>

                                    

                                    

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Placeholder <i class="fa fa-info info-top" title="This text will be shown inside field until user starts entering answer"></i> </label>

                                            

                                            <input name="placeholder" type="text" class="form-control" value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['placeholder'];}?>"  >

                                        </div>

                                    </div> 
                                     <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Attachment 
                                                <small>To allow/force user to upload file/attachment</small>
                                            </label>

                                            

                                            <input <?php if($_SESSION['wrongsignup']['attachment']==1) echo "checked";  ?> type="checkbox" name="attachment" value="<?php if($_SESSION['wrongsignup']['attachment']==1) echo 1; else echo 0; ?>">

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Required </label>

                                            

                                            <input <?php if($_SESSION['wrongsignup']['required']==1) echo "checked";  ?> type="checkbox" name="required" value="<?php if($_SESSION['wrongsignup']['required']==1) echo 1; else echo 0; ?>">

                                        </div>

                                    </div>

                                  

                                    

                                 


                                 
                                    

                                    


                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                               Add New Question

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

