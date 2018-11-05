
<link href="<?php echo base_url();?>resources/frontend/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>resources/frontend/css/core.css?time=<?php echo time();?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>resources/frontend/css/components.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>resources/frontend/css/icons.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>resources/frontend/css/pages.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url();?>resources/frontend/css/responsive.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo base_url();?>resources/frontend/css/menu.css?time=<?php echo time();?>" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>resources/frontend/css/sign-up.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>resources/frontend/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>resources/frontend/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>resources/frontend/css/jquery.timepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>resources/frontend/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css" />

<?php //if($this->uri->segment(1) == "dashboard"){?>
<link href="<?php echo base_url();?>resources/frontend/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>resources/frontend/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" /> 
<?php //} ?>

<link href="<?php echo base_url();?>resources/frontend/css/common.css?time=<?php echo time();?>" rel="stylesheet" type="text/css"/>



<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

<style type="text/css">
	
	<?php $this_web_primary = $web_settings->primary_color;


	$this_web_primary = "#83a7b9";


	echo "color:".$this_web_primary;



	 ?>

	 /*-----------------*/
	.about-ul i{
        color: <?php echo $this_web_primary; ?>;
   	}
	/*-----------------*/
	.btn-default:hover,
     .open > .dropdown-toggle.btn-default {
      background-color: <?php echo $this_web_primary; ?> !important;
      border: 1px solid <?php echo $this_web_primary; ?> !important;
    }
	/*-----------------*/
	.btn-custom.btn-default {
  	   color: <?php echo $this_web_primary; ?> !important;
    }
	/*-----------------*/
	.checkbox-custom input[type="checkbox"]:checked + label::before {
  	    background-color: <?php echo $this_web_primary; ?>;
    	border-color: <?php echo $this_web_primary; ?>;
  	}
	/*-----------------*/
	.radio-custom input[type="radio"] + label::after {
 	   background-color: <?php echo $this_web_primary; ?>;
  	}
	/*-----------------*/
	.radio-custom input[type="radio"]:checked + label::before {
      border-color: <?php echo $this_web_primary; ?>;
 	}
	/*-----------------*/
	.radio-custom input[type="radio"]:checked + label::after {
  		  background-color: <?php echo $this_web_primary; ?>;
    }
	/*-----------------*/
	.panel-custom > .panel-heading {
  	   background-color: <?php echo $this_web_primary; ?>;
    }
	/*-----------------*/
	.panel-border.panel-custom .panel-heading {
       border-color: <?php echo $this_web_primary; ?> !important;
  	   color: <?php echo $this_web_primary; ?> !important;
    }
	/*-----------------*/
	.progress-bar-custom {
 	   background-color: <?php echo $this_web_primary; ?>;
    }
	/*-----------------*/
	table.focus-on tbody tr.focused th {
      background-color: <?php echo $this_web_primary; ?>;

    }
	/*-----------------*/
	table.focus-on tbody tr.focused td {
      background-color: <?php echo $this_web_primary; ?>;

  }
	/*-----------------*/
	.table-rep-plugin .checkbox-row input[type="checkbox"]:checked + label::before {
   background-color: <?php echo $this_web_primary; ?>;
      border-color: <?php echo $this_web_primary; ?>;
 }
	/*-----------------*/
	.tablesaw-enhanced .tablesaw-bar .btn:active {
 color: <?php echo $this_web_primary; ?> !important;

}
	/*-----------------*/
	table.dataTable td.focus {
   outline: 3px solid <?php echo $this_web_primary; ?> !important;

  }
	/*-----------------*/
	button.ColVis_Button,
.ColVis_Button:hover {
  background-color: <?php echo $this_web_primary; ?> !important;
  border: 1px solid <?php echo $this_web_primary; ?> !important;
}
	/*-----------------*/
	.jsgrid-pager-page.jsgrid-pager-current-page {
  background-color: <?php echo $this_web_primary; ?>;

}
	/*-----------------*/
	button.ColVis_Button,
