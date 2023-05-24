<div id="photo_view_{id}" class="photo_view" onClick="Photo.setEvent(event, '{close-link}')">
<div class="photo_close" onClick="Photo.Close('{close-link}'); return false;"></div>
 <div class="photo_bg">
  <div class="photo_com_title" style="padding-top:0px;">[all]Фотография {jid} из {photo-num}[/all][wall]Просмотр фотографии[/wall]<div><a href="/" onClick="Photo.Close('{close-link}'); return false;">Закрыть</a></div></div>
  [all]<a href="/photo{uid}_{prev-id}{section}" onClick="Photo.Show(this.href); return false"><div class="photo_prev_but"></div></a>
  <a href="/photo{uid}_{next-id}{section}" onClick="Photo.Show(this.href); return false"><div class="photo_next_but"></div></a>[/all]
  [mark-block]<div class="mark_userid_bg" id="mark_userid_bg{id}">
   <div class="fl_l"><a href="/id{mark-user-id}" onClick="Page.Go(this.href); return false">{mark-user-name}</a> {mark-gram-text} Вас на этой фотографии.</a></div>
   <div class="button_div_gray margin_left fl_r" style="margin-top:-5px"><button onClick="{mark-del-link}; return false">Удалить отметку</button></div>
   <div class="button_div fl_r" style="margin-top:-5px"><button onClick="Distinguish.OkUser({id}); return false">Потвердить</button></div>
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
   <a href="/photo{uid}_{next-id}{section}" onClick="[all]Photo.Show(this.href)[/all][wall]Photo.Close('{close-link}')[/wall]; return false" id="photo_href"><div class="photo_img_box"><img style="max-width:534px;max-height:604px" id="ladybug_ant{id}" class="ladybug_ant" src="{photo}" alt=""/></a></div>
  <div class="clear"></div>
  <div id="save_crop_text{id}" class="save_crop_text no_display" style="padding:20px;padding-left:0px">
   Укажите область, которая будет сохранена как фотография Вашей страницы.
   <div class="button_div_gray margin_left fl_r" style="margin-top:-5px"><button onClick="crop.close({id}); return false">Отмена</button></div>
   <div class="button_div fl_r" style="margin-top:-5px"><button onClick="crop.save({id}, {uid}); return false">Готово</button></div>
  </div>
  <div id="pinfo_{id}" class="pinfo">
  <div class="photo_leftcol">
   <input type="hidden" id="i_left{id}" />
   <input type="hidden" id="i_top{id}" />
   <input type="hidden" id="i_width{id}" />
   <input type="hidden" id="i_height{id}" />
   <div class="peoples_on_this_photos" id="peoples_on_this_photos{id}">{mark-peoples}</div>
   <div class="photo_descr clear" id="photo_descr_{id}">{descr}</div>
   <div class="photo_info">Добавлена {date}</div>
   <div class="public_likes_user_block no_display" id="public_likes_user_block{photo-id}" onMouseOver="likephoto.wall_like_users_five('{photo-id}')" onMouseOut="likephoto.wall_like_users_five_hide('{photo-id}')" style="margin-left:446px;margin-top:-95px">
   <div onClick="likephoto.pall_liked_users('{photo-id}', '', '{plikes}')">Понравилось {plikes-text}</div>
   <div class="public_wall_likes_hidden">
    <div class="public_wall_likes_hidden2">
     <a href="/id{viewer-id}" id="like_user{viewer-id}_{photo-id}" class="no_display" onClick="Page.Go(this.href); return false"><img src="{viewer-ava}" width="32" /></a>
     <div id="likes_users{photo-id}"></div>
    </div>
   </div>
   <div class="public_like_strelka"></div>
  </div>
  <input type="hidden" id="update_like{photo-id}" value="0" />
  <div style="margin-top:-18px" class="fl_r public_wall_like cursor_pointer" onClick="{plike-js-function}" onMouseOver="likephoto.wall_like_users_five('{photo-id}', 'uPages')" onMouseOut="likephoto.wall_like_users_five_hide('{photo-id}')" id="wall_like_link{photo-id}">
   <div class="fl_l" id="wall_like_active">{translate=wall_like}</div>
   <div class="public_wall_like_no {pyes-like}" id="wall_active_ic{photo-id}"></div>
   <b id="wall_like_cnt{photo-id}" class="{pyes-like-color}">{plikes}</b>
  </div>
   <div style="margin-top:5px"></div>
   [all-comm]<a href="/" onClick="comments.all({id}, {num}); return false" id="all_href_lnk_comm_{id}"><div class="photo_all_comm_bg" id="all_lnk_comm_{id}">Показать предыдущие {comm_num}</div></a><span id="all_comments_{id}"></span>[/all-comm]
   <span id="comments_{id}">{comments}</span>
   [add-comm]<div class="photo_com_title">Ваш комментарий</div>
   <textarea id="textcom_{id}" class="inpst" style="width:520px;height:70px;margin-bottom:10px;"></textarea>
   <div class="button_div fl_l"><button id="add_comm" onClick="comments.add({id}); return false">Отправить</button></div>[/add-comm]
   </div>
  <div class="photo_rightcol">
   Из альбома:<br />
   <a href="/album{aid}" onClick="Page.Go(this.href); return false">{album-name}</a><br /><br />
   Отправитель:<br />
   <div><a href="/id{uid}" onClick="Page.Go(this.href); return false">{author}</a></div><span style="color:#888">{author-info}</span><br />
   <div class="menuleft" style="width:209px;">
    [system]<a href="/" onClick="Distinguish.Start({id}); return false"><div>Отметить человека</div></a>
   [owner]<a href="/" onClick="crop.start({id}); return false"><div>Поместить на мою страницу</div></a>
   <a href="/" onClick="Photo.EditBox({id}, 0); return false"><div>Редактировать фотографию</div></a>[/system]
   [del][owner]<a href="/" onClick="Photo.MsgDelete({id}, {aid}, 1); return false"><div>Удалить фотографию</div></a>[/owner][/del]
   [system]<a onClick="Report.Box('photo', '{id}')"><div>Пожаловаться на фотаграфию</div></a>
   [owner]<div class="photos_gradus_pos">
    <div class="fl_l">Повернуть:</div>
	<div class="photos_gradus_left fl_l" onClick="Photo.Rotation('right', '{id}')"></div>
	<div class="photos_gradus_right fl_l" onClick="Photo.Rotation('left', '{id}')"></div>
	<div class="fl_l" style="margin-left:5px"><img src="{theme}/images/loading_mini.gif" id="loading_gradus{id}" class="no_display" /></div>
   </div>[/owner][/system]
   </div>
  </div>
 </div>
<div class="clear"></div>
</div>