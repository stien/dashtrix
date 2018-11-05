<?php require_once("common/header.php");?>


<?php /*?>        <!-- Page-Title -->
<div class="row">
    <div class="col-sm-12 m-b-30">
        <div class="button-list pull-right m-t-15">
            <a class="btn btn-white" href="requests-group.html">Join group request</a>
            <a class="btn btn-default" href="requests-draft-create.html">Create request</a>
        </div>

        <h4 class="page-title">Dashboard</h4>
        <p class="text-muted">Hello <b>Inspiron Trade</b>!</p>
    </div>
</div>
<div class="row">
    <div class="col-md-8">

        <div class="card-box widget-box-1">
            <h4 class="header-title m-t-0">Requests</h4>

        </div>

    </div>
    <!-- end col -->

    <div class="col-md-3 col-md-offset-1">
        <div class="widget-box-2">
            <h4 class="header-title m-t-0">Account</h4>
            <p class="text-muted font-13">
                You are currently on starter plan.
            </p>
            <a href="packages.html" type="button" class="btn btn-white waves-effect">Upgrade package</a>
            <hr>
            <h4 class="header-title m-t-0 m-b-15">Help</h4>
            <a href="#" class="font-13"></a>
            <br />
            <a href="#" class="font-13">Get started</a>
            <hr>
            <h4 class="header-title m-t-0 m-b-15">Blog</h4>
            <a href="#" class="font-13">Blog article name</a>
            <br />
            <a href="#" class="font-13">Blog sample</a>
            <br />
            <a href="#" class="font-13">Sample article</a>
        </div>
    </div>
    <!-- end col -->
</div><?php */?>



    
	<?php if(ACTYPE == "2" && $this->uri->segment(1) == "dashboard"){?>
   <div class="row">
         <div class="col-sm-12 m-b-30">
        <div class="button-list pull-right m-t-15">
            <a class="btn btn-default" href="<?php echo base_url().'buy-tokens'; ?>">Buy Token</a>
        </div>

        <h4 class="page-title">Transactions</h4>
    </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box m-b-50">
                <div class="table-responsive">
                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">
                    	<thead>
                    	<tr>
                    	<th >Date</th>
                    	<th >Tokens</th>
                    	<th >Currency</th>
                    	<th >Amount Paid</th>
                    	<th >Status </th>
                    	<th >Action</th></tr>
                    	</thead>
                    	<?php
							$arr = array('uID' => UID);
							$config = $this->front_model->get_query_simple('*','dev_web_transactions',$arr);
							$transctions 	= $config->result_object();
						?>
                    	<tbody>
                    	<?php 
							foreach($transctions AS $row){
								$arrcur = array('id' => $row->currency);
								$cour = $this->front_model->get_query_simple('*','dev_web_payment_options',$arrcur);
								$currency 	= $cour->result_object();
								//echo $row->datecreated;
						?>
                    		<tr>
                    			<td><?php echo date("m/d/y",strtotime($row->datecreated));?></td>
                    			<td><?php echo $row->tokens;?></td>
                    			<td><?php echo $currency[0]->name;?></td>
                    			<td><?php echo $row->amountPaid;?> <?php echo $row->amtType;?></td>
                    			<td><?php 
										if($row->status == "1"){echo "<div class='status-pending'>Pending</div>";} 
										else if($row->status == "2"){echo "<div class='status-confirm'>Confirmed</div>";} 
										else if($row->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}
										else if($row->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}
									?>
                   				</td>
                    			<td>
                                    <a href="<?php echo base_url().'transaction-details/'.$row->tID; ?>">
                                        <button class="btn btn-sm btn-default">
                                            View Details
                                        </button>
                                       
                                    </a>
                            </td>
                    		</tr>
                    	<?php } ?>
                    	</tbody>
                    </table>
                </div>
            </div>

        </div> <!-- end col -->
    </div>
    <?php } else if(ACTYPE == "1" && $this->uri->segment(1) == "admin" && $this->uri->segment(2) == "tranasctions"){ ?>
    <div class="row">
         <div class="col-sm-12 m-b-30">
        	<h4 class="page-title">Transactions</h4>
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
                <div class="">
                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">
                    	<thead>
                    	<tr>
                    	<th >Name</th>
                    	<th >Username</th>
                    	<th >Tokens</th>
                    	<th >Currency</th>
                    	<th >Amount Paid</th>
                    	<th >Date</th>
                    	
                    	<th >Status </th>
                    	<th >Action</th></tr>
                    	</thead>
                    	<?php
							$arr = array();
							$config = $this->front_model->get_query_simple('*','dev_web_transactions',$arr);
							$transctions 	= $config->result_object();
						?>
                    	<tbody>
                    	<?php 
							foreach($transctions AS $row){
								$arrcur = array('curID' => $row->currency);
								$cour = $this->front_model->get_query_simple('*','dev_web_currency',$arrcur);
								$currency 	= $cour->result_object();
								//echo $row->datecreated;
								$arusr = array('uID' => $row->uID);
								$usrqry = $this->front_model->get_query_simple('*','dev_web_user',$arusr);
								$user 	= $usrqry->result_object();
						?>
                    		<tr>
                    			<td title="<?php echo $user[0]->uFname. " ".$user[0]->uLname;?>"><?php echo substr( $user[0]->uFname. " ".$user[0]->uLname,0,10)."...";?></td>
                    			<td><?php echo $user[0]->uUsername;?></td>
                    			<td><?php echo $row->tokens;?></td>
                    			<td><?php echo $currency[0]->currencyName;?></td>
                    			<td><?php echo $row->amountPaid;?> <?php echo $row->amtType;?></td>
                    			<td><?php echo date("m/d/y",strtotime($row->datecreated));?></td>
                    			
                    			<td><?php 
										if($row->status == "1"){echo "<div class='status-pending'>Pending</div>";} 
										else if($row->status == "2"){echo "<div class='status-confirm'>Confirmed</div>";} 
										else if($row->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}
										else if($row->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}
									?>
                   				</td>
                    			<td>
                    				<?php 
										if($row->status == "1"){ ?>
                    				<div class="btn-group">
									  <button type="button" class="btn btn-info">Edit</button>
									  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									  </button>
									  <ul class="dropdown-menu">
										<li><a href="javascript:;" onClick="btnstatusupdate(2,<?php echo $row->tID;?>);">Conﬁrmed</a></li>
										<!--<li><a href="javascript:;" onClick="btnstatusupdate(1);">Pending</a></li>-->
										<li><a href="javascript:;" onClick="btnstatusupdate(3,<?php echo $row->tID;?>);">Cancelled</a></li>
										<li><a href="javascript:;" onClick="btnstatusupdate(4,<?php echo $row->tID;?>);">Refunded</a></li>
									  </ul>
									</div>
                    				<?php } ?>
                    			</td>
                    		</tr>
                    	<?php } ?>
                    	</tbody>
                    </table>
                </div>
            </div>

        </div> <!-- end col -->
    </div>
    <?php } else if(ACTYPE == "1" && $this->uri->segment(1) == "dashboard"){ ?>
    	<div class="row">
         <div class="col-sm-12 m-b-30">
        	<h4 class="page-title">WELCOME TO ADMIN DASHBOARD</h4>
    	</div>
    	</div>
    	<div class="row">
			<div class="col-sm-4 m-b-30">
				<div class="card-box widget-box-1 boxdisplay">
					<span><?php echo number_format($this->front_model->totaltokensolds());?></span>
					<p>Tokens Sold</p>
				</div>	
			</div>	
   			
   			<div class="col-sm-4 m-b-30">
				<div class="card-box widget-box-1 boxdisplay">
					<span>$54,200</span>
					<p>Total Raised</p>
				</div>	
			</div>	
  			
  			<div class="col-sm-4 m-b-30">
				<div class="card-box widget-box-1 boxdisplay">
					<span><?php echo number_format($this->front_model->totaltransactions());?></span>
					<p>Transactions</p>
				</div>	
			</div>	
  			
  			<div class="col-sm-4 m-b-30">
				<div class="card-box widget-box-1 boxdisplay">
					<span><?php echo number_format($this->front_model->totalvisitors());?></span>
					<p>Visitors</p>
				</div>	
			</div>	
  			
  			<div class="col-sm-4 m-b-30">
				<div class="card-box widget-box-1 boxdisplay">
					<span><?php echo number_format($this->front_model->totalusers());?></span>
					<p>Users</p>
				</div>	
			</div>	
  			
  			<div class="col-sm-4 m-b-30">
				<div class="card-box widget-box-1 boxdisplay">
					<span>0</span>
					<p>Affiliates</p>
				</div>	
			</div>	
   			
   			
    	</div>
    <?php } ?>
    
<?php require_once("common/footer.php");?>
<script language="javascript">
<?php if(ACTYPE == "1"){?>
function btnstatusupdate(val,id){
	var x = confirm("Are you sure you want to perform this action?");
	if (x){
		window.location='<?php echo base_url(); ?>admin/do/action/tranasctions/'+val+'/'+id;
		return true;
	}
	else {
		return false;
	}
}
<?php } ?>
</script>
