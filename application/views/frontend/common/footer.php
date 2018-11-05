    <!-- Footer -->
    <div class="col-md-12">
                 <?php if(!$pdf_view && !am_i('lib')){ ?>
                <p style="font-size: 10px; color: #ffffff; opacity:0;" class="flt_right clr_white">Developed By <a title="Logo Design, Website Development & Design Company - DeDevelopers" class="hover_none" href="http://www.dedevelopers.com/" target="_blank">DeDevelopers</a></p>
            <?php } ?>
            </div>
<footer class="footer text-right">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
           <!--      <div class="powered_by">
                    <a target="_blank" href="<?php echo "http://icodashboard.io"; ?>">
                        <img src="<?php echo base_url().'resources/frontend/images/powered_by_icodashboard.png'; ?>" >
                    </a>
                </div> -->
                <div class="gpdr-complaint-img">
                    <a href="<?php echo base_url().'privacy-policy'; ?>">
                        <img src="<?php echo base_url().'resources/frontend/images/gdpr-complaint.png'; ?>" >
                    </a>
                </div>
                <div class="scl-lis">
                    <?php $config_lis = $this->db->order_by('cID','DESC')->limit(1)->get('dev_web_config')->result_object()[0]; ?>
                    <?php if($config_lis->configFacebook){ ?>
                        <a target="_blank" href="<?php echo $config_lis->configFacebook; ?>">
                            <i class="fa fa-facebook"></i>
                        </a>
                    <?php } ?>
                    <?php if($config_lis->configTwitter){ ?>
                        <a target="_blank" href="<?php echo $config_lis->configTwitter; ?>">
                            <i class="fa fa-twitter"></i>
                        </a>
                    <?php } ?>
                    <?php if($config_lis->instagram){ ?>
                        <a target="_blank" href="<?php echo $config_lis->instagram; ?>">
                            <i class="fa fa-instagram"></i>
                        </a>
                    <?php } ?>
                    <?php if($config_lis->webGoogle){ ?>
                        <a target="_blank" href="<?php echo $config_lis->webGoogle; ?>">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    <?php } ?>
                    <?php if($config_lis->webYouTube){ ?>
                        <a target="_blank" href="<?php echo $config_lis->webYouTube; ?>">
                            <i class="fa fa-youtube-play"></i>
                        </a>
                    <?php } ?>
                    <?php if(am_i('hydro')){ ?>
                        <?php if($config_lis->discord){ ?>
                            <a target="_blank" href="<?php echo $config_lis->discord; ?>">
                                <img style="width: 30px;" src="<?php echo base_url().'resources/frontend/images/discord.png'; ?>">
                            </a>
                        <?php } ////////////////////////////////////////// ?>

                        
                    <?php }else{ ?>

                    
                  


                        <?php if($config_lis->tumbler){ ?>
                            <a target="_blank" href="<?php echo $config_lis->tumbler; ?>">
                                <i class="fa fa-tumblr"></i>
                            </a>
                        <?php } ////////////////////////////////////////// ?>
                    <?php } ?>


                    <?php if($config_lis->webLkndIn){ ?>
                        <a target="_blank" href="<?php echo $config_lis->webLkndIn; ?>">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    <?php } ?>
                    <?php if($config_lis->telegram){ ?>
                        <a target="_blank" href="<?php echo $config_lis->telegram; ?>">
                            <i class="fa fa-telegram"></i>
                        </a>
                    <?php } ?>
                    <?php if($config_lis->bitcointalk){ ?>
                        <a target="_blank" href="<?php echo $config_lis->bitcointalk; ?>">
                            <img style="width: 30px;" src="<?php echo base_url().'resources/frontend/images/bitcointalk.png'; ?>">
                        </a>
                    <?php } ?>
                    <?php if($config_lis->reddit){ ?>
                        <a target="_blank" href="<?php echo $config_lis->reddit; ?>">
                            <i class="fa fa-reddit"></i>
                        </a>
                    <?php } ?>
                    <?php if($config_lis->steemit){ ?>
                        <a target="_blank" href="<?php echo $config_lis->steemit; ?>">
                            <i class="fa fa-steemit"></i>steemit
                        </a>
                    <?php } ?>
                    <?php if($config_lis->github){ ?>
                        <a target="_blank" href="<?php echo $config_lis->github; ?>">
                            <i class="fa fa-github"></i>
                        </a>
                    <?php } ?>


                </div>
            </div>
            <div class="col-md-6 text-right" style="padding-top: 9px; float: left;">

           <?php echo WEBCOPY;?>

           
           
            
             <a style="color: #5d5d5d;" href="<?php echo base_url().'terms'; ?>">Terms & Conditions</a> | 
             <a style="color: #5d5d5d;" href="<?php echo base_url().'privacy-policy'; ?>">Privacy Policy</a>
          

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
        $okay_popup_shown=false;
        if(!$on_verification_page && $user_verified!=1 && $kyc_verification_enabled==1 && $kyc_verification_at==1)
        {
            if(am_i('tib')){
                $vf = $this->db->where('uID',UID)->count_all_results('dev_web_user_verification');
                if($vf==0){
                    require_once("verification_popup_to_user.php");
                    $okay_popup_shown=true;
                }
            }
            else
            {
                require_once("verification_popup_to_user.php");
                $okay_popup_shown=true;
            }
        }
       
        if(!$on_verification_page && $show_popup_verification && $user_verified!=1 && !am_i('tib'))
        {
            require_once("verification_popup_to_user.php");
            $okay_popup_shown=true;
        }
         
        if(!$on_verification_page && $kyc_verification && $user_verified!=1 && !am_i('tib'))
        {
            require_once("verification_popup_to_user.php");
            $okay_popup_shown=true;
        }


        if(!$okay_popup_shown && !$on_verification_page && !$_SESSION['first_login']==1)
        {
            require_once("compaign.php"); 
        }

        if($_SESSION['first_login']==1 && ($this->uri->segment(1)!="kyc-verification" && $this->uri->segment(1)!="verify")){
            require_once("welcome_slide.php");
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


<?php echo html_entity_decode($this->front_model->get_query_simple('google_analytics','dev_web_config',array('cID'=>1))->result_object()[0]->google_analytics); ?>

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
 <?php 


 if(1==1){ ?>
 <script type="text/javascript" src="https://cdn.weglot.com/weglot.min.js"></script>
<script>
    Weglot.setup({
      api_key: '<?php echo $web_settings->translation_key; ?>',
      originalLanguage: 'en',
      destinationLanguages : '<?php echo $web_settings->allowed_langs; ?>',

     });

 
        <?php 

            if($web_settings->default_lang!="en" && $web_settings->default_lang!="" && strlen($web_settings->default_lang)==2){
         ?>
        

            Weglot.on("switchersReady", function(initialLanguage) {

        Weglot.switchTo('<?php echo $web_settings->default_lang; ?>');

         
});
    <?php } ?>

</script>
<?php } ?>
 <script type="text/javascript">
     $(document).on('click','a',function(){
        var that = $(this);
        var base_url = '<?php echo base_url(); ?>';
        var clicked_link = $(that).attr('href');
        if(base_url+'buy-tokens'==clicked_link)
        {
            $("body").append('<div class="loading">Loading&#8230;</div>');
        }
       
     });
 </script>
<?php 

if(am_i("tib")){
    if(isset($_SESSION['JobsSessions']))
    {

 ?>

<script>
  window.intercomSettings = {
    app_id: "x6dwfgjb",
    name: "<?php echo $user_own_details->uFname.' '.$user_own_details->uLname; ?>", // Full name
    email: "<?php echo $user_own_details->uEmail; ?>", // Email address
    created_at: <?php echo strtotime($user_own_details->joinDate); ?> // Signup date as a Unix timestamp
  };
  </script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/x6dwfgjb';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
<?php }else{

    ?>
<script>
  window.intercomSettings = {
    app_id: "x6dwfgjb"
  };
</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/x6dwfgjb';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>


<?php } } ?>


</html>
