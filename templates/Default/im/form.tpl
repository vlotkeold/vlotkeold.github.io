<script type="text/javascript">
$(document).ready(function(){
	vii_interval_im = setInterval('im.update()', 2000);
	music.jPlayerInc();
	$('.im_scroll').scroll(function(){
		if($('.im_scroll').scrollTop() <= ($('.im_scroll').height()/2)+250)
			im.page('{for_user_id}');
	});
});
</script>
<div id="jquery_jplayer"></div>
<input type="hidden" id="teck_id" value="" />
<input type="hidden" id="typePlay" value="standart" />
<input type="hidden" id="teck_prefix" value="" />
<div class="note_add_bg clear support_addform im_addform">
<div id="im_bottom_sh" style="display: block;"></div>
<div class="ava_mini im_ava_mini">
 <a href="/id{myuser-id}" onClick="Page.Go(this.href); return false"><img src="{my-ava}" alt="" /></a>
</div>
<textarea 
	class="videos_input wysiwyg_inpt fl_l im_msg_texta" 
	id="msg_text" 
	style="height:40px"
	placeholder="������� ���� ���������.."
	onKeyPress="if(event.keyCode == 10 || (event.ctrlKey && event.keyCode == 13)) im.send('{for_user_id}', '{my-name}', '{my-ava}')"
	onKeyUp="im.typograf()"
></textarea>
<div class="ava_mini im_ava_mini" style="margin-bottom: 3px;">
 <a href="/id{for_user_id}" onClick="Page.Go(this.href); return false"><img src="{for-ava}" alt="" /></a>
</div>
{online}
<div class="clear"></div>
<div id="attach_files" class="no_display" style="margin-left:60px"></div>
<input id="vaLattach_files" type="hidden" />
<div class="clear"></div>
<div class="button_blue fl_l" style="margin-left:60px;margin-top: -5px;"><button onClick="im.send('{for_user_id}', '{my-name}', '{my-ava}')" id="sending">���������</button></div>
<div style="margin-top: -5px;"><div class="wall_attach_icon_smile fl_l" id="wall_attach_link" onclick="wall.attach_addphoto()" style="margin-left:5px"></div></div>
<div style="margin-top: -5px;"><div class="wall_attach_icon_gifts fl_l" id="wall_attach_link" onclick="stikers.boxbuy()" style="margin-left:5px"></div></div>
<div class="wall_attach fl_l" onClick="wall.attach_menu('open', this.id, 'wall_attach_menu')" onMouseOut="wall.attach_menu('close', this.id, 'wall_attach_menu')" id="wall_attach" style="margin-top:-5px;margin-left: 170px;">����������</div>
 <div class="wall_attach_menu no_display" onMouseOver="wall.attach_menu('open', 'wall_attach', 'wall_attach_menu')" onMouseOut="wall.attach_menu('close', 'wall_attach', 'wall_attach_menu')" id="wall_attach_menu" style="margin-left: 295px;margin-top: -75px;">
 <div class="wall_attach_icon_gifts" id="wall_attach_link" onClick="gifts.box('{for_user_id}')">�������</div>
 <div class="wall_attach_icon_smile" id="wall_attach_link" onClick="wall.attach_addsmile()">�������</div>
 <div class="wall_attach_icon_video" id="wall_attach_link" onClick="wall.attach_addvideo()">�����������</div>
 <div class="wall_attach_icon_photo" id="wall_attach_link" onClick="wall.attach_addaudio()">�����������</div>
 <div class="wall_attach_icon_audio" id="wall_attach_link" onClick="wall.attach_addDoc()">��������</div>
</div>
<div class="clear" style="margin-top:10px"></div>
<div class="clear"></div>
</div>
<input type="hidden" id="status_sending" value="1" />
<input type="hidden" id="for_user_id" value="{for_user_id}" />