<?php require_once("common/header.php");?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
               <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
            </div>
            <h4 class="page-title">Bounty Submission</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
          


            <div class="card-box widget-box-1">
                <?php
                $bounty = $this->front_model->get_query_simple('*','dev_web_airdrop_campaigns',array('id'=>$submission->camp_id))->result_object()[0];


                 ?>
                

                    <b style="display: inline-block;">Bounty Submission:</b>

                    <p  style="display: inline-block;">
                    <?php echo $bounty->name; ?> 
                   

                </p>
                <br>

                    <b style="display: inline-block;">Submission Date:</b>
                    <p style="display: inline-block;">
                        <?php echo date("m/d/y",strtotime($submission->created_at)); ?>
                    </p>
                    <hr>

                    <b>Submission Data</b>




                <?php foreach(json_decode($submission->ans) as $key=>$val){ ?>

                <div class="m-t-15 w100" >

                    
                    <h4>
                        <?php echo $val->q; ?>
                    </h4>

                    <p><?php echo $val->a; ?></p>
                    
                </div>

                <?php } ?>

                <?php if($bounty->camp_type==2){ ?>

                <div class="m-t-15 w100" >

                    
                    <h4>
                        URL of completed task
                    </h4>

                    <p><?php echo $submission->url; ?></p>
                    
                </div>


                <?php }else if($submission->file){


                 ?>



                <div class="m-t-15 w100" >
                    <a target="_blank" href="<?php echo base_url().'resources/uploads/airdrops/'.$submission->file; ?>">
                        <button class=" btn btn-default">Attachment</button>
                        </a>


                         <a href="<?php echo base_url().'ico/ico_airdrop_submission_status/1/'.$submission->id; ?>">
                        <button class=" btn btn-info">Approve</button>
                    </a>

                    <a href="<?php echo base_url().'ico/ico_airdrop_submission_status/0/'.$submission->id; ?>">
                        <button class=" btn btn-danger">Reject</button>
                    </a>
                 
                    
                </div>
               

                <?php } ?>
 <div class="col-md-12">
                    <hr>
                </div>
<?php if(ACTYPE==1 && $submission->status == "0"){ ?>
                <div class="p-full">
                         <a href="javascript:;" onClick="btnstatusupdate(1,<?php echo $submission->id;?>);" >
                            <button class="btn btn-default">Approve</button>
                        </a>

                        <a href="javascript:;" onClick="btnstatusupdate(0,<?php echo $row->id;?>);">
                            <button class="btn btn-danger">Reject</button>
                        </a>
                     </div>

<?php } ?>

              
                
            </div>

          
        </div>
        <!-- end col -->
        <div class="col-md-4">
             <div class="card-box widget-box-1">
                <div class="user_view">
                    <?php

                   $arr = array('uID'=>$submission->uID);

                    $user = $this->front_model->get_query_simple('*','dev_web_user',$arr)->result_object()[0];


                     ?>


                     <div class="p-pic">
                         <img src="<?php echo base_url().'resources/uploads/profile/'.$user->uImage; ?>">
                     </div>
                     <div class="p-name">
                         <p style="font-size: 16px;">
                            <b>
                                <?php echo $user->uFname.' '.$user->uLname; ?>
                            </b>
                        </p>
                         <small><?php
                         switch ($user->uActType) {
                             case '1':
                                 echo "Admin";
                                 break;
                            case '2':
                                 echo "Token Buyer";
                                 break;
                             
                             default:
                                 echo "Other";
                                 break;
                         }

                          ?></small>
                     </div>

                     <div class="p-full">
                         <a href="mailto:<?php echo $user->uEmail; ?>" >
                            <button class="btn btn-default">Email</button>
                        </a>

                        <a href="#" >
                            <button class="btn btn-info">Edit</button>
                        </a>
                     </div>
                     <hr>
                     <div class="p-details">
                         <b>Status:</b> <span>
                             <?php 
                                        if($row->uStatus == "0"){echo "<div class='status-pending'>In-Active</div>";} 
                                        else if($row->uStatus == "1"){echo "<div class='status-confirm'>Active</div>";} 
                                        //else if($row->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}
                                        //else if($row->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}
                                    ?>
                         </span>

                         <b>E-mail: </b> <span><?php echo $user->uEmail; ?></span> <br>
                         <b>Phone: </b> <span><?php echo $user->uPhone; ?></span><br>
                         <b>Username: </b> <span><?php echo $user->uUsername; ?></span>
                     </div>
                </div>
             </div>
        </div>
        <!-- end col -->

    </div>
<?php require_once("common/footer.php");?>

<?php if(isset($_GET['type'])){?>
	<script language="javascript">
		 $("html, body").delay(400).animate({
        scrollTop: $('#passwordrequest').offset().top 
    }, 2000);
	</script>
<?php } ?>

<script language="javascript">
<?php if(ACTYPE == "1"){?>
function btnstatusupdate(val,id){
    var x = confirm("Are you sure you want to perform this action?");
    if (x){
        window.location='<?php echo base_url(); ?>ico/ico_airdrop_submission_status/'+val+'/'+id;
        return true;
    }
    else {
        return false;
    }
}


<?php } ?>
</script>