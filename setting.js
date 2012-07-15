/*
##########################################################################################################
###### Project   : cool fade popup  																######
###### File Name : content-management.php                   										######
###### Author    : Gopi.R (http://www.gopipulse.com/work/)                        					######
###### Link      : http://www.gopipulse.com/work/2011/01/08/cool-fade-popup/    						######
##########################################################################################################
*/


function PopUpFad_submit()
{
	if(document.PopUpFad_form.PopUpFad_text.value=="")
	{
		alert("Please enter the message.")
		document.PopUpFad_form.PopUpFad_text.focus();
		return false;
	}
	else if(document.PopUpFad_form.PopUpFad_status.value=="")
	{
		alert("Please select the display status.")
		document.PopUpFad_form.PopUpFad_status.focus();
		return false;
	}
	else if(document.PopUpFad_form.PopUpFad_group.value=="")
	{
		alert("Please enter the group name. this field is used to group the message.")
		document.PopUpFad_form.PopUpFad_group.focus();
		return false;
	}
}

function _PopUpFad_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.PopUpFad_Display.action="options-general.php?page=cool-fade-popup/content-management.php&AC=DEL&DID="+id;
		document.PopUpFad_Display.submit();
	}
}	

function _PopUpFad_redirect()
{
	window.location = "options-general.php?page=cool-fade-popup/content-management.php";
}