<?php
include "scripts/checkbro.php";


/*================== NEW DOC POST ACTION ==================*/
$archivefolder = "vault/files/archives/";
if (isset($_POST['uploadingBro'])){

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

	$uploadingBro = $_CLEAN["uploadingBro"];
	$doctype = $_CLEAN["doctype"];
	$docname = $_POST["docname"];
	$docdate = $_POST["docdate"];
	$doctime = date("YmdHis");
	
	if (strlen($docdate)){ 
		$docdate = $docdate;
	} else {
		$docdate = date("Y-m-d");
	}
	$docdate = date("Y-m-d", strtotime($docdate));
	$name = $_FILES['docFile']['name'];
	
	if (strlen($name)) {
		list($txt, $ext) = explode(".", $name);
		
			$folder = "$doctype/";
			$file_name = "$docdate~$docname~$FirstName $LastName~$uploadingBro~$doctime";
			$newname = "$file_name.$ext";
			move_uploaded_file( $_FILES['docFile']['tmp_name'], "$archivefolder$folder$newname");
			chmod("$archivefolder$folder$newname", 0755);
			header("location: archives");
	}
}

/*================== DOC REQUESTS ==================*/

if (isset($_GET['request'])){

$request = $_GET['request'];

if ($request == "minutes") {$i = 0;} elseif ($request == "financial") {$i = 1;} elseif ($request == "general") {$i = 2;} elseif ($request == "constitution") {$i = 3;} elseif ($request == "songs") {$i = 4;}
$folder_name = array("Minutes","Financial Reports","General References","Constitution Signatures","Class Songs");
$folder_name1 = "$folder_name[$i]";
$dir = "$archivefolder$request/";
	if (is_dir($dir)) {
		if ($openNotes = opendir($dir)) {
			while (($file = readdir($openNotes)) !== false) {
				if($file != "." && $file != ".."){
					${'doc_list'.$i}[] = $file;
					rsort(${'doc_list'.$i});
				}
			}
			
			if (strlen(${'doc_list'.$i})) {
				
				function getBro($uploadingBroID)
				{
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
			
								if ("$bro" == "$uploadingBroID") {
									$selected = " selected";
								} else {
									$selected = "";
								}
							
								${'brothers'.$year} .= "<option value='$bro'$selected>$fname $lname</option>";
							
							}
			
							${'class'.$year} = "<optgroup label='Class of $year'>${'brothers'.$year}</optgroup>";
							$allclasses .= "${'class'.$year}";
						}
					}
					return "<select name='author' style='width:100px;'><option>Select Brother</option>$allclasses</select>";
				}
			
				foreach (${'doc_list'.$i} as $fileid => $each_file) {
					$htmlescp = htmlspecialchars($each_file);
					$urldecoded = urldecode($each_file);
					list($txt,$ext) = explode(".", $urldecoded);
					list($docdate,$docname,$uploadingBro,$uploadingBroID,$doctime) = explode("~", $txt);
					$getbro = getBro($uploadingBroID);
					${'archives_files'.$i} .= "<tr>
         				<td>$docdate</td>
         				<td><a href=\"$dir$htmlescp\">$docname</a></td>
         				<td><a href='directory?bro=$uploadingBroID'>$uploadingBro</a></td>
         				<td><a href='#' id='rename'>Edit</a>
         				</td>
          				</tr>
          				
          				<tr class='hidden form'>
          				<form method='post' action='archives'>
          				<td><input type='date' name='date' placeholder='Date' class='edit' style='width:100px' value='$docdate' /></td>
						<td><input type='text' name='file_edit' placeholder='Name' class='edit' style='width:500px' value='$docname'  id='docname' title='Do not use \"~\" or \"/\" or \".\" in the document name.' /><br>
							<!--<input type='text' name='full_file' value='$each_file' placeholder='Full File Name' class='edit' style='width:500px' />-->
							<input type='hidden' name='folder' value='$request' />
							<input type='hidden' name='orig_name' value='$each_file' />
						</td>
						<td>$getbro</td><td><input type='submit' value='Save' /></td>
						</form>
						</tr>";
          		}
          	
          	${'archives'.$folder_dir} = "<div class='lookupContent'>
          			<span class='bold'>These documents contain our history.</span>
					<table cellspacing='0' cellpadding='0' width='100%' id='roster'>
					<thead>
						<tr bgcolor='#eee'>
						<td width='80px'>Date</td>
						<td width='600px'>Document</td>
						<td width='130px'>Author</td>
        				<td></td>
        				</tr>
					</thead>
					<tbody>
						${'archives_files'.$i}
					</tbody>
					</table>
<script>
$(function(){
	$('input#docname').tooltip();
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
</script>
					</div>";
					
			} else {
				${'archives'.$folder_dir} = "<div class='lookupContent'>
				<p>There are no $folder_name1 right now!</p></div>";
			}
			echo ${'archives'.$folder_dir};
		}
	}
}


?>