    <!-- Footer -->
<footer class="footer text-right">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
<!--                © <?php echo date("Y");?> ICODASHBOARD.IO. All rights reserved.-->
           <?php echo WEBCOPY;?>
            </div>
            <div class="col-xs-6">
                <?php if(!$pdf_view){ ?>
                <p style="font-size: 10px; color: #ffffff; opacity:0;" class="flt_right clr_white">Developed By <a title="Logo Design, Website Development & Design Company - DeDevelopers" class="hover_none" href="http://www.dedevelopers.com/" target="_blank">DeDevelopers</a></p>
            <?php } ?>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->    </div>
</div>



<!-- App JS -->
<script>
    var resizefunc = [];
</script>
<div class="alert alert-danger alert-dismissable msg-container-wrapper hidden">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
        ×
    </button>
    <ul class="msg-container">

    </ul>
</div>

<?php require("js_include.php"); ?>

<?php
    if(isset($_SESSION['JobsSessions']) && ACTYPE==2){



        if($show_popup_verification)
        {
            require_once("verification_popup_to_user.php");
        }
        else
        {



        
            if($user_verified!=1 && !isset($_SESSION['vf_popup_shown']) && $kyc_verification_enabled==1){
                require_once("verification_popup_to_user.php");
            }
            else{
                require_once("compaign.php"); 
            }
        }

}

  ?>


<script type="text/javascript">
    var $containerClone = $('.msg-container-wrapper').clone();

    function addContainer(id, $parent)
    {
        var $clone = $containerClone.clone();
        $clone.prop('id', id).removeClass('hidden').prependTo($parent);
    }

    function closeContainer(id)
    {
        var $container;

        if(id){
            $container = $('.msg-container-wrapper#'+id);
        }else{
            $container = $('.msg-container-wrapper');
        }

        $container.find('button.close').click();
    }

    function populateContainer(id, msg)
    {
        var $container;

        if(id){
            $container = $('.msg-container-wrapper#'+id);
        }else{
            $container = $('.msg-container-wrapper');
        }

        if($container.parents('.modal').first()){
            $container.parents('.modal').animate({ scrollTop: 0 }, "fast");
        }else{
            $('body, html').animate({ scrollTop: 0 }, "fast");
        }

        $container.find('.msg-container').append('<li>'+msg+'</li>');
    }
	$(document).ready(function(){
		setTimeout(function(){ 
			$(".successfull, .wrongerror").fadeOut();
		}, 5000);
		
	});
</script>
<?php unset($_SESSION['error']); unset($_SESSION['thankyou']); unset($_SESSION['error_change']);unset($_SESSION['thankyou_change']);
unset($_SESSION['thankyou_wallet']);
?>
</body>


<?php echo $this->front_model->get_query_simple('google_analytics','dev_web_config',array('cID'=>1))->result_object()[0]->google_analytics; ?>

<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- <script src='https://www.google.com/recaptcha/api.js?onload=recaptchaOnload&render=explicit' async defer></script>
<script type="text/javascript">
    var _captchaTries = 0;
function recaptchaOnload() {
    alert('hello');
    _captchaTries++;
    if (_captchaTries > 9)
        return;
    if ($('.g-recaptcha').length > 0) {
        grecaptcha.render("recaptcha", {
            sitekey: '6LfwclQUAAAAAHN1mXuB6NG2Q3gecwB1l0HfT5k5',
            callback: function() {
                console.log('recaptcha callback');
            }
        });
        return;
    }
    console.log('tied');
    window.setTimeout(recaptchaOnload, 1000);
}
</script>
 -->
</html>
