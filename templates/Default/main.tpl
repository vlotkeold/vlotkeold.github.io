<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
{header}
<meta name="description" content="<b>яВинете</b> – универсальное средство для коммуникации и поиска людей, которым ежедневно пользуются множество пользователей ПК." />
<noscript><meta http-equiv="refresh" content="0; URL=/badbrowser.php"></noscript>
<link media="screen" href="{theme}/style/style.css" type="text/css" rel="stylesheet" /> 
<link media="screen" href="{theme}/im_chat/im_chat.css?{server_time}" type="text/css" rel="stylesheet" /> 
<link media="screen" href="{theme}/style/ads.css" type="text/css" rel="stylesheet" />   
<script type="text/javascript" src="{theme}/js/audio_player.js"></script>
<script type="text/javascript" src="{theme}/js/chat.js"></script>
{js}[not-logged]<script type="text/javascript" src="{theme}/js/reg.js"></script>
<script type="text/javascript" src="{theme}/js/index.js"></script>[/not-logged]
<link rel="shortcut icon" href="{theme}/images/faviconnew.ico" />
</head>
<body onResize="onBodyResize()" class="no_display" [not-logged]style="background:#fff"[/not-logged]>
<div class="scroll_fix_bg no_display" onMouseDown="myhtml.scrollTop()"><div class="scroll_fix_page_top">{translate=up}</div></div>
<div id="audioPlayer"></div>
<div id="doLoad"></div>
<div class="autowr">
[dont_admin]<div class="head">
 [logged]<a class="udinsMy" href="/feed{news-link}" onClick="Page.Go(this.href); return false;" id="news_link"><span id="new_news">{new-news}</span></a>[/logged]
  [not-logged]<a href="/" class="udinsMy"></a>[/not-logged]
  [logged]<div class="headmenu">
     <!--search-->
   <div id="seNewB">
    <input type="text" value="{translate=search2_h}" class="fave_input search_input" 
		onBlur="if(this.value==''){this.value='{translate=search2_h}';this.style.color = '#c1cad0';}" 
		onFocus="if(this.value=='{translate=search2_h}'){this.value='';this.style.color = '#000'}" 
		onKeyPress="if(event.keyCode == 13) gSearch.go();"
		onKeyUp="FSE.Txt()"
		onClick="if(this.value != 0) $('.fast_search_bg').show()"
	id="query" maxlength="65" />
	<div id="search_types">
	 <input type="hidden" value="1" id="se_type" />
	 <div class="search_type" id="search_selected_text" onClick="gSearch.open_types('#sel_types'); return false">по людям</div>
	 <div class="search_alltype_sel no_display" id="sel_types">
	  <div id="1" onClick="gSearch.select_type(this.id, 'по людям'); FSE.GoSe($('#query').val()); return false" class="search_type_selected">по людям</div>
	  <div id="2" onClick="gSearch.select_type(this.id, 'по видеозаписям'); FSE.GoSe($('#query').val()); return false">по видеозаписям</div>
	  <div id="3" onClick="gSearch.select_type(this.id, 'по заметкам');  FSE.GoSe($('#query').val()); return false">по заметкам</div>
	  <div id="4" onClick="gSearch.select_type(this.id, 'по сообществам'); FSE.GoSe($('#query').val()); return false">по сообществам</div>
	  <div id="5" onClick="gSearch.select_type(this.id, 'по аудиозаписям');  FSE.GoSe($('#query').val()); return false">по аудиозаписям</div>
	  <div id="6" onClick="gSearch.select_type(this.id, 'по группам');  FSE.GoSe($('#query').val()); return false">по группам</div>
	 </div>
	</div>
   <div class="fast_search_bg no_display" id="fast_search_bg">
   <a href="/" style="padding:12px;background:#eef3f5" onClick="gSearch.go(); return false" onMouseOver="FSE.ClrHovered(this.id)" id="all_fast_res_clr1"><text>Искать</text> <b id="fast_search_txt"></b><div class="fl_r fast_search_ic"></div></a>
   <span id="reFastSearch"></span>
   </div>
   </div>
   <!--/search-->
   <a href="/?go=search&type=1&query=" onClick="Page.Go(this.href); return false">люди</a>
   <a href="/?go=search&type=4" onClick="Page.Go(this.href); return false">сообщества</a>
   <!-- <a href="/apps" onClick="Page.Go(this.href); return false">игры</a> -->
   <a href="/audio" onClick="doLoad.js(0); player.open(); return false;" id="fplayer_pos">музыка</a>
   <a href="/support?act=new" onClick="Page.Go(this.href); return false">помощь</a>
   <a href="/?act=logout">выйти</a>
   </div>
   <!--/search--> 
  [/logged]
  </div>
