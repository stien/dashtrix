<?php require_once("common/header.php");?>

<?php if(!isset($_REQUEST['link'])){ ?>
 <div class="fullcontent right clear">
 	<div class="dev-col-1 colbg">
        <h1>Job Details - : : - <?php echo $jobs[0]->jTitle;?></h1>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="detailspage">
         <?php 
		 	foreach($jobs as $row):
			$condition = array('cID' => $row->cID);
			$industry = $this->admin_model->get_table_data_condition('dev_web_categories',$condition);
			$condition2 = array('uID' => $row->uID);
			$user = $this->admin_model->get_table_data_condition('dev_web_user',$condition2);
		 ?>
            <tr>
              <th>Company Name</th>
              <td align="left"><?php echo $user[0]->uFname.' '.$user[0]->uLname; ?></td>
            </tr>
            <tr>
              <th>Job Title</th>
              <td align="left"><?php echo $row->jTitle; ?></td>
            </tr>
            <tr>
              <th>Department</th>
              <td align="left"><?php echo $row->uUsername; ?></td>
            </tr>
            <tr>
              <th>Industry</th>
              <td align="left"><?php echo $industry[0]->catName; ?></td>
            </tr>
            <tr>
              <th>Experience Level</th>
              <td align="left"><?php echo $row->jExpLevel; ?></td>
            </tr>
            <tr>
              <th>Total Vacancies</th>
              <td align="left"><?php echo $row->jVacancy; ?></td>
            </tr>
            <tr>
              <th>Required Skills</th>
              <td align="left"><?php echo $row->jRequiredSkills; ?></td>
            </tr>
            <tr>
              <th>Qualification</th>
              <td align="left"><?php echo $row->jQualification; ?></td>
            </tr> 
            <tr>
              <th>Job Nature</th>
              <td align="left"><?php echo $row->jNature; ?></td>
            </tr>
            <tr>
              <th>Job Shift</th>
              <td align="left"><?php echo $row->jShift; ?></td>
            </tr>
            <tr>
              <th>Travel Required</th>
              <td align="left"><?php if($row->jRequiredTravel == 1){echo "Required";} else {echo "<strong style='color:#f00'>Not Required</strong>";} ?></td>
            </tr>
            <tr>
              <th>Gender Specific</th>
              <td align="left"><?php echo $row->jGender; ?></td>
            </tr>
            <tr>
              <th>Salary</th>
              <td align="left"><?php echo $row->jStartSalary; ?> - <?php echo $row->jEndSalary; ?></td>
            </tr>
            <tr>
              <th>Benefits</th>
              <td align="left"><?php echo $row->jBenefits; ?></td>
            </tr>
            <tr>
              <th>City</th>
              <td align="left"><?php echo $row->jStateCity; ?></td>
            </tr>
            <tr>
              <th>Job Expiry</th>
              <td align="left"><?php echo date("M, d Y",strtotime($row->jExpiry)); ?></td>
            </tr>
            <tr>
              <th>User Status</th>
              <td align="left"><?php if($row->uStatus == '1'){echo 'Active';} else {echo '<span style="color:#096"><strong>In-Active</strong></span>';} ?></td>
            </tr>
 			<tr>
              	<th>Join Date</th>
              	<td align="left"><?php echo date("l, F d, Y",strtotime($row->joinDate)); ?></td>
            </tr>
            
             <tr>
              <th style="height:71px;">Logo/Profile Picture</th>
              <td align="left">
              	<?php if($row->uImage != ""){ ?>
                	<img src="<?php echo base_url(); ?>resources/uploads/profile/<?php echo $row->uImage; ?>" alt="Image" width="100px">
                <?php } else { ?>
                	<img src="<?php echo base_url(); ?>resources/uploads/profile/img_not_available.png" alt="No Image" width="100px">
                <?php } ?>
              </td>
            </tr>
            
            </tr>
        <?php endforeach; ?>
        </table>
      </div>
 </div>
 <?php } ?>
<?php require_once("common/footer.php"); ?>