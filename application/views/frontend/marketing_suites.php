<?php require_once("common/header.php");?>

    <div class="row">

         <div class="col-sm-12 m-b-30">

        	<h4 class="page-title">Marketing Suite</h4>

    	</div>

    </div>

    <div class="row">
				<a href="<?php echo base_url().'admin/bounty-missions'; ?>">
					<div class="col-sm-3 m-b-30">
						<div class="card-box widget-box-1 boxdisplay">
							<span>
								<img src="<?php echo base_url();?>resources/frontend/images/bounty-missions.png" height="77" alt="">
							</span>
							<p><strong>
							 Bounty Campaign Syndication
							</strong></p>
						</div>
					</div>
				</a>
				<a href="<?php echo $accounts_url.'redirect-to/ico-directory-submission'; ?>">
					<div class="col-sm-3 m-b-30">
						<div class="card-box widget-box-1 boxdisplay">
							<span>
								<img src="<?php echo base_url();?>resources/frontend/images/screenshot_7857_clipped_rev_1.png" height="77" alt="">
							</span>
							<p><strong>
							 ICO Directory Tool
							</strong></p>
						</div>
					</div>
				</a>
				<a href="<?php echo base_url().'admin/sponsored-predictions' ?>">
					<div class="col-sm-3 m-b-30">
						<div class="card-box widget-box-1 boxdisplay">
							<span>
								<img src="<?php echo base_url();?>resources/frontend/images/stox.png" height="60" alt="" style="padding:6px;">
							</span>
							<p><strong>
							 Sponsored Predictions
							</strong></p>
						</div>
					</div>
				</a>
				<a href="<?php echo $accounts_url.'redirect-to/paid-content-placement'; ?>">
					<div class="col-sm-3 m-b-30">
						<div class="card-box widget-box-1 boxdisplay">
							<span>
								<img src="<?php echo base_url();?>resources/frontend/images/news-icon.png" height="77" alt="">
							</span>
							<p><strong>
							 Content Promotion
							</strong></p>
						</div>
					</div>
				</a>
        <?php /* ?>
				<a href="#">
					<div class="col-sm-3 m-b-30">
						<div class="card-box widget-box-1 boxdisplay">
							<span>
								<img src="<?php echo base_url();?>resources/frontend/images/screenshot_7858.png" height="77" alt="">
							</span>
							<p><strong>
							 Influencer Marketing
							</strong></p>
						</div>
					</div>
				</a>
				<a href="#">
					<div class="col-sm-3 m-b-30">
						<div class="card-box widget-box-1 boxdisplay">
							<span>
								<img src="<?php echo base_url();?>resources/frontend/images/affiliates.png" height="77" alt="">
							</span>
							<p><strong>
							 Affiliate Manager
							</strong></p>
						</div>
					</div>
				</a>
				<a href="#">
					<div class="col-sm-3 m-b-30">
						<div class="card-box widget-box-1 boxdisplay">
							<span>
								<img src="<?php echo base_url();?>resources/frontend/images/email.png" height="77" alt="">
							</span>
							<p><strong>
							 Email Campaigns
							</strong></p>
						</div>
					</div>
				</a>
				<a href="#">
					<div class="col-sm-3 m-b-30">
						<div class="card-box widget-box-1 boxdisplay">
							<span>
								<img src="<?php echo base_url();?>resources/frontend/images/video_reviews.png" height="77" alt="">
							</span>
							<p><strong>
							 Video Reveiws
							</strong></p>
						</div>
					</div>
				</a>
        <?php */ ?>
			</div>

<?php require_once("common/footer.php");?>
<?php require_once("common/compaign.php"); ?>
<style>
.boxdisplay{
  min-height: 182px;
}
</style>
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