[/dont_admin]
 [on_admin]
 <div id="page_header" class="p_head p_head_l0">

<div class="back"></div> 
[logged]<a class="left" href="/feed" onClick="Page.Go(this.href); return false"></a>[/logged]
[not-logged]<a class="left" href="/"></a>[/not-logged]
<div class="right"></div>
<a class="content">
        
<div id="top_nav" class="head_nav">
  <table cellspacing="0" cellpadding="0" id="top_links">
    <tbody><tr>
	<!--search-->[logged]
   <div id="seNewB">
    <input type="text" value="{translate=search2_h}" class="fave_input search_input" 
		onBlur="if(this.value==''){this.value='{translate=search2_h}';this.style.color = '#c1cad0';}" 
		onFocus="if(this.value=='{translate=search2_h}'){this.value='';this.style.color = '#000'}" 
		onKeyPress="if(event.keyCode == 13) gSearch.go();"
		onKeyUp="FSE.Txt()"
		onClick="if(this.value != 0) $('.fast_search_bg').show()"
	id="query" maxlength="65" />
	<div id="search_types">
   <div class="fast_search_bg no_display" id="fast_search_bg">
   <a href="/" style="padding:12px;background:#eef3f5" onClick="gSearch.go(); return false" onMouseOver="FSE.ClrHovered(this.id)" id="all_fast_res_clr1"><text>{translate=search_h}</text> <b id="fast_search_txt"></b><div class="fl_r fast_search_ic"></div></a>
   <span id="reFastSearch"></span>
   </div>
   </div>[/logged]
   <!--/search-->
	 <td class="top_back_link_td" style="visibility:hidden">
        <a class="top_nav_link fl_l" href="" id="top_back_link" onclick="if (nav.go(this, event, {back: true}) === false) { showBackLink(); return false; }" style="max-width: 196px; "></a>
      </td>
      <td style="[not-logged]visibility:hidden[/not-logged]"><nobr>
        <a class="top_nav_link" id="head_people" href="/?go=search&type=1&query=" onClick="Page.Go(this.href); return false">{translate=people_h}</a>
      </nobr></td>
      <td style="[not-logged]visibility:hidden[/not-logged]"><nobr>
        <a class="top_nav_link" id="head_communities" href="/?go=search&type=4" onClick="Page.Go(this.href); return false">{translate=comm_h}</a>
      </nobr></td>
    <td style="[not-logged]visibility:hidden[/not-logged]"><nobr>
        <a class="top_nav_link" id="head_games" href="/apps" onClick="Page.Go(this.href); return false">{translate=apps_h}</a>
      </nobr></td>
      <td style="[not-logged]visibility:hidden[/not-logged]"><nobr>
        <a class="top_nav_link" href="/audio" onClick="doLoad.js(0); player.open(); return false;" id="fplayer_pos">{translate=audio_h}<div id="head_play_btn1" onmouseover="addClass(this, 'over');" onmouseout="removeClass(this, 'over'); removeClass(this, 'down')" onmousedown="addClass(this, 'down')" onmouseup="removeClass(this, 'down')" onclick="headPlayPause(event)"></div></a>
      </nobr></td>
      <td id="support_link_td" style="[not-logged]visibility:hidden[/not-logged]"><nobr>
        <a class="top_nav_link" id="top_support_link" href="/support" onClick="Page.Go(this.href); return false">{translate=help_h}</a>
      </nobr></td>
      <td id="logout_link_td" style=""><nobr>
       [logged] <a class="top_nav_link" id="logout_link" href="/?act=logout">{translate=exit_h}</a>[/logged]
       [not-logged]{translate=langtoeng}[/not-logged]
      </nobr></td>
    </tr>
  </tbody></table>
