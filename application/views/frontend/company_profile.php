<?php require_once("common/header.php");?>

<?php

	$arr2 = array('uID' => UID);

	$config2 = $this->front_model->get_query_simple('*','dev_web_user',$arr2);

	$user 	= $config2->result_object();

?>

<div id="jobsectors" class="rightop clear left wd100">

  <div class="container">

    <div class="col-xs-12 nopad">

      <div class="col-xs-5 pr0 nopad">

        <div class="col-xs-12 nopad">

          <div class="media cv-inner left wd100" style="min-height: 682px;">

            <h1>Company Profile Information</h1>

            <div class="media-body nopad coverletterbox col-xs-12">

              <div class="col-xs-4 nopad imgcompany">

                <div id="change-profile-pic">

                <div class="editphoto" title="Upload Picture"> <i class="fa fa-upload"></i> </div>

                

                <?php if($user[0]->uImage != ""){?>

                <img src="<?php echo base_url(); ?>resources/uploads/profile/<?php echo $user[0]->uImage;?>" id="profile_picture">

                <?php } else { ?>

                <img src="<?php echo base_url(); ?>resources/frontend/images/no_photo.jpg" alt="No Pic" id="profile_picture"><br>

                <?php } ?>

                </div>

                <?php if($user[0]->uImage != ""){?>

                <span style="  padding: 5px;

                  border: 1px solid #f0f0f0;

                  text-align: center;

                  color: #f00;

                  font-weight: bold;"> <a href="javascript:;" onClick="deletelogo()" style="color: #f00;"><i class="fa  fa-trash"></i> Remove Photo</span></a> 

                <script language="javascript">

				  function deletelogo()

					{

						var x = confirm("Are you sure you want to delete Company logo?");

						if (x){

							window.location='<?php echo base_url(); ?>jobsite/remove_company_photo';

							return true;

						}

						else {

							return false;

						}

					}

				  

				  </script>

                <?php } ?>

              </div>

              <div class="col-xs-8 pright0">

                <p>

                  <?php if($user[0]->uCompany != ""){echo $user[0]->uCompany;} else {echo $user[0]->uFname." ".$user[0]->uLname;}?>

                </p>

                <?php if($user[0]->uWebsite != ""){ ?>

                <p><?php echo $user[0]->uWebsite;?></p>

                <?php } ?>

                <?php if($user[0]->uPhone != ""){ ?>

                <p><?php echo $user[0]->uPhone;?></p>

                <?php } ?>

                <?php if($user[0]->uNoEmp != ""){ ?>

                <p># of Employees: <?php echo $user[0]->uNoEmp;?></p>

                <?php } ?>

                <?php if($user[0]->uAddress != ""){ ?>

                <p><?php echo $user[0]->uAddress;?></p>

                <?php } ?>

              </div>

              <?php if($user[0]->uAbout != ""){?>

              <div class="col-xs-12 nopad aboutcomp">

                <h2>About Company:</h2>

                <?php echo $user[0]->uAbout;?> </div>

              <?php } ?>

            </div>

          </div>

        </div>

        <?php /*?><div class="col-xs-12 nopad">

     	   <div class="media cv-inner left wd100">

        	<h1>Company Profile Information</h1>

          <div class="media-body nopad coverletterbox col-xs-12">

			<div class="">

            	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="userinfo">

               

                  <tr>

                    <td width="25%" height="30">Phone #</td>

                    <td width="3%" align="left">:</td>

                    <td width="71%"><?php echo $user[0]->uPhone;?></td>

                  </tr>

                  <tr>

                    <td width="20%" height="30">No. Of Employees</td>

                    <td align="left">:</td>

                    <td><?php echo $user[0]->uNoEmp;?></td>

                  </tr>

                  <tr>

                    <td width="20%" height="30">Company Address</td>

                    <td align="left">:</td>

                    <td><?php echo $user[0]->uAddress;?></td>

                  </tr>

                  <tr>

                    <td height="30">Company Website</td>

                    <td align="left">:</td>

                    <td><?php echo $user[0]->uWebsite;?></td>

                  </tr>

                  <tr>

                    <td height="30">About Company</td>

                    <td align="left">:</td>

                    <td><?php echo $user[0]->uAbout;?></td>

                  </tr>

                  <tr>

                    <td height="30">Account Type</td>

                    <td align="left">:</td>

                    <td><?php if($user[0]->uActType == 1){echo 'Jobseeker';} else {echo "Recruiter";}?></td>

                  </tr>

              </table>

 

            </div>

          </div>

        </div>

        </div><?php */?>

      </div>

      <div class="col-xs-7">

        <div class="media cv-inner left wd100" style="min-height: 241px;">

          <div class="media-body nopad coverletterbox col-xs-12">

          <?php if(isset($_SESSION['msglogin'])){?>

          <div class="errormsg"><?php echo $_SESSION['msglogin'];?></div>

          <?php } ?>

          <h1>Company Information</h1>

          <form name="category" id="category" method="post" enctype="multipart/form-data" onSubmit="return buttondisabled()" action="<?php echo base_url(); ?>jobsite/update_company">

            <div class="col-xs-12 nopad boxinput">

              <label> Phone Number: </label>

              <input type="text" value="<?php echo $user[0]->uPhone; ?>" required name="phone" id="phone" class="inputjob" />

            </div>

            <div class="col-xs-12 nopad boxinput">

              <label> No. Of Employees: </label>

              <input type="text" value="<?php echo $user[0]->uNoEmp; ?>" class="inputjob" required name="employesnum" id="employesnum" />

            </div>

            <div class="col-xs-12 nopad boxinput">

              <label> Company Address: </label>

              <input type="text" value="<?php echo $user[0]->uAddress; ?>" class="inputjob" required name="address" id="address" />

            </div>

            <div class="col-xs-12 nopad boxinput">

              <label> Company Website: </label>

              <input type="text" value="<?php echo $user[0]->uWebsite; ?>" class="inputjob" required name="website" id="website" />

              <div id="urlvalidate"></div>

            </div>

            <div class="col-xs-12 nopad boxinput">

              <label> Fax: </label>

              <input type="text" value="<?php echo $user[0]->uFax; ?>" class="inputjob" name="compfax" id="compfax" />

            </div>

            <div class="col-xs-12 nopad boxinput">

              <label> SIC Code: </label>

              <input type="text" value="<?php echo $user[0]->SICCODE; ?>" class="inputjob" name="compsic" id="compsic" />

            </div>

            <div class="col-xs-12 nopad boxinput">

              <label> Business Type: </label>

              <input type="text" value="<?php echo $user[0]->uBusinessType; ?>" class="inputjob" name="compbustype" id="compbustype" />

            </div>

            <div class="col-xs-12 nopad boxinput">

              <label> Company Information: </label>

              <textarea name="companyinfo" class="textarea inputjob" id="companyinfo" required><?php echo $user[0]->uAbout; ?></textarea>

            </div>

            </div>

            <div class="col-xs-12 nopad boxinput">

              <button type="submit" name="signup" id="signypbutton" class="btn pink">Update Company Profile</button>

            </div>

          </form>

        </div>

      </div>

    </div>

  </div>

