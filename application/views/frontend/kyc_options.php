
   
    	<div class="row">
         <div class="col-sm-12 m-b-30">
        	<h4 class="page-title">KYC Verification APIs
              
            </h4>
    	</div>
    	</div>
    	<div class="row">


            <?php


             foreach($options as $key=>$option){ ?>


			<div class="col-sm-3 m-b-30">
				<div class="card-box widget-box-1 boxdisplay" style="min-height: 250px;">
                    <span>
                        
                        <img src="<?php echo base_url();?>resources/frontend/images/<?php echo $option->icon;?>" alt="<?php echo $option->name; ?>" width="50">
                       
                        </span>
					<p><?php echo $option->name; ?></p>
                    <p>
                        <input onclick="openModal(<?php echo $option->id; ?>,this);"   <?php echo $option->active==1?"checked":""; ?> type="checkbox" name="isActive<?php echo $option->id; ?>" value="<?php echo $option->active; ?>">

                        <button  onclick="openModal2(<?php echo $option->id; ?>);" class="btn btn-default btn-block btn-sm btn-smart" type="button">
                            View Details
                        </button>
                    </p>
                   

				</div>	
			</div>	


            <div class="modal-cs display_none" id="modal<?php echo $option->id; ?>">
                <div class="modal-box">
                    <div class="modal-heading">
                        <?php echo $option->name; ?>

                        <button onclick="closeModel();" class="btn bt-danger right" >
                            <i  class="fa fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form method="post" action="" onSubmit="return detectRequired(this);">
                            <div class="row">

                                <input type="hidden" name="type" value="<?php echo $option->type; ?>">
                                <input type="hidden" name="option_id" value="<?php echo $option->id; ?>">

                                <?php if($option->type=="STANDARD"){ ?>
                                    <input type="hidden" name="url" value="">
                                    <center><h4>You'll have to review KYC information manually.</h4></center>
                                <?php }else{ ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?php echo $option->name; ?> URL: <sup>*</sup></label>
                                            <input name="url" type="text" class="form-control" value="<?php echo $option->url; ?>" required autofocus>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?php echo $option->name; ?> Public Key: <sup><?php if($option->type!="OKVERIFY") echo "*"; ?></sup></label>
                                            <textarea name="public_key" class="form-control" <?php if($option->type!="OKVERIFY") echo "required"; ?> ><?php echo $option->public_key; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?php echo $option->name; ?> Private Key: <sup>*</sup></label>
                                            <textarea name="private_key" class="form-control" required ><?php echo $option->private_key; ?></textarea>
                                        </div>
                                    </div>
                                    <?php if($option->type=="IDMINDPLUGIN"){ ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?php echo $option->name; ?> Form ID: </label>
                                            <input name="form_id" type="text" class="form-control" value="<?php echo $option->form_id; ?>" required >
                                        </div>
                                    </div>
                                    <?php } ?>

                                

                                    <?php } ?>
                                   

                                    

                                    <div class="col-md-6 col-md-offset-3 m-t-40">
                                        <div class="form-group">
                                            <button class="btn btn-default btn-block btn-lg" type="submit">
                                                Save & Activate
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                 </div>
            </div>


            <?php } ?>







   			
   			
    	</div>
