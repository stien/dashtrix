<?php require_once("common/header.php");?>
    <div class="row">
        <div class="col-sm-12 m-b-30">
<?php 
        $c_p_link = 'verifications';
        require_once 'common/import_export.php'; ?>
            <div class="button-list pull-right m-t-15">
               
               

<div class="btn-group">
<button type="button" class="btn btn-info">Export (ReadAble)</button>
<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
<ul class="dropdown-menu">

<li><a href="<?php echo base_url().'ico/export_verifications/all'; ?>" >All</a></li>

<li><a href="<?php echo base_url().'ico/export_verifications/pending'; ?>" >Pending</a></li>

<li><a href="<?php echo base_url().'ico/export_verifications/accepted'; ?>">Accepted</a></li>

<li><a href="<?php echo base_url().'ico/export_verifications/rejected'; ?>" >Rejected</a></li>
</ul>
</div>


               
            </div>

            
           
            <h4 class="page-title">USER VERIFICATIONS</h4>
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
<table class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">
<thead>

<tr>
<th>Date</th>

<th>Name</th>
<th>Username</th>
<th>Email Address</th>
<th>Status </th>
<th>Action</th>
</tr>
</thead>
<?php 


$arr = array('deleted'=>0);  

$config = $this->front_model->get_query_orderby('*','dev_web_user_verification',$arr,'id','DESC');
$transctions  = $config->result_object();
 ?>
<tbody>
<?php               foreach($transctions AS $row){ 
$arucon = array('id' => $row->uCountry);
$conqry = $this->front_model->get_query_simple('*','dev_web_countries',$arucon);
$countries  = $conqry->result_object(); 

$arucon = array('uID' => $row->uID);
$conqry = $this->front_model->get_query_simple('*','dev_web_user',$arucon);
$user  = $conqry->result_object()[0];  
?>
<tr>
 <td>
<?php echo date("m/d/y",strtotime($row->datecreated));?>
</td>
<td title="<?php echo $row->uFname. " ".$row->uMname. " ".$row->uLname;?>">
<?php echo $row->uFname. " ".$row->uMname. " ".$row->uLname; ?>
</td>
<td>
<?php echo $user->uUsername;?>
</td>
<td>
<?php echo $user->uEmail;?>
</td>

<td>
<?php
if($row->uStatus == "0"){echo "<div class='status-pending'>Pending</div>";}
else if($row->uStatus == "1"){echo "<div class='status-confirm'>Accepted</div>";}
else if($row->uStatus == "2"){echo "<div class='status-cancelled'>Rejected</div>";}
?>


</td>


<td>
<div class="btn-group">
<button type="button" class="btn btn-info">Actions</button>
<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
<ul class="dropdown-menu">
<?php                    
 if($row->uStatus != "1"){
?>
<li><a href="javascript:;" onClick="btnstatusupdate(1,<?php echo $row->id;?>);">Accept</a></li>
<?php } if($row->uStatus != "2"){ ?>
<li><a href="javascript:;" onClick="btnstatusupdate(2,<?php echo $row->id;?>);">Reject</a></li>
<?php } ?>
<li><a href="<?php echo base_url().'admin/view-user-verification/'.$row->id; ?>">View</a></li>

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
        </div>
        <!-- end col -->
    </div>




<div class="modal-cs display_none ask_reason" >
    <div class="modal-box">
        <div class="modal-heading">
            <h4 class="left">Reject user verification</h4>

            <button onclick="closeModel();" class="btn bt-danger right" >
                <i  class="fa fa-times"></i>
            </button>
        </div>

        <div class="modal-body">
            <form method="post" action="<?php echo base_url();?>ico/reject_user_verification">
                <div class="row">



                    <div class="col-md-12">
                            <div class="form-group">
                                <label>Reason: </label>
                                <textarea class="form-control" name="reason" rows="5"></textarea>
                                <input type="hidden" name="id" id="reject_id">
                            </div>
                    </div>

                    

                    <div class="col-md-6 col-md-offset-3 m-t-40">
                        <div class="form-group">
                            <button class="btn btn-default btn-block btn-lg" type="submit">
                                Reject
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
function btnstatusupdate(val, id) {

    if(val==2)
    {
        $("#reject_id").val(id)

        $(".ask_reason").show();
        return;
    }

    var x = confirm("Are you sure you want to perform this action?");
    if (x) {
        window.location = '<?php echo base_url(); ?>ico/approve_user_verification/' + id;
        return true;
    } else {
        return false;
    }
}

function btnstatusupdate2(val, id) {
    var x = confirm("Are you sure you want to perform this action?");
    if (x) {
        window.location = '<?php echo base_url(); ?>ico/account_status/' + val + '/' + id;
        return true;
    } else {
        return false;
    }
}

function btnstatusdelete(id) {
    var x = confirm("Are you sure you want to Remove this verification data?");
    if (x) {
        window.location = '<?php echo base_url(); ?>ico/remove_user_verification/' + id;
        return true;
    } else {
        return false;
    }
}
<?php } ?>

function closeModel()
{
     $(".modal-cs").hide();
}

</script>