<?php require_once("common/header.php");?>

	
   
    	<div class="row">
         <div class="col-sm-12 m-b-30">
        	<h4 class="page-title">Buy Tokens</h4>
    	</div>
    	</div>
    	<div class="row">

    		<div class="col-md-3"></div>
    		<div class="col-md-6">

    			<div class="box-buy-tokens-old">
   			      
   					<h2 class="text-center"><i class="left fa <?php echo $option->icon; ?>"></i> Enter Token Amount</h2>
                    <h2 class="text-center">
                        <button type="button" onclick="open_converter()" class="btn btn-info btn-sm">Price/Token Converter</button>
                    </h2>

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
                    <div class="errornotification">
                        <?php echo $_SESSION['error'];?>
                    </div>
                </div>
            </div>
            <?php } ?>

   					<form method="post" action="">
                            <div class="row">
                                    <?php

                                    if($active_token){
                                   
                                     if($active_token->min_invest!=0 || $active_token->max_invest!=0){ ?>
                                    <div class="col-md-12">
                                        <div class="info" style="background: orange; padding: 5px; text-align: center; margin:10px 0px;">
                                            <i class="fa fa-warning"></i> <?php

                                            if($active_token->min_invest!=0)
                                            {
                                                echo "Minimum amount investment is $".$active_token->min_invest.' (USD)';
                                                
                                            }
                                            if($active_token->min_invest!=0 && $active_token->max_invest!=0)
                                                echo " and ";
                                            if($active_token->max_invest!=0)
                                            {
                                                echo "Maximum amount investment is $".$active_token->max_invest.' (USD)';
                                            }


                                             ?>
                                        </div>
                                    </div>
                                    <?php } ?>

                                 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Price per Token (USD): </label>
                                            <input name="priceee" type="text" disabled class="form-control" value="<?php echo $price_should_be; ?>" required>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Amount of Tokens to Purchase: </label>
                                            <input name="amount" type="number"  step='0.01' class="form-control" value="" required oninput="update_values(this)" 


                                            >
                                        </div>
                                    </div>


                                    <div class="col-md-12" style="display: none;">
                                        <div class="form-group">
                                            <label>Total Tokens with Bonus: </label>
                                            <input name="bonus" type="text" id="total_tokens" disabled class="form-control" value="" required >
                                        </div>
                                    </div>

                                    <?php /* ?>
                                    <div class="col-md-12 " >
                                        <div class="form-group">
                                            <label>Total Price (USD): </label>
                                            <input name="total_price" type="text" id="total_price" disabled class="form-control" value="" required >
                                        </div>
                                    </div>
                                    <?php */ ?>

                                <?php }else{ ?>
                                    <div class="" style="background: orange; text-align: center; padding: 10px 13px;">
              No token pricing is active. Please contact with administrator to proceed further.
             </div>
 <?php } ?>

                                  

                                   

                                   <div class="col-md-12">
						            

						            <div class="col-md-3 right  m-t-40">
						                 <div class="form-group">
											<input type="hidden" id="option_id" name="option" value="">
												<button id="submit_btn" <?php if(!$active_token) echo "disabled"; ?> class="btn btn-default btn-block btn-sm "  type="submit">
						                              Next
						                        </button>
						                 </div>
						            </div>

                                    <div class="col-md-3 right m-t-40">
                                         <div class="form-group">
                                            <a href="<?php echo base_url().'dashboard'; ?>">
                                                <button class="btn btn-danger btn-block btn-sm "  type="button">
                                                      Cancel
                                                </button>
                                            </a>
                                         </div>
                                    </div>
						            </div>
                                </div>
                        </form>
    			</div>

    		</div>

    	<div class="col-md-3"></div>


    	</div>
  <div class="modal-cs display_none ask_reason" >
    <div class="modal-box">
        <div class="modal-heading">
            <h4 class="left">Converter</h4>

            <button onclick="closeModel();" class="btn bt-danger right" >
                <i  class="fa fa-times"></i>
            </button>
        </div>

        <div class="modal-body">
            <form method="post" action="">
                <div class="row">

                  

                    <div class="col-md-12">
                            <div class="form-group">
                                <label>Type: </label>
                                <select class="form-control" name="type" id="convert_type">
                                    <option value="1">Tokens to USD</option>
                                    <option value="2">USD to Tokens</option>
                                </select>
                              
                            </div>
                    </div>
                     <div class="col-md-12">
                            <div class="form-group">
                                <label>Amount : </label>
                                <input type="number" name="amount" step="0.01" id="convert_amount" required class="form-control">
                                
                            </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group text-center">
                            <h3 class="text-center" id="conversion_result" style="display: none;"></h3>
                        </div>
                    </div>

                    

                    <div class="col-md-6 col-md-offset-3 m-t-40">
                        <div class="form-group">
                            <button class="btn btn-default btn-block btn-lg" type="button" onclick="convertNow();" name="submit">
                                Convert
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
    
