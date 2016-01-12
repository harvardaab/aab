<?php

if (isset($_GET['request'])){
	$request = $_GET['request'];

if ($request == "enlarge") {
	$bro = $_GET['bro'];
	
	$profpic = "vault/photos/profpic/$bro.jpg";
	$default = "vault/photos/profpic/default.jpg";
	if (file_exists($profpic)) {
		$largepic = "<img src='$profpic' style='max-width:600' />";
	} else {
		$largepic = "<img src='$default' />";
	}
	
	$large = "<div class='lookupContent'>
		<table cellspacing='0' cellpadding='0' class='profile'><tr><td width='70px' valign='top'>
		<div><a href='directory_process?bro=$bro' id='data'><img src='pix/icons/directory.png' id='proflink' title='Back to Profile!' style='width:50;height:50' /></a></div>
		</td>
		<td>
		<div class='profile'>$largepic</div>
		</td>
		</table>
		</div>
		<script>
		$(function(){
			$('a#data').click(function(){
				$('div.lookupDiv').empty();
				$('div.lookupDiv').load('directory_process?bro=$bro&echo=yes');
				
				return false;
			});
			$('img#proflink[title]').tooltip();
		});
		</script>";

	echo $large;
}

if ($request == "form") {
	$bro = $_GET['bro'];
	$source = $_GET['source'];
	
	$profpic = "vault/photos/profpic/$bro.jpg";
	$default = "vault/photos/profpic/default.jpg";
	if (file_exists($profpic)) {
		$largepic = "<img src='$profpic' class='thumb preview' />";
	} else {
		$largepic = "<img src='$default' class='thumb preview' />";
	}
	
	$form = "<div class='lookupContent'>
		<table cellpadding='0' cellspacing='0'><tr><td width='270px'>$largepic</td>
		<td valign='top'><span class='title'>Add a New Profile Photo!</span>
			<form id='PhotoForm' class='NiceForm' method='post' action='directory_photo' enctype='multipart/form-data'>
			<input type='hidden' name='profpicbro' value='$bro' />
			<input type='hidden' name='source' value='$source' />
			<input type='file' name='profpic' style='margin: 30 0'/><br>
			<input type='submit' value='Submit' id='SaveNews' class='submit' />
			</form></td></tr></table>
		</div>";
	
	echo $form;
}

}

if(isset($_POST['profpicbro'])){
	$bro = $_POST['profpicbro'];
	$source = $_POST['source'];
	$path = "vault/photos/profpic/";
	
	if ($_FILES['profpic']['tmp_name'] != "") {
		move_uploaded_file($_FILES['profpic']['tmp_name'], "$path$bro.jpg");
		chmod("$path$bro.jpg", 0755);
	}
	
	header("location: directory?bro=$bro");
	
}
?>