<?php
	$error_msg = "";
	$query = "SELECT Accepted FROM Terms_Acceptance WHERE User_ID = '$user_id'";
	$result = mysqli_query($dbcon,$query) or die('Error accesing your profile.(terms)');
	$num_rows = mysqli_num_rows($result);
	$row = mysqli_fetch_assoc($result);
	if($num_rows != 1 || $row['Accepted'] != 1)
	{
		$error_msg = "Please accept the <a href='terms.php'>Terms and Conditions.</a>";
		//echo $error_msg;
		$display_check = 1;
	}
	else
	{
	$query = "SELECT * FROM Accounts WHERE User_ID = '$user_id'";
	$result = mysqli_query($dbcon,$query) or die('Error accesing your profile.(Temp Accounts)');
	$row = mysqli_fetch_assoc($result);
	$user_id = $row['User_ID'];
	$email_id = $row['Email_ID'];
	$password = $row['Password'];
	
	$query = "INSERT INTO Faculty_Permanent.Accounts VALUES(0, '$user_id', '$email_id', '$password')";
	mysqli_query($dbcon,$query) or die('Error updating your profile.');
	
	$data_copied = 1;
	$tables_array = array("Application_Details", "Personal_Information", "Academic_Qualifications", "Teaching_Experience",
						  "Sponsored_Research_Projects", "Thesis_Guidance", "Industrial_Experience", "Research_Papers", "Best_Papers",
						  "Thrust_Areas_SOP", "Patents", "Other_Information", "Future_Plans", "General_Questions", "Referees", 
						  "Forms_Submitted");
					
	foreach($tables_array as $table)
   {
		$query = "INSERT INTO Faculty_Permanent.".$table." SELECT * FROM Faculty_Temporary.".$table." WHERE ".
				 "User_ID = '$user_id'";
		if(!mysqli_query($dbcon, $query))
		{
			echo $table;
			$data_copied = 0;
			die('<br />Sorry! Not able to confirm!.');
		}
	}
	if($data_copied)
	{
		$query = "UPDATE Confirmed_Applications SET Confirmed = 1, Time = NOW() WHERE User_ID = '$user_id'";
        mysqli_query($dbcon, $query)
        or die('<br />Sorry! Not able to confirm. comfirmed'); 
        $query = "UPDATE Forms_Submitted SET Confirmed_Applications = 1 WHERE User_ID = '$user_id'";
		mysqli_query($dbcon, $query)
        or die('<br />Sorry! Not able to confirm. (forms)');
        $display_check = 0;
		include($includes_path.'/php/application_pdf_save.php');
		include($includes_path.'/php/summary_pdf_save.php');
	}
  }
?>
