<?php include("common/header.php");

$path_to_varification = base_url().'resources/uploads/verification/';
?>

<style type="text/css">
    .taking_image img{
      float: left;
    
}
.easy{
    float: left;
    width: 100%;
}
.mt-10{
    margin-top: 10px;
}
.w-auto{
    width: auto !important;
}
label{
    float: left;
    width: 100%;
    font-weight: bold !important;
}
.parent_image{
    position: relative;
    float: left;
    padding: 2px;
    border:1px solid;
    width: 150px;
    height: 150px;
    overflow: hidden;
    margin-right: 10px;
    margin-bottom: 10px;
}
.parent_image .view{
        position: absolute;
    right: 0;
    background: #1cba33;
    font-size: 21px;
    height: 25px;
    width: 30px;
    color: #fff;
    top: 0;
    text-align: center;
}
.parent_image .download{
        position: absolute;
    right: 22%;
    background: #1cba33;
    font-size: 21px;
    height: 25px;
    width: 30px;
    color: #fff;
    top: 0;
    text-align: center;
}

</style>
<?php 
function value_help($key)
{
    // if(set_value($key))
    //     return set_value($key);
    // if($verification->$key)
        return $verification->$key;
    // if($user->$key)
    //     return $user->$key;
}



$verification_document = $this->db->where('v_id',$verification->id)
->where('parent',0)
->where('type','parent')
->get('dev_web_verification_docs')
->result_object()[0];

 ?>

<div class="wrapper-page w-full">

   

                   

<form method="POST" action="" accept-charset="UTF-8" id="personal-info">
<div class="row">
<div class="col-md-12">
    <div class="col-md-6 nopad">
 <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php $title = "Basic Information"; ?>
                   
                      <span class="signupformd"><?php echo $title;?></span>
                    
                  


                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name </label>
                                            <span class="view_data">
                                                <?php echo $verification->uFname; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name </label>
                                            <span class="view_data">
                                                <?php echo $verification->uLname; ?>
                                            </span>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Middle Name</label>
                                            <span class="view_data">
                                                <?php echo $verification->uMname; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date of Birth </label>
                                            <span class="view_data">
                                                <?php echo $verification->uDOB; ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone Number </label>
                                            <span class="view_data">
                                                <?php echo $verification->uPhone; ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Employment or Occupation </label>
                                            <span class="view_data">
                                                <?php echo $verification->uEmployment; ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Approx. Annual Gross Income (USD)</label>
                                            <span class="view_data">
                                                $<?php echo $verification->uGross; ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>How much USD does this user want to contribute?</label>
                                            <span class="view_data">
                                                $<?php echo $verification->uContribute; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Ethereum Address</label>
                                            <span class="view_data">
                                                <?php echo $verification->uETH; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


</div>
<div class="col-md-6 nopad">
 <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php $title = "Address"; ?>

                      <span class="signupformd"><?php echo $title;?></span>

                               
                                 

                                <div class="row">
                                   <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Country </label>
                                           
                                                <?php 
                                                $countries = $this->front_model->get_query_simple('*','dev_web_countries',array('id'=>$verification->uCountry))->result_object();
                                                foreach($countries as $country)
                                                {
                                                   
                                                ?>
                                            <span class="view_data">

                                                   <?php echo $country->nicename; ?>
                                               </span>
                                                <?php } ?>
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Zip Code </label>
                                            <span class="view_data">
                                           <?php echo $verification->uZip; ?>
                                       </span>
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City </label>
                                            <span class="view_data">
                                            <?php echo $verification->uCity; ?>
                                        </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>State/Province </label>
                                            <span class="view_data">
                                            <?php echo $verification->uState; ?>
                                        </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Street </label>
                                            <span class="view_data">
                                            <?php echo $verification->uStreet; ?>
                                        </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Apartment </label>
                                            <span class="view_data">
                                            <?php echo $verification->uApartment; ?>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>

<div class="row">
    <div class="col-md-12">
 


