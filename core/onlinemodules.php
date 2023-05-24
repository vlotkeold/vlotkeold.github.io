<?php
/* 
	Appointment: ����������� �������
	File: mod.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if(isset($_GET['go']))
	$go = htmlspecialchars(strip_tags(stripslashes(trim(urldecode(mysql_escape_string($_GET['go']))))));
else
	$go = "main";

$mozg_module = $go;

check_xss();

switch($go){
	
	//�����������
	case "register":
		include ENGINE_DIR.'/modules/register.php';
	break;
	
	//Stikers
	case "stikers":
		include ENGINE_DIR.'/modules/stikers.php';
	break;
	
	//Langs
	case "lang":
		include ENGINE_DIR.'/modules/lang.php';
	break;
	
	//Login
	case "llogin":
		include ENGINE_DIR.'/modules/llogin.php';
	break;
	
	//� �����
	case "about":
		$spBar = true;
		include ENGINE_DIR.'/modules/about.php';
	break;
	
	//� �����
	case "abouts":
		include ENGINE_DIR.'/modules/abouts.php';
	break;
	
	//Reg
	case "rreg":
		include ENGINE_DIR.'/modules/rreg.php';
	break;
	
	//�������������
	case "dev":
		include ENGINE_DIR.'/modules/dev.php';
	break;
	
	//������
	case "jobs":
		include ENGINE_DIR.'/modules/jobs.php';
	break;
	
	case "job":
		include ENGINE_DIR.'/modules/job.php';
	break;
	
	//Terms
	case "terms":
		include ENGINE_DIR.'/modules/terms.php';
	break;
	
	//��� � ���������
	case "im_chat":
		include ENGINE_DIR.'/modules/im_chat.php';
	break;
	
	//ADS
	case "ads":
		include ENGINE_DIR.'/modules/ads.php';
	break;
	
	//��������
	case "graffiti":
		include ENGINE_DIR.'/modules/graffiti.php';
	break;
	
	//������� ������������
	case "profile":
		$spBar = true;
		include ENGINE_DIR.'/modules/profile.php';
	break;
	
	//���������� ���������
	case "stats_groups":
		include ENGINE_DIR.'/modules/stats_groups.php';
	break;
	
	//�������������� ���� ��������
	case "editprofile":
		include ENGINE_DIR.'/modules/editprofile.php';
	break;
	
	//�������� �������
	case "loadcity":
		include ENGINE_DIR.'/modules/loadcity.php';
	break;
	
	//Apps
	case "apps":
		include ENGINE_DIR.'/modules/apps.php';
	break;
	
	//editapps
	case "editapp":
		$css_loading = 'apps_edit';
		include ENGINE_DIR.'/modules/editapp.php';
	break;
	
	//�������
	case "albums":
		if($config['album_mod'] == 'yes')
			include ENGINE_DIR.'/modules/albums.php';
		else {
			$user_speedbar = '����������';
			msgbox('', '������ ��������.', 'info');
		}
	break;
	
	//�������
	case "groups_albums":
		include ENGINE_DIR.'/modules/albums_groups.php';
	break;
	
	//�������� ����������
	case "photo":
		include ENGINE_DIR.'/modules/photo.php';
	break;
	
	case "photo_groups":
		include ENGINE_DIR.'/modules/photo_groups.php';
	break;
	
	//������
	case "friends":
		include ENGINE_DIR.'/modules/friends.php';
	break;
	
	//��������
	case "fave":
		include ENGINE_DIR.'/modules/fave.php';
	break;
	
	//���������
	case "messages":
		include ENGINE_DIR.'/modules/messages.php';
	break;
	
	//�������
	case "im":
		include ENGINE_DIR.'/modules/im.php';
	break;

	//�������
	case "notes":
		include ENGINE_DIR.'/modules/notes.php';
	break;
	
	//������ � AJAX
    case "ajaxfriends":
		include ENGINE_DIR.'/modules/ajaxfriends.php';
    break;
	
	//��������� � AJAX
    case "ajaxmsg":
		include ENGINE_DIR.'/modules/ajaxmsg.php';
    break;
	
	//���� � AJAX
    case "ajaxphoto":
		include ENGINE_DIR.'/modules/ajaxphoto.php';
    break;
	
	//��������
	case "subscriptions":
		include ENGINE_DIR.'/modules/subscriptions.php';
	break;
	
	//�����
	case "videos":
		if($config['video_mod'] == 'yes')
			include ENGINE_DIR.'/modules/videos.php';
		else {
			$user_speedbar = '����������';
			msgbox('', '������ ��������.', 'info');
		}
	break;
	
	//�����
	case "search":
		include ENGINE_DIR.'/modules/search.php';
	break;
	
	//�����
	case "wall":
		include ENGINE_DIR.'/modules/wall.php';
	break;
	
	//������
	case "status":
		include ENGINE_DIR.'/modules/status.php';
	break;
	
	//�������
	case "news":
		include ENGINE_DIR.'/modules/news.php';
	break;
	
	//���������
	case "settings":
		include ENGINE_DIR.'/modules/settings.php';
	break;
	
	//������
	case "support":
		include ENGINE_DIR.'/modules/support.php';
	break;
	
	//�������������� �������
	case "restore":
		include ENGINE_DIR.'/modules/restore.php';
	break;
	
	//�������� �������� ��� ������������ ������ �� �����, �������, ��� ���������
	case "attach":
		include ENGINE_DIR.'/modules/attach.php';
	break;
	
	//���� �����
	case "blog":
		include ENGINE_DIR.'/modules/blog.php';
	break;

	//������
	case "balance":
		include ENGINE_DIR.'/modules/balance.php';
	break;
	
	//�������
	case "gifts":
		include ENGINE_DIR.'/modules/gifts.php';
	break;

	//����������
	case "groups":
		include ENGINE_DIR.'/modules/groups.php';
	break;
	
	//����������
	case "clubs":
		include ENGINE_DIR.'/modules/clubs.php';
	break;
	
	//���������� -> ��������� ��������
	case "public":
		$spBar = true;
		include ENGINE_DIR.'/modules/public.php';
	break;
	
	//���������� -> ������
	case "club":
		$spBar = true;
		include ENGINE_DIR.'/modules/club.php';
	break;
	
	//���������� -> �������� ����
	case "attach_groups":
		include ENGINE_DIR.'/modules/attach_groups.php';
	break;
	
	//���������� -> �������� ����
	case "attach_clubs":
		include ENGINE_DIR.'/modules/attach_clubs.php';
	break;

	//������
	case "audio":
		if($config['audio_mod'] == 'yes')
			include ENGINE_DIR.'/modules/audio.php';
		else {
			$user_speedbar = '����������';
			msgbox('', '������ ��������.', 'info');
		}
	break;
	
	//����� � ����
	case "audio_player":
		if($config['audio_mod'] == 'yes')
			include ENGINE_DIR.'/modules/audio_player.php';
		else {
			$spBar = true;
			$user_speedbar = '����������';
			msgbox('', '������ ��������.', 'info');
		}
	break;

	//����������� ��������
	case "static":
		include ENGINE_DIR.'/modules/static.php';
	break;

	//�������� �������� �� ����
	case "distinguish":
		include ENGINE_DIR.'/modules/distinguish.php';
	break;

	//�������� ���� ��� �������� ������
	case "happy_friends_block_hide":
		$_SESSION['happy_friends_block_hide'] = 1;
		die();
	break;

	//�������� ���� ��� �������� ������
	case "fast_search":
		include ENGINE_DIR.'/modules/fast_search.php';
	break;

	//������
	case "report":
		include ENGINE_DIR.'/modules/report.php';
	break;
	
	// ������
	case "alias":
	$spBar = true;
    $alias = $db->safesql($_GET['url']);
	if($alias){
	$alias_club = $db->super_query("SELECT id,title FROM `".PREFIX."_clubs` WHERE adres = '".$alias."' "); //��������� ������ � �����
 	$alias_public = $db->super_query("SELECT id,title FROM `".PREFIX."_communities` WHERE adres = '".$alias."' "); //��������� ������ � ��������� �������
	$alias_user = $db->super_query("SELECT user_id, user_search_pref FROM `".PREFIX."_users` WHERE alias = '".$alias."'"); // ��������� ������ � �������������
    if($alias_user){   			
	    $_GET['id']= $alias_user['user_id'];
	    include ENGINE_DIR.'/modules/profile.php';
		}elseif($alias_public){   		
		$_GET['pid']= $alias_public['id'];
		include ENGINE_DIR.'/modules/public.php';
		}elseif($alias_club){   		
		$_GET['gid']= $alias_club['id'];
		include ENGINE_DIR.'/modules/club.php';
	}else{
	$spBar = true;
			$user_speedbar = '����������';
			msgbox('', '�������� ��� <b>'.$alias.'</b> �������� ��� �����������.', 'info');
	}
	}
    break;

	//�������� ������ � ���������� ��� �����
	case "repost":
		include ENGINE_DIR.'/modules/repost.php';
	break;

	//������������ ����������
	case "updates":
		include ENGINE_DIR.'/modules/updates.php';
	break;
	
	//����������
	case "board":
		include ENGINE_DIR.'/modules/board.php';
	break;

	//���������
	case "doc":
		include ENGINE_DIR.'/modules/doc.php';
	break;

	//������
	case "votes":
		include ENGINE_DIR.'/modules/votes.php';
	break;
	
	case "rating":
		include ENGINE_DIR.'/modules/rating.php';
	break;
	
	case "editpage":
		include ENGINE_DIR.'/modules/editpage.php';
	break;
	
	case "editclub":
		include ENGINE_DIR.'/modules/editclub.php';
	break;
	
	//���������� -> ��������� �������� -> �����������
	case "public_audio":
		include ENGINE_DIR.'/modules/public_audio.php';
	break;
	
	//���������� �������� ������������
	case "my_stats":
		include ENGINE_DIR.'/modules/my_stats.php';
	break;	
	
	//���������� -> ��������� �������� -> �����������
	case "public_videos":
		include ENGINE_DIR.'/modules/public_videos.php';
	break;
	
	//���������� => ����������
	case "groups_forum":
		include ENGINE_DIR.'/modules/groups_forum.php';
    break;
	
	//���������� -> ������ -> �����������
	case "club_audio":
		include ENGINE_DIR.'/modules/club_audio.php';
	break;
	
	case "forum":
		include ENGINE_DIR.'/modules/forum.php';
	break;



		default:
			$spBar = true;
			
			/*if($logged)
				header("Location: /u{$user_info['user_id']}");
			else*/
				if($go != 'main')
					msgbox('', $lang['no_str_bar'], 'info');
}

if(!$metatags['title'])
	$metatags['title'] = $config['home'];
	
if($user_speedbar) 
	$speedbar = $user_speedbar;
else 
	$speedbar = $lang['welcome'];

$headers = '<title>'.$metatags['title'].'</title>
<meta name="generator" content="TOEngine" />
<meta http-equiv="content-type" content="text/html; charset=windows-1251" />';
?>