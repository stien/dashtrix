<?php require_once("common/header.php"); ?>
<script language="javascript" type="application/javascript">
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
	function makeActions(id)
	{
		var x = confirm("Are you sure you want to do this action?");
		  if (x){
			  	window.location = '<?php echo base_url(); ?>admin/manage_coupoun?type=delete&cid='+id;
				return true;
		  }
		  else {
			return false;
		  }
	}
	
</script>
<?php
error_reporting(-1);
//$arrcop2 		= array();
$cprows 	 = $this->admin_model->get_table_data('dev_web_coupon_active');
?>
    <div class="fullcontent right clear">
      <div class="dev-col-1 colbg left">
        <div class="ContentDiv">
          <h1>Active/Inactive Coupon on Frontend</h1>
          <form name="category" id="category" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/active_inactiv_coupon/">
            <div class="formwrap">
              <input type="hidden" value="<?php echo $cprows[0]->cpaID; ?>" name="fID" id="fID" />
              <label> Show on Website: </label>
              <select name="cpshow" id="cpshow" required class="selectbox textarea">
                <option value="">--- Show on Webiste---</option>
                <option value="1" <?php if($cprows[0]->cpActive == 1){echo "SELECTED";} ?>>Yes</option>
                <option value="0" <?php if($cprows[0]->cpActive == 0){echo "SELECTED";} ?>>No</option>
              </select>
            </div>
            <div class="formwrap">
              <label> Country: </label>
              <select name="country" id="country" class="selectbox textarea">
                <option value="0" <?php if($cprows[0]->cpCountry == 0){echo "SELECTED";} ?>>--- Select Country ---</option>
                <?php foreach($country as $countrydata): ?>
                <option value="<?php echo $countrydata->country_name;?>" <?php if($countrydata->country_name == $cprows[0]->cpCountry){echo 'SELECTED';} ?>><?php echo $countrydata->country_name;?></option>
                <?php endforeach;?>
              </select>
            </div>
           
            <div class="formwrap">
              <input type="submit" value="Active/Inactive Coupon" name="submit" id="submit" class="btn btn-lg btn-green right" />
            </div>
          </form>
        </div>
      </div>
      
    </div>
    <?php require_once("common/footer.php"); ?>