<?php require_once("common/header.php");?>
<div class="fullcontent right clear">
<form name="myForm" id="myForm" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/live_bulk_upload_submit">
<div class="dev-col-1 colbg left" style="position:relative;">
<div class="loader" id="loader-upload" style="display:none;">
	<img src="<?php echo base_url(); ?>resources/frontend/images/gears.gif"> <div id="uploaddb">Uploading File... Please wait</div>
</div>
<div class="ContentDiv">
<h1>Bulk Upload</h1>
<div class="formwrap">
<label> Upload CSV FILE: </label>
<input type="file" required name="file" id="file" />
</div>
<div id="progress" class="hide">
        <div id="bar"></div>
        <div id="percent">0%</div >
</div>
<br/>
 
<!-- Below code will show the upload status message -->
<div id="message"></div>
</div>
<?php /*?><div class="formwrap">
<input type="submit" value="Upload" name="submit" id="submit" class="btn btn-lg btn-green right" />
</div><?php */?>
</div>
</form>
<div class="dev-col-1 colbg left" style="position:relative;">
<div class="ContentDiv">
<h1>Uploaded Files</h1>
<?php
//$dir    = 'resources';
//$files1 = scandir($dir);
$files2 = glob("resources/*.csv");
//print_r($files2);
?>
<table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>Sr. #</th>
              <th>File Name</th>
              </tr>
          </thead>
          <tbody>
         
            <?php 
				$i=1;
				foreach($files2 as $key => $valuecat):
				//if($key != '0' && $key != '1'){ 
				$exp = explode("resources/",$valuecat);
				//print_r($exp);
			?>
             <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $exp[1]; ?></td>
              </tr>
            <?php
			$i++;
			//}
			endforeach;	
			
			?>
            
          </tbody>
        </table>
</div>
</div>


</div>


<?php require_once("common/footer.php");?>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script language="javascript">
$(document).ready(function()
{
	
	//Enable Upload button
	$('#file').change(function(){
		$('#submit').removeAttr('disabled');
		$("#loader-upload").show();
		$('#myForm').submit();
		//$("#myForm").ajaxForm(options);
	});
	//Show the progress bat after upload button hit
	$('#submit').change(function(){
		$('#progress').removeClass('hide');
	});
	//We can even provide options to ajaxForm to get callbacks like success,error, uploadProgress and beforeSend
    var options = {
	//beforeSend : this function called before form submission
    beforeSend: function()
    {
        $("#progress").show();
        $("#bar").width('0%');
        $("#message").html("");
        $("#percent").html("0%");
    },
	//uploadProgress : this function called when the upload is in progress
    uploadProgress: function(event, position, total, percentComplete)
    {
		$("#submit").val('Please wait...');
		$('#submit').prop('disabled', true);
        $("#bar").width(percentComplete/2+'%');
        $("#percent").html(percentComplete/2+'%');
    },
	//success : this function is called when the form upload is successful.
    success: function(responseval)
    {
			//$("#bar").width('80%');
			//$("#percent").html('80%');
			$("#uploaddb").html('Uploading Records in Database... <br>Please Wait');
    },
	//complete: this function is called when the form upload is completed.
    complete: function(response)
    {
			if(response.responseText == 1){
			$("#bar").width('100%');
			$("#percent").html('100%');
			$("#file").val("");
			$("#submit").val('Upload');
			$('#submit').prop('disabled', false);
			$("#loader-upload").hide();
			$("#message").html("<font color='green'>Records uploaded successfully in database.</font>");
		} 
		else if(response.responseText == 3){
			$("#progress").hide();
			$("#file").val("");
			$("#submit").val('Upload');
			$('#submit').prop('disabled', false);
			$("#loader-upload").hide();
			alert("File with same name already exist!");
		}
		else if(response.responseText == 7){
			$("#progress").hide();
			$("#file").val("");
			$("#submit").val('Upload');
			$('#submit').prop('disabled', false);
			$("#loader-upload").hide();
			alert("Invalid File Type or File too large");
		}
		else {
			$("#bar").width('100%');
			$("#percent").html('100%');
			$("#file").val("");
			$("#submit").val('Upload');
			$('#submit').prop('disabled', false);
			$("#loader-upload").hide();
			$("#message").html("<font color='green'>Records uploaded successfully in database.</font>");
        	//$("#message").html("<font color='green'>"+response.responseText+"</font>");
		}
    },
    error: function()
    {
        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
    }
};
     $("#myForm").ajaxForm(options);
});

</script>
<style>
div.custom_file_upload {
	width: 230px;
	height: 20px;
	margin: 40px auto;
}
#message {font-size: 14px;
  float: left;
  margin-top: 21px;
  margin-left: 8px;}
div.submit {
	width: 80px;
	height: 24px;
	background: #7abcff;
	background: -moz-linear-gradient(top,  #7abcff 0%, #60abf8 44%, #4096ee 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#7abcff), color-stop(44%,#60abf8), color-stop(100%,#4096ee));
	background: -webkit-linear-gradient(top,  #7abcff 0%,#60abf8 44%,#4096ee 100%);
	background: -o-linear-gradient(top,  #7abcff 0%,#60abf8 44%,#4096ee 100%);
	background: -ms-linear-gradient(top,  #7abcff 0%,#60abf8 44%,#4096ee 100%);
	background: linear-gradient(top,  #7abcff 0%,#60abf8 44%,#4096ee 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7abcff', endColorstr='#4096ee',GradientType=0 );

	display: inline;
	position: absolute;
	overflow: hidden;
	cursor: pointer;
	
	-webkit-border-top-right-radius: 5px;
	-webkit-border-bottom-right-radius: 5px;
	-moz-border-radius-topright: 5px;
	-moz-border-radius-bottomright: 5px;
	border-top-right-radius: 5px;
	border-bottom-right-radius: 5px;
	
	font-weight: bold;
	color: #FFF;
	text-align: center;
	padding-top: 8px;
}
div.submit:before {
	content: 'UPLOAD';
	position: absolute;
	left: 0; right: 0;
	text-align: center;
	
	cursor: pointer;
}

div.submit input {
	position: relative;
	height: 30px;
	width: 250px;
	display: inline;
	cursor: pointer;
	opacity: 0;
}

#progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
#percent { position:absolute; display:inline-block; top:3px; left:48%; }
.hide{display:none;}
#loader-upload {  background-color: rgba(0,0,0,.5);
  position: absolute;
  padding: 90px;
  display: none;
  width: 100%;
  box-sizing: border-box;
  height: 100%;
  text-align: center;
  color: #fff;
  font-size: 14px;
  text-transform: uppercase;
  font-weight: bold; }
</style>

<script language="javascript">
<?php /*?>window.btn_clicked = false;
window.onbeforeunload = function(){
if(window.btn_clicked ==  false){ 
		//return 'Processing will stop, Are you sure you want to leave page.';
}
};<?php */?>
</script>