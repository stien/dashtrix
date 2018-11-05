<?php require_once("common/header.php");?>

<?php
	$arr2 = array('uUsername' => $this->uri->segment(2));
	$config2 = $this->front_model->get_query_simple('*','dev_web_user',$arr2);
	$user 	= $config2->result_object();
?>
<div id="jobsectors" class="rightop clear left wd100">
  <div class="container">
    <div class="col-xs-12 nopad">
      <div class="col-xs-12 pr0 nopad">
      	<div class="col-xs-12 nopad">
     	   <div class="media cv-inner left wd100">
        	
          <div class="media-body nopad coverletterbox col-xs-12">
			<div class="col-xs-2 nopad imgcompany">
            		
            	 <?php if($user[0]->uImage != ""){?>
                  <img src="<?php echo base_url(); ?>resources/uploads/profile/<?php echo $user[0]->uImage;?>">
                <?php } else { ?>
                    	<img src="<?php echo base_url(); ?>resources/frontend/images/no_photo.jpg" alt="No Pic"><br>
                <?php } ?> 
            </div>
            <div class="col-xs-8 pright0">
            	<p><strong><?php if($user[0]->uCompany != ""){echo $user[0]->uCompany;} else {echo $user[0]->uFname." ".$user[0]->uLname;}?></strong></p>
                <?php if($user[0]->uWebsite != ""){ ?>
                <p>Website: <?php echo $user[0]->uWebsite;?></p>
                <?php } ?>
                <?php if($user[0]->uPhone != ""){ ?>
                <p>Phone: <?php echo $user[0]->uPhone;?></p>
                <?php } ?>
                <?php if($user[0]->uNoEmp != ""){ ?>
                <p># of Employees: <?php echo $user[0]->uNoEmp;?></p>
                <?php } ?>
                <?php if($user[0]->uAddress != ""){ ?>
                <p>Address: <?php echo $user[0]->uAddress;?></p>
                <?php } ?>
				<?php if($user[0]->uCountry != ""){ ?>
                <p>Country: <?php echo $user[0]->uCountry;?></p>
                <?php } ?>
            </div>
            <?php if($user[0]->uAbout != ""){?>
            <div class="col-xs-12 nopad aboutcomp">
            	<h2>About Company:</h2>
                <?php echo $user[0]->uAbout;?>
            </div>
            <?php } ?>
          </div>
        </div>
        </div>
      </div>
      <div class="col-xs-7">
        
      </div>
      </div>
    </div>
  </div>
</div>
<?php require_once("common/footer.php");?>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/frontend/js/jquery-pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/frontend/js/jquery.imgareaselect.min.js"></script>
<?php
//Only display the javacript if an image has been uploaded
if(strlen($large_photo_exists)>0){
	$current_large_image_width = getWidth($large_image_location);
	$current_large_image_height = getHeight($large_image_location);?>
<script type="text/javascript">
function preview(img, selection) { 
	var scaleX = <?php echo $thumb_width;?> / selection.width; 
	var scaleY = <?php echo $thumb_height;?> / selection.height; 
	
	$('#thumbnail + div > img').css({ 
		width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px', 
		height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
} 

$(document).ready(function () { 
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("You must make a selection first");
			return false;
		}else{
			return true;
		}
	});
}); 

$(window).load(function () { 
	$('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview }); 
});

</script>
<?php }?>
<style>
.largethumb img{width:100%;}
.boxupload {   margin: 0px 0 0;
  border: 1px solid #ccc;
  padding: 14px;
  background-color: #fafafa;}
  .imgcompany { position:relative;}
  .imgcompany img { width:100%;}
  .editphoto {position: absolute;
  padding: 3px 8px;
  right: 0;
  background-color: #fff;
  font-size: 18px;}
  .aboutcomp {  margin-top: 11px;  text-align: justify;}
  .aboutcomp h2 { margin-bottom:5px;}
</style>
<script language="javascript">
function showuploadbox()
{
	$("#uploadbox").show();
}
</script>