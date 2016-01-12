<?php

include "scripts/checkbro.php";

if (isset($_GET['bro'])) {
	$bro = $_GET['bro'];
	$sql = mysql_query("SELECT * FROM brothers WHERE bro = '$bro' LIMIT 1");
	$broCount = mysql_num_rows($sql);
	if ($broCount > 0){
		while($row = mysql_fetch_array($sql)){
			$class = $row['Class'];   // class of the brother in question
			
			// Get today's date to see which class is OLDEST and STILL ENROLLED
			$month = date('m');
			$year = date('Y');
			if ($month < 6){
				$senior_class = $year;
			} else{
				$senior_class = $year + 1;
			}
			
			if ($class >= $senior_class) {
				$enrolled = true;
			} else {
				$enrolled = false;
			}
		
		if ($enrolled) {  /*============ BROFILE OF CURRENT BROTHER ==============*/

			/*-------- INDIVIDUAL BROFILE INFO ----------*/
			$fname = $row['FirstName'];
			$lname = $row['LastName'];
			$class = $row['Class'];
			$concentration = $row['Concentration'];
			$house = $row['House'];
			$hometown = $row['Hometown'];
			$ethnicity = $row['Ethnicity'];
			$hob_act = $row['Hobbies'];
			$career_goals = $row['CareerGoals'];
			$intel_interests = $row['Interests'];
			$why_aab = $row['WhyAAB'];
			$facebook = $row['Facebook'];
			
			$classY = substr($class, 2);
			
			/*------  Display Pic. If not, default pic.  -----*/
			$check_jpg = "vault/photos/profpic/$bro.jpg";
			$default_pic = "vault/photos/profpic/default.jpg";
			if (file_exists($check_jpg)) {
    		    $prof_pic = "<img src='$check_jpg' class='thumb profpic' />";
			} else {
				$prof_pic = "<img src='$default_pic' class='thumb profpic' />";
			}
			
			if (strlen($house)){ $houseO = "$house House"; } else { $houseO = ""; }
			if (strlen($facebook)) {$fblink = "<a href='$facebook'><img src='pix/spritefb1.png' onMouseOver=\"this.src='pix/spritefb2.png'\" onMouseOut=\"this.src='pix/spritefb1.png'\" style='vertical-align:middle; float:right;'/></a>";} else {$fblink = "";}
			if (strlen($concentration)){$concentration = "&nbsp;&nbsp;&#8226;&nbsp;&nbsp;$concentration";} else {$concentration = "";}
			if (strlen($hometown)){$hometown = "&nbsp;&nbsp;&#8226;&nbsp;&nbsp;$hometown";} else {$hometown = "";}
			if (strlen($hob_act)){$hob_act = "<b>Hobbies & Activities</b><p>$hob_act</p>";} else {$hob_act = "";}
			if (strlen($career_goals)){$career_goals = "<b>Career Goals</b><p>$career_goals</p>";} else {$career_goals = "";}
			if (strlen($intel_interests)){$intel_interests = "<b>Intellectual Interests</b><p>$intel_interests</p>";} else {$intel_interests = "";}
			if (strlen($why_aab)){$why_aab = "<b>Why AAB</b><p>$why_aab</p>";} else {$why_aab = "";}
			

			
			$broInfo .= "<table width='100%' cellspacing='0' cellpadding='0' id='brofile-box' class='lift-shadow' style='width:100%'>
			<tr width='100%'>
				<td valign='top' width='280px'>
				$prof_pic
				</td>
				
				<td valign='top' style='width:384; float:left;'>
				<h2><span id='name'>$fname $lname</span><span id='classyear'> '$classY</span>$fb</h2>
				<p id='info'>$house$concentration$hometown</p>
			
				$hob_act$career_goals$intel_interests$why_aab
				</td>
			</tr>
			</table>";

/*============ roster of current bros ==============*/
$broster_link = "Brothers";

// Count down from the latest graduated class and render roster
for ($i = $senior_class; $i <= ($senior_class + 2); $i++){
$class = mysql_query("SELECT * FROM brothers WHERE Class = '$i' ORDER BY LastName ASC");
while($row = mysql_fetch_array($class)){
		$bro = $row['bro'];
		$firstname = $row['FirstName'];
		$lastname = $row['LastName'];
		
		if (isset($_GET['bro'])) {
			$broID = $_GET['bro'];
			if ($bro !== $broID) {
				$bro_link = "<a href='brofile?bro=$bro'><li>$firstname $lastname</li></a>";
			} else {
				$bro_link = "<li class='selected'>$firstname $lastname</li>";
			}
		}
		
		${'bros'.$i} .= $bro_link;
	}

$upperclassmen .= "<dt>Class of $i</dt>
		${'bros'.$i}<br>";
}

// If freshmen are admitted, add to roster
$class = mysql_query("SELECT * FROM brothers WHERE Class = '$i' ORDER BY LastName ASC");
$classCount = mysql_num_rows($class);
if ($classCount > 0){
	while($row = mysql_fetch_array($class)){
		$bro = $row['bro'];
		$firstname = $row['FirstName'];
		$lastname = $row['LastName'];
		
		if (isset($_GET['bro'])) {
			$broID = $_GET['bro'];
			if ($bro !== $broID) {
				$bro_link = "<a href='brofile?bro=$bro'><li>$firstname $lastname</li></a>";
			} else {
				$bro_link = "<li class='selected'>$firstname $lastname</li>";
			}
		}
		
		${'bros'.$i} .= $bro_link;
	}

$younguns .= "<dt>Class of $i</dt>
		${'bros'.$i}<br>";
}

$broster = "$upperclassmen$younguns";

		} else {   					/*============ BROFILE OF ALUMNI BROTHER ==============*/
		$broster_link = "Alumni";
			$privacy = $row['Privacy'];
			
			if ($privacy == "1") {		// If Private Profile set, don't show. Redirect to brothers page.
				header("location: brothers");
			} else {
			
			$fname = $row['FirstName'];
			$lname = $row['LastName'];
			$class = $row['Class'];
			$concentration = $row['Concentration'];
			$house = $row['House'];
			$hometown = $row['Hometown'];
			$ethnicity = $row['Ethnicity'];
			$hob_act = $row['Hobbies'];
			$career_goals = $row['CareerGoals'];
			$intel_interests = $row['Interests'];
			$why_aab = $row['WhyAAB'];
			$Privacy = $row['Privacy'];
			$companyorg = $row['CompanyOrg'];
			$position = $row['Position'];
			$currentloc = $row['CurrentLocation'];
			$facebook = $row['Facebook'];
			
			$classY = substr($class, 2);
			
			if (strlen($facebook)) {
				$fblink = "<a href='$facebook'><img src='pix/spritefb1.png' onMouseOver=\"this.src='pix/spritefb2.png'\" onMouseOut=\"this.src='pix/spritefb1.png'\" style='vertical-align:middle; float:right;'/></a>";
			} else {
				$fblink = "";
			}
			
			if (strlen($position)) {
				$position = "<b style='color: #243E6E'>$position</b> at ";
			} else {
				$position = "Works at ";
			}
			
			if (strlen($companyorg)) {
				$position = "";
				$career = "";
			} else {
				$companyorg = "<b style='color: #243E6E'>$companyorg</b><br>";
				$career = "<img src='pix/suitcase.svg' style='height:18;width:20;vertical-align:middle;'/> $position$companyorg";
			}
			
			if (strlen($currentloc)) {
				$currentloc = "<img src='pix/location.svg' style='height:20;width:20;vertical-align:middle;'/> <b style='color: #243E6E'>$currentloc</b><br>";
			} else {
				$currentloc = "";
			}

			if (strlen($house)){
				$houseO = "$house House";
			} else {
				$houseO = "";
			}
			
			if (strlen($hob_act)){
				$hob_act = "<b>Hobbies & Activities</b><p>$hob_act</p>";
			} else {
				$hob_act = "";
			}
			
			if (strlen($career_goals)){
				$career_goals = "<b>Career Goals</b><p>$career_goals</p>";
			} else {
				$career_goals = "";
			}
			
			if (strlen($intel_interests)){
				$intel_interests = "<b>Intellectual Interests</b><p>$intel_interests</p>";
			} else {
				$intel_interests = "";
			}
			
			if (strlen($why_aab)){
				$why_aab = "<b>Why AAB</b><p>$why_aab</p>";
			} else {
				$why_aab = "";
			}
			
			/*------  Display Pic. If not, default pic.  -----*/
			$check_jpg = "vault/photos/profpic/$bro.jpg";
			$default_pic = "vault/photos/profpic/default.jpg";
			if (file_exists($check_jpg)) {
				$prof_pic = "<img src='$check_jpg' class='thumb profpic' />";
			} else {
				$prof_pic = "<img src='$default_pic' class='thumb profpic' />";
			}
			
			/*============= This section would have allowed logged in bros to see the public directory
			if (isset($_SESSION["bro"])) {
				$survey = "$hob_act$career_goals$intel_interests$why_aab";
				$currentinfo = "$career$currentloc";
				$fb = $fblink;
			} else { */
				$survey = "";
				$currentinfo = "";
				$fb = "";
				$prof_pic = "<img src='$default_pic' class='thumb profpic' />";
			
			
			$broInfo .= "<table width='100%' cellspacing='0' cellpadding='0' id='brofile-box' class='lift-shadow' style='width:100%'>
			<tr width='100%'>
				<td valign='top' width='280px'>$prof_pic</td>
				
				<td valign='top' style='width:384px; float:left;'>
				<h2><span id='name'>$fname $lname</span><span id='classyear'> '$classY</span>$fb</h2>
				<p>$currentinfo</p>
				<p id='info'>$house&nbsp;&nbsp;&#8226;&nbsp;&nbsp;$concentration&nbsp;&nbsp;&#8226;&nbsp;&nbsp;$hometown</p>
				
				$survey
				</td>
			</tr>
			</table>";
			
			}
			/*============ GENERATE ROSTER OF ALL BROS by CLASS ==============*/

			// Get today's date to see which class graduated most recently
			$month = date("m");
			$year = date("Y");

			if ($month > 6){
				$classYear = $year;
			} else{
				$classYear = $year - 1;
			}

			// Count down from the latest graduated class and render roster
			for ($i = $classYear; $i >= 2001; $i--){
				$class = mysql_query("SELECT * FROM brothers WHERE Class = '$i' ORDER BY LastName ASC");
				$classCount = mysql_num_rows($class);
				if ($classCount > 0){
					while($row = mysql_fetch_array($class)){
						$bro = $row['bro'];
						$firstname = $row['FirstName'];
						$lastname = $row['LastName'];
						$privacy = $row['Privacy'];
						
						if ($privacy == "1") {
						} else {
		
						if (isset($_GET['bro'])) {
							$broID = $_GET['bro'];
							if ($bro !== $broID) {
								$bro_link = "<a href='brofile?bro=$bro'><li>$firstname $lastname</li></a>";
							} else {
								$bro_link = "<li class='selected'>$firstname $lastname</li>";
							}
						}
		
						${'bros'.$i} .= $bro_link;
						
						}
					}
				}
				$broster .= "<dt>Class of $i</dt>${'bros'.$i}<br>";
			}
		}
		}
	}
}


mysql_close($mysql_connection);

?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"
      xmlns:fb="https://www.facebook.com/2008/fbml">


<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->


<head>
<title><?php echo "$fname $lname"; ?> - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>
</head>

<body id="brothers">
<div class="wrap">

<?php include_once "$header.php" ?>


	<div class="brofile-nav left">
		<h1><a href="brothers" id='bro_link'><?php echo $broster_link ?></a></h1>
		<div id='brofile-list'><?php echo $broster ?></div>
	</div>
	<div class="brofile right">
		<?php echo $broInfo ?>
		<?php echo $broverlay ?>
	</div>

<script>
$(function() {
	$("#apple img[rel]").overlay({effect: 'apple'});
});
</script>

</div>

</body>
</html>