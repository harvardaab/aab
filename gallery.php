<?php include "scripts/checkbro.php";

$gallery_sql = mysql_query("SELECT * FROM albums WHERE Private='0' ORDER BY Date DESC");  // Search only for publicly accessible albums
	$gallery_count = mysql_num_rows($gallery_sql);
	if ($gallery_count > 0) {
		while ($g = mysql_fetch_array($gallery_sql)) {
			$a_id = $g['id'];
			$a_name = $g['Name'];
			$a_desc = $g['Description'];
			$a_date = $g['Date'];
			$a_author = $g['Author'];
			$a_html = $g['Album'];
			$a_priv = $g['Private'];
			
			if ($a_priv == 0) {
							$a_dateN = date("F j, Y",strtotime($a_date));
			
			if ($a_author != "") {
				$author_sql = mysql_query("SELECT FirstName, LastName FROM brothers WHERE bro = '$a_author' LIMIT 1");
				$author_count = mysql_num_rows($author_sql);
				if ($author_count > 0 ) {
					while ($a = mysql_fetch_array($author_sql)) {
						$a_fname = $a['FirstName'];
						$a_lname = $a['LastName'];
						$a_author = "<a href='brofile?bro=$a_author'>$a_fname $a_lname</a>";
						}
					}
				} else {
					$a_author = "";
				}
			
					$album_list .= "<div class='lift-shadow'>
						<div class='each-album'>
						<span class='album-title'><b>$a_name</b> &#8226; $a_desc</span><br>
						<span class='album-date'>$a_dateN</span><br><br>
						$a_html
						</div>
						</div>";
					
			}
		}
	} else { $album_list = "<h3 id='open_edit'>There are no albums available. Check back soon for updates!</h3>"; }
	
	mysql_close($mysql_connection);
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"
      xmlns:fb="https://www.facebook.com/2008/fbml">


<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->


<head>
<title>Gallery - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>

</head>

<body id="gallery">
<div class="wrap">

	<?php include_once "$header.php" ?>

	<div class="body-content ui-tabs">
		<ul class='ui-tabs-nav'><li class='ui-tabs-active'><a>Gallery</a></li></ul>
		<?php echo $album_list ?>
	</div>
</div>

</body>
</html>