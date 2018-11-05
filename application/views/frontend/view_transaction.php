<?php 

include("common/header.php");
?>

<style type="text/css">
    .taking_image img{
      float: left;
    
}
.easy{
    float: left;
    width: 100%;
}
.mt-10{
    margin-top: 10px;
}
.w-auto{
    width: auto !important;
}
label{
    float: left;
    width: 100%;
    font-weight: bold !important;
}
.view_data{
    float: left;
    width: 100%;
}
.parent_image{
    position: relative;
    float: left;
    padding: 2px;
    border:1px solid;
    width: 150px;
    height: 150px;
    overflow: hidden;
    margin-right: 10px;
    margin-bottom: 10px;
}
.parent_image .view{
        position: absolute;
    right: 0;
    background: #1cba33;
    font-size: 21px;
    height: 25px;
    width: 30px;
    color: #fff;
    top: 0;
    text-align: center;
}
.parent_image .download{
        position: absolute;
    right: 22%;
    background: #1cba33;
    font-size: 21px;
    height: 25px;
    width: 30px;
    color: #fff;
    top: 0;
    text-align: center;
}

</style>


<div class="wrapper-page w-full">


<div class="row">
<div class="col-md-12">
    <div class="col-md-6 ">
 <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php $title = "Basic Information"; ?>
                   
                      <span class="signupformd"><?php echo $title;?></span>
                    
                  


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Unique ID </label>
                                            <span class="view_data">
                                                <?php

                                                    echo $trans->transaction_id;

                                                ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Transaction Type </label>
                                            <span class="view_data">
                                                <?php

                                                    if($trans->t_type==2){
                                                        echo "Completed A Survey";
                                                    }
                                                    else if($trans->t_type==30){
                                                        echo "Referral Bonus";
                                                    }
                                                    else
                                                    {
                                                        echo "Purchased Token";
                                                    }

                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tokens Purchased </label>
                                            <span class="view_data">
                                                <?php

                                                    echo $trans->without_bonus_tokens;
                                                    

                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tokens awarded with bonus </label>
                                            <span class="view_data">
                                                <?php

                                                    echo $trans->tokens;
                                                    

                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Paid using </label>
                                            <span class="view_data">
                                                <?php echo $trans->amtType; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Paid <?php echo $trans->amtType; ?></label>
                                            <span class="view_data">
                                                <?php

                                                    echo $trans->amountPaid;
                                                    

                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Paid USD</label>
                                            <span class="view_data">
                                                <?php

                                                    echo $trans->usdPayment;
                                                    

                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Conversion Rate</label>
                                            <span class="view_data">
                                                1 USD = 
                                                <?php

                                                    echo $trans->conversion_rate;
                                                ?>  <?php echo $trans->amtType; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Time</label>
                                            
                                            <span><?php echo date("m/d/y H:i:s",strtotime($trans->datecreated));?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <span>
                                                <?php 
                                                        if($trans->status == "1"){echo "<div class='status-pending'>Pending</div>";} 
                                                        else if($trans->status == "2"){echo "<div class='status-confirm'>Confirmed</div>";} 
                                                        else if($trans->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}
                                                        else if($trans->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}
                                                    ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


</div>
<div class="col-md-6 ">
 <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php $title = "Volitility"; ?>

                      <span class="signupformd"><?php echo $title;?></span>

                               
                                 

                                <div class="row">
                                   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Volitility Percent (%)</label>
                                            <span class="view_data">
                                                <?php

                                                    echo $trans->volitility_percent.'%';
                                                    

                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Without Volitility Paid (USD)</label>
                                            <span class="view_data">
                                                <?php

                                                    echo $trans->without_volitility_usd;
                                                ?>
                                            </span>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-md-6 ">
 <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php $title = "Other Details"; ?>

                      <span class="signupformd"><?php echo $title;?></span>

                               
                                 

                                <div class="row">
                                   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Campaign Used:</label>
                                            <span class="view_data">
                                                <?php

                                                    echo $trans_camp->title;
                                                    

                                                ?>
                                                <a href="<?php echo base_url().'admin/edit-ico-setting/'.$trans_camp->id; ?>"><i class="fa fa-link"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Token pricing template used: </label>
                                            <span class="view_data">
                                                <?php

                                                    echo $trans_template->tokenDateStarts .' - ' . $trans_template->tokenDateEnds;
                                                ?>

                                                <a href="<?php echo base_url().'admin/edit-token-pricing/'.$trans_template->tkID; ?>"><i class="fa fa-link"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            
        </div>
        </div>


                       
<div class="row">

<div class="col-md-6 ">
 <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php $title = "User Details"; ?>

                      <span class="signupformd"><?php echo $title;?></span>

                               
                                 

                                <div class="row">
                                   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name:</label>
                                            <span class="view_data">
                                                <?php

                                                    echo $trans_user->uFname.' '.$trans_user->uLname;


                                                    

                                                ?>
                                                
                                            </span>
                                            <a href="<?php echo base_url().'admin/user/'.$trans_user->uID; ?>"><i class="fa fa-link"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Company: </label>
                                            <span class="view_data">
                                                 <?php

                                                    echo $trans_user->uCompany;


                                                    

                                                ?>

                                               
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email: </label>
                                            <span class="view_data">
                                                 <?php

                                                    echo $trans_user->uEmail;


                                                    

                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Balance (tokens): </label>
                                            <span class="view_data">
                                                 <?php
                                                    echo $trans_user->tokens;

                                                ?>
                                            </span>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


 <div class="col-md-2">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php $title = "QR Code"; ?>

                      <span class="signupformd"><?php echo $title;?></span>

                               
                                 

                                <div class="row">
                                   
<img width="150" src="<?php echo base_url().'resources/uploads/qr_codes/'.$trans->transaction_id.'.gif'; ?>" title="<?php echo $trans->transaction_id; ?>" />
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>

   
</div>



</div>



<script>

    var resizefunc = [];

</script>

<?php include("common/footer.php");?>
<script type="text/javascript">
    $(document).ready(function(){
        $('input').prop('readonly',true);
    });
    $('input').click(function(){
        $(this).select();
    });
</script>




</body>

</html>

