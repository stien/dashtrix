<?php require_once("common/header.php");?>

    
   
        <div class="row">


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

           
            <div class="col-md-4"></div>
            <div class="col-md-4">

                <div class="box-buy-tokens">
                    <div class="box-buy-tokens-upper">
                        <i class=" fa <?php echo $option->icon; ?>"></i>
                    </div>
                    <div class="box-buy-tokens-lower" style="width: 100%;">

                    <div class="col-md-12">
                        <span>To get tokens send amount to the address:</span>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px;">
                        <div class="form-group copy_parent">
                            <label style="font-weight: bold !important;">Amount:</label>
                            <input id="amount_req" type="text" name="" value="<?php echo $crypto_required; ?> <?php echo $option->c_name; ?>" class="form-control">
                            <i onclick="copydataid('amount_req',this)" class="fa fa-copy copy_self"></i>
                        </div>
                    </div>

                    <?php /* if($option->type!=2){ ?> ($<?php echo $__usd_required; ?>)<?php }  */ ?>
                    




                    <?php if($option->type==1){ ?>
                    <?php if($address){ ?>


                    <div class="col-md-12" style="margin-top: 10px;">
                        <div class="form-group copy_parent">
                            <label style="font-weight: bold !important;">Wallet Address:</label>
                            <input id="address" type="text" name="" value="<?php echo $address; ?>" class="form-control">
                            <i onclick="copydataid('address',this)" class="fa fa-copy copy_self"></i>
                        </div>
                    </div>

                      


                    <?php } }else if($option->type==2){ ?>

                        <div class="col-sm-12">
                            <form method="post" action="" style="float: left; width: 40%;">
                                <input type="hidden" name="paid_stripe" value="1">
                                <input type="hidden" name="hash" value="1">


                                
                                

                                  <script
                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="<?php echo $option->api_key; ?>"
                                    data-amount="<?php echo $crypto_required*100; ?>"
                                    data-name="ICO"
                                    data-currency="USD"
                                    data-description="Widget"
                                    data-image="http://projectsdedevelopers.com/energy/resources/frontend/images/logo.png"
                                    data-locale="auto">
                                  </script>  


                              </form>
                        </div>


                        <?php }else if($option->type==3){ ?>

                        <div class="col-md-12">
                            <h4>Please pay <span class="btc_val"><?php echo $crypto_required; ?> <?php echo $option->c_name; ?></span> to given details</h4>
                        </div>

                        <?php if($option->bank_name){ ?>

                            <div class="col-md-12">
                                    <div class="form-group copy_parent">
                                        <label style="font-weight: bold !important;">Bank Name:</label>
                                        <input id="bank_name" type="text" name="" value="<?php echo $option->bank_name; ?>" class="form-control">
                                        <i onclick="copydataid('bank_name',this)" class="fa fa-copy copy_self"></i>
                                    </div>
                            </div>
                        <?php } if($option->bank_address){ ?>

                        <div class="col-md-12">
                                <div class="form-group copy_parent">
                                    <label style="font-weight: bold !important;">Bank Address:</label>
                                    <input id="bank_address" type="text" name="" value="<?php echo $option->bank_address; ?>" class="form-control">
                                    <i onclick="copydataid('bank_address',this)" class="fa fa-copy copy_self"></i>
                                </div>
                        </div>
                        <?php } if($option->routing_number){ ?>

                        <div class="col-md-12">
                                <div class="form-group copy_parent">
                                    <label style="font-weight: bold !important;">Routing Number:</label>
                                    <input id="routing_number" type="text" name="" value="<?php echo $option->routing_number; ?>" class="form-control">
                                    <i onclick="copydataid('routing_number',this)" class="fa fa-copy copy_self"></i>
                                </div>
                        </div>
                        <?php } if($option->swift_code){ ?>

                        <div class="col-md-12">
                                <div class="form-group copy_parent">
                                    <label style="font-weight: bold !important;">Swift Code:</label>
                                    <input id="swift_code" type="text" name="" value="<?php echo $option->swift_code; ?>" class="form-control">
                                    <i onclick="copydataid('swift_code',this)" class="fa fa-copy copy_self"></i>
                                </div>
                        </div>
                        <?php } if($option->iban){ ?>

                        <div class="col-md-12">
                                <div class="form-group copy_parent">
                                    <label style="font-weight: bold !important;">IBAN:</label>
                                    <input id="iban" type="text" name="" value="<?php echo $option->iban; ?>" class="form-control">
                                    <i onclick="copydataid('iban',this)" class="fa fa-copy copy_self"></i>
                                </div>
                        </div>
                        <?php } if($option->account_number){ ?>

                         <div class="col-md-12">
                                <div class="form-group copy_parent">
                                    <label style="font-weight: bold !important;">Account Number:</label>
                                    <input id="account_number" type="text" name="" value="<?php echo $option->account_number; ?>" class="form-control">
                                    <i onclick="copydataid('account_number',this)" class="fa fa-copy copy_self"></i>
                                </div>
                        </div>
                        <?php } if($option->account_name){ ?>


                        <div class="col-md-12">
                                <div class="form-group copy_parent">
                                    <label style="font-weight: bold !important;">Account Name:</label>
                                    <input id="account_name" type="text" name="" value="<?php echo $option->account_name; ?>" class="form-control">
                                    <i onclick="copydataid('account_name',this)" class="fa fa-copy copy_self"></i>
                                </div>
                        </div>
                        <?php } if($option->account__address){ ?>

                        <div class="col-md-12">
                                <div class="form-group copy_parent">
                                    <label style="font-weight: bold !important;">Account Address:</label>
                                    <input id="account__address" type="text" name="" value="<?php echo $option->account__address; ?>" class="form-control">
                                    <i onclick="copydataid('account__address',this)" class="fa fa-copy copy_self"></i>
                                </div>
                        </div>
                        <?php } if($option->account__phone_number){ ?>

                        <div class="col-md-12">
                                <div class="form-group copy_parent">
                                    <label style="font-weight: bold !important;">Account Phone Number:</label>
                                    <input id="account_name" type="text" name="" value="<?php echo $option->account__phone_number; ?>" class="form-control">
                                    <i onclick="copydataid('account_name',this)" class="fa fa-copy copy_self"></i>
                                </div>
                        </div>
                        <?php }  ?>

                     
                  


                        <?php }elseif($option->type==4 || $option->type==5){ ?>

                        <div class="col-md-12">
                            <h4>Please pay <span class="btc_val"><?php echo $crypto_required; ?> USD</span> to given details via Western Union</h4>
                        </div>
                        <?php if($option->receiver_full_name){ ?>

                        <div class="col-md-12">
                                <div class="form-group copy_parent">
                                    <label style="font-weight: bold !important;">Receiver Full Name:</label>
                                    <input id="receiver_full_name" type="text" name="" value="<?php echo $option->receiver_full_name; ?>" class="form-control">
                                    <i onclick="copydataid('receiver_full_name',this)" class="fa fa-copy copy_self"></i>
                                </div>
                        </div>
                        <?php } if($option->receiver_city){ ?>


                        <div class="col-md-12">
                                <div class="form-group copy_parent">
                                    <label style="font-weight: bold !important;">Receiver City:</label>
                                    <input id="receiver_city" type="text" name="" value="<?php echo $option->receiver_city; ?>" class="form-control">
                                    <i onclick="copydataid('receiver_city',this)" class="fa fa-copy copy_self"></i>
                                </div>
                        </div>

                    <?php } if($option->receiver_state){ ?>


                        <div class="col-md-12">
                                <div class="form-group copy_parent">
                                    <label style="font-weight: bold !important;">Receiver State:</label>
                                    <input id="receiver_state" type="text" name="" value="<?php echo $option->receiver_state; ?>" class="form-control">
                                    <i onclick="copydataid('receiver_state',this)" class="fa fa-copy copy_self"></i>
                                </div>
                        </div>


                        <?php } if($option->receiver_city){ ?>


                        <div class="col-md-12">
                                <div class="form-group copy_parent">
                                    <label style="font-weight: bold !important;">Receiver Country:</label>
                                    <input id="receiver_city" type="text" name="" value="<?php 
                                $rcvr_country = $this->front_model->get_query_simple('nicename','dev_web_countries',array('id'=>$option->receiver_country))->result_object()[0];
                                echo $rcvr_country->nicename;
                                 ?>" class="form-control">
                                    <i onclick="copydataid('receiver_city',this)" class="fa fa-copy copy_self"></i>
                                </div>
                        </div>
                        <?php }  ?>


                        <?php } ?>




                <?php if($option->type!=2){ ?>
                
                <?php if($option->time_active==1){ ?>
                  

                  <div class="col-md-12" style="margin-top: 10px;">
                     <div class="form-group">
                       <i class="fa fa-clock-o"></i> Time remaining: <b id="timer">--:--:--</b>
                    </div>
                  </div>
              <?php } ?>


                  <div class="col-md-12" style="margin-top: 10px;">

                        <button type="button" onclick="javascript:showQRCode();" class="show_qr_code"><i class="fa fa-qrcode"></i> Show QR Code</button>
                        <div id="overlay" onclick="off()">
                            <div class="qr_code  over_lay_text" >
                                <img width="200" src="<?php echo base_url().'resources/uploads/qr_codes/'.$trans_id.'.gif'; ?>" title="<?php echo $trans_id; ?>" />
                            </div>
                        </div>
                    </div>


                  <div class="col-md-12" style="margin-top: 10px;">

                    <h2 >Enter Confirmation</h2>
                     </div>
                  <div class="col-md-12" style="margin-top: 10px;">

                    <form method="post" action="">
                            

                                    


                                        <div class="form-group copy_parent">
                                            <label>

                                             
                                            <?php

                                                    if($option->type==1)
                                                        echo "Transaction Hash";
                                                    elseif($option->type==4)
                                                        echo "Enter MCTN Number";
                                                    else 
                                                        echo "Enter Bank Wire Transaction";
                                              ?>: </label>
                                            <input name="hash" id="input_hash" type="text" class="form-control" value="" required>
                                            <i onclick="copydataid('input_hash',this)" class="fa fa-copy copy_self"></i>
                                        </div>


                                    <div class="col-md-6 right  m-t-40">
                                         <div class="form-group">
                                            <input type="hidden" id="option_id" name="option" value="">
                                                <button id="submit_btn" class="btn btn-default btn-block btn-sm " type="submit">
                                                      <?php echo get_lang_msg("next"); ?>
                                                </button>
                                         </div>
                                    </div>

                                    <div class="col-md-6 right m-t-40">
                                         <div class="form-group">
                                            <a href="<?php echo base_url().'dashboard'; ?>">
                                                <button class="btn btn-danger btn-block btn-sm "  type="button">
                                                      <?php echo get_lang_msg("cancel"); ?>
                                                      
                                                </button>
                                            </a>
                                         </div>
                                    </div>
                                  
                                    

                                 
                               
                        </form>
                    </div>






              <?php } ?>

                </div>

                   
                    
                </div>
            </div>
            <div class="col-md-4">




        </div>

    
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


