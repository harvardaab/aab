<?php
include "scripts/checkbro.php";

/*================== NEW GUIDE POST ACTION ==================*/
$libfolder = "vault/files/thestacks/";
if (isset($_POST['uploadingBro'])){

	$type = $_POST["typeID"];
	$course = $_POST["courseID"];
	$courseNum = $_POST["course_num"];
	$year = $_POST["year"];
	$sgName = $_POST["sg_name"];
	$uploadingBro = $_POST["uploadingBro"];
	$name = $_FILES['notesFile']['name'];
	
	if (strlen($name)) {
		list($txt, $ext) = explode(".", $name);
		if ($type == "DE") {
			$folder = "dept/";
		} elseif ($type == "GE") {
			$folder = "gened/";
		} elseif ($type == "CA") {
			$folder = "career/";
		} elseif (!$type || !$course) {
			$folder = "dept/";
			$course = "Unknown_Dept";
		}
	}
	
	$docdate = date("YmdHis");
	$file_name = "$course~$courseNum~$sgName~$year~$FirstName $LastName~$uploadingBro~$docdate";
	$newname = "$file_name.$ext";
	move_uploaded_file( $_FILES['notesFile']['tmp_name'], "$libfolder$folder$newname");
	chmod("$libfolder$folder$newname", 0755);
	header("location: library");
}

/*================== GUIDE REQUESTS ==================*/

if (isset($_GET['request'])){
$request = $_GET['request'];

$folder_name = array("Gen Ed", "Other", "Career");

if ($request == "gened") {$i = 0;} elseif ($request == "dept") {$i = 1;} elseif ($request == "career") {$i = 2;}
	$folder_name1 = "$folder_name[$i]";
	$dir = "$libfolder$request/";
	if (is_dir($dir)) {
		if ($openNotes = opendir($dir)) {
			while (($file = readdir($openNotes)) !== false) {
				if($file != "." && $file != ".."){
					${'course_list'.$i}[] = $file;
					sort(${'course_list'.$i});
				}
			}
			
			if (${'course_list'.$i} != "") {
			foreach (${'course_list'.$i} as $each_file) {
				list($txt,$ext) = explode(".", $each_file);
				list($course_name,$course_num,$sg_name,$year,$uploadingBro,$uploadingBroID,$docdate) = explode("~", $txt);
				$course = "$course_name $course_num";
			
			
			// Directed Course Search for later implementation -- doesn't work if pulled up asynchronously with jquery
			/*<select name='typeID' class='edit' style='width:100px'>
								<option value=''>Search for...</option>
								<option value='DE'>Depts</option>
								<option value='GE'>GenEd</option>
								<option value='CA'>Career</option>
							</select><br>
							<select name='courseID' class='edit' style='width:100px'></select>*/
							
			
			${'list_files'.$i} .= "<tr>
         				<td>$course</td>
         				<td>$year</td>
         				<td><a href=\"$dir$each_file\">$sg_name</a></td>
         				<td><a href='directory?bro=$uploadingBroID'>$uploadingBro</a></td>
         				<td><a href='#' id='rename'>Edit</a></td>
          				</tr>
          				
          				<tr class='hidden form'>
          				<form method='post' action='library' id='edit_file'>
          				<td><input type='text' name='course_name' placeholder='Course Name' class='edit' style='width:100px' value='$course_name' /><br>
							<input type='text' name='course_num' placeholder='Course Number' class='edit' style='width: 100px' value='$course_num' /></td>
          				<td><input type='text' name='year' placeholder='Year' class='edit' style='width:50px' value='$year' /></td>
						<td><input type='text' name='file_edit' placeholder='Name' class='edit' style='width:400px' value='$sg_name' id='sg_name' title='Do not use \"~\" or \"/\" or \".\" in the document name.'  /><br>
							<!--<input type='text' name='full_file' value='$each_file' placeholder='Full File Name' class='edit' style='width:500px' />-->
							<input type='hidden' name='folder' value='$request' />
							<input type='hidden' name='orig_name' value='$each_file' />
						</td>
						<td>$getbro</td><td><input type='submit' value='Save' /></td>
						</form>
						</tr>";
          	
          	${'list'.$folder_dir} = "<div class='lookupContent'>
					<table cellspacing='0' cellpadding='0' width='100%' id='roster' style='padding-bottom:30px'>
					<thead>
						<tr bgcolor='#eee'>
						<td width='100px'>Course</td>
						<td width='80px'>Year</td>
						<td width='500px'>Study Guide</td>
						<td width='100px'>Contributor</td>
						<td></td>
        				</tr>
					</thead>
					<tbody>
						${'list_files'.$i}
					</tbody>
					</table>
					<span class='bold'>If you can't find what you're looking for, try <a href='http://www.mk2review.com'>MK2Review</a> or <a href='http://www.finalsclub.org'>FinalsClub</a>.</span>
					</div>
					<script>
$(function(){
	$('form#edit_file').relatedSelects({
		onChangeLoad: 'datasupplier.php',
		loadingMessage: 'Loading Courses...',
		selects: ['typeID', 'courseID']
	});
	$('input#sg_name').tooltip();
	$('table#roster tr').hover(function(){
		$(this).find('a#rename').fadeTo('fast', 1.0);
		}, function(){
		$(this).find('a#rename').fadeTo('fast', 0.1)
	});
	$('a#rename').click(function(){
		var row = $(this).parent().parent();
		$(row).empty();
		$(row).next().toggle();
		return false;
	});
});
</script>";
			}
			} else {
				${'list'.$folder_dir} = "<div class='lookupContent'>
				<p>There are no $folder_name1 guides right now!</p></div>";
			}
			echo ${'list'.$folder_dir};
		}
	}
}
?>