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
 <a href="/epage?act=edit&pid={pid}" onClick="Page.Go(this.href); return false;"><div>Информация</div></a>
 <a href="/epage?act=users&pid={pid}" onClick="Page.Go(this.href); return false;"><div>Участники</div></a>
 [p_lastnews]<div class="buttonsprofileSec2"><a href="/epage?act=lastnews&pid={pid}" onClick="Page.Go(this.href); return false;"><div>Свежие новости</div></a></div>[/p_lastnews]
 <!--<a href="/epage?act=blacklist&pid={pid}" onClick="Page.Go(this.href); return false;"><div>Черный список</div></a>-->
 <a href="/epage?act=link&pid={pid}" onClick="Page.Go(this.href); return false;"><div>Ссылки</div></a>
</div>
</div>
<div style="margin-top:-120px"><a href="/{adres}" onClick="Page.Go(this.href); return false;" style="float:right;">Вернутся к сообществу</a></div>
<div style="margin-top:120px"></div>
<div class="settings_general">
<div class="err_yellow" id="info_save" style="display:none;font-weight:normal;margin: 20px 0px -20px 0px;"></div><br><br>


<form method="POST" action="" name="entryform">
<textarea class="videos_input wysiwyg_inpt" id="lastnews" name="lastnews">{lastnews}</textarea>
<div class="clear"></div>
</form>
<div style="margin: 15px 0px;"></div>
<div class="texta_profileedit">&nbsp;</div><div class="button_blue fl_l"><button name="save" onClick="epage.saveNews('{pid}'); return false" id="saveform_interests">Сохранить</button></div><div class="mgclr_edit"></div>
<br>
<br>
</div>