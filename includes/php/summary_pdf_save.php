<?php
  require_once('../tcpdf/config/lang/eng.php');
  require_once('../tcpdf/tcpdf.php');
  require_once($includes_path.'/php/mysqlcon_perm.php');
  
  $user_id = $_SESSION['user_id'];

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('IIT Mandi');
$pdf->SetTitle('Summary Document - Online Application for Faculty Position');
$pdf->SetSubject('');
$pdf->SetKeywords('IIT Mandi, Online application, faculty');

// set default header data
$pdf->SetHeaderData('logo', 30, 'Summary Document', 'IIT Mandi');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// add a page
$pdf->AddPage();

// -----------------------------------------Heading--------------------------------------------------------------//
$pdf->SetFont('times', '', 16);
$pdf->MultiCell(200, 4, 'Application for Faculty Position - Summary Document', 0, 'C', 0, 1, '', $pdf->getY(), true);
$pdf->Ln(4);

/*----------------------------------------Application details and personal Info----------------------------------------*/
// set font
$pdf->SetFont('times', '', 11);
$sr_no = 1;
$position_X = 60;
$width_values = 82;

	$query = "SELECT Application_ID FROM Accounts WHERE User_ID = '$user_id'";
//	echo "<br/><br/><br/>$dbcon_perm";
    $data = mysqli_query($dbcon_perm, $query) or die('There was a problem accessing your profile.(Perm Accounts)');
    $row = mysqli_fetch_assoc($data);
    if ($row != NULL) 
    {
		$application_id = $row['Application_ID'];
	}
    else
    {
      die('There was a problem accessing your profile.(Null application id)');
    }

    $query = "SELECT * FROM Application_Details WHERE User_ID = '$user_id'";
    $data = mysqli_query($dbcon_perm, $query) or die('There was a problem accessing your profile.(Application Details)');
    $row = mysqli_fetch_assoc($data);

    if ($row != NULL) 
    {
      $assistant_professor = $row['Assistant_Professor'];
      $assistant_professor_contract = $row['Assistant_Professor_Contract'];
      $professor = $row['Professor'];
      $associate_professor = $row['Associate_Professor'];
      $comp_elec = $row['Sch_Comp_Elec_Engg'];
	  $engg = $row['Sch_Engg'];
	  $basic_sci = $row['Sch_Basic_Sci'];
	  $hum_soc = $row['Sch_Hum_Soc_Sci'];
     }
    else 
    {
      die('There was a problem accessing your profile.(Application Details)');
    }
    
    $query = "SELECT Firstname, Lastname, Middlename, Correspondence_Address, Correspondence_Phone, Correspondence_eMail, Correspondence_Fax,".
			 "Date_of_Birth, Category, Photo_Extension FROM Personal_Information WHERE User_ID = '$user_id'";
	$data = mysqli_query($dbcon_perm, $query);
	$row = mysqli_fetch_assoc($data); 

    if ($row != NULL) 
    {
	  $firstname = $row['Firstname'];
      $lastname = $row['Lastname'];
      $middlename = $row['Middlename'];
      $correspondence_address = $row['Correspondence_Address'];
	  $correspondence_phone = $row['Correspondence_Phone'];
	  $correspondence_fax = $row['Correspondence_Fax'];
	  $correspondence_email = $row['Correspondence_eMail'];
      list($year,$month,$date) = explode('-',$row['Date_of_Birth']);
	  $category = $row['Category'];
	  $photograph_ext = $row['Photo_Extension'];
     }
   else 
    {
      echo '<p class="error">There was a problem accessing your profile(null personal info).</p>';
    }
        
$width_address = 80;
$photoY = $pdf->getY();
$posts = "";
if($assistant_professor)
	$posts .= "
Assistant Professor";
if($assistant_professor_contract)
	$posts .= "
Assistant Professor (on Contract) ";	
if($associate_professor)
	$posts .= "
Associate Professor";
if($professor)
	$posts .= "
Professor";
	
$schools = "";
if($comp_elec)
	$schools .= " School of Computing and Electrical Engineering ";
if($engg)
	$schools .= " School of Engineering ";
if($basic_sci)
	$schools .= " School of Basic Sciences ";
if($hum_soc)
	$schools .= " School of Humanities and Social Sciences ";


$currentY = $pdf->getY();
$pdf->SetFont('times', '', 11);
$pdf->MultiCell($width_values, 4, $sr_no.'. Application ID', 0, 'L', 0, 1, '', $currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $application_id, 0, '', 0, 1, $position_X, $currentY, true); $currentY +=6;
$pdf->MultiCell($width_values, 4, $sr_no.'. Position(s) applied for', 0, 'L', 0, 1, '', $currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $posts, 0, '', 0, 1, $position_X, $currentY, true); $currentY = $pdf->getY();
$pdf->MultiCell($width_values, 4, $sr_no.'. School(s)', 0, 'L', 0, 1, '', $currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $schools, 0, '', 0, 1, $position_X, $currentY, true); $currentY +=6;

// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$pdf->Image($uploaddir.'/photograph.'.$photograph_ext, 155, $photoY, 30, 42, '', '', 'R', true, 150, '', false, false, 0, true, false, false);

$currentY = $pdf->getY()+2;
$pdf->MultiCell($width_values, 4, $sr_no.'. Name', 0, 'L', 0, 1, '' ,$currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $firstname.' '.$middlename.' '.$lastname, 0, 'L', 0, 1, $position_X, $currentY, true); $currentY +=6;
$pdf->MultiCell($width_values, 4, $sr_no.'. Date of Birth', 0, 'L', 0, 1, '', $currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $date.'-'.$month.'-'.$year, 0, '', 0, 1, $position_X, $currentY, true); $currentY +=5;
$pdf->MultiCell($width_values, 4, $sr_no.'. Category', 0, 'L', 0, 1, '', $currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $category, 0, '', 0, 1, $position_X, $currentY, true); $currentY +=5;
$pdf->Ln(1);
    
$width_values = 100;
$width_address = 65;

$currentY = $pdf->getY();
$pdf->MultiCell($width_values, 4, '7. Address  ', 0, 'L', 0, 1, '', '', true);

$currentX = $pdf->getX();
	$text =<<<EOD
$correspondence_address
EOD;
$pdf->MultiCell($width_address, 4, $text, 0, 'L', 0, 1, $currentX+45, $currentY, true);

	$text = <<<EOD
Phone Number - $correspondence_phone
Email Id - $correspondence_email
Fax - $correspondence_fax
EOD;
$pdf->MultiCell($width_address, 4, $text, 0, 'L', 0, 1, 130, $currentY, true);
$pdf->Ln(10);


/*--------------------------------------Academic Qualifications------------------------------------------------*/
$width_degree = 75;
$width_specialization = 85;
$width_university = 100;
$width_year = 68;
$width_grade = 60;

$acad_tbl = <<<EOD
<table width="388" cellpadding="2" border="1" align="center">
    <tr>
		<td><b>Academic Qualifications</b></td>
    </tr>
    <tr>
        <td width="$width_degree">Degree /<br /> Title</td>
        <td width="$width_specialization">Branch / <br />Specialization </td>
		<td width="$width_university">University / College</td>
		<td width="$width_year"> Completion Year</td>
		<td width="$width_grade">Grade / % Marks</td>
    </tr>  
    
EOD;
    
        $query = "SELECT Degree_Examination, Specialization, University_Insti, Completion_Year, Grade FROM ".
				 "Academic_Qualifications WHERE User_ID = '$user_id' ORDER BY Completion_Year";
		$result = mysqli_query($dbcon_perm, $query) or die('Unable to fetch acad qualifications');
		$i = 0;	
		if(mysqli_num_rows($result)>=1)
	   {
		while($row = mysqli_fetch_assoc($result)) 
		{
			$degree_array[$i] = $row['Degree_Examination'];
			$specialization_array[$i] = $row['Specialization'];
			$year_array[$i] = $row['Completion_Year'];
			$institute_array[$i] = $row['University_Insti'];
			$grade_array[$i] = $row['Grade'];
			$i++;
		}

		for (; (list($key_degree, $degree) = each($degree_array)) && (list($key_specialization, $specialization) = each($specialization_array))
			   && (list($key_year, $year) = each($year_array)) && (list($key_institute, $institute) = each($institute_array)) 
			   && (list($key_grade, $grade) = each($grade_array)) ;) 
		{
			$acad_tbl .= <<<EOD
			<tr>
				<td width="$width_degree">$degree</td>
				<td width="$width_specialization">$specialization </td>
				<td width="$width_university">$institute</td>
				<td width="$width_year">$year</td>
				<td width="$width_grade">$grade</td>
			</tr>
EOD;
	}
   }
		$acad_tbl .= '</table>';

$currentY = $pdf->getY();       //to be used for adjoining table
//Font for details
$pdf->SetFont('times', '', 10);
$pdf->writeHTML($acad_tbl, false, false, false, false);
$acadY = $pdf->getY();            //-----------------used for next set of tables---------------------------------------//


