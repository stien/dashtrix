<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JobsRope.com -  Admin Panel</title>
<style type="text/css">
@import url("<?php echo base_url(); ?>resources/backend/css/style.css");
</style>
</head>

<body>
<div id="wrap">
	Welcome To JobsRope Admin Panel
</div>


<?php echo form_open('backend/login'); ?>

<div class="login">
	<?php 
		if(isset($_SESSION['msglogin'])): 
			echo '<div class="msgbox">'.$_SESSION['msglogin'].'</div>';
		endif; 
	?>
	<label>Username</label>
    <label>
    	<input type="text" name="username" id="username" class="loginput" />
    </label>
    <label>Password</label>
    <label>
    	<input type="password" name="password" id="password" class="loginput" />
    </label>
        <label>
    	<input type="submit" value="Login" class="btn btn-lg btn-green right" style="    margin: 0;"/>
    </label>
    
    <div id="error">
    <?php 
		if(isset($_SESSION['notification']))
		{
			echo '<p>'.$_SESSION['notification'].'</p>';
		}
	?>
	<?php echo validation_errors(); ?>
</div>

</div>
</form>
<?php unset($_SESSION['notification']); ?>
</body>
</html>