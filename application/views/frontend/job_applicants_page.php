<?php 
ob_start();
//error_reporting(0);
require_once("common/header.php");
?>
<div id="loginbx">
<div class="container">        
<div class="col-xs-12 bxlogin nopad">
<!--Sectors-->
<div class="col-xs-12 pright0">
		<?php if(isset($_SESSION['msglogin'])){?>
        	<div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
        <?php }
		// JOB DETAILS
				$condition4 = array('jID' => $this->uri->segment(2));
				$ind4 = $this->front_model->get_query_simple('*','dev_web_jobs',$condition4);
				$jobs = $ind4->result_object();
		 ?>
  <div class="login-inner2 left wd100 jobpost minheightjob" style="margin-right:0;">
    <h2>Job Applicants - ::- <?php echo $jobs[0]->jTitle;?>
    	<span style="float:right; font-size:12px; text-transform:capitalize;">
        	<span style="padding: 6px;
  margin-bottom: 5px; float:left;">Filter By:&nbsp;&nbsp;</span> <select name="applicantsearch" id="applicantsearch" class="right" onchange="redirectpage(this.value)" style="padding: 6px;
  margin-bottom: 5px;">
        	<option value="0">All Applicants</option>
            <option value="1" <?php if(isset($_GET['type']) && $_GET['type'] == 1){echo "SELECTED";}?>>Shortlisted</option>
            <option value="2" <?php if(isset($_GET['type']) && $_GET['type'] == 2){echo "SELECTED";}?>>Rejected</option>
        </select>
        </span>
    </h2>
    <table width="100%" id="postedjobs" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>Job Title</th>
              <th>URL</th>
              <th>User Name</th>
              <th>Applied Date</th>
              <th>Status</th>
              <th>Message to Jobseeker</th>
            </tr>
          </thead>
          <tbody>
          <?php
	        if(isset($_GET['type'])){
				
				$condition = array('jID' => $this->uri->segment(2),'aStatus' => $_GET['type']);
			} else {
				$condition = array('jID' => $this->uri->segment(2));
			}
			$usinfo =  $this->front_model->get_query_simple('*','dev_web_applied',$condition);
			$jobs_list = $usinfo->result_object();
			foreach($jobs_list as $key => $valuecat):
				
				$c2 = array('uID' => $valuecat->uID);
				$us =  $this->front_model->get_query_simple('*','dev_web_user',$c2);
				$user = $us->result_object();
				
				$condition2 = array('cvID' => $valuecat->cvID);
				$cv = $this->front_model->get_query_simple('*','dev_web_cv',$condition2);
				$cvd = $cv->result_object();
				// JOB DETAILS
				$condition4 = array('jID' => $valuecat->jID);
				$ind4 = $this->front_model->get_query_simple('*','dev_web_jobs',$condition4);
				$jobs = $ind4->result_object();
			?>
            <tr>
              <td onclick="showmessagebox(<?php echo $user[0]->uID; ?>)"><?php echo $jobs[0]->jTitle; ?></td>
              <td><a href="<?php echo base_url(); ?>resources/uploads/resume/<?php echo $cvd[0]->cvFile;?>">View Cv</a></td>
              <td onclick="showmessagebox(<?php echo $user[0]->uID; ?>)"><?php echo $user[0]->uFname; ?> <?php echo $user[0]->uLname; ?></td>
              <td onclick="showmessagebox(<?php echo $user[0]->uID; ?>)"><?php echo date("F, d Y h:i:m A",strtotime($valuecat->appliedDate)); ?></td>
              <td><select name="appliedval" id="appliedval" onchange="appliedstatus(<?php echo $valuecat->aID;?>,this.value)">
                	<option value="">--- Status ---</option>
                    <option value="1" <?php if($valuecat->aStatus == 1){echo "SELECTED";}?>>Shortlist</option>
                    <option value="2" <?php if($valuecat->aStatus == 2){echo "SELECTED";}?>>Reject</option>
                </select></td>
              <td>
			  	<a href="javascript:;" onclick="showmessagebox(<?php echo $user[0]->uID; ?>)">
                	<button name="postjob" class="btn pink" >Message</button>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
  </div>
</div>
</div>
</div>

<div class="container-popup" id="boxmesage">
    <div class="rightpop">
    
    	<div id="messpopup">
        	
        </div>
    </div>
</div>

<?php require_once("common/footer.php");?>
<link href="<?php echo base_url(); ?>resources/backend/css/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css">
<script language="javascript" src="<?php echo base_url(); ?>resources/backend/js/datatable/jquery.dataTables.js" runat="server"></script>
<script language="javascript">
$(document).ready(function () {
	$('#postedjobs').dataTable();
});
function appliedstatus(id,val)
{
	document.location = "<?php echo base_url(); ?>jobsite/change_status/"+id+"/"+val;
}
function showmessagebox(uid)
{
	$("#boxmesage").show();
	$("#messpopup").html('Loading....');
	var autoURL = "<?php echo base_url(); ?>jobsite/getmessage_box?rnd=" + Math.random() +"&val="+uid;
	$.ajax({
				url : autoURL,
				async: true,
				cache: false,
				method : "POST",
				success : function(response)
				{
						
					$("#messpopup").html(response);				
				}
			});
}
function submitmessage()
{
	if($("#messagesender").val() == ""){
			$("#messagesender").addClass('redborder');
	}
	else {
		var autoURL = "<?php echo base_url(); ?>jobsite/sendmessage_sender?rnd=" + Math.random() +"&message="+$("#messagesender").val()+"&sid="+$("#senderid").val();
		$.ajax({
				url : autoURL,
				async: true,
				cache: false,
				method : "POST",
				success : function(response)
				{
					$("#messpopup").html(response);				
					setTimeout(function() {
						$('#boxmesage').fadeOut('fast');
					}, 1000);
				}
		});
	}
}
function closemsgbox(){
	$("#boxmesage").hide();
}
function redirectpage(id)
{
		if(id == 0){
			window.location = '<?php echo base_url(); ?>job-applicants/<?php echo $this->uri->segment(2);?>';
		}
		else {
			window.location = '<?php echo base_url(); ?>job-applicants/<?php echo $this->uri->segment(2);?>?type='+id;
		}
}
</script>

<style>
th { font-size:12px;}
</style>