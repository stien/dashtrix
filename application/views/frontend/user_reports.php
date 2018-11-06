<?php require_once("common/header.php"); ?>
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
              <?php if(strpos_recursive(current_url(),'demo.blocktrics.io') && $this->uri->segment(4)!="whitelist"){ ?>
                <a class="btn btn-danger" href="<?php echo base_url();?>ico/export_for_accounts"><i class="fa fa-download"></i> Export For Accounts.IcoDashboad.io</a>
              <?php } ?>
<?php if($this->uri->segment(4)!="whitelist"){ ?>

<a class="btn btn-default" href="<?php echo base_url();?>admin/add/user"><i class="fa fa-plus"></i> Add New User</a>
<div class="btn-group">
<button type="button" class="btn btn-info">Export (ReadAble)</button>
<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
<ul class="dropdown-menu">

<li><a href="<?php echo base_url();?>admin/export/users/csv/all" >All</a></li>

<li><a href="<?php echo base_url();?>admin/export/users/csv/active" >Active</a></li>

<li><a href="<?php echo base_url();?>admin/export/users/inactive">In-Active</a></li>

<li><a href="<?php echo base_url();?>admin/export/users/csv/rejected" >Rejected</a></li>
<li><a href="<?php echo base_url();?>admin/export/users/csv/buyers" >Buyers</a></li>
<li><a href="<?php echo base_url();?>admin/export/users/csv/admins" >Admins</a></li>
<li><a href="<?php echo base_url();?>admin/export/emails/users" >Emails</a></li>
</ul>
</div>
<?php } ?>
                <?php /* ?>
                    <a class="btn btn-default" href="<?php echo base_url();?>admin/export/users/comma"><i class="fa fa-download"></i> Export Comma Seprated</a>
                    <a class="btn btn-default" href="<?php echo base_url();?>admin/export/users/tab"><i class="fa fa-download"></i> Export Tab Seprated</a>
                    <?php */ ?>
            </div>


            <?php 

         $c_p_link = 'users';
         if($this->uri->segment(5)=="whitelist")
            $c_p_link = 'pages?where=whitelist&there=1';
       

            
            require_once 'common/import_export.php'; ?>
            <h4 class="page-title">MANAGE <?php echo $this->uri->segment(4)=="whitelist"?"WHITELIST":""; ?> USERS</h4>
        </div>
    </div>


    <?php if(isset($_SESSION['thankyou'])){ ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="successfull">
                                <?php echo $_SESSION['thankyou']; ?>
                            </div>

                        </div>

                    </div>

                    <?php } ?>
                        <?php if(isset($_SESSION['error'])){ ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="wrongerror">
                                        <?php echo $_SESSION['error'];?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

    <div class="row">
                
    </div>
    <div class="row">
        <div class="col-lg-12">



            <div class="card-box m-b-50">
                
                                <div class="table-responsive">
                                    <table class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">
                                        <thead>

                                            <tr>
                                                <th>Name</th>
                                                <!-- <th>Username</th> -->
                                                <th>Email Address</th>
                                                <th>Phone</th>
                                                <th>Country</th>
                                                <th>Created</th>
                                                <!-- <th>Type</th> -->
                                                <th>Refered By </th>
                                                <th>Balance </th>
                                                <th>Status </th>
                                                <th>KYC Verified </th>
                                                <th>Email Verified </th>
                                                <?php if(am_i('securix')){ ?>
                                                <th>Receipts </th>
                                              <?php } ?>
                                                <?php if($this->uri->segment(4)=="whitelist"){ ?><th>Dashboard Access </th> <?php } ?>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php   
                                         $arr = array('del'=>0,"whitelist"=>0); 
                                         if($this->uri->segment(4)=="whitelist")
                                          $arr['whitelist']=1;

                                        $config = $this->front_model->get_query_orderby('*','dev_web_user',$arr,'uID','DESC');  
                                         $transctions    = $config->result_object();
                                           ?>
                                            <tbody>
                                                <?php                           foreach($transctions AS $row){

       $arucon = array('id' => $row->uCountry); 
        $conqry = $this->front_model->get_query_simple('*','dev_web_countries',$arucon);
        $countries  = $conqry->result_object();   
        $arusr = array('uID' => $row->uID);
         $usrqry = $this->front_model->get_query_simple('*','dev_web_transactions',$arusr);                              
         $user   = $usrqry->result_object();  

$verification_details = $this->front_model->get_query_simple('*','dev_web_user_verification',array('uID'=>$row->uID,'deleted'=>0))->result_object()[0];

           ?>
                                                    <tr>
                                                        <td title="<?php echo $row->uFname. " ".$row->uLname;?>">
                                                            <?php echo substr( $row->uFname. " ".$row->uLname,0,10)."...";?>
                                                        </td>
                                                       
                                                        <td>
                                                            <?php echo $row->uEmail;?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->uPhone;?>
                                                        </td>
                                                        <td>
                                                            <?php echo $countries[0]->nicename;?>
                                                        </td>
                                                        <td>
                                                            <?php echo date("m/d/y",strtotime($row->joinDate));?>
                                                        </td>

                                                       
                                                                <td>
                                                                    <?php
          $referred_by  = $this->db->where('uID',$row->referrer)->get('dev_web_user')->result_object();
          if(!empty($referred_by))
            echo $referred_by[0]->uFname.' '.$referred_by[0]->uLname;
          else
            echo '--';

           ?>
                                                                </td>
            <td>
              <?php echo get_my_tokens($row->uID); ?>
            </td>

                                                       
                                                        <td>
                                                            <?php                                       if($row->uStatus == "0"){echo "<div class='status-pending'>In-Active</div>";}
                                                             else if($row->uStatus == "1"){echo "<div class='status-confirm'>Active</div>";}
                                                             else if($row->uStatus == "2"){echo "<div class='status-cancelled'>Rejected</div>"; }
?>
                                                        </td>
<td>
          <?php       
     if($verification_details->uStatus  == 2 || $row->kyc_verified==1){
            echo "<div class='status-confirm'>Yes</div>";
      } 
      else {
      echo "<div class='status-cancelled'>No</div>";
       }                                   
     ?>
 </td>
 <td>
          <?php       
     if($row->uverifyemail  == 1){
            echo "<div class='status-confirm'>Yes</div>";
      } 
      else {
      echo "<div class='status-cancelled'>No</div>";
       }                                   
     ?>
 </td>
                                                <?php if(am_i('securix')){ ?>

<td>
  <a target="_blank" href="<?php echo base_url().'admin/receipts/'.$row->uID; ?>">
    <button type="button" class="btn btn-default">
      <i class="fa fa-tv"></i> View (<?php

        echo $this->db->where('receipt_name !=',"")->where('uID',$row->uID)->count_all_results('dev_web_transactions');
   ?>)
    </button>
  </a>
  
</td>
<?php } ?>

 <?php if($this->uri->segment(4)=="whitelist"){ ?>

<td>
<?php 

$ablility_level = json_decode($row->whitelist_settings)->ability;

if($ablility_level=="1")
  echo "Full Access";
if($ablility_level=="2")
  echo "Can't buy tokens";
if($ablility_level=="3")
  echo "waiting to be invited";

 ?>
 <div class="btn-group">
        <button type="button" class="btn btn-info">Change Access</button>
        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
        <ul class="dropdown-menu">
                                                                    
           <li><a href="javascript:;" onClick="changeAccess(1,<?php echo $row->uID;?>);">Full Access</a></li>
           <li><a href="javascript:;" onClick="changeAccess(2,<?php echo $row->uID;?>);">Can't Buy Tokens</a></li>
           <li><a href="javascript:;" onClick="changeAccess(3,<?php echo $row->uID;?>);">Wait for invitation</a></li>

 
 
  </ul>
              
</div>


</td>
  <?php } ?>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-info">Actions</button>
                                                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
                                                                <ul class="dropdown-menu">
                                                                    

    <?php                                       
    if($row->uStatus == "1"){                                  
         ?>
         
           <li><a href="javascript:;" onClick="btnstatusupdate(0,<?php echo $row->uID;?>);">In-Active</a></li>
    
     <?php } else { ?>

  <li><a href="javascript:;" onClick="btnstatusupdate(1,<?php echo $row->uID;?>);">Active</a></li>

<?php }
 if($verification_details->uStatus != 1 && $row->kyc_verified!=1){
  ?>
   
   <li>
    <a href="javascript:;" onClick="btnstatusupdate2(<?php echo $row->uID;?>,<?php echo $verification_details->id?$verification_details->id:-1;?>);">KYC Verified</a>
  </li>
   
    <?php }  if($row->uverifyemail  != 1){ ?>
<li><a href="javascript:;" onClick="btnstatusupdate3(<?php echo $row->uID;?>);">Email Verified</a></li>

    <?php } ?>





 <li><a href="javascript:;" onClick="add_tokens(<?php echo $row->uID;?>,'<?php echo custom_number_format(get_my_tokens($row->uID),decimals_()); ?>');">Add Tokens</a></li>
 <li><a href="javascript:;" onClick="btnstatusdelete(<?php echo $row->uID;?>);">Delete</a></li>

 <li><a href="<?php echo base_url().'admin/user/'.$row->uID; ?>">View</a></li>
 
  </ul>
              
              </div>
              
               </td>
             
              </tr>
           
            <?php } ?>
        
          </tbody>
     
      </table>
   
     </div>
  
   </div>

</div>


<div class="modal-cs display_none ask_reason" >
    <div class="modal-box">
        <div class="modal-heading">
            <h4 class="left">Add Tokens</h4>

            <button onclick="closeModel();" class="btn bt-danger right" >
                <i  class="fa fa-times"></i>
            </button>
        </div>

        <div class="modal-body">
            <form method="post" action="<?php echo base_url();?>ico/add_tokens">
                <div class="row">

                    <div class="col-md-12">
                      <div class="form-group">
                        <b>Current Balance: </b>
                        <label id="current_balance">--.--</label>
                      </div>
                    </div>

                    <div class="col-md-12">
                            <div class="form-group">
                                <label>Tokens: </label>
                                <input type="number" step="0.1" name="balance" required class="form-control">
                                <input type="hidden" name="id" id="user_id">
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


<!-- end col -->
    </div>
    <?php require_once("common/footer.php");?>
        <script language="javascript">
            <?php if(ACTYPE == "1"){?>
            function btnstatusupdate(val, id) {
                var x = confirm("Are you sure you want to perform this action?");
                if (x) {
                    window.location = '<?php echo base_url(); ?>admin/do/action/user/' + val + '/' + id;
                    return true;
                } else {
                    return false;
                }
            }

            function btnstatusupdate2(val, id) {
                var x = confirm("Are you sure you want to perform this action?");
                if (x) {
                    window.location = '<?php echo base_url(); ?>ico/account_status_verification/' + val + '/' + id;
                    return true;
                } else {
                    return false;
                }
            }
            function changeAccess(val, id) {
                var x = confirm("Are you sure you want to perform this action?");
                if (x) {
                    window.location = '<?php echo base_url(); ?>ico/change_access/' + val + '/' + id;
                    return true;
                } else {
                    return false;
                }
            }
            function btnstatusupdate3(val) {
                var x = confirm("Are you sure you want to perform this action?");
                if (x) {
                    window.location = '<?php echo base_url(); ?>ico/manually_verify_email/' + val;
                    return true;
                } else {
                    return false;
                }
            }

            function btnstatusdelete(id) {
                var x = confirm("Are you sure you want to Remove this user? All data & created bounties will be removed against this user");
                if (x) {
                    window.location = '<?php echo base_url(); ?>ico/remove_user/' + id;
                    return true;
                } else {
                    return false;
                }
            }
            function add_tokens(id,bal)
            {

                  $("#current_balance").html(bal)
                  $("#user_id").val(id)

                  $(".ask_reason").show();
                  return;
              
            }
            function closeModel()
            {
              $(".modal-cs").hide();
            }
            <?php } ?>
        </script>