<?php include("common/header.php");
$_SESSION['my_id']=UID;
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

                   <?php $title = "Verify Yourself"; ?>

                      <span class="signupformd"><?php echo $title;?></span>
                      <?php if($this->uri->segment(2)=="accepted"){ ?>
                        <div style="background:green; float:left; width: 100%; color:white; padding: 20px; text-align: center;">
                            Your information has been processed successfully!
                        </div>
                    
<?php }elseif($this->uri->segment(2)=="rejected"){ ?>
    <div style="background:red; color:white; float:left; width: 100%; padding: 20px; text-align: center;">
                            Your information has been rejected!
                        </div>
<?php }elseif($this->uri->segment(2)=="review"){ ?>
    <div style="background:orange; color:white; float:left; width: 100%; padding: 20px; text-align: center;">
                            Your information is being reviewed
                        </div>
<?php }else{ ?>
      <!-- Please replace the src value with your correspoing form URL -->

<div id='veriff-root'></div>
<?php } ?>

</div>
</div>
</div>
</div>

                           
                                   

                              

</form>

             

</div>



<script>

    var resizefunc = [];

</script>


<?php include("common/footer.php");?>
<script type="text/javascript">
 
</script>  


<script>

    $(document).ready(function() {



        $('.birth_date_pre').datepicker({

            format: 'yyyy-mm-dd',
            endDate: '-0d'
        });
         $('.birth_date').datepicker({

            format: 'yyyy-mm-dd',

        });

    });



</script>
<link rel='stylesheet' href='https://cdn.veriff.me/sdk/js/styles.css'>
<script src='https://cdn.veriff.me/sdk/js/veriff.min.js'></script>
<script type="text/javascript">
    var veriff = Veriff({
    env: 'production', // or 'staging' production
    apiKey: '<?php echo $api_details->public_key; ?>',

    parentId: 'veriff-root',
    onSession: function(err, response) {
        post_data(response);
        // console.log(response);
    }
  });
    veriff.setParams({
    person: {
      givenName: '<?php echo $user_own_details->uFname; ?>',
      lastName: '<?php echo $user_own_details->uLname; ?>',
      idNumber: '<?php echo $user_own_details->uID; ?>'
    },
    callback:"<?php echo base_url().'ico/veriff_callback'; ?>"
  });
    // veriff.callback("https://gooogle.com");
  veriff.mount();
  function post_data(data)
  {
    $.post('<?php echo base_url().'ico/save_veriff_resp' ?>',{data:data},function(r){
        window.location = r;
    });
  }
</script>


</body>

</html>