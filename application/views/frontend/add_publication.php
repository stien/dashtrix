<?php
/**
 * Created by PhpStorm.
 * User: Mahev Stark
 * Date: 4/25/2018
 * Time: 1:32 PM
 */
?>

<?php require_once("common/header.php");?>
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12 m-b-30">
        <div class="button-list pull-right m-t-15">
            <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
        </div>
        <h4 class="page-title">Add New Publication</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <form method="POST" action="" accept-charset="UTF-8" id="form-profile">
            <input type="hidden" name="type" value="company">

            <div class="card-box widget-box-1">
                <h4 class="header-title m-t-0 m-b-30">Add New Publication</h4>
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





                        <div class="form-group">
                            <label>Link</label>
                            <input type="url" name="link" value="" class="form-control" required=""> 
                        </div>
                        <div class="form-group">
                            <label>Price (USD)</label>
                            <input type="number" name="price" step="1"  value="" class="form-control" required="">
                        </div>



                                        <div class="form-group">

                                            <label>Logo <sup>*</sup>  </label>

                                            <input name="inputfile" required="" type="file" accept="image/*" class="form-control"  value="" id="inputfile">
                                            <label class="msg"></label>


                                            <img src="" class="uploading_image display_none">

                                        </div>

                             
                        

                        
                  

                 





                </div>
            </div>
            <div class="row" id="">
                <div class="col-sm-12 m-b-30">
                    <div class="button-list pull-right m-t-15">
                        <button class="btn btn-default submit-form" type="submit" ><span class="m-r-5"><i class="fa fa-check"></i></span>Submit</button>
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
    url: '<?php echo base_url().'ico/take_publication_image'; ?>',
    data: formData,
    processData: false,
    contentType: false,
    type: 'POST',
  
    success: function (data) {

      data = JSON.parse(data);
       
      $('.msg').html(data.msg);


      if(data.status==1){
          $('.uploading_image').attr('src',data.src);
          $('.uploading_image').show();
         $('#submit_btn').prop('disabled', false);

        }
    }
  });
});
});

function removeMe(that)
{
    //$(that).parent().remove();
}
</script>



