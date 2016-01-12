<?php

include "scripts/checkbro.php";

/*------------- Privacy Settings ---------------*/
if (isset($_POST["NewBro"])) {
	$FirstName = $_POST['FirstName'];
	$LastName = $_POST['LastName'];
	$Class = $_POST['Class'];
	$RecruitClass = $_POST['RecruitClass'];
	$Email = $_POST['Email'];
	$CallName = $_POST['CallName'];
	$CallNameStory = $_POST['CallNameStory'];
	
	$pw_lower = strtolower($CallName);
    $pw_sql = str_replace("-", "", $pw_lower);
    $pw_sql = str_replace(" ", "", $pw_sql);
    
    $update_sql = mysql_query("INSERT INTO brothers (FirstName, LastName, Class, Email, CallName, Password)
    	VALUES ('$FirstName','$LastName','$Class','$Email','$CallName','$pw_sql')");
}

if (isset($_GET["PrefsBro"])){
	$PrefsBro = $_GET["PrefsBro"];
	$Privacy = $_GET["Privacy"];
	
	if ($Privacy == "yes") {
		$Privacy_sql = "1";
	} else { $Privacy_sql = "0"; }
	
	$update_sql = mysql_query("UPDATE brothers SET Privacy='$Privacy_sql' WHERE bro='$PrefsBro'");
}

$prefs_sql = mysql_query("SELECT * FROM brothers WHERE bro='$bro' LIMIT 1");
$prefs_count = mysql_num_rows($prefs_sql);
if ($prefs_count > 0) {
	while ($p = mysql_fetch_array($prefs_sql)) {
		$Privacy = $p['Privacy'];
		
		if ($Privacy == 1) {
			$checkbox = "<input type='checkbox' name='Privacy' id='PrivacyCheck' value='yes' checked />";
		} else {
			$checkbox = "<input type='checkbox' name='Privacy' id='PrivacyCheck' value='yes' />";
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
<title>Preferences - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>
<link rel="stylesheet" type="text/css" href="css/checkbox.css"/>
<script type="text/javascript" src="js/iphone-style-checkboxes.js"></script>
<script>
$(function(){
	$("#tabs").tabs();
	$(':checkbox').iphoneStyle();
});
$(function(){
	$('.iPhoneCheckContainer').click(function(){
		$.ajax({
    		type: 'GET',
    		url: 'prefs.php',
    		data: $('#PrefsForm').serialize(),
    		success: function() {
        		$('span#result').html('Saved!');
        		setTimeout(function() { $('span#result').empty() }, 2000);
    		}
     	 });
	});
});
</script>
<style>
div#newbro input {width: 150;}
div.padded {padding:20px;}
</style>
</head>

<body id="prefs">

<?php include_once "sidebar.php" ?>
	
<div class="main-wrap">

	<div id='top-bar'>
		<ul class='top-heading'><li><span>Preferences</span></li></ul>
		<?php include_once "searchbar.php" ?>
	</div>

	<div class="inner_content">
		
		<div class='padded'>
		<form id='PrefsForm' class='left'>
			<label for='PrivacyCheck' style='font-size: 15px'>Private Profile</label><?php echo $checkbox ?>
			<input type='hidden' name='PrefsBro' value='<?php echo $bro ?>' />
			<br><span id='result'></span>
		</form>
		<a href='huid' class='right'>CC Numbers</a>
		
		<hr id='survey'>
		
		<span class='bold'>Add a New Brother</span>
		<form method='post' action='prefs'>
			<input type='text' name='FirstName' class='edit' placeholder='First Name' /><br>
			<input type='text' name='LastName' class='edit' placeholder='Last Name' /><br>
			<input type='text' name='Class' class='edit' placeholder='Graduating Class' style='width: 100px'/><br>
			<input type='text' name='RecruitClass' class='edit' placeholder='Recruiting Class' style='width: 100px'/><br>
			<input type='text' name='Email' class='edit' placeholder='@college Email'/><br>
			<input type='text' name='CallName' class='edit' placeholder='Call Name' /><br>
			<textarea name='CallNameStory' class='edit' placeholder='When he stepped up to the steps at the Kong...' style='width: 300px; height: 150px'></textarea><br>
			<input type='submit' name='NewBro' value='Add' class='submit' />
		</form>
		</div>

	</div>

</div>

</body>
</html>