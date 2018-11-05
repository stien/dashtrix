<?php include("common/header.php");?>

<?php
	$kyc_aml = $this->front_model->get_query_simple('*','dev_web_kyc_ml_user',array('kycID'=>$this->uri->segment(3)))->result_object()[0];
?>

<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">
                     

                   <?php 

						$title = "EDIT NEW KYC/AMML - ADMIN";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="<?php echo base_url();?>ico/admin_kyc_settings_edit" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Company Name <sup>*</sup></label>

                                            <input name="company_name" type="text" class="form-control" value="<?php echo $kyc_aml->title;?>" required autofocus>
                                            <input name="id" type="hidden" class="form-control" value="<?php echo $kyc_aml->kycID;?>" autofocus>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Company URL <sup>*</sup></label>

                                            <input name="comp_url" type="url" class="form-control" required value="<?php echo $kyc_aml->url;?>">

                                        </div>

                                    </div>

                                    

                                   

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>API Settings</label>
											<textarea name="settings" rows="10" id="settings" required class="form-control"><?php echo $kyc_aml->apisetting;?></textarea>
                                        </div>

                                    </div>

                                   
									 <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                               Update Setting

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

            endDate: '-0d'

        });

    });

</script>





</body>

</html>

