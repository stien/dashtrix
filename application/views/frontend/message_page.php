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
    <h2>Messages</h2>
    <table width="100%" id="postedjobs" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>User Name</th>
              <th>Message</th>
              <th>Posted Date</th>
              <th>View Message</th>
            </tr>
          </thead>
          <tbody>
          <?php
			if(ACTYPE == 1){
				$condition = array('uID' => UID, 'mdID' => 0);
			} else {
	        	$condition = array('sID' => UID, 'mdID' => 0);
		  	}
			$usinfo =  $this->front_model->get_query_simple('*','dev_web_messages',$condition);
			$jobs_list = $usinfo->result_object();
			foreach($jobs_list as $key => $valuecat):
				if(ACTYPE == 2){
					$c2 = array('uID' => $valuecat->uID);
				}
				else {
					$c2 = array('uID' => $valuecat->sID);
				}
				$us =  $this->front_model->get_query_simple('*','dev_web_user',$c2);
				$user = $us->result_object();				
			?>
            <tr>
              <td onclick="viewmessage(<?php echo $valuecat->mID; ?>)"><?php echo $user[0]->uFname; ?> <?php echo $user[0]->uLname; ?></td>
              <td  onclick="viewmessage(<?php echo $valuecat->mID; ?>)"><?php echo $valuecat->sMessage; ?></td>
              <td  onclick="viewmessage(<?php echo $valuecat->mID; ?>)"><?php echo date("F, d Y h:i:s A",strtotime($valuecat->mPosted)); ?></td>
              <td align="center"  onclick="viewmessage(<?php echo $valuecat->mID; ?>)">
              <a href="<?php echo base_url(); ?>view-message/<?php echo $valuecat->mID; ?>"><i class="fa fa-comments-o left coloredit" style="font-size:18px;"></i></a></td>
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
function viewmessage(id){
	window.location='<?php echo base_url(); ?>view-message/'+id;
}
</script>

<style>
th { font-size:12px;}
</style>