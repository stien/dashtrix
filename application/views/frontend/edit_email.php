<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php 

						$title = "EDIT EMAIL - ADMIN";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">


                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Name <sup>*</sup> </label>

                                            <input name="eName" type="text" class="form-control" value="<?php  echo $email->eName; ?>" required autofocus>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Subject <sup>*</sup> </label>

                                            <input name="eSubject" type="text" class="form-control" value="<?php  echo $email->eSubject; ?>" required >

                                        </div>

                                    </div>
                                     <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Email <sup>*</sup> </label>

                                            <input name="eEmail" type="email" class="form-control" value="<?php  echo $email->eEmail; ?>" required>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <?php

                                            $varsss_ = get_square_vars(strip_tags($email->eContent));
                                             if($varsss_){ ?>
<div style="text-align: center; background: orange; color:#fff; padding: 10px;">
   Please DO NOT edit these variables: <b><?php echo $varsss_; ?></b>
</div>
<?php } ?>
                                            <label>Content <sup>*</sup> </label>

                                            <textarea name="eContent" rows="5" class="form-control"><?php echo $email->eContent; ?></textarea>

                                        </div>

                                    </div>

                                    


                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                               Update Email

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

<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=2cr6zzcaf0uyf6ni2f5lza6wb3mjedm5vh15vy89hjx48qnu"></script>
<script>

    // tinymce.init({ selector:'textarea',  });


tinymce.init({ 
    selector: 'textarea',
    height : "400",
    setup: function (editor) {
        editor.on('change', function (e) {
            editor.save();
        });
    }
});

</script>

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

