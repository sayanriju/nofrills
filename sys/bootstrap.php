<?php
/* Include core file for F3 */
require_once SYSDIR.'lib/f3base.php';

/* Set system configuration variables */
F3::set('AUTOLOAD',SYSDIR.'lib/');
F3::set('IMPORTS',SYSDIR.'lib/');
F3::set('GUI',SYSDIR.'gui/'); // Where the view/templates/pages reside!
F3::set('CONFIGDIR',SYSDIR.'config/'); // Home of configuration files

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

/* Generate the defined Routes (slug based) */
$routes_json=Helper::json_minify(@file_get_contents(F3::get('CONFIGDIR')."/routes.json"));
F3::set("routes_json",$routes_json);    // Store as Framework variable to decode and use elsewehere

if(!F3::get('MAINTENANCE_MODE')) {
    foreach (json_decode($routes_json,true) as $slug=>$page)
    {
        $slug=ltrim($slug,'/'); // To avoid double-slashes in url
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
}
else {      // In maintanence mode; show under construction page
    echo F3::render("pages/under_construction.php");
}

/* Run the app! */
F3::run();

/* End of file bootstrap.php */ 
