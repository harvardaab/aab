<?php

include "scripts/checkbro.php";

?>
<?php

/*============ LOOK UP BROS W/ DIRECTORSHIPS =============*/

// Current Board
$year = date("Y");

$positions = array("archives","finance","brotherhood","edpol","service","alumni","recruitment");
$positions_name = array("Archives","Finance","Brotherhood","Educational/Political Awareness","Service","Alumni Relations","Recruitment");

// Find any enrolled bros with leadership
for ($i = 0; $i <= 6; $i++){
	$position = $positions[$i];
	$position_name = $positions_name[$i];
	$leaders = mysql_query("SELECT * FROM brothers WHERE Leadership LIKE '%$position$year%' ORDER BY LastName ASC");
	$count = mysql_num_rows($leaders);
	if ($count > 0) {
		while ($row = mysql_fetch_array($leaders)) {
			$bro = $row['bro'];
			$firstname = $row['FirstName'];
			$lastname = $row['LastName'];
			$class = $row['Class'];
			$leadership = $row['Leadership'];
			$email = $row['Email'];
			
			$classY = substr($class, 2);
			$name = "<a href='brofile?bro=$bro'>$firstname $lastname '$classY</a>";
			$options = "<span class='right'><a href='brofile?bro=$bro' class='options'>Profile</a> <a href='mailto:$email?Subject=AAB&body=Hi%20$firstname,'  class='options'>Contact</a></span>";
			
			$img_path = "vault/photos/profpic/$bro.jpg";
			$default = "vault/photos/profpic/default.jpg";
			if (file_exists($img_path)) {
				$photo = "<a href='brofile?bro=$bro'><img src='$img_path' class='thumb small' /></a>";
			} else {
				$photo = "<a href='brofile?bro=$bro'><img src='$default' class='thumb small' /></a>";
			}
			
			$directors .= "<div class='each-director'>$photo$name, $position_name$options</div>";
		}
		$board = "<div class='all-directors'><span id='board'>Board of Directors $year</span><br>$directors</div>";
	}
}

// Next Board
$next = $year + 1;

// Find any enrolled bros with leadership for next year
for ($i = 0; $i <= 6; $i++){
	$position = $positions[$i];
	$position_name = $positions_name[$i];
	$leader_sql = mysql_query("SELECT * FROM brothers WHERE Leadership LIKE '%$position$next%' ORDER BY LastName ASC");
	$count_lead = mysql_num_rows($leader_sql);
	if ($count_lead > 0) {
		while ($row = mysql_fetch_array($leader_sql)) {
			$bro = $row['bro'];
			$firstname = $row['FirstName'];
			$lastname = $row['LastName'];
			$class = $row['Class'];
			$leadership = $row['Leadership'];
			$email = $row['Email'];
			
			$classY = substr($class, 2);
			$name = "<a href='brofile?bro=$bro'>$firstname $lastname '$classY</a>";
			$options = "<span class='right'><a href='brofile?bro=$bro' class='options'>Profile</a> <a href='mailto:$email?Subject=AAB&body=Hi%20$firstname,'  class='options'>Contact</a></span>";
			
			$img_path = "vault/photos/profpic/$bro.jpg";
			$default = "vault/photos/profpic/default.jpg";
			if (file_exists($img_path)) {
				$photo = "<a href='brofile?bro=$bro'><img src='$img_path' class='thumb small' /></a>";
			} else {
				$photo = "<a href='brofile?bro=$bro'><img src='$default' class='thumb small' /></a>";
			}
			
			$new_directors .= "<div class='each-director'>$photo$name, $position_name$options</div>";
		}
		$new_board = "<div class='padded'><span id='board'>Congratulations to the Incoming Board of Directors $next!</span>$new_directors</div>";
	}
}

mysql_close($mysql_connection);

?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"
      xmlns:fb="https://www.facebook.com/2008/fbml">

<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->

<head>
	<title>About - Asian American Brotherhood - Harvard College</title>
	<?php include_once "head.php" ?>
</head>
	<script>
$(function(){
	$('#tabs').tabs();
	$('div.each-director').hover(function(){
		$(this).find('a.options').fadeTo('fast', 1.0);
		}, function(){
		$(this).find('a.options').fadeTo('fast', 0.25)
	});
});
	</script>
<style>
a.options {opacity:.25}
div.padded {margin-bottom: 30px}
b {font-weight: 600;}
ul#benefits {margin-left: 25px;}
ul#benefits li {padding-bottom: 20px; font-family:Source Sans Pro; font-weight:300; font-size: 14px;}
</style>
<body id="about">
<div class="wrap">

	<?php include_once "$header.php" ?>
	
	<div class="tabs ui-tabs lift-shadow" id='tabs'>
		<ul class='ui-tabs-nav'>
			<li class='ui-tabs-active'><a href="#about">About</a></li>
			<li><a href="#constitution">Constitution</a></li>
			<li><a href="#leadership">Leadership</a></li>
			<li><a href="#recruit">Recruitment</a></li>
		</ul>
	
		<div id='about'>
