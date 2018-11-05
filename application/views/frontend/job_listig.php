<?php 
require_once("common/header.php");
?>
<div id="loginbx">

  <div class="container">

  <div class="col-xs-3 pr0 navleftbar">

  	<?php require_once("common/search_refine.php");?>

  	<?php //require_once("common/categories.php");?>

  </div>

    <div class="col-xs-9 nopad">

    <?php

		$arr = array('catLink' => $this->uri->segment(2));

		$config	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);

		$catid 	= $config->result_object();

	?>

      <div class="login-inner left mabottom5">

        <h2 class="mabottom0">
			Jobs in Country -::- 
			<?php 
			if($this->uri->segment(1) == "country"){
			$u = str_replace("-"," ",$this->uri->segment(2));
			echo $u;
			}
			else {
				echo $catid[0]->catName; }?> 
            
        </h2>

      </div>

      

    <?php
		//$arr = array('cID' => $catid[0]->cID,'jJobStatus' => 1);

		//$jconfig	= $this->front_model->get_query_simple('*','dev_web_jobs',$arr);

		//$jobs 		= $jconfig->result_object();

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

                <?php 

				if($job->jStartSalary == "0" || $job->jEndSalary == "0"){echo "Not Disclosed";} else {

					if($job->jSalHidden == "1"){ echo "Not Disclosed"; } else {?>

                <?php echo $job->jCurrency;?><?php echo number_format($job->jStartSalary);?> - <?php echo $job->jCurrency;?><?php echo number_format($job->jEndSalary);?> <?php if($job->jsalType != ""){ echo "Per ".$job->jsalType;}?>

                <?php }} ?>

            </div>

        </div>

        <?php if($job->jDescription != ""){?>

        <div class="col-xs-12 nopad jobdesp">

       <?php /*?> <a href="<?php echo base_url(); ?>company/<?php echo $company[0]->uUsername;?>"><?php */?>

		<?php if($company[0]->uImage != ""){?>

        <img src="<?php echo base_url(); ?>resources/uploads/profile/<?php echo $company[0]->uImage; ?>" width="50" alt="" class="pullright" style="margin-left: 5px;">

        <?php }  else { ?>

        <div class="postedby pullright">

        	<p>Posted BY</p>

            <span>

				<?php if($job->jCDisclose == 0){echo "Confidential";} else {

					if($company[0]->uCompany == ""){echo $company[0]->uFname." ".$company[0]->uLname;} else {echo $company[0]->uCompany;}}?>

            </span>

        </div>

        <?php /*?><img src="<?php echo base_url(); ?>resources/frontend/images/no_photo.jpg" width="50" height="42" alt="<?php echo $company[0]->uFname;?> <?php echo $company[0]->uLname;?>" class="pullright" style="margin-left: 5px;"><?php */?>

        <?php } ?>

        <?php /*?></a><?php */?>

        	<?php echo substr(strip_tags(htmlspecialchars_decode($job->jDescription)),0,300)."...";?>

        </div>

        <?php } ?>

        <div class="col-xs-12 nopad jobdesp locdata">

       		<div class="col-xs-6 nopad">

           <?php /*?> <?php if($job->jStateCity !="0" || $job->jCoutry != "0"){?>

            <i class="fa fa-map-marker iconfont"></i>

            <?php if($job->jStateCity !="0"){?><a href="<?php echo base_url(); ?>city/<?php echo strtolower(str_replace(" ","-",$city[0]->city_name));?>"><?php echo $city[0]->city_name;?> , <?php echo $city[0]->city_state;?></a> -<?php } ?> 

            <?php if($job->jCoutry !="0"){?><a href="<?php echo base_url(); ?>country/<?php echo strtolower(str_replace(" ","-",$country[0]->country_name));?>"><?php echo $country[0]->country_name;?></a>

            <?php }} ?><?php */?>

            </div>

            <div class="col-xs-6 rightext nopad"><i class="fa fa-clock-o iconfont"></i><?php echo date("M, d Y",strtotime($job->jPostedDate));?></div>

            

        </div>

      </div>

      

    <?php

	endforeach;

		} else {

			echo '<div class="infomsg">No Jobs found against <strong>"'.$catid[0]->catName.'"</strong> category!</div>';

		}

	?>

   </div>

   <div class="pagination clear right" style="margin-top: 10px;

    margin-right: -5px;

    margin-bottom: 10px;"><?php echo $links; ?></div>

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

text-align:center;

line-height: 23px;

font-size: 13px;

margin-left: 12px;

border-radius: 5px;}

.postedby p {font-size: 11px;

text-transform: uppercase;}

.postedby span {color: #000;}

.pagination a {

  padding: 7px 9px;

  margin-right: 4px;

  border-radius: 3px;

  border: 1px solid silver;

  background: #e9e9e9;

  box-shadow: inset 0 1px 0 rgba(255,255,255,.8),0 1px 3px rgba(0,0,0,.1);

  font-size: .875em;

  color: #717171;

  text-shadow: 0 1px 0 rgba(255,255,255,1);

}

.pagination a.current {

  border: none!important;

  background: #2f3237!important;

  color: #fff!important;

  box-shadow: inset 0 0 8px rgba(0,0,0,.5),0 1px 0 rgba(255,255,255,.1)!important;

}

.pagination a:hover {

  background: #fefefe;

  background: -webkit-gradient(linear,0 0,0 100%,from(#FEFEFE),to(#f0f0f0));

  background: -moz-linear-gradient(0 0 270deg,#FEFEFE,#f0f0f0);

}

</style>

