<?php require_once("common/header.php");?>
<div id="loginbx">
  <div class="container">
    <div class="col-xs-3 pr0 navleftbar">
    <?php require_once("common/search_refine.php");?>
    <?php require_once("common/categories.php");?>
    </div>
    <div class="col-xs-9 nopad">
      <?php
		$arr = array('city_name' => str_replace("-"," ",$this->uri->segment(2)));
		$config	= $this->front_model->get_query_simple('*','dev_web_cities',$arr);
		$catid 	= $config->result_object();
	?>
      <div class="login-inner left mabottom5">
        <h2 class="mabottom0">Jobs In - :: - <?php echo $catid[0]->city_name;?></h2>
      </div>
      <?php
		$arr = array('jStateCity' => $catid[0]->city_id);
		$jconfig	= $this->front_model->get_query_simple('*','dev_web_jobs',$arr);
		$jobs 		= $jconfig->result_object();
		if(count($jobs) > 0){
			foreach($jobs as $job):
			// GET COMPANY NAME
			$arr2 = array('uID' => $job->uID);
			$uconfig	= $this->front_model->get_query_simple('*','dev_web_user',$arr2);
			$company 	= $uconfig->result_object();
			// GET CITY NAME
			$arr3 = array('city_id' => $job->jStateCity);
			$cconfig	= $this->front_model->get_query_simple('*','dev_web_cities',$arr3);
			$city 	= $cconfig->result_object();
			// GET COUNTRY NAME
			$arr4 = array('id' => $job->jCoutry);
			$coconfig	= $this->front_model->get_query_simple('*','dev_web_countries',$arr4);
			$country 	= $coconfig->result_object();
	?>
      <div class="col-xs-12 nopad job-inner" data-id="<?php echo $job->jID;?>" id="jobboxbutton">
        <h2>
        	<a href="<?php echo base_url(); ?>job/<?php echo $job->jURL;?>"><?php echo $job->jTitle;?></a>
            <div class="showbuttons right" id="jb_<?php echo $job->jID;?>">
            	<a href="<?php echo base_url(); ?>job/<?php echo $job->jURL;?>"><button name="postjob" class="btn pink">View Job Details</button></a>
                <?php if(isset($_SESSION['JobsSessions'])){
					$ar = array('jID' => $job->jID,'uID' => UID,);
					$c = $this->front_model->get_query_simple('*','dev_web_saved',$ar);
					$count = $c->num_rows();
					if($count > 0) {
						echo '<button name="postjob" class="btn blue" style="background:#2a2a2a">Already Saved</button>';
					} else { ?>
                    <a href="<?php echo base_url(); ?>savejob/<?php echo $job->jID;?>"><button name="postjob" class="btn blue"><i class="fa fa-save"></i> Save</button></a>
                    <?php } ?>
                     <?php
				} else { ?>
                 <a href="<?php echo base_url(); ?>savejob/<?php echo $job->jID;?>"><button name="postjob" class="btn blue"><i class="fa fa-save"></i> Save</button></a>
                 <?php } ?>
               
            </div>
        </h2>
        <span class="company left"><?php echo $company[0]->uFname;?> <?php echo $company[0]->uLname;?></span>
        <div class="col-xs-12 nopad">
          <div class="col-xs-3 pr0">
            <div class="text-muted">Job Type</div>
            <?php echo $job->jNature;?> </div>
          <div class="col-xs-3 borleft">
            <div class="text-muted">Shift</div>
            <?php echo $job->jShift;?> </div>
          <div class="col-xs-3 borleft">
            <div class="text-muted">Experience</div>
            <?php echo $job->jExpLevel;?> Years </div>
          <div class="col-xs-3 borleft">
            <div class="text-muted">Salary</div>
            <?php echo number_format($job->jStartSalary);?> - <?php echo number_format($job->jEndSalary);?> USD </div>
        </div>
        <?php if($company[0]->uAbout != ""){?>
        <div class="col-xs-12 nopad jobdesp">
          <?php if($company[0]->uImage != ""){?>
          <img src="<?php echo base_url(); ?>resources/frontend/images/1af302d45db649c6a9dab29f73237f5f22211.jpg" alt="<?php echo $company[0]->uFname;?> <?php echo $company[0]->uLname;?>" class="pullright">
          <?php }  else { ?>
          <img src="<?php echo base_url(); ?>resources/frontend/images/no_photo.jpg" width="50" height="42" alt="<?php echo $company[0]->uFname;?> <?php echo $company[0]->uLname;?>" class="pullright">
          <?php } ?>
          <?php echo substr($job->jDescription,0,150);?>
         </div>
        <?php } ?>
        <div class="col-xs-12 nopad jobdesp locdata">
          <div class="col-xs-6 nopad"><i class="fa fa-map-marker iconfont"></i><a href="<?php echo base_url(); ?>city/<?php echo strtolower(str_replace(" ","-",$city[0]->city_name));?>"><?php echo $city[0]->city_name;?> , <?php echo $city[0]->city_state;?></a> - <a href="<?php echo base_url(); ?>country/<?php echo strtolower(str_replace(" ","-",$country[0]->country_name));?>"><?php echo $country[0]->country_name;?></a></div>
          <div class="col-xs-6 rightext nopad"><i class="fa fa-clock-o iconfont"></i><?php echo date("M, d Y",strtotime($job->jPostedDate));?></div>
        </div>
      </div>
      <?php
	endforeach;
		} else {
			echo '<div class="infomsg">No Jobs found against city <strong>"'.$catid[0]->city_name.'"</strong>!</div>';
		}
	?>
    </div>
  </div>
</div>
<?php require_once("common/footer.php");?>
<script language="javascript">
$('[id="jobboxbutton"]').on("mouseenter",function(evt){
	evt.stopPropagation();
	var id = $(this).data("id");
	$("#jb_"+id).fadeIn();
});
$('[id="jobboxbutton"]').on("mouseleave",function(evt){
	evt.stopPropagation();
	var id = $(this).data("id");
	$(".showbuttons").hide();
});
</script>