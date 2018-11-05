/*
****** Custom Jquery to call on website
****** Bilal Yousaf
****** Web Developer
*/

/* Left navbar Jquery*/
$(document).ready(function () {
	/***********LEFT NAV BAR*************/
    leftnavbar();
	/***********DATATABLE*************/
	$('#categories,#categories2').dataTable();
	
	$("[id='buttonadd']").click(function(){
		$("#newboxwrap").slideToggle();
	});
   	$('input').iCheck({
   		checkboxClass: 'icheckbox_flat',
    	radioClass: 'iradio_flat'
  	});
	
	/***********SELECTBOX*************/
	/*$('select').each(function () {
    // Cache the number of options
    var $this = $(this),
    numberOfOptions = $(this).children('option').length;
    // Hides the select element
    $this.addClass('s-hidden');
    // Wrap the select element in a div
    $this.wrap('<div class="select"></div>');
    // Insert a styled div to sit over the top of the hidden select element
    $this.after('<div class="styledSelect"></div>');
    // Cache the styled div
    var $styledSelect = $this.next('div.styledSelect');
    // Show the first select option in the styled div
    $styledSelect.text($this.children('option').eq(0).text());
    // Insert an unordered list after the styled div and also cache the list
    var $list = $('<ul />', {
        'class': 'options'
    }).insertAfter($styledSelect);
    // Insert a list item into the unordered list for each select option
    for (var i = 0; i < numberOfOptions; i++) {
        $('<li />', {
            text: $this.children('option').eq(i).text(),
            rel: $this.children('option').eq(i).val()
        }).appendTo($list);
    }
    // Cache the list items
    var $listItems = $list.children('li');
    // Show the unordered list when the styled div is clicked (also hides it if the div is clicked again)
    $styledSelect.click(function (e) {
        e.stopPropagation();
        $('div.styledSelect.active').each(function () {
            $(this).removeClass('active').next('ul.options').hide();
        });
        $(this).toggleClass('active').next('ul.options').toggle();
		
    });
    // Updates the select element to have the value of the equivalent option
    $listItems.click(function (e) {
        e.stopPropagation();
        $styledSelect.text($(this).text()).removeClass('active');
        $this.val($(this).attr('rel'));
        $list.hide();
        
    });
    // Hides the unordered list when clicking outside of it
    $(document).click(function () {
        $styledSelect.removeClass('active');
        $list.hide();
    });
	});*/
});

// SELECT CHANGE FUNCTION
/*$(document).ready(function() {
    $('#selecctall').click(function(event) {  
		//on click 
        if(this.checked) { // check select status
            $('[class=checkbox1]').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('[class=checkbox1]').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
});*/

// LEFT NAV BAR
function leftnavbar()
{
	$(".leftnav ul li").click(function () {
		$(".leftnav ul li").removeClass('activeclass');
		$(this).siblings().find('ul').slideUp(400);
		$(this).find('ul').slideDown(400);      
		$(this).addClass('activeclass');
    });
}
