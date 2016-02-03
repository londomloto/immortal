<?php echo breadcrumb(); ?>

<h2>Welcome, <?php echo get_user_session('fullname'); ?></h2>
<p>
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
</p>

<h3>About</h3>
<ul>
	<li><a href="<?php echo site_url('home/about/company'); ?>" data-push="1">Company</a></li>
	<li><a href="<?php echo site_url('home/about/privacy'); ?>" data-push="1">Privacy</a></li>
	<li>
		<a href="<?php echo site_url('home/about/developer'); ?>" data-push="1">Developers</a>
		<ul>
			<li><a href="<?php echo site_url('home/about/developer/john'); ?>" data-push="1">Jean Doel</a></li>
			<li><a href="<?php echo site_url('home/about/developer/supernova'); ?>" data-push="1">Supernova</a></li>
		</ul>
	</li>
</ul>
