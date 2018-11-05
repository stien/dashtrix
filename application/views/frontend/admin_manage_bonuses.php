<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">
        <div class="button-list pull-right m-t-15">
            <a class="btn btn-default" href="<?php echo base_url()."admin/add-bonus/".$id;?>"><i class="fa fa-plus"></i> Add Bonus</a>
        </div>

        <h4 class="page-title">Bonuses</h4>
    </div>
    </div><?php if(isset($_SESSION['thankyou'])){?>
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
               
            <?php
				$arrcount = array('token_id'=>$id);
				$configcount = $this->front_model->get_query_simple('*','dev_web_bonuses',$arrcount);
				$bonuses 	= $configcount->result_object();
                
			?>
            
            <div class="table-responsive">
                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">
                    	<thead>
                    	<tr>
                    	
                        <th >Bonus Type</th>
                        <th >Bonus Method</th>
                        <th >Start Date</th>
                        <th >End Date</th>
                        <th >More Than</th>
                    	<th >Less Than</th>
                        <th >Bonus</th>
                    	
                    	<th >Action</th></tr>
                    	</thead>
                    	
                    	<tbody>
                    	<?php 
							foreach($bonuses AS $row){
						?>
                    		<tr>
                                <td><?php echo $row->type==1?"Standard":"Escalating";?></td>
                                <td><?php echo $row->method==1?"Tokens Purchased":"Purchase Amount";?></td>
                                <td><?php if($row->from_date != "" && $row->from_date != "0000-00-00"){echo date("m/d/y",strtotime($row->from_date));} else echo "--";
                                    
                                ?>
                            

                                </td>
                                <td><?php if($row->end_date != "" && $row->end_date != "0000-00-00"){echo date("m/d/y",strtotime($row->end_date));}
                                else echo "--";
                                   
                                ?></td>
                                <td><?php echo $row->more_than;?></td>
                                <td><?php echo $row->less_than!="-1"?$row->less_than:'--';?></td>
                                <td><?php echo $row->bonus;?>%</td>

                    			
                    			
                    			<td>
                    				
                    				<div class="btn-group">
									  <button type="button" class="btn btn-info">Actions</button>
									  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									  </button>
									  <ul class="dropdown-menu">
									  
										<li>
											<a href="javascript:;" onClick="btnstatusupdate(<?php echo $row->id;?>);">Delete</a>
										</li>
                                        <?php /*
                                        <li>
                                            <a href="<?php echo base_url().'admin/edit-bonus/'.$row->id ?>">Edit</a>
                                        </li>
                                        */ ?>
										
										
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
function btnstatusupdate(val){
	var x = confirm("Are you sure you want to perform this action?");
	if (x){
		window.location='<?php echo base_url(); ?>ico/remove_bonus/'+val;
		return true;
	}
	else {
		return false;
	}
}

<?php } ?>
</script>
