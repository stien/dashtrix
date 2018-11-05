<?php require_once("common/header.php"); ?>
    <script language="javascript" type="application/javascript">
function deleteuser(id)
{
	var x = confirm("Are you sure you want to delete this Department?");
	if (x){
		window.location='<?php echo base_url(); ?>backend/manage/benefits?type=delete&bid='+id;
		return true;
	}
	else {
		return false;
	}
}
</script>
    <div class="fullcontent right clear"> <a href="<?php echo base_url(); ?>backend/new-benefits">
      <div class="right">
        <button class="btn btn-lg btn-orange right" id="buttonadd">Add New Benefit</button>
      </div>
      </a>
      <div class="left subaction">
      </div>
      
       
      <div class="dev-col-1 colbg clear">
        <h1>Manage Benefits</h1>
       
          <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
            <thead>
              <tr>
                <th>Department Name</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
			foreach($department as $key => $valuecat):
			?>
              <tr>
                <td><?php echo $valuecat->bName; ?></td>
                <td><?php if($valuecat->bStatus == '1'){echo 'Active';} else {echo 'In-Active';} ?></td>
                <td align="center"><a href="<?php echo base_url(); ?>backend/new-benefits?type=edit&bid=<?php echo $valuecat->bID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>
                <td align="center"><a onClick="deleteuser(<?php echo $valuecat->bID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </form>
      </div>
    </div>
    <?php require_once("common/footer.php"); ?>