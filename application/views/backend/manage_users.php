<?php require_once("common/header.php"); ?>
<script language="javascript" type="application/javascript">
	function gotourl(id)
	{
		window.location='<?php echo base_url(); ?>backend/user/details/'+id;
	}
	function deleteuser(id)
	{
		var x = confirm("Are you sure you want to delete this user?");
	  	if (x){
			window.location='<?php echo base_url(); ?>backend/manage/users?type=delete&uid='+id;
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
	function makeActions(action)
	{
		var x = confirm("Are you sure you want to do this action?");
	  	if (x){
			var formaction = '<?php echo base_url(); ?>backend/users/actions?action='+action;
			$('#actionsds').attr('action', formaction);
			$("#actionsds").submit();
			return true;
		  }
		  else {
			return false;
		  }
	}
</script>
     <?php if($this->uri->segment(3) == "jobseeker"){?>
    <div class="fullcontent right clear">
    <div class="dev-col-1 colbg clear left">
    	<h1>Filters</h1>
        
        <a href="<?php echo base_url(); ?>admin/download_csv"><div class="left"><button class="btn btn-lg btn-green left" style="  background-color: #2C3439;" id="buttonadd">DOWNLOAD CSV</button></div></a>
        
         <a href="<?php echo base_url(); ?>admin/filter_jobseekers?type=verified"><div class="right"><button class="btn btn-lg btn-green right" id="buttonadd">EMAIL VERIFIED JOBSEKKERS</button></div></a>
          <a href="<?php echo base_url(); ?>admin/filter_jobseekers?type=resume"><div class="right"><button style="margin-right:10px;" class="btn btn-lg btn-orange right" id="buttonadd">RESUME UPLOADED JOBSEEKERS</button></div></a>
          <a href="<?php echo base_url(); ?>admin/filter_jobseekers?type=profile"><div class="right">
          	<button class="btn btn-lg btn-green right" id="buttonadd" style="margin-right:10px;">PROFILE COMPLETED</button>
            </div></a>
    </div>
    </div>
	<?php } ?>
    <div class="fullcontent right clear">
      <div class="left subaction" style="margin-top:10px;">
          <span style="  margin-top: 12px;
  float: left;"> Keyword Search: </span>
          <form action="" method="get" style="float:right; margin-left:5px;" onSubmit="return checklength()">
        	<input type="text" value="<?php if(isset($_GET['searchbox'])){echo $_GET['searchbox'];}?>" style="padding:10px;" name="searchbox" id="searchbox" placeholder="Keyword">
            	<button type="submit" value="Search" class="btn btn-lg btn-orange right" style="margin:0;" >Search</button>
          </form>
      </div>
        <a href="<?php echo base_url(); ?>backend/add/user"><div class="right"><button class="btn btn-lg btn-orange right" id="buttonadd">Add New User</button></div></a>
      <div class="dev-col-1 colbg clear">
        <h1>Manage <?php if($this->uri->segment(3) == "employer"){echo "Recruiter";} else if($this->uri->segment(3) == "jobseeker"){echo "Jobseekers";} else {echo 'users';}?></h1>
        <div class="pagination clear left" style="float:left;    width: 71%;"><?php echo $links; ?></div>
        <div class="actns" style="width: 20%; margin-left:0; float:right; margin-bottom:5px; clear:none !important;">
    <select name="actions" id="actions" class="fastselect" onChange="makeActions(this.value)">
                    <option value="">--- Choose Action ---</option>
                    <option value="1">Delete Selected</option>
                    <option value="2">Active Selected</option>
                    <option value="3">InActive Selected</option>
          </select>
            
            </div>
        <form name="actionsds" id="actionsds" method="post" action="">
        <table width="100%" class="hover tableuser" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>&nbsp;</th>
              <th>Full Name</th>
              <th>Email Address</th>
              <th>Country</th>
              <?php if($this->uri->segment(3) == "employer"){?>
              <th>Jobs</th>
              <?php } ?>
              <th>Type</th>
              <th>Join Date</th>
              <th>Last Login</th>
              <th>Account</th>
              <th>Resume</th>
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
			foreach($user_list as $key => $valuecat):
			// IP DEtAiLS
				$condition = array('uID' => $valuecat->uID);
				$ipban =  $this->admin_model->get_table_data_condition_countrce('dev_web_ip',$condition);
				$ipcount = $ipban->num_rows();
				$iprow = $ipban->result_object();
				// RESUME CHCK
				$conditioncv = array('uID' => $valuecat->uID);
				$cv =  $this->admin_model->get_table_data_condition_countrce('dev_web_cv',$conditioncv);
				$cvcount = $cv->num_rows();
				if($this->uri->segment(3) == "employer"){
					$conjobs = array('uID' => $valuecat->uID);
					$cvjbs =  $this->admin_model->get_table_data_condition_countrce('dev_web_jobs',$conjobs);
					$jbcount = $cvjbs->num_rows();
				}
			?>
            <tr>
              <td><input type="checkbox" value="<?php echo $valuecat->uID; ?>" class="checkbox1" name="chkuser[]" id="chkuser[]" /></td>
              <td><?php echo $valuecat->uCompany; ?></td>
              <td><?php echo $valuecat->uEmail; ?> <i class="fa fa-check-circle-o " style="color:<?php if($valuecat->uverifyemail == '1'){echo '#093';}else {echo '#f00';}?>;"></i></td>
              <td><?php echo $valuecat->uCountry; ?></td>
              <?php if($this->uri->segment(3) == "employer"){?>
              <th><?php echo $jbcount;?></th>
              <?php } ?>
              <td><?php if($valuecat->uActType == 1){echo "Jobseeker";} else {echo "<strong style='color:#f00;'>Recruiter</strong>";} ?></td>
              <td><?php echo date("F, d Y",strtotime($valuecat->joinDate)); ?></td>
              <td><?php if($valuecat->uLoginLast != ""){echo date("F, d Y h:i A",strtotime($valuecat->uLoginLast));}else {echo "<strong style='color:#ccc'>Not Loggedin Yet</strong>";} ?></td>
              <td><?php if($valuecat->usocial == ""){echo "<strong style=' color:#6AAD43;'>NORMAL</strong>";} else {echo '<span style="color:#f00; font-weight:bold;"'.$valuecat->usocial.'</span>';} ?></td>
              <td><?php if($cvcount > 0){echo 'Uploaded';} else {echo '<strong style="color:#f00;">Not Uploaded</strong>';} ?></td>
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
        <div class="pagination clear right"><?php echo $links; ?></div>
</form>
         <div class="actns" style="width: 20%; margin-left:0">
    <select name="actions" id="actions" class="fastselect" onChange="makeActions(this.value)">
                    <option value="">--- Choose Action ---</option>
                    <option value="1">Delete Selected</option>
                    <option value="2">Active Selected</option>
                    <option value="3">InActive Selected</option>
          </select>
            
            </div>
      </div>
    </div>
    <?php require_once("common/footer.php"); ?>
	<style>
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
  text-decoration:none;
}
.pagination a.current {
  border: none!important;
  background: #2f3237!important;
  color: #fff!important;
  box-shadow: inset 0 0 8px rgba(0,0,0,.5),0 1px 0 rgba(255,255,255,.1)!important;
}
.pagination{    clear: both;
    float: right;
    display: block;
    margin-top: 20px;
    font-size: 12px;}
.tableuser {}
.tableuser td {    padding: 10px;
    border-right: 1px solid #e1e1e1;
    border-bottom: 1px solid #e1e1e1;
    font-size: 11px;
    color: #777;}
	.tableuser tr:hover { background:#FF9;}
.tableuser th {font-weight: bold;
    text-align: left;
    background-color: #f0f0f0 !important;
    color: #333;
    text-transform: uppercase;
	border-bottom: 1px solid #e1e1e1;
    padding: 9px;
    border-right: 1px solid #e1e1e1;}
	</style>
    <script language="javascript">
	function checklength(){
		if($("#searchbox").val().length < 3){
			alert("Minimum 3 characters needed for search");
			return false;
		}
	}
	</script>