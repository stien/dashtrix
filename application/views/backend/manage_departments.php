<?php require_once("common/header.php"); ?>
    <script language="javascript" type="application/javascript">
function deleteuser(id)
{
	var x = confirm("Are you sure you want to delete this Department?");
	if (x){
		window.location='<?php echo base_url(); ?>backend/manage/department?type=delete&did='+id;
		return true;
	}
	else {
		return false;
	}
}
function makeActions(action)
	{
	  	if (action != 0){
			var formaction = '<?php echo base_url(); ?>backend/manage/department?type=action&id='+action;
			window.location.href = formaction;
			return true;
		  }
		  else {
			var formaction = '<?php echo base_url(); ?>backend/manage/department';
			window.location.href = formaction;
			return true;
		  }
	}
</script>
    <div class="fullcontent right clear"> <a href="<?php echo base_url(); ?>backend/new-department">
      <div class="right">
        <button class="btn btn-lg btn-orange right" id="buttonadd">Add New Department</button>
      </div>
      </a>
      <div class="left subaction">
            Choose Company: 
        <select name="actions" id="actions" class="fastselect" onChange="makeActions(this.value)">
        <option value="0">Choose Company</option>
        <?php 
			$condition2 = array('uActType' => 2);
			$user = $this->admin_model->get_table_data_condition('dev_web_user',$condition2);
			foreach($user as $log):
		?>
           <option value="<?php echo $log->uID;?>" <?php if(isset($_GET['id']) == $log->uID){echo "Selected";}?>><?php echo $log->uFname.' '.$log->uLname;?></option>
         <?php endforeach;?>
          </select>
      </div>
      
       
      <div class="dev-col-1 colbg clear">
        <h1>Manage Departments</h1>
       
          <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
            <thead>
              <tr>
                <th>Company</th>
                <th>Department Name</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
			foreach($department as $key => $valuecat):
			$condition2 = array('uID' => $valuecat->uID);
			$user = $this->admin_model->get_table_data_condition('dev_web_user',$condition2);
			?>
              <tr>
                <td><?php if($valuecat->uID == 0){echo "<strong style='color:#f00;'>Default</strong>";} else {echo $user[0]->uFname.' '.$user[0]->uLname;} ?></td>
                <td><?php echo $valuecat->dName; ?></td>
                <td><?php if($valuecat->dStatus == '1'){echo 'Active';} else {echo 'In-Active';} ?></td>
                <td align="center"><a href="<?php echo base_url(); ?>backend/new-department?type=edit&did=<?php echo $valuecat->dID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>
                <td align="center"><a onClick="deleteuser(<?php echo $valuecat->dID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </form>
      </div>
    </div>
    <?php require_once("common/footer.php"); ?>