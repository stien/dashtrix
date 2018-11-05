    
    </div>
	<!-- catagerios section -->
	<div class="clear"></div>
</div>
<?php 
unset($_SESSION['notify']);
?>
<script language="javascript" type="application/javascript" src="<?php echo base_url(); ?>resources/backend/js/jquery.min.js" runat="server"></script>
<script language="javascript" type="application/javascript" src="<?php echo base_url(); ?>resources/backend/js/datatable/jquery.dataTables.js" runat="server"></script>
<script language="javascript" type="application/javascript" src="<?php echo base_url(); ?>resources/backend/js/icheck/icheck.js" runat="server"></script>
<script language="javascript" type="application/javascript" src="<?php echo base_url(); ?>resources/backend/js/JQuerycustom.js" runat="server"></script>


<link href="<?php echo base_url(); ?>resources/frontend/fastselect/fastselect.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>resources/frontend/fastselect/fastselect.standalone.js"></script>
<script language="javascript">
$(document).ready(function(){
	$('.fastselect').fastselect();
});
</script>

<script language="javascript" type="application/javascript" src="<?php echo base_url(); ?>resources/backend/ckeditor/ckeditor.js" runat="server"></script>
<script language="javascript" type="application/javascript" src="<?php echo base_url(); ?>resources/backend/ckeditor/sample.js" runat="server"></script>
<script type="text/javascript">
	//<![CDATA[
	CKEDITOR.replace( 'texteditor',
	{
		fullPage : false,
		enterMode	 : Number(2),
		extraPlugins : 'docprops'
	});
	//]]>

</script>
</body>
</html>
