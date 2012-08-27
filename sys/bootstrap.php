<?php
/* Include core file for F3 */
require_once '../sys/lib/f3base.php';

/* Set system configuration variables */
F3::set('AUTOLOAD','../sys/lib/');
F3::set('IMPORTS','../sys/lib/');
F3::set('GUI','../sys/gui/'); // Where the view/templates/pages reside!
F3::set('CONFIGDIR','../sys/config/'); // Home of configuration files

/* Load site/app specific configurations */
F3::config(F3::get('CONFIGDIR').'/settings.cfg');
if(!F3::get('CACHE'))
    F3::set('CACHE_TIMEOUT',0); // If caching is disabled, force timeout value to 0

/* Custom Error Pages */
F3::set('ONERROR', function() {
        echo F3::render("pages/error.php");
    });

/* Admin Routes */
require_once "admin.php";

/* Dynamically generated Routes (slug based) */
$routes_json=Helper::json_minify(@file_get_contents(F3::get('CONFIGDIR')."/routes.json"));
F3::set("routes_json",$routes_json);    // Store as Framework variable to decode and use elsewehere
foreach (json_decode($routes_json,true) as $slug=>$page)
{
    F3::route(
        "GET /$slug",
        function() use($page)
        {
            if(file_exists(F3::get('GUI')."/pages/$page"))
                echo F3::render("pages/$page");
            else
                F3::error(404);
        },
        F3::get('CACHE_TIMEOUT')
    );
}

/* Run the app! */
F3::run();

/* End of file bootstrap.php */ 
