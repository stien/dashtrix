<?php require_once("common/header.php");?>
<style>.wrapper{
padding-top:112px !important;
}
</style>
<?php  $page_data = $this->front_model->get_query_simple('*','dev_web_pages',array('pLink'=>'privacy-policy','pStatus'=>1))->result_object()[0];
if($page_data->type==1){
  redirect($page_data->pElink);
  exit;
}

  ?>
</div>


<div class="row" style="background-color:#252525; padding: 57px 0px;">
    <div class="col-md-2"></div>
    <div class="col-md-8 text-center">
        <h1 style="color:#fff; text-transform:capitalize;">
          <?php echo $page_data->pHeading; ?>
        </h1>
    </div>
    <div class="col-md-2"></div>
</div>
<div class="container">
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <?php echo $page_data->pContent; ?>
  </div>
</div>



<?php require_once("common/footer.php");?>
<?php require_once("common/compaign.php"); ?>
<style>
.boxdisplay{
  min-height: 182px;
}
</style>
<script language="javascript">
