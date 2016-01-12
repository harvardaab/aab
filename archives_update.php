<?php

$archivefolder = "vault/files/archives/";
$folder_dir_arr = array("minutes","financial","general","constitution","songs");
$folder_name_arr = array("Minutes","Financial Reports","General References","Constitution Signatures","Class Songs");

for ($i=0; $i<5; $i++) {
$folder_name = "$folder_name_arr[$i]";
$folder_dir = "$folder_dir_arr[$i]";
$dir = "$archivefolder$folder_dir/";
	if (is_dir($dir)) {
		if ($openNotes = opendir($dir)) {
			while (($file = readdir($openNotes)) !== false) {
				if($file != "." && $file != ".."){
					${'doc_list'.$i}[] = $file;
					rsort(${'doc_list'.$i});
				}
			}
			
			if (strlen(${'doc_list'.$i})) {
				foreach (${'doc_list'.$i} as $fileid => $each_file) {
          			$urldecoded = urldecode($each_file);
          			list($txt,$ext) = explode(".", $urldecoded);
					list($docdate,$docname,$uploadingBro,$uploadingBroID,$doctime) = explode("~", $txt);
					$urlencoded = urlencode($docname);
					$newfile = "$docdate~$docname~$uploadingBro~$uploadingBroID~$doctime.$ext";
          			rename("$dir$each_file", "$dir$newfile");*/
          		}
          	}
		}
	}
}
?>