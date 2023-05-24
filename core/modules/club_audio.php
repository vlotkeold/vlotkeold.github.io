<?php
/* 
	Appointment: ���������� -> ��������� �������� -> �����������
	File: public_audio.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if($logged){

	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	
	switch($act){
		
		//################### ���������� ����� � ������ ���������� ###################//
		case "addlistgroup":
		
			NoAjaxQuery();
			
			$gid = intval($_POST['gid']);
			$aid = intval($_POST['aid']);
			
			$check = $db->super_query("SELECT url, artist, name FROM `".PREFIX."_audio` WHERE aid = '{$aid}'");
			
			$infoGroup = $db->super_query("SELECT admin FROM `".PREFIX."_clubs` WHERE id = '{$gid}'");
			
			if(stripos($infoGroup['admin'], "id{$user_id}|") !== false) $public_admin = true;
			else $public_admin = false;
			
			if($public_admin){
			
				$db->query("INSERT INTO `".PREFIX."_clubs_audio` SET public_id = '{$gid}', url = '".$db->safesql($check['url'])."', artist = '".$db->safesql($check['artist'])."', name = '".$db->safesql($check['name'])."',  adate = '{$server_time}'");
				
				$db->query("UPDATE `".PREFIX."_clubs` SET audio_num = audio_num+1 WHERE id = '{$gid}'");
				
				mozg_clear_cache_file("groups/audio{$gid}");
				
			}
			
			exit;
			
		break;
		
		//################### ���������� ���������������� ������ ###################//
		case "editsave":
		
			NoAjaxQuery();
			
			$aid = intval($_POST['aid']);
			$gid = intval($_POST['gid']);
			$artist = ajax_utf8(textFilter($_POST['artist'], false, true));
			$name = ajax_utf8(textFilter($_POST['name'], false, true));

			if(isset($artist) AND empty($artist)) $artist = '����������� �����������';
			if(isset($name) AND empty($name)) $name = '��� ��������';
			
			$infoGroup = $db->super_query("SELECT admin FROM `".PREFIX."_clubs` WHERE id = '{$gid}'");
			
			if(stripos($infoGroup['admin'], "id{$user_id}|") !== false) $public_admin = true;
			else $public_admin = false;
			
			if($public_admin){
			
				$db->query("UPDATE `".PREFIX."_clubs_audio` SET artist = '{$artist}', name = '{$name}' WHERE aid = '{$aid}'");
				
				mozg_clear_cache_file("groups/audio{$gid}");
				
			}
			
			exit;
			
		break;
		
		//################### �������� ����� �� �� ###################//
		case "del":
		
			NoAjaxQuery();
			
			$aid = intval($_POST['aid']);
			$gid = intval($_POST['gid']);
			
			$infoGroup = $db->super_query("SELECT admin FROM `".PREFIX."_clubs` WHERE id = '{$gid}'");
			
			if(stripos($infoGroup['admin'], "id{$user_id}|") !== false) $public_admin = true;
			else $public_admin = false;
			
			if($public_admin){

				$db->query("DELETE FROM `".PREFIX."_clubs_audio` WHERE aid = '{$aid}'");
				
				$db->query("UPDATE `".PREFIX."_clubs` SET audio_num = audio_num-1 WHERE id = '{$gid}'");
				
				mozg_clear_cache_file("groups/audio{$gid}");
				
			}
			
			exit;
			
		break;
		
		//################### ����� ###################//
		case "search":
			
			NoAjaxQuery();
			
			$sql_limit = 20;
			
			if($_POST['page'] > 0) $page_cnt = intval($_POST['page'])*$sql_limit;
			else $page_cnt = 0;
			
			$gid = intval($_POST['gid']);
	
			$query = $db->safesql(ajax_utf8(strip_data($_POST['query'])));
			$query = strtr($query, array(' ' => '%')); //�������� ������� �� �������� ���� ����� ��� ������
			
			$adres = strip_tags($_POST['adres']);
			
			$row_count = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_audio` WHERE MATCH (name, artist) AGAINST ('%{$query}%') OR artist LIKE '%{$query}%' OR name LIKE '%{$query}%'");
			
			$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS ".PREFIX."_audio.aid, url, artist, name, auser_id, ".PREFIX."_users.user_search_pref FROM ".PREFIX."_audio LEFT JOIN ".PREFIX."_users ON ".PREFIX."_audio.auser_id = ".PREFIX."_users.user_id WHERE MATCH (name, artist) AGAINST ('%{$query}%') OR artist LIKE '%{$query}%' OR name LIKE '%{$query}%' ORDER by `adate` DESC LIMIT {$page_cnt}, {$sql_limit}", 1);
			
			$infoGroup = $db->super_query("SELECT admin FROM `".PREFIX."_clubs` WHERE id = '{$gid}'");
			
			if(stripos($infoGroup['admin'], "id{$user_id}|") !== false) $public_admin = true;
			else $public_admin = false;

			$tpl->load_template('public_audio/search_result.tpl');

			$jid = intval($page_cnt);
			
			if($sql_){
			
				if(!$page_cnt)
					$tpl->result['content'] .= "<script>langNumric('langNumric', '{$row_count['cnt']}', '�����������', '�����������', '������������', '�����������', '������������');</script><div class=\"allbar_title\" style=\"margin-bottom:0px\">� ������ ������� <span id=\"seAudioNum\">{$row_count['cnt']}</span> <span id=\"langNumric\"></span> | <a href=\"/{$adres}\" onClick=\"Page.Go(this.href); return false\" style=\"font-weight:normal\">� ����������</a> | <a href=\"/\" onClick=\"Page.Go(location.href); return false\" style=\"font-weight:normal\">��� �����������</a></div>";
			
				foreach($sql_ as $row){
					$jid++;
					$tpl->set('{jid}', $jid);
					$tpl->set('{aid}', $row['aid']);
					$tpl->set('{url}', $row['url']);
					$tpl->set('{artist}', stripslashes($row['artist']));
					$tpl->set('{name}', stripslashes($row['name']));
					$tpl->set('{author-n}', substr($row['user_search_pref'], 0, 1));
					$expName = explode(' ', $row['user_search_pref']);
					$tpl->set('{author-f}', $expName[1]);
					$tpl->set('{author-id}', $row['auser_id']);
					
					//����� ������
					if($public_admin){
						$tpl->set('[admin-group]', '');
						$tpl->set('[/admin-group]', '');
						$tpl->set_block("'\\[all-users\\](.*?)\\[/all-users\\]'si","");
					} else {
						$tpl->set_block("'\\[admin-group\\](.*?)\\[/admin-group\\]'si","");
						$tpl->set('[all-users]', '');
						$tpl->set('[/all-users]', '');
					}
					
					$tpl->compile('content');
				}
				
			} else {
				
				if(!$page_cnt){
				
					$tpl->result['info'] .= "<div class=\"allbar_title\">��� ������������ | <a href=\"/{$adres}\" onClick=\"Page.Go(this.href); return false\" style=\"font-weight:normal\">� ����������</a> | <a href=\"/\" onClick=\"Page.Go(location.href); return false\" style=\"font-weight:normal\">��� �����������</a></div>";
				
					msgbox('', '<br /><br /><br />�� ������� <b>'.stripslashes($query).'</b> �� ������� �� ����� �����������<br /><br /><br />', 'info_2');
				
				}
			}
			
			AjaxTpl();
			
			exit;
			
		break;
		
		//################### �������� ���� ����� ###################//
		default:
			
			$metatags['title'] = '����������� ����������';
			
			$gid = intval($_GET['gid']);
			
			$sql_limit = 20;
			
			if($_POST['page'] > 0) $page_cnt = intval($_POST['page'])*$sql_limit;
			else $page_cnt = 0;
			
			if($page_cnt)
				NoAjaxQuery();
			
			$sql_ = $db->super_query("SELECT aid, url, artist, name FROM `".PREFIX."_clubs_audio` WHERE public_id = '{$gid}' ORDER by `adate` DESC LIMIT {$page_cnt}, {$sql_limit}", 1);

			$infoGroup = $db->super_query("SELECT audio_num, adres, admin FROM `".PREFIX."_clubs` WHERE id = '{$gid}'");
			
			if(!$page_cnt){
				$tpl->load_template('public_audio/top.tpl');
				$tpl->set('{pid}', $gid);
					
				if($infoGroup['adres']) $tpl->set('{adres}', $infoGroup['adres']);
				else $tpl->set('{adres}', 'public'.$gid);
						
				if($infoGroup['audio_num']) $tpl->set('{audio-num}', $infoGroup['audio_num'].' <span id="langNumricAll"></span>');
				else $tpl->set('{audio-num}', '��� ������������');
					
				$tpl->set('{x-audio-num}', $infoGroup['audio_num']);
					
				if(!$infoGroup['audio_num']){
					$tpl->set('[no]', '');
					$tpl->set('[/no]', '');
				} else
					$tpl->set_block("'\\[no\\](.*?)\\[/no\\]'si","");
				
				$tpl->compile('info');
			}
			
			if($sql_){

				$jid = intval($page_cnt);
				
				if(stripos($infoGroup['admin'], "id{$user_id}|") !== false) $public_admin = true;
				else $public_admin = false;
			
				$tpl->load_template('public_audio/track.tpl');
				
				$tpl->result['content'] .= '<div id="allGrAudis">';
				
				foreach($sql_ as $row){
					$jid++;
					$tpl->set('{jid}', $jid);
					$tpl->set('{pid}', $gid);
					$tpl->set('{aid}', $row['aid']);
					$tpl->set('{url}', $row['url']);
					$tpl->set('{artist}', stripslashes($row['artist']));
					$tpl->set('{name}', stripslashes($row['name']));
					
					//����� ������
					if($public_admin){
						$tpl->set('[admin-group]', '');
						$tpl->set('[/admin-group]', '');
						$tpl->set_block("'\\[all-users\\](.*?)\\[/all-users\\]'si","");
					} else {
						$tpl->set_block("'\\[admin-group\\](.*?)\\[/admin-group\\]'si","");
						$tpl->set('[all-users]', '');
						$tpl->set('[/all-users]', '');
					}
					
					$tpl->compile('content');
				}
				

				if($infoGroup['audio_num'] > $sql_limit AND !$page_cnt)
					$tpl->result['content'] .= '<div id="ListAudioAddedLoadAjax"></div><div class="cursor_pointer" style="margin-top:-4px" onClick="ListAudioAddedLoadAjax()" id="wall_l_href_se_audiox"><div class="public_wall_all_comm profile_hide_opne" style="width:754px" id="wall_l_href_audio_se_loadx">�������� ������ ������������</div></div>';
				
				$tpl->result['content'] .= '</div>';
				
			}
			
			if($page_cnt){
				AjaxTpl();
				exit;
			}
			
	}
	
	$tpl->clear();
	$db->free();
	
} else {
	$user_speedbar = '����������';
	msgbox('', $lang['not_logged'], 'info');
}

?>