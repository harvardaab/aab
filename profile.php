<?php
header('Content-Type: text/html; charset=utf-8');
require_once "scripts/checkbro.php";

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
	$callnamestory = $_CLEAN['callnamestory'];
	$recruitclass = $_CLEAN['recruitclass'];
    $class = $_CLEAN['class'];
    $house = $_CLEAN['house'];
    $concentration = $_CLEAN['concentration'];
    $huid = $_CLEAN['huid'];
    $ethnicity = $_CLEAN['ethnicity'];
    $hometown = $_CLEAN['hometown'];
    $bday_m = $_CLEAN['bday_m'];
    $bday_d = $_CLEAN['bday_d'];
    $bday_y = $_CLEAN['bday_y'];
    $hobbies = $_CLEAN['hobbies'];
    $careergoals = $_CLEAN['careergoals'];
    $intelint = $_CLEAN['intelint'];
    $whyaab = $_CLEAN['whyaab'];
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
	CallName='$callname', CallNameStory='$callnamestory', Password='$pw_sql', Class='$class', RecruitClass='$recruitclass', House='$house', Concentration='$concentration', HUID16='$huid',
	Ethnicity='$ethnicity', Hometown='$hometown', Birthday='$birthday_update', Email='$emailH', Email_personal='$emailP',
	CareerGoals='$careergoals', Hobbies='$hobbies', Interests='$intelint', WhyAAB='$whyaab',
	Email_work='$emailW', Phone_cell='$phoneC', Phone_work='$phoneW', Phone_home='$phoneH', Facebook='$facebook', Twitter='$twitter',
	LinkedIn='$linkedin', CampusAdd='$CampusAdd', MailingAdd='$MailingAdd', HomeAdd='$HomeAdd', Occupation='$Occupation',
	CompanyOrg='$CompanyOrg', Position='$Position', CurrentLocation='$CurrentCity', Address='$Address',
	HobbiesInterests='$HobbiesInterests' WHERE bro='$bro'") or die (mysql_error());
}
mysql_close($mysql_connection);
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"


<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->


<head>
<title><?php echo "$FirstName $LastName" ?> - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>
<script src="/js/jquery.easytabs.min.js"></script>
<script>
$(function(){
	var thisurl = $('a#profilebro').attr('href');
	$('div.lookupDiv').load(thisurl);
	
	$('a.sidenav').click(function(){
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
<div class="in-wrap">

<?php include_once "sidebar.php" ?>
	<div id='top-bar'>
		<ul class='top-heading'><li><span><?php echo "$FirstName $LastName" ?></span></li></ul>
		<?php include_once "searchbar.php" ?>
	</div>

<div class="inner_content">
	
	<div class='sidelist'>
		<a href='directory_process?bro=<?php echo $bro ?>&echo=yes&source=profile' id='profilebro' class='sidenav'>
			<div class='each-itemDiv content-nav selected'><div class='each-item'><span class='name'>Profile</span></div><img src='pix/rarrow.svg' class='right rarrow' style='margin: -38px 10px 0px 0px; width: 14px; height: 14px;' /></div>
		</a>
		<a href='directory_photo?request=form&bro=<?php echo $bro ?>&source=profile' class='sidenav'>
			<div class='each-itemDiv content-nav'><div class='each-item'><span class='name'>Photo</span></div><img src='pix/rarrow.svg' class='right rarrow hidden' style='margin: -38px 10px 0px 0px; width: 14px; height: 14px;' /></div>
		</a>
	</div>
	
	<div class='lookupDiv overflow'>
	</div>

</div>

</div>
</body>
</html>