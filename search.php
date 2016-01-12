<?php

include "scripts/checkbro.php";

if (isset($_GET['term'])) {
	$term = $_GET['term'];
	
	if ($term != "") {
		echo "<a href='#' class='right' id='close'><img src='pix/close.svg' style='height: 20; width:20' /></a>
			<script>
			$(function(){
			    $('#close').click(function(){
					$('#results').toggle();
					return false;
				});
			});
			</script>";
		// Searching brothers
		$authors = array();
		$bro_sql = mysql_query("SELECT * FROM brothers WHERE CONCAT(FirstName, LastName) LIKE '%$term%' OR CONCAT(FirstName, ' ', LastName) LIKE '%$term%' ORDER BY LastName ASC") or die (mysql_error());
		$bro_count = mysql_num_rows($bro_sql);
		if (($bro_count < 10) && ($bro_count > 0)) {
			while ($b = mysql_fetch_array($bro_sql)) {
				$bro = $b['bro'];
				$firstname = $b['FirstName'];
				$lastname = $b['LastName'];
				
				$results_bro .= "<li><a href='directory?bro=$bro'>$firstname $lastname</a></li>";
				$author_push = array_push($authors,$bro);
			}
			echo "<span class='head'>Brothers</span><ul>$results_bro</ul>";
		}

		// Searching news
		foreach($authors as $author) { $author_check .= "OR author='$author' "; }
		$news_sql = mysql_query("SELECT * FROM news WHERE title LIKE '%$term%' OR content LIKE '%$term%' $author_check ORDER BY datestamp DESC") or die (mysql_error());
		$news_count = mysql_num_rows($news_sql);
		if (($news_count < 10) && ($news_count > 0)) {
			while ($n = mysql_fetch_array($news_sql)) {
				$id = $n['id'];
				$title = $n['title'];
				$content = $n['content'];
				
				$results_news .= "<li><a href='content?n=$id'>$title</a></li>";
			}
			echo "<span class='head'>News</span><ul>$results_news</ul>";
		}
		
		foreach($authors as $author) { $author_check .= "OR Author='$author' "; }
		// Searching events
		$event_sql = mysql_query("SELECT * FROM events WHERE Name LIKE '%$term%' OR Description LIKE '%$term%' $author_check ORDER BY Date DESC") or die (mysql_error());
		$event_count = mysql_num_rows($event_sql);
		if (($event_count < 10) && ($event_count > 0)) {
			while ($n = mysql_fetch_array($event_sql)) {
				$id = $n['id'];
				$title = $n['Name'];
				$desc = $n['Description'];
				
				$results_event .= "<li><a href='content?e=$id'>$title</a></li>";
			}
			echo "<span class='head'>Events</span><ul>$results_event</ul>";
		}
		
		if (($bro_count == 0) && ($news_count == 0) && ($event_count == 0)) {
			echo "<span>No matching results!</span>";
		}
	} else {
		echo "<span>Start searching!</span><a href='#' class='right' id='close'><img src='pix/close.svg' style='height: 20; width:20' /></a>
			<script>
			$(function(){
			    $('#close').click(function(){
					$('#results').toggle();
					return false;
				});
			});
			</script>";
	}
}

?>