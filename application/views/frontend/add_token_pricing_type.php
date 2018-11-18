<?php include("common/header.php");?>
<div class="wrapper-page widht-800">

    <div class="card-box">

                      <DIV class="signupformd-title">TOKEN PRICE TEMPLATES - SET ROUND TYPE</div>

        <div class="panel-body">

                <ul class="nav nav-wizard token-pricing">
                <li class="active"><a href="#"  data-toggle="tooltip" data-placement="top" title="Set token pricing type"><SPAN>1</span> TOKEN TYPE</a></li>
                <li><a href="#"  data-toggle="tooltip" data-placement="top" title="Set token bonus type"><SPAN>2</span> BONUS TYPE</a></li>
                <li><a href="#"  data-toggle="tooltip" data-placement="top" title="Define bonus levels"><SPAN>3</span> SET BONUS</a></li>
                    <li><a href="#"  data-toggle="tooltip" data-placement="top" title="Attach to a campaign"><SPAN>4</span> ATTACH TO CAMPAIGN</a></li>
              </ul>

            <div class="row">
                <div class="col-lg-12">
            
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal">

                          

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">
                                                    
                                <div class="row">

                                    <div class="col-md-12">


                                        <div class="box-buy-tokens-old">
                                             

                                            
                                            <h3 class="text-center">Set the TYPE of pricing round</h3>
                                                    

                                             
                                            <div class="col-md-6 m-b-30 pointer" onclick="href('individual',this)">
                                                <div class="card-box widget-box-1 boxdisplay" style="min-height: 290px;">
                                            <span>
                                                
                                                <h2>Individual</h2>
                                            </span>
                                              <p>An individual pricing template which can be activated/deactivated manually at any time or end automatically by reaching a token cap or end date. </p>
                                                </div>  
                                            </div>

                                      <!-- <div class="col-md-6 m-b-30 pointer" onclick="href('multiple',this)" > -->
                                        <div class="col-md-6 m-b-30 pointer" >
                                        <div class="card-box widget-box-1 boxdisplay"  style="min-height: 290px;  opacity: .3; cursor: not-allowed;">
                                            <span>
                                                <h2>Multiple</h2>
                                            </span>
                                           <!--  <p>A series of pricing templates which activate automatically in the order you specify, when reaching the end date or token cap. (you will need to create a minimum of 2 pricing templates if selecting this option)</p> -->
                                            <p>A series of pricing templates which activate automatically in the order you specify, at the end date or token cap. COMING SOON...</p>
                                        </div>  
                                      </div>
                                  </div>

                                    </div>

                                    

                                    
                                    
                                  <div class="col-md-12">
                                    

                                    <div class="col-md-3 right  m-t-40">
                                         <div class="form-group">
                                            <input type="hidden" id="c_type" name="c_type" value="">
                                                <button id="submit_btn" disabled class="btn btn-default btn-block btn-sm "  type="submit">
                                                      Next
                                                </button>
                                         </div>
                                    </div>

                                    <div class="col-md-3 right m-t-40">
                                         <div class="form-group">
                                            <a href="<?php echo base_url().'admin/token/pricing'; ?>">
                                                <button class="btn btn-danger btn-block btn-sm "  type="button">
                                                      Cancel
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

    $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })

function href(loc,that)
{
    $("#submit_btn").prop('disabled',false);
    $("#c_type").val(loc);

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
