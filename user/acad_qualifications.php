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

		  $query = "SELECT Academic_Qualifications FROM Forms_Submitted WHERE User_ID = '$user_id'";
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
	  $query = "SELECT Sr_No, Degree_Examination, Specialization, University_Insti, Completion_Year, Grade FROM ".
				 "Academic_Qualifications WHERE User_ID = '$user_id' ORDER BY Completion_Year";
	  $data = mysqli_query($dbcon, $query);
	  if (mysqli_num_rows($data) >= 1)
	  {
		$i = 0;
		while($row = mysqli_fetch_assoc($data))
		{
			$sr_no_array[$i] = $row['Sr_No'];
			$degree_array[$i] = $row['Degree_Examination'];
			$specialization_array[$i] = $row['Specialization'];
			$year_array[$i] = $row['Completion_Year'];
			$institute_array[$i] = $row['University_Insti'];
			$grade_array[$i] = $row['Grade'];
			$i++;
		}

	$table1 =<<<EOD
	
		<table id="table2">
		<tbody1>
		<tr>
			<th scope="col"></th>
			<th scope="col">Degree</th>
			<th scope="col">Subject / Specialization</th>
			<th scope="col">University / Institution</th>
			<th class="year">Year of Completion</th>
			<th scope="col">Grade</th>
		</tr>
EOD;

		for (; (list($key_sr_no, $sr_no) = each($sr_no_array)) && (list($key_degree, $degree) = each($degree_array)) && (list($key_specialization, $specialization) = each($specialization_array)) && (list($key_year, $year) = each($year_array)) && (list($key_institute, $institute) = each($institute_array)) && (list($key_grade, $grade) = each($grade_array)) ;) 
		{
		$table1 .= <<<EOD
			<tr id=$sr_no>
				<td><input type="checkbox" id=$sr_no></td>
				<td>$degree</td>
				<td>$specialization</td>
				<td>$institute</td>
				<td>$year</td>
				<td>$grade</td>
			</tr>
EOD;
		}

$table1 .=<<<EOD
		</tbody1>
		</table>
		<input type="button" class="delbutton" value="Delete Record" onclick='send_query("del_acad_qualification.php"); ' />
		<input type="button" class="delbutton" value="Add more records" onclick="parent.location= '../forms/acad_qualifications.php' " />
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
<p class="texta">Academic Profile</p>
<?php
	echo $table1;
?>
<br />
<br />
<div >
<input type="button" value="Back" onclick="parent.location= 'personal_info.php' ">
<input type="button" value="Next" onclick="parent.location= 'teaching_exp.php' ">
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
