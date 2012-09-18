<script language="JavaScript" type="text/javascript">
		var frmvalidator  = new Validator("personal_info");
		frmvalidator.EnableMsgsTogether();
		frmvalidator.addValidation("Lastname","req","Please enter your last name.");
		frmvalidator.addValidation("Lastname","alphabetic_space","Last name should only contain alphabets and spaces (if required).");
		frmvalidator.addValidation("Correspondence_Address","req","Please enter your correspondence address.");
		frmvalidator.addValidation("Correspondence_eMail","req","Please enter your correspondence email ID.");
		frmvalidator.addValidation("Correspondence_eMail","email","Please enter a valid correspondence email ID.");
		frmvalidator.addValidation("Correspondence_Phone","req","Please enter your correspondence phone number");
		frmvalidator.addValidation("Permanent_Address","req","Please enter your permanent address.");
		frmvalidator.addValidation("Permanent_eMail","email","Please enter a valid permanent email ID.");
		frmvalidator.addValidation("Nationality","selone","Please select your nationality.");
		frmvalidator.addValidation("Sex","selone","Please select your sex.");
		frmvalidator.addValidation("Marital_Status","selone","Please select your marital status.");
		frmvalidator.addValidation("Photograph","req","Please upload your photograph.");
</script>
