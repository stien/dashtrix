<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <!-- Site Properties -->
    <title>
    <?php if(WEBNAME != ""){echo WEBNAME;}else {?>
    Dashboard - <?php echo TITLEWEB;?>
    <?php } ?>
    </title>
	<?php require("css_include.php"); ?>




    <?php require("favicon.php"); ?>
    


    <script src="//www.google.com/recaptcha/api.js"></script>
</head>

<body>

<div class="wrapper sponsoredw">
    <div class="container sponsored on_kyc_margin_bottom_100">

    <!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container">

            <!-- Logo container-->
            <div class="logo">
                <a <?php if(SUBDOMAIN__!='') { echo "target='_blank'"; } ?> href="<?php if(SUBDOMAIN__!='') { echo str_replace(SUBDOMAIN__.'.','',base_url()); } else echo base_url(); ?>" class="logo">
                	<img id="" src="<?php echo base_url();?>resources/frontend/images/logo.png?time=<?php echo time(); ?>" style="width: <?php echo LOGO_WIDTH; ?>%;" alt="<?php echo TITLEWEB;?>">
                </a>
            </div>
            <!-- End Logo container-->

          	<?php


                if(ACTYPE==1){
                    $notqry = $this->front_model->get_query_orderby_limit('*','dev_web_notfiications',array('uID' => 0),'nID','DESC',10,0);


                }
                else
                {


				    $notqry = $this->front_model->get_query_orderby_limit('*','dev_web_notfiications',array('uID' => UID),'nID','DESC',10,0);
                }
                $noti   = $notqry->result_object();

			?>

            <div class="menu-extras">

                <ul class="nav navbar-nav navbar-right pull-right">
				<?php if(1==1){?>
                <?php if(ACTYPE==2){?>
                    <li class="total_tokens navbar-c-items">

                        <?php $token_symbol = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('active'=>1))->result_object()[0];
                        echo $token_symbol->token_symbol?$token_symbol->token_symbol:'Token';
                             ?>
                         Balance: <?php echo custom_number_format(get_my_tokens(UID),decimals_()); ?>
                    </li>

                    <?php } ?>

                    <li class="dropdown navbar-c-items">
                        <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
    <i class="icon-bell"></i> <span class="badge badge-xs badge-danger"><?php echo count($noti);?></span>
</a>
<ul class="dropdown-menu dropdown-menu-lg notyfy">
    <li class="notifi-title">Notifications</li>
  	 <li class="list-group slimscroll-noti notification-list">
       <?php foreach($noti as $notifications){?>

        <a href="<?php echo base_url();?>notifications" class="list-group-item">
            <div class="media">
                <div class="pull-left p-r-10">
                    <em class="fa fa-bell noti-primary notiimpo"></em>
                </div>
                <div class="media-body">
                    <h5 class="media-heading"><?php echo $notifications->nData;?></h5>
                    <p class="m-0">

                    </p>
                </div>
            </div>
        </a>

       <?php } ?>
         </li>
    <li>
        <a href="<?php echo base_url();?>notifications" class="list-group-item text-right">
            <small class="font-600">See all notifications</small>
        </a>
    </li>
