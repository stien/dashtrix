<?php require_once("common/header.php");?>

  <?php if(ACTYPE == "1"){?>

    

   <div class="row">

         <div class="col-sm-12 m-b-30">

        <div class="button-list pull-right m-t-15">

            <a class="btn btn-default" href="<?php echo base_url().'admin/add-ico-milestone/step-1'; ?>">Add ICO Milestone</a>

        </div>

        <?php 
        $c_p_link = 'ico-milestones';
        require_once 'common/import_export.php'; ?>

        <h4 class="page-title">ICO Milestones</h4>

    </div>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="card-box m-b-50">
              Setting your campaign milestones is a very helpful tool to keep track of your campaign at any time in the main dashboard. Based on the values you enter below, ICODash will keep track of your status in real time and provide you with useful charts and progress indicators on your main dashboard page. 
<br>
<span style="font-style: italic;">
*Setting Campaign Milestones is not required to run your campaign. 
</span>

            </div>
            <div class="card-box m-b-50">
            
<span style="font-style: italic;">
*Milestones tied to their campaigns become active/inactive themselves when campaign(s) is/are active/inactive
</span>

            </div>
            <div class="card-box">

                <div class="table-responsive">

                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">

                      <thead>

                      <tr>
                      <th>Campaign</th>
                      <th >Total Funding (USD)</th>
                      <th >Minimum Funding (USD)</th>
                      <th ># of tokens sold</th>
                      <th >Created At </th>
                      <th >Status </th>
                      <th >Action</th></tr>

                      </thead>

                    
                      <tbody>

                      <?php 

              foreach($ico_milestones AS $row){

                $arrcur = array('id' => $row->campaign);

                $cour = $this->front_model->get_query_simple('*','dev_web_ico_settings',$arrcur);

                $camp   = $cour->result_object();

                //echo $row->datecreated;

            ?>

                        <tr>

                          <td>
                             <?php echo $camp[0]->title; ?>
                             </td>

                                <td>
                               $<?php echo $row->total_funding; ?>
                             </td>


                          <td>$<?php echo $row->min_funding; ?></td>

                          <td><?php echo $row->tokens_sold; ?></td>
                          <td><?php echo date("m/d/y",strtotime($row->datecreated));?></td>
                       
                          <td><?php 

                    if($row->status == "0"){echo "<div class='status-pending'>In-Active</div>";} 

                    else if($row->status == "1"){echo "<div class='status-confirm'>Active</div>";} 

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
                                        <li>
                                          <a href="<?php echo base_url().'admin/edit-ico-milestone/'.$row->id; ?>" >Edit</a>
                                        </li>
                                        
                                        <li>
                                          <a href="javascript:;" onClick="btnstatusupdate(<?php echo $row->id;?>);">Delete</a>
                                        </li>

                                        <?php /* if($row->status==1 && 2==3){ ?>
                                          <li>
                                            <a href="javascript:;" onClick="btnstatusupdate2(2,<?php echo $row->id;?>);">Completed</a>
                                          </li>
                                          <li>
                                            <a href="javascript:;" onClick="btnstatusupdate2(3,<?php echo $row->id;?>);">Cancelled</a>
                                          </li>
                                        <?php } */ ?>
                                        
                                       
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

    <?php } ?>



<?php require_once("common/footer.php");?>

<script type="text/javascript">
  <?php if(ACTYPE == "1"){?>
    function btnstatusupdate(id){ var x = confirm("Are you sure you want to perform this action?"); if (x){   window.location='<?php echo base_url(); ?>admin/delete-ico-milestone/'+id;    return true;  } else {    return false; }}


     function btnstatusupdate2(val,id){ var x = confirm("Are you sure you want to perform this action?"); if (x){   window.location='<?php echo base_url(); ?>ico/milestone_status/'+val+'/'+id;    return true;  } else {    return false; }}


<?php } ?></script>