function href(loc)
{
    window.location = "<?php echo base_url().'buy-tokens/' ?>"+loc;
}

function copydata()
{
    var copyText = document.getElementById("address");
      copyText.select();
      document.execCommand("Copy");
}
function copydataid(id,that)
{
    var copyText = document.getElementById(id);
      copyText.select();
      document.execCommand("Copy");
      $(that).removeClass('fa-copy');
      $(that).addClass('fa-check');
      setTimeout(function(){
        $(that).removeClass('fa-check');
         $(that).addClass('fa-copy');
      },3000);
}


function time_count(){}


function formatTime(seconds) {
    var h = Math.floor(seconds / 3600),
        m = Math.floor(seconds / 60) % 60,
        s = seconds % 60;
    if (h < 10) h = "0" + h;
    if (m < 10) m = "0" + m;
    if (s < 10) s = "0" + s;
    return h + ":" + m + ":" + s;
}

<?php

    if($option->time_active==1){

    $time_db = (explode(':', $option->count_down)[0]*60)+explode(':', $option->count_down)[1];
    $time = time()-$_SESSION['buy_time'];

    if($time_db>$time){
        $time = $time_db-$time;
    }
    else
    {
        $time = 0;
    }



 ?>



var count = <?php echo $time; ?>;
var counter = setInterval(timer, 1000);

function timer() {
    count--;
    if (count < 0)
    {




     clearInterval(counter);


     window.location = "<?php echo base_url().'ico/clear_buy_token'; ?>";

     return;
    }
    document.getElementById('timer').innerHTML = formatTime(count);
}


<?php } ?>

// $("body").click(function(){
//     $("#overlay").hide();
// });
function showQRCode()
{
    $("#overlay").show();

}

function off() {
    document.getElementById("overlay").style.display = "none";
}

</script>
