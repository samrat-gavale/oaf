<script type="text/javascript" language="JavaScript">

function checkCheckBoxes(theForm)
{
	if (
	theForm.Conditions_Read.checked == false ||
	theForm.Confirmed_Information.checked == false) 
	{
		alert ('Please tick the checkboxes!');
		return false;
	} 
	else 
	{ 	
		return true;
	}
}
</script> 
