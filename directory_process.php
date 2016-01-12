<?php
include_once "scripts/checkbro.php";
if (isset($_GET['bro'])){
	$bro = $_GET['bro'];
}

	$bro_sql = mysql_query("SELECT * FROM brothers WHERE bro='$bro' LIMIT 1") or die (mysql_error());
	$bro_count = mysql_num_rows($bro_sql);
	if ($bro_count > 0) {
		while ($row = mysql_fetch_array($bro_sql)){
			$firstname = $row['FirstName'];
			$middlename = $row['MiddleName'];
			$lastname = $row['LastName'];
			$class = $row['Class'];
			$recruitclass = $row['RecruitClass'];
			$callname = $row['CallName'];
			$callnamestory = $row['CallNameStory'];
			$house = $row['House'];
			$concentration = $row['Concentration'];
			$hometown = $row['Hometown'];
			$ethnicity = $row['Ethnicity'];
			$birthday = $row['Birthday'];
			$hobbies = $row['Hobbies'];
			$career_goals = $row['CareerGoals'];
			$intel_interests = $row['Interests'];
			$why_aab = $row['WhyAAB'];
			$email_harvard = $row['Email'];
			$email_personal = $row['Email_personal'];
			$phone_cell = $row['Phone_cell'];
			$phone_home = $row['Phone_home'];
			$huid = $row['HUID16'];
			$campusAdd = $row['CampusAdd'];
			$mailAdd = $row['MailingAdd'];
			$homeAdd = $row['HomeAdd'];
			$facebook = $row['Facebook'];
			$twitter = $row['Twitter'];
			$linkedin = $row['LinkedIn'];
			$currentloc = $row['CurrentLocation'];
			$companyorg = $row['CompanyOrg'];
			$position = $row['Position'];
			$lastactivity = $row['LastActivity'];
			
			
			
			// BASIC INFO
			$classY = substr($class, 2);
			$class = "<tr><td><label id='label'>Graduating Class</label></td><td>$class</td></tr>";
			
			if (strlen($middlename)) {
				$middlename = " $middlename";
			} else {
				$middlename = "";
			}
			
			if (strlen($callname)) {
				$callname = "<tr><td><label id='label'>Call Name</label></td><td>Brother $callname</td></tr>";
			} else {
				$callname = "";
			}
			
			if (strlen($callnamestory)) {
				$callnamestory = "<tr><td><label id='label'>Story Behind the Call Name</label></td><td>$callnamestory</td></tr>";
			} else {
				$callnamestory = "";
			}
			
			if (strlen($recruitclass)){
				$recruitclass = "<tr><td><label id='label'>Recruit Class</label></td><td>$recruitclass</td></tr>";
			} else {
				$recruitclass = "";
			}
			
			
			// BIRTHDAY
			if ($birthday == "null-null-null") {
				$birthday == "";
			} elseif (!strlen($birthday)) {
				$birthday == "";
			} elseif (strlen($birthday)) {
				list($by,$bm,$bd) = explode("-",$birthday);			// Check if bday has month
				if (strlen($by)) {
					$full_date = "$by-$bm-$bd";
					$bday_echo = date("F j, Y", strtotime($full_date));
				} else {
					$bdayyear = date("Y");
					$full_date = "$bdayyear-$bm-$bd";
					$bday_echo = date("F j", strtotime($full_date));
				}
				
				//$bday = 
				$birthday = "<tr><td><label id='label'>Birthday</label></td><td>$bday_echo</td></tr>";
			}
			
			
			
			// BASIC INFO
			if (strlen($house)){ $house = "<tr><td><label id='label'>House</label></td><td>$house</td></tr>"; } else { $house = ""; }
			if (strlen($concentration)){$concentration = "<tr><td><label id='label'>Concentration</label></td><td>$concentration</td></tr>";} else {$concentration = "";}
			if (strlen($hometown)){$hometown = "<tr><td><label id='label'>Hometown</label></td><td>$hometown</td></tr>";} else {$hometown = ""; $concentration = "$concentration";}
			if (strlen($phone_cell)) {$phone_cell = "<tr><td><label id='label'>Mobile</label></td><td>$phone_cell</td></tr>";}
			if (strlen($phone_home)) {$phone_home = "<tr><td><label id='label'>Home</label></td><td>$phone_home</td></tr>";}
			if (strlen($email_harvard)) {$email_harvard = "<tr><td><label id='label'>Harvard</label></td><td><a href='mailto:$email_harvard' class='email'>$email_harvard</a></td></tr>";}
			if (strlen($email_personal)) {$email_personal = "<tr><td><label id='label'>Personal</label></td><td><a href='mailto:$email_personal' class='email'>$email_personal</a></td></tr>";}
			
			
			
			// ALUM / SOCIAL MEDIA INFO
			if (strlen($position)) {$position = "<b style='color: #243E6E'>$position</b> at ";} else {$position = "Works at ";}
			if (!strlen($companyorg)) {
				$position = "";
				$career = "";
			} else {
				$companyorg = "<b style='color: #243E6E'>$companyorg</b><br>";
				$career = "<img src='pix/suitcase.svg' style='height:18px;width:20px;vertical-align:middle;'/> $position$companyorg";
			}
			if (strlen($currentloc)) {
				$currentloc = "<img src='pix/location.svg' style='height:20px;width:20px;vertical-align:middle;'/> <b style='color: #243E6E'>$currentloc</b><br>";
			} else {
				$currentloc = "";
			}
			
			if (strlen($career) || strlen($currentloc)) { $currentinfo = "<div class='category'>$career$currentloc</div>"; }
			
			
			
			// LAST ACTIVITY
			if (!strlen($lastactivity)) {
				$lastactivity = "";
			} else {
			
			$now = date("U");
			$lastactivity = date("U", strtotime($lastactivity));
			$diff = $now - $lastactivity;
			if ($diff < 60) { $txt = "a few seconds ago"; }  // less than 60 sec
			elseif ($diff < 60*50) { $txt = "a few minutes ago"; }  // less than 3000sec / 50 min
			elseif ($diff < 5400) { $txt = "about an hour ago"; }  // less than 5400sec / 1hr30 min
			elseif ($diff < 60*60*20) { $txt = "a few hours ago"; }  // less than 5hrs
			elseif ($diff < 60*60*24) { $txt = "a day ago"; }  // less than 24 hrs
			elseif ($diff < 60*60*24*6) { $txt = "a few days ago"; }  // less than 6 days
			elseif ($diff < 60*60*24*9) { $txt = "about a week ago"; }  // less than 9 days
			elseif ($diff < 60*60*24*28) { $txt = "a few weeks ago"; }  // less than 28 days
			elseif ($diff < 60*60*24*45) { $txt = "about a month ago"; }  // less than 45 days
			elseif ($diff < 60*60*24*30*12) {
				$diff_mo = round($diff/(60*60*24*30));
				$txt = "$diff_mo months ago"; }  // less than a year
			elseif ($diff < 60*60*24*30*12*10) {
				if ($diff < 60*60*24*30*12*2) { // 1 year ago
					$diff_yr = round($diff/(60*60*24*30*12));
					$txt = "$diff_yr year ago";
				} else {
					$diff_yr = round($diff/(60*60*24*30*12));
					$txt = "$diff_yr years ago";
				}  // less than ten years
			}
			
			$lastactivity = "<br><br><span class='last-act'>Last seen $txt</span>";
			
			}
			
			
			// SURVEY FORMATTING
			$hobbies = nl2br($hobbies);
			$career_goals = nl2br($career_goals);
			$intel_interests = nl2br($intel_interests);
			$why_aab = nl2br($why_aab);
			
			// SURVEY
			if (strlen($hobbies)){$hobbies = "<b>Hobbies & Activities</b><p>$hobbies</p>";} else {$hobbies = "";}			
			if (strlen($career_goals)){$career_goals = "<b>Career Goals</b><p>$career_goals</p>";} else {$career_goals = "";}
			if (strlen($intel_interests)){$intel_interests = "<b>Intellectual Interests</b><p>$intel_interests</p>";} else {$intel_interests = "";}
			if (strlen($why_aab)){$why_aab = "<b>Why AAB</b><p>$why_aab</p>";} else {$why_aab = "";}
			
			if ((strlen($hobbies))||(strlen($career_goals))||(strlen($intel_interests))||(strlen($why_aab)))
			{$survey = "<div class='survey'>$hobbies$career_goals$intel_interests$why_aab</div>";}
			
			
			// SOCIAL NETWORKS
				if (strlen($facebook)) {$fb = "<a href='$facebook'><img src='pix/icons/socialfb.png' class='social' /></a>";} else {$fb = "";}
				if (strlen($twitter)) {$tw = "<a href='$twitter'><img src='pix/icons/socialtw.png' class='social' /></a>";} else {$tw = "";}
				if (strlen($linkedin)) {$li = "<a href='$linkedin'><img src='pix/icons/socialli.png' class='social' /></a>";} else {$li = "";}
		
				if ((strlen($fb)) || (strlen($tw)) || (strlen($li))) {
					$social = "<tr><td><label id='label'>Social</label></td><td>$fb$tw$li</td></tr>";
				}
			
			
			// PROF PHOTO
			$profpic = "vault/photos/profpic/$bro.jpg";
			$default = "vault/photos/profpic/default.jpg";
			if (file_exists($profpic)) {
				$thumb = "<a href='directory_photo?bro=$bro' id='thumb'><img src='$profpic' class='thumb preview' id='thumbnail' title='Click to enlarge!'/></a>";
			} else {
				$thumb = "<img src='$default' class='thumb preview' />";
			}
			
		
		if (isset($_GET['source'])){
			$source = $_GET['source'];
		}
		
		$broster .= "$random
		<div class='lookupContent' id='box'>
		<table cellspacing='0' cellpadding='0' class='profile'><tr>
		<td width='270px' valign='top'>
		<div class='thumb'>$thumb</div>
		</td>
		<td valign='top'>
		
		<div class='profile'>
		
		<span class='name'>$firstname$middlename $lastname</span><span class='classyear'> '$classY</span>
		<a href='directory_edit?bro=$bro&source=$source' class='edit-link right hidden'>EDIT</a><br>
		
		<div id='tabbing-container' class='tab-container'>
			<ul class='etabs'>
    			<li class='tab'><a href='#profile'>Profile</a></li>
    			<li class='tab'><a href='#survey'>Survey</a></li>
    			<li class='tab'><a href='#contacts'>Contact</a></li>
  			</ul>
  			
  			<div id='profile' class='detailed-profile hidden'>
    			
    			$currentinfo
				
				<table id='detailed-profile'>
				<tr><td width='150px'><label id='contact'></label></td><td width='200px'></td></tr>
				$recruitclass$callname$callnamestory$house$concentration$hometown$birthday$social
				</table>
				$lastactivity
  			</div>
  			
  			<div id='survey' class='detailed-profile hidden'>
    			$survey
  			</div>
  			
  			<div id='contacts' class='detailed-profile hidden'>
    			<table id='detailed-profile'>
				<tr><td width='150px'><label id='contact'></label></td><td width='200px'></td></tr>
				$phone_cell$phone_home$email_personal$email_harvard
				</table>
  			</div>
		</div>
		
		
		
		</div>
		</td>
		</tr></table>
		</div>
		
		<script>
		$(function(){
			$('#tabbing-container').easytabs();
			$('img.thumb.preview[title]').tooltip();
			$('div.lookupContent').hover(function(){
				$(this).find('a.edit-link').toggle();
			});
			
			$('a.edit-link').click(function(){
				$('div.lookupDiv').empty();
				$('div.lookupDiv').load('directory_edit?bro=$bro&source=$source');
				return false;
			});
			
			$('img#thumbnail').click(function(){
				$('div.lookupDiv').empty();
				$('div.lookupDiv').load('directory_photo?request=enlarge&bro=$bro&source=$source');
				return false;
			});
		});
		</script>";
		
		if (isset($_GET['echo'])) {
			echo $broster;
		}
		
		}
	}
?>