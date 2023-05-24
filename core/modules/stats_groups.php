<?php
/* 
	Appointment: ���������� ����������
	File: stats_groups.php 
	Author: f0rt1 
	Engine: Vii Engine
	Copyright: NiceWeb Group (�) 2011
	e-mail: niceweb@i.ua
	URL: http://www.niceweb.in.ua/
	ICQ: 427-825-959
	������ ��� ������� ���������� �������
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){

	$act = $_GET['act'];

	switch($act){
		
		default:
		
			//################### ������� ���������� ###################//
			
			$gid = intval($_GET['gid']);
			
			$month = intval($_GET['m']);
			if($month AND $month <= 0 OR $month > 12) $month = 2;
			
			$year = intval($_GET['y']);
			if($year AND $year < 2013 OR $year > 2020) $year = 2013;
			
			//������� ������ ����������
			$owner = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '{$gid}'");
			
			//�������� �� ������
			if(strpos($owner['admin'], "u{$user_info['user_id']}|") !== false){

				if($month AND $year){
				
					$stat_date = date($year.'-'.$month, $server_time);
					$r_month = date($month, $server_time);
					
				} else {
				
					$stat_date = date('Y-m', $server_time);
					$r_month = date('m', $server_time);
					
					$month = date('n', $server_time);

				}

				$stat_date = strtotime($stat_date);

				$t_date = langdate('F', $stat_date);
				
				//���������� ������ ��� ������ �� ���� �����
				$sql_ = $db->super_query("SELECT cnt, date, hits, new_users, exit_users FROM `".PREFIX."_communities_stats` WHERE gid = '{$gid}' AND date_x = '{$stat_date}' ORDER by `date` ASC", 1);

				if($sql_){
				
					foreach($sql_ as $row){
						
						$dat_exp = date('j', $row['date']);

						$arr_r_unik[$dat_exp] = $row['cnt'];

						$arr_r_hits[$dat_exp] = $row['hits'];
						
						$arr_r_new_users[$dat_exp] = $row['new_users'];
						
						$arr_r_exit_users[$dat_exp] = $row['exit_users'];
					
					}
				
				}
				
				if($r_month == '01' OR $r_month == '03' OR $r_month == '05' OR $r_month == '07' OR $r_month == '08' OR $r_month == '10' OR $r_month == '12' OR $r_month == '1' OR $r_month == '3' OR $r_month == '5' OR $r_month == '7' OR $r_month == '8') $limit_day = 31;
				elseif($r_month == '02') $limit_day = 28;
				else $limit_day = 30;
				
				for($i = 1; $i <= $limit_day; $i++){
					
					if(!$arr_r_unik[$i]) $arr_r_unik[$i] = 0;
					$r_unik .= '['.$i.', '.$arr_r_unik[$i].'],';
					
					if(!$arr_r_hits[$i]) $arr_r_hits[$i] = 0;
					$r_hits .= '['.$i.', '.$arr_r_hits[$i].'],';
					
					if(!$arr_r_new_users[$i]) $arr_r_new_users[$i] = 0;
					$r_new_users .= '['.$i.', '.$arr_r_new_users[$i].'],';
					
					if(!$arr_r_exit_users[$i]) $arr_r_exit_users[$i] = 0;
					$r_exit_users .= '['.$i.', '.$arr_r_exit_users[$i].'],';
					
				}

				//������� ������������ ���-�� ������ �� ���� �����
				$row_max = $db->super_query("SELECT cnt FROM `".PREFIX."_communities_stats` WHERE gid = '{$gid}' AND date_x = '{$stat_date}' ORDER by `cnt` DESC");
				
				$rNum = round($row_max['cnt'] / 15);
				if($rNum < 1) $rNum = 1;

				$tickSize = $rNum;

				//������� ������������ ���-�� ���������� �� ���� �����
				$row_max_hits = $db->super_query("SELECT hits FROM `".PREFIX."_communities_stats` WHERE gid = '{$gid}' AND date_x = '{$stat_date}' ORDER by `hits` DESC");
				
				$rNum_hits = round($row_max_hits['hits'] / 15);
				if($rNum_hits < 1) $rNum_hits = 1;

				$tickSize_hits = $rNum_hits;
				$tickSize = $rNum;
								
				//������� ������������ ���-�� ����� ������ �� ���� �����
				$row_max_new_users = $db->super_query("SELECT new_users FROM `".PREFIX."_communities_stats` WHERE gid = '{$gid}' AND date_x = '{$stat_date}' ORDER by `new_users` DESC");
				
				$rNum_new_users = round($row_max_new_users['new_users'] / 15);
				if($rNum_new_users < 1) $rNum_new_users = 1;

				$tickSize_new_users = $rNum_new_users;

				//������� ������������ ���-�� �������� ������ �� ���� �����
				$row_max_exit_users = $db->super_query("SELECT exit_users FROM `".PREFIX."_communities_stats` WHERE gid = '{$gid}' AND date_x = '{$stat_date}' ORDER by `exit_users` DESC");
				
				$rNum_exit_users = round($row_max_exit_users['exit_users'] / 15);
				if($rNum_exit_users < 1) $rNum_exit_users = 1;

				$tickSize_exit_users = $rNum_exit_users;
				
				//��������� ������
				$tpl->load_template('public_stats/head.tpl');
				
				$tpl->set('{r_unik}', $r_unik);
				$tpl->set('{r_hits}', $r_hits);
				$tpl->set('{r_new_users}', $r_new_users);
				$tpl->set('{r_exit_users}', $r_exit_users);
				$tpl->set('{t-date}', $t_date);
				$tpl->set('{tickSize}', $tickSize);
				$tpl->set('{tickSize_hits}', $tickSize_hits);
				$tpl->set('{tickSize_new_users}', $tickSize_new_users);
				$tpl->set('{tickSize_exit_users}', $tickSize_exit_users);
				$tpl->set('{gid}', $gid);

				$tpl->set('{months}', installationSelected($month, '<option value="1">������</option><option value="2">�������</option><option value="3">����</option><option value="4">������</option><option value="5">���</option><option value="6">����</option><option value="7">����</option><option value="8">������</option><option value="9">��������</option><option value="10">�������</option><option value="11">������</option><option value="12">�������</option>'));
				$tpl->set('{year}', installationSelected($year, '<option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option>'));
				
				$tpl->compile('content');

			} else

				msgbox('', '������ �������!', 'info');

	}
	
	$tpl->clear();
	$db->free();
	
} else {

	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
	
}
?>