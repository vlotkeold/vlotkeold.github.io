<?php
/* 
	Appointment: ���������� ��
	File: db.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if(isset($_POST['action']) AND count($_REQUEST['ta'])){
	$arr = $_REQUEST['ta'];
	reset($arr);
	
	$tables = "";
	
	while(list($key, $val) = each($arr)){
		$tables .= ", `" . $db->safesql( $val ) . "`";
	}
	
	$tables = substr($tables, 1);
	
	if($_REQUEST['whattodo'] == "optimize"){
		$query = "OPTIMIZE TABLE  ";
	} else {
		$query = "REPAIR TABLE ";
	}
	$query .= $tables;
	
	$db->query($query);
	
	msgbox('����������', '��������� �������� ������� ���������', '?mod=db');
		
	exit;
}

echoheader();
echohtmlstart('���������� ��������� �����');

echo <<<HTML
<script type="text/javascript" src="/admin/js/jquery.js"></script>
<script type="text/javascript">
function save(){
	var rndval = new Date().getTime(); 
	$("#progress").html("<iframe width='99%' height='220' src='/adminpanel.php?mod=dumper&action=backup&comp_method=" + $("#comp_method").val() + "&rndval=" + rndval + "' frameborder='0' marginwidth='0' marginheight='0' scrolling='no'></iframe>");
}
function dbload(){
	var rndval = new Date().getTime(); 
	$("#progress2").html("<iframe width='99%' height='220' src='/adminpanel.php?mod=dumper&action=restore&file=" + $("#file").val() + "&rndval=" + rndval + "' frameborder='0' marginwidth='0' marginheight='0' scrolling='no'></iframe>");
}
</script>
�������� ����� ������ ���� ������: <select name="comp_method" id="comp_method" class="inpu"><OPTION VALUE='1'>GZip<OPTION VALUE='0' SELECTED>��� ������</select>
<input type="submit" value="���������" name="saveconf" class="inp" style="margin-top:0px" onClick="save(); return false;" />
<div id="progress"></div>
HTML;

echohtmlstart('�������� ��������� ����� � �����');

function fn_select($items, $selected){
	$select = '';
	foreach ($items as $key => $value){
		$select .= $key == $selected ? "<OPTION VALUE='{$key}' SELECTED>{$value}" : "<OPTION VALUE='{$key}'>{$value}";
	}
	return $select;
}

define('PATH', 'backup/');

function file_select(){
	$files = array('');
	if(is_dir(PATH) AND $handle = opendir(PATH)){
		while(false !== ($file = readdir($handle))){
			if(preg_match("/^.+?\.sql(\.(gz|bz2))?$/", $file)){
				$files[$file] = $file;
			}
		}
		closedir($handle);
	}
	return $files;
}

$files = fn_select(file_select(), '');

echo <<<HTML
�������� ��������� ����� ���� ������: <select name="file" id="file" class="inpu">{$files}</select>
<input type="submit" value="������������ ��" name="saveconf" class="inp" style="margin-top:0px" onClick="dbload(); return false;" />
<div id="progress2"></div>
HTML;

echohtmlstart('��������� � ����������� ���� ������');

$tabellen = "";
$db->query("SHOW TABLES");
while($row = $db->get_array()){

	$titel = $row[0];
	
	if(substr($titel, 0, strlen(PREFIX)) == PREFIX){
		$tabellen .= "<option value=\"$titel\" selected>$titel</option>\n";
	}

}
$db->free();

echo <<<HTML
<form method="POST" action="">
<select style="width:240px;height:230px;margin-right:10px;float:left" size="7" name="ta[]" class="inpu" multiple="multiple">{$tabellen}</select> 

<input type="radio" name="whattodo" style="margin-right:5px" value="optimize" checked /><b>����������� ���� ������</b><br />
<div style="margin-left:273px;margin-bottom:15px">�� ������ ���������� ����������� ���� ������, ��� ����� ����� ����������� ������� ����� �� �����, � ����� �������� ������ ���� ������. ������������� ������������ ������ ������� ������� ���� ��� � ������.</div>

<input type="radio" name="whattodo" style="margin-right:5px" /><b>������ ���� ������</b><br />
<div style="margin-left:273px;">��� ����������� ��������� MySQL �������, �� ����� ���������� �����-���� ��������, ����� ��������� ����������� ��������� ������, ������������� ���� ������� ������� ������ ��� ��� ��������.</div>

<input type="submit" value="�������� ��������" name="action" class="inp" style="margin-top:10px;margin-left:21px" />
</form>
HTML;

echohtmlend();
?>