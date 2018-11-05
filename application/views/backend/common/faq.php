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
				$link = 'edit_faq';
				$edit = 'Edit';
				foreach($edit_show as $editval):
					$ques = $editval->fQues;
					$ans	 = $editval->fAns;
					$status	 = $editval->fStatus;
					$fID   = $editval->fID;
				endforeach;
				echo '<a href="'.base_url().'backend/faqs?type=show"><div class="right"><button class="btn btn-lg btn-orange right" id="buttonadd">Add New FAQ</button></a></div>';
			}
			else
			{
				$showd = '';
				$link = 'add_faq';
				$ans = '';$ques = '';
				$status = 1;
				$fID = '';
				$edit = 'Add';
				echo '<div class="right"><button class="btn btn-lg btn-orange right" id="buttonadd">Add New FAQ</button></div>';
			}
		?>
      
      <div class="dev-col-1 colbg left" id="newboxwrap" <?php echo $showd; ?>>
        <div class="ContentDiv">
          <h1>Add New FAQ</h1>
          <form name="category" id="category" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/<?php echo $link; ?>/">
            <div class="formwrap">
              <label> FAQ Question: </label>
              <input type="text" value="<?php echo $ques; ?>" required name="faqques" id="faqques" />
              <input type="hidden" value="<?php echo $fID; ?>" name="fID" id="fID" />
            </div>
            <div class="formwrap">
              <label> FAQ Answer: </label>
				<textarea name="answers" id="answers" class="textarea" required><?php echo $ans; ?></textarea>
            </div>
            <div class="formwrap">
              <label> Type: </label>
              <input type="radio" name="catStatus" id="catStatus" <?php if($status == 1){echo 'checked';}?> value="1" />
              <span>FAQ</span>
              <input type="radio" name="catStatus" id="catStatus" value="2" <?php if($status == 2){echo 'checked';}?> />
              <span>Security FAQ</span> </div>
            <div class="formwrap">
              <input type="submit" value="<?php echo $edit; ?> FAQ" name="submit" id="submit" class="btn btn-lg btn-green right" />
            </div>
          </form>
        </div>
      </div>
      <div class="dev-col-1 colbg clear">
        <h1>Manage FAQ's</h1>
         <form name="actionsds" id="actionsds" method="post" action="">
        <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>Question</th>
              <th>Answer</th>
              <th>Type</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
         
            <?php 
				foreach($faqs as $key => $valuecat):
			?>
             <tr>
              <td><?php echo $valuecat->fQues; ?></td>
              <td><?php echo $valuecat->fAns; ?></td>
              <td><?php if($valuecat->fStatus == '1'){echo 'FAQ';} else {echo 'Security FAQ';} ?></td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/faq?type=edit&cid=<?php echo $valuecat->fID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a></td>
              <td align="center"><a href="<?php echo base_url(); ?>backend/faq?type=delete&cid=<?php echo $valuecat->fID; ?>"><i class="fa fa-trash-o left coloredit"></i></a></td>
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