<p>Founded in 1999, the Asian American Brotherhood seeks to promote intercultural understanding and social activism at Harvard and beyond. The values of our organization stand upon three pillars: Service, Activism, and Brotherhood. Throughout the years, AAB has been a force of collaborative and positive change in our community, a tradition of which we are proud and hope to carry on for years to come.</p>
<h2>Service</h2>
<p>AAB believes that the collective organization of passionate individuals serves best to foster a culture of service and transform communities. Whether we are preparing the Harvard Square Homeless Shelter to open its doors for the season, cleaning along the Charles River, or going on Habitat for Humanity builds, we regularly engage in projects to improve the environment and institutions around us. AAB is committed to working with any and all groups who wish to create a more vibrant community based on civic participation and collaborative partnerships.</p>
<h2>Activism</h2>
<p>Our organization is also a force for political and social consciousness. AAB joins a rich history of ethnic organization on Harvard's campus, promoting discussions on the state of Asian-America through political, cultural, migratory, and even culinary and medical perspectives. In recent years, AAB has organized an annual series of events known as Asian American Awareness Week, collaborating with over a dozen campus groups to explore issues relating to Asian American identity. In addition, AAB is proud to host Reflections, an end-of-year celebration of graduating seniors who have made significant contributions to Asian American community. To raise awareness of Asian American politicians, musical artists, cultural icons, and journalists, AAB has invited to campus many leaders within our community: from Boston Councilmember-at-Large Sam Yoon to Pulitzer award-winner Sheryl WuDunn, rapper Dumbfoundead to classical virtuoso Sarah Chang, we hope that our activism works to inspire a new generation of Asian American leaders.</p>
<h2>Brotherhood</h2>
<p>Since its founding, AAB has guided dozens of young men through their undergraduate careers at Harvard. The group's horizontal structure ensures that every voice is respected, and our close-knit membership provides every member the opportunity to be an active and contributing force within the organization. At its core, AAB is committed to exploring the oft-neglected issue of Asian American masculinity. We embody the ideal that demographics of all colors and genders should be represented in leadership during and after our time at Harvard.</p>
<p>Ever in pursuit of these three pillars of our organization, the Asian American Brotherhood strives to be an active and positive member of the Harvard community.</p>
		</div>
		
		<div id='constitution'>
<p>"We, the brothers of the Asian American Brotherhood, have united
ourselves in order to forge a stronger sense of unity among Asian Americans
in our community and to foster solidarity without coercion. In promoting
understanding and bonds across ethnic lines, the Asian American Brotherhood
seeks to empower both our members and the communities that we serve."</p>
		
		<a href='vault/files/archives/general/2012-11-30~AAB Constitution~James Sun~113~20121224151028.pdf'>Download PDF</a>
		</div>
		
		<div id='leadership'>
			<?php echo $new_board ?>
			<?php echo $board ?>
		</div>
		
		<div id='recruit'>
<p>Many of our members name joining the Asian American Brotherhood as one of the most
rewarding decisions they have ever made at Harvard. Some reasons to recruit for AAB include:</p>

<ul id='benefits'>
<li><b>Lifelong Bonds:</b> Our history of maintaining a close-knit community ensures that members truly
get to know each other on a profound level throughout their years together within the organization.</li>
<li><b>Leadership Development:</b> We pride ourselves on our horizontal structure, entrusting all members--directors
and non-officers alike--with significant responsibilities in planning events, engaging in community outreach, and managing operations.<br>
<li><b>Community Service:</b> Our organization is committed to fostering a culture of community engagement, and thus members regularly
embark on service projects together, organized both officially within the organization and organically without.</li>
<li><b>Political Awareness:</b> To stimulate discourse on topics relevant to our communities, we host discussions relating to
the Asian American experience and the social experience of the minority male.</li>
<li><b>Social Opportunities:</b> AAB regularly interacts with other cultural and social groups at Harvard and in the Boston area
for collaborations on parties, social mixers, and group outings.</li>
<li><b>Alumni Network:</b> Their unity strengthened by the closeness of the organization, our rapidly expanding alumni network
consistently provides resources and guidance to current members.</li>
</ul>

<p>The Asian American Brotherhood actively recruits for new members at the start of the spring semester.
All events and announcements will be posted on <a href='media'>news</a> and via email. Given the close-knit
structure of our organization, we believe that our recruiting process is the most effective way for us to
familiarize ourselves with a more manageable group of prospective members. That said, we recognize that there are always
many more Harvard students interested in and fit for membership. All prospective members who would like to learn more about
AAB should reach out to any member listed on our website, or send an email to <a href='mailto:aa.brotherhood@gmail.com'>aa.brotherhood@gmail.com</a>. All AAB members
would be happy to talk with anyone about the organization, our recruiting process, and their experiences within the Brotherhood.</p>
		</div>
</div>

</body>
</html>