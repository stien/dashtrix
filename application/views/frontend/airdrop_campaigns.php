<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">
        <div class="button-list pull-right m-t-15">
            <a class="btn btn-default" href="<?php echo base_url();?>admin/add-bounty-campaign"><i class="fa fa-plus"></i> Add New Bounty Campaign</a>
        </div>

        <?php 
        $c_p_link = 'bounties';
        require_once 'common/import_export.php'; ?>

        <h4 class="page-title">Bounty Campaigns</h4>
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

                        <th >Name</th>
                        <th >Type</th>
                        <th >Amount</th>
                        <th >Method</th>
                        <th >Avialable</th>
                        <th >Submitted</th>
                        <th >Awarded</th>
                        <th >Created</th>
                    	<th >Status </th>
                    	<th >Action</th></tr>
                    	</thead>
                    	<?php
							$arr = array();
							$config = $this->front_model->get_query_orderby('*','dev_web_airdrop_campaigns',$arr,'id','DESC');
							$camps 	= $config->result_object();


                           
						?>
                    	<tbody>
                    	<?php 
							foreach($camps AS $row){

                                 $camp_types = $this->front_model->get_query_simple('*','dev_web_airdrop_cats',array('id'=>$row->camp_type))->result_object()[0];
								
						?>
                    		<tr>
                                <td><?php echo $row->name;?></td>
                                <td>
                                    <?php

                                    echo $camp_types->title;
                                    
                                     ?>
                                </td>
                                <td>
                                    <?php echo $row->bounty_qty; ?>
                                </td>

                                <td>Tokens</td>
                                <td>
                                    <?php

                                        $submitted = $this->db->where('camp_id',$row->id)->where('status',1)->count_all_results('dev_web_airdrop_submissions');

                                        $raw_ = $row->bounty_qty/$row->bounty_persons;
                                        $submitted_2 = $raw_*$submitted;
                                        echo number_format($row->bounty_qty-$submitted_2,decimals_());
                                        

                                         ?>   
                                </td>

                                <td>
                                    
                                    <?php

                                    echo $this->db->where('camp_id',$row->id)->where('status !=',2)->count_all_results('dev_web_airdrop_submissions');
                                     ?>
                                </td>
                                <td>
                                    <?php

                                    echo $this->db->where('camp_id',$row->id)->where('status',1)->count_all_results('dev_web_airdrop_submissions');
                                     ?>
                                </td>
                    			<td><?php echo date("m/d/y",strtotime($row->created_at));?></td>
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

                                        <li><a href="<?php echo base_url().'admin/edit-bounty-campaign/'.$row->id; ?>" >Edit</a></li>
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
		window.location='<?php echo base_url(); ?>ico/ico_airdrop_camp_status/'+val+'/'+id;
		return true;
	}
	else {
		return false;
	}
}

function btnstatusupdate3(id){
    var x = confirm("Are you sure you want to perform this action?");
    if (x){
        window.location='<?php echo base_url(); ?>ico/ico_airdrop_camp_delete/'+id;
        return true;
    }
    else {
        return false;
    }
}
<?php } ?>
</script>
