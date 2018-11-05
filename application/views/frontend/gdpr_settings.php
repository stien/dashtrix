<?php require_once("common/header.php");?>

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
    <div class="col-sm-12 m-b-30">
        <h4 class="page-title">GDPR SETTINGS</h4>
    </div>
</div>

<div class="row">

<div class="col-lg-12">


<div class="card-box m-b-50">    
<?php
$kyc_aml = $this->front_model->get_query_simple('*','dev_web_kyc_aml',array('id'=>1))->result_object()[0];
if($kyc_aml->gdpr_cookies==1){
?>
	<div class="form-group"  style="margin-bottom: 0;">
		<label style="text-transform: uppercase; font-weight: bold;"><strong>Disable "Tracking Cookies from EU"</strong></label>
		<a href="<?php  echo base_url().'ico/disable_cookie'; ?>">
			<button  type="button" class="btn btn-primary right">Disable</button>
		</a>
	</div>
<?php }else{ ?>
	<div class="form-group nopad" style="margin-bottom: 0;">
		<label  style="text-transform: uppercase; font-weight: bold;"><strong>Enable "Tracking Cookies from EU"</strong></label>
		<a href="<?php echo base_url().'ico/enable_cookie'; ?>">
		<button type="button" class="btn btn-primary right">Enable</button>
		</a>
	</div>
	
<?php } ?>
</div>

<div class="col-sm-12 m-b-10">
	<h4><strong>User Deletion Requests</strong></h4>
</div>  
<div class="card-box m-b-50 easy" style="clear: both;">    


<form action="<?php echo base_url();?>ico/delete_user_data" id="deletionform" method="post">
	<div class="col-md-12 nopad">
		<div class="form-group">
			<label>
				Enter a user name to have the user and all their data completely deleted from the system:
			</label>
			<input name="username" id="userdelete" onKeyUp="show_form_button()" autocomplete="off" class="form-control" type="text" required="" value="">
		</div>
		<div class="form-group">
			<button type="button" disabled onClick="openModal3()" id="disablebtn" class="btn btn-default right" name="submit">
				Delete User
			</button>
		</div>
	</div>

<div class="modal-cs display_none" id="modal3">
<div class="modal-box">
	<div class="modal-heading">
		IMPORTANT INFORMATION

		<button onclick="closeModel();" class="btn bt-danger right" >
			<i  class="fa fa-times"></i>
		</button>
	</div>

	<div class="modal-body" style="text-align: center;">
	   <div class="col-md-12 nopad">
		   <i class="fa fa-exclamation-triangle" style="font-size: 40px; margin-bottom: 20px; color:#f00;"></i>
		   <br>
			ARE YOU SURE YOU WANT TO REMOVE THIS USER!
			<br>
			ALL USER DATA WILL BE REMOVED AND IT WILL NOT BE RECOVERED!
		</div>        
		<button type="submit" onClick="deleteuser()" class="btn btn-default" name="submit" style="margin-top: 25px; clear: both;">
			Delete User
		</button>                   
	</div>
</div>
</div>
	
</form>
</div>

    </div> <!-- end col -->

</div>

<?php require_once("common/footer.php");?>

<script language="javascript">

    <?php if(ACTYPE == "1"){?>
function show_form_button()
{
	
	if($("#userdelete").val() != ""){
		$("#disablebtn").attr("disabled",false);
	}
}
function deleteuser(){

	$("#deletionform").submit();
}
function closeModel()
{
     $(".modal-cs").hide();
}

function openModal()
{

	 $("#modalTerms").fadeIn();

    


   
}
function openModal2()
{

    $("#modalCapm").fadeIn();





}

function openModal3()
{
    $("#modal3").fadeIn();
}

    function btnstatusdelete(id){

        var x = confirm("Are you sure you want to Remove this user? All data & created bounties will be removed against this user");

        if (x){

            window.location='<?php echo base_url(); ?>ico/remove_banned_country/'+id;

            return true;

        }

        else {

            return false;

        }



    }

    <?php } ?>

    function closeModel()
    {
        $(".modal-cs").hide();
    }
    function showModel_box()
    {
        $("#modalTerms").show();
    }

</script>


<div class="modal-cs display_none" id="modalTerms">
    <div class="modal-box">
        <div class="modal-heading">
            Add New Country

            <button onclick="closeModel();" class="btn bt-danger right" >
                <i  class="fa fa-times"></i>
            </button>
        </div>

        <div class="modal-body">
            <form method="post" action="">
                <div class="row">






                    <div class="col-md-6 col-md-offset-3 m-t-40">
                        <div class="form-group">

                            <select class="form-control" name="country">

                            <?php

                            $arucon = array();

                            $conqry = $this->front_model->get_query_simple('*','dev_web_countries',$arucon);

                            $conts 	= $conqry->result_object();

                            foreach($conts as $cont){
                            ?>
                                <option value="<?php echo $cont->id; ?>"><?php echo $cont->nicename; ?></option>

                            <?php } ?>


                            </select>

                        </div>
                    </div>

                    <div class="col-md-6 col-md-offset-3 m-t-40">
                        <div class="form-group">



                                <button class="btn btn-default btn-block btn-lg" type="submit" name="submit">
                                    Add
                                </button>


                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
