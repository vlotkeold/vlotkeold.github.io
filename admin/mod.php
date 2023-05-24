<?php
/* 
	Appointment: ����������� ��������� �������
	File: mod.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

$mod = htmlspecialchars(strip_tags(stripslashes(trim(urldecode(mysql_escape_string($_GET['mod']))))));

check_xss();

// ����������� ��� ����
$langdate = array (
'January'		=>	"������",
'February'		=>	"�������",
'March'			=>	"�����",
'April'			=>	"������",
'May'			=>	"���",
'June'			=>	"����",
'July'			=>	"����",
'August'		=>	"�������",
'September'		=>	"��������",
'October'		=>	"�������",
'November'		=>	"������",
'December'		=>	"�������",
'Jan'			=>	"���",
'Feb'			=>	"���",
'Mar'			=>	"���",
'Apr'			=>	"���",
'Jun'			=>	"���",
'Jul'			=>	"���",
'Aug'			=>	"���",
'Sep'			=>	"���",
'Oct'			=>	"���",
'Nov'			=>	"���",
'Dec'			=>	"���",

'Sunday'		=>	"�����������",
'Monday'		=>	"�����������",
'Tuesday'		=>	"�������",
'Wednesday'		=>	"�����",
'Thursday'		=>	"�������",
'Friday'		=>	"�������",
'Saturday'		=>	"�������",

'Sun'			=>	"��",
'Mon'			=>	"��",
'Tue'			=>	"��",
'Wed'			=>	"��",
'Thu'			=>	"��",
'Fri'			=>	"��",
'Sat'			=>	"��",
);

$server_time = intval($_SERVER['REQUEST_TIME']);

switch($mod){

	//��������� �������
	case "system":
		include ADMIN_DIR.'/system.php';
	break;

	//���������� ��
	case "db":
		include ADMIN_DIR.'/db.php';
	break;

	//dumper
	case "dumper":
		include ADMIN_DIR.'/dumper.php';
	break;

	//������ ���������
	case "mysettings":
		include ADMIN_DIR.'/mysettings.php';
	break;

	//������������
	case "users":
		include ADMIN_DIR.'/users.php';
	break;

	//�������� ��������
	case "massaction":
		include ADMIN_DIR.'/massaction.php';
	break;

	//�������
	case "notes":
		include ADMIN_DIR.'/notes.php';
	break;

	//�������
	case "gifts":
		include ADMIN_DIR.'/gifts.php';
	break;
	
	//Stikers
	case "stikers":
		include ADMIN_DIR.'/stikers.php';
	break;
	
	//Developers News
	case "devnews":
		include ADMIN_DIR.'/devnews.php';
	break;

	//����������
	case "groups":
		include ADMIN_DIR.'/groups.php';
	break;
	
	//������
	case "clubs":
		include ADMIN_DIR.'/clubs.php';
	break;

	//������� �����
	case "tpl":
		include ADMIN_DIR.'/tpl.php';
	break;

	//������� ���������
	case "mail_tpl":
		include ADMIN_DIR.'/mail_tpl.php';
	break;

	//�������� ���������
	case "mail":
		include ADMIN_DIR.'/mail.php';
	break;

	//������ ��: IP, E-Mail
	case "ban":
		include ADMIN_DIR.'/ban.php';
	break;

	//����� � ������
	case "search":
		include ADMIN_DIR.'/search.php';
	break;

	//����������� ��������
	case "static":
		include ADMIN_DIR.'/static.php';
	break;

	//���������
	case "antivirus":
		include ADMIN_DIR.'/antivirus.php';
	break;

	//���� ���������
	case "logs":
		include ADMIN_DIR.'/logs.php';
	break;

	//����������
	case "stats":
		include ADMIN_DIR.'/stats.php';
	break;

	//�����
	case "videos":
		include ADMIN_DIR.'/videos.php';
	break;

	//������
	case "musics":
		include ADMIN_DIR.'/musics.php';
	break;

	//�������
	case "albums":
		include ADMIN_DIR.'/albums.php';
	break;

	//������
	case "country":
		include ADMIN_DIR.'/country.php';
	break;

	//������
	case "city":
		include ADMIN_DIR.'/city.php';
	break;

	//������ �����
	case "report":
		include ADMIN_DIR.'/report.php';
	break;
	
	//��������
	case "jobs":
		include ADMIN_DIR.'/jobs.php';
	break;

	//���. ���� ��������
	case "xfields":
		include ADMIN_DIR.'/xfields.php';
	break;

	default:
	
		include ADMIN_DIR.'/main.php';
}
?>