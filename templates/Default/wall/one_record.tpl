[record]<div class="wallrecord wall_upage" id="wall_record_{rec-id}" style="padding-bottom:4px;margin-top:5px">
 <div style="float:left;width:60px"><div class="ava_mini [privacy-comment][if-comments]wall_ava_mini[/if-comments][/privacy-comment]" id="ava_rec_{rec-id}"><a href="/id{user-id}" onClick="Page.Go(this.href); return false"><img src="{ava}" alt="" title="" /></a>{online}</div></div>
 <div class="wall_rec_autoresize" style="width:550px">
 <div class="wallauthor fl_l" style="padding-left:0px"><a href="/id{user-id}" onClick="Page.Go(this.href); return false">{name}</a> <span class="color777">{type}</span></div>
 [owner]<div class="wall_delete" onMouseOver="myhtml.title('{rec-id}', '<b>������� ������</b>', 'wall_del_')" onClick="wall.delet('{rec-id}'); return false" id="wall_del_{rec-id}"></div>
[yesedit][yesedittime]<div class="editwall" onMouseOver="myhtml.title('{rec-id}', '<b>�������������</b>', 'wall_edit_')" onClick="wall.edit_form('{rec-id}'); return false" id="wall_edit_{rec-id}"></div>[/yesedittime][/yesedit][/owner]
 <div class="wall_tell_ok no_display" id="wall_ok_tell_{rec-id}" style="margin-left:2px;margin-top:1px"></div>
 [owner-record]<div class="wall_delete" onMouseOver="myhtml.title('{rec-id}', '<b>�������� ��� ����</b>', 'wall_spam_')" onClick="Report.WallSend('wall', '{rec-id}'); return false"id="wall_spam_{rec-id}"></div>[/owner-record]
 <div class="wall_clear"></div>
 <div class="walltext" id="edit_rec_{rec-id}">{text}</div>
 <div id="edit_rec_cont_{rec-id}" class="no_display">
<textarea id="texts_{rec-id}" name="texts" class="inpst" style="width:530px;height:30px">{text_edit}</textarea>
<div class="button_blue fl_l" style="margin-top:2px;"><button style="" onClick="wall.save({rec-id}); return false">��������� ���������</button></div>
<div class="button_div_nostl fl_l margin_left" style="margin-top:2px;"><button onClick="wall.edit_close('{rec-id}'); return false">������</button></div>
<div style="padding:12px"></div></div>
 <div class="size10 infowalltext_f clear">
  <div class="fl_l">{date} [privacy-comment][comments-link]<span id="fast_comm_link_{rec-id}" class="fast_comm_link">&nbsp;|&nbsp; <a href="/" id="fast_link_{rec-id}" onClick="wall.open_fast_form('{rec-id}'); wall.fast_open_textarea('{rec-id}'); return false">��������������</a></span>[/comments-link][/privacy-comment]</div>
  <div class="public_likes_user_block no_display" style="margin-left:440px" id="public_likes_user_block{rec-id}" onMouseOver="groups.wall_like_users_five('{rec-id}')" onMouseOut="groups.wall_like_users_five_hide('{rec-id}')">
   <div onClick="wall.all_liked_users('{rec-id}', '', '{likes}')">����������� {likes-text}</div>
   <div class="public_wall_likes_hidden">
    <div class="public_wall_likes_hidden2">
     <a href="/id{viewer-id}" id="like_user{viewer-id}_{rec-id}" class="no_display" onClick="Page.Go(this.href); return false"><img src="{viewer-ava}" width="32" /></a>
     <div id="likes_users{rec-id}"></div>
    </div>
   </div>
   <div class="public_like_strelka"></div>
  </div>
  <input type="hidden" id="update_like{rec-id}" value="0" />
  <div class="fl_r public_wall_like cursor_pointer" onClick="{like-js-function}" onMouseOver="groups.wall_like_users_five('{rec-id}', 'uPages')" onMouseOut="groups.wall_like_users_five_hide('{rec-id}')" id="wall_like_link{rec-id}">
   <div class="fl_l" id="wall_like_active">{translate=wall_like}</div>
   <div class="public_wall_like_no {yes-like}" id="wall_active_ic{rec-id}"></div>
   <b id="wall_like_cnt{rec-id}" class="{yes-like-color}">{likes}</b>
  </div>
   <div class="wall_tell_all cursor_pointer" onMouseOver="myhtml.title('{rec-id}', '��������� � ���������� ��� �����', 'wall_tell_all_')" onClick="Repost.Box('{rec-id}'); return false "id="wall_tell_all_{rec-id}"></div>
  [privacy-comment][comments-link]<div class="wall_fast_form no_display" id="fast_form_{rec-id}">
   <div class="no_display wall_fast_texatrea" id="fast_textarea_{rec-id}">
    <textarea class="wall_inpst fast_form_width wall_fast_text" style="height:33px;color:#000;margin:0px" id="fast_text_{rec-id}"
		onKeyPress="if(event.keyCode == 10 || (event.ctrlKey && event.keyCode == 13))wall.fast_send('{rec-id}', '{author-id}')"
	></textarea>
    <div class="button_blue fl_l margin_top_5"><button onClick="wall.fast_send('{rec-id}', '{author-id}'); return false" id="fast_buts_{rec-id}">{translate=wall_send}</button></div>
   </div>
   <div class="clear"></div>
  </div>[/comments-link][/privacy-comment]
 </div>
 <div class="clear"></div>
 </div>
 <div class="clear"></div>