</div>

</div>

<?php require_once("common/footer.php");?>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>resources/frontend/js/jquery.imgareaselect.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>resources/frontend/js/jquery.form.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>resources/frontend/css/imgareaselect.css">

<script src="<?php echo base_url(); ?>resources/frontend/js/functions.js"></script>

<?php /*?><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<?php */?>

<div id="profile_pic_modal" class="modal fade">

	<div class="modal-dialog">

			<div class="modal-content">

				<div class="modal-header">

					<?php /*?><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><?php */?>

				   <h2 style="text-transform: uppercase;

  font-size: 17px;">Change Profile Picture

					<div class="right" style="  margin-top: -14px;">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

					<button type="button" id="save_crop" class="btn btn-primary">Crop & Save</button>

                    </div>

                   </h2>

                   <span style="color:#f00 !important; display:block;">Please select an area to crop the image and press crop and save button</span>

				</div>

				<div class="modal-body">

					<form id="cropimage" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>jobsite/change_pic">

						<strong>Upload Image:</strong> <br><br>

						<input type="file" name="profile-pic" id="profile-pic" />

						<input type="hidden" name="hdn-profile-id" id="hdn-profile-id" value="1" />

						<input type="hidden" name="hdn-x1-axis" id="hdn-x1-axis" value="" />

						<input type="hidden" name="hdn-y1-axis" id="hdn-y1-axis" value="" />

						<input type="hidden" name="hdn-x2-axis" value="" id="hdn-x2-axis" />

						<input type="hidden" name="hdn-y2-axis" value="" id="hdn-y2-axis" />

						<input type="hidden" name="hdn-thumb-width" id="hdn-thumb-width" value="" />

						<input type="hidden" name="hdn-thumb-height" id="hdn-thumb-height" value="" />

                        <input type="hidden" name="uID" id="uID" value="<?php echo UID;?>" />

						<input type="hidden" name="action" value="" id="action" />

						<input type="hidden" name="image_name" value="" id="image_name" />

						

						<div id='preview-profile-pic'></div>

					<div id="thumbs" style="padding:5px; width:600p"></div>

					</form>

				</div>

				

			</div>

		</div>

