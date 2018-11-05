<?php require_once("common/header.php");?>
    <div class="fullcontent right clear">
      <?php if(isset($_GET['type']) && $_GET['type'] == 'edit' && isset($_GET['uid']))
	{
		$link = 'edit_user';
		$edit = 'Edit';
		foreach($edit_user as $editval):
			$cID	 	= $editval->cID;
			$fname	 	= $editval->uFname;
			$lname	 	= $editval->uLname;
			$uEmail		= $editval->uEmail;
			$uCountry	= $editval->uCountry;
			$uGender	= $editval->uGender;
			$uPhone		= $editval->uPhone;
			$uEstablished		= $editval->uEstablished;
			$uNoEmp		= $editval->uNoEmp;
			$uAddress	= $editval->uAddress;
			$uWebsite	= $editval->uWebsite;
			$uAbout		= $editval->uAbout;
			$uActType	= $editval->uActType;
			$uPayment	= $editval->uPayment;
			$uStatus 	= $editval->uStatus;
			$uID		= $editval->uID;
			$uAdverts 	= $editval->uAdverts;
			$uCanSearch 	= $editval->uCanSearch;
		endforeach;
	}
	else
	{
		$link = 'add_user';
		$cID 		= 0;
		$fname	 	= '';
		$lname		= '';
		$uEmail	 	= '';
		$uGender	= '';
		$uPhone		= '';
		$uCountry	= '';
		$uActType	= '1';
		$uEstablished = 0;
		$uNoEmp 	= 0;
		$uAddress	= '';
		$uWebsite	= '';
		$uAbout	= '';
		$uPayment	= '';
		$uType   	= '';
		$uStatus 	= 1;
		$uID		= '';
		$uAdverts 	= '';
		$uCanSearch 	= '';
		$edit = 'Add';
	}
