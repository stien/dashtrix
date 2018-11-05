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
    <div class="fullcontent right clear">
      <?php if(isset($_GET['type']) && $_GET['type'] == 'edit' && isset($_GET['cid']))
			{
				$showd = 'style="display:block"';
				$link = 'edit_coupon';
				$edit = 'Edit';
				foreach($edit_show as $editval):
					$cpCountry = $editval->cpCountry;
					$cpCode	 = $editval->cpCode;
					$cpPrice	 = $editval->cpPrice;
					$cpStatus	 = $editval->cpStatus;
					$cpID   = $editval->cpID;
				endforeach;
				echo '<a href="'.base_url().'admin/manage_coupoun?type=show"><div class="right"><button class="btn btn-lg btn-orange right" id="buttonadd">Add New Coupon</button></a></div>';
			}
			else
			{
				$showd = '';
				$link = 'add_coupon';
				$cpCountry = '';$cpCode = '';
				$cpPrice = '';
				$cpStatus = 1;
				$cpID = '';
				$edit = 'Add';
				echo '<div class="right"><button class="btn btn-lg btn-orange right" id="buttonadd">Add New Coupon</button></div>';
			}
		?>
      
      <div class="dev-col-1 colbg left" id="newboxwrap" <?php echo $showd; ?>>
        <div class="ContentDiv">
          <h1>Add New Coupon Code</h1>
          <form name="category" id="category" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/<?php echo $link; ?>/">
            <div class="formwrap">
              <label> Coupon Code: </label>
              <input type="text" value="<?php echo $cpCode; ?>" required name="cpCode" id="cpCode" />
              <input type="hidden" value="<?php echo $cpID; ?>" name="fID" id="fID" />
            </div>
            <div class="formwrap">
              <label> Coupon Discount: (%) </label>
              <input type="text" value="<?php echo $cpPrice; ?>" required name="cpPrice" id="cpPrice" />
            </div>
            <div class="formwrap">
              <label> Country: </label>
              <select name="cpCountry" id="cpCountry" required class="selectbox textarea">
                <option value="">--- Select Country ---</option>
                <?php foreach($country as $countrydata): ?>
                <option value="<?php echo $countrydata->country_name;?>" <?php if($countrydata->country_name == $cpCountry){echo 'SELECTED';} ?>><?php echo $countrydata->country_name;?></option>
                <?php endforeach;?>
              </select>
            </div>
            <div class="formwrap">
              <label> Status: </label>
              <input type="radio" name="catStatus" id="catStatus" <?php if($cpStatus == 1){echo 'checked';}?> value="1" />
              <span>Active</span>
              <input type="radio" name="catStatus" id="catStatus" value="2" <?php if($cpStatus == 2){echo 'checked';}?> />
              <span>In-Active</span> </div>
            <div class="formwrap">
              <input type="submit" value="<?php echo $edit; ?> Coupon" name="submit" id="submit" class="btn btn-lg btn-green right" />
            </div>
          </form>
        </div>
      </div>
      <div class="dev-col-1 colbg clear">
        <h1>Manage Coupon Code</h1>
         <form name="actionsds" id="actionsds" method="post" action="">
        <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>Coupon Code</th>
              <th>Discount (%)</th>
              <th>Country</th>
              <th>Status</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
         
            <?php 
				foreach($faqs as $key => $valuecat):
			?>
             <tr>
              <td><?php echo $valuecat->cpCode; ?></td>
              <td><?php echo $valuecat->cpPrice; ?>%</td>
              <td><?php echo $valuecat->cpCountry; ?></td>
              <td><?php if($valuecat->cpStatus == '1'){echo 'Active';} else {echo 'In-Active';} ?></td>
              <td align="center"><a href="<?php echo base_url(); ?>admin/manage_coupoun?type=edit&cid=<?php echo $valuecat->cpID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>
              <td align="center"><a onClick="makeActions(<?php echo $valuecat->cpID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
            </tr>
            <?php
			endforeach;	
			?>
            
          </tbody>
        </table><!--href="'.base_url().'index.php/backend/fields"-->
        </form>
            
      </div>
      
    </div>
    <?php require_once("common/footer.php"); ?>