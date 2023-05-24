<script type="text/javascript">
$(document).ready(function(){
	myhtml.checked(['{n_friends}', '{n_wall}', '{n_comm}', '{n_comm_ph}', '{n_comm_note}', '{n_gifts}', '{n_rec}', '{n_im}']);
});
function save_notify(){
	var n_friends = $('#n_friends').val();
	var n_wall = $('#n_wall').val();
	var n_comm = $('#n_comm').val();
	var n_comm_ph = $('#n_comm_ph').val();
	var n_comm_note = $('#n_comm_note').val();
	var n_gifts = $('#n_gifts').val();
	var n_rec = $('#n_rec').val();
	var n_im = $('#n_im').val();
	$.post('/index.php?go=settings&act=save_notify', {n_friends: n_friends, n_wall: n_wall, n_comm: n_comm, n_comm_ph: n_comm_ph, n_comm_note: n_comm_note, n_gifts: n_gifts, n_rec: n_rec, n_im: n_im});
}
</script>
<div class="search_form_tab">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:15px">
  <a href="/settings" onClick="Page.Go(this.href); return false;"><div>Общее</div></a>
  <a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div>Приватность</div></a>
  <div class="buttonsprofileSec"><a href="/settings/notify" onClick="Page.Go(this.href); return false;"><div>Оповещения</div></a></div>
  <a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div>Черный список</div></a>
<a href="/balance" onClick="Page.Go(this.href); return false;"><div>Баланс</div></a>
<a href="/balance?act=history" onClick="Page.Go(this.href); return false;"><div>История</div></a>
<a href="/balance?act=invited" onClick="Page.Go(this.href); return false;"><div>Приглашённые друзья</div></a>
</div>
</div>
<div class="settings_notify">
<div class="settings_section">
<div class="clear"></div>
<div class="margin_top_10"></div><div class="allbar_title">Оповещения по электронной почте</div>
<div class="page_bg border_radius_5 clear margin_top_10">
<div class="html_checkbox" id="n_friends" onClick="myhtml.checkbox(this.id); save_notify()">Заявки в друзья </div><div class="clear" style="height:10px"></div>
<div class="html_checkbox" id="n_wall" onClick="myhtml.checkbox(this.id); save_notify()">Ответ на запись</div><div class="clear" style="height:10px"></div>
<div class="html_checkbox" id="n_comm" onClick="myhtml.checkbox(this.id); save_notify()">Комментирование видеозаписей</div><div class="clear" style="height:10px"></div>
<div class="html_checkbox" id="n_comm_ph" onClick="myhtml.checkbox(this.id); save_notify()">Комментарии к фотографиям</div><div class="clear" style="height:10px"></div>
<div class="html_checkbox" id="n_comm_note" onClick="myhtml.checkbox(this.id); save_notify()">Комментирование заметок</div><div class="clear" style="height:10px"></div>
<div class="html_checkbox" id="n_gifts" onClick="myhtml.checkbox(this.id); save_notify()">Подарки и конкурсы</div><div class="clear" style="height:10px"></div>
<div class="html_checkbox" id="n_rec" onClick="myhtml.checkbox(this.id); save_notify()">Комментарии на стене</div><div class="clear" style="height:10px"></div>
<div class="html_checkbox" id="n_im" onClick="myhtml.checkbox(this.id); save_notify()">Личные сообщения</div><div class="clear"></div>
</div>

<div class="allbar_title">Звуковые оповещения</div>
{user_audio_off_button}
<div class="mgclr"></div>
</div></div>