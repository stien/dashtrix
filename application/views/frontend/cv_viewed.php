<?php require_once("common/header.php");?>

<div id="jobsectors" class="rightop clear left wd100">
  <div class="container">
    <div class="col-xs-12 nopad">
    
      <div class="login-inner left mabottom5">
            <h2 class="mabottom0">CV Viewed</h2>
      </div>
         
      <table width="100%" id="postedjobs" class="hover" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th>CV Title</th>
            <th>User Name</th>
            <th>Viewed</th>
            </tr>
        </thead>
        <tbody>
          <?php 
            $cvviewed = $this->front_model->getcvViewedcount(UID);
            //$cvcout = $configco->num_rows();
            foreach($cvviewed as $job):
            $arr2 = array('cvID' => $job->cvID);
            $configco = $this->front_model->get_query_simple('*','dev_web_cv',$arr2);
            $cvcout = $configco->result_object();
			// GET COMPANY INFO
            $arr5 = array('uID' => $cvcout[0]->uID);
            $configco5 = $this->front_model->get_query_simple('*','dev_web_user',$arr5);
            $user = $configco5->result_object();
            //echo $this->db->last_query();
          ?>
          <tr>
              <td><?php echo $cvcout[0]->cvTitle; ?></td>
              <td><?php echo $user[0]->uUsername; ?></td>
              <td><?php echo "<span style='color:#f00; margin-left:10px;font-weight:bold;'>(".$job->cvcount.") Times</span>";?></td>
            </tr>
          <?php
          endforeach;  ?>
        </tbody>
      </table>
          
      </div>
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
</script>