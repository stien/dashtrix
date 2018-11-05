<!doctype html>
<html lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Panel - :: - JobsRope.com</title>
<link href="<?php echo base_url(); ?>resources/backend/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
// ADD HTTP WITH URL
function addhttp($url) {
	if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
		$url = "http://" . $url;
	}
	else
	{
		$url = $url;
	}
	return $url;
}
?>
<div class="wrapper auto">
<!-- Top Bar -->
<div class="topbbar">
  <div class="logoadmin"> JobsRope.com </div>
  <div class="rightadmin">
    <ul>
      <li><a href="<?php echo base_url(); ?>backend/logout">Logout</a></li>
      <li><a href="<?php echo base_url(); ?>backend/configuration" <?php if($this->uri->segment(2) == 'configuration'){ echo 'class="rightadminhover"';}?>>Configuration</a></li>
      <li><a href="<?php echo base_url(); ?>backend/dashboard" <?php if($this->uri->segment(2) == 'dashboard'){ echo 'class="rightadminhover"';}?>>Home</a></li>
    </ul>
  </div>
</div>
<!-- Left nav section-->
<div class="leftnav left">
  <ul>
    <li><a href="<?php echo base_url(); ?>" target="_blank">Back To Website</a></li>
    <li><a href="<?php echo base_url(); ?>backend/dashboard" <?php if($this->uri->segment(2) == 'dashboard'){ echo 'class="activeclass"';}?>>Dashboard</a></li>
    <li><a href="<?php echo base_url(); ?>backend/configuration" <?php if($this->uri->segment(2) == 'configuration'){ echo 'class="activeclass"';}?>>Configuration</a></li>
    <li><a href="<?php echo base_url(); ?>backend/categories" <?php if($this->uri->segment(2) == 'categories'){ echo 'class="activeclass"';}?>>Catagories</a></li>
    <!--MANAGE USERS-->
    <li><a href="javascript:;" <?php if(($this->uri->segment(2) == 'add' && $this->uri->segment(3) == 'user') || ($this->uri->segment(2) == 'manage' && $this->uri->segment(3) == 'users'  ||  $this->uri->segment(3) == 'details' || $this->uri->segment(3) == 'employer' || $this->uri->segment(3) == 'jobseeker')){ echo 'class="activeclass"';}?>>User Management</a>
      <ul class="dropdown" <?php if(($this->uri->segment(2) == 'add' && $this->uri->segment(3) == 'user') || ($this->uri->segment(2) == 'manage' && $this->uri->segment(3) == 'users' ||  $this->uri->segment(3) == 'details'  ||  $this->uri->segment(3) == 'employer' || $this->uri->segment(3) == 'jobseeker')) { echo 'style="display:block"';}?>>
        <li><i class="fa fa-angle-double-right left color iconpad"></i><a href="<?php echo base_url(); ?>backend/add/user" <?php if($this->uri->segment(2) == 'add' && $this->uri->segment(3) == 'user'){echo 'class="activeclasschild"';}?>>Add User</a></li>
        <li><i class="fa fa-angle-double-right left color iconpad"></i><a href="<?php echo base_url(); ?>backend/manage/users" <?php if($this->uri->segment(2) == 'manage' && $this->uri->segment(3) == 'users' ||  $this->uri->segment(3) == 'details'){echo 'class="activeclasschild"';}?>>Manage All Users</a></li>
        <li><i class="fa fa-angle-double-right left color iconpad"></i><a href="<?php echo base_url(); ?>backend/manage/jobseeker" <?php if($this->uri->segment(2) == 'manage' && $this->uri->segment(3) == 'jobseeker'){echo 'class="activeclasschild"';}?>>Manage jobseekers</a></li>
        <li><i class="fa fa-angle-double-right left color iconpad"></i><a href="<?php echo base_url(); ?>backend/manage/employer" <?php if($this->uri->segment(2) == 'manage' && $this->uri->segment(3) == 'employer'){echo 'class="activeclasschild"';}?>>Manage Employers/Companies</a></li>
      </ul>
    </li>
    
    <li><a href="javascript:;" <?php if($this->uri->segment(2) == 'new-job' || $this->uri->segment(3) == 'jobs'  || $this->uri->segment(3) == 'applicants' || $this->uri->segment(4) == 'archived'){ echo 'class="activeclass"';}?>>Jobs Management</a>
      <ul class="dropdown" <?php if($this->uri->segment(2) == 'new-job' || $this->uri->segment(3) == 'jobs' || $this->uri->segment(3) == 'applicants' || $this->uri->segment(4) == 'archived') { echo 'style="display:block"';}?>>
        <li><i class="fa fa-angle-double-right left color iconpad"></i><a href="<?php echo base_url(); ?>backend/new-job" <?php if($this->uri->segment(2) == 'new-job'){echo 'class="activeclasschild"';}?>>Add New Job</a></li>
        <li><i class="fa fa-angle-double-right left color iconpad"></i><a href="<?php echo base_url(); ?>backend/manage/jobs" <?php if($this->uri->segment(2) == 'manage' && $this->uri->segment(3) == 'jobs'  && $this->uri->segment(4) == ''  || $this->uri->segment(3) == 'applicants' ||  $this->uri->segment(3) == 'details'){echo 'class="activeclasschild"';}?>>Manage Jobs</a></li>
        <li><i class="fa fa-angle-double-right left color iconpad"></i><a href="<?php echo base_url(); ?>backend/manage/jobs/archived" <?php if($this->uri->segment(3) == 'jobs' && $this->uri->segment(4) == 'archived'){echo 'class="activeclasschild"';}?>>Archived Jobs</a></li>
      </ul>
    </li>
    
    <?php /*?><li><a href="javascript:;" <?php if($this->uri->segment(2) == 'new-department' || $this->uri->segment(3) == 'department'){ echo 'class="activeclass"';}?>>Company Department Management</a>
      <ul class="dropdown" <?php if($this->uri->segment(2) == 'new-department' || $this->uri->segment(3) == 'department') { echo 'style="display:block"';}?>>
        <li><i class="fa fa-angle-double-right left color iconpad"></i><a href="<?php echo base_url(); ?>backend/new-department" <?php if($this->uri->segment(2) == 'new-department'){echo 'class="activeclasschild"';}?>>Add New Department</a></li>
        <li><i class="fa fa-angle-double-right left color iconpad"></i><a href="<?php echo base_url(); ?>backend/manage/department" <?php if($this->uri->segment(2) == 'manage' && $this->uri->segment(3) == 'department'){echo 'class="activeclasschild"';}?>>Manage Departments</a></li>
      </ul>
    </li><?php */?>
    
    <li><a href="javascript:;" <?php if($this->uri->segment(2) == 'new-benefits' || $this->uri->segment(3) == 'benefits'){ echo 'class="activeclass"';}?>>Company Benifits Management</a>
      <ul class="dropdown" <?php if($this->uri->segment(2) == 'new-benefits' || $this->uri->segment(3) == 'benefits') { echo 'style="display:block"';}?>>
        <li><i class="fa fa-angle-double-right left color iconpad"></i><a href="<?php echo base_url(); ?>backend/new-benefits" <?php if($this->uri->segment(2) == 'new-benefits'){echo 'class="activeclasschild"';}?>>Add New Benefit</a></li>
        <li><i class="fa fa-angle-double-right left color iconpad"></i><a href="<?php echo base_url(); ?>backend/manage/benefits" <?php if($this->uri->segment(2) == 'manage' && $this->uri->segment(3) == 'benefits'){echo 'class="activeclasschild"';}?>>Manage Benefits</a></li>
      </ul>
    </li>
     <li><a href="<?php echo base_url(); ?>backend/pages" <?php if($this->uri->segment(2) == 'pages'){ echo 'class="activeclass"';}?>>Manage Pages</a></li>
      <li><a href="<?php echo base_url(); ?>backend/faq" <?php if($this->uri->segment(2) == 'faq'){ echo 'class="activeclass"';}?>>Manage FAQ's</a></li>
       <li><a href="<?php echo base_url(); ?>backend/subscribers" <?php if($this->uri->segment(2) == 'subscribers'){ echo 'class="activeclass"';}?>>Alerts Management Users</a></li>
        <li><a href="<?php echo base_url(); ?>admin/manage_orders" <?php if($this->uri->segment(2) == 'manage_orders'){ echo 'class="activeclass"';}?>>Order Management</a></li>
        <li><a href="<?php echo base_url(); ?>admin/upload_bulk_csv" <?php if($this->uri->segment(2) == 'upload_bulk_csv'){ echo 'class="activeclass"';}?>>Upload Bulk CSV</a></li>
        <li><a href="javascript:;" <?php if($this->uri->segment(2) == 'manage_coupoun' || $this->uri->segment(2) == 'coupon_setting'){ echo 'class="activeclass"';}?>>Company Coupon Management</a>
      <ul class="dropdown" <?php if($this->uri->segment(2) == 'coupon_setting' || $this->uri->segment(2) == 'manage_coupoun') { echo 'style="display:block"';}?>>
        <li><i class="fa fa-angle-double-right left color iconpad"></i><a href="<?php echo base_url(); ?>admin/coupon_setting" <?php if($this->uri->segment(2) == 'coupon_setting'){echo 'class="activeclasschild"';}?>>Coupon Active/Inactive</a></li>
        <li><i class="fa fa-angle-double-right left color iconpad"></i><a href="<?php echo base_url(); ?>admin/manage_coupoun" <?php if($this->uri->segment(2) == 'manage_coupoun'){echo 'class="activeclasschild"';}?>>Manage Coupons</a></li>
      </ul>
    </li>
     <li><a href="<?php echo base_url(); ?>backend/banned" <?php if($this->uri->segment(2) == 'banned'){ echo 'class="activeclass"';}?>>Manage Blocked IP List</a></li>
      <li><a href="<?php echo base_url(); ?>admin/change_password" <?php if($this->uri->segment(2) == 'change_password'){ echo 'class="activeclass"';}?>>Change Password</a></li>
    <li><a href="<?php echo base_url(); ?>backend/logout">Logout</a></li>
  </ul>
</div>
<!-- Right Dashboard Wrapper section -->
<div class="rightwrapper right">
<?php 
	if(isset($_SESSION['notify']))
	{
		echo '<div class="message success">'.$_SESSION['notify'].'</div>';
	}
	if(isset($_GET['msg']) && $_GET['msg'] == "success")
	{
		echo '<div class="message success">Record has been added successfully!</div>';
	}
	?>
