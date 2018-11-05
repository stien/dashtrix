<?php 
if($web_settings->import_export_feature==1){
 ?>

<div class="button-list pull-right m-t-15 " style="margin-right: 10px;">
           
            <a href="javascript:ImportWebsite();">
             <button  type="button" class="btn btn-primary"><i class="fa fa-download"></i> Import</button>
            </a>
</div>
<div class="button-list pull-right m-t-15 " style="margin-right: 10px;">
            <a class="btn btn-default" href="<?php echo base_url()."ie/export/".$c_p_link;?>"><i class="fa fa-upload"></i> Export</a>
</div>
<div class="modal-cs modal-cs-website display_none" id="UploadCSVWebsite" style="position: fixed !important;">
                <div class="modal-box">
                    <div class="modal-heading">
                        Upload a CSV file to import data

                        <button onclick="closeModelWebsite();" class="btn bt-danger right" >
                            <i  class="fa fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form enctype="multipart/form-data" method="post" action="<?php echo base_url()."ie/import/".$c_p_link;?>">
                            <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div style="padding: 10px; text-align: center; background: red; color:#fff;">Please be noted that every record with same identity will be replaced with new data from your uploaded file</div>

                                            <label>CSV: <sup>*</sup></label>
                                            <input name="csv" type="file" class="form-control" value="" required multiple>
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-md-offset-3 m-t-40">
                                        <div class="form-group">
                                            <button class="btn btn-default btn-block btn-lg" type="submit">
                                                Import
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                 </div>
            </div>


<script type="text/javascript">
function closeModelWebsite()
{
	var x = document.getElementById("UploadCSVWebsite");
    x.style.display = "none";
}
function ImportWebsite()
{
    closeModelWebsite();
    var x = document.getElementById("UploadCSVWebsite");
    x.style.display = "block";
    
}
</script>
 <?php
}
 ?>
