<?php $error=F3::get('ERROR');?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo "$error[code] - $error[title]!";?></title>
	<style type="text/css">

	body { background-color: #fff; margin: 40px; font-family: Arial, Sans-serif; font-size: 12px; color: #000; }

	#container  {
		width: 600px;
		padding: 0px;
		margin: 0 auto;
	}
	#header {
		background-color: #000;
		-webkit-border-radius: 10px 10px 0 0;
		-moz-border-radius: 10px 10px 0 0;
		border-radius: 10px 10px 0 0;
		border: 1px solid #000;
	}
	#header h1 {
		color: #FFF;
		font-weight: bold;
		font-size: 16px;
		padding: 10px;
		margin: 0px;
	}
	#body {
		background-color: #EEE;
		-webkit-border-radius: 0 0 10px 10px;
		-moz-border-radius: 0 0 10px 10px;
		border-radius: 0 0 10px 10px;
		border: 1px solid #000;
		padding: 10px;
	}
    #foot {
        margin-top:2em;
        font-style:italic;
        font-size:85%;
    }
	</style>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo "$error[code] - $error[title]!";?></h1>
		</div>
		<div id="body">
			<p><?php echo $error['text'] ;?></p>
            <div id='foot'>
            <hr/>
            Running NoFrills CMS on <?php echo F3::get('BASEURL') ;?>
            </div>
		</div>
	</div>
</body>
</html>
