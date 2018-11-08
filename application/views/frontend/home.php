<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <link rel="shortcut icon" href="assets/img/favicon.svg">
    <title><?php  echo TITLEWEB; ?> - Login</title>
 	<?php require("common/css_include.php"); require("common/favicon.php"); ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<body>
    <?php if(am_i('securix')){ ?>
       <!-- Google Tag Manager (noscript) -->
<!-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KSTKNCH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> -->
<!-- End Google Tag Manager (noscript) -->


    <?php } ?>

     <?php 

    $bg = $this->front_model->get_query_simple('*','dev_web_config',array('cID'=>1))->result_object()[0];


    if($bg->sign_bg){
      
        if(strpos($bg->sign_bg,'#') !== false)
            $color_bg = $bg->sign_bg;
        else
            $color_bg = '#'.$bg->sign_bg;
    }
         

     ?>

<div class="account-pages"></div>
<div class="clearfix"></div>

<div class="wrapper-page">

    <div class="panel-heading text-center m-b-15 right-style">
        <?php if(!am_i('yanu')){ ?>
        <h2 class="logInTl">Dashboard Login</h2>
    <?php } ?>
        <img class="logo-sign" src="<?php echo base_url();?>resources/frontend/images/logo.png?time=<?php echo time(); ?>" alt="<?php  echo TITLEWEB; ?>"/>

    <?php if(am_i('yanu')){ ?>

    <div class="row">

        <div class="col-sm-12 text-center">
            <p style="margin-top: 30px;" class="<?php if(strpos(strtolower($color_bg),'fff') !== false || strpos(strtolower($color_bg),'fffff') !== false) { } else { ?>text-white <?php } ?>">
                Create an account to participate in Yanu token sale <br> <a href="<?php echo base_url();?>signup/step" class="text-primary m-l-5">Sign Up <i class="fa fa-angle-right"></i></a>
            </p>
        </div>
    </div>
    <?php } ?>

    </div>

    <div class="card-box loginpage left-style">
        <div class="panel-body">
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

            <form method="POST" action="<?php echo base_url();?>do/login" accept-charset="UTF-8" role="form">

            <div class="col-md-12">
                <div class="form-group">
                    <!-- <label>Email Address: <sup>*</sup></label> -->
                    <input name="username" class="form-control uname" type="text" required="" value="" placeholder="Email Address">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <!-- <label>Password: <sup>*</sup></label> -->
                    <input name="password" class="form-control pss" type="password" required="" placeholder="Password">
                </div>
            </div>
            <?php if(CAPTCHA==1){ ?>
                <div class="col-md-12">
                                        <div class="form-group">
                                                <div class="g-recaptcha" data-sitekey="<?php echo CAPTCHA_KEY; ?>"></div>
                                        </div>
                                    </div>
<?php } ?>

            <div class="col-md-12 m-t-20">
                <div class="form-group">
                    <button class="btn btn-default btn-block btn-lg" type="submit">
                        LOG IN
                    </button>
                </div>
            </div>

<?php if(!am_i('yanu')){ ?>
            <div class="form-group m-t-20 m-b-0">
                <div class="col-sm-12">

                               <!-- <div class="text-dark midLoginText">OR</div> -->

                    <a href="<?php echo base_url();?>signup/step" class="text-dark btn btn-default btn-block btn-lg orangeButt">CREATE NEW ACCOUNT</a>

                </div>
            </div>
 <?php }else{ ?>
 <!--    <div class="form-group m-t-20 m-b-0">
                <div class="col-sm-12 text-center">
                    <a href="<?php echo base_url();?>forgot-password" class="text-dark"><i
                                class="fa fa-lock m-r-5"></i> Forgot Password?</a>
                </div>
            </div> -->
 <?php } ?>

            </form>

        </div>
    </div>


  <div class="row">
        <div class="col-sm-12 text-center">
         
                
                    <a href="<?php echo base_url();?>forgot-password" class="text-dark"><i
                                class="fa fa-help m-r-5"></i> Forgot Credentials?</a>
           
        </div>
    </div> 

    <?php if(!am_i('yanu')){ ?>
<!--     <div class="row">
        <div class="col-sm-12 text-center">
            <p class="">
                <a href="<?php echo base_url();?>privacy-policy" class="text-primary m-l-5">
                    <i class="fa fa-book m-r-5"></i> Privacy Policy</a>
            </p>
        </div>
    </div> -->
    <?php } ?>

