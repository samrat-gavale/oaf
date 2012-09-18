<script language="JavaScript" type="text/javascript">
		var frmvalidator  = new Validator("sponsored_research");
		frmvalidator.EnableMsgsTogether();
		frmvalidator.addValidation("Completed_Nos","req","Please enter number of completed projects (0 if none).");
		frmvalidator.addValidation("Completed_Nos","numeric","Number of completed projects should be a numeric value.");
		frmvalidator.addValidation("Completed_Amount","req","Please enter the amount of grant of completed projects.");
		frmvalidator.addValidation("In_Progress_Nos","req","Please enter number of projects in progress (0 if none).");
		frmvalidator.addValidation("In_Progress_Nos","numeric","Number of projects in progress should be a numeric value.");
		frmvalidator.addValidation("In_Progress_Amount","req","Please enter the amount of grant of projects in progress.");
		frmvalidator.addValidation("Projects_List","req","Please upload the list of projects.");
</script>
