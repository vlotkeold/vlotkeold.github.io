<link media="screen" href="{theme}/style/im.css" type="text/css" rel="stylesheet" /> 
<input type="hidden" id="type" value="1"/>
<div class="miniature_box">
<div class="miniature_pos" style="width:637px;padding:0px;margin-top:{top}px">
<a class="fl_r tb_close" onClick="viiBox.clos('boxbuy', 1)" style="cursor: pointer;">Закрыть</a>
<script type="text/javascript">
$(document).ready(function(){
	$('.miniature_box').scroll(function(){
		if($('.miniature_box').scrollTop()>=parseInt($('.miniature_pos').css('margin-top'))+51){
			$('#tb_tabs').addClass('tb_fixed');
			$('.tb_tabs').css('width', '607px');
		} else $('#tb_tabs').removeClass('tb_fixed');
	});
});
</script>
<div class="tb_title" id="tb_title">Магазин стикеров</div>
<div class="tb_tabs_wrap" id="tb_tabs_wrap">
	<div id="tb_tabs">
		<div class="tb_tabs clear_fix">
			<div class="progress fl_r tb_prg"></div>
			<div class="fl_l summary_tab_sel">
				<a class="summary_tab2" style="cursor: pointer;"><div class="summary_tab3"><nobr>Все стикеры</nobr></div></a>
			</div>
		</div>
		<div class="tb_tabs_sh"></div>
	</div>
</div>

<div class="gifts_section clear_fix">
<div style="cursor:pointer">
<a class="fl_l im_sticker_bl" onclick="wall.attach_addstiker(); return false">
  <div class="fl_l im_sticker_bl_mimg"><img src="{theme}/images/stickers/102/128.png" width="88" height="96" class="im_sticker_bl_bimg"></div>
  <div class="fl_l im_sticker_bl_imgs">
    <div class="fl_l im_sticker_bl_simg"><img src="{theme}/images/stickers/103/64.png" width="38" height="42"></div><div class="fl_l im_sticker_bl_simg"><img src="{theme}/images/stickers/101/64.png" width="38" height="42"></div><div class="fl_l im_sticker_bl_simg"><img src="{theme}/images/stickers/105/64.png" width="38" height="42"></div><div class="fl_l im_sticker_bl_simg"><img src="{theme}/images/stickers/126/64.png" width="38" height="42"></div><div class="fl_l im_sticker_bl_simg"><img src="{theme}/images/stickers/107/64.png" width="42" height="42"></div><div class="fl_l im_sticker_bl_simg"><img src="{theme}/images/stickers/112/64.png" width="42" height="42"></div>
  </div>
  <div class="im_sticker_bl_info clear">
    <div class="fl_r im_sticker_bl_act"><div class="im_sticker_act fl_r">Добавлено<span class="emoji_sprite im_stickers_act_done fl_r"></span></div></div>
    <div class="im_sticker_bl_name">Смайлы</div>
    <div class="im_sticker_bl_desc">Владимир Воронков</div>
  </div>
</a>
</div>
<div style="cursor:pointer" class="fl_r">
<a class="fl_l im_sticker_bl" [stikers1_yes]onclick="wall.attach_addstiker_cat(); return false"[/stikers1_yes]>
  <div class="fl_l im_sticker_bl_mimg"><img src="{theme}/images/stickers/66/128.png" width="88" height="96" class="im_sticker_bl_bimg"></div>
  <div class="fl_l im_sticker_bl_imgs">
    <div class="fl_l im_sticker_bl_simg"><img src="{theme}/images/stickers/89/64.png" width="38" height="42"></div><div class="fl_l im_sticker_bl_simg"><img src="{theme}/images/stickers/63/64.png" width="38" height="42"></div><div class="fl_l im_sticker_bl_simg"><img src="{theme}/images/stickers/75/64.png" width="38" height="42"></div><div class="fl_l im_sticker_bl_simg"><img src="{theme}/images/stickers/71/64.png" width="38" height="42"></div><div class="fl_l im_sticker_bl_simg"><img src="{theme}/images/stickers/86/64.png" width="42" height="42"></div><div class="fl_l im_sticker_bl_simg"><img src="{theme}/images/stickers/50/64.png" width="42" height="42"></div>
  </div>
  <div class="im_sticker_bl_info clear">
  [stikers1_yes]<div class="fl_r im_sticker_bl_act"><div class="im_sticker_act fl_r">Добавлено<span class="emoji_sprite im_stickers_act_done fl_r"></span></div></div>[/stikers1_yes]
  [stikers1_no]<div class="im_sticker_act im_sticker_act_blue fl_r" onclick="stikers.buycat_1(); return false" id="cat_stik_1okd">5 голосов</div>[/stikers1_no]
    <div class="im_sticker_bl_name">Персик</div>
    <div class="im_sticker_bl_desc">Иосиф Сталин</div>
  </div>
</a>
</div>
</div>

</div>
</div>