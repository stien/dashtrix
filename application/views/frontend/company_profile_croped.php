<?php require_once("common/header.php");?>

<?php
	$arr2 = array('uID' => UID);
	$config2 = $this->front_model->get_query_simple('*','dev_web_user',$arr2);
	$user 	= $config2->result_object();
?>



<div id="jobsectors" class="rightop clear left wd100">
  <div class="container">
    <div class="col-xs-12 nopad">
    <form id="form1" runat="server">
    	<input type="file" id="FileUpload1" accept=".jpg,.png,.gif" />
        <img id="Image1" src="" alt="" style="display: none" />
    	<canvas id="canvas" height="5" width="5"></canvas>
        <input type="button" id="btnCrop" value="Crop" style="display: none" />
        <input type="submit" id="btnUpload" value="Upload" Style="display: none" />
        <input type="hidden" name="imgX1" id="imgX1" />
        <input type="hidden" name="imgY1" id="imgY1" />
        <input type="hidden" name="imgWidth" id="imgWidth" />
        <input type="hidden" name="imgHeight" id="imgHeight" />
        <input type="hidden" name="imgCropped" id="imgCropped" />
    </form>
      <div class="col-xs-5 pr0 nopad">
        <div class="media cv-inner left wd100">
        	<h1>Company Profile Information</h1>
          <div class="media-body nopad coverletterbox col-xs-12">
          	<div class="imagecompany">
            </div>
			<div class="">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="userinfo">
                  <tr>
                    <td width="25%" height="30">Phone #</td>
                    <td width="3%" align="left">:</td>
                    <td width="71%"><?php echo $user[0]->uPhone;?></td>
                  </tr>
                  <tr>
                    <td width="20%" height="30">No. Of Employees</td>
                    <td align="left">:</td>
                    <td><?php echo $user[0]->uNoEmp;?></td>
                  </tr>
                  <tr>
                    <td width="20%" height="30">Company Address</td>
                    <td align="left">:</td>
                    <td><?php echo $user[0]->uAddress;?></td>
                  </tr>
                  <tr>
                    <td height="30">Company Website</td>
                    <td align="left">:</td>
                    <td><?php echo $user[0]->uWebsite;?></td>
                  </tr>
                  <tr>
                    <td height="30">About Company</td>
                    <td align="left">:</td>
                    <td><?php echo $user[0]->uAbout;?></td>
                  </tr>
                  <tr>
                    <td height="30">Account Type</td>
                    <td align="left">:</td>
                    <td><?php if($user[0]->uActType == 1){echo 'Jobseeker';} else {echo "Recruiter";}?></td>
                  </tr>
              </table>
 
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-7">
        <div class="media cv-inner left wd100" style="min-height: 241px;">
        	<div class="media-body nopad coverletterbox col-xs-12">
          	<?php if(isset($_SESSION['msglogin'])){?>
            <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
            <?php } ?>
            <h1>Company Information</h1>
             <form name="category" id="category" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>jobsite/update_company">
            
            <div class="col-xs-12 nopad boxinput">
              <label> Phone Number: </label>
              <input type="text" value="<?php echo $user[0]->uPhone; ?>" required name="phone" id="phone" class="inputjob" />
            </div>
          
            <div class="col-xs-12 nopad boxinput">
              <label> No. Of Employees: </label>
              <input type="text" value="<?php echo $user[0]->uNoEmp; ?>" class="inputjob" required name="employesnum" id="employesnum" />
            </div>
            <div class="col-xs-12 nopad boxinput">
              <label> Company Address: </label>
              <input type="text" value="<?php echo $user[0]->uAddress; ?>" class="inputjob" required name="address" id="address" />
            </div>
            <div class="col-xs-12 nopad boxinput">
              <label> Company Website: </label>
              <input type="text" value="<?php echo $user[0]->uWebsite; ?>" class="inputjob" required name="website" id="website" />
              <div id="urlvalidate"></div>
            </div>
            <div class="col-xs-12 nopad boxinput">
              <label> Company Information: </label>
              <textarea name="companyinfo" class="textarea inputjob" id="companyinfo" required><?php echo $user[0]->uAbout; ?></textarea>
            </div>
          </div>
            
             <div class="col-xs-12 nopad boxinput">
              <button type="submit" name="signup" class="btn pink">Update Company Profile</button>           
            </div>
         </form>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>
<?php require_once("common/footer.php");?>
<script language="javascript">
$('#employesnum').keyup(function() {
  if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});
$('#phone').keyup(function() {
  if (this.value.match(/[^0-9]/g)) {
    this.value = this.value.replace(/[^0-9]/g, '');
  } 
});
$("#website").on("keyup",function(e){
	
	if(e.which === 32) {
			$("#urlvalidate").html('No space are allowed in URL');
			$("#urlvalidate").show();
            var str = $(this).val();
            str = str.replace(/\s/g,'');
            $(this).val(str);            
    }else {
		if($("#website").val() == ""){
		$("#urlvalidate").hide();
	}else {
	var regex = new RegExp("^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?"); 
var without_regex = new RegExp("^([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?");
var str = $("#website").val();
if(regex.test(str) || without_regex.test(str)){
    $("#urlvalidate").html('');
	$("#urlvalidate").hide();
}else{
	$("#urlvalidate").html('Please provide URL only e.g: (www.domain.com)');
	$("#urlvalidate").show();
}
	}
	}
});
</script>
<style>
#urlvalidate { display:none; color:#fff; padding:5px; background:#f00; margin:5px 0; text-align:center;}
</style>
<script type="text/javascript" src="http://cdn.rawgit.com/tapmodo/Jcrop/master/js/jquery.Jcrop.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#FileUpload1').change(function () {
                $('#Image1').hide();
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#Image1').show();
                    $('#Image1').attr("src", e.target.result);
                    $('#Image1').Jcrop({
                        onChange: SetCoordinates,
                        onSelect: SetCoordinates
                    });
                }
                reader.readAsDataURL($(this)[0].files[0]);
            });

            $('#btnCrop').click(function () {
                var x1 = $('#imgX1').val();
                var y1 = $('#imgY1').val();
                var width = $('#imgWidth').val();
                var height = $('#imgHeight').val();
                var canvas = $("#canvas")[0];
                var context = canvas.getContext('2d');
                var img = new Image();
                img.onload = function () {
                    canvas.height = height;
                    canvas.width = width;
                    context.drawImage(img, x1, y1, width, height, 0, 0, width, height);
                    $('#imgCropped').val(canvas.toDataURL());
					alert(canvas.toDataURL());
                    $('[id*=btnUpload]').show();
                };
                img.src = $('#Image1').attr("src");
            });
        });
        function SetCoordinates(c) {
            $('#imgX1').val(c.x);
            $('#imgY1').val(c.y);
            $('#imgWidth').val(c.w);
            $('#imgHeight').val(c.h);
            $('#btnCrop').show();
        };
    </script>