<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php 

						$title = "ADD NEW DIRECTORY TOOL - ADMIN";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="<?php echo base_url();?>ico/add_directory_submission" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Title <sup>*</sup></label>

                                            <input name="title" type="text" class="form-control" value="" required autofocus>

                                        </div>

                                    </div>
                                     <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Tool URL <sup>*</sup></label>

                                            <input name="urllink" type="url" class="form-control" required value="">

                                        </div>

                                    </div>

                                    
                                   	<div class="col-md-12">

                                        <div class="form-group">
											<div class="col-md-3">
                                            <label>Included In Default ICO: <sup>*</sup></label>
                                            </div>
											<label>
                                            <input name="default" required type="radio" value="1" onClick="show_price_tab(1)">
                                            Included
                                            </label>
                                            <label>
                                            <input name="default" required type="radio" value="0" onClick="show_price_tab(0)">
                                            Not-Included
                                            </label>

                                        </div>

                                    </div>
									<div class="col-md-6" id="price_tab" style="display: none;">

                                        <div class="form-group">

                                            <label>Price <sup>*</sup></label>

                                            <input name="price" type="number" id="price_inp" step="0.1" class="form-control" value="">

                                        </div>

                                    </div>
                                    

                     

                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                               Submit

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
	function show_price_tab(id){
		if(id=="1"){
			$("#price_tab").hide();
			$("#price_tab").atr("required", false);
			$("#price_inp").val('');
		} else{
			$("#price_tab").show();
			$("#price_tab").atr("required", true);
		}
	}
	
    $(document).ready(function() {



        $('#birth_date').datepicker({

            format: 'yyyy-mm-dd',

            endDate: '-0d'

        });

    });

</script>





</body>

</html>

