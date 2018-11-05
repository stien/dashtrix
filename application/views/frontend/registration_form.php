<?php
/**
 * Created by PhpStorm.
 * User: Mahev Stark
 * Date: 4/30/2018
 * Time: 1:55 PM
 */
?>


<?php require_once("common/header.php");?>



<div class="row">

    <div class="col-sm-12 m-b-30">
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


        



        <h4 class="page-title">User Registration 


        </h4>

    </div>

</div>

<div class="row">

    <div class="col-lg-12">
        
        <?php /* ?>
        <div class="card-box m-b-50">   
        <?php
			$uf_id = 1;
			$user_verification = $this->front_model->get_query_simple('*','dev_web_campaigns',array('id'=>$uf_id))->result_object()[0];

			if($user_verification->active==1){
		?>
			<div class="form-group" style="margin-bottom: 0;">
				<label><strong>Disable "User Verification" on-boarding campaign</strong></label>
				<a href="<?php  echo base_url().'ico/disable_uf/'.$uf_id; ?>">
				 <button  type="button" class="btn btn-primary right">Disable</button>
				</a>
			</div>
			<?php }else{ ?>
			<div class="form-group"  style="margin-bottom: 0;">
				<label><strong>Enable "User Verification" on-boarding campaign</strong></label>
                    <a href="<?php echo base_url().'ico/enable_uf/'.$uf_id; ?>">
				        <button type="button"   class="btn btn-primary right">Enable</button>
                    </a>

			</div>
            <div class="modal-cs display_none" id="modalCapm">
                    <div class="modal-box">
                        <div class="modal-heading">
                            Choose which items to collect

                            <button onclick="closeModel();" class="btn bt-danger right" >
                                <i  class="fa fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url().'ico/enable_uf/'.$uf_id; ?>">
                                <div class="row">






                                    <div class="col-md-6 col-md-offset-3 m-t-40">
                                        <div class="form-group">

                                            <label class="m-r-10">
                                                <input type="checkbox" value="1" name="passport" <?php if($kyc_aml->passport==1) echo "checked"; ?>>
                                                Passport
                                            </label>

                                            <label class="m-r-10">
                                                <input type="checkbox" value="1" name="user_holding_passport_image" <?php if($kyc_aml->user_holding_passport_image==1) echo "checked"; ?>>
                                                User Holing Passport Image
                                            </label>

                                            <label class="m-r-10">
                                                <input type="checkbox" value="1" name="utility_bill" <?php if($kyc_aml->utility_bill==1) echo "checked"; ?>>
                                                Utility Bill
                                            </label>

                                            <label class="m-r-10">
                                                <input type="checkbox" value="1" name="bank_statement" <?php if($kyc_aml->bank_statement==1) echo "checked"; ?>>
                                                Bank Statement
                                            </label>

                                            <label class="m-r-10">
                                                <input type="checkbox" value="1" name="last_four_digits_of_ssn" <?php if($kyc_aml->last_four_digits_of_ssn==1) echo "checked"; ?>>
                                                Last 4 digits of SSN
                                            </label>

                                            <label class="m-r-10">
                                                <input type="checkbox" value="1" name="birhtday" <?php if($kyc_aml->birthday==1) echo "checked"; ?>>
                                                Birthday
                                            </label>

                                            <label class="m-r-10">
                                                <input type="checkbox" value="1" name="employer" <?php if($kyc_aml->employer==1) echo "checked"; ?>>
                                                Employer
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-md-offset-3 m-t-40">
                                        <div class="form-group">



                                                <button class="btn btn-default btn-block btn-lg" type="submit" name="submit">
                                                    Enable
                                                </button>


                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
			<?php } ?>
		</div>
        
        <?php */ ?>
       
        <div class="card-box m-b-50" style="clear: both;"> 
        <?php


			$uf_id = 1;

            $kyc_aml = $this->front_model->get_query_simple('*','dev_web_kyc_aml',array('id'=>1))->result_object()[0];

			
            if($kyc_aml->force_verification==1){
                ?>


                <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Disable "User Email Verification" </strong></label>
                    <a href="<?php  echo base_url().'ico/disable_uf_email/'; ?>">
                        <button  type="button" class="btn btn-primary right">Disable</button>
                    </a>
                </div>

            <?php }else{ ?>


                <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Enable "User Email Verification"</strong></label>
                    <a href="<?php  echo base_url().'ico/enable_uf_email'; ?>">
                        <button type="button"  class="btn btn-primary right">Enable</button>
                    </a>
                </div>

            <?php } ?>
		</div>




        <div class="card-box m-b-50" style="clear: both;"> 
        <?php


           

            $captcha = $this->front_model->get_query_simple('*','dev_web_config',array('cID'=>1))->result_object()[0];

            
            if($captcha->captcha==1){
                ?>


                <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Disable "Captcha" </strong></label>
                    <a href="<?php  echo base_url().'ico/disable_captcha/'; ?>">
                        <button  type="button" class="btn btn-primary right">Disable</button>
                    </a>
                </div>

            <?php }else{ ?>


                <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Enable "Captcha"</strong></label>
                    <a href="<?php  echo base_url().'ico/enable_captcha'; ?>">
                        <button type="button"  class="btn btn-primary right">Enable</button>
                    </a>
                </div>

            <?php } ?>
        </div>




        <div class="card-box m-b-50" style="clear: both;"> 
        <?php


            $uf_id = 1;

            $ask_eth = $this->front_model->get_query_simple('*','dev_web_config',array())->result_object()[0];

            
            if($ask_eth->ask_eth==1){
                ?>


                <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Disable "Enter ETH Wallet Address" </strong></label>
                    <a href="<?php  echo base_url().'ico/disable_ask_eth'; ?>">
                        <button  type="button" class="btn btn-primary right">Disable</button>
                    </a>
                </div>

            <?php }else{ ?>


                <div class="form-group" style="margin-bottom: 0;">
                    <label style="text-transform: uppercase;"><strong>Enable "Enter ETH Wallet Address"</strong></label>
                    <a href="<?php  echo base_url().'ico/enable_ask_eth'; ?>">
                        <button type="button"  class="btn btn-primary right">Enable</button>
                    </a>
                </div>

            <?php } ?>
        </div>



		 <div class="button-list pull-right m-b-10"  style="clear: both;">

            <a class="btn btn-default" href="<?php echo base_url().'admin/new-reg-form'; ?>"><i class="fa fa-plus"></i> Add New Form</a>


        </div>

         <?php 
        $c_p_link = 'user-registration';
        require_once 'common/import_export.php'; ?>
        <div class="card-box m-b-50"  style="clear: both;">

            
            <div class="table-responsive">

                <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">

                    <thead>

                    <tr>
                        <th >Form Title</th>
                        <th >Status</th>
                        <th >Action</th>
                    </tr>

                    </thead>

                    <?php



                    ?>

                    <tbody>

                    <?php

                    foreach($registration_form AS $row){
                        ?>

                        <tr>


                            <td><?php echo $row->title;?></td>
                            <td>
                                 <?php 
                                        if($row->status == "0"){echo "<div class='status-pending'>In-Active</div>";} 
                                        else if($row->status == "1"){echo "<div class='status-confirm'>Active</div>";}
                                    ?>
                            </td>
                            <td>



                                <div class="btn-group">

                                    <button type="button" class="btn btn-info">Actions</button>

                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        <span class="caret"></span>

                                        <span class="sr-only">Toggle Dropdown</span>

                                    </button>

                                    <ul class="dropdown-menu">


                                        <li><a href="<?php echo base_url().'admin/edit-reg-form/'.$row->id; ?>" >Edit</a></li>
                                        <li><a href="javascript:;" onClick="btnstatusdelete(<?php echo $row->id;?>);">Delete</a></li>
                                        <?php if($row->status==0){ ?>
                                        <li><a href="<?php echo base_url().'ico/activate_form/'.$row->id; ?>" >Activate</a></li>
                                    <?php } ?>


                                    </ul>

                                </div>



                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>



    </div> <!-- end col -->

</div>

<?php require_once("common/footer.php");?>

<script language="javascript">

    <?php if(ACTYPE == "1"){?>




    function btnstatusdelete(id){

        var x = confirm("Are you sure you want to Remove this user? All data & created bounties will be removed against this user");

        if (x){

            window.location='<?php echo base_url(); ?>ico/remove_form_field/'+id;

            return true;

        }

        else {

            return false;

        }



    }

    <?php } ?>

    $("#clciModel").click(function(){
        $("#modalTerms").show();
    });

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
            Add New Field

            <button onclick="closeModel();" class="btn bt-danger right" >
                <i  class="fa fa-times"></i>
            </button>
        </div>

        <div class="modal-body">
            <form method="post" action="">
                <div class="row">






                    <div class="col-md-6 col-md-offset-3 m-t-40">
                        <div class="form-group">
                            <label>Field Name</label>
                            <input type="text" name="field" class="form-control" value="">

                        </div>

                        <div class="form-group">
                            <label>
                            <input type="checkbox" name="required" value="1">
                                Required
                            </label>

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
