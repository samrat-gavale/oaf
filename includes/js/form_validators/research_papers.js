<script language="JavaScript" type="text/javascript">
		var frmvalidator  = new Validator("research_papers");
		frmvalidator.EnableMsgsTogether();
		frmvalidator.addValidation("Num_Books","req","Please enter number of books published. (enter 0 if none).");
		frmvalidator.addValidation("Num_Books","numeric","Number of books published should be a numeric value.");
		frmvalidator.addValidation("Num_Nat_Jou","req","Please enter number of papres published in natioanl journals. (enter 0 if none).");
		frmvalidator.addValidation("Num_Nat_Jou","numeric","Number of papres published in natioanl journals should be a numeric value.");
		frmvalidator.addValidation("Num_Int_Jou","req","Please enter number of papres published in internatioanl journals. (enter 0 if none).");
		frmvalidator.addValidation("Num_Int_Jou","numeric","Number of papres published in internatioanl journals should be a numeric value.");
		frmvalidator.addValidation("Num_Nat_Conf","req","Please enter number of papres published in natioanl confernces. (enter 0 if none).");
		frmvalidator.addValidation("Num_Nat_Conf","numeric","Number of papres published in natioanl confernces should be a numeric value.");
		frmvalidator.addValidation("Num_Int_Conf","req","Please enter number of papres published in internatioanl confernces. (enter 0 if none).");
		frmvalidator.addValidation("Num_Int_Conf","numeric","Number of papres published in internatioanl confernces should be a numeric value.");
		frmvalidator.addValidation("Publications_List","req","Please upload the list of publications.");
</script>
