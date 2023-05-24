<div style="margin-left:110px"><div class="news_wall_msg_bg no_display" id="wall_text_250" style="width:300px;font-weight: normal;margin-top:-4px;">
 <div class="news_wall_msg_text" ><b><a href="/verify" onclick="page.go(this.href)">Подтвержденное сообщество</a></b><br><div class="mgclr"></div>Данная отметка означает, что страница была подтверждена администрацией яВинете.<div class="clear"></div></div></div></div>
<script type="text/javascript">
$(document).ready(function(){
	myhtml.checked(['{settings-comments}']);
	music.jPlayerInc();
	$(window).scroll(function(){
		if($(document).height() - $(window).height() <= $(window).scrollTop()+($(document).height()/2-250)){
			groups.wall_page();
		}
	});
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
<div class="ava fl_r" style="margin-right:0px" onMouseOver="groups.wall_like_users_five_hide()">
<div class="ava">
	<div id="owner_photo_wrap">
		<div id="owner_photo_top_bubble_wrap">[admin_red]
			<div id="owner_photo_top_bubble">
				<div class="owner_photo_bubble_delete_wrap" onclick="groups.delphoto('{id}'); return false;">
					<div class="owner_photo_bubble_delete"></div>
				</div>
			</div>[/admin_red]
		</div>
		<div class="b_photo ">
			<span id="ava">
				<a href="" onclick="epage.vPhoto('{id}', '{ava}'); return false">
					<span id="ava"><img src="{photo}" alt="" title="Увеличить" id="ava_1"></span>
				</a>
			</span>[admin_red]
			<div id="owner_photo_bubble_wrap">
				<div id="owner_photo_bubble"><div class="owner_photo_bubble_action owner_photo_bubble_action_update" onclick="groups.loadphoto('{id}'); return false">
					<span class="owner_photo_bubble_action_in">Загрузить фотографию</span>
				</div>
				<div class="owner_photo_bubble_action owner_photo_bubble_action_crop" onclick="epage.miniature('{id}'); return false;">
					<span class="owner_photo_bubble_action_in">Изменить миниатюру</span>
				</div>
				</div>
			</div>[/admin_red]
		</div>
	</div>
</div>
 
 <div class="clear"></div>
 <div class="menuleft" style="margin-top:5px">
  [admin]
  <a href="/epage?act=edit&pid={id}" onClick="Page.Go(this.href); return false"><div>Управление страницей</div></a>
  <a href="/adscreate" onClick="Page.Go(this.href);ads.createpublic(); return false"><div>Рекламировать страницу</div></a>[/admin]
 </div>
  <div class="publick_subscblock">
   <div id="yes" class="{yes}">
    <div class="button_blue fl_l" style="margin-bottom:15px;line-height:15px"><button onClick="groups.login('{id}'); return false" style="width:174px">Подписаться</button></div>
    <div id="num2">{num-2}</div>
   </div>
   <div id="no" class="{no}" style="text-align:left">
	Вы подписаны на новости.<br />
    <a href="/public{id}" onClick="groups.wall_tell_g('{id}'); return false">Рассказать друзьям</a><div class="wall_tell_all" style="margin-right:58px;margin-top:5px;opacity:1"></div>
    <div style="margin-top:7px"></div>
	<a href="/public{id}" onClick="groups.exit2('{id}', '{viewer-id}'); return false">Отписаться</a>
   </div>
   <div class="clear"></div>
  </div>
 <div style="margin-top:7px">
  <div class="{no-users}" id="users_block">
   <div class="albtitle cursor_pointer" onClick="groups.subscribes_groups('{id}')">Подписчики</div>
   <div class="public_bg">
    <div class="color777 public_margbut">{num}</div>
	<div class="public_usersblockhidden">{users}</div>
    <div class="clear"></div>
   </div>
  </div>
 </div>
 [pr_links][yeslinks]<div class="albtitle cursor_pointer" onClick="groups.links('{id}')">Ссылки</div>
<div class="p_header_bottom" onclick="groups.links('{id}')">{links_num}</div>  
<div class="public_bg" style=" background: #FFF;padding-left: 5px; ">
  {club_links}
 </div>[/yeslinks][/pr_links]
 [pr_contact][feedback]<div class="albtitle cursor_pointer" onClick="groups.allfeedbacklist('{id}')">Контакты [yes][/yes]</div>
 <div class="public_bg" id="feddbackusers">
  [yes]<div class="color777 public_margbut">{num-feedback}</div>[/yes]
  {feedback-users}
  [no]<div class="line_height color777" align="center">Страницы представителей, номера телефонов, e-mail<br />
  <a href="/public{id}" onClick="groups.addcontact('{id}'); return false">Добавить контакты</a></div>[/no]
 </div>[/feedback][/pr_contact]
   [pr_videos][videos]<div class="albtitle cursor_pointer" onClick="Page.Go('/public/videos{id}'); return false">Видеозаписи</div>
 <div class="public_bg">
  [yesvideo]<div class="color777 public_margbut">{videos-num} <span id="langNumricVide"></span></div>[/yesvideo]
  {videos}
  [novideo]<div class="line_height color777" align="center">Ролики с Вашим участием и другие видеоматериалы<br />
  <a href="/public/videos{id}" onClick="Page.Go(this.href); return false">Добавить видеозапись</a></div>[/novideo]
 </div>[/videos][/pr_videos]
 [pr_audio][audios]<div class="albtitle cursor_pointer" onClick="Page.Go('/audios-{id}'); return false">Аудиозаписи</div>
 <div class="public_bg">
  [yesaudio]<div class="color777 public_margbut">{audio-num} <span id="langNumricAll"></span></div>[/yesaudio]
  {audios}
  [noaudio]<div class="line_height color777" align="center">Композиции или другие аудиоматериалы<br />
  <a href="/audios-{id}" onClick="Page.Go(this.href); return false">Добавить аудиозапись</a></div>[/noaudio]
 </div>[/audios][/pr_audio]
 [pr_albums][albums]<div class="b_albums {b_albums}"><div class="page_bg border_radius_5 margin_top_10">
  <div class="albtitle cursor_pointer" onClick="Page.Go('/albums-{id}'); return false">Альбомы<div></div></div>
 <div class="p_header_bottom" onClick="Page.Go('/albums-{id}'); return false"><span class="fl_r"></span>{albums-num}</div>
{albums}<div class="clear"></div></div>
	</div>[/albums][/pr_albums]
 <div id="fortoAutoSizeStyle"></div>
</div>
<div class="profiewr">
 <div id="public_editbg_container">
 <div class="public_editbg_container">
 <div class="fl_l" style="width:410px">
  [admin_red]<div class="set_status_bg no_display" id="set_status_bg">
  <input type="text" id="status_text" class="status_inp" value="{status-text}" style="width:385px;" maxlength="255" onKeyPress="if(event.keyCode == 13)gStatus.set('', 1)" />
  <div class="fl_l status_text"><span class="no_status_text [status]no_display[/status]">Введите здесь текст статуса.</span><a href="/" class="yes_status_text [no-status]no_display[/no-status]" onClick="gStatus.set(1, 1); return false">Удалить статус</a></div>
  [status]<div class="button_div_gray fl_r status_but margin_left"><button>Отмена</button></div>[/status]
  <div class="button_blue fl_r status_but"><button id="status_but" onClick="gStatus.set('', 1)">Сохранить</button></div>
 </div>[/admin_red]
 <div class="public_title" id="e_public_title">{title}</div>
 <div class="status">
  <div>[admin_red]<a href="/" id="new_status" onClick="gStatus.open(); return false">[/admin_red]{status-text}[admin_red]</a>[/admin_red]</div>
  [admin_red]<span id="tellBlockPos"></span>
  <div class="status_tell_friends no_display" style="width:215px">
   <div class="status_str"></div>
   <div class="html_checkbox" id="tell_friends" onClick="myhtml.checkbox(this.id); gStatus.startTellPublic('{id}')">Рассказать подписчикам сообщества</div>
  </div>[/admin_red]
  [admin_red]<a href="#" onClick="gStatus.open(); return false" id="status_link" [status]class="no_display"[/status]>установить статус</a>[/admin_red]
 </div>
  <div class="{descr-css}" id="descr_display"><div class="flpodtext">Описание:</div> <div class="flpodinfo" id="e_descr">{descr}</div></div>
  [web]<div class="flpodtext">Веб-сайт:</div> <div class="flpodinfo"><a href="{web}" target="_blank">{web}</a></div>[/web]
    <div class="{date_created-css}" id="descr_display"><div class="flpodtext">Дата основания:</div> <div class="flpodinfopublic" id="e_descr" style="width: 295px;">{date_created}</div></div>
  [p_lastnews]<div class="{lastnews-css} cursor_pointer" onClick="NewsLast.MoreMenu(); return false" id="moreMenuLnk"><div class="public_wall_all_comm profile_hide_opne" id="moreMenuText">Свежие новости</div></div>
 <div id="moreMenu" class="no_display">
  <br><div class="{lastnews-css}" id="lastnews_display"><div class="flpodinfopublic" id="e_lastnews">{lastnews}</div></div><br>
 </div>[/p_lastnews]
 [admin][sub10]<br><div class="cursor_pointer" onClick="menuadmin.MoreMenu(); return false" id="moreMenuLnk1"><div class="public_wall_all_comm profile_hide_opne" id="moreMenuText1">Как сделать страницу эффективнее?</div></div>
 <div id="moreMenu1" class="no_display">
  <br><div id=""><div class="flpodinfopublic" id="e_helppub">
   <div id="help_steps_body" class="help_steps_module  clear_fix">
    [nophoto]<div class="clear_fix help_step_row" id="help_step_photo">
  <div class="help_step_image fl_l"></div>
  <div class="fl_l help_step_info">
    <div class="help_step_title"><a href="javascript:groups.loadphoto('{id}'); return false" >Загрузить фотографию</a></div>
    <div class="color777">Фотография поможет выделить Вашу страницу среди других</div>
  </div>
</div>[/nophoto]
<div class="clear_fix help_step_row" id="help_step_ad">
  <div class="help_step_image fl_l"></div>
  <div class="fl_l help_step_info">
    <div class="help_step_title"><a href="/adscreate" onClick="Page.Go(this.href);ads.createpublic(); return false">Разместить рекламное объявление</a></div>
    <div class="color777">Таргетированная реклама поможет именно Вашей целевой аудитории найти эту страницу и рассказать о ней своим друзьям</div>
  </div>
</div>
<div class="clear_fix help_step_row" id="help_step_desc">
  <div class="help_step_image fl_l"></div>
  <div class="fl_l help_step_info">
    <div class="help_step_title"><a href="/epage?act=edit&pid={id}" onClick="Page.Go(this.href); return false">Рассказать об истории или деятельности</a></div>
    <div class="color777">Небольшое описание добавит Вашей странице индивидуальности</div>
  </div>
</div>
</div>
  </div></div><br>
 </div>[/sub10][/admin]
 </div>
 [admin]<div class="public_editbg fl_l no_display" id="edittab1">
  <div class="public_title2">Редактирование страницы</div>
  <div class="public_hr"></div>
  <div class="texta">Название:</div>
   <input type="text" id="title" class="inpst" maxlength="100"  style="width:210px;" value="{title}" />
  <div class="mgclr"></div>
  <div class="texta">Описание:</div>
   <textarea id="descr" class="inpst" style="width:210px;height:80px">{edit-descr}</textarea>
  <div class="mgclr"></div>
  <div class="texta">Адрес страницы:</div>
   <input type="hidden" id="prev_adres_page" class="inpst" maxlength="10"  style="width:210px;" value="{adres}" />
   <input type="text" id="adres_page" class="inpst" maxlength="10"  style="width:210px;" value="{adres}" />
  <div class="mgclr"></div>
  <div class="texta">Веб-сайт:</div>
   <input type="text" id="web" class="inpst" maxlength="100"  style="width:210px;" value="{web}" />
 <div class="mgclr"></div>
  <div class="texta">&nbsp;</div>
   <div class="html_checkbox" id="comments" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Комментарии</div>
  <div class="mgclr clear"></div>
  <div class="texta">&nbsp;</div>
  <div class="html_checkbox" id="contact" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Контакты</div>
  <div class="mgclr clear"></div>
  <div class="texta">&nbsp;</div>
  <div class="html_checkbox" id="audio" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Аудиозаписи</div>
  <div class="mgclr clear"></div>
  <div class="texta">&nbsp;</div>
  <div class="html_checkbox" id="videos" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Видеозаписи</div>
  <div class="mgclr clear"></div>
  <div class="texta">&nbsp;</div>
   <a href="/public{id}" onClick="groups.edittab_admin(); return false">Назначить администраторов &raquo;</a>
  <div class="mgclr"></div>
  <div class="texta">&nbsp;</div>
   <div class="button_blue fl_l"><button onClick="groups.saveinfo('{id}'); return false" id="pubInfoSave">Сохранить</button></div>
   <div class="button_div_gray fl_l margin_left"><button onClick="groups.editformClose(); return false">Отмена</button></div>
  <div class="mgclr"></div>
 </div>
 <div class="public_editbg fl_l no_display" id="edittab2">
  <div class="public_title2">Руководители страницы</div>
  <div class="public_hr"></div>
  <input 
	type="text" 
	placeholder="Введите ссылку или ID страницы пользователя" 
	class="videos_input" 
	style="width:370px"
	onKeyPress="if(event.keyCode == 13)groups.addadmin('{id}')"
	id="new_admin_id"
   />
  <div class="clear"></div>
  <div style="width:400px" id="admins_tab">{admins}</div>
  <div class="clear"></div>
  <div class="button_blue fl_l"><button onClick="groups.editform(); return false">Назад</button></div>
 </div>[/admin]
 </div>
 </div>
 <div class="albtitle" style="border-bottom:0px">{rec-num}</div>
 [admin_red]<div class="newmes" id="wall_tab" style="border-bottom:0px;margin-bottom:-5px">
  <input type="hidden" value="Что у Вас нового?" id="wall_input_text" />
  <input type="text" class="wall_inpst" value="Что у Вас нового?" onMouseDown="wall.form_open(); return false" id="wall_input" style="margin:0px" />
  <div class="no_display" id="wall_textarea">
   <textarea id="wall_text" class="wall_inpst wall_fast_opened_texta" style="width:381px"
	onKeyUp="wall.CheckLinkText(this.value)"
	onBlur="wall.CheckLinkText(this.value, 1)"
	onKeyPress="if(event.keyCode == 10 || (event.ctrlKey && event.keyCode == 13)) groups.wall_send('{id}')"
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
   <div class="attach_link_block_ic fl_l"></div><div class="attach_link_block_te"><div class="fl_l">Ссылка: <a href="/" id="attatch_link_url" target="_blank"></a></div><img class="fl_l cursor_pointer" style="margin-top:2px;margin-left:5px" src="{theme}/images/close_a.png" onMouseOver="myhtml.title('1', 'Не прикреплять', 'attach_lnk_')" id="attach_lnk_1" onClick="wall.RemoveAttachLnk()" /></div>
   <input type="hidden" id="attach_lnk_stared" />
   <input type="hidden" id="teck_link_attach" />
   <span id="urlParseImgs" class="no_display"></span>
   </div>
   <div class="clear"></div>
   <div id="attach_block_vote" class="no_display">
   <div class="attach_link_bg">
	<div class="medadd_h medadd_h_poll inl_bl">Тема опроса<img class="fl_r cursor_pointer" style="margin-top:2px;margin-left:5px" src="/templates/Default/images/close_a.png" onMouseOver="myhtml.title('1', 'Не прикреплять', 'attach_vote_')" id="attach_vote_1" onClick="Votes.RemoveForAttach()" /></div><div class="mgclr"></div><input type="text" id="vote_title" class="inpst" maxlength="80" value="" style="width:330px;" 
		onKeyUp="$('#attatch_vote_title').text(this.value)"
	/><div class="mgclr"></div>
	<div class="medadd_h2 medadd_h_poll2">Варианты ответа<small class="fl_r"><span id="addNewAnswer" ><a class="cursor_pointer" onClick="Votes.AddInp()">добавить</a></span> | <span id="addDelAnswer">удалить</span></small></div><div class="mgclr"></div><input type="text" id="vote_answer_1" class="inpst" maxlength="80" value="" style="width:330px;" /><div class="mgclr"></div>
	<div class="texta">&nbsp;</div><input type="text" id="vote_answer_2" class="inpst" maxlength="80" value="" style="width:330px;" /><div class="mgclr"></div>
	<div id="addAnswerInp"></div>
	<div class="clear"></div>
   <input type="hidden" id="answerNum" value="2" />
   </div>  
   </div>
   <div class="clear"></div>
   <input id="vaLattach_files" type="hidden" />
   <div class="clear"></div>
   <div class="button_blue fl_l margin_top_10"><button onClick="groups.wall_send('{id}'); return false" id="wall_send">Отправить</button></div>
   <div class="html_checkbox" id="podpis" onClick="myhtml.checkbox(this.id);" style="margin-top: 14px;margin-left: 15px;">подпись</div>
   <div class="wall_attach fl_r" onClick="wall.attach_menu('open', this.id, 'wall_attach_menu')" onMouseOut="wall.attach_menu('close', this.id, 'wall_attach_menu')" id="wall_attach">Прикрепить</div>
   <div class="wall_attach_menu no_display" onMouseOver="wall.attach_menu('open', 'wall_attach', 'wall_attach_menu')" onMouseOut="wall.attach_menu('close', 'wall_attach', 'wall_attach_menu')" id="wall_attach_menu">
    <div class="wall_attach_icon_smile" id="wall_attach_link" onClick="groups.wall_attach_addphoto(0, 0, '{id}')">Фотографию</div>
    <div class="wall_attach_icon_video" id="wall_attach_link" onClick="wall.attach_addvideo_public(0, 0, '{id}')">Видеозапись</div>
    <div class="wall_attach_icon_photo" id="wall_attach_link" onClick="wall.attach_addaudio()">Аудиозапись</div>
	<div class="wall_attach_icon_audio" id="wall_attach_link" onClick="wall.attach_addDoc()">Документ</div>
	<div class="wall_attach_icon_doc" id="wall_attach_link" onClick="$('#attach_block_vote').slideDown('fast');wall.attach_menu('close', 'wall_attach', 'wall_attach_menu');$('#vote_title').focus();$('#vaLattach_files').val($('#vaLattach_files').val()+'vote|start||')">Опрос</div>
   </div>
  </div>
  <div class="clear"></div>
 </div>[/admin_red]
 <div id="public_wall_records">{records}</div>
 <div class="cursor_pointer {wall-page-display}" onClick="groups.wall_page('{id}'); return false" id="wall_all_records"><div class="public_wall_all_comm" id="load_wall_all_records" style="margin-left:0px">к предыдущим записям</div></div>
 <input type="hidden" id="page_cnt" value="1" />
</div>
<div class="clear"></div>