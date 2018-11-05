<?php require_once("common/header.php");?>

<?php
	// USER INFORMATION
	error_reporting(0);
	$arr3 = array('uID' => UID);
	$config3 = $this->front_model->get_query_simple('*','dev_web_user',$arr3);
	$userinfo 	= $config3->result_object();
	// CV INFOMRATION
	$arr2 = array('uID' => UID);
	$config2 = $this->front_model->get_query_simple('*','dev_web_cv',$arr2);
	$cresume = $config2->num_rows();
	if($cresume > 0){
	$user 	= $config2->result_object();
	}
?>
<div id="jobsectors" class="rightop clear left wd100">
  <div class="container">
    <div class="col-xs-12 nopad">
     <?php if(isset($_SESSION['msglogin'])){?>
        <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>
        <?php } ?>
      <div class="col-xs-5 nopad pr0">
        <div class="media cv-inner left wd100">
        	<h2>Resume Management</h2>
          <div class="media-body nopad coverletterbox col-xs-12" style="min-height: 267px;">
          	<p style="margin-top:0;">Click to view:</p>
			<div>
            	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="userinfo">
                  <?php if($cresume > 0){ ?>
                  <tr>
                    <td width="25%" height="30">CV Status</td>
                    <td width="3%" align="left">:</td>
                    <td width="71%"><?php if($user[0]->cvView == 1){echo "<strong style='color:#7ca52f'>Searchable by recruiters</strong>";} else { echo "<i class='fa fa-eye-slash' style='color:#f00;'></i> Hidden by recruiters";}?> </td>
                  </tr>
                  <tr>
                    <td width="20%" height="30">View CV</td>
                    <td align="left">:</td>
                    <td>
                    <?php if($user[0]->cvFile != ""){?>
                    <a href="<?php echo base_url(); ?>resources/uploads/resume/<?php echo $user[0]->cvFile;?>" target="_blank">                    <i class="fa fa-eye"></i>
                    </a>
                    <?php } else { ?>
                    <a href="javascript:;" title="No CV file uploaded"><i class="fa fa-eye"></i>
                    </a>
                    <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td width="20%" height="30">Email CV</td>
                    <td align="left">:</td>
                    <td><a href="<?php echo base_url(); ?>jobsite/email_resume"><i class="fa fa-envelope-o"></i></a></td>
                  </tr>
                 
                  <tr>
                    <td height="30">Delete CV</td>
                    <td align="left">:</td>
                    <td><a href="javascript:;" onClick="deletecv(<?php echo $user[0]->cvID;?>)"><i class="fa fa-trash-o"></i></a></td>
                  </tr>
                  <tr>
                    <td height="30">Edit CV</td>
                    <td align="left">:</td>
                    <td><a href="<?php echo base_url(); ?>create-cv"><i class="fa fa-edit"></i></a></td>
                  </tr>
                   <tr>
                    <td height="30">CV Created</td>
                    <td align="left">:</td>
                    <td><?php if($user[0]->cvPosted != ""){echo date("M, d Y",strtotime($user[0]->cvPosted));}?></td>
                  </tr>
                  <tr>
                    <td height="30">Last Updated</td>
                    <td align="left">:</td>
                    <td><?php if($user[0]->cvUpdated != ""){echo date("M, d Y",strtotime($user[0]->cvUpdated));}?></td>
                  </tr>
                  <?php } else { ?>
                  <tr>
                    <td colspan="3" height="30">
                    	<?php echo '<div class="errormsg">No CV created yet, Please click on below icon to create a new CV!</div>';?>
                    </td>                  
                  </tr>
                   <tr>
                    <td colspan="3" height="35"  align="center">&nbsp;</td>
                  </tr>
                   <tr>
                    <td colspan="3"  align="center"><a href="<?php echo base_url(); ?>create-cv"><i class="fa fa-edit" style=" font-size:145px"></i></a></td>
                  </tr>
                  <?php } ?>
              </table>
 
            </div>
          </div>
        </div>
        
      </div>
      <div class="col-xs-7">
        <div class="media cv-inner left wd100" style="min-height: 241px;">
        	<h2>Profile Information</h2>
          	<div class="media-body nopad coverletterbox col-xs-12">
            <p style="margin-top:0;">Your profile information is as below:</p>
            	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="userinfo">
                  <tr>
                    <td width="20%" height="30">Full Name</td>
                    <td width="3%" align="left">:</td>
                    <td width="76%"><?php echo $userinfo[0]->uFname;?> <?php echo $userinfo[0]->uLname;?></td>
                  </tr>
                  <tr>
                    <td width="20%" height="30">Email Address</td>
                    <td width="3%" align="left">:</td>
                    <td width="76%"><?php echo $userinfo[0]->uEmail;?></td>
                  </tr>
                  <tr>
                    <td width="20%" height="30">Date of Birth</td>
                    <td align="left">:</td>
                    <td><?php echo date("M, d Y",strtotime($userinfo[0]->uDOB));?></td>
                  </tr>
                  <tr>
                    <td width="20%" height="30">Country</td>
                    <td align="left">:</td>
                    <td><?php echo $userinfo[0]->uCountry;?></td>
                  </tr>
                 
                  <tr>
                    <td height="30">Address</td>
                    <td align="left">:</td>
                    <td><?php echo $userinfo[0]->uAddress;?></td>
                  </tr>
                   <tr>
                    <td height="30">City</td>
                    <td align="left">:</td>
                    <td><?php echo $userinfo[0]->uCity;?></td>
                  </tr>
                   <tr>
                    <td height="30">Zip Code</td>
                    <td align="left">:</td>
                    <td><?php echo $userinfo[0]->uZip;?></td>
                  </tr>
                   <tr>
                    <td height="30">Contact Number</td>
                    <td align="left">:</td>
                    <td><?php if($userinfo[0]->uPhone != ""){echo "+";} echo $userinfo[0]->uPhone;?></td>
                  </tr>
              </table>
          	</div>
          </div>
        
        </div>
      </div>
      
    </div>
  </div>
</div>
<?php require_once("common/footer.php");?>
<script language="javascript">
function deletecv(id){
	$("#boxmesagedeletecv").show();
	<?php /*?>var x = confirm("Are you sure you want to remove CV?");
	  	if (x){
			window.location='<?php echo base_url(); ?>jobsite/removeCv/'+id;
			return true;
		}
		else {
			return false;
		}
<?php */?>
}
function hidepass()
{
	$("#boxmesagedeletecv, #boxmesageemail").hide();
}
</script>
<div class="container-popup" id="boxmesagedeletecv" style="display:none;">
    <div class="rightpop">
    
    	<div id="messpopup" style="display:block;">
        	<h2>Delete Resume <i class="fa fa-close right" style="cursor:pointer;" onClick="hidepass()"></i></h2>
            <p style="margin:10px 0;">
            	Please enter your password below to remove your resume!
            </p>
            <div style="margin-bottom:0 !important;">
            	<form name="1apply" id="1apply" method="post" action="<?php echo base_url(); ?>jobsite/removeCv">
                <div class="col-xs-12 nopad boxinput">
                  <input type="password" value="" class="inputjob" placeholder="Provide Password" required name="userpass" id="userpass" />
                </div>
            	<button name="signup" type="submit" class="btn blue">Remove CV</button>
                <input type="hidden" value="<?php echo $user[0]->cvID;?>" name="cvID" id="cvID">
                <button name="signup" type="button" class="btn red" onClick="hidepass()">Cancel</button>
                </form>
                
            </div>
        </div>
    </div>
</div>

<?php /*?><style>
.coverletterbox  p { font-size:12px;}
.userinfo { font-size:12px;}
</style><?php */?>