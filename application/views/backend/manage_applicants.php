<?php require_once("common/header.php"); ?>
<script language="javascript" type="application/javascript">
function deleteuser(id)
{
	var x = confirm("Are you sure you want to delete this Applicant?");
	if (x){
		window.location='<?php echo base_url(); ?>backend/manage/applicants/<?php echo $this->uri->segment(4);?>?type=delete&aid='+id;
		return true;
	}
	else {
		return false;
	}
}
</script>
    <div class="fullcontent right clear"> <a href="<?php echo base_url(); ?>backend/manage/jobs">
      <div class="right">
        <button class="btn btn-lg btn-orange right" id="buttonadd">Manage Jobs</button>
      </div>
      </a>
      <div class="dev-col-1 colbg clear">
        <h1>Applicants Applied For -::- <?php echo $job[0]->jTitle;?></h1>
       
          <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
            <thead>
              <tr>
                <th>Applicant Name</th>
                <th>CV</th>
                <th>Status</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
			foreach($applied as $key => $valuecat):
			$condition2 = array('uID' => $valuecat->uID);
			$user = $this->admin_model->get_table_data_condition('dev_web_user',$condition2);
			$conditionc = array('cvID' => $valuecat->cvID);
			$cvw = $this->admin_model->get_table_data_condition('dev_web_cv',$conditionc);
			
			?>
              <tr>
                <td><?php echo $user[0]->uFname.' '.$user[0]->uLname; ?></td>
                <td><?php if(count($cvw)>0){$ext = pathinfo($cvw[0]->cvFile, PATHINFO_EXTENSION);?> 
                	<a href="<?php echo base_url(); ?>resources/uploads/cvs/<?php echo $cvw[0]->cvFile;?>">
                    	<i class="fa <?php if($ext == "pdf"){echo 'fa-file-pdf-o';}else {echo 'fa-file-word-o';}?> coloredit"></i><?php }?>
                    </a>
                </td>
                <td><?php if($valuecat->aStatus == '0'){echo 'Applied';} else if($valuecat->aStatus == '1'){echo '<strong style="color:#008000;">Shortlisted</strong>';} else if($valuecat->aStatus == '2'){echo '<strong style="color:#f00;">Rejected</strong>';} ?></td>
                <td align="center"><a onClick="deleteuser(<?php echo $valuecat->aID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </form>
      </div>
    </div>
    <?php require_once("common/footer.php"); ?>