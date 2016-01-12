<?php

include "scripts/checkbro.php";

/*------------- generating bro name for profile link ---------------*/
if (isset($_SESSION["FirstName"])) {
	$bfirstname = $_SESSION['FirstName'];
	$blastname = $_SESSION['LastName'];
} else {header("location: .");}

/*------------- Form Handlers ---------------*/
if(isset($_POST['bro_profile'])) {
	$target_bro = $_POST['bro_profile'];
	$firstname = $_POST['firstname'];
	$middlename = $_POST['middlename'];
	$lastname = $_POST['lastname'];
	$call_name = $_POST['CallName'];
    $class = $_POST['class'];
    $house = $_POST['house'];
    $concentration = $_POST['concentration'];
    $huid = $_POST['huid'];
    $ethnicity = $_POST['ethnicity'];
    $hometown = $_POST['hometown'];
    $bday_m = $_POST['bday_m'];
    $bday_d = $_POST['bday_d'];
    $bday_y = $_POST['bday_y'];
    
    $birthday_update = "$bday_y-$bday_m-$bday_d";
    $pw_lower = strtolower($call_name);
    $pw_sql = str_replace("-", "", $pw_lower);
    $pw_sql = str_replace(" ", "", $pw_sql);
    
	$update_sql = mysql_query("UPDATE brothers SET FirstName='$firstname', MiddleName='$middlename', LastName='$lastname', CallName='$call_name', Password='$pw_sql', Class='$class', House='$house', Concentration='$concentration', HUID16='$huid', Ethnicity='$ethnicity', Hometown='$hometown', Birthday='$birthday_update' WHERE bro='$target_bro'");
}

if(isset($_POST['bro_contacts'])) {
	$target_bro = $_POST['bro_contacts'];
    $emailH = $_POST['emailH'];
    $emailP = $_POST['emailP'];
    $emailW = $_POST['emailW'];
    $phoneC = $_POST['phoneC'];
    $phoneW = $_POST['phoneW'];
    $phoneH = $_POST['phoneH'];
    $facebook = $_POST['facebook'];
    
    $update_sql = mysql_query("UPDATE brothers SET Email='$emailH', Email_personal='$emailP', Email_work='$emailW', Phone_cell='$phoneC', Phone_work='$phoneW', Phone_home='$phoneH', Facebook='$facebook' WHERE bro='$target_bro'");
}

if(isset($_POST['bro_loc'])) {
	$target_bro = $_POST['bro_loc'];
    $CampusAdd = $_POST['CampusAdd'];
    $MailingAdd = $_POST['MailingAdd'];
    $HomeAdd = $_POST['HomeAdd'];
    
    $update_sql = mysql_query("UPDATE brothers SET CampusAdd='$CampusAdd', MailingAdd='$MailingAdd', HomeAdd='$HomeAdd' WHERE bro='$target_bro'");
}

if(isset($_POST['bro_alum'])) {
	$target_bro = $_POST['bro_alum'];
    $Occupation = $_POST['Occupation'];
    $CompanyOrg = $_POST['CompanyOrg'];
    $Position = $_POST['Position'];
    $CurrentCity = $_POST['CurrentCity'];
    $Address = $_POST['Address'];
    $HobbiesInterests = $_POST['HobbiesInterests'];
    
    $update_sql = mysql_query("UPDATE brothers SET Occupation='$Occupation', CompanyOrg='$CompanyOrg', Position='$Position', CurrentLocation='$CurrentCity', Address='$Address', HobbiesInterests='$HobbiesInterests' WHERE bro='$target_bro'");
}

