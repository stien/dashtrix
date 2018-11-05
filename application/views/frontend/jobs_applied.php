<?php require_once("common/header.php");?>

<?php
	$arr2 = array('uID' => UID);
	$config2 = $this->front_model->get_query_simple('*','dev_web_user',$arr2);
	$user 	= $config2->result_object();
?>
<div id="jobsectors" class="rightop clear left wd100">
  <div class="container">
      <div class="col-xs-12 nopad">
        <div class="login-inner left mabottom5">
        <h2 class="mabottom0">Jobs Applied</h2>
      </div>
      <?php if(isset($_SESSION['msglogin'])){?>
        <div class="infomsg"><?php echo $_SESSION['msglogin'];?></div>
        <?php } ?>
            <table width="100%" id="postedjobs" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>Job Title</th>
              <th>Company</th>
              <th>Posted Date</th>
              <th>Status</th>
              <th>Job Information</th>
              </tr>
          </thead>
          <tbody>
          <?php 
			$jobs = $this->front_model->get_applied_jobs(UID);
			if(count($jobs) == 0){
				//echo '<div class="errormsg">No Job Applied so far!</div>';
			}else {
            foreach($jobs as $job):
            $arr = array('city_id' => $job->jStateCity);
            $config = $this->front_model->get_query_simple('*','dev_web_cities',$arr);
            $city	= $config->result_object();
            // GET COUNTRY
            $arr2 = array('id' => $job->jCoutry);
            $configco = $this->front_model->get_query_simple('*','dev_web_countries',$arr2);
            $cout = $configco->result_object();
			// GET COMPANY INFO
            $arr5 = array('uID' => $job->uID);
            $configco5 = $this->front_model->get_query_simple('*','dev_web_user',$arr5);
            $company = $configco5->result_object();
            //echo $this->db->last_query();
          ?>
          <tr>
              <td><?php echo $job->jTitle; ?></td>
              <td><?php echo $user[0]->uFname; ?> <?php echo $user[0]->uLname; ?></td>
              <td><?php echo date("M, d Y",strtotime($job->appliedDate));?></td>
              <td><?php if($job->aStatus == 0){echo "Applied";} 
							else if($job->aStatus == 1){echo "<span style='color:#09f'>Shortlisted</span>";} 
							else if($job->aStatus == 2){echo "<span style='color:#f00'>Rejected</span>";}?></td>
              <td align="center"><a href="<?php echo base_url(); ?>job/<?php echo $job->jURL; ?>"><i class="fa fa-th-large left coloredit"></i></a></td>
              </tr>
          <?php
          endforeach; } ?>
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