</div>
[/record]
[all-comm]<div class="cursor_pointer" onClick="wall.all_comments('{rec-id}', '{author-id}'); return false" id="wall_all_but_link_{rec-id}"><div class="public_wall_all_comm" id="wall_all_comm_but_{rec-id}">�������� {gram-record-all-comm}</div></div>[/all-comm]
[comment]<div class="wall_fast_block" id="wall_fast_comment_{comm-id}" onMouseOver="ge('fast_del_{comm-id}').style.display = 'block'" onMouseOut="ge('fast_del_{comm-id}').style.display = 'none'">
<div class="wall_fast_ava"><a href="/id{user-id}" onClick="Page.Go(this.href); return false"><img src="{ava}" alt="" /></a></div>
<div><a href="/id{user-id}" onClick="Page.Go(this.href); return false">{name}</a></div>[owner]<div class="comm_delete" onMouseOver="myhtml.title('{comm-id}', '<b>�������</b>', 'wall_del_')" onClick="wall.fast_comm_del('{comm-id}'); return false" id="wall_del_{comm-id}"></div>[/owner]
[uowner][yesedit][yesedittime]<div class="editcomm" onMouseOver="myhtml.title('{comm-id}', '<b>�������������</b>', 'wall_edit_')" onClick="wall.edit_form('{comm-id}'); return false" id="wall_edit_{comm-id}"></div>[/yesedittime][/yesedit][/uowner]
<div class="wall_fast_comment_text" id="edit_rec_{comm-id}">{text}</div>
<div id="edit_rec_cont_{comm-id}" class="no_display">
<textarea id="texts_{comm-id}" name="texts" class="inpst" style="width:500px;height:30px">{text_edit}</textarea>
<div class="button_blue fl_l" style="margin-top:2px;margin-left:37px"><button style="" onClick="wall.save({comm-id}); return false">��������� ���������</button></div>
<div class="button_div_nostl fl_l margin_left" style="margin-top:2px;"><button onClick="wall.edit_close('{comm-id}'); return false">������</button></div>
<div style="padding:15px"></div></div>
<div class="wall_fast_date fl_l">{date}</div>
<div class="clear"></div>
</div>[/comment]
[comment-form]<div class="wall_fast_opened_form" id="fast_form" style="width:550px;">
 <input type="text" class="wall_inpst fast_form_width wall_fast_input" value="��������������..." id="fast_inpt_{rec-id}" onMouseDown="wall.fast_open_textarea('{rec-id}', 2); return false" style="width:540px;margin:0px" />
 <div class="no_display wall_fast_texatrea" id="fast_textarea_{rec-id}">
  <textarea class="wall_inpst fast_form_width wall_fast_text" style="height:33px;width:540px;color:#000;margin-top:0px" id="fast_text_{rec-id}"
	onKeyPress="if(event.keyCode == 10 || (event.ctrlKey && event.keyCode == 13))wall.fast_send('{rec-id}', '{author-id}')"
	onKeyUp="wall.CheckLinkTextComm(this.value)"
	onBlur="wall.CheckLinkTextComm(this.value, 1)"
  ></textarea>
  <div id="attach_files_comm" class="margin_top_10 no_display"></div>
   <div id="attach_block_lnk_comm" class="no_display clear">
   <div class="attach_link_bg">
    <div align="center" id="loading_att_lnk_comm"><img src="{theme}/images/loading_mini.gif" style="margin-bottom:-2px" /></div>
    <img src="" align="left" id="attatch_link_img_comm" class="no_display cursor_pointer" onClick="wall.UrlNextImgComm()" />
	<div id="attatch_link_title_comm"></div>
	<div id="attatch_link_descr_comm"></div>
	<div class="clear"></div>
   </div>
   <div class="attach_toolip_but"></div>
   <div class="attach_link_block_ic fl_l"></div><div class="attach_link_block_te"><div class="fl_l">������: <a href="/" id="attatch_link_url_comm" target="_blank"></a></div><img class="fl_l cursor_pointer" style="margin-top:2px;margin-left:5px" src="{theme}/images/close_a.png" onMouseOver="myhtml.title('1', '�� �����������', 'attach_lnk_')" id="attach_lnk_1" onClick="wall.RemoveAttachLnkComm()" /></div>
   <input type="hidden" id="attach_lnk_stared_com" />
   <input type="hidden" id="teck_link_attach_com" />
   <span id="urlParseImgs_com" class="no_display"></span>
   </div>
   <div class="clear"></div>
   <input id="vaLattach_files_comm" type="hidden" />
   <div class="clear"></div>
  <div class="button_div fl_l margin_top_5"><button onClick="wall.fast_send('{rec-id}', '{author-id}'); return false" id="fast_buts_{rec-id}">{translate=wall_send}</button></div>
 </div>
 <div class="clear"></div>
</div>[/comment-form]