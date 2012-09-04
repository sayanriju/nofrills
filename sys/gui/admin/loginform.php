<!DOCTYPE html>
<html lang="en">

<head>
	<title>NoFrills CMS : Admin Login</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.21" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">    
</head>

<body>
    <?php if(F3::get("SESSION.login_failed_msg")!=''):?>
        <div class='alert alert-error' style="font-weight:bolder;"><?php echo F3::get("SESSION.login_failed_msg");?></div> 
    <?php endif;?>
    <?php if(F3::get("SESSION.logout_msg")!=''):?>
        <div class='alert alert-info' style="font-weight:bolder;"><?php echo F3::get("SESSION.logout_msg");?></div> 
    <?php endif;?>
    
    
    <div class="span6" style="margin:3em;">
    <legend>NoFrills CMS : Admin Login</legend>
    <form class="form-horizontal" method='post' action='login'>
        <div class="control-group">
        <label class="control-label" for="username">Username :</label>
        <div class="controls">
        <input type="text" id="username" name="username">
        </div>
        </div>
        <div class="control-group">
        <label class="control-label" for="passwd">Password :</label>
        <div class="controls">
        <input type="password" id="passwd" name="passwd">
        </div>
        </div>
        <div class="control-group">
        <div class="controls">
         <button type="submit" class="btn">Sign in</button>
        </div>
        </div>
    </form>
    </div>
</body>

</html>