if(isset($_GET['leader_bro'])) {
	$target_bro = $_GET['leader_bro'];
    $lead_name = $_GET['lead_name'];
    $lead_year = $_GET['lead_year'];
    $leadership_pos = "$lead_name$lead_year";
    
    $checkpos_sql = mysql_query("SELECT Leadership FROM brothers WHERE bro='$target_bro' LIMIT 1") or die (mysql_error());
    	while ($p = mysql_fetch_row($checkpos_sql)) {
    		$pos = $p[0];
    	}
    		if (!$pos) {
    			$leadership = $leadership_pos;
   			} else{
   				$pos_array = explode(",",$pos);
   			}
   			
   			if (in_array($leadership_pos,$pos_array)) {
   				$leadership = $pos;
   			} elseif (!in_array($leadership_pos,$pos_array)) {
   				$leadership_arr = array_push($pos_array, $leadership_pos);
   				$leadership = implode(",",$leadership_arr);
   			}
   		
    $update_sql = mysql_query("UPDATE brothers SET Leadership='$leadership' WHERE bro='$target_bro'") or die (mysql_error());

}

/*------------- IMAGE HANDLER ---------------*/
$path = "vault/photos/profpic/";
$valid_formats = array("jpg", "png", "jpeg");

	if (isset($_POST['bro_photo'])) {
			$target_bro = $_POST['bro_photo'];
			$name = $_FILES['profpic']['name'];
			$size = $_FILES['profpic']['size'];
			
			if(strlen($name)){
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats)){
						if($size<(1024*1024*2)) { // Max File Size: 2MB
							$actual_image_name = "$path$target_bro.jpg";
							$tmp = $_FILES['profpic']['tmp_name'];
							if(move_uploaded_file($tmp, $actual_image_name)){
								chmod("$path$target_bro.jpg", 0755);
								echo "<img src='$path".$actual_image_name."'  class='preview'>";
							} else echo "failed";
						} else echo "Image file size max 2 MB";
					} else echo "Invalid file format..";
			} else echo "Please select image..!";
	exit;
	}

