<?php require_once("common/header.php");?>
    <div class="fullcontent right clear">
      <?php if(isset($_GET['type']) && $_GET['type'] == 'edit' && isset($_GET['did']))
	{
		$link = 'edit_department_submit';
		$edit = 'Edit';
		foreach($departments as $editval):
			$uID	 	= $editval->uID;
			$dName	 	= $editval->dName;
			$dStatus 	= $editval->dStatus;
			$dID		= $editval->dID;
		endforeach;
	}
	else
	{
		$link = 'add_department_submit';
		$uID 		= 0;
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
              <label> Country: </label>
              <select name="company" id="company" class="selectbox fastselect textarea">
                <option value="0">--- Select Company ---</option>
                <?php foreach($users as $countrydata): ?>
                <option value="<?php echo $countrydata->uID;?>" <?php if($countrydata->uID == $uID){echo 'SELECTED';} ?>><?php echo $countrydata->uFname.' '.$countrydata->uLname;?></option>
                <?php endforeach;?>
              </select>
            </div>
            <div class="formwrap">
              <label> Department Name: </label>
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
	