<?php require_once("common/header.php");?>
<div class="row">

         <div class="col-sm-12 m-b-30">


            <h4 class="page-title">Transactions


            </h4>

        </div>

    </div>
    <div class="row">

         <div class="col-sm-12">

           

           
        </div>
         <div class="col-sm-12 m-b-20">
            <div class="card-box left" style="width: 100%;">
                <div class="box_trans">
                    <div class="box_trans_">
                        <span class="box_trans_v"><?php
                            echo $total_transs_= $this->db->where('status',2)->count_all_results('dev_web_transactions');

                         ?></span>
                        <span class="box_trans_l">Transactions</span>
                    </div>
                    <div class="box_trans_">
                        <span class="box_trans_v">
                            <?php
                $this->db->select('SUM(`tokens`) AS TOKENS');
                $this->db->where('status',2);
                $query = $this->db->get('dev_web_transactions');





            $row = $query->result_object();
            
            if($row[0]->TOKENS == NULL){

               echo $sold_out_tokens= "0";

            $sold_out_tokens=0;

            } else {
                echo  custom_number_format($row[0]->TOKENS,decimals_());
                $sold_out_tokens=$row[0]->TOKENS;
            }
                             ?>
                        </span>
                        <span class="box_trans_l">Sales Volume</span>
                    </div>
                    <div class="box_trans_">
                        <span class="box_trans_v"><?php 
                            $now = time(); // or your date as well
                            $very_first_trans = $this->db->where('status',2)->order_by('tID','ASC')->limit(1)->get('dev_web_transactions')->result_object();
                             $your_date = strtotime(date("Y-m-d",strtotime($very_first_trans[0]->datecreated)));
                                $datediff = $now - $your_date;

                                $total_days= round($datediff / (60 * 60 * 24));
                            if(empty($very_first_trans))
                            {
                                echo "0";
                            }
                            else
                            {
                                echo custom_number_format($sold_out_tokens/$total_transs_,decimals_());
                            }
                            

                        ?></span>
                        <span class="box_trans_l">Average Transactions</span>
                    </div>
                    <div class="box_trans_">
                        <span class="box_trans_v"><?php

                            if(!$total_days){
                                echo "0";
                            }
                            else
                            {
                                echo number_format($total_transs_/$total_days,decimals_());
                            }
                         ?></span>
                        <span class="box_trans_l">Transactions Per Day</span>
                    </div>
                    <div class="box_trans_">
                        <span class="box_trans_v"><?php 
                           
                            if(empty($very_first_trans))
                            {
                                echo "$0";
                            }
                            else
                            {
                               
                                echo '$'.custom_number_format($sold_out_tokens/$total_days,decimals_());
                            }
                            

                        ?></span>
                        <span class="box_trans_l">Sales Volume Per Day</span>
                    </div>


                </div>
            </div>
        </div>
        <div class="col-sm-12 m-b-30">
            <div class="card-box">
 <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            </div>
        </div>

    </div>
    <div class="row" id="more_data" style="display: none;">
        <div class="col-md-12">
            <div class="card-box" style="text-align: center;">
                
                <div id="more_data_table"></div>
            </div>
        </div>
    </div>
    
<div class="row">

         <div class="col-sm-12 m-b-30">
<?php 
        $c_p_link = 'tranasctions';
        require_once 'common/import_export.php'; ?>
            <div class="button-list pull-right m-t-15 m-r-10">   
