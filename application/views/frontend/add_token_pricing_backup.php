<?php include("common/header.php");?>
<div class="wrapper-page widht-800">
    <div class="card-box">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                   <?php 
						$title = "TOKEN PRICE TEMPLATES";

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

                            <form method="POST" action="<?php echo base_url();?>do/admin/token/add" accept-charset="UTF-8" id="personal-info">
                                                    
                                <div class="row">

                                    <div class="col-md-6">
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


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Token Price (Price in USD per token) <sup>*</sup></label>
                                            <input name="price_token" type="number" step='0.01' class="form-control" value="" required >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bonus (%) <sup>*</sup></label>
                                            <input name="bonus" type="number" step='0.01' class="form-control" required value="">
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
                                            <label>Token Cap</label>
                                            <input name="address" type="text" class="form-control" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label>
                                            <input type="checkbox" name="end_on_end_date" value="1">
                                            End this campaign automatically when it reaches the campaign end date 
                                        </label>

                                    </div>
                                     <div class="col-md-12">
                                        <label>
                                            <input type="checkbox" name="end_on_end_token" value="1">
                                            End this campaign automatically if the number of tokens sold reaches the allocated number for sale above.
                                        </label>

                                    </div>

                                    
                                    
                                    <div class="col-md-6 col-md-offset-3 m-t-40">
                                        <div class="form-group">
                                            <button <?php if(empty($campaigns)) echo "disabled"; ?> class="btn btn-default btn-block btn-lg" type="submit">
                                               Add New Token
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
</script>


</body>
</html>
