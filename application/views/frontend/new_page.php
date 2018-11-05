<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">


                   <?php 

						$title = "ADD NEW PAGE - ADMIN";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Would you like to link it to an existing page or add text manually?</label>
                                            <select class="form-control" name="type" onchange="change_type(this.value)">
                                                <option <?php if($edit) if($page->type==0) echo "selected"; ?> value="0">Maunally</option>
                                                <option <?php if($edit) if($page->type==1) echo "selected"; ?> value="1">Link</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                 <div class="row" id="link_div" style="display: <?php if($page->type==0) echo "none"; else ""; ?>;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Link <sup>*</sup> <small>Please add complete link to an existing page</small> </label>
                                            <input class="form-control" name="pElink" type="url" class="form-control" value="<?php if($edit) echo $page->pElink; else echo set_value('pElink'); ?>"  >
                                        </div>
                                    </div>
                                </div>
                                                    

                                <div class="row" id="manually_div" style="display: <?php if($page->type==1) echo "none"; else ""; ?>;">


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Page Name </label>

                                            <input name="pName" type="text" class="form-control" value="<?php if($edit) echo $page->pName; else echo set_value('pName'); ?>" required autofocus>

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Page Heading <sup>*</sup></label>

                                            <input name="pHeading" type="text" class="form-control" value="<?php if($edit) echo $page->pHeading; else echo set_value('pHeading'); ?>" required autofocus>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Page Title <sup>*</sup></label>

                                            <input name="pTitle" type="text" class="form-control" value="<?php if($edit) echo $page->pTitle; else echo set_value('pTitle'); ?>" required >

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Page Description <sup>*</sup></label>

                                            <input name="pDescp" type="text" class="form-control" value="<?php if($edit) echo $page->pDescp; else echo set_value('pDescp'); ?>" required >

                                        </div>

                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Page Keywords <sup>*</sup></label>

                                            <input name="pKeyword" type="text" class="form-control" value="<?php if($edit) echo $page->pKeyword; else echo set_value('pKeyword'); ?>" required >

                                        </div>

                                    </div>
                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Page Content <sup>*</sup></label>

                                            <textarea name="pContent" type="text" class="form-control"  rows="10" 
                                                ><?php if($edit) echo $page->pContent; else echo set_value('pContent'); ?></textarea>

                                        </div>

                                    </div>

                                   
                                    

                                   

                                </div>

                                <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                               <?php echo $edit?"Submit":"Submit"; ?>

                                            </button>

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
    height : "250",
    setup: function (editor) {
        editor.on('change', function (e) {
            editor.save();
        });
    }
});
function change_type(v)
{
    if(v==0)
    {
        $("#link_div input").prop('required',false);
        $("#link_div").hide();
        $("#manually_div input").prop('required',true);

        $("#manually_div").show();
    }
    else
    {
        $("#manually_div input").prop('required',false);
        $("#manually_div").hide();
        $("#link_div input").prop('required',true);

        $("#link_div").show();
    }
}
</script>




</body>

</html>

