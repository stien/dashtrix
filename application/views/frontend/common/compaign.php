<?php 
 if($web_settings->hide_airdrop==1){ 
if($preview_admin==1)
{
	$cond = array('id'=>$preview_admin_id);
}
else
{
	$cond = array('active'=>1,'user_type'=>ACTYPE);
}


$campaign = $this->front_model->get_query_simple('*','dev_web_campaigns',$cond)->result_object()[0];


$count_all_results = $this->db->where('camp_id',$campaign->id)->where('uID',UID)->count_all_results('dev_web_camp_ans');


if(($count_all_results==0 && !isset($_SESSION['snooze_intro'])) || $preview_admin==1){

if(!empty($campaign)){

	$does_sort = $this->db->where('camp_id',$campaign->id)->where('position !=',0)->count_all_results('dev_web_camp_slides');
               
                if($does_sort>0)
                {
                    $order_by = 'position';
                }
                else
                {
                    $order_by = 'id';
                }


	$slides = $this->db->where(array('camp_id'=>$campaign->id))->order_by($order_by)->get('dev_web_camp_slides')->result_object();


	if(!empty($slides)){







?>


<div class="campaign-outer">
<div class="campaign-inner">


			<div class="c-head">
					<?php /* ?>
					<a class="right" href="<?php echo base_url().'ico/skip_intro'; ?>">
						Skip Intro <i class="fa fa-times"></i>
					</a>
					<?php */ ?>
			</div>
	
 
			
			<div class="campaign-self">
					
					
					<form method="post" action="<?php echo $preview_admin==1?current_url():base_url().'ico/submit_campaign'; ?>">
					<div class="c-body  c-1">


							<div class="c-image">
								<img src="<?php echo base_url().'resources/uploads/campaigns/'; echo $campaign->image?$campaign->image:'dummy_image.png'; ?>">
							</div>

							<h2 class="c-title">
								<?php echo $campaign->title; ?>
							</h2>

							<p class="c-description">
								<?php echo $campaign->description; ?>
							</p>
					</div>






					<!-- /////////////////////////////////////////////////////////// -->







					<?php foreach($slides as $key=>$slide){ ?>





				
					<div class="c-body  c-<?php echo $key+2; ?> display_none">


							<div class="c-image">
								<img src="<?php echo base_url().'resources/uploads/campaigns/'.$slide->image; ?>">
							</div>

							<h2 class="c-title">
								<?php echo $slide->title; ?>
							</h2>


							<?php if($slide->type==1){ ?>



							<div class="c-sections">







								 <?php 
                                $arr = array(
                                	'question_1'=>$slide->question_1,
                                	'question_2'=>$slide->question_2,
                                	'question_3'=>$slide->question_3,
                                	'question_4'=>$slide->question_4,
                                	'link_1'=>$slide->link_1,
                                	'link_2'=>$slide->link_2,
                                	'link_3'=>$slide->link_3,
                                	'link_4'=>$slide->link_4
                                );

                                for ($i=1; $i<=4; $i++) {

                                        $var_a = 'question_'.$i;
                                        $var_ = $i;

                                        $var_b = 'link_'.$var_;

                                	   
                                
                    					if($arr[$var_a]!=0)
                    					{
                    						$question = $this->front_model->get_query_simple('*','dev_web_slide_qs',array('id'=>$arr[$var_a]))->result_object()[0];
                    						if($question->attachment==0){
                    						?>


                    						<div class="c-sec c-sec-50">
                    							<label><?php echo $question->q; ?></label>
                    							<input type="text" name="questions[]" class="form-control" <?php echo $question->required==1?"required":""; ?> placeholder="<?php echo $question->placeholder; ?>">
                    						</div>

                    						<?php }else{ ?>

                    						<div class="c-sec c-sec-50">
                    							<label><?php echo $question->q; ?></label>
	                                            <input type="hidden" name="q_id_file" value="<?php echo $question->id; ?>">

                    							 <input name="inputfile" type="file" class="form-control inputfile_only_campagin"  value="" id="inputfile_<?php echo $key.'_'.$i; ?>" multiple>
	                                            <label class="msg_<?php echo $key.'_'.$i; ?>"></label>
	                                            <div class="this_take"><?php echo eas_creation__(); ?></div>
                    						</div>


                    						<?php
                    					}}
                    					else if($arr[$var_b]!=0)
                    					{

                    						$link = $this->front_model->get_query_simple('*','dev_web_slide_links',array('id'=>$arr[$var_b]))->result_object()[0];

                    						?>

                    						<div class="c-sec c-sec-50">

                    							<a target="<?php echo $link->new_tab==1?"_blank":""; ?>" href="<?php echo $link->link; ?>">
                    								<?php echo $link->text; ?>
                    							</a>
                    							
                    						</div>

                    						<?php
                    						

                    					}
                    					else{

                    						?>


	                    						<div class="c-sec c-sec-50">
	                    							&nbsp;
	                    						</div>

                    						<?php
                    					}

                    				}
                    				?>











								
							</div>


							<?php }else{ ?>


							<div class="c-sections">

								<div class="c-sec c-sec-100">
									<p class="c-description">
										<?php echo $slide->finish_description; ?>
									</p>
								</div>

								<div class="c-sec c-sec-100">

									<?php $question = $this->front_model->get_query_simple('*','dev_web_slide_qs',array('id'=>$slide->finish_question))->result_object()[0]; ?>
        							<label><?php echo $question->q; ?></label>
        							<input type="text" name="finish_question" class="form-control" <?php echo $question->required==1?"required":""; ?>>
        							<input type="hidden" name="campaign_id" value="<?php echo $campaign->id; ?>">
        						</div>


        						<div class="c-sec c-sec-100 text-center m-t-20">
        							<button class="btn btn-default " type="submit">
        								Finish <?php echo $preview_admin==1?"Preview":""; ?>
        							</button>
        						</div>
								
							</div>



							<?php } ?>

							
					</div>
					

					

			

			<?php } ?>


			</form>

















					<!-- ///////////////////////////////////////////////// -->















					<div class="c-footer">


						<div class="c-count">


						<button onclick="prev()" class="left prev prev-btn c-btn"> <i class="fa fa-arrow-left"></i> Prev.</button>


							<span class="c-ul">
								<?php 

								 
								$k = count($slides)+1;
								for($i=1; $i<=$k; $i++){

								 ?>

								 	<span class="c-li c-li-<?php echo $i; ?>">
								 		<i class=" fa fa-circle"></i>
								 	</span>
								 <?php } ?>
							</span>

							
						<button onclick="next()" class="right next next-btn c-btn">Next <i class="fa fa-arrow-right"></i></button>
						</div>



						
					</div>

					

			</div>



			

	 

</div>
</div>
<script type="text/javascript">
	var current_slide = 1;

	var allowed_next = true;

	$(".c-li").css('color','#000');

	$(".c-li-"+current_slide).css('color',"#00aaff");

	var total_slides = <?php echo count($slides)+1; ?>;
	function next()
	{
		if(!allowed_next)
			return false;

		var required = $(".c-"+current_slide).find(':input[required]');

		console.log(required);
		// return;
		var errr = 0;
		required.each(function(i,v){
			if(!required[i].value){
				$(required[i]).css('border-color','red');
				errr = 1;

			}
		});

		if(errr==1)
			return false;




		$(".c-body").hide();
		current_slide = current_slide+1;

		if(current_slide>total_slides){
			return false;
		}




		$('.c-'+current_slide).fadeIn();

		if(current_slide==total_slides){
			$(".next").hide();
		}

		$('.prev').show();

		$(".c-li").css('color','#000');

		$(".c-li-"+current_slide).css('color',"#00aaff");

	}

	function prev()
	{
		if(!allowed_next) return false;
		$(".c-body").hide();
		current_slide = current_slide-1;

		if(current_slide<1){
			return false;
		}




		$('.c-'+current_slide).fadeIn();

		if(current_slide==1){
			$(".prev").hide();
		}

		$('.next').show();

		 $(".c-li").css('color','#000');

	$(".c-li-"+current_slide).css('color',"#00aaff");
	}


</script>

<?php }}} ?>
<script type="text/javascript">
	$(function () {
$('.inputfile_only_campagin').change(function () {
	var that = $(this);
     // $(that).next().next().hide();

 
  $(that).next().text('Please Wait...');
  allowed_next = false;

  var myfile = $(that).val();
  var formData = new FormData();


   $.each($(that)[0].files, function(i, file) {
	    formData.append('inputfile[]', file);
	});

  	formData.append('id', $(that).prev().val());


  
   $('.msg').text('Uploading in progress...');
  $.ajax({
    url: '<?php echo base_url().'ico/take_campaign_image'; ?>',
    data: formData,
    processData: false,
    contentType: false,
    type: 'POST',
  
    success: function (data) {

    $(that).next().hide();
    if(data=="failed" || data=="File size max 8 MB" || data=="Invalid file format..." || data=="Please select a file..!") {
        $(that).next().html(data);
        $(that).next().show();

    }
    else {
        $('.this_take').html(data);
        $(".this_take").show();

    }
    allowed_next = true;

       
  }
});
});
});

</script>
<?php } ?>