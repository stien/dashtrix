<?php require_once("common/header.php");?>

  
   
      <div class="row">
         <div class="col-sm-12 m-b-30">
          <h4 class="page-title">Buy Tokens</h4>
      </div>
      </div>
      <div class="row">

        <div class="col-md-2"></div>
        <div class="col-md-8">

          <div class="box-buy-tokens-old">
          <form method="post" action="">

            <?php if($verified_or_not){ ?>
            <h3 class="text-center">Select Currency Type</h3>
            


             
      <div class="col-md-6 m-b-30 pointer" onclick="href('crypto',this)">
        <div class="card-box widget-box-1 boxdisplay">
            <span>
                <img src="<?php echo base_url();?>resources/frontend/images/crypto-currency.png" alt="<?php echo $option->name; ?>" width="50">
            </span>
            <p>Crypto Currency</p>
        </div>  
      </div>

      <div class="col-md-6 m-b-30 pointer" onclick="href('fiat',this)">
        <div class="card-box widget-box-1 boxdisplay" >
            <span>
                <img src="<?php echo base_url();?>resources/frontend/images/fiat-currency.png" alt="<?php echo $option->name; ?>" width="50">
            </span>
            <p>FIAT Currency</p>
        </div>  
      </div>
<?php }else{ ?>
      
<h3 class="text-center">Verify your E-mail first</h3>
<div class="card-box widget-box-1 boxdisplay">
  Your E-mail address isn't verified yet, please verify your E-mail by clicking "Verify" button in a E-mail sent to your provided E-mail address on time of signup with us.
  <br>
   <div class="form-group">
                        <a href="<?php echo base_url().'resend-verification-email'; ?>">
                            <button class="btn btn-default btn-block btn-lg" type="button" style="width: auto;
    float: none;
    margin: 0 auto;
    margin-top: 20px;">
                               Resend E-mail
                            </button>
                        </a>
                    </div>
</div>

<?php } ?>
          


        

            <div class="col-md-12">
            

            

            <div class="col-md-3 right  m-t-40">
                 <div class="form-group">
          <input type="hidden" id="c_type" name="c_type" value="">
            <button id="submit_btn" class="btn btn-default btn-block btn-sm " disabled type="submit">
                              Next
                        </button>
                 </div>
            </div>
            <div class="col-md-3 right m-t-40">
                 <div class="form-group">
                    <a href="<?php echo base_url().'dashboard'; ?>">
                        <button class="btn btn-danger btn-block btn-sm "  type="button">
                              Cancel
                        </button>
                    </a>
                 </div>
            </div>
            </div>
        
        
        </form> 
        
      </div>

      </div>

      <div class="col-md-2"></div>


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


function href(loc,that)
{
  $("#submit_btn").prop('disabled',false);
  $("#c_type").val(loc);

  $('.card-box').removeClass('hovered-card-box');
  $(that).find('.card-box').addClass('hovered-card-box');
  
}
</script>
