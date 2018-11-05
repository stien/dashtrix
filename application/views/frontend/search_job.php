    <div class="login-inner left mabottom5">
        <h2 class="mabottom0">Job Search -::- <span style="color:#ef7268"><?php echo urldecode($_GET['search']);?></span></h2>
      </div>
	<?php
		$jobs	= $this->front_model->job_search_records(urldecode($_GET['search']),$_GET['country']);
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
      		<a href="#"><?php echo $job->jTitle;?></a>
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
      	<span class="company left"><?php if($job->jCDisclose == 0){echo "Confidential";} else {echo $company[0]->uCompany;}?></span>
        <div class="col-xs-12 nopad">
        	<div class="col-xs-3 pr0">
            	<div class="text-muted">Job Type</div>
                <?php echo $job->jNature;?>
            </div>
            <div class="col-xs-3 borleft">
            	<div class="text-muted">Shift</div>
                <?php echo $job->jShift;?>
            </div>
            <div class="col-xs-3 borleft">
            	<div class="text-muted">Experience</div>
                 <?php echo $job->jExpLevel;?> - <?php echo $job->jExpLevelmax;?> Years
            </div>
            <div class="col-xs-3 borleft">
            	<div class="text-muted">Salary</div>
                <?php if($job->jSalHidden == "1"){ echo "Not Disclosed"; } else {?>
                <?php echo $job->jCurrency;?><?php echo number_format($job->jStartSalary);?> - <?php echo $job->jCurrency;?><?php echo number_format($job->jEndSalary);?> <?php if($job->jsalType != ""){ echo "Per ".$job->jsalType;}?>
                <?php } ?>
            </div>
        </div>
        <?php if($job->jDescription != ""){?>
        <div class="col-xs-12 nopad jobdesp">
        
		<?php if($company[0]->uImage != ""){?>
        <img src="<?php echo base_url(); ?>resources/uploads/profile/<?php echo $company[0]->uImage; ?>" alt="" width="50" class="pullright">
        <?php }  else { ?>
        <img src="<?php echo base_url(); ?>resources/frontend/images/no_photo.jpg" width="50" height="42" alt="" class="pullright">
        <?php } ?>
        
        	<?php echo substr(strip_tags(htmlspecialchars_decode($job->jDescription)),0,300)."...";?>
        </div>
        <?php } ?>
        <div class="col-xs-12 nopad jobdesp locdata">
       <?php /*?> <?php if($job->jStateCity !="0" || $job->jCoutry != "0"){?>
       		<div class="col-xs-6 nopad"><i class="fa fa-map-marker iconfont"></i><a href="<?php echo base_url(); ?>country/<?php echo strtolower(str_replace(" ","-",$country[0]->country_name));?>"><?php echo $country[0]->country_name;?></a>
            </div>
            <?php } ?><?php */?>
            <div class="col-xs-6 nopad"></div>
            <div class="col-xs-6 rightext right nopad"><i class="fa fa-clock-o iconfont"></i><?php echo date("M, d Y",strtotime($job->jPostedDate));?></div>
            
        </div>
      </div>
    <?php
	endforeach;
		} else {
			echo '<div class="infomsg">No Jobs found against <strong>"'.$_GET['search'].'"</strong></div>';
		}
	?></div>
      </div></div>
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
