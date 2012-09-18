<?php
	include('oaf_paths.php');
	require_once($includes_path.'/php/mysqlcon_perm.php');
	include($includes_path.'/php/set_session.php');
	include($includes_path.'/php/check_login.php');

	$tables_array = array("Application_Details", "Accounts", "Personal_Information", "Academic_Profile", "Teaching_Experience", "Sponsored_Research", "Thesis_Supervision",
						 "Industrial_Experience", "Research_Publications", "Best_Papers", "Statement_of_Purpose", "Patents", "Other_Information", "Future_Plans", "General_Questions", "Referees", "Terms_&_Conditions", "Checklist_and_Confirm",
						 "Forms_Submitted");
$tables_array = array(
 "Academic_Qualifications",
 "Accounts",
 "Application_Details",
 "Best_Papers",
 "Forms_Submitted",
 "Future_Plans",
 "General_Questions",
 "Industrial_Experience",
 "Other_Information",
 "Patents",
 "Personal_Information",
 "Referees",
 "Research_Papers",
 "Sponsored_Research_Projects",
 "Teaching_Experience",
 "Thesis_Guidance",
 "Thrust_Areas_SOP"
 );


	for (; (list($key_form, $table) = each($tables_array)) ;)
	{
		$query = "DELETE FROM $table WHERE User_ID = $user_id";
        mysqli_query($dbcon_perm, $query) or
		trigger_error("Query: $query\n<br />MySQL Error: " . mysqli_error($dbcon));

	}


?>