/*------------------------------------------------Teaching Experience---------------------------------------------------*/
$width_designation = 70;
$width_period = 55;
$teaching_tbl = <<<EOD
	<table width="225" cellpadding="2" border="1" align="center">
       	<tr>
		<th ><b>Teaching Experience</b></th>
	</tr>
		<tr>
			<th width="$width_university">University / Organisation</th>
			<th width="$width_designation">Designation</th>
			<th width="$width_period">Period</th>
		</tr>
EOD;

		$query = "SELECT University_Organisation, Designation, Total_Period, Nature_of_Duties FROM ".
				 "Teaching_Experience WHERE User_ID = '$user_id' ORDER BY Period_From";
		$result = mysqli_query($dbcon_perm, $query) or die('Unable to fetch teaching exp');
		$i = 0;
		if(mysqli_num_rows($result)>=1)
	   {
		while($row = mysqli_fetch_assoc($result)) 
		{
			$university_array[$i] = $row['University_Organisation'];
			$designation_array[$i] = $row['Designation'];
			$period_array[$i] = $row['Total_Period'];
			$i++;
		}

		for (; (list($key_university, $university) = each($university_array)) && (list($key_designation, $designation) = each($designation_array)) 
				&& (list($key_period, $period) = each($period_array))
			;)
		{
			$teaching_tbl .= <<<EOD
				<tr>
					<td width="$width_university">$university</td>
					<td width="$width_designation">$designation</td>
					<td width="$width_period">$period</td>
				</tr>
EOD;
		 }
		}	
		$teaching_tbl .='</table>';

$pdf->setY($currentY);              //--------------------------Order of setX and setY matters!!-----------------------------------//
$pdf->setX(131);

$pdf->writeHTML($teaching_tbl, false, false, false, false);
		

/*-----------------------------------------------Industrial Experience---------------------------------------------*/
$width_organisation = 80;
		$indus_exp_tbl = <<<EOD
		  <table width="225" cellpadding="2" border="1" align="center">
			<tr>
				<td colspan="3"><b>Induatrial Experience</b></td>
			</tr>
			<tr>
				<th width = "$width_university">Organisation</th><th width = "$width_designation">Designation</th>
				<th width = "$width_period">Totlal Period</th>
			</tr>
EOD;

		$query = "SELECT Organisation, Designation, Total_Period FROM ".
				 "Industrial_Experience WHERE User_ID = '$user_id'";
		$result = mysqli_query($dbcon_perm, $query) or die('Unable to fetch indus exp');

		$i = 0;
		if(mysqli_num_rows($result)>=1)
	   {
		while($row = mysqli_fetch_assoc($result)) 
		{
			$organi_array[$i] = $row['Organisation'];
			$desig_array[$i] = $row['Designation'];
			$peri_array[$i] = $row['Total_Period'];
			$i++;
		}

		for (;  (list($key_organi, $organi) = each($organi_array)) 
				&& (list($key_designation, $desig) = each($desig_array))
				&& (list($key_period, $peri) = each($peri_array))
			;)
		{
		$indus_exp_tbl .=<<<EOD
			<tr>
				<td>$organi</td>
				<td>$desig</td>
				<td>$peri</td>
			</tr>
EOD;
		}
	}
		$indus_exp_tbl .='</table>';
$pdf->setY($pdf->getY()+5);			//--------------------------Order of setX and setY matters!!-----------------------------------
$pdf->setX(131);

$pdf->writeHTML($indus_exp_tbl, false, false, false, false);
$indusY = $pdf->getY();


/*----------------------------------------Thesis Guided----------------------------------------------*/
$width_status = 70;
$width_degree_level = 90;
$width_nos = 27;
	$query = "SELECT Completed, In_Progress FROM Thesis_Guidance WHERE User_ID = '$user_id'";
		$result = mysqli_query($dbcon_perm, $query) or die('Unable to fetch sthesis guided');
		$row = mysqli_fetch_assoc($result);
		$completed = $row['Completed'];
		$in_progress = $row['In_Progress'];
		$thesis_guid_tbl = $tbl = <<<EOD
<table border="1" width="97" align="center" cellpadding="2">
<tr>
	<th colspan="2"><b>Thesis Supervised</b></th>
</tr>
<tr>
				<th width="$width_status">Status</th>
				<th width="$width_nos">Nos</th>
</tr>
			<tr>
				<td>Completed</td>
				<td>$completed</td>
			</tr>
			<tr>
				<td>In Progress</td>
				<td>$in_progress</td>
			</tr>
</table>
EOD;

$currentY = ($acadY > $indusY)?$acadY:$indusY;
$currentY +=5;
$pdf->setY($currentY);			//--------------------------Order of setX and setY matters!!-----------------------------------//
$pdf->writeHTML($tbl, true, false, false, false, '');
$nextY = $pdf->getY();

