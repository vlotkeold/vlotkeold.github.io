<script type="text/javascript">
$(document).ready(function(){
	var mw = ($('html, body').width()-845)/2;
	$('.photo_bg').css('margin-left', mw+'px').css('margin-right', mw+'px');
});
</script>
<div id="photo_view_{id}" class="photo_view" onClick="PhotoGroups.setEvent(event, '{close-link}')">
<div class="photo_close" onClick="PhotoGroups.Close('{close-link}'); return false;"></div>
 <div class="photo_bg">
  <div class="photo_com_title" style="padding-top:0px;">[all]���������� {jid} �� {photo-num}[/all][wall]�������� ����������[/wall]<div><a href="/" onClick="PhotoGroups.Close('{close-link}'); return false;">�������</a></div></div>
  [all]<a href="/photo-{uid}_{prev-id}{section}" onClick="PhotoGroups.Show(this.href); return false"><div class="photo_prev_but"></div></a>
  <a href="/photo-{uid}_{next-id}{section}" onClick="PhotoGroups.Show(this.href); return false"><div class="photo_next_but"></div></a>[/all]
  [mark-block]<div class="mark_userid_bg" id="mark_userid_bg{id}">
   <div class="fl_l"><a href="/id{mark-user-id}" onClick="Page.Go(this.href); return false">{mark-user-name}</a> {mark-gram-text} ��� �� ���� ����������.</a></div>
   <div class=" button_gray margin_left fl_r" style="margin-top:-5px"><button onClick="{mark-del-link}; return false">������� �������</button></div>
   <div class="button_blue fl_r" style="margin-top:-5px"><button onClick="Distinguish.OkUser({id}); return false">����������</button></div>
   <div class="clear"></div>
  </div>[/mark-block]
   <div id="distinguishSettings{id}" class="distinguishSettings" style="display:none" onMouseOver="Distinguish.HideTag({id})">
	<div style="position:absolute;border-right:3px solid #dbe6f0;cursor:default" id="distinguishSettingsBorder_left{id}"></div>
	<div style="position:absolute;border-bottom:3px solid #dbe6f0;cursor:default" id="distinguishSettingsBorder_top{id}"></div>
	<div style="position:absolute;border-left:3px solid #dbe6f0;cursor:default" id="distinguishSettingsBorder_right{id}"></div>
	<div style="position:absolute;border-top:3px solid #dbe6f0;cursor:default" id="distinguishSettingsBorder_bottom{id}"></div>
    <div style="position:absolute;cursor:default" class="imgareaselect-outer" id="distinguishSettings_left{id}"></div>
	<div style="position:absolute;cursor:default" class="imgareaselect-outer" id="distinguishSettings_top{id}"></div>
	<div style="position:absolute;cursor:default" class="imgareaselect-outer" id="distinguishSettings_right{id}"></div>
	<div style="position:absolute;cursor:default" class="imgareaselect-outer" id="distinguishSettings_bottom{id}"></div>
   </div>
   <a id="photo_href"><div class="photo_img_box cursor_pointer" onClick="[all]PhotoGroups.Show('/photo-{uid}_{next-id}{section}')[/all][wall]PhotoGroups.Close('{close-link}')[/wall]; return false"><img id="ladybug_ant{id}" class="ladybug_ant" src="{photo}" alt="" /></a></div>
  <div class="clear"></div>
  <div id="save_crop_text{id}" class="save_crop_text no_display" style="padding:20px;padding-left:0px">
   ������� �������, ������� ����� ��������� ��� ���������� ����� ��������.
   <div class=" button_gray margin_left fl_r" style="margin-top:-5px"><button onClick="crop.close({id}); return false">������</button></div>
   <div class="button_blue fl_r" style="margin-top:-5px"><button onClick="crop.save({id}, {uid}); return false">������</button></div>
  </div>
  <div id="pinfo_{id}" class="pinfo">
  <div class="photo_leftcol">
   <input type="hidden" id="i_left{id}" />
   <input type="hidden" id="i_top{id}" />
   <input type="hidden" id="i_width{id}" />
   <input type="hidden" id="i_height{id}" />
   <div id="pv_wide">
   <div class="peoples_on_this_photos" id="peoples_on_this_photos{id}" style="margin:0px 5px;margin-bottom: 15px;">{mark-peoples}</div><br><div class="mgclear"></div>
   <div class="pv_can_edit" id="photo_descr_{id}">{descr}</div>
   <div class="photo_info">��������� {date}</div></div>
   <br /><div style="margin-left:5px;">
   [all-comm]<a href="/" onClick="commentsGroups.all({id}, {num}); return false" id="all_href_lnk_comm_{id}"><div class="photo_all_comm_bg" id="all_lnk_comm_{id}">�������� ���������� {comm_num}</div></a><span id="all_comments_{id}"></span>[/all-comm]
   <span id="comments_{id}">{comments}</span>
   [add-comm]<div class="photo_com_title">��� �����������</div>
   <textarea id="textcom_{id}" class="inpst" style="width:520px;height:70px;margin-bottom:10px;"></textarea>
   <div class="button_blue fl_l"><button id="add_comm" onClick="commentsGroups.add({id}); return false">���������</button></div>[/add-comm]
   </div></div>
  <div class="photo_rightcol">
   �� �������:<br />
   <a href="/albums/view/{aid}" onClick="Page.Go(this.href); return false">{album-name}</a><br /><br />
   �����������:<br />
   <div><a href="/{user-id}" onClick="Page.Go(this.href); return false">{author}</a></div><br />
   <div class="menuleft" style="width:169px;margin-left:-5px">
    <a href="/" onClick="Distinguish.Start({id}); return false"><div>�������� ��������</div></a>
   [owner]<a href="/" onClick="crop.start({id}); return false"><div>��������� �� ��� ��������</div></a>
   <a href="/" onClick="PhotoGroups.MsgDelete({id}, {aid}, 1); return false"><div>������� ����������</div></a>
   <a href="/" onClick="PhotoGroups.EditBox({id}, 0); return false"><div>������������� ����������</div></a>[/owner]
   <a onClick="Report.Box('photo', '{id}')"><div>�������� ������</div></a>
   </div>
  </div>
 </div>
<div class="clear"></div>
</div>