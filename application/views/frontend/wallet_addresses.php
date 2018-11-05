<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">
        

            
            <h4 class="page-title">MANAGE WALLET ADDRESSES</h4>


    </div>
    </div>
    <div class="row">
        <div class="col-lg-12">


            <div class="card-box m-b-50" style="clear: both;"> 
                    <div class="form-group" style="margin-bottom: 0;">
                       
                        <a href="javascript:showAdd();">
                         <button  type="button" class="btn btn-primary">Add New Single Address</button>
                        </a>

                        <a href="javascript:showUploadCSV();">
                         <button  type="button" class="btn btn-primary">Upload CSV</button>
                        </a>

                        <?php

                        $already = $this->front_model->get_query_simple('*','dev_web_payment_options',array('id'=>$this->uri->segment(3)))->result_object()[0];
                        if($already->one_per_trans==1){
                         ?>

                         <a href="<?php echo base_url().'ico/change_payment_option_one_per_trans/'.$already->id.'/0'; ?>">
                         <button  type="button" class="btn btn-danger right">Disable This Feature</button>
                        </a>

                        <?php }else{ ?>
                        <a href="<?php echo base_url().'ico/change_payment_option_one_per_trans/'.$already->id.'/1'; ?>">
                         <button  type="button" class="btn btn-default right">Enable This Feature</button>
                        </a>
                        <?php } ?>


                    </div>
              </div>

              <div class="card-box m-b-50" style="clear: both;"> 
                    <div class="form-group" style="margin-bottom: 0;">
                        <form method="post" action="<?php echo base_url().'ico/update_warning/'.$already->id; ?>">
                        <select name="warning" class="form-control" style="width: 10%; float: left; margin-right: 10px;">
                            <?php for($i=0;$i<=100;$i++){ ?>
                                <option <?php if($i==$already->warning_before) echo "selected"; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                         <button  type="submit" class="btn btn-primary">Update Warning</button>                        
                        </form>
                    </div>
              </div>


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
                            	<th >Address </th>                            	
                                <th >Used </th>
                                <th >Used On</th>
                            	<th >Action </th>
                            </tr>
                    	</thead>
                    	<tbody>
                    	<?php 
							foreach($addresses AS $row){
								
						?>
                    		<tr>
                    			<td title="<?php echo $row->address;?>"><?php echo $row->address;?></td>
                    		
                    			
                    		
        
                    			<td><?php 
										if($row->used == "0"){echo "<div class='status-pending'>No</div>";} 
										else if($row->used == "1"){echo "<div class='status-confirm'>Yes</div>";} ?>
                   				</td>
                                <td ><?php if($row->used==1 || $row->used=="1") echo date("m/d/y | H:i a", strtotime($row->used_on)); else echo "--:--";?></td>

                    			<td>
                    				
                    				<div class="btn-group">
									  <button type="button" class="btn btn-info">Actions</button>
									  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									  </button>
									  <ul class="dropdown-menu">

                                        <li><a href="javascript:showEdit(<?php echo $row->id; ?>,'<?php echo $row->address; ?>');" >Edit</a></li>
								        <li><a href="javascript:;" onClick="btnstatusdelete(<?php echo $row->id;?>);">Delete</a></li>
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






<!-- add modal -->

 <div class="modal-cs display_none" id="modalAdd">
                <div class="modal-box">
                    <div class="modal-heading">
                        Add New Wallet Address

                        <button onclick="closeModel();" class="btn bt-danger right" >
                            <i  class="fa fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form method="post" action="<?php echo base_url().'ico/add_wallet_address/'.$this->uri->segment(3); ?>">
                            <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Address: <sup>*</sup></label>
                                            <input name="address" type="text" class="form-control" value="" required autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-md-offset-3 m-t-40">
                                        <div class="form-group">
                                            <button class="btn btn-default btn-block btn-lg" type="submit">
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                 </div>
            </div>

            <!-- edit modal -->
 <div class="modal-cs display_none" id="modalEdit">
                <div class="modal-box">
                    <div class="modal-heading">
                        Edit Wallet Address

                        <button onclick="closeModel();" class="btn bt-danger right" >
                            <i  class="fa fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form method="post" action="<?php echo base_url().'ico/update_wallet_address'; ?>">
                            <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Address: <sup>*</sup></label>
                                            <input name="address" id="address_edit" type="text" class="form-control" value="" required autofocus>
                                            <input type="hidden" name="id" id="address_id" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-md-offset-3 m-t-40">
                                        <div class="form-group">
                                            <button class="btn btn-default btn-block btn-lg" type="submit">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                 </div>
            </div>
<!-- csv upload -->
<div class="modal-cs display_none" id="UploadCSV">
                <div class="modal-box">
                    <div class="modal-heading">
                        Upload a CSV of addresses

                        <button onclick="closeModel();" class="btn bt-danger right" >
                            <i  class="fa fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form enctype="multipart/form-data" method="post" action="<?php echo base_url().'ico/upload_wallet_addresses/'.$this->uri->segment(3); ?>">
                            <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div style="padding: 10px; text-align: center; background: red; color:#fff;">Please <a href="<?php echo base_url().'resources/frontend/sample.csv'; ?>" download>Download Sample Format</a> and check supported fromate before you upload yours.</div>

                                            <label>CSV: <sup>*</sup></label>
                                            <input name="csv[]" type="file" class="form-control" value="" required multiple>
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-md-offset-3 m-t-40">
                                        <div class="form-group">
                                            <button class="btn btn-default btn-block btn-lg" type="submit">
                                                Upload
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
        window.location='<?php echo base_url(); ?>ico/delete_wallet_address/'+val;
        return true;
    }
    else {
        return false;
    }
}
<?php } ?>

function closeModel()
{
     $(".modal-cs").hide();
}
function showAdd()
{
    closeModel();
    $("#modalAdd").show();
}

function showEdit(id,val)
{
    closeModel();
    $("#modalEdit").find('#address_edit').val(val);
    $("#modalEdit").find('#address_id').val(id);
    $("#modalEdit").show();
}
function showUploadCSV()
{
    closeModel();
    $("#UploadCSV").show();
}


</script>