<a class="btn btn-default" href="<?php echo base_url();?>admin/export/tranasctions/csv"><i class="fa fa-download"></i> Export CSV (ReadAble)</a> 
<?php /* ?>
<a class="btn btn-default" href="<?php echo base_url();?>admin/export/users/comma"><i class="fa fa-download"></i> Export Comma Seprated</a> 
<a class="btn btn-default" href="<?php echo base_url();?>admin/export/users/tab"><i class="fa fa-download"></i> Export Tab Seprated</a> 
<?php */ ?>
</div> 

            <h4 class="page-title">All Transactions


            </h4>

        </div>

    </div>
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
    <div class="row">

        <div class="col-lg-12">

            <div class="card-box m-b-50">

               

                <div class="table-responsive">

                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">

                    	<thead>

                    	<tr>

                            <th>Trans. Type</th>

                    	<th >Name</th>
                        <?php if(am_i('securix')){ ?>
                    	   <th >Email</th>
                        <?php  }else{ ?>
                           <th >Username</th>
                        <?php } ?>

                    	<th >Tokens</th>

                    	<th >Currency</th>

                    	<th >Amount Paid</th>

                    	<th >Date</th>

                    	

                    	<th >Status </th>

                    	<th >Action</th></tr>

                    	</thead>

                    	<?php

							$arr = array();

							$config = $this->front_model->get_query_simple('*','dev_web_transactions',$arr);

							$transctions 	= $config->result_object();

						?>

                    	<tbody>

                    	<?php 

							foreach($transctions AS $row){

								$arrcur = array('curID' => $row->currency);

								$cour = $this->front_model->get_query_simple('*','dev_web_currency',$arrcur);

								$currency 	= $cour->result_object();

								//echo $row->datecreated;

								$arusr = array('uID' => $row->uID);

								$usrqry = $this->front_model->get_query_simple('*','dev_web_user',$arusr);

								$user 	= $usrqry->result_object();

						?>

                    		<tr>


                                 <td>
                                <?php

                                if($row->t_type==2){
                                    echo "Completed A Survey";
                                }
                                else if($row->t_type==30){
                                    echo "Referral Bonus";
                                }
                                else
                                {
                                    echo "Purchased Token";
                                }

                                 ?>
                             </td>

                    			<td title="<?php echo $user[0]->uFname. " ".$user[0]->uLname;?>"><?php echo substr( $user[0]->uFname. " ".$user[0]->uLname,0,10)."...";?></td>

                                <?php if(am_i('securix')){ ?>
                                   <td><?php echo $user[0]->uEmail; ?></td>
                                <?php  }else{ ?>
                                   <td><?php echo $user[0]->uUsername; ?></td>
                                <?php } ?>

                    			

                    			<td><?php echo $row->tokens;?></td>

                    			<td><?php echo $currency[0]->currencyName;?></td>

                    			<td><?php echo $row->amountPaid;?> <?php echo $row->amtType;?></td>

                    			<td><?php echo date("m/d/y",strtotime($row->datecreated));?></td>

                    			

                    			<td><?php 

										if($row->status == "1"){echo "<div class='status-pending'>Pending</div>";} 

										else if($row->status == "2"){echo "<div class='status-confirm'>Confirmed</div>";} 

										else if($row->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}

										else if($row->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}

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

                                        if($row->status == "1"){ ?>

										<li><a href="javascript:;" onClick="btnstatusupdate(2,<?php echo $row->tID;?>);">Conﬁrmed</a></li>

										<!--<li><a href="javascript:;" onClick="btnstatusupdate(1);">Pending</a></li>-->

										<li><a href="javascript:;" onClick="btnstatusupdate(3,<?php echo $row->tID;?>);">Cancelled</a></li>

										<li><a href="javascript:;" onClick="btnstatusupdate(4,<?php echo $row->tID;?>);">Refunded</a></li>

                                        <?php } ?>

                                        <li><a href="javascript:;" onclick="deletecampaign(<?php echo $row->tID;?>);">Delete</a></li>
                                        <li><a href="javascript:;" onclick="viewHash('<?php echo $row->hash;?>');">View Hash</a></li>
                                        <li><a href="<?php echo base_url().'view-transaction/'.$row->tID; ?>">View Details</a></li>


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


    <div class="modal-cs display_none delete_transaction" >
    <div class="modal-box">
        <div class="modal-heading">
            <h4 class="left">Delete Transaction</h4>

            <button onclick="closeModel();" class="btn bt-danger right" >
                <i  class="fa fa-times"></i>
            </button>
        </div>

        <div class="modal-body">
            <form method="post" action="<?php echo base_url();?>ico/delete_transaction">
                <div class="row">

                    
                    <div class="col-md-12">
                        <div style="text-align: center; background: orange; color:#fff; padding: 10px;">
                           If you delete this transaction, the statistics on the dashboard will be also affected. Please make sure before deleting this transaction.
                        </div>
                    </div>
                    <div class="col-md-6 m-t-40">
                        <div class="form-group">
                            <button class="btn btn-danger btn-block btn-lg" type="button" onclick="closeModel()">
                                Cancel
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 m-t-40">
                        <div class="form-group">
                            <input type="hidden" name="id" id="delete_trans_id" value="">
                            <button class="btn btn-default btn-block btn-lg" type="submit">
                                Continue to delete
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
    <div class="modal-cs display_none view_hash" >
    <div class="modal-box">
        <div class="modal-heading">
            <h4 class="left">View Transaction Reference</h4>

            <button onclick="closeModel();" class="btn bt-danger right" >
                <i  class="fa fa-times"></i>
            </button>
        </div>

        <div class="modal-body">
                <div class="row">

                    
                    <div class="col-md-12">
                        <h4 style="font-style: italic;" id="view_hash_place"></h4>
                    </div>
                   

                    <div class="col-md-6 m-t-40"></div>
                    <div class="col-md-3 m-t-40"></div>
                    <div class="col-md-3 m-t-40">
                        <div class="form-group">
                            <button class="btn btn-default" type="button" onclick="closeModel();">
                                Done
                            </button>
                        </div>
                    </div>

                </div>
        </div>
    </div>
</div>
<?php require_once("common/footer.php");?>

<script>
function closeModel()
{
    $(".modal-cs").hide();
}
function deletecampaign(id)
{
  $("#delete_trans_id").val(id);
  $(".delete_transaction").show();
  return; 
}










    window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    zoomEnabled: true,
    theme: "light2",
    title:{
        text: "Token Sale"
    },
    axisX:{
        valueFormatString: "DD MMM",
        crosshair: {
            enabled: true,
            snapToDataPoint: true
        }
    },
    axisY: {
        title: "Tokens sold & Transactions",
        crosshair: {
            enabled: true
        }
    },
    toolTip:{
        shared:true
    },  
    legend:{
        cursor:"pointer",
        verticalAlign: "bottom",
        horizontalAlign: "left",
        dockInsidePlotArea: true,
        itemclick: toogleDataSeries
    },
    data: [

    {

         click: function(e){
            showMore(  e.dataSeries.type,  e.dataPoint.x, e.dataPoint.y);
           },

        type: "line",
        showInLegend: true,
        name: "Total Tokens",
        markerType: "square",
        xValueFormatString: "DD MMM, YYYY",
        color: "#F08080",
        dataPoints: [

            <?php 

            for($i=30; $i>=1; $i--)
            {
                $date = date('Y-m-d',strtotime("-".$i." days"));
                $k = $i-1;
                $date_less = date('Y-m-d',strtotime("-".$k." days"));

                $this->db->where('datecreated <', $date_less);
                $this->db->where('datecreated >', $date);
                
                $users = $this->db->get('dev_web_transactions')->result_object();



                $this->db->select('SUM(`tokens`) AS TOKENS');
                $this->db->where('datecreated <', $date_less);
                $this->db->where('datecreated >', $date);

                $query = $this->db->get('dev_web_transactions');





            $row = $query->result_object();
            if($row[0]->TOKENS == NULL){
                $tokens = "0";
            } else {
                $tokens = $row[0]->TOKENS;
            }
             





                $arr_date = explode('-', $date);

                //$last_thirty_days_trans.= "[$i,$tokens], ";
                echo '{x:new Date('.date("Y",strtotime($date)).','.(date("m",strtotime($date))-1).','.date("d",strtotime($date)).'),y:'.$tokens.'},';
            }


?>
        ]
    },
    {

        click: function(e){
            showMore(  e.dataSeries.type,  e.dataPoint.x, e.dataPoint.y);
           },

        type: "line",
        showInLegend: true,
        name: "Total Transactions",
        markerType: "circle",
        xValueFormatString: "DD MMM, YYYY",
        color: "#2fd448",
        dataPoints: [

            <?php 

            for($i=30; $i>=1; $i--)
            {
                $date = date('Y-m-d',strtotime("-".$i." days"));
                $k = $i-1;
                $date_less = date('Y-m-d',strtotime("-".$k." days"));

                $this->db->where('datecreated <', $date_less);
                $this->db->where('datecreated >', $date);
                
                $users = $this->db->get('dev_web_transactions')->result_object();



               
                $this->db->where('datecreated <', $date_less);
                $this->db->where('datecreated >', $date);

                $query = $this->db->count_all_results('dev_web_transactions');





          

                $tokens = $query;


                $arr_date = explode('-', $date);

                //$last_thirty_days_trans.= "[$i,$tokens], ";
                echo '{x:new Date('.date("Y",strtotime($date)).','.(date("m",strtotime($date))-1).','.date("d",strtotime($date)).'),y:'.$tokens.'},';
            }


?>
        ]
    }
    ]
});
chart.render();

function toogleDataSeries(e){
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else{
        e.dataSeries.visible = true;
    }
    chart.render();
}

}
function viewHash(hash)
{
    if(hash=="")
        hash="Not submitted";
    $(".view_hash").find('#view_hash_place').html(hash);
    $(".view_hash").show();
}



function showMore(type,x,y){
    $("#more_data").fadeIn();
    $("#more_data .card-box").append('<div class="loading5"><img src="<?php echo base_url().'resources/frontend/images/loading.gif'; ?>" width="100px"></div>');
    $.post('<?php echo base_url().'ico/get_relevant_more_transaction_data' ?>',{type:type,x:x,y:y},function(res){
        console.log(res);
        
        $("#more_data_table").html(res);
        $("#more_data .loading5").remove();

    });
}


function btnstatusupdate(val,id){

    var x = confirm("Are you sure you want to perform this action?");

    if (x){

        window.location='<?php echo base_url(); ?>admin/do/action/tranasctions/'+val+'/'+id;

        return true;

    }

    else {

        return false;

    }

}

      </script>
      <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<style type="text/css">
    .bgorange{
        background: orange;
    }
</style>
