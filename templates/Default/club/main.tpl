<script type="text/javascript">
$(document).ready(function(){
	$('#wall_text, .fast_form_width').autoResize();
	myhtml.checked(['{settings-comments}']);
	music.jPlayerInc();
	$(window).scroll(function(){
		if($(document).height() - $(window).height() <= $(window).scrollTop()+($(document).height()/2-250)){
			clubs.wall_page({id});
		}
	});
	langNumric('langNumricAll', '{audio-num}', '�����������', '�����������', '������������', '�����������', '������������');
});
$(document).click(function(event){
	wall.event(event);
});
</script>
<div id="jquery_jplayer"></div>
<div id="addStyleClass"></div>
<input type="hidden" id="teck_id" value="" />
<input type="hidden" id="teck_prefix" value="" />
<input type="hidden" id="typePlay" value="standart" />
<input type="hidden" id="public_id" value="{id}" />
<div class="ava fl_r" style="margin-right:0px" onMouseOver="clubs.wall_like_users_five_hide()">
<div class="ava">
	<div id="owner_photo_wrap">
		<div id="owner_photo_top_bubble_wrap">[admin]
			<div id="owner_photo_top_bubble">
				<div class="owner_photo_bubble_delete_wrap" onclick="clubs.delphoto('{id}'); return false;">
					<div class="owner_photo_bubble_delete"></div>
				</div>
			</div>[/admin]
		</div>
		<div class="b_photo ">
			<span id="ava">
				<a href="" onclick="clubs.vPhoto('{id}', '{ava}'); return false">
					<span id="ava"><img src="{photo}" alt="" title="���������" id="ava_1"></span>
				</a>
			</span>[admin]
			<div id="owner_photo_bubble_wrap">
				<div id="owner_photo_bubble"><div class="owner_photo_bubble_action owner_photo_bubble_action_update" onclick="clubs.loadphoto('{id}'); return false">
					<span class="owner_photo_bubble_action_in">��������� ����������</span>
				</div>
				<div class="owner_photo_bubble_action owner_photo_bubble_action_crop" onclick="eclub.miniature('{id}'); return false;">
					<span class="owner_photo_bubble_action_in">�������� ���������</span>
				</div>
				</div>
			</div>[/admin]
		</div>
	</div>
</div>
<div class="clear"></div>
 <div class="menuleft" style="margin-top:5px">
  [admin] <a href="/eclub?act=edit&cid={id}" onClick="Page.Go(this.href); return false"><div>���������� �������</div></a>[/admin]
  [admin-del]<a href="/" onClick="clubs.delclubbox('{id}'); return false"><div id="pubDel">������� ������</div></a>[/admin-del]
  <a href="/adscreate" onClick="Page.Go(this.href);ads.createpublic(); return false">������������� ������</a>
 </div>
  <div class="publick_subscblock">
   <div id="yes" class="{yes}">
    <div class="button_div fl_l" style="margin-bottom:15px;line-height:15px"><button onClick="clubs.login('{id}'); return false" style="width:174px">��������</button></div>
    <a onClick="clubs.all_people('{id}')" style="cursor:pointer"><div id="num2">{num}</div></a>
   </div>
   <div id="no" class="{no}" style="text-align:left">
	�� ��������� �� ������� ���� ������.<br />
	<a href="/club{id}" onClick="clubs.exit2('{id}', '{viewer-id}'); return false">�����</a>
   </div>
   <div id="no-fev" class="{no-fev}" style="text-align:left">
	�� ������ ������ � ������ ������.<br />
    <div style="margin-top:7px"></div>
	<a href="/club{id}" onClick="clubs.exit2('{id}', '{viewer-id}'); return false">��������</a>
   </div>
   <div class="clear"></div>
  </div>
 <div style="margin-top:7px">
  <div class="{no-users}" id="users_block">
   <div class="albtitle cursor_pointer" onClick="clubs.subscribes_groups('{id}')">���������</div>
   <div class="public_bg">
    <div class="color777 public_margbut">{num}</div>
	<div class="public_usersblockhidden">{users}</div>
    <div class="clear"></div>
   </div>
  </div>
 </div>
 [pr_contact][feedback]<div class="albtitle cursor_pointer" onClick="clubs.allfeedbacklist('{id}')">�������� [yes][/yes]</div>
 <div class="public_bg" id="feddbackusers">
  [yes]<div class="color777 public_margbut">{num-feedback}</div>[/yes]
  {feedback-users}
  [no]<div class="line_height color777" align="center">�������� ��������������, ������ ���������, e-mail<br />
  <a href="/club{id}" onClick="clubs.addcontact('{id}'); return false">�������� ��������</a></div>[/no]
 </div>[/feedback][/pr_contact]
 <div id="fortoAutoSizeStyle"></div>
