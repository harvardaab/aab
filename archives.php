<?php
include "scripts/checkbro.php";

if (isset($_POST['file_edit'])) {
	
	$archivefolder = "vault/files/archives/";
	
	$date = $_POST['date'];
	$new_filename = $_POST['file_edit'];
	$author = $_POST['author'];
	$folder = $_POST['folder'];
	$orig_name = $_POST["orig_name"];
	/*$new_name = $_POST["full_file"];*/  // For editing full file names w/ extensions
	
	// Find file ext and orig upload datestamp from orig name
	list($txt,$ext) = explode(".", $orig_name);
	list($docdate,$docname,$uploadingBro,$uploadingBroID,$doctime) = explode("~", $txt);
	
	// Correct date format
	$date_format = date("Y-m-d", strtotime($date));
	
	// Looking up author's name from bro id
	$author_sql = mysql_query("SELECT * FROM brothers WHERE bro='$author' LIMIT 1") or die(mysql_error());
	$author_count = mysql_num_rows($author_sql);
	if ($author_count > 0) {
		while ($a = mysql_fetch_array($author_sql)) {
			$fname = $a['FirstName'];
			$lname = $a['LastName'];
		}
	}
	
	// New name for file
	$new_name = "$date_format~$new_filename~$fname $lname~$author~$doctime.$ext";
	
	$dir = "$archivefolder$folder/";
	if (is_dir($dir)) {
		if ($openNotes = opendir($dir)) {
			while (($file = readdir($openNotes)) !== false) {
				if($file != "." && $file != ".."){
					${'doc_list'.$i}[] = $file;		// Array of all files in the specified directory
				}
			}
			
			if (strlen(${'doc_list'.$i})) {	// If the array is not empty
				if (in_array($orig_name, ${'doc_list'.$i})) {	// And the orig file is in the array
					rename("$dir$orig_name", "$dir$new_name"); // Rename the file
				}
			}
		}
	}
}

?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">


<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->


<head>
<title>Archives - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>
	<link rel="stylesheet" type="text/css" href="css/jackedup.css"/>
<link href='http://fonts.googleapis.com/css?family=Puritan:400,700' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="js/humane.js"></script>
	<script src="js/jquery.relatedselects.min.js" type="text/javascript"></script>
<script>
$(function(){
	$('#tabs').tabs();
	$("input#docname").tooltip();
	$("input#docfile").tooltip();
	$('div.lookupDiv').load('archives_process?request=minutes');
	$('a#each-item').click(function(){
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
.ui-tooltip {
        padding: 10px 20px;
        color: white;
        box-shadow: 0 0 7px black;
        font-size: 14px;
    }
a#rename {opacity:0.1}
</style>
</head>

<body id="library" class="pattern">
<?php include_once "sidebar.php" ?>
	<div id='tabs' class='ui-tabs'>
		<div id='top-bar'>
		<ul class='tab left ui-tabs-nav'>
			<li class='ui-tabs-active'><a href='#archive'>Archives</a></li>
			<li><a href='#newarchive'>+ Add</a></li>
		</ul>
		<?php include_once "searchbar.php" ?>
		</div>
		
		<div class='inner_content'>
		<div id='archive' style='padding:0px;'>
			<div class='sidelist'>
				<a href='archives_process?request=minutes' id='each-item'>
				<div class='each-itemDiv content-nav selected'><div class='each-item'><span class='name'>Minutes</span></div><img src='pix/rarrow.svg' class='right rarrow' style='margin: -38px 10px 0px 0px; width: 14px; height: 14px;' /></div>
				</a>
				<a href='archives_process?request=financial' id='each-item'>
				<div class='each-itemDiv content-nav'><div class='each-item'><span class='name'>Financial Reports</span></div><img src='pix/rarrow.svg' class='right rarrow hidden' style='margin: -38px 10px 0px 0px; width: 14px; height: 14px;' /></div>
				</a>
				<a href='archives_process?request=general' id='each-item'>
				<div class='each-itemDiv content-nav'><div class='each-item'><span class='name'>General Reference</span></div><img src='pix/rarrow.svg' class='right rarrow hidden' style='margin: -38px 10px 0px 0px; width: 14px; height: 14px;' /></div>
				</a>
				<a href='archives_process?request=constitution' id='each-item'>
				<div class='each-itemDiv content-nav'><div class='each-item'><span class='name'>Constitution Signatures</span></div><img src='pix/rarrow.svg' class='right rarrow hidden' style='margin: -38px 10px 0px 0px; width: 14px; height: 14px;' /></div>
				</a>
				<a href='archives_process?request=songs' id='each-item'>
				<div class='each-itemDiv content-nav'><div class='each-item'><span class='name'>Class Songs</span></div><img src='pix/rarrow.svg' class='right rarrow hidden' style='margin: -38px 10px 0px 0px; width: 14px; height: 14px;' /></div>
				</a>
			</div>
			<div class='lookupDiv'></div>
		</div>
		<div id='newarchive'>
			<h1 class='bold'>Add a record to AAB's history. <font style="color:red">All fields are mandatory.</font></h1>
			
			<table cellpadding='0' cellspacing='0' class='upload'>
			<form action="archives_process" method="post" enctype="multipart/form-data" id="DocsForm">
				<tr><td width='300'><label>1. Choose a document type:</label></td>
				<td><select name="doctype" class='edit' style='width:200'>
					<option value="">Select...</option>
					<option value="general">General Reference</option>
					<option value="constitution">Signed Constitution</option>
					<option value="financial">Financial Report</option>
					<option value="minutes">Meeting Minutes</option>
					<option value="songs">Class Song</option>
				</select></td></tr>
				<tr><td><label>2. When was it published?</label></td>
				<td><input type="date" name="docdate" class='edit' placeholder="Month/Day/Year" id='datepicker' style="width:200px;"/></td></tr>
				<tr><td><label>3. What should we call it?</label></td>
				<td><input type="text" name="docname" class='edit' placeholder="e.g. Budget Fall 2010, Recruiting Schedule, Class of 2012 Song" style="width:420px;" id='docname' title='Do not use "~" or "/" or "." in the document name.' /></td></tr>
				<input type="hidden" name="uploadingBro" value="<?php echo $bro ?>" />
				<tr><td><label>4. Attach that file!</label></td>
				<td><input type="file" name="docFile" class='edit' style='width:200' id='docfile' title='Make sure there is no "." in the document name.' /></td></tr>
				<tr><td colspan='2'><button type="submit" class="submit" id='SaveDoc' style="width:200">Upload</button></td></tr>
			</form>
			</table>
		</div>
		</div>
	</div>
</body>
</html>