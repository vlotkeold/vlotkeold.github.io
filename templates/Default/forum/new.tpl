<script type="text/javascript">
$(document).ready(function(){
	$('#title_n').focus();
});
</script>
<div class="search_form_tab" style="margin-top:-9px;background:#fff">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:31px">
  <a href="/public{id}" onClick="Page.Go(this.href); return false;"><div><b>� ����������</b></div></a>
  <a href="/forum{id}" onClick="Page.Go(this.href); return false;"><div><b>����������</b></div></a>
  <div class="buttonsprofileSec"><a href="/forum{id}?act=new" onClick="Page.Go(this.href); return false;"><div><b>����� ����</b></div></a></div>
 </div>
</div>
<div class="clear"></div>
<div class="note_add_bg">
<div class="videos_text">���������</div>
<input type="text" class="videos_input" style="width:805px" maxlength="65" id="title_n" />
<div class="input_hr"></div>
<div class="videos_text">�����</div>
<textarea class="videos_input wysiwyg_inpt" id="text" style="height:200px"></textarea>
<div class="clear"></div>
<div id="attach_files" class="no_display"></div>
<input id="vaLattach_files" type="hidden" />
<div class="clear"></div>
<div class="button_div fl_l margin_top_10"><button onClick="Forum.New('{id}'); return false" id="forum_sending">������� ����</button></div>
<div class="wall_attach fl_r" onClick="wall.attach_menu('open', this.id, 'wall_attach_menu')" onMouseOut="wall.attach_menu('close', this.id, 'wall_attach_menu')" id="wall_attach" style="margin-top:10px">����������</div>
 <div class="wall_attach_menu no_display" onMouseOver="wall.attach_menu('open', 'wall_attach', 'wall_attach_menu')" onMouseOut="wall.attach_menu('close', 'wall_attach', 'wall_attach_menu')" id="wall_attach_menu" style="margin-left:730px;margin-top:30px">
 <div class="wall_attach_icon_smile" id="wall_attach_link" onClick="wall.attach_addsmile()">�������</div>
 <div class="wall_attach_icon_photo" id="wall_attach_link" onClick="wall.attach_addphoto()">����������</div>
 <div class="wall_attach_icon_video" id="wall_attach_link" onClick="wall.attach_addvideo()">�����������</div>
 <div class="wall_attach_icon_audio" id="wall_attach_link" onClick="wall.attach_addaudio()">�����������</div>
 <div class="wall_attach_icon_doc" id="wall_attach_link" onClick="wall.attach_addDoc()">��������</div>
</div>
<div class="clear"></div>
</div>