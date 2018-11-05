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
                <span class="pull-right">
                    <a href="<?php echo base_url().'view-airdrop-campaign/'.$bounty->id; ?>">
                        <button class="btn btn-primary btn-sm">
                            <i class="fa fa-tv"></i> View
                        </button>
                    </a>
                </span>
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



