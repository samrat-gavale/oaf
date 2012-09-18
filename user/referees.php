<?php
	include('../user/oaf_paths.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/html/header.html');
	require_once($includes_path.'/php/mysqlcon.php');
	include($includes_path.'/php/check_login.php');
	include ($includes_path.'/php/oaf_vars.php');
	include ($includes_path.'/php/functions.php');
	include ($includes_path.'/js/delete_records.js');
	$error_msg = "";

		  $query = "SELECT Referees FROM Forms_Submitted WHERE User_ID = '$user_id'";
		  $row = mysqli_fetch_array(mysqli_query($dbcon, $query))
				  or
				  trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbcon));
		  if ($row[0] == 1) ;
		  else 
		  {
			mysqli_close($dbcon);
			$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('forms');
  		    echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
		  }

		//Stuff for displaying table Check if any data of the user is present in the database
	  $query = "SELECT Sr_No, Name, Designation, Address, Phone, Fax, Email_ID FROM Referees WHERE User_ID = '$user_id'";
	  $data = mysqli_query($dbcon, $query);
	  if (mysqli_num_rows($data) >= 1)
	  {
		$i = 0;
		while($row = mysqli_fetch_assoc($data))
		{
			$sr_no_array[$i] = $row['Sr_No'];
			$name_array[$i] = $row['Name'];
			$designation_array[$i] = $row['Designation'];
			$address_array[$i] = $row['Address'];
			$phone_array[$i] = $row['Phone'];
			$email_array[$i] = $row['Email_ID'];
			$fax_array[$i] = $row['Fax'];
			$i++;
		}

	$table1 =<<<EOD
	
		<table id="table2">
		<tbody1>
		<tr>
			<th scope="col"></th>
			<th scope="col">Name</th>
			<th scope="col">Designation</th>
			<th scope="col" class="table_address">Address</th>
			<th scope="col">Phone</th>
			<th scope="col">E-mail</th>
			<th scope="col">Fax</th>
		</tr>
EOD;

		for (; (list($key_sr_no, $sr_no) = each($sr_no_array)) && (list($key_name, $name) = each($name_array)) 
				&& (list($key_designation, $designation) = each($designation_array)) && (list($key_phone, $phone) = each($phone_array))
				&& (list($key_address, $address) = each($address_array)) && (list($key_email, $email) = each($email_array)) 
				&& (list($key_fax, $fax) = each($fax_array)) ;) 
		{
		$table1 .= <<<EOD
			<tr id=$sr_no>
				<td><input type="checkbox" id=$sr_no></td>
				<td>$name</td>
				<td>$designation</td>
				<td class="table_address">$address</td>
				<td>$phone</td>
				<td>$email</td>
				<td>$fax</td>
			</tr>
EOD;
		}

$table1 .=<<<EOD
		</tbody1>
		</table>
		<input type="button" class="delbutton" value="Delete Record" onclick='send_query("del_referees.php"); ' />
		<input type="button" class="delbutton" value="Add More Records" onclick="parent.location= '../forms/referees.php' " />
		<br /><br />
		To delete a record, check the box on its left and click on 'Delete Record' button.
		<div id='test'>
		</div>
EOD;
//echo $table1;
	}
	else
	  {
		$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('forms');
	    echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
     }

?>

<div id="maincontainer">
<div id="contentwrapper">

<div id="contentcolumn">
<p class="texta">Referees</p>
<?php
	echo $table1;
?>
<br />

<input type="button" value="Back" onclick="parent.location= 'index.php' ">
<input type="button" value="Next" onclick="parent.location= 'terms.php' ">
</div>

</div>

</div>

</div>

<div id="leftcolumn">
<?php include($includes_path.'/php/sidemenu.php');?>
</div>

</div>

<?php include($includes_path.'/html/footer.html'); ?>
</body>
</html>
