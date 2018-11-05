<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">
        

            
            <h4 class="page-title">EMAILS








                <?php 
        $c_p_link = 'email-settings';
        require_once 'common/import_export.php'; ?>


            </h4>


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
                            	<th >Name </th>                            	
                                <th >Subject </th>
                                <th >Email </th>
                                <th >Code</th>
                            	<th >Action </th>
                            </tr>
                    	</thead>
                    	<tbody>
                    	<?php 
							foreach($emails AS $row){
								
						?>
                    		<tr>
                                <td title="<?php echo $row->eName;?>"><?php echo $row->eName;?></td>
                                <td title="<?php echo $row->eSubject;?>"><?php echo $row->eSubject;?></td>
                                <td title="<?php echo $row->eEmail;?>"><?php echo $row->eEmail;?></td>
                                <td title="<?php echo $row->eCode;?>"><?php echo $row->eCode;?></td>

                    			<td>
                    				
                    				<div class="btn-group">
									  <button type="button" class="btn btn-info">Actions</button>
									  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									  </button>
									  <ul class="dropdown-menu">

                                        <li><a href="<?php echo base_url().'admin/edit-email/'.$row->eID; ?>" >Edit</a></li>
								        <?php /* ?>
                                        <li><a href="javascript:;" onClick="btnstatusdelete(<?php echo $row->eID;?>);">Delete</a></li>
                                        <?php */ ?>

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

function btnstatusdelete(val){
    var x = confirm("Are you sure you want to perform this action?");
    if (x){
        window.location='<?php echo base_url(); ?>ico/delete_email/'+val;
        return true;
    }
    else {
        return false;
    }
}
<?php } ?>


</script>
