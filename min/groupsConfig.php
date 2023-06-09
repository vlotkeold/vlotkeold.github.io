<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 **/

return array(

    // custom source example
    'general' => array(
     	$min_documentRoot . '/templates/Default/js/jquery.lib.js',
     	$min_documentRoot . '/templates/Default/js/main.js',
     	$min_documentRoot . '/templates/Default/js/profile.js',
    ),
	
    'no_general' => array(
     	$min_documentRoot . '/templates/Default/js/jquery.lib.js',
     	$min_documentRoot . '/templates/Default/js/main.js',
    ),
	
);