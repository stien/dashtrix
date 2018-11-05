<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">


            


        <div class="button-list pull-right m-t-15">
            <a class="btn btn-default" href="<?php echo base_url();?>admin/add-question"><i class="fa fa-plus"></i> Add New Question</a>
        </div>
        <?php 
        $c_p_link = 'questions';
        require_once 'common/import_export.php'; ?>

        <h4 class="page-title">MANAGE QUESTIONS</h4>
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
                            	<th >Question</th>
                            	<th >Required</th>
                            	<th >Action</th>
                            </tr>
                    	</thead>
                    	
                    	<tbody>
                    	<?php 
							foreach($qs AS $row){
							
								
								 
						?>
                    		<tr>
                    			<td title="<?php echo $row->q; ?>"><?php echo substr($row->q,0,100); ?></td>
                    			 

                                <td><?php 
                                        if($row->required == "1"){echo "<div class='status-pending'>Yes</div>";} 
                                        else if($row->required == "0"){echo "<div class='status-confirm'>Yes</div>";} 
                                        
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
										<li><a href="<?php echo base_url().'admin/edit-question/'.$row->id; ?>" >Edit</a></li>
										
										<li><a href="javascript:;" onClick="btnstatusupdate(1,<?php echo $row->id;?>);">Delete</a></li>
										
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
		window.location='<?php echo base_url(); ?>ico/delete_question/'+id;
		return true;
	}
	else {
		return false;
	}
}
<?php } ?>
</script>
