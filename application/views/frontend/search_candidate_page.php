<?php require_once("common/header.php");?>

<div id="jobsectors" class="rightop clear left wd100">
  <div class="container">
    <div class="col-xs-12 nopad">
    <?php if(isset($_SESSION['cansearchsession'])){?>
      <div class="login-inner left mabottom5">
            <h2 class="mabottom0">CV Search</h2>
      </div>
         
      <table width="100%" id="postedjobs" class="hover" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th>CV Title</th>
            <th>User Name</th>
            <th>Posted Date</th>
            <th>Download CV</th>
            </tr>
        </thead>
        <tbody>
          <?php 
			//$jobs = $this->front_model->search_candidate_cvs();
			
            foreach($_SESSION['cansearchsession'] as $job):
            /*$arr = array('city_id' => $job->jStateCity);
            $config = $this->front_model->get_query_simple('*','dev_web_cities',$arr);
            $city	= $config->result_object();*/
            // GET COUNTRY
            $arr2 = array('cvID' => $job->cvID, 'uID' => UID);
            $configco = $this->front_model->get_query_simple('*','dev_cv_viewed',$arr2);
            $cvcout = $configco->num_rows();
			// GET COMPANY INFO
            $arr5 = array('uID' => $job->uID);
            $configco5 = $this->front_model->get_query_simple('*','dev_web_user',$arr5);
            $user = $configco5->result_object();
            //echo $this->db->last_query();
          ?>
          <tr>
              <td><?php echo $job->cvTitle; ?></td>
              <td><?php echo $user[0]->uFname; ?> <?php echo $user[0]->uLname; ?></td>
              <td><?php echo date("M, d Y",strtotime($job->cvPosted));?></td>
              <td><a href="<?php echo base_url(); ?>download-cv/<?php echo $job->cvID; ?>"><i class="fa fa-cloud-download left coloredit" style="font-size:16px;"></i></a> <?php if($cvcout > 0){echo "<span style='color:#f00; margin-left:10px;font-weight:bold;'>(Already Viewed)</span>";}?></td>
            </tr>
          <?php
          endforeach;  ?>
        </tbody>
      </table>
          
      </div>
      <?php } ?>
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