/*------------- generating requested bro info ---------------*/
if (isset($_GET['bro'])) {
	$lookupID = $_GET['bro'];
	$bro_sql = mysql_query("SELECT * FROM brothers WHERE bro = '$lookupID' LIMIT 1");
	$bro_count = mysql_num_rows($bro_sql);
	if ($bro_count > 0){
		while($row = mysql_fetch_array($bro_sql)){
			$email = $row['Email'];
			$firstname = $row['FirstName'];
			$middlename = $row['MiddleName'];
			$lastname = $row['LastName'];
			$CallName = $row['CallName'];
			$class = $row['Class'];
			$house = $row['House'];
			$concentration = $row['Concentration'];
			$huid = $row['HUID16'];
			$ethnicity = $row['Ethnicity'];
			$hometown = $row['Hometown'];
			$birthday_full = $row['Birthday'];
			$leadership = $row['Leadership'];
			$hob_act = $row['Hobbies'];
			$career_goals = $row['CareerGoals'];
			$intel_interests = $row['Interests'];
			$why_aab = $row['WhyAAB'];
			$address = $row['Address'];
			$facebook = $row['Facebook'];
			$email_personal = $row['Email_personal'];
			$email_work = $row['Email_work'];
			$phone_cell = $row['Phone_cell'];
			$phone_work = $row['Phone_work'];
			$phone_home = $row['Phone_home'];
			$aim = $row['AIM'];
			$icq = $row['ICQ'];
			$CampusAdd = $row['CampusAdd'];
			$MailingAdd = $row['MailingAdd'];
			$HomeAdd = $row['HomeAdd'];
			$occupation = $row['Occupation'];
			$companyorg = $row['CompanyOrg'];
			$btitle = $row['Position'];
			$current_loc = $row['CurrentLocation'];
			$address = $row['Address'];
			$HobbiesInterests = $row['HobbiesInterests'];
			
			$month = date("m");
			$year = date("Y");
			
			//if ($month > 6) {
			//	$classYear = $year + 1;
			//	} else {$classYear = $year;}
			
			//if ($class < $classYear) {
				$alumni_tab = "<li><a href='#alumniDiv'>Alumni</a></li>";
				$alumni = "<table cellspacing='10' cellpadding='0'>
				<form id='AlumForm' enctype='multipart/form-data'>
				<tr><td><label>Occupation:</label></td><td><input type='text' name='Occupation' value='$occupation' placeholder='Physician' id='focus' style='width:200'/></td></tr>
				<tr><td><label>Company/Org:</label></td><td><input type='text' name='CompanyOrg' value='$companyorg' placeholder='Mass General Hospital' id='focus' style='width:400'/></td></tr>
				<tr><td><label>Position:</label></td><td><input type='text' name='Position' value='$btitle' placeholder='Director of Surgery' id='focus' style='width:400'/></td></tr>
				<tr><td><label>Current City:</label></td><td><input type='text' name='CurrentCity' value='$current_loc' placeholder='Boston, MA' id='focus' style='width:200'/></td></tr>
				<tr><td><label>Address:</label></td><td><input type='text' name='Address' value='$address' placeholder='123 Maple St, Boston, MA 12345' id='focus' style='width:400'/></td></tr>
				<tr><td><label>Hobbies & Interests:</label></td><td><textarea type='text' name='HobbiesInterests' placeholder='What do you like to do in your free time?' id='textblock' id='focus' style='width:400; height:100'>$HobbiesInterests</textarea></td></tr>
				<input type='hidden' name='bro_alum' value='$lookupID' />
				<tr><td colspan='2'><input type='button' id='SaveAlum' value='Update' class='submit' onclick='return submitAlum();'/></td></tr>
				</form>
				</table>";
			//} else {
				$location_tab = "<li><a href='#locationDiv'>Location</a></li>";
				$location = "<table cellspacing='10' cellpadding='0'>
				<form id='LocForm' enctype='multipart/form-data'>
				<tr><td><label>Campus Address:</label></td><td><input type='text' name='CampusAdd' placeholder='Leverett F110' id='focus' value='$CampusAdd' style='width:140'/></td></tr>
				<tr><td><label>Mailing Address:</label></td><td><input type='text' name='MailingAdd' value='$MailingAdd' placeholder='111 Leverett Mail Center, 28 DeWolfe St' id='focus' style='width:400'/></td></tr>
				<tr><td><label>Home Address:</label></td><td><input type='text' name='HomeAdd' value='$HomeAdd' placeholder='123 Maple St, Metropolis, KS 12345' id='focus' style='width:400'/></td></tr>
				<input type='hidden' name='bro_loc' value='$lookupID' />
				<tr><td colspan='2'><input type='button' id='SaveLoc' value='Update' class='submit' onclick='return submitLoc();'/></td></tr>
				</form>
				</table>";
			//}
			
				/*=======  Display Pic. If not, default pic.  =======*/
				$check_jpg = "$path$lookupID.jpg";
				$default_pic = "".$path."default.jpg";
				if (file_exists($check_jpg)) {
    			    $prof_pic = "<div id='apple'><img src='$check_jpg' width='300px' align='center' rel='#photoverlay'/></div>";
				} else {
					$prof_pic = "<div id='apple'><img src='$default_pic' width='300px' align='center' rel='#photoverlay' /></div>";
				}

				/*=======  Check for leadership positions  =======*/
				$position_name = array("archives" => "Director of Archives",
									   "finance" => "Director of Finance",
									   "brotherhood" => "Director of Brotherhood",
									   "edpol" => "Director of Educational/Political Awareness",
									   "service" => "Director of Service",
									   "alumni" => "Director of Alumni Relations");
				
				$add_position = "<a href='#' id='leadToggle' style='color:#ccc'>+ Add Position</a>
					<div id='leadForm' style='display:none; padding:10; border:solid 1 #ccc; width:330'>
						<form id='PositionForm' enctype='multipart/form-data'>
							<input name='lead_year' id='focus' placeholder='Year' style='width:100'/>
							<select name='lead_name' class='editselect' style='width:150'>
								<option value='null'>Position</option>
								<option value='archives'>Archives</option>
								<option value='finance'>Finance</option>
								<option value='brotherhood'>Brotherhood</option>
								<option value='edpol'>EdPol Awareness</option>
								<option value='service'>Service</option>
								<option value='alumni'>Alumni Relations</option>
							</select>
							<input type='hidden' name='leader_bro' value='$lookupID' />
							<input type='button' class='loginsubmit' id='SavePosition' style='width:60;height:29' value='Add' onclick='return submitPosition();'/>
						</form>
					</div>";
				
				if ($leadership != "") {
					$all_positions = explode(",", $leadership);
					foreach ($all_positions as $each_position){
						preg_match_all('/(\d)|(\w)/', $each_position, $matches);
						$lead_year = implode($matches[1]);
						$position = implode($matches[2]);
						$position = $position_name[$position];
					
						$position_list .= "<tr><td>$lead_year</td><td>$position</td></tr>";
						$positions = "<table cellspacing='0' cellpadding='10' id='positions'>
							<thead>
								<tr bgcolor='#eee'><td>Year</td><td>Position</td></tr>
							</thead>
							<tbody>
								$position_list
							</tbody>
							</table>
							$add_position";
					}
				} else {
					$positions = "<table><tr><td><h3>This brother has not held any positions.</h3></td></tr></table>
						$add_position";
				}
				
				/*=======  House Affiliation  =======*/
				if ($house != "") {
					$selected_house = $house;
				} else {
					$selected_house = "null";
				}
				
				$house_name = array(1 => "Adams",
									2 => "Cabot",
									3 => "Currier",
									4 => "Dunster",
									5 => "Eliot", 
									6 => "Kirkland", 
									7 => "Leverett", 
									8 => "Lowell", 
									9 => "Mather", 
									10 => "Pforzheimer",
									11 => "Quincy",
									12 => "Winthrop");
				
				foreach (range(1,12) as $house_num) {
					$selected = "";
					if($house_name[$house_num] == $selected_house) { $selected = " selected"; }
						$house_select .= '<option value='.$house_name[$house_num].' ' . $selected . '>' . $house_name[$house_num] . '</option>';
				}
				
				/*=======  Birthday Configuration  =======*/
				if ($birthday_full != "") {
					list($bday_y,$bday_m,$bday_d) = explode("-", $birthday_full);
					$selected_year = $bday_y;
					$selected_month = $bday_m;
					$selected_day = $bday_d;
				} else {
					$selected_year = "null";
					$selected_month = "null";
					$selected_day = "null";
				}
			
				$month_name = array(1 => "January",
									2 => "February",
									3 => "March",
									4 => "April",
									5 => "May", 
									6 => "June", 
									7 => "July", 
									8 => "August", 
									9 => "September", 
									10 => "October",
									11 => "November",
									12 => "December");
				$yearRange = 40;
				$ageLimit = 18; // Selected Age
				$thisYear = date('Y');  // Generate Options
				$startYear = ($thisYear - $yearRange);
				$selectYear = ($thisYear - $ageLimit);
				
				foreach (range($thisYear, $startYear) as $year) {
					$selected = "";
					if($year == $selected_year) { $selected = " selected"; }
						$birthday_year .= '<option value='.$year.' ' . $selected . '>' . $year . '</option>';
				}
				
				foreach (range(01, 12) as $month) {
					$selected = "";
					if($month == $selected_month) { $selected = " selected"; }
						$birthday_month .= '<option value='.$month.' ' . $selected . '>' . $month_name[$month] . '</option>';
				}
				
				foreach (range(01, 31) as $day) {
					$selected = "";
					if($day == $selected_day) { $selected = " selected"; }
						$birthday_day .= '<option value='.$day.' ' . $selected . '>' . $day . '</option>';
				}
	
	$profile = "<table cellspacing='10' cellpadding='0' style='width:100%;'>
	<form id='ProfileForm' enctype='multipart/form-data'>
    <input type='hidden' name='bro_profile' value='$lookupID' />
    <tr><td><label>Name:</label></td><td><input type='text' name='firstname' id='focus' placeholder='First' value='$firstname'  style='width:100' />
    		<input type='text' name='middlename' id='focus' placeholder='Middle' value='$middlename'  style='width:100' />
    		<input type='text' name='lastname' id='focus' placeholder='Last' value='$lastname'  style='width:100' /></td></tr>
    <tr><td><label>Brother:</label></td><td><input type='text' id='focus' name='CallName' placeholder='Call Name' value='$CallName' style='width:120'/></td></tr>
    <tr><td><label>Birthday:</label></td><td>
    	<select name='bday_m' class='editselect' style='width:130'>
    		<option value='null'>Month</option>
    		$birthday_month
    	</select>
    	<select name='bday_d' class='editselect' style='width:60'>
    		<option value='null'>Day</option>
    		$birthday_day
    	</select>
    	<select name='bday_y' class='editselect' style='width:75'>
    		<option value='null'>Year</option>
    		$birthday_year
    	</select>
    </td></tr>
    <tr><td><label>Class of:</label></td><td><input type='text' name='class' id='focus' placeholder='Year of Graduation' value='$class'  style='width:100' /></td></tr>
    <tr><td><label>House Affiliation:</label></td><td><select name='house' class='editselect' style='width:150'><option value='null'>House</option>$house_select</select></td></tr>
	<tr><td><label>Concentration:</label></td><td><input type='text' name='concentration' id='focus' placeholder='Concentration' value='$concentration' style='width:310' /></td></tr>
	<tr><td><label>HUID:</label></td><td><input type='text' name='huid' id='focus' placeholder='16-digit HUID' value='$huid' style='width:310; maxlength:16' /></td></tr>
	<tr><td><label>Ethnicity:</label></td><td><input type='text' name='ethnicity' id='focus' placeholder='Ethnicity' value='$ethnicity' style='width:310' /></td></tr>
	<tr><td><label>Hometown:</label></td><td><input type='text' name='hometown' id='focus' placeholder='Hometown' value='$hometown' style='width:310' /></td></tr>
    <tr><td colspan='2'><input type='button' class='submit' id='SaveProfile' value='Update' onclick='return submitProfile();' /></td></tr>
	<div id='previewProfile' style='display:none'></div>
	</form>
	</table>";
	
	$contacts = "<table cellspacing='10' cellpadding='0' style='width:100%;'>
	<form id='ContactsForm' enctype='multipart/form-data'>
	<input type='hidden' name='bro_contacts' value='$lookupID' />
	<tr><td><label><img src='media/spritefb2.png'/></label></td><td><input type='text' name='facebook' id='focus' placeholder='https://facebook.com/myprofile' value='$facebook' style='width:310'/></td></tr>
	<tr><td><label>Email (Harvard):</label></td><td><input type='email' name='emailH' id='focus' placeholder='@college or @post' value='$email' style='width:310'/></td></tr>
	<tr><td><label>Email (Personal):</label></td><td><input type='email' name='emailP' id='focus' placeholder='@gmail' value='$email_personal' style='width:310'/></td></tr>
	<tr><td><label>Email (Work):</label></td><td><input type='email' name='emailW' id='focus' placeholder='@com or @org' value='$email_work' style='width:310'/></td></tr>
	<tr><td><label>Phone (Cell):</label></td><td><input type='text' name='phoneC' id='focus' placeholder='###-###-####' value='$phone_cell' style='width:250'/></td></tr>
	<tr><td><label>Phone (Work):</label></td><td><input type='text' name='phoneW' id='focus' placeholder='###-###-####' value='$phone_work' style='width:250'/></td></tr>
	<tr><td><label>Phone (Home):</label></td><td><input type='text' name='phoneH' id='focus' placeholder='###-###-####' value='$phone_home' style='width:250'/></td></tr>
	<tr><td><label>AIM:</label></td><td><input type='text' name='aim' id='focus' placeholder='AIM SN' value='$aim' style='width:250'/></td></tr>
	<tr><td><label>ICQ:</label></td><td><input type='text' name='icq' id='focus' placeholder='ICQ #' value='$icq' style='width:250'/></td></tr>
	<tr><td colspan='2'><input type='button' class='submit' id='SaveContacts' value='Update' onclick='return submitContacts();' /></td></tr>
	<div id='previewContacts' style='display:none'></div>
	</form>
	</table>";
	
	$survey = "<table cellspacing='10' cellpadding='0' style='width:100%;' id='survey'>
	<tr><td><label>Hobbies & Activities:</label></td><td><p>$hob_act</p></td></tr>
	<tr><td><label>Career Goals:</label></td><td><p>$career_goals</p></td></tr>
	<tr><td><label>Intellectual Interests:</label></td><td><p>$intel_interests</p></td></tr>
	<tr><td><label>Why AAB:</label></td><td><p>$why_aab</p></td></tr>
	</table>";
	
	$photoverlay = "<div class='apple_overlay' id='photoverlay'>
	<h1>Upload a Profile Photo:</h1>
	<form id='PhotoForm' method='post' enctype='multipart/form-data' style='padding:30 0'>
	<img src='media/frame.png' style='vertical-align:middle; padding-right: 20'/><input type='file' name='profpic' id='profpic' />
	<input type='hidden' name='bro_photo' value='$lookupID' />
	<input type='button' class='submit' style='margin-top:30;' value='Upload' onclick='return submitPhoto();' />
	</form>
	<div id='preview' style='display:none'></div>
	</div>";
		}
	}
} //else {header("location: .");}
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"


