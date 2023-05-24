<?php

if(!defined('MOZG'))
    die('Hacking attempt!');

if($ajax == 'yes')
    NoAjaxQuery();
	$metatags['title'] = "Пользовательское соглашение";
	$user_id = $user_info['user_id'];
	
        $tpl->load_template('terms/index.tpl');
        $tpl->set('{alt_name}', $alt_name);
        $tpl->set('{title}', stripslashes($row['title']));
        $tpl->set('{text}', stripslashes($row['text']));
        $tpl->compile('content');

    
    $tpl->clear();
    $db->free();

?>