</a>
<div id="ts_cont_wrap" ontouchstart="event.cancelBubble = true;" onmousedown="event.cancelBubble = true;" style="display: none; "></div>
      </div>
    </div>
 [/on_admin]
[logged]<div id="side_bar" class="fl_l">
<ol>
<li><table id="myprofile_table" cellspacing="0" cellpadding="0"><tbody><tr><td id="myprofile_wrap"><a href="{my-page-link}" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">{translate=my_page}</span></a></td> <td id="myprofile_edit_wrap"><a href="/edit" onClick="Page.Go(this.href); $('.profileMenu').hide(); return false;" id="myprofile_edit" class="left_row"><span class="left_label inl_bl">{translate=my_edit}</span></a></td></tr></tbody></table></li>
<li><a href="/friends&section={requests-link}" onClick="Page.Go(this.href); return false" id="requests_link" class="left_row"><span class="left_count_pad">[demands-log]<span class="left_count_wrap fl_r"><span id="new_requests" onMouseDown="ajax.friends()" class="inl_bl left_count">{demands}</span></span>[/demands-log]</span><span class="left_label inl_bl">{translate=my_friends}</span></a></li>
<li><a href="/albums{my-id}" onClick="Page.Go(this.href); return false" id="requests_link_new_photos" class="left_row">[photo-log]<span class="left_count_wrap fl_r"><span onMouseDown="ajax.photo()" class="inl_bl left_count" id="new_photos">{new_photos}</span></span>[/photo-log] <span class="left_label inl_bl">{translate=my_photos}<span></span></a></li>
<li><a href="/videos" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">{translate=my_videos}</span></a></li>
<li><a href="/audio" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">{translate=my_audios}</span></a></li>
<li><a href="/im" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_count_pad left_count_persist">[msg-log]<span class="left_count_wrap fl_r"><span id="new_msg" onMouseDown="ajax.msg()" class="inl_bl left_count">{msg}</span></span>[/msg-log] </span><span class="left_label inl_bl">{translate=my_msg}</span></a></li>
<li><a href="/groups" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">{translate=my_groups}</span></a></li>
<li><a href="/feed" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">{translate=my_news}</span></a></li>
<li><a href="/feed&section=notifications" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">{translate=my_notifications}</span></a></li>
<li><a href="/fave" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">{translate=my_fave}<span></span></a></li>
<li><a href="/settings" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">{translate=my_sett}<span></span></a></li>
<div class="more_div"></div>
<li><a href="/apps" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">{translate=my_apps}<span></span></a></li>
<li><a href="/docs" onClick="Page.Go(this.href); return false" class="left_row"><span class="left_label inl_bl">{translate=my_doc}<span></span></a></li>
</ol>
<div class="fmenu no_display">
<div id="stl_side" class="fixed stl_active over" style="width: 140px;margin-left:-8px; top: -40px; height: 482px; display: block;">
<div id="fmenu" class="over" style="opacity: 1;">
<a class="fmenu_item fl_r" href="/im" onClick="Page.Go(this.href); return false" onmousedown="ajax.msg()" onmouseover="Pads.preload('msg')">
<span id="new_msg"><span class="fmenu_text inl_bl">[msg-log]{msg2}[/msg-log]</span></span>
<span id="fmenu_msg" class="fmenu_icon inl_bl"></span>
</a>
<a class="fmenu_item fl_r" href="/feed&section=notifications" onClick="Page.Go(this.href); return false" onmousedown="return Pads.show('nws', event)" onmouseover="Pads.preload('nws')">
<span class="fmenu_text inl_bl"></span>
<span id="fmenu_nws" class="fmenu_icon inl_bl"></span>
</a>
<a class="fmenu_item fl_r" href="/settings" onClick="Page.Go(this.href); return false" onmousedown="return Pads.show('ap', event)" onmouseover="Pads.preload('ap')">
<span class="fmenu_text inl_bl"></span>
<span id="fmenu_ap" class="fmenu_icon inl_bl"></span>
</a>
</div>
</div></div>

