<?php
/* 
	Appointment: ����� ���������� �����
	File: stats.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

echoheader();
echohtmlstart('����� ���������� �����');

$users = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users`");
$albums = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_albums`");
$attach = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_attach`");
$audio = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_audio`");
$groups = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities`");
$clubs = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_clubs`");
$groups_wall = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities_wall`");
$invites = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_invites`");
$notes = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_notes`");
$videos = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_videos`");

$db->query("SHOW TABLE STATUS FROM `".DBNAME."`");
$mysql_size = 0;
while ($r = $db->get_array()){
	if(strpos($r['Name'], PREFIX."_") !== false) 
		$mysql_size += $r['Data_length'] + $r['Index_length'];
}
$db->free();
$mysql_size = formatsize($mysql_size);

function dirsize($directory){
	if(!is_dir($directory)) return - 1;
	$size = 0;
	if($DIR = opendir($directory)){
		while(($dirfile = readdir($DIR)) !== false){
			if(@is_link($directory.'/'.$dirfile) || $dirfile == '.' || $dirfile == '..') continue;
			if(@is_file($directory.'/'.$dirfile)) $size += filesize($directory . '/' . $dirfile);
			else if(@is_dir($directory.'/'.$dirfile)){
				$dirSize = dirsize($directory.'/'.$dirfile);
				if($dirSize >= 0) $size += $dirSize;
				else return - 1;
			}
		}
		closedir( $DIR );
	}
	return $size;
}

$cache_size = formatsize(dirsize("uploads"));

echo <<<HTML

<div class="fllogall">������ ���� ������ MySQL:</div>
 <div style="margin-bottom:10px">{$mysql_size}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">������ ����� /uploads/:</div>
 <div style="margin-bottom:10px">{$cache_size}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">���������������� �������������:</div>
 <div style="margin-bottom:10px">{$users['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">���������� ��������� ��������:</div>
 <div style="margin-bottom:10px">{$albums['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">���������� ������������� ����:</div>
 <div style="margin-bottom:10px">{$attach['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">���������� ������������:</div>
 <div style="margin-bottom:10px">{$audio['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">���������� ���������:</div>
 <div style="margin-bottom:10px">{$groups['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">���������� ������� �� ������ ���������:</div>
 <div style="margin-bottom:10px">{$groups_wall['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">���������� ����������� �������������:</div>
 <div style="margin-bottom:10px">{$invites['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">���������� �������:</div>
 <div style="margin-bottom:10px">{$notes['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">���������� ������������:</div>
 <div style="margin-bottom:10px">{$videos['cnt']}&nbsp;</div>
<div class="mgcler"></div>

HTML;

echohtmlend();
?>