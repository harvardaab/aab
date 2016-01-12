<?php

require_once "scripts/checkbro.php";

/*------------- generating bro name for profile link ---------------*/
if (!isset($_SESSION["bro"])) {header("location: .");}

function clean($elem) 
{ 
    if(!is_array($elem)) 
        $elem = htmlentities($elem,ENT_QUOTES,"UTF-8"); 
    else 
        foreach ($elem as $key => $value) 
            $elem[$key] = mysql_real_escape_string($value);
    return $elem; 
} 
$_CLEAN = clean($_POST);
$_CLEANED = clean($_GET);
/*============ UPDATING PROFILE / DIRECTORY ==============*/
if(isset($_POST['bro_profile'])) {
	$bro = $_CLEAN['bro_profile'];
	$firstname = $_CLEAN['firstname'];
	$middlename = $_CLEAN['middlename'];
	$lastname = $_CLEAN['lastname'];
	$callname = $_CLEAN['callname'];
    $class = $_CLEAN['class'];
    $recruitclass = $_CLEAN['recruitclass'];
    $house = $_CLEAN['house'];
    $concentration = $_CLEAN['concentration'];
    $huid = $_CLEAN['huid'];
    $ethnicity = $_CLEAN['ethnicity'];
    $hometown = $_CLEAN['hometown'];
    $bday_m = $_CLEAN['bday_m'];
    $bday_d = $_CLEAN['bday_d'];
    $bday_y = $_CLEAN['bday_y'];
    $CampusAdd = $_CLEAN['campusadd'];
    $MailingAdd = $_CLEAN['mailadd'];
    $HomeAdd = $_CLEAN['homeadd'];
    $emailH = $_CLEAN['emailharv'];
    $emailP = $_CLEAN['emailpers'];
    $emailW = $_CLEAN['emailwork'];
    $phoneC = $_CLEAN['phonecell'];
    $phoneW = $_CLEAN['phonework'];
    $phoneH = $_CLEAN['phonehome'];
    $facebook = $_CLEAN['facebook'];
    $twitter = $_CLEAN['twitter'];
    $linkedin = $_CLEAN['linkedin'];
    $Occupation = $_CLEAN['occupation'];
    $CompanyOrg = $_CLEAN['companyorg'];
    $Position = $_CLEAN['position'];
    $CurrentCity = $_CLEAN['currentloc'];
    $Address = $_CLEAN['address'];
    $HobbiesInterests = $_CLEAN['hobbiesint'];
    
    if (($bday_m == "") || ($bday_d == "")) {
    	$birthday_update = "";
    } else {
    	$birthday_update = "$bday_y-$bday_m-$bday_d";
    }
    $pw_lower = strtolower($callname);
    $pw_sql = str_replace("-", "", $pw_lower);
    $pw_sql = str_replace(" ", "", $pw_sql);
    
	$update_sql = mysql_query("UPDATE brothers SET FirstName='$firstname', MiddleName='$middlename', LastName='$lastname',
	CallName='$callname', Password='$pw_sql', Class='$class', RecruitClass='$recruitclass', House='$house', Concentration='$concentration', HUID16='$huid',
	Ethnicity='$ethnicity', Hometown='$hometown', Birthday='$birthday_update', Email='$emailH', Email_personal='$emailP',
	Email_work='$emailW', Phone_cell='$phoneC', Phone_work='$phoneW', Phone_home='$phoneH', Facebook='$facebook', Twitter='$twitter',
	LinkedIn='$linkedin', CampusAdd='$CampusAdd', MailingAdd='$MailingAdd', HomeAdd='$HomeAdd', Occupation='$Occupation',
	CompanyOrg='$CompanyOrg', Position='$Position', CurrentLocation='$CurrentCity', Address='$Address',
	HobbiesInterests='$HobbiesInterests' WHERE bro='$bro'") or die (mysql_error());
}


/*============ LOOKING UP A BRO (if a specific brother is queried/direct-linked) ==============*/
if(isset($_GET['bro'])){
	$bro = $_CLEANED['bro'];
	
	include_once "directory_process.php";
	
	$lookup = $broster;
} else {
	
	// Getting a random bro's profile
	$aab_sql = mysql_query("SELECT bro FROM brothers") or die (mysql_error());
	$aab_count = mysql_num_rows($aab_sql);

	$bro = rand(0, $aab_count);
	$random = "<div class='random'><span>Meet a new brother!</span></div>";
	
	include_once "directory_process.php";
	
	$lookup = $broster;
}

/*============ GENERATE ROSTER OF ALL BROS by CLASS ==============*/

// Get today's date to see which class is OLDEST and STILL ENROLLED
$year = date("Y");
$classYear = $year + 3;

// Count down from the youngest class and render roster
for ($i = $classYear; $i > 2000; $i--){
	$class_sql = mysql_query("SELECT * FROM brothers WHERE Class = '$i' ORDER BY Class DESC, LastName ASC");
	$classCount = mysql_num_rows($class_sql);
	if ($classCount > 0) {
		while($row = mysql_fetch_array($class_sql)){
			$eachbro = $row['bro'];
			$FirstName = $row['FirstName'];
			$LastName = $row['LastName'];
			
			
			$classY = substr($Class, 2);
			
			// Check for photos
			$profpic = "vault/photos/profpic/$eachbro.jpg";
			$default = "vault/photos/profpic/default.jpg";
			if (file_exists($profpic)) {
				$thumb = "<img src='$profpic' class='thumb small' />";
			} else {
				$thumb = "<img src='$default' class='thumb small' />";
			}
			
			//If this bro is selected, show selection in the nav list
			if ($eachbro == $bro) {
				$selected = "rarrow";
			} else {
				$selected = "rarrow hidden";
			}
		
		$directory .= "<a href='directory_process?bro=$eachbro&echo=yes&source=directory' id='each-bro'><div class='each-itemDiv'>
		<div class='each-item'>
		<table cellspacing='0' cellpadding='0'><tr>
		<td width='60px'>$thumb</td>
		<td width='200px'><span class='name'>$FirstName $LastName</span></td>
		<td width='20px'><img src='pix/rarrow.svg' class='$selected' style='width: 14px; height: 14px;' /></td>
		</tr></table>
		</div>
		</div>
		</a>";
		}
	}
}

mysql_close($mysql_connection);

?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->


<head>
<title>Directory - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>
<script src="/js/jquery.easytabs.min.js"></script>
<script>
$(function(){
	$('a#each-bro').click(function(){
		var thisurl = $(this).attr('href');
		$('div.lookupDiv').load(thisurl);
		
		$(this).find('div.each-itemDiv img.rarrow').show();
		$(this).siblings().find('div.each-itemDiv img.rarrow').hide();
		
		return false;
	});
	
	$('#loadingDiv')
    .hide()  // hide it initially
    .ajaxStart(function() {
        $(this).show();
    })
    .ajaxStop(function() {
        $(this).hide();
    });
});
</script>
<style>
.etabs, .tab { margin: 0px; padding: 0; }
.tab { display: inline-block; zoom:1; *display:inline; background: #fff; }
.tab a { font-size: 14px; line-height: 2em; display: block; margin:0px; padding: 0 10px; outline: none; }
.tab a:hover { text-decoration: none; }
.tab.active { background: #fff; position: relative; border-bottom: solid 1px #ccc; }
.tab a.active { font-weight: bold; }
.tab-container {margin-top:20px;}
.tab-container, .panel-container { background: #fff; border: solid #eee 1px; padding: 10px;}
</style>
</head>

<body id="directory" class="pattern">

<?php include_once "sidebar.php" ?>

<div class="main-wrap">

	<div id='top-bar'>
		<ul class='top-heading'><li><span>Directory</span></li></ul>
		<?php include_once "searchbar.php" ?>
	</div>

	<div class="inner_content">
	
		<div class='sidelist overflow'>
			<?php echo $directory; ?>
		</div>
	
		<div class='lookupDiv overflow'>
			<?php echo $lookup; ?>
		</div>

	</div>

</div>
</body>
</html>