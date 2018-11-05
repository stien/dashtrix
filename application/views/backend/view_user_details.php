<?php require_once("common/header.php");?>
<script language="javascript" type="application/javascript">
function deleteuser(id)
{
	var x = confirm("Are you sure you want to delete Cv?");
	if (x){
		window.location='<?php echo base_url(); ?>backend/user/details/<?php echo $this->uri->segment(4);?>?type=delete&aid='+id;
		return true;
	}
	else {
		return false;
	}
}
function deleteappliedjob(id)
{
	var x = confirm("Are you sure you want to delete this application?");
	if (x){
		window.location='<?php echo base_url(); ?>backend/user/details/<?php echo $this->uri->segment(4);?>?type=applieddelte&aid='+id;
		return true;
	}
	else {
		return false;
	}
}
function deletesavedjob(id)
{
	var x = confirm("Are you sure you want to delete this saved job?");
	if (x){
		window.location='<?php echo base_url(); ?>backend/user/details/<?php echo $this->uri->segment(4);?>?type=saveddelte&aid='+id;
		return true;
	}
	else {
		return false;
	}
}
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
</script>
<div class="fullcontent right clear">
<div class="left">
		<a href="<?php echo base_url(); ?>backend/user/details/<?php echo $user_detail[0]->uID;?>" class="left" style="margin-right:5px;">
        	<button class="btn btn-lg btn-orange right <?php if(!isset($_GET['link'])){echo 'activebtns';}?>" id="buttonadd" >User Detail</button>
    	</a>
	<?php if($user_detail[0]->uActType == 2){?>
	   	<a href="<?php echo base_url(); ?>backend/user/details/<?php echo $user_detail[0]->uID;?>?link=postedjobs">
        	<button class="btn btn-lg btn-orange right <?php if(isset($_GET['link'])  && $_GET['link'] == 'postedjobs'){echo 'activebtns';}?>" id="buttonadd" >Posted Jobs</button>
    	</a>
    <?php } else { ?>
    	<a href="<?php echo base_url(); ?>backend/user/details/<?php echo $user_detail[0]->uID;?>?link=applied" class="left" style="margin-right:5px;">
        	<button class="btn btn-lg btn-orange right <?php if(isset($_GET['link'])  && $_GET['link'] == 'applied'){echo 'activebtns';}?>" id="buttonadd" >Applied Jobs</button>
    	</a>
        <a href="<?php echo base_url(); ?>backend/user/details/<?php echo $user_detail[0]->uID;?>?link=cvs" class="left"  style="margin-right:5px;">
        	<button class="btn btn-lg btn-orange right <?php if(isset($_GET['link']) && $_GET['link'] == 'cvs'){echo 'activebtns';}?>" id="buttonadd" >User CV's</button>
    	</a>
        <a href="<?php echo base_url(); ?>backend/user/details/<?php echo $user_detail[0]->uID;?>?link=saved">
        	<button class="btn btn-lg btn-orange right <?php if(isset($_GET['link']) && $_GET['link'] == 'saved'){echo 'activebtns';}?>" id="buttonadd">Saved Jobs</button>
    	</a>
    <?php } ?>