</ul>
                    </li>
				<?php } ?>
                    <li class="dropdown navbar-c-items">
                        <a href="#" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true">
                            <strong class="upperclass userTitle"><?php echo FNAME." ".LNAME;?></strong> <img src="<?php
                            $path_profile = 'resources/uploads/profile/';

                            if($user_own_details->uImage)
                            $profile_self = base_url().$path_profile.$user_own_details->uImage;
                            else
                            $profile_self = base_url()."resources/frontend/img/default.svg";

                             echo $profile_self; ?>" alt="user-img" class="img-circle">

                        </a>
                      
                        <ul class="dropdown-menu userDrop">
                            <li><a href="<?php echo base_url();?>account/details"><i class="fa fa-user   m-r-10"></i> Account Settings</a></li>
                            <?php if(ACTYPE!=1){ ?>
                            <li><a href="<?php echo base_url();?>account/delete"><i class="fa fa-times   m-r-10"></i> Delete Account</a></li>
                            <?php } ?>
                                    <li><a href="<?php echo base_url();?>change-password"><i class="fa fa-lock  m-r-10"></i> Change Password</a></li>
                                <?php /*?><li><a href="javascript:void(0)"><i class="ti-help-alt  m-r-10"></i> Help</a></li><?php */?>
                            <li class="divider"></li>
                            <li>
                               <a href="<?php echo base_url();?>logout"><i class="fa fa-lock-o text-danger m-r-10"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <?php 

                $bg_nav_toggle = $this->front_model->get_query_simple('*','dev_web_config',array('cID'=>1))->result_object()[0];


    
      
        if(strpos($bg_nav_toggle->logo_bg,'#') !== false)
            $color_bgnav_toggle = $bg_nav_toggle->logo_bg;
        else
            $color_bgnav_toggle = '#'.$bg_nav_toggle->logo_bg; ?>
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle" >
                        <div class="lines">
                            <span style="<?php if(strpos(strtolower($color_bgnav_toggle),'fff') !== false || strpos(strtolower($color_bgnav_toggle),'fffff') !== false) { echo "background:black"; } else { echo "background:white"; } ?>"></span>
                            <span style="<?php if(strpos(strtolower($color_bgnav_toggle),'fff') !== false || strpos(strtolower($color_bgnav_toggle),'fffff') !== false) { echo "background:black"; } else { echo "background:white"; } ?>"></span>
                            <span style="<?php if(strpos(strtolower($color_bgnav_toggle),'fff') !== false || strpos(strtolower($color_bgnav_toggle),'fffff') !== false) { echo "background:black"; } else { echo "background:white"; } ?>"></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>

        </div>
    </div>

    <div class="navbar-custom">
        <div class="container">
            <div id="navigation" >
                <!-- Navigation Menu-->
                <ul class="navigation-menu">

                	<li <?php if($this->uri->segment(1) == "dashboard"){echo 'class="active"';}?>><a href="<?php echo base_url();?>dashboard">
                    <?php if(ACTYPE==1){ ?>
                        <img src="<?php echo base_url();?>resources/frontend/images/dashboard-icon.png" alt="" width="24">
                    <?php } ?>
                	Dashboard</a></li>
				   <?php if(ACTYPE == "2"){?>
                    <?php if($current_logged_user && json_decode($current_logged_user->whitelist_settings)->ability==1 || $current_logged_user->whitelist==0){ ?>
					<li <?php if($this->uri->segment(1) == "buy-tokens"){echo 'class="active"';}?>><a href="<?php echo base_url().'buy-tokens'; ?>">
						Buy Tokens</a></li>

                    <?php } ?>


                        <li <?php if($this->uri->segment(1) == "tranasctions"){echo 'class="active"';}?>><a href="<?php echo base_url().'tranasctions'; ?>">
                       Transactions</a></li>


                        <?php if($web_settings->hide_bounties==1){ ?>
                    <li class="dropdown navbar-c-items  <?php if($this->uri->segment(1) == "bounties"){echo 'active';}?>">
                        <a href="javascript:;" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true">
                           Bounties
                        </a>
                        <ul class="dropdown-menu">

                                <li><a href="<?php echo base_url().'bounties'; ?>"><i class="md md-content-copy  m-r-10"></i>Bounties</a></li>

                                <li class="divider"></li>
                                <li><a href="<?php echo base_url().'user-bounty-submissions' ?>"><i class="md md-content-copy  m-r-10"></i> My Submissions</a></li>


                            </ul>
                    </li>

                <?php } ?>


<?php if($web_settings->hide_ref==1){ ?>


                    <?php if(ACTYPE==2){ ?>

                        <li <?php if($this->uri->segment(1) == "my-referral-url"){echo 'class="active"';}?>><a href="<?php echo base_url();?>my-referral-url">My Referral URL</a></li>
           

    <?php } ?>

<?php } ?>

<?php /* ?>
					<li <?php if($this->uri->segment(1) == "referral"){echo 'class="active"';}?>><a href="<?php echo base_url();?>referrals" class=""><img src="<?php echo base_url();?>resources/frontend/images/referral-icon-small.png" alt="" width="24"> Referral Program</a></li>


                       <li class="dropdown navbar-c-items">
                           <a href="javascript:;" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true">
                               <i class="md md-content-copy"></i>Marketing Suite
                           </a>
                           <ul class="dropdown-menu">
                               <li><a href="<?php echo base_url().'paid-content-placement'; ?>"><i class="md md-content-copy  m-r-10"></i> Paid Content Placement</a></li>
                               <li><a href="<?php echo base_url().'my-paid-contents'; ?>"><i class="md md-content-copy  m-r-10"></i> My Paid Content</a></li>
                           </ul>
                       </li> <?php */ ?>
                    <?php } ?>
                    <!-- IF ACCOUNT IS ADMIN-->
                     <?php if(ACTYPE == "1"){?>

                    <?php if(role_exists(1)){ ?>

					<li class="dropdown navbar-c-items">
                        <a href="javascript:;" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true">
                           <i class="md md-settings"></i>ICO Settings
                        </a>
                        <ul class="dropdown-menu">

                                <li><a href="<?php echo base_url().'admin/ico-settings'; ?>"><i class="md md-content-copy  m-r-10"></i> ICO Campaigns</a></li>
                                <li class="divider"></li>

                                <li><a href="<?php echo base_url().'admin/whitelist'; ?>"><i class="md md-content-copy  m-r-10"></i> Whitelist</a></li>
                                <li class="divider"></li>


                                <li><a href="<?php echo base_url();?>admin/token/pricing"><i class="md md-content-copy  m-r-10"></i> Token Pricing</a></li>

                                <li class="divider"></li>


                                <li><a href="<?php echo base_url().'admin/payment-settings'; ?>"><i class="md md-content-copy  m-r-10"></i> Payment Settings</a></li>
                                <li class="divider"></li>

                                <?php if($web_settings->hide_ref==1){ ?>

                                <li><a href="<?php echo base_url();?>admin/referral-settings"><i class="md md-content-copy  m-r-10"></i> Referral Settings</a></li>
                            <?php } ?>
                            <?php if($web_settings->hide_airdrop==1){ ?>

                                <li><a href="<?php echo base_url().'admin/user-onboarding-compaigns' ?>"><i class="md md-content-copy  m-r-10"></i> User On-boarding</a></li>
                            <?php } ?>

                           
                                <li><a href="<?php echo base_url().'admin/ico-milestones' ?>"><i class="md md-content-copy  m-r-10"></i> ICO Milestones</a></li>
                                

                                <?php if($web_settings->allow_sale_bar==1){ ?>
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url().'admin/edit-sale-bar' ?>"><i class="md md-content-copy  m-r-10"></i> Edit Sale bar</a></li>

                                <?php } ?>



							</ul>
                    </li>
                    <?php } ?>
                    <?php if(role_exists(2)){ ?>


                    <li class="dropdown navbar-c-items">
                        <a href="javascript:;" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true">
                           <i class="md md-desktop-mac"></i>Site Settings
                        </a>
                        <ul class="dropdown-menu">

                                <li><a href="<?php echo base_url().'admin/settings'; ?>"><i class="md md-content-copy  m-r-10"></i> General Settings</a></li>
                                <li><a href="<?php echo base_url().'admin/language-settings'; ?>"><i class="md md-content-copy  m-r-10"></i> Language Settings</a></li>
                                <li><a href="<?php echo base_url().'admin/email-settings'; ?>"><i class="md md-content-copy  m-r-10"></i> Email Settings</a></li>

                                 <li><a href="<?php echo base_url().'admin/authy-settings'; ?>"><i class="md md-content-copy  m-r-10"></i> Authy Settings</a></li>

                                   <li><a href="<?php echo base_url();?>KYC/AML"><i class="md md-content-copy  m-r-10"></i>  KYC/AML</a></li>


                                <li><a href="<?php echo base_url();?>admin/gdpr-settings"><i class="md md-content-copy  m-r-10"></i>  GDPR Settings</a></li>
                                
                                <li><a href="<?php echo base_url();?>admin/admin-users"><i class="md md-content-copy  m-r-10"></i>  Admin Users</a></li>
								<li>
                                	<a href="<?php echo base_url();?>admin/banned-countries">
                                		<i class="md md-content-copy  m-r-10"></i>  IP Bans
                                	</a>
                                </li>
                                <li>
                                	<a href="<?php echo base_url();?>admin/user-registration">
                                		<i class="md md-content-copy  m-r-10"></i>  User Registration
                                	</a>
                                </li>

                                <li class="divider"></li>

                                 <li>
                                    <a href="<?php echo base_url();?>admin/privacy-pages">
                                        <i class="md md-content-copy  m-r-10"></i>  Privacy Pages
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>admin/terms-pages">
                                        <i class="md md-content-copy  m-r-10"></i>  Terms Pages
                                    </a>
                                </li>

                            <!--     <li><a href="<?php echo base_url().'admin/create-smart-contract' ?>"><i class="md md-content-copy  m-r-10"></i> Smart Contract Creation</a></li>
                                <li><a href="<?php echo base_url().'admin/submitted-smart-contracts' ?>"><i class="md md-content-copy  m-r-10"></i> Submitted Smart Contracts</a></li>
                                <li class="divider"></li> -->


                                <!-- <li><a href="<?php echo base_url().'admin/settings'; ?>"><i class="md md-content-copy  m-r-10"></i> Site Settings</a></li> 

                                <li class="divider"></li>

                                <li class="divider"></li>-->
           
                            </ul>
                    </li>
                    <?php } ?>
                    <?php if(role_exists(3)){ ?>


                     <li class="dropdown navbar-c-items">
                        <a href="javascript:;" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true">
                           <i class="md md-assignment"></i>Reports
                        </a>
                        <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url();?>admin/user/reports"><i class="md md-content-copy  m-r-10"></i> User Reports</a></li>
                                <li>
                                    <a href="<?php echo base_url();?>admin/user/reports/whitelist">
                                        <i class="md md-content-copy  m-r-10"></i>  Whitelist Users
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url();?>admin/user/verifications"><i class="md md-content-copy  m-r-10"></i> User Verifications</a></li>

                                <li><a href="<?php echo base_url();?>admin/tranasctions"><i class="md md-content-copy  m-r-10"></i> Transactions </a></li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="md md-content-copy  m-r-10"></i> Bounty Reports </a></li>

                                <li><a href="#"><i class="md md-content-copy  m-r-10"></i> Activity Logs </a></li>
                                
                                <li><a href="#"><i class="md md-content-copy  m-r-10"></i> Referral Reports </a></li>

                                <?php /* ?>
                                <li class="divider"></li>

                                <?php */ ?>

                            </ul>
                    </li>
                    <?php } ?>
                    <?php if(role_exists(4)){ ?>
                        <?php if($web_settings->hide_bounties==1){ ?>

                    <li class="dropdown navbar-c-items">
                        <a href="javascript:;" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true">
                           <i class="md md-perm-media"></i>Bounty Campaigns
                        </a>
                        <ul class="dropdown-menu">
								<li><a href="<?php echo base_url().'admin/bounty-campaigns' ?>"><i class="md md-content-copy m-r-10"></i> Manage Bounties </a></li>
                                <li><a href="<?php echo base_url().'admin/bounty-submissions' ?>"><i class="md md-content-copy  m-r-10"></i> View Submissions</a></li>

								<li class="divider"></li>


                                <li><a href="<?php echo base_url().'admin/bounty-landing-page' ?>"><i class="md md-content-copy m-r-10"></i> Bounties Landing Page</a></li>

                                 <li class="divider"></li>

                                <li><a href="<?php echo base_url().'admin/add-bounty-campaign' ?>"><i class="md md-content-copy  m-r-10"></i> Create New Bounty</a></li>




							</ul>
                    </li>
                    <?php } ?>
                    <?php } ?>
                    <?php /*if(role_exists(5)){ ?>

                    <li class="dropdown navbar-c-items">
                        <a href="javascript:;" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true">
                           <i class="md md-work"></i>ICO Tools
                        </a>
                        <ul class="dropdown-menu">

                                <li><a href="<?php echo base_url().'admin/ico-directory-submission'; ?>"><i class="md md-content-copy  m-r-10"></i> Directory Submission</a></li>


                                  <li><a href="<?php echo base_url().'admin/paid-content-placement'; ?>"><i class="md md-content-copy  m-r-10"></i> Promoted Content</a></li>


                               <?php /* ?> <li><a href="<?php echo base_url().'marketing-suite'; ?>"><i class="md md-content-copy  m-r-10"></i> Marketing Suite</a></li>

								<?php */ ?>


                          <!--       <li><a href="<?php echo base_url().'admin/sponsored-predictions' ?>"><i class="md md-content-copy  m-r-10"></i> Sponsored Predictions</a></li>
                                 <li><a href="<?php echo base_url().'spring-role'; ?>"><i class="md md-content-copy  m-r-10"></i> Spring Role</a></li>

                                <li><a href="<?php echo base_url().'admin/create-smart-contract' ?>"><i class="md md-content-copy  m-r-10"></i> Token Creation</a></li> -->
<?php /* ?>
                                <li><a href="<?php echo base_url().'#' ?>"><i class="md md-content-copy  m-r-10"></i> GDPR Scanner</a></li>
                                <?php */ ?>



				<!-- 			</ul>
                    </li> -->
                    <?php/* } */ ?>
                   



                    <li class="navbar-c-items">
                        <a href="<?php echo base_url().'admin/support' ?>" class="waves-effect waves-light profile" aria-expanded="true">
                           <i class="fa fa-life-ring"></i>Support
                        </a>

                    </li>

                    <?php } ?>
                </ul><!-- End navigation menu -->

                </div>
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->

         <!--        <div class="userTitle">
                <ul class="navigation-menu right">
                    <li  class="">
                        <a href="<?php echo base_url();?>dashboard">
                            WELCOME <strong class="upperclass"><?php echo FNAME." ".LNAME;?></strong>
                        </a>
                    </li>
                </ul>
            </div> -->
            
</header>
<!-- End Navigation Bar-->


    <div id="msg-container-master"></div>


    <?php
  if(ACTYPE==1){
    $walled_address_ = $this->front_model->get_query_simple('*','dev_web_payment_options',array('one_per_trans'=>1))->result_object();

    foreach($walled_address_ as $walled)
    {
         $count_addresss = $this->front_model->get_query_simple('*','dev_web_wallet_addresses',array('option_id'=>$walled->id,'used'=>0))->result_object();

         if($walled->warning_before>count($count_addresss)){



    


     ?>


    <div style="text-align: center; background: orange; color:#fff; padding: 10px;">
        Your wallet addresses are near to end. Please enter new <a href="<?php echo base_url().'admin/wallet-addresses/'.$walled->id; ?>">here</a> to continue using one address per tranasction feature.
    </div>
<?php 
    break;
} }  } ?>
