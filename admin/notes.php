<?php
/* 
	Appointment: �������
	File: notes.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

//��������������
if($_GET['act'] == 'edit'){
	$note_id = intval($_GET['id']);
	
	//SQL ������ �� ����� ���������� � �������
	$row = $db->super_query("SELECT title, full_text FROM `".PREFIX."_notes` WHERE id = '".$note_id."'");
	
	if($row){
		//���������� ������
		include ENGINE_DIR.'/classes/parse.php';
		$parse = new parse();
		
		if(isset($_POST['save'])){
			$title = textFilter($_POST['title'], false, true);
			$text = $parse->BBparse(textFilter($_POST['full_text']));

			if(isset($title) AND !empty($title) AND isset($text) AND !empty($text)){
				$db->query("UPDATE `".PREFIX."_notes` SET title = '".$title."', full_text = '".$text."' WHERE id = '".$note_id."'");
				msgbox('����������', '������� ������� ���������', '?mod=notes');
			} else
				msgbox('������', '��������� ��� ����', '?mod=notes&act=edit&id='.$note_id);
		} else {
			$row['title'] = stripslashes($row['title']);
			$row['full_text'] = $parse->BBdecode(stripslashes(myBrRn($row['full_text'])));
			
			echoheader();
			
			echohtmlstart('�������������� �������');
			
			echo <<<HTML
<style type="text/css" media="all">
.inpu{width:487px;}
textarea{width:450px;height:400px;}
</style>

<form action="" method="POST">

<input type="hidden" name="mod" value="notes" />

<div class="fllogall" style="width:100px">���������:</div>
 <input type="text" name="title" class="inpu" value="{$row['title']}" />
<div class="mgcler"></div>

<div class="fllogall" style="width:100px">�����������:</div>
 <textarea name="full_text" class="inpu">{$row['full_text']}</textarea>
<div class="mgcler"></div>

<div class="fllogall" style="width:100px">&nbsp;</div>
 <input type="submit" value="���������" class="inp" name="save" style="margin-top:0px" />
 <input type="submit" value="�����" class="inp" style="margin-top:0px" onClick="history.go(-1); return false" />

</form>
HTML;
			echohtmlend();
		}
	} else
		msgbox('����������', '������������� ������� �� �������', '?mod=notes');

	die();
}
	
echoheader();	

$se_uid = intval($_GET['se_uid']);
if(!$se_uid) $se_uid = '';

$se_user_id = intval($_GET['se_user_id']);
if(!$se_user_id) $se_user_id = '';

$sort = intval($_GET['sort']);
$se_name = textFilter($_GET['se_name'], false, true);

if($se_uid OR $sort OR $se_name OR $se_user_id){
	if($se_uid) $where_sql .= "AND id = '".$se_uid."' ";
	if($se_user_id) $where_sql .= "AND owner_user_id = '".$se_user_id."' ";
	$query = strtr($se_name, array(' ' => '%')); //�������� ������� �� �������� ���� ����� ��� ������
	if($se_name) $where_sql .= "AND title LIKE '%".$query."%' ";
	if($sort == 1) $order_sql = "`title` ASC";
	else if($sort == 2) $order_sql = "`date` ASC";
	else if($sort == 3) $order_sql = "`comm_num` DESC";
	else $order_sql = "`date` DESC";
} else
	$order_sql = "`date` DESC";
	
$selsorlist = installationSelected($sort, '<option value="1">�� ��������</option><option value="2">�� ���� ����������</option><option value="3">�� ���������� ������������</option>');

//������� ������ �����
if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
$gcount = 20;
$limit_page = ($page-1)*$gcount;

$sql_ = $db->super_query("SELECT tb1.id, title, date, comm_num, owner_user_id, tb2.user_name FROM `".PREFIX."_notes` tb1, `".PREFIX."_users` tb2 WHERE tb1.owner_user_id = tb2.user_id {$where_sql} ORDER by {$order_sql} LIMIT {$limit_page}, {$gcount}", 1);

//���-�� ����� �������
$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_notes` WHERE id != '' {$where_sql}");

echo <<<HTML
<style type="text/css" media="all">
.inpu{width:300px;}
textarea{width:300px;height:100px;}
</style>

<form action="adminpanel.php" method="GET">

<input type="hidden" name="mod" value="notes" />

<div class="fllogall">����� �� ID �������:</div>
 <input type="text" name="se_uid" class="inpu" value="{$se_uid}" />
<div class="mgcler"></div>

<div class="fllogall">����� �� ��������:</div>
 <input type="text" name="se_name" class="inpu" value="{$se_name}" />
<div class="mgcler"></div>

<div class="fllogall">����� �� ID ������:</div>
 <input type="text" name="se_user_id" class="inpu" value="{$se_user_id}" />
<div class="mgcler"></div>

<div class="fllogall">����������:</div>
 <select name="sort" class="inpu">
  <option value="0"></option>
  {$selsorlist}
 </select>
<div class="mgcler"></div>

<div class="fllogall">&nbsp;</div>
 <input type="submit" value="�����" class="inp" style="margin-top:0px" />

</form>
HTML;

echohtmlstart('������ ������� ('.$numRows['cnt'].')');

foreach($sql_ as $row){
	$row['title'] = stripslashes($row['title']);
	$row['date'] = langdate('j M Y � H:i', strtotime($row['date']));

	$users .= <<<HTML
<div style="background:#fff;float:left;padding:5px;width:100px;text-align:center;"><a href="/u{$row['owner_user_id']}" target="_blank">{$row['user_name']}</a></div>
<div style="background:#fff;float:left;padding:5px;width:329px;text-align:center;margin-left:1px"><a href="?mod=notes&act=edit&id={$row['id']}" title="������������: {$row['comm_num']}">{$row['title']}</a></div>
<div style="background:#fff;float:left;padding:5px;width:110px;text-align:center;margin-left:1px">{$row['date']}</div>
<div style="background:#fff;float:left;padding:4px;width:20px;text-align:center;font-weight:bold;margin-left:1px"><input type="checkbox" name="massaction_note[]" style="float:right;" value="{$row['id']}" /></div>
<div class="mgcler"></div>
HTML;
}

echo <<<HTML
<script language="text/javascript" type="text/javascript">
function ckeck_uncheck_all() {
    var frm = document.editnotes;
    for (var i=0;i<frm.elements.length;i++) {
        var elmnt = frm.elements[i];
        if (elmnt.type=='checkbox') {
            if(frm.master_box.checked == true){ elmnt.checked=false; }
            else{ elmnt.checked=true; }
        }
    }
    if(frm.master_box.checked == true){ frm.master_box.checked = false; }
    else{ frm.master_box.checked = true; }
}
</script>
<form action="?mod=massaction&act=notes" method="post" name="editnotes">

<div style="background:#f0f0f0;float:left;padding:5px;width:100px;text-align:center;font-weight:bold;margin-top:-5px">�����</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:329px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">�������</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:110px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">���� ����������</div>
<div style="background:#f0f0f0;float:left;padding:4px;width:20px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px"><input type="checkbox" name="master_box" title="������� ���" onclick="javascript:ckeck_uncheck_all()" style="float:right;"></div>
<div class="clr"></div>
{$users}
<div style="float:right">
<select name="mass_type" class="inpu">
 <option value="0">- �������� -</option>
 <option value="1">������� �������</option>
 <option value="2">�������� �����������</option>
</select>
<input type="submit" value="��������" class="inp" />
</div>
</form>
<div class="clr"></div>
HTML;

$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);

echo navigation($gcount, $numRows['cnt'], '?'.$query_string.'&page=');

htmlclear();

echohtmlend();
?>