</div>
</div>
<?php if(!isset($_REQUEST['link'])){ ?>
 <div class="fullcontent right clear">
 	<div class="dev-col-1 colbg">
        <h1>User Details - : : - <?php echo $user_detail[0]->uFname.' '.$user_detail[0]->uLname;?></h1>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="detailspage">
         <?php 
		 	foreach($user_detail as $row):
			$condition = array('cID' => $row->cID);
			$industry = $this->admin_model->get_table_data_condition('dev_web_categories',$condition);
		 ?>
            <tr>
              <th>Full Name</th>
              <td align="left"><?php echo $row->uFname.' '.$row->uLname; ?></td>
            </tr>
            <tr>
              <th>Email Address</th>
              <td align="left"><?php echo $row->uEmail; ?></td>
            </tr>
            <tr>
              <th>Username</th>
              <td align="left"><?php echo $row->uUsername; ?></td>
            </tr>
            <?php if($row->uActType == 2){?>
            <tr>
              <th>Industry</th>
              <td align="left"><?php echo $industry[0]->catName; ?></td>
            </tr> 
            <tr>
              <th>Established In</th>
              <td align="left"><?php echo date("F, d Y",strtotime($row->uEstablished)); ?></td>
            </tr>
            <tr>
              <th>No of Employees</th>
              <td align="left"><strong><?php echo $row->uNoEmp; ?></strong> Employees</td>
            </tr>
            <tr>
              <th>Adress</th>
              <td align="left"><?php echo $row->uAddress; ?></td>
            </tr>
            <tr>
              <th>Website URL</th>
              <td align="left"><a href="<?php echo addhttp($row->uWebsite);?>" target="_blank" style="color:#36F; font-weight:bold; text-decoration:none;"><?php echo $row->uWebsite; ?></a></td>
            </tr>
            <tr>
              <th>About Company</th>
              <td align="left"><?php echo $row->uAbout; ?></td>
            </tr>
            <?php } ?>
            
            <tr>
              <th>Gender</th>
              <td align="left"><?php echo $row->uGender; ?></td>
            </tr>
            <tr>
              <th>Phone</th>
              <td align="left"><?php echo $row->uPhone; ?></td>
            </tr>
            <tr>
              <th>Country</th>
              <td align="left"><?php echo $row->uCountry; ?></td>
            </tr>
            <tr>
              <th>Account Type</th>
              <td align="left"><?php if($row->uActType == 1){echo "Jobseeker";} else {echo "<strong style='color:#f00'>Employer</strong>";} ?></td>
            </tr>
            <tr>
              <th>User Status</th>
              <td align="left"><?php if($row->uStatus == '1'){echo 'Active';} else {echo '<span style="color:#096"><strong>In-Active</strong></span>';} ?></td>
            </tr>
 			<tr>
              	<th>Join Date</th>
              	<td align="left"><?php echo date("l, F d, Y",strtotime($row->joinDate)); ?></td>
            </tr>
            
             <tr>
              <th style="height:71px;">Logo/Profile Picture</th>
              <td align="left">
              	<?php if($row->uImage != ""){ ?>
                	<img src="<?php echo base_url(); ?>resources/uploads/profile/<?php echo $row->uImage; ?>" alt="Image" width="100px">
                <?php } else { ?>
                	<img src="<?php echo base_url(); ?>resources/uploads/profile/img_not_available.png" alt="No Image" width="100px">
                <?php } ?>
              </td>
            </tr>
            
            </tr>
        <?php endforeach; ?>
        </table>
      </div>
 </div>
 <?php } ?>
