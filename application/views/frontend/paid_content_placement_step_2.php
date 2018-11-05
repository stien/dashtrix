<?php
/**
 * Created by PhpStorm.
 * User: Mahev Stark
 * Date: 4/30/2018
 * Time: 3:41 PM
 */
?>
<?php require_once("common/header.php");?>
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12 m-b-30">
        <div class="button-list pull-right m-t-15">
            <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
        </div>
        <h4 class="page-title">Paid Content Placement</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6">




        <div class="col-md-8 col-md-offset-2">
            <div class="col-md-12 text-center">
                <img src="<?php echo base_url().'resources/frontend/images/content-promotions.png'; ?>">
            </div>

            <div class="col-md-12">
                <h4 class="clr293D68">Step 2 of 3: Select Publications</h4>
                <p>
                    Choose the publications you would like to place your content on. Accepted content types include press releases, expert/opinion articles on trending industry topics, videos or infographics.

                </p>
            </div>
        </div>


    </div>
    <!-- end col -->

    <div class="col-md-6">
        <form method="post" action="">

            <div class="card-box widget-box-1 easy m-b-0">


                <div class="form-group">
                    <label>Subject</label>
                    <input class="form-control" value="" name="subject" type="text" required>
                </div>

                <div class="form-group">
                    <label>Article Content</label>
                    <textarea rows="10" class="form-control" name="content" required></textarea>
                </div>

                <div class="form-group">
                    <label>Keyword Tags</label>
                    <input class="form-control" value="" name="keywords" type="text" required>
                </div>

                <div class="form-group">

                    <label>File <sup>*</sup> </label>

                    <input name="inputfile" type="file" accept="" class="form-control"  value="" id="inputfile">
                    <label class="msg"></label>
                    <img src="" class="uploading_image img" width="100px">

                </div>
            </div>

            <div class="next-walabtn">
                <button class="btn btn-default btn-sm" name="post">
                    Next
                </button>
            </div>
        </form>

    </div>
    <!-- end col -->

</div>
<?php require_once("common/footer.php");?>
<script>
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
                url: '<?php echo base_url().'ico/upload_paid_creation_file'; ?>',
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
</script>