</div>
<div class="profiewr">
 <div id="public_editbg_container">
 <div class="public_editbg_container">
 <div class="fl_l" style="width:400px">
 <div class="public_title2" id="e_public_title2">{title}</div>
 <div class="public_hr"></div>
  <div class="{descr-css}" id="descr_display"><div class="flpodtext">��������:</div> <div class="flpodinfo" id="e_descr">{descr}</div></div>
  <div class="{website-css}" id="website_display"><div class="flpodtext">���-����:</div> <div class="flpodinfopublic" id="e_website"><a href='{website}'>{website}</a></div></div>
  <br>
 </div>
 [admin]<div class="public_editbg fl_l no_display" id="edittab1">
  <div class="public_title2">�������������� ��������</div>
  <div class="public_hr"></div>
  <div class="texta">��������:</div>
   <input type="text" id="title" class="inpst" maxlength="100"  style="width:210px;" value="{title}" />
  <div class="mgclr"></div>
  <div class="texta">��������:</div>
   <textarea id="descr" class="inpst" style="width:210px;height:80px">{edit-descr}</textarea>
  <div class="mgclr"></div>
  <div class="texta">����� ������:</div>
   <input type="hidden" id="prev_adres_page" class="inpst" maxlength="100"  style="width:210px;" value="{adres}" />
   <input type="text" id="adres_page" class="inpst" maxlength="100"  style="width:210px;" value="{adres}" />
  <div class="mgclr"></div>
  <div class="texta">���-����:</div>
   <input type="text" id="website" class="inpst" maxlength="100"  style="width:210px;" value="{website}" />
  <div class="mgclr"></div>
  <div class="texta">�����:</div>
 <div class="sett_privacy" onClick="clubs.privacyOpen('wall1')" id="wall_lnk_wall1" style="margin-top: 3px;">{val_wall1_text_wall}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_wall1" style="margin-top: 0px;margin-left: -250px;width: 80px;">
  <div id="selected_p_wall_lnk_wall1" class="sett_selected" onClick="clubs.privacyClose('wall1')">{val_wall1_text_wall}</div>
  <div class="sett_hover" onClick="clubs.setPrivacy('wall1', '���������', '1', 'wall_lnk_wall1')">���������</div>
  <div class="sett_hover" onClick="clubs.setPrivacy('wall1', '��������', '2', 'wall_lnk_wall1')">��������</div>
  <div class="sett_hover" onClick="clubs.setPrivacy('wall1', '��������', '3', 'wall_lnk_wall1')">��������</div>
 </div>
 <input type="hidden" id="wall1" value="{val_wall1_wall}" />
