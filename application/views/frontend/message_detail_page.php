<?php 
ob_start();
error_reporting(0);
require_once("common/header.php");
?>

<div id="loginbx">
<div class="container">        
<div class="col-xs-12 bxlogin nopad">
<!--Sectors-->
<div class="col-xs-12 pright0">
		<?php if(isset($_SESSION['msglogin'])){?>
        	<div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
        <?php } ?>
  <div class="login-inner2 left wd100 jobpost" style="margin-right:0;">
    <h2>Message Detail</h2>
    <?php
		$condition2 = array('mID' => $this->uri->segment(2));
		$msgrow2 = $this->front_model->get_query_simple('*','dev_web_messages',$condition2);
		$c = $msgrow2->num_rows();
		if($c > 0){
		$messages2 = $msgrow2->result_object();
		
		if($messages2[0]->sID == UID){$uid= $messages2[0]->uID;}else {$uid= $messages2[0]->sID;}
	?>
    <div id="messageboxinbox">
    	
    </div>
    
    <div class="col-xs-12 nopad">
    	<div class="col-xs-11 nopad">
        <input type="hidden" value="<?php echo $uid;?>" id="sID" name="sID" />
        		<input type="text" value="" name="ibmessage" id="ibmessage" class="inputjob" placeholder="Write your message here...." />
        </div>
        <div class="col-xs-1 nopad">
        	<button name="postjob" class="btn pink" onclick="sendmessageData()" id="msgbtn" style="margin-top: 0; padding: 9px; width: 100%;" >Send</button>
        </div>
    </div>
    <?php } else { ?>
    	<div class="errormsg">No Record Found in database</div>
    <?php } ?>
  </div>
</div>
</div>
</div>
<?php require_once("common/footer.php");?>
<script language="javascript">
function sendmessageData(){
	if($("#ibmessage").val() == ""){
			$("#ibmessage").addClass('redborder');
			return false;
	}
	else {
		$("#msgbtn").html('Sending...');
		var autoURL = "<?php echo base_url(); ?>jobsite/sendmessage_inbox?rnd=" + Math.random() +"&message="+$("#ibmessage").val()+"&mid="+<?php echo $this->uri->segment(2);?>+"&sid="+$("#sID").val();
		$.ajax({
				url : autoURL,
				async: true,
				cache: false,
				method : "POST",
				success : function(response)
				{
					showmessagebox(<?php echo $this->uri->segment(2);?>);
					$("#ibmessage").val('');
					$("#msgbtn").html('Send');
					//$("#ibmessage").val(response);
				}
		});
	}
}
function showmessagebox(id)
{
	var autoURL = "<?php echo base_url(); ?>jobsite/message_get_data?rnd=" + Math.random() +"&mID="+id;
	$.ajax({
				url : autoURL,
				async: true,
				cache: false,
				method : "POST",
				success : function(response)
				{	
					$("#messageboxinbox").html(response);
					 var wtf    = $('#messageboxinbox');
					  var height = wtf[0].scrollHeight;
					  wtf.scrollTop(height);				
				}
	});
}
$(document).ready(function(e) {
    showmessagebox(<?php echo $this->uri->segment(2);?>);
	var wtf    = $('#messageboxinbox');
					  var height = wtf[0].scrollHeight;
					  wtf.scrollTop(height);
});
setInterval(function(){
     showmessagebox(<?php echo $this->uri->segment(2);?>);
}, 2000);
</script>