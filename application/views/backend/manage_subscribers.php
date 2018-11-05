<?php require_once("common/header.php"); ?>
<script language="javascript" type="application/javascript">
	function deleteuser(id)
	{
		var x = confirm("Are you sure you want to delete this subscriber?");
	  	if (x){
			window.location='<?php echo base_url(); ?>backend/subscribers?type=delete&cid='+id;
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
				$link = 'edit_subscribers';
				$edit = 'Edit';
				foreach($edit_show as $editval):
					$ques 	= $editval->subEmail;
					$fID   = $editval->subID;
				endforeach;
				//echo '<a href="'.base_url().'backend/subscribers?type=show"><div class="right"><button class="btn btn-lg btn-orange right" id="buttonadd">Add New Subscriber</button></a></div>';
			}
			else
			{
				$showd = '';
				$link = 'add_subscriber';
				$ans = '';$ques = '';
				$status = 1;
				$fID = '';
				$edit = 'Add New';
				//echo '<div class="right"><button class="btn btn-lg btn-orange right" id="buttonadd">Add New Subscriber</button></div>';
			}
		?>
      
      <div class="dev-col-1 colbg left" id="newboxwrap" <?php echo $showd; ?>>
        <div class="ContentDiv">
          <h1><?php echo $edit;?> Subscriber</h1>
          <form name="category" id="category" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/<?php echo $link; ?>/">
            <div class="formwrap">
              <label> Email Address: </label>
              <input type="email" value="<?php echo $ques; ?>" required name="faqques" id="faqques" />
              <input type="hidden" value="<?php echo $fID; ?>" name="fID" id="fID" />
            </div>
            
            <div class="formwrap">
              <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-lg btn-green right" />
            </div>
          </form>
        </div>
      </div>
      <div class="dev-col-1 colbg clear">
        <h1>Manage Alerts</h1>
         <form name="actionsds" id="actionsds" method="post" action="">
        <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>User Name</th>
              <th>Job Title</th>
              <th>Job Skills</th>
              <th>Job Type</th>
              <th>Status</th>
              <th>Instant</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
         
            <?php 
				foreach($faqs as $key => $valuecat):
					$arr = array("uID"=>$valuecat->uID);
					$us = $this->admin_model->get_table_data_condition('dev_web_user',$arr);
			?>
             <tr>
              <td><?php echo $us[0]->uFname." ".$us[0]->uLname; ?></td>
              <td><?php echo $valuecat->jobTitle; ?></td>
              <td><?php echo $valuecat->jobSkills; ?></td>
              <td><?php echo $valuecat->jobNature; ?></td>
              <td><?php echo "Daily Alerts";?></td>
              <td align="center"><?php if($valuecat->jobInstant == 1){echo "Yes";} else {echo "No";}?></td>
              <td align="center"><a onClick="deleteuser(<?php echo $valuecat->jaID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
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