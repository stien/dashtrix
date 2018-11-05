<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">
        
<div class="button-list pull-right m-t-15">
                        <a class="btn btn-default" href="<?php echo base_url();?>admin/add-admin"><i class="fa fa-plus"></i> Add New Admin</a>
                    </div>
            
            <h4 class="page-title">MANAGE USERS

                    

                    <?php 
        $c_p_link = 'admin-users?where=uActType&there=1';
        require_once 'common/import_export.php'; ?>

        </h4>


    </div>
    </div>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box m-b-50">
               
                <div class="table-responsive">
                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">
                    	<thead>
                    	<tr>
                    	<th >Name</th>
                    	
                    	<th >Email</th>
                    	
                        <th >Status </th>
                    	<th >Action</th></tr>
                    	</thead>
                    	<?php
							$arr = array('uActType'=>1);
							$config = $this->front_model->get_query_orderby('*','dev_web_user',$arr,'uID','DESC');
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

								

                                $owner = $this->front_model->get_query_simple('*','dev_web_user',array('uID'=>$row->client_of))->result_object();
						?>
                    		<tr>
                    			<td title="<?php echo $row->uFname. " ".$row->uLname;?>"><?php echo substr( $row->uFname. " ".$row->uLname,0,10)."...";?></td>
                    		
                    			<td><?php echo $row->uEmail;?></td>
                    		
        
                    			<td><?php 
										if($row->uStatus == "0"){echo "<div class='status-pending'>In-Active</div>";} 
										else if($row->uStatus == "1"){echo "<div class='status-confirm'>Active</div>";} 
										//else if($row->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}
										//else if($row->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}
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

                                <li><a href="<?php echo base_url().'admin/edit-admin/'.$row->uID; ?>" >Edit</a></li>

									  	<?php 
										if($row->uStatus == "1"){ 
										?>
										<li><a href="javascript:;" onClick="btnstatusupdate(0,<?php echo $row->uID;?>);">In-Active</a></li>
										<?php } else { ?>
										<li><a href="javascript:;" onClick="btnstatusupdate(1,<?php echo $row->uID;?>);">Active</a></li>
										<?php } ?>
								<li><a href="javascript:;" onClick="btnstatusdelete(<?php echo $row->uID;?>);">Delete</a></li>
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
		window.location='<?php echo base_url(); ?>admin/do/action/user/'+val+'/'+id;
		return true;
	}
	else {
		return false;
	}
}
function btnstatusdelete(val){
    var x = confirm("Are you sure you want to perform this action?");
    if (x){
        window.location='<?php echo base_url(); ?>ico/delete_admin/'+val;
        return true;
    }
    else {
        return false;
    }
}
<?php } ?>
</script>
