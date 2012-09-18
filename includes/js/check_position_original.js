<script type="text/javascript" language="JavaScript">

function CheckPositionSchool()
{
	theForm = document.forms["application_details"];
if(
   (theForm.Assistant_Professor.checked == false &&
	theForm.Assistant_Professor_Contract.checked == false &&
	theForm.Associate_Professor.checked == false && 
	theForm.Professor.checked == false 
	)
	||
	(
	theForm.Sch_Comp_Elec_Engg.checked == false &&
	theForm.Sch_Basic_Sci.checked == false &&
	theForm.Sch_Engg.checked == false && 
	theForm.Sch_Hum_Soc_Sci.checked == false
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
