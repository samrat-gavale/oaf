<script language="JavaScript" type="text/javascript">
		var frmvalidator  = new Validator("teaching_exp");
		frmvalidator.EnableMsgsTogether();
		frmvalidator.addValidation("University","req","Please enter your University name.");
		frmvalidator.addValidation("Designation","alphabetic_space","Designation should only contain alphabets.");
		frmvalidator.addValidation("From_Month","req","Please select From_Month.");
		frmvalidator.addValidation("From_Year","req","Please select From_Year.");
		frmvalidator.addValidation("To_Month","req","Please select To_Month.");
		frmvalidator.addValidation("To_Year","req","Please select To_Year");
		frmvalidator.addValidation("Monthly_Salary","req","Please enter your monthly salary.");
</script>
