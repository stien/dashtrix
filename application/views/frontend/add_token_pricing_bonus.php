<?php include("common/header.php");?>
<div class="wrapper-page widht-800">
    <div class="card-box">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                   <?php 
                        $title = "TOKEN PRICE TEMPLATES";

                        
                    ?>
                   
                    <div class="tab-content">
                      <span class="signupformd"><?php echo $title;?></span>
                        <div class="tab-pane active" id="personal">

                          

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">
                                                    
                                <div class="row">

                                    <div class="col-md-12">


                                        <div class="box-buy-tokens-old">
                                             

                                            
                                            <h3 class="text-center">Which type of pricing round would you like to create?</h3>
                                                    


                                             
                                            <div class="col-md-6 m-b-30 pointer" onclick="href('1',this)">
                                                <div class="card-box widget-box-1 boxdisplay" style="min-height: 170px;">
                                            <span>
                                                
                                                <h2>Standard</h2>
                                            </span>
                                             
                                                </div>  
                                            </div>

                                      <div class="col-md-6 m-b-30 pointer" onclick="href('3',this)">
                                        <div class="card-box widget-box-1 boxdisplay"  style="min-height: 170px;">
                                            <span>
                                                <h2>Escalating Bonus</h2>
                                            </span>
                                           
                                        </div>  
                                      </div>
                                      <div class="col-md-6 m-b-30 pointer" onclick="href('2',this)">
                                        <div class="card-box widget-box-1 boxdisplay"  style="min-height: 170px;">
                                            <span>
                                                <h2>No Bonus</h2>
                                            </span>
                                        </div>  
                                      </div>
                                  </div>

                                    </div>

                                    

                                    
                                    
                                    <div class="col-md-12">
                                    

                                    <div class="col-md-3 right  m-t-40">
                                         <div class="form-group">
                                            <input type="hidden" id="b_type" name="b_type" value="">
                                            
                                                <button id="submit_btn" class="btn btn-default btn-block btn-sm " disabled=""  type="submit">
                                                      Next
                                                </button>
                                         </div>
                                    </div>

                                    <div class="col-md-3 right m-t-40">
                                         <div class="form-group">
                                            <a href="<?php echo base_url().'admin/add/token/pricing'; ?>">
                                                <button class="btn btn-danger btn-block btn-sm "  type="button">
                                                      Go Back
                                                </button>
                                            </a>
                                         </div>
                                    </div>
                                    </div>
                                   
                                </div>
                            </form>
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

<script>
    $(document).ready(function() {

        $('#birth_date').datepicker({
            format: 'yyyy-mm-dd',
           
        });
        $('#end_date').datepicker({
            format: 'yyyy-mm-dd',
            
            //endDate: '-0d'
        });
    });

function href(loc,that)
{
    $("#submit_btn").prop('disabled',false);
    $("#b_type").val(loc);

    $('.card-box').removeClass('hovered-card-box');
    $(that).find('.card-box').addClass('hovered-card-box');
    
}



</script>


<style type="text/css">
    .hovered-card-box h2{
        color:#fff !important;
    }
</style>

</body>
</html>