<div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php $title = "Documents"; ?>

                      <span class="signupformd"><?php echo $title;?></span>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Document Type </label>
                                            <span class="view_data">
                                                <?php if($verification_document->document_type==1)
                                                echo "National ID Card";
                                                if($verification_document->document_type==2)
                                                echo "Passport";
                                                if($verification_document->document_type==3)
                                                echo "Driving Licence";
                                                 ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Including Country </label>
                                            
                                                <?php
                                                echo $verification_document->including_country;
                                                $countries = $this->front_model->get_query_simple('*','dev_web_countries',array('id'=>$verification_document->including_country))->result_object();
                                                foreach($countries as $country)
                                                {
                                                ?>
                                            <span class="view_data">
                                                    <?php echo $country->nicename; ?>
                                                </span>
                                                <?php } ?>
                                            
                                        </div>
                                    </div>



                                    
                                    
                                    <div class="col-md-6">
                                        <div class="form-group taking_image">
                                            <label>Document Front   </label>
                                            
                                            <?php if($verification_document->doc_front){
                                                $doc_front = base_url().'resources/uploads/verification/'.$verification_document->doc_front;
                                             ?>
                                                <div class="parent_image">
                                                <img data-id="front" src="<?php echo $doc_front; ?>" class="">
                                                <a class="view" href="<?php echo $doc_front; ?>" target="_blank">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a class="download" download href="<?php echo $doc_front; ?>">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                </div>
                                            <?php }else { echo "<br>Not Submitted"; } ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group taking_image">
                                            <label>Document Back   </label>
                                           <?php if($verification_document->doc_back){ 
                                            $doc_back = base_url().'resources/uploads/verification/'.$verification_document->doc_back;
                                            ?>
                                            <div class="parent_image">
                                            <img data-id="back" src="<?php echo $doc_back; ?>" class="">
                                            <a class="view" href="<?php echo $doc_back; ?>" target="_blank">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a class="download" download href="<?php echo $doc_back; ?>">
                                                <i class="fa fa-download"></i>
                                            </a>
                                            </div>
                                        <?php }else { echo "<br>Not Submitted"; } ?>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <hr>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group taking_image">
                                            <label>Selfie with Document Identity / Passport   </label>
                                            <?php

                                            $selfies = $this->front_model->get_query_simple('*','dev_web_verification_docs',array(
                                                'type'=>'selfie',
                                                'parent'=>$verification_document->id
                                            ))->result_object();
                                            foreach($selfies as $selfie){
                                                $selfie_ = base_url().'resources/uploads/verification/'.$selfie->selfie;
                                             ?>
                                                <div class="parent_image">

                                            <img data-id="selfie" src="<?php echo $selfie_; ?>" class="">
                                            <a class="view" href="<?php echo $selfie_; ?>" target="_blank">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a class="download" download href="<?php echo $selfie_; ?>">
                                                <i class="fa fa-download"></i>
                                            </a>
                                            </div>

                                            <?php } if(empty($selfies)) { echo "<br>Not Submitted"; } ?>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <hr>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group taking_image">
                                            <label>Proof of address e.g Utility Bills or Driving Licence   </label>
                                            <?php

                                            $bills = $this->front_model->get_query_simple('*','dev_web_verification_docs',array(
                                                'type'=>'bill',
                                                'parent'=>$verification_document->id
                                            ))->result_object();
                                            foreach($bills as $bill){
                                                $bill_ = base_url().'resources/uploads/verification/'.$bill->bill;
                                             ?>
                                       <div class="parent_image">

                                            <img data-id="bill" src="<?php echo $bill_; ?>" class="">
                                            <a class="view" href="<?php echo $bill_; ?>" target="_blank">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a class="download" download href="<?php echo $bill_; ?>">
                                                <i class="fa fa-download"></i>
                                            </a>
                                            </div>

                                            <?php } if(empty($bills)) { echo "<br>Not Submitted"; }  ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

</div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php if($verification_document->doc_front){
            $img___ = $path_to_varification.$verification_document->doc_front;
            $name___ = "Document Front";
            echo nice_img_view($name___,$img___);
        }

        if($verification_document->doc_back){
            $img___ = $path_to_varification.$verification_document->doc_back;
            $name___ = "Document Back";
            echo nice_img_view($name___,$img___);
        }





        ?>
        
    </div>
</div>
                                   




                               

                                   

                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">
                                            <a href="<?php echo base_url().'admin/user/verifications';  ?>">
                                            <button type="button" id="verification" class="btn btn-default btn-block btn-lg" >

                                               Back to user verifications

                                            </button>
                                        </a>

                                        </div>

                                    </div>

                                   

                              

</form>

             

</div>



<script>

    var resizefunc = [];

</script>

<?php include("common/footer.php");?>
<script type="text/javascript">
    $(document).ready(function(){
        $('input').prop('readonly',true);
    });
    $('input').click(function(){
        $(this).select();
    });
</script>




</body>

</html>