<div style="margin-left:-6px;margin-bottom:10px;text-align: center;">

</div>
<div class="more_div"></div>
 <br>
<div id="gift"></div>
[yes_balance]
<div style="text-align: center; padding: 5px; background: none repeat scroll 0% 0% rgb(247, 247, 247); border-bottom: 1px solid rgb(221, 221, 221); margin: 0px 0px 0px;" id="left_balance_box">
    <div style="padding-top: 2px;" id="coins_left">{translate=my_balance1} <b>{ubm}</b> {translate=my_balance2}</div><br/>
  <a href="/settings&act=balance" onClick="Page.Go(this.href); return false">{translate=more}</a>
 </div>
 [/yes_balance]
 <div id="ads_view" style="display;"></div>

<div class="clear"></div>

<div style="margin-left:3px;">
<div id="ads_view1" style="display;"></div>
</div>
</div>
 </div>
 </div>
 [/logged]
 [not-logged]
 <div class="leftpanel" >
  <form method="POST" action="" style="margin-left:-3px">
   <div class="flLg" style="margin-left:19px">{translate=login}</div><center><input type="text" name="email" id="log_email" class="inplog" maxlength="50" /></center>
   <div class="flLg" style="margin-left:19px">{translate=pass}</div><center><input type="password" name="password" id="log_password" class="inplog" maxlength="50" /></center>
   <div class="logpos">
<div style="margin-top:2px">
    <div class="button_blue" style="width:121px;margin-right:-2px"><button name="log_in" id="login_but" style="width:113px">{translate=sign}</button></div></div>
	<div style="margin-top:5px"><a href="/restore" onClick="Page.Go(this.href); return false">{translate=ycne}</a></div>
   </div>
  </form>
 </div>[/not-logged]
 <div class="content" [logged]style="width:647px;"[/logged]>
  <div class="cont_border_left">
   <div class="cont_border_right">
    <div class="speedbar [speedbar]no_display[/speedbar]" id="speedbar">{speedbar}</div>
    <div class="padcont">
	 <div id="page">{info}{content}</div>
	 [logged]<div id="chat_onl_wrap" class="chat_onl_wrap" style="display: block;">
	 <div class="chats_sp chat_cont_sh_top"></div>
	 <div class="chat_cont_scrolling">
	 <div class="chat_onl_height"></div>
	 </div>
	 <div class="chats_sp chat_cont_sh_bottom"></div>
	 <a class="chat_tab_wrap" id="chat_tab_wrap" onclick="im_chat.chatOpen()">
	 <div class="chat_onl_cont"><div class="chat_onl" id="ims">{of}</div><div class="chats_sp chat_onl_icon"></div></div></a>
	 </div>
	 [/logged]
	 <div class="clear"></div>
	</div>
   </div>
  </div>
  <div class="cont_border_bottom"></div>
  <div class="footer">
   <a href="/about" onClick="Page.Go(this.href); return false">{translate=about}</a>
   <a href="/support?act=new" onClick="Page.Go(this.href); return false">{translate=help}</a>
   <a href="/terms" onClick="Page.Go(this.href); return false">{translate=terms}</a>
   <a href="/ads" onClick="Page.Go(this.href); return false">{translate=ads}</a>
   <a href="/dev" onClick="Page.Go(this.href); return false">{translate=developers}</a>
   <a href="/jobs.php">{translate=jobs}</a>
   <br /><br />
   {translate=sitename} &copy 2014 <a class="bnav_lang" onClick="trsn.box()" id="langTitle1" style="cursor:pointer">{lang}</a>
  </div>
  <small><div><center><a href="/id1" onClick="Page.Go(this.href); return false">{translate=author}</a></center></div></small>
 </div>
