<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">
        <div class="button-list pull-right m-t-15">
            <a class="btn btn-default" href="<?php echo base_url();?>admin/create-smart-contract"><i class="fa fa-plus"></i> Add Contract</a>
        </div>

        <h4 class="page-title">Submitted Smart Contracts</h4>
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
                <div class="">
                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">
                    	<thead>
                    	<tr>
                            <th >Contract Name</th>
                            <th >Owner Ethereum Addr.</th>
                            <th >ICO Start Date</th>
                            <th >ICO End Date</th>
                            <th >Min CPA in ETH</th>
                        	<th >Created At</th>
                        	
                        	<th >Action</th>
                         </tr>
                    	</thead>
                    
                    	<tbody>
                    	<?php 
							foreach($contracts AS $row){
								
						?>
                    		<tr>
                                <td title="<?php echo $row->token_name;?>"><?php echo substr( $row->token_name,0,10)."...";?></td>
                                <td title="<?php echo $row->owner_ethereum_address;?>"><?php echo substr( $row->owner_ethereum_address,0,10)."...";?></td>
                                <td><?php echo $row->token_symbol;?></td>

                                <td><?php echo date("m/d/y",strtotime($row->ico_start_date));?></td>
                                <td><?php echo date("m/d/y",strtotime($row->ico_end_date));?></td>

                                <td><?php echo $row->min_cpa_in_eth;?></td>
                    			<td><?php echo date("m/d/y",strtotime($row->created_at));?></td>
                    			<td>
                    				
                    				<div class="btn-group">
									  <button type="button" class="btn btn-info">Actions</button>
									  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									  </button>
									  <ul class="dropdown-menu">
                                        <li><a href="<?php echo base_url().'admin/view-smart-contract/'.$row->id; ?>" >Details</a></li>
                                        <li><a href="javascript:;" onClick="btnstatusupdate(1,<?php echo $row->id;?>);">Delete</a></li>
									  	
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
		window.location='<?php echo base_url(); ?>ico/ico_delete_smart_contract/'+id;
		return true;
	}
	else {
		return false;
	}
}
<?php } ?>
</script>
