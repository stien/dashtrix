<?php require_once("common/header.php");?>

<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-5">
    <div class="col-md-12 m-b-10 text-center">
    <h2 >Thank You</h2>
  </div>
    <div class="card-box">
        <div class="panel-body" style="padding: 0px;">



      <p class="  m-b-20 easy">Dear <?php echo $user_own_details->uFname.' '.$user_own_details->uLname; ?>,</p>
      <p class="  m-b-20 easy">Thanks for Supporting!</p>
      <p class="  m-b-20 easy">Your Token purchase request has been processed to our team. Your token will be awarded to your account once we got a confirmation regarding your payment.</p>

      <div class="col-md-12 nopad">
         <div class="col-md-12 nopad">
        
        
          <a class="pull-right" href="javascript:refer();">
            <button type="button" class="btn btn-info">Refer a Friend</button>
          </a>
       
       
         

          <?php if($_SESSION['needs_kyc']!=1){ ?>
        
            <a class=" m-r-15 pull-right" href="<?php echo base_url().'kyc-verification'; ?>">
              <button type="button" class="btn btn-default">Verify KYC</button>
            </a>
          
        <?php } ?>

         <a class="pull-left m-r-15" href="<?php echo base_url().'dashboard'; ?>">
            <button type="button" class="btn btn-danger">Go to Dashboard</button>
          </a>
        </div>
      </div>




    </div>
  </div>
</div>
  <div class="col-md-2"></div>
</div>




<div class="modal-cs display_none ask_reason" >
    <div class="modal-box">
        <div class="modal-heading">
            <h4 class="left">Refer a Friend</h4>

            <button onclick="closeModel();" class="btn bt-danger right" >
                <i  class="fa fa-times"></i>
            </button>
        </div>

        <div class="modal-body">
            <form method="post" action="<?php echo base_url();?>ico/refer_a_friend">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" required="" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" required="" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Your Message:</label>
                        <textarea class="form-control" name="msg" required rows="5"></textarea>
                      </div>
                    </div>
                   

                    <div class="col-md-6 col-md-offset-3 m-t-40">
                        <div class="form-group">
                            <button class="btn btn-default btn-block btn-lg" type="submit">
                                Refer
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once("common/footer.php");?>
<script type="text/javascript">
  function refer()
  {
    closeModel();
    $(".ask_reason").show();
  }
function closeModel()
{
$(".modal-cs").hide();
}
</script>
