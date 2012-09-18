<script language="JavaScript" type="text/javascript">
		var frmvalidator  = new Validator("change_pass");
		frmvalidator.EnableMsgsTogether();
		frmvalidator.addValidation("Password","req","Please enter your new password.");
		frmvalidator.addValidation("ConfirmPassword","req","Please confirm your new password.");
		frmvalidator.addValidation("ConfirmPassword","eqelmnt=Password", "The confirmed password is not same as password");
		frmvalidator.addValidation("Password","minlength=5","The length of password should be five cahracters or more.");
		frmvalidator.addValidation("Password","maxlength=20","The length of password should be twenty characters or more.");
</script>
