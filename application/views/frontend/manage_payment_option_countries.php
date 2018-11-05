
<?php require_once("common/header.php");?>




    

  <?php if(ACTYPE == "1"){?>

    

   <div class="row">

         <div class="col-sm-12 m-b-30">

        <div class="button-list pull-right m-t-15">

            <a class="btn btn-default" href="javascript:addCountry();">Add Country</a>

        </div>



        <h4 class="page-title">Allowed Countries</h4>

    </div>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="card-box m-b-50">

                <div class="table-responsive">

                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">

                      <thead>

                      <tr>
                      <th>Name</th>
                      <th >Status</th>


                      <th >Tokens</th>

                      <th >Currency</th>

                      <th >Amount Paid</th>

                      <th >Status </th>

                      <th >Action</th></tr>

                      </thead>

                      <?php

              $arr = array('uID' => UID);

              $config = $this->front_model->get_query_simple('*','dev_web_transactions',$arr);

              $transctions  = $config->result_object();

                            // echo $this->db->last_query();

            ?>

                      <tbody>

                      <?php 

              foreach($transctions AS $row){

                $arrcur = array('id' => $row->currency);

                $cour = $this->front_model->get_query_simple('*','dev_web_payment_options',$arrcur);

                $currency   = $cour->result_object();

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

    <?php } ?>



<?php require_once("common/footer.php");?>

