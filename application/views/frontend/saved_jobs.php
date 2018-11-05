
<?php require_once("common/header.php");?>
<div id="jobsectors" class="rightop clear left wd100">
  <div class="container">
    <div class="col-xs-12 nopad">
        <div class="login-inner left mabottom5">
        <h2 class="mabottom0">Saved Jobs</h2>
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
              <th>Remove Saved Job(s)</th>
              </tr>
          </thead>
          <tbody>
      <?php     	
	 	$arr = array('uID' => UID);
		$config = $this->front_model->get_query_simple('*','dev_web_saved',$arr);
		$jcount = $config->num_rows();
		
		$jobs	= $config->result_object();
		$c= 1;
	  	foreach($jobs as $job):
		
			$arr2 = array('jID' => $job->jID);
			$config2 = $this->front_model->get_query_simple('*','dev_web_jobs',$arr2);
			$jodetail= $config2->result_object();
			// GET CITY
			$arr4 = array('city_id' => $jodetail[0]->jStateCity);
			$config4 = $this->front_model->get_query_simple('*','dev_web_cities',$arr4);
			$city	= $config4->result_object();
			// GET COUNTRY
			$arr3 = array('id' => $jodetail[0]->jCoutry);
			$configco = $this->front_model->get_query_simple('*','dev_web_countries',$arr3);
			$cout = $configco->result_object();
			// GET Company
			$arr5 = array('uID' => $jodetail[0]->uID);
			$config5 = $this->front_model->get_query_simple('*','dev_web_user',$arr5);
			$comp = $config5->result_object();
	  ?>
      <tr>
              <td><?php echo $jodetail[0]->jTitle; ?></td>
              <td><?php echo $comp[0]->uFname; ?> <?php echo $comp[0]->uLname; ?></td>
              <td><?php echo date("M, d Y",strtotime($job->sDate));?></td>
              <td align="center">
              	<a href="<?php echo base_url(); ?>removesaved/<?php echo $job->sID?>">
                	<i class="fa fa-close" style="color:#f00;" title="Remove Saved"></i>
                </a>
              </td>
              </tr>
      <?php 
	  $c++;
	  endforeach;  ?>
    </tbody>
    </table>
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