<style type="text/css">
    <?php 

    $bg = $this->front_model->get_query_simple('*','dev_web_config',array('cID'=>1))->result_object()[0];


    if($bg->sign_bg){
      
        if(strpos($bg->sign_bg,'#') !== false)
            $color_bg = $bg->sign_bg;
        else
            $color_bg = '#'.$bg->sign_bg;
         

     ?>

      body .account-pages {

              margin: 0;
                  background-size: cover !important;
             
            }

 <?php } if($bg->logo_bg){

     if(strpos($bg->logo_bg,'#') !== false)
            $color_bg = $bg->logo_bg;
        else
            $color_bg = '#'.$bg->logo_bg;
  ?>

    

body #topnav .topbar-main {
  background: <?php echo $color_bg; ?> !important;
}
<?php } if($bg->page_bg){

    if(strpos($bg->page_bg,'#') !== false)
            $color_bg = $bg->page_bg;
        else
            $color_bg = '#'.$bg->page_bg;
 ?>
body{
  background: <?php echo $color_bg; ?> !important;
}
<?php }  ?>
</style>

<!-- jQuery  -->
<script src="<?php echo base_url();?>resources/frontend/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>resources/frontend/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>resources/frontend/js/detect.js"></script>
<script src="<?php echo base_url();?>resources/frontend/js/fastclick.js"></script>
<script src="<?php echo base_url();?>resources/frontend/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url();?>resources/frontend/js/jquery.blockUI.js"></script>
<script src="<?php echo base_url();?>resources/frontend/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url();?>resources/frontend/js/jquery.scrollTo.min.js"></script>

<!-- Notification js -->
<script src="<?php echo base_url();?>resources/frontend/js/notify.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>resources/frontend/js/notify-metro.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>resources/frontend/js/moment.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>resources/frontend/js/daterangepicker.js" type="text/javascript"></script>

<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="<?php echo base_url();?>resources/frontend/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>resources/frontend/js/jsvalidation.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>resources/frontend/js/rules.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>resources/frontend/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>resources/frontend/js/app.js"></script>
<?php //if($this->uri->segment(1) == "dashboard"){?>
<script src="<?php echo base_url();?>resources/frontend/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>resources/frontend/js/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url();?>resources/frontend/js/dataTables.responsive.min.js"></script>
<script language="javascript">
$(document).ready(function () {
	$('#requests-table').dataTable({
        "order": [],
    });
    $('.make-me-table').dataTable({
        "order": [],
    });
});
</script>
<?php //} ?>
<script type="text/javascript" src="<?php echo base_url();?>resources/frontend/js/global.config.js"></script>

<script type="text/javascript">
    var logo_text_src = 'assets/img/logo-text.svg';
    var logo_src = 'assets/img/logo.svg';
    var $logo = $('img#logo');

    $(window).resize(function(){
        var width = $( window ).width();

        if(width <= 400){
            if($logo.attr('src') != logo_src){
                $logo.hide();
                $logo.attr('style', 'width:35px;');
                $logo.attr('src', logo_src);
                $logo.show();
            }
        }else{
            if($logo.attr('src') != logo_text_src){
                $logo.hide();
                $logo.attr('style', '');
                $logo.attr('src', logo_text_src);
                $logo.show();
            }
        }
    });
    $(window).resize();

    function displayNotifications(){
                                    }
    displayNotifications();

    function displayNotification($type, $message){
        switch($type){
            case 'ok':
                $.Notification.notify('success', 'top-center', 'Success', $message);
                break;
            case 'warning':
                $.Notification.notify('warning', 'top-center', 'Warning', $message);
                break;
            case 'info':
                $.Notification.notify('info', 'top-center', 'Info', $message);
                break;
            case 'err':
                $.Notification.notify('error', 'top-center', 'Error', $message);
                break;
            default:
                return;
        }
    }

    window.uploadAvatar = $.fn.uploadAvatar = function(action, consumer_type) {
        Dropzone.autoDiscover = false;
        var defaultImageSrc = $("#avatarimg").attr("src");
        var dropzone = new Dropzone('#photo-upload', {
            autoProcessQueue: true,
            autoDiscover: false,
            url: action,
            paramName: 'avatar',
            addRemoveLinks: true,
            headers: {"X-CSRF-TOKEN": $('#form-avatar input[name="_token"]').first().val()},
            thumbnail: function (file, dataUrl) {
                $('#avatarimg').prop('src', dataUrl);
            },
            totaluploadprogress: function (progress) {
                $('.bar').css('width', progress + "%");
            },
//            accept: function (file, done) {
//                $('a.upload').first().show().click(function (e) {
//                    // Make sure that the form isn't actually being sent.
//                    e.preventDefault();
//                    e.stopPropagation();
//                    dropzone.processQueue();
//                });
//                $('.bar').attr("style", "margin-top:10px;height:5px;width:0%; background:#888888;");
//                done();
//            },
            sending: function (file, xhr, formData) {
                $('.bar').css('background', 'green');
                $('a.upload').hide();
                // Needed for the validation to work properly
                formData.append('type', consumer_type);
                // Needed to trick laravel to accept this as a PUT request
                formData.append('_method', 'put');
            },
            addedfile: function (file) {
                // Handle server side upload here if it is not on submit.
                // call this to remove default dropzone container
            },
            reset: function () {
                $('#avatarimg').attr("src", defaultImageSrc);
                $('a.dz-remove').hide();
                $('a.upload').hide();
                $('.bar').attr("style", "margin-top:10px;height:5px;width:0%; background:#888888;");
            },
            removedfile: function (file) {
                // Handle server side removal here
                dropzone.removeAllFiles(true);
            },
            success: function (file, data) {
                $.Notification.notify('success', 'top-center', 'Success', data.ok);
            },
            error: function (file, msg, xhr) {
                $.Notification.notify('error', 'top-center', 'Error', msg.avatar[0]);
                $('.bar').css('background', 'red');
            }
        });
    };

</script>


<?php if(am_i("tib")){ ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5QJZR58"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php } ?>
<?php echo LIVECHAT;?>
<!-- App core js -->
<script src="<?php echo base_url();?>resources/frontend/js/jquery.core.js"></script>
<script src="<?php echo base_url();?>resources/frontend/js/jquery.app.js"></script>

<!-- plugins js -->
<script src="<?php echo base_url();?>resources/frontend/js/bootstrap-select.min.js"></script>
<script src="<?php echo base_url();?>resources/frontend/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url();?>resources/frontend/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>resources/frontend/js/jquery.timepicker.min.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>resources/frontend/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>resources/frontend/js/jsvalidation.js"></script>
<!-- Start of LiveChat (www.livechatinc.com) code -->
<?php /*?><script type="text/javascript">
window.__lc = window.__lc || {};
window.__lc.license = 9823825;
(function() {
  var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
  lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
})();
</script><?php */?>
<!-- End of LiveChat code -->