<?php require_once("common/footer.php");?>
<script language="javascript">
<?php if(ACTYPE == "1"){?>
function btnstatusupdate(val,id){
	var x = confirm("Are you sure you want to perform this action?");
	if (x){
		window.location='<?php echo base_url(); ?>admin/do/action/tranasctions/'+val+'/'+id;
		return true;
	}
	else {
		return false;
	}
}
<?php } ?>


function href(loc)
{
	window.location = "<?php echo base_url().'buy-tokens/' ?>"+loc;
}
function update_values(val)
{

 //    if(!$(val).val())
 //    {
 //        $("#total_tokens").val(null);

 //        // $("#total_price").val(null);
 //        return;

 //    }

	// var val = $(val).val();
 //    var _val = val;

 //    $("body").append('<div class="loading">Loading&#8230;</div>');
 //        $.post('<?php //echo base_url().'ico/get_version_2_bonus'; ?>',{tokens:_val},function(data){
 //            $("#total_tokens").val(data);
 //            $(".loading").remove();
 //        });


        return;

	// if(val>0)
    var php_active_token_s = <?php echo get_bonus($active_token->tkID,am_i('scia')); ?>;


    var _bonus = 0;
    for(let i = 0; i<php_active_token_s.length; i++)
    {
        if(parseFloat(val)>=php_active_token_s[i][0] && parseFloat(val)<=php_active_token_s[i][1])
        {
            var _bonus = php_active_token_s[i][2];
            break;
        }
    }

    if(_bonus==0)
        _bonus = parseFloat(<?php echo get_bonus($active_token->tkID,false); ?>);
    console.log(_bonus);
    php_active_token = _bonus;

	var bonus = (php_active_token/100);

	var total = val*bonus;

 


	 

	var total = parseFloat(total)+parseFloat(val);
 

	var total = parseFloat(total).toFixed(2);


    $("#total_tokens").val(total);


    var php_2_var = <?php echo $price_should_be?$price_should_be:0; ?>;
	var total_price = (php_2_var)*val;
	var total_price = parseFloat(total_price).toFixed(2);


	

    var volatility = <?php echo $option->volatility?$option->volatility:0; ?>;
    var volatility = parseFloat(volatility).toFixed(2);
    var volatility = parseFloat(volatility)/parseFloat(100);


    var volatility_ = total_price*volatility;


    var total_price = parseFloat(total_price).toFixed(2);


    var total_price = parseFloat(volatility_) + parseFloat(total_price);

	// $("#total_price").val(total_price);


}


function closeModel()
{
     $(".modal-cs").hide();
}

function open_converter(id,title,link)
            {

                

                  $(".ask_reason").show();
                  return;
              
            }
    function convertNow()
    {
         $("body").append('<div class="loading">Loading&#8230;</div>');
        var type = $("#convert_type").val();
        var amount = $("#convert_amount").val();
        $.post("<?php echo base_url()."ico/converter_step_2"; ?>",{type:type,amount:amount},function(data){
            $("#conversion_result").html(data);
            $("#conversion_result").show();

             $(".loading").remove();
        });
    }
</script>
