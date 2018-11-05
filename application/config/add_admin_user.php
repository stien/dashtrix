<?php include("common/header.php");?>

<div class="wrapper-page widht-800">
    <div class="card-box">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                   <?php 
						$title = "ADD NEW USER - ADMIN";
					?>
                   
                    <div class="tab-content">
                      <span class="signupformd"><?php echo $title;?></span>
                        <div class="tab-pane active" id="personal">
                            <form method="POST" action="<?php echo base_url();?>do/admin/user/signup" accept-charset="UTF-8" id="personal-info">
                                                    
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First name <sup>*</sup></label>
                                            <input name="first_name" type="text" class="form-control" value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['first_name'];}?>" required autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last name <sup>*</sup></label>
                                            <input name="last_name" type="text" class="form-control" required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['last_name'];}?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>User Type <sup>*</sup></label>
                                            
                                            <select class="form-control" name="type" required>
                                            <option selected="selected" disabled="disabled" hidden="hidden" value="">Choose</option>
                                            <option value="2" <?php if(isset($_SESSION['wrongsignup'])){if($_SESSION['wrongsignup']['type'] == "1"){echo "SELECTED";}}?>>Token Buyer</option>
                                            <option value="4" <?php if(isset($_SESSION['wrongsignup'])){if($_SESSION['wrongsignup']['type'] == "4"){echo "SELECTED";}}?>>Airdrop or Bounty</option>
                                            <option value="3" <?php if(isset($_SESSION['wrongsignup'])){if($_SESSION['wrongsignup']['type'] == "3"){echo "SELECTED";}}?>>Market Affiliate</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>E-mail <sup>*</sup></label>
                                            <input name="email" type="email" class="form-control" required value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone number</label>
                                            <input name="phone" type="text" class="form-control" value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['phone'];}?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date of birth</label>
                                            <div class="input-group">
                                                <input name="birth_date" type="text" class="form-control" placeholder="mm/dd/yyyy" id="birth_date" value="<?php if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['birth_date'];}?>">
                                                <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input name="address" type="text" class="form-control" value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['address'];}?>">
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Country <sup>*</sup></label>
                                            
                                            <select class="form-control" name="country" required>
                                            <option selected="selected" disabled="disabled" hidden="hidden" value="">Choose</option>
                                            <?php
												foreach($countries as $country){
											?>
                                            <option value="<?php echo $country->id;?>" <?php if(isset($_SESSION['wrongsignup'])){if($_SESSION['wrongsignup']['country'] == $country->id){echo "SELECTED";}}?>><?php echo $country->nicename;?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input name="city" type="text" class="form-control" value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['city'];}?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Username <sup>*</sup></label>
                                            <input name="username" type="text" class="form-control" required value="<?php  if(isset($_SESSION['wrongsignup'])){echo $_SESSION['wrongsignup']['username'];}?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password <sup>*</sup></label>
                                            <input name="password" type="password" disabled class="form-control" required>
                                            <p class="text-muted font-13">Password will be generated automatically and will email to user.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-md-offset-3 m-t-40">
                                        <div class="form-group">
                                            <button class="btn btn-default btn-block btn-lg" type="submit">
                                               Add New User
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
</script>


</body>
</html>
