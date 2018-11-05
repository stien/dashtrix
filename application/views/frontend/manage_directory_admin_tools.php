<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">
        
		
        <h4 class="page-title">MANAGE DIRECTORY TOOLS
        	<div class="right">
        		<a href="<?php echo base_url();?>admin/add/directory/tool">
        		<button class="btn btn-danger">
        			Add New Item
        		</button>
				</a>
        	</div>
        </h4>
    </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box m-b-50">
               <?php if(isset($_SESSION['thankyou'])){?>
            <div class="col-md-12">
                <div class="form-group">
                    <div class="successfull">
                    	<?php echo $_SESSION['thankyou'];?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if(isset($_SESSION['error'])){?>
            <div class="col-md-12">
                <div class="form-group">
                    <div class="wrongerror">
                    	<?php echo $_SESSION['error'];?>
                    </div>
                </div>
            </div>
            <?php } ?>
                <div class="table-responsive">
                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">
                    	<thead>
                    	<tr>
                    	<th >Title</th>
                    	<th >Price</th>
                    	<th >Link</th>
                    	<th >Included</th>
                    	<th >Status </th>
                    	<th >Action</th></tr>
                    	</thead>
                    	<?php
							$arr = array();
							$config = $this->front_model->get_query_orderby('*','dev_web_ico_directory',$arr,'dID','ASC');
							$transctions 	= $config->result_object();
						?>
                    	<tbody>
                    	<?php 
							foreach($transctions AS $row){
								$arucon = array('id' => $row->uCountry);
								$conqry = $this->front_model->get_query_simple('*','dev_web_countries',$arucon);
								$countries 	= $conqry->result_object();	
								
								$arusr = array('uID' => $row->uID);
								$usrqry = $this->front_model->get_query_simple('*','dev_web_transactions',$arusr);
								$user 	= $usrqry->result_object();

								$s_status = $this->front_model->get_query_simple('*','dev_web_system_status',array('uID'=>$row->uID))->result_object()[0];
						?>
                    		<tr>
                    			
                    			<td><?php echo $row->dTitle;?></td>
                    			<td><?php echo $row->dPrice;?></td>
                    			<td><?php echo $row->dURL;?></td>
                    			<td><?php 
										if($row->dChecked == "1"){echo "<div class='status-pending'>Included</div>";} 
										else if($row->dChecked == "0"){echo "<div class='status-refunded'>Not-Included</div>";} 
									?>
                   				</td>
                                
                    			<td><?php 
										if($row->dStatus == "0"){echo "<div class='status-pending'>In-Active</div>";} 
										else if($row->dStatus == "1"){echo "<div class='status-confirm'>Active</div>";} 
									?>
                   				</td>
                    			<td>
                    				
                    				<div class="btn-group">
									  <button type="button" class="btn btn-info">Actions</button>
									  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									  </button>
									  <ul class="dropdown-menu">
									  	<?php 
										if($row->dStatus == "1"){ 
										?>
										<li><a href="javascript:;" onClick="btnstatusupdate(0,<?php echo $row->dID;?>);">In-Active</a></li>
										<?php } else { ?>
										<li><a href="javascript:;" onClick="btnstatusupdate(1,<?php echo $row->dID;?>);">Active</a></li>
										<?php } ?>
										<li><a href="javascript:;" onClick="btnstatusdelete(<?php echo $row->dID;?>);">Delete</a></li>
									  </ul>
									</div>
                    				
                    			</td>
                    		</tr>
                    	<?php } ?>
                    	</tbody>
                    </table>
                </div>
            </div>

        </div> <!-- end col -->
    </div>
<?php require_once("common/footer.php");?>
<script language="javascript">
<?php if(ACTYPE == "1"){?>
function btnstatusupdate(val,id){
	var x = confirm("Are you sure you want to perform this action?");
	if (x){
		window.location='<?php echo base_url(); ?>ico/update_directory_tool_status/'+val+'/'+id;
		return true;
	}
	else {
		return false;
	}
}
	function btnstatusdelete(id){
	var x = confirm("Are you sure you want to perform this action?");
	if (x){
		window.location='<?php echo base_url(); ?>ico/delete_directory_tool_status/'+id;
		return true;
	}
	else {
		return false;
	}
}
<?php } ?>
</script>
