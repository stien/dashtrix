<?php require_once("common/header.php");?>

<?php 

	$datac = '';

	foreach($datachart as $chart):

	$d = explode(" ",$chart->Review);

	$dd = explode("-",$d[0]);

     $datac .=  '{ x: new Date('.$dd[0].', '.($dd[1]-1).', '.$dd[2].'), y: '.$chart->Datacount.'},';

	endforeach;

	$datachart = substr($datac,0,-1);

	?>

<script type="text/javascript" src="<?php echo base_url(); ?>resources/backend/js/jquery.canvasjs.min.js"></script>

<script type="text/javascript">

window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer",

    {

		animationEnabled: true,

        title: {

            //text: "Date Time Formatting"               

        },

        axisX:{      

            valueFormatString: "D MMM" ,

            labelAngle: -50

        },

        axisY: {

          valueFormatString: "#,###"

      },



      data: [

      {        

        type: "column",

        color: "rgba(0,75,141,0.7)",

        dataPoints: [

        	<?php echo $datachart;?> 

        ]

    }

    

    ]

});



chart.render();

}

</script>

<style>

#categories2_length, #categories_length , .dataTables_info, .dataTables_paginate, .dataTables_filter{ display:none;}

.canvasjs-chart-credit {display:none;}

</style>

		<!-- wrapper top bar -->

        <?php 

		foreach($getStats as $val):

			$usersall 			= $val['userTotal'];

			$categories 	= $val['catsTotal'];

			$websitesget	 	= $val['webTotal'];

			$reviews	 	= $val['revTotal'];

			$commentsall	 	= $val['comTotal'];

			$visitors	 	= $val['visTotal'];

			$agents	 	= $val['agents'];

			$totalviewd	 	= $val['totalviewd'];

			$totalnotviewed	 	= $val['totalnotviewed'];

			$comorder	 	= $val['comorder'];

		endforeach;

		

		foreach($todayStats as $tval):

			$users 			= $tval['userTotal'];

			$categories 	= $tval['catsTotal'];

			$websites	 	= $tval['webTotal'];

			$reviews	 	= $tval['revTotal'];

			$comments	 	= $tval['comTotal'];

			$visitors	 	= $tval['visTotal'];

			$comorder	 	= $tval['comorder'];

		endforeach;

		?>

        <!--TODAY JOBS-->

        <div class="dev-col-1 left colbg">

       	<h1>Today Stats</h1>

        <div class="wrapboxmain left">

        	<?php /*?><div class="wrapbox left">

            	<span class="left bgorange"><?php echo $categories; ?></span>

                <h3 class="right colororange"><a href="<?php echo base_url(); ?>backend/categories" style=" text-decoration:none;" class="colororange">Categories</a></h3>

            </div><?php */?>

        	<div class="wrapbox left">

            	<span class="left bgyellow"><?php echo $users; ?></span>

                <h3 class="right coloryellow"><a href="<?php echo base_url(); ?>admin/today_stats?type=jobseeker" style=" text-decoration:none;" class="coloryellow">Jobseekers</a></h3>

            </div>

            <div class="wrapbox left">

            	<span class="left bgorange"><?php echo $comments; ?></span>

                <h3 class="right colororange"><a href="<?php echo base_url(); ?>admin/today_stats?type=recruiter" style=" text-decoration:none;" class="colororange">Recruiters</a></h3>

            </div>

        	<div class="wrapbox left">

            	<span class="left bggreen"><?php echo $websites; ?></span>

                <h3 class="right colorgreen"><a href="<?php echo base_url(); ?>backend/manage/jobs?viewd=today" style=" text-decoration:none;" class="colorgreen">Jobs</a></h3>

            </div>

         

        </div>

        </div>

        <div class="dev-col-1 left colbg">

       	<h1>General Stats</h1>

        <div class="wrapboxmain left">

        	<div class="wrapbox left">

            	<span class="left bgorange"><?php echo $categories; ?></span>

                <h3 class="right colororange"><a href="<?php echo base_url(); ?>backend/categories" style=" text-decoration:none;" class="colororange">Categories</a></h3>

            </div>

        	<div class="wrapbox left">

            	<span class="left bgyellow"><?php echo $usersall; ?></span>

                <h3 class="right coloryellow"><a href="<?php echo base_url(); ?>backend/manage/users" style=" text-decoration:none;" class="coloryellow">All Users</a></h3>

            </div>

        	<div class="wrapbox left">

            	<span class="left bggreen"><?php echo $websitesget; ?></span>

                <h3 class="right colorgreen"><a href="<?php echo base_url(); ?>backend/manage/jobs" style=" text-decoration:none;" class="colorgreen">Jobs</a></h3>

            </div>

            <div class="wrapbox left">

            	<span class="left bggreen"><?php echo $reviews; ?></span>

                <h3 class="right colorgreen"><a href="<?php echo base_url(); ?>backend/manage/jobseeker" style=" text-decoration:none;" class="colorgreen">Jobseekers</a></h3>

            </div>

            <div class="wrapbox left">

            	<span class="left bgorange"><?php echo $commentsall; ?></span>

                <h3 class="right colororange"><a href="<?php echo base_url(); ?>backend/manage/employer"style=" text-decoration:none;" class="colororange">Recruiters</a></h3>

            </div>

            <div class="wrapbox left">

            	<span class="left bgyellow"><?php echo $visitors; ?></span>

                <h3 class="right coloryellow">VISTORS</h3>

            </div>

             <div class="wrapbox left">

            	<span class="left bgyellow">$<?php echo $comorder; ?></span>

                <h3 class="right coloryellow"><a href="<?php echo base_url(); ?>admin/manage_orders" style=" text-decoration:none;" class="coloryellow">Orders</a></h3>

            </div>

            

            <div class="wrapbox left">

            	<span class="left bgorange"><?php echo $agents; ?></span>

                <h3 class="right colororange"><a href="<?php echo base_url(); ?>admin/today_stats?type=agents" style=" text-decoration:none;" class="colororange">Posted By Agents</a></h3>

            </div>

            

             <div class="wrapbox left">

            	<span class="left bggreen"><?php echo $totalviewd; ?></span>

                <h3 class="right colorgreen"style="font-size:17px"><a href="<?php echo base_url(); ?>admin/today_stats?type=jobsviews" style=" text-decoration:none;" class="colorgreen" >Job Viewed By Moderator</a></h3>

        </div>

        <div class="wrapbox left">

            	<span class="left bgyellow"><?php echo $totalnotviewed; ?></span>

                <h3 class="right coloryellow" style="font-size:17px"><a href="<?php echo base_url(); ?>admin/today_stats?type=jobsnotviewed" style=" text-decoration:none;" class="coloryellow" >Job Not Viewed By Moderator</a></h3>

        </div>

        </div>

    <div class="dev-col-1 left colbg">

      <h1>Jobs Posted per day</h1>

      <div id="chartContainer" style="height: 400px;"></div>

    </div>

    

   <!-- LATEST DATA-->

       <div class="dev-col-1 left colbg">

       <h1>Latest Users</h1>

       	<table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">

          <thead>

            <tr>

              <th>Full Name</th>

              <th>Email Address</th>

              <th>Country</th>

              <th>Type</th>

              <th>Join Date</th>

              <th>Last Login</th>

              <th>Account</th>

              <th>Status</th>

              <th>Jobs</th>

              <th>Details</th>

              <th>IP</th>

              <th>Edit</th>

              <th>Delete</th>

            </tr>

          </thead>

          <tbody>

          <?php

			foreach($user_list as $key => $valuecat):

			?>

            <tr>

              <td><?php echo $valuecat->uFname.' '.$valuecat->uLname; ?></td>

              <td><?php echo $valuecat->uEmail; ?></td>

              <td><?php echo $valuecat->uCountry; ?></td>

              <td><?php if($valuecat->uActType == 1){echo "Jobseeker";} else {echo "<strong style='color:#f00;'>Employers</strong>";} ?></td>

              <td><?php echo date("F, d Y",strtotime($valuecat->joinDate)); ?></td>

              <td><?php if($valuecat->uLoginLast != ""){echo date("F, d Y h:i A",strtotime($valuecat->uLoginLast));}else {echo "<strong style='color:#ccc'>Not Loggedin Yet</strong>";} ?></td>

              <td><?php if($valuecat->usocial == ""){echo "<strong style=' color:#6AAD43;'>NORMAL</strong>";} else {echo '<span style="color:#f00; font-weight:bold;"'.$valuecat->usocial.'</span>';} ?></td>

              <td><?php if($valuecat->uStatus == '1'){echo 'Active';} else {echo 'In-Active';} ?></td>

              <td align="center">

              <?php if($valuecat->uActType == 2){?>

              	<a href="<?php echo base_url(); ?>backend/manage/jobs?type=action&filter=company&id=<?php echo $valuecat->uID;?>"><i class="fa fa-th-large left coloredit"></i></a>

              <?php } else { ?>

              		<a href="<?php echo base_url(); ?>backend/user/details/<?php echo $valuecat->uID;?>?link=applied"><i class="fa fa-th-large left coloredit"></i></a>

              <?php } ?>

              </td>

              <td align="center"><a href="<?php echo base_url(); ?>backend/user/details/<?php echo $valuecat->uID; ?>"><i class="fa fa-th-large left coloredit"></i></a></td>

              <td align="center"><?php echo $valuecat->uIP;?></td>

              <td align="center"><a href="<?php echo base_url(); ?>backend/add/user?type=edit&uid=<?php echo $valuecat->uID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>

              <td align="center"><a onClick="deleteuser(<?php echo $valuecat->uID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>

            </tr>

            <?php endforeach; ?>

          </tbody>

        </table>

       </div>

    <div class="dev-col-1 left colbg">

      <h1>Latest Jobs</h1>

   	  <table width="100%" id="categories2" class="hover" border="0" cellspacing="0" cellpadding="0">

        <thead>

            <tr>

              <th>Job Title</th>

              <th>URL</th>

              <th>Company</th>

              <th>Industry</th>

              <th>Posted Date</th>

              <th>Update Date</th>

              <th>Nature</th>

              <th>Status</th>

              <th>Applicants</th>

              <th>Details</th>

              <th>Edit</th>

              <th><?php if($this->uri->segment(4) != "" && $this->uri->segment(4) == "archived"){echo "Delete";} else {echo "Archive";}?></th>

            </tr>

          </thead>

          <tbody>

          <?php

			foreach($jobs_list as $key => $valuecat):

				$condition = array('uID' => $valuecat->uID);

				$user = $this->admin_model->get_table_data_condition('dev_web_user',$condition);

				$condition2 = array('cID' => $valuecat->cID);

				$industry = $this->admin_model->get_table_data_condition('dev_web_categories',$condition2);

			?>

            <tr>

              <td><?php echo $valuecat->jTitle; ?></td>

              <td><?php echo $valuecat->jURL; ?></td>

              <td><?php echo $user[0]->uFname; ?> <?php echo $user[0]->uLname; ?></td>

              <td><?php echo $industry[0]->catName; ?></td>

              <td><?php echo date("F, d Y",strtotime($valuecat->jPostedDate)); ?></td>

              <td><?php if($valuecat->jJobUpdated != ""){echo date("F, d Y h:i A",strtotime($valuecat->jJobUpdated));}else {echo "<strong style='color:#ccc'>Not Updated Yet</strong>";} ?></td>

              <td><?php echo $valuecat->jNature; ?></td>

              <td><?php if($valuecat->jJobStatus == '1'){echo 'Active';} else {echo 'In-Active';} ?></td>

              <td align="center"><a href="<?php echo base_url(); ?>backend/manage/applicants/<?php echo $valuecat->jID; ?>"><i class="fa fa-th-large left coloredit"></i></a></td>

              <td align="center"><a href="<?php echo base_url(); ?>backend/job/details/<?php echo $valuecat->jID; ?>"><i class="fa fa-th-large left coloredit"></i></a></td>

              <td align="center"><a href="<?php echo base_url(); ?>backend/new-job?type=edit&jid=<?php echo $valuecat->jID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>

              <td align="center"><a onClick="<?php if($valuecat->jArchived == '1'){?>deleteuser(<?php echo $valuecat->jID; ?>)<?php } else {?>archiveduser(<?php echo $valuecat->jID; ?>)<?php } ?>" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>

            </tr>

            <?php endforeach; ?>

          </tbody>

      </table>

      </div>

       

<?php require_once("common/footer.php"); ?>