<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->


<head>
	<meta name="description" content="Brotherhood. Activism. Service."/>
	<meta name="keywords" content="Asian American Brotherhood, Harvard, College, University, AAB"/>
	
	<title><?php echo "$firstname $lastname" ?> - Asian American Brotherhood - Harvard College</title>
	<link rel="icon" type="image/x-icon" href="media/favicon.ico"/>
	<link rel="shortcut icon" type="image/x-icon" href="media/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<link rel="stylesheet" type="text/css" href="css/header.css"/>
	<link rel="stylesheet" type="text/css" href="css/jackedup.css"/>
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
	<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
	<script type="text/javascript" src="js/jquery.form.js"></script>
	<script type="text/javascript" src="js/humane.js"></script>
	<script type="text/javascript" src="js/fileInput.js"></script>
<script>
function submitProfile() {
		$("#previewProfile").html('');
		$("#ProfileForm").ajaxForm({
			target: '#previewProfile'
			}).submit();
        $('#SaveProfile').attr('value','Saved!'); //Creating closure for setTimeout function. 
    		setTimeout(function() { $('#SaveProfile').attr('value','Update') }, 2000);
	return false;
}
function submitContacts() {
		$("#previewContacts").html('');
		$("#ContactsForm").ajaxForm({
			target: '#previewContacts'
			}).submit();
        $('#SaveContacts').attr('value','Saved!'); //Creating closure for setTimeout function. 
    		setTimeout(function() { $('#SaveContacts').attr('value','Update') }, 2000);
    return false;
}
function submitLoc() {
		$("#previewloc").html('');
		$("#LocForm").ajaxForm({
			target: '#previewLoc'
			}).submit();
        $('#SaveLoc').attr('value','Saved!'); //Creating closure for setTimeout function. 
    		setTimeout(function() { $('#SaveLoc').attr('value','Update') }, 2000);
    return false;
}
function submitPosition() {
		$("#previewPosition").html('');
		$("#PositionForm").ajaxForm({
			target: '#previewPosition'
			}).submit();
        $('#SavePosition').attr('value','Saved!'); //Creating closure for setTimeout function. 
    		setTimeout(function() { $('#SavePosition').attr('value','Update') }, 2000);
    return false;
}
function submitAlum() {
		$("#previewAlum").html('');
		$("#AlumForm").ajaxForm({
			target: '#previewAlum'
			}).submit();
        $('#SaveAlum').attr('value','Saved!'); //Creating closure for setTimeout function. 
    		setTimeout(function() { $('#SaveAlum').attr('value','Update') }, 2000);
    return false;
}

