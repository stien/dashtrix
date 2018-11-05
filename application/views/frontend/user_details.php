<?php
/**
 * Created by PhpStorm.
 * User: Mahev Stark
 * Date: 4/30/2018
 * Time: 11:47 AM
 */
?>

<?php require_once("common/header.php");

$verification_details = $this->front_model->get_query_simple('*','dev_web_user_verification',array('uID'=>$user_details->uID,'deleted'=>0))->result_object()[0];
?>
<?php

                                $arr = array('uID' => $user_details->uID);

                                $config = $this->front_model->get_query_simple('*','dev_web_transactions',$arr);

                                $transctions    = $config->result_object();

                                // echo $this->db->last_query();

                                ?>
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12 m-b-30">
        <div class="button-list pull-right m-t-15">
            <?php /*?> <button class="btn btn-default submit-form" type="button" ><span class="m-r-5"><i class="fa fa-check"></i></span>Save changes</button><?php */?>
        </div>
        <h4 class="page-title">User Details</h4>
        <hr />
    </div>
</div>



<div class="row profile-mew-design">
    <div class="col-md-12">
            <h2 class="header-title m-t-0 m-b-30" style="font-size: 25px;"><?php 
            if($user_details->uFname)

            {
                echo $user_details->uFname.' '.$user_details->uLname;
            }
            else
            {
                echo $user_details->uCompany;
            }

             ?></h2>

    </div>
    <div class="col-md-12 m-b-30 ht-160">
        <div class="col-md-2 nopad">
            <div class="profile_img" style=" height:160px; overflow: hidden;">
                <img src="<?php echo base_url().'resources/uploads/profile/'.$user_details->uImage; ?>">
            </div>
        </div>
        <div class="col-md-4 nopad ht-160">
            <div class="card-box ht-160 left">
                <div class="col-md-6 nopad" style="padding-right: 10% !important;">
                    <span class="w100p">
                        <?php echo $user_details->uAddress; ?>
                    </span>
                    <span class="w100p">
                        <?php echo $user_details->uCity; ?>
                    </span>
                    <span class="w100p">
                        <?php $country = $this->front_model->get_query_simple('*','dev_web_countries',array('id'=>$user_details->uCountry))->result_object();
                                if(empty($country)) echo "N/A";
                                else echo $country->nicename;
                                ?>
                    </span>
                   
                </div>
                
                <div class="col-md-6 nopad">
                    <span class="w100p">
                        Date Registrered: <?php echo date("m/d/y",strtotime($user_details->joinDate)); ?>
                    </span>
                    <span class="w100p">
                        <?php echo $user_details->uEmail; ?>
                    </span>
                    <span class="w100p">
                        <?php echo $user_details->uPhone; ?>
                    </span>

                    
                </div>
                
            </div>
        </div>
        <div class="col-md-4 ">
            <div class="card-box ht-160 left box_with_full_spans">

                <div class="col-md-6 text-center" >
                    <span class="big_"><?php echo custom_number_format(count($transctions),decimals_()); ?></span>
                    <span>Transactions</span>
                </div>
                <div class="col-md-6 text-center" >
                    <span class="big_"><?php echo custom_number_format(get_my_tokens($user_details->uID),decimals_()); ?></span>
                    <span>Tokens</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 nopad text-center box_with_full_spans">
            <div class="card-box ht-160 left" style="<?php if($verification_details->uStatus==2 || $user_details->kyc_verified==1)echo "background: green; color:#fff;"; else echo "background: red; color:#fff;"; ?>">
                <span class="big_"><?php if($verification_details->uStatus==2 || $user_details->kyc_verified==1)echo "Yes"; else echo "No"; ?></span>
                <span>Verified</span>
            </div>
        </div>

    </div>
</div>



