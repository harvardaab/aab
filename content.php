<?php

include "scripts/checkbro.php";

if (isset($_GET['n']) || isset($_GET['e']) || isset($_GET['a']) || isset($_GET['nl'])) {
	if (isset($_GET['edit'])) {
			$edit = "&edit";
	}
	
	if (isset($_GET['n'])) {
		$nid = mysql_real_escape_string($_GET['n']);
		$page = "news&n=$nid$edit";
	} elseif (isset($_GET['e'])) {
		$eid = mysql_real_escape_string($_GET['e']);
		$page = "events&e=$eid$edit";
	} elseif (isset($_GET['a'])) {
		$aid = mysql_real_escape_string($_GET['a']);
		$page = "albums&a=$aid$edit";
	} elseif (isset($_GET['nl'])) {
		$nlid = mysql_real_escape_string($_GET['nl']);
		$page = "newsletters&nl=$nlid$edit";
	}
	
} else {
	$page = "news";
}

$open = "<script>
			$(function(){
				$('div.lookupDiv').load('content_process?request=$page');
			});
			</script>";

mysql_close($mysql_connection);
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->


<head>
<title>Content - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>
<script>
$(function(){
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
<?php echo $open ?>
</head>

<body id="directory" class="pattern">

<?php include_once "sidebar.php" ?>

<div id='tabs' class='ui-tabs'>
	<div id='top-bar'>
		<ul class='tab left'>
		<li><a href="content_process?request=news" id='each-item' class='selected'>News</a></li>
		<li><a href="content_process?request=events" id='each-item'>Events</a></li>
		<li><a href="content_process?request=albums" id='each-item'>Gallery</a></li>
		<li><a href="content_process?request=newsletters" id='each-item'>Newsletter</a></li>
		</ul>
		
		<?php include_once "searchbar.php" ?>
	</div>
	
	<div id='news_list'>
		<div class='lookupDiv'></div>
	</div>
	
</div>

</body>
</html>