<?php require_once("common/header.php"); ?>
<script language="javascript" type="application/javascript">
	function deletewebsitedata(bid)
	{
		var x = confirm("Are you sure you want to do remove this IP Address?");
	  	if (x){
			window.location='<?php echo base_url(); ?>admin/unBanUserIP?type=banned&bId='+bid;
			return true;
		}
		else {
			return false;
		}
	}
</script>
    <div class="fullcontent right clear">
      
      <div class="dev-col-1 colbg clear">
        <h1>Banned IP's</h1>
        <form name="actionsds" id="actionsds" method="post" action="">
        <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>Banned IP Address</th>
              <th>Un-Ban IP</th>
            </tr>
          </thead>
          <tbody>
          <?php
			foreach($alldata as $key => $valuecat):
				//$web = $this->admin_model->get_specific_user($valuecat['uID']);
			?>
            <tr >
              <td ><?php echo $valuecat['ipAdd']; ?></td>
              <td align="center"><a onClick="deletewebsitedata(<?php echo $valuecat['ipID']; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
    </form>
         
      </div>
    </div>
    <?php require_once("common/footer.php"); ?>