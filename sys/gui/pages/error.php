<!DOCTYPE html>
<?php $error=F3::get('ERROR');?>
<html>
<head>
	<meta charset="utf-8">
	<title>FuelPHP Framework</title>
	<link rel='stylesheet' href='assets/css/bootstrap.css'/>
	<link rel='stylesheet' href='assets/css/style.css'/>
</head>
<body>
	<div class="container" style='margin:5em auto;width:940px;'>
		<div class="hero-unit">
            <h1><?php echo "$error[code] - $error[title]!";?></h1>
            <br/>
            <p style='margin:1em auto 0;font-style:italic;'><?php echo $error['text'] ;?></p>
		</div>
		<footer class='pull-right'>
			<p>
				Powered by <a target='_blank' href="https://github.com/sayanriju/nofrills">NoFrills CMS</a><br/>Released under the GNU/GPLv3 license.<br>
			</p>
		</footer>
	</div>
</body>
</html>
