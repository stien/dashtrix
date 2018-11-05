<?php
/**
 * Created by PhpStorm.
 * User: Mahev Stark
 * Date: 4/30/2018
 * Time: 1:13 PM
 */
?>

<?php require_once("common/header.php");?>

<div class="row">
    <div class="col-sm-12 m-b-30">
        <h4 class="page-title">Manage Banned Countries</h4>
    </div>
</div>

<div class="row">

<div class="col-lg-12">
<div class="card-box m-b-50">    
<?php
$kyc_aml = $this->front_model->get_query_simple('*','dev_web_kyc_aml',array('id'=>1))->result_object()[0];
if($kyc_aml->ban_country==1){
?>
	<div class="form-group"  style="margin-bottom: 0;">
		<label style="text-transform: uppercase; font-weight: bold;"><strong>Disable "Country Ban"</strong></label>
		<a href="<?php  echo base_url().'ico/disable_cb'; ?>">
			<button  type="button" class="btn btn-primary right">Disable</button>
		</a>
	</div>
<?php }else{ ?>
	<div class="form-group nopad" style="margin-bottom: 0;">
		<label  style="text-transform: uppercase; font-weight: bold;"><strong>Enable "Country Ban"</strong></label>
		<a href="<?php echo base_url().'ico/enable_cb'; ?>">
		<button type="button" class="btn btn-primary right">Enable</button>
		</a>
	</div>
	<div class="modal-cs display_none" id="modal3">
		<div class="modal-box">
			<div class="modal-heading">
				Please select one

				<button onclick="closeModel();" class="btn bt-danger right" >
					<i  class="fa fa-times"></i>
				</button>
			</div>

			<div class="modal-body">
				<form method="post" action="">
					<div class="row">

						<div class="col-md-6 col-md-offset-3 m-t-40">
							<div class="form-group">


								<a href="<?php echo base_url().'ico/enable_cb'; ?>">

									<button class="btn btn-default btn-block btn-lg" type="button" name="submit">
										Enable
									</button>

								</a>


							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>
</div>
       <div class="button-list pull-right m-b-10 m-t-15" style="clear: both;">
					<a class="btn btn-default" href="javascript:;" onclick="showModel_box()"><i class="fa fa-plus"></i> Add New Country</a>
                    <a class="btn btn-default" href="javascript:;" onclick="showModel_boxIP()"><i class="fa fa-plus"></i> Add New IP</a>

                    
				</div>

            <?php 
        $c_p_link = 'banned-countries';
        require_once 'common/import_export.php'; ?>
        <div class="card-box m-b-50" style="clear:both;">
           
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
            <div class="table-responsive" >
                
                <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">
                    <thead>
                    <tr>
                        <th >Name/IP</th>
                        <th >Type</th>
                        <th >Action</th>
                    </tr>

                    </thead>

                    <?php



                    ?>

                    <tbody>

                    <?php

                    	foreach($banned_countries AS $row){
                        $arucon = array('id' => $row->cID);
                        $conqry = $this->front_model->get_query_simple('*','dev_web_countries',$arucon);
                        $con 	= $conqry->result_object()[0];
                     ?>
                     <tr>


                            <td><?php echo $row->type=='country'?$con->nicename:$row->ip;?></td>
                            <td><?php echo strtoupper($row->type); ?></td>




                            <td>



                                <div class="btn-group">

                                    <button type="button" class="btn btn-info">Actions</button>

                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        <span class="caret"></span>

                                        <span class="sr-only">Toggle Dropdown</span>

                                    </button>

                                    <ul class="dropdown-menu">


                                        <li><a href="javascript:;" onClick="btnstatusdelete(<?php echo $row->id;?>);">Delete</a></li>


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


function closeModel()
{
     $(".modal-cs").hide();
}

function openModal()
{

	 $("#modalTerms").fadeIn();

    


   
}
function openModal2()
{

    $("#modalCapm").fadeIn();





}

function openModal3()
{
    $("#modal3").fadeIn();
}

    function btnstatusdelete(id){

        var x = confirm("Are you sure you want to Remove this?");

        if (x){

            window.location='<?php echo base_url(); ?>ico/remove_banned_country/'+id;

            return true;

        }

        else {

            return false;

        }



    }

    <?php } ?>

    function closeModel()
    {
        $(".modal-cs").hide();
    }
    function showModel_box()
    {
        $("#modalTerms").show();
    }
    function showModel_boxIP()
    {
        $("#modalIP").show();
    }

</script>


<div class="modal-cs display_none" id="modalTerms">
    <div class="modal-box">
        <div class="modal-heading">
            Add New Country

            <button onclick="closeModel();" class="btn bt-danger right" >
                <i  class="fa fa-times"></i>
            </button>
        </div>

        <div class="modal-body">
            <form method="post" action="">
                <div class="row">






                    <div class="col-md-6 col-md-offset-3 m-t-40">
                        <div class="form-group">

                            <select class="form-control" name="country">

                            <?php

                            $arucon = array();

                            $conqry = $this->front_model->get_query_simple('*','dev_web_countries',$arucon);

                            $conts 	= $conqry->result_object();

                            foreach($conts as $cont){
                            ?>
                                <option value="<?php echo $cont->id; ?>"><?php echo $cont->nicename; ?></option>

                            <?php } ?>


                            </select>
                            <input type="hidden" name="type" value="country">

                        </div>
                    </div>

                    <div class="col-md-6 col-md-offset-3 m-t-40">
                        <div class="form-group">



                                <button class="btn btn-default btn-block btn-lg" type="submit" name="submit">
                                    Add
                                </button>


                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal-cs display_none" id="modalIP">
    <div class="modal-box">
        <div class="modal-heading">
            Add New IP

            <button onclick="closeModel();" class="btn bt-danger right" >
                <i  class="fa fa-times"></i>
            </button>
        </div>

        <div class="modal-body">
            <form method="post" action="">
                <div class="row">






                    <div class="col-md-6 col-md-offset-3 m-t-40">
                        <div class="form-group">

                            <input class="form-control" name="ip" value="" required="">
                            <input type="hidden" name="type" value="ip">


                        </div>
                    </div>

                    <div class="col-md-6 col-md-offset-3 m-t-40">
                        <div class="form-group">



                                <button class="btn btn-default btn-block btn-lg" type="submit" name="submit">
                                    Add
                                </button>


                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
