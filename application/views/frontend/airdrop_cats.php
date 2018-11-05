<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">
        <div class="button-list pull-right m-t-15">
            <a class="btn btn-default" href="<?php echo base_url();?>admin/add-bounty-cat"><i class="fa fa-plus"></i> Add New</a>
        </div>

        <?php 
        $c_p_link = 'bounties-landing';
        require_once 'common/import_export.php'; ?>

        <h4 class="page-title">Bounty Page Customization</h4>

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
                        <th >Description</th>
                        <th >Link</th>
                        <th >Image</th>
                        
                    	<th >Status </th>
                    	<th >Action</th></tr>
                    	</thead>
                    	<?php
							$arr = array();
							$config = $this->front_model->get_query_orderby('*','dev_web_airdrop_cats',$arr,'id','DESC');
							$camps 	= $config->result_object();
						?>
                    	<tbody>
                    	<?php 
							foreach($camps AS $row){
								
						?>
                    		<tr>
                                <td title="<?php echo $row->title; ?>"><?php echo substr($row->title,0,50);?></td>
                                
                                 <td title="<?php echo $row->description; ?>"><?php echo substr($row->description,0,50);?></td>

                                <td>
                                    <?php echo $row->slug; ?>
                                </td>
                                <td>
                                    <img width="50" src="<?php echo base_url().'resources/uploads/campaigns/landing/'.$row->image; ?>">
                                </td>

                    			<td><?php 
										if($row->active == "1"){echo "<div class='status-confirm'>Active</div>";} 
										else if($row->active == "0"){echo "<div class='status-pending'>In-Active</div>";} 
										
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
										if($row->active == "1"){ 
										?>
										<li><a href="javascript:;" onClick="btnstatusupdate(0,<?php echo $row->id;?>);">In-Active</a></li>
										<?php } else { ?>
										<li><a href="javascript:;" onClick="btnstatusupdate(1,<?php echo $row->id;?>);">Active</a></li>
										<?php } ?>

                                        <li><a href="<?php echo base_url().'admin/edit-bounty-cat/'.$row->id; ?>" >Edit</a></li>
                                        <li><a href="javascript:;" onClick="btnstatusupdate3(<?php echo $row->id;?>);">Delete</a></li>

										
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
		window.location='<?php echo base_url(); ?>ico/ico_airdrop_cat_status/'+val+'/'+id;
		return true;
	}
	else {
		return false;
	}
}

function btnstatusupdate3(id){
    var x = confirm("Are you sure you want to perform this action?");
    if (x){
        window.location='<?php echo base_url(); ?>ico/delete_ico_airdrop_cat/'+id;
        return true;
    }
    else {
        return false;
    }
}
<?php } ?>
</script>
