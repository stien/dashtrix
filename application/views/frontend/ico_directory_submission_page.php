<?php require_once("common/header.php");?>
<div class="row">
	 <div class="col-sm-12 m-b-30">
		<h4 class="page-title">ICO DIRECTORY SUBMISSIONS</h4>
	</div>
</div>
<div class="row">
<div class="col-md-12">
	<div class="card-box easy">
	
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
            
	<form action="<?php echo base_url();?>ico/add_items_price" method="post">
		<div class="col-md-12 itemup">
		<div class="col-md-1">
			
		</div>
		<div class="col-md-2">
			<strong><i class="fa fa-dollar"></i>595.00</strong>
		</div>
		<div class="col-md-5">
			<strong>ICO SUBMISSION + ALL FREE SUBMISSIONS</strong>
		</div>
		<div class="col-md-4">
			
		</div>
		</div>
	<?php 
		$arr = array();
		$config = $this->front_model->get_query_orderby('*','dev_web_ico_directory',$arr,'dID','ASC');
		$directoryItems 	= $config->result_object();
		foreach($directoryItems as $items){
	?>
	<div class="col-md-12 itemsdown">
		<div class="col-md-1">
			<input type="checkbox" name="checkbox[]" id="checkbox_p" <?php if($items->dChecked == "1"){echo "checked disabled";}?> value="<?php echo $items->dID;?>" onClick="updatePrice(<?php echo $items->dID;?>,'<?php echo $items->dPrice;?>')">
		</div>
		<div class="col-md-2">
			<?php if($items->dChecked == "1"){?>
			<strong style="font-size: 10px;">INCLUDED</strong>
			<?php } else {?>
			<strong><i class="fa fa-dollar"></i><?php echo $items->dPrice;?></strong>
			<?php } ?>
			
		</div>
		<div class="col-md-5">
			<strong><?php echo $items->dTitle;?></strong>
		</div>
		<div class="col-md-4">
			<a href="<?php echo $items->dURL;?>" target="_blank">
				<?php echo $items->dURL;?>
			</a>
		</div>
		</div>
	<?php } ?>
	
		<div class="btmend">
			<div class="left col-md-6">
			<strong>TOTAL PRICE: </strong> <div class="prieitem">$</div><div id="priceitem">595</div>
			</div>
			<div class="right  col-md-6 rightbtn">
			<button type="submit" name="subbtn" class="btn btn-primary ">
				PURCHASE
			</button>
		</div>
		</div>
		<input type="hidden" name="priceTotalshow" id="priceTotalshow" value="595">
		
	</form>
	</div>
</div>
</div>

<?php require_once("common/footer.php");?>
<script language="javascript">
function updatePrice(val,id){
	
	var startpriece = $("#priceTotalshow").val();
	var priceadd = id;
	var valprice = parseInt(startpriece)+parseInt(priceadd);
	var priceinput = $("#priceTotalshow").val(valprice);

	$("#priceitem").html(valprice);
}
</script>