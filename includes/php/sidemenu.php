<?php

	$forms_array = array("Application Details", "Personal Information", "Academic Profile", "Teaching Experience", "Sponsored Research", "Thesis Supervision",
						 "Industrial Experience", "Research Publications", "Best Papers", "Statement of Purpose", "Patents", "Other Information", "Future Plans", "General Questions", "Referees", "Terms & Conditions", "Checklist and Confirm"
						 );
					
	$links_array = array("application_details.php", "personal_info.php", "acad_qualifications.php", "teaching_exp.php", "sponsored_research.php", "thesis_guidance.php",
						  "industrial_exp.php", "research_papers.php", "best_papers.php", "thrust_areas_sop.php", "patents.php", "other_information.php", "future_plans.php", "general_questions.php", "referees.php", "terms.php", "checklist_and_confirm.php"
						  );
						  
	//column names must match to that in table (refer mysql_source.sql  for column names, cloumn names have bee deliberately kept same as those of the tables in database) 
	
	$query = "SELECT Application_Details, Personal_Information, Academic_Qualifications, Teaching_Experience, Sponsored_Research_Projects, Thesis_Guidance, ".
			 "Industrial_Experience, Research_Papers, Best_Papers, Thrust_Areas_SOP, Patents, Other_Information, Future_Plans, General_Questions, Referees, Terms_Acceptance, Confirmed_Applications
				FROM Forms_Submitted WHERE User_ID = '" . $_SESSION['user_id'] . "'";

	$data = mysqli_query($dbcon, $query) or die('not able to fetch side menu');
	$row = mysqli_fetch_assoc($data);
	
	$links_html  = <<<EOD
	<head>
		<link rel="stylesheet" href="../menu1/menu_style.css" type="text/css" />
	</head>
	<div class="outer">
		<div class='menu1'>
				<ul>
EOD;
	for (; (list($key_form, $form) = each($forms_array)) && (list($key_link, $link) = each($links_array)) && (list($table, $bool_value) = each($row)) ;) 
		{
		$link = <<<EOD
				<li><a href= "../user/$link" target='_self'>$form
EOD;
			if($bool_value == 1) 
				$link.="  &#10004</a></li>";//        <!--- insert a space and a tick mark --->
			else
				$link.="</a></li>";
		$links_html .=$link;
		}
		$links_html.="</ul>
					</div>
				</div>";
		echo $links_html;
	mysqli_close($dbcon);
?>
