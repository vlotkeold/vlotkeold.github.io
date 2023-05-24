<?php
/* 
	Appointment: ������ ��: IP, E-Mail
	File: ban.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

//���� ���������
if(isset($_POST['save'])){
	$ban_date = intval($_POST['days']);
	$this_time = $ban_date ? $server_time + ($ban_date * 60 * 60 * 24) : 0;
	if($this_time) $always = 1; else $always = 0;
	if(isset($_POST['ip'])) $ip = $db->safesql(htmlspecialchars(strip_tags(trim($_POST['ip'])))); else $ip = "";
	$descr = textFilter($_POST['descr']);
	
	if($ip){
		$row = $db->super_query("SELECT id FROM `".PREFIX."_banned` WHERE ip ='".$ip."'");
		if($row){
			msgbox('������', '���� IP ��� �������� ��� ������', '?mod=ban');
		} else {
			$db->query("INSERT INTO `".PREFIX."_banned` SET descr = '".$descr."', date = '".$this_time."', always = '".$always."', ip = '".$ip."'");
			@unlink(ENGINE_DIR.'/cache/system/banned.php');
			header("Location: ?mod=ban");
		}
	} else
		msgbox('������', '������� IP ������� ����� �������� ��� ������', 'javascript:history.go(-1)');
} else {
	echoheader();
	
	//�������������
	if($_GET['act'] == 'unban'){
		$id = intval($_GET['id']);
		$db->query("DELETE FROM `".PREFIX."_banned` WHERE id = '".$id."'");
		@unlink(ENGINE_DIR.'/cache/system/banned.php');
		header("Location: ?mod=ban");
	}
	
	echohtmlstart('���������� � ������ IP ������');
	echo <<<HTML
<style type="text/css" media="all">
.inpu{width:308px;}
textarea{width:300px;height:100px;}
</style>

�� ������ ��������������� ������ ��������, ����� ������������� ������������ IP ������. ��� ����� IP ������, �� ������ �� ���� ������� IP ��� ������� ����������� ���������, � �� ������ ��� �����������.
<br /><br />
<b>����������:</b> �� ������ ��������������� � ������� �������� ��������� * ��� ����������� � IP ����� ��� ����������� ����� (��������: 127.0.*.*).

<form method="POST" action="" style="margin-top:15px">

<div class="fllogall">IP:</div><input type="text" name="ip" class="inpu" value="{$row['user_email']}" /><div class="mgcler"></div>

<div class="fllogall">���������� ���� ����������:<br /><small><b>0</b> ����������� �� �������.</small></div><input type="text" name="days" class="inpu" value="{$row['user_name']}" /><div class="mgcler"></div>

<div class="fllogall">������� ����������:</div><textarea class="inpu" name="descr"></textarea><div class="mgcler"></div>

<div class="fllogall">&nbsp;</div><input type="submit" value="���������" name="save" class="inp" style="margin-top:0px" />

</form>
HTML;

	echohtmlstart('������ ��������������� IP �������');
	
	$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS id, descr, date, ip FROM `".PREFIX."_banned` ORDER by `id` DESC", 1);
	if($sql_){
		foreach($sql_ as $row){
			if($row['date'])
				$row['date'] = langdate('j F Y � H:i', $row['date']);
			else
				$row['date'] = '�������������';
				
			$row['descr'] = stripslashes($row['descr']);
			$short = substr(strip_tags($row['descr']), 0, 50).'..';
			$row['descr'] = myBrRn($row['descr']);
			
			$banList .= <<<HTML
<div style="background:#fff;float:left;padding:5px;width:150px;text-align:center;border-bottom:1px dashed #ccc">{$row['ip']}</div>
<div style="background:#fff;float:left;padding:5px;width:130px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc">{$row['date']}</div>
<div style="background:#fff;float:left;padding:5px;width:177px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc" title="{$row['descr']}">{$short}</div>
<div style="background:#fff;float:left;padding:5px;width:100px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc"><a href="?mod=ban&act=unban&id={$row['id']}">��������������</a></div>
HTML;
		}
	} else
		$banList = '<center><b>������ ����</b></center>';
		
	echo <<<HTML
<div style="background:#f0f0f0;float:left;padding:5px;width:150px;text-align:center;font-weight:bold;margin-top:-5px">IP</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:130px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">���� ��������� ����</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:177px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">������� ����</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:100px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">��������</div>
{$banList}
HTML;

	echohtmlend();
}
?>