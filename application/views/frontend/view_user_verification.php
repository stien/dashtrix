<?php 
if(!$pdf_view)
include("common/header.php");
else
include("common/css_include.php");


$path_to_varification = base_url().'resources/uploads/verification/';
$pdf_icon = base_url().'resources/frontend/images/pdf_small.png';
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
.view_data{
    float: left;
    width: 100%;
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

$self_user = $this->db->where('uID',$verification->uID)->get('dev_web_user')->result_object()[0];
$active_api = $this->db->where('active',1)->get('dev_web_kyc_apis')->result_object()[0];
 ?>

<div class="wrapper-page w-full">

   

                   
<?php if($active_api=="IDMIND" || $active_api=="" || $active_api=="STANDARD"){ ?>
<form method="POST" action="" accept-charset="UTF-8" id="personal-info">
<div class="row">
<div class="col-md-12">
    <div class="col-md-6 ">
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
                                            <label>Source of income </label>
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
<div class="col-md-6 ">
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
            if(get_extension($verification_document->doc_front)!='pdf'){
                $img___ = $path_to_varification.$verification_document->doc_front;
                $link___ = $img___;
            }
            else{
                $img___ = $pdf_icon;
                $link___ = $path_to_varification.$verification_document->doc_front;
            }


            $name___ = "Document Front";
            echo nice_img_view($name___,$img___,$link___);
        }

        if($verification_document->doc_back){
            if(get_extension($verification_document->doc_back)!='pdf')
            {          
                $img___ = $path_to_varification.$verification_document->doc_back;
                $link___ = $img___;
            }
            else
            {
                $img___ = $pdf_icon;
                $link___ = $path_to_varification.$verification_document->doc_back;
            }

            $name___ = "Document Back";
            echo nice_img_view($name___,$img___,$link___);
        }


        $selfies = $this->front_model->get_query_simple('*','dev_web_verification_docs',array(
            'type'=>'selfie',
            'parent'=>$verification_document->id
        ))->result_object();
        foreach($selfies as $selfie){
            if(get_extension($selfie->selfie)!='pdf'){
                $img___ = $path_to_varification.$selfie->selfie;
                $link___ = $img___;
            }
            else{
                $img___ = $pdf_icon;
                $link___ = $path_to_varification.$selfie->selfie;
            }

            $name___ = "Selfie with Doc.";
            echo nice_img_view($name___,$img___,$link___);
        }

        $bills = $this->front_model->get_query_simple('*','dev_web_verification_docs',array(
            'type'=>'bill',
            'parent'=>$verification_document->id
        ))->result_object();
        foreach($bills as $bill){
            if(get_extension($bill->bill)!='pdf'){
                $img___ = $path_to_varification.$bill->bill;
                $link___ = $img___;
            }
            else{
                $img___ = $pdf_icon;
                $link___ = $path_to_varification.$bill->bill;
            }

            $name___ = "Address Proof";
            echo nice_img_view($name___,$img___,$link___);
        }

        ?>
        
    </div>
</div>
                                   




                               

                                   
                        
                                    <div class="row">
                                    <div class="col-md-6 col-md-offset-3 m-t-40 text-center">
                                         <?php if(!$pdf_view){ ?>
                                        <div class="form-group">
                                            <a href="<?php echo base_url().'admin/user/verifications';  ?>">
                                                <button type="button" id="verification" class="btn btn-default  " >
                                                   <i class="fa fa-arrow-left"></i> 
                                                   Go Back

                                                </button>
                                            </a>
                                            <a href="<?php echo base_url().'ico/view_user_verification_pdf/'.$verification->id;  ?>">
                                                <button type="button" class="btn btn-primary  " >

                                                   <i class="fa fa-file-pdf-o"></i> Save

                                                </button>
                                            </a>

                                        </div>
                                    <?php } ?>

                                    </div>
                                    </div>

                                   

                              

</form>
<?php }else{ ?>
    <div class="row">
<div class="col-md-12">
    <div class="col-md-6 ">
 <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php $title = "Information"; ?>
                   
                      <span class="signupformd"><?php echo $title;?></span>
                    
                    <?php $data_api = (array) json_decode($self_user->kyc_mind);
                    $data_api_form = $data_api['form_data'];
                    $data_api_form =(array) $data_api_form;
                   
                     ?>


                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name </label>
                                            <span class="view_data">
                                                <?php echo $data_api_form['full_name']; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name </label>
                                            <span class="view_data">
                                                <?php echo $data_api_form['last_name']; ?>
                                            </span>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email </label>
                                            <span class="view_data">
                                                <?php echo $data_api_form['email']; ?>
                                            </span>
                                        </span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date of Birth </label>
                                            <span class="view_data">
                                                <?php echo $data_api_form['dob']; ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone Number </label>
                                            <span class="view_data">
                                                <?php echo $data_api_form['phone_code'].' '.$data_api_form['phone']; ?>
                                            </span>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Country </label>
                                            <span class="view_data">
                                                <?php echo $data_api_form['country']; ?>
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
        <?php 
            $name___ = "Selfie";
            echo nice_img_view($name___,$data_api_form['selfie'],$data_api_form['selfie']);

             $name___ = "Type ".$data_api_form['docType'];
             $name___ .= " Country ".$data_api_form['docCountry'];
            echo nice_img_view($name___,$data_api_form['scanData'],$data_api_form['scanData']);
       

        

        ?>
        
    </div>
</div>
    <?php } ?>

             

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

