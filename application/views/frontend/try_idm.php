<?php include("common/header.php");?>


<?php 

function value_help($verification,$user,$key)
{

 
    if($verification->$key)
        echo $verification->$key;
    if($user->$key)
        echo $user->$key;
    
}


 ?>
<div class="wrapper-page widht-800">

   

                   

<form method="POST" action="" accept-charset="UTF-8" id="personal-info">

 <div class="card-box">


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


        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">
                  
                  <div id="idm-container" style="width: 100%;"></div>
                  <div style="font-size: 18px; font-style: italic;" id="response_div"></div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    




<?php include("common/footer.php");?>


  
  <script>

      var _idm = {
          container_id: "idm-container",
          check_repeated:false,
          accept_message:'Thank you, your information will be reviewed very soon.',
          deny_message:'Oops! That didn\'t work.',
          agree_checkbox:'I have read and agree <a href="<?php echo base_url().'terms'; ?>">Terms and conditions</a>',
          cryptocurrencies:'ETH::Ethereum',
          user_id:'<?php echo UID; ?>',
          plugin_token: "<?php echo $token; ?>",
          required_address_country_list: ["US","GB","CA","ZA","SE","DK"] ,
          required_id_country_list:['US::^(?!666|000|9\\d{2})\\d{3}[- ]{0,1}(?!00)\\d{2}[- ]{0,1}(?!0{4})\\d{4}$'],
          country_blacklist: ['AR','PR'],
          on_response: function(jwtresponse){

              //handle response jwtresponse here
              //A simple example below:
              const array = jwtresponse.split('.');
              const header = JSON.parse(atob(array[0]));
              const response = JSON.parse(atob(array[1]));
              const signature = array[2];
              // alert("Result from Identitymind: " + response.kyc_result);
              $.post('<?php echo base_url().'idm/try_kcy_response' ?>',{res:jwtresponse},function(res){
                jres = JSON.parse(res);
                $("#response_div").html(jres.msg);
                if(jres.r==1)
                {
                  window.location = jres.l;
                }
              });

          }
      };

      (function(){var a=document.createElement('script');var m=document.getElementsByTagName('script')[0];a.src='https://cd1st.identitymind.com/idm.min.js';m.parentNode.insertBefore(a,m)})()

  </script>
