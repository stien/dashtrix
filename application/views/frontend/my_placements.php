<?php
/**
 * Created by PhpStorm.
 * User: Mahev Stark
 * Date: 4/30/2018
 * Time: 4:54 PM
 */
?>


<?php require_once("common/header.php");?>

<div class="row">
    <div class="col-sm-12 m-b-30">
    

        <h4 class="page-title">Paid Contents</h4>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card-box m-b-50">
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
            <div class="table-responsive">
                <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">
                    <thead>
                    <tr>
                        <th >Date</th>
                        <th >Amount Paid</th>
                        <th >Order Details</th>
                        <th >Download (content)</th>
                        <th >Download (File/Image)</th>


                        <th >Status </th>
                       

                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    foreach($paid_contents AS $row){
                        $user = $this->front_model->get_query_simple('*','dev_web_user',array('uID'=>$row->uID))->result_object()[0];
                        if(!empty(explode(',',$row->publications))){
                            $all_amounts = $this->db->where_in('id',explode(',',$row->publications))->where('status',1)->get('dev_web_publications')->result_object();

                            foreach($all_amounts as $one_amount)
                                $total_amount += $one_amount->price;

                        }
                        else
                        {
                            $total_amount = 0;
                        }



                        ?>
                        <tr>
                            <td><?php echo date("m/d/y",strtotime($row->time));?></td>

                           
                            <td>$<?php echo number_format($total_amount,decimals_());?></td>




                            <td>
                                <a href="javascript:;" onclick="openModalEdit(<?php echo $row->id; ?>);">
                                    <button class="btn btn-defualt bnt-sm" type="button">
                                        <i class="fa fa-tv"></i>
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url().'download-paid-content/'.$row->id; ?>" target="_blank">
                                    <button class="btn btn-info bnt-sm" type="button">
                                        <i class="fa fa-arrow-down"></i>
                                    </button>
                                </a>
                            </td>

                            <td>
                                <?php if($row->file){ ?>
                                <a href="<?php echo base_url().'resources/uploads/marketing/'.$row->file; ?>" download>
                                    <button class="btn btn-info bnt-sm" type="button">
                                        <i class="fa fa-arrow-down"></i>
                                    </button>
                                </a>

                                <?php } ?>
                            </td>
                            <td><?php
                                if($row->status == "0"){echo "<div class='status-pending'>Awaitng Payment</div>";}
                                else if($row->status == "1"){echo "<div class='status-pending'>Pending</div>";}
                                else if($row->status == "2"){echo "<div class='status-confirm'>Submitted</div>";}
                                else if($row->status == "3"){echo "<div class='status-cancelled'>Rejected</div>";}
                                else if($row->status == "5"){echo "<div class='status-confirm'>Completed</div>";}
                                ?>
                            </td>

                           

                        </tr>

                            <div class="modal-cs display_none" id="editModel<?php echo $row->id; ?>">
                            <div class="modal-box">
                                <div class="modal-heading">
                                    <h4 class="left">Selected Publications</h4>

                                    <button onclick="closeModel();" class="btn bt-danger right" >
                                        <i  class="fa fa-times"></i>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form method="post" action="<?php echo base_url();?>ico/do_deposit_admin">
                                        <div class="row">

                                            <?php foreach($all_amounts as $one_pub){ ?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <a href="<?php echo $one_pub->link; ?>">
                                                        <img src="<?php echo base_url().'resources/uploads/marketing/'.$one_pub->logo; ?>" width="100%">
                                                    </a>
                                                </div>
                                            </div>
                                            <?php } ?>

                                            






                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div> <!-- end col -->
</div>
<?php require_once("common/footer.php");?>
<script language="javascript">

    function btnstatusupdate(id){
        var x = confirm("Are you sure you want to perform this action?");
        if (x){
            window.location='<?php echo base_url(); ?>ico/update_paid_content_status/'+id;
            return true;
        }
        else {
            return false;
        }
    }
    function btnstatusupdate2(id){
        var x = confirm("Are you sure you want to perform this action? Amount of <?php echo $total_amount; ?> will be refunded to user");
        if (x){
            window.location='<?php echo base_url(); ?>ico/reject_paid_content/'+id;
            return true;
        }
        else {
            return false;
        }
    }
    function btnstatusupdate3(id){
        var x = confirm("Are you sure you want to perform this action?");
        if (x){
            window.location='<?php echo base_url(); ?>ico/update_paid_content_status2/'+id;
            return true;
        }
        else {
            return false;
        }
    }
    function openModalEdit(id)
    {
        $(".modal-cs").hide();
        $("#editModel"+id).fadeIn();
    }
    function closeModel()
    {
        $(".modal-cs").hide();
    }

</script>