/*---------------------------------------------Sponsored Research-------------------------------------------*/
$width_status = 70;
$width_amount = 82;
		$spon_res_tbl = <<<EOD
		<table width="179" cellpadding="2" border="1" align="center">
			<tr>
				<td colspan="3"><b>Sponsored Research Projects</b></td>
			</tr>
			<tr>
				<td width="$width_status">Status</td>
				<td width="$width_nos">Nos</td>
				<th width="$width_amount">Total Grant</th>
			</tr>
EOD;
		
		$query = "SELECT Completed_Nos, Completed_Amount, In_Progress_Nos, In_Progress_Amount FROM Sponsored_Research_Projects ".
				 "WHERE User_ID = '$user_id'";
		$result = mysqli_query($dbcon_perm, $query) or die('Unable to fetch spon research');
		$row = mysqli_fetch_assoc($result); 
		$completed_amount = $row['Completed_Amount'];
		$completed_nos = $row['Completed_Nos'];
		$in_progress_amount = $row['In_Progress_Amount'];
		$in_progress_nos = $row['In_Progress_Nos'];

			$spon_res_tbl .= <<<EOD
			<tr>
				<td>Completed</td>
				<td>$completed_nos</td>
				<td>$completed_amount</td>
			</tr>
			<tr>
				<td>In Progress</td>
				<td>$in_progress_nos</td>
				<td>$in_progress_amount</td>
			</tr>
EOD;

	$spon_res_tbl .='</table>';
$pdf->setY($currentY);
$pdf->setX(48);
$pdf->writeHTML($spon_res_tbl, false, false, false, false);
$nextY = $pdf->getY();


/*---------------------------------------------Publications---------------------------*/
$width_status = 60;
$width_category = 71;
$width_papers = $width_category*4;

		$publication_tbl = <<<EOD
		<table width="334" cellpadding="2" border="1" align="center">
			<tr>
				<td colspan="5"><b>Publications</b></td>
			</tr>
			<tr>
				<td width="50" rowspan="2">Books</td>
				<td width="$width_papers" colspan="4">Papers</td>
			</tr>
			<tr>
				<td width="$width_category">National Journals</td>
				<td width="$width_category">International Journals</td>
				<td width="$width_category">National Conferences</td>
				<td width="$width_category">International Conferences</td>
			</tr>
EOD;

		$query = "SELECT Num_Books_Pub, Num_National_Journals, Num_International_Journals, Num_National_Conferences, ".
				 "Num_International_Conferences FROM Research_Papers WHERE User_ID = '$user_id'";
		$result = mysqli_query($dbcon_perm, $query)or die('Unable to fetch data.(Research Papers)');
		$row = mysqli_fetch_assoc($result);
		
		$num_books = $row['Num_Books_Pub'];
		$num_nat_jou = $row['Num_National_Journals'];
		$num_int_jou = $row['Num_International_Journals'];
		$num_nat_conf = $row['Num_National_Conferences'];
		$num_int_conf = $row['Num_International_Conferences'];
		
		$publication_tbl .= <<<EOD
			<tr>
				<td>$num_books</td>
				<td>$num_nat_jou</td>
				<td>$num_int_jou</td>
				<td>$num_nat_conf</td>
				<td>$num_int_conf</td>
			</tr>
		</table>
EOD;

//$currentY = $pdf->getY()+10;
$pdf->setY($currentY);			//--------------------------Order of setX and setY matters!!-----------------------------------
$pdf->setX(105);
$pdf->writeHTML($publication_tbl, false, false, false, false);
$nextY = ( ( ($pdf->getY()) > $nextY )?($pdf->getY()):$nextY );

/*------------------------------------------------No of Patents--------------------------------------------------------*/
$currentY = $nextY+3.5;
$patent_text = 'Number of Patents (awarded/pending) - ';
$position_X = 70;
	$query = "SELECT Num_Patents FROM Patents WHERE User_ID = '$user_id'";
	$result = mysqli_query($dbcon_perm, $query) or die('Unable to fetch data.(Patents)');

	if(mysqli_num_rows($result)>=1)
	{
		$row = mysqli_fetch_assoc($result);
		$num_patents = $row['Num_Patents'];
		$patent_text.=$num_patents;
	}
	else
	{
		$patent_text.=' No records found.';
	}
$pdf->MultiCell($width_values, 4, $patent_text, 0, 'L', 0, 1, '', $currentY, true);

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//ob_clean();
//Close and output PDF document
$pdf->Output($uploaddir.'/Summary Document.pdf', 'F');

//============================================================+
// END OF FILE                                                
//============================================================+
