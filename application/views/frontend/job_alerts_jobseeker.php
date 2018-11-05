<?php require_once("common/header.php");?>

<?php
	$arr2 = array('uID' => UID);
	$config2 = $this->front_model->get_query_simple('*','dev_job_alerts',$arr2);
	$user 	= $config2->result_object();
	
	$arr2us = array('uID' => $user[0]->uID);
	$config2user = $this->front_model->get_query_simple('*','dev_web_user',$arr2us);
	$userdata 	= $config2user->result_object();
?>
<div id="jobsectors" class="rightop clear left wd100">
  <div class="container">
    <div class="col-xs-12 nopad">
      <div class="col-xs-3 pr0 nopad" >
        <div class="media cv-inner left wd100" style="min-height: 435px;">
        	<h4>Job Alerts Information</h4>
          <div class="media-body nopad coverletterbox col-xs-12">
          	<p>Your current account information:</p>
			<div class="">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="userinfo">
                  <tr>
                    <td width="35%" height="40">Job Title</td>
                    <td width="3%" align="left">:</td>
                    <td width="71%"><?php echo $user[0]->jobTitle;?></td>
                  </tr>
                  <tr>
                    <td width="20%" height="40">Job Skills</td>
                    <td align="left">:</td>
                    <td><?php echo $user[0]->jobSkills;?></td>
                  </tr>
                  <tr>
                    <td width="20%" height="40">Job Nature</td>
                    <td align="left">:</td>
                    <td><?php echo $user[0]->jobNature;?></td>
                  </tr>
                  <tr>
                    <td height="40">Instant Alerts</td>
                    <td align="left">:</td>
                    <td><?php if($user[0]->jobInstant == 1) {echo "Active";} else {echo "In-Active";}?></td>
                  </tr>
                 <tr>
                    <td height="30" colspan="3" style="color:#ef7268">Your job services are presently customized for the following Industry domains</td>
                  </tr>
                   <tr>
                    <td height="30" colspan="3" style="font-size:13px;">
                    	<?php
						$exp = explode(",",$userdata[0]->uSectors);
						foreach($exp as $sec):
						$arr22 = array('cID' => $sec);
						$secc = $this->front_model->get_query_simple('*','dev_web_categories',$arr22);
						$sect = $secc->result_object();
						?>
                        <?php  $dsec .= $sect[0]->catName.", ";?>
                        <?php endforeach;?>
                        <?php echo substr($dsec,0,-2);?>
                    </td>
                  </tr>
              </table>
 
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-9">
        <div class="media cv-inner left wd100" style="min-height: 241px;">
        	<h4>Job Alerts<div id="logingbar" class="right"></div></h4>
          	<div class="media-body nopad coverletterbox col-xs-12">
          	<p>Please Update your job alerts below</p>
          	<?php if(isset($_SESSION['msglogin'])){?>
            <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
            <?php } ?>
            
            <form name="loginform" id="loginform" action="<?php echo base_url(); ?>jobsite/alerts_submit" method="post">
              <div class="col-xs-12 nopad boxinput">
              		<label>Job Title</label>
                <input type="hidden" name="aID" id="aID" class="inputjob" value="<?php echo $user[0]->jaID;?>">
                <input type="text" name="jobtitle" id="jobtitle" class="inputjob" value="<?php echo str_replace(","," ",$user[0]->jobTitle);?>" required placeholder="Job Title" onBlur="checkspaces('jobtitle')">
              </div>
              <div class="col-xs-12 nopad boxinput">
              <label>Job Skills:</label>
                <input type="text" name="skills" id="skills" class="inputjob" value="<?php echo str_replace(","," ",$user[0]->jobSkills);?>" placeholder="Skills" onBlur="checkspaces('skills')">
              </div>
              <?php /*?><div class="col-xs-12 nopad boxinput">
                <select name="desiredloc" id="desiredloc" class="inputjob">
                  <option value="">--- Desired Location ---</option>
                  <?php 
                    $arr = array();
                    $config 	= $this->front_model->get_query_simple('*','dev_web_countries',$arr);
                    $countries = $config->result_object();
                  foreach($countries as $country):?>
                  <option value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
                  <?php endforeach; ?>
                </select>
              </div><?php */?>
              <div class="col-xs-12 nopad boxinput">
              <label>Job Type:</label>
                <select name="jobType" id="jobType" class="inputjob">
                   <option value="">--- Job Type ---</option>
                   <option value="Full-Time" <?php if($user[0]->jobNature == "Full-Time"){echo "SELECTED";}?>>Full-Time</option>
                   <option value="Internship" <?php if($user[0]->jobNature == "Internship"){echo "SELECTED";}?>>Internship</option>
                   <option value="Part-Time" <?php if($user[0]->jobNature == "Part-Time"){echo "SELECTED";}?>>Part-Time</option>
                   <option value="Temporary/Contract" <?php if($user[0]->jobNature == "Temporary/Contract"){echo "SELECTED";}?>>Temporary/Contract</option>
                </select>
              </div>
              
              <div class="col-xs-12 nopad boxinput">
              <label>Instant Alerts:</label>
              		<div class="instantalerts left wd100">
                   		<div class="col-xs-1">
                        	<input type="checkbox" name="jobInstant" id="jobInstant" value="1" <?php if($user[0]->jobInstant == "1"){echo "CHECKED";}?>>
                        </div>
                        <div class="col-xs-11 nopad">
                        	<h2>Instant job alerts</h2>
                            <p>Newly added jobs that are relevant to you, based on your activity on the site</p>
                        </div>
                    </div>
              	
                <?php /*?><select name="jobInstant" id="jobInstant" class="inputjob">
                   <option value="">--- Instant Alerts ---</option>
                   <option value="1" <?php if($user[0]->jobInstant == "1"){echo "SELECTED";}?>>Yes</option>
                   <option value="0" <?php if($user[0]->jobInstant == "0"){echo "SELECTED";}?>>No</option>
                   
                </select><?php */?>
              </div>
            
             <div class="col-xs-12 nopad boxinput">
              <button type="submit" name="signup" class="btn pink">Update Alerts & Preferences</button>           
            </div>
         </form>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>
<?php require_once("common/footer.php");?>
<script language="javascript" type="application/javascript" src="<?php echo base_url(); ?>resources/backend/js/icheck/icheck.js" runat="server"></script>
<script language="javascript">
	$(document).ready(function () {
	$('input').iCheck({
   		checkboxClass: 'icheckbox_flat',
    	radioClass: 'iradio_flat'
  	});
	});
</script>

<style>
@import "<?php echo base_url(); ?>resources/backend/css/icheck/_all.css";
.instantalerts { border:1px solid #ccc; padding:10px; margin-bottom:5px; box-sizing:border-box; background:#fafafa;}
</style>