<?php
@session_start();
@ob_start();
@ob_implicit_flush(0);

@error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

define('MOZG', true);
define('ROOT_DIR', dirname (__FILE__));
define('ENGINE_DIR', ROOT_DIR.'/core');
define('CONFIG_DIR', ROOT_DIR.'/config');
define('ADMIN_DIR', ROOT_DIR.'/admin');

@include CONFIG_DIR.'/config.php';

if(!$config['home_url']) die("Author VK CMS new: Sloopy");
echo "<center>Author NEW VK CMS: Sloopy</center>";
$admin_link = $config['home_url'].'adminpanel.php';

include ENGINE_DIR.'/classes/mysql.php';
include CONFIG_DIR.'/db.php';
include ADMIN_DIR.'/functions.php';
include ADMIN_DIR.'/login.php';

$db->close();
?>