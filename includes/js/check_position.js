<script type="text/javascript" language="JavaScript">

function CheckPositionSchool(theForm)
{
if(
   (theForm.Assistant_Professor.checked == false &&
	theForm.Assistant_Professor_Contract.checked == false
	)
	||
	(
	theForm.Sch_Comp_Elec_Engg.checked == false &&
	theForm.Sch_Engg.checked == false
	)
   )
	{
		alert ('Please select atleast one post and one school.');
		return false;
	} 
	else 
	{ 	
		return true;
	}
}
</script> 
