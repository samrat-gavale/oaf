<?php
  include('oaf_paths.php');
  include('includes/html/header.html');
  require_once('includes/php/mysqlcon.php');
?>

<style>
.fieldset
{
width:465px;
}
</style>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">

 <p class ="texta">PDF Documents</p>
 <form enctype="multipart/form-data" method="post" action="includes/php/application_pdf_form.php" >
 <fieldset class="fieldset">
 <table>
<tr>
		 <td class="labelcell"><label for="user_id" >User ID</label></td>
</tr>
<tr>
		 <td class="fieldcell"><input type="text" id="user_id" name="User_ID" maxlength="4" size="10"
		    			value="<?php if (isset($_POST['User_ID'])) echo $_POST['User_ID']; ?>" /></td>
		<td  class="labelcell"><input type="submit" value="Get Application document"></td>	 
</tr>
</table>
</fieldset>
</form>

 <form enctype="multipart/form-data" method="post" action="includes/php/summary_pdf_form.php" >
 <fieldset class="fieldset">
 <table>
<tr>
		 <td class="labelcell"><label for="user_id" >User ID</label></td>
</tr>
<tr>
		 <td class="fieldcell"><input type="text" id="user_id" name="User_ID" maxlength="4" size="10"
		    			value="<?php if (isset($_POST['User_ID'])) echo $_POST['User_ID']; ?>" /></td>
		<td  class="labelcell"><input type="submit" value="Get Summary document"></td>	 
</tr>
</table>
</fieldset>
</form>

</div>
</div>

<div id="leftcolumn">
</div>

<div id="rightcolumn">
</div>

</div>

<?php include('includes/html/footer.html'); ?>
</body>
</html>
