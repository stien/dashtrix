<?php require_once("common/header.php"); ?>
<script language="javascript" type="application/javascript">
	function gotourl(id)
	{
		window.location='<?php echo base_url(); ?>index.php/backend/detail/page/'+id;
	}
</script>
    <div class="fullcontent right clear">
     <div class="dev-col-1 colbg">
        <h1>Manage Pages</h1>
        <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>Heading</th>
              <th>Link</th>
              <th>Status</th>
              <th>View Details</th>
              <th>Edit</th>
              </tr>
          </thead>
          <tbody>
          <?php
			foreach($showallpages as $key => $valuecat):
			?>
            <tr>
              <td><?php echo $valuecat->pHeading; ?></td>
              <td><?php echo $valuecat->pLink; ?></td>
              <td><?php if($valuecat->pStatus == '1'){echo 'Active';} else {echo 'In-Active';} ?></td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/detail/page/<?php echo $valuecat->pID; ?>"><i class="fa fa-th-large left coloredit"></i></a></td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/edit/page?type=edit&pID=<?php echo $valuecat->pID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php require_once("common/footer.php"); ?>