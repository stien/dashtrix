<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">


            


        <div class="button-list pull-right m-t-15">
            <a class="btn btn-default" href="<?php echo base_url();?>admin/add/campaign"><i class="fa fa-plus"></i> Add New Campaign</a>
        </div>
        <?php 
        $c_p_link = 'user-onboarding';
        require_once 'common/import_export.php'; ?>

        <div class="button-list pull-right m-t-15 " style="margin-right: 5px;">
                <a class="btn btn-primary" href="<?php echo base_url();?>admin/questions"><i class="fa fa-question"></i> Questions</a>
            </div>

            <div class="button-list pull-right m-t-15"  style="margin-right: 5px;">
                <a class="btn btn-primary" href="<?php echo base_url();?>admin/links"><i class="fa fa-link"></i> Links</a>
            </div>

        <h4 class="page-title">Manage User On-Boarding Slides</h4>
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
                            	<th >User Type</th>
                            	<th >Award Tokens</th>
                            	<th >Created</th>
                                <th >Status </th>
                            	<th >Slides </th>
                            	<th >Action</th>
                            </tr>
                    	</thead>
                    	<?php
							$arr = array();
							$config = $this->front_model->get_query_orderby('*','dev_web_user',$arr,'uID','DESC');
							$transctions 	= $config->result_object();
						?>
                    	<tbody>
                    	<?php 
							foreach($camps AS $row){
								$arucon = array('camp_id' => $row->uCountry);
								$conqry = $this->front_model->get_query_simple('*','dev_web_camp_slides',$arucon);
								$slides 	= $conqry->result_object();	
								
								 
						?>
                    		<tr>
                    			<td title="<?php echo $row->title; ?>"><?php echo substr($row->title,0,20); ?></td>
                    			<td title="<?php echo $row->description; ?>"><?php echo substr($row->description,0,20); ?></td>

                                <td><?php 
                                        if($row->user_type == "1"){echo "<div class='status-pending'>Admin</div>";} 
                                        else if($row->user_type == "2"){echo "<div class='status-confirm'>Buyer</div>";} 
                                        else if($row->user_type == "4"){echo "<div class='status-confirm'>Airdrop</div>";}
                                        else if($row->user_type == "3"){echo "<div class='status-confirm'>Marketing</div>";}
                                    ?>
                                </td>
                    			<td><?php echo $row->award_tokens;?></td>
                                <td><?php echo date("m/d/y",strtotime($row->created_at));?></td>


                                <td><?php 
                                        if($row->active == "0")
                                            {

                                                ?>

                                                <a href="<?php echo base_url().'ico/activate_camp/'.$row->id; ?>">

                                                    <div class='status-pending'>In-Active</div>

                                                </a>

                                                <?php }
                                        else if($row->active == "1"){

                                            ?>

                                                    <a href="<?php echo base_url().'ico/deactivate_camp/'.$row->id; ?>">
                                                         <div class='status-confirm'>Active</div>
                                                     </a>

                                            <?php }                                        
                                    ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url().'admin/campaign-slides/'.$row->id; ?>">
                                        <button class="btn btn-default">Slides</button>
                                    </a>
                                </td>
                    		 
                    			
                    			
                    			<td>
                    				
                    				<div class="btn-group">
									  <button type="button" class="btn btn-info">Actions</button>
									  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									  </button>
									  <ul class="dropdown-menu">
									  	
                                        <li><a href="<?php echo base_url().'admin/campaign-slides/'.$row->id; ?>" >Slides</a></li>
										<li><a href="<?php echo base_url().'admin/edit-campaign/'.$row->id; ?>" >Edit</a></li>

                                        <?php 
                                        if($row->active == "1"){ 
                                        ?>
                                        <li><a href="javascript:;" onClick="btnstatusupdate2(0,<?php echo $row->id;?>);">In-Active</a></li>
                                        <?php } else { ?>
                                        <li><a href="javascript:;" onClick="btnstatusupdate3(1,<?php echo $row->id;?>);">Active</a></li>
                                        <?php } ?>



										
                                        <li><a href="javascript:;" onClick="btnstatusupdate(1,<?php echo $row->id;?>);">Delete</a></li>
										<li><a href="<?php echo current_url().'?preview=1&id='.$row->id; ?>">Preview</a></li>
										
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
		window.location='<?php echo base_url(); ?>ico/delete_camp/'+id;
		return true;
	}
	else {
		return false;
	}
}

function btnstatusupdate2(val,id){
    var x = confirm("Are you sure you want to perform this action?");
    if (x){
        window.location='<?php echo base_url(); ?>ico/deactivate_camp/'+id;
        return true;
    }
    else {
        return false;
    }
}

function btnstatusupdate3(val,id){
    var x = confirm("Are you sure you want to perform this action?");
    if (x){
        window.location='<?php echo base_url(); ?>ico/activate_camp/'+id;
        return true;
    }
    else {
        return false;
    }
}
<?php } ?>
</script>
<?php
    if($_GET['preview']==1)
    {
        $preview_admin=1;
        $preview_admin_id = $_GET['id'];
        require_once('common/compaign.php');
    }
 ?>
