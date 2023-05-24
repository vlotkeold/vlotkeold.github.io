<script type="text/javascript">
$(document).click(function(event){
	settings.event(event);
});
</script>
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
  <a href="/settings" onClick="Page.Go(this.href); return false;"><div>Общее</div></a>
  <a href="/settings&act=privacy" onClick="Page.Go(this.href); return false;"><div>Приватность</div></a>
  <a href="/settings&act=blacklist" onClick="Page.Go(this.href); return false;"><div>Черный список</div></a>
  <a href="/settings&act=mobile" onClick="Page.Go(this.href); return false;"><div>Мобильные сервисы</div></a>
  [stikers]<div class="buttonsprofileSec2"><a href="/settings&act=stikers" onClick="Page.Go(this.href); return false;"><div>Стикеры</div></a></div>[/stikers]
  <a href="/settings&act=balance" onClick="Page.Go(this.href); return false;"><div>Баланс</div></a>
 </div>
</div>
<div class="settings_general">
<div class="margin_top_10"></div><div class="allbar_title">Мои стикеры</div>
<div class="settings_section">
{stikers_nabor}
</div>
<div class="margin_top_10"></div><div class="allbar_title">Платные стикеры</div>
<div class="settings_section">
{stikers_nabor_buy}
</div>
</div>