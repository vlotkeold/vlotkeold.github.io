<?php
/* 
	Appointment: ����������� ��������
	File: static.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

//���� ������ ������
if(isset($_POST['save'])){
	//���������� ������
	include_once ENGINE_DIR.'/classes/parse.php';
	$parse = new parse();
			
	$title = textFilter($_POST['title'], false, true);
	$alt_name = totranslit($_POST['alt_name']);
	$text = $parse->BBparse(textFilter($_POST['text']));
	
	if(isset($title) AND !empty($title) AND isset($text) AND !empty($text) AND isset($alt_name) AND !empty($alt_name)){
		$db->query("INSERT INTO `".PREFIX."_static` SET alt_name = '".$alt_name."', title = '".$title."', text = '".$text."'");
		header("Location: ?mod=static");
	} else
		msgbox('������', '��� ���� ����������� � ����������', 'javascript:history.go(-1)');
} else {
	//��������
	if($_GET['act'] == 'del'){
		$id = intval($_GET['id']);
		$db->query("DELETE FROM `".PREFIX."_static` WHERE id = '".$id."'");
		header("Location: ?mod=static");
	}
	
	//��������������
	if($_GET['act'] == 'edit'){
		$id = intval($_GET['id']);
		$row = $db->super_query("SELECT title, alt_name, text FROM `".PREFIX."_static` WHERE id = '".$id."'");
		if($row){
		
			//���������
			if(isset($_POST['save_edit'])){
				//���������� ������
				include_once ENGINE_DIR.'/classes/parse.php';
				$parse = new parse();
						
				$title = textFilter($_POST['title'], false, true);
				$alt_name = totranslit($_POST['alt_name']);
				$text = $parse->BBparse(textFilter($_POST['text']));
				
				if(isset($title) AND !empty($title) AND isset($text) AND !empty($text) AND isset($alt_name) AND !empty($alt_name)){
					$db->query("UPDATE`".PREFIX."_static` SET alt_name = '".$alt_name."', title = '".$title."', text = '".$text."' WHERE id = '".$id."'");
					header("Location: ?mod=static");
				} else
					msgbox('������', '��� ���� ����������� � ����������', 'javascript:history.go(-1)');
					
				die();
			}
			
			echoheader();
			
			$row['title'] = stripslashes($row['title']);
			
			//���������� ������
			include_once ENGINE_DIR.'/classes/parse.php';
			$parse = new parse();
	
			$row['text'] = $parse->BBdecode(myBrRn(stripslashes($row['text'])));
			
			echohtmlstart('�������������� ��������');
			echo <<<HTML
<form method="POST" action="">

<style type="text/css" media="all">
.inpu{width:458px;}
textarea{width:300px;height:300px;}
</style>

<div class="fllogall" style="width:130px">���������:</div><input class="inpu" type="text" name="title" value="{$row['title']}" /><div class="mgcler"></div>

<div class="fllogall" style="width:130px">�����: (�������� <b>test</b>):</div><input class="inpu" type="text" name="alt_name" value="{$row['alt_name']}" /><div class="mgcler"></div>

<div class="fllogall" style="width:130px">�����:</div><textarea class="inpu" name="text">{$row['text']}</textarea><div class="mgcler"></div>

<div class="fllogall" style="width:130px">&nbsp;</div>
 <input type="submit" value="���������" name="save_edit" class="inp" style="margin-top:0px" />
 <input type="submit" value="�����" class="inp" style="margin-top:0px" onClick="history.go(-1); return false" />


</form>
HTML;
			echohtmlend();
		} else
			msgbox('����������', '�������� �� �������', '?mod=static');
		
		die();
	}
	
	echoheader();
	
	echohtmlstart('�������� ����� ��������');
	echo <<<HTML
<form method="POST" action="">

<style type="text/css" media="all">
.inpu{width:458px;}
textarea{width:300px;height:300px;}
</style>

<div class="fllogall" style="width:130px">���������:</div><input class="inpu" type="text" name="title" /><div class="mgcler"></div>

<div class="fllogall" style="width:130px">�����: (�������� <b>test</b>):</div><input class="inpu" type="text" name="alt_name" /><div class="mgcler"></div>

<div class="fllogall" style="width:130px">�����:</div><textarea class="inpu" name="text"></textarea><div class="mgcler"></div>

<div class="fllogall" style="width:130px">&nbsp;</div><input type="submit" value="�������" name="save" class="inp" style="margin-top:0px" />

</form>
HTML;
	
	echohtmlstart('������ ����������� �������');
	
	$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS id, title, alt_name FROM `".PREFIX."_static` ORDER by `id` DESC", 1);
	foreach($sql_ as $row){
		$row['title'] = stripslashes($row['title']);
		$static_list .= <<<HTML
<div style="margin-bottom:5px;border-bottom:1px dashed #ccc;padding-bottom:5px">&raquo; <a href="?mod=static&act=edit&id={$row['id']}" style="font-size:13px"><b>{$row['title']}</b></a> &nbsp; <span style="color:#777">[ <a href="?mod=static&act=del&id={$row['id']}" style="color:#777">�������</a> ] [ <a href="/{$row['alt_name']}.html" target="_blank" style="color:#777">��������</a> ]</span></div>
HTML;
	}
	
	echo $static_list;
	
	echohtmlend();
}
?>