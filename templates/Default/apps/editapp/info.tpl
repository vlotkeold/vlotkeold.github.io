<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
  <div class="buttonsprofileSec2"><a href="/editapp/info_{id}" onClick="Page.Go(this.href); return false;"><div>Информация</div></a></div>
  <a href="/editapp/options_{id}" onClick="Page.Go(this.href); return false;"><div>Настройки</div></a>
  <a href="/editapp/payments_{id}" onClick="Page.Go(this.href); return false;"><div>Платежи</div></a>
  <a href="/editapp/admins_{id}" onClick="Page.Go(this.href); return false;"><div>Администраторы</div></a>
 </div>
</div>
<div class="settings_general" style="height:200px">
<div id="apps_options_saved" class="apps_edit_success"></div>
<div style="margin-top:15px"></div>
<div id="apps_edit_img_block_reload" class="apps_edit_img_block">

<center><img id="apps_img_reload" src="{img}" id="apps_edit_img_small" style=""></center>


<div id="apps_edit_upload_small">

<div class="button_blue fl_l">

<button onclick="AppsEdit.LoadPhoto({id}); $('.profileMenu').hide(); return false;">Выбрать файл</button>

</div>

</div>

</div>

<div class="clear" style="margin-top:-136px;"></div>
  <div class="texta_profileedit">Название:</div>
   <input type="text" class="inpst" maxlength="100" id="app_name"  style="width:256px;" value="{title}" />
  <div class="mgclr"></div>

<div class="texta_profileedit">Описание:</div>
  <textarea class="inpst" style="height: 60px; width: 256px; margin-bottom: 10px; resize: none; overflow-y: hidden; position: absolute; top: 0px; left: -9999px; line-height: normal; text-decoration: none; letter-spacing: normal; " tabindex="-1"></textarea>
  <textarea id="app_desc" class="inpst" style="width:256px;height:60px;resize:none;overflow-y: hidden;">{desc}</textarea>
  <div class="mgclr"></div>

<input type="hidden" id="app_id" value="{id}">

<input type="hidden" id="app_hash" value="{hash}">
<div class="texta_profileedit">&nbsp;</div>
<div class="button_blue fl_l">

<button id="app_save_btn" onclick="AppsEdit.SaveOptions('save_info',{id});" style="width: 258px;">Сохранить изменения</button>

</div>


</div>
