<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php 

						$title = "ADD NEW CAMPAING SLIDE - ADMIN";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Title <sup>*</sup> <i class="fa fa-info info-tip" title="This will be shown as heading of this slide"></i></label>

                                            <input name="title" type="text" class="form-control" value="<?php  echo $slide->title;?>" required autofocus>

                                            <input type="hidden" name="camp_id" value="<?php  echo $slide->camp_id;?>">

                                        </div>

                                    </div>

                                    

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Slide Type <sup>*</sup></label>

                                            

                                            <select class="form-control" name="type" required onchange="javascript:show_prespective_div(this)">

                                            <option selected="selected" disabled="disabled" hidden="hidden" value="">Choose</option>

                                            <option value="1" <?php if($slide->type == "1") echo "SELECTED"; ?>>Get Data</option>

                                            <option value="2" <?php if($slide->type == "2") echo "SELECTED"; ?>>Finish</option>

                                           

                                            </select>

                                        </div>

                                    </div>



                                    <div class="get-data-div <?php echo $slide->type == "1" ? "":"display_none"; ?> ">
                                        
                                        <?php 

                                        $questions = $this->front_model->get_query_simple('*','dev_web_slide_qs',array())->result_object();
                                        $links = $this->front_model->get_query_simple('*','dev_web_slide_links',array())->result_object();
                                        ?>

                                                <div class="box-slide-q-1 ">


                                                    <?php  for($i=0; $i<=3; $i++){

                                                        $q_var = 'question_'.($i+1);
                                                        $link_var = 'link_'.($i+1);


                                                     ?>

                                                    <div class="col-md-12">
                                                        <label>Section <?php echo $i+1; ?></label>
                                                        <select class="form-control" name="section[]"   <?php echo $slide->type == "1" ? "required":""; ?> >
                                                            <option value="">Choose Question, Link or "None"</option>
                                                            <option <?php  echo $slide->$q_var==0?"selected":""; ?> value="none|0">None</option>
                                                            <?php foreach($questions as $question){ ?>
                                                                <option <?php  echo $slide->$q_var==$question->id?"selected":""; ?> value="<?php echo 'q|'.$question->id; ?>">Q: <?php echo $question->q; ?></option>
                                                            <?php } ?>


                                                            <?php foreach($links as $link){ ?>
                                                                <option <?php  echo $slide->$link_var==$link->id?"selected":""; ?> value="<?php echo 'link|'.$link->id; ?>">Link: <?php echo $link->text; ?></option>
                                                            <?php } ?>

                                                        </select>
                                                    </div>

                                                    <?php } ?>
                                                    
                                                </div>





                                    </div>
                                    <div class="finish-div <?php echo $slide->type == "2" ? "":"display_none"; ?>">
                                        


                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label>Description <sup>*</sup> <i class="fa fa-info info-tip" title="This will be shown as congratulations text on final slide"></i></label>

                                                <textarea name="description" class="form-control" <?php echo $slide->type == "2" ? "required":""; ?> value=""><?php  echo $slide->finish_description;?></textarea>

                                            </div>

                                        </div>


                                        <div class="col-md-12">
                                            <label>What to ask at congratulations?</label>
                                            <select class="form-control" name="finish_question"  <?php echo $slide->type == "2" ? "required":""; ?> >
                                                <option value="">Choose Question</option>
                                                <option value="none|0">None</option>
                                                <?php foreach($questions as $question){ ?>
                                                    <option value="<?php echo 'q|'.$question->id; ?>">Q: <?php echo $question->q; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>





                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>Image <sup>*</sup> </label>

                                            <input name="inputfile" type="file" accept="image/*" class="form-control"  value="" id="inputfile">
                                            <label class="msg"></label>


                                            <img src="<?php echo base_url().'resources/uploads/campaigns/'; echo $slide->image; ?>" class="uploading_image ">

                                        </div>

                                    </div>

                                    

                                 


                                    

                                    

                                    


                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                               Add New Slide

                                            </button>

                                        </div>

                                    </div>

                                   

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>



        </div>

    </div>

</div>



<script>

    var resizefunc = [];

</script>

<?php include("common/footer.php");?>



<script>

    $(document).ready(function() {



        $('#birth_date').datepicker({

            format: 'yyyy-mm-dd',

            endDate: '-0d'

        });

    });
function show_prespective(that)
{
    if($(that).val()==1){
        $(".links-div").hide();
        $(".qs-div").show();
    }
    else
    {
        $(".qs-div").hide();
        $(".links-div").show();

    }
}


function show_prespective_div(that)
{
    if($(that).val()==1){


        $(".finish-div").find('input').prop('required',false);
        $(".finish-div").find('textarea').prop('required',false);
        $(".finish-div").find('select').prop('required',false);


        $(".finish-div").hide();

        $(".get-data-div").find('input').prop('required',true);
        $(".get-data-div").find('textarea').prop('required',true);
        $(".get-data-div").find('select').prop('required',true);

        $(".get-data-div").show();
        
    }
    else
    {
        $(".get-data-div").find('input').prop('required',false);
        $(".get-data-div").find('textarea').prop('required',false);
        $(".get-data-div").find('select').prop('required',false);

        $(".get-data-div").hide();

        $(".finish-div").find('input').prop('required',true);
        $(".finish-div").find('textarea').prop('required',true);
        $(".finish-div").find('select').prop('required',true);

        $(".finish-div").show();
        

    }
}
</script>

<script>
$(function () {
$('#inputfile').change(function () {

     $('.img').hide();

 
  $('.msg').text('Please Wait...');
  $('#submit_btn').prop('disabled', true);

  var myfile = $('#inputfile').val();
  var formData = new FormData();
  formData.append('inputfile', $('#inputfile')[0].files[0]);
   $('.msg').text('Uploading in progress...');
  $.ajax({
    url: '<?php echo base_url().'ico/take_image_camp'; ?>',
    data: formData,
    processData: false,
    contentType: false,
    type: 'POST',
  
    success: function (data) {

      data = JSON.parse(data);
       
      $('.msg').html(data.msg);


      if(data.status==1){
          $('.uploading_image').attr('src',data.src);
          $('.uploading_image').show();
         $('#submit_btn').prop('disabled', false);

        }
    }
  });
});
});
</script>



</body>

</html>

