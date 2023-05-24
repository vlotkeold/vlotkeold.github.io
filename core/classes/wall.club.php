<?php
/* 
	Appointment: ����� ��� ����� ���������
	File: wall.clubs.php 
 
*/

class wall {

	var $query = false;
	var $template = false;
	var $compile = false;
	
	function query($query){
		global $db;
		
		$this->query = $db->super_query($query, 1);
	}

	function template($template){
		global $tpl;
		$this->template = $tpl->load_template($template);
	}
	
	function compile($compile){
		$this->compile = $compile;
	}
	
	function select($public_admin, $server_time){
		global $tpl, $db, $user_info, $pid;
		
		$user_id = $user_info['user_id'];

		$this->template;
		
		foreach($this->query as $row_wall){
			$tpl->set('{rec-id}', $row_wall['id']);
			
			//������ �������� ���������..
			$expBR = explode('<br />', $row_wall['text']);
			$textLength = count($expBR);
			$strTXT = strlen($row_wall['text']);
			if($textLength > 9 OR $strTXT > 600)
				$row_wall['text'] = '<div class="wall_strlen" id="hide_wall_rec'.$row_wall['id'].'">'.$row_wall['text'].'</div><div class="wall_strlen_full" onMouseDown="wall.FullText('.$row_wall['id'].', this.id)" id="hide_wall_rec_lnk'.$row_wall['id'].'">�������� ���������..</div>';
				
			//������������� �����
			if($row_wall['attach']){
				$attach_arr = explode('||', $row_wall['attach']);
				$cnt_attach = 1;
				$cnt_attach_link = 1;
				$jid = 0;
				$attach_result = '';
				foreach($attach_arr as $attach_file){
					$attach_type = explode('|', $attach_file);
					
					//���� �� ����� ����������
					if($row_wall['tell_uid'])
						$globParId = $row_wall['tell_uid'];
					else
						$globParId = $row_wall['public_id'];
						
					if($attach_type[0] == 'photo' AND file_exists(ROOT_DIR."/uploads/clubs/{$globParId}/photos/c_{$attach_type[1]}")){
						if($cnt_attach < 2)
							$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row_wall['id']}\" onClick=\"clubs.wall_photo_view('{$row_wall['id']}', '{$globParId}', '{$attach_type[1]}', '{$cnt_attach}')\"><img id=\"photo_wall_{$row_wall['id']}_{$cnt_attach}\" src=\"/uploads/clubs/{$globParId}/photos/{$attach_type[1]}\" align=\"left\" /></div>";
						else
							$attach_result .= "<img id=\"photo_wall_{$row_wall['id']}_{$cnt_attach}\" src=\"/uploads/clubs/{$globParId}/photos/c_{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"clubs.wall_photo_view('{$row_wall['id']}', '{$globParId}', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row_wall['id']}\" />";
						
						$cnt_attach++;
						
						$resLinkTitle = '';
						
					//���� �� ����� �����
					} elseif($attach_type[0] == 'photo_u'){
						$attauthor_user_id = $row_wall['tell_uid'];

						if($attach_type[1] == 'attach' AND file_exists(ROOT_DIR."/uploads/attach/{$attauthor_user_id}/c_{$attach_type[2]}")){
							if($cnt_attach < 2)
								$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row_wall['id']}\" onClick=\"clubs.wall_photo_view('{$row_wall['id']}', '{$attauthor_user_id}', '{$attach_type[1]}', '{$cnt_attach}', 'photo_u')\"><img id=\"photo_wall_{$row_wall['id']}_{$cnt_attach}\" src=\"/uploads/attach/{$attauthor_user_id}/{$attach_type[2]}\" align=\"left\" /></div>";
							else
								$attach_result .= "<img id=\"photo_wall_{$row_wall['id']}_{$cnt_attach}\" src=\"/uploads/attach/{$attauthor_user_id}/c_{$attach_type[2]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"clubs.wall_photo_view('{$row_wall['id']}', '', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row_wall['id']}\" />";
								
							$cnt_attach++;
						} elseif(file_exists(ROOT_DIR."/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/c_{$attach_type[1]}")){
							if($cnt_attach < 2)
								$attach_result .= "<div class=\"profile_wall_attach_photo cursor_pointer page_num{$row_wall['id']}\" onClick=\"clubs.wall_photo_view('{$row_wall['id']}', '{$attauthor_user_id}', '{$attach_type[1]}', '{$cnt_attach}', 'photo_u')\"><img id=\"photo_wall_{$row_wall['id']}_{$cnt_attach}\" src=\"/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/{$attach_type[1]}\" align=\"left\" /></div>";
							else
								$attach_result .= "<img id=\"photo_wall_{$row_wall['id']}_{$cnt_attach}\" src=\"/uploads/users/{$attauthor_user_id}/albums/{$attach_type[2]}/c_{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" onClick=\"clubs.wall_photo_view('{$row_wall['id']}', '{$row_wall['tell_uid']}', '{$attach_type[1]}', '{$cnt_attach}')\" class=\"cursor_pointer page_num{$row_wall['id']}\" />";
								
							$cnt_attach++;
						}
						
						$resLinkTitle = '';
						
					//�����
					} elseif($attach_type[0] == 'video' AND file_exists(ROOT_DIR."/uploads/videos/{$attach_type[3]}/{$attach_type[1]}")){
						$attach_result .= "<div align=\"left\" style=\"margin-top:0px;margin-right:3px\"><a href=\"/video{$attach_type[3]}_{$attach_type[2]}\" onClick=\"videos.show({$attach_type[2]}, this.href, location.href); return false\"><img src=\"/uploads/videos/{$attach_type[3]}/{$attach_type[1]}\" style=\"margin-top:3px;margin-right:3px\" align=\"left\" /></a></div>";
						
						$resLinkTitle = '';
						
					//������
					} elseif($attach_type[0] == 'audio'){
						$audioId = intval($attach_type[1]);
						$audioInfo = $db->super_query("SELECT artist, name, url FROM `".PREFIX."_audio` WHERE aid = '".$audioId."'");
						if($audioInfo){
							$jid++;
							$attach_result .= '<div class="audioForSize'.$row_wall['id'].'" id="audioForSize"><div class="audio_onetrack audio_wall_onemus"><div class="audio_playic cursor_pointer fl_l" onClick="music.newStartPlay(\''.$jid.'\', '.$row_wall['id'].')" id="icPlay_'.$row_wall['id'].$jid.'"></div><div id="music_'.$row_wall['id'].$jid.'" data="'.$audioInfo['url'].'" class="fl_l" style="margin-top:-1px"><a href="/?go=search&type=5&query='.$audioInfo['artist'].'&n=1" onClick="Page.Go(this.href); return false"><b>'.stripslashes($audioInfo['artist']).'</b></a> &ndash; '.stripslashes($audioInfo['name']).'</div><div id="play_time'.$row_wall['id'].$jid.'" class="color777 fl_r no_display" style="margin-top:2px;margin-right:5px">00:00</div><div class="player_mini_mbar fl_l no_display player_mini_mbar_wall" id="ppbarPro'.$row_wall['id'].$jid.'"></div></div></div>';
						}
						
						$resLinkTitle = '';
					//�������
					} elseif($attach_type[0] == 'smile' AND file_exists(ROOT_DIR."/uploads/smiles/{$attach_type[1]}")){
						$attach_result .= '<img src=\"/uploads/smiles/'.$attach_type[1].'\" style="margin-right:5px" />';
						
						$resLinkTitle = '';
						
					//���� ������
					} elseif($attach_type[0] == 'link' AND preg_match('/http:\/\/(.*?)+$/i', $attach_type[1]) AND $cnt_attach_link == 1){
						$count_num = count($attach_type);
						$domain_url_name = explode('/', $attach_type[1]);
						$rdomain_url_name = str_replace('http://', '', $domain_url_name[2]);
						
						$attach_type[3] = stripslashes($attach_type[3]);
						$attach_type[3] = substr($attach_type[3], 0, 200);
							
						$attach_type[2] = stripslashes($attach_type[2]);
						$str_title = substr($attach_type[2], 0, 55);
						
						if(stripos($attach_type[4], '/uploads/attach/') === false){
							$attach_type[4] = '{theme}/images/no_ava_groups_100.gif';
							$no_img = false;
						} else
							$no_img = true;
						
						if(!$attach_type[3]) $attach_type[3] = '';
							
						if($no_img AND $attach_type[2]){
							if($row_wall['tell_comm']) $no_border_link = 'border:0px';
							
							$attach_result .= '<div style="margin-top:2px" class="clear"><div class="attach_link_block_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">������: <a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$rdomain_url_name.'</a></div></div><div class="clear"></div><div class="wall_show_block_link" style="'.$no_border_link.'"><a href="/away.php?url='.$attach_type[1].'" target="_blank"><div style="width:108px;height:80px;float:left;text-align:center"><img src="'.$attach_type[4].'" /></div></a><div class="attatch_link_title"><a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$str_title.'</a></div><div style="max-height:50px;overflow:hidden">'.$attach_type[3].'</div></div></div>';

							$resLinkTitle = $attach_type[2];
							$resLinkUrl = $attach_type[1];
						} else if($attach_type[1] AND $attach_type[2]){
							$attach_result .= '<div style="margin-top:2px" class="clear"><div class="attach_link_block_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">������: <a href="/away.php?url='.$attach_type[1].'" target="_blank">'.$rdomain_url_name.'</a></div></div></div><div class="clear"></div>';
							
							$resLinkTitle = $attach_type[2];
							$resLinkUrl = $attach_type[1];
						}
						
						$cnt_attach_link++;
						
					//���� ��������
					} elseif($attach_type[0] == 'doc'){
					
						$doc_id = intval($attach_type[1]);
						
						$row_doc = $db->super_query("SELECT dname, dsize FROM `".PREFIX."_doc` WHERE did = '{$doc_id}'");
						
						if($row_doc){
							
							$attach_result .= '<div style="margin-top:5px;margin-bottom:5px" class="clear"><div class="doc_attach_ic fl_l" style="margin-top:4px;margin-left:0px"></div><div class="attach_link_block_te"><div class="fl_l">���� <a href="/index.php?go=doc&act=download&did='.$doc_id.'" target="_blank" onMouseOver="myhtml.title(\''.$doc_id.$cnt_attach.$row_wall['id'].'\', \'<b>������ �����: '.$row_doc['dsize'].'</b>\', \'doc_\')" id="doc_'.$doc_id.$cnt_attach.$row_wall['id'].'">'.$row_doc['dname'].'</a></div></div></div><div class="clear"></div>';
								
							$cnt_attach++;
						}
						
					//���� �����
					} elseif($attach_type[0] == 'vote'){
					
						$vote_id = intval($attach_type[1]);
						
						$row_vote = $db->super_query("SELECT title, answers, answer_num FROM `".PREFIX."_votes` WHERE id = '{$vote_id}'", false, "votes/vote_{$vote_id}");
						
						if($vote_id){

							$checkMyVote = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_votes_result` WHERE user_id = '{$user_id}' AND vote_id = '{$vote_id}'", false, "votes/check{$user_id}_{$vote_id}");
							
							$row_vote['title'] = stripslashes($row_vote['title']);
							
							if(!$row_wall['text'])
								$row_wall['text'] = $row_vote['title'];

							$arr_answe_list = explode('|', stripslashes($row_vote['answers']));
							$max = $row_vote['answer_num'];
							
							$sql_answer = $db->super_query("SELECT answer, COUNT(*) AS cnt FROM `".PREFIX."_votes_result` WHERE vote_id = '{$vote_id}' GROUP BY answer", 1, "votes/vote_answer_cnt_{$vote_id}");
							$answer = array();
							foreach($sql_answer as $row_answer){
							
								$answer[$row_answer['answer']]['cnt'] = $row_answer['cnt'];
								
							}
							
							$attach_result .= "<div class=\"clear\" style=\"height:10px\"></div><div id=\"result_vote_block{$vote_id}\"><div class=\"wall_vote_title\">{$row_vote['title']}</div>";
							
							for($ai = 0; $ai < sizeof($arr_answe_list); $ai++){

								if(!$checkMyVote['cnt']){
								
									$attach_result .= "<div class=\"wall_vote_oneanswe\" onClick=\"Votes.Send({$ai}, {$vote_id})\" id=\"wall_vote_oneanswe{$ai}\"><input type=\"radio\" name=\"answer\" /><span id=\"answer_load{$ai}\">{$arr_answe_list[$ai]}</span></div>";
								
								} else {

									$num = $answer[$ai]['cnt'];

									if(!$num ) $num = 0;
									if($max != 0) $proc = (100 * $num) / $max;
									else $proc = 0;
									$proc = round($proc, 2);
									
									$attach_result .= "<div class=\"wall_vote_oneanswe cursor_default\">
									{$arr_answe_list[$ai]}<br />
									<div class=\"wall_vote_proc fl_l\"><div class=\"wall_vote_proc_bg\" style=\"width:".intval($proc)."%\"></div><div style=\"margin-top:-16px\">{$num}</div></div>
									<div class=\"fl_l\" style=\"margin-top:-1px\"><b>{$proc}%</b></div>
									</div><div class=\"clear\"></div>";
			
								}
							
							}
							
							if($row_vote['answer_num']) $answer_num_text = gram_record($row_vote['answer_num'], 'fave');
							else $answer_num_text = '�������';
							
							if($row_vote['answer_num'] <= 1) $answer_text2 = '������������';
							else $answer_text2 = '�������������';
								
							$attach_result .= "{$answer_text2} <b>{$row_vote['answer_num']}</b> {$answer_num_text}.<div class=\"clear\" style=\"margin-top:10px\"></div></div>";
							
						}
						
					} else
					
						$attach_result .= '';

				}
					
				if($resLinkTitle AND $row_wall['text'] == $resLinkUrl OR !$row_wall['text'])
					$row_wall['text'] = $resLinkTitle.$attach_result;
				else if($attach_result)
					$row_wall['text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row_wall['text']).$attach_result;
				else
					$row_wall['text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row_wall['text']);
			} else
				$row_wall['text'] = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $row_wall['text']);
			
			$resLinkTitle = '';
			
			//���� ��� ������ � "���������� �������"
			if($row_wall['tell_uid']){
				if($row_wall['public'])
					$rowUserTell = $db->super_query("SELECT title, photo FROM `".PREFIX."_clubs` WHERE id = '{$row_wall['tell_uid']}'");
				else
					$rowUserTell = $db->super_query("SELECT user_search_pref, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$row_wall['tell_uid']}'");

				if(date('Y-m-d', $row_wall['tell_date']) == date('Y-m-d', $server_time))
					$dateTell = langdate('������� � H:i', $row_wall['tell_date']);
				elseif(date('Y-m-d', $row_wall['tell_date']) == date('Y-m-d', ($server_time-84600)))
					$dateTell = langdate('����� � H:i', $row_wall['tell_date']);
				else
					$dateTell = langdate('j F Y � H:i', $row_wall['tell_date']);
				
				if($row_wall['public']){
					$rowUserTell['user_search_pref'] = stripslashes($rowUserTell['title']);
					$tell_link = 'club';
					if($rowUserTell['photo'])
						$avaTell = '/uploads/clubs/'.$row_wall['tell_uid'].'/50_'.$rowUserTell['photo'];
					else
						$avaTell = '{theme}/images/no_ava_50.png';
				} else {
					$tell_link = 'id';
					if($rowUserTell['user_photo'])
						$avaTell = '/uploads/users/'.$row_wall['tell_uid'].'/50_'.$rowUserTell['user_photo'];
					else
						$avaTell = '{theme}/images/no_ava_50.png';
				}

				if($row_wall['tell_comm']) $border_tell_class = 'wall_repost_border'; else $border_tell_class = 'wall_repost_border2';
				
				$row_wall['text'] = <<<HTML
{$row_wall['tell_comm']}
<div class="{$border_tell_class}">
<div class="wall_tell_info"><div class="wall_tell_ava"><a href="/{$tell_link}{$row_wall['tell_uid']}" onClick="Page.Go(this.href); return false"><img src="{$avaTell}" width="30" /></a></div><div class="wall_tell_name"><a href="/{$tell_link}{$row_wall['tell_uid']}" onClick="Page.Go(this.href); return false"><b>{$rowUserTell['user_search_pref']}</b></a></div><div class="wall_tell_date">{$dateTell}</div></div>{$row_wall['text']}
<div class="clear"></div>
</div>
HTML;
			}
			
			$rowxd = $db->super_query("SELECT user_photo,user_search_pref,alias FROM `".PREFIX."_users` WHERE user_id = '{$row_wall['uid']}'");
			
			$tpl->set('{text}', stripslashes($row_wall['text']));
			
			$tpl->set('{user-id}', $row_wall['public_id']);
			
			megaDate($row_wall['add_date']);
			
			if($row_wall['uid']!=0 and $row_wall['ofmessgroup']==0) {
				if($rowxd['alias']) $tpl->set('{adres-id}', $rowxd['alias']);
				else $tpl->set('{adres-id}', 'id'.$row_wall['uid']);
				if($rowxd['user_photo'])
					$tpl->set('{ava}', '/uploads/users/'.$row_wall['uid'].'/50_'.$rowxd['user_photo']);
				else
					$tpl->set('{ava}', '{theme}/images/no_ava_50.png');	
				$tpl->set('{name}', $rowxd['user_search_pref']);
			} else {
				if($row_wall['adres']) $tpl->set('{adres-id}', $row_wall['adres']);
				else $tpl->set('{adres-id}', 'club'.$row_wall['public_id']);
				if($row_wall['photo'])
					$tpl->set('{ava}', '/uploads/clubs/'.$row_wall['public_id'].'/50_'.$row_wall['photo']);
				else
					$tpl->set('{ava}', '{theme}/images/no_ava_50.png');	
				$tpl->set('{name}', $row_wall['title']);
			}
			
			$rowxxd = $db->super_query("SELECT user_photo,user_search_pref,alias FROM `".PREFIX."_users` WHERE user_id = '{$row_wall['uid']}'");
				
				if($rowxxd['alias']) $alias_name = $rowxxd['alias'];
				else $alias_name = $row_wall['uid'];
				
				if($row_wall['view_author']==1 and $row_wall['uid']!=0 and $row_wall['ofmessgroup']==1) $tpl->set('{author_view}', '<div class="wall_signed"><a class="wall_signed_by" href="/'.$alias_name.'">'.$rowxxd['user_search_pref'].'</a></div>');
				else $tpl->set('{author_view}', '');
			
			//��� ��������
			if(stripos($row_wall['likes_users'], "id{$user_id}|") !== false){
				$tpl->set('{yes-like}', 'public_wall_like_yes');
				$tpl->set('{yes-like-color}', 'public_wall_like_yes_color');
				$tpl->set('{like-js-function}', 'clubs.wall_remove_like('.$row_wall['id'].', '.$user_id.')');
			} else {
				$tpl->set('{yes-like}', '');
				$tpl->set('{yes-like-color}', '');
				$tpl->set('{like-js-function}', 'clubs.wall_add_like('.$row_wall['id'].', '.$user_id.')');
			}
			
			if($row_wall['likes_num']){
				$tpl->set('{likes}', $row_wall['likes_num']);
				$tpl->set('{likes-text}', '<span id="like_text_num'.$row_wall['id'].'">'.$row_wall['likes_num'].'</span> '.gram_record($row_wall['likes_num'], 'like'));
			} else {
				$tpl->set('{likes}', '');
				$tpl->set('{likes-text}', '<span id="like_text_num'.$row_wall['id'].'">0</span> ��������');
			}
			
			//������� ��������� � ��� ��� ������� �������� ��� ����
			$tpl->set('{viewer-id}', $user_id);
			if($user_info['user_photo'])
				$tpl->set('{viewer-ava}', '/uploads/users/'.$user_id.'/50_'.$user_info['user_photo']);
			else
				$tpl->set('{viewer-ava}', '{theme}/images/no_ava_50.png');
				
			if($row_wall['type'])
				$tpl->set('{type}', $row_wall['type']);
			else
				$tpl->set('{type}', '');
			
			//�����
			if($public_admin){
				$tpl->set('[owner]', '');
				$tpl->set('[/owner]', '');
			} else
				$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");

			//���� ���� �������� � ������, �� ��������� ����. �������� / �����������
			if($row_wall['fasts_num'])
				$tpl->set_block("'\\[comments-link\\](.*?)\\[/comments-link\\]'si","");
			else {
				$tpl->set('[comments-link]', '');
				$tpl->set('[/comments-link]', '');
			}

			//����������� ��������������� �������
			if($row_wall['comments'] OR $public_admin){
				$tpl->set('[privacy-comment]', '');
				$tpl->set('[/privacy-comment]', '');
			} else
				$tpl->set_block("'\\[privacy-comment\\](.*?)\\[/privacy-comment\\]'si","");
				
			$tpl->set('[record]', '');
			$tpl->set('[/record]', '');
			$tpl->set_block("'\\[comment\\](.*?)\\[/comment\\]'si","");
			$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
			$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
			$tpl->compile($this->compile);

			//���� ���� �������� � ������, �� ��������� ����� ������ ��� � ����������� ���� � ������� �������� � ������
			if($row_wall['comments'] OR $public_admin){
				if($row_wall['fasts_num']){
					
					//�������� ��� �������� � id wall_fast_block_{id} ��� ��� JS
					$tpl->result[$this->compile] .= '<div id="wall_fast_block_'.$row_wall['id'].'" class="public_wall_rec_comments">';
			
					if($row_wall['fasts_num'] > 3)
						$comments_limit = $row_wall['fasts_num']-3;
					else
						$comments_limit = 0;
					
					$sql_comments = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.id, public_id, text, add_date, tb2.user_photo, user_search_pref FROM `".PREFIX."_clubs_wall` tb1, `".PREFIX."_users` tb2 WHERE tb1.public_id = tb2.user_id AND tb1.fast_comm_id = '{$row_wall['id']}' ORDER by `add_date` ASC LIMIT {$comments_limit}, 3", 1);

					//��������� ������ "�������� N ������"
					$tpl->set('{gram-record-all-comm}', gram_record(($row_wall['fasts_num']-3), 'prev').' '.($row_wall['fasts_num']-3).' '.gram_record(($row_wall['fasts_num']-3), 'comments'));
					if($row_wall['fasts_num'] < 4)
						$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
					else {
						$tpl->set('{rec-id}', $row_wall['id']);
						$tpl->set('[all-comm]', '');
						$tpl->set('[/all-comm]', '');
					}
					$tpl->set('{public-id}', $row_comments['public_id']);
					$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
					$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
					$tpl->set_block("'\\[comment\\](.*?)\\[/comment\\]'si","");
					$tpl->compile($this->compile);
				
					//����������� ������� ��������
					foreach($sql_comments as $row_comments){
						$tpl->set('{public-id}', $row_comments['public_id']);
						$tpl->set('{name}', $row_comments['user_search_pref']);
						if($row_comments['user_photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_comments['public_id'].'/50_'.$row_comments['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						$tpl->set('{comm-id}', $row_comments['id']);
						$tpl->set('{user-id}', $row_comments['public_id']);
						
						$expBR2 = explode('<br />', $row_comments['text']);
						$textLength2 = count($expBR2);
						$strTXT2 = strlen($row_comments['text']);
						if($textLength2 > 6 OR $strTXT2 > 470)
							$row_comments['text'] = '<div class="wall_strlen" id="hide_wall_rec'.$row_comments['id'].'" style="max-height:102px"">'.$row_comments['text'].'</div><div class="wall_strlen_full" onMouseDown="wall.FullText('.$row_comments['id'].', this.id)" id="hide_wall_rec_lnk'.$row_comments['id'].'">�������� ���������..</div>';
										
						$tpl->set('{text}', stripslashes($row_comments['text']));
						megaDate($row_comments['add_date']);
						if($public_admin OR $user_id == $row_comments['public_id']){
							$tpl->set('[owner]', '');
							$tpl->set('[/owner]', '');
						} else
							$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
					
						$tpl->set('[comment]', '');
						$tpl->set('[/comment]', '');
						$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
						$tpl->set_block("'\\[comment-form\\](.*?)\\[/comment-form\\]'si","");
						$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
						$tpl->compile($this->compile);
					}

					//��������� ����� ������
					$tpl->set('{rec-id}', $row_wall['id']);
					$tpl->set('{user-id}', $row_wall['public_id']);
					$tpl->set('[comment-form]', '');
					$tpl->set('[/comment-form]', '');
					$tpl->set_block("'\\[record\\](.*?)\\[/record\\]'si","");
					$tpl->set_block("'\\[comment\\](.*?)\\[/comment\\]'si","");
					$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
					$tpl->compile($this->compile);
					
					//��������� ���� ��� JS
					$tpl->result[$this->compile] .= '</div>';
				}
			}
		}
	}
}
?>