<?php

/**
	Helper methods for NoFrills CMS

	The contents of this file are subject to the terms of the GNU General
	Public License Version 3.0. You may not use this file except in
	compliance with the license. Any of the license terms and conditions
	can be waived if you get permission from the copyright holder.

	Copyright (c) 2012 
	Sayan "Riju" Chakrabarti <me@sayanriju.co.cc>

		@package Expansion
		@version 1.0
**/

class Helper extends Base {

    /*  List of filename extensions allowed in NoFrills
     * (The codemirror editor in Admin GUI is also configured to allow only these)
     *
     */
    public static $allowed_ext=array('php','html','htm','js','json','cfg','css');

    /** JSON.minify()
    *   v0.1 (c) Kyle Simpson
    *   MIT License
    *   https://github.com/getify/JSON.minify
    *   
    *   Minimizes and removes comments from Json string
    *   @param  $json   string  The json string to minimize
    *   @returns    string  Minimized json string which validates
    */
    public static function json_minify($json) 
    {
        $tokenizer = "/\"|(\/\*)|(\*\/)|(\/\/)|\n|\r/";
        $in_string = false;
        $in_multiline_comment = false;
        $in_singleline_comment = false;
        $tmp; $tmp2; $new_str = array(); $ns = 0; $from = 0; $lc; $rc; $lastIndex = 0;
            
        while (preg_match($tokenizer,$json,$tmp,PREG_OFFSET_CAPTURE,$lastIndex)) {
            $tmp = $tmp[0];
            $lastIndex = $tmp[1] + strlen($tmp[0]);
            $lc = substr($json,0,$lastIndex - strlen($tmp[0]));
            $rc = substr($json,$lastIndex);
            if (!$in_multiline_comment && !$in_singleline_comment) {
                $tmp2 = substr($lc,$from);
                if (!$in_string) {
                    $tmp2 = preg_replace("/(\n|\r|\s)*/","",$tmp2);
                }
                $new_str[] = $tmp2;
            }
            $from = $lastIndex;
                
            if ($tmp[0] == "\"" && !$in_multiline_comment && !$in_singleline_comment) {
                preg_match("/(\\\\)*$/",$lc,$tmp2);
                if (!$in_string || !$tmp2 || (strlen($tmp2[0]) % 2) == 0) {	// start of string with ", or unescaped " character found to end string
                    $in_string = !$in_string;
                }
                $from--; // include " character in next catch
                $rc = substr($json,$from);
            }
            else if ($tmp[0] == "/*" && !$in_string && !$in_multiline_comment && !$in_singleline_comment) {
                $in_multiline_comment = true;
            }
            else if ($tmp[0] == "*/" && !$in_string && $in_multiline_comment && !$in_singleline_comment) {
                $in_multiline_comment = false;
            }
            else if ($tmp[0] == "//" && !$in_string && !$in_multiline_comment && !$in_singleline_comment) {
                $in_singleline_comment = true;
            }
            else if (($tmp[0] == "\n" || $tmp[0] == "\r") && !$in_string && !$in_multiline_comment && $in_singleline_comment) {
                $in_singleline_comment = false;
            }
            else if (!$in_multiline_comment && !$in_singleline_comment && !(preg_match("/\n|\r|\s/",$tmp[0]))) {
                $new_str[] = $tmp[0];
            }
        }
        $new_str[] = $rc;
        return implode("",$new_str);        
    }

  	/**
	* A recurive function used to traverse a directory and output the files and folders within
	* Source: https://github.com/dfmcphee/simple-code-editor/blob/master/admin/nimbl.php
    * 
	* @param $dir String containing directory to traverse
	*/
	public static function output_directory($dir) {
		if ($handle = opendir($dir)) {
			echo '<ul class="nav nav-list">';
		    while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != "..") {
		        	$path = $dir . '/' . $entry;
		        	$id = str_replace('../', '', $path);
		        	$id = str_replace('/', '-', $id);
		        	$id = str_replace('.', '-', $id);
		        	
		        	if (is_dir($path)) {
			        	echo '<li>';
			        	echo '<a href="#" data-toggle="collapse" data-target="#' . $id . '">';
			        	echo '<i class="icon-folder-close"></i>' .  $entry . '</a></li>';
			        	echo '<li id="' . $id . '" class="collapse">';
			        	static::output_directory($path);
			        	echo '</li>';
		        	}
		        	else {
                        
                        if(in_array((pathinfo($entry, PATHINFO_EXTENSION)),static::$allowed_ext))                      
                            echo '<li><a href="#" class="file-item" path="' . $path . '" ><i class="icon-file"></i>' . $entry . '</a></li>';
                        else
                            continue;
		        	}
		        }
		    }
		    closedir($handle);
		    echo '</ul>';
		}
	}

    public static function authenticate($username,$passwd) 
    {
        $arr=json_decode(static::json_minify(@file_get_contents(F3::get('CONFIGDIR').'/passwd.json')),true);
        foreach($arr as $u=>$ph)
        {
            if($username==$u && md5($passwd)==$ph)
                return true;
        }
        return false;
    }
    
    

}

/* End of file json.php */