<div class="row">
    <div class="col-md-12">



        <div class="card-box widget-box-1">
            <h4 class="header-title m-t-0 m-b-30"><?php echo "Transactions"; ?></h4>
            <div class="row">







                <div class="col-lg-12">

                    <div class="card-box m-b-50">

                        <div class="table-responsive">

                            <table  class="table table-actions-bar make-me-table"  style="margin-bottom: 50px !important;">

                                <thead>

                                <tr>
                                    <th>Trans. Type</th>
                                    <th >Date</th>


                                    <th >Tokens</th>

                                    <th >Currency</th>

                                    <th >Amount Paid</th>

                                    <th >Status </th>

                                    <th >Action</th></tr>

                                </thead>

                                

                                <tbody>

                                <?php

                                foreach($transctions AS $row){

                                    $arrcur = array('id' => $row->currency);

                                    $cour = $this->front_model->get_query_simple('*','dev_web_payment_options',$arrcur);

                                    $currency 	= $cour->result_object();

                                    //echo $row->datecreated;

                                    ?>

                                    <tr>

                                        <td>
                                            <?php
                                            if($row->t_type==2){
                                                echo "Completed A Survey";
                                            }
                                            else
                                            {
                                                echo "Purchased Token";
                                            }

                                            ?>
                                        </td>

                                        <td><?php echo date("m/d/y",strtotime($row->datecreated));?></td>

                                        <td><?php echo $row->tokens;?></td>

                                        <td><?php echo $currency[0]->name;?></td>

                                        <td><?php echo $row->amountPaid;?> <?php echo $row->amtType;?></td>

                                        <td><?php

                                            if($row->status == "1"){echo "<div class='status-pending'>Pending</div>";}

                                            else if($row->status == "2"){echo "<div class='status-confirm'>Confirmed</div>";}

                                            else if($row->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}

                                            else if($row->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}

                                            ?>

                                        </td>

                                        <td>

                                            <a href="<?php echo base_url().'transaction-details/'.$row->tID; ?>">

                                                <button class="btn btn-sm btn-default">

                                                    View Details

                                                </button>



                                            </a>

                                        </td>

                                    </tr>

                                <?php } ?>

                                </tbody>

                            </table>

                        </div>

                    </div>



                </div> <!-- end col -->
















            </div>
        </div>
        <div class="card-box widget-box-1">
            <h4 class="header-title m-t-0 m-b-30"><?php echo "Login History"; ?></h4>
            <div class="row">






                <div class="col-lg-12">

                    <div class="card-box m-b-50">

                        <div class="table-responsive">

                            <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">

                                <thead>

                                <tr>

                                    <th >IP</th>
                                    <th >Login Time</th>
                                    <th >Logout Time</th>
                                    <th >Time Spent</th>



                                </tr>

                                </thead>

                                <?php

                                $arr = array('uID' => $user_details->uID);

                                $config = $this->front_model->get_query_simple('*','dev_web_user_login_history',$arr);

                                $history 	= $config->result_object();

                                // echo $this->db->last_query();

                                ?>

                                <tbody>

                                <?php

                                foreach($history AS $row){



                                    //echo $row->datecreated;

                                    ?>

                                    <tr>


                                        <td><?php echo $row->ip;?></td>

                                        <td><?php echo date("m/d/y | H:i:s",strtotime($row->time));?></td>
                                        <td><?php 

                                        if($row->logged_out==1)
                                         echo date("m/d/y | H:i:s",strtotime($row->logout_time));
                                        else 
                                            echo "--";
                                        ?>
                                    </td>
                                        <td>
                                            <?php
                                                if($row->logged_out==1)
                                                {
                                                    $login_time_ = strtotime($row->time);
                                                    $logout_time_ = strtotime($row->logout_time);
                                                    $seconds = $logout_time_ - $login_time_;
                                                    $hours = floor($seconds / 3600);
                                                    $mins = floor($seconds / 60 % 60);
                                                    $secs = floor($seconds % 60);

                                                    echo $hours.':'.$mins.':'.$secs;
                                                }
                                                else
                                                {
                                                    $login_time_ = strtotime($row->time);
                                                    $now = time();
                                                    $seconds = $now - $login_time_;

                                                    if($seconds > 7200)
                                                        echo "2+ hours";
                                                    else
                                                        echo "--";

                                                }

                                             ?>

                                        </td>
                                             




                                    </tr>

                                <?php } ?>

                                </tbody>

                            </table>

                        </div>

                    </div>



                </div> <!-- end col -->
















            </div>
        </div>
        <?php /* ?>
        <div class="card-box widget-box-1">
            <h4 class="header-title m-t-0 m-b-30"><?php echo "Contact Info"; ?></h4>
            <div class="row">






                <div class="col-lg-12">



                    <div class="col-md-3">
                        <div class="form-group">
                            <b>
                                Email
                            </b>
                            <br>
                            <label>
                                <?php echo $user_details->uEmail; ?>
                            </label>

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <b>
                                Phone
                            </b>
                            <br>
                            <label>
                                <?php echo $user_details->uPhone; ?>
                            </label>

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <b>
                                County
                            </b>
                            <br>
                            <label>
                                <?php $country = $this->front_model->get_query_simple('*','dev_web_countries',array('id'=>$user_details->uCountry))->result_object();
                                if(empty($country)) echo "N/A";
                                else echo $country->nicename;
                                ?>
                            </label>

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <b>
                                Zip
                            </b>
                            <br>
                            <label>
                                <?php echo $user_details->uZip; ?>
                            </label>

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <b>
                                Address
                            </b>
                            <br>
                            <label>
                                <?php echo $user_details->uAddress; ?> &nbsp;
                                <?php echo $user_details->uAddress2; ?>
                            </label>

                        </div>
                    </div>





                </div> <!-- end col -->
















            </div>
        </div>
        <div class="card-box widget-box-1">
            <h4 class="header-title m-t-0 m-b-30"><?php echo "User Verified"; ?></h4>
            <div class="row">






                <div class="col-lg-12">



                    <div class="col-md-3">
                        <div class="form-group">
                            <b>
                                User Verified
                            </b>
                            <br>
                            <label>
                                <?php if($user_details->uverifyemail==1){ ?>
                                    <div class='status-confirm'>Yes</div>
                                <?php }else{ ?>

                                    <div class='status-cancelled'>No</div>


                                <?php } ?>
                            </label>

                        </div>
                    </div>







                </div> <!-- end col -->
















            </div>
        </div>
        <?php */ ?>


        <div class="card-box widget-box-1">
            <h4 class="header-title m-t-0 m-b-30"><?php echo "Custorm Signup Fields"; ?></h4>
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-md-3">
                        <div class="form-group">

                            <?php $c_fields = $this->front_model->get_query_simple('*','dev_web_registraton_forms_filled',array('uID'=>$user_details->uID))->result_object(); 
                
                            foreach(json_decode($c_fields[0]->data) as $key_c_fields=>$val_c_fields){
                            ?>


                            <b>
                            <?php echo $key_c_fields; ?>
                            </b>
                            <br>
                            <label>
                            <?php echo $val_c_fields; ?>
                                
                            </label>
                        <?php } if(empty(json_decode($c_fields[0]->data))){
                         ?> 
                         <b>No data available</b>

                     <?php } ?>

                        </div>
                    </div>

                </div> 
            </div>
        </div>








    </div>
    <!-- end col -->


    <!-- end col -->

