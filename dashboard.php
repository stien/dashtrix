<?php /*
 *---------------------------------------------------------------
 * SYSTEM DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" directory.
 * Set the path if it is not in the same directory as this file.
 */
    $system_path = 'system';

/*
 *---------------------------------------------------------------
 * APPLICATION DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * directory than the default one you can set its name here. The directory
 * can also be renamed or relocated anywhere on your server. If you do,
 * use an absolute (full) server path.
 * For more info please see the user guide:
 *
 * https://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 */
    $application_folder = 'application';

/*
 *---------------------------------------------------------------
 * VIEW DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * If you want to move the view directory out of the application
 * directory, set the path to it here. The directory can be renamed
 * and relocated anywhere on your server. If blank, it will default
 * to the standard location inside your application directory.
 * If you do move this, use an absolute (full) server path.
 *
 * NO TRAILING SLASH!
 */
    $view_folder = '';


/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routes.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here. For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT: If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller. Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the $routing array below to use this feature
 */
    // The directory name, relative to the "controllers" directory.  Leave blank
    // if your controller is not in a sub-directory within the "controllers" one
    // $routing['directory'] = '';

    // The controller class file name.  Example:  mycontroller
    // $routing['controller'] = '';

    // The controller function you wish to be called.
    // $routing['function'] = '';


/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 */
    // $assign_to_config['name_of_config_item'] = 'value of config item';



// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

    // Set the current directory correctly for CLI requests
    if (defined('STDIN'))
    {
        chdir(dirname(__FILE__));
    }

    if (($_temp = realpath($system_path)) !== FALSE)
    {
        $system_path = $_temp.DIRECTORY_SEPARATOR;
    }
    else
    {
        // Ensure there's a trailing slash
        $system_path = strtr(
            rtrim($system_path, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
        ).DIRECTORY_SEPARATOR;
    }

    // Is the system path correct?
    if ( ! is_dir($system_path))
    {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
        exit(3); // EXIT_CONFIG
    }

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
    // The name of THIS file
    define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

    // Path to the system directory
    define('BASEPATH', $system_path);

    // Path to the front controller (this file) directory
    define('FCPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

    // Name of the "system" directory
    define('SYSDIR', basename(BASEPATH));

    // The path to the "application" directory
    if (is_dir($application_folder))
    {
        if (($_temp = realpath($application_folder)) !== FALSE)
        {
            $application_folder = $_temp;
        }
        else
        {
            $application_folder = strtr(
                rtrim($application_folder, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
            );
        }
    }
    elseif (is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR))
    {
        $application_folder = BASEPATH.strtr(
            trim($application_folder, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
        );
    }
    else
    {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
        exit(3); // EXIT_CONFIG
    }

    define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);

    // The path to the "views" directory
    if ( ! isset($view_folder[0]) && is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR))
    {
        $view_folder = APPPATH.'views';
    }
    elseif (is_dir($view_folder))
    {
        if (($_temp = realpath($view_folder)) !== FALSE)
        {
            $view_folder = $_temp;
        }
        else
        {
            $view_folder = strtr(
                rtrim($view_folder, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
            );
        }
    }
    elseif (is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR))
    {
        $view_folder = APPPATH.strtr(
            trim($view_folder, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
        );
    }
    else
    {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
        exit(3); // EXIT_CONFIG
    }

    define('VIEWPATH', $view_folder.DIRECTORY_SEPARATOR);


/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And heeeeeeere we go...
 */

require_once BASEPATH.'core/CodeIgniter.php';

require_once("common/header.php");?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url().'resources/frontend/css/circle.css'; ?>">


    <?php if(isset($_SESSION['thankyou'])){?>

            <div class="col-md-12">

                <div class="form-group">

                    <div class="successfull">

                        <?php echo $_SESSION['thankyou'];?>

                    </div>

                </div>

            </div>

            <?php } ?>

            <?php if(isset($_SESSION['error'])){?>

            <div class="col-md-12">

                <div class="form-group">

                    <div class="wrongerror">

                        <?php echo $_SESSION['error'];?>

                    </div>

                </div>

            </div>

            <?php } ?>

    

	<?php if(ACTYPE == "2" && $this->uri->segment(1) == "dashboard"){?>

  	<div class="row">

  		  	<div class="col-sm-12 m-b-30" style="text-align: center;">

				<h4 class="page-title">WELCOME TO OUR ICO</h4>

			</div>

			<div class="row">

				<div class="col-sm-3 m-b-30">

					<div class="card-box widget-box-1 boxdisplay">

						<span  style="font-size: 60px;" title="<?php $my_tokens__ = get_my_tokens(UID); echo number_format($my_tokens__,5);  ?>">
							<?php echo custom_number_format($my_tokens__,2); ?>
						</span>

						<p><strong>
          
                           <?php  echo $token_symbol->token_symbol?$token_symbol->token_symbol:'Token';
                             ?>
                         Balance

                        </strong></p>

					</div>	

				</div>

                <div class="col-sm-3 m-b-30">

                    <div class="card-box widget-box-1 boxdisplay">

						<span  style="font-size: 60px;">

							<?php $current_otken_price = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
							    echo '$'.number_format($current_otken_price->tokenPrice,2);
                            ?>
						</span>

                        <p><strong>

                                Current Price

                            </strong></p>

                    </div>

                </div>


				<a href="<?php echo base_url();?>buy-tokens">

				<div class="col-sm-3 m-b-30">

					<div class="card-box widget-box-1 boxdisplay">

						<span style="font-size: 60px;">
<?php  echo $token_symbol->token_symbol?$token_symbol->token_symbol:'Token';
                             ?>
							

						</span>

						<p><strong>Buy <?php  echo $token_symbol->token_symbol?$token_symbol->token_symbol:' '; ?> Tokens</strong></p>

					</div>	

				</div>

				</a>

				<a href="<?php echo base_url();?>bounties">

				<div class="col-sm-3 m-b-30">

					<div class="card-box widget-box-1 boxdisplay">

						<span>

							<img src="<?php echo base_url();?>resources/frontend/images/bounties-icon.png" width="85" alt="">

						</span>

						<p><strong>View Bounties</strong></p>

					</div>	

				</div>

				</a>


			</div>

            <div class="row">


                <div class="col-sm-3 m-b-30">

                    <div class="card-box widget-box-1 boxdisplay bg64cbe0 crlfff">

						<span  style="font-size: 60px;">

							<?php

 $current_active_camp = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$current_otken_price->ico_camp))->result_object()[0];


$now = time(); // or your date as well

$your_date = strtotime(date("Y-m-d",strtotime($current_active_camp->end_date)));
$datediff = $your_date - $now;

$x_roun_day_left =  round($datediff / (60 * 60 * 24));

echo $x_roun_day_left>0?$x_roun_day_left:'No';

?>
						</span>

                        <p><strong>

                                PRE-ICO Days Remaining

                            </strong></p>

                    </div>

                </div>

            <div class="col-sm-3 m-b-30">

                <div class="card-box widget-box-1 boxdisplay bg5d6afc crlfff">

						<span  style="font-size: 60px;">

							<?php echo $current_otken_price->tokenBonus.'%'; ?>
						</span>

                    <p><strong>

                           Current Bonus

                        </strong></p>

                </div>

            </div>

                <div class="col-sm-3 m-b-30">

                    <?php $ms_as_user = $this->front_model->get_query_simple('*','dev_web_user',array('uID'=>UID))->result_object()[0]; ?>
                    <?php if(!$ms_as_user->uWallet){ ?>
                        <a href="<?php echo base_url().'account/details'; ?>">
                    <?php } ?>
                    <div class="card-box widget-box-1 boxdisplay bg5d6afc crlfff <?php if($ms_as_user->uWallet) echo "bggreen"; else echo "bgred"; ?>">

						<span  style="font-size: 60px;">
                            <?php if($ms_as_user->uWallet) echo "Set"; else echo "Not Set"; ?>

						</span>

                        <p><strong>

                                Wallet Address

                            </strong></p>

                    </div>
                    <?php if(!$ms_as_user->uWallet){ ?>
                    </a>
                    <?php } ?>

                </div>

                <div class="col-sm-3 m-b-30" >
                    <?php

                    echo $user_verified;
                     if($user_verified==0){ ?>
                        <a href="<?php echo base_url().'verify'; ?>">
                     <?php } ?>
                    <div style="min-height: 189px;" class="card-box widget-box-1 boxdisplay bg5d6afc crlfff <?php if($user_verified==1) echo "bggreen"; else if($user_verified==2) echo "bgred"; else echo "bgorange";  ?>">

						<span  style="font-size: <?php if($user_verified==0) echo "45"; else echo "60"; ?>px;">
                          <?php if($user_verified==1) echo "Verified"; else if($user_verified==2) echo "Rejected"; else echo "Not Verified";  ?>

						</span>

                        <p><strong>

                                Account Status
                            </strong></p>

                    </div>
                     <?php if($user_verified==0){ ?>
                        </a>
                     <?php } ?>

                </div>

        </div>

	</div>

   <div class="row">

         <div class="col-sm-12 m-b-30">

        <div class="button-list pull-right m-t-15">

            <a class="btn btn-default" href="<?php echo base_url().'buy-tokens'; ?>">Buy Tokens</a>

        </div>

        <h4 class="page-title">Transactions</h4>

    </div>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="card-box m-b-50">

                <div class="table-responsive">

                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">

                    	<thead>

                    	<tr>
                        <th>Trans. Type</th>
                    	<th >Date</th>


                    	<th >Tokens</th>

                    	<th >Currency</th>

                    	<th >Amount Paid</th>

                    	<th >Status </th>

                    	<th >Action</th></tr>

                    	</thead>

                    	<?php

							$arr = array('uID' => UID);

							$config = $this->front_model->get_query_simple('*','dev_web_transactions',$arr);

							$transctions 	= $config->result_object();

                            // echo $this->db->last_query();

						?>

                    	<tbody>

                    	<?php 

							foreach($transctions AS $row){

								$arrcur = array('id' => $row->currency);

								$cour = $this->front_model->get_query_simple('*','dev_web_payment_options',$arrcur);

								$currency 	= $cour->result_object();

								//echo $row->datecreated;

						?>

                    		<tr>

                                <td>
                                <?php
                                if($row->t_type==2){
                                    echo "Completed A Survey";
                                }
                                else
                                {
                                    echo "Purchased Token";
                                }

                                 ?>
                             </td>

                    			<td><?php echo date("d F Y",strtotime($row->datecreated));?></td>

                    			<td><?php echo $row->tokens;?></td>

                    			<td><?php echo $currency[0]->name;?></td>

                    			<td><?php echo $row->amountPaid;?> <?php echo $row->amtType;?></td>

                    			<td><?php 

										if($row->status == "1"){echo "<div class='status-pending'>Pending</div>";} 

										else if($row->status == "2"){echo "<div class='status-confirm'>Confirmed</div>";} 

										else if($row->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}

										else if($row->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}

									?>

                   				</td>

                    			<td>

                                    <a href="<?php echo base_url().'transaction-details/'.$row->tID; ?>">

                                        <button class="btn btn-sm btn-default">

                                            View Details

                                        </button>

                                       

                                    </a>

                            </td>

                    		</tr>

                    	<?php } ?>

                    	</tbody>

                    </table>

                </div>

            </div>



        </div> <!-- end col -->

    </div>

    <?php } else if(ACTYPE == "1" && $this->uri->segment(1) == "admin" && $this->uri->segment(2) == "tranasctions"){ ?>

    <div class="row">

         <div class="col-sm-12 m-b-30">

            <div class="button-list pull-right m-t-15">   
<a class="btn btn-default" href="<?php echo base_url();?>admin/export/tranasctions/csv"><i class="fa fa-download"></i> Export CSV</a> 
<?php /* ?>
<a class="btn btn-default" href="<?php echo base_url();?>admin/export/users/comma"><i class="fa fa-download"></i> Export Comma Seprated</a> 
<a class="btn btn-default" href="<?php echo base_url();?>admin/export/users/tab"><i class="fa fa-download"></i> Export Tab Seprated</a> 
<?php */ ?>
</div> 

        	<h4 class="page-title">Transactions


            </h4>

    	</div>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="card-box m-b-50">

               <?php if(isset($_SESSION['thankyou'])){?>

            <div class="col-md-12">

                <div class="form-group">

                    <div class="successfull">

                    	<?php echo $_SESSION['thankyou'];?>

                    </div>

                </div>

            </div>

            <?php } ?>

            <?php if(isset($_SESSION['error'])){?>

            <div class="col-md-12">

                <div class="form-group">

                    <div class="wrongerror">

                    	<?php echo $_SESSION['error'];?>

                    </div>

                </div>

            </div>

            <?php } ?>

                <div class="">

                    <table  class="table table-actions-bar" id="requests-table" style="margin-bottom: 50px !important;">

                    	<thead>

                    	<tr>

                            <th>Trans. Type</th>

                    	<th >Name</th>

                    	<th >Username</th>

                    	<th >Tokens</th>

                    	<th >Currency</th>

                    	<th >Amount Paid</th>

                    	<th >Date</th>

                    	

                    	<th >Status </th>

                    	<th >Action</th></tr>

                    	</thead>

                    	<?php

							$arr = array();

							$config = $this->front_model->get_query_simple('*','dev_web_transactions',$arr);

							$transctions 	= $config->result_object();

						?>

                    	<tbody>

                    	<?php 

							foreach($transctions AS $row){

								$arrcur = array('curID' => $row->currency);

								$cour = $this->front_model->get_query_simple('*','dev_web_currency',$arrcur);

								$currency 	= $cour->result_object();

								//echo $row->datecreated;

								$arusr = array('uID' => $row->uID);

								$usrqry = $this->front_model->get_query_simple('*','dev_web_user',$arusr);

								$user 	= $usrqry->result_object();

						?>

                    		<tr>


                                 <td>
                                <?php
                                if($row->t_type==2){
                                    echo "Completed A Survey";
                                }
                                else
                                {
                                    echo "Purchased Token";
                                }

                                 ?>
                             </td>

                    			<td title="<?php echo $user[0]->uFname. " ".$user[0]->uLname;?>"><?php echo substr( $user[0]->uFname. " ".$user[0]->uLname,0,10)."...";?></td>

                    			<td><?php echo $user[0]->uUsername;?></td>

                    			<td><?php echo $row->tokens;?></td>

                    			<td><?php echo $currency[0]->currencyName;?></td>

                    			<td><?php echo $row->amountPaid;?> <?php echo $row->amtType;?></td>

                    			<td><?php echo date("d F Y",strtotime($row->datecreated));?></td>

                    			

                    			<td><?php 

										if($row->status == "1"){echo "<div class='status-pending'>Pending</div>";} 

										else if($row->status == "2"){echo "<div class='status-confirm'>Confirmed</div>";} 

										else if($row->status == "3"){echo "<div class='status-cancelled'>Cancelled</div>";}

										else if($row->status == "4"){echo "<div class='status-refunded'>Refunded</div>";}

									?>

                   				</td>

                    			<td>

                    				<?php 

										if($row->status == "1"){ ?>

                    				<div class="btn-group">

									  <button type="button" class="btn btn-info">Edit</button>

									  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

										<span class="caret"></span>

										<span class="sr-only">Toggle Dropdown</span>

									  </button>

									  <ul class="dropdown-menu">

										<li><a href="javascript:;" onClick="btnstatusupdate(2,<?php echo $row->tID;?>);">Conﬁrmed</a></li>

										<!--<li><a href="javascript:;" onClick="btnstatusupdate(1);">Pending</a></li>-->

										<li><a href="javascript:;" onClick="btnstatusupdate(3,<?php echo $row->tID;?>);">Cancelled</a></li>

										<li><a href="javascript:;" onClick="btnstatusupdate(4,<?php echo $row->tID;?>);">Refunded</a></li>

									  </ul>

									</div>

                    				<?php } ?>

                    			</td>

                    		</tr>

                    	<?php } ?>

                    	</tbody>

                    </table>

                </div>

            </div>



        </div> <!-- end col -->

    </div>

    <?php } else if(ACTYPE == "1" && $this->uri->segment(1) == "dashboard"){ ?>

    	<div class="row">

         <div class="col-sm-12 m-b-30">

        	<h4 class="page-title">WELCOME TO ADMIN DASHBOARD</h4>

    	</div>

    	</div>

    	<div class="row">

            <div class="col-sm-4 m-b-30">

                <div class="card-box widget-box-1 boxdisplay sales">

                    <span class="d-flip d-flip-all-time">$<?php echo custom_number_format($this->front_model->total_sales('all-time'),2);?></span>
                    <span class="d-flip d-flip-today">$<?php echo custom_number_format($this->front_model->total_sales(),2);?></span>
                    <span class="d-flip d-flip-week">$<?php echo custom_number_format($this->front_model->total_sales('week'),2);?></span>
                    <span class="d-flip d-flip-month">$<?php echo custom_number_format($this->front_model->total_sales('month'),2);?></span>
                    
                    

                    <p>Total Sales</p>
                    <span class="flip-control">
                        <a class="flip-all-time" href="javascript:dFlip('all-time','sales');">All</a> | 

                        <a class="flip-today" href="javascript:dFlip('today','sales');">Today</a> | 
                        <a class="flip-week" href="javascript:dFlip('week','sales');">Week</a> | 
                        <a class="flip-month" href="javascript:dFlip('month','sales');">Month</a>  
                    </span>

                </div>  

            </div>

			<div class="col-sm-4 m-b-30">

				<div class="card-box widget-box-1 boxdisplay token">
                    <span class="d-flip d-flip-all-time"><?php echo custom_number_format($this->front_model->totaltokensolds('all-time'),2);?></span>
                    <span class="d-flip d-flip-today"><?php echo custom_number_format($this->front_model->totaltokensolds(),2);?></span>
                    <span class="d-flip d-flip-week"><?php echo custom_number_format($this->front_model->totaltokensolds('week'),2);?></span>
					<span class="d-flip d-flip-month"><?php echo custom_number_format($this->front_model->totaltokensolds('month'),2);?></span>
                    

					<p>Tokens Sold</p>
                    <span class="flip-control">
                        <a class="flip-all-time" href="javascript:dFlip('all-time','token');">All</a>
                         | 
                        <a class="flip-today" href="javascript:dFlip('today','token');">Today</a> | 
                        <a class="flip-week" href="javascript:dFlip('week','token');">Week</a> | 
                        <a class="flip-month" href="javascript:dFlip('month','token');">Month</a> 
                    </span>

				</div>	

			</div>	

   			
            <?php /* ?>
   			<div class="col-sm-4 m-b-30">

				<div class="card-box widget-box-1 boxdisplay raised">

					<span class="d-flip d-flip-today">$200</span>
                    <span class="d-flip d-flip-week">$300</span>
                    <span class="d-flip d-flip-month">$5000</span>
                    <span class="d-flip d-flip-all-time">$700000</span>

					<p>Total Raised</p>
                    <span class="flip-control">
                        <a class="flip-today" href="javascript:dFlip('today','raised');">Today</a> | 
                        <a class="flip-week" href="javascript:dFlip('week','raised');">Week</a> | 
                        <a class="flip-month" href="javascript:dFlip('month','raised');">Month</a> | 
                        <a class="flip-all-time" href="javascript:dFlip('all-time','raised');">All</a>
                    </span>

				</div>	

			</div>	

            <?php */ ?>
  			

  			<div class="col-sm-4 m-b-30">

				<div class="card-box widget-box-1 boxdisplay trans">

                    <span  class="d-flip d-flip-all-time"><?php echo number_format($this->front_model->totaltransactions_2('all-time'));?></span>

                    <span  class="d-flip d-flip-today"><?php echo number_format($this->front_model->totaltransactions_2('today'));?></span>
                    <span  class="d-flip d-flip-week"><?php echo number_format($this->front_model->totaltransactions_2('week'));?></span>
                    <span  class="d-flip d-flip-month"><?php echo number_format($this->front_model->totaltransactions_2('month'));?></span>
					

					<p>Transactions</p>

                    <span class="flip-control">
                        <a class="flip-all-time" href="javascript:dFlip('all-time','trans');">All</a> | 

                        <a class="flip-today" href="javascript:dFlip('today','trans');">Today</a> | 
                        <a class="flip-week" href="javascript:dFlip('week','trans');">Week</a> | 
                        <a class="flip-month" href="javascript:dFlip('month','trans');">Month</a>
                    </span>

				</div>	
                

			</div>	

  			<div class="col-sm-4 m-b-30">

				<div class="card-box widget-box-1 boxdisplay visits">

                    <span><?php echo number_format($this->front_model->totalvisitors('today'));?></span>
                  

					<p>Visitors</p>

				</div>	

			</div>	

  			<div class="col-sm-4 m-b-30">

				<div class="card-box widget-box-1 boxdisplay users">

					<span><?php echo number_format($this->front_model->totalusers());?></span>

					<p>Users</p>

				</div>	

			</div>	


            <?php $current_otken_price = $this->front_model->get_query_simple('*','dev_web_token_pricing',array('status'=>1))->result_object()[0];
                              


         $current_active_camp = $this->front_model->get_query_simple('*','dev_web_ico_settings',array('id'=>$current_otken_price->ico_camp))->result_object()[0];

    
// echo date("Y-m-d",strtotime($current_active_camp->end_date)).'|'.date("Y-m-d",strtotime($current_active_camp->start_date));

$now = strtotime(date("Y-m-d")); // or your date as well

$your_date = strtotime(date("Y-m-d",strtotime($current_active_camp->end_date)));
$your_date_before = strtotime(date("Y-m-d",strtotime($current_active_camp->start_date)));
$datediff = $your_date - $now;

$your_date_before = $your_date - $your_date_before;
$your_date_before = round($your_date_before / (60 * 60 * 24));

  $x_roun_day_left =  round($datediff / (60 * 60 * 24));

  $days_percent = $x_roun_day_left>0?$x_roun_day_left:0;

 $days_percent = ($days_percent/$your_date_before)*100;
 $days_percent = number_format($days_percent);

 //tokens sold in this campaign
 $go_in_past = $your_date_before - $x_roun_day_left;
 $query     = $this->db->select('SUM(tokens) AS TOKENS')->where('DATE(datecreated) >= ',date("Y-m-d",strtotime("-".$go_in_past." days")))->where('status',2)->get('dev_web_transactions');


  $row = $query->result_object();
if($row[0]->TOKENS == NULL){
    $tokens_this_camp = "0";
} else {
    $tokens_this_camp = $row[0]->TOKENS;
}

 $query     = $this->db->select('SUM(usdPayment) AS TOKENS')->where('DATE(datecreated) >= ',date("Y-m-d",strtotime("-".$go_in_past." days")))->where('status',2)->get('dev_web_transactions');


  $row = $query->result_object();
if($row[0]->TOKENS == NULL){
    $usd_payment = "0";
} else {
    $usd_payment = $row[0]->TOKENS;
}


$total_token_buyers = $this->db->where('DATE(joinDate) >= ',date("Y-m-d",strtotime("-".$go_in_past." days")))->where('uStatus',1)->count_all_results('dev_web_user');


$so_percent_sold =  ($tokens_this_camp/$current_active_camp->tokens_for_sale)*100;
$so_percent_sold =  number_format($so_percent_sold);


$average_token_sold = $tokens_this_camp/$go_in_past;
$average_revenue = $usd_payment/$go_in_past;
$average_token_buyers = $total_token_buyers/$go_in_past;

 $token_revenue = $current_active_camp->tokens_for_sale*$current_otken_price->tokenPrice;

$token_revenue = ($usd_payment/$token_revenue)*100;

 ?>
  		
  			<div class="col-sm-4 m-b-30">

				<div class="card-box widget-box-1 boxdisplay easy" style="padding-bottom: 10px; padding-top:10px;">

					<div class="cm_miles easy" >CAMPAIGN MILESTONES</div>
                    <div class="cm_mile_under easy">
                        <div class="cm_mile_under_1 thirty_three text-center">
                            <div class="cm_mile_under_text  text-center">Days Left</div>
                            <div class="c100 p<?php echo $days_percent; ?> big  force-center font-75">
                                <span><?php echo $days_percent; ?>%</span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>

                        </div>
                        <div class="cm_mile_under_2 thirty_three text-center">
                            <div class="cm_mile_under_text  text-center">Tokens Sold</div>
                            <div class="c100 p<?php echo $so_percent_sold; ?> big  force-center font-75">
                                <span><?php echo $so_percent_sold; ?>%</span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>
                        </div>
                        <div class="cm_mile_under_3 thirty_three text-center">
                            <div class="cm_mile_under_text  text-center">Funds Raised</div>
                            <div class="c100 p75 big  force-center font-75">
                                <span>70%</span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>
                        </div>
                    </div>

				</div>	

			</div>	

            <div class="col-sm-6 m-b-30">
                <div class="card-box widget-box-1 easy">
                    <div class="col-md-12">
                        <div class="av_title">AVERAGE DAILY PERFORMANCE</div>
                    </div>
                    <div class="col-md-12 pd-10 f-20">
                        <div class="col-md-4 text-right">
                            <?php echo custom_number_format($average_token_sold,2); ?>
                        </div>
                        <div class="col-md-8">
                            Tokens Sold
                        </div>
                    </div>

                    <div class="col-md-12 pd-10 f-20">
                        <div class="col-md-4 text-right">
                            $<?php echo custom_number_format($average_revenue,2); ?>
                        </div>
                        <div class="col-md-8">
                            Total Revenue
                        </div>
                    </div>

                    <div class="col-md-12 pd-10 f-20">
                        <div class="col-md-4 text-right">
                            <?php echo custom_number_format($average_token_buyers,2); ?>
                        </div>
                        <div class="col-md-8">
                            Token Buyers
                        </div>
                    </div>


                    <div class="col-md-12 pd-10 f-20">
                        <div class="col-md-4 text-right">
                            <?php echo custom_number_format($average_token_buyers,2); ?>
                        </div>
                        <div class="col-md-8">
                            New Users
                        </div>
                    </div>

                </div>
            </div>

             <div class="col-sm-6 m-b-30">
                <div class="card-box widget-box-1 easy">
                    <div class="col-md-12">
                        <div class="av_title">CAMPAIGN MATRICS</div>
                    </div>
                    <div class="col-md-12 pd-10 f-20">
                        <div class="col-md-4 text-right  m-t-10">
                            <?php echo number_format($so_percent_sold,2); ?>%
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-12 nopad">Tokens Sold</div>
                            <div class="bg_dark_grey" style="float:left;height:18px; width: <?php echo number_format($so_percent_sold,2); ?>%;"></div>
                        </div>
                    </div>

                    <div class="col-md-12 pd-10 f-20">
                        <div class="col-md-4 text-right  m-t-10">
                            <?php echo number_format($token_revenue,2); ?>%
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-12 nopad">Token Revenue</div>
                            <div style="background:#77ffd3;float:left;height:18px; width: <?php echo number_format($token_revenue,2); ?>%;"></div>
                        </div>
                    </div>
                </div>
            </div>

   			

   			

    	</div>

    <?php } ?>



<?php require_once("common/footer.php");?>

<script language="javascript">

<?php if(ACTYPE == "1"){?>

function btnstatusupdate(val,id){

	var x = confirm("Are you sure you want to perform this action?");

	if (x){

		window.location='<?php echo base_url(); ?>admin/do/action/tranasctions/'+val+'/'+id;

		return true;

	}

	else {

		return false;

	}

}


function dFlip(period,cls)
{
    $('.'+cls).find(".d-flip").hide();
    $('.'+cls).find(".flip-control").find('a').css('color','#23527c');
    $('.'+cls).find(".d-flip-"+period).fadeIn();
    $('.'+cls).find(".flip-"+period).css('color','#000');

}

<?php } ?>

</script>


<style type="text/css">
    .bgorange{
        background: orange;
    }
</style>