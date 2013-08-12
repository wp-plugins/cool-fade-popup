/*
##########################################################################################################
###### Project   : Cool fade popup wordpress plugin 												######
###### File Name : content-management.php                   										######
###### Author    : Gopi.R (http://www.gopiplus.com/work/)                        					######
###### Link      : http://www.gopiplus.com/work/2011/01/08/cool-fade-popup/    						######
##########################################################################################################
*/

function PopUpFad_submit()
{
	if(document.PopUpFad_form.PopUpFad_text.value=="")
	{
		alert("Please enter the popup message.")
		document.PopUpFad_form.PopUpFad_text.focus();
		return false;
	}
	else if(document.PopUpFad_form.PopUpFad_group.value == "Select")
	{
		alert("Please select the popup group. This field is used to group the message.")
		document.PopUpFad_form.PopUpFad_group.focus();
		return false;
	}
	else if(document.PopUpFad_form.PopUpFad_status.value == "Select")
	{
		alert("Please select the display status.")
		document.PopUpFad_form.PopUpFad_status.focus();
		return false;
	}
}

function _PopUpFad_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_PopUpFad_display.action="options-general.php?page=cool-fade-popup&ac=del&did="+id;
		document.frm_PopUpFad_display.submit();
	}
}	

function _PopUpFad_redirect()
{
	window.location = "options-general.php?page=cool-fade-popup";
}

function PopUpFad_help()
{
	window.open("http://www.gopiplus.com/work/2011/01/08/cool-fade-popup/");
}