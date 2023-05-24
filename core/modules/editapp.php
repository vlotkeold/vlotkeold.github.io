<?php

if(!defined('MOZG'))
	die('� �� �� ��� �����??');

if($ajax == 'yes')
	NoAjaxQuery();

$user_id = $user_info['user_id'];

$key = 'sofwar';

$act = $_GET['act'];
if($logged){

	switch($act){
		//�������� ����������
		case "create":
			$metatags['title'] = '�������� ����������';
			$tpl->load_template('apps/editapp/create.tpl');
			$tpl->compile('content');
		
		break;
		//�������� ����������
		case "do_create":
			$title = $_POST['title'];
			$desc = $_POST['desc'];
			$secret = md5($key.'asd4465a4das56d4as65'.rand(99,9999)); // ���������� ��������� ����
			$db->query("SET NAMES 'utf8'"); // � ������ �� �� ���� ��������� ��������)

			$db->query("INSERT INTO `".PREFIX."_apps` (`id`,`title`,`desc`,`secret`,`user_id`) VALUES ('','".$title."','".$desc."','".$secret."','".$user_id."') "); 
			$dbid = $db->insert_id();
			 echo $dbid;
			 	die(); // �������� ��������� ���������� ������ ��� �� ������ ����� ������ �����
		break;
		//������� info
		case "info":
			$metatags['title'] = '�������������� ����������';
			$id = intval($_GET['id']);
			$row = $db->super_query("SELECT `id`, `title`, `desc`, `img`,`secret`,`user_id`,`admins` FROM `".PREFIX."_apps` WHERE `id`='{$id}'");
			$array_admin = explode('|', $row['admins']);

			if(in_array($user_id, $array_admin) or $user_id == $row['user_id'] ){
				if($row['img'] == ''){
					$img = '/uploads/apps/no.gif';
				} else $img = '/uploads/apps/'.$row['id'].'/100_'.$row['img'];

				$tpl->set('{id}', $row['id']);
				$tpl->set('{title}', $row['title']);
				$tpl->set('{img}', $img);
				$tpl->set('{desc}', $row['desc']);
				$tpl->set('{hash}', md5($id.'_'.$key));
				$tpl->load_template('apps/editapp/info.tpl');
				$tpl->compile('content');
			}else{
				$tpl->load_template('apps/editapp/error.tpl');
				$tpl->compile('content');
			} 
		break;

		// ���������� �������� info
		case "save_info":
			NoAjaxQuery();

			$id = intval($_POST['app']);
			$app_hash = $_POST['app_hash'];
			$title = $_POST['app_title'];
			$desc = $_POST['app_desc'];

			if($app_hash == md5($id.'_'.$key)){
				if($title == '') die("name");
				elseif($desc == '') die("desc");

				$db->query("SET NAMES 'utf8'"); // � ������ �� �� ���� ��������� ��������)

				$db->query("UPDATE `".PREFIX."_apps` SET `title`='{$title}', `desc`='{$desc}' WHERE `id`='{$id}'");
				echo "ok";
			}else{
				$tpl->load_template('apps/editapp/error.tpl');
				$tpl->compile('content');
			} 
		break;


		//������� ���������

		case "options":
			$metatags['title'] = '�������������� ����������';
			$id = intval($_GET['id']);

			$row = $db->super_query("SELECT `id`, `title`, `desc`, `img`,`status`,`secret`,`width`,`height`,`url`,`user_id`,`admins`,`type` FROM `".PREFIX."_apps` WHERE `id`='{$id}'");

			$array_admin = explode('|', $row['admins']);

			if(in_array($user_id, $array_admin) or $user_id == $row['user_id'] ){
				// ������� �����, �� � �����)
				if($row['status'] == 1){
					$option = '<option value="1" selected="selected">���������� �������� � ����� ����</option><option value="-1" >���������� ���������</option>';
				}else{
					$option = '<option value="1" >���������� �������� � ����� ����</option><option value="-1" selected="selected">���������� ���������</option>';
				}

				if($row['type'] == 1){
					$type = '<option value="1" selected="selected">Iframe</option><option value="2">Flash</option>';
					$tpl->set('{sflash}', 'none');
					$tpl->set('{siframe}', 'table');
				}else{
					$type = '<option value="1">Iframe</option><option value="2" selected="selected">Flash</option>';
					$tpl->set('{sflash}', 'table');
					$tpl->set('{siframe}', 'none');
				}
           		$tpl->set('{id}', $row['id']);
           		$tpl->set('{url}', $row['url']);
				$tpl->set('{title}', $row['title']);
				$tpl->set('{desc}', $row['desc']);
				$tpl->set('{height}', $row['height']);
				$tpl->set('{width}', $row['width']);
				$tpl->set('{img}', '/uploads/apps/'.$row['id'].'/100_'.$row['img']);
				$tpl->set('{status}', $row['status']);
				$tpl->set('{option}', $option);
				$tpl->set('{type}', $type);
				$tpl->set('{secret}', $row['secret']);
				$tpl->set('{hash}', md5($id.'_'.$key));
				$tpl->load_template('apps/editapp/options.tpl');
				$tpl->compile('content');
			}else{
				$tpl->load_template('apps/editapp/error.tpl');
				$tpl->compile('content');
			} 
		break;

		// ���������� �������� info
		case "save_options":
			NoAjaxQuery();

			$id = intval($_POST['app']);
			$app_hash = $_POST['app_hash'];
			$secret = $_POST['app_secret'];
			$url = $_POST['app_url'];
			$status = intval($_POST['app_status']);
			$width = intval($_POST['app_width']);
			$height = intval($_POST['app_height']);
			$type = intval($_POST['app_type']);

			if($secret == '') die("secret2");
			elseif($url == '' and $type == '1') die("iframe_url");
			elseif($width == '' and $type == '1') die("iframe_width");
			elseif($height == '' and $type == '1') die("iframe_height");
			
			if($app_hash == md5($id.'_'.$key)){
				$db->query("UPDATE `".PREFIX."_apps` SET `secret`='{$secret}', `status`='{$status}', `url`='{$url}', `width`='{$width}', `height`='{$height}', `type`='{$type}' WHERE `id`='{$id}'");
				echo "ok";
			}else{
				$tpl->load_template('apps/editapp/error.tpl');
				$tpl->compile('content');
			} 
		break;

			//���� �������� swf
		case "load_flash":
			NoAjaxQuery();
			$tpl->set('{id}', intval($_GET['id']));
			$tpl->load_template('/apps/editapp/load_flash.tpl');
			$tpl->compile('content');
			AjaxTpl();
			die();
		break;


		case 'flash':
			NoAjaxQuery();

			$id = intval($_GET['id']);

			$flash_tmp = $_FILES['uploadfile']['tmp_name'];
			$flash_name = totranslit($_FILES['uploadfile']['name']); // ������������ �������� ��� ����������� �������
			$flash_rename = substr(md5($server_time+rand(1,100000)), 0, 15); // ��� ����������
			$flash_size = $_FILES['uploadfile']['size']; // ������ �����
			$type = end(explode(".", $flash_name)); // ������ �����

			//�������� ����, ������ ������ �� ����������
			if(strtolower($type) == 'swf'){
				$res_type = '.'.$type;
				$db->query("UPDATE `".PREFIX."_apps` SET `flash`='{$flash_rename}{$res_type}' WHERE `id`='{$id}'");

				$flash_dir = ROOT_DIR.'/uploads/apps/'.$id.'/';
				if(!is_dir($flash_dir)){
					@mkdir($flash_dir, 0777);
					@chmod($flash_dir, 0777);
				}

				move_uploaded_file($flash_tmp, $flash_dir.$flash_rename.'.swf');
				echo 'ok';
			} else	echo 'bad_format';
		break;



		//������� �������

		case "payments":
			$metatags['title'] = '�������������� ����������';
			$id = intval($_GET['id']);
			$row = $db->super_query("SELECT `id`,`user_id`,`balance`,`admins` FROM `".PREFIX."_apps` WHERE `id`='{$id}'");

			$array_admin = explode('|', $row['admins']);

			if(in_array($user_id, $array_admin) or $user_id == $row['user_id'] ){
				$row1 = $db->super_query("SELECT `id`, `votes`, `from`, `whom`,`date`,`application_id` FROM `".PREFIX."_apps_transactions` WHERE `application_id`='{$id}' ORDER BY id DESC LIMIT 20",1);
			
				$tpl->load_template('apps/editapp/table.tpl');
				foreach($row1  as $rowsd){
					$users = $db->super_query("SELECT `user_name`, `user_lastname` FROM `".PREFIX."_users` WHERE `user_id`='{$rowsd[whom]}'");
			
					if(date('Y-m-d', $rowsd['date']) == date('Y-m-d', $server_time)) $dateTell = langdate('������� � H:i', $rowsd['date']);	else $dateTell = langdate('j F Y � H:i', $rowsd['date']);

					$tpl->set('{name}', $users['user_name'].' '.$users['user_lastname']);
					//$tpl->set('{from}', $rowsd['from']);
					$tpl->set('{from}', $rowsd['whom']);
					$tpl->set('{whom}', $rowsd['whom']);
					$tpl->set('{date}', $dateTell);
					$tpl->set('{application_id}', $rowsd['application_id']);
					$tpl->set('{id}', $rowsd['id']);
					$tpl->set('{votes}', $rowsd['votes']);
					$tpl->compile('payments');
				
				}	
					$tpl->set('{id}', $id);
					$tpl->set('{balance}', $row['balance']);
					$tpl->load_template('apps/editapp/payments.tpl');
					$tpl->set('{hash}', md5($key.'asd4465a4das56d4as65'));
					$tpl->set('{payments}', $tpl->result['payments']);
					$tpl->compile('content');
			}else{
				$tpl->load_template('apps/editapp/error.tpl');
				$tpl->compile('content');
			} 

		break;

		//������� ��������������

		case "admins":
			$metatags['title'] = '�������������� ����������';
			$id = intval($_GET['id']);

			$row = $db->super_query("SELECT `id`,`user_id`,`admins`, `admins_num` FROM `".PREFIX."_apps` WHERE `id`='{$id}'");
			$array_admin = explode('|', $row['admins']);

			if(in_array($user_id, $array_admin) or $user_id == $row['user_id'] ){

				$array_admins = explode('|', $row['admins']);
				$tpl->load_template('apps/editapp/admin_all.tpl');
				foreach($array_admins as $user){
					if($user){
						$infoUser = $db->super_query("SELECT user_photo, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$user}'");
						
						if($infoUser['user_photo'])
							$tpl->set('{img}', '/uploads/users/'.$user.'/50_'.$infoUser['user_photo']);
						else
							$tpl->set('{img}', '/images/no_ava_50.png');
						
						$tpl->set('{name}', $infoUser['user_search_pref']);
						$tpl->set('{uid}', $user);
						
						$tpl->compile('all');
					}
				}

				$users = $db->super_query("SELECT user_search_pref, user_photo FROM `".PREFIX."_users` WHERE `user_id`='{$row[user_id]}'");

				$tpl->set('{id}', $id);
				if($users['user_photo'])
					$tpl->set('{img}', '/uploads/users/'.$row['user_id'].'/50_'.$users['user_photo']);
				else
					$tpl->set('{img}', '/templates/Default/images/no_ava_50.png');

				$tpl->set('{name}', $users['user_search_pref']);
				$tpl->set('{uid}', $row['user_id']);
				$tpl->set('{numadmin}', $row['admins_num'].' '.gram_record($count_common['cnt'], 'admins'));
				$tpl->set('{hash}', md5($id.'_'.$key));

				$tpl->set('{all}', $tpl->result['all']);								
				$tpl->load_template('apps/editapp/admins.tpl');
				$tpl->compile('content');

			}else{
				$tpl->load_template('apps/editapp/error.tpl');
				$tpl->compile('content');
			} 

		break;

		case 'save_admin':
			$id = intval($_POST['id']);
			$app_hash = $_POST['hash'];
			$addr = intval($_POST['addr']);

			if($app_hash == md5($id.'_'.$key)){
				//��������� �� ������������� �����
				$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_id = '{$addr}'");
				if(!$row['cnt']) die('not_user');
				$myRow = $db->super_query("SELECT admins,user_id FROM `".PREFIX."_apps` WHERE id = '{$id}'");
				$array_admin = explode('|', $myRow['admins']);
				if(!in_array($addr, $array_admin) AND $user_id != $addr AND $myRow['user_id'] != $addr){
					$db->query("UPDATE `".PREFIX."_apps` SET admins_num = admins_num+1, admins = '{$myRow['admins']}|{$addr}|' WHERE id = '{$id}'");
					echo 'ok';
				} else echo "not";
			
			}else{
				$tpl->load_template('apps/editapp/error.tpl');
				$tpl->compile('content');
			} 
			die();
    	break;

    	case 'del_admin':
			$id = intval($_POST['id']);
			$app_hash = $_POST['hash'];
			$addr = intval($_POST['addr']);

			if($app_hash == md5($id.'_'.$key)){

				$myRow = $db->super_query("SELECT admins,user_id FROM `".PREFIX."_apps` WHERE id = '{$id}'");
				$array_admin = explode('|', $myRow['admins']);

				if($myRow['user_id'] == $addr) die("general");

				if(in_array($addr, $array_admin) AND $user_id != $addr){
					$myRow['admins'] = str_replace("|{$addr}|", "", $myRow['admins']);
					$db->query("UPDATE `".PREFIX."_apps` SET admins_num = admins_num-1, admins = '{$myRow['admins']}' WHERE id = '{$id}'");
					echo 'ok';
				} else echo "not";
			
			}else{
				$tpl->load_template('apps/editapp/error.tpl');
				$tpl->compile('content');
			} 
			die();
    	break;

		case "del_admin_form":
			$id = intval($_POST['id']);
			$addr = intval($_POST['addr']);
			$app_hash = $_POST['hash'];

			if($app_hash == md5($id.'_'.$key)){
    			$app = $db->super_query("SELECT `title` FROM `".PREFIX."_apps` WHERE id = '{$id}'");
    			$users = $db->super_query("SELECT `user_name`, `user_lastname` FROM `".PREFIX."_users` WHERE user_id = '{$addr}'");

    			$tpl->set('{id}', $id);
				$tpl->set('{title}', $app['title']);
				$tpl->set('{uid}', $addr);
				$tpl->set('{name}', $users['user_name']. ' '. $users['user_lastname']);
  				$tpl->load_template('apps/editapp/del_admin_form.tpl');
   				$tpl->compile('content');
   			}else{
				$tpl->load_template('apps/editapp/error.tpl');
				$tpl->compile('content');
			} 
			AjaxTpl();
  			die();
 			$tpl->clear();
  			$db->free();
  		break;

  		case "search_admin":
    		$row = $db->super_query("SELECT user_photo, user_id FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
  			$tpl->load_template('apps/editapp/add_admin.tpl');
   			if($row['user_photo']){
    			$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/50_'.$row['user_photo']);
   			} else {
    			$tpl->set('{ava}', '/temlates/Default/images/no_ava_50.png');
   			}
   			$tpl->compile('content');
			AjaxTpl();
  			die();
 			$tpl->clear();
  			$db->free();
  		break;

  		case "checkAdmin":
   			NoAjaxQuery();
   			$id = intval($_POST['id']);
   			$row = $db->super_query("SELECT user_photo, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$id}'");
   			if($row) echo $row['user_search_pref']."|".$row['user_photo'];
   			die();
  		break;
		
		//�������� ����������


		case "deleteapp":
			$id = intval($_POST['app']);
			$app_hash = $_POST['app_hash'];

			if($app_hash == md5($id.'_'.$key)){
				$app = $db->super_query("SELECT `title` FROM `".PREFIX."_apps` WHERE id = '{$id}'");
				if($app['user_id'] == $user_id){
					$db->query("DELETE FROM `".PREFIX."_apps` WHERE `id`='{$id}'");
					echo "ok";
				} else echo "not";
				
			}else{
				$tpl->load_template('apps/editapp/error.tpl');
				$tpl->compile('content');
			} 
		break;
		
	

		//���� �������� ����������
		case "load_photo":
			NoAjaxQuery();
			$tpl->set('{id}', intval($_GET['id']));
			$tpl->load_template('/apps/editapp/load_photo.tpl');
			$tpl->compile('content');
			AjaxTpl();
			die();
		break;

		//������� �������� ����
		case "upload":
			NoAjaxQuery();

			include ENGINE_DIR.'/classes/images.php';

			$id = intval($_GET['id']);

			$uploaddir = ROOT_DIR.'/uploads/apps/';
			
			//���� ��� ����� �����, �� ������ �
			if(!is_dir($uploaddir.$id)){ 
				@mkdir($uploaddir.$id, 0777 );
				@chmod($uploaddir.$id, 0777 );
			}
			//����������� �������
			$allowed_files = array('jpg', 'png', 'gif');

			//�������� ������ � ����������
			$image_tmp = $_FILES['uploadfile']['tmp_name'];
			$image_name = totranslit($_FILES['uploadfile']['name']); // ������������ �������� ��� ����������� �������
			$image_rename = substr(md5($server_time+rand(1,100000)), 0, 15); // ��� ����������
			$image_size = $_FILES['uploadfile']['size']; // ������ �����
			$type = end(explode(".", $image_name)); // ������ �����

			if(in_array($type, $allowed_files)){
				if($image_size < 5000000){
					$res_type = '.'.$type;
					$uploaddir = ROOT_DIR.'/uploads/apps/'.$id.'/'; // ���������� ���� ���������
					if(move_uploaded_file($image_tmp, $uploaddir.$image_rename.$res_type)) {
					
						//�������� ���������� ����� 100�100
						$tmb = new thumbnail($uploaddir.$image_rename.$res_type);
						$tmb->size_auto('100x100');
						$tmb->jpeg_quality(97);
						$tmb->save($uploaddir.'100_'.$image_rename.$res_type);

						$image_rename = $db->safesql($image_rename);
						$res_type = $db->safesql($res_type);

						$db->query("UPDATE `".PREFIX."_apps` SET `img`='{$image_rename}{$res_type}' WHERE `id`='{$id}'");
						echo $config['home_url'].'uploads/apps/'.$id.'/100_'.$image_rename.$res_type;

					} else
						echo 'bad';
				} else
					echo 'big_size';
			} else
				echo 'bad_format';

		break;

	}
	$db->free();
	$tpl->clear();
} else {
	$user_speedbar = '����������';
	msgbox('', $lang['not_logged'], 'info');
}
?>