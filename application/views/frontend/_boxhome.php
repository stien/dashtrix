<?php require_once("common/header.php");?>
<div id="jobsectors" class="rightop clear left wd100">
  <div class="container">
    <div class="col-xs-12 nopad">
      <?php if(isset($_SESSION['JobsSessions']) && ACTYPE == 1){ ?>
      <!--RECOMMENDED JOB-->
      <div class="col-xs-12 nopad">
        <?php 
				$cvd2 = array('uID' => UID);
				$uscv =  $this->front_model->get_query_simple('*','dev_web_cv',$cvd2);
				$usercv = $uscv->result_object();
				$datarec = $usercv[0]->pJobtitle." ".$usercv[0]->pjobskills;
				$exp = explode(" ",$datarec);
				for($i=0;$i<=count($exp)-1;$i++){
					if(count($exp) > 1){$or = "OR";} else {$or = "";}
					$jti .= "`jTitle` LIKE '%".$exp[$i]."%' ".$or." ";
				}
				$jti = $jti."`cID` = '".$usercv[0]->jobSector."'";
				$qury = $jti;
				//$qury =  substr($jti,0,-3);
				$recommendedjob =  $this->front_model->recommenededjobsrand($qury);
			
				foreach($recommendedjob as $recommend):
			?>
        <div class="col-xs-3 pr0" id="jb_<?php echo $recommend->jID;?>">
          <div class="recommended"> <small class="left">Recommended
            <?php /*?><i class="fa fa-close right" title="close" onClick="hidrecommended(<?php echo $recommend->jID;?>)"></i><?php */?>
            </small> <a href="<?php echo base_url(); ?>job/<?php echo $recommend->jURL;?>">
            <div class="jobbox">
              <h3><?php echo substr($recommend->jTitle,0,25)."...";?></h3>
              <p><?php echo $recommend->jStartSalary;?> - <?php echo $recommend->jEndSalary;?></p>
              <span><?php echo $recommend->jNature;?></span> </div>
            </a> </div>
        </div>
        <?php 
			endforeach;?>
      </div>
      <!---->
      <?PHP } ?>
      <div class="col-xs-3 <?php if(isset($_GET['search'])){echo "pr0";}else { echo "nopad";}?> navleftbar">
        <?php require_once("common/categories_home.php");?>
      </div>
      <div class="col-xs-9 nopad">
        <?php if(isset($_GET['search'])){
		require_once("search_job.php");
	} else { ?>
        <div class="col-xs-12">
        	<div class="col-xs-12">
          <h1 style="border: 1px solid #ccc;padding: 10px;background-color: #fff;
    box-sizing: border-box;">Latest Jobs</h1>
    </div>
          <?php 
            foreach($jobs as $job):
            $arr = array('city_id' => $job->jStateCity);
            $config = $this->front_model->get_query_simple('*','dev_web_cities',$arr);
            $city	= $config->result_object();
            // GET COUNTRY
            $arr2 = array('id' => $job->jCoutry);
            $configco = $this->front_model->get_query_simple('*','dev_web_countries',$arr2);
            $cout = $configco->result_object();
			// GET COUNTRY
            $userarray = array('uID' => $job->uID);
            $userrow = $this->front_model->get_query_simple('*','dev_web_user',$userarray);
            $user = $userrow->result_object();
          ?>
          <div class="col-xs-4">
            <div class="boxrecent heightsame">
              <h2> <a href="<?php echo base_url(); ?>job/<?php echo $job->jURL;?>"><?php echo substr($job->jTitle,0,20)."..."?></a> </h2>
              <p class="col-xs-8 pr0" style="min-height: 105px;"> 
			  <?php echo substr(strip_tags(htmlspecialchars_decode($job->jDescription)),0,120); ?>... </p>
              <div class="col-xs-4 nopad imgrighthome"> <a href="<?php echo base_url(); ?>company/<?php echo $user[0]->uUsername;?>">
                <?php if($job->uImage == ""){?>
                <img src="<?php echo base_url(); ?>resources/frontend/images/no_photo.jpg" alt="No Photo">
                <?php } else { ?>
                <img src="<?php echo base_url(); ?>resources/uploads/profile/thumbnail_<?php echo $job->uImage; ?>">
                <?php } ?>
                </a> </div>
              <div class="btndetail" style="margin-top:0;"> <a href="<?php echo base_url(); ?>job/<?php echo $job->jURL;?>">
                <button name="details" class="btn green">View Details</button>
                </a> </div>
            </div>
          </div>
          <?php endforeach;?>
        </div>
        <a href="<?php echo base_url(); ?>create-cv">
        <div class="col-xs-6">
        	<div class="col-xs-12">
          <div class="uploadcvbx"> <i class="fa left fa-file-text"></i> Upload Your CV </div>
          </div>
        </div>
        </a> <a href="<?php echo base_url(); ?>saved-jobs">
        <div class="col-xs-6">
        <div class="col-xs-12">
          <div class="uploadcvbx" style="background:#7CA52F;"> <i class="fa left fa-star"></i> View Saved Jobs </div>
          </div>
        </div>
        </a>
        <?php } ?>
      </div>
    </div>
    <?php if($_GET['search'] == ""){?>
    <!--Top Viewed JOB-->
    <div class="col-xs-12 nopad">
      <?php 
				$topjobs =  $this->front_model->topviewedJobs();
				foreach($topjobs as $top):
			?>
      <a href="<?php echo base_url(); ?>job/<?php echo $top->jURL;?>">
      <div class="col-xs-3 pr0" id="jb_<?php echo $top->jID;?>">
        <div class="recommended"> <small class="left">Top Viewed Job</small>
          <div class="jobbox">
            <h3><?php echo substr($top->jTitle,0,25)."...";?></h3>
            <p><?php echo $top->jStartSalary;?> - <?php echo $top->jEndSalary;?></p>
            <span><?php echo $top->jNature;?></span> </div>
        </div>
      </div>
      </a>
      <?php 
			endforeach;?>
    </div>
    <!----> 
  	<?php } ?>
  </div>
  
</div>
<?php require_once("common/footer.php");?>
<style>
.media {
	min-height: 46px;
}
.heightsame {
	min-height: 186px;
}
</style>
<script language="javascript">
function hidrecommended(id)
{
	$("#jb_"+id).fadeOut();
}
</script>