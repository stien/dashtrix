<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <link rel="shortcut icon" href="assets/img/favicon.svg">
    <title>Thank You</title>
 	<?php require("common/css_include.php"); ?>
</head>
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>

<div class="wrapper-page">
    <div class="panel-heading text-center m-b-15">
        <img src="<?php echo base_url();?>resources/frontend/images/logo.png" alt="ICO"/>
    </div>
    <div class="card-box">
        <div class="panel-body contentpage">
            <h2><?php echo $page[0]->pHeading;?></h2>
            <?php echo $page[0]->pContent;?><br>
            <img src="<?php echo base_url(); ?>resources/frontend/images/ttyp.png" class="thankyou_img" alt="">
        </div>
    </div>

</div>

<script>
    var resizefunc = [];
</script>
<?php require("common/js_include.php"); ?>

<?php unset($_SESSION['thankyou']);?>
</body>
</html>


