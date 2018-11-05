<?php require_once("common/header.php");?>
<!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
           
            <h4 class="page-title text-center">KYC VERIFICATION STATUS</h4>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-2"></div>
        <div class="col-md-8">
            

            <div class="card-box widget-box-1">
                <h4 class="header-title m-t-0 m-b-30">KYC Verification Rejected!
                   
                </h4>
                <div class="row" >
                  
                    <div class="col-md-12">
                        <div class="">
                            Your KYC verification has been rejected by <a href="https://shuftipro.com/" target="_blank">ShuftiPro</a>. 
                            <br>
                            <?php if($_SESSION['rejected_kyc']->status_code!="SP0") echo $_SESSION['rejected_kyc']->message; ?>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
             <div class="row" id="passwordrequest">
                <div class="col-sm-12 m-b-30 text-center">
                    <div class="button-list m-t-15">
                        <a href="<?php echo base_url().'verify'; ?>">
                        <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-refresh"></i></span>Try Again</button>
                    </a>
                    </div>
                </div>
            </div>
           


           
        </div>
        <!-- end col -->

       


        <!-- end col -->

    </div>
<?php require_once("common/footer.php");?>


