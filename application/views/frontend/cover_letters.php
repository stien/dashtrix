<?php require_once("common/header.php");?>
<div id="jobsectors" class="rightop clear left wd100">
  <div class="container">
    <div class="col-xs-12 nopad">
      <div class="col-xs-5 nopad">
        <div class="media login-inner nopad left wd100">
        	<h2>Add new Cover Letter</h2>
          <div class="media-body nopad coverletterbox col-xs-12">
          	<p style="margin-top:0;">Please use this form to create your covering letter</p>
          	<?php if(isset($_SESSION['msglogin'])){?>
            <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
            <?php } ?>
            <?php
				if($this->uri->segment(2) == "edit"){
					$arr2 = array('cvID' => $this->uri->segment(3));
					$config2	 = $this->front_model->get_query_simple('*','dev_wev_coverletters',$arr2);
					$edit 	= $config2->result_object();
					$cvID 	= $edit[0]->cvID;
					$title 	= $edit[0]->cvTitle;
					$letter 	= $edit[0]->cvText;
					$url = 'do/editcover';
				}
				else {
					$title 	= "";
					$letter 	= "";
					$url = 'do/cover';
				}
			?>
            <form name="loginform" id="loginform" action="<?php echo base_url(); ?><?php echo $url;?>" method="post" onSubmit="return buttondisabled()">
            <div class="col-xs-12 nopad boxinput">
              <input type="text" name="coverTitle" id="coverTitle" required class="inputjob" value="<?php echo $title;?>" placeholder="Cover Letter Title">
              <?php
			  if($this->uri->segment(2) == "edit"){
				  echo '<input type="hidden" name="cvID" id="cvID" class="inputjob" value="'.$cvID.'">';
			  }
			  ?>
            </div>
            <div class="col-xs-12 nopad boxinput">
            	<textarea name="coverlettertext" id="coverlettertext" class="inputjob textarea" placeholder="Cover Letter" required><?php echo strip_tags(htmlspecialchars_decode($letter));?></textarea>
                <div class="countword">
                <small class="left">
                    	700 words allowed only!
                    </small>
                	<small class="right">
                    	Words: <div id="wordcount" class="right" style="  font-size: 11px;
  margin-top: 1px;
  margin-left: 5px;">0</div>
                    </small>
                </div>
            </div>
             <div class="col-xs-12 nopad boxinput">
              <button type="submit" name="signup" id="signypbutton" class="btn pink">Submit</button>           
            </div>
         </form>
          </div>
        </div>
      </div>
      <div class="col-xs-7">
        <div class="media login-inner left wd100" style="min-height: 298px;">
        	<h2>Covering Letters</h2>
          <div class="media-body left col-xs-12 nopad coverletterbox">
          	<p style="margin-top:0;">Use a covering letter to tell the recruiter why you're suitable for the role. You have the following covering letters saved:</p>
            <?php
			$arr = array('uID' => UID);
			$config	 = $this->front_model->get_query_simple('*','dev_wev_coverletters',$arr);
			$coovers 	= $config->result_object();
			if(count($coovers) == 0){
				echo '<div class="errormsg">No Cover Letter found!</div>';
			}else {
			foreach($coovers as $cover):
			?>
          	<div class="coverbx nopad left col-xs-12" onClick="showrelevantcover(<?php echo $cover->cvID;?>)">
            	<div class="col-xs-10">
                	<?php echo $cover->cvTitle;?>
                </div>
            	<div class="col-xs-2 right">
                	<a href="javascript:;" onClick="deletecover(<?php echo $cover->cvID;?>)"><i class="fa iconcover fa-trash-o"></i></a>
                    <a href="<?php echo base_url(); ?>cover-letters/edit/<?php echo $cover->cvID;?>"><i class="fa iconcover fa-pencil-square"></i></a>
                </div>
                <div id="cover_bx_<?php echo $cover->cvID;?>" class="bx_cov">
                	<?php echo $cover->cvText;?>
                </div>
            </div>
            <?php
			endforeach;
			}
			?>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>
<?php require_once("common/footer.php");?>
<script language="javascript">

$(document).ready(function() {
  $("#coverlettertext").on('keyup', function() {
    var words = this.value.match(/\S+/g).length;
	$("#wordcount").html(words);
    if (words > 700) {
      var trimmed = $(this).val().split(/\s+/, 700).join(" ");
      $(this).val(trimmed + " ");
    }
  });
}); 
function showrelevantcover(id){
	$("#bx_cov").hide();
	$("#cover_bx_"+id).show();
}
function deletecover(id)
{
	var x = confirm("Are you sure? You want to remove cover letter?");
	if (x){
		window.location='<?php echo base_url(); ?>cover/remove/'+id;
		return true;
	}
	else {
		return false;
	}}
	function buttondisabled(){
	$("#signypbutton").attr("diabled",true);
	$("#signypbutton").html('Please wait...');
	
}
</script>