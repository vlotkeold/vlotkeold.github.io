<style type="text/css" media="all">
.texta_profileedit {width: 195px;padding-top: 5px;}
</style>
<script type="text/javascript">
$(document).ready(function(){
	myhtml.checked(['{settings-audio}','{settings-contact}','{settings-comments}','{settings-videos}']);
	$('#descr').autoResize({extraSpace:0,limit:608});
	if($('#public_category').val() == 0) $('#pcategory').hide();
});
</script>
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <div class="buttonsprofileSec2"><a href="/eclub?act=edit&cid={pid}" onClick="Page.Go(this.href); return false;"><div>Информация</div></a></div>
 <a href="/eclub?act=users&cid={pid}" onClick="Page.Go(this.href); return false;"><div>Участники</div></a>
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
  <div class="texta_profileedit">Описание:</div>
  <textarea class="inpst" style="height: 60px; width: 256px; margin-bottom: 10px; resize: none; overflow-y: hidden; position: absolute; top: 0px; left: -9999px; line-height: normal; text-decoration: none; letter-spacing: normal; " tabindex="-1"></textarea>
  <textarea id="descr" class="inpst" style="width:256px;height:60px;resize:none;overflow-y: hidden;">{edit-descr}</textarea>
  <div class="mgclr"></div>
  <div class="mgclr" style="padding-top:7px;"></div>
  <div class="texta_profileedit" style="padding-top: 0px;">Обратная связь:</div>
   <div class="html_checkbox" id="comments" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Комментарии включены</div>
  <div class="mgclr clear" style="padding-top:7px;"></div>
  <div class="texta_profileedit" style="padding-top: 0px;">Дополнительные разделы:</div>
  <div class="html_checkbox" id="contact" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Контакты</div>
  <div class="mgclr clear" style="padding-top:7px;"></div>
  <div class="texta_profileedit" style="padding-top: 0px;">Стена:</div>
 <div class="sett_privacy" onClick="clubs.privacyOpen('wall1')" id="wall_lnk_wall1" style="margin-top: -3px;">{val_wall1_text_wall}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_wall1" style="margin-top: 0px;margin-left: 200px;width: 80px;">
  <div id="selected_p_wall_lnk_wall1" class="sett_selected" onClick="clubs.privacyClose('wall1')">{val_wall1_text_wall}</div>
  <div class="sett_hover" onClick="clubs.setPrivacy('wall1', 'Выключена', '1', 'wall_lnk_wall1')">Выключена</div>
  <div class="sett_hover" onClick="clubs.setPrivacy('wall1', 'Открытая', '2', 'wall_lnk_wall1')">Открытая</div>
  <div class="sett_hover" onClick="clubs.setPrivacy('wall1', 'Закрытая', '3', 'wall_lnk_wall1')">Закрытая</div>
 </div>
 <input type="hidden" id="wall1" value="{val_wall1_wall}" />
<div class="mgclr clear" style="padding-top:5px;"></div>
  <div class="texta_profileedit" style="padding-top: 0px;">Тип группы:</div>
 <div class="sett_privacy" onClick="clubs.privacyOpen('intog')" id="intog_lnk_wall1" style="margin-top: -3px;">{val_intog_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_intog" style="margin-top: 0px;margin-left: 200px;width: 70px;">
  <div id="selected_p_wall_lnk_wall1" class="sett_selected" onClick="clubs.privacyClose('intog')">{val_intog_text}</div>
  <div class="sett_hover" onClick="clubs.setPrivacy('intog', 'Открытая', '1', 'intog_lnk_wall1')">Открытая</div>
  <div class="sett_hover" onClick="clubs.setPrivacy('intog', 'Закрытая', '2', 'intog_lnk_wall1')">Закрытая</div>
 </div>
 <input type="hidden" id="intog" value="{val_intog}" />
 <div class="mgclr clear" ></div>
<div style="margin: 15px 0px;"></div>
<div class="texta_profileedit">&nbsp;</div><div class="button_blue fl_l"><button name="save" onClick="eclub.saveInfo('{pid}'); return false" id="saveform_interests">Сохранить</button></div><div class="mgclr_edit"></div>
<br>
<br>
</div>