<div class="mgclr"></div>
  <div class="texta">��� ������:</div>
 <div class="sett_privacy" onClick="clubs.privacyOpen('intog')" id="intog_lnk_wall1" style="margin-top: 3px;">{val_intog_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_intog" style="margin-top: 0px;margin-left: -250px;width: 70px;">
  <div id="selected_p_wall_lnk_wall1" class="sett_selected" onClick="clubs.privacyClose('intog')">{val_intog_text}</div>
  <div class="sett_hover" onClick="clubs.setPrivacy('intog', '��������', '1', 'intog_lnk_wall1')">��������</div>
  <div class="sett_hover" onClick="clubs.setPrivacy('intog', '��������', '2', 'intog_lnk_wall1')">��������</div>
 </div>
 <input type="hidden" id="intog" value="{val_intog}" />
<div class="mgclr"></div>
  <div class="texta">&nbsp;</div>
   <div class="html_checkbox" id="comments" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">����������� ��������</div>
  <div class="mgclr clear"></div>
  <div class="texta">&nbsp;</div>
   <a href="/club{id}" onClick="clubs.edittab_admin(); return false">��������� ��������������� &raquo;</a>
   <div class="mgclr"></div>
   <div class="texta">&nbsp;</div>
   <a href="/club{id}" onClick="clubs.edittab_fev(); return false">������ � ������ &raquo;</a>
   <div class="mgclr"></div>
  <div class="mgclr"></div>
  <div class="texta">&nbsp;</div>
   <div class="button_div fl_l"><button onClick="clubs.saveinfo('{id}'); return false" id="pubInfoSave">���������</button></div>
   <div class=" button_gray fl_l margin_left"><button onClick="clubs.editformClose(); return false">������</button></div>
  <div class="mgclr"></div>
 </div>
 <div class="public_editbg fl_l no_display" id="edittab2">
  <div class="public_title2">������������ ��������</div>
  <div class="public_hr"></div>
  <input 
	type="text" 
	placeholder="������� ������ �� �������� ��� ID ������������" 
	class="videos_input" 
	style="width: 370px"
	onKeyPress="if(event.keyCode == 13)clubs.addadmin('{id}')"
	id="new_admin_id"
   />
  <div class="clear"></div>
  <div style="width:385px" id="admins_tab">{admins}</div>
  <div class="clear"></div>
  <div class="button_div fl_l"><button onClick="clubs.editform(); return false">�����</button></div>
 </div>
 <div class="public_editbg fl_l no_display" id="edittab3">
  <div class="public_title2">������ � ������</div>
  <div class="public_hr"></div>
  <div class="clear"></div>
  <div style="width:385px" id="admins_tab">{fev-clubs}</div>
  <div class="clear"></div>
  <div class="button_div fl_l"><button onClick="clubs.editform(); return false">�����</button></div>
 </div>[/admin]
 </div>
 </div>
 [wall_privacy]<div class="albtitle" style="border-bottom:0px">{rec-num}</div>
 [wall_privacy_admin]<div class="newmes" id="wall_tab" style="border-bottom:0px;margin-bottom:-5px">
  <input type="hidden" value="� ��� ������ ����������?" id="wall_input_text" />
  <input type="text" class="wall_inpst" value="� ��� ������ ����������?" onMouseDown="wall.form_open(); return false" id="wall_input" style="margin:0px" />
  <div class="no_display" id="wall_textarea">
   <textarea id="wall_text" class="wall_inpst wall_fast_opened_texta" style="width:381px"
	onKeyUp="wall.CheckLinkText(this.value)"
	onBlur="wall.CheckLinkText(this.value, 1)"
	onKeyPress="if(event.keyCode == 10 || (event.ctrlKey && event.keyCode == 13)) clubs.wall_send('{id}')"
   >
   </textarea>
   <div id="attach_files" class="margin_top_10 no_display"></div>
   <div id="attach_block_lnk" class="no_display clear">
   <div class="attach_link_bg">
    <div align="center" id="loading_att_lnk"><img src="{theme}/images/loading_mini.gif" style="margin-bottom:-2px" /></div>
    <img src="" align="left" id="attatch_link_img" class="no_display cursor_pointer" onClick="wall.UrlNextImg()" />
	<div id="attatch_link_title"></div>
	<div id="attatch_link_descr"></div>
	<div class="clear"></div>
   </div>
   <div class="attach_toolip_but"></div>
   <div class="attach_link_block_ic fl_l"></div><div class="attach_link_block_te"><div class="fl_l">������: <a href="/" id="attatch_link_url" target="_blank"></a></div><img class="fl_l cursor_pointer" style="margin-top:2px;margin-left:5px" src="{theme}/images/close_a.png" onMouseOver="myhtml.title('1', '�� �����������', 'attach_lnk_')" id="attach_lnk_1" onClick="wall.RemoveAttachLnk()" /></div>
   <input type="hidden" id="attach_lnk_stared" />
   <input type="hidden" id="teck_link_attach" />
   <span id="urlParseImgs" class="no_display"></span>
   </div>
   <div class="clear"></div>
   <div id="attach_block_vote" class="no_display">
   <div class="attach_link_bg">
	<div class="medadd_h medadd_h_poll inl_bl">���� ������<img class="fl_r cursor_pointer" style="margin-top:2px;margin-left:5px" src="/templates/Default/images/close_a.png" onMouseOver="myhtml.title('1', '�� �����������', 'attach_vote_')" id="attach_vote_1" onClick="Votes.RemoveForAttach()" /></div><div class="mgclr"></div><input type="text" id="vote_title" class="inpst" maxlength="80" value="" style="width:330px;" 
		onKeyUp="$('#attatch_vote_title').text(this.value)"
	/><div class="mgclr"></div>
	<div class="medadd_h2 medadd_h_poll2">�������� ������<small class="fl_r"><span id="addNewAnswer" ><a class="cursor_pointer" onClick="Votes.AddInp()">��������</a></span> | <span id="addDelAnswer">�������</span></small></div><div class="mgclr"></div><input type="text" id="vote_answer_1" class="inpst" maxlength="80" value="" style="width:330px;" /><div class="mgclr"></div>
	<div class="texta">&nbsp;</div><input type="text" id="vote_answer_2" class="inpst" maxlength="80" value="" style="width:330px;" /><div class="mgclr"></div>
	<div id="addAnswerInp"></div>
	<div class="clear"></div>

   <input type="hidden" id="answerNum" value="2" />
   </div>
   
   </div>
   <div class="clear"></div>
   <input id="vaLattach_files" type="hidden" />
   <div class="clear"></div>
   <div class="button_blue fl_l margin_top_10"><button onClick="clubs.wall_send('{id}'); return false" id="wall_send">���������</button></div>
  [admin]<div class="html_checkbox" id="ofgroupsmess" onClick="myhtml.checkbox(this.id); myhtml.toggleCheck('podpis')" style="margin-top: 14px;margin-left: 15px;">�� ����� ����������</div>[/admin]
  [admin]<div class="html_checkbox no_display" id="podpis" onClick="myhtml.checkbox(this.id);" style="margin-top: 14px;margin-left: 15px;">�������</div>[/admin]
   <div class="wall_attach fl_r" onClick="wall.attach_menu('open', this.id, 'wall_attach_menu')" onMouseOut="wall.attach_menu('close', this.id, 'wall_attach_menu')" id="wall_attach">����������</div>
   <div class="wall_attach_menu no_display" onMouseOver="wall.attach_menu('open', 'wall_attach', 'wall_attach_menu')" onMouseOut="wall.attach_menu('close', 'wall_attach', 'wall_attach_menu')" id="wall_attach_menu">
    <div class="wall_attach_icon_smile" id="wall_attach_link" onClick="clubs.wall_attach_addphoto(0, 0, '{id}')">����������</div>
    <div class="wall_attach_icon_video" id="wall_attach_link" onClick="clubs.wall_video_add_box()">�����������</div>
    <div class="wall_attach_icon_photo" id="wall_attach_link" onClick="wall.attach_addaudio()">�����������</div>
	<div class="wall_attach_icon_audio" id="wall_attach_link" onClick="wall.attach_addDoc()">��������</div>
	<div class="wall_attach_icon_doc" id="wall_attach_link" onClick="$('#attach_block_vote').slideDown('fast');wall.attach_menu('close', 'wall_attach', 'wall_attach_menu');$('#vote_title').focus();$('#vaLattach_files').val($('#vaLattach_files').val()+'vote|start||')">�����</div>
   </div>
  </div>
  <div class="clear"></div>
 </div>[/wall_privacy_admin]
 <div id="public_wall_records">{records}</div>[/wall_privacy]
 <div class="cursor_pointer {wall-page-display}" onClick="clubs.wall_page('{id}'); return false" id="wall_all_records"><div class="public_wall_all_comm" id="load_wall_all_records" style="margin-left:0px">� ���������� �������</div></div>
 <input type="hidden" id="page_cnt" value="1" />
</div>
<div class="clear"></div>