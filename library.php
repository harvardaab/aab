<?php
include "scripts/checkbro.php";

if (isset($_POST['file_edit'])) {
	
	$libfolder = "vault/files/thestacks/";
	
	$new_year = $_POST['year'];
	$new_filename = $_POST['file_edit'];
	$new_course_name = $_POST['course_name'];
	$new_course_num = $_POST['course_num'];
	$folder = $_POST['folder'];
	$orig_name = $_POST["orig_name"];
	/*$new_name = $_POST["full_file"];*/  // For editing full file names w/ extensions
	
	// Find file ext and orig upload datestamp from orig name
	list($txt,$ext) = explode(".", $orig_name);
	list($old_course_name,$old_course_num,$old_name,$old_year,$uploadingBro,$uploadingBroID,$docdate) = explode("~", $txt);
	
	
	// New name for file
	$new_name = "$new_course_name~$new_course_num~$new_filename~$new_year~$uploadingBro~$uploadingBroID~$docdate.$ext";
	
	$dir = "$libfolder$folder/";
	if (is_dir($dir)) {
		if ($openNotes = opendir($dir)) {
			while (($file = readdir($openNotes)) !== false) {
				if($file != "." && $file != ".."){
					${'doc_list'.$i}[] = $file;		// Array of all files in the specified directory
				}
			}
			
			if (${'doc_list'.$i} != "") {	// If the array is not empty
				if (in_array($orig_name, ${'doc_list'.$i})) {	// And the orig file is in the array
					rename("$dir$orig_name", "$dir$new_name"); // Rename the file
				}
			}
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
<title>Library - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>
<link href='http://fonts.googleapis.com/css?family=Puritan:400,700' rel='stylesheet' type='text/css'>
<script src="js/jquery.relatedselects.min.js" type="text/javascript"></script>
<script>
$(function(){
	$('#tabs').tabs();
	$('div.lookupDiv').load('library_process?request=gened');
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
<script>
$(function(){
	$("form#courses").relatedSelects({
		onChangeLoad: 'datasupplier.php',
		loadingMessage: 'Loading Courses...',
		selects: ['typeID', 'courseID']
	});
	$("input#sg_name").tooltip();
	$("input#sg_file").tooltip();
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
	<div id='tabs'>
		<div id='top-bar'>
		<ul class='tab left ui-tabs-nav'>
			<li class='ui-tabs-active'><a href='#stacks'>The Stacks</a></li>
			<li><a href='#newstack'>+ Add</a></li>
		</ul>
		<?php include_once "searchbar.php" ?>
		</div>
		
		<div class='inner_content'>
		<div id='stacks' style='padding:0;margin:0'>
			<div class='sidelist'>
				<a href='library_process?request=gened' id='each-item'>
				<div class='each-itemDiv content-nav selected'><div class='each-item'><span class='name'>Gen Ed</span></div><img src='pix/rarrow.svg' class='right rarrow' style='margin: -38px 10px 0px 0px; width: 14px; height: 14px;' /></div>
				</a>
				<a href='library_process?request=dept' id='each-item'>
				<div class='each-itemDiv content-nav'><div class='each-item'><span class='name'>Departments</span></div><img src='pix/rarrow.svg' class='right rarrow hidden' style='margin: -38px 10px 0px 0px; width: 14px; height: 14px;' /></div>
				</a>
				<a href='library_process?request=career' id='each-item'>
				<div class='each-itemDiv content-nav'><div class='each-item'><span class='name'>Career</span></div><img src='pix/rarrow.svg' class='right rarrow hidden' style='margin: -38px 10px 0px 0px; width: 14px; height: 14px;' /></div>
				</a>
			</div>
			<div class='lookupDiv'></div>
		</div>
		
		<div id='newstack'>
			<h1 class='bold'>Share your notes and study guides with AAB's growing collection. <font style="color:red">All fields are mandatory.</font></h1>
			
			<table cellpadding='0' cellspacing='0' class='upload'>
				<tr><td width='300'><label>1. What course is the guide for?:</label></td>
				<td>
				<form action="library_process" method="post" enctype="multipart/form-data" id="courses">
				<select name="typeID" class="edit">
					<option value="">Search for...</option>
					<option value="DE">Departments</option>
					<option value="GE">General Education</option>
					<option value="CA">Career</option>
				</select>
				<select name="courseID" class="edit"></select>
				<input type="text" name="course_num" class="edit" placeholder="Course Number" style="width:120px;"/>
				</td></tr>
				<tr><td><label>2. When was the course?</label></td>
				<td><input type="text" name="year" class="edit" placeholder="Year" style="width:70px;"/></td></tr>
				<tr><td><label>3. What should we call it?</label></td>
				<td><input type="text" name="sg_name" class="edit" id='sg_name' placeholder="e.g. Midterm 2 Review, ID list, PSet 3" style="width:370px;" title='Do not use "+" or "/" or "." in the guide name.'/></td></tr>
				<input type="hidden" name="uploadingBro" value="<?php echo $bro ?>" />
				<tr><td><label>4. Attach that file!</label></td>
				<td><input type="file" name="notesFile" class='edit' id='sg_file' style='width:200' title='Make sure there is no "." in the guide name.'/></td></tr>
				<tr><td><input type="submit" class="submit" value="Upload" style="width:200"/></td></tr>
			</form>
			</table>
		</div>
	</div>

</body>
</html>