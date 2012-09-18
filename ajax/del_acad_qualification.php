<?php
    include('../includes/php/set_session.php');
    require_once('../includes/php/mysqlcon.php');
	$query='DELETE FROM Academic_Qualifications WHERE '.$_GET['query'];
	mysqli_query($dbcon,$query);
	$query = "SELECT Sr_No from Academic_Qualifications WHERE User_ID =  '$user_id'";
	$data = mysqli_query($dbcon, $query);
			 $rows = mysqli_num_rows($data);
			 //Check if maximum limit is reached
			 if($rows == 0)
			 {
				$query = "UPDATE Forms_Submitted SET Academic_Qualifications = 0 WHERE User_ID = '$user_id'";
				mysqli_query($dbcon, $query) or
				trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbcon));
			 }
?>
