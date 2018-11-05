<?php require_once("common/header.php");?>
 
    <div class="row">
         <div class="col-sm-12 m-b-30">
        <div class="button-list pull-right m-t-15">




             <a class="btn btn-default" href="<?php echo base_url();?>admin/arrange-slides/<?php echo $id; ?>"><i class="fa fa-bars"></i> Re-Arrange</a>
            <a class="btn btn-default" href="<?php echo base_url();?>admin/add/slide/<?php echo $id; ?>"><i class="fa fa-plus"></i> Add New Slide</a>
            

        </div>

        <?php 
        $c_p_link = 'camp-slides';
        require_once 'common/import_export.php'; ?>

        <h4 class="page-title">MANAGE CAMPAIGN SLIDES</h4>
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
                                <th >Sort Order</th>
                            	<th >Title</th>
                            	<th >Type</th>
                            	<th >Section 1</th>
                            	<th >Section 2</th>
                            	<th >Section 3</th>
                            	<th >Section 4</th>
                            	<th >Action</th>
                            </tr>
                    	</thead>
                    	<?php
							 
						?>
                    	<tbody>
                    	<?php 
							foreach($slides AS $ky=>$row){
								// if($row->type)

								
								
								 
						?>
                    		<tr>
                                <td ><?php echo $ky+1; ?></td>
                    			<td title="<?php echo $row->title; ?>"><?php echo substr($row->title,0,20); ?></td>

                                <td><?php 
                                        if($row->type == "1"){echo "<div class='status-confirm'>Standard</div>";} 
                                        else if($row->type == "2"){echo "<div class='status-pending'>Finish</div>";} 
                                        
                                    ?>
                                </td>



                                <?php 
                                $arr = array(
                                	'question_1'=>$row->question_1,
                                	'question_2'=>$row->question_2,
                                	'question_3'=>$row->question_3,
                                	'question_4'=>$row->question_4,
                                	'link_1'=>$row->link_1,
                                	'link_2'=>$row->link_2,
                                	'link_3'=>$row->link_3,
                                	'link_4'=>$row->link_4
                                );

                                for ($i=1; $i<=4; $i++) {

                                        $var_a = 'question_'.$i;
                                        $var_ = $i;

                                        $var_b = 'link_'.$var_;

                                	   
                                
                    					if($arr[$var_a]!=0)
                    					{
                    						$question = $this->front_model->get_query_simple('*','dev_web_slide_qs',array('id'=>$arr[$var_a]))->result_object()[0];
                    						echo "<td title='".$question->q."'>";
                    						echo "Q: ".substr($question->q,0,20);
                    						echo strlen($question->q)>20?"...":"";

                    						echo "</td>";
                    					}
                    					else if($arr[$var_b]!=0)
                    					{

                    						$link = $this->front_model->get_query_simple('*','dev_web_slide_links',array('id'=>$arr[$var_b]))->result_object()[0];
                    						echo "<td title='".$link->text."'>";
                    						echo "<a target='_blank' href='".$link->link."' >Link: ".substr($link->text,0,20);

                    						echo "</a>";
                    						echo strlen($link->q)>20?"...":"";

                    						echo "</td>";

                    					}
                    					else{
                    						echo "<td>";
                    						echo "--";
                    						echo "</td>";

                    					}

                    				}
                    				?>




                             

                    		 
                    			
                    			
                    			<td>
                    				
                    				<div class="btn-group">
									  <button type="button" class="btn btn-info">Actions</button>
									  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="caret"></span>
										<span class="sr-only">Toggle Dropdown</span>
									  </button>
									  <ul class="dropdown-menu">
									  	
										<li><a href="<?php echo base_url().'admin/edit-campaign-slide/'.$row->id; ?>" >Edit</a></li>
										
										<li><a href="javascript:;" onClick="btnstatusupdate(1,<?php echo $row->id;?>);">Delete</a></li>
										
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
<?php if(ACTYPE == "1"){?>
function btnstatusupdate(val,id){
	var x = confirm("Are you sure you want to perform this action?");
	if (x){
		window.location='<?php echo base_url(); ?>ico/delete_camp_slide/'+id;
		return true;
	}
	else {
		return false;
	}
}
<?php } ?>
</script>
