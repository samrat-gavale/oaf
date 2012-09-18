<?php
  session_start();
  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) 
  {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) 
    {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['username'] = $_COOKIE['username'];
    }
  }
  require_once('../../tcpdf/config/lang/eng.php');
  require_once('../../tcpdf/tcpdf.php');
  require_once('mysqlcon_perm.php');
  include('oaf_vars.php');         //oaf vars contains set session
  
  $user_id = $_SESSION['user_id'];
  //echo $a;   
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// Logo
		$image_file = '../../images/logo.jpg';
		$this->Image($image_file, 10, 5, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', '', 15);
		$this->SetY(10);
		// Title
		$this->Cell(0, 15, 'Indian Institute of Technology', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->setY(18);
		$this->Cell(0, 15, 'Mandi, H.P.', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->setY(25);
		$this->setFont('helvetica', '', 12);
		$this->Cell(0, 15, 'Admin Block, Near bus stand, Mandi, Himachal Pradesh, India', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->Line(10, 30, 195, 30);
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', '', 8);
		$this->Line(10, 280, 195, 280);
		//footer tag
		$this->Cell(0, 10, 'IIT Mandi, Application for Faculty Position', 0, false, 'L', 0, '', 0, false, 'T', 'M');
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
	
	public function CreateTextBox($textval, $x = 0, $y, $width = 0, $height = 10, $fontsize = 10, $fontstyle = '', $align = 'L') {
		$this->SetXY($x+10, $y); // 15 = margin left
		$this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
		$this->Cell($width, $height, $textval, 0, false, $align);
	}

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('IIT Mandi');
$pdf->SetTitle('IIT Mandi Application for Faculty Position');
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
$pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// add a page
$pdf->AddPage();


// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
//$pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 127);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
// -----------------------------------------Heading--------------------------------------------------------------// 

$currentY = $pdf->getY();
$pdf->SetFont('times', '', 16);
$pdf->MultiCell(200, 4, 'Application for Faculty Position', 0, 'C', 0, 1, '', $currentY, true);
$pdf->Ln(4);


/*----------------------------------------Application details---------------------------------------------------------*/
// set font
$pdf->SetFont('times', '', 11);
$sr_no = 1;
$position_X = 60;
$width_values = 82;
$width_heading = 175;
$user_id = $_SESSION['user_id'];
	$query = "SELECT Application_ID FROM Accounts WHERE User_ID = $user_id ";
    $data = mysqli_query($dbcon_perm, $query) or die('There was a problem accessing your profile.(perm accounts)');
    $row = mysqli_fetch_assoc($data);
    if ($row != NULL) 
    {
		$application_id = $row['Application_ID'];
	}
    else
    {
      die('There was a problem accessing your profile.');
    }

    $query = "SELECT * FROM Application_Details WHERE User_ID = $user_id ";
    $data = mysqli_query($dbcon_perm, $query) or die('There was a problem accessing your profile.(application details)');
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
      die('There was a problem accessing your profile.(null application details)');
    }
    
$width_values = 102;
$width_address = 80;
$photoY = $pdf->getY();
$posts = "";
if($assistant_professor)
	$posts .= "Assistant Professor
	";
if($assistant_professor_contract)
	$posts .= "Assistant Professor (on Contract)
	";	
if($associate_professor)
	$posts .= "Associate Professor
	";
if($professor)
	$posts .= "Professor
	";
	
$schools = "";
if($comp_elec)
	$schools .= "School of Computing and Electrical Engineering
	";
if($engg)
	$schools .= "School of Engineering
	";
if($basic_sci)
	$schools .= "School of Basic Sciences
	";
if($hum_soc)
	$schools .= "School of Humanities and Social Sciences
	";


$currentY = $pdf->getY();
$photoY = $currentY+5;

$pdf->SetFont('times', '', 12);
$pdf->MultiCell($width_values, 4, $sr_no.'. Application ID', 0, 'L', 0, 1, '', $currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $application_id, 0, '', 0, 1, $position_X, $currentY, true); $currentY +=7;
$pdf->MultiCell($width_values, 4, $sr_no.'. Position(s) applied for', 0, 'L', 0, 1, '', $currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $posts, 0, '', 0, 1, $position_X, $currentY, true); $currentY = $pdf->getY();
$pdf->MultiCell($width_values, 4, $sr_no.'. School(s)', 0, 'L', 0, 1, '', $currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $schools, 0, '', 0, 1, $position_X, $currentY, true);


/*---------------------------------------------------Personal INfo--------------------------------------------------------------*/

    $query = "SELECT * FROM Personal_Information WHERE User_ID = $user_id ";
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
	  $permanent_address = $row['Permanent_Address'];
	  $permanent_phone = $row['Permanent_Phone'];
	  $permanent_fax = $row['Permanent_Fax'];
	  $permanent_email = $row['Permanent_eMail'];
      list($year,$month,$date) = explode('-',$row['Date_of_Birth']);
      $age = $row['Age'];
	  $category = $row['Category'];
	  $nationality = $row['Nationality'];
	  if($row['Sex'] == 'M') $sex = 'Male'; else $sex = 'Female';
	  $marital_status = (($row['Marital_Status'] == 'M')? 'Married':'Unmarried');
  	  $photograph_ext = $row['Photo_Extension'];
     }
   else
    {
      echo '<p class="error">There was a problem accessing your profile.(null personal info)</p>';
    }

// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
$pdf->Image('../'.$uploaddir.'/photograph.'.$photograph_ext, 155, $photoY, '', 33, '', '', 'R', true, 150, '', false, false, 0, true, false, false);

$currentY = $pdf->getY();
//Font for heading
$pdf->SetFont('times', '', 15);                  
$pdf->MultiCell($width_heading, 4, 'Personal Information', 0, 'C', 0, 1, '' ,$currentY, true); $currentY = $pdf->getY(); $sr_no = 1;
$pdf->SetFont('times', '', 12);                  
$pdf->MultiCell($width_values, 4, $sr_no.'. Name', 0, 'L', 0, 1, '' ,$currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $firstname.' '.$middlename.' '.$lastname, 0, 'L', 0, 1, $position_X, $currentY, true); $currentY +=6;
$pdf->MultiCell($width_values, 4, $sr_no.'. Date of Birth', 0, 'L', 0, 1, '', $currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $date.'-'.$month.'-'.$year.'  (Age - '.$age.')' , 0, '', 0, 1, $position_X, $currentY, true); $currentY +=6;
$pdf->MultiCell($width_values, 4, $sr_no.'. Sex', 0, 'L', 0, 1, '', $currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $sex, 0, '', 0, 1, $position_X, $currentY, true); $currentY +=6;
$pdf->MultiCell($width_values, 4, $sr_no.'. Nationality', 0, 'L', 0, 1, '', $currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $nationality, 0, '', 0, 1, $position_X, $currentY, true); $currentY +=6;
$pdf->MultiCell($width_values, 4, $sr_no.'. Marital Status', 0, 'L', 0, 1, '', $currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $marital_status, 0, '', 0, 1, $position_X, $currentY, true);$currentY +=6;
$pdf->MultiCell($width_values, 4, $sr_no.'. Category', 0, 'L', 0, 1, '', $currentY, true); $sr_no +=1;
$pdf->MultiCell($width_values, 5, $category, 0, '', 0, 1, $position_X, $currentY, true); $currentY +=9;
    
$width_values = 100;
$width_address = 65;
$correspondence_address_label = "7. Correspondence
    Address";
$pdf->MultiCell($width_values, 4, $correspondence_address_label, 0, 'L', 0, 1, '', $currentY, true);

$currentX = $pdf->getX();
	$text =<<<EOD
$correspondence_address
EOD;
$pdf->MultiCell($width_address, 4, $text, 0, 'L', 0, 1, $currentX+45, $currentY, true);
$nextY = $pdf->getY();

	$text = <<<EOD
Phone Number - $correspondence_phone
Email Id - $correspondence_email
Fax - $correspondence_fax
EOD;

$pdf->MultiCell($width_address, 4, $text, 0, 'L', 0, 1, 130, $currentY, true);
$pdf->Ln(3);

$currentY = $nextY+3;
$pdf->MultiCell($width_values, 4, '8. Permanent Address  ', 0, 'L', 0, 1, '', $currentY, true);

$currentX = $pdf->getX();
	$text =<<<EOD
$permanent_address
EOD;
$pdf->MultiCell($width_address, 4, $text, 0, 'L', 0, 1, $currentX+45, $currentY, true);
$nextY = $pdf->getY();

	$text = <<<EOD
Phone Number - $permanent_phone
Email Id - $permanent_email
Fax - $permanent_fax
EOD;
$pdf->MultiCell($width_address, 4, $text, 0, 'L', 0, 1, 130, $currentY, true);


//----------------------------------------------Academic Profile--------------------------------------------
$width_level = 80;
$width_degree = 145;
$width_specialization = 135;
$width_university = 155;
$width_year = 85;
$width_grade = 95;

$acad_tbl = <<<EOD
<table width="525" cellpadding="2" border="1" align="center">
    <tr>
        <td width="$width_degree">Degree /<br /> Title</td>
        <td width="$width_specialization">Branch / <br />Specialization </td>
		<td width="$width_university">University/College</td>
		<td width="$width_year">Year of <br /> Completion</td>
		<td width="$width_grade">Grade / % Marks</td>
    </tr>
EOD;
    
        $query = "SELECT Degree_Examination, Specialization, University_Insti, Completion_Year, Grade FROM ".
				 "Academic_Qualifications WHERE User_ID = $user_id ORDER BY Completion_Year";
		$result = mysqli_query($dbcon_perm, $query);
		$i = 0;	
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
		$acad_tbl .= '</table>';

$pdf->setY($nextY+7);
//Font for heading
$pdf->SetFont('times', '', 15);
$pdf->MultiCell($width_heading, 4, 'Academic Profile', 0, 'C', 0, 1, '' ,'', true);
$pdf->Ln(3);
//Font for details
$pdf->SetFont('times', '', 11);
$pdf->writeHTML($acad_tbl, false, false, false, false);
$pdf->Ln(12);


/*------------------------------------Teaching Experience------------------------------------------------*/
//Font for heading
$pdf->SetFont('times', '', 15);
$pdf->MultiCell($width_heading, 4, 'Teaching Experience', 0, 'C', 0, 1, '' ,$pdf->getY(), true);
$pdf->Ln(3);
//Font for details
$pdf->SetFont('times', '', 11);

$width_designation = 75;
$width_from = 55;
$width_to = 55;
$width_period = 70;
$width_nat_of_dut = 150;
$width_salary = 70;
$teaching_tbl = <<<EOD
	<table width="520" cellpadding="2" border="1" align="center">
       <tbody>
		<tr>
			<th width="$width_university">University / Organisation</th>
			<th width="$width_designation">Designation</th>
			<th width="$width_from">From</th>
			<th width="$width_to">To</th>
			<th width="$width_period">Duration</th>
			<th width="$width_salary">Monthly Salary</th>
			<th width="$width_nat_of_dut">Nature of Duties</th>
		</tr>
EOD;

		$query = "SELECT University_Organisation, Designation, Period_From, Period_To, Total_Period, Monthly_Salary, Nature_of_Duties FROM ".
				 "Teaching_Experience WHERE User_ID = $user_id ";
		$result = mysqli_query($dbcon_perm, $query) or die('Not able to fetch teaching experience profile!');
		$i = 0;
		if(mysqli_num_rows($result)>=1)
	   {
		while($row = mysqli_fetch_assoc($result)) 
		{
			$university_array[$i] = $row['University_Organisation'];
			$designation_array[$i] = $row['Designation'];
			$from_array[$i] = $row['Period_From'];
			$to_array[$i] = $row['Period_To'];
			$period_array[$i] = $row['Total_Period'];
			$salary_array[$i] = $row['Monthly_Salary'];
			$duties_array[$i] = $row['Nature_of_Duties'];
			$i++;
		}
		
		for (; (list($key_university, $university) = each($university_array)) && (list($key_designation, $designation) = each($designation_array))
				&& (list($key_from, $from) = each($from_array)) && (list($key_to, $to) = each($to_array))
				&& (list($key_period, $period) = each($period_array)) && (list($key_duties, $duties) = each($duties_array))
				&& (list($key_salary, $salary) = each($salary_array))
			;)
		{
			$teaching_tbl .= <<<EOD
				<tr>
					<td width="$width_university">$university</td>
					<td width="$width_designation">$designation</td>
					<td width="$width_from">$from</td>
					<td width="$width_to">$to</td>
					<td width="$width_period">$period</td>
					<td width="$width_salary">$salary</td>
					<td width="$width_nat_of_dut">$duties</td>
				</tr>
EOD;
		}
		$teaching_tbl .='</table>';

	 $pdf->writeHTML($teaching_tbl, false, false, false, false);

	   }
	   else 
	   		$pdf->MultiCell($width_values, 4, 'No records for Teaching Experience.', 0, 'L', 0, 1, '' ,$pdf->getY(), true);
$pdf->Ln(12);


/*-----------------------------------------------Industrial Experience---------------------------------------------*/
		
$pdf->SetFont('times', '', 15);
$pdf->MultiCell($width_heading, 4, 'Industrial Experience', 0, 'C', 0, 1, '' ,'', true);
$pdf->Ln(3);
//Font for details
$pdf->SetFont('times', '', 11);

$width_organisation = 120;
		$indus_exp_tbl = <<<EOD
		  <table width="550" cellpadding="2" border="1" align="center">
			<tr>
				<th width = "$width_organisation">Organisation</th>
				<th width = "$width_designation">Designation</th>
				<th width = "$width_from">From</th>
				<th width = "$width_to">To</th>
				<th width = "$width_period">Totlal Period</th>
				<th width = "$width_salary">Monthly Salary</th>
				<th width = "$width_nat_of_dut">Nature of Duties</th>
			</tr>
EOD;

		$query = "SELECT Organisation, Designation, Period_From, Period_To, Total_Period, Monthly_Salary, Nature_of_Duties FROM ".
				 "Industrial_Experience WHERE User_ID = $user_id ORDER BY Period_From";
		$result = mysqli_query($dbcon_perm, $query) or die('Not able to retreive data, Industrial Exp');
		$i = 0;
		if(mysqli_num_rows($result)>=1)
	   {
		while($row = mysqli_fetch_assoc($result))
		{
			$organisation_ind_array[$i] = $row['Organisation'];
			$designation_ind_array[$i] = $row['Designation'];
			$from_ind_array[$i] = $row['Period_From'];
			$to_ind_array[$i] = $row['Period_To'];
			$period_ind_array[$i] = $row['Total_Period'];
			$salary_ind_array[$i] = $row['Monthly_Salary'];
			$duties_ind_array[$i] = $row['Nature_of_Duties'];
			$i++;
		}
		
		for (; (list($key_organisation, $organisation) = each($organisation_ind_array)) && (list($key_designation, $designation) = each($designation_ind_array))
				&& (list($key_from, $from) = each($from_ind_array)) && (list($key_to, $to) = each($to_ind_array)) 
				&& (list($key_period, $period) = each($period_ind_array)) && (list($key_duties, $duties) = each($duties_ind_array))
				&& (list($key_salary, $salary) = each($salary_ind_array))
			;)
		{
				$indus_exp_tbl .= <<<EOD
				 <tr>
					<td>$organisation</td>
					<td>$designation</td>
					<td>$from</td>
					<td>$to</td>
					<td>$period</td>
					<td width="$width_salary">$salary</td>
					<td>$duties</td>
				</tr>
EOD;
		}

		$indus_exp_tbl .='</table>';
        $pdf->writeHTML($indus_exp_tbl, false, false, false, false);

	   }
	   else 
			$pdf->MultiCell($width_values, 4, 'No records for Industrial / Consultancy Experience.', 0, 'L', 0, 1, '' ,$pdf->getY(), true);
$pdf->Ln(12);

/*----------------------------------------------------------------------------------------------------------*/
$pdf->SetFont('times', '', 15);
$pdf->MultiCell($width_heading, 4, 'Research Profile', 0, 'C', 0, 1, '' ,$pdf->getY(), true);
$pdf->Ln(3);
$headingY = $pdf->getY();

/*---------------------------------------------Sponsored Research-------------------------------------------*/
$pdf->SetFont('times', '', 15);
$pdf->MultiCell($width_values, 4, 'Sponsored Research Projects', 0, 'L', 0, 1, '',$headingY, true);
$pdf->Ln(2);
//Font for details
$pdf->SetFont('times', '', 11);

$width_status = 150;
$width_nos = 150;
$width_amount = 200;
		$spon_res_tbl = <<<EOD
		<table width="400" cellpadding="2" border="1" align="center">
			<tr>
				<td width="$width_status">Status of Projects</td>
				<td width="$width_nos">Number</td>
				<th width="$width_amount">Total Grant</th>
			</tr>
EOD;
		
		$query = "SELECT Completed_Nos, Completed_Amount, In_Progress_Nos, In_Progress_Amount, List_Uploaded FROM Sponsored_Research_Projects ".
				 "WHERE User_ID = '" . $_SESSION['user_id'] . "'";
		$result = mysqli_query($dbcon_perm, $query) or die('There was a problem accessing your profile.(Spon Research)');
		$row = mysqli_fetch_assoc($result);
		if(mysqli_num_rows($result)>=1)
	   {
		$spon_res_uploaded = $row['List_Uploaded'];	   		
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
	$pdf->writeHTML($spon_res_tbl, false, false, false, false);
	}
	   else 
			$pdf->MultiCell($width_values, 4, 'No records for Sponsored Research.', 0, 'L', 0, 1, '' ,'', true);
$pdf->Ln(8);


/*------------------------------------------Thesis Supervision--------------------------------------------------------*/
$pdf->SetFont('times', '', 15);
$pdf->MultiCell($width_heading, 4, 'Thesis Supervised', 0, 'L', 0, 1, '', '', true);
$pdf->Ln(2);
//Font for details
$pdf->SetFont('times', '', 11);

	$query = "SELECT Completed, In_Progress, List_Uploaded FROM Thesis_Guided WHERE User_ID = $user_id ";
		$result = mysqli_query($dbcon_perm, $query) ;
		if(mysqli_num_rows($result)>=1)
	   {		
		$row = mysqli_fetch_assoc($result) or die('There was a problem accessing your profile.(Spon Research)');
		$thesis_guid_uploaded = $row['List_Uploaded'];
		$completed = $row['Completed'];
		$in_progress = $row['In_Progress'];
		$thesis_guid_tbl = <<<EOD
<table border="1" width="290" align="center" cellpadding="2">
<tr>
				<th width="$width_status">Status of Thesis</th>
				<th width="$width_nos">Number</th>
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
//$pdf->setX(70);
$pdf->writeHTML($thesis_guid_tbl, true, false, false, false, '');
}
	   else 
			$pdf->MultiCell($width_values, 4, 'No records for Thesis Supervision.', 0, 'L', 0, 1, '' ,'', true);

$pdf->Ln(8);


/*---------------------------------------------Publications---------------------------------------------*/
$pdf->SetFont('times', '', 15);
$pdf->MultiCell($width_values, 4, 'Publications', 0, 'L', 0, 1, '' ,'', true);
$pdf->Ln(2);
//Font for details
$pdf->SetFont('times', '', 11);

$width_category = 100;

		$publication_tbl = <<<EOD
		<table width="500" cellpadding="2" border="1" align="center">
			<tr>
				<td rowspan="2" width="120">Books Published / Accepted for Publishing</td>
				<td colspan="4">Papers Published / Accepted in</td>
			</tr>
			<tr>
				<td width="$width_category">National Journals</td>
				<td width="$width_category">International Journals</td>
				<td width="$width_category">National Conferences</td>
				<td width="$width_category">International Conferences</td>
			</tr>
EOD;

		$query = "SELECT * FROM Research_Papers WHERE User_ID = $user_id ";
		$result = mysqli_query($dbcon_perm, $query)or die('Unable to fetch data.(Research Papers)');
		$i = 0;
		if(mysqli_num_rows($result)>=1)
	   	{		
		$row = mysqli_fetch_assoc($result) or die('There was a problem accessing your profile.(Research Papers)');

		$num_books = $row['Num_Books_Pub'];
		$num_nat_jou = $row['Num_National_Journals'];
		$num_int_jou = $row['Num_International_Journals'];
		$num_nat_conf = $row['Num_National_Conferences'];
		$num_int_conf = $row['Num_International_Conferences'];
		
		$books_uploaded = $row['Books_Pub'];
		$nat_jou_uploaded = $row['National_Journals'];
		$int_jou_uploaded = $row['International_Journals'];
		$nat_conf_uploaded = $row['National_Conferences'];
		$int_conf_uploaded = $row['International_Conferences'];
		
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

$pdf->writeHTML($publication_tbl, false, false, false, false);
}
	   else 
	   {
		$pdf->MultiCell($width_values, 4, 'No records for Research Papers.', 0, 'L', 0, 1, '' ,'', true);
		$books_uploaded = 0;
		$nat_jou_uploaded = 0;
		$int_jou_uploaded = 0;
		$nat_conf_uploaded = 0;
		$int_conf_uploaded = 0;
		
		}

$pdf->Ln(8);



/*-------------------------------------------------Best Papers-----------------------------------------------------------*/
	$query = "SELECT Papers_Uploaded FROM Best_Papers WHERE User_ID = $user_id ";
	$result = mysqli_query($dbcon_perm, $query) or die('Unable to fetch data.(Best_Papers)');
	$row = mysqli_fetch_assoc($result);
	$best_papers_uploaded = $row['Papers_Uploaded'];



/*------------------------------------------------No of Patents--------------------------------------------------------*/
$width_paragraph = 180;
$pdf->SetFont('times', '', 15);
$pdf->MultiCell($width_heading, 4, 'Patents', 0, 'C', 0, 1, '', '', true);
$pdf->Ln(3);
$currentY = $pdf->getY();
$num_patent_text = 'Number of Patents (awarded/pending) - ';

$pdf->SetFont('times', '', 12);
	$query = "SELECT Num_Patents, Patents FROM Patents WHERE User_ID = '" . $_SESSION['user_id'] . "'";
	$result = mysqli_query($dbcon_perm, $query) or die('Unable to fetch data.(Patents)');

	if(mysqli_num_rows($result)>=1)
	{
		$row = mysqli_fetch_assoc($result);
		$num_patents = $row['Num_Patents'];
		$patents_details = '<b>Details - </b><br/>'.$row['Patents'];
		$num_patent_text.=$num_patents;
	}
	else
	{
		$num_patent_text.=' No records found.';
		$patents_details = '';
	}

		$pdf->MultiCell($width_values, 5, $num_patent_text, 0, '', 0, 1, '', '', true);
		$pdf->writeHTML($patents_details, false, false, false, false);

$pdf->Ln(8);


/*------------------------------------------------Statement of Purpose--------------------------------------------------------*/
$pdf->SetFont('times', '', 15);
$pdf->MultiCell($width_heading, 4, 'Statement of Purpose', 0, 'C', 0, 1, '', '', true);
$pdf->Ln(2);

$position_X = 80;
	$query = "SELECT Thrust_Area, SOP FROM Thrust_Areas_SOP WHERE User_ID = $user_id ";
	$result = mysqli_query($dbcon_perm, $query) or die('Unable to fetch data.(Statement of Purpose)');

	if(mysqli_num_rows($result)>=1)
	{
		$row = mysqli_fetch_assoc($result);
		$thrust_area = $row['Thrust_Area'];
		$sop = $row['SOP'];
		
		if($thrust_area == 1)  		$display_text = $thrust_area_1;
		else if($thrust_area == 2)  $display_text = $thrust_area_2;
		else if($thrust_area == 3)  $display_text = "Technologies, including IT and communications, for sustainable development."; //$thrust_area_3;
		else if($thrust_area == 4)  $display_text = "";
		else 						$display_text = "No record found.";
		
		$pdf->SetFont('times', 'B', 12);
		$pdf->MultiCell($width_heading, 5, $display_text, 0, 'C', 0, 1, '', '', true);
		$pdf->SetFont('times', '', 12);
		$pdf->MultiCell($width_paragraph, 5, $sop, 0, '', 0, 1, '', '', true);
	}
	else
	{
		$pdf->MultiCell($width_values, 5, 'No records found.', 0, '', 0, 1, '', '', true);
	}
$pdf->Ln(8);


/*-----------------------------------------------Other Information----------------------------------------------*/
$width_paragraph = 180;
   $query = "SELECT * FROM Other_Information WHERE User_ID = $user_id ";
    $data = mysqli_query($dbcon_perm, $query) or die('No other Info');
    $row = mysqli_fetch_array($data);

    if ($row != NULL)
    {
	  $memberships = $row['Memberships'];
      $proficiencies = $row['Proficiencies'];
      $other_info = $row['Other_Info'];
	  $awards_uploaded = $row['Awards'];
	  $extracurriculars_uploaded = $row['Extracurriculars'];
	  
$pdf->SetFont('times', '', 15);
$pdf->MultiCell($width_heading, 4, 'Memberships, Felllowships of Professional Societies', 0, 'C', 0, 1, '', '', true);
$pdf->Ln(1);
$pdf->SetFont('times', '', 12);
$pdf->MultiCell($width_paragraph, 4, $memberships, 0, 'L', 0, 1, '', '', true);
$pdf->Ln(8);

$pdf->SetFont('times', '', 15);
$pdf->MultiCell($width_heading, 4, 'Special training, Proficiency or Expertise and Relevant Information', 0, 'C', 0, 1, '', '', true);
$pdf->Ln(1);
$pdf->SetFont('times', '', 12);
$pdf->MultiCell($width_paragraph, 4, $proficiencies, 0, 'L', 0, 1, '', '', true);
$pdf->Ln(8);

$pdf->SetFont('times', '', 15);
$pdf->MultiCell($width_heading, 4, 'Other Relevant Information', 0, 'C', 0, 1, '', '', true);
$pdf->Ln(1);
$pdf->SetFont('times', '', 12);
$pdf->MultiCell($width_paragraph, 4, $other_info, 0, 'L', 0, 1, '', '', true);
$pdf->Ln(8);
     }
    else 
    $pdf->MultiCell($width_values, 4, 'No records found for Proficeincies, Membershpis.', 0, 'L', 0, 1, '' ,$pdf->getY(), true);
$pdf->Ln(5);


/*-------------------------------------------------Future Plans-----------------------------------------------------------*/
	$query = "SELECT * FROM Future_Plans WHERE User_ID = $user_id ";
	$result = mysqli_query($dbcon_perm, $query) or die('Unable to fetch data.(Best_Papers)');
	$row = mysqli_fetch_assoc($result);
	$research_plan_uploaded = $row['Research_Plans'];
	$teaching_plan_uploaded = $row['Teaching_Plans'];



/*--------------------------------------------------------General Questions------------------------------------------------------*/
	$pdf->SetFont('times', '', 15);
	$pdf->MultiCell($width_heading, 4, 'General Questions', 0, 'C', 0, 1, '', '', true);

   $query = "SELECT * FROM General_Questions WHERE User_ID = $user_id ";
    $data = mysqli_query($dbcon_perm, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) 
    {
	  $q1 = $row['Question_1'];
	  $q2 = $row['Question_2'];
      $q3 = $row['Question_3'];
      $q4 = $row['Question_4'];
      $q5 = $row['Question_5'];

$gen_ques =<<<EOD
$question_1<br/>
Response - $q1<br/><br/>

$question_2<br/>
Response - $q2<br/><br/>

$question_3<br/>
Response - $q3<br/><br/>

$question_4<br/>
Response - $q4<br/><br/>

$question_5<br/>
Response - $q5<br/><br/>
  
EOD;
  
$pdf->SetFont('times', '', 12);
$pdf->writeHTML($gen_ques, false, false, false, false);
    }
    else 
    $pdf->MultiCell($width_values, 4, 'No records found for General Questions.', 0, 'L', 0, 1, '' ,'', true);
$pdf->Ln(12);


/*----------------------------------------------------------Referees----------------------------------------------------*/
$pdf->SetFont('times', '', 15);
$pdf->MultiCell($width_heading, 4, 'References', 0, 'C', 0, 1, '' ,$pdf->getY(), true);
$pdf->Ln(3);
//Font for details
$pdf->SetFont('times', '', 11);

$width_designation = 100;
$width_name = 100;
$width_address = 160;
$width_phone = 90;
$width_email = 95;
$width_fax = 90;
	  $query = "SELECT Sr_No, Name, Designation, Address, Phone, Fax, Email_ID FROM Referees WHERE User_ID = $user_id ";
	  $data = mysqli_query($dbcon_perm, $query);
	  if (mysqli_num_rows($data) >= 1)
	  {
		$i = 0;
		while($row = mysqli_fetch_assoc($data))
		{
			$name_ref_array[$i] = $row['Name'];
			$designation_ref_array[$i] = $row['Designation'];
			$address_ref_array[$i] = $row['Address'];
			$phone_ref_array[$i] = $row['Phone'];
			$email_ref_array[$i] = $row['Email_ID'];
			$fax_ref_array[$i] = $row['Fax'];
			$i++;
		}

	$referee_tbl =<<<EOD
	 <table width="500" cellpadding="2" border="1" align="center">
		<tr>
			<th width="$width_name">Name</th>
			<th width="$width_designation">Designation</th>
			<th width="$width_address">Address</th>
			<th width="$width_phone">Phone</th>
			<th width="$width_email">E-mail</th>
			<th width="$width_fax">Fax</th>
		</tr>
EOD;

		for (;  (list($key_name, $name) = each($name_ref_array)) 
				&& (list($key_designation, $designation) = each($designation_ref_array)) && (list($key_phone, $phone) = each($phone_ref_array))
				&& (list($key_address, $address) = each($address_ref_array)) && (list($key_email, $email) = each($email_ref_array)) 
				&& (list($key_fax, $fax) = each($fax_ref_array)) ;)
		{
		$referee_tbl .= <<<EOD
		  <tr>
				<td>$name</td>
				<td>$designation</td>
				<td>$address</td>
				<td>$phone</td>
				<td>$email</td>
				<td>$fax</td>
			</tr>
EOD;
		}

	$referee_tbl .='</table>';
    $pdf->writeHTML($referee_tbl, false, false, false, false);
	   }
	   else 
			$pdf->MultiCell($width_values, 4, 'No records for References.', 0, 'L', 0, 1, '' , '', true);
$pdf->Ln(12);


/*---------------------------------------------------Declaration------------------------------------------------------*/
$pdf->SetFont('times', '', 15);
$pdf->MultiCell($width_values, 4, 'Declaration to be Signed by the Candidate', 0, 'L', 0, 1, '' , '', true);

$pdf->setX(20);
$pdf->SetFont('times', '', 12);
$declaration = "I hereby declare that the entries in this form are true to the best of my knowledge and belief. If at any time I am found to have concealed any material/ information or given any false details, my appointment shall be liable to be summarily terminated without notice or compensation.";
$pdf->MultiCell($width_paragraph, 4, $declaration, 0, 'L', 0, 1, '' , '', true);
$pdf->Ln(22);

	$date_place =<<<EOD
Date - <br/>
Place -
EOD;

$sign = <<<EOD
<b>Signature of Applicant</b><br/><br/>
Name -                                
EOD;

// write the first column
$pdf->writeHTMLCell(110, '', '', '', $date_place, 0, 0, 0, true, 'L', true);

// write the second column
$pdf->writeHTMLCell(80, '', '', '', $sign, 0, 0, 0, true, 'L', true);

$uploads = "<h3>Documents Uploaded -</h3> <br/>";
$counter = 1;

if($best_papers_uploaded)
{
$uploads .=" $counter. Three Best Papers <br/>";
$counter++;
}

if($nat_jou_uploaded)
{
$uploads .=" $counter. List of Papers Published/Accepted in National Journals<br/>";
$counter++;
}

if($int_jou_uploaded)
{
$uploads .=" $counter. List of Papers Published/Accepted in International Journals<br/>";
$counter++;
}

if($nat_conf_uploaded)
{
$uploads .=" $counter. List of Papers Presented in National Conferences<br/>";
$counter++;
}

if($int_conf_uploaded)
{
$uploads .=" $counter. List of Papers Presented in International Conferences<br/>";
$counter++;
}

if($books_uploaded)
{
$uploads .=" $counter. List of all Publications<br/>";
$counter++;
}

if($spon_res_uploaded)
{
$uploads .=" $counter. List of Sponsored Research Projects<br/>";
$counter++;
}

if($thesis_guid_uploaded)
{
$uploads .=" $counter. List of Thesis Supervisions<br/>";
$counter++;
}

if($awards_uploaded)
{
$uploads .=" $counter. List of Awards, Honours and Recognitions<br/>";
$counter++;
}

if($extracurriculars_uploaded)
{
$uploads .=" $counter. List of Extracurricular Activities<br/>";
$counter++;
}

if($research_plan_uploaded)
{
$uploads .=" $counter. Research Plan for next five years<br/>";
$counter++;
}

if($teaching_plan_uploaded)
{
$uploads .=" $counter. Teaching Plan for next three years<br/>";
$counter++;
}


$pdf->AddPage();
$pdf->Ln(18);
$pdf->writeHTML($uploads, false, false, false, false);

//move pointer to last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Application Document.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
