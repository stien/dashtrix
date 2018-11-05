<?php
/**
 * Created by PhpStorm.
 * User: Mahev Stark
 * Date: 4/30/2018
 * Time: 3:09 PM
 */
?>

<?php require_once("common/header.php");?>
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12 m-b-30">
            <div class="button-list pull-right m-t-15">
                <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
            </div>
            <h4 class="page-title">Paid Content Placement</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">




                  <div class="col-md-8 col-md-offset-2">
                      <div class="col-md-12 text-center">
                        <img src="<?php echo base_url().'resources/frontend/images/content-promotions.png'; ?>">
                      </div>

                      <div class="col-md-12">
                          <h4 class="clr293D68">Step 1 of 3: Select Publications</h4>
                          <p>
                              Choose the publications you would like to place
                              Place your content on. Accepted content types include
                              Press releases, expert/opinion articles on trending
                              Industry topics, videos or infographics

                          </p>
                      </div>
                      </div>


        </div>
        <!-- end col -->

        <div class="col-md-6">
            <form method="post" action="">

                <div class="card-box widget-box-1 easy m-b-0">
                    <?php

                        foreach($publications as $publication){
                    ?>

                            <div class="col-md-3 bb-pc-box ">
                                <img  class="" src="<?php echo base_url().'resources/uploads/marketing/'.$publication->logo; ?>">


                                <div class="form-group text-center">
                                    <label class="text-center" >
                                        <input type="checkbox" value="<?php echo $publication->id; ?>" name="publication[]"  onclick="update_final(this,'<?php echo $publication->price; ?>')">
                                        <?php echo '$'.$publication->price; ?>
                                    </label>
                                </div>
                            </div>
                            <?php } ?>
                </div>
                <div class="display_final">
                    $<span>0.00</span>
                </div>
                <div class="next-walabtn">
                    <button class="btn btn-default btn-sm" name="post">
                        Next
                    </button>
                </div>
            </form>

        </div>
        <!-- end col -->

    </div>
<?php require_once("common/footer.php");?>
<script>
    function update_final(that,price)
    {
        price = parseFloat(price);

        // console.log(price);return;


        var old_price = $(".display_final").find('span').text();

        old_price = parseFloat(old_price);

        if($(that).is(':checked'))
        {
            var final_price = old_price+price;

        }
        else {
            if(old_price>0)
            var final_price = old_price-price;
            else
                final_price = old_price;

        }


        $(".display_final").find('span').html(final_price);

    }
</script>

<style>
    .bb-pc-box{
        min-height: 80px;
        text-align: center;
    }

</style>
