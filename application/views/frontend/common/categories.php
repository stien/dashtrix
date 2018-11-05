<?php
$arr = array();
$config 	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);
$sectors 	= $config->result_object();
?>
<div class="col-xs-12 nopad">
  <div class="login-inner left">
    <h2>Jobs by Category</h2>
    <ul>
      <?php foreach($sectors as $cat):
		$arrjob = array('cID' => $cat->cID, 'jJobStatus'=>1);
		$configjobs 	= $this->front_model->get_query_simple('*','dev_web_jobs',$arrjob);
		$jobscount 	= $configjobs->num_rows();
	  ?>
      <li><i class="fa fa-arrow-right smallicon"></i> <a href="<?php echo base_url(); ?>jobs/<?php echo $cat->catLink;?>"><?php echo $cat->catName;?> (<?php echo $jobscount;?>)</a></li>
      <?php endforeach;?>
    </ul>
  </div>
</div>
