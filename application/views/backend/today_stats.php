<?php require_once("common/header.php");?>
   <!-- LATEST DATA-->
   <?php if(isset($_GET['type']) && $_GET['type'] == "jobseeker"){?>
       <div class="dev-col-1 left colbg">
       <h1>Today Jobseekers</h1>
       	<table width="100%" class="hover" id="categories" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>&nbsp;</th>
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
			$comp = $this->admin_model->gettodayuserslist(1);
			$user_list = $comp;
			foreach($user_list as $key => $valuecat):
			// IP DEtAiLS
				$condition = array('uID' => $valuecat->uID);
				$ipban =  $this->admin_model->get_table_data_condition_countrce('dev_web_ip',$condition);
				$ipcount = $ipban->num_rows();
				$iprow = $ipban->result_object();
			?>
            <tr>
              <td><input type="checkbox" value="<?php echo $valuecat->uID; ?>" class="checkbox1" name="chkuser[]" id="chkuser[]" /></td>
              <td><?php echo $valuecat->uFname.' '.$valuecat->uLname; ?></td>
              <td><?php echo $valuecat->uEmail; ?></td>
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
    <?php if(isset($_GET['type']) && $_GET['type'] == "recruiter"){?>
       <!--COMPANY USER-->
       <div class="dev-col-1 left colbg">
       <h1>Today Recruiters</h1>
       	<table width="100%" class="hover" id="categories" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>&nbsp;</th>
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
			$comp = $this->admin_model->gettodayuserslist(2);
			$user_list = $comp;
			foreach($user_list as $key => $valuecat):
			// IP DEtAiLS
				$condition = array('uID' => $valuecat->uID);
				$ipban =  $this->admin_model->get_table_data_condition_countrce('dev_web_ip',$condition);
				$ipcount = $ipban->num_rows();
				$iprow = $ipban->result_object();
			?>
            <tr>
              <td><input type="checkbox" value="<?php echo $valuecat->uID; ?>" class="checkbox1" name="chkuser[]" id="chkuser[]" /></td>
              <td><?php echo $valuecat->uFname.' '.$valuecat->uLname; ?></td>
              <td><?php echo $valuecat->uEmail; ?></td>
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
       <?php if(isset($_GET['type']) && $_GET['type'] == "agents"){?>
       <div class="dev-col-1 left colbg">
       <h1>Posted By Agents</h1>
   	   <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <?php /*?><th>&nbsp;</th><?php */?>
              <th>Job Title</th>
              <th>URL</th>
              <th>Company</th>
              <th>Industry</th>
              <th>Posted Date</th>
              <th>Update Date</th>
              <th>Nature</th>
              <th>Verified</th>
              <th>Status</th>
              <th>Ip</th>
              <th>Applicants</th>
              <th>Viewed by moderator</th>
              <th>View Job</th>
              <th>Post By</th>
              <th>Edit</th>
              <th><?php if($this->uri->segment(4) != "" && $this->uri->segment(4) == "archived"){echo "Delete";} else {echo "Delete";}?></th>
            </tr>
          </thead>
          <tbody>
          <?php
			$condition = array('jPostedUser' => 0);
			$jobs_list =  $this->admin_model->get_table_data_condition('dev_web_jobs',$condition);	
			foreach($jobs_list as $key => $valuecat):
				$condition = array('uID' => $valuecat->uID);
				$user = $this->admin_model->get_table_data_condition('dev_web_user',$condition);
				$condition2 = array('cID' => $valuecat->cID);
				$industry = $this->admin_model->get_table_data_condition('dev_web_categories',$condition2);
				// IP DEtAiLS
				$condition = array('ipAdd' => $valuecat->jJobIP);
				$ipban =  $this->admin_model->get_table_data_condition_countrce('dev_web_ip',$condition);
				$ipcount = $ipban->num_rows();
				$iprow = $ipban->result_object();
				
				$conditionagr = array('uID' => $valuecat->agtID);
				$useragt = $this->admin_model->get_table_data_condition('dev_web_user',$conditionagr);
			?>
            <tr>
              <?php /*?><td><input type="checkbox" value="<?php echo $valuecat->jID; ?>" class="checkbox1" name="chkuser[]" id="chkuser[]" /></td><?php */?>
              <td><?php echo $valuecat->jTitle; ?></td>
              <td><?php echo $valuecat->jURL; ?></td>
              <td><?php echo $user[0]->uFname; ?> <?php echo $user[0]->uLname; ?></td>
              <td><?php echo $industry[0]->catName; ?></td>
              <td><?php echo date("F, d Y",strtotime($valuecat->jPostedDate)); ?></td>
              <td><?php if($valuecat->jJobUpdated != ""){echo date("F, d Y h:i A",strtotime($valuecat->jJobUpdated));}else {echo "<strong style='color:#ccc'>Not Updated Yet</strong>";} ?></td>
              <td><?php echo $valuecat->jNature; ?></td>
              <td><?php if($valuecat->jJobStatus == '1'){?>
              <a onClick="deleteuser(<?php echo $valuecat->jID; ?>)" href="javascript:;">Spam? Remove Job</a>
              <?php } ?>
			</td>
              <td><?php if($valuecat->jJobStatus == '1'){echo 'Active';} else {echo 'In-Active';} ?></td>
              <td align="center">
			  <?php echo $valuecat->jJobIP; ?>
               <?php if($ipcount > 0){?>
              	<strong style="color:#f00;">IP Banned</strong> / <a href="<?php echo base_url(); ?>admin/unBanUserIP?uid=<?php echo $user[0]->uID; ?>&bId=<?php echo $iprow[0]->ipID;?>&rev=ip">Un-Ban IP</a>
              <?php }  else { ?>
			  <?php if($valuecat->jJobIP != ""){ ?> / <a href="<?php echo base_url(); ?>admin/banUserIPFull?uid=<?php echo $user[0]->uID; ?>&rev=ip">Ban IP</a><?php } ?>
              <?php } ?>
              </td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/manage/applicants/<?php echo $valuecat->jID; ?>"><i class="fa fa-th-large left coloredit"></i></a></td>
              <td align="center"><?php if($valuecat->jViewed == '1'){echo '<span style="color:#09f;">Viewed</span>';} else {echo '<span style="color:#f00;"><strong>Pending</strong></span>';} ?></td>
              <td align="center"><a href="<?php echo base_url(); ?>job/<?php echo $valuecat->jURL; ?>?view=moderator" target="_blank"><i class="fa fa-search left coloredit"></i></a></td>
              <td align="center"><?php if($valuecat->jPostedUser == '1'){echo 'Recruiter';} else {echo 'Agent ('.$useragt[0]->uFname.' '.$useragt[0]->uLname.')';} ?></td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/new-job?type=edit&jid=<?php echo $valuecat->jID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>
              <td align="center"><a onClick="deleteuser(<?php echo $valuecat->jID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
       </div>
      <?php } ?>
      
      <?php if(isset($_GET['type']) && $_GET['type'] == "jobsviews"){?>
       <div class="dev-col-1 left colbg">
       <h1>Jobs Viewed By Moderator</h1>
   	   <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <?php /*?><th>&nbsp;</th><?php */?>
              <th>Job Title</th>
              <th>URL</th>
              <th>Company</th>
              <th>Industry</th>
              <th>Posted Date</th>
              <th>Update Date</th>
              <th>Nature</th>
              <th>Verified</th>
              <th>Status</th>
              <th>Ip</th>
              <th>Applicants</th>
              <th>Viewed by moderator</th>
              <th>View Job</th>
              <th>Post By</th>
              <th>Edit</th>
              <th><?php if($this->uri->segment(4) != "" && $this->uri->segment(4) == "archived"){echo "Delete";} else {echo "Delete";}?></th>
            </tr>
          </thead>
          <tbody>
          <?php
			$condition = array('jViewed' => 1);
			$jobs_list =  $this->admin_model->get_table_data_condition('dev_web_jobs',$condition);	
			foreach($jobs_list as $key => $valuecat):
				$condition = array('uID' => $valuecat->uID);
				$user = $this->admin_model->get_table_data_condition('dev_web_user',$condition);
				$condition2 = array('cID' => $valuecat->cID);
				$industry = $this->admin_model->get_table_data_condition('dev_web_categories',$condition2);
				// IP DEtAiLS
				$condition = array('ipAdd' => $valuecat->jJobIP);
				$ipban =  $this->admin_model->get_table_data_condition_countrce('dev_web_ip',$condition);
				$ipcount = $ipban->num_rows();
				$iprow = $ipban->result_object();
				
				$conditionagr = array('uID' => $valuecat->agtID);
				$useragt = $this->admin_model->get_table_data_condition('dev_web_user',$conditionagr);
				
			?>
            <tr>
              <?php /*?><td><input type="checkbox" value="<?php echo $valuecat->jID; ?>" class="checkbox1" name="chkuser[]" id="chkuser[]" /></td><?php */?>
              <td><?php echo $valuecat->jTitle; ?></td>
              <td><?php echo $valuecat->jURL; ?></td>
              <td><?php echo $user[0]->uFname; ?> <?php echo $user[0]->uLname; ?></td>
              <td><?php echo $industry[0]->catName; ?></td>
              <td><?php echo date("F, d Y",strtotime($valuecat->jPostedDate)); ?></td>
              <td><?php if($valuecat->jJobUpdated != ""){echo date("F, d Y h:i A",strtotime($valuecat->jJobUpdated));}else {echo "<strong style='color:#ccc'>Not Updated Yet</strong>";} ?></td>
              <td><?php echo $valuecat->jNature; ?></td>
              <td><?php if($valuecat->jJobStatus == '1'){?>
              <a onClick="deleteuser(<?php echo $valuecat->jID; ?>)" href="javascript:;">Spam? Remove Job</a>
              <?php } ?>
			</td>
              <td><?php if($valuecat->jJobStatus == '1'){echo 'Active';} else {echo 'In-Active';} ?></td>
              <td align="center">
			  <?php echo $valuecat->jJobIP; ?>
               <?php if($ipcount > 0){?>
              	<strong style="color:#f00;">IP Banned</strong> / <a href="<?php echo base_url(); ?>admin/unBanUserIP?uid=<?php echo $user[0]->uID; ?>&bId=<?php echo $iprow[0]->ipID;?>&rev=ip">Un-Ban IP</a>
              <?php }  else { ?>
			  <?php if($valuecat->jJobIP != ""){ ?> / <a href="<?php echo base_url(); ?>admin/banUserIPFull?uid=<?php echo $user[0]->uID; ?>&rev=ip">Ban IP</a><?php } ?>
              <?php } ?>
              </td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/manage/applicants/<?php echo $valuecat->jID; ?>"><i class="fa fa-th-large left coloredit"></i></a></td>
              <td align="center"><?php if($valuecat->jViewed == '1'){echo '<span style="color:#09f;">Viewed</span>';} else {echo '<span style="color:#f00;"><strong>Pending</strong></span>';} ?></td>
              <td align="center"><a href="<?php echo base_url(); ?>job/<?php echo $valuecat->jURL; ?>?view=moderator" target="_blank"><i class="fa fa-search left coloredit"></i></a></td>
              <td align="center"><?php if($valuecat->jPostedUser == '1'){echo 'Recruiter';} else {echo 'Agent ('.$useragt[0]->uFname.' '.$useragt[0]->uLname.')';} ?></td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/new-job?type=edit&jid=<?php echo $valuecat->jID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>
              <td align="center"><a onClick="deleteuser(<?php echo $valuecat->jID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
       </div>
      <?php } ?>
      
      <?php if(isset($_GET['type']) && $_GET['type'] == "jobsnotviewed"){?>
       <div class="dev-col-1 left colbg">
       <h1>Jobs Not Viewed By Moderator</h1>
   	   <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <?php /*?><th>&nbsp;</th><?php */?>
              <th>Job Title</th>
              <th>URL</th>
              <th>Company</th>
              <th>Industry</th>
              <th>Posted Date</th>
              <th>Update Date</th>
              <th>Nature</th>
              <th>Verified</th>
              <th>Status</th>
              <th>Ip</th>
              <th>Applicants</th>
              <th>Viewed by moderator</th>
              <th>View Job</th>
              <th>Post By</th>
              <th>Edit</th>
              <th><?php if($this->uri->segment(4) != "" && $this->uri->segment(4) == "archived"){echo "Delete";} else {echo "Delete";}?></th>
            </tr>
          </thead>
          <tbody>
          <?php
			$condition = array('jViewed' => 0);
			$jobs_list =  $this->admin_model->get_table_data_condition('dev_web_jobs',$condition);	
			foreach($jobs_list as $key => $valuecat):
				$condition = array('uID' => $valuecat->uID);
				$user = $this->admin_model->get_table_data_condition('dev_web_user',$condition);
				$condition2 = array('cID' => $valuecat->cID);
				$industry = $this->admin_model->get_table_data_condition('dev_web_categories',$condition2);
				// IP DEtAiLS
				$condition = array('ipAdd' => $valuecat->jJobIP);
				$ipban =  $this->admin_model->get_table_data_condition_countrce('dev_web_ip',$condition);
				$ipcount = $ipban->num_rows();
				$iprow = $ipban->result_object();
			?>
            <tr>
              <?php /*?><td><input type="checkbox" value="<?php echo $valuecat->jID; ?>" class="checkbox1" name="chkuser[]" id="chkuser[]" /></td><?php */?>
              <td><?php echo $valuecat->jTitle; ?></td>
              <td><?php echo $valuecat->jURL; ?></td>
              <td><?php echo $user[0]->uFname; ?> <?php echo $user[0]->uLname; ?></td>
              <td><?php echo $industry[0]->catName; ?></td>
              <td><?php echo date("F, d Y",strtotime($valuecat->jPostedDate)); ?></td>
              <td><?php if($valuecat->jJobUpdated != ""){echo date("F, d Y h:i A",strtotime($valuecat->jJobUpdated));}else {echo "<strong style='color:#ccc'>Not Updated Yet</strong>";} ?></td>
              <td><?php echo $valuecat->jNature; ?></td>
              <td><?php if($valuecat->jJobStatus == '1'){?>
              <a onClick="deleteuser(<?php echo $valuecat->jID; ?>)" href="javascript:;">Spam? Remove Job</a>
              <?php } ?>
			</td>
              <td><?php if($valuecat->jJobStatus == '1'){echo 'Active';} else {echo 'In-Active';} ?></td>
              <td align="center">
			  <?php echo $valuecat->jJobIP; ?>
               <?php if($ipcount > 0){?>
              	<strong style="color:#f00;">IP Banned</strong> / <a href="<?php echo base_url(); ?>admin/unBanUserIP?uid=<?php echo $user[0]->uID; ?>&bId=<?php echo $iprow[0]->ipID;?>&rev=ip">Un-Ban IP</a>
              <?php }  else { ?>
			  <?php if($valuecat->jJobIP != ""){ ?> / <a href="<?php echo base_url(); ?>admin/banUserIPFull?uid=<?php echo $user[0]->uID; ?>&rev=ip">Ban IP</a><?php } ?>
              <?php } ?>
              </td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/manage/applicants/<?php echo $valuecat->jID; ?>"><i class="fa fa-th-large left coloredit"></i></a></td>
              <td align="center"><?php if($valuecat->jViewed == '1'){echo '<span style="color:#09f;">Viewed</span>';} else {echo '<span style="color:#f00;"><strong>Pending</strong></span>';} ?></td>
              <td align="center"><a href="<?php echo base_url(); ?>job/<?php echo $valuecat->jURL; ?>?view=moderator" target="_blank"><i class="fa fa-search left coloredit"></i></a></td>
              <td align="center"><?php if($valuecat->jPostedUser == '1'){echo 'Recruiter';} else {echo 'Agent';} ?></td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/new-job?type=edit&jid=<?php echo $valuecat->jID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>
              <td align="center"><a onClick="deleteuser(<?php echo $valuecat->jID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
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
		var x = confirm("Are you sure you want to permanently delete this job?");
	  	if (x){
			window.location='<?php echo base_url(); ?>backend/manage/jobs?type=delete&jid='+id;
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
