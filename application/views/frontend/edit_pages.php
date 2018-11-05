<?php
/**
 * Created by PhpStorm.
 * User: Mahev Stark
 * Date: 4/30/2018
 * Time: 1:55 PM
 */
?>


<?php require_once("common/header.php");?>



<div class="row">

    <div class="col-sm-12 m-b-30">
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


        



        <h4 class="page-title">Manage Registration Form</h4>

    </div>

</div>

<div class="row">

    <div class="col-lg-12">
        
     
		 <div class="button-list pull-right m-b-10 m-t-15"  style="clear: both;">

            <a class="btn btn-default" href="<?php echo base_url().'admin/new-page/'.$type; ?>"><i class="fa fa-plus"></i> Add New Page</a>

           

        </div>
         <?php 

         $c_p_link = 'pages';
         if($this->uri->segment(2)=="terms-pages")
            $c_p_link = 'pages?where=terms&there=1';
        if($this->uri->segment(2)=="privacy-pages")
            $c_p_link = 'pages?where=privacy&there=1';

            
            require_once 'common/import_export.php'; ?>
        <div class="card-box m-b-50"  style="clear: both;">

            
            <div class="table-responsive">

                <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">

                    <thead>

                    <tr>
                        <th >Page Type</th>
                        <th >Page Name</th>
                        <th >Page Title</th>
                        <th >Page Link</th>
                        <th >Page Keywords</th>
                        <th >Status</th>
                        <th >Action</th>
                    </tr>

                    </thead>

                    <?php



                    ?>

                    <tbody>

                    <?php

                    foreach($pages AS $row){
                        ?>

                        <tr>


                            <td><?php echo $row->type==1?"Link":"Text";?></td>
                            <td><?php echo $row->pName;?></td>
                            <td><?php echo $row->pTitle;?></td>
                            <td>
                                <a target="_blank" href="<?php echo $row->type==0?base_url().$row->pLink:$row->pElink;?>">
                                    <?php echo $row->type==0?$row->pLink:$row->pElink;?>
                                </a>
                            </td>
                            <td><?php echo $row->pKeyword;?></td>
                            <td>
                                 <?php 
                                        if($row->pStatus == "0"){echo "<div class='status-pending'>In-Active</div>";} 
                                        else if($row->pStatus == "1"){echo "<div class='status-confirm'>Active</div>";}
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
                                        <?php
                                        if($row->terms==1)
                                        {
                                            $type_of_page = "terms";
                                        }
                                        elseif($row->privacy==1)
                                        {
                                            $type_of_page = "privacy";
                                        }
                                        else
                                        {
                                            $type_of_page="";
                                        }

                                         ?>

                                        <li><a href="<?php echo base_url().'admin/edit-page/'.$row->pID; ?>" >Edit</a></li>
                                        <li><a href="javascript:;" onClick="btnstatusdelete(<?php echo $row->pID;?>);">Delete</a></li>
                                        <?php if($row->pStatus==0){ ?>
                                        <li><a href="<?php echo base_url().'ico/activate_page/'.$row->pID.'/'.$type_of_page; ?>" >Activate</a></li>
                                    <?php } else{ ?>
                                        <li><a href="<?php echo base_url().'ico/inactivate_page/'.$row->pID; ?>" >In-activate</a></li>
                                    <?php } ?>


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

    <?php if(ACTYPE == "1"){?>




    function btnstatusdelete(id){

        var x = confirm("Are you sure you want to Remove page");

        if (x){

            window.location='<?php echo base_url(); ?>ico/remove_page/'+id;

            return true;

        }

        else {

            return false;

        }



    }

    <?php } ?>

    $("#clciModel").click(function(){
        $("#modalTerms").show();
    });

    function closeModel()
    {
        $(".modal-cs").hide();
    }
    function showModel_box()
    {
        $("#modalTerms").show();
    }

</script>

