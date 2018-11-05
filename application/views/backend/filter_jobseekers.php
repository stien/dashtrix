<?php require_once("common/header.php");?>
   <!-- LATEST DATA-->
   <div class="fullcontent right clear">
    <div class="dev-col-1 colbg clear left">
    	<h1>Filters</h1>
         <a href="<?php echo base_url(); ?>admin/filter_jobseekers?type=verified"><div class="right"><button class="btn btn-lg btn-green right" id="buttonadd">EMAIL VERIFIED JOBSEKKERS</button></div></a>
          <a href="<?php echo base_url(); ?>admin/filter_jobseekers?type=resume"><div class="right"><button style="margin-right:10px;" class="btn btn-lg btn-orange right" id="buttonadd">RESUME UPLOADED JOBSEEKERS</button></div></a>
          <a href="<?php echo base_url(); ?>admin/filter_jobseekers?type=profile"><div class="right">
          	<button class="btn btn-lg btn-green right" id="buttonadd" style="margin-right:10px;">PROFILE COMPLETED</button>
            </div></a>
    </div>
    </div>
   <?php
   //error_reporting(-1);
   if(isset($_GET['type']) && $_GET['type'] == "verified"){?>
    <div class="dev-col-1 left colbg">
      <h1>Email Verified Jobseekers</h1>
   	  <table width="100%" class="hover" id="categories" border="0" cellspacing="0" cellpadding="0">
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
            <th>Ip</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
			$comp = $this->admin_model->verifiedemaileduser(1,1);
			$user_list = $comp;
			foreach($user_list as $key => $valuecat):
			// IP DEtAiLS
				$condition = array('uID' => $valuecat->uID);
				$ipban =  $this->admin_model->get_table_data_condition_countrce('dev_web_ip',$condition);
				$ipcount = $ipban->num_rows();
				$iprow = $ipban->result_object();
			?>
          <tr>
            <td><?php echo $valuecat->uFname.' '.$valuecat->uLname; ?></td>
            <td><?php echo $valuecat->uEmail; ?> <i class="fa fa-check-circle-o " style="color:<?php if($valuecat->uverifyemail == '1'){echo '#093';}else {echo '#f00';}?>;"></i></td>
            <td><?php echo $valuecat->uCountry; ?></td>
            <td><?php if($valuecat->uActType == 1){echo "Jobseeker";} else {echo "<strong style='color:#f00;'>Recruiter</strong>";} ?></td>
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
            <td align="center">
			  
			  <?php echo $valuecat->uIP; ?>
              <?php if($ipcount > 0){?>
           	  <strong style="color:#f00;">IP Banned</strong> / <a href="<?php echo base_url(); ?>admin/unBanUserIP?uid=<?php echo $valuecat->uID; ?>&bId=<?php echo $iprow[0]->ipID;?>&rev=ip">Un-Ban User</a>
              <?php }  else { ?>
			  <?php if($valuecat->uIP != ""){ ?> / <a href="<?php echo base_url(); ?>admin/banUserIP?uid=<?php echo $valuecat->uID; ?>&rev=ip">Ban User</a><?php } ?>
              <?php } ?>
            </td>
            <td align="center"><a href="<?php echo base_url(); ?>backend/user/details/<?php echo $valuecat->uID; ?>"><i class="fa fa-th-large left coloredit"></i></a></td>
            <td align="center"><a href="<?php echo base_url(); ?>backend/add/user?type=edit&uid=<?php echo $valuecat->uID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>
            <td align="center"><a onClick="deleteuser(<?php echo $valuecat->uID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
   <?php } ?>
    <?php if(isset($_GET['type']) && $_GET['type'] == "resume"){?>
       <!--COMPANY USER-->
    <div class="dev-col-1 left colbg">
      <h1>Email Verified Jobseekers</h1>
   	  <table width="100%" class="hover" id="categories" border="0" cellspacing="0" cellpadding="0">
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
            <th>Ip</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
			$comp = $this->admin_model->resumeuploaded(1);
			$user_list = $comp;
			foreach($user_list as $key => $valuecat):
			// IP DEtAiLS
				$condition = array('uID' => $valuecat->uID);
				$ipban =  $this->admin_model->get_table_data_condition_countrce('dev_web_ip',$condition);
				$ipcount = $ipban->num_rows();
				$iprow = $ipban->result_object();
			?>
          <tr>
            <td><?php echo $valuecat->uFname.' '.$valuecat->uLname; ?></td>
            <td><?php echo $valuecat->uEmail; ?> <i class="fa fa-check-circle-o " style="color:<?php if($valuecat->uverifyemail == '1'){echo '#093';}else {echo '#f00';}?>;"></i></td>
            <td><?php echo $valuecat->uCountry; ?></td>
            <td><?php if($valuecat->uActType == 1){echo "Jobseeker";} else {echo "<strong style='color:#f00;'>Recruiter</strong>";} ?></td>
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
            <td align="center">
			  
			  <?php echo $valuecat->uIP; ?>
              <?php if($ipcount > 0){?>
           	  <strong style="color:#f00;">IP Banned</strong> / <a href="<?php echo base_url(); ?>admin/unBanUserIP?uid=<?php echo $valuecat->uID; ?>&bId=<?php echo $iprow[0]->ipID;?>&rev=ip">Un-Ban User</a>
              <?php }  else { ?>
			  <?php if($valuecat->uIP != ""){ ?> / <a href="<?php echo base_url(); ?>admin/banUserIP?uid=<?php echo $valuecat->uID; ?>&rev=ip">Ban User</a><?php } ?>
              <?php } ?>
            </td>
            <td align="center"><a href="<?php echo base_url(); ?>backend/user/details/<?php echo $valuecat->uID; ?>"><i class="fa fa-th-large left coloredit"></i></a></td>
            <td align="center"><a href="<?php echo base_url(); ?>backend/add/user?type=edit&uid=<?php echo $valuecat->uID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>
            <td align="center"><a onClick="deleteuser(<?php echo $valuecat->uID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
       <?php } ?>
       <?php if(isset($_GET['type']) && $_GET['type'] == "profile"){?>
       <!--COMPANY USER-->
    <div class="dev-col-1 left colbg">
      <h1>Completed Profile</h1>
   	  <table width="100%" class="hover" id="categories" border="0" cellspacing="0" cellpadding="0">
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
            <th>Ip</th>
            <th>Details</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
			$comp = $this->admin_model->profilefilledjobseekers(1);
			$user_list = $comp;
			foreach($user_list as $key => $valuecat):
			// IP DEtAiLS
				$condition = array('uID' => $valuecat->uID);
				$ipban =  $this->admin_model->get_table_data_condition_countrce('dev_web_ip',$condition);
				$ipcount = $ipban->num_rows();
				$iprow = $ipban->result_object();
			?>
          <tr>
            <td><?php echo $valuecat->uFname.' '.$valuecat->uLname; ?></td>
            <td><?php echo $valuecat->uEmail; ?> <i class="fa fa-check-circle-o " style="color:<?php if($valuecat->uverifyemail == '1'){echo '#093';}else {echo '#f00';}?>;"></i></td>
            <td><?php echo $valuecat->uCountry; ?></td>
            <td><?php if($valuecat->uActType == 1){echo "Jobseeker";} else {echo "<strong style='color:#f00;'>Recruiter</strong>";} ?></td>
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
            <td align="center">
			  
			  <?php echo $valuecat->uIP; ?>
              <?php if($ipcount > 0){?>
           	  <strong style="color:#f00;">IP Banned</strong> / <a href="<?php echo base_url(); ?>admin/unBanUserIP?uid=<?php echo $valuecat->uID; ?>&bId=<?php echo $iprow[0]->ipID;?>&rev=ip">Un-Ban User</a>
              <?php }  else { ?>
			  <?php if($valuecat->uIP != ""){ ?> / <a href="<?php echo base_url(); ?>admin/banUserIP?uid=<?php echo $valuecat->uID; ?>&rev=ip">Ban User</a><?php } ?>
              <?php } ?>
            </td>
            <td align="center"><a href="<?php echo base_url(); ?>backend/user/details/<?php echo $valuecat->uID; ?>"><i class="fa fa-th-large left coloredit"></i></a></td>
            <td align="center"><a href="<?php echo base_url(); ?>backend/add/user?type=edit&uid=<?php echo $valuecat->uID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>
            <td align="center"><a onClick="deleteuser(<?php echo $valuecat->uID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
       <?php } ?>
      
    
<?php require_once("common/footer.php"); ?>
<script language="javascript">
function deleteuser(id)
	{
		var x = confirm("Are you sure you want to permanently delete?");
	  	if (x){
			window.location='<?php echo base_url(); ?>backend/manage/users?type=delete&uid='+id;
			return true;
		}
		else {
			return false;
		}
	}
	function deletewebsitedata(id)
	{
		var x = confirm("Are you sure you want to do this Complaint and all its data?");
	  	if (x){
			window.location='<?php echo base_url(); ?>backend/complaints?type=delete&wid='+id;
			return true;
		}
		else {
			return false;
		}
	}
	function deletecompanydata(id)
	{
		var x = confirm("Are you sure you want to delete this Company and all its data?");
	  	if (x){
			window.location='<?php echo base_url(); ?>backend/manage/company/?type=delete&wid='+id;
			return true;
		}
		else {
			return false;
		}
	}
	function deletecommentsedata(id)
	{
		var x = confirm("Are you sure you want to do remove this comment?");
	  	if (x){
			window.location='<?php echo base_url(); ?>admin/comments_show/<?php echo $this->uri->segment(3);?>?type=delete&wid='+id;
			return true;
		}
		else {
			return false;
		}
	}
</script>
