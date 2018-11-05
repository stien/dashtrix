<?php require_once("common/header.php");?>
    <div class="fullcontent right clear">
      <?php if(isset($_GET['type']) && $_GET['type'] == 'edit' && isset($_GET['bid']))
	{
		$link = 'edit_benefit_submit';
		$edit = 'Edit';
		foreach($departments as $editval):
			$dName	 	= $editval->bName;
			$dStatus 	= $editval->bStatus;
			$dID		= $editval->bID;
		endforeach;
	}
	else
	{
		$link = 'add_benefit_submit';
		$dName	 	= '';
		$dStatus 	= 1;
		$dID		= '';
		$edit = 'Add New';
	}
?>
      <form name="category" id="category" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/<?php echo $link; ?>/">
        <div class="dev-col-1 colbg left">
          <div class="ContentDiv">
            <h1><?php echo $edit;?> Department</h1>
            
            <div class="formwrap">
              <label> Benefit Name: </label>
              <input type="text" value="<?php echo $dName; ?>" required name="dName" id="dName" />
              <input type="hidden" value="<?php echo $dID; ?>" required name="dID" id="dID" />
            </div>
            <div class="formwrap">
              <label> Status: </label>
              <input type="radio" name="catStatus" id="catStatus" <?php if($dStatus == 1){echo 'checked';} ?> value="1" />
              <span>Active</span>
              <input type="radio" name="catStatus" id="catStatus" <?php if($dStatus == 0){echo 'checked';} ?> value="0" />
              <span>In-Active</span> </div>
            
          </div>
          <div class="formwrap">
              <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-lg btn-green right" />
            </div>
        </div>
      </form>
    </div>
    <?php require_once("common/footer.php"); ?>
	