<?
/* 
	Appointment: ��������� �����
	File: init.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

	
@include CONFIG_DIR.'/config.php';

if(!$config['home_url']) die("<center><b><font color=\"blue\">NEW VK CMS</font></b></center>");

include ENGINE_DIR.'/classes/mysql.php';
include CONFIG_DIR.'/db.php';
include ENGINE_DIR.'/classes/templates.php';
if($config['gzip'] == 'yes') include ENGINE_DIR.'/modules/gzip.php';
//FUNC. COOKIES
function clean_url($url) {
	if( $url == '' ) return;
	
	$url = str_replace( "http://", "", strtolower( $url ) );
	$url = str_replace( "https://", "", $url );
	if( substr( $url, 0, 4 ) == 'www.' ) $url = substr( $url, 4 );
	$url = explode( '/', $url );
	$url = reset( $url );
	$url = explode( ':', $url );
	$url = reset( $url );
	
	return $url;
}

$domain_cookie = explode (".", clean_url( $_SERVER['HTTP_HOST'] ));
$domain_cookie_count = count($domain_cookie);
$domain_allow_count = -2;

if($domain_cookie_count > 2){

	if(in_array($domain_cookie[$domain_cookie_count-2], array('com', 'net', 'org') )) 
		$domain_allow_count = -3;
		
	if($domain_cookie[$domain_cookie_count-1] == 'ua' ) 
		$domain_allow_count = -3;
		
	$domain_cookie = array_slice($domain_cookie, $domain_allow_count);
}

$domain_cookie = ".".implode(".", $domain_cookie);

define('DOMAIN', $domain_cookie);

function set_cookie($name, $value, $expires) {
	
	if( $expires ) {
		
		$expires = time() + ($expires * 86400);
	
	} else {
		
		$expires = FALSE;
	
	}
	
	if( PHP_VERSION < 5.2 ) {
		
		setcookie($name, $value, $expires, "/", DOMAIN . "; HttpOnly");
	
	} else {
		
		setcookie($name, $value, $expires, "/", DOMAIN, NULL, TRUE);
	
	}
}
//����� �����
if($_GET['act'] == 'chage_lang'){
	
	$langId = intval($_GET['id']);
	$config['lang_list'] = nl2br($config['lang_list']);
	$expLangList = explode('<br />', $config['lang_list']);
	$numLangs = count($expLangList);
	
	if($langId > 0 AND $langId <= $numLangs){

		//������ ����
		set_cookie("lang", $langId, 365);

	}
	
	$langReferer = $_SERVER['HTTP_REFERER'];
	
	header("Location: {$langReferer}");

}

//lang
$config['lang_list'] = nl2br($config['lang_list']);
$expLangList = explode('<br />', $config['lang_list']);
$numLangs = count($expLangList);
$useLang = intval($_COOKIE['lang']);
if($useLang <= 0) $useLang = 1;
$cil = 0;
foreach($expLangList as $expLangData){

	$cil++;
	
	$expLangName = explode(' | ', $expLangData);
	
	if($cil == $useLang AND $expLangName[0]){
	
		$rMyLang = $expLangName[0];
		$checkLang = $expLangName[1];
		
	}
	
}

if(!$checkLang){
	$rMyLang = '�������';
	$checkLang = 'Russian';
}

include ROOT_DIR.'/lang/'.$checkLang.'/site.lng';
include ENGINE_DIR.'/modules/functions.php';


if($_GET['act'] == 'change_mobile'){
	$_SESSION['user_mobile'] = 1;
	header("Location: /?go=main");
	$db->query("UPDATE LOW_PRIORITY `".PREFIX."_users` SET user_mobile=1 WHERE user_id = '{$user_info['user_id']}'");
}

if($_GET['act'] == 'change_fullver'){
	$_SESSION['user_mobile'] = 0;
	header("Location: /");
	$db->query("UPDATE LOW_PRIORITY `".PREFIX."_users` SET user_mobile=0 WHERE user_id = '{$user_info['user_id']}'");
}

if($_SESSION['user_mobile'] == 1){
	if($_GET['go'] == 'messages'){ 	$_GET['go'] = 'im'; }
	$config['temp'] = 'mobile';
	if($_GET['go'] == '' AND $_GET['act'] != 'logout'){ 	header("Location: /?go=main"); exit; }
}

$tpl = new mozg_template;
$tpl->dir = ROOT_DIR.'/templates/'.$config['temp'];
define('TEMPLATE_DIR', $tpl->dir);

$_DOCUMENT_DATE = false;
$Timer = new microTimer();
$Timer->start();

$server_time = intval($_SERVER['REQUEST_TIME']);

include ENGINE_DIR.'/modules/login.php';

if($config['offline'] == "yes") include ENGINE_DIR . '/modules/offline.php';
if($user_info['user_delet']) include ENGINE_DIR . '/modules/profile_delet.php';
if($user_info['user_delete_type'] >= '1') include ENGINE_DIR . '/modules/profile_delete.php';
$sql_banned = $db->super_query("SELECT * FROM ".PREFIX."_banned", true, "banned", true);
if(isset($sql_banned)) $blockip = check_ip($sql_banned); else $blockip = false;
if($user_info['user_ban_date'] >= $server_time OR $user_info['user_ban_date'] == '0' OR $blockip) include ENGINE_DIR . '/modules/profile_ban.php';

//���� ���� ��������� �� ��������� ��������� ���� ��������� � ������� ������ � �� ������ ���
if($logged){
	if(!$user_info['user_lastupdate']) $user_info['user_lastupdate'] = 1;

	if(date('Y-m-d', $user_info['user_lastupdate']) < date('Y-m-d', $server_time))
		$sql_rate = ", user_rate = user_rate+1, user_lastupdate = '{$server_time}'";
	if($sql_rate <= 100)
	$db->query("UPDATE LOW_PRIORITY `".PREFIX."_users` SET user_last_visit = '{$server_time}' {$sql_rate} WHERE user_id = '{$user_info['user_id']}'");
}

//��������� ����� �������������
$user_group = unserialize(serialize(array(
							1 => array( #�������������
								'addnews' => '1', 
							),
							2 => array( #������� ���������
								'addnews' => '0', 
							),
							3 => array( #���������
								'addnews' => '0', 
							),
							4 => array( #������������
								'addnews' => '0', 
							), 
							5 => array( #������������
								'addnews' => '0', 
							),
						)));

//����� �������
$online_time = $server_time - $config['online_time'];

include ENGINE_DIR.'/onlinemodules.php';
?>