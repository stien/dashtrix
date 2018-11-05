<?php require_once("common/header.php");?>
<?php

  $ref__ = $this->db->get('dev_web_ref_setting')->result_object()[0];
  
 ?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
               <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
            </div>
            <h4 class="page-title"><?php echo $ref__->tokenTitle; ?></h4>
        </div>
    </div>
    <?php if($ref__){ ?>
    <div class="row">
        

        <div class="col-md-8">
            
            <div class="card-box widget-box-1">
             <?php echo $ref__->tokenText; ?>
            </div>
        </div>
    </div>
  <?php } ?>


    <div class="row">
        

        <div class="col-md-8">
            
            <div class="card-box widget-box-1">


                    <h4 class="header-title m-t-0 m-b-30">Referral URL</h4>
                    <div class="row">


                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Referral URL</label>
                                <input id="copyme" type="text" value="<?php echo base_url().'signup?ref='.$users['uCode'];?>" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 right">
                            <button class="btn btn-default m-t-20 right" type="button" onclick="copyMe('copyme',this)"><span class="m-r-5"><i class="fa fa-copy"></i></span>Copy</button>
                        </div>
                    </div>


            </div>
        </div>
        <!-- end col -->

    </div>
<?php require_once("common/footer.php");?>

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

    function copyMe(id,that)
    {
        var copyText = document.getElementById(id);
        copyText.select();
        document.execCommand("Copy");

        $(that).html('<i class="fa fa-check"></i></span>Copied')
    }

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
    url: '<?php echo base_url().'ico/take_image_profile'; ?>',
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
