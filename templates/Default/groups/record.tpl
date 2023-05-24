[record]<div class="wallrecord wall_upage public_wall" id="wall_record_{rec-id}" style="padding-bottom:5px;margin-top:5px">
 <div style="float:left;width:60px"><div class="ava_mini" id="ava_rec_{rec-id}"><a href="/{adres-id}" onClick="Page.Go(this.href); return false"><img src="{ava}" /></a></div></div>
 <div style="float:left;width:85%;margin-left:0px">
 <div class="wallauthor fl_l" style="padding-left:0px"><a href="/{adres-id}" onClick="Page.Go(this.href); return false">{name}</a> <span class="color777">{type}</span></div>
 [owner]<div class="wall_delete" onMouseOver="myhtml.title('{rec-id}', 'Удалить запись', 'wall_del_')" onClick="groups.wall_delet('{rec-id}'); return false" id="wall_del_{rec-id}"></div>[/owner]
 <div class="wall_tell_ok no_display" id="wall_ok_tell_{rec-id}" style="margin-top:-1px;margin-left:-2px;[owner]margin-top:1px;margin-right:5px[/owner]"></div>
 <div class="wall_clear"></div>
 <div class="walltext" id="walltext{rec-id}">{text} {author_view}</div>
 <div class="size10 infowalltext_f clear">
  <div class="fl_l">{date} [privacy-comment][comments-link]<span id="fast_comm_link_{rec-id}" class="fast_comm_link">&nbsp;|&nbsp; <a href="/" id="fast_link_{rec-id}" onClick="wall.open_fast_form('{rec-id}'); wall.fast_open_textarea('{rec-id}'); return false">Комментировать</a></span>[/comments-link][/privacy-comment]</div>
  <div class="public_likes_user_block no_display" id="public_likes_user_block{rec-id}" onMouseOver="groups.wall_like_users_five('{rec-id}')" onMouseOut="groups.wall_like_users_five_hide('{rec-id}')">
   <div onClick="groups.wall_all_liked_users('{rec-id}', '', '{likes}')">Понравилось {likes-text}</div>
   <div class="public_wall_likes_hidden">
    <div class="public_wall_likes_hidden2">
     <a href="/id{viewer-id}" id="like_user{viewer-id}_{rec-id}" class="no_display" onClick="Page.Go(this.href); return false"><img src="{viewer-ava}" width="32" /></a>
     <div id="likes_users{rec-id}"></div>
    </div>
   </div>
   <div class="public_like_strelka"></div>
  </div>
  <input type="hidden" id="update_like{rec-id}" value="0" />
  <div class="fl_r public_wall_like cursor_pointer" onClick="{like-js-function}" onMouseOver="groups.wall_like_users_five('{rec-id}')" onMouseOut="groups.wall_like_users_five_hide('{rec-id}')" id="wall_like_link{rec-id}">
   <div class="fl_l" id="wall_like_active">Мне нравится</div>
   <div class="public_wall_like_no {yes-like}" id="wall_active_ic{rec-id}"></div>
   <b id="wall_like_cnt{rec-id}" class="{yes-like-color}">{likes}</b>
  </div>
   <div class="wall_tell_all cursor_pointer" onMouseOver="myhtml.title('{rec-id}', 'Отправить в сообщество или другу', 'wall_tell_all_')" onClick="Repost.Box('{rec-id}', 1); return false "id="wall_tell_all_{rec-id}" style="margin-top:0px;margin-right:7px;[owner]margin-top:2px;margin-right:8px[/owner]"></div>
  [privacy-comment][comments-link]<div class="wall_fast_form no_display" id="fast_form_{rec-id}" style="margin-bottom:2px">
   <div class="no_display wall_fast_texatrea" id="fast_textarea_{rec-id}">
    <textarea class="wall_inpst fast_form_width wall_fast_text" style="height:33px;width:325px;color:#000;margin:0px" id="fast_text_{rec-id}"
		onKeyPress="if(event.keyCode == 10 || (event.ctrlKey && event.keyCode == 13)) groups.wall_send_comm('{rec-id}', '{user-id}')"
	></textarea>
    <div class="button_blue fl_l margin_top_5"><button onClick="groups.wall_send_comm('{rec-id}', '{user-id}'); return false" id="fast_buts_{rec-id}">Отправить</button></div>
   [owner]<div class="html_checkbox" id="for_group{rec-id}" onclick="myhtml.checkbox(this.id);" style="margin: 10px 0px 0px 10px;font-size: 11px;color:#000">от сообщества</div>[/owner]
   <div id="reply_to_title-{rec-id}" class="reply_to_title fl_l" style="width: 130px;"></div>
   </div>
   <div class="clear"></div>
  </div>[/comments-link][/privacy-comment]
 </div>
 </div>
 <div class="clear"></div>
