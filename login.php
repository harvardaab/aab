<?php include "scripts/checkbro.php";

// If logged in, can't see this page
if (isset($_SESSION["bro"])) {
	header("location: .");
}

$thisYear = date('Y') + 3;
$startYear = 2001;

foreach (range($thisYear, $startYear) as $year) {
	$b_sql = mysql_query("SELECT * FROM brothers WHERE Class='$year' ORDER BY LastName") or die (mysql_error());
	$b_count = mysql_num_rows($b_sql);
	if ($b_count > 0) {
		while ($b = mysql_fetch_array($b_sql)) {
			$bro = $b['bro'];
			$fname = $b['FirstName'];
			$lname = $b['LastName'];
			${'brothers'.$year} .= "<option value='$bro'>$fname $lname</option>";
		}
		${'class'.$year} = "<optgroup label='Class of $year'>${'brothers'.$year}</optgroup>";
		$brotherlist .= ${'class'.$year};
	}
}

mysql_close($mysql_connection);

?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"


<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->


<head>
<title>Members Access - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>
<script>
$(function(){
	$('#loginbutton').click(function() {
		var formdata = $('#login-form').serialize();
		$.ajax({
			type: 'GET',
			url: 'login_process.php',
			data: formdata,
			success: function(data){
				$('#status').html(data);
				$('#status').fadeIn(400);
				$('#status').delay(1000).fadeOut(400);
				
				if (data == "<font id='success'>Welcome.</font>") {
					var url = "http://harvardaab.com/directory";
					$(location).delay(4000).attr('href',url);
				}
			}
		});
		return false;
	});
	return false;
});
$(function(){
	$('input#password').focus(function(){
		$('div#pwhint').toggle().delay(3000).fadeOut(1000);
	});
});
</script>
</head>

<body id="home" class="pattern-login">
<div class='login-box'>
		<a href="."><img src="pix/logo.png" style="height:80; width:100; margin: 30 100;"/></a>
		<form id="login-form">
		<select class='loginselect' name='bro'>
			<option value=''>Select Brother</option>
			<?php echo $brotherlist; ?>
		</select>
		<br>
		<input type="password" name="password" id='password' class="loginform" placeholder="password" title='"As of now, you have no identity within the brotherhood."'/><br/>
		<input type='checkbox' name='remember' value='yes' checked='checked' class='hidden' />
		<input type='submit' value='' id='loginbutton' />
		<span id='status'></span>
		</form>
</div>

<div id='pwhint' class='hidden'>As of now, you have no identity within the brotherhood.<br>All lowercase, no spaces or hyphens.</div>

</body>
</html>