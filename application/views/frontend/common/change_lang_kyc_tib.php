<style type="text/css">
    .lang_bxx_selected{
        border:1px solid #dedede;
    }
    .lang_bxx
    {
        display: inline-block;
        padding:5px;
        width: 40px;
        float: right;
        margin-bottom: 10px;

    }
    .lang_bxx img{
        width: 100%;
        float: left;
    }
    .card-box
    {
        clear: both;
    }
</style>
    <div class="col-md-12 easy nopad" >



        <a title="Turkish" href="<?php echo base_url().'set-kyc-lang/tr'; ?>">
            <div class="lang_bxx <?php if($_SESSION['kyc_lang']=="tr") echo "lang_bxx_selected"; ?>">
                <img src="<?php echo base_url().'resources/frontend/images/tr.gif'; ?>">
            </div>
        </a>

        <a title="Spanish" href="<?php echo base_url().'set-kyc-lang/es'; ?>">
            <div class="lang_bxx <?php if($_SESSION['kyc_lang']=="es") echo "lang_bxx_selected"; ?>">
                <img src="<?php echo base_url().'resources/frontend/images/es.gif'; ?>">
            </div>
        </a>


        <a title="English" href="<?php echo base_url().'set-kyc-lang/en'; ?>">
            <div class="lang_bxx <?php if($_SESSION['kyc_lang']=="en") echo "lang_bxx_selected"; ?>">
                <img src="<?php echo base_url().'resources/frontend/images/en.gif'; ?>">
            </div>
        </a>
   
        
   
        
    </div>