</div>
[comments-link]<div id="wall_fast_block_{rec-id}" class="public_wall_rec_comments"></div>[/comments-link]
<div class="clear"></div>
[/record]
[all-comm]<div class="cursor_pointer" onClick="groups.wall_all_comments('{rec-id}', '{public-id}'); return false" id="wall_all_but_link_{rec-id}"><div class="public_wall_all_comm" id="wall_all_comm_but_{rec-id}">Показать {gram-record-all-comm}</div></div>[/all-comm]
[comment]<div class="wall_fast_block" id="wall_fast_comment_{comm-id}" onMouseOver="ge('fast_del_{comm-id}').style.display = 'block'" onMouseOut="ge('fast_del_{comm-id}').style.display = 'none'">
<div class="wall_fast_ava"><a href="/{prefix}{user-id}" onClick="Page.Go(this.href); return false"><img src="{ava}" alt="" /></a></div>
<div id="name_comment"><a href="/{prefix}{user-id}" onClick="Page.Go(this.href); return false">{name}</a></div>
<div class="wall_fast_comment_text">{text}</div>
<div class="wall_fast_date fl_l">{date} <a class="color777" onClick="groups.comm_wall_gotocomment('{rec_answer_id}', '{rec-id}', '{public-id}'); return false" style="cursor:pointer">{rec_answer_name}</a>[not-owner]&nbsp;|&nbsp;[/not-owner]</div>[not-owner]<a href="/" class="size10" id="fast_answer_{comm-id}" onClick="groups.comm_wall_answer('{comm-id}','{rec-id}'); return false" onMouseDown="wall.fast_open_textarea('{rec-id}', 2); return false">Ответить</a>[/not-owner][owner]<a href="/" class="size10 fl_r no_display" id="fast_del_{comm-id}" onClick="groups.comm_wall_delet('{comm-id}', '{public-id}'); return false">Удалить</a>[/owner]
<div class="clear"></div>
</div>[/comment]
[comment-form]<input type="hidden" class="answer_comment_id" id="answer_comment_{rec-id}" value="0"/>
<div class="wall_fast_opened_form" id="fast_form">
 <input type="text" class="wall_inpst fast_form_width wall_fast_input" value="Комментировать..." id="fast_inpt_{rec-id}" onMouseDown="wall.fast_open_textarea('{rec-id}', 2); return false" style="width:325px;margin:0px" />
 <div class="no_display wall_fast_texatrea" id="fast_textarea_{rec-id}">
  <textarea class="wall_inpst fast_form_width wall_fast_text" style="height:33px;width:325px;color:#000;margin-top:0px" id="fast_text_{rec-id}"
	onKeyPress="if(event.keyCode == 10 || (event.ctrlKey && event.keyCode == 13)) groups.wall_send_comm('{rec-id}', '{user-id}')"
  ></textarea>
  <div class="button_blue fl_l margin_top_5"><button onClick="groups.wall_send_comm('{rec-id}', '{user-id}'); return false" id="fast_buts_{rec-id}">Отправить</button></div>
	<div id="reply_to_title-{rec-id}" class="reply_to_title fl_l" style="margin-left:7px;margin-top:1px"></div>
  [owner]<div class="html_checkbox" id="for_group{rec-id}" onclick="myhtml.checkbox(this.id);" style="margin: 11px 0px 0px 0px;font-size: 11px;">от сообщества</div>[/owner]
  </div>
 <div class="clear"></div>
</div>[/comment-form]