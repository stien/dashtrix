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
        <?php } ?>
  <div class="login-inner2 left wd100 jobpost minheightjob" style="margin-right:0;">
    <h2>Jobs Posted</h2>
    <table width="100%" id="postedjobs" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>Job Title</th>
              <th>Company</th>
              <th>Posted Date</th>
              <th>City</th>
              <th>Country</th>
              <th>Status</th>
              <?php if(ACTYPE != 0){?>
              <th>Responses</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
          <?php
	        if(ACTYPE == 0){
				$condition = array('agtID' => UID);
			}else {
				$condition = array('uID' => UID);
			}
			$usinfo =  $this->front_model->get_query_simple('*','dev_web_jobs',$condition);
			$jobs_list = $usinfo->result_object();
			foreach($jobs_list as $key => $valuecat):
				$c2 = array('uID' => $valuecat->uID);
				$us =  $this->front_model->get_query_simple('*','dev_web_user',$c2);
				$user = $us->result_object();
				$condition2 = array('cID' => $valuecat->cID);
				$ind = $this->front_model->get_query_simple('*','dev_web_categories',$condition2);
				$industry = $ind->result_object();
				
				// POSTED COUNT
   			    $condition = array('jID' => $valuecat->jID);
				$usinfo =  $this->front_model->get_query_simple('*','dev_web_applied',$condition);
				$appcount = $usinfo->num_rows();
			?>
            
            <tr onmouseover="show_hidedata(<?php echo $valuecat->jID; ?>)">
              <td>
			  	<a href="<?php echo base_url(); ?>job/<?php echo $valuecat->jURL; ?>" title="<?php echo $valuecat->jTitle; ?>"><?php echo $valuecat->jTitle; ?></a>
                
                <div id="jobactions_<?php echo $valuecat->jID; ?>" class="jactionshow" style="display:none">
                	<?php if($valuecat->expired == 1){ ?>
                    	<a href="javascript:;" class="jobactns" style="color:#f00;">Job Expired</a>
                    <?php } else { ?>
                    
                    	
                        <?php if(ACTYPE != 0){?>
                        <a href="<?php echo base_url(); ?>post-job?type=edit&jid=<?php echo $valuecat->jID; ?>" class="jobactns">Edit</a>
                        <a href="<?php echo base_url(); ?>job/<?php echo $valuecat->jURL; ?>?link=broadcast" class="jobactns">Broadcast</a>
                        <a href="<?php echo base_url(); ?>job/<?php echo $valuecat->jURL; ?>?link=sendasemail" class="jobactns">Send job as email</a>
                   		<?php } else { ?>
                        <a href="<?php echo base_url(); ?>?type=edit&jid=<?php echo $valuecat->jID; ?>" class="jobactns">Edit</a>
                        <?php } ?>
                    <?php } ?>
                    
                    <a href="javascript:;" onClick="deleteuser(<?php echo $valuecat->jID; ?>)" class="jobactns">Remove</a>
                </div>
                
              </td>
              <td onclick="showapplicants(<?php echo $valuecat->jID; ?>)"><?php echo $user[0]->uCompany; ?></td>
              <td onclick="showapplicants(<?php echo $valuecat->jID; ?>)"><?php echo date("F, d Y",strtotime($valuecat->jPostedDate)); ?></td>
              <td onclick="showapplicants(<?php echo $valuecat->jID; ?>)"><?php echo str_replace(",",", ",$valuecat->jStateCity); ?></td>
              <td onclick="showapplicants(<?php echo $valuecat->jID; ?>)"><?php echo $valuecat->jCoutry; ?></td>
              <td onclick="showapplicants(<?php echo $valuecat->jID; ?>)"><?php if($valuecat->jDraft == '1')
			  {
				  echo "<strong style='color:#f00;'>Drafted</strong> / <a href='".base_url()."jobsite/post_draft_job_active/".$valuecat->jID."' style='color:#09f'><strong>Submit Job as Live</strong> </a> / <a href='".base_url()."jobsite/cancel_draft_job/".$valuecat->jID."' style='color:#f00'>Cancel Draft</a>";
			  } else {if($valuecat->jJobStatus == '1'){echo 'Active';} else {echo 'In-Active';}} ?></td>
              <?php if(ACTYPE != 0){?>
              <td align="center" <?php if($valuecat->expired == 1){} else { ?>onclick="showapplicants(<?php echo $valuecat->jID; ?>)"<?php } ?>>
              <?php if($valuecat->expired == 1){} else { ?>
              <a href="<?php echo base_url(); ?>job-applicants/<?php echo $valuecat->jID; ?>"><i class="fa fa-th-large left coloredit"></i> <?php } ?> (<?php echo $appcount;?>)</a>
             
              </td>
              <?php } ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
  </div>
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
function deleteuser(id)
{
	var x = confirm("Are you sure? Once the job is deleted.. it can not be recovered.");
	if (x){
		window.location='<?php echo base_url(); ?>jobsite/delete_user_job/'+id;
		return true;
	}
	else {
		return false;
	}}
function showapplicants(id){
	window.location='<?php echo base_url(); ?>job-applicants/'+id;
}
function edituser(id){
	window.location='<?php echo base_url(); ?>post-job?type=edit&jid='+id;
}
function show_hidedata(id)
{
	$(".jactionshow").hide();
	$("#jobactions_"+id).show();
}
</script>

<style>
th { font-size:12px;}
.jobactns {color: #3973CA;
  padding-right: 27px;
  margin-top: 7px;
  display: block;
  float: left;}
</style>