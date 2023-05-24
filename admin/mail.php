<?php
/* 
	Appointment: �������� �������� ���������
	File: mail.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');
	
$act = $_GET['act'];

switch($act){

	//################### ������ �������� ###################//
	case "send":
		$limit = intval($_POST['limit']);
		$lastid = intval($_POST['lastid']);
		$title = textFilter(ajax_utf8($_POST['title']), false, true);
		$_POST['text'] = ajax_utf8($_POST['text']);
		
		$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS user_search_pref, user_email FROM `".PREFIX."_users` ORDER by `user_id` ASC LIMIT ".$lastid.", ".$limit, 1);
		
		if($sql_){
			include_once ENGINE_DIR.'/classes/mail.php';
			$mail = new dle_mail($config, true);
			
			foreach($sql_ as $row){
				$find = array ('/data:/i', '/about:/i', '/vbscript:/i', '/onclick/i', '/onload/i', '/onunload/i', '/onabort/i', '/onerror/i', '/onblur/i', '/onchange/i', '/onfocus/i', '/onreset/i', '/onsubmit/i', '/ondblclick/i', '/onkeydown/i', '/onkeypress/i', '/onkeyup/i', '/onmousedown/i', '/onmouseup/i', '/onmouseover/i', '/onmouseout/i', '/onselect/i', '/javascript/i', '/javascript/i' );
				$replace = array ("d&#097;ta:", "&#097;bout:", "vbscript<b></b>:", "&#111;nclick", "&#111;nload", "&#111;nunload", "&#111;nabort", "&#111;nerror", "&#111;nblur", "&#111;nchange", "&#111;nfocus", "&#111;nreset", "&#111;nsubmit", "&#111;ndblclick", "&#111;nkeydown", "&#111;nkeypress", "&#111;nkeyup", "&#111;nmousedown", "&#111;nmouseup", "&#111;nmouseover", "&#111;nmouseout", "&#111;nselect", "j&#097;vascript" );

				$message_send = preg_replace($find, $replace, $_POST['text']);
				$message_send = preg_replace("#<iframe#i", "&lt;iframe", $message_send);
				$message_send = preg_replace("#<script#i", "&lt;script", $message_send);
				$message_send = str_replace("<?", "&lt;?", $message_send);
				$message_send = str_replace("?>", "?&gt;", $message_send);
				$message_send = $db->safesql($message_send);
				$message_send = str_replace("{%user-name%}", $row['user_search_pref'], $_POST['text']);
				
				$mail->send($row['user_email'], $title, $message_send);
				
				echo 'ok';
			}
		}

		die();
	break;
	
	default:
		$users = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users`"); 
		if($users['cnt'] < 20)
			$max_users = $users['cnt'];
		else
			$max_users = 20;

		echoheader();
		
		echo '<div id="form">';
		echohtmlstart('���������� � �������� ���������');
	
		echo <<<HTML
<style type="text/css" media="all">
.inpu{width:305px;}
textarea{width:600px;height:300px;}
</style>
<script type="text/javascript" src="/admin/js/jquery.js"></script>
<script type="text/javascript">
function mailSend(){
	var limit = $('#limit').val();
	var title = $('#title').val();
	var text = $('#text').val();
	var interval = parseInt($('#interval').val())*1000;
	var lastid = $('#lastlimit').val();
	if(lastid != 'finish'){
		if(title != 0){
			if(text != 0){
				$('#form').hide();
				document.getElementById('limit').disabled = true;
				document.getElementById('interval').disabled = true;
				document.getElementById('text').disabled = true;
				document.getElementById('button').disabled = true;
				document.getElementById('title').disabled = true;
				$('#sendingbox').show();
				$.post('/adminpanel.php?mod=mail&act=send', {limit: limit, title: title, text: text, lastid: lastid}, function(data){
					if(data){
						setTimeout('mailSend()', interval);
						$('#lastlimit').val(parseInt(lastid)+parseInt(limit));
						$('#ok_users').text(parseInt(lastid)+parseInt(limit));
						if($('#ok_users').text() == $('#user_cnt').text())
							$('#status').html('<font color="green">�������� ���������</font>');
					} else {
						$('#status').html('<font color="green">�������� ���������</font>');
						$('#lastlimit').val('finish');
						$('#ok_users').text($('#user_cnt').text());
					}
				});
			} else
				alert('������� ����� ���������');
		} else
			alert('������� ��������� ���������');
	} else
		alert('������������� ��������, ��� ����� ��������');
}
</script>
<form method="POST" action="">

<div class="fllogall">���������� ����� �� ���� ������:</div><input type="text" id="limit" class="inpu" style="width:50px" value="{$max_users}" /><div class="mgcler"></div>

<div class="fllogall">�������� ����� ��������� �����:</div><input type="text" id="interval" class="inpu" style="width:50px" value="1" /> ���.<div class="mgcler"></div>

<div class="fllogall">���������:</div><input type="text" id="title" class="inpu" /><div class="mgcler"></div>

<div class="fllogall">����� ���������:</div><textarea class="inpu" id="text"></textarea><div class="mgcler"></div>

<div class="fllogall">&nbsp;</div><div style="margin-bottom:7px">� ����� ��������� �� ������ ������������ ��� <br /><b>{%user-name%}</b>, ������� �������� ��� ����������.</div><div class="mgcler"></div>

<div class="fllogall">&nbsp;</div><div class="button_div fl_l"><button onClick="mailSend(); return false" id="button" class="inp" style="margin-top:5px">������ ��������</button></div>
<input type="hidden" id="lastlimit" class="inpu" value="0" />
</form>
HTML;

		echo '</div><div id="sendingbox" style="display:none">';
		echohtmlstart('�������� ���������');
		echo <<<HTML
<div id="result"></div>
���������� ���������: <span style="color:red;" id="ok_users">0</span> �� <span style="color:blue;" id="user_cnt">{$users['cnt']}</span> ������: <span id="status">��������...</span><br /><br />
<span style="color:#777">�������� ���� ������� ��������� �������������, �� ���������� ������ ���� �� ��� ���, ���� �� ����� �������� ��� ������</span>
</div>
HTML;
		echohtmlend();
}
?>