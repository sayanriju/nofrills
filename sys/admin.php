<?php
function reset_flashmsg() 
{
    F3::set('SESSION.login_failed_msg','');
    F3::set('SESSION.logout_msg','');
}

/* Authetication Logic */
F3::route("GET /login", function(){
        if(F3::get('SESSION.whoami')!='')   // Already Logged in
        {
            F3::reroute("/admin");
        }
        echo F3::render("admin/loginform.php");
        reset_flashmsg();
});

F3::route("POST /login", function(){
        F3::set('SESSION.whoami','');
        reset_flashmsg();
        if(Helper::authenticate(F3::get('POST.username'),F3::get('POST.passwd'))){
            F3::set('SESSION.whoami',F3::get('POST.username'));
            F3::reroute("/admin");
        }
        else{
            F3::set('SESSION.login_failed_msg','Login Failed! Try Again.');
            F3::reroute("/login");
        }
    });
F3::route("GET /logout", function(){
    F3::set('SESSION.whoami','');
    F3::set('SESSION.logout_msg','You\'ve Logged Out Successfully');
    F3::reroute('/login');
});

/* The Admin Routes*/
F3::route("GET /admin", function(){
        if(F3::get('SESSION.whoami')=='')   // Not logged in, show login form
        {
            F3::reroute("/login");
        }
        
        echo F3::render("admin/dashboard.php"); // Dashboard
    });

F3::route("POST /admin/ajax.php", function(){   // Do actual stuff via ajax
    if(F3::get('SESSION.whoami')=='')
    {
        $response=-99; // Do nothing if not logged in.
        die();
    }
    
    // If 'createfile' is passed, create it
    if (isset($_POST['createfile'])) {
        // First check if file exists already
        if(file_exists($_POST['createfile']))
            $response=-1;
        else {
            // Check for acceptable filename extension
            if(!in_array((pathinfo($_POST['createfile'], PATHINFO_EXTENSION)),array('php','htm','html')))
                $response=-2;
            else {
                // Now try and create file
                $retval = file_put_contents($_POST['createfile'],"");
                if($retval===FALSE)
                    $response=0;    // Error!
                else
                    $response=1;    // Success!
            }
        }
    }
    
    // If a file path is passed in, open it and get its contents
	if (isset($_POST['file'])) {
		$response = file_get_contents($_POST['file']);
	}
	
	// If file contents are passed in, update the file with the new contents
	if (isset($_POST['code'])) {
		$code = $_POST['code'];
		$file = $_POST['file'];
		
		$code = trim(stripslashes($code));
		
		if (file_put_contents($file, $code) !== false){
			$response = 'success';
		}
		else {
			$response = 'fail';
		}
	}
	
	echo $response;
});
