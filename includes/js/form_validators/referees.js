<script language="JavaScript" type="text/javascript">
		var frmvalidator  = new Validator("referees");
		frmvalidator.EnableMsgsTogether();
		frmvalidator.addValidation("Name","req","Please enter name of the referee.");
		frmvalidator.addValidation("Designation","req"," Please enter designation of the referee.");
		frmvalidator.addValidation("Correspondence_Address","req","Please enter the referee's correspondence address.");
		frmvalidator.addValidation("Phone","req","Please enter a valid phone number.");
		frmvalidator.addValidation("Email","req","Please enter the email ID of referee.");
		
		frmvalidator.addValidation("Email","email","Please enter a valid email ID");
</script>
