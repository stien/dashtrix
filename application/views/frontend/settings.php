<?php require_once("common/header.php");?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
               <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
            </div>
            <h4 class="page-title">Site Settings</h4>
        </div>
    </div>

    <div class="row">
        
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
        
        <div class="col-md-8">
            <form method="POST" action="" accept-charset="UTF-8" id="form-profile">
            <input type="hidden" name="type" value="company">

            <div class="card-box widget-box-1">
                <h4 class="header-title m-t-0 m-b-30">Site Settings</h4>
                <div class="row">
                   
                     
                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Site Name</label>
                            <input class="form-control" name="configWeb" value="<?php echo $setting->configWeb; ?>" required type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Site Title</label>
                            <input class="form-control" name="configTitle" value="<?php echo $setting->configTitle; ?>" required type="text">
                        </div>
                    </div>
                  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>URL <sup>*</sup> <small>(Your site's current URL e.g. <?php echo base_url(); ?>)</small></label>
                            <input class="form-control" name="configURL" value="<?php echo $setting->configURL; ?>" required type="text">
                        </div>
                    </div>
                  

                     <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone</label>
                            <input class="form-control" name="configPhone"  value="<?php echo $setting->configPhone!=123?$setting->configPhone:''; ?>" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input class="form-control" name="configEmail"  value="<?php echo $setting->configEmail; ?>" required type="email">
                        </div>
                    </div>
                      <div class="col-md-12">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="configAddress" class="form-control"><?php echo $setting->configAddress; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Copyright text</label>
                            <input class="form-control" name="configCopy" value="<?php echo $setting->configCopy;?>" required type="text">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Facebook</label>
                            <input class="form-control" name="configFacebook" value="<?php echo $setting->configFacebook;?>"  type="text">
                        </div>
                    </div>

                    

                   

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Twitter</label>
                            <input class="form-control" name="configTwitter" value="<?php echo $setting->configTwitter;?>" type="text">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Instagram</label>
                            <input class="form-control" name="instagram" value="<?php echo $setting->instagram;?>" type="text">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Google</label>
                            <input class="form-control" name="webGoogle" value="<?php echo $setting->webGoogle;?>" type="text">
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Youtube</label>
                            <input class="form-control" name="webYouTube" value="<?php echo $setting->webYouTube;?>" type="text">
                        </div>
                    </div>

                    <?php if(am_i('hydro')){ ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Discord</label>
                                <input class="form-control" name="discord" value="<?php echo $setting->discord;?>" type="text">
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tumblr</label>
                                <input class="form-control" name="tumbler" value="<?php echo $setting->tumbler;?>" type="text">
                            </div>
                        </div>
                    <?php } ?>

                    <!-- lllllllllllllll -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telegram</label>
                            <input class="form-control" name="telegram" value="<?php echo $setting->telegram;?>" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bitcointalk</label>
                            <input class="form-control" name="bitcointalk" value="<?php echo $setting->bitcointalk;?>" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Reddit</label>
                            <input class="form-control" name="reddit" value="<?php echo $setting->reddit;?>" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Steemit</label>
                            <input class="form-control" name="steemit" value="<?php echo $setting->steemit;?>" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>GitHub</label>
                            <input class="form-control" name="github" value="<?php echo $setting->github;?>" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>LinkedIn</label>
                            <input class="form-control" name="webLkndIn" value="<?php echo $setting->webLkndIn;?>" type="text">
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                            <label>Color</label>
                            <input class="form-control jscolor" name="color" value="<?php echo str_replace('#','', $setting->color);?>" required type="text">
                        </div>
                    </div>


                     <div class="col-md-12">
                        <div class="form-group">
                            <label>Google Analytics Code</label>
                            <textarea class="form-control" name="google_analytics"><?php echo $setting->google_analytics;?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Logo Background Color</label>
                            <input class="form-control jscolor" name="logo_bg" value="<?php echo str_replace('#','', $setting->logo_bg);?>" required type="text">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Signup, Login & Forgot Password Background Color</label>
                            <input class="form-control jscolor" name="sign_bg" value="<?php echo str_replace('#','', $setting->sign_bg);?>" required type="text">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Page Background Color</label>
                            <input class="form-control jscolor" name="page_bg" value="<?php echo str_replace('#','', $setting->page_bg);?>" required type="text">
                        </div>
                    </div>


                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Timezone</label>

                                                <select required name="timezone" class="form-control">
                                                    <option value="">Please Choose</option>
                                                <?php $timezones = $this->db->order_by('zone_name','ASC')->get('dev_web_timezones')->result_object();
                                                foreach($timezones as $timezone){
                                                 ?>
                                                    <option <?php if($setting->timezone==$timezone->zone_name) echo "selected"; ?> value="<?php echo $timezone->zone_name; ?>"><?php echo $timezone->zone_name; ?></option>

                                                <?php } ?>
                                                </select>
                                           
                                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Decimal Points <small>How many decimals you want to display after point (0.000)</small></label>

                                <select  name="decimals" class="form-control">
                                    <option value="">Please Choose</option>
                                <?php 
                                for($i=1; $i<=10; $i++){


                                    $x = 1; 
                                    $d_="";
                                    while($x<=$i){
                                        $d_ .= "0";
                                        $x++;
                                    }


                                 ?>
                                    <option <?php if($setting->decimals==$i) echo "selected"; ?> value="<?php echo $i; ?>"><?php echo $i. " (0.".$d_.")"; ?></option>

                                <?php } ?>
                                </select>
                           
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Subdomain <small>e.g "fonts" from https://fonts.google.com, only fill this if you want to open your website in new tab on click of logo</small></label>
                            <input class="form-control" name="subdomain" value="<?php echo $setting->subdomain;?>" type="text">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    


                       <?php /*?><div class="col-md-12">

                            <div class="form-group">

                                <label>Image <sup>*</sup> </label>

                                <input name="inputfile" type="file" accept="image/*" class="form-control"  value="" id="inputfile">
                                <label class="msg"></label>
                                <img src="<?php echo base_url().'resources/frontend/images/'.$setting->logo; ?>" class="uploading_image ">

                            </div>

                        </div><?php */?>


                   

                   
                    
                    
                 
                  
                 
                    
                    
                    
                </div>
            </div>
			 <div class="row" id="passwordrequest">
                <div class="col-sm-12 m-b-30">
                    <div class="button-list pull-right m-t-15">
                        <button class="btn btn-default submit-form" type="submit" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button>
                    </div>
                </div>
            </div>
            </form>




           
        </div>
        <!-- end col -->

        <div class="col-md-4">
          <div class="card-box m-b-50" style="clear: both; float: left; width: 100%;">
            <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>User Dashboard "PRE-ICO days" remaining text</strong></label>
                    <form method="post" action="<?php echo base_url().'ico/update_meta'; ?>">
                    <div class="custom_buttons">
                        

                        <div class="form-group">
                            <input class="form-control" style="width: 100%; float: left;" type="text" name="campaign_user_dashboard_text" value="<?php
                            $text_for_this_one_div = $this->db->where('type','campaign_user_dashboard_text')->get('dev_web_meta')->result_object()[0];
                                if($text_for_this_one_div->value)
                                    echo $text_for_this_one_div->value;
                                else
                                    echo 'PRE-ICO Days Remaining';
                             ?>">
                         </div>
                            
                   


                        <button style="margin-top: 15px;"  class="btn btn-default right">Update</button>
                    </div>


                   
                        
                    
                    </form>

                    
                </div>
        </div>
        <?php if(am_i('securix')){ ?>
         <div class="card-box m-b-50" style="clear: both; float: left; width: 100%; margin-top: 20px;">
            <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Welcome Text On User Dashboard</strong></label>
                    <form method="post" action="<?php echo base_url().'ico/update_welcome_text'; ?>">
                    <div class="custom_buttons">
                        

                        <div class="form-group">
                            <label>Heading</label>
                            <input class="form-control" style="width: 100%; float: left;" type="text" name="welcome_heading" value="<?php echo $setting->welcome_heading;?>">
                         </div>
                         <div class="form-group">
                            <label>Body</label>
                            <textarea class="form-control" name="welcome_body"><?php echo $setting->welcome_body;?></textarea>
                         </div>
                            
                   


                        <button style="margin-top: 15px;"  class="btn btn-default right">Update</button>
                    </div>


                   
                        
                    
                    </form>

                    
                </div>
        </div>
    <?php } ?>


<!--     <div class="card-box m-b-50" style="clear: both; float: left; width: 100%; margin-top: 20px;">
            <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Syndicate to BankICO</strong></label>
                    <br>
                    <?php if($setting->syndicate==1){ ?>
                    <a href="<?php echo base_url().'ico/turn_off_syndication'; ?>" class="m-t-15">
                        <button class="btn btn-danger" type="button">Turn Off</button>
                    </a>
                    <?php }else{ ?>
                    <a href="<?php echo base_url().'ico/turn_on_syndication'; ?>" class="m-t-15">
                        <button class="btn btn-primary" type="button">Turn On</button>
                    </a>
                    <?php } ?>

                    
                </div>
        </div> -->
        <?php if(role_exists(1)){ ?>


        <div class="card-box m-b-50" style="clear: both; float: left; width: 100%; margin-top: 20px;">
            <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Hide Bounties from user side</strong></label>
                    <br>
                    <?php if($setting->hide_bounties==1){ ?>
                    <a href="<?php echo base_url().'ico/hide_bounties/0'; ?>" class="m-t-15">
                        <button class="btn btn-danger" type="button">Hide</button>
                    </a>
                    <?php }else{ ?>
                    <a href="<?php echo base_url().'ico/hide_bounties/1'; ?>" class="m-t-15">
                        <button class="btn btn-primary" type="button">Show</button>
                    </a>
                    <?php } ?>

                    
                </div>
        </div>

        <div class="card-box m-b-50" style="clear: both; float: left; width: 100%; margin-top: 20px;">
            <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Hide Airdrop from user side</strong></label>
                    <br>
                    <?php if($setting->hide_airdrop==1){ ?>
                    <a href="<?php echo base_url().'ico/hide_airdrop/0'; ?>" class="m-t-15">
                        <button class="btn btn-danger" type="button">Hide</button>
                    </a>
                    <?php }else{ ?>
                    <a href="<?php echo base_url().'ico/hide_airdrop/1'; ?>" class="m-t-15">
                        <button class="btn btn-primary" type="button">Show</button>
                    </a>
                    <?php } ?>

                    
                </div>
        </div>

        <div class="card-box m-b-50" style="clear: both; float: left; width: 100%; margin-top: 20px;">
            <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Hide Referral from user side</strong></label>
                    <br>
                    <?php if($setting->hide_ref==1){ ?>
                    <a href="<?php echo base_url().'ico/hide_ref/0'; ?>" class="m-t-15">
                        <button class="btn btn-danger" type="button">Hide</button>
                    </a>
                    <?php }else{ ?>
                    <a href="<?php echo base_url().'ico/hide_ref/1'; ?>" class="m-t-15">
                        <button class="btn btn-primary" type="button">Show</button>
                    </a>
                    <?php } ?>

                    
                </div>
        </div>
    <?php } ?>


        </div>
        <!-- end col -->

    </div>
<?php require_once("common/footer.php");?>
<script type="text/javascript" src="<?php echo base_url().'resources/frontend/js/jscolor.min.js' ?>"></script>

<?php if(isset($_GET['type'])){?>
	<script language="javascript">
		 $("html, body").delay(400).animate({
        scrollTop: $('#passwordrequest').offset().top 
    }, 2000);
	</script>
<?php } ?>
<script language="javascript">
function confirmpassword_request(){
	if($("#newpass").val() != $("#confirmpass").val()){
		$("#upbtn").attr("disabled",true);
		$("#confirmerror").html('<div class="wrongerror">Password & New Password not matched!</div>');
	} else {
		$("#upbtn").attr("disabled",false);
		$("#confirmerror").html('');
	}
}
</script>

<script>

    function cclick()
    {
        $("#inputfile").click();
    }
$(function () {
$('#inputfile').change(function () {

     $('.img').hide();

 
  $('.msg').text('Please Wait...');
  $('#submit_btn').prop('disabled', true);

  var myfile = $('#inputfile').val();
  var formData = new FormData();
  formData.append('inputfile', $('#inputfile')[0].files[0]);
   $('.msg').text('Uploading in progress...');
  $.ajax({
    url: '<?php echo base_url().'ico/take_image_logo'; ?>',
    data: formData,
    processData: false,
    contentType: false,
    type: 'POST',
  
    success: function (data) {

      data = JSON.parse(data);
       
      $('.msg').html(data.msg);


      if(data.status==1){
     

          $('.img').attr('src',data.src);
          $('.img').show();
         $('#submit_btn').prop('disabled', false);

        }
    }
  });
});
});

$("#remove-photo").click(function(){
    
    $.post('<?php echo base_url().'ico/remove_profile_pic'; ?>',{remove:true},function(){
         $('.img').attr('src','<?php echo base_url().'resources/uploads/profile/default.svg'; ?>');
          $('.img').show();
    });
});
</script>
