<?php
/* 
	Appointment: ����������
	File: groups.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

//��������������
if($_GET['act'] == 'edit'){
	$id = intval($_GET['id']);
	
	//SQL ������ �� ����� ���������� 
	$row = $db->super_query("SELECT title, descr, comments, photo, com_real, ptype FROM `".PREFIX."_communities` WHERE id = '".$id."'");
	if($row){
		if(isset($_POST['save'])){
			$title = textFilter($_POST['title'], false, true);
			$descr = textFilter($_POST['descr']);
			
			if(isset($title) AND !empty($title) AND isset($descr) AND !empty($descr)){
				if($_POST['comments']) $comments = 1;
				else $comments = 0;
				
				if($_POST['del_photo']){
					@unlink(ROOT_DIR.'/uploads/groups/'.$id.'/'.$row['photo']);
					$sql_line_del = ", photo = ''";
				}
				
				$db->query("UPDATE `".PREFIX."_communities` SET title = '".$title."', descr = '".$descr."', comments = '".$comments."' ".$sql_line_del." WHERE id = '".$id."'");
				msgbox('����������', '���������� ������� ���������������', '?mod=groups');
			} else
				msgbox('������', '��������� ��� ����', '?mod=groups&act=edit&id='.$id);
		} else {
			$row['title'] = stripslashes($row['title']);
			$row['descr'] = stripslashes(myBrRn($row['descr']));
			
			if($row['comments']) $checked = 'checked';
			
			echoheader();
			echohtmlstart('�������������� ����������');
			
			echo <<<HTML
<style type="text/css" media="all">
.inpu{width:447px;}
textarea{width:450px;height:100px;}
</style>

<form action="" method="POST">

<input type="hidden" name="mod" value="notes" />

<div class="fllogall" style="width:140px">��������:</div>
 <input type="text" name="title" class="inpu" value="{$row['title']}" />
<div class="mgcler"></div>

<div class="fllogall" style="width:140px">��������:</div>
 <textarea name="descr" class="inpu">{$row['descr']}</textarea>
<div class="mgcler"></div>

<div class="fllogall" style="width:140px">����������� ��������:</div>
 <input type="checkbox" name="comments" style="margin-bottom:10px" {$checked} />
<div class="mgcler"></div>

<div class="fllogall" style="width:140px">������� ����:</div>
 <input type="checkbox" name="del_photo" style="margin-bottom:10px" />
<div class="mgcler"></div>

<div class="fllogall" style="width:140px">&nbsp;</div>
 <input type="submit" value="���������" class="inp" name="save" style="margin-top:0px" />
 <input type="submit" value="�����" class="inp" style="margin-top:0px" onClick="history.go(-1); return false" />

</form>
HTML;
			echohtmlend();
		}
	} else
		msgbox('������', '���������� �� �������', '?mod=groups');
		
	die();
}

echoheader();	

$se_uid = intval($_GET['se_uid']);
if(!$se_uid) $se_uid = '';

$se_user_id = intval($_GET['se_user_id']);
if(!$se_user_id) $se_user_id = '';

$sort = intval($_GET['sort']);
$se_name = textFilter($_GET['se_name'], false, true);

if($se_uid OR $sort OR $se_name OR $se_user_id OR $_GET['ban'] OR $_GET['delet']){
	if($se_uid) $where_sql .= "AND id = '".$se_uid."' ";
	if($se_user_id) $where_sql .= "AND real_admin = '".$se_user_id."' ";
	$query = strtr($se_name, array(' ' => '%')); //�������� ������� �� �������� ���� ����� ��� ������
	if($se_name) $where_sql .= "AND title LIKE '%".$query."%' ";
	if($_GET['ban']){$where_sql .= "AND ban = 1 ";$checked_ban = "checked";}
	if($_GET['delet']){$where_sql .= "AND del = 1 ";$checked_delet = "checked";}
	if($sort == 5) $where_sql = "AND photo != '' ";
	if($sort == 1) $order_sql = "`title` ASC";
	else if($sort == 2) $order_sql = "`date` ASC";
	else if($sort == 3) $order_sql = "`traf` DESC";
	else if($sort == 4) $order_sql = "`rec_num` DESC";
	else $order_sql = "`date` DESC";
} else
	$order_sql = "`date` DESC";
	
//������� ������ �����
if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
$gcount = 20;
$limit_page = ($page-1)*$gcount;

$sql_ = $db->super_query("SELECT tb1.id, title, date, traf, real_admin, del, ban, rec_num, com_real, tb2.user_name FROM `".PREFIX."_communities` tb1, `".PREFIX."_users` tb2 WHERE tb1.real_admin = tb2.user_id {$where_sql} ORDER by {$order_sql} LIMIT {$limit_page}, {$gcount}", 1);

//���-�� ����� �������
$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities` WHERE id != '' {$where_sql}");

$selsorlist = installationSelected($sort, '<option value="1">�� ��������</option><option value="2">�� ���� ��������</option><option value="3">�� ���������� ����������</option><option value="4">�� ���������� ������� �� �����</option><option value="5">������ � ����</option>');

echo <<<HTML
<style type="text/css" media="all">
.inpu{width:300px;}
textarea{width:300px;height:100px;}
</style>

<form action="adminpanel.php" method="GET">

<input type="hidden" name="mod" value="groups" />

<div class="fllogall">����� �� ID ����������:</div>
 <input type="text" name="se_uid" class="inpu" value="{$se_uid}" />
<div class="mgcler"></div>

<div class="fllogall">����� �� ��������:</div>
 <input type="text" name="se_name" class="inpu" value="{$se_name}" />
<div class="mgcler"></div>

<div class="fllogall">����� �� ID ���������:</div>
 <input type="text" name="se_user_id" class="inpu" value="{$se_user_id}" />
<div class="mgcler"></div>

<div class="fllogall">���:</div>
 <input type="checkbox" name="ban" style="margin-bottom:10px" {$checked_ban} />
<div class="mgcler"></div>

<div class="fllogall">�������:</div>
 <input type="checkbox" name="delet" style="margin-bottom:10px" {$checked_delet} />
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

echohtmlstart('������ ��������� ('.$numRows['cnt'].')');

foreach($sql_ as $row){
	$row['title'] = stripslashes($row['title']);
	$row['date'] = langdate('j M Y � H:i', strtotime($row['date']));

	if($row['del']) 
		$color = 'color:red';
	else if($row['ban'])
		$color = 'color:blue';
	else if($row['com_real'])
		$color = 'color:green';
	else
		$color = '';
		
	$users .= <<<HTML
<div style="background:#fff;float:left;padding:5px;width:100px;text-align:center;"><a href="/u{$row['real_admin']}" target="_blank">{$row['user_name']}</a></div>
<div style="background:#fff;float:left;padding:5px;width:243px;text-align:center;margin-left:1px"><a href="?mod=groups&act=edit&id={$row['id']}" title="������� �� �����: {$row['rec_num']}" style="{$color}">{$row['title']}</a></div>
<div style="background:#fff;float:left;padding:5px;width:75px;text-align:center;margin-left:1px">{$row['traf']}</div>
<div style="background:#fff;float:left;padding:5px;width:110px;text-align:center;margin-left:1px">{$row['date']}</div>
<div style="background:#fff;float:left;padding:4px;width:20px;text-align:center;font-weight:bold;margin-left:1px"><input type="checkbox" name="massaction_list[]" style="float:right;" value="{$row['id']}" /></div>
<div class="mgcler"></div>
HTML;
}

echo <<<HTML
<script language="text/javascript" type="text/javascript">
function ckeck_uncheck_all() {
    var frm = document.edit;
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
<form action="?mod=massaction&act=groups" method="post" name="edit">

<div style="background:#f0f0f0;float:left;padding:5px;width:100px;text-align:center;font-weight:bold;margin-top:-5px">���������</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:243px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">����������</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:75px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">����������</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:110px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">���� ��������</div>
<div style="background:#f0f0f0;float:left;padding:4px;width:20px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px"><input type="checkbox" name="master_box" title="������� ���" onclick="javascript:ckeck_uncheck_all()" style="float:right;"></div>
<div class="clr"></div>
{$users}
<div style="float:left;font-size:10px">
<font color="red">��������� ���������� �������� ������� ������</font><br />
<font color="blue">��������� ���������� �������� ����� ������</font><br />
<font color="green">����������� ����������</font>
</div>
<div style="float:right">
<select name="mass_type" class="inpu" style="width:260px">
 <option value="0">- �������� -</option>
 <option value="1">������� ����������</option>
 <option value="2">������������� ����������</option>
 <option value="3">������������ ����������</option>
 <option value="4">�������������� ����������</option>
 <option value="5">����������� ����������</option>
 <option value="6">������ ������������ ����������</option>
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