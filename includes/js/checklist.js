<script type="text/javascript" language="JavaScript">
function checkCheckBoxes(theForm)
{
	if 
	(
	theForm.Photograph.checked == false ||
	theForm.Personal.checked == false ||
	theForm.Academic_Record.checked == false ||
	theForm.Research_Experience.checked == false ||
	theForm.Publications.checked == false ||
	theForm.Awards.checked == false ||
	theForm.Research_Plan.checked == false ||
	theForm.Teaching_Plan.checked == false ||
	theForm.Referee.checked == false ||
	theForm.Terms.checked == false 
	)
	{
		alert ('Please tick all the necessary checkboxes!');
		return false;
	} 
	else
	{ 	
		return true;
	}
}
</script> 
