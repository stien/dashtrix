<?php require_once("common/header.php");?>
<?php

$option = $this->db->where('id',$id)->get('dev_web_payment_options')->result_object()[0];
 ?>
	
   
    	<div class="row">
         <div class="col-sm-12 m-b-30">
        	<h4 class="page-title">Add New Payment Settings
               
            </h4>
    	</div>
    	</div>
    	<div class="row">
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


           <div class="col-md-8">
            <div class="card-box">
                        <form method="post" action="" onSubmit="return detectRequired(this);">
                            <div class="row">



                                                          

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Type: <sup>*</sup></label>
                                            <select class="form-control" required name="type" onchange="pull_type(this.value)">
                                                <option value="" >--Please Select--</option>
                                                <option <?php if($_GET['type']==1) echo "selected"; ?> value="1">Crypto</option>
                                                <option <?php if($_GET['type']==2) echo "selected"; ?> value="2">Stripe</option>
                                                <option <?php if($_GET['type']==3) echo "selected"; ?> value="3">Wire Details</option>
                                                <option <?php if($_GET['type']==4) echo "selected"; ?> value="4">Western Union</option>
                                                <option <?php if($_GET['type']==5) echo "selected"; ?> value="5">Money Gram</option>
                                            </select>                                            
                                        </div>
                                    </div>



                                


                                <?php if($_GET['type']==1){ ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name: <sup>*</sup></label>
                                            <input name="name" type="text" class="form-control" value="<?php echo $option->name; ?>" required autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo $option->name; ?> Wallet Address: <sup>*</sup></label>
                                            <input name="address" type="text" class="form-control" value="<?php echo $option->address; ?>" required autofocus>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Icon: <sup>*</sup> <small> <a target="_blank" href="https://fontawesome.com/v4.7.0/icons/">List available here</a></small></label>
                                            <input name="icon" type="text" class="form-control" value="<?php echo $option->icon; ?>" required >
                                        </div>
                                    </div>


                                    

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Activate Countdown Clock: <sup>*</sup></label>
                                            <input name="active_time" type="checkbox" <?php echo $option->time_active==1?"checked":""; ?> value="1" onclick="show_timer(this,<?php echo $option->id; ?>)">


                                        </div>
                                    </div>

                                    <div class="col-md-6 <?php echo $option->time_active==1?"":"display_none"; ?> " id="timer_div">
                                        <div class="form-group">
                                            <label>Time in minutes: <sup>*</sup> <small>(00:00)</small></label>
                                            <input name="time" type="text" value="<?php echo $option->count_down; ?>" class="form-control">

                                            
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Volatility (%)</label>
                                            <select class="form-control" name="volatility" required>
                                                <?php for($i=0;$i<=100;$i++){ ?>
                                                    <option <?php if($option->volatility==$i) echo "selected"; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                   

                                    <?php }else if($_GET['type']==2){ ?>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name: <sup>*</sup></label>
                                            <input name="name" type="text" class="form-control" value="<?php echo $option->name; ?>" required autofocus>
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Icon: <sup>*</sup> <small> <a target="_blank" href="https://fontawesome.com/v4.7.0/icons/">List available here</a></small></label>
                                            <input name="icon" type="text" class="form-control" value="<?php echo $option->icon; ?>" required >
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>API Key: <sup>*</sup> </label>
                                            <input name="api_key" type="text" class="form-control" value="<?php echo $option->api_key; ?>" required >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>API Secret: <sup>*</sup></label>
                                            <input name="api_secret" type="text" class="form-control" value="<?php echo $option->secret_key; ?>" required >
                                        </div>
                                    </div>
                                    





                                    <?php }else if($_GET['type']==3){ ?>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name: <sup>*</sup></label>
                                            <input name="name" type="text" class="form-control" value="<?php echo $option->name; ?>" required autofocus>
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Icon: <sup>*</sup> <small> <a target="_blank" href="https://fontawesome.com/v4.7.0/icons/">List available here</a></small></label>
                                            <input name="icon" type="text" class="form-control" value="<?php echo $option->icon; ?>" required >
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Bank Name: <sup>*</sup></label>
                                                <input name="bank_name" type="text" class="form-control" value="<?php echo $option->bank_name; ?>" required >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Bank Address:</label>
                                                <input name="bank_address" type="text" class="form-control" value="<?php echo $option->bank_address; ?>"  >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Routing Number: </label>
                                                <input name="routing_number" type="text" class="form-control at_least_one" value="<?php echo $option->routing_number; ?>"  >
                                                <input type="hidden" name="exists_rounting" value="1" id="exists_rounting">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Swift Code: </label>
                                                <input name="swift_code" type="text" class="form-control at_least_one" value="<?php echo $option->swift_code; ?>"  >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>IBAN: </label>
                                                <input name="iban" type="text" class="form-control at_least_one" value="<?php echo $option->iban; ?>"  >
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Account Number: </label>
                                                <input name="account_number" type="text" class="form-control" value="<?php echo $option->account_number; ?>"  >
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Account Holder's Address: </label>
                                                <input name="account__address" type="text" class="form-control" value="<?php echo $option->account__address; ?>"  >
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Account Holder's Phone Number: </label>
                                                <input name="account__phone_number" type="text" class="form-control" value="<?php echo $option->account__phone_number; ?>"  >
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Account Holder's Name: </label>
                                                <input name="account_name" type="text" class="form-control" value="<?php echo $option->account_name; ?>"  >
                                            </div>
                                        </div>
                                        

                                    <?php }else if($_GET['type']==4){ ?>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name: <sup>*</sup></label>
                                            <input name="name" type="text" class="form-control" value="<?php echo $option->name; ?>" required autofocus>
                                        </div>
                                    </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Receiver Full Name: <sup>*</sup></label>
                                                <input name="receiver_full_name" type="text" class="form-control" value="<?php echo $option->receiver_full_name; ?>" required >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Receiver City: <sup>*</sup></label>
                                                <input name="receiver_city" type="text" class="form-control" value="<?php echo $option->receiver_city; ?>" required >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="form-group">
                                           <label>Receiver Country: <sup>*</sup></label>
                                               <select class="form-control" required name="receiver_country">
                                                    <option value="" disabled>Please choose</option>
                                                    <?php foreach($countries as $country){ ?>
                                                        <option <?php if($option->receiver_country==$country->id) echo "selected"; ?> value="<?php echo $country->id; ?>"><?php echo $country->nicename; ?></option>
                                                    <?php } ?>

                                               </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="form-group">
                                           <label>Receiver State: <sup>*</sup></label>
                                               <input type="text" name="receiver_state" value="<?php echo $option->receiver_state; ?>" class="form-control">
                                            </div>
                                        </div>


                                    <?php } else if($_GET['type']==5){ ?>

                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name: <sup>*</sup></label>
                                            <input name="name" type="text" class="form-control" value="<?php echo $option->name; ?>" required autofocus>
                                        </div>
                                    </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Receiver Full Name: <sup>*</sup></label>
                                                <input name="receiver_full_name" type="text" class="form-control" value="<?php echo $option->receiver_full_name; ?>" required >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Receiver City: <sup>*</sup></label>
                                                <input name="receiver_city" type="text" class="form-control" value="<?php echo $option->receiver_city; ?>" required >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="form-group">
                                           <label>Receiver Country: <sup>*</sup></label>
                                               <select class="form-control" required name="receiver_country">
                                                    <option value="" disabled>Please choose</option>
                                                    <?php foreach($countries as $country){ ?>
                                                        <option <?php if($option->receiver_country==$country->id) echo "selected"; ?> value="<?php echo $country->id; ?>"><?php echo $country->nicename; ?></option>
                                                    <?php } ?>

                                               </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        <div class="form-group">
                                           <label>Receiver State: <sup>*</sup></label>
                                               <input type="text" name="receiver_state" value="<?php echo $option->receiver_state; ?>" class="form-control">
                                            </div>
                                        </div>


                                    <?php } ?>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Min. Amount (USD)</label>
                                            <input type="number" step="0.5" name="min_amount" class="form-control" value="<?php echo $option->min_amount; ?>" <?php echo $_GET['type']==4?'required':''; echo $_GET['type']==5?'required':''; ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Max. Amount (USD)</label>
                                            <input type="number" step="0.5" name="max_amount" class="form-control" value="<?php echo $option->max_amount; ?>" <?php echo $_GET['type']==4?'required':''; echo $_GET['type']==5?'required':''; ?>>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                           <label>Restricted Countries <sup>*</sup> <SMALL style="color:#f00">Checkmark the countries you would like to restrict users from creating a transaction. </SMALL>

                                            <a href="javascript:select_all('allowed_country_');">select all</a> /
                                            <a href="javascript:deselect_all('allowed_country_');">deselect all</a>

                                           </label>

                                           <div style="height: 100px; overflow-y: scroll; float: left; width: 100%;">
                                                <?php foreach($countries as $country){ ?>
                                                    <label style="margin-right: 10px; margin-bottom: 5px;">
                                                    <input class="allowed_country_" name="allowed_country[]" type="checkbox" <?php if(in_array($country->id,explode(',',$option->allowed_country))) echo "checked"; ?> value="<?php echo $country->id; ?>"><?php echo $country->nicename; ?>
                                                    </label>
                                                <?php } ?>
                                           </div>

                                           <?php /* ?>
                                           <select id="multiselect" class="form-control " multiple searchable="Search here.." required name="allowed_country" >
                                               <option <?php if($option->allowed_country==0) echo "selected"; ?> value="0">All</option>
                                                <?php foreach($countries as $country){ ?>
                                                    <option <?php if($option->allowed_country==$country->id) echo "selected"; ?> value="<?php echo $country->id; ?>"><?php echo $country->nicename; ?></option>
                                                <?php } ?>

                                           </select>
                                           <?php */ ?>

                                          
                                        </div>
                                    </div>

                                    <div class="col-md-12 m-t-40">
                                        <div class="form-group">
                                            <button class="btn btn-default pull-right " type="submit">
                                                Save Changes
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

function openModal2(id,that)
{
        window.location = "<?php echo base_url().'admin/edit-payment-option/'; ?>" + id;


         // $(".modal-cs").hide();


         //    $("#modal"+id).fadeIn();

   

   
}   
function openModal(id,that)
{

    if($(that).is(':checked')){
        window.location = "<?php echo base_url().'admin/edit-payment-option/'; ?>" + id;
        

         // $(".modal-cs").hide();


         //    $("#modal"+id).fadeIn();

    }else{
        $.post('<?php echo base_url().'ico/inactive_payment_option'; ?>',{id:id},function(data){});
    }


   
}   
function closeModel()
{
     $(".modal-cs").hide();
}

function show_timer(that)
{
    if($(that).is(':checked')){
        $("#timer_div").show();
    }       
    else
    {
        $("#timer_div").hide();

    }
}
function showAdd()
{
    $("#modalAdd").fadeIn();
}


$("input:radio[name=type]").change(function(){
    var val = $(this).val();


    $(".other-options").hide();
    $(".other-options").find('input').prop('required',false);
    $(".other-options").find('textarea').prop('required',false);
    


    if(val==1)
        showWallet();
    if(val==2)
        showAPI();
    if(val==3)
        showWire();
});

function showWallet()
{
    

    $(".wallet-option").show();

    $(".wallet-option").find('input').prop('required',false);

    
}
function showAPI()
{
   

    $(".api-option").show();

    $(".api-option").find('input').prop('required',false);

}

function showWire()
{
    


    $(".wire-option").show();

    $(".wire-option").find('textarea').prop('required',false);

}
function detectRequired(that)
{
    var y = $(that).find("#exists_rounting").val();
    if(y!=1) return true;
    var x = false;
    $(".at_least_one").each(function(i,v){
        if($(this).val())
            x = true;
    });

    if(x)
    {
        return true;
    }
    else
    {
        alert("You need to fill one of them: Routing No., Swift Code, IBAN");
        return false;
    }
}
function select_all(id)
{
    $("."+id).prop('checked',true);
}
function deselect_all(id)
{
    $("."+id).prop('checked',false);
}
function pull_type(type)
{
    window.location = "<?php echo base_url().'admin/add-payment-option?type=' ?>"+type;
}

</script>
<style type="text/css">
    .modal-box{
        width: 50% !important;
    }
    .modal-cs {position:absolute !important;}

</style>

