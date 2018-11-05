<?php require_once("common/header.php");?>
<div id="loginbx">
  <div class="container">
    <div class="col-xs-12 bxlogin nopad">
    <?php foreach($pages as $page):?>
      <div class="login-inner left" style="margin-bottom:5px;">
        <h2><?php echo $page->fQues;?></h2>
        <div class="pagecontent"> 
        	<?php echo $page->fAns;?>
        </div>
       
      </div>
      <?php endforeach;?>
    </div>
  </div>
</div>
<?php require_once("common/footer.php");?>
