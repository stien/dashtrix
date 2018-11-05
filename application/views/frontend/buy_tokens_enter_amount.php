<?php require_once("common/header.php");


?>

  

      <div class="row">

        <div class="col-md-3"></div>
        <div class="col-md-6">

          <div class="box-buy-tokens-old">
              
            <h2 class="text-center">Enter Token Amount</h2>
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
                    <div class="errornotification">
                        <?php echo $_SESSION['error'];?>
                    </div>
                </div>
            </div>
            <?php } ?>

            <form method="post" action="">
              <?php
                if($type==1)
                    $type=1;
                elseif($type==2)
                    $type=3;
                elseif($type==3)
                    $type=2;

               ?>
                <?php $cryptos = $this->front_model->get_query_simple('*','dev_web_payment_options',array('active'=>1,'type'=>$type))->result_object(); ?>

                <div class="form-group">
                  <label><?php echo get_lang_msg("i_want_to_buy_tokens_using"); ?>:</label>
                  <select class="form-control" required name="currency">
                    <?php foreach($cryptos as $crypto){ ?>
                      <option value="<?php echo $crypto->id; ?>"><?php echo $crypto->name;  ?> (<?php echo $crypto->c_name; ?>)</option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label><?php echo get_lang_msg("amount_of_tokens"); ?>:</label>
                 <input class="form-control" type="number" step="0.1" name="amount_of_tokens" required>
                </div>


                 <div class="form-group">

                        <button id="i_agree" class="btn btn-default pull-right " type="submit" name="submit" value="1">
                            <?php echo get_lang_msg("confirm"); ?>
                        
                        </button>
                        <a href="<?php echo base_url().'better-luck-next-time'; ?>">
                            <button class="btn btn-danger pull-right m-r-10" type="button">
                            <?php echo get_lang_msg("cancel");
                             ?>

                            </button>
                        </a>

                    </div>
                           
             </form>
          </div>

        </div>

<?php require_once("common/footer.php");?>
