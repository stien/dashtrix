<?php require_once("common/header.php");?>

<?php

$arr = array('id' => $id);
    $config = $this->front_model->get_query_simple('*', 'dev_web_registration_forms', $arr);
    $form = $config->result_object();

if(!isset($_SESSION['t']['jsondata'])) {
    $jsondata = json_decode($form[0]->form, true);
    $_SESSION['t']['jsondata'] = $jsondata;
}
else {
    $jsondata = $_SESSION['t']['jsondata'];
}

?>

<div class="row">
    <div class="col-sm-12 m-b-30">
        <h4 class="page-title">
           <?php echo $edit?"Edit":"Add"; ?> Form
        </h4>
    </div>
</div>
<div class="row">

    <div class="col-sm-4 m-b-30">
        <div class="card-box widget-box-1 left" style="width: 100%;">
            <p class="m-b-10">Click On a Specific button to create field!</p>
            <button type="button" class="btn btn-primary m-r-15  m-b-10" onClick="showform_modal('text')">Text Field</button>
            <button type="button" class="btn btn-default m-r-15  m-b-10" onClick="showform_modal('date')">Date Picker</button>
            <button type="button" class="btn btn-primary  m-b-10" onClick="showform_modal('number')">Number Field</button>
            <button type="button" class="btn btn-danger m-r-15 m-b-10" onClick="showform_modal('textarea')">Text Area</button>
            <button type="button" class="btn btn-primary  m-r-15 m-b-10" onClick="showform_modal('dropdown')">Drop Down</button>
            <button type="button" class="btn btn-primary m-b-10" onClick="showform_modal('file')">Upload File</button>
            <button type="button" class="btn btn-primary m-b-10" onClick="showform_modal('url')">Links (URL)</button>

        </div>




            <div class="card-box widget-box-1  left w100">

                        <h2>DEFAULT Fields</h2>
                        <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First name <sup>*</sup></label>
                                            <input name="first_name" type="text" class="form-control" value="" disabled readonly autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last name <sup>*</sup></label>
                                            <input name="last_name" type="text" class="form-control" disabled readonly value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>E-mail <sup>*</sup></label>
                                            <input name="email" type="email" class="form-control" disabled readonly value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone number: <sup>*</sup> <i class="fa fa-question" title="You must enter your number in the following format: 1-212-222-2222"></i></label>
                                            <input name="phone" type="text" disabled readonly class="form-control" value="" placeholder="Use format: 1-555-555-5555">
                                        </div>
                                    </div>
                                   
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Country <sup>*</sup></label>
                                            
                                            <select class="form-control" name="country" disabled readonly>
                                            <option selected="selected" disabled="disabled" hidden="hidden" value="">Choose</option>
                                           
                                            </select>
                                        </div>
                                    </div>

                                   
                               
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Username <sup>*</sup></label>
                                            <input name="username" type="text" class="form-control" disabled readonly value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password <sup>*</sup></label>
                                            <input name="password" type="password" class="form-control" disabled readonly>
                                            <p class="text-muted font-13">Minimum 8 characters.</p>
                                        </div>
                                    </div>
                                  
                                </div>

            </div> 
    </div>
    <!--DISPLAY FORM STORAGE-->
    <div class="col-sm-8 m-b-30">

        <?php if($edit){ ?>
        <h4 class="easy m-b-10">
            <a href="<?php  echo base_url().'ico/revert_form_edit'; ?>" class="pull-right">
                <button type="button" class="btn btn-default">Revert Form</button>
            </a>
        </h4>
    <?php } ?>

        <div class="col-md-12 display_none msg_div">
            <div class="form-group">
                <div class="successfull">
                    <?php echo $_SESSION['thankyou'];?>
                </div>
            </div>
        </div>
        <form method="post" action="">
            <?php if($sub!="no"){ ?>
                <input type="hidden" name="submission_form" value="1">
            <?php } ?>



                <div class="card-box widget-box-1  left w100">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Form Name: <sup>*</sup></label>
                                <input type="text" name="formname" class="form-control" id="formname" value="<?php echo $form[0]->title; ?>" placeholder="Please provide Form name">

                            </div>
                        </div>
            </div> 



        

            <div class="card-box widget-box-1  left w100">   

                <?php foreach($jsondata as $b_key=>$banner){?>
                    <div class="box-new-forms while_removing_<?php echo $b_key; ?>">
                        <div class="col-md-<?php if($banner['typetext'] == "textarea"){?>12<?php } else {?>6<?php }?>">
                            <div class="form-group">
                                <label class="easy"><?php echo $banner['name'];?>: <?php if($banner['type']==1) { ?><sup>*</sup> <?php } ?>
                                    <button type="button" class="cross-edit-form btn btn-danger btn-xs pull-right m-l-5" onclick="removeMe(<?php echo $b_key; ?>)">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <button type="button" class="edit-form btn btn-primary btn-xs pull-right" onclick="editMe(<?php echo $b_key; ?>)">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                </label>
                                <?php if($banner['typetext'] == "textarea"){?>
                                    <textarea type="text" name="name" class="form-control" readonly id="name" placeholder=""></textarea>
                                <?php } else {?>
                                    <input type="text" name="name" class="form-control" readonly id="name" value="" placeholder="" >
                                <?php } ?>


                            </div>
                        </div>
                    </div>


                    <div class="modal-cs display_none" id="modalEdit<?php echo $b_key; ?>">
                        <div class="modal-box-large">
                            <div class="modal-heading">
                                <span class="left m-t-5">Edit Field - <?php echo $banner['name']; ?></span>
                                <button onclick="closeModel();" class="btn bt-danger right" type="button" >
                                    <i  class="fa fa-times"></i>
                                </button>
                            </div>

                            <div class="modal-body had_form<?php echo $b_key; ?>">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name: <sup>*</sup></label>
                                                <input name="name" type="text" class="form-control take_me" value="<?php echo $banner['name']; ?>" required autofocus>
                                                <input name="typetext" type="hidden" id="typetextval" class="form-control take_me" value="<?php echo $banner['typetext']; ?>" required>
                                                <input name="key" value="<?php echo $b_key; ?>" type="hidden" class=" take_me">
                                                <input name="fid" value="<?php echo $id; ?>" type="hidden" class=" take_me">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ToolTip:  <small> (This will be displayed as a hover in front of field)</small></label>
                                                <input name="tooltip" type="text" class="form-control  take_me" value="<?php echo $banner['tooltip']; ?>"  >
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Required: <sup>*</sup>(This field will be required to fill?)</label>
                                                <br>
                                                <div class="col-md-4">
                                                    <label>
                                                        <input class=" take_me" type="radio" name="type"  value="1" <?php echo $banner['type']==1?'checked':''; ?>> Yes - Required
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>
                                                        <input type="radio" name="type" class=" take_me" value="2" <?php echo $banner['type']!=1?'checked':''; ?>> No - Not Required
                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="other-options <?php echo $banner['typetext']=="dropdown"?"":"display_none"; ?>" id="dropdown_div">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Drop Down values: <small>(Enter One option per line)</small></label>
                                                    <textarea name="dropvalue" class="form-control take_me" id="dropval" placeholder="(Enter One option per line)" ><?php echo $banner['dropvalue']; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-md-offset-3 m-t-40">
                                            <div class="form-group">
                                                <button class="btn btn-default btn-block btn-lg" type="button" onclick="submitForm(<?php echo $b_key; ?>);">
                                                    Update Form
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>








                <?php } ?>

                    <div class="col-md-6 col-md-offset-3 m-t-40">
                        <div class="form-group">
                            <button class="btn btn-default btn-block" type="submit">
                                <?php echo $edit?"Update":"Submit"; ?>
                            </button>
                        </div>
                    </div>


            </div>
        </form>
    </div>

    <div class="modal-cs display_none" id="modalAdd">
        <div class="modal-box-large" style="float: none;
    margin: 0 auto;
    width: 80%;
    margin-top: 100px;">
            <div class="modal-heading">
                <span class="left m-t-5">Add New Field Information</span>
                <button onclick="closeModel();" class="btn bt-danger right" >
                    <i  class="fa fa-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <form method="post" action="<?php echo base_url().'ico/add_form_data_edit_one'; ?>">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name: <sup>*</sup></label>
                                <input name="name" type="text" class="form-control" value="" required autofocus>
                                <input name="typetext" type="hidden" id="typetextval" class="form-control" value="" required>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ToolTip:  <small> (This will be displayed as a hover in front of field)</small></label>
                                <input name="tooltip" type="text" class="form-control" value=""  >
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Required: <sup>*</sup>(This field will be required to fill for bounty owners?)</label>
                                <br>
                                <div class="col-md-4">
                                    <label>
                                        <input type="radio" name="type" checked value="1"> Yes - Required
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label>
                                        <input type="radio" name="type" value="2"> No - Not Required
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="other-options display_none" id="dropdown_div">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Drop Down values: <small>(Enter One option per line)</small></label>
                                    <textarea name="dropvalue" class="form-control" id="dropval" placeholder="(Enter One option per line)" ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-md-offset-3 m-t-40">
                            <div class="form-group">
                                <button class="btn btn-default btn-block btn-lg" type="submit">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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

    function showform_modal(id)
    {
        $(".modal-cs").hide();
        $("#modalAdd").fadeIn();
        $("[id='typetextval']").val(id);
        if(id == "dropdown"){
            $("[id='dropdown_div']").show();
            $("[id='dropval']").attr("required",true);
        }
        else {
            $("[id='dropdown_div']").hide();
            $("[id='dropval']").attr("required",false);
        }
    }
    function closeModel()
    {
        $(".modal-cs").hide();
    }
    function editMe(id) {
        $(".modal-cs").hide();
        $("#modalEdit"+id).show();

    }
    function submitForm(that) {
        var s = $(".had_form"+that).find('.take_me').serialize();
        $.post('<?php echo base_url().'ico/edit_form_data'; ?>',s, function(data){

      window.location = window.location.href;
        });

    }

    function removeMe(that) {

        $.post('<?php echo base_url().'ico/remove_form_data'; ?>',{key:that,id:<?php echo $id?$id:0; ?>}, function(data){

            $(".while_removing_"+that).remove();
            $(".msg_div").find('.successfull').html('Field removed successfully!');
            $(".msg_div").show();
        });

    }

</script>
