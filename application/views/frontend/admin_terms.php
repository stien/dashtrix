<?php require_once("common/header.php");?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
             
            </div>
            <h4 class="page-title">Edit Terms & Conditions</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="" accept-charset="UTF-8" id="form-profile">
            <input type="hidden" name="type" value="company">

            <div class="card-box widget-box-1">
                <h4 class="header-title m-t-0 m-b-30">Edit Terms</h4>
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


                    <div class="form-group">
                        <label>Terms & Conditions Text</label>
                        <textarea class="form-control" rows="5" name="terms_text"><?php echo $terms->text; ?></textarea>
                    </div>


                    <?php foreach(json_decode($terms->c_statements) as $st) echo get_terms_div($st); ?>


                <!--     <div class="statement">
                        <div class="form-group">
                            <label>Statement</label>
                            <textarea class="form-control" name="statement[]"></textarea>
                        </div>

                        <div class="kut">
                            <button onclick="removeTerm(this)" type="button" class="btn btn-xs btn-danger">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
 -->


                   
                    


                    <div class="form-group">
                        <button type="button" onclick="addTerm(this)" class="btn btn-xs btn-default">
                            Add Statement
                        </button>
                    </div>
                    
                 
                  
                 
                    
                    
                    
                </div>
            </div>
			 <div class="row" id="">
                <div class="col-sm-12 m-b-30">
                    <div class="button-list pull-right m-t-15">
                        <button class="btn btn-default submit-form" type="submit" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button>
                    </div>
                </div>
            </div>
            </form>




           
        </div>
        <!-- end col -->

        <div class="col-md-4">
          
        </div>
        <!-- end col -->

    </div>
<?php require_once("common/footer.php");?>



<script>

    function addTerm(that)
    {


            $.post("<?php echo base_url().'ico/get_terms_div'; ?>",{status:true},function(resp){
                $(that).parent().before(resp);
            });

    }
    function removeTerm(that)
    {
        $(that).parent().parent().remove();
    }


</script>
