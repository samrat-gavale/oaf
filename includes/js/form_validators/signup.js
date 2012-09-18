<script language="JavaScript" type="text/javascript">
		var frmvalidator  = new Validator("signup");
		frmvalidator.EnableMsgsTogether();
		frmvalidator.addValidation("EmailID","req","Please enter your Email ID.");
		frmvalidator.addValidation("EmailID","email","Please enter a vaild Email ID.");
		frmvalidator.addValidation("ConfirmEmailID","req","Please confirm your Email ID.");
		frmvalidator.addValidation("ConfirmEmailID","eqelmnt=EmailID", "The confirmed Email ID is not same as Email ID");
		frmvalidator.addValidation("Password","req","Please enter your password.");
		frmvalidator.addValidation("Password","minlength=5","The length of password should be five cahracters or more.");
		frmvalidator.addValidation("Password","maxlength=20","The length of password should be twenty characters or more.");
		frmvalidator.addValidation("ConfirmPassword","req","Please confirm your password.");
		frmvalidator.addValidation("ConfirmPassword","eqelmnt=Password", "The confirmed password is not same as password");
</script>
