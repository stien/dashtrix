<?php require_once("common/header.php");?>
	<?php
		$c2 = array();
		$us =  $this->front_model->get_query_simple('*','dev_web_ref_setting',$c2);
		$referrel = $us->result_object();

		$c22 = array('uID'=>UID);
		$us2 =  $this->front_model->get_query_simple('*','dev_web_user',$c22);
		$user = $us2->result_object();
	?>
    	<div class="row">
         <div class="col-sm-12 m-b-30">
        	<h4 class="page-title">REFERRAL PROGRAM</h4>
    	</div>
    	</div>
    	<div class="row">
    		<div class="col-sm-12 m-b-30">
    		<div class="bgdark">
    			<?php echo $referrel[0]->tokenTitle;?>
    		</div>
			</div>
    	</div>
    	<div class="row">
			<div class="col-sm-3 m-b-30">
				<div class="card-box widget-box-1 boxdisplay">
					<span>0</span>
					<p>Your Referrals</p>
				</div>	
			</div>	
   			
   			<div class="col-sm-3 m-b-30">
				<div class="card-box widget-box-1 boxdisplay">
					<span>0</span>
					<p>Token Earned</p>
				</div>	
			</div>	
  			
  			<div class="col-sm-6 m-b-30">
				<div class="card-box widget-box-1 usrinfodip">
					<p>
						Email Address: <br>
						<span><?php echo $user[0]->uEmail;?></span>
					</p>
					<p>ETH Wallet: <br>
						<span><?php echo $user[0]->uWallet;?></span>
					</p>
					<p>Telegram Username: <br>
						<span><?php echo $user[0]->uTelegram;?></span>
					</p>
				</div>	
				
			</div>	 
   			<hr>
				
			<div class="row">
			<div class="col-sm-12 m-b-30">
				<div class="card-box widget-box-1">
					<h4><strong>GENERAL REFERRAL RULES</strong> </h4>
					<p>
						<?php echo $referrel[0]->tokenText;?>
					</p>
				</div>
			</div>
			</div>
    	</div>
    
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
<?php } ?>
</script>
