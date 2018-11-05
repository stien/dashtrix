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
	function deleteuser(id)
	{
		var x = confirm("Are you sure you want to delete this category?");
	  	if (x){
			window.location='<?php echo base_url(); ?>backend/categories?type=delete&cid='+id;
			return true;
		}
		else {
			return false;
		}
	}
	function makeActions(action)
	{
		var x = confirm("Are you sure you want to do this action?");
		  if (x){
			  	var formaction = '<?php echo base_url(); ?>backend/categories/actions?action='+action;
				$('#actionsds').attr('action', formaction);
				$("#actionsds").submit();
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
				$link = 'edit_categories';
				$edit = 'Edit';
				foreach($edit_show as $editval):
					$catname = $editval['catName'];
					$parent	 = $editval['catParent'];
					$title	 = $editval['catTitle'];
					$descp	 = $editval['catDesp'];
					$keys	 = $editval['catKeys'];
					$status	 = $editval['catStatus'];
					$catID   = $editval['cID'];
				endforeach;
				echo '<a href="'.base_url().'index.php/backend/categories?type=show"><div class="right"><button class="btn btn-lg btn-orange right" id="buttonadd">Add New Category</button></a></div>';
			}
			else
			{
				$showd = '';
				$link = 'add_categories';
				$catname = '';
				$parent = '0';
				$title	 = "";
				$descp	 = "";
				$keys	 = "";
				$status = 1;
				$catID = '';
				$edit = 'Add';
				echo '<div class="right"><button class="btn btn-lg btn-orange right" id="buttonadd">Add New Category</button></div>';
			}
		?>
      <?php /*?><div class="filter left"> <span>Filter:</span> <span>
        <select name="filter" id="filter" class="filterclas" onChange="get_cat_list(this.value)">
          <option value="0">---Select A Parent---</option>
          <?php foreach($all_categories as $key => $value): ?>
          <option value="<?php echo $value['cID']; ?>" <?php if($value['cID'] == isset($_GET['parent'])){echo 'SELECTED';} ?>><?php echo $value['catName']; ?></option>
          <?php endforeach; ?>
        </select>
        </span> </div><?php */?>
      <div class="dev-col-1 colbg left" id="newboxwrap" <?php echo $showd; ?>>
        <div class="ContentDiv">
          <h1>Add New Category</h1>
          <form name="category" id="category" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/<?php echo $link; ?>/">
            <div class="formwrap">
              <label> Category Name: </label>
              <input type="text" value="<?php echo $catname; ?>" required name="catName" id="catName" />
              <input type="hidden" value="<?php echo $catID; ?>" name="catID" id="catID" />
            </div>
            <div class="formwrap">
              <label> Meta Title: </label>
              <input type="text" value="<?php echo $title; ?>" required name="metaTitle" id="metaTitle" />
            </div>
            <div class="formwrap">
              <label> Meta Description: </label>
              <input type="text" value="<?php echo $descp; ?>" required name="metaDesc" id="metaDesc" />
            </div>
            <div class="formwrap">
              <label> Meta Keywords: </label>
              <input type="text" value="<?php echo $keys; ?>" required name="metakeys" id="metakeys" />
               <input type="hidden" value="0" required name="parentID" id="parentID" />
            </div>
            <?php /*?><div class="formwrap">
              <label> Parent Category: </label>
              <select name="parentID" id="parentID" class="selectbox" onChange="showimagebox(this.value);">
                <option value="0">--- Select Parent ---</option>
                <?php foreach($all_categories as $key => $value){ ?>
                <option value="<?php echo $value['cID']; ?>" <?php if($parent == $value['cID']){echo 'SELECTED';} ?>><?php echo $value['catName']; ?></option>
                <?php }	?>
              </select>
            </div><?php */?>
            <?php if($parent == 0){ ?>
<?php /*?>            <div class="formwrap" id="displayimg">
              <label> Parent Category Image: </label>
              <input type="file" name="userfile" id="userfile" />
            </div>
<?php */?>            <?php } ?>
            <div class="formwrap">
              <label> Status: </label>
              <input type="radio" name="catStatus" id="catStatus" <?php if($status == 1){echo 'checked';}?> value="1" />
              <span>Active</span>
              <input type="radio" name="catStatus" id="catStatus" value="0" <?php if($status == 0){echo 'checked';}?> />
              <span>In-Active</span> </div>
            <div class="formwrap">
              <input type="submit" value="<?php echo $edit; ?> Category" name="submit" id="submit" class="btn btn-lg btn-green right" />
            </div>
          </form>
          <script language="javascript">
		  function showimagebox(id){
			  if(id == 0){
				$("#displayimg").show();  
			  }
			  else {
				  $("#displayimg").hide();  
			  }
		  }
		  </script>
        </div>
      </div>
      <div class="dev-col-1 colbg clear">
        <h1>Manage Categories</h1>
         <form name="actionsds" id="actionsds" method="post" action="">
        <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>&nbsp;</th>
              <th>Category Name</th>
              <th>Parent Name</th>
              <th>Title</th>
              <th>Meta Description</th>
              <th>Keywords</th>
              
              <th>Status</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
         
            <?php 
			if(isset($_GET['parent'])) {
				foreach($all_show_parent as $key => $valuecat):
			?>
             <tr>
              <td><input type="checkbox" value="<?php echo $valuecat['cID']; ?>" class="checkbox1" name="srcheck[]" id="srcheck[]" /></td>
              <td><?php echo $valuecat['catName']; ?></td>
              <td><?php echo $valuecat['catParent']; ?></td>
              <td><?php echo $valuecat['catTitle']; ?></td>
              <td><?php echo $valuecat['catDesp']; ?></td>
              <td><?php echo $valuecat['catKeys']; ?></td>
            
              <td><?php echo $valuecat['catLink']; ?></td>
              <td><?php if($valuecat['catStatus'] == '1'){echo 'Active';} else {echo 'In-Active';} ?></td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/categories?type=edit&cid=<?php echo $valuecat['cID']; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/categories?type=delete&cid=<?php echo $valuecat['cID']; ?>"><i class="fa fa-trash-o left coloredit"></i></a></td>
            </tr>
            <?php
			endforeach;	
			}
			else
			{
			foreach($all_show as $key => $valuecat):
			?>
            <tr>
              <td><input type="checkbox" value="<?php echo $valuecat['cID']; ?>" class="checkbox1" name="srcheck[]" id="srcheck[]" /></td>
              <td><?php if($valuecat['catParent'] != '0' ){echo '<i class="fa icon-arrow-right coloredit"></i>&nbsp;&nbsp;&nbsp;';} ?> <?php echo $valuecat['catName']; ?></td>
              <td><?php echo $valuecat['Parent_name']; ?></td>
              <td><?php echo $valuecat['catTitle']; ?></td>
              <td><?php echo $valuecat['catDesp']; ?></td>
              <td><?php echo $valuecat['catKeys']; ?></td>
            
              <td><?php if($valuecat['catStatus'] == '1'){echo 'Active';} else {echo 'In-Active';} ?></td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/categories?type=edit&cid=<?php echo $valuecat['cID']; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>
              <td align="center"><a href="javascript:;" onClick="deleteuser(<?php echo $valuecat['cID']; ?>)"><i class="fa fa-trash-o left coloredit"></i></a></td>
            </tr>
            <?php endforeach;
			}
			?>
          </tbody>
        </table><!--href="'.base_url().'index.php/backend/fields"-->
    </form>
            <div class="actns">
            Choose Action: 
            
                <select name="actions" id="actions" onChange="makeActions(this.value)">
                    <option value="">Choose Action</option>
                    <option value="1">Delete</option>
                    <option value="2">Active Selected</option>
                    <option value="3">InActive Selected</option>
                </select>
            
            </div>
      </div>
      
    </div>
    <?php require_once("common/footer.php"); ?>