</div>
[logged]<script type="text/javascript">
function upClose(xnid){
	$('#event'+xnid).remove();
	$('#updates').css('height', $('.update_box').size()*123+'px');
}
function GoPage(event, p){
	var oi = (event.target) ? event.target.id: ((event.srcElement) ? event.srcElement.id : null);
	if(oi == 'no_ev' || oi == 'update_close' || oi == 'update_close2') return false;
	else {
		pattern = new RegExp(/photo[0-9]/i);
		pattern2 = new RegExp(/video[0-9]/i);
		if(pattern.test(p))
			Photo.Show(p);
		else if(pattern2.test(p)){
			vid = p.replace('/video', '');
			vid = vid.split('_');
			videos.show(vid[1], p, location.href);
		} else
			Page.Go(p);
	}
}
$(document).ready(function(){
	setInterval(function(){
		$.post('/index.php?go=updates', function(d){
			row = d.split('|');
			if(d && row[1]){
				if(row[0] == 1) uTitle = 'Новый ответ на стене';
				else if(row[0] == 2) uTitle = 'Новый комментарий к фотографии';
				else if(row[0] == 3) uTitle = 'Новый комментарий к видеозаписи';
				else if(row[0] == 4) uTitle = 'Новый комментарий к заметке';
				else if(row[0] == 5) uTitle = 'Новый ответ на Ваш комментарий';
				else if(row[0] == 6) uTitle = 'Новый ответ в теме';
				else if(row[0] == 7) uTitle = 'Новый подарок';
				else if(row[0] == 8) uTitle = 'Новое сообщение';
				else if(row[0] == 9) uTitle = 'Новая оценка';
				else if(row[0] == 10) uTitle = 'Ваша запись понравилась';
				else if(row[0] == 11) uTitle = 'Новая заявка';
				else if(row[0] == 12) uTitle = 'Заявка принята';
				else uTitle = 'Событие';
				temp = '<div class="update_box cursor_pointer" id="event'+row[4]+'" onClick="'+row[6]+'; upClose('+row[4]+')"><div class="update_box_margin"><div style="height:19px"><span>'+uTitle+'</span><div class="update_close fl_r no_display" id="update_close" onMouseDown="upClose('+row[4]+')"><div class="update_close_ic" id="update_close2"></div></div></div><div class="clear"></div><div class="update_inpad"><a href="/id'+row[2]+'" onClick="Page.Go(this.href); return false"><img src="'+row[5]+'" id="no_ev" /></a><div class="update_data"><a id="no_ev" href="/id'+row[2]+'" onClick="Page.Go(this.href); return false">'+row[1]+'</a>&nbsp;&nbsp;'+row[3]+'</div></div><div class="clear"></div></div></div>';
				$('#updates').html($('#updates').html()+temp);
				var beepThree = $("#beep-three")[0];
    				beepThree.play();
				if($('.update_box').size() <= 5) $('#updates').animate({'height': (123*$('.update_box').size())+'px'});
				if($('.update_box').size() > 5){
					evFirst = $('.update_box:first').attr('id');
					$('#'+evFirst).animate({'margin-top': '-123px'}, 400, function(){
						$('#'+evFirst).fadeOut('fast', function(){
							$('#'+evFirst).remove();
						});
					});
				}
			}
		});
	}, 2500);
});


</script>[/logged]
<div class="no_display"><audio id="beep-three" controls preload="auto"><source src="{theme}/sound/beep.ogg"></source></audio></div>
<div id="updates"></div>
<div class="clear"></div>
</body>
</html>