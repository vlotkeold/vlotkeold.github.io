<?php
/* 
	Appointment: �������
	File: gifts.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

//���� ������ "��������"
if(isset($_POST['save'])){
	$textn = intval($_POST['text']);
	$author = intval($_POST['author']);

	//�������� ����, ������ ������ �� ����������
	if($textn){
					$db->query("INSERT INTO `".PREFIX."_dev_news` SET text = '".$textn."', author = '".$author."', date = '".$server_time."'");
					msgbox('����������', '������� ������� ���������', '?mod=devnews');
	} else
		msgbox('������', '�������� �������', 'javascript:history.go(-1)');
	
	die();
}

//��������
if($_GET['act'] == 'deleted'){
	$id = intval($_GET['id']);
	$row = $db->super_query("SELECT text FROM `".PREFIX."_dev_news` WHERE id = '".$id."'");
	if($row){
		$db->query("DELETE FROM `".PREFIX."_dev_news` WHERE id = '".$id."'");
		header('Location: ?mod=devnews');
	}
}

echoheader();

$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_dev_news`");

$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS * FROM `".PREFIX."_dev_news` ORDER by `id` DESC", 1);
foreach($sql_ as $row){
	$news .= <<<HTML
<b>�����:</b> {$row['author']}<br>
<b>����:</b> <br>{$row['text']}
<a href="?mod=news&act=deleted&id={$row['id']}"><div style="float:right">�������</div></a>
<div style="margin: 3px 0px;height: 1px;overflow: hidden;background: #E7EAED;"></div>
<br />
HTML;
}

echohtmlstart('���������� �������');
			
echo <<<HTML
<style type="text/css" media="all">
.inpu{width:50px;}
textarea{width:450px;height:400px;}
</style>

<form action="" enctype="multipart/form-data" method="POST">

<input type="hidden" name="mod" value="notes" />

<div class="fllogall" style="width:180px">�����:</div>
 <input type="text" name="author" class="inpu" style="width:380px"/>
<div class="mgcler"></div>

<div class="fllogall" style="width:180px">�����:</div>
 <textarea type="text" name="textn" class="inpu" style="width:380px"></textarea>
<div class="mgcler"></div>

<div class="fllogall" style="width:180px">&nbsp;</div>
 <input type="submit" value="��������" class="inp" name="save" style="margin-top:0px" />
</form>
HTML;

echohtmlstart('������� ('.$numRows['cnt'].')');

echo <<<HTML
{$news}
<div class="clr"></div>
HTML;

echohtmlend();
?>