<script language="JavaScript" type="text/javascript">
		var frmvalidator  = new Validator("thesis_guidance");
		frmvalidator.EnableMsgsTogether();
		frmvalidator.addValidation("Completed","req","Please enter the number of supervisions completed. (enter 0 if none)");
		frmvalidator.addValidation("Completed","numeric","Number of completed supervisions should be a numeric value.");
		frmvalidator.addValidation("In_Progress","req","Please enter the number of supervisions in progress. (enter 0 if none).");
		frmvalidator.addValidation("In_Progress","numeric","Number of supervisions in progress should be a numeric value.");
		frmvalidator.addValidation("Guidance_List","req","Please upload the list of supervisions.");
</script>
