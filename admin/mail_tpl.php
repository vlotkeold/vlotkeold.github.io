<?php
/* 
	Appointment: ������� ���������
	File: mail_tpl.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

	
if(isset($_POST['save'])){
	$find = array ("<", ">");
	$replace = array ("&lt;", "&gt;");
	for($i = 1; $i <= 8; $i++){
		$post = $db->safesql(str_replace($find, $replace, $_POST[$i]));
		$db->query("UPDATE `".PREFIX."_mail_tpl` SET text = '".$post."' WHERE id = '".$i."'");
	}
}

$row1 = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '1'");
$row2 = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '2'");
$row3 = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '3'");
$row4 = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '4'");
$row5 = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '5'");
$row6 = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '6'");
$row7 = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '7'");
$row8 = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '8'");

echoheader();
	
echo <<<HTML
<style type="text/css" media="all">
.inpu{width:590px;height:150px;margin-top:5px}
</style>
<form method="POST" action="">
HTML;

echohtmlstart('1. ��������� E-Mail ���������, ������� ���������� ��� ����� ������ � ������');
echo <<<HTML
<b>{%user%}</b> &nbsp;-&nbsp; ��� ������������ �������� ������������� ����������<br />
<b>{%user-friend%}</b> &nbsp;-&nbsp; ������������ ������� �������� ������ �� ������
<textarea class="inpu" name="1">{$row1['text']}</textarea>
HTML;
		
echohtmlstart('2. ��������� E-Mail ���������, ������� ���������� ��� ������ �� ������');
echo <<<HTML
<b>{%user%}</b> &nbsp;-&nbsp; ��� ������������ �������� ������������� ����������<br />
<b>{%user-friend%}</b> &nbsp;-&nbsp; ������������ ������� �������<br />
<b>{%rec-link%}</b> &nbsp;-&nbsp; ������ �� ������
<textarea class="inpu" name="2">{$row2['text']}</textarea>
HTML;
		
echohtmlstart('3. ��������� E-Mail ���������, ������� ���������� ��� ����� ����������� � �����');
echo <<<HTML
<b>{%user%}</b> &nbsp;-&nbsp; ��� ������������ �������� ������������� ����������<br />
<b>{%user-friend%}</b> &nbsp;-&nbsp; ������������ ������� ������� �����������<br />
<b>{%rec-link%}</b> &nbsp;-&nbsp; ������ �� �����������
<textarea class="inpu" name="3">{$row3['text']}</textarea>
HTML;
		
echohtmlstart('4. ��������� E-Mail ���������, ������� ���������� ��� ����� ����������� � ����');
echo <<<HTML
<b>{%user%}</b> &nbsp;-&nbsp; ��� ������������ �������� ������������� ����������<br />
<b>{%user-friend%}</b> &nbsp;-&nbsp; ������������ ������� ������� �����������<br />
<b>{%rec-link%}</b> &nbsp;-&nbsp; ������ �� ����������
<textarea class="inpu" name="4">{$row4['text']}</textarea>
HTML;
HTML;
		
echohtmlstart('5. s��������� E-Mail ���������, ������� ���������� ��� ����� ����������� � �������');
echo <<<HTML
<b>{%user%}</b> &nbsp;-&nbsp; ��� ������������ �������� ������������� ����������<br />
<b>{%user-friend%}</b> &nbsp;-&nbsp; ������������ ������� ������� �����������<br />
<b>{%rec-link%}</b> &nbsp;-&nbsp; ������ �� �������
<textarea class="inpu" name="5">{$row5['text']}</textarea>
HTML;
		
echohtmlstart('6. ��������� E-Mail ���������, ������� ���������� ��� ����� �������');
echo <<<HTML
<b>{%user%}</b> &nbsp;-&nbsp; ��� ������������ �������� ������������� ����������<br />
<b>{%user-friend%}</b> &nbsp;-&nbsp; ������������ ������� �������� �������<br />
<b>{%rec-link%}</b> &nbsp;-&nbsp; ������ �� �������
<textarea class="inpu" name="6">{$row6['text']}</textarea>
HTML;
		
echohtmlstart('7. ��������� E-Mail ���������, ������� ���������� ��� ����� ������ �� �����');
echo <<<HTML
<b>{%user%}</b> &nbsp;-&nbsp; ��� ������������ �������� ������������� ����������<br />
<b>{%user-friend%}</b> &nbsp;-&nbsp; ������������ ������� ������� ������<br />
<b>{%rec-link%}</b> &nbsp;-&nbsp; ������ �� ������
<textarea class="inpu" name="7">{$row7['text']}</textarea>
HTML;
		
echohtmlstart('8. ��������� E-Mail ���������, ������� ���������� ��� ����� ������������ ���������');
echo <<<HTML
<b>{%user%}</b> &nbsp;-&nbsp; ��� ������������ �������� ������������� ����������<br />
<b>{%user-friend%}</b> &nbsp;-&nbsp; ������������ ������� �������� ���������<br />
<b>{%rec-link%}</b> &nbsp;-&nbsp; ������ �� ���������
<textarea class="inpu" name="8">{$row8['text']}</textarea>
HTML;
HTML;

echo <<<HTML
<input type="submit" value="���������" name="save" class="inp" style="margin-top:5px" />
</form>
HTML;

echohtmlend();
?>