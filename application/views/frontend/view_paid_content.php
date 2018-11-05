<?php
/**
 * Created by PhpStorm.
 * User: Mahev Stark
 * Date: 4/30/2018
 * Time: 5:00 PM
 */
?>

<?php require_once("common/header.php");?>
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12 m-b-30">

        <h4 class="page-title">View Paid Content</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <form method="POST" action="" accept-charset="UTF-8" id="form-profile">
            <input type="hidden" name="type" value="company">

            <div class="card-box widget-box-1">
                <h4 class="header-title m-t-0 m-b-30"><?php echo $paid_content->subject; ?></h4>
                <div class="row">

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

                    <p>
                        <?php echo $paid_content->content; ?>
                    </p>

                    <div class="col-md-3 m-t-20">
                        <?php
                        if($paid_content->file) {

                            if (in_array(explode('.', $paid_content->file)[count(explode('.', $paid_content->file)) - 1], array('pdf', 'PDF')))
                                $img_to_return = base_url() . 'resources/frontend/images/' . "pdf_small.png";
                            else if (in_array(explode('.', $paid_content->file)[count(explode('.', $paid_content->file)) - 1], array('doc', 'DOCX', 'docx', 'DOC', 'rtf', 'RTF')))
                                $img_to_return = base_url() . 'resources/frontend/images/' . "doc_small.png";
                            else
                                $img_to_return = base_url() . 'resources/uploads/marketing/' . $paid_content->file;


                        }

                        ?>
                        <a target="_blank" download href="<?php base_url() . 'resources/uploads/marketing/' . $paid_content->file;  ?>">
                            <img src="<?php echo $img_to_return; ?>" width="100%">
                        </a>


                    </div>

                    <div class="col-md-12 m-t-20">
                        <?php
                            echo str_replace(',', ', ',$paid_content->keywords);
                        ?>
                    </div>








                    </div>
            </div>

        </form>





    </div>
    <!-- end col -->

    <div class="col-md-4">

    </div>
    <!-- end col -->

</div>
<?php require_once("common/footer.php");?>
<script type="text/javascript" src="<?php echo base_url().'resources/frontend/js/jscolor.min.js' ?>"></script>

<?php if(isset($_GET['type'])){?>
    <script language="javascript">
        $("html, body").delay(400).animate({
            scrollTop: $('#passwordrequest').offset().top
        }, 2000);
    </script>
<?php } ?>
<script language="javascript">
    function confirmpassword_request(){
        if($("#newpass").val() != $("#confirmpass").val()){
            $("#upbtn").attr("disabled",true);
            $("#confirmerror").html('<div class="wrongerror">Password & New Password not matched!</div>');
        } else {
            $("#upbtn").attr("disabled",false);
            $("#confirmerror").html('');
        }
    }
</script>

<script>

    function cclick()
    {
        $("#inputfile").click();
    }
    $(function () {
        $('#inputfile').change(function () {

            $('.img').hide();


            $('.msg').text('Please Wait...');
            $('#submit_btn').prop('disabled', true);

            var myfile = $('#inputfile').val();
            var formData = new FormData();
            formData.append('inputfile', $('#inputfile')[0].files[0]);
            $('.msg').text('Uploading in progress...');
            $.ajax({
                url: '<?php echo base_url().'ico/take_image_logo'; ?>',
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',

                success: function (data) {

                    data = JSON.parse(data);

                    $('.msg').html(data.msg);


                    if(data.status==1){


                        $('.img').attr('src',data.src);
                        $('.img').show();
                        $('#submit_btn').prop('disabled', false);

                    }
                }
            });
        });
    });

    $("#remove-photo").click(function(){

        $.post('<?php echo base_url().'ico/remove_profile_pic'; ?>',{remove:true},function(){
            $('.img').attr('src','<?php echo base_url().'resources/uploads/profile/default.svg'; ?>');
            $('.img').show();
        });
    });
</script>
