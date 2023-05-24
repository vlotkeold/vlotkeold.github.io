<?php
/* 
	Appointment: Вакансии
	File: jobs.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

//Удаление
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
<b>Вакансия:</b> {$row['namejob']}<br>
<b>Номер вакансии:</b> {$row['id']}<br>
<b>Автор:</b> {$row['name']}<br>
<b>Телефон:</b> {$row['phone']}<br>
<b>Почта:</b> <a href="mailto:{$row['email']}">{$row['email']}</a><br>
<b>О себе и своем опыте:</b><br>
{$row['description']}
<a href="?mod=jobs&act=deleted&id={$row['id']}"><div style="float:right">Удалить</div></a>
<div style="margin: 3px 0px;height: 1px;overflow: hidden;background: #E7EAED;"></div>
<br />
HTML;
}

echohtmlstart('Вакансии ('.$numRows['cnt'].')');

echo <<<HTML
{$jobs}
<div class="clr"></div>
HTML;

echohtmlend();
?>