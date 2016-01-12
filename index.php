<?php

include "scripts/checkbro.php";

$img_path = "vault/photos/albums/slideshow/";
if ($handle = opendir($img_path)) {

    /* This is the correct way to loop over the directory. */
    while (false !== ($photo = readdir($handle))) {
    	if ($photo != "." && $photo != "..") {
    		list($txt,$ext) = explode(".", "$photo\n");
    		$caption = str_replace("-"," ",$txt);
    		$photos .= "<div class='slide'><img src='$img_path$photo\n' title='$caption' style='width:570;' />
    		<div class='caption'><p>$caption</p></div></div>";
    	}
    }

    closedir($handle);
}

mysql_close($mysql_connection);

?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"
      xmlns:fb="https://www.facebook.com/2008/fbml">


<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->


<head>
	<title>Asian American Brotherhood - Harvard College</title>
	<link rel="stylesheet" type="text/css" href="css/slide.css"/>
	<?php include_once "head.php" ?>
	<script src="js/slides.min.jquery.js"></script>
	<script>
		$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: 'pix/slide/loading.gif',
				play: 3000,
				pause: 2500,
				hoverPause: true,
				animationStart: function(current){
					$('.caption').animate({
						bottom:-35
					},100);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationStart on slide: ', current);
					};
				},
				animationComplete: function(current){
					$('.caption').animate({
						bottom:0
					},200);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationComplete on slide: ', current);
					};
				},
				slidesLoaded: function() {
					$('.caption').animate({
						bottom:0
					},200);
				}
			});
		});
	</script>
</head>

<body id="home">
<div class='wrap'>

	<?php include_once "$header.php" ?>

	<div class="body-content">
		<h1 style='padding: 0px 0px 30px 150px;'>Welcome to the Asian American Brotherhood.</h1>
	
		<div id='slides'>
			<div class="slides_container">
				<?php echo $photos ?>
			</div>
		</div>
		<img src="pix/slide/example-frame.png" width="739" height="341" alt="Example Frame" id="frame">
	</div>

</div>
</body>
</html>