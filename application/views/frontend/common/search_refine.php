<div class="col-xs-12 nopad">
      <div class="login-inner left">
      <?php print_r($_SESSSION['refinesearch']);?>
        <h2>Refine Search</h2>
        <form name="signupform" id="signupform" action="<?php echo base_url(); ?>advance/search" method="post">
          
          <div class="col-xs-12 nopad boxinput selectbxfast">
            <select name="category" id="category" required class="inputjob fastselect">
          	<option value="">--- Select Categories ---</option>
		  <?php 
		  $arr = array();
		  	$config 	= $this->front_model->get_query_simple('*','dev_web_categories',$arr);
			$categories 	= $config->result_object();
		  foreach($categories as $caregory):?>
          	<option value="<?php echo $caregory->cID;?>" 
				<?php if(isset($_SESSION['refinesearch']) && $_SESSION['refinesearch']['category'] == $caregory->cID){echo "SELECTED";}?> >
				<?php echo $caregory->catName;?></option>
          <?php endforeach; ?>
          </select>
          </div>
          
          <div class="col-xs-12 nopad boxinput selectbxfast">
            <select name="experience" id="experience" class="inputjob fastselect">
          		<option value="">--- Select Experience Level ---</option>
                <?php for($i=0;$i<=25;$i++): ?>
                <option value="<?php echo $i;?>" 
				<?php if(isset($_SESSION['refinesearch']) && $_SESSION['refinesearch']['experience'] == $i){echo "SELECTED";}?>>
						<?php if($i == 0){echo '< 1';}else {echo $i;}?></option>
                <?php endfor; ?>
                <option value="26" 
				<?php if(isset($_SESSION['refinesearch']) && $_SESSION['refinesearch']['experience'] == "26"){echo "SELECTED";}?>>&gt; 25 Years</option>
          	</select>
          </div>
          <div class="col-xs-12 nopad boxinput">
            <input type="text" name="minsalary" id="minsalary" class="inputjob" value="<?php if(isset($_SESSION['refinesearch'])){echo $_SESSION['refinesearch']['minsalary'];}?>" placeholder="Minimum Salary ($)">
          </div>
          <div class="col-xs-12 nopad boxinput">
            <input type="text" name="maxsalary" id="maxsalary" value="<?php if(isset($_SESSION['refinesearch'])){echo $_SESSION['refinesearch']['maxsalary'];}?>" class="inputjob" placeholder="Maximum Salary ($)">
          </div>
          <div class="col-xs-12 nopad boxinput selectbxfast">
            <select name="jobType" id="jobType" class="inputjob fastselect">
          		<option value="">--- Select Job Type ---</option>
               <option value="Full-Time" <?php if(isset($_SESSION['refinesearch']) && $_SESSION['refinesearch']['jobType'] == "Full-Time"){echo "SELECTED";}?>>Full-Time</option>
               <option value="Internship" <?php if(isset($_SESSION['refinesearch']) && $_SESSION['refinesearch']['jobType'] == "Internship"){echo "SELECTED";}?>>Internship</option>
               <option value="Part-Time" <?php if(isset($_SESSION['refinesearch']) && $_SESSION['refinesearch']['jobType'] == "Part-Time"){echo "SELECTED";}?>>Part-Time</option>
               <option value="Per Diem" <?php if(isset($_SESSION['refinesearch']) && $_SESSION['refinesearch']['jobType'] == "Per Diem"){echo "SELECTED";}?>>Per Diem</option>
               <option value="Seasonal" <?php if(isset($_SESSION['refinesearch']) && $_SESSION['refinesearch']['jobType'] == "Seasonal"){echo "SELECTED";}?>>Seasonal</option>
               <option value="Temporary/Contract" <?php if(isset($_SESSION['refinesearch']) && $_SESSION['refinesearch']['jobType'] == "Temporary/Contract"){echo "SELECTED";}?> <?php if(isset($_SESSION['refinesearch']) && $_SESSION['refinesearch']['jobType'] == "Full-Time"){echo "SELECTED";}?>>Temporary/Contract</option>
               <option value="Volunteer" <?php if(isset($_SESSION['refinesearch']) && $_SESSION['refinesearch']['jobType'] == "Volunteer"){echo "SELECTED";}?>>Volunteer</option>
               <option value="Work Study" <?php if(isset($_SESSION['refinesearch']) && $_SESSION['refinesearch']['jobType'] == "Work Study"){echo "SELECTED";}?>>Work Study</option>
          	</select>
          </div>
          <div class="col-xs-12 nopad boxinput">
            <button type="submit" name="signup" class="btn blue">Search</button>
          </div>
        </form>
      </div>
    </div>
    
