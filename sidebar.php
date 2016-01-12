<div id=inside-nav>
			<div id="nav">
				<a href="." title="Home"><img src="pix/logo-transparent.png" class="nav-icons" /></a>
				<a href="directory" title="Directory"><img src="pix/icons/directory.png" class="nav-icons"/></a>
				<a href="calendar" title="Calendar"><img src="pix/icons/calendar.png" class="nav-icons"/></a>
				<?php echo $recruitingapp ?>
				<a href="pftw" title="Pix From the Weekend"><img src="pix/icons/gallery.png" class="nav-icons"/></a>
				<a href="content" title="Media Content"><img src="pix/icons/media.png" class="nav-icons"/></a>
				<a href="library" title="Library"><img src="pix/icons/library.png" class="nav-icons"/></a>
				<a href="archives" title="Archives" ><img src="pix/icons/archive.png" class="nav-icons"/></a>
				<a href="prefs" title="Preferences"><img src="pix/icons/prefs.png" class="nav-icons"/></a>
				<img src='pix/slide/loading.gif' id='loadingDiv'/>
				
				<script>
				$(function(){
					$('div#nav > a').hover(function(){
						$(this).tooltip({ position: { my: "left+5 center-12", at: "right center" } });
					});
				});
				</script>
			</div>
			<div id="account">
				<a href='logout' id='logout'>Logout</a>
				<a href="profile" id='profilelink'><?php echo $thumbnail ?></a>
			</div>
</div>