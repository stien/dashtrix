<?php require_once("common/header.php");?>
<div class="clear left wd100 postadvertbg">
    <div class="col-xs-12 nopad">
    	<div class="container">
        
        <?php 
			$v = "`jobTitle` LIKE '%web manager job%' OR `jobSkills` LIKE '%web manager job%'";
			$var = $this->front_model->gettagreviewsdata($v);
			//print_r($var);
		?>
        	<div class="col-xs-4 nopad textadvert" style="min-height: 276px;">
            	<h2>Start advertising your job now</h2>
                <ul>
                	<li><i class="fa fa-check"></i> Live for 28 days</li>
                    <li><i class="fa fa-check"></i> Automatically refreshed to the top of the listings every 7 days</li>
                </ul>
            </div>
            <!---->
            <div class="col-xs-8 nopad textadvertrighr">
            	<div class="col-xs-7 nopad colorbg">
                	<div class="clear">
                        <span class="left jadtext">How many job adverts would you like?</span>
                        <input type="text" value="1" name="jadvert" id="jadvert" onBlur="setslidervalue()" class="jinput right">
                    </div>
                  <div class="topbotmar">
                    <div id="numberrange"></div>
                  </div>
                  <div class="textadinfo clear">
                   	<p class="botmar">You've got 12 months to post your adverts, stock up and save more:</p>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>1</td>
    <td>Advert</td>
    <td>$149</td>
    <td>each</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Adverts</td>
    <td>$140</td>
    <td>each</td>
    <td>Save $18</td>
  </tr>
  <tr>
    <td>3</td>
    <td>Adverts</td>
    <td>$130</td>
    <td>each</td>
    <td>Save $57</td>
  </tr>
  <tr>
    <td>4</td>
    <td>Adverts</td>
    <td>$120</td>
    <td>each</td>
    <td>Save $116</td>
  </tr>
  <tr>
    <td>5+</td>
    <td>Adverts</td>
    <td>$110</td>
    <td>each</td>
    <td>Save $195+</td>
  </tr>
</table>
                    </div>
                </div>
                <div class="col-xs-5 nopad padclas">
                	<p>Total Price</p>
                    <span id="priceUp" class="priceclass">$<?php echo sprintf('%0.2f', '149'); ?></span>
                    <span class="blocktext clear"><i id="weeknum">4</i> x 4 week job adverts</span>
                    <span class="saveclass"> (Saving $<span id="discountid"></span> per advert)</span>
                    <button type="submit" id="recruiter" onClick="processcart()" class="btn blue cartfull">Add to Cart</button>
                </div>
                </div>
            </div>
        </div>
</div>
<div class="jobsteps clear left wd100">
	<div class="container">
		<div class="col-xs-12">
        	<h1>In three simple steps</h1>
            <div class="col-xs-4 jobsteps">
            	<div class="add-job addbox"></div>
                <p>Buy the job adverts you need</p>
            </div>
            <div class="col-xs-4 jobsteps">
            	<div class="add-cal addbox"></div>
                <p>Write, review and post your advert <br>for 28 days</p>
            </div>
            <div class="col-xs-4 jobsteps">
            	<div class="add-ppl addbox"></div>
                <p>Receive applications directly to <br>your inbox</p>
            </div>
        </div>
    </div>
</div>
<?php require_once("common/footer.php");?>
<link href="<?php echo base_url(); ?>resources/frontend/css/nouislider.min.css" rel="stylesheet" type="text/css" media="all">
<script src="<?php echo base_url(); ?>resources/frontend/js/nouislider.min.js"></script>
<script language="javascript">
var stepSlider = document.getElementById('numberrange');
noUiSlider.create(stepSlider, {
	start: [ 1 ],
	step: 1,
	range: {
		'min': [  1 ],
		'max': [ 10 ]
	}
});
var rangeSliderValueElement = document.getElementById('jadvert');
stepSlider.noUiSlider.on('update', function( values, handle ) {
	rangeSliderValueElement.value = Math.round(values[handle]);
	if(values == 1){var prce = '149';} else if(values == 2){var prce = '140';} else if(values == 3){var prce = '130';} else if(values ==4){var prce = '120';} else if(values >= 5){var prce = '110';}
	$("#priceUp").html('$'+values[handle]*prce+'.00');
	$("#weeknum").html(Math.round(values[handle]));
	$("#discountid").html("149"-prce);
});

var handle = stepSlider.querySelector('.noUi-handle');

handle.setAttribute('tabindex', 0);

handle.addEventListener('click', function(){
	this.focus();
});

handle.addEventListener('keydown', function( e ) {

	var value = Number( stepSlider.noUiSlider.get() );

	switch ( e.which ) {
		case 37: stepSlider.noUiSlider.set( value - 1 );
			break;
		case 39: stepSlider.noUiSlider.set( value + 1 );
			break;
	}
});

function setslidervalue(){
	var d = $("#jadvert").val();
	stepSlider.noUiSlider.set( d )
}
</script>
<script language="javascript">
function processcart(){
	//var val = $("#jadvert").val();
	$("#recruiter").html('<i class="fa fa-cog fa-spin"></i> &nbsp;&nbsp;processing...');
	var autoURL = "<?php echo base_url(); ?>jobsite/cart_process?rnd=" + Math.random() +"&val="+$("#jadvert").val();
	$.ajax({
				url : autoURL,
				async: true,
				cache: false,
				method : "POST",
				success : function(response)
				{
					$("[id='cart']").show();
					$("#recruiter").html('Add to Cart');
					$("#cartval").html($("#jadvert").val());
					$(".navcart").show();
					cartboxautoupdate();
					
				}
			});
}
</script>