<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>NoFrills CMS</title>
	<link rel='stylesheet' href='assets/css/bootstrap.min.css'/>
  	<link rel='stylesheet' href='assets/css/bootstrap-responsive.min.css'/>
	<link rel='stylesheet' href='assets/css/style.css'/>
</head>
<body>
	<div class="container" style='margin:5em auto;width:940px;'>
		<div class="hero-unit">
			<h1><?php echo F3::get('SITENAME');?></h1>
			<p>Welcome to the lightweight, minimalistic &amp; geeky Content Management System with absolutely No Frills attached!</p>
            <br/>
			<p>
                <a class="btn btn-info large" href="<?php echo F3::get("SITEURL");?>/admin">Login to Admin Panel</a>
            </p>
            Default Username: <strong>admin</strong><br/>
            Default Password:  <strong>admin</strong>
		</div>
		<footer class='pull-right'>
			<p>
				Powered by <a target='_blank' href="https://github.com/sayanriju/nofrills">NoFrills CMS</a><br/>Released under the GNU/GPLv3 license.<br>
			</p>
		</footer>
	</div>
</body>
</html>