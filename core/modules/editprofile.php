<?php
/* 
	Appointment: �������������� ��������
	File: editprofile.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$user_id = $user_info['user_id'];
	$act = $_GET['act'];
	
	$metatags['title'] = $lang['editmyprofile'];
	
	switch($act){	
		
		//�������� ����������
		case "upload":
			NoAjaxQuery();
			
			//���������� ����� ��� ����������
			include ENGINE_DIR.'/classes/images.php';
			
			$user_id = $user_info['user_id'];
			$uploaddir = ROOT_DIR.'/uploads/users/';
			$privacy = intval($_POST['privacy']);
			$privacy_comm = intval($_POST['privacy_comm']);
			if($privacy <= 0 OR $privacy > 3) $privacy = 1;
			if($privacy_comm <= 0 OR $privacy_comm > 3) $privacy_comm = 1;
			$sql_privacy = '1|'.$privacy_comm;
			
			//���� ��� ����� �����, �� ������ �
			if(!is_dir($uploaddir.$user_id)){ 
				@mkdir($uploaddir.$user_id, 0777 );
				@chmod($uploaddir.$user_id, 0777 );
				@mkdir($uploaddir.$user_id.'/albums', 0777 );
				@chmod($uploaddir.$user_id.'/albums', 0777 );
			}
			
			//���� ��� ����� �������, �� ������ �
			$check_system_albums = $db->super_query("SELECT aid, cover FROM `".PREFIX."_albums` WHERE user_id = '{$user_id}' AND system = 1");							
						if(!$check_system_albums) {
							$hash = md5(md5($server_time).$name.$descr.md5($user_info['user_id']).md5($user_info['user_email']).$_IP);
							$date_create = date('Y-m-d H:i:s', $server_time);
									
							$sql_ = $db->query("INSERT INTO `".PREFIX."_albums` (user_id, name, descr, ahash, adate, position, system, privacy) VALUES ('{$user_id}', '���������� �� ��������', '', '{$hash}', '{$date_create}', '0', '1', '{$sql_privacy}')");
							$aid_fors = $db->insert_id();
							$db->query("UPDATE `".PREFIX."_users` SET user_albums_num = user_albums_num+1 WHERE user_id = '{$user_id}'");
						} else $aid_fors = $check_system_albums['aid'];
			$album_dir = ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$aid_fors.'/';
			if(!is_dir($album_dir)){
				@mkdir($album_dir, 0777);
				@chmod($album_dir, 0777);
			}
			
			//����������� �������
			$allowed_files = array('jpg', 'jpeg', 'jpe', 'png', 'gif');
			
			//�������� ������ � ����������
			$image_tmp = $_FILES['uploadfile']['tmp_name'];
			$image_name = totranslit($_FILES['uploadfile']['name']); // ������������ �������� ��� ����������� �������
			$image_rename = substr(md5($server_time+rand(1,100000)), 0, 15); // ��� ����������
			$image_size = $_FILES['uploadfile']['size']; // ������ �����
			$type = end(explode(".", $image_name)); // ������ �����
			
			//�������� ����, ������ ������ �� ����������
			if(in_array($type, $allowed_files)){
				if($image_size < 5000000){
					$res_type = '.'.$type;
					$uploaddir = ROOT_DIR.'/uploads/users/'.$user_id.'/'; // ���������� ���� ���������
					if(move_uploaded_file($image_tmp, $uploaddir.$image_rename.$res_type)) {
					if(copy($uploaddir.$image_rename.$res_type, $album_dir.$image_rename.$res_type)){

						//�������� ���������
						$tmb = new thumbnail($uploaddir.$image_rename.$res_type);
						$tmb->size_auto(770);
						$tmb->jpeg_quality(95);
						$tmb->save($uploaddir.'o_'.$image_rename.$res_type);
						
						//�������� ������� ����������
						$tmb = new thumbnail($uploaddir.$image_rename.$res_type);
						$tmb->size_auto(200, 1);
						$tmb->jpeg_quality(97);
						$tmb->save($uploaddir.$image_rename.$res_type);
						
						//�������� ���������� ����� 50�50
						$tmb = new thumbnail($uploaddir.$image_rename.$res_type);
						$tmb->size_auto('50x50');
						$tmb->jpeg_quality(97);
						$tmb->save($uploaddir.'50_'.$image_rename.$res_type);
						
						
							
						$date = date('Y-m-d H:i:s', $server_time);
								
						$position_all = $_SESSION['position_all'];
						if($position_all){
							$position_all = $position_all+1;
							$_SESSION['position_all'] = $position_all;
						} else {
							$position_all = 100000;
							$_SESSION['position_all'] = $position_all;
						}

						$db->query("INSERT INTO `".PREFIX."_photos` (album_id, photo_name, user_id, date, position) VALUES ('{$aid_fors}', '{$image_rename}{$res_type}', '{$user_id}', '{$date}', '{$position_all}')");
						$ins_id = $db->insert_id();
						
						if(!$check_system_albums['cover'])
						$db->query("UPDATE `".PREFIX."_albums` SET cover = '' WHERE aid = '{$aid_fors}'");
						$db->query("UPDATE `".PREFIX."_albums` SET cover = '{$image_rename}{$res_type}' WHERE aid = '{$aid_fors}'");
						
						$db->query("UPDATE `".PREFIX."_albums` SET photo_num = photo_num+1, adate = '{$date}' WHERE aid = '{$aid_fors}'");
						
						//�������� ���������� ����� 100�100
						$tmb = new thumbnail($uploaddir.$image_rename.$res_type);
						$tmb->size_auto('100x100');
						$tmb->jpeg_quality(97);
						$tmb->save($uploaddir.'100_'.$image_rename.$res_type);
						
						//�������� ��������� �����
								$tmb = new thumbnail($album_dir.$image_rename.$res_type);
								$tmb->size_auto('140x100');
								$tmb->jpeg_quality('90');
								$tmb->save($album_dir.'c_'.$image_rename.$res_type);

						$image_rename = $db->safesql($image_rename);
						$res_type = $db->safesql($res_type);

						//��������� �� �����
						$row = $db->super_query("SELECT user_sex FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
						if($row['user_sex'] == 2)
							$sex_text = '��������';
						else
							$sex_text = '�������';
						
						$row_view_photos = $db->super_query("SELECT * FROM `".PREFIX."_photos` WHERE user_id = '{$user_id}'");
						$wall_text = "<div class=\"profile_update_photo\"><a href=\"/photo{$user_id}_{$ins_id}_{$aid_fors}\" onClick=\"Photo.Show(this.href); return false\"><img src=\"/uploads/users/{$user_id}/o_{$image_rename}{$res_type}\" style=\"margin-top:3px\"></a></div>";
						
						$db->query("INSERT INTO `".PREFIX."_wall` SET author_user_id = '{$user_id}', for_user_id = '{$user_id}', text = '{$wall_text}', add_date = '{$server_time}', type = '{$sex_text} ���������� �� ��������:', noedit = '1'");
						$dbid = $db->insert_id();
						
						$db->query("UPDATE `".PREFIX."_users` SET user_wall_num = user_wall_num+1 WHERE user_id = '{$user_id}'");
						
						//��������� � ����� ��������
						$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 1, action_text = '{$wall_text}', obj_id = '{$dbid}', action_time = '{$server_time}'");
						
						//��������� ��� ����� � ��
						$db->query("UPDATE `".PREFIX."_users` SET user_photo = '{$image_rename}{$res_type}', user_wall_id = '{$dbid}' WHERE user_id = '{$user_id}'");
						
						echo $config['home_url'].'uploads/users/'.$user_id.'/'.$image_rename.$res_type;

						mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
						mozg_clear_cache();
					}
					} else
						echo 'bad';
				} else
					echo 'big_size';
			} else
				echo 'bad_format';

			die();
		break;
		
		//�������� ����������
		case "del_photo":
			NoAjaxQuery();
			$user_id = $user_info['user_id'];
			$uploaddir = ROOT_DIR.'/uploads/users/'.$user_id.'/';
			$row = $db->super_query("SELECT user_photo, user_wall_id FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			if($row['user_photo']){
				$check_wall_rec = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_wall` WHERE id = '{$row['user_wall_id']}'");
				if($check_wall_rec['cnt']){
					$update_wall = ", user_wall_num = user_wall_num-1";
					$db->query("DELETE FROM `".PREFIX."_wall` WHERE id = '{$row['user_wall_id']}'");
					$db->query("DELETE FROM `".PREFIX."_news` WHERE obj_id = '{$row['user_wall_id']}'");
				}
				
				$db->query("UPDATE `".PREFIX."_users` SET user_photo = '', user_wall_id = '' {$update_wall} WHERE user_id = '{$user_id}'");

				@unlink($uploaddir.$row['user_photo']);
				@unlink($uploaddir.'50_'.$row['user_photo']);
				@unlink($uploaddir.'100_'.$row['user_photo']);
				@unlink($uploaddir.'o_'.$row['user_photo']);
				@unlink($uploaddir.'130_'.$row['user_photo']);
				
				mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
				mozg_clear_cache();
			}
			die();
		break;
		
		//�������� �������� ������� ����������
		case "load_photo":
			NoAjaxQuery();
			$tpl->load_template('load_photo.tpl');
			$tpl->compile('content');
			AjaxTpl();
			die();
		break;
		
		//���������� ������� ������
		case "save_general":
			NoAjaxQuery();
		
			$post_user_sex = intval($_POST['sex']);
			if($post_user_sex == 1 OR $post_user_sex == 2)
				$user_sex = $post_user_sex;
			else
				$user_sex = false;
			
			$user_name = ajax_utf8(textFilter($_POST['name']));
			$user_lastname = ajax_utf8(textFilter(ucfirst($_POST['lastname'])));
			$user_dev = ajax_utf8(textFilter(ucfirst($_POST['dev'])));
			$user_otcestvo = ajax_utf8(textFilter(ucfirst($_POST['otcestvo'])));
			$user_roditeli = ajax_utf8(textFilter(ucfirst($_POST['roditeli'])));
			$user_mother = ajax_utf8(textFilter($_POST['mother']));
			/*function tag($user_mother){
            $user_mother= preg_replace("/@(\w+) -(.*)-/", '<a href="/$1" target="_blank">$2</a>', $user_mother);
			return $user_mother;
			}*/
			$user_father = ajax_utf8(textFilter($_POST['father']));
			/*function tag($user_father){
            $user_father= preg_replace("/@(\w+) -(.*)-/", '<a href="/$1" target="_blank">$2</a>', $user_father);
			return $user_father;
			}*/
			$user_bratiasestry = ajax_utf8(textFilter(ucfirst($_POST['bratiasestry'])));
			$user_rodgorod = ajax_utf8(textFilter(ucfirst($_POST['rodgorod'])));
			$user_babushkadedushka = ajax_utf8(textFilter(ucfirst($_POST['babushkadedushka'])));
			$user_deti = ajax_utf8(textFilter(ucfirst($_POST['deti'])));
			$user_vnuki = ajax_utf8(textFilter(ucfirst($_POST['vnuki'])));
			$user_lange = ajax_utf8(textFilter(ucfirst($_POST['lange'])));
			$user_day = intval($_POST['day']);
			$user_month = intval($_POST['month']);
			$user_year = intval($_POST['year']);
			$user_dprivacy = intval($_POST['dprivacy']);
			$user_birthday = $user_year.'-'.$user_month.'-'.$user_day.'-'.$user_dprivacy;
			
			if($user_sex){
				$post_sp = intval($_POST['sp']);
				if($post_sp >= 1 AND $post_sp <= 7)
					$sp = $post_sp;
				else
					$sp = false;
				
				if($sp){
					$sp_val = intval($_POST['sp_val']);
					$user_sp = $sp.'|'.$sp_val;
				}
			}	
			
			/*$user_mother = tag($user_mother);
			$user_father = tag($user_father);*/
			$db->query("UPDATE `".PREFIX."_users` SET user_sex = '{$user_sex}', user_dev = '{$user_dev}', user_father = '{$user_father}', user_mother = '{$user_mother}', user_otcestvo = '{$user_otcestvo}', user_roditeli = '{$user_roditeli}', user_bratiasestry = '{$user_bratiasestry}', user_rodgorod = '{$user_rodgorod}', user_babushkadedushka = '{$user_babushkadedushka}', user_deti = '{$user_deti}', user_vnuki = '{$user_vnuki}', user_lange = '{$user_lange}', user_day = '{$user_day}', user_month = '{$user_month}', user_year = '{$user_year}', user_birthday = '{$user_birthday}', user_sp = '{$user_sp}', user_name = '{$user_name}', user_lastname = '{$user_lastname}', user_search_pref = '{$user_name} {$user_lastname}' WHERE user_id = '{$user_info['user_id']}'");

			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			mozg_clear_cache();
				
			echo 'ok';

			die();
		break;
		
		//���������� ���������
		case "save_contact":
			NoAjaxQuery();
            
			$phonebook = ajax_utf8(textFilter($_POST['phonebook'], 0, 200));
			$user_rai = ajax_utf8(textFilter($_POST['rai']));
			$user_metro = ajax_utf8(textFilter(ucfirst($_POST['metro'])));
			$user_ulica = ajax_utf8(textFilter(ucfirst($_POST['ulica'])));
			$user_nazvanie = ajax_utf8(textFilter(ucfirst($_POST['nazvanie'])));
			$user_country = intval($_POST['country']);
			$user_city = intval($_POST['city']);
			$xfields = array();
			$xfields['vk'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['vk'], 0, 200))));
			$xfields['od'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['od'], 0, 200))));
			$xfields['phone'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['phone'], 0, 200))));
			$xfields['skype'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['skype'], 0, 200))));
			$xfields['fb'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['fb'], 0, 200))));
			$xfields['icq'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['icq'], 0, 200))));
			$xfields['site'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['site'], 0, 200))));
			
			if($user_country > 0){
				$country_info = $db->super_query("SELECT name FROM `".PREFIX."_country` WHERE id = '".$user_country."'");
				$city_info = $db->super_query("SELECT name FROM `".PREFIX."_city` WHERE id = '".$user_city."'");
					
				$user_country_city_name = $country_info['name'].'|'.$city_info['name'];
			} else {
				$user_city = 0;
				$user_country = 0;
				$user_country_city_name = '';
			}	
			
			foreach($xfields as $name => $value){
				$value = str_replace("|", "&#124;", $value);
				if(strlen($value) > 0)
					$xfieldsdata .= $name.'|'.$value.'||';
			}
			
			$db->query("UPDATE `".PREFIX."_users` SET phonebook = '{$phonebook}', user_xfields = '{$xfieldsdata}', user_country = '{$user_country}', user_city = '{$user_city}', user_country_city_name = '{$user_country_city_name}', user_rai = '{$user_rai}', user_metro = '{$user_metro}', user_ulica = '{$user_ulica}', user_nazvanie = '{$user_nazvanie}'  WHERE user_id = '{$user_info['user_id']}'");
			
			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			
			echo 'ok';
			
			die();
		break;
		
		//���������� ���������
		case "save_interests":
			NoAjaxQuery();

			$xfields = array();
			$xfields['activity'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['activity'], 0, 5000))));
			$xfields['interests'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['interests'], 0, 5000))));
			$xfields['myinfo'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['myinfo'], 0, 5000))));
			$xfields['music'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['music'], 0, 5000))));
			$xfields['kino'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['kino'], 0, 5000))));
			$xfields['books'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['books'], 0, 5000))));
			$xfields['games'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['games'], 0, 5000))));
			$xfields['quote'] = $db->safesql(ajax_utf8(htmlspecialchars(substr($_POST['quote'], 0, 5000))));
			
			foreach($xfields as $name => $value){
				$value = str_replace("|", "&#124;", $value);
				if(strlen($value) > 0)
					$xfieldsdata .= $name.'|'.$value.'||';
			}
			
			$db->query("UPDATE `".PREFIX."_users` SET user_xfields_all = '{$xfieldsdata}' WHERE user_id = '{$user_info['user_id']}'");
			
			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			
			echo 'ok';
			
			die();
		break;
		
		//���������� �������� �����������
		case "save_education":
			NoAjaxQuery();
			
			
		   $user_countrysr = intval($_POST['country']);
		   $user_citysr = intval($_POST['city']);
		   $user_shkola = ajax_utf8(textFilter($_POST['shkola']));
		   $user_datasr = intval($_POST['datasr']);
		   $user_nacalosr = intval($_POST['nacalosr']);
		   $user_konecsr = intval($_POST['konecsr']);
		   $user_klass = intval($_POST['klass']);
		   $user_spec = ajax_utf8(textFilter($_POST['spec']));
		  
		   if($user_countrysr > 0){
				$country_info = $db->super_query("SELECT name FROM `".PREFIX."_country` WHERE id = '".$user_countrysr."'");
				$city_info = $db->super_query("SELECT name FROM `".PREFIX."_city` WHERE id = '".$user_citysr."'");
					
				$user_country_city_namesr = $country_info['name'].'|'.$city_info['name'];
			} else {
				$user_citysr = 0;
				$user_countrysr = 0;
				$user_country_city_namesr = '';
			}	
		
				
            $db->query("UPDATE `".PREFIX."_users` SET user_countrysr = '{$user_countrysr}', user_citysr = '{$user_citysr}', user_shkola = '{$user_shkola}', user_datasr = '{$user_datasr}', user_nacalosr = '{$user_nacalosr}', user_konecsr = '{$user_konecsr}', user_country_city_namesr = '{$user_country_city_namesr}', user_spec = '{$user_spec}', user_klass = '{$user_klass}'  WHERE user_id = '{$user_info['user_id']}'");

			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			mozg_clear_cache();
				
			echo 'ok';

			die();
		break;
		
		//���������� ������� �����������
		case "save_higher_education":
			NoAjaxQuery();
			
			
		   $user_countryvi = intval($_POST['country']);
		   $user_cityvi = intval($_POST['city']);
		   $user_vuz = ajax_utf8(textFilter($_POST['vuz']));
		   $user_fac = ajax_utf8(textFilter($_POST['fac']));
		   $user_form = intval($_POST['form']);
		   $user_statusvi = intval($_POST['statusvi']);
		   $user_datavi = intval($_POST['datavi']);
		   
		  
		   if($user_countryvi > 0){
				$country_info = $db->super_query("SELECT name FROM `".PREFIX."_country` WHERE id = '".$user_countryvi."'");
				$city_info = $db->super_query("SELECT name FROM `".PREFIX."_city` WHERE id = '".$user_cityvi."'");
					
				$user_country_city_namevi = $country_info['name'].'|'.$city_info['name'];
			} else {
				$user_cityvi = 0;
				$user_countryvi = 0;
				$user_country_city_namevi = '';
			}	
	
            $db->query("UPDATE `".PREFIX."_users` SET user_countryvi = '{$user_countryvi}', user_cityvi = '{$user_cityvi}', user_vuz = '{$user_vuz}', user_fac = '{$user_fac}', user_form = '{$user_form}', user_statusvi = '{$user_statusvi}', user_country_city_namevi = '{$user_country_city_namevi}', user_datavi = '{$user_datavi}'  WHERE user_id = '{$user_info['user_id']}'");

			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			mozg_clear_cache();
				
			echo 'ok';

			die();
		break;
		
		//���������� �������
		case "save_career":
			NoAjaxQuery();
			
			
		   $user_countryca = intval($_POST['country']);
		   $user_cityca = intval($_POST['city']);
		   $user_mesto = ajax_utf8(textFilter($_POST['mesto']));
		   $user_nacaloca = intval($_POST['nacaloca']);
		   $user_konecca = intval($_POST['konecca']);
		   $user_dolj = ajax_utf8(textFilter($_POST['dolj']));
		  
		   if($user_countryca > 0){
				$country_info = $db->super_query("SELECT name FROM `".PREFIX."_country` WHERE id = '".$user_countryca."'");
				$city_info = $db->super_query("SELECT name FROM `".PREFIX."_city` WHERE id = '".$user_cityca."'");
					
				$user_country_city_nameca = $country_info['name'].'|'.$city_info['name'];
			} else {
				$user_cityca = 0;
				$user_countryca = 0;
				$user_country_city_nameca = '';
			}	
		
				
            $db->query("UPDATE `".PREFIX."_users` SET user_countryca = '{$user_countryca}', user_cityca = '{$user_cityca}', user_mesto = '{$user_mesto}', user_dolj = '{$user_dolj}', user_nacaloca = '{$user_nacaloca}', user_konecca = '{$user_konecca}', user_country_city_nameca = '{$user_country_city_nameca}'  WHERE user_id = '{$user_info['user_id']}'");

			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			mozg_clear_cache();
				
			echo 'ok';

			die();
		break;
		
		//���������� ������� ������
		case "save_military":
			NoAjaxQuery();
			
			
		   $user_countrysl = intval($_POST['country']);
		   $user_citysl = intval($_POST['city']);
		   $user_chast = ajax_utf8(textFilter($_POST['chast']));
           $user_zvanie = ajax_utf8(textFilter($_POST['zvanie']));
		   $user_nacalosl = intval($_POST['nacalosl']);
		   $user_konecsl = intval($_POST['konecsl']);
		  
		   if($user_countrysl > 0){
				$country_info = $db->super_query("SELECT name FROM `".PREFIX."_country` WHERE id = '".$user_countrysl."'");
				$city_info = $db->super_query("SELECT name FROM `".PREFIX."_city` WHERE id = '".$user_citysl."'");
					
				$user_country_city_namesl = $country_info['name'].'|'.$city_info['name'];
			} else {
				$user_citysl = 0;
				$user_countrysl = 0;
				$user_country_city_namesl = '';
			}	
		
				
            $db->query("UPDATE `".PREFIX."_users` SET user_countrysl = '{$user_countrysl}', user_citysl = '{$user_citysl}', user_chast = '{$user_chast}', user_zvanie = '{$user_zvanie}', user_nacalosl = '{$user_nacalosl}', user_konecsl = '{$user_konecsl}', user_country_city_namesl = '{$user_country_city_namesl}'  WHERE user_id = '{$user_info['user_id']}'");

			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			mozg_clear_cache();
				
			echo 'ok';

			die();
		break;
		
		//���������� ��������� �������
		case "save_personal":
			NoAjaxQuery();
		   
		   $user_pred = intval($_POST['pred']);
		   $user_miro = ajax_utf8(textFilter($_POST['miro']));
		   $user_jizn = intval($_POST['jizn']);
		   $user_ludi = intval($_POST['ludi']);
		   $user_kurenie = intval($_POST['kurenie']);
		   $user_alkogol = intval($_POST['alkogol']);
		   $user_narkotiki = intval($_POST['narkotiki']);
		   $user_vdox = ajax_utf8(textFilter($_POST['vdox']));
           
		
				
            $db->query("UPDATE `".PREFIX."_users` SET user_pred = '{$user_pred}', user_miro = '{$user_miro}', user_jizn = '{$user_jizn}', user_ludi = '{$user_ludi}', user_kurenie = '{$user_kurenie}', user_alkogol = '{$user_alkogol}', user_narkotiki = '{$user_narkotiki}', user_vdox = '{$user_vdox}' WHERE user_id = '{$user_info['user_id']}'");

			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			mozg_clear_cache();
				
			echo 'ok';

			die();
		break;
		
		//���������� ���.�����
		case "save_xfields":

			$xfields = profileload();
			
			$postedxfields = $_POST['xfields'];
			
			$newpostedxfields = array();

			$xfieldsdata = xfieldsdataload($xfieldsid);

			foreach($xfields as $name => $value){

				$newpostedxfields[$value[0]] = $postedxfields[$value[0]];

				if($value[2] == "select"){
					$options = explode("\r\n", $value[3]);

					$newpostedxfields[$value[0]] = $options[$postedxfields[$value[0]]].'|1';
				}

			}
			
			$postedxfields = $newpostedxfields;
			
			foreach($postedxfields as $xfielddataname => $xfielddatavalue){

				if(!$xfielddatavalue){
					continue;
				}
				
				$expxfielddatavalue = explode('|', $xfielddatavalue);
				
				if($expxfielddatavalue[1])
					$xfielddatavalue = str_replace('|1', '', textFilter($xfielddatavalue));
				else
					$xfielddatavalue = ajax_utf8(textFilter($xfielddatavalue));

				$xfielddataname = $db->safesql($xfielddataname);

				if(isset($xfielddatavalue) AND !empty($xfielddatavalue)){
					$xfielddataname = str_replace("|", "&#124;", $xfielddataname);
					$xfielddatavalue = str_replace("|", "&#124;", $xfielddatavalue);
					$filecontents[] = "$xfielddataname|$xfielddatavalue";
				}
			}
				
			if($filecontents)
				$filecontents = implode( "||", $filecontents);
			else
				$filecontents = '';

			$db->query("UPDATE `".PREFIX."_users` SET xfields = '{$filecontents}' WHERE user_id = '{$user_info['user_id']}'");

			mozg_clear_cache_file('user_'.$user_info['user_id'].'/profile_'.$user_info['user_id']);
			
			exit;
		break;
		
		//�������� �������������� ���������
		case "contact":
			$user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_contact'];
			$tpl->load_template('editprofile.tpl');
			$row = $db->super_query("SELECT user_xfields, user_rai, user_metro, user_ulica, user_nazvanie, user_country, user_city, phonebook FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			
			//################## ��������� ������ ##################//
			$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `name` ASC", true, "country", true);
			foreach($sql_country as $row_country)
				$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
					
			$tpl->set('{country}', installationSelected($row['user_country'], $all_country));
			
			//################## ��������� ������ ##################//
			$sql_city = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$row['user_country']}' ORDER by `name` ASC", true, "country_city_".$row['user_country'], true);
			foreach($sql_city as $row2) 
				$all_city .= '<option value="'.$row2['id'].'">'.stripslashes($row2['name']).'</option>';

			$tpl->set('{city}', installationSelected($row['user_city'], $all_city));
			
			$tpl->set('{phonebook}', $row['phonebook']);
			$tpl->set('{rai}', $row['user_rai']);
			$tpl->set('{metro}', $row['user_metro']);
			$tpl->set('{ulica}', $row['user_ulica']);
			$tpl->set('{nazvanie}', $row['user_nazvanie']);
			
			$xfields = xfieldsdataload($row['user_xfields']);
			$tpl->set('{vk}', stripslashes($xfields['vk']));
			$tpl->set('{od}', stripslashes($xfields['od']));
			$tpl->set('{fb}', stripslashes($xfields['fb']));
			$tpl->set('{skype}', stripslashes($xfields['skype']));
			$tpl->set('{icq}', stripslashes($xfields['icq']));
			$tpl->set('{site}', stripslashes($xfields['site']));
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
			$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
			$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
			$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
			$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
			$tpl->set_block("'\\[xfields\\](.*?)\\[/xfields\\]'si","");
			$tpl->set('[contact]', '');
			$tpl->set('[/contact]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;
		
		//�������� �������������� ���������
		case "interests":
			$user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_interests'];
			$tpl->load_template('editprofile.tpl');
			$row = $db->super_query("SELECT user_xfields_all FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			$xfields = xfieldsdataload($row['user_xfields_all']);
			$tpl->set('{activity}', stripslashes($xfields['activity']));
			$tpl->set('{interests}', stripslashes($xfields['interests']));
			$tpl->set('{myinfo}', stripslashes($xfields['myinfo']));
			$tpl->set('{music}', stripslashes($xfields['music']));
			$tpl->set('{kino}', stripslashes($xfields['kino']));
			$tpl->set('{books}', stripslashes($xfields['books']));
			$tpl->set('{games}', stripslashes($xfields['games']));
			$tpl->set('{quote}', stripslashes($xfields['quote']));
			$tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
			$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
			$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
			$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
			$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
			$tpl->set_block("'\\[xfields\\](.*?)\\[/xfields\\]'si","");
			$tpl->set('[interests]', '');
			$tpl->set('[/interests]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;
		
		//�������� �������������� �������� �����������
		case "education":
		    $user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_education'];
            $tpl->load_template('editprofile.tpl');
			$row = $db->super_query("SELECT user_shkola, user_datasr, user_klass, user_spec, user_nacalosr, user_konecsr, user_countrysr, user_citysr  FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			
			
			$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `name` ASC", true, "country", true);
			foreach($sql_country as $row_country)
				$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
					
			$tpl->set('{country}', installationSelected($row['user_countrysr'], $all_country));
			
			$sql_city = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$row['user_countrysr']}' ORDER by `name` ASC", true, "country_city_".$row['user_countrysr'], true);
			foreach($sql_city as $row2) 
				$all_city .= '<option value="'.$row2['id'].'">'.stripslashes($row2['name']).'</option>';

			$tpl->set('{city}', installationSelected($row['user_citysr'], $all_city));
			
			$tpl->set('{shkola}', $row['user_shkola']);
			
			$tpl->set('{nacalosr}', installationSelected($row['user_nacalosr'], 
			'<option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			$tpl->set('{konecsr}', installationSelected($row['user_konecsr'],
			 '<option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			 $tpl->set('{datasr}', installationSelected($row['user_datasr'],
			 '<option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			$tpl->set('{klass}', installationSelected($row['user_klass'], 
			'<option value="1">�</option><option value="2">�</option><option value="3">�</option><option value="4">�</option><option value="5">�</option><option value="6">�</option><option value="7">�</option><option value="8">�</option><option value="9">�</option><option value="10">�</option><option value="11">�</option><option value="12">�</option><option value="13">�</option><option value="14">�</option><option value="15">�</option><option value="16">�</option><option value="17">�</option><option value="18">�</option><option value="19">�</option><option value="20">�</option><option value="21">�</option><option value="22">�</option><option value="23">�</option><option value="24">�</option><option value="25">�</option><option value="26">�</option><option value="27">�</option><option value="28">�</option><option value="29">�</option><option value="30">�2</option><option value="31">�2</option><option value="32">�2</option><option value="33">�2</option><option value="34">�2</option><option value="35">�2</option><option value="36">�2</option><option value="37">�2</option><option value="38">�2</option><option value="39">�2</option><option value="40">�2</option><option value="41">�2</option><option value="42">�2</option><option value="43">�2</option><option value="44">�2</option><option value="45">�2</option><option value="46">�2</option><option value="47">�2</option><option value="48">�2</option><option value="49">�2</option><option value="50">�2</option><option value="51">�2</option><option value="52">�2</option><option value="53">�2</option><option value="54">�2</option><option value="55">�2</option><option value="56">�2</option><option value="57">�2</option><option value="58">�2</option><option value="59">�3</option><option value="60">�3</option><option value="61">�3</option><option value="62">�3</option><option value="63">�3</option><option value="64">�3</option><option value="65">�3</option><option value="66">�3</option><option value="67">�3</option><option value="68">�3</option><option value="69">�3</option><option value="70">�3</option><option value="71">�3</option><option value="72">�3</option><option value="73">�3</option><option value="74">�3</option><option value="75">�3</option><option value="76">�3</option><option value="77">�3</option><option value="78">�3</option><option value="79">�3</option><option value="80">�3</option><option value="81">�3</option><option value="82">�3</option><option value="83">�3</option><option value="84">�3</option><option value="85">�3</option><option value="86">�3</option><option value="87">�3</option><option value="88">1</option><option value="89">2</option><option value="90">3</option><option value="91">4</option><option value="92">5</option><option value="93">6</option><option value="94">7</option><option value="95">8</option><option value="96">9</option><option value="97">10</option><option value="98">11</option><option value="99">12</option><option value="100">13</option><option value="101">14</option><option value="102">15</option>'));
			$tpl->set('{spec}', $row['user_spec']);
			$tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
			$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
			$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
			$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
			$tpl->set('[education]', '');
			$tpl->set('[/education]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;
		
		//�������� �������������� ������� �����������
		case "higher_education":
		    $user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_higher_education'];
            $tpl->load_template('editprofile.tpl');
			
			$row = $db->super_query("SELECT user_vuz, user_fac, user_form, user_statusvi, user_datavi, user_countryvi, user_cityvi  FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			
			$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `name` ASC", true, "country", true);
			foreach($sql_country as $row_country)
				$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
					
			$tpl->set('{country}', installationSelected($row['user_countryvi'], $all_country));
			
			$sql_city = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$row['user_countryvi']}' ORDER by `name` ASC", true, "country_city_".$row['user_countryvi'], true);
			foreach($sql_city as $row2) 
				$all_city .= '<option value="'.$row2['id'].'">'.stripslashes($row2['name']).'</option>';

		   $tpl->set('{city}', installationSelected($row['user_cityvi'], $all_city));
		   $tpl->set('{vuz}', $row['user_vuz']);
		   $tpl->set('{fac}', $row['user_fac']);			
		   $tpl->set('{form}', installationSelected($row['user_form'], 
			'<option value="1">�������</option>
			 <option value="2">��������</option>
			 <option value="3">�������</option>'));
		   $tpl->set('{statusvi}', installationSelected($row['user_statusvi'], 
			'<option value="1">����������</option>
			 <option value="2">�������(����������)</option>
			 <option value="3">�������(��������)</option>
			 <option value="4">�������(�������)</option>
			 <option value="5">���������(����������)</option>
			 <option value="6">���������(��������)</option>
			 <option value="7">���������(�������)</option>			 
			 <option value="8">��������</option>
			 <option value="9">�������� ����</option>
			 <option value="10">������ ����</option>'));
			$tpl->set('{datavi}', installationSelected($row['user_datavi'],
			 '<option value="2020">2020</option><option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			$tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
			$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
			$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
			$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
			$tpl->set('[higher_education]', '');
			$tpl->set('[/higher_education]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;    
		

		//�������� �������������� �������
		case "career":
		    $user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_career'];
            $tpl->load_template('editprofile.tpl');
			
			$row = $db->super_query("SELECT user_mesto, user_nacaloca, user_konecca, user_dolj, user_countryca, user_cityca  FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
		    
			$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `name` ASC", true, "country", true);
			foreach($sql_country as $row_country)
				$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
					
			$tpl->set('{country}', installationSelected($row['user_countryca'], $all_country));
			
			$sql_city = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$row['user_countryca']}' ORDER by `name` ASC", true, "country_city_".$row['user_countryca'], true);
			foreach($sql_city as $row2) 
				$all_city .= '<option value="'.$row2['id'].'">'.stripslashes($row2['name']).'</option>';
				
			$tpl->set('{city}', installationSelected($row['user_cityca'], $all_city));
			$tpl->set('{mesto}', $row['user_mesto']);
			$tpl->set('{nacaloca}', installationSelected($row['user_nacaloca'], 
			'<option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			 $tpl->set('{konecca}', installationSelected($row['user_konecca'],
			 '<option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>')); 
			$tpl->set('{dolj}', $row['user_dolj']);
			$tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
			$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
			$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
			$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
			$tpl->set('[career]', '');
			$tpl->set('[/career]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;
		
		//�������� �������������� ������
		case "military":
		    $user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_military'];
            $tpl->load_template('editprofile.tpl');
		    $row = $db->super_query("SELECT user_chast, user_zvanie, user_nacalosl, user_konecsl, user_countrysl, user_citysl  FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			
			$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `name` ASC", true, "country", true);
			foreach($sql_country as $row_country)
				$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
					
			$tpl->set('{country}', installationSelected($row['user_countrysl'], $all_country));
			
			$sql_city = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$row['user_countrysl']}' ORDER by `name` ASC", true, "country_city_".$row['user_countrysl'], true);
			foreach($sql_city as $row2) 
				$all_city .= '<option value="'.$row2['id'].'">'.stripslashes($row2['name']).'</option>';
				
			$tpl->set('{city}', installationSelected($row['user_citysl'], $all_city));
				
			$tpl->set('{chast}', $row['user_chast']);
			$tpl->set('{zvanie}', $row['user_zvanie']);	
			$tpl->set('{nacalosl}', installationSelected($row['user_nacalosl'], 
			'<option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			 $tpl->set('{konecsl}', installationSelected($row['user_konecsl'],
			 '<option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option>	<option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option>'));
			$tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
			$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
			$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
			$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
			$tpl->set('[military]', '');
			$tpl->set('[/military]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;
		
		//�������� �������������� ��������� �������
			case "personal":
			$user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_personal'];
            $tpl->load_template('editprofile.tpl');
			$row = $db->super_query("SELECT user_pred, user_miro, user_jizn, user_ludi, user_kurenie, user_alkogol, user_narkotiki, user_vdox FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
		
		    $tpl->set('{pred}', installationSelected($row['user_pred'], 
			'<option value="1">��������������</option>
			 <option value="2">����������������</option>
			 <option value="3">����������������</option>
			 <option value="4">���������</option>
			 <option value="5">�����������</option>
			 <option value="6">��������������</option>
			 <option value="7">�������������</option>			 
			 <option value="8">��������������������</option>
			 <option value="9">���������������</option>'));
			$tpl->set('{miro}', $row['user_miro']);
			$tpl->set('{jizn}', installationSelected($row['user_jizn'], 
			'<option value="1">����� � ����</option>
			 <option value="2">������� � ����</option>
			 <option value="3">����������� � �����</option>
			 <option value="4">����� � ������������</option>
			 <option value="5">����������������� ����</option>
			 <option value="6">������������</option>
			 <option value="7">������� � ��������</option>			 
			 <option value="8">����� � �������</option>'));
		    $tpl->set('{ludi}', installationSelected($row['user_ludi'], 
			'<option value="1">�� � ������������</option>
			 <option value="2">������� � ���������</option>
			 <option value="3">������� � ��������</option>
			 <option value="4">������ � ���������</option>
			 <option value="5">�������� � ��������</option>
			 <option value="6">���� � ����������</option>'));
			$tpl->set('{kurenie}', installationSelected($row['user_kurenie'], 
			'<option value="1">����� ����������</option>
			 <option value="2">����������</option>
			 <option value="3">�������������</option>
			 <option value="4">�����������</option>
			 <option value="5">�������������</option>'));
			$tpl->set('{alkogol}', installationSelected($row['user_alkogol'], 
			'<option value="1">����� ����������</option>
			 <option value="2">����������</option>
			 <option value="3">�������������</option>
			 <option value="4">�����������</option>
			 <option value="5">�������������</option>'));
			$tpl->set('{narkotiki}', installationSelected($row['user_narkotiki'], 
			'<option value="1">����� ����������</option>
			 <option value="2">����������</option>
			 <option value="3">�������������</option>
			 <option value="4">�����������</option>
			 <option value="5">�������������</option>'));
			$tpl->set('{vdox}', $row['user_vdox']);
            $tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
			$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
			$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
			$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set('[personal]', '');
			$tpl->set('[/personal]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;
		
		//�������� �������������� ���.�����
		case "all":
			$user_speedbar = $lang['editmyprofile'].' &raquo; ������';
			$tpl->load_template('editprofile.tpl');

			$xfields = profileload();
			
			$row = $db->super_query("SELECT xfields FROM `".PREFIX."_users` WHERE user_id = '".$user_info['user_id']."'");
			
			$xfieldsdata = xfieldsdataload($row['xfields']);
			
			foreach($xfields as $name => $value){
				
				$fieldvalue = $xfieldsdata[$value[0]];
				$fieldvalue = stripslashes($fieldvalue);
				
				$output .= "<div class=\"texta\">{$value[1]}:</div>";
					
				$for_js_list .= "'xfields[{$value[0]}]': $('#{$value[0]}').val(), ";
					
				if($value[2] == "textarea"){  
					
					$output .= '<textarea id="'.$value[0].'" class="inpst" style="width:300px;height:50px;">'.myBrRn($fieldvalue).'</textarea>';
						
				} elseif($value[2] == "text"){  
					
					$output .= '<input type="text" id="'.$value[0].'" class="inpst" maxlength="100" value="'.$fieldvalue.'" style="width:300px;" />';
						
				} elseif($value[2] == "select"){  
					
					$output .= '<select class="inpst" id="'.$value[0].'">';
					$output .= '<option value="">- �� ������� -</option>';
					
					foreach(explode("\r\n", $value[3]) AS $index => $value){

						$value = str_replace("'", "&#039;", $value);
						$output .= "<option value=\"$index\"" . ($fieldvalue == $value ? " selected" : "") . ">$value</option>\r\n";
						
					}
					
					$output .= '</select>';
					
				}
					
				$output .= '<div class="mgclr"></div>';

			}
			
			$for_js_list = substr($for_js_list, 0, (strlen($for_js_list)-2));
			
			$tpl->set('{xfields}', $output);
			$tpl->set('{for-js-list}', $for_js_list);
			
			$tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[general\\](.*?)\\[/general\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set('[xfields]', '');
			$tpl->set('[/xfields]', '');
			$tpl->compile('content');
			$tpl->clear();
		break;
				//�������� ���������
		case "miniature":
			
			$row = $db->super_query("SELECT user_photo FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			
			if($row['user_photo']){
			
				$tpl->load_template('miniature/main.tpl');
				$tpl->set('{user-id}', $user_info['user_id']);
				$tpl->set('{ava}', $row['user_photo']);
				$tpl->compile('content');
				
				AjaxTpl();
			
			} else
				echo '1';
			
			exit();
			
		break;
		
		//���������� ���������
		case "miniature_save":
			
			$row = $db->super_query("SELECT user_photo FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");

			$i_left = intval($_POST['i_left']);
			$i_top = intval($_POST['i_top']);
			$i_width = intval($_POST['i_width']);
			$i_height = intval($_POST['i_height']);

			if($row['user_photo'] AND $i_width >= 100 AND $i_height >= 100 AND $i_left >= 0 AND $i_height >= 0){

				include_once ENGINE_DIR.'/classes/images.php';

				$tmb = new thumbnail(ROOT_DIR."/uploads/users/{$user_info['user_id']}/{$row['user_photo']}");
				$tmb->size_auto($i_width."x".$i_height, 0, "{$i_left}|{$i_top}");
				$tmb->jpeg_quality(100);
				$tmb->save(ROOT_DIR."/uploads/users/{$user_info['user_id']}/100_{$row['user_photo']}");
				
				$tmb = new thumbnail(ROOT_DIR."/uploads/users/{$user_info['user_id']}/100_{$row['user_photo']}");
				$tmb->size_auto("100x100", 1);
				$tmb->jpeg_quality(100);
				$tmb->save(ROOT_DIR."/uploads/users/{$user_info['user_id']}/100_{$row['user_photo']}");
				
				$tmb = new thumbnail(ROOT_DIR."/uploads/users/{$user_info['user_id']}/100_{$row['user_photo']}");
				$tmb->size_auto("50x50");
				$tmb->jpeg_quality(100);
				$tmb->save(ROOT_DIR."/uploads/users/{$user_info['user_id']}/50_{$row['user_photo']}");
				
				echo $user_info['user_id'];
			
			} else
				echo 'err';
			
			exit();
			
		break;
		default:
		
			//�������� �������������� ��������
			$user_speedbar = $lang['editmyprofile'].' &raquo; '.$lang['editmyprofile_genereal'];
			
			$tpl->load_template('editprofile.tpl');
			
			$row = $db->super_query("SELECT user_name, user_lastname, user_birthday, user_dev, user_otcestvo, user_roditeli, user_mother, user_father, user_bratiasestry, user_rodgorod, user_babushkadedushka, user_deti, user_vnuki, user_lange, user_sex, user_day, user_month, user_year, user_country, user_city, user_sp FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
			
			$tpl->set('{name}', $row['user_name']);
			$tpl->set('{lastname}', $row['user_lastname']);
			
	
			    if($row['user_sex']== 2){
				$tpl->set('{dev}', $row['user_dev']);
				$tpl->set('[dev]','');
				$tpl->set('[/dev]','');
			} else 
				$tpl->set_block("'\\[dev\\](.*?)\\[/dev\\]'si","");
			
			
			$tpl->set('{otcestvo}', $row['user_otcestvo']);
			$tpl->set('{roditeli}', $row['user_roditeli']);
			$tpl->set('{mother}', $row['user_mother']);
			$tpl->set('{father}', $row['user_father']);
			$tpl->set('{bratiasestry}', $row['user_bratiasestry']);
			$tpl->set('{rodgorod}', $row['user_rodgorod']);
			$tpl->set('{babushkadedushka}', $row['user_babushkadedushka']);
			$tpl->set('{deti}', $row['user_deti']);
			$tpl->set('{vnuki}', $row['user_vnuki']);
			$tpl->set('{lange}', $row['user_lange']);
			
			$pbdate = explode("-", $row['user_birthday']);
			
			$tpl->set('{sex}', installationSelected($row['user_sex'], '<option value="1">�������</option><option value="2">�������</option>'));
			
			$tpl->set('{user-day}', installationSelected($row['user_day'], '<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>'));
			
			$tpl->set('{user-month}', installationSelected($row['user_month'], '<option value="1">������</option><option value="2">�������</option><option value="3">�����</option><option value="4">������</option><option value="5">���</option><option value="6">����</option><option value="7">����</option><option value="8">�������</option><option value="9">��������</option><option value="10">�������</option><option value="11">������</option><option value="12">�������</option>'));
			
			$tpl->set('{user-year}', installationSelected($row['user_year'], '<option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option>'));
			
			$tpl->set('{data-profiles}', installationSelected($pbdate['3'], '<option value="1">���������� ���� ��������</option><option value="2">���������� ������ ����� � ����</option><option value="3">�� ���������� ���� ��������</option>'));
			
			//################## ��������� ������ ##################//
			$sql_country = $db->super_query("SELECT SQL_CALC_FOUND_ROWS * FROM `".PREFIX."_country` ORDER by `name` ASC", true, "country", true);
			foreach($sql_country as $row_country)
				$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
					
			$tpl->set('{country}', installationSelected($row['user_country'], $all_country));
			
			//################## ��������� ������ ##################//
			$sql_city = $db->super_query("SELECT SQL_CALC_FOUND_ROWS id, name FROM `".PREFIX."_city` WHERE id_country = '{$row['user_country']}' ORDER by `name` ASC", true, "country_city_".$row['user_country'], true);
			foreach($sql_city as $row2) 
				$all_city .= '<option value="'.$row2['id'].'">'.stripslashes($row2['name']).'</option>';

			$tpl->set('{city}', installationSelected($row['user_city'], $all_city));
			
			$user_sp = explode('|', $row['user_sp']);
			if($user_sp[1]){
				$rowSp = $db->super_query("SELECT user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$user_sp[1]}'");
				$tpl->set('{sp-name}', $rowSp['user_search_pref']);
				$tpl->set_block("'\\[sp\\](.*?)\\[/sp\\]'si","");
				
				if($row['user_sex'] == 1){
					if($user_sp[0] == 2)
						$tpl->set('{sp-text}', '�������:');
					elseif($user_sp[0] == 3)
						$tpl->set('{sp-text}', '�������:');
					else if($user_sp[0] == 4)
						$tpl->set('{sp-text}', '����:');
					else if($user_sp[0] == 5)
						$tpl->set('{sp-text}', '�������:');
					else
						$tpl->set('{sp-text}', '������:');
				} else {
					if($user_sp[0] == 2)
						$tpl->set('{sp-text}', '����:');
					elseif($user_sp[0] == 3)
						$tpl->set('{sp-text}', '�����:');
					else if($user_sp[0] == 4)
						$tpl->set('{sp-text}', '���:');
					else if($user_sp[0] == 5)
						$tpl->set('{sp-text}', '�������:');
					else
						$tpl->set('{sp-text}', '������:');
				}
			} else {
				$tpl->set('[sp]', '');
				$tpl->set('[/sp]', '');
			}
			
			if($row['user_sex'] == 2){
				$tpl->set('[user-m]', '');
				$tpl->set('[/user-m]', '');
				$tpl->set_block("'\\[user-w\\](.*?)\\[/user-w\\]'si","");
			} elseif($row['user_sex'] == 1){
				$tpl->set('[user-w]', '');
				$tpl->set('[/user-w]', '');
				$tpl->set_block("'\\[user-m\\](.*?)\\[/user-m\\]'si","");
			} else {
				$tpl->set('[sp-all]', '');
				$tpl->set('[/sp-all]', '');
				$tpl->set('[user-m]', '');
				$tpl->set('[/user-m]', '');
				$tpl->set('[user-w]', '');
				$tpl->set('[/user-w]', '');
			}
			
			$tpl->copy_template = str_replace("[instSelect-sp-{$user_sp[0]}]", 'selected', $tpl->copy_template);
			$tpl->set_block("'\\[instSelect-(.*?)\\]'si","");
			
			$tpl->set_block("'\\[contact\\](.*?)\\[/contact\\]'si","");
			$tpl->set_block("'\\[interests\\](.*?)\\[/interests\\]'si","");
			$tpl->set_block("'\\[education\\](.*?)\\[/education\\]'si","");
			$tpl->set_block("'\\[higher_education\\](.*?)\\[/higher_education\\]'si","");
			$tpl->set_block("'\\[xfields\\](.*?)\\[/xfields\\]'si","");
			$tpl->set_block("'\\[career\\](.*?)\\[/career\\]'si","");
			$tpl->set_block("'\\[military\\](.*?)\\[/military\\]'si","");
			$tpl->set_block("'\\[personal\\](.*?)\\[/personal\\]'si","");
			$tpl->set('[general]', '');
			$tpl->set('[/general]', '');
			$tpl->compile('content');
			$tpl->clear();
	}
	
} else {
	$user_speedbar = '����������';
	msgbox('', $lang['not_logged'], 'info');
}
?>