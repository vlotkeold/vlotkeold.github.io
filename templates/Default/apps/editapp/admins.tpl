<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
  <a href="/editapp/info_{id}" onClick="Page.Go(this.href); return false;"><div>Информация</div></a>
  <a href="/editapp/options_{id}" onClick="Page.Go(this.href); return false;"><div>Настройки</div></a>
  <a href="/editapp/payments_{id}" onClick="Page.Go(this.href); return false;"><div>Платежи</div></a>
  <div class="buttonsprofileSec2"><a href="/editapp/admins_{id}" onClick="Page.Go(this.href); return false;"><div>Администраторы</div></a></div>
 </div>
</div>

<div id="content_reload">

<div id="app_edit">

<input type="hidden" id="app_id" value="{id}">

<input type="hidden" id="app_hash" value="{hash}">

<div class="button_blue fl_r" style="margin-right: 15px;">

<button id="apps_edit_search_btn" onclick="AppsEdit.uSearch()">Добавить администратора</button>

</div>

<div class="app_edit_main">

<div id="app_edit_error_wrap">

<div id="app_edit_error"></div>

</div>

<div id="app_edit_wrap">

<div id="apps_edit_admins">

<div id="apps_edit_summary_wrap" class="summary_wrap" style="display: block;margin-top:20px;">

<div id="apps_edit_summary" class="summary">У приложения {numadmin}</div>

</div>

<div id="apps_edit_users_rows" class="clear_fix">

<div id="apps_edit_admin{uid}" class="apps_edit_user clear_fix">

<div class="apps_edit_user_thumb_wrap fl_l">

<a class="apps_edit_user_thumb" href="/id{uid}">

<img class="apps_edit_user_img" src="{img}" width="32">

</a>

</div>

<div class="apps_edit_user_info fl_l">

<a class="apps_edit_user_name" href="/id{uid}">{name} </a>  <b> главный администратор</b>

</div>

<div class="apps_edit_user_actions fl_r"><a class="apps_edit_user_action" onclick="AppsEdit.uRemoveAdmin({uid})">Разжаловать</a></div>

</div>

{all}

</div>

</div>

</div>

</div>

</div>

</div>
