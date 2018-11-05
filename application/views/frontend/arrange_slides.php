<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">

                   <?php 

						$title = "ARRANGE CAMPAING SLIDES - ADMIN";

					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">

                                   
                                     <div class="col-md-12">
                                        <ul id="sortable">
                                            <?php foreach($slides as $key=>$slide){ ?>
                                                <li data-id='<?php echo $slide->id; ?>' id="set_<?php echo $key+1; ?>" class="ui-state-default">
                                                    <span class="ui-icon ui-icon-arrowthick-2-n-s">
                                                      <i class="fa fa-bars"></i>  <?php echo $slide->title; ?>
                                                    </span>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                     </div>



                                   
                                    

                                    

                                    


                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">
                                            <input type="hidden" name="sorted" value="" id="sorted">
                                            <input type="hidden" name="ids" value="" id="ids">
                                            <button name="submit" class="btn btn-default btn-block btn-lg" type="submit">

                                               Update

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

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<style type="text/css">
        #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { 
margin: 0 3px 3px 3px;
    /* padding: 0.4em; */
    padding-left: 1.5em;
    font-size: 1.4em;
    /* height: 18px; */
    background: #eee;
    float: left;
    clear: both;
    width: 100%;
    margin-top: 26px;
    height: 44px;
    padding: 10px;

    }
    
    .ui-state-default {cursor: move;cursor: -webkit-grab; cursor: grab;}

     
</style>

<script>

    $(document).ready(function(){

      

    $("#sortable").sortable({
        stop : function(event, ui){
         var sorted = $(this).sortable('serialize');
         // console.log(sorted);

         ids =[];
         $("#sortable li").each(function(i,v){
            ids.push($(this).attr('data-id'));
         });
        console.log(ids);
        console.log(sorted);
         $("#sorted").val(sorted);
         $("#ids").val(ids);
        }
    });
  $("#sortable").disableSelection();
});//ready

</script>



</body>

</html>