</div>

<script>
    var resizefunc = [];
</script>
<div class="loginFooter">
<?php require("common/footer.php"); ?>
</div>

<script>
    jQuery(document).ready(function(){

        $("form").validate({
            errorElement: 'span',
            errorClass: 'help-block error-help-block',

            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length ||
                    element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                    error.insertAfter(element.parent());
                    // else just place the validation message immediatly after the input
                }
                else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error'); // add the Bootstrap error class to the control group
            },


            /*
             // Uncomment this to mark as validated non required fields
             unhighlight: function(element) {
             $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
             },
             */
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error'); //.addClass('has-success'); // remove the Boostrap error class from the control group
                
            },

            focusInvalid: false, // do not focus the last invalid input

            rules: {"username":{"laravelValidation":[["Required",[],"The username field is required.",true],["String",[],"The username must be a string.",false]]},"password":{"laravelValidation":[["Required",[],"The password field is required.",true],["String",[],"The password must be a string.",false]]}},
            onfocusout: false
        })

                var checkmarkIdPrefix = "loadingCheckSVG-";
                var checkmarkCircleIdPrefix = "loadingCheckCircleSVG-";
                var verticalSpacing = 75;

                function shuffleArray(array) {
                    for (var i = array.length - 1; i > 0; i--) {
                        var j = Math.floor(Math.random() * (i + 1));
                        var temp = array[i];
                        array[i] = array[j];
                        array[j] = temp;
                    }
                    return array;
                }

                function createSVG(tag, properties, opt_children) {
                  var newElement = document.createElementNS("http://www.w3.org/2000/svg", tag);
                  for(prop in properties) {
                    newElement.setAttribute(prop, properties[prop]);
                  }
                  if (opt_children) {
                    opt_children.forEach(function(child) {
                      newElement.appendChild(child);
                    })
                  }
                  return newElement;
                }

                function createPhraseSvg(phrase, yOffset) {
                  var text = createSVG("text", {
                    fill: "white",
                    x: 50,
                    y: yOffset,
                    "font-size": 18,
                    "font-family": "Arial"
                  });
                  text.appendChild(document.createTextNode(phrase + "..."));
                  return text;
                }
                function createCheckSvg(yOffset, index) {
                  var check = createSVG("polygon", {
                    points: "21.661,7.643 13.396,19.328 9.429,15.361 7.075,17.714 13.745,24.384 24.345,9.708 ",
                    fill: "rgba(255,255,255,1)",
                    id: checkmarkIdPrefix + index
                  });
                  var circle_outline = createSVG("path", {
                    d: "M16,0C7.163,0,0,7.163,0,16s7.163,16,16,16s16-7.163,16-16S24.837,0,16,0z M16,30C8.28,30,2,23.72,2,16C2,8.28,8.28,2,16,2 c7.72,0,14,6.28,14,14C30,23.72,23.72,30,16,30z",
                    fill: "white"
                  })
                  var circle = createSVG("circle", {
                    id: checkmarkCircleIdPrefix + index,
                    fill: "rgba(255,255,255,0)",
                    cx: 16,
                    cy: 16,
                    r: 15
                  })
                  var group = createSVG("g", {
                    transform: "translate(10 " + (yOffset - 20) + ") scale(.9)"
                  }, [circle, check, circle_outline]);
                  return group;
                }

                function addPhrasesToDocument(phrases) {
                  phrases.forEach(function(phrase, index) {
                    var yOffset = 30 + verticalSpacing * index;
                    document.getElementById("phrases").appendChild(createPhraseSvg(phrase, yOffset));
                    document.getElementById("phrases").appendChild(createCheckSvg(yOffset, index));
                  });
                }

                function easeInOut(t) {
                  var period = 200;
                  return (Math.sin(t / period + 100) + 1) /2;
                }
                        $('form').on('submit', function(){

                            if ($('.uname').val().length > 0 && $('.pss').val().length > 0 ) {

                            $('#page').css('display','flex').fadeIn();

                          var phrases = shuffleArray(["Confirming Security Protocals", 
                                                        "Confirming Access Control", 
                                                        "Enforcing Authentication",
                                                        "Configuring Role-Based Access",
                                                        "Encrypting Database Communication",
                                                        "Analyzing Network Exposure",
                                                        "Auditing System Activity",
                                                        "Requesting Access",
                                                        "Attempting Handshake", 
                                                        "Establishing Handshake",
                                                        "Configuring Dashboard",
                                                        "Reading Preferences",
                                                        "Deploying Dashboard",
                                                        "Logging System Activity"
                                ]);
                          addPhrasesToDocument(phrases);
                          var start_time = new Date().getTime();
                          var upward_moving_group = document.getElementById("phrases");
                          upward_moving_group.currentY = 0;
                          var checks = phrases.map(function(_, i) { 
                            return {check: document.getElementById(checkmarkIdPrefix + i), circle: document.getElementById(checkmarkCircleIdPrefix + i)};
                          });
                          function animateLoading() {
                            var now = new Date().getTime();
                            upward_moving_group.setAttribute("transform", "translate(0 " + upward_moving_group.currentY + ")");
                            upward_moving_group.currentY -= 1.35 * easeInOut(now);
                            checks.forEach(function(check, i) {
                              var color_change_boundary = - i * verticalSpacing + verticalSpacing + 15;
                              if (upward_moving_group.currentY < color_change_boundary) {
                                var alpha = Math.max(Math.min(1 - (upward_moving_group.currentY - color_change_boundary + 15)/30, 1), 0);
                                check.circle.setAttribute("fill", "rgba(255, 255, 255, " + alpha + ")");
                                var check_color = [Math.round(255 * (1-alpha) + 120 * alpha), Math.round(255 * (1-alpha) + 154 * alpha)];
                                check.check.setAttribute("fill", "rgba(255, " + check_color[0] + "," + check_color[1] + ", 1)");
                              }
                            })
                            if (now - start_time < 30000 && upward_moving_group.currentY > -710) {
                              requestAnimationFrame(animateLoading);
                            }
                          }
                          //animateLoading();
                            }


                    })

        })


</script>

<?php unset($_SESSION['thankyou']); unset($_SESSION['error']);?>
<?php if(!$pdf_view && !am_i('lib')){ ?>
<p style="font-size: 10px; color: #ffffff; opacity:0;" class="flt_right clr_white">Developed by Stien</p>
<?php } ?>

<div id="page">
  <div id="phrase_box">
  <svg width="100%" height="100%">
    <defs>
      <mask id="mask" maskUnits="userSpaceOnUse" maskContentUnits="userSpaceOnUse">
        <linearGradient id="linearGradient" gradientUnits="objectBoundingBox" x2="0" y2="1">
          <stop stop-color="white" stop-opacity="0" offset="0%"/>
          <stop stop-color="white" stop-opacity="1" offset="30%"/>
          <stop stop-color="white" stop-opacity="1" offset="70%"/>
          <stop stop-color="white" stop-opacity="0" offset="100%"/>
        </linearGradient>
        <rect width="100%" height="100%" fill="url(#linearGradient)"/>
      </mask>
    </defs>
    <g width="100%" height="100%" style="mask: url(#mask);">
      <g id="phrases"></g>
    </g>
  </svg>
  </div>

</div>
</body>

</html>
