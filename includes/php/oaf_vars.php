<?php
$email_pattern = '/^[a-zA-Z0-9][a-zA-Z0-9\-\._&!?=#]*@/';
$phone_pattern = '/^\(?0[1-4]\d{1,2}\)?[-\s]?\d{6,8}/';
$nationality_array = array('','Indian', 'OCI', 'PIO');

define("MAXFILESIZE_PHOTO", "2097152");
define("MAXFILESIZE_AWARDS", "2097152");
define("MAXFILESIZE_EXTRACUR", "2097152");
define("MAXFILESIZE_FUTURE_PLANS", "2097152");
define("MAXFILESIZE_RESEARCH", "2097152");
define("MAXFILESIZE_BEST_PAPERS", "2097152");
define("MAXFILESIZE_THESIS_GUIDANCE", "2097152");
define("MAXFILESIZE_THRUST_AREAS_SOP", "2097152");
define("MAXFILESIZE_SPONSORED_PROJECTS", "2097152");
define("MAX_ACAD_QUALI", "8");
define("MAX_SPON_RESEARCH", "5");
define("MAX_THESIS_GUIDED", "5");
define("MAX_TEACH_EXP", "5");
define("MAX_INDUS_EXP", "5");
define("MAX_REFEREES", "5");
$allowed_types_photo = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/JPG', 'image/X-PNG', 'image/x-png');
$allowed_types_docs = array('application/pdf');

/*********************************Important to change (if necessary)***********************************************/
$uploaddir = '../../../oaf_uploads/'.$_SESSION['user_id'].'/';

$question_1 = "1. Has there been any break in your academic career? If so, give details thereof with reasons.";
$question_2 = "2. Have you been punished during your studies at College/University? If so, give details.";
$question_3 = "3. Have you been punished during your services or convicted by Court of Law?  If so, give details";
$question_4 = "4. Were you at any time declared medically unfit or asked to submit your resignation or discharged or dismissed? If yes,give details.";
$question_5 = "5. Do you have any court cases pending as one of the parties? If yes give details.";

$thrust_area_1 = "Materials for electronics and electrical engineering, including meta-materials and nano-materials";
$thrust_area_2 = "Energy-efficeint and environmentally sound infrastructure for the Himalayan region.";
$thrust_area_3 = "Technologies, including IT and communications, for sustainable development.";
?>
