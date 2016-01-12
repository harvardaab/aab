<?php

include "scripts/checkbro.php";

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
					return "<select name='author' class='txtselect' id='author' style='width:250px;'><option>Select Brother</option>$allclasses</select>";
				}

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
?>
<?php
/*========= NEW FORM HANDLERS ===========*/

/*------------- News ---------------*/
if (isset($_POST['news_authorID'])) {
	$news_authorID = $_CLEAN['news_authorID'];
	$news_title = $_CLEAN['news_title'];
	$news_content = $_CLEAN['news_content'];
	
	$update_sql = mysql_query("INSERT INTO news (title, content, author, datestamp) VALUES ('$news_title','$news_content','$news_authorID',now())") or die (mysql_error());
	header("location: content");
}

/*------------- Event ---------------*/
$path = "vault/photos/events/";
$valid_formats = array("jpg", "png", "jpeg");
$file_upload = "event_photo";

if (isset($_POST['event_authorID'])) {
	$event_author = $_CLEAN['event_authorID'];
	$event_name = $_CLEAN['event_name'];
	$event_date = $_CLEAN['event_date'];
	$event_timeS = $_CLEAN['event_timeS'];
	$event_timeE = $_CLEAN['event_timeE'];
	$event_loc = $_CLEAN['event_loc'];
	$event_desc = $_CLEAN['event_desc'];
	
	if ($event_date != "") {
		$event_date = date("Y-m-d", strtotime($event_date));
    } else { $event_date = ""; }
    
	$update_sql = mysql_query("INSERT INTO events (Name, Date, TimeStart, TimeEnd, Location, Description,  Author)
		VALUES ('$event_name','$event_date','$event_timeS','$event_timeE','$event_loc','$event_desc','$event_author')") or die (mysql_error());
		
	$e_newID = mysql_insert_id();
	
	$name = $_FILES['$file_upload']['name'];
	
	/*$size = $_FILES['$file_upload']['size'];
	
	if(strlen($name)){
		list($txt, $ext) = explode(".", $name);
		if(in_array($ext,$valid_formats)){
			if($size<(1024*1024)) { // Max File Size: 1MB
				$actual_image_name = "$path$e_newID.png";
				$tmp = $_FILES['$file_upload']['tmp_name'];
				if(move_uploaded_file($tmp, $path.$actual_image_name)){
					chmod("$path$e_newID.png", 0755);
				} else echo "failed";
			} else echo "Image file size max 2 MB";
		} else echo "Invalid file format..";
	} else echo "Please select image..!";*/
	
	if ($_FILES['event_photo']['tmp_name'] != "") {
		move_uploaded_file($_FILES['event_photo']['tmp_name'], "$path$e_newID.png");
		chmod("$path$e_newID.png", 0755);
	}
	header("location: content");
}

/*------------- Album ---------------*/
$path = "vault/photos/albums/";
if (isset($_POST["album_authorID"])) {
	$album_author = $_CLEAN['album_authorID'];
	$album_name = $_CLEAN['album_name'];
	$album_desc = $_CLEAN['album_desc'];
	$album_date = $_CLEAN['album_date'];
	$album_priv = $_CLEAN['album_priv'];
	$album_html = $_CLEAN['album_html'];
	
	$album_date = date("Y-m-d", strtotime($album_date));
	
	if ($album_priv == "yes") {
		$album_priv = 1;
		} else { $album_priv = 0; }
	
	$addalbum_sql = mysql_query("INSERT INTO albums (Name, Description, Date, Author, Album, Private)
		VALUES ('$album_name','$album_desc','$album_date','$album_author','$album_html','$album_priv')") or die (mysql_error());
	
	header("location: content");
}
	
/*------------- Newsletter ---------------*/
if (isset($_POST['newsletter_authorID'])) {
	$newsletter_authorID = $_CLEAN['newsletter_authorID'];
	$newsletter_title = $_CLEAN['newsletter_title'];
	$newsletter_date = $_CLEAN['newsletter_date'];
	$newsletter_html = $_CLEAN['newsletter_html'];
	$newsletter_date = date("Y-m-d", strtotime($newsletter_date));
	
	$update_sql = mysql_query("INSERT INTO newsletter (title, html, author, date) VALUES ('$newsletter_title','$newsletter_html','$newsletter_authorID','$newsletter_date')") or die (mysql_error());
	
	header("location: content");
}

?>
<?php
/*========= EDIT FORM HANDLERS ===========*/

if (isset($_POST['edit_type'])) {
	$edit_type = $_POST['edit_type'];
	$edit_id = $_POST['edit_id'];
	
	/*------------- News ---------------*/
	if ($edit_type == "news") {
		$author = $_CLEAN['author'];
		$title = $_CLEAN['edit_news_title'];
		$content = $_CLEAN['edit_news_content'];
		
		$update_sql = mysql_query("UPDATE news SET title='$title', content='$content', author='$author' WHERE id='$edit_id'") or die (mysql_error());
		header("location: content");
		
	/*------------- Event ---------------*/
	} elseif ($edit_type == "event") {
		
		$path = "vault/photos/events/";
		$valid_formats = array("jpg", "png", "jpeg");
		
		$event_author = $_CLEAN['author'];
		$event_name = $_CLEAN['event_name'];
		$event_date = $_CLEAN['event_date'];
		$event_timeS = $_CLEAN['event_timeS'];
		$event_timeE = $_CLEAN['event_timeE'];
		$event_loc = $_CLEAN['event_loc'];
		$event_desc = $_CLEAN['event_desc'];
		
		if ($event_date != "") {
			$event_date = date("Y-m-d", strtotime($event_date));
    	} else { $event_date = ""; }
    	
    	$pic = $_FILES['event_photo']['name'];
    	
    	if ($_FILES['event_photo']['tmp_name'] != "") {
			move_uploaded_file($_FILES['event_photo']['tmp_name'], "$path$edit_id.png");
			chmod("$path$edit_id.png", 0755);
		}
    	
    	$update_sql = mysql_query("UPDATE events SET Name='$event_name', Date='$event_date', TimeStart='$event_timeS', TimeEnd='$event_timeE', Location='$event_loc', Description='$event_desc', Author='$event_author' WHERE id='$edit_id'") or die (mysql_error());
		
		if ($update_sql){
			echo $pic, $edit_id, $event_name, $event_author, $event_date, $event_loc;
		}
		header("location: content");
	
	/*------------- Album ---------------*/
	} elseif ($edit_type == "album") {
		
		$path = "vault/photos/albums/";
		$album_author = $_CLEAN['author'];
		$album_name = $_CLEAN['album_name'];
		$album_desc = $_CLEAN['album_desc'];
		$album_date = $_CLEAN['album_date'];
		$album_priv = $_CLEAN['album_priv'];
		$album_html = $_CLEAN['album_html'];
	
		$album_date = date("Y-m-d", strtotime($album_date));
	
			if ($album_priv == "yes") {
				$album_priv = 1;
			} else { $album_priv = 0; }
	
		$addalbum_sql = mysql_query("UPDATE albums SET Name='$album_name', Description='$album_desc', Date='$album_date', Author='$album_author', Album='$album_html', Private='$album_priv' WHERE id='$edit_id'") or die (mysql_error());
	
		header("location: content");
		
	/*------------- Newsletter ---------------*/
	} elseif ($edit_type == "newsletter") {
	
		$newsletter_authorID = $_CLEAN['author'];
		$newsletter_title = $_CLEAN['newsletter_title'];
		$newsletter_date = $_CLEAN['newsletter_date'];
		$newsletter_html = $_CLEAN['newsletter_html'];
		$newsletter_date = date("Y-m-d", strtotime($newsletter_date));
	
		$update_sql = mysql_query("UPDATE newsletter SET title='$newsletter_title', html='$newsletter_html', author='$newsletter_authorID', date='$newsletter_date' WHERE id='$edit_id'") or die (mysql_error());
	
		header("location: content");
	}
}
?>
<?php
/*=================== HTML REQUESTS ===================*/



/*------------- Displaying Old News ---------------*/
if (isset($_GET["request"])) {

if ($_GET["request"] == "news"){
	if (isset($_GET['n'])){
		$nid = $_GET['n'];
		$sql = "SELECT * FROM news WHERE id='$nid' LIMIT 1";
	} else {
		$sql = "SELECT * FROM news ORDER BY datestamp DESC";
	}
	$news_sql = mysql_query("$sql") or die(mysql_error());
	$news_count = mysql_num_rows($news_sql);
	if ($news_count > 0) {
		while ($n = mysql_fetch_array($news_sql)) {
			$nid = $n['id'];
			$title = $n['title'];
			$content = $n['content'];
			$authorID = $n['author'];
			$datestamp = $n['datestamp'];
			$content_html = nl2br($content);
			
			list($news_date, $news_time) = explode(" ", $datestamp);
			$date_name = date("F j, Y", strtotime($news_date));
			$date = "$date_name";
			
			if ($authorID != "") {
				$author_sql = mysql_query("SELECT FirstName, LastName FROM brothers WHERE bro = '$authorID' LIMIT 1");
				$author_count = mysql_num_rows($author_sql);
				if ($author_count > 0 ) {
					while ($a = mysql_fetch_array($author_sql)) {
						$a_fname = $a['FirstName'];
						$a_lname = $a['LastName'];
						$news_author = "<a href='directory?bro=$authorID'>$a_fname $a_lname</a> &#8226; ";
					}
				}
			} else {
				$news_author = "";
			}
			
			$getbro = getBro($authorID);
			
			if (isset($_GET['edit'])) {
				$news_list = "<div class='lookupContent blackshadow'>
				<span class='title'>Edit News</span>
				<div class='content-item' style='margin-top:30px;'>
					<form class='NiceForm' method='post' action='content_process'>
					<div><input type='text' name='edit_news_title' value='$title' class='txtinput' id='newstitle' /></div>
					<div>$getbro</div>
					<div><textarea name='edit_news_content' class='txtblock'>$content</textarea></div>
					<div><input type='submit' value='Save' class='submit' /></div>
					<input type='hidden' name='edit_type' value='news' />
					<input type='hidden' name='edit_id' value='$nid' />
					</form>
				</div>
				</div>";
			} else {
				$news_collate .= "<div class='lookupContent blackshadow'>
					<div class='content-item'>
						<div><a href='content?n=$nid' class='title'>$title</a><label class='right'><span class='hidden' id='edit_button'><a href='content?n=$nid&edit'>Edit</a> &#8226; </span>$news_author$date_name</label></div>
						<div><p>$content_html</p></div>
					</div>
					</div>";
				$news_list = "<a href='content_process?request=newsform' id='addform'><div id='addform-box'>ADD</div></a>
					<script>
						$(function(){
							$('a#addform').click(function(){
								var thisurl = $(this).attr('href');
								$('div.lookupDiv').load(thisurl);
								
								return false;
							});
						});
					</script>
					$news_collate";
				$edit = "<script>
					$(function(){
						$('div.lookupContent').hover(function(){
							$(this).find('span#edit_button').toggle();
						});
					});
					</script>";
			}
		}
	} else { $news_list = "<div class='lookupContent blackshadow'><div class='content-item'>
		<h3>There are no updates on record. Click '+Add' to add an article!</h3>
		</div></div>"; }
	
	echo $news_list, $edit;
}

if ($_GET["request"] == "newsform"){
	$news_form = "<div class='lookupContent blackshadow'>
			<span class='title'>New Article</span>
			<form id='NewsForm' class='NiceForm' method='post' action='content_process'>
			<input type='text' name='news_title' placeholder='Title' class='txtinput' id='newstitle'/>
			<textarea name='news_content' placeholder=\"What's new in AAB?\" class='txtblock' style='margin-top:20' rows='100' cols='20'></textarea>
			<input type='hidden' name='news_authorID' value='$bro' />
			<input type='submit' value='Submit' id='SaveNews' class='submit' />
			</form>
			</div>";
	
	echo $news_form;
}


if ($_GET["request"] == "events"){
	if (isset($_GET['e'])){
		$eid = $_GET['e'];
		$sql = "SELECT * FROM events WHERE id='$eid' LIMIT 1";
	} else {
		$sql = "SELECT * FROM events ORDER BY Date DESC, TimeStart DESC";
	}
	$event_sql = mysql_query("$sql") or die (mysql_error());
	$event_count = mysql_num_rows($event_sql);
	if ($event_count > 0) {
		while ($e = mysql_fetch_array($event_sql)) {
			$e_id = $e['id'];
			$e_name = $e['Name'];
			$e_date = $e['Date'];
			$e_timeS = $e['TimeStart'];
			$e_timeE = $e['TimeEnd'];
			$e_loc = $e['Location'];
			$e_desc = $e['Description'];
			$e_authorID = $e['Author'];
			$e_desc_html = nl2br($e_desc);
		
			$e_dateN = date("F j, Y", strtotime($e_date));
			$e_dateD = date("l", strtotime($e_date));
			
			$e_dateDay = "&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;$e_dateD";
			
			if ($e_authorID != "") {
				$author_sql = mysql_query("SELECT FirstName, LastName FROM brothers WHERE bro = '$e_authorID' LIMIT 1");
				$author_count = mysql_num_rows($author_sql);
				if ($author_count > 0 ) {
					while ($e = mysql_fetch_array($author_sql)) {
						$e_fname = $e['FirstName'];
						$e_lname = $e['LastName'];
						$e_author = "<a href='directory?bro=$e_author'>$e_fname $e_lname</a> &#8226; ";
					}
				} else {
					$e_author = "";
				}
			}
			
			$getbro = getBro($e_authorID);
			
				if ((!$e_timeS) && (!$e_timeE)) {
					$e_time = "";
				} elseif (($e_timeS != "") && (!$e_timeE)) {
					$e_time = "&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;$e_timeS";
				} elseif ((!$e_timeS) && ($e_timeE != "")) {
					$e_time = "&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;ends at $e_timeE";
				} elseif (($e_timeS != "") && ($e_timeE != "")) {
					$e_time = "&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;$e_timeS - $e_timeE";
				}
			
				if ($e_loc != "") {
					$e_location = "&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;$e_loc";
				} else {
					$e_location = "";
				}
				
				$check_pic = "vault/photos/events/$e_id.png";
				$default_pic = "vault/photos/events/default.png";
				if (file_exists($check_pic)) {
					$e_pic = "$check_pic";
				} else { $e_pic = "$default_pic"; }
			
			
			if (isset($_GET['edit'])) {
				$event_list = "<div class='lookupContent blackshadow'>
			<span class='title'>Edit Event</span>
			<form id='EventForm' class='NiceForm' method='post' action='content_process' enctype='multipart/form-data'>
				<input type='text' name='event_name' placeholder='Name' class='txtinput' id='eventtitle' value='$e_name' style='width:420'/>
				<table>
					<tr>
					<td><input type='text' name='event_loc' placeholder='Location' class='txtinput' id='loc_input' value='$e_loc' style='width:320' /></td>
					<td>$getbro</td>
					</tr>
				</table>
				
				<table>
					<tr>
					<td><input type='date' name='event_date' placeholder='Date' class='txtinput' id='date_input' value='$e_date' style='width:255'/></td>
					<td><input type='text' name='event_timeS' placeholder='Starts' class='txtinput' id='time_input1' value='$e_timeS' style='width:170'/></td>
					<td><input type='text' name='event_timeE' placeholder='Ends' class='txtinput' id='time_input2' value='$e_nameE' style='width:170'/></td>
					</tr>
				</table>
				
				<textarea name='event_desc' placeholder='Description' class='txtblock' style='margin: 5 0 0 3; width:602' rows='250' cols='20'>$e_desc</textarea>
				<img src='pix/frame.png' style='vertical-align:middle; margin:10'/><img src='$e_pic' style='vertical-align:middle; width:100px; margin:10px' />
				<input type='file' name='event_photo' id='event_photo' style='width:312; margin-right:20;' />
				<input type='hidden' name='edit_type' value='event' />
				<input type='hidden' name='edit_id' value='$e_id' />
				<input type='submit' value='Submit' id='SaveNews' class='submit'/>
			</form>
			</div>";
			} else {
				$event_collate .= "<div class='lookupContent blackshadow'>
				<table cellspacing='0' cellpadding='0' width='100%' class='content-item'>
				<tr>
					<td width='300' valign='top'><img src='$e_pic' style='width:300'/></td>
					<td align='left' style='padding:0 20; vertical-align:top'>
						<a href='content?e=$e_id' class='title'>$e_name</a><a href='content?e=$e_id&edit' class='hidden right' id='edit_button'>Edit</a>
						<p style='color:#888; font-weight:bold'>$e_dateN$e_dateDay$e_time$e_location</p>
						<p>$e_desc_html</p>
						
					</td>
				</tr>
				</table>
				</div>";
				
				$event_list = "<a href='content_process?request=eventform' id='addform'><div id='addform-box'>ADD</div></a>
					<script>
						$(function(){
							$('a#addform').click(function(){
								var thisurl = $(this).attr('href');
								$('div.lookupDiv').load(thisurl);
								
								return false;
							});
						});
					</script>
					$event_collate";
				$edit = "<script>
					$(function(){
						$('div.lookupContent').hover(function(){
							$(this).find('a#edit_button').toggle();
						});
					});
					</script>";
			}
		}
	} else {
		$event_list = "<div class='lookupContent blackshadow'><div class='content-item'>
		<h3>There are no events on record. Click '+Add' to add an event!</h3>
		</div></div>";
	}
	
	echo $event_list, $edit;

}


if ($_GET["request"] == "eventform"){
	$event_form = "<div class='lookupContent blackshadow'>
			<span class='title'>New Event</span>
			<form id='EventForm' class='NiceForm' method='post' action='content_process' enctype='multipart/form-data'>
				<table>
					<tr>
					<td><input type='text' name='event_name' placeholder='Name' class='txtinput' id='eventtitle' style='width:370'/></td>
					<td><input type='text' name='event_loc' placeholder='Location' class='txtinput' id='loc_input' style='width:229' /></td>
					</tr>
				</table>
				
				<table>
					<tr>
					<td><input type='date' name='event_date' placeholder='Date' class='txtinput' id='date_input' style='width:255'/></td>
					<td><input type='text' name='event_timeS' placeholder='Starts' class='txtinput' id='time_input1' style='width:170'/></td>
					<td><input type='text' name='event_timeE' placeholder='Ends' class='txtinput' id='time_input2' style='width:170'/></td>
					</tr>
				</table>
				
				<textarea name='event_desc' placeholder='Description' class='txtblock' style='margin: 5 0 0 3; width:602' rows='250' cols='20'></textarea>
				<img src='pix/frame.png' style='vertical-align:middle; margin:0 20'/><input type='file' name='event_photo' id='event_photo' style='width:312; margin-right:20;' />
				<input type='hidden' name='event_authorID' value='$bro' />
				<input type='submit' value='Submit' id='SaveNews' class='submit'/>
			</form>
			</div>";
	echo $event_form;
}


if ($_GET["request"] == "albums"){
	if (isset($_GET['a'])){
		$aid = $_GET['a'];
		$sql = "SELECT * FROM albums WHERE id='$aid' LIMIT 1";
	} else {
		$sql = "SELECT * FROM albums ORDER BY Date DESC";
	}
	$album_sql = mysql_query("$sql") or die (mysql_error());
	$album_count = mysql_num_rows($album_sql);
	if ($album_count > 0) {
		while ($a = mysql_fetch_array($album_sql)) {
			$a_id = $a['id'];
			$a_name = $a['Name'];
			$a_desc = $a['Description'];
			$a_date = $a['Date'];
			$a_authorID = $a['Author'];
			$a_html = $a['Album'];
			$a_priv = $a['Private'];
		
		
			$a_dateN = date("F j, Y",strtotime($a_date));
			
			if ($a_authorID != "") {
				$author_sql = mysql_query("SELECT FirstName, LastName FROM brothers WHERE bro = '$a_authorID' LIMIT 1");
				$author_count = mysql_num_rows($author_sql);
				if ($author_count > 0 ) {
					while ($a = mysql_fetch_array($author_sql)) {
						$a_fname = $a['FirstName'];
						$a_lname = $a['LastName'];
						$a_author = "<a href='directory?bro=$a_author'>$a_fname $a_lname</a> &#8226; ";
					}
				} else {
					$a_author = "";
				}
			}
			
			$getbro = getBro($a_authorID);
			
			if (isset($_GET['edit'])) {
				$album_list = "<div class='lookupContent blackshadow'>
						<span class='title'>Edit Album</span>
						<form class='NiceForm' method='post' action='content_process' style='padding-top:30px;'>
						<input type='text' name='album_name' class='txtinput' id='albumtitle' value='$a_name' placeholder='Name' ><br>
						<input type='date' name='album_date' class='txtinput' id='date_input' value='$a_date' placeholder='Date' /><br>
						<input type='text' name='album_desc' class='txtinput' id='albumdesc' value='$a_desc' placeholder='Description' style='width:700px'/><br>
						$getbro<br>
						<textarea name='album_html' class='txtblock' id='newsletter' placeholder='<HTML>'>$a_html</textarea>
						<input type='hidden' name='edit_type' value='album' />
						<input type='hidden' name='edit_id' value='$a_id' />
						<input type='submit' class='submit' value='Save' />
						</form>
						</div>";
			} else {
					$album_collate .= "<div class='lookupContent blackshadow'>
						<div class='content-item'>
						<label class='right'><span class='hidden' id='edit_button'><a href='content?a=$a_id&edit'>Edit</a> &#8226; </span>$a_author$a_dateN</label>
						<a href='content?a=$a_id' class='title'>$a_name</a>
						<p>$a_desc</p>
						$a_html
						</div>
						</div>";
					$album_list = "<a href='content_process?request=albumform' id='addform'><div id='addform-box'>ADD</div></a>
					<script>
						$(function(){
							$('a#addform').click(function(){
								var thisurl = $(this).attr('href');
								$('div.lookupDiv').load(thisurl);
								
								return false;
							});
						});
					</script>
					$album_collate";
					$edit = "<script>
					$(function(){
						$('div.lookupContent').hover(function(){
							$(this).find('span#edit_button').toggle();
						});
					});
					</script>";
			}
		}
	} else {
		$album_list = "<div class='lookupContent blackshadow'>
		<h3>There are no albums on record. Click '+Add' to add photos!</h3>
		</div>";
	}
	
	echo $album_list, $edit;
}

if ($_GET["request"] == "albumform"){
	$album_form = "<div class='lookupContent blackshadow'>
			<span class='title'>New Album</span>
			<form id='AlbumForm' class='NiceForm' enctype='multipart/form-data' method='post' action='content_process'>
				<table>
					<tr><td><input type='text' name='album_name' placeholder='Album Name' class='txtinput' id='albumtitle' style='width:370'/></td>
						<td colspan='2'><input type='date' name='album_date' placeholder='Album Date' class='txtinput' id='date_input' style='width:255'/></td></tr>
					<tr><td><input type='text' name='album_desc' placeholder='Album Description' class='txtinput' id='albumdesc' style='width:370' /></td>
						<td align='right' width='150'><span style='font-family:Arial; font-size:11; color:#bbb'>Private Album</span></td><td><input name='album_priv' type='checkbox' value='yes' style='width:300'/></td></tr>
					<input type='hidden' name='album_authorID' value='$bro' />
				</table>
				<textarea name='album_html' placeholder='Copy and paste the HTML object generated by Picasa' class='txtblock' id='newsletter' rows='100' cols='20'></textarea>
				<input type='submit' value='Submit' id='SaveAlbum' class='submit' />
			</form>
			</div>";
	
	echo $album_form;
}

if ($_GET["request"] == "newsletters"){
	if (isset($_GET['nl'])){
		$nlid = $_GET['nl'];
		$sql = "SELECT * FROM newsletter WHERE id='$nlid' LIMIT 1";
	} else {
		$sql = "SELECT * FROM newsletter ORDER BY date DESC";
	}
	$newsletter_sql = mysql_query("$sql") or die (mysql_error());
	$newsletter_count = mysql_num_rows($newsletter_sql);
	if ($newsletter_count > 0) {
		while ($n = mysql_fetch_array($newsletter_sql)) {
			$nlid = $n['id'];
			$title = $n['title'];
			$date = $n['date'];
			$authorID = $n['author'];
			$html = $n['html'];
		
			$date_name = date("F j, Y", strtotime($date));
			
			if (strlen($authorID)) {
				$author_sql = mysql_query("SELECT FirstName, LastName FROM brothers WHERE bro = '$authorID' LIMIT 1") or die (mysql_error());
				$author_count = mysql_num_rows($author_sql);
				if ($author_count > 0 ) {
					while ($a = mysql_fetch_array($author_sql)) {
						$a_fname = $a['FirstName'];
						$a_lname = $a['LastName'];
						$newsletter_author = "<a href='directory?bro=$authorID'>$a_fname $a_lname</a> &#8226; ";
					}
				}
			} else {
				$newsletter_author = "";
			}
			
			$getbro = getBro($authorID);
			
			if (isset($_GET['edit'])) {
				$newsletter_list = "<div class='lookupContent blackshadow'>
					<span class='title'>Edit Issue</span>
					<form class='NiceForm' method='post' action='content_process' style='padding-top:30px;'>
					<input type='text' name='newsletter_title' placeholder='Title' class='txtinput' id='newstitle' value='$title'/>
					<input type='date' name='newsletter_date' placeholder='Date' class='txtinput' id='date_input' value='$date' style='width:255; margin:4 0;'/>
					<textarea name='newsletter_html' placeholder='Copy and paste the HTML object generated by Issuu.com' class='txtblock' id='newsletter' rows='100' cols='20'>$html</textarea>
					$getbro
					<input type='hidden' name='edit_type' value='newsletter' />
					<input type='hidden' name='edit_id' value='$nlid' />
					<input type='submit' value='Submit' id='SaveNewsletter' class='submit'>
					</form>
					</div>";
			} else {
				$newsletter_collate .= "<div class='lookupContent blackshadow'>
					<label class='right'><span class='hidden' id='edit_button'><a href='content?nl=$nlid&edit'>Edit</a> &#8226; </span>$newsletter_author$date_name</label>
					<a href='content?nl=$nlid' class='title'>$title</a>
					<p>$html</p>
					</div>";
				$newsletter_list = "<a href='content_process?request=newsletterform' id='addform'><div id='addform-box'>ADD</div></a>
					<script>
						$(function(){
							$('a#addform').click(function(){
								var thisurl = $(this).attr('href');
								$('div.lookupDiv').load(thisurl);
								
								return false;
							});
						});
					</script>
					$newsletter_collate";
				$edit = "<script>
					$(function(){
						$('div.lookupContent').hover(function(){
							$(this).find('span#edit_button').toggle();
						});
					});
					</script>";
			}
		}
	} else {
		$newsletter_list = "<div class='lookupContent blackshadow'>
		<h3>There are no newsletters on record. Click '+Add' to add an issue!</h3>
		</div>";
	}
	
	echo $newsletter_list, $edit;
}

if ($_GET["request"] == "newsletterform"){
	$newsletter_form = "<div class='lookupContent blackshadow'>
			<span class='title'>New Issue</span>
			<form id='NewsletterForm' class='NiceForm' enctype='multipart/form-data' method='post' action='content_process'>
			<input type='text' name='newsletter_title' placeholder='Title' class='txtinput' id='newstitle'/>
			<input type='date' name='newsletter_date' placeholder='Date' class='txtinput' id='date_input' style='width:255; margin:4 0;'/>
			<textarea name='newsletter_html' placeholder='Copy and paste the HTML object generated by Issuu.com' class='txtblock' id='newsletter' rows='100' cols='20'></textarea>
			<input type='hidden' name='newsletter_authorID' value='$bro' />
			<input type='submit' value='Submit' id='SaveNewsletter' class='submit'>
			</form>
			</div>";
	
	echo $newsletter_form;
}

}
?>