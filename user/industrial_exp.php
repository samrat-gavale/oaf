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

		  $query = "SELECT Industrial_Experience FROM Forms_Submitted WHERE User_ID = '$user_id'";
		  $row = mysqli_fetch_array(mysqli_query($dbcon, $query))
				  or
				  trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbcon));
		  if ($row[0] == 1) ;
		  else 
		  {
			$next_url = 'http://' . $_SERVER['HTTP_HOST'] . changeDirName('forms');
  		    echo '<meta http-equiv="refresh" content="0;url='.$next_url.'">';
			mysqli_close($dbcon);
			exit();
		  }

		//Stuff for displaying table Check if any data of the user is present in the database
	  $query = "SELECT Sr_No, Organisation, Designation, Period_From, Period_To, Total_Period, Monthly_Salary, Nature_of_Duties FROM ".
				 "Industrial_Experience WHERE User_ID = '$user_id' ORDER BY Period_From";
	  $data = mysqli_query($dbcon, $query);
	  if (mysqli_num_rows($data) >= 1)
	  {
		$i = 0;
		while($row = mysqli_fetch_assoc($data))
		{
			$sr_no_array[$i] = $row['Sr_No'];
			$organisation_array[$i] = $row['Organisation'];
			$designation_array[$i] = $row['Designation'];
			$from_array[$i] = $row['Period_From'];
			$to_array[$i] = $row['Period_To'];
			$period_array[$i] = $row['Total_Period'];
			$mon_salary_array[$i] = $row['Monthly_Salary'];
			$duties_array[$i] = $row['Nature_of_Duties'];
			$i++;
		}

	$table1 =<<<EOD
	
		<table id="table2">
		<tbody1>
		<tr>
			<th scope="col"></th>
			<th scope="col">Organisation</th>
			<th scope="col">Designation</th>
			<th scope="col">From</th>
			<th scope="col">To</th>
			<th scope="col">Period</th>
			<th scope="col">Monthly Salary</th>
			<th scope="col" class="nature_of_duties">Nature of Duties</th>
		</tr>
EOD;

		for (; (list($key_sr_no, $sr_no) = each($sr_no_array)) && (list($key_organisation, $organisation) = each($organisation_array)) 
				&& (list($key_designation, $designation) = each($designation_array)) && (list($key_from, $from) = each($from_array))
				&& (list($key_to, $to) = each($to_array)) && (list($key_period, $period) = each($period_array)) 
				&& (list($key_duties, $duties) = each($duties_array)) && (list($key_mon_salary, $mon_salary) = each($mon_salary_array))
			;)
		{
		$table1 .= <<<EOD
			<tr id=$sr_no>
				<td><input type="checkbox" id=$sr_no></td>
				<td>$organisation</td>
				<td>$designation</td>
				<td>$from</td>
				<td>$to</td>
				<td>$period</td>
				<td>$mon_salary</td>
				<td>$duties</td>
			</tr>
EOD;
		}

$table1 .=<<<EOD
		</tbody1>
		</table>
		<input type="button" class="delbutton" value="Delete Record" onclick='send_query("del_industrial_exp.php"); ' />
		<input type="button" class="delbutton" value="Add more records" onclick="parent.location= '../forms/industrial_exp.php' " />
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
<p class="texta">Industrial Experience</p>
<?php
	echo $table1;
?>
<br />
<br />
<div >
<input type="button" value="Back" onclick="parent.location= 'thesis_guidance.php' ">
<input type="button" value="Next" onclick="parent.location= 'research_papers.php' ">
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
