<?php
include "scripts/checkbro.php";

mysql_close($mysql_connection);
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">


<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->


<head>
<title>Calendar - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>
	<link rel="stylesheet" type="text/css" href="css/jackedup.css"/>
<link href='http://fonts.googleapis.com/css?family=Puritan:400,700' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="js/humane.js"></script>
	<script src="js/jquery.relatedselects.min.js" type="text/javascript"></script>
<script>
$(function(){
	$('div.lookupDiv').load('calendar_process?request=calendar');
	$('a#each-item').click(function(){
		var thisurl = $(this).attr('href');
		$('div.lookupDiv').load(thisurl);
		
		$(this).addClass("selected");
		$(this).parent().siblings().find('a#each-item').removeClass("selected");
		
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
</head>

<body id="library" class="pattern">
<?php include_once "sidebar.php" ?>

<div class="main-wrap">

	<div id='tabs'>
	
		<div id='top-bar'>
		<ul class='tab left'>
			<li><a href='calendar_process?request=calendar' id='each-item' class='selected'>Calendar</a></li>
			<li><a href='calendar_process?request=bdays&month=current' id='each-item'>Birthdays</a></li>
			
		</ul>
		<?php include_once "searchbar.php" ?>
		</div>
		
		<div class='inner_content'>
			<div class='lookupDiv'></div>
		</div>
	</div>

</div>
</body>
</html>