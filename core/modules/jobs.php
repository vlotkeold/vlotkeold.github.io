<?php

if(!defined('MOZG'))
    die('Hacking attempt!');

if($ajax == 'yes')
    NoAjaxQuery();
	$user_id = $user_info['user_id'];
	$metatags['title'] = "Работа яВинете";
	$user_speedbar = "Работа яВинете";
	
        $tpl->load_template('page/jobs.tpl');
        $tpl->set('{alt_name}', $alt_name);
        $tpl->set('{title}', stripslashes($row['title']));
        $tpl->set('{text}', stripslashes($row['text']));
        $tpl->compile('content');

    
    $tpl->clear();
    $db->free();

?>