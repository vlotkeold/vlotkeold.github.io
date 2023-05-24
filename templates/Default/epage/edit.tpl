<style type="text/css" media="all">
.texta_profileedit {width: 195px;padding-top: 5px;}
</style>
<script type="text/javascript">
$(document).ready(function(){
	myhtml.checked(['{settings-audio}','{settings-contact}','{settings-comments}','{settings-videos}','{settings-lastnews}', '{settings-links}', '{settings-albums}']);
	$('#descr').autoResize({extraSpace:0,limit:608});
	if($('#public_category').val() == 0) $('#pcategory').hide();
});
</script>
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <div class="buttonsprofileSec2"><a href="/epage?act=edit&pid={pid}" onClick="Page.Go(this.href); return false;"><div>Информация</div></a></div>
 [noadmin_red]<a href="/epage?act=users&pid={pid}" onClick="Page.Go(this.href); return false;"><div>Участники</div></a>[/noadmin_red]
 [p_lastnews]<a href="/epage?act=lastnews&pid={pid}" onClick="Page.Go(this.href); return false;"><div>Свежие новости</div></a>[/p_lastnews]
 <!--<a href="/epage?act=blacklist&pid={pid}" onClick="Page.Go(this.href); return false;"><div>Черный список</div></a>-->
 <a href="/epage?act=link&pid={pid}" onClick="Page.Go(this.href); return false;"><div>Ссылки</div></a>
