<?php include("common/header.php");?>
<div class="wrapper-page widht-800">
    <div class="card-box">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                   <?php 
						$title = "EDIT PRICE TEMPLATES";

                         $campaigns = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('active'=>1))->result_object();

					?>
                   
                    <div class="tab-content">
                      <span class="signupformd"><?php echo $title;?></span>
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

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">
                                                    
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ICO Campaigns <sup>*</sup></label>
                                            <select class="form-control" name="ico_camp">
                                                <?php 


                                                foreach($campaigns as $ico_camp){



                                                 ?>
                                                    <option value="<?php echo $ico_camp->id; ?>"
                                                        <?php if($token->ico_camp==$ico_camp->id) echo "selected"; ?>
                                                        >
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
                                                <option <?php if($token->currency_type=="USD") echo "selected"; ?> value="USD">USD</option>
                                                <option <?php if($token->currency_type=="ETH") echo "selected"; ?> value="ETH">ETH</option>
                                                <option <?php if($token->currency_type=="BTC") echo "selected"; ?> value="BTC">BTC</option>
                                            </select>
                                        </div>
                                    </div>




                                    <div class="col-md-12" id="not_show_until_change" >
                                        <div class="form-group">
                                            <label ><span id="currency_type_label">

                                                <?php if($token->currency_type=="USD") echo "Token Price (Price in USD per token)"; else echo "1 ".$token->currency_type." = how much of your token?"; ?>
                                              </span>
                                                <sup>*</sup></label>
                                            <input id="limit_of_price" name="price_token" type="number" step='0.01' max="<?php if($token->currency_type!="USD"){ ?>1<?php } ?>" class="form-control" value="<?php echo $token->tokenPrice; ?>" required >
                                        </div>
                                    </div>


                                   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bonus (%) <sup>*</sup></label>
                                            <input name="bonus" type="number" step='0.01' class="form-control" required value="<?php echo $token->tokenBonus; ?>">
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
                                                <input required name="start_date" type="text" class="form-control" placeholder="yyyy-mm-dd" id="birth_date" value="<?php echo date("Y-m-d",strtotime($token->tokenDateStarts)); ?>">
                                                <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Start Time </label>
                                            <div class="input-group">
                                                <input  name="start_time" type="time" class="form-control time_picker" value="<?php echo date("H:i",strtotime($token->start_time)); ?>">
                                                <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <div class="input-group">
                                                <input required name="end_date" type="text" class="form-control" placeholder="yyyy-mm-dd" id="end_date" value="<?php echo date("Y-m-d",strtotime($token->tokenDateEnds)); ?>">
                                                <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <div class="input-group">
                                                <input  name="end_time" type="time" class="form-control time_picker" value="<?php echo date("H:i",strtotime($token->end_time)); ?>">
                                                <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="" >Minimum Investment Amount (USD)</label>
                                            <input name="min_invest" type="number" step="0.1" class="form-control" value="<?php echo $token->min_invest; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="" >Maximum Investment Amount (USD)</label>
                                            <input name="max_invest" type="number" step="0.1" class="form-control" value="<?php echo $token->max_invest; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="" >Token Cap <sup>*</sup></label>
                                            <input name="address" type="text" class="form-control" value="<?php echo $token->tokenCap; ?>" required>
                                        
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label >How will your pricing round end?</label>
                                    </div>

                                    <div class="col-md-12">
                                       
                                            <input type="radio" id="end_type1" name="end_type" value="1" required <?php if($token->end_type=="1") echo "checked"; ?>>
                                        <label  for="end_type1"> 
                                            End date 
                                        </label>

                                    </div>
                                    <div class="col-md-12">
                                            <input type="radio" id="end_type2" name="end_type" value="2" required <?php if($token->end_type=="2") echo "checked"; ?>>
                                        
                                        <label for="end_type2" >
                                            Token Cap
                                        </label>

                                    </div>
                                     <div class="col-md-12">
                                        
                                            <input type="radio" id="end_type3" name="end_type" value="3" required <?php if($token->end_type=="3") echo "checked"; ?>>
                                       <label for="end_type3" > 
                                            Whichever happens first
                                        </label>

                                    </div>
                                    
                                    <div class="col-md-6 col-md-offset-3 m-t-40">
                                        <div class="form-group">
                                            <button <?php if(empty($campaigns)) echo "disabled"; ?> class="btn btn-default btn-block btn-lg" type="submit">
                                               Update Token
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
