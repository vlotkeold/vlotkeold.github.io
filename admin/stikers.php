<?php
/* 
	Appointment: Stikers
	File: stikers.php
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

//Если нажали "Добавить"
if(isset($_POST['save'])){
	$category = intval($_POST['category']);
	
	//Разришенные форматы
	$allowed_files = array('png');
	
	//Получаем данные о фотографии ОРИГИНАЛ
	$image_tmp = $_FILES['original']['tmp_name'];
	$image_name = totranslit($_FILES['original']['name']); // оригинальное название для оприделения формата
	$image_size = $_FILES['original']['size']; // размер файла
	$type = end(explode(".", $image_name)); // формат файла

	//Получаем данные о фотографии КОПИЯ
	$image_tmp_2 = $_FILES['thumbnail']['tmp_name'];
	$image_name_2 = totranslit($_FILES['thumbnail']['name']); // оригинальное название для оприделения формата
	$image_size_2 = $_FILES['thumbnail']['size']; // размер файла
	$type_2 = end(explode(".", $image_name_2)); // формат файла

	//Проверям если, формат верный то пропускаем
		if(in_array(strtolower($type), $allowed_files)){
			if($category >= 1){
			if($image_size < 200000){
					$rand_name = rand(0, 1000);
					move_uploaded_file($image_tmp, ROOT_DIR.'/uploads/stikers/'.$rand_name.'.'.$type);
					$db->query("INSERT INTO `".PREFIX."_stikers_list` SET img = '".$rand_name."', category = '".$category."'");
					msgbox('Информация', 'Стикер успешно добавлен', '?mod=stikers');
			} else
				msgbox('Ошибка', 'Оригинал привышает допустимый размер 200 кб', 'javascript:history.go(-1)');
			} else
				msgbox('Error', 'Укажите категорию', 'javascript:history.go(-1)');
		} else
			msgbox('Ошибка', 'Неправильный формат', 'javascript:history.go(-1)');
	
	die();
}

//Удаление
if($_GET['act'] == 'del'){
	$id = intval($_GET['id']);
	$row = $db->super_query("SELECT img FROM `".PREFIX."_stikers_list` WHERE sid = '".$id."'");
	if($row){
		$db->query("DELETE FROM `".PREFIX."_stikers_list` WHERE sid = '".$id."'");
		@unlink(ROOT_DIR."/uploads/stikers/".$row['img'].'.png');
		header('Location: ?mod=stikers');
	}
}

//Сохраняем
if($_GET['act'] == 'edit'){
	$id = intval($_GET['id']);
	$category = intval($_GET['category']);
	if($price <= 0) $price = 1;
	$db->query("UPDATE`".PREFIX."_stikers_list` SET category = '".$category."' WHERE sid = '".$id."'");
	header('Location: ?mod=stikers');
}

echoheader();

$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_stikers_list`");

$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS * FROM `".PREFIX."_stikers_list` ORDER by `sid` DESC", 1);
foreach($sql_ as $row){
	$stikers .= <<<HTML
<div style="float:left;width: 150px;height:150px;text-align:center;margin-bottom:55px;margin-top:10px">
<center><img src="/uploads/stikers/{$row['img']}.png" style="margin-bottom:15px" /></center>
Категория: <input type="text" id="category{$row['sid']}" class="inpu" value="{$row['category']}" /><br />
[ <a href="?mod=stikers" onClick="window.location.href='?mod=stikers&act=edit&id={$row['sid']}&category='+document.getElementById('category{$row['sid']}').value; return false">изменить категорию</a> ] [ <a href="?mod=stikers&act=del&id={$row['sid']}">удалить</a> ]
</div>
HTML;
}

echohtmlstart('Добавление стикера');
			
echo <<<HTML
<style type="text/css" media="all">
.inpu{width:50px;}
textarea{width:450px;height:400px;}
</style>

<form action="" enctype="multipart/form-data" method="POST">

<input type="hidden" name="mod" value="notes" />

<div class="fllogall" style="width:180px">Категория:</div>
 <input type="text" name="category" class="inpu" />
<div class="mgcler"></div>

<div class="fllogall" style="width:180px">Оригинал .png:</div>
 <input type="file" name="original" class="inpu" style="width:300px" />
<div class="mgcler"></div>

<div class="fllogall" style="width:180px">&nbsp;</div>
 <input type="submit" value="Добавить" class="inp" name="save" style="margin-top:0px" />
</form>
HTML;

echohtmlstart('Список стикеров ('.$numRows['cnt'].')');

echo <<<HTML
{$stikers}
<div class="clr"></div>
HTML;

echohtmlend();
?>