?>
      <form name="category" id="category" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/<?php echo $link; ?>/">
        <div class="dev-col-2 colbg left">
          <div class="ContentDiv">
            <h1><?php echo $edit;?> New User</h1>
            <div class="formwrap">
              <label> User Type: </label>
              <select name="userType" id="userType" required class="selectbox" <?php if($edit == "Edit"){?>style="background:#f0f0f0;" disabled<?php }?>  onChange="showcompany(this.value)">
                <option value="">--- Select Type ---</option>
                <option value="1" <?php if($uActType == 1){echo 'SELECTED';} ?>>Jobseeker</option>
                <option value="2" <?php if($uActType == 2){echo 'SELECTED';} ?>>Recruiter</option>
                <option value="0" <?php if($uActType == 0){echo 'SELECTED';} ?>>Agent</option>
              </select>
            </div>
            <div id="companydetails" <?php if($uActType == 2){echo 'style="display:block;"';} ?>>
                <div class="formwrap" id="industry">
                  <label> Industry: </label>
                  <select name="industry" id="industry"  class="selectbox textarea">
                    <option value="">--- Select Industry ---</option>
                    <?php foreach($industry as $industrydata): ?>
                    <option value="<?php echo $industrydata->cID;?>" <?php if($industrydata->cID == $cID){echo 'SELECTED';} ?>><?php echo $industrydata->catName;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
            </div>
            <div class="formwrap">
              <label> First Name: </label>
              <input type="text" value="<?php echo $fname; ?>" required name="fname" id="fname" />
              <input type="hidden" value="<?php echo $uID; ?>" required name="uID" id="uID" />
            </div>
            <div class="formwrap">
              <label> Last Name: </label>
              <input type="text" value="<?php echo $lname; ?>" required name="lname" id="lname" />
            </div>
            <div class="formwrap">
              <label> Email Address: </label>
              <input type="email" value="<?php echo $uEmail; ?>" required name="emailadd" id="emailadd" />
            </div>
            <?php 
			if(!isset($_GET['type']) && !isset($_GET['uid']))
			{
			?>
            <div class="formwrap">
              <label> password: </label>
              <input type="text" value="" required name="password" id="password" />
            </div>
            <?php } ?>
            
            <div class="formwrap">
              <label> Gender: </label>
              <select name="uGender" id="uGender" class="selectbox">
                <option value="">--- Select Type ---</option>
                <option value="Male" <?php if($uGender == 'Male'){echo 'SELECTED';} ?>>Male</option>
                <option value="Female" <?php if($uGender == 'Female'){echo 'SELECTED';} ?>>Female</option>
              </select>
            </div>
            
            <div class="formwrap">
              <label> Status: </label>
              <input type="radio" name="catStatus" id="catStatus" <?php if($uStatus == 1){echo 'checked';} ?> value="1" />
              <span>Active</span>
              <input type="radio" name="catStatus" id="catStatus" <?php if($uStatus == 0){echo 'checked';} ?> value="0" />
              <span>In-Active</span> </div>
            
          </div>
        </div>
        <!--Extra Information-->
        <div class="dev-col-2 colbg left" style="margin-left:1%;">
          <div class="ContentDiv">
            <h1>User Additional Information</h1>
            <div class="formwrap">
              <label> Country: </label>
              <select name="country" id="country" class="selectbox textarea">
                <option value="">--- Select Country ---</option>
                <?php foreach($country as $countrydata): ?>
                <option value="<?php echo $countrydata->country_name;?>" <?php if($countrydata->country_name == $uCountry){echo 'SELECTED';} ?>><?php echo $countrydata->country_name;?></option>
                <?php endforeach;?>
              </select>
            </div>
            <div class="formwrap">
              <label> Phone Number: </label>
              <input type="text" value="<?php echo $uPhone; ?>" name="phone" id="phone" />
            </div>
          <div id="companydetails" <?php if($uActType == 2){echo 'style="display:block;"';} ?>>
            <div class="formwrap">
              <label> Established In: </label>
              <input type="date" value="<?php echo $uEstablished; ?>" name="established" id="established" />
            </div>
            <div class="formwrap">
              <label> No. Of Employees: </label>
              <input type="number" value="<?php echo $uNoEmp; ?>" name="employesnum" id="employesnum" />
            </div>
            <div class="formwrap">
              <label> Company Address: </label>
              <input type="text" value="<?php echo $uAddress; ?>" name="address" id="address" />
            </div>
            <div class="formwrap">
              <label> Company Website: </label>
              <input type="text" value="<?php echo $uWebsite; ?>" name="website" id="website" />
            </div>
            <div class="formwrap">
              <label> Company Information: </label>
              <textarea name="companyinfo" class="textarea" id="companyinfo"><?php echo $uAbout;?></textarea>
            </div>
          
          <?php /*?><div class="formwrap">
           	  <label> Payment Status: </label>
              	<select name="payment" id="payment" required class="selectbox">
    	            <option value="">--- Select Payment Status ---</option>
	                <option value="1" <?php if($uPayment == 1){echo 'SELECTED';} ?>>Paid</option>
                    <option value="2" <?php if($uPayment == 2){echo 'SELECTED';} ?>>Pending</option>
              </select>
            </div><?php */?>
          
          <div class="formwrap">
              	<label> Number Of Adverts: </label>
              	<select name="advert" id="advert" class="selectbox">
    	            <option value="">--- Select Number of Adverts ---</option>
                    <?php for($i=1;$i<=10;$i++):?>
	                <option value="<?php echo $i;?>" <?php if($uAdverts == $i){echo 'SELECTED';} ?>><?php echo $i;?> Advert(s)</option>
                    <?php endfor;?>
              </select>
            </div>  
          
          <div class="formwrap">
              	<label> Candidate Search Feature: </label>
              	<select name="candidateSearch" id="candidateSearch" class="selectbox">
    	            <option value="">--- Select Candidate Search ---</option>
	                <option value="1" <?php if($uCanSearch == '1'){echo 'SELECTED';} ?>>1 Day</option>
                    <option value="7" <?php if($uCanSearch == '7'){echo 'SELECTED';} ?>>1 Week</option>
                    <option value="28" <?php if($uCanSearch == '28'){echo 'SELECTED';} ?>>1 Month</option>

              </select>
            </div>
          </div>
            <div class="formwrap">
              <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-lg btn-green right" />
            </div>
          </div>
        </div>
      </form>
    </div>
    <?php require_once("common/footer.php"); ?>
	<script language="javascript">
	function showcompany(id){
		if(id == 2){ 
			$('[id="companydetails"]').show();
		}
		else{
			$('[id="companydetails"]').find('input,select,textarea').val('');
			$('[id="companydetails"]').hide();
		}
	}
	</script>