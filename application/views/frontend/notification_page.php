<?php require_once("common/header.php");?>
    <div class="row">
         <div class="col-sm-12 m-b-30">
        <h4 class="page-title">Notifications</h4>
    </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box m-b-50">
                <div class="table-responsive">
                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">
                    	<thead>
                    	<tr>
                    	<th >Subject</th>
                        <th >Date</th>
                    	<th >Time</th>
                    	<th >Notification</th>
                    	</tr>
                    	</thead>
                    	<tbody>
                    	<?php 

                        if(ACTYPE==1){
                            $arr = array('uID'=>0);

                        }
                        else{
                            $arr = array('uID'=>UID);

                        }

							$config 	= $this->front_model->get_query_orderby('*','dev_web_notfiications',$arr,'nID','DESC');
							$notifications 	= $config->result_object();
							
							foreach($notifications as $row){
						?>
                    		<tr>
                    			<td><?php echo $row->nSubject;?></td>
                                <td><?php echo date("m/d/y",strtotime($row->nDate));?></td>
                    			<td><?php echo date("H:i a",strtotime($row->nDate));?></td>
                    			<td><?php echo $row->nData;?></td>
                    		</tr>
                    	<?php } ?>
                    	</tbody>
                    </table>
                </div>
            </div>

        </div> <!-- end col -->
    </div>




<?php require_once("common/footer.php");?>
