<?php
/* 
	Appointment: ������
	File: city.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

//����������
if(isset($_POST['add'])){
	$country = intval($_POST['country']);
	$city = textFilter($_POST['city'], false, true);
	if(isset($city) AND !empty($city) AND $country){
		$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_city` WHERE name = '".$city."' AND id_country = '".$country."'");
		if(!$row['cnt']){
			$db->query("INSERT INTO `".PREFIX."_city` SET name = '".$city."', id_country = '".$country."'");
			system_mozg_clear_cache_file('country_city_'.$country);
			msgbox('����������', '����� ������� ��������', '?mod=city');
		} else
			msgbox('������', '����� ����� ��� ��������', 'javascript:history.go(-1)');
	} else
		msgbox('������', '��� ���� ������������', 'javascript:history.go(-1)');
	
	die();
}

//��������
if($_GET['act'] == 'del'){
	$id = intval($_GET['id']);
	$row = $db->super_query("SELECT id_country FROM `".PREFIX."_city` WHERE id = '".$id."'");
	if($row){
		$db->query("DELETE FROM `".PREFIX."_city` WHERE id = '".$id."'");
		system_mozg_clear_cache_file('country_city_'.$row['id_country']);
		header("Location: ?mod=city&country=".$row['id_country']);
	}
	die();
}

$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS * FROM `".PREFIX."_country` ORDER by `name` ASC", 1);
foreach($sql_ as $row){
	$row['name'] = stripslashes($row['name']);
	$countryes .= <<<HTML
<div style="margin-bottom:5px;border-bottom:1px dashed #ccc;padding-bottom:5px">&raquo;&nbsp; <a href="?mod=city&country={$row['id']}" style="font-size:13px"><b>{$row['name']}</b></a></div>
HTML;
	$all_country .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
	if($_GET['country'] == $row['id'])
		$pref = $row['name'];
}

echoheader();
echohtmlstart('���������� ������');
	
echo <<<HTML
<form method="POST" action="">
������� �������� ������: &nbsp;&nbsp; <input style="width:150px" type="text" class="inpu" name="city" /> &nbsp;<select name="country" class="inpu" style="width:150px"><option value="">- ������� ������ -</option>{$all_country}</select>
<input type="submit" value="��������" name="add" class="inp" style="margin-top:0px" />
</form>
HTML;

//���� ������ �� ����� �������
if($_GET['country']){
	echohtmlstart('������ ������: '.$pref);
	$ncountry_id = intval($_GET['country']);
	$sql_c = $db->super_query("SELECT SQL_CALC_FOUND_ROWS id, name FROM `".PREFIX."_city` WHERE id_country = '".$ncountry_id."'", 1);
	foreach($sql_c as $row_c){
		$row_c['name'] = stripslashes($row_c['name']);
		$cites .= <<<HTML
<div style="margin-bottom:5px;border-bottom:1px dashed #ccc;padding-bottom:5px">&raquo;&nbsp; <span style="font-size:13px"><b>{$row_c['name']}</b></span> &nbsp; <span style="color:#777">[ <a href="?mod=city&act=del&id={$row_c['id']}" style="color:#777">�������</a> ]</span></div>
HTML;
	}
	echo $cites.'<input type="submit" value="�����" class="inp" style="margin-top:0px" onClick="history.go(-1); return false" />';
} else {
	echohtmlstart('�������� ������, � ������� ������ ����������� ������:');
	echo $countryes;
}

echohtmlend();
?>