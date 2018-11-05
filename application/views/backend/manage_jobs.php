<?php error_reporting(0);require_once("common/header.php"); ?>
<script language="javascript" type="application/javascript">
	function archiveduser(id)
	{
		var x = confirm("Are you sure you want to Archive this job?");
	  	if (x){
			window.location='<?php echo base_url(); ?>backend/manage/jobs?type=archived&jid='+id;
			return true;
		}
		else {
			return false;
		}
	}
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
	function get_cat_list(cid){
		if(cid == 0)
		{
			window.location='<?php echo base_url(); ?>backend/categories';
		}
		else
		{
			window.location='<?php echo base_url(); ?>backend/categories?parent='+cid;
		}
	}
	function makeActions(action,name)
	{
	  	if (action != 0){
			if(name == 'company'){
				var formaction = '<?php echo base_url(); ?>backend/manage/jobs?type=action&filter=company&id='+action;
			}
			else if(name == 'industry'){
				var formaction = '<?php echo base_url(); ?>backend/manage/jobs?type=action&filter=industry&id='+action;
			}
			else if(name == 'nature'){
				var formaction = '<?php echo base_url(); ?>backend/manage/jobs?type=action&filter=nature&id='+action;
			}
			else if(name == 'experience'){
				var formaction = '<?php echo base_url(); ?>backend/manage/jobs?type=action&filter=experience&id='+action;
			}
			window.location.href = formaction;
			return true;
		  }
		  else {
			var formaction = '<?php echo base_url(); ?>backend/manage/jobs';
			window.location.href = formaction;
			return true;
		  }
	}
</script>
    <div class="fullcontent right clear">

        <a href="<?php echo base_url(); ?>backend/new-job"><div class="right"><button class="btn btn-lg btn-orange right" id="buttonadd">Add New Job</button></div></a>
      <?php if($this->uri->segment(4) == ""){ ?>
        <?php /*?><div class="left subaction">
         <span style="left">Company: </span>
        <select name="actions" id="actions" class="fastselect" onChange="makeActions(this.value,'company')">
        <option value="0">Choose Company</option>
        <?php 
			$condition2 = array('uActType' => 2);
			$user = $this->admin_model->get_table_data_condition('dev_web_user',$condition2);
			foreach($user as $log):
		?>
                    <option value="<?php echo $log->uID;?>" <?php if($_GET['filter'] == 'company' && $_GET['id'] == $log->uID){echo "Selected";}?>><?php echo $log->uFname.' '.$log->uLname;?></option>
         <?php endforeach;?>
          </select>
      </div><?php */?>
     	<div class="left subaction">
          <span style="left"> Indutry: </span>
        <select name="actions" id="actions" class="fastselect" onChange="makeActions(this.value,'industry')">
         <option value="0">Choose Industry</option>
        <?php 
			$cat = $this->admin_model->get_table_data('dev_web_categories');
			foreach($cat as $category):
		?>
            <option value="<?php echo $category->cID;?>" <?php if($_GET['filter']  == 'industry' &&  $_GET['id'] == $category->cID){echo "Selected";}?>><?php echo $category->catName;?></option>
         <?php endforeach;?>
          </select>
      </div>
      	<div class="left subaction">
          <span style="left"> Job Nature: </span>
        <select name="actions" id="actions" class="fastselect" onChange="makeActions(this.value,'nature')">
                       <option value="0">--- Select Job Type ---</option>
                       <option value="Full-Time" <?php if($_GET['filter']  == 'nature' &&  $_GET['id'] == "Full-Time"){echo "Selected";}?>>Full-Time</option>
                       <option value="Internship" <?php if($_GET['filter']  == 'nature' &&  $_GET['id'] == "Internship"){echo "Selected";}?>>Internship</option>
                       <option value="Part-Time" <?php if($_GET['filter']  == 'nature' &&  $_GET['id'] == "Part-Time"){echo "Selected";}?>>Part-Time</option>
                       <option value="Per Diem" <?php if($_GET['filter']  == 'nature' &&  $_GET['id'] == "Per Diem"){echo "Selected";}?>>Per Diem</option>
                       <option value="Seasonal" <?php if($_GET['filter']  == 'nature' &&  $_GET['id'] == "Seasonal"){echo "Selected";}?>>Seasonal</option>
                       <option value="Temporary/Contract" <?php if($_GET['filter']  == 'nature' &&  $_GET['id'] == "Temporary/Contract"){echo "Selected";}?>>Temporary/Contract</option>
                       <option value="Volunteer" <?php if($_GET['filter']  == 'nature' &&  $_GET['id'] == "Volunteer"){echo "Selected";}?>>Volunteer</option>
                       <option value="Work Study" <?php if($_GET['filter']  == 'nature' &&  $_GET['id'] == "Work Study"){echo "Selected";}?>>Work Study</option>
          </select>
      </div>
      	<div class="left subaction">
          <span style="left"> Experience: </span>
        <select name="actions" id="actions" class="fastselect" onChange="makeActions(this.value,'experience')">
                       <option value="0">--- Select Experience ---</option>
                       	<option value="-2" <?php if($_GET['filter']  == 'experience' && $_GET['id'] == '-2'){echo "SELECTED";}?>>Student</option>
                        <option value="-1" <?php if($_GET['filter']  == 'experience' && $_GET['id'] == '-1'){echo "SELECTED";}?>>Fresh Graduate</option>
                        <?php for($i=0;$i<=25;$i++): ?>
                        <option value="<?php echo $i;?>" <?php if($_GET['filter'] == 'experience' && $i == $_GET['id']){echo "SELECTED";}?>><?php if($i == 0){echo '< 1';}else {echo $i;}?></option>
                        <?php endfor; ?>
						<option value="26">&gt; 25 Years</option>
          </select>
      </div>
      <?php } ?>
      	<div class="dev-col-1 colbg clear">
        <h1>Manage <?php if($this->uri->segment(4) != "" && $this->uri->segment(4) == "archived"){echo "Archived";}?> Jobs</h1>
        <form name="actionsds" id="actionsds" method="post" action="">
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
              <td align="center"><a onClick="<?php if($valuecat->jArchived == '1'){?>deleteuser(<?php echo $valuecat->jID; ?>)<?php } else {?>archiveduser(<?php echo $valuecat->jID; ?>)<?php } ?>" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
</form>
         <?php /*?><div class="actns">
            Choose Action: 
    <select name="actions" id="actions" onChange="makeActions(this.value)">
                    <option value="">Choose Action</option>
                    <option value="1">Delete Selected</option>
                    <option value="2">Active Selected</option>
                    <option value="3">InActive Selected</option>
          </select>
            
            </div><?php */?>
      </div>
    </div>
    <?php require_once("common/footer.php"); ?>