<?php require_once("common/header.php");?>
<?php

  $ref__ = $this->db->get('dev_web_ref_setting')->result_object()[0];
  
 ?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
               <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
            </div>
            <h4 class="page-title">Language Settings</h4>
        </div>
    </div>
   


    <div class="row">
        

        <div class="col-md-8">
            
            <div class="card-box widget-box-1">


                    <h4 class="header-title m-t-0 m-b-30">Language Settings</h4>
                    <div class="row">
                      <form method="post" action="" >

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Default Language:</label>
                                <select class="form-control" name="default_lang" required>
                                <?php 
                                $langs = all_langs();

                                foreach($langs as $lang)
                                {

                                  ?>
                                    <option <?php if($lang['short_name']==$web_settings->default_lang) echo "selected"; ?> value="<?php echo $lang['short_name']; ?>"><?php echo $lang['name'].' ('.$lang['short_name'].')'; ?></option>

                                  <?php
                                }
                                ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Allowed Languages:</label>
                                <select id="vendors" class="form-control" name="allowed_langs[]" multiple required>
                                <?php 
                                $langs = all_langs();
                                foreach($langs as $lang)
                                {
                                  ?>
                                    <option
                                     <?php if(in_array($lang['short_name'],explode(',',$web_settings->allowed_langs))) echo "selected"; ?>
                                     value="<?php echo $lang['short_name']; ?>"><?php echo $lang['name'].' ('.$lang['short_name'].')'; ?></option>

                                  <?php
                                }
                                ?>
                                </select>
                            </div>

                        </div>
                        <div class="col-md-12 right">
                            <button class="btn btn-default m-t-20 right" >Save</button>
                        </div>
                      </form>
                    </div>


            </div>
        </div>
        <!-- end col -->

    </div>
<?php require_once("common/footer.php");?>
<link href="<?php echo base_url();?>resources/frontend/css/jquery.multiselect.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url();?>resources/frontend/js/jquery.multiselect.js"></script>
<script language="javascript">
$('#vendors').multiselect({
    columns: 2,
    placeholder: 'Pleas Select',
    search: true,
    selectAll: true
});
</script>