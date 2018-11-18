<?php include("common/header.php");?>
<div class="wrapper-page widht-800">
    <div class="card-box">
           <DIV class="signupformd-title">TOKEN PRICE TEMPLATES - SET PRICING ROUND TYPE</div>

        <div class="panel-body">

                               <ul class="nav nav-wizard token-pricing">
                <li><a href="#"  data-toggle="tooltip" data-placement="top" title="Set token pricing type"><SPAN>1</span> TOKEN TYPE</a></li>
                <li class="active"><a href="#"  data-toggle="tooltip" data-placement="top" title="Set token bonus type"><SPAN>2</span> BONUS TYPE</a></li>
                <li><a href="#"  data-toggle="tooltip" data-placement="top" title="Define bonus levels"><SPAN>3</span> SET BONUS</a></li>
                    <li><a href="#"  data-toggle="tooltip" data-placement="top" title="Attach to a campaign"><SPAN>4</span> ATTACH TO CAMPAIGN</a></li>
              </ul>
              
            <div class="row">
                <div class="col-lg-12">
                  
                    <div class="tab-content">
                      <!-- <span class="signupformd"><?php echo $title;?></span> -->
                        <div class="tab-pane active" id="personal">

                          

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">
                                                    
                                <div class="row">

                                    <div class="col-md-12">


                                        <div class="box-buy-tokens-old">
                                             

                                            
                                            <h3 class="text-center">Set the type of bonus</h3>
                                                    


                                             
                                            <div class="col-md-6 m-b-30 pointer" onclick="href('1',this)">
                                                <div class="card-box widget-box-1 boxdisplay">
                                            <span>
                                                
                                                <h2>Standard</h2>
                                            </span>
                                             
                                                </div>  
                                            </div>

                                      <div class="col-md-6 m-b-30 pointer" onclick="href('3',this)">
                                        <div class="card-box widget-box-1 boxdisplay">
                                            <span>
                                                <h2>Escalating</h2>
                                            </span>
                                           
                                        </div>  
                                      </div>
                                      <div class="col-md-6 m-b-30 pointer" onclick="href('2',this)">
                                        <div class="card-box widget-box-1 boxdisplay">
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
                                            <a href="<?php echo base_url().'admin/add/token/pricing/type'; ?>">
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
