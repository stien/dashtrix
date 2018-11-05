<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">


        <h4 class="page-title">Bounties</h4>
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
                        <th >Token Payout</th>
                        <th >Available</th>
                        <th >Completed</th>
                        <th >Start Date</th>
                        <th >End Date</th>
                    	<th >Action</th></tr>
                    	</thead>
                    	<?php

                            $camp_type = $this->front_model->get_query_simple('*','dev_web_airdrop_cats',array('slug'=>$slug,'active'=>1))->result_object()[0];

							$arr = array('active'=>1,'camp_type'=>$camp_type->id);
							$config = $this->front_model->get_query_orderby('*','dev_web_airdrop_campaigns',$arr,'id','DESC');
							$camps 	= $config->result_object();
						?>
                    	<tbody>
                    	<?php 
							foreach($camps AS $row){
								
						?>
                    		<tr>
                                <td><?php echo $row->name;?></td>
                                <td><?php echo number_format($row->bounty_qty/$row->bounty_persons,decimals_()); ?></td>

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
                                    echo $submitted;


                                     ?>
                                </td>
                                <td><?php echo date("m/d/y",strtotime($row->start_date));?></td>
                                <td><?php echo date("m/d/y",strtotime($row->end_date));?></td>
                                 
                    	 
                    			<td>
                    				
                    				<div class="btn-group">


                                        <?php
                                        $already_submitted = $this->front_model->get_query_simple('*','dev_web_airdrop_submissions',array('uID'=>UID,'camp_id'=>$row->id))->num_rows();

                                        if($already_submitted==0){

                                         ?>


                    					<a href="<?php echo base_url().'submit-airdrop-campaign/'.$row->id; ?>">
									  		<button type="button" class="btn btn-default">Submit</button>
										</a>

                                        <?php } ?>
                    					<a href="<?php echo base_url().'view-airdrop-campaign/'.$row->id; ?>">
									  		<button type="button" class="btn btn-info">View</button>
									  	</a>
									  
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
        window.location='<?php echo base_url(); ?>ico/delete_ico_setting/'+id;
        return true;
    }
    else {
        return false;
    }
}
<?php } ?>
</script>
