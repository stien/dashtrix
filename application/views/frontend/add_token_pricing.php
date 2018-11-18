<?php include("common/header.php");?>
<div class="wrapper-page widht-800">
    <div class="card-box">
        
         <DIV class="signupformd-title">TOKEN PRICE TEMPLATES - ATTACH CAMPAIGN</div>

        <div class="panel-body">

                                <ul class="nav nav-wizard token-pricing">
                <li><a href="#"  data-toggle="tooltip" data-placement="top" title="Set token pricing type"><SPAN>1</span> TOKEN TYPE</a></li>
                <li><a href="#"  data-toggle="tooltip" data-placement="top" title="Set token bonus type"><SPAN>2</span> BONUS TYPE</a></li>
                <li><a href="#"  data-toggle="tooltip" data-placement="top" title="Define bonus levels"><SPAN>3</span> SET BONUS</a></li>
                    <li class="active"><a href="#"  data-toggle="tooltip" data-placement="top" title="Attach to a campaign"><SPAN>4</span> ATTACH TO CAMPAIGN</a></li>
              </ul>

            <div class="row">
                <div class="col-lg-12">
                   <?php 
					//	$title = "TOKEN PRICE TEMPLATES";

                         $campaigns = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('active'=>1))->result_object();

					?>
                   
                    <div class="tab-content">
                      <!-- <span class="signupformd"><?php echo $title;?></span> -->
                        <div class="tab-pane active" id="personal">

                            <?php if(empty($campaigns)){ ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="wrongerror">
                                        No ICO campaign(s) found. Please add ICO Campaign to add a token price
                                        <br>
                                        <a href="<?php echo base_url().'admin/add-ico-setting'; ?>">
                                            <button class="btn btn-xs btn-primary">Add ICO Campaign</button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <?php } ?>

                            <form method="POST" action="<?php echo base_url();?>do/admin/token/add" accept-charset="UTF-8" id="personal-info">

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
                                                    
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ICO Campaigns <sup>*</sup></label>
                                            <select class="form-control" name="ico_camp">
                                                <?php 


                                                foreach($campaigns as $ico_camp){



                                                 ?>
                                                    <option value="<?php echo $ico_camp->id; ?>">
                                                        <?php echo $ico_camp->title; ?>
                                                    </option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Which currency would you like to use for this pricing template? <sup>*</sup></label>
                                            <select required class="form-control" name="currency_type" onchange="currency_type_changed(this.value)">
                                                <option value="">--Please Choose--</option>
                                                <option value="USD">USD</option>
                                                <option value="ETH">ETH</option>
                                                <option value="BTC">BTC</option>
                                            </select>
                                        </div>
                                    </div>




                                    <div class="col-md-12" id="not_show_until_change" style="display: none;">
                                        <div class="form-group">
                                            <label ><span id="currency_type_label"></span>
                                                <sup>*</sup></label>
                                            <input id="limit_of_price" name="price_token" type="number" step='0.01' max="1" class="form-control" value="" required >
                                        </div>
                                    </div>


                                    <div class="col-md-6" style="display: none;">
                                        <div class="form-group">
                                            <label>Bonus (%) <sup>*</sup></label>
                                            <input name="bonus" type="number" step='0.01' class="form-control"  value="-1">
                                        </div>
                                    </div>
                                   
                                   
                                    <div class="col-md-12" style="display: none;">
                                        <div class="form-group">
                                            <label>Timezone</label>

                                                <select  name="timezone" class="form-control">
                                                    <option value="America/New_York" selected>America/New_York</option>
                                                <?php /* $timezones = $this->db->order_by('zone_name','ASC')->get('dev_web_timezones')->result_object();
                                                foreach($timezones as $timezone){
                                                 ?>
                                                    <option <?php if($token->timezone==$timezone->zone_name) echo "selected"; ?> value="<?php echo $timezone->zone_name; ?>"><?php echo $timezone->zone_name; ?></option>

                                                <?php } */ ?>
                                                </select>
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12" style="font-style: italic;">
                                       <i class="fa fa-info"></i> <label>Please enter date and time according EST timezone</label>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <div class="input-group">
                                                <input required name="start_date" type="text" class="form-control" placeholder="yyyy-mm-dd" id="birth_date" value="">
                                                <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Start Time </label>
                                            <div class="input-group">
                                                <input name="start_time" type="time" class="form-control time_picker" value="">
                                                <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    

                                    
                                    


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <div class="input-group">
                                                <input required name="end_date" type="text" class="form-control" placeholder="yyyy-mm-dd" id="end_date" value="">
                                                <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>End Time </label>
                                            <div class="input-group">
                                                <input name="end_time" type="time" class="form-control time_picker" value="">
                                                <span class="input-group-addon bg-custom b-0 text-white">
                                                    <i class="icon-clock"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    
                                    


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Minimum Investment Amount (USD)</label>
                                            <input name="min_invest" type="number" step="0.1" class="form-control" value="0.00">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Maximum Investment Amount (USD)</label>
                                            <input name="max_invest" type="number" step="0.1" class="form-control" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Token Cap <sup>*</sup></label>
                                            <input name="address" type="text" class="form-control" value="" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label>How will your pricing round end?</label>
                                    </div>

                                    <div class="col-md-12">
                                        
                                            <input type="radio" id="end_type1" name="end_type" value="1" required>
                                          <label for="end_type1">End date 
                                        </label>

                                    </div>
                                    <div class="col-md-12">
                                        
                                            <input type="radio" id="end_type2" name="end_type" value="2" required>
                                            <label for="end_type2">Token Cap
                                        </label>

                                    </div>
                                     <div class="col-md-12">
                                       
                                            <input type="radio" id="end_type3" name="end_type" value="3" required>
                                         <label for="end_type3">Whichever happens first
                                        </label>

                                    </div>

                                    
                                    
                                    <div class="col-md-6 col-md-offset-3 m-t-40">
                                        <div class="form-group">
                                            <input type="hidden" name="c_type" value="<?php echo $c_type; ?>">
                                            <input type="hidden" name="count" value="<?php echo $count; ?>">
                                            <button <?php if(empty($campaigns)) echo "disabled"; ?> class="btn btn-default btn-block btn-lg" type="submit">
                                               Save <?php if($c_type=="multiple") echo "& continue"; ?>
                                            </button>
                                        </div>
                                    </div>
                                   
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    var resizefunc = [];
</script>
<?php include("common/footer.php");?>

<script>
    $(document).ready(function() {

        $('#birth_date').datepicker({
            format: 'yyyy-mm-dd',
           
        });
		$('#end_date').datepicker({
            format: 'yyyy-mm-dd',
			
           	//endDate: '-0d'
        });
    });
    function currency_type_changed(v)
    {
        if(v!="" && v!==null)
        {


            if(v=="USD"){
                $("#currency_type_label").html("Token Price (Price in USD per token)");
                $("#limit_of_price").prop("max",false);
            }
            else
            {
                $("#currency_type_label").html("1 "+v+" = how much of your token?");
                $("#limit_of_price").prop("max","1");
            }



            $("#not_show_until_change").show();
        }
        else
        {
            $("#not_show_until_change").hide();

        }
    }
</script>


</body>
</html>
