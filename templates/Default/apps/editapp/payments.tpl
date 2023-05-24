<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
  <a href="/editapp/info_{id}" onClick="Page.Go(this.href); return false;"><div>Информация</div></a>
  <a href="/editapp/options_{id}" onClick="Page.Go(this.href); return false;"><div>Настройки</div></a>
  <div class="buttonsprofileSec2"><a href="/editapp/payments_{id}" onClick="Page.Go(this.href); return false;"><div>Платежи</div></a></div>
  <a href="/editapp/admins_{id}" onClick="Page.Go(this.href); return false;"><div>Администраторы</div></a>
 </div>
</div>
<div class="settings_general" style="">

<div id="app_edit_error_wrap">

<div id="app_edit_error"></div>

</div>

<div class="app_stat_head no_padd no_lpadd">История платежей - На балансе: {balance} голосов</div>
<div style="float:right;margin-top:-36px"><a onclick="AppsEdit." style="cursor:pointer">Вывести</a></div>
<div id="app_payments_settings_err" class="error" style="display: none; margin: 0 0 15px 0;"></div>

<div id="app_user_cont" style="margin-bottom: 20px;">

<table id="app_payments_table" cellspacing="0" cellpadding="0" class="wk_table">

<tbody>

<tr>

<th style="width:300px;padding: 1px 5px 2px;">

<div class="app_time_label">Пользователь</div>

</th>

<th style="padding: 1px 5px 2px;">

<div class="app_time_label">голосов</div>

</th>

<th style="width:155px; padding: 1px 5px 2px;">

<div class="app_time_label">Время</div>

</th>

</tr>{payments}</tbody>

</table>

</div>

<br class="clear">
</div>
