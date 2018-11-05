<?php include("common/header.php");?>
<div class="wrapper-page widht-800">
    <div class="card-box">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                   <?php 
						$title = "TOKEN PRICE TEMPLATES - Bonus";


					?>
                   
                    <div class="tab-content">
                      <span class="signupformd"><?php echo $title;?></span>
                        <div class="tab-pane active" id="personal">

                            

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">

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
                    <div class="errornotification">
                        <?php echo $_SESSION['error'];?>
                    </div>
                </div>
            </div>
            <?php } ?>
                                                    
                                <div class="row">

                                <?php echo print_leve(array('hide_remove'=>true)); ?>

                                <div class="col-lg-12 nopad">
                                    <button onclick="add_leve(this)" type="button" class="btn btn-primary btn-sm">+ Add Level</button>
                                </div>
                                    

                                 
                                   <div class="col-md-12">
                                    

                                    <div class="col-md-3 right  m-t-40">
                                         <div class="form-group">
                                            <input type="hidden" id="submit" name="submit" value="1">
                                       
                                                <button id="submit_btn" class="btn btn-default btn-block btn-sm "  type="submit">
                                                      Next
                                                </button>
                                         </div>
                                    </div>

                                    <div class="col-md-3 right m-t-40">
                                         <div class="form-group">
                                            <a href="<?php echo base_url().'admin/add/token/pricing/bonus/'; ?>">
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
    
    function add_leve(that)
    {
        $("body").append('<div class="loading">Loading&#8230;</div>');
        $.post('<?php echo base_url().'ico/get_leve_div'; ?>',{get:true},function(data){
            $(that).before(data);
            $(".loading").remove();
        });
    }
    function remove_leve(that)
    {
        $(that).parent().remove();
    }
    function href(loc,that)
{
    $("#submit_btn").prop('disabled',false);
    $("#b_type").val(loc);

    $('.card-box').removeClass('hovered-card-box');
    $(that).find('.card-box').addClass('hovered-card-box');
    
}
</script>


</body>
</html>
