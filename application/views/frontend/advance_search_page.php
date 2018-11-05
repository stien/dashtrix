<?php require_once("common/header.php");?>
<div id="loginbx">
  <div class="container">
  <div class="col-xs-3 pr0 navleftbar">
  	<?php require_once("common/search_refine.php");?>
  	<?php require_once("common/categories.php");?>
  </div>
    <div class="col-xs-9 nopad">
      <div class="login-inner left mabottom5">
        <h2 class="mabottom0">Advance Search - :: - Jobs</h2>
      </div>
      
    <?php
		if(count($jobsadvance) > 0){
			foreach($jobsadvance as $job):
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
      <?php //print_r($jobs);?>
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
        <img src="<?php echo base_url(); ?>resources/uploads/profile/<?php echo $company[0]->uImage; ?>" width="50" alt="<?php echo $company[0]->uFname;?> <?php echo $company[0]->uLname;?>" class="pullright" style="margin-left: 5px;">
        <?php }  else { ?>
        <div class="postedby pullright">
        	<p>Posted BY</p>
            <span>
				<?php if($job->jCDisclose == 0){echo "Confidential";} else {
					if($company[0]->uCompany == ""){echo $company[0]->uFname." ".$company[0]->uLname;} else {echo $company[0]->uCompany;}}?>
            </span>
        </div>
        <?php } ?>
        
        	<?php echo substr(strip_tags(htmlspecialchars_decode($job->jDescription)),0,300)."...";?>
        </div>
        <?php } ?>
        <div class="col-xs-12 nopad jobdesp locdata">
       		<div class="col-xs-6 nopad">
            
            </div>
            <div class="col-xs-6 rightext nopad"><i class="fa fa-clock-o iconfont"></i><?php echo date("M, d Y",strtotime($job->jPostedDate));?></div>
            
        </div>
      </div>
    <?php
	endforeach;
		} else {
			echo '<div class="infomsg">No Record Founds!</div>';
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

<style>
.postedby {  
border: 1px solid #ccc;
padding: 16px;
line-height: 23px;
font-size: 13px;
margin-left: 12px;
border-radius: 5px;}
.postedby p {font-size: 11px;
text-transform: uppercase;}
.postedby span {color: #000;}
</style>