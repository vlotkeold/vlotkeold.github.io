<?php
/* 
	Appointment: ����� � ������
	File: search.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

//���� ������ ������
if(isset($_POST['save'])){
	if(function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()){
		$_POST['find'] = stripslashes($_POST['find']);
		$_POST['replace'] = stripslashes($_POST['replace']);
	} 

	$find = $db->safesql(addslashes(trim($_POST['find'])));
	$replace = $db->safesql(addslashes(trim($_POST['replace'])));
	
	if(isset($find) AND !empty($find) AND isset($replace) AND !empty($replace)){
		if($_POST['photo_comm']) $db->query("UPDATE `".PREFIX."_photos_comments` SET `text` = REPLACE(`text`, '".$find."', '".$replace."')");
		if($_POST['video_comm']) $db->query("UPDATE `".PREFIX."_videos_comments` SET `text` = REPLACE(`text`, '".$find."', '".$replace."')");
		if($_POST['notes_comm']) $db->query("UPDATE `".PREFIX."_notes_comments` SET `text` = REPLACE(`text`, '".$find."', '".$replace."')");
		if($_POST['users_wall']) $db->query("UPDATE `".PREFIX."_wall` SET `text` = REPLACE(`text`, '".$find."', '".$replace."')");
		if($_POST['groups_wall']) $db->query("UPDATE `".PREFIX."_communities_wall` SET `text` = REPLACE(`text`, '".$find."', '".$replace."')");
		if($_POST['news']) $db->query("UPDATE `".PREFIX."_news` SET `action_text` = REPLACE(`action_text`, '".$find."', '".$replace."')");
		if($_POST['msg']) $db->query("UPDATE `".PREFIX."_messages` SET `text` = REPLACE(`text`, '".$find."', '".$replace."')");
		if($_POST['gift_msg']) $db->query("UPDATE `".PREFIX."_gifts` SET `msg` = REPLACE(`msg`, '".$find."', '".$replace."')");
		if($_POST['notes_text']) $db->query("UPDATE `".PREFIX."_notes` SET `full_text` = REPLACE(`full_text`, '".$find."', '".$replace."')");
		
		msgbox('����������', '����� � ���� ������ ��� ������� �������.', '?mod=search');
	} else
		msgbox('������', '��� ���� ����������� � ����������', 'javascript:history.go(-1)');
} else {
	echoheader();
	
	echohtmlstart('������� ������ ������ � ���� ������ �������');
	echo <<<HTML
<style type="text/css" media="all">
.inpu{width:308px;}
textarea{width:300px;height:100px;}
</style>
������ ������� ���������� ������ ������ � ����� ����. �������� � ��� ��������� ����� � �� ������ ��� �������� � ������������, �������� � �.�.
<br /><br />
<b><font color="red">��������:</b> ����� ������� �� �������� ������� ��������� ����� ���� ������, �.�. ������ �������� � ������ ������������ ��� �� ������ ��������� ������, ���������� ����� ��������. �� ������������ �� ����������� ����������� ������ �������� ���� ��� ���������, �.�. ��� ����� ����������� � ������� ������ ����.</font>

<form method="POST" action="" style="margin-top:15px">
<div class="mgcler"></div>

<div class="fllogall">��� ��������:</div>

 <input type="checkbox" name="photo_comm" style="margin-bottom:10px" /> � ������������ � �����������<br />
 <input type="checkbox" name="video_comm" style="margin-bottom:10px;margin-left:286px" /> � ������������ � ������������<br />
 <input type="checkbox" name="notes_comm" style="margin-bottom:10px;margin-left:286px" /> � ������������ � ��������<br />
 <input type="checkbox" name="users_wall" style="margin-bottom:10px;margin-left:286px" /> �� ������ �������������<br />
 <input type="checkbox" name="groups_wall" style="margin-bottom:10px;margin-left:286px" /> �� ������ ���������<br />
 <input type="checkbox" name="news" style="margin-bottom:10px;margin-left:286px" /> � ����� ��������<br />
 <input type="checkbox" name="msg" style="margin-bottom:10px;margin-left:286px" /> � ������������ ����������<br />
 <input type="checkbox" name="gift_msg" style="margin-bottom:10px;margin-left:286px" /> � ���������� � ��������<br />
 <input type="checkbox" name="notes_text" style="margin-bottom:10px;margin-left:286px" /> � ����������� �������<br />
 
<div class="mgcler"></div>

<div class="fllogall">������� ������ �����:</div><textarea class="inpu" name="find"></textarea><div class="mgcler"></div>

<div class="fllogall">������� ����� �����:</div><textarea class="inpu" name="replace"></textarea><div class="mgcler"></div>

<div class="fllogall">&nbsp;</div><input type="submit" value="���������� ������" name="save" class="inp" style="margin-top:0px" />

</form>
HTML;

	echohtmlend();
}
?>