</div>
</div>
<div style="margin-top:-120px"><a href="/{adres}" onClick="Page.Go(this.href); return false;" style="float:right;">Вернутся к сообществу</a></div>
<div style="margin-top:120px"></div>
<div class="settings_general">
<div class="err_yellow" id="info_save" style="display:none;font-weight:normal;margin: 20px 0px -20px 0px;"></div><br><br>
<div class="clear" style="margin-top:10px;"></div>
  <div class="texta_profileedit">Название:</div>
   <input type="text" id="title" class="inpst" maxlength="100"  style="width:256px;" value="{title}" />
  <div class="mgclr"></div>
    <div class="texta_profileedit">Адрес страницы:</div>
   <span style="border: 1px solid #C6D4DC;  border-right: 0px;padding: 3px 4px;margin-right: -6px;color: #777;" onclick="settings.elfocus('adres_page')">
   http://ivinete.ru/</span><input type="text" id="adres_page" class="inpst" maxlength="10"  style="width:172px;border-left:0px;outline:none;background: transparent;" value="{adres}" />
  <div class="mgclr"></div>  
  <div class="texta_profileedit">Категория:</div>
  <div class="group_edit_field fl_l">
  <div id="container1" class="selector_container dropdown_container selector_focused" style="width: 266px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected" readonly="true" value="{category_name}" style="color: rgb(0, 0, 0); width: 239px; " id="container1">
							<input type="hidden" name="public_category" id="public_category" value="{category_id}" class="resultField">
							<input type="hidden" name="public_category_custom" id="public_category_custom" value="" class="customField">
					</td>
					<td id="container1" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 266px; height: auto; bottom: auto; visibility: visible;"><ul>{categores}</ul></div>
		<div class="result_list_shadow" style="width: 266px;"><div class="shadow1"></div><div class="shadow2"></div></div></div></div>
  </div>
  <div class="mgclr"></div>
  <!--<div id="pcategory">
  <div class="texta_profileedit">Подкатегория:</div>
  <div class="group_edit_field fl_l">
  <div id="container2" class="selector_container dropdown_container selector_focused" style="width: 266px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected" readonly="true" value="{pcategory_name}" style="color: rgb(0, 0, 0); width: 239px; " id="container2">
							<input type="hidden" name="public_pcategory" id="public_pcategory" value="{pcategory_id}" class="resultField">
							<input type="hidden" name="public_category_custom" id="public_category_custom" value="" class="customField">
					</td>
					<td id="container2" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 266px; bottom: auto; visibility: visible;position:relative"><ul id="pcategory_list">{pcategores}</ul></div>
		<div class="result_list_shadow" style="width: 266px;"><div class="shadow1"></div><div class="shadow2"></div></div></div></div>
  </div>
  <div class="mgclr"></div>
  </div>-->
  <div class="mgclr"></div>
  <div class="texta_profileedit">Описание:</div>
  <textarea class="inpst" style="height: 60px; width: 256px; margin-bottom: 10px; resize: none; overflow-y: hidden; position: absolute; top: 0px; left: -9999px; line-height: normal; text-decoration: none; letter-spacing: normal; " tabindex="-1"></textarea>
  <textarea id="descr" class="inpst" style="width:256px;height:60px;resize:none;overflow-y: hidden;">{edit-descr}</textarea>
  <div class="mgclr"></div>
  <div class="texta_profileedit">Веб-сайт:</div>
   <input type="text" id="website" class="inpst" maxlength="100"  style="width:256px;" value="{website}" />
  <div class="mgclr"></div>
  <div class="texta_profileedit">Дата основания:</div>
  <div class="group_edit_field fl_l">
  <div id="day_block" class="fl_l">
  <div id="container5" class="selector_container dropdown_container selector_focused fl_l" style="width: 60px;">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected" readonly="true" value="{day_name}" style="color: rgb(0, 0, 0); width: 37px; " id="container5">
							<input type="hidden" name="day" id="day" value="{day_id}" class="resultField">
							<input type="hidden" name="public_category_custom" id="public_category_custom" value="" class="customField">
					</td>
					<td id="container5" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 60px; height: 250px; visibility: visible; overflow-x: hidden; overflow-y: visible;"><ul id="day_list">{day}</ul></div>
		<div class="result_list_shadow" style="width: 60px; margin-top: 250px; "><div class="shadow1"></div><div class="shadow2"></div></div></div></div>
  </div>
  <div class="fl_l" style="padding:1px 4px;"></div>
  <div id="container4" class="selector_container dropdown_container selector_focused fl_l" style="width: 130px;">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected" readonly="true" value="{month_name}" style="color: rgb(0, 0, 0); width: 107px; " id="container4">
							<input type="hidden" name="month" id="month" value="{month_id}" class="resultField">
							<input type="hidden" name="public_category_custom" id="public_category_custom" value="" class="customField">
					</td>
					<td id="container4" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 130px; height: 235px; visibility: visible; overflow-x: hidden; overflow-y: visible;"><ul>{month}</ul></div>
		<div class="result_list_shadow" style="width: 130px; margin-top: 235px; "><div class="shadow1"></div><div class="shadow2"></div></div></div></div>
  <div class="fl_l" style="padding:1px 4px;"></div>
  <div id="container3" class="selector_container dropdown_container selector_focused fl_l" style="width: 60px;">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected" readonly="true" value="{years_name}" style="color: rgb(0, 0, 0); width: 37px; " id="container3">
							<input type="hidden" name="years" id="years" value="{years_id}" class="resultField">
							<input type="hidden" name="public_category_custom" id="public_category_custom" value="" class="customField">
					</td>
					<td id="container3" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 60px; height: 250px; visibility: visible; overflow-x: hidden; overflow-y: visible;"><ul>{years}</ul></div>
		<div class="result_list_shadow" style="width: 60px; margin-top: 250px; "><div class="shadow1"></div><div class="shadow2"></div></div></div></div>
  </div>
  <div class="mgclr" style="padding-top:7px;"></div>
  <div class="texta_profileedit" style="padding-top: 0px;">Обратная связь:</div>
   <div class="html_checkbox" id="comments" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Комментарии включены</div>
  <div class="mgclr clear" style="padding-top:7px;"></div>
  <div class="texta_profileedit" style="padding-top: 0px;">Дополнительные разделы:</div>
  <div class="html_checkbox" id="links" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Ссылки</div>
  <div class="mgclr clear" style="padding-top:3px;"></div>
  <div class="texta_profileedit" style="padding-top: 0px;">&nbsp;</div>
  <div class="html_checkbox" id="albums" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Фотоальбомы</div>
  <div class="mgclr clear" style="padding-top:3px;"></div>
  <div class="texta_profileedit" style="padding-top: 0px;">&nbsp;</div>
   <div class="html_checkbox" id="audio" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Аудиозаписи</div>
  <div class="mgclr clear" style="padding-top:3px;"></div>
  <div class="texta_profileedit" style="padding-top: 0px;">&nbsp;</div>
  <div class="html_checkbox" id="contact" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Контакты</div>
  <div class="mgclr clear" style="padding-top:3px;"></div>
  <div class="texta_profileedit" style="padding-top: 0px;">&nbsp;</div>
  <div class="html_checkbox" id="videos" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Видеозаписи</div>
  <div class="mgclr clear" style="padding-top:3px;"></div>
  <div class="texta_profileedit" style="padding-top: 0px;">&nbsp;</div>
  <div class="html_checkbox" id="lastnews" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Свежие новости</div>
  <div class="mgclr clear"></div>
<div style="margin: 15px 0px;"></div>
<div class="texta_profileedit">&nbsp;</div><div class="button_blue fl_l"><button name="save" onClick="epage.saveInfo('{pid}'); return false" id="saveform_interests">Сохранить</button></div><div class="mgclr_edit"></div>
<br>
<br>
</div>