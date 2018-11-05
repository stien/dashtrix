<?php require_once("common/header.php"); ?>
<script language="javascript" type="application/javascript">
	function deleteuser(id)
	{
		var x = confirm("Are you sure you want to delete this Order?");
	  	if (x){
			window.location='<?php echo base_url(); ?>admin/manage_orders?type=delete&cid='+id;
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

      <div class="dev-col-1 colbg clear">
        <h1>Manage Orders</h1>
         <form name="actionsds" id="actionsds" method="post" action="">
        <table width="100%" id="categories" class="hover" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>User Name</th>
              <th>Transaction ID</th>
              <th>Adverts</th>
              <th>Candidate Search</th>
              <th>Payment</th>
              <th>Price</th>
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
              <td><?php echo $valuecat->transActionID; ?></td>
              <td><?php if($valuecat->uAdverts ==0){echo "0 Advert";} else { echo $valuecat->uAdverts." Adverts";} ?></td>
              <td><?php if($valuecat->uCandi ==0){echo "0 Day";} else { echo $valuecat->uCandi." Days";} ?></td>
              <td><?php if($valuecat->uStatus == 1){echo "Yes";} else {echo "No";}?></td>
              <td align="center">$<?php echo $valuecat->uPrice?></td>
              <td align="center"><a onClick="deleteuser(<?php echo $valuecat->oID; ?>)" href="javascript:;"><i class="fa fa-trash-o left coloredit"></i></a></td>
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