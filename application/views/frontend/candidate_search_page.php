<?php require_once("common/header.php");?>

<div class="jobsteps clear left wd100" style="background:none;">
	<div class="container">
		<div class="col-xs-12">
        	<h1>With instant access to our CV database, your next placement is only a few clicks away.</h1>
            <div class="col-xs-4">
            	<div class="stepbg">
                    <div class="add-job-rec addbox"></div>
                    <p>1 Day</p>
                    <p class="large">$190</p>
                    <div class="buttonpro">
                    	<button type="submit" id="recruiter_1" onClick="processcart('1')" class="btn blue cartfull">Add to Cart</button>
                    </div>
                </div>
            </div>
            <div class="col-xs-4 ">
            	<div class="stepbg">
            	<div class="add-cal-rec addbox"></div>
                <p>7 Days</p>
                <p class="large">$250</p>
                <div class="buttonpro">
                    	<button type="submit" id="recruiter_7" onClick="processcart('7')" class="btn blue cartfull">Add to Cart</button>
                    </div>
                </div>
            </div>
            <div class="col-xs-4">
            	<div class="stepbg">
            	<div class="add-ppl-rec addbox"></div>
                <p>1 Month</p>
                <p class="large">$750</p>
                <div class="buttonpro">
                    	<button type="submit" id="recruiter_28" onClick="processcart('28')" class="btn blue cartfull">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once("common/footer.php");?>
<script language="javascript">
function processcart(id){
	$("#recruiter_"+id).html('<i class="fa fa-cog fa-spin"></i> &nbsp;&nbsp;processing...');
	var autoURL = "<?php echo base_url(); ?>jobsite/cart_process_candidate?rnd=" + Math.random() +"&val="+id;
	$.ajax({
				url : autoURL,
				async: true,
				cache: false,
				method : "POST",
				success : function(response)
				{
					$("[id='cart']").show();
					$("#recruiter_"+id).html('Add to Cart');
					$("#cartval").html($("#jadvert").val());
					$(".navcart").show();
					cartboxautoupdate();
					
				}
			});
}
</script>
<style>
.stepbg {
  border: 1px solid #f0f0f0;
  background: #fff;
  border-radius: 4px;
  padding: 15px;
  min-height: 250px;
  margin-top: 30px;
}
.large {
	  font-size: 33px;
  margin-top: 10px;
 }
</style>