<?php include("common/header.php");?>



<div class="wrapper-page widht-800">

    <div class="card-box">

        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12">


                   <?php 

						$title = "EDIT ADMIN - ADMIN";



					?>

                   

                    <div class="tab-content">

                      <span class="signupformd"><?php echo $title;?></span>

                        <div class="tab-pane active" id="personal">

                            <form method="POST" action="" accept-charset="UTF-8" id="personal-info">

                                                    

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>First name <sup>*</sup></label>

                                            <input name="first_name" type="text" class="form-control" value="<?php echo $admin->uFname; ?>" required autofocus>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>Last name <sup>*</sup></label>

                                            <input name="last_name" type="text" class="form-control" required value="<?php echo $admin->uLname; ?>">

                                        </div>

                                    </div>

                                    <div class="col-md-6 " style="display: none;">

                                        <div class="form-group">

                                            <label>User Type <sup>*</sup></label>

                                            

                                            <select class="form-control" name="type" required>

                                    

                                            <option value="1" selected>Admin</option>

                                          

                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>E-mail <sup>*</sup></label>

                                            <input name="email" type="email" class="form-control" required value="<?php echo $admin->uEmail; ?>">
                                            <input name="to_admin_users" type="hidden" value="1">

                                        </div>

                                    </div>

                                    

                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tools Access</label>
                                            <label>
                                                <input type="checkbox" name="admin_roles[]" value="-1" class="at_least_one only_one_c" <?php if(in_array(-1, $roles_edit)) echo "checked"; ?>>
                                                Full Amin Access
                                            </label>
                                            <div class="easy on_me_c">
                                                <br><br>
                                            <label>Or select from the following</label><br><br>

                                                <label>
                                                    <input type="checkbox" name="admin_roles[]" value="1" class="at_least_one" <?php if(in_array(1, $roles_edit)) echo "checked"; ?>>
                                                    ICO Settings
                                                </label>

                                                <label>
                                                    <input type="checkbox" name="admin_roles[]" value="2" class="at_least_one" <?php if(in_array(2, $roles_edit)) echo "checked"; ?>>
                                                    Site Settings
                                                </label>

                                                <label>
                                                    <input type="checkbox" name="admin_roles[]" value="4" class="at_least_one" <?php if(in_array(4, $roles_edit)) echo "checked"; ?>>
                                                    Bounty Campaigns
                                                </label>

                                                <label>
                                                    <input type="checkbox" name="admin_roles[]" value="3" class="at_least_one" <?php if(in_array(3, $roles_edit)) echo "checked"; ?>>
                                                    Reports
                                                </label>
                                                <label>
                                                    <input type="checkbox" name="admin_roles[]" value="5" class="at_least_one" <?php if(in_array(5, $roles_edit)) echo "checked"; ?>>
                                                    ICO Tools
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                  


                                    <div class="col-md-6 col-md-offset-3 m-t-40">

                                        <div class="form-group">

                                            <button class="btn btn-default btn-block btn-lg" type="submit">

                                              Update Admin

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
    $(".only_one_c").click(function(){
    if($(this).is(':checked')){
        $(".on_me_c").hide();
    }
    else
    {
        $(".on_me_c").show();
    }
});

function detectRequired(that)
{

    var x = false;
    $(".at_least_one").each(function(i,v){
        if($(this).val())
            x = true;
    });

    if(x)
    {
        return true;
    }
    else
    {
        alert("You need to assign at least one role to this admin user");
        return false;
    }
}


</script>





</body>

</html>

