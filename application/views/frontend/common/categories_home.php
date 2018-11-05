<?php

$arr = array();

$config 	= $this->front_model->get_query_orderby_limit('*','dev_web_categories',$arr,'catName','ASC',19,0);

$sectors 	= $config->result_object();

?>

<div class="col-xs-12 nopad">

  <div class="login-inner left" style="  padding-bottom: 11px;">

    <h2>Jobs by Category</h2>

    <ul>

      <?php foreach($sectors as $cat):

	  	$arrjob = array('cID' => $cat->cID, 'jJobStatus'=>1);

		$configjobs 	= $this->front_model->get_query_simple('*','dev_web_jobs',$arrjob);

		$jobscount 	= $configjobs->num_rows();

	  ?>

      <li><i class="fa fa-arrow-right smallicon"></i> <a href="<?php echo base_url(); ?>jobs/<?php echo $cat->catLink;?>"><?php echo $cat->catName;?> (<?php echo $jobscount;?>)</a></li>

      <?php endforeach;?>

      <div id="morecat" style="display:none;"> 

      <?php

		$arr2 = array();

		$config2 	= $this->front_model->get_query_orderby_limit('*','dev_web_categories',$arr2,'catName','ASC',50,20);

		$sectors2 	= $config2->result_object();

		?>

      <?php foreach($sectors2 as $cat2):

	  $arrjob = array('cID' => $cat2->cID);

		$configjobs 	= $this->front_model->get_query_simple('*','dev_web_jobs',$arrjob);

		$jobscount 	= $configjobs->num_rows();?>

      <li><i class="fa fa-arrow-right smallicon"></i> <a href="<?php echo base_url(); ?>jobs/<?php echo $cat2->catLink;?>"><?php echo $cat2->catName;?> (<?php echo $jobscount;?>)</a></li>

      <?php endforeach;?>

      </div>

      <a href="javascript:;" onclick="showmorecategories()" id="hidemore">

      		<button name="signup" class="btn green wd100">View More</button></a>

      <a href="javascript:;" onclick="hidemorecategories()" id="viemore" style="display:none;">

      		<button name="signup" class="btn green wd100">Hide More</button></a>

    </ul>

  </div>

</div>

<script language="javascript">

function showmorecategories(){

	$("#morecat").slideDown();

	$("#hidemore").hide();

	$("#viemore").show();

}

function hidemorecategories(){

	$("#morecat").slideUp();

	$("#hidemore").show();

	$("#viemore").hide();

}

</script>

