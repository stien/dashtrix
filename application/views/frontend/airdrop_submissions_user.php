<?php require_once("common/header.php");?>

    <div class="row">
         <div class="col-sm-12 m-b-30">
     

        <h4 class="page-title">Bounty Campaign Submissions</h4>
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

                        <th >Username</th>
                        <th >Name</th>
                        <th >Amount</th>
                       
                    	<th >Status </th>
                    	<th >Action</th></tr>
                    	</thead>
                    	<?php
							$arr = array('uID'=>UID);
							$config = $this->front_model->get_query_orderby('*','dev_web_airdrop_submissions',$arr,'id','DESC');
							$camps 	= $config->result_object();


						?>
                    	<tbody>
                    	<?php 
							foreach($camps AS $row){

                            $arr = array('uID'=>$row->uID);

                            $user = $this->front_model->get_query_simple('*','dev_web_user',$arr)->result_object()[0];

                             $arr = array('id'=>$row->camp_id);

                            $camp_self= $this->front_model->get_query_simple('*','dev_web_airdrop_campaigns',$arr)->result_object()[0];
								
						?>
                    		<tr>
                                <td><?php echo $user->uUsername;?></td>
                                <td>
                                    <a href="<?php echo base_url().'view-airdrop-campaign/'.$camp_self->id; ?>">
                                        <?php echo $camp_self->name;?>
                                    </a>
                                </td>

                                
                    			<td>
                           
                                 <?php echo number_format($camp_self->bounty_qty/$camp_self->bounty_persons,decimals_()); ?>
                                </td>
                    			<td><?php 
										if($row->status == "1"){echo "<div class='status-confirm'>Confirmed</div>";} 
                                        else if($row->status == "0"){echo "<div class='status-pending'>Pending</div>";} 
										else if($row->status == "2"){echo "<div class='status-pending'>Rejected</div>";} 
										
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
									  	

                                        <li><a href="<?php echo base_url().'view-user-bounty-submission/'.$row->id ?>" >View</a></li>

										
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