<?php if($user_detail[0]->uActType == 1){?>
<?php if(isset($_REQUEST['link']) && $_REQUEST['link'] == "cvs"){ ?>
<div class="fullcontent right clear">
 	<div class="dev-col-1 colbg">
        <h1>User CV's</h1>
       
        <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
            <thead>
              <tr>
                <th>Title</th>
                <th>CV</th>
                <th>Status</th>
                <th>Uplodaed Date</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
            <?php
			foreach($cv as $key => $valuecat):	
			?>
              <tr>
                <td><?php echo $valuecat->cvTitle; ?></td>
                <td><?php if(count($cv)>0){$ext = pathinfo($valuecat->cvFile, PATHINFO_EXTENSION);?> 
                	<a href="<?php echo base_url(); ?>resources/uploads/cvs/<?php echo $valuecat->cvFile;?>">
                    	<i class="fa <?php if($ext == "pdf"){echo 'fa-file-pdf-o';}else {echo 'fa-file-word-o';}?> coloredit"></i><?php }?>
                    </a>
                </td>
                <td><?php if($valuecat->cvStatus == '1'){echo 'Active';} else {echo '<strong style="color:#f00;">In-Active</strong>';} ?></td>
                <td><?php echo date("F, d Y, h:i:s",strtotime($valuecat->cvPosted)); ?></td>
                <td align="center"><a onClick="deleteuser(<?php echo $valuecat->cvID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
      </div>
 </div>
<?php }?>
<?php if(isset($_REQUEST['link']) && $_REQUEST['link'] == "applied"){ ?>
<div class="fullcontent right clear">
 	<div class="dev-col-1 colbg">
        <h1>Jobs Applied</h1>
       
        <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
            <thead>
              <tr>
                <th>Job Title</th>
                <th>CV Title</th>
                <th>CV</th>
                <th>Status</th>
                <th>Applied Date</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
            <?php
			foreach($applied as $key => $valuecat):	
				$condition = array('jID' => $valuecat->jID);
				$job = $this->admin_model->get_table_data_condition('dev_web_jobs',$condition);
				$condition = array('cvID' => $valuecat->cvID);
				$cv = $this->admin_model->get_table_data_condition('dev_web_cv',$condition);
			?>
              <tr>
                <td><?php echo $job[0]->jTitle; ?></td>
                <td><?php echo $cv[0]->cvTitle; ?></td>
                <td><?php if(count($cv)>0){$ext = pathinfo($cv[0]->cvFile, PATHINFO_EXTENSION);?> 
                	<a href="<?php echo base_url(); ?>resources/uploads/cvs/<?php echo $cv[0]->cvFile;?>">
                    	<i class="fa <?php if($ext == "pdf"){echo 'fa-file-pdf-o';}else {echo 'fa-file-word-o';}?> coloredit"></i><?php }?>
                    </a>
                </td>
                <td><?php if($valuecat->aStatus == '1'){echo '<strong style="color:#008000;">Shortlisted</strong>';} else if($valuecat->aStatus == '2'){echo '<strong style="color:#f00;">Rejected</strong>';} else {echo 'Applied';} ?></td>
                <td><?php echo date("F, d Y, h:i:s",strtotime($valuecat->appliedDate)); ?></td>
                <td align="center"><a onClick="deleteappliedjob(<?php echo $valuecat->aID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
      </div>
 </div>
<?php } ?>
<?php if(isset($_REQUEST['link']) && $_REQUEST['link'] == "saved"){ ?>
<div class="fullcontent right clear">
 	<div class="dev-col-1 colbg">
        <h1>User Saved Jobs</h1>
       
        <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
            <thead>
              <tr>
                <th>Job Title</th>
                <th>Saved Date</th>
                <th>Delete Saved</th>
              </tr>
            </thead>
            <tbody>
            <?php
			foreach($saved as $key => $valuecat):	
				$condition = array('jID' => $valuecat->jID);
				$job = $this->admin_model->get_table_data_condition('dev_web_jobs',$condition);
			?>
              <tr>
                <td><?php echo $job[0]->jTitle; ?></td>
                <td><?php echo date("F, d Y",strtotime($valuecat->sDate)); ?></td>
                <td align="center"><a onClick="deletesavedjob(<?php echo $valuecat->sID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
      </div>
 </div>
<?php } ?>
<?php } ?>
<?php if($user_detail[0]->uActType == 2){ ?>
<?php if(isset($_REQUEST['link']) && $_REQUEST['link'] == "postedjobs"){ ?>
<div class="fullcontent right clear">
 	<div class="dev-col-1 colbg">
        <h1>Company Posted Jobs</h1>
       
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
              <th>Status</th>
              <th>Applicants</th>
              <th>Details</th>
              <th>Edit</th>
              <th><?php if($this->uri->segment(4) != "" && $this->uri->segment(4) == "archived"){echo "Delete";} else {echo "Archive";}?></th>
            </tr>
          </thead>
            <tbody>
          <?php
			foreach($jobs as $key => $valuecat):
				$condition = array('uID' => $valuecat->uID);
				$user = $this->admin_model->get_table_data_condition('dev_web_user',$condition);
				$condition2 = array('cID' => $valuecat->cID);
				$industry = $this->admin_model->get_table_data_condition('dev_web_categories',$condition2);
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
              <td><?php if($valuecat->jJobStatus == '1'){echo 'Active';} else {echo 'In-Active';} ?></td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/manage/applicants/<?php echo $valuecat->jID; ?>"><i class="fa fa-th-large left coloredit"></i></a></td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/job/details/<?php echo $valuecat->jID; ?>"><i class="fa fa-th-large left coloredit"></i></a></td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/new-job?type=edit&jid=<?php echo $valuecat->jID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>
              <td align="center"><?php if($valuecat->jArchived == '1'){?><strong style="color:#f00;">Archied</strong><?php } else {?><a onClick="<?php if($valuecat->jArchived == '1'){?><?php } else {?>archiveduser(<?php echo $valuecat->jID; ?>)<?php } ?>" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a><?php } ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
          </table>
      </div>
 </div>
<?php }} ?>
<?php require_once("common/footer.php"); ?>