function submitPhoto() {
		$("#preview").html('');
		$("#PhotoForm").ajaxForm({
			target: '#preview'
			}).submit();
		var jacked = humane.create({baseCls: 'humane-jackedup', addnCls: 'humane-jackedup-success'})
jacked.log("Photo Added!");
	return false;
}


$(document).ready(function(){
  $("a#leadToggle").click(function(){
    $("div#leadForm").toggle(400);
  });
});

$(document).ready(function(){
$('#tabs div').hide();
$('#tabs div:first').show();
$('#tabs ul li:first').addClass('active');
 
$('#tabs ul li a').click(function(){
$('#tabs ul li').removeClass('active');
$(this).parent().addClass('active');
var currentTab = $(this).attr('href');
$('#tabs div').hide();
$(currentTab).show();
return false;
});
});

$(function() {
	$("#apple img[rel]").overlay({effect: 'apple'});
});
</script>

<!--[if lt IE 7]>
<style>
  div.apple_overlay {
    background-image:url(/media/img/overlay/overlay_IE6.gif);
    color:#fff;
  }
 
  /* default close button positioned on upper right corner */
  div.apple_overlay div.close {
    background-image:url(/media/img/overlay/overlay_close_IE6.gif);
  }
</style>
<![endif]-->

	<style>
