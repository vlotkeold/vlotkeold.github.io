<?php
/* 
	Appointment: ������
	File: country.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

//����������
if(isset($_POST['add'])){
	$country = textFilter($_POST['country'], false, true);
	if(isset($country) AND !empty($country)){
		$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_country` WHERE name = '".$country."'");
		if(!$row['cnt']){
			$db->query("INSERT INTO `".PREFIX."_country` SET name = '".$country."'");
			system_mozg_clear_cache_file('country');
			msgbox('����������', '������ ������� ���������', '?mod=country');
		} else
			msgbox('������', '����� ������ ��� ���������', 'javascript:history.go(-1)');
	} else
		msgbox('������', '������� �������� ��������', 'javascript:history.go(-1)');
	
	die();
}

//��������
if($_GET['act'] == 'del'){
	$id = intval($_GET['id']);
	$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_country` WHERE id = '".$id."'");
	if($row['cnt']){
		$db->query("DELETE FROM `".PREFIX."_country` WHERE id = '".$id."'");
		system_mozg_clear_cache_file('country');
		header("Location: ?mod=country");
	}
	die();
}

$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS * FROM `".PREFIX."_country` ORDER by `name` ASC", 1);
foreach($sql_ as $row){
	$countryes .= <<<HTML
<div style="margin-bottom:5px;border-bottom:1px dashed #ccc;padding-bottom:5px">&raquo;&nbsp; <span style="font-size:13px"><b>{$row['name']}</b></span> &nbsp; <span style="color:#777">[ <a href="?mod=country&act=del&id={$row['id']}" style="color:#777">�������</a> ]</span></div>
HTML;
}

echoheader();
echohtmlstart('���������� ������');

echo <<<HTML
<form method="POST" action="">
������� �������� ������: &nbsp;&nbsp;<input type="text" class="inpu" name="country" />
<input type="submit" value="��������" name="add" class="inp" style="margin-top:0px" />
</form>
HTML;

echohtmlstart('������ �����');

echo <<<HTML
{$countryes}
HTML;

echohtmlend();
?>