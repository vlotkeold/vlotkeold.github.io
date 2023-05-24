<div style="margin-left:110px"><div class="news_wall_msg_bg no_display" id="wall_text_250" style="width:300px;font-weight: normal;margin-top:-4px;">
 <div class="news_wall_msg_text" ><b><a href="/verify" onclick="page.go(this.href)">Подтвержденное сообщество</a></b><br><div class="mgclr"></div>Данная отметка означает, что страница пользователя была подтверждена администрацией яВинете.<div class="clear"></div></div></div></div>
<script type="text/javascript">
$(document).ready(function(){
	$('#wall_text, .fast_form_width').autoResize();
	$(window).scroll(function(){
		
			if($(document).height() - $(window).height() <= $(window).scrollTop()+($(document).height()/2-250)){
				about.wall_page({id})
			}
			if($(window).scrollTop() < $('#fortoAutoSizeStyle').offset().top){
				startResizeCss = false;
				$('#addStyleClass').remove();
			}
			if($(window).scrollTop() > $('#fortoAutoSizeStyle').offset().top && !startResizeCss){
				startResizeCss = true;
				$('#page').append('<div id="addStyleClass"><style type="text/css" media="all">.wallrecord{width:630px;}.public_likes_user_block{margin-left: 435px;}.public_wall_like{margin-right: -30px;}.wall_tell{margin-right: -10px;}.wall_tell_all{margin-top: 0px;margin-right: -28px;}</style></div>');
			}
	});
	myhtml.checked(['{settings-comments}']);
	music.jPlayerInc();
	$(window).scroll(function(){
		if($(document).height() - $(window).height() <= $(window).scrollTop()+($(document).height()/2-250)){
			about.wall_page();
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
<div class="ava fl_r" style="margin-right:0px" onMouseOver="about.wall_like_users_five_hide()">
<div class="ava">
	<div id="owner_photo_wrap">
		<div id="owner_photo_top_bubble_wrap">[admin]
			<div id="owner_photo_top_bubble">
				<div class="owner_photo_bubble_delete_wrap" onclick="about.delphoto('{id}'); return false;">
					<div class="owner_photo_bubble_delete"></div>
				</div>
			</div>[/admin]
		</div>
		<div class="b_photo ">
			<span id="ava">
				<a href="" onclick="about.vPhoto('{id}', '{ava}'); return false">
					<span id="ava"><img src="{photo}" alt="" title="Увеличить" id="ava_1"></span>
				</a>
			</span>[admin]
			<div id="owner_photo_bubble_wrap">
				<div id="owner_photo_bubble"><div class="owner_photo_bubble_action owner_photo_bubble_action_update" onclick="about.loadphoto('{id}'); return false">
					<span class="owner_photo_bubble_action_in">Загрузить фотографию</span>
				</div>
				<div class="owner_photo_bubble_action owner_photo_bubble_action_crop" onclick="about.miniature('{id}'); return false;">
					<span class="owner_photo_bubble_action_in">Изменить миниатюру</span>
				</div>
				</div>
			</div>[/admin]
		</div>
	</div>
</div>
 
 <div class="clear"></div>
 <div class="menuleft" style="margin-top:5px">
 </div>
 <div class="albtitle cursor_pointer" onClick="abouts.links('{id}')">Мобильные приложения</div>
 <br>
 <div class="albtitle cursor_pointer" onClick="abouts.links('{id}')">Официальные сообщества</div>
 <br>
<div class="albtitle cursor_pointer" onClick="Page.Go('/support')">Помощь</div>
 <div class="public_bg" id="feddbackusers">
  <div class="line_height color777" align="center">Наша <b>команда поддержки</b> поможет с любыми проблемами<br /><br><a class="button_blue" style="margin-top: 10px" href="/support?act=new"><button>Задать вопрос</button></a></div>
 </div>
 [pr_contact][feedback]<div class="albtitle cursor_pointer" onClick="about.allfeedbacklist('{id}')">Контакты [yes][/yes]</div>
 <div class="public_bg_about" id="feddbackusers">
  {feedback-users}
  [no]<div class="line_height color777" align="center">Страницы представителей, номера телефонов, e-mail<br />
  <a href="/about{id}" onClick="about.addcontact('{id}'); return false">Добавить контакты</a></div>[/no]
 </div>[/feedback][/pr_contact]
 <div class="albtitle cursor_pointer">Другое</div>
 <div class="module_body clear_fix">
    <div class="clear_fix topic_row">
 <div class="icon fl_l"></div>
  <div class="info fl_l">
    <div><a class="topic_title" href="/ads">Реклама</a></div>
  </div>
  </div>
  </div>
 <div id="fortoAutoSizeStyle"></div>
</div>
<div class="profiewr">
 <div id="public_editbg_container">
 <div class="public_editbg_container">
 <div class="fl_l" style="width:410px">
  [admin]<div class="set_status_bg no_display" id="set_status_bg">
  <input type="text" id="status_text" class="status_inp" value="{status-text}" style="width:385px;" maxlength="255" onKeyPress="if(event.keyCode == 13)gStatus.set('', 1)" />
  <div class="fl_l status_text"><span class="no_status_text [status]no_display[/status]">Введите здесь текст статуса.</span><a href="/" class="yes_status_text [no-status]no_display[/no-status]" onClick="gStatus.set(1, 1); return false">Удалить статус</a></div>
  [status]<div class="button_div_gray fl_r status_but margin_left"><button>Отмена</button></div>[/status]
  <div class="button_blue fl_r status_but"><button id="status_but" onClick="gStatus.set('', 1)">Сохранить</button></div>
 </div>[/admin]
 
  <div class="wall_text"><div class="wall_text_name"></div> <div id="wpt-47200925_5"><div class="wall_post_text">яВинете — это сетевой проект, который помогает людям <br>высказываться и находить слушателей. Вы можете общаться с широким<br>кругом интересных людей или поддерживать связь с друзьями и близкими. <br><br>Задача яВинете — в каждый отдельно взятый момент оставаться наиболее современным, быстрым и эстетичным способом общения в сети.</div></div></div>
  <br>
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
<div class="texta">Тематика:</div>
 <div class="padstylej"><select id="gtype" class="inpst" style="width:220px;" onChange="sp.check()">
  <option value="">- Не выбрано -</option>
  {gtype2}
 </select></div>
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
 <!--[admin]<div class="newmes" id="wall_tab" style="border-bottom:0px;margin-bottom:-5px">
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
   <div class="button_blue fl_l margin_top_10"><button onClick="abouts.wall_send('{id}'); return false" id="wall_send">Отправить</button></div>
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
 </div>[/admin]-->
 <div id="public_wall_records">{records}</div>
 <div class="cursor_pointer {wall-page-display}" onClick="groups.wall_page('{id}'); return false" id="wall_all_records"><div class="public_wall_all_comm" id="load_wall_all_records" style="margin-left:0px">к предыдущим записям</div></div>
 <input type="hidden" id="page_cnt" value="1" />
</div>
<div class="clear"></div>