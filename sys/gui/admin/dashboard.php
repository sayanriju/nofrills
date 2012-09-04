<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>NoFrills CMS : Admin Control Panel</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="assets/css/codemirror.css" rel="stylesheet">
		<link href="assets/css/admin.css" rel="stylesheet">
	</head>
	<body>
    <div class="page-header well">
    <h1>
        <?php echo F3::get('SITENAME') ;?>
        <small>Admin Control Panel</small>
        <div class="pull-right">
            <button data-placement="bottom" title="View Frontend in New Window/Tab" rel="tooltip" class='btn btn-inverse' id='visit_site'>Visit Site</button>
            <button data-placement="bottom" title="Logout" rel="tooltip" id="logout" class="btn btn-warning"><i class="icon-off"></i></button>
        </div>
    </h1>
    </div>	    	    
    <div class="container">
        <div class="row">
            <div id="alerts" class="span12">
                
            </div>
        </div>
        <div class="row">
            <div id="file-tree" class="span3">
                <div class="row">
                    <h3>Page Files<button id="createnew" class="btn btn-primary btn-mini pull-right"><i class="icon-plus-sign icon-white"></i> Create New Page</button></h3>
                    <div class="well"><?php Helper::output_directory(SYSDIR.'gui/pages'); ?></div>
                </div>
                <div class="row">
                    <h3>Asset Files</h3>
                    <div class="well"><?php Helper::output_directory('assets'); ?></div>
                </div>
                <div class="row">
                    <h3>Config Files</h3>
                    <div class="well"><?php Helper::output_directory(SYSDIR.'config'); ?></div>
                </div>
            </div>
            <div class="span9">
                <div class="navbar navbar-inverse">
                  <div class="navbar-inner">
                      <span class='brand'><em id="filename"></em></span> 
                    <div class="container">
                       <button type="submit" id="save-file" class="btn btn-primary pull-right">Save</button>
                    </div>
                  </div>
                </div>
                <div id="editor">
                    <form id="editor-form">
                        <textarea id="code" name="code"></textarea>
                    </form>
                </div>
            </div>
        </div>
		<footer>
            <hr style='margin-top:2em;'/>
			<p class='pull-right'>
				Powered by <a target='_blank' href="https://github.com/sayanriju/nofrills">NoFrills CMS</a><br/>Released under the GNU/GPLv3 license.<br>
			</p>
		</footer>
    </div>
        
        <script>
            // Define Variables for use within javascript files included below
            var siteurl=<?php echo json_encode(F3::get('SITEURL'));?>;
            var routes=<?php echo F3::get('routes_json');?>;
        </script>
		<script src="assets/js/jquery.js"></script>
		<script src="assets/js/codemirror.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/admin.js"></script>

	</body>
</html>
