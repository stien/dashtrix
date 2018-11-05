<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">

             <div class="button-list pull-right m-t-15">
            <a class="btn btn-default" href="<?php echo base_url();?>admin/add-publication"><i class="fa fa-plus"></i> Add New </a>
        </div>
        <h4 class="page-title">MANAGE CONTENT PROMOTIONS</h4>
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

                            <th >Logo </th>
                            <th >Link </th>
                            <th >Price </th>
                            <th >Status </th>
                    	   <th >Action</th>
                        </tr>
                    	</thead>

                    	<tbody>
                    	<?php
							foreach($contents AS $row){
						?>
                    		<tr>
                    			<td>
                                    <img src="<?php echo base_url().'resources/uploads/marketing/'.$row->logo;?>" width="100">
                                </td>
                    			<td>
                                    <a href="<?php echo $row->link;?>"><?php echo $row->link;?></a>
                                </td>
                                <td>
                                   $<?php echo $row->price;?>
                                </td>

                    			<td><?php
										if($row->status == "0"){echo "<div class='status-pending'>In-Active</div>";}
										else if($row->status == "1"){echo "<div class='status-confirm'>Active</div>";}

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
                                        <li><a href="<?php echo base_url().'admin/edit-publication/'.$row->id; ?>" >Edit</a></li>


									  	<?php
										if($row->status == "1"){
										?>
										<li><a href="javascript:;" onClick="btnstatusupdate(0,<?php echo $row->id;?>);">In-Active</a></li>
										<?php } else { ?>
										<li><a href="javascript:;" onClick="btnstatusupdate(1,<?php echo $row->id;?>);">Active</a></li>
										<?php } ?>

                                        <li><a href="javascript:;" onClick="btnstatusupdated(<?php echo $row->id;?>);">Delete</a></li>

										<?php /*?><li><a href="javascript:;" onClick="btnstatusdelete(<?php echo $row->uID;?>);">Delete</a></li><?php */?>
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
		window.location='<?php echo base_url(); ?>ico/update_publication_status/'+val+'/'+id;
		return true;
	}
	else {
		return false;
	}
}
function btnstatusupdated(id){
    var x = confirm("Are you sure you want to perform this action?");
    if (x){
        window.location='<?php echo base_url(); ?>ico/delete_publication/'+id;
        return true;
    }
    else {
        return false;
    }
}
<?php } ?>
</script>
