<?php
/**
 * Created by PhpStorm.
 * User: Mahev Stark
 * Date: 4/30/2018
 * Time: 4:13 PM
 */
?>

<?php require_once("common/header.php");?>

<div class="row">
    <div class="col-sm-12 m-b-30">


        <h4 class="page-title">My Paid Contents</h4>
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
                        <th >Subject</th>
                        <th >Keywords</th>
                        <th >Content</th>
                        <th >Submitted at</th>

                        <th >Status </th>
                        <th >Action</th>

                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    foreach($my_paid_contents AS $row){
                        ?>
                        <tr>
                            <td title="<?php echo $row->subject;?>"><?php echo substr( $row->subject,0,10)."...";?></td>
                            <td title="<?php echo $row->keywords;?>"><?php echo substr( $row->keywords,0,100)."...";?></td>
                            <td title="<?php echo $row->content;?>"><?php echo substr( $row->content,0,100)."...";?></td>
                            <td><?php echo date("m/d/y H:i A",strtotime($row->time));?></td>
                            <td><?php
                                if($row->status == "0"){echo "<div class='status-pending'>Awaitng Payment</div>";}
                                else if($row->status == "1"){echo "<div class='status-pending'>Awaitng Approval</div>";}
                                else if($row->status == "2"){echo "<div class='status-confirm'>Published</div>";}
                                ?>
                            </td>

                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-info">Actions</button>
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo base_url().'view-paid-content/'.$row->id; ?>">View</a></li>

                                        <?php
                                        if($row->status == "0"){
                                            ?>
                                            <li><a href="javascript:;" onClick="btnstatusupdate(<?php echo $row->id;?>);">Update Payment</a></li>

                                        <?php } ?>
                                        <?php /*?><li><a href="javascript:;" onClick="btnstatusdelete(<?php echo $row->uID;?>);">Delete</a></li><?php */?>
                                    </ul>
                                </div>

                            </td>

                        </tr>



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
            window.location='<?php echo base_url(); ?>ico/update_paid_content_payment/'+id;
            return true;
        }
        else {
            return false;
        }
    }


</script>
