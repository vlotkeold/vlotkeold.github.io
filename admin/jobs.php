<?php
/* 
	Appointment: ��������
	File: jobs.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

//��������
if($_GET['act'] == 'deleted'){
	$id = intval($_GET['id']);
	$row = $db->super_query("SELECT SQL_CALC_FOUND_ROWS * FROM `".PREFIX."_jobs` WHERE id = '".$id."'");
	if($row){
		$db->query("DELETE FROM `".PREFIX."_jobs` WHERE id = '".$id."'");
		$db->query("DELETE FROM `".PREFIX."_job` WHERE id = '".$id."'");
		header('Location: ?mod=jobs');
	}
}	
	
echoheader();

$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_job`");

$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS * FROM `".PREFIX."_jobs` ORDER by `id` DESC", 1);
foreach($sql_ as $row){
	$jobs .= <<<HTML
<b>��������:</b> {$row['namejob']}<br>
<b>����� ��������:</b> {$row['id']}<br>
<b>�����:</b> {$row['name']}<br>
<b>�������:</b> {$row['phone']}<br>
<b>�����:</b> <a href="mailto:{$row['email']}">{$row['email']}</a><br>
<b>� ���� � ����� �����:</b><br>
{$row['description']}
<a href="?mod=jobs&act=deleted&id={$row['id']}"><div style="float:right">�������</div></a>
<div style="margin: 3px 0px;height: 1px;overflow: hidden;background: #E7EAED;"></div>
<br />
HTML;
}

echohtmlstart('�������� ('.$numRows['cnt'].')');

echo <<<HTML
{$jobs}
<div class="clr"></div>
HTML;

echohtmlend();
?>