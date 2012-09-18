<script language="JavaScript" type="text/javascript">
		var frmvalidator  = new Validator("patents");
		frmvalidator.EnableMsgsTogether();
		frmvalidator.addValidation("Num_Patents","req","Please enter number of patents. (Enter 0 if none.)");
		frmvalidator.addValidation("Num_Patents","numeric","The number of patents should be a numeric value!");
</script>
