<?php include("common/header.php");

$_SESSION['my_id']=UID;
?>


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
<iframe id="this_frame" width="100%" height="1000px" style="border:0px;" src="https://plugins.identitymindglobal.com/viewform/9wzs6/?user_id=<?php echo UID; ?>"></iframe>

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




</body>

</html>