.ColVis_Button:hover {
 
  background-color: <?php echo $this_web_primary; ?> !important;
  border: 1px solid <?php echo $this_web_primary; ?> !important;
}
	/*-----------------*/
	.jsgrid-pager-page.jsgrid-pager-current-page {
  background-color: <?php echo $this_web_primary; ?>;

}
	/*-----------------*/
	.jsgrid-pager-nav-button a:hover {
  color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.widget-bg-color-icon .bg-icon-green {
  border: 1px solid <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.widget-bg-color-icon .bg-icon-custom {
  border: 1px solid <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.table-actions-bar .table-action-btn:hover {
  color: <?php echo $this_web_primary; ?>;
  border-color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.datepicker table tr td span.active:hover,
.datepicker table tr td span.active:hover:hover,
.datepicker table tr td span.active.disabled:hover,
.datepicker table tr td span.active.disabled:hover:hover,
.datepicker table tr td span.active:active,
.datepicker table tr td span.active:hover:active,
.datepicker table tr td span.active.disabled:active,
.datepicker table tr td span.active.disabled:hover:active,
.datepicker table tr td span.active.active,
.datepicker table tr td span.active:hover.active,
.datepicker table tr td span.active.disabled.active,
.datepicker table tr td span.active.disabled:hover.active,
.datepicker table tr td span.active.disabled,
.datepicker table tr td span.active:hover.disabled,
.datepicker table tr td span.active.disabled.disabled,
.datepicker table tr td span.active.disabled:hover.disabled,
.datepicker table tr td span.active[disabled],
.datepicker table tr td span.active:hover[disabled],
.datepicker table tr td span.active.disabled[disabled],
.datepicker table tr td span.active.disabled:hover[disabled] {
  background-color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.datepicker table tr td.active,
.datepicker table tr td.active:hover,
.datepicker table tr td.active.disabled,
.datepicker table tr td.active.disabled:hover {
  background-color: <?php echo $this_web_primary; ?> !important;
 
}
	/*-----------------*/
	.wizard > .steps .current a {
  background: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.wizard > .steps .current a:hover {
  background: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.wizard > .steps .current a:active {
  background: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.text-custom {
  color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.text-green {
  color: <?php echo $this_web_primary; ?> !important;
}
	/*-----------------*/
	.main_title span {
	color: <?php echo $this_web_primary; ?> !important;
}
	/*-----------------*/
	 .get-started .button_2 {
   
    background-color: <?php echo $this_web_primary; ?> !important;

}
	/*-----------------*/
	.green-a a{
	color: <?php echo $this_web_primary; ?> !important;
}
	/*-----------------*/
	.navigation-menu li.active a i {
  color: <?php echo $this_web_primary; ?> !important;
}
	/*-----------------*/
	.navigation-menu li.active > a {
  color: <?php echo $this_web_primary; ?> !important;
}
	/*-----------------*/
	#topnav .topbar-main .logo i {
  color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	#topnav .topbar-main .logo span{
  color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	#topnav .topbar-main .noti-custom {
  color: <?php echo $this_web_primary; ?>;
  border: 2px solid <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	#topnav .navbar-toggle:hover span {
  background-color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	#topnav .navbar-toggle:focus span {
  background-color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	#topnav .navigation-menu > li > a:hover {
  color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	#topnav .navigation-menu > li > a:hover i {
  color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	#topnav .navigation-menu > li > a:focus {
  color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	#topnav .navigation-menu > li > a:focus i {
  color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	#topnav .navigation-menu > li > a:active {
  color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	#topnav .navigation-menu > li > a:active i {
  color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	 #topnav .navigation-menu > li:hover a {
    color: <?php echo $this_web_primary; ?>;
  }
	/*-----------------*/
	 #topnav .navigation-menu > li:hover a i {
    color: <?php echo $this_web_primary; ?>;
  }
	/*-----------------*/
	  #topnav .navigation-menu > li .submenu li a:hover {
    color: <?php echo $this_web_primary; ?>;
  }
	/*-----------------*/
	  #topnav .navigation-menu > li.has-submenu.open > a {
    color: <?php echo $this_web_primary; ?>;
  }
	/*-----------------*/
	.footer ul li a:hover {
  color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	ul#primary_nav li a:hover, .main-menu > ul > li > a:hover{opacity:0.9; color: <?php echo $this_web_primary; ?> !important;}
	/*-----------------*/
	.main-menu ul ul li:hover > a {color:<?php echo $this_web_primary; ?>; padding-left:15px;}
	/*-----------------*/
	a.show-submenu-mega:focus{color:<?php echo $this_web_primary; ?> !important;background-color:#f9f9f9;}
	/*-----------------*/
	a {color:<?php echo $this_web_primary; ?>;text-decoration: none;-webkit-transition: all 0.2s ease;transition: all 0.2s ease; outline:none;}
	/*-----------------*/
	a.button, .button{

	background-color:<?php echo $this_web_primary; ?>;
	
}
	/*-----------------*/
	a.button_plan:hover{
	color:#fff;
	background-color:<?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	a.button_2{
	
	background-color:<?php echo $this_web_primary; ?>;
	
}
	/*-----------------*/
	a.button_login, .button_login{

	border:2px solid <?php echo $this_web_primary; ?>;

	color:<?php echo $this_web_primary; ?>;
	
}
	/*-----------------*/
	.green-link{
	color: <?php echo $this_web_primary; ?> !important;
	font-size: 16px;
}
	/*-----------------*/
	footer a:hover{
	color:<?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.tabs nav li.tab-current a{
	color:#2b333f;
	border-bottom: 2px solid <?php echo $this_web_primary; ?> !important;
    padding-bottom: 5px;
}
	/*-----------------*/
	#filter_tools ul li a#grid_icon:before, #filter_tools ul li a#list_icon:before, #filter_tools ul li a#map_icon:before{

	color:<?php echo $this_web_primary; ?>;
	
}
	/*-----------------*/
	ul#tools_2 li a i, ul#tools_2 li form i{
	
	color:<?php echo $this_web_primary; ?>;

}
	/*-----------------*/
	.box_login strong{
	background:<?php echo $this_web_primary; ?> url(../img/waves.png) no-repeat bottom left;}
	/*-----------------*/
	.pagination > li > span {
	color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	ul#primary_nav li#buy a{
	background: <?php echo $this_web_primary; ?> !important;
	text-transform: inherit !important;
	color: #fff !important;
	font-size: 15px !important;
}
	/*-----------------*/

	.green-light{
	background: <?php echo $this_web_primary; ?>;
	color: #fff !important;
	padding-top: 50px;
	padding-bottom: 35px;
}
	/*-----------------*/
	.about-ul i{
    color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.open > .dropdown-toggle.btn-default {
  background-color: <?php echo $this_web_primary; ?> !important;
  border: 1px solid <?php echo $this_web_primary; ?> !important;
}
	/*-----------------*/
	.btn-custom.btn-default {
  color: <?php echo $this_web_primary; ?> !important;
}
	/*-----------------*/
	.checkbox-custom input[type="checkbox"]:checked + label::before {
  background-color: <?php echo $this_web_primary; ?>;
  border-color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.radio-custom input[type="radio"] + label::after {
  background-color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.radio-custom input[type="radio"]:checked + label::before {
  border-color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.radio-custom input[type="radio"]:checked + label::after {
  background-color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.panel-custom > .panel-heading {
  background-color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.panel-border.panel-custom .panel-heading {
  border-color: <?php echo $this_web_primary; ?> !important;
  color: <?php echo $this_web_primary; ?> !important;
}
	/*-----------------*/
	.progress-bar-custom {
  background-color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	table.focus-on tbody tr.focused th {
  background-color: <?php echo $this_web_primary; ?>;
  color: #ffffff;
}
	/*-----------------*/
	table.focus-on tbody tr.focused td {
  background-color: <?php echo $this_web_primary; ?>;
  color: #ffffff;
}
	/*-----------------*/
	.table-rep-plugin .checkbox-row input[type="checkbox"]:checked + label::before {
  background-color: <?php echo $this_web_primary; ?>;
  border-color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.tablesaw-enhanced .tablesaw-bar .btn:active {
  color: <?php echo $this_web_primary; ?> !important;
  background-color: #ebeff2;
  outline: none !important;
  box-shadow: none !important;
  background-image: none;
}
	/*-----------------*/
	table.dataTable th.focus,
table.dataTable td.focus {
  outline: 3px solid <?php echo $this_web_primary; ?> !important;
  outline-offset: -1px;
}
	/*-----------------*/
	button.ColVis_Button,
.ColVis_Button:hover {

  background-color: <?php echo $this_web_primary; ?> !important;
  border: 1px solid <?php echo $this_web_primary; ?> !important;
}
	/*-----------------*/
	.jsgrid-pager-page.jsgrid-pager-current-page {
  background-color: <?php echo $this_web_primary; ?>;
  color: #ffffff;
}
	/*-----------------*/
	.jsgrid-pager-nav-button a:hover {
  color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.widget-bg-color-icon .bg-icon-green {
  background-color: rgba(27, 185, 51, 0.04);
  border: 1px solid <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.widget-bg-color-icon .bg-icon-custom {
  background-color: rgba(95, 190, 170, 0.2);
  border: 1px solid <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.table-actions-bar .table-action-btn:hover {
  color: <?php echo $this_web_primary; ?>;
  border-color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.datepicker table tr td span.active:hover,
.datepicker table tr td span.active:hover:hover,
.datepicker table tr td span.active.disabled:hover,
.datepicker table tr td span.active.disabled:hover:hover,
.datepicker table tr td span.active:active,
.datepicker table tr td span.active:hover:active,
.datepicker table tr td span.active.disabled:active,
.datepicker table tr td span.active.disabled:hover:active,
.datepicker table tr td span.active.active,
.datepicker table tr td span.active:hover.active,
.datepicker table tr td span.active.disabled.active,
.datepicker table tr td span.active.disabled:hover.active,
.datepicker table tr td span.active.disabled,
.datepicker table tr td span.active:hover.disabled,
.datepicker table tr td span.active.disabled.disabled,
.datepicker table tr td span.active.disabled:hover.disabled,
.datepicker table tr td span.active[disabled],
.datepicker table tr td span.active:hover[disabled],
.datepicker table tr td span.active.disabled[disabled],
.datepicker table tr td span.active.disabled:hover[disabled] {
  background-color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.datepicker table tr td.active,
.datepicker table tr td.active:hover,
.datepicker table tr td.active.disabled,
.datepicker table tr td.active.disabled:hover {
  background-color: <?php echo $this_web_primary; ?> !important;

}
	/*-----------------*/
	.wizard > .steps .current a {
  background: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.wizard > .steps .current a:hover {
  background: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.wizard > .steps .current a:active {
  background: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.bg-custom {
  background-color: <?php echo $this_web_primary; ?> !important;
}
	/*-----------------*/
	.text-custom {
  color: <?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.text-green {
  color: <?php echo $this_web_primary; ?> !important;
}
	/*-----------------*/
	.hovered-card-box{
  /*border:5px solid <?php echo $this_web_primary; ?>;*/
      background: <?php echo $this_web_primary; ?>b3;
    color: #fff;
}
	/*-----------------*/
	.main_title span {
	color: <?php echo $this_web_primary; ?> !important;
	font-weight: 700;
}
	/*-----------------*/
	 .get-started .button_2 {

    background-color: <?php echo $this_web_primary; ?> !important;
 
}
	/*-----------------*/
	.green-a a{
	color: <?php echo $this_web_primary; ?> !important;
}
	/*-----------------*/
	a.button_plan:hover{
	color:#fff;
	background-color:<?php echo $this_web_primary; ?>;
}
	/*-----------------*/
	.btn-default, .btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .btn-default.focus, .btn-default:active, .btn-default:focus, .btn-default:hover, .open > .dropdown-toggle.btn-default{
		    background-color: <?php echo $this_web_primary; ?> !important;
    border: 1px solid <?php echo $this_web_primary; ?> !important;
	}
	a.text-primary:focus, a.text-primary:hover{
		    color: <?php echo $this_web_primary; ?> !important;
	}
	.text-primary {
    color: <?php echo $this_web_primary; ?> !important;
}
	

</style>




<script src="<?php echo base_url();?>resources/frontend/js/modernizr.min.js"></script>
<?php echo html_entity_decode(GOOGLEANALYTICS);?>
<?php if(am_i('securix')){

	if($this->uri->segment(1)=="thank-you-for-your-purchase")
	{ ?>

		<!-- Google Tag Manager -->

<!-- End Google Tag Manager -->


			

		<?php

	}
	else
	{


 ?>
        <!-- Google Tag Manager -->

<!-- End Google Tag Manager -->

    <?php } } ?>