</div>
<?php require_once("common/footer.php");?>
<script type="text/javascript" src="<?php echo base_url().'resources/frontend/js/jscolor.min.js' ?>"></script>

<?php if(isset($_GET['type'])){?>
    <script language="javascript">
        $("html, body").delay(400).animate({
            scrollTop: $('#passwordrequest').offset().top
        }, 2000);
    </script>
<?php } ?>
<script language="javascript">
    function confirmpassword_request(){
        if($("#newpass").val() != $("#confirmpass").val()){
            $("#upbtn").attr("disabled",true);
            $("#confirmerror").html('<div class="wrongerror">Password & New Password not matched!</div>');
        } else {
            $("#upbtn").attr("disabled",false);
            $("#confirmerror").html('');
        }
    }
</script>

<script>

    function cclick()
    {
        $("#inputfile").click();
    }
    $(function () {
        $('#inputfile').change(function () {

            $('.img').hide();


            $('.msg').text('Please Wait...');
            $('#submit_btn').prop('disabled', true);

            var myfile = $('#inputfile').val();
            var formData = new FormData();
            formData.append('inputfile', $('#inputfile')[0].files[0]);
            $('.msg').text('Uploading in progress...');
            $.ajax({
                url: '<?php echo base_url().'ico/take_image_logo'; ?>',
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',

                success: function (data) {

                    data = JSON.parse(data);

                    $('.msg').html(data.msg);


                    if(data.status==1){


                        $('.img').attr('src',data.src);
                        $('.img').show();
                        $('#submit_btn').prop('disabled', false);

                    }
                }
            });
        });
    });

    $("#remove-photo").click(function(){

        $.post('<?php echo base_url().'ico/remove_profile_pic'; ?>',{remove:true},function(){
            $('.img').attr('src','<?php echo base_url().'resources/uploads/profile/default.svg'; ?>');
            $('.img').show();
        });
    });
</script>
