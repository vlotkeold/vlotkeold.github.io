<?php
/* 
	Appointment: Основные функции сайта
	File: functions.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

class microTimer {
	function start(){
		global $starttime;
		$mtime = microtime();
		$mtime = explode( ' ', $mtime );
		$mtime = $mtime[1] + $mtime[0];
		$starttime = $mtime;
	}
	function stop(){
		global $starttime;
		$mtime = microtime();
		$mtime = explode( ' ', $mtime );
		$mtime = $mtime[1] + $mtime[0];
		$endtime = $mtime;
		$totaltime = round( ($endtime - $starttime), 5 );
		return $totaltime;
	}
}
function num2word($num,$words) {            
    $num=$num%100;
    if ($num>19) { $num=$num%10; }
    switch ($num) {
        case 1:  { return($words[0]); }
        case 2: case 3: case 4:  { return($words[1]); }
        default: { return($words[2]); }
    }
}
function monthdays($month, $year){
	return date("t", strtotime($year . "-" . $month . "-01"));
}
//################### Мобильный статус ###################//
function detect_mobile_device(){
        // Проверяем, если значение клиента пользователя претендует на Windows, но не Windows Mobile
if(stristr(@$_SERVER['HTTP_USER_AGENT'],'windows')&&!stristr(@$_SERVER['HTTP_USER_AGENT'],'windows ce')) return false;
        // Проверяем, если вы зашли с компьютера то оповещаем, что это мобильный браузер
if(preg_match('/up.browser|up. link |windows ce|iemobile|mini|mmp|symbian|midp|wap|phone|pocket|mobile|pda|psp/i',
        @$_SERVER['HTTP_USER_AGENT'])) return true;
        // Проверка HTTP-заголовка принимают ли wap.wml или wap.xhtml поддержки.
if(isset($_SERVER['HTTP_ACCEPT'])&&(stristr($_SERVER['HTTP_ACCEPT'],'text/vnd.wap.wml')||
        stristr($_SERVER['HTTP_ACCEPT'],'application/vnd.wap.xhtml xml'))) return true;
   // Проверяем мобильное устройство.
if(isset($_SERVER['HTTP_X_WAP_PROFILE'])||isset($_SERVER['HTTP_PROFILE'])||
        isset($_SERVER['X-OperaMini-Features'])||isset($_SERVER['UA-pixels'])) return true;
        // Создаем массив с первыми четырьмя персонажами из самых распространенных мобильных версий.
$a = array ('acs-','alav','alca','amoi','audi','aste','avan','benq','bird','blac',
        'bla z','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
        'ipaq','java', 'jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
        'maui','maxo','midp','mi ts','mmef','mobi','mot-','moto','mwbp','nec-',
        'newt','noki','opwv','palm','pana' ,'pant','pdxg','phil','play','pluc',
        'port','prox','qtek','qwap','sage','sams','s any','sch-','sec-','send',
        'seri','sgh-','shar','sie-','siem','smal','smar','sony ','sph-','symb',
        't-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda',' w3c ',
        'wap-','wapa','wapi','wapp','wapr','webc','winw','winw','xda','xda-');
        // Проверяем, если первые четыре символа текущего клиента мобильных версий то устанавливается в качестве ключа в массиве.
if(isset($a[ substr (@$_SERVER['HTTP_USER_AGENT'],0,4)])) return true;
}
function totranslit($var, $lower = true, $punkt = true) {
	global $langtranslit;
	
	if ( is_array($var) ) return "";

	if (!is_array ( $langtranslit ) OR !count( $langtranslit ) ) {

		$langtranslit = array(
		'а' => 'a', 'б' => 'b', 'в' => 'v',
		'г' => 'g', 'д' => 'd', 'е' => 'e',
		'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
		'и' => 'i', 'й' => 'y', 'к' => 'k',
		'л' => 'l', 'м' => 'm', 'н' => 'n',
		'о' => 'o', 'п' => 'p', 'р' => 'r',
		'с' => 's', 'т' => 't', 'у' => 'u',
		'ф' => 'f', 'х' => 'h', 'ц' => 'c',
		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
		'ь' => '', 'ы' => 'y', 'ъ' => '',
		'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
		"ї" => "yi", "є" => "ye",
		
		'А' => 'A', 'Б' => 'B', 'В' => 'V',
		'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
		'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
		'И' => 'I', 'Й' => 'Y', 'К' => 'K',
		'Л' => 'L', 'М' => 'M', 'Н' => 'N',
		'О' => 'O', 'П' => 'P', 'Р' => 'R',
		'С' => 'S', 'Т' => 'T', 'У' => 'U',
		'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
		'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
		'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
		'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
		"Ї" => "yi", "Є" => "ye",
		);

	}
	
	$var = str_replace( ".php", "", $var );
	$var = trim( strip_tags( $var ) );
	$var = preg_replace( "/\s+/ms", "-", $var );

	$var = strtr($var, $langtranslit);
	
	if ( $punkt ) $var = preg_replace( "/[^a-z0-9\_\-.]+/mi", "", $var );
	else $var = preg_replace( "/[^a-z0-9\_\-]+/mi", "", $var );

	$var = preg_replace( '#[\-]+#i', '-', $var );

	if ( $lower ) $var = strtolower( $var );
	
	if( strlen( $var ) > 200 ) {
		
		$var = substr( $var, 0, 200 );
		
		if( ($temp_max = strrpos( $var, '-' )) ) $var = substr( $var, 0, $temp_max );
	
	}
	
	return $var;
}
function GetVar($v){
	if(ini_get('magic_quotes_gpc'))
		return stripslashes($v) ;
	return $v;
}
function check_xss(){
	$url = html_entity_decode(urldecode($_SERVER['QUERY_STRING']));
	
	if($url){
		if((strpos( $url, '<' ) !== false) || (strpos( $url, '>' ) !== false) || (strpos( $url, '"' ) !== false) || (strpos( $url, './' ) !== false) || (strpos( $url, '../' ) !== false) || (strpos( $url, '\'' ) !== false) || (strpos( $url, '.php' ) !== false)){
			if($_GET['go'] != "search" AND $_GET['go'] != "messages") 
				die('Hacking attempt!');
		}
	}
	
	$url = html_entity_decode( urldecode( $_SERVER['REQUEST_URI'] ) );
	if($url){
		if((strpos($url, '<') !== false) || (strpos($url, '>') !== false) || (strpos($url, '"') !== false) || (strpos($url, '\'') !== false)){
			if($_GET['go'] != "search" AND $_GET['go'] != "messages")
				die('Hacking attempt!');
		}
	}
}
function langdate($format, $stamp){
	global $langdate;
	return strtr(@date($format, $stamp), $langdate);
}
function navigation($gc, $num, $type){
	global $tpl, $page;

	$gcount = $gc;
	$cnt = $num;
	$items_count = $cnt;
	$items_per_page = $gcount;
	$page_refers_per_page = 5;
	$pages = '';		
	$pages_count = ( ( $items_count % $items_per_page != 0 ) ) ? floor( $items_count / $items_per_page ) + 1 : floor( $items_count / $items_per_page );
	$start_page = ( $page - $page_refers_per_page <= 0  ) ? 1 : $page - $page_refers_per_page + 1;
	$page_refers_per_page_count = ( ( $page - $page_refers_per_page < 0 ) ? $page : $page_refers_per_page ) + ( ( $page + $page_refers_per_page > $pages_count ) ? ( $pages_count - $page )  :  $page_refers_per_page - 1 );
			
	if($page > 1)
		$pages .= '<a href="'.$type.($page-1).'" onClick="Page.Go(this.href); return false">&laquo;</a>';
	else
		$pages .= '';
				
	if ( $start_page > 1 ) {
		$pages .= '<a href="'.$type.'1" onClick="Page.Go(this.href); return false">1</a>';
		$pages .= '<a href="'.$type.( $start_page - 1 ).'" onClick="Page.Go(this.href); return false">...</a>';
			
	}
					
	for ( $index = -1; ++$index <= $page_refers_per_page_count-1; ) {
		if ( $index + $start_page == $page )
			$pages .= '<span>' . ( $start_page + $index ) . '</span>';
		else 
			$pages .= '<a href="'.$type.($start_page+$index).'" onClick="Page.Go(this.href); return false">'.($start_page+$index).'</a>';
	} 
			
	if ( $page + $page_refers_per_page <= $pages_count ) { 
		$pages .= '<a href="'.$type.( $start_page + $page_refers_per_page_count ).'" onClick="Page.Go(this.href); return false">...</a>';
		$pages .= '<a href="'.$type.$pages_count.'" onClick="Page.Go(this.href); return false">'.$pages_count.'</a>';	
	} 
				
	$resif = $cnt/$gcount;
	if(ceil($resif) == $page)
		$pages .= '';
	else
		$pages .= '<a href="'.$type.($page+1).'" onClick="Page.Go(this.href); return false">&raquo;</a>';

	if ( $pages_count <= 1 )
		$pages = '';

	$tpl_2 = new mozg_template();
	$tpl_2->dir = TEMPLATE_DIR;
	$tpl_2->load_template('nav.tpl');
	$tpl_2->set('{pages}', $pages);
	$tpl_2->compile('content');
	$tpl_2->clear();
	$tpl->result['content'] .= $tpl_2->result['content'];
}
function box_navigation($gc, $num, $id, $function, $act){
	global $tpl, $page;
	$gcount = $gc;
	$cnt = $num;
	$items_count = $cnt;
	$items_per_page = $gcount;
	$page_refers_per_page = 5;
	$pages = '';		
	$pages_count = ( ( $items_count % $items_per_page != 0 ) ) ? floor( $items_count / $items_per_page ) + 1 : floor( $items_count / $items_per_page );
	$start_page = ( $page - $page_refers_per_page <= 0  ) ? 1 : $page - $page_refers_per_page + 1;
	$page_refers_per_page_count = ( ( $page - $page_refers_per_page < 0 ) ? $page : $page_refers_per_page ) + ( ( $page + $page_refers_per_page > $pages_count ) ? ( $pages_count - $page )  :  $page_refers_per_page - 1 );
	
	if(!$act)
		$act = "''";
	else
		$act = "'{$act}'";
			
	if($page > 1)
		$pages .= '<a href="" onClick="'.$function.'('.$id.', '.($page-1).', '.$act.'); return false">&laquo;</a>';
	else
		$pages .= '';
				
	if ( $start_page > 1 ) {
		$pages .= '<a href="" onClick="'.$function.'('.$id.', 1, '.$act.'); return false">1</a>';
		$pages .= '<a href="" onClick="'.$function.'('.$id.', '.($start_page-1).', '.$act.'); return false">...</a>';
			
	}
					
	for ( $index = -1; ++$index <= $page_refers_per_page_count-1; ) {
		if ( $index + $start_page == $page )
			$pages .= '<span>' . ( $start_page + $index ) . '</span>';
		else 
			$pages .= '<a href="" onClick="'.$function.'('.$id.', '.($start_page+$index).', '.$act.'); return false">'.($start_page+$index).'</a>';
	} 
			
	if ( $page + $page_refers_per_page <= $pages_count ) { 
		$pages .= '<a href="" onClick="'.$function.'('.$id.', '.($start_page + $page_refers_per_page_count).', '.$act.'); return false">...</a>';
		$pages .= '<a href="" onClick="'.$function.'('.$id.', '.$pages_count.', '.$act.'); return false">'.$pages_count.'</a>';	
	} 
				
	$resif = $cnt/$gcount;
	if(ceil($resif) == $page)
		$pages .= '';
	else
		$pages .= '<a href="/" onClick="'.$function.'('.$id.', '.($page+1).', '.$act.'); return false">&raquo;</a>';

	if ( $pages_count <= 1 )
		$pages = '';

	$tpl_2 = new mozg_template();
	$tpl_2->dir = TEMPLATE_DIR;
	$tpl_2->load_template('nav.tpl');
	$tpl_2->set('{pages}', $pages);
	$tpl_2->compile('content');
	$tpl_2->clear();
	$tpl->result['content'] .= $tpl_2->result['content'];
}

function check_smartphone(){
        if ( $_SESSION['mobile_enable'] ) return true;
        $phone_array = array('iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'mobile windows', 'cellphone', 'opera mobi', 'operamobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'symbos', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser', 'android');
        $agent = strtolower( $_SERVER['HTTP_USER_AGENT'] );
        foreach ($phone_array as $value) {
                if ( strpos($agent, $value) !== false ) return true;
        }
        return false;
}
function msgbox($title, $text, $tpl_name) {
	global $tpl;
	
	$tpl_2 = new mozg_template();
	$tpl_2->dir = TEMPLATE_DIR;
	
	$tpl_2->load_template($tpl_name.'.tpl');
	$tpl_2->set('{error}', $text);
	$tpl_2->set('{title}', $title);
	$tpl_2->compile('info');
	$tpl_2->clear();
	
	$tpl->result['info'] .= $tpl_2->result['info'];
}
function creat_system_cache($prefix, $cache_text){
	$filename = ENGINE_DIR . '/cache/core/'.$prefix.'.php';

	$fp = fopen($filename, 'wb+');
	fwrite($fp,$cache_text);
	fclose($fp);
	
	@chmod($filename, 0666);
}
function system_cache($prefix) {
	$filename = ENGINE_DIR.'/cache/core/'.$prefix.'.php';
	return @file_get_contents($filename);
}
function mozg_clear_cache(){
	$fdir = opendir(ENGINE_DIR.'/cache/'.$folder);
	
	while($file = readdir($fdir))
		if($file != '.' and $file != '..' and $file != '.htaccess' and $file != 'core')
			@unlink(ENGINE_DIR.'/cache/'.$file);
}
function mozg_clear_cache_folder($folder){
	$fdir = opendir(ENGINE_DIR.'/cache/'.$folder);
	
	while($file = readdir($fdir))
		@unlink(ENGINE_DIR.'/cache/'.$folder.'/'.$file);
}
function mozg_clear_cache_file($prefix) {
	@unlink(ENGINE_DIR.'/cache/'.$prefix.'.tmp');
}
function mozg_mass_clear_cache_file($prefix){
	$arr_prefix = explode('|', $prefix);
	foreach($arr_prefix as $file)
		@unlink(ENGINE_DIR.'/cache/'.$file.'.tmp');
}
function mozg_create_folder_cache($prefix){
	if(!is_dir(ROOT_DIR.'/core/cache/'.$prefix)){
		@mkdir(ROOT_DIR.'/core/cache/'.$prefix, 0777);
		@chmod(ROOT_DIR.'/core/cache/'.$prefix, 0777);
	}
}
function mozg_create_cache($prefix, $cache_text) {
	$filename = ENGINE_DIR.'/cache/'.$prefix.'.tmp';
	$fp = fopen($filename, 'wb+');
	fwrite($fp, $cache_text);
	fclose($fp);
	@chmod($filename, 0666);
}
function mozg_cache($prefix) {
	$filename = ENGINE_DIR.'/cache/'.$prefix.'.tmp';
	return @file_get_contents($filename);
}
function strip_data($text) {
	$quotes = array ("\x27", "\x22", "\x60", "\t", "\n", "\r", "'", ",", "/", ";", ":", "@", "[", "]", "{", "}", "=", ")", "(", "*", "&", "^", "%", "$", "<", ">", "?", "!", '"' );
	$goodquotes = array ("-", "+", "#" );
	$repquotes = array ("\-", "\+", "\#" );
	$text = stripslashes( $text );
	$text = trim( strip_tags( $text ) );
	$text = str_replace( $quotes, '', $text );
	$text = str_replace( $goodquotes, $repquotes, $text );
	return $text;
}
function installationSelected($id, $options){
	$source = str_replace('value="'.$id.'"', 'value="'.$id.'" selected', $options);
	return $source;
}
function InstallationSelectedNew($id, $options){
	$source = str_replace('val="'.$id.'" class="', 'val="'.$id.'" class="active ', $options);
	return $source;
}
function ajax_utf8($source){
	return iconv('utf-8', 'windows-1251', $source);
}
function xfieldsdataload($id){
	if( $id == "" ) return;
	
	$xfieldsdata = explode( "||", $id );
	foreach ( $xfieldsdata as $xfielddata ) {
		list ( $xfielddataname, $xfielddatavalue ) = explode( "|", $xfielddata );
		$xfielddataname = str_replace( "&#124;", "|", $xfielddataname );
		$xfielddataname = str_replace( "__NEWL__", "\r\n", $xfielddataname );
		$xfielddatavalue = str_replace( "&#124;", "|", $xfielddatavalue );
		$xfielddatavalue = str_replace( "__NEWL__", "\r\n", $xfielddatavalue );
		$data[$xfielddataname] = $xfielddatavalue;
	}
	
	return $data;
}
function profileload() {
	$path = ENGINE_DIR.'/xfields.txt';
	$filecontents = file($path);

	if(!is_array($filecontents)){
		exit('Невозможно загрузить файл');
	}
				
	foreach($filecontents as $name => $value){
		$filecontents[$name] = explode("|", trim($value));
		foreach($filecontents[$name] as $name2 => $value2){
			$value2 = str_replace("&#124;", "|", $value2); 
			$value2 = str_replace("__NEWL__", "\r\n", $value2);
			$filecontents[$name][$name2] = $value2;
		}
	}
	return $filecontents;
}
function NoAjaxQuery(){
	if(clean_url($_SERVER['HTTP_REFERER']) != clean_url($_SERVER['HTTP_HOST']) AND $_SERVER['REQUEST_METHOD'] != 'POST')
		header('Location: /index.php?go=none');
}
function replace_rn($source){
	
	$find[] = "'\r'";
	$replace[] = "";
	$find[] = "'\n'";
	$replace[] = "";
	
	$source = preg_replace($find, $replace, $source);
	
	return $source;
	
}
function myBr($source){
	
	$find[] = "'\r'";
	$replace[] = "<br />";
	
	$find[] = "'\n'";
	$replace[] = "<br />";

	$source = preg_replace($find, $replace, $source);
	
	return $source;
	
}
function myBrRn($source){

	$find[] = "<br />";
	$replace[] = "\r";
	$find[] = "<br />";
	$replace[] = "\n";
	
	$source = str_replace($find, $replace, $source);
	
	return $source;
}
function rn_replace($source){
	
	$find[] = "'\r'";
	$replace[] = "";
	$find[] = "'\n'";
	$replace[] = "";
	
	$source = preg_replace($find, $replace, $source);
	
	return $source;
	
}
function gram_record($num,$type){
	
	$strlen_num = strlen($num);
	
	if($num <= 21){
		$numres = $num;
	} elseif($strlen_num == 2){
		$parsnum = substr($num,1,2);
		$numres = str_replace('0','10',$parsnum);
	} elseif($strlen_num == 3){
		$parsnum = substr($num,2,3);
		$numres = str_replace('0','10',$parsnum);
	} elseif($strlen_num == 4){
		$parsnum = substr($num,3,4);
		$numres = str_replace('0','10',$parsnum);
	} elseif($strlen_num == 5){
		$parsnum = substr($num,4,5);
		$numres = str_replace('0','10',$parsnum);
	}
	
	if($type == 'rec'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_rec1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_rec2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_rec3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_rec4}';
		}
	}
	
	if($type == 'comments'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_com1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_com2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_com3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_com4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_com5}';
		}
	}
	
	if($type == 'albums'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_alb1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_alb2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_alb3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_alb4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_alb5}';
		}
	}
	
	if($type == 'photos'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_pho1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_pho2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_pho3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_pho4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_pho5}';
		}
	}
	
	if($type == 'dialog'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_dia1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_dia2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_dia3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_dia4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_dia5}';
		}
	}
	
	if($type == 'friends_demands'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_dem1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_dem2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_dem3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_dem4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_dem5}';
		}
	}
	
	if($type == 'user_age'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_age1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_age2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_age3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_age4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_age5}';
		}
	}
	
	if($type == 'friends'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_fri1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_fri2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_fri3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_fri4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_fri5}';
		}
	}
	
	if($type == 'friends_mutual'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_mfr1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_mfr2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_mfr3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_mfr4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_mfr5}';
		}
	}
	
	if($type == 'topics'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_top1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_top2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_top3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_top4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_top5}';
		}
	}
	
	if($type == 'friends_online'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_ofr1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_ofr2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_ofr3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_ofr4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_ofr5}';
		}
	}
	
	if($type == 'friends_phonebook_friends'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_pfr1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_pfr2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_pfr3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_pfr4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_pfr5}';
		}
	}
	
	if($type == 'fave'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_fav1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_fav2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_fav3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_fav4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_fav5}';
		}
	}
	
	if($type == 'flist'){
		if($numres == 0){
			$gram_num_record = 'заявок';
		} elseif($numres == 1){
			$gram_num_record = 'заявка';
		} elseif($numres < 5){
			$gram_num_record = 'заявки';
		} elseif($numres < 21){
			$gram_num_record = 'заявок';
		} elseif($numres == 21){
			$gram_num_record = 'заявка';
		}
	}
	
	if($type == 'prev'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_pre1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_pre2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_pre3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_pre4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_pre5}';
		}
	}
	
	if($type == 'admins'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_adm1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_adm2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_adm3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_adm4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_adm5}';
		}
	}
	
	if($type == 'subscr'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_sbr1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_sbr2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_sbr3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_sbr4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_sbr5}';
		}
	}
	
	if($type == 'videos'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_vid1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_vid2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_vid3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_vid4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_vid5}';
		}
	}
	
	if($type == 'notes'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_not1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_not2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_not3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_not4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_not5}';
		}
	}
	
	if($type == 'like'){
		if($numres == 0){
			$gram_num_record = '{translate=fun_lik1}';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_lik2}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_lik3}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_lik4}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_lik5}';
		}
	}
	
	if($type == 'updates'){
		if($numres == 0){
			$gram_num_record = '';
		} elseif($numres == 1){
			$gram_num_record = '{translate=fun_upd1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_upd2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_upd3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_upd4}';
		}
	}
	
	if($type == 'msg'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_mes1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_mes2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_mes3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_mes4}';
		}
	}
	
	if($type == 'questions'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_que1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_que2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_que3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_que4}';
		}
	}

	if($type == 'gifts'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_gif1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_gif2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_gif3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_gif4}';
		}
	}

	if($type == 'groups_users'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_gua1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_gua2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_gua3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_gua4}';
		}
	}
	
	if($type == 'apps'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_gua1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_gua2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_gua3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_gua4}';
		}
	}
		
	if($type == 'groups'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_gro1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_gro2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_gro3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_gro4}';
		}
	}
	
	if($type == 'clubs'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_clu1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_clu2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_clu3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_clu4}';
		}
	}		
	
	if($type == 'public'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_pub1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_pub2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_pub3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_pub4}';
		}
	}
	
	if($type == 'votes'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_vot1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_vot2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_vot3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_vot4}';
		}
	}
	
	if($type == 'subscribers'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_sub1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_sub2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_sub3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_sub4}';
		}
	}
	
	if($type == 'subscribers2'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_sb1} <span id="traf2">'.$num.'</span> {translate=fun_sb21}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_sb2} <span id="traf2">'.$num.'</span> {translate=fun_sb22}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_sb3} <span id="traf2">'.$num.'</span> {translate=fun_sb23}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_sb4} <span id="traf2">'.$num.'</span> {translate=fun_sb24}';
		}
	}
	
	if($type == 'feedback'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_fed1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_fed2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_fed3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_fed4}';
		}
	}

	if($type == 'se_groups'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_seg1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_seg2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_seg3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_seg4}';
		}
	}
	
	if($type == 'se_clubs'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_sec1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_sec2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_sec3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_sec4}';
		}
	}

	if($type == 'news'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_new1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_new2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_new3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_new4}';
		}
	}	

	if($type == 'audio'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_aud1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_aud2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_aud3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_aud4}';
		}
	}
	
	if($type == 'links'){
		if($numres == 1){
			$gram_num_record = 'сслыка';
		} elseif($numres < 5){
			$gram_num_record = 'ссылки';
		} elseif($numres < 21){
			$gram_num_record = 'ссылок';
		} elseif($numres == 21){
			$gram_num_record = 'ссылка';
		}
	}

	if($type == 'video_views'){
		if($numres == 1){
			$gram_num_record = '{translate=fun_vvi1}';
		} elseif($numres < 5){
			$gram_num_record = '{translate=fun_vvi2}';
		} elseif($numres < 21){
			$gram_num_record = '{translate=fun_vvi3}';
		} elseif($numres == 21){
			$gram_num_record = '{translate=fun_vvi4}';
		}
	}
	
	return $gram_num_record;
}
function gramatikName($source){
	$name_u_gram = $source;
	$str_1_name = strlen($name_u_gram);
	$str_2_name = $str_1_name-2;
	$str_3_name = substr($name_u_gram, $str_2_name, $str_1_name);
	$str_5_name = substr($name_u_gram, 0, $str_2_name);
	$str_4_name = strtr($str_3_name,array(
					'ай' => 'ая',
					'ил' => 'ила',
					'др' => 'дра',
					'ей' => 'ея',
					'кс' => 'кса',
					'ша' => 'ши',
					'на' => 'ны',
					'ка' => 'ки',
					'ад' => 'ада',
					'ма' => 'мы',
					'ля' => 'ли',
					'ня' => 'ни',
					'ин' => 'ина',
					'ик' => 'ика',
					'ор' => 'ора',
					'им' => 'има',
					'ём' => 'ёма',
					'ий' => 'ия',
					'рь' => 'ря',
					'тя' => 'ти',
					'ся' => 'си',
					'из' => 'иза',
					'га' => 'ги',
					'ур' => 'ура',
					'са' => 'сы',
					'ис' => 'иса',
					'ст' => 'ста',
					'ел' => 'ла',
					'ав' => 'ава',
					'он' => 'она',
					'ра' => 'ры',
					'ан' => 'ана',
					'ир' => 'ира',
					'рд' => 'рда',
					'ян' => 'яна',
					'ов' => 'ова',
					'ла' => 'лы',
					'ия' => 'ии',
					'ва' => 'вой',
					'ыч' => 'ыча'
					));
	$name_user_gram = $str_5_name.$str_4_name;
	return $name_user_gram;
}

function gramatikName1($source){
	$name_u_gram = $source;
	$str_1_name = strlen($name_u_gram);
	$str_2_name = $str_1_name-2;
	$str_3_name = substr($name_u_gram, $str_2_name, $str_1_name);
	$str_5_name = substr($name_u_gram, 0, $str_2_name);
	$str_4_name = strtr($str_3_name,array(
					'ай' => 'аю',
					'ил' => 'илу',
					'др' => 'дру',
					'ей' => 'ею',
					'кс' => 'ксу',
					'ша' => 'ше',
					'на' => 'не',
					'ка' => 'ке',
					'ад' => 'аду',
					'ма' => 'ме',
					'ля' => 'ле',
					'ня' => 'не',
					'ин' => 'ину',
					'ик' => 'ику',
					'ор' => 'ору',
					'им' => 'иму',
					'ём' => 'ёму',
					'ий' => 'ия',
					'рь' => 'ря',
					'тя' => 'те',
					'ся' => 'се',
					'из' => 'иза',
					'га' => 'ге',
					'ур' => 'ура',
					'са' => 'сы',
					'ис' => 'иса',
					'ст' => 'ста',
					'ел' => 'лу',
					'ав' => 'аву',
					'он' => 'она',
					'ра' => 'ре',
					'ан' => 'ану',
					'ир' => 'иру',
					'рд' => 'рду',
					'ян' => 'яну',
					'ов' => 'ова',
					'ла' => 'ле',
					'ия' => 'ие',
					'ва' => 'вой',
					'ыч' => 'ычу'
					));
	$name_user_gram = $str_5_name.$str_4_name;
	return $name_user_gram;
}

function Hacking(){
	global $ajax, $lang;
	
	if($ajax){
		NoAjaxQuery();
		echo <<<HTML
<script type="text/javascript">
document.title = '{$lang['error']}';
document.getElementById('speedbar').innerHTML = '{$lang['error']}';
document.getElementById('page').innerHTML = '{$lang['no_notes']}';
</script>
HTML;
		die();
	} else
		return header('Location: /index.php?go=none');
}
function textFilter($source, $substr_num = false, $strip_tags = false){
	global $db;
	
	if(function_exists("get_magic_quotes_gpc") AND get_magic_quotes_gpc())
		$source = stripslashes($source);  
	
	$find = array('/data:/i', '/about:/i', '/vbscript:/i', '/onclick/i', '/onload/i', '/onunload/i', '/onabort/i', '/onerror/i', '/onblur/i', '/onchange/i', '/onfocus/i', '/onreset/i', '/onsubmit/i', '/ondblclick/i', '/onkeydown/i', '/onkeypress/i', '/onkeyup/i', '/onmousedown/i', '/onmouseup/i', '/onmouseover/i', '/onmouseout/i', '/onselect/i', '/javascript/i');
		
	$replace = array("d&#097;ta:", "&#097;bout:", "vbscript<b></b>:", "&#111;nclick", "&#111;nload", "&#111;nunload", "&#111;nabort", "&#111;nerror", "&#111;nblur", "&#111;nchange", "&#111;nfocus", "&#111;nreset", "&#111;nsubmit", "&#111;ndblclick", "&#111;nkeydown", "&#111;nkeypress", "&#111;nkeyup", "&#111;nmousedown", "&#111;nmouseup", "&#111;nmouseover", "&#111;nmouseout", "&#111;nselect", "j&#097;vascript");

	$source = preg_replace("#<iframe#i", "&lt;iframe", $source);
	$source = preg_replace("#<script#i", "&lt;script", $source);
		
	if(!$substr_num)
		$substr_num = 25000;

	$source = $db->safesql(myBr(htmlspecialchars(substr(trim($source), 0, $substr_num))));
	
	$source = str_ireplace("{", "&#123;", $source);
	$source = str_ireplace("`", "&#96;", $source);
	$source = str_ireplace("{theme}", "&#123;theme}", $source);
	
	$source = preg_replace($find, $replace, $source);
	
	if($strip_tags)
		$source = strip_tags($source);

	return $source;
}
function user_age($user_year, $user_month, $user_day){
	global $server_time;
	
	if($user_year){
		$current_year = date('Y', $server_time);
		$current_month = date('n', $server_time);
		$current_day = date('j', $server_time);
		
		$current_str = strtotime($current_year.'-'.$current_month.'-'.$current_day);
		$current_user = strtotime($current_year.'-'.$user_month.'-'.$user_day);

		if($current_str >= $current_user)
			$user_age = $current_year-$user_year;
		else
			$user_age = $current_year-$user_year-1;

		if($user_month AND $user_month AND $user_day)
			return $user_age.' '.gram_record($user_age, 'user_age');
		else
			return false;
	}
}
function megaDate($date, $func = false, $full = false){
	global $tpl, $server_time;

	$date_comm = $date;
	
	if(date('Y-m-d', $date_comm) == date('Y-m-d', $server_time))
		return $tpl->set('{date}', langdate('сегодня в H:i', $date_comm));
	elseif(date('Y-m-d', $date_comm) == date('Y-m-d', ($server_time-84600)))
		return $tpl->set('{date}', langdate('вчера в H:i', $date_comm));
	else
		if($func == 'no_year')
			return $tpl->set('{date}', langdate('j M в H:i', $date_comm));
		else
			if($full)
				return $tpl->set('{date}', langdate('j F Y в H:i', $date_comm));
			else
				return $tpl->set('{date}', langdate('j M Y в H:i', $date_comm));
}
function megaDateNoTpl($date, $func = false, $full = false){
	global $server_time;

	if(date('Y-m-d', $date) == date('Y-m-d', $server_time))
		return $date = langdate('сегодня в H:i', $date);
	elseif(date('Y-m-d', $date) == date('Y-m-d', ($server_time-84600)))
		return $date = langdate('вчера в H:i', $date);
	else
		if($func == 'no_year')
			return $date = langdate('j M в H:i', $date);
		else
			if($full)
				return $date = langdate('j F Y в H:i', $date);
			else
				return $date = langdate('j M Y в H:i', $date);
}
function OnlineTpl($time){
	global $tpl, $online_time, $lang;
	if($time >= $online_time)
		return $tpl->set('{online}', $lang['online']);
	else
		return $tpl->set('{online}', '');
}
function AjaxTpl(){
	global $tpl, $config;
	echo str_replace('{theme}', '/templates/'.$config['temp'], $tpl->result['info'].$tpl->result['content']);
}
function GenerateAlbumPhotosPosition($uid, $aid = false){
	global $db;
	
	//Автоматизация моб. верси
	if($_GET['act'] == 'change_mobile') $_SESSION['mobile'] = 1;
	if($_GET['act'] == 'change_fullver'){
	$_SESSION['mobile'] = 2;
	header('Location: /');
	}
	if(check_smartphone()){
	if($_SESSION['mobile'] != 2)
	$config['temp'] = "mobile";
	$check_smartphone = true;
	}
	if($_SESSION['mobile'] == 1){
	$config['temp'] = "mobile";
	}	
	
	//Выводим все фотографии из альбома и обновляем их позицию только для просмотра альбома
	if($uid AND $aid){
		$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS id FROM `".PREFIX."_photos` WHERE album_id = '{$aid}' ORDER by `position` ASC", 1);
		$count = 1;
		foreach($sql_ as $row){
			$db->query("UPDATE LOW_PRIORITY `".PREFIX."_photos` SET position = '{$count}' WHERE id = '{$row['id']}'");
			$photo_info .= $count.'|'.$row['id'].'||';
			$count++;
		}
		mozg_create_cache('user_'.$uid.'/position_photos_album_'.$aid, $photo_info);
	}
}
function GenerateAlbumPhotosPositionGroups($uid, $aid = false){
        global $db;
        
        //Выводим все фотографии из альбома и обновляем их позицию только для просмотра альбома
        if($uid AND $aid){
                $sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS id FROM `".PREFIX."_communities_photos` WHERE album_id = '{$aid}' ORDER by `position` ASC", 1);
                $count = 1;
                foreach($sql_ as $row){
                        $db->query("UPDATE LOW_PRIORITY `".PREFIX."_communities_photos` SET position = '{$count}' WHERE id = '{$row['id']}'");
                        $photo_info .= $count.'|'.$row['id'].'||';
                        $count++;
                }
                mozg_create_cache('user_'.$uid.'/position_photos_album_groups_'.$aid, $photo_info);
        }
}
function CheckFriends($friendId){
	global $user_info;
	
	$openMyList = mozg_cache("user_{$user_info['user_id']}/friends");

	if(stripos($openMyList, "u{$friendId}|") !== false)
		return true;
	else
		return false;
}
function CheckBlackList($userId){
	global $user_info;
	
	$openMyList = mozg_cache("user_{$userId}/blacklist");

	if(stripos($openMyList, "|{$user_info['user_id']}|") !== false)
		return true;
	else
		return false;
}
function MyCheckBlackList($userId){
	global $user_info;
	
	$openMyList = mozg_cache("user_{$user_info['user_id']}/blacklist");

	if(stripos($openMyList, "|{$userId}|") !== false)
		return true;
	else
		return false;
}
function check_ip($ips){
	$_IP = $_SERVER['REMOTE_ADDR'];
	$blockip = FALSE;
	if(is_array($ips)){
		foreach($ips as $ip_line){
			$ip_arr = rtrim($ip_line['ip']);
			$ip_check_matches = 0;
			$db_ip_split = explode(".", $ip_arr);
			$this_ip_split = explode(".", $_IP);
			for($i_i = 0; $i_i < 4; $i_i ++){
				if($this_ip_split[$i_i] == $db_ip_split[$i_i] or $db_ip_split[$i_i] == '*'){
					$ip_check_matches += 1;
				}
			}
			if($ip_check_matches == 4){
				$blockip = $ip_line['ip'];
				break;
			}
		}
	}
	return $blockip;
}
function gtypeNew($category = false){
	switch($category){
		case 0:return ""; break;
		case 1:return "Веб-сайт"; break;
		case 2:return "Интернет-магазин"; break;
		case 3:return "Образовательное учреждение"; break;
		case 4:return "СМИ"; break;
		case 5:return "Компания"; break;
		case 6:return "Организация"; break;
		case 7:return "Высокие технологии"; break;
		case 8:return "Искусство и развлечения"; break;
		case 9:return "Потребительские товары"; break;
		case 10:return "Экономика и финансы"; break;
	}
}
function convertMonth($month, $h = false){
	switch($month){
		case 0:return "Месяц:"; break;
		case 1:return "Января"; break;
		case 2:return "Февраля"; break;
		case 3:return "Марта"; break;
		case 4:return "Апреля"; break;
		case 5:return "Мая"; break;
		case 6:return "Июня"; break;
		case 7:return "Июля"; break;
		case 8:return "Августа"; break;
		case 9:return "Сентября"; break;
		case 10:return "Октября"; break;
		case 11:return "Ноября"; break;
		case 12:return "Декабря"; break;
	}
}
function russian_date($dt, $years = true){

	$date=explode(".", date('d.m.Y',$dt));
	
	switch ($date[1]){
		case 1: $m='января'; break;
		case 2: $m='февраля'; break;
		case 3: $m='марта'; break;
		case 4: $m='апреля'; break;
		case 5: $m='мая'; break;
		case 6: $m='июня'; break;
		case 7: $m='июля'; break;
		case 8: $m='августа'; break;
		case 9: $m='сентября'; break;
		case 10: $m='октября'; break;
		case 11: $m='ноября'; break;
		case 12: $m='декабря'; break;
	}
	if($years == true) $h = $date[2];
	else $h = '';
	return $date[0].'&nbsp;'.$m.'&nbsp;'.$h;
}
?>