#survey p{font-family:Arial, sans-serif;font-size:14}

a#directory {color:#ccc; text-align:right; font-size:30}
a#directory:hover {color:#888}

.apple_overlay {width:450; background-image:url('media/white.png');}

table#positions {border:solid 1 #ccc}
table#positions tbody tr td {font-family: Arial, sans-serif;}

#tabs { width:100% }
#tabs ul { margin-bottom:10; padding-bottom:10; border-bottom: dotted 1 #ccc }
#tabs ul li {margin-right:20}
#tabs ul li a {font-size:20}
	</style>
</head>

<body id="directory" class="pattern">

	<?php include_once "$header.php" ?>

<div class="body-wrap">

<div class="inner_content">

<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
	<td valign="top" width="320px"><a href='#'><?php echo $prof_pic ?></a><?php echo $photoverlay ?></td>
	
	<td valign="top">
	
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr><td><h1 class="tabs"><?php echo "$firstname $lastname" ?></h1></td>
		<td valign="top"><h3 style="text-align:right"><a href='directory' id='directory'>Directory ></a></h3></td></tr>
	</table>
	
	<div id='tabs'>
	<ul>
		<li><a href="#profileDiv">Profile</a></li>
		<li><a href="#contactsDiv">Contacts</a></li>
		<?php echo $location_tab ?>
		<li><a href="#surveyDiv">Survey</a></li>
		<li><a href="#positionsDiv">Roles</a></li>
		<?php echo $alumni_tab ?>
	</ul>
	
		<div id='profileDiv'><?php echo $profile ?></div>
		<div id='contactsDiv'><?php echo $contacts ?></div>
		<div id='locationDiv'><?php echo $location ?></div>
		<div id='surveyDiv'><?php echo $survey ?></div>
		<div id='positionsDiv'><?php echo $positions ?></div>
		<div id='alumniDiv'><?php echo $alumni ?></div>
	</div>
	
	</td></tr>
</table>

	</div>

</div>

</body>
</html>