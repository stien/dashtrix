<?php require_once("common/header.php");?> 
<div class="row">   
<div class="col-sm-12 m-b-30">  
<div class="button-list pull-right m-t-15">   
<a class="btn btn-default" href="<?php echo base_url();?>admin/add/user"><i class="fa fa-plus"></i> Add New User</a> 
<a class="btn btn-default" href="<?php echo base_url();?>admin/export/users/csv"><i class="fa fa-download"></i> Export CSV</a> 
<?php /* ?>
<a class="btn btn-default" href="<?php echo base_url();?>admin/export/users/comma"><i class="fa fa-download"></i> Export Comma Seprated</a> 
<a class="btn btn-default" href="<?php echo base_url();?>admin/export/users/tab"><i class="fa fa-download"></i> Export Tab Seprated</a> 
<?php */ ?>
</div>    
<h4 class="page-title">MANAGE USERS</h4>  
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
		   	<th >Username</th>                    	<th >Email Address</th>                    	<th >Phone</th>                    	<th >Country</th>                    	<th >Created</th>                    	<th >Type</th>                         <th >Reffered By </th>   <th >Status </th>                            <th >Acount Status </th>                    	<th >Action</th></tr>                    	</thead>                    	<?php							$arr = array('del'=>0);							$config = $this->front_model->get_query_orderby('*','dev_web_user',$arr,'uID','DESC');							$transctions 	= $config->result_object();						?>                    	<tbody>                    	<?php 							foreach($transctions AS $row){								$arucon = array('id' => $row->uCountry);								$conqry = $this->front_model->get_query_simple('*','dev_web_countries',$arucon);								$countries 	= $conqry->result_object();																	$arusr = array('uID' => $row->uID);								$usrqry = $this->front_model->get_query_simple('*','dev_web_transactions',$arusr);								$user 	= $usrqry->result_object();						?>                    		<tr>                    			<td title="<?php echo $row->uFname. " ".$row->uLname;?>"><?php echo substr( $row->uFname. " ".$row->uLname,0,10)."...";?></td>                    			<td><?php echo $row->uUsername;?></td>                    			<td><?php echo $row->uEmail;?></td>                    			<td><?php echo $row->uPhone;?></td>                    			<td><?php echo $countries[0]->nicename;?></td>                    			<td><?php echo date("m/d/y",strtotime($row->joinDate));?></td>                    			<td><?php 										if($row->uActType == "1"){echo "<div class='status-pending'>Admin</div>";} 										else if($row->uActType == "2"){echo "<div class='status-confirm'>Buyer</div>";} 										else if($row->uActType == "4"){echo "<div class='status-confirm'>Airdrop</div>";}										else if($row->uActType == "3"){echo "<div class='status-confirm'>Marketing</div>";}									?>  
        <td>
          <?php
          $referred_by  = $this->db->where('uID',$row->referrer)->get('dev_web_user')->result_object();
          if(!empty($referred_by))
            echo $referred_by[0]->uFname.' '.$referred_by[0]->uLname;
          else
            echo '--';

           ?>
        </td>

                         				</td>                    			<td><?php 										if($row->uStatus == "0"){echo "<div class='status-pending'>In-Active</div>";} 										else if($row->uStatus == "1"){echo "<div class='status-confirm'>Active</div>";} 										//else if($row->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}										//else if($row->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}									?>                   				</td>                                <td><?php                                    if($row->account_status == "0"){echo "<div class='status-pending'>Problem</div>";}                                    else if($row->account_status == "1"){echo "<div class='status-confirm'>OK</div>";}                                    //else if($row->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}                                    //else if($row->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}                                    ?>                                </td>                    			<td>                    				                    				<div class="btn-group">									  <button type="button" class="btn btn-info">Actions</button>									  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">										<span class="caret"></span>										<span class="sr-only">Toggle Dropdown</span>									  </button>									  <ul class="dropdown-menu">									  	<?php 										if($row->uStatus == "1"){ 										?>										<li><a href="javascript:;" onClick="btnstatusupdate(0,<?php echo $row->uID;?>);">In-Active</a></li>										<?php } else { ?>										<li><a href="javascript:;" onClick="btnstatusupdate(1,<?php echo $row->uID;?>);">Active</a></li>										<?php } ?>                                          <?php                                          if($row->account_status == "1"){                                              ?>                                              <li><a href="javascript:;" onClick="btnstatusupdate2(0,<?php echo $row->uID;?>);">Account - Problem</a></li>                                          <?php } else { ?>                                              <li><a href="javascript:;" onClick="btnstatusupdate2(1,<?php echo $row->uID;?>);">Account - OK</a></li>                                          <?php } ?>                                          <li><a href="javascript:;" onClick="btnstatusdelete(<?php echo $row->uID;?>);">Delete</a></li>                                          <li><a href="<?php echo base_url().'admin/user/'.$row->uID; ?>" >View</a></li>									  </ul>									</div>                    				                    			</td>                    		</tr>                    	<?php } ?>                    	</tbody>                    </table>                </div>            </div>        </div> <!-- end col -->    </div><?php require_once("common/footer.php");?><script language="javascript"><?php if(ACTYPE == "1"){?>function btnstatusupdate(val,id){	var x = confirm("Are you sure you want to perform this action?");	if (x){		window.location='<?php echo base_url(); ?>admin/do/action/user/'+val+'/'+id;		return true;	}	else {		return false;	}}function btnstatusupdate2(val,id){    var x = confirm("Are you sure you want to perform this action?");    if (x){        window.location='<?php echo base_url(); ?>ico/account_status/'+val+'/'+id;        return true;    }    else {        return false;    }}	function btnstatusdelete(id){		var x = confirm("Are you sure you want to Remove this user? All data & created bounties will be removed against this user");		if (x){			window.location='<?php echo base_url(); ?>ico/remove_user/'+id;			return true;		}		else {			return false;		}			}<?php } ?></script>