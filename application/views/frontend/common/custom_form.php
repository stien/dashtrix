<?php



// $cond = array('status'=>1);
// $form = $this->front_model->get_query_simple('*','dev_web_registration_forms',$cond)->result_object()[0];

$jsondata = json_decode($form->form,true);

$this->data['jsondata']=$jsondata;



 foreach($jsondata as $keyy=>$banner){?>
 
                            <div class="col-md-<?php if($banner['typetext'] == "textarea" || $banner['typetext'] == "file" || $banner['typetext'] == "url"){?>12<?php } else {?>6<?php }?>">
                                <div class="form-group">
                                    <label><?php echo $banner['name'];?>:
                                        <?php if($banner['type']==1){ ?>

                                        <sup>*</sup>
                                        <?php  } if($banner['tooltip']){ ?>
                                            <i data-toggle="tooltip" title="<?php echo $banner['tooltip']; ?>" class="fa fa-question-circle" aria-hidden="true"></i>
                                        <?php } ?>
                                    </label>
                                    <?php if($banner['typetext'] == "textarea"){?>
                                        <textarea  <?php if($banner['type']=="1"){echo "data-required";}?>  type="text" name="collect[<?php echo $keyy; ?>]" class="form-control"  id="name" placeholder=""><?php if($bounty_edit) echo get_be_ue_($b_e_f_user_created,$banner['name']); ?></textarea>
                                    <?php } else if($banner['typetext']=="file") {?>

                                       <div >
                                           <div>
                                               <input   <?php if($banner['type']==1) echo "required"; ?> type="file" name="inputfile" id="inputfile" >
                                           </div>
                                       </div>




                                        <div class="col-md-12 nopad">
                                            <div class="errornotification m-b-15 easy" style="padding-top:10px; color:#f00; background-color: white; border:none; padding:0; clear:both; display:<?php echo isset($_SESSION['CreationBountyFile'])?'':'none'; ?>;">

                                                <?php echo eas_creation__(); ?>

                                            </div>
                                            <div class="errornotification2 m-b-15 easy" style="padding-top:10px; color:#fff;  background-color: #FF0000; border:none; padding:5px 20px; clear:both; display:none;">



                                            </div>
                                            <div class="form-group" id="progess" style="display:none;">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                                                </div>
                                            </div>
                                        </div>


                                    <?php } elseif($banner['typetext'] == "url") {?>

                                        <?php

                                            $required = $banner['type']==1 ? "required":"";


                                            if(!$bounty_edit) {

                                                echo get_url_div($required, 0);

                                            }
                                            else{
                                                foreach ($b_e_f_urls as $b_e_f_urls_key=>$b_e_f_urls_val){
                                                    if($b_e_f_urls_key!=0)
                                                        $cc__crose = 1;
                                                    else
                                                        $cc__crose = 0;
                                                    echo get_url_div($required, $cc__crose,$b_e_f_urls_val);
                                                }
                                            }
                                        ?>




                                        <div class="easy kaaat">
                                            <button type="button" onclick="cloneTop(this,'<?php echo $required; ?>', 1)" class="btn btn-default btn-xs m-t-5">Add More+</button>
                                        </div>







                                    <?php } else if($banner['typetext'] == "dropdown"){?>
                                        <?php 
                                                $dropvalues = $banner['dropvalue'];
                                                $expdrop = explode("\r\n",$dropvalues);
                                        ?>
                                        <select name="collect[<?php echo $keyy; ?>]" class="form-control" <?php if($banner['type']=="1"){echo "REQUIRED";}?>>
                                            <option selected="selected" disabled="disabled" hidden="hidden" value="">Choose</option>
                                            <?php 
                                                foreach($expdrop as $key=>$optionval){
                                            ?>
                                                <option value="<?php echo $optionval;?>"><?php echo $optionval;?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } else {?>
                                        <input type="text" <?php
                                        if(
                                            strpos(strtolower($banner['name']),"keyword")
                                            || strpos(strtolower($banner['name']),"keywords")
                                            || strpos(strtolower($banner['name']),"tags")
                                        )  echo " data-role=\"tagsinput\""; ?> name="collect[<?php echo $keyy; ?>]" class="form-control" <?php if($banner['typetext'] == "date"){?>id="datepicker" <?php }else {?> id="name" <?php } ?> value="<?php if($bounty_edit) echo get_be_ue_($b_e_f_user_created,$banner['name']); ?>" placeholder="">
                                    <?php } ?>
                                </div>


                            </div>


                    <?php } ?>