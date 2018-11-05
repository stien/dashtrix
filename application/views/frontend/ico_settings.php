<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">
        <div class="button-list pull-right m-t-15">
            <a class="btn btn-default" href="<?php echo base_url();?>admin/add-ico-setting"><i class="fa fa-plus"></i> Add New ICO Campaign</a>
        </div>

        <?php 
        $c_p_link = 'ico-settings';
        require_once 'common/import_export.php'; ?>

        <h4 class="page-title">ICO CAMPAIGNS</h4>
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
                        <th >Title</th>
                    	<th >Campaign Type</th>
                    	<th >Start at</th>
                        <th >End at</th>
                    	<th >Timezone</th>
                    	<th >Token Symbol</th>
                    	<th >Total Tokens Issued</th>
                    	<th >Tokens For Sale</th>
                        <th >Min. Raise Amount</th>
                    	<th >Max. Raise Amount</th>
                    	<th >Status </th>
                    	<th >Action</th></tr>
                    	</thead>
                    	<?php
							$arr = array();
							$config = $this->front_model->get_query_orderby('*','dev_web_ico_settings',$arr,'id','DESC');
							$settings 	= $config->result_object();
						?>
                    	<tbody>
                    	<?php 
							foreach($settings AS $row){
								
						?>
                    		<tr>
                                <td><?php echo $row->title;?></td>

                                <td><?php echo $row->camp_type==1?"Pre-Sale":"ICO";?></td>
                                <td><?php echo date("m/d/y",strtotime($row->start_date));
                                echo ' '.date("h:i A",strtotime($row->start_time));
                                ?></td>
                                <td><?php echo date("m/d/y",strtotime($row->end_date));
                                echo ' '.date("h:i A",strtotime($row->end_time));
                                ;?></td>

                                <td><?php echo $row->timezone?$row->timezone:'--';?></td>
                                <td><?php echo $row->token_symbol;?></td>
                                <td><?php echo $row->total_tokens_issued;?></td>
                                <td><?php echo $row->tokens_for_sale;?></td>
                    			<td><?php echo $row->min_raise_amount;?></td>
                    			<td><?php echo $row->max_raise_amount;?></td>
                    			<td><?php 
										if($row->active == "1"){echo "<div class='status-confirm'>Yes</div>";} 
										else if($row->active == "0"){echo "<div class='status-pending'>No</div>";} 
										
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

                                        <li><a href="<?php echo base_url().'admin/edit-ico-setting/'.$row->id; ?>" >Edit</a></li>
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

    <div class="modal-cs display_none delete_camp" >
    <div class="modal-box">
        <div class="modal-heading" style="background: red;">
            <h5 class="text-center"  style="color:#fff;">Important System Message</h5>

           
        </div>

        <div class="modal-body">
            <form method="post" action="<?php echo base_url();?>ico/delete_ico_setting" onSubmit="return checkBox(this);">
                <div class="row">

                    
                    <div class="col-md-12">
                        <h3>Are you sure you want to delete this campaign?</h3>
                        <span>When deleting a campaign:</span>
                        <br>

                        <span>1. You lose all of the data tied to this campaign</span>
                        <br>

                        <span>2. All token pricing templates tied to this campaign are deleted</span>
                        <br>
                    </div>
                     <div class="col-md-12 m-t-20">
                        <div class="form-group">
                           <label>
                              &nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" name="delete" value="1" id="letgoifchecked">
                               I confirm I want to delete this campaign and all data associated to this
                           </label>
                        </div>
                    </div>
                    <div class="col-md-6 m-t-20">
                        <div class="form-group">
                            <button class="btn btn-danger btn-block btn-lg" type="button" onclick="closeModel()">
                                Cancel
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 m-t-20">
                        <div class="form-group">
                            <input type="hidden" name="id" id="delete_trans_id" value="">
                            <button class="btn btn-default btn-block btn-lg" type="submit">
                                OK
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once("common/footer.php");?>
<script language="javascript">
<?php if(ACTYPE == "1"){?>
function btnstatusupdate(val,id){
	var x = confirm("Are you sure you want to perform this action?");
	if (x){
		window.location='<?php echo base_url(); ?>ico/ico_setting_status/'+val+'/'+id;
		return true;
	}
	else {
		return false;
	}
}

function btnstatusupdate3(id){

    closeModel();
    $("#delete_trans_id").val(id);
    $(".delete_camp").show();
    return;
    var x = confirm("Are you sure you want to perform this action?");
    if (x){
        window.location='<?php echo base_url(); ?>ico/delete_ico_setting/'+id;
        return true;
    }
    else {
        return false;
    }
}
 function closeModel()
{
    $(".modal-cs").hide();
}
function checkBox(that)
{
    if($("#letgoifchecked").is(':checked')){
        $(that).submit();
    }
    else{
        closeModel();
        return false;
    }
}
<?php } ?>
</script>