</div>

<style>

.modal-open{overflow:hidden}.modal{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1050;display:none;overflow:hidden;-webkit-overflow-scrolling:touch;outline:0}.modal.fade .modal-dialog{-webkit-transition:-webkit-transform .3s ease-out;-o-transition:-o-transform .3s ease-out;transition:transform .3s ease-out;-webkit-transform:translate(0,-25%);-ms-transform:translate(0,-25%);-o-transform:translate(0,-25%);transform:translate(0,-25%)}.modal.in .modal-dialog{-webkit-transform:translate(0,0);-ms-transform:translate(0,0);-o-transform:translate(0,0);transform:translate(0,0)}.modal-open .modal{overflow-x:hidden;overflow-y:auto}.modal-dialog{position:relative;width:auto;margin:10px}.modal-content{position:relative;background-color:#fff;-webkit-background-clip:padding-box;background-clip:padding-box;border:1px solid #999;border:1px solid rgba(0,0,0,.2);border-radius:6px;outline:0;-webkit-box-shadow:0 3px 9px rgba(0,0,0,.5);box-shadow:0 3px 9px rgba(0,0,0,.5)}.modal-backdrop{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1040;background-color:#000}.modal-backdrop.fade{filter:alpha(opacity=0);opacity:0}.modal-backdrop.in{filter:alpha(opacity=50);opacity:.5}.modal-header{min-height:16.43px;padding:15px;border-bottom:1px solid #e5e5e5}.modal-header .close{margin-top:-2px}.modal-title{margin:0;line-height:1.42857143}.modal-body{position:relative;padding:15px}.modal-footer{padding:15px;text-align:right;border-top:1px solid #e5e5e5}.modal-footer .btn+.btn{margin-bottom:0;margin-left:5px}.modal-footer .btn-group .btn+.btn{margin-left:-1px}.modal-footer .btn-block+.btn-block{margin-left:0}.modal-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}@media (min-width:768px){.modal-dialog{width:600px;margin:30px auto}.modal-content{-webkit-box-shadow:0 5px 15px rgba(0,0,0,.5);box-shadow:0 5px 15px rgba(0,0,0,.5)}.modal-sm{width:300px}}

.largethumb img {

	width: 100%;

}

.imgcompany {

	position: relative;

}

.imgcompany img {

	width: 100%;

}

.editphoto {

	position: absolute;

	padding: 3px 8px;

	right: 0;

	background-color: #fff;

	font-size: 18px;

}

.aboutcomp {

	margin-top: 11px;

	text-align: justify;

}

.aboutcomp h2 {

	margin-bottom: 5px;

}

</style>

<script language="javascript">

function buttondisabled(){

	$("#signypbutton").attr("diabled",true);

	$("#signypbutton").html('Please wait...');

	

}

</script>