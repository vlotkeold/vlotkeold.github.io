<div style="margin-left:110px"><div class="news_wall_msg_bg no_display" id="wall_text_250" style="width:300px;font-weight: normal;margin-top:-4px;">
 <div class="news_wall_msg_text" ><b><a href="/verify" onclick="page.go(this.href)">{translate=page_verifiedaccount}</a></b><br><div class="mgclr"></div>{translate=page_verifiedaccount2}<div class="clear"></div></div></div></div>
<script type="text/javascript">[after-reg]Profile.LoadPhoto();[/after-reg]
$(document).ready(function(){
	music.jPlayerInc();
	$('#wall_text, .fast_form_width').autoResize();
	[owner]if($('.profile_onefriend_happy').size() > 4) $('#happyAllLnk').show();[/owner]
});
$(document).click(function(event){
	wall.event(event);
});
</script>
<div id="jquery_jplayer"></div>
<input type="hidden" id="teck_id" value="" />
<input type="hidden" id="teck_prefix" value="" />
<input type="hidden" id="typePlay" value="standart" />
<div class="ava">
[owner]<div class="cover_newava" >[/owner]
<div id="owner_photo_wrap">
  <div id="owner_photo_top_bubble_wrap">
  [owner]<div id="owner_photo_top_bubble">
        <div class="owner_photo_bubble_delete_wrap" onClick="Profile.DelPhoto(); $('.profileMenu').hide(); return false;">
          <div class="owner_photo_bubble_delete"></div>
        </div>
  </div>[/owner]
</div>
<div class="b_photo "><span id="ava">
<a href="{link}" onclick="Photo.Show(this.href); return false"><span id="ava"><img src="{ava}" alt="" title="{translate=page_enlarge}" id="ava_{user-id}" /></span></a>
[owner] <div id="owner_photo_bubble_wrap">
        <div id="owner_photo_bubble"><div class="owner_photo_bubble_action owner_photo_bubble_action_update" onClick="Profile.LoadPhoto(); $('.profileMenu').hide(); return false;">
  <span class="owner_photo_bubble_action_in">{translate=page_loadphoto}</span>
</div><div class="owner_photo_bubble_action owner_photo_bubble_action owner_photo_bubble_action_crop" onClick="Profile.miniature(); return false;">
  <span class="owner_photo_bubble_action_in">{translate=page_editminiat}</span>
</div></div>
  </div>[/owner]
</div></div>[owner]</div>[/owner]
<div class="menuleft" style="margin-top:5px">
[owner]
<a href="/edit" onClick="Page.Go(this.href); $('.profileMenu').hide(); return false;"><div>{translate=page_edit}</div></a>
<div class="more_div2"></div>
[gifts]<a class="fans" href="/gifts{user-id}" onClick="gifts.viewer('{user-id}'); return false"><div style="text-align:left;"> {translate=page_mygifts} <small style="float:right;color: #60878E;"><b>{gifts-text}<span class="fl_r profile_gifts"></span></b></small></div></a>[/gifts]
[sub]<a class="fans" href="/" onClick="subscriptions.fall({user-id}); return false"><div style="text-align:left;">{translate=page_myfollowers}<small style="float:right;color: #60878E;"><b>{sub-num}<span class="fl_r profile_sub"></span></b></small></div></a>[/sub][/owner]
[not-owner]<div class="profile_subscblock">
   [blacklist][privacy-msg]<div class="button_blue fl_l" style="margin-top:10px;line-height:15px"><button onClick="messages.new_({user-id}); return false" style="width:174px">{translate=page_sendmessages}</button></div>
   <div class="clear"></div>[/privacy-msg][/blacklist]
   [no-friends][blacklist]<div class="button_blue fl_l" style="margin-top:10px;line-height:15px"><button onClick="friends.add({user-id}); return false" style="width:174px">{translate=page_nofriends}</button></div>
   <div class="clear"></div>[/blacklist][/no-friends]
    [yes-friends]<br><div id="friend_status"><div class="friend_status_info">{name} {translate=page_yesfriends}</div></div>

   <div class="clear"></div>[/yes-friends]
</div>
[blacklist][no-subscription]<a href="/" onClick="subscriptions.add({user-id}); return false" id="lnk_unsubscription"><div><span id="text_add_subscription">{translate=page_addsub}</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addsubscription_load" class="no_display" style="margin-right:-13px" /></div></a>[/no-subscription][/blacklist]
[yes-subscription]<a href="/" onClick="subscriptions.del({user-id}); return false" id="lnk_unsubscription"><div><span id="text_add_subscription">{translate=page_delsub}</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addsubscription_load" class="no_display" style="margin-right:-13px" /></div></a>[/yes-subscription]
[sub2]<a class="fans" href="/" onClick="subscriptions.fall({user-id}); return false"><div style="text-align:left;">{translate=page_followers} {name2}<small style="float:right;color: #60878E;"><b>{sub-num2}<span class="fl_r profile_sub"></span></b></small></div></a>[/sub2]
[privacy-gift][gifts]<a class="fans" href="/gifts{user-id}" onClick="gifts.viewer('{user-id}'); return false"><div style="text-align:left;">{translate=page_gifts} {name2}<small style="float:right;color: #60878E;"><b>{gifts-text}<span class="fl_r profile_gifts"></span></b></small></div></a>[/gifts][/privacy-gift]

<div class="more_div2"></div>
<a href="/" onClick="gifts.box('{user-id}'); return false"><div>{translate=page_sendgifts}<span class="fl_r profile_gifts"></span></div></a>
[/not-owner]
</div>

[blacklist]<div class="leftcbor">
 [privacy-gift][gifts]<div class="albtitle cursor_pointer" onClick="gifts.viewer('{user-id}'); return false">{gifts-text2}[not-owner]<span class="fl_r profile_gifts"></span>[/not-owner]</div>
 <div class="newmesnobg" style="padding:0px"><center><a href="/gifts{user-id}" onClick="gifts.viewer('{user-id}'); return false">{gifts}</a></center><div class="clear"></div>
 </div>[/gifts][/privacy-gift]
 [common-friends]<div class="albtitle cursor_pointer" onClick="Page.Go(this.href='/friends&section=common&id{user-id}'); return false">{translate=page_mutal_friends}</div>
 <div class="p_header_bottom" onclick="Page.Go('/friends&section=common&id{user-id}')"><span class="fl_r"></span>{mutual-num}</div>
 <div class="newmesnobg" style="padding:0px;padding-top:10px;">{mutual_friends}<div class="clear"></div>
 </div>[/common-friends]
 [friends]<div class="albtitle cursor_pointer" [owner]onclick="Page.Go('/friends&section=all')"[/owner][not-owner]onclick="Page.Go('/friends&section=all&id{user-id}')"[/not-owner]>{translate=page_friends}</div>
 <div class="p_header_bottom" [owner]onclick="Page.Go('/friends&section=all')"[/owner][not-owner]onclick="Page.Go('/friends&section=all&id{user-id}')"[/not-owner]><span class="fl_r"></span>{friends-num}</div>
 <div class="newmesnobg" style="padding:0px;padding-top:10px;">{friends}<div class="clear"></div>
 </div>[/friends]
 [online-friends]<div class="albtitle cursor_pointer" [owner]onclick="Page.Go('/friends&section=online')"[/owner][not-owner]onclick="Page.Go('/friends&section=online&id{user-id}')"[/not-owner]>{translate=page_online_friends}</div>
 <div class="p_header_bottom" [owner]onclick="Page.Go('/friends&section=online')"[/owner][not-owner]onclick="Page.Go('/friends&section=online&id{user-id}')"[/not-owner]><span class="fl_r"></span>{online-friends-num}</div>
 <div class="newmesnobg" style="padding:0px;padding-top:10px;">{online-friends}<div class="clear"></div>
 </div>[/online-friends]
 [privacy-public][groups]<div class="albtitle cursor_pointer" onClick="groups.all_groups_user('{user-id}')">{translate=page_comm}</div>
 <div class="p_header_bottom" onClick="groups.all_groups_user('{user-id}')"><span id="groups_num">{groups-num} </span></div>
 <div class="newmesnobg" style="padding-right:0px;padding-bottom:0px;">{groups}<div class="clear"></div>
 </div>[/groups][/privacy-public]
 [albums]<div class="albtitle cursor_pointer" onClick="Page.Go('/albums{user-id}'); return false">{translate=page_albums}</div>
 <div class="p_header_bottom" onClick="Page.Go('/albums{user-id}'); return false"><span>{albums-num}</span></div>
 <div class="newmesnobg" style="padding-right:0px;padding-bottom:0px;"><div style="margin-top:-10px">{albums}</div><div class="clear"></div>
 </div><br>[/albums]
 [privacy-video][videos]<div class="albtitle cursor_pointer" onclick="Page.Go('/videos/{user-id}')">{translate=page_videos}<div></div></div>
 <div class="p_header_bottom" onclick="Page.Go('/videos/{user-id}')">{videos-num}</div>
 <div class="newmesnobg" style="padding-right:0px;padding-bottom:0px;">{videos}<div class="clear"></div>
 </div>[/videos][/privacy-video]
  [privacy-audio][audios]<div id="jquery_jplayer"></div><input type="hidden" id="teck_id" value="1" />
  <div class="albtitle cursor_pointer" onclick="Page.Go('/audio{user-id}')">{translate=page_audios}<div></div></div>
 <div class="p_header_bottom" onclick="Page.Go('/audio{user-id}')">{audios-num}</div>
 <div class="newmesnobg" style="padding-right:0px;padding-bottom:0px;">{audios}<div class="clear"></div>
 </div>[/audios][/privacy-audio]
  [not-owner]<div class="menuleft" style="margin-top:14px"><div class="more_div"></div>
  [yes-friends]<a onMouseDown="friends.delet({user-id}, 0); return false"><div>{translate=page_deletedfr}</div></a>[/yes-friends]
[no-fave]<a href="/" onClick="fave.add({user-id},1); return false" id="addfave_but"><div><span id="text_add_fave">{translate=page_addfave}</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addfave_load" class="no_display" /></div></a>[/no-fave]
[yes-fave]<a href="/" onClick="fave.delet({user-id},1); return false" id="addfave_but"><div><span id="text_add_fave">{translate=page_delfave}</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addfave_load" class="no_display" /></div></a>[/yes-fave]
[no-blacklist]<a href="/" onClick="settings.addblacklist({user-id}); return false" id="addblacklist_but"><div><span id="text_add_blacklist">{translate=page_addblacklist}</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addblacklist_load" class="no_display" /></div></a>[/no-blacklist]
[yes-blacklist]<a href="/" onClick="settings.delblacklist({user-id}, 1); return false" id="addblacklist_but"><div><span id="text_add_blacklist">{translate=page_delblacklist}</span> <img src="/templates/Default/images/loading_mini.gif" alt="" id="addblacklist_load" class="no_display" /></div></a>[/yes-blacklist]
</div>
[/not-owner]
<div class="clear"></div>
</div>[/blacklist]
</div>

<div class="profiewr">
 [owner]<div class="set_status_bg no_display" id="set_status_bg">
  <input type="text" id="status_text" class="status_inp" value="{status-text}" style="width:385px;" maxlength="255" onKeyPress="if(event.keyCode == 13)gStatus.set()" />
  <div class="fl_l status_text"><span class="no_status_text [status]no_display[/status]"></span>{translate=page_newstatus}</div>
  <div class="button_blue fl_r status_but"><button id="status_but" onClick="gStatus.set()">{translate=page_save}</button></div>
 </div>[/owner]
 <div class="titleu">{name} {lastname} <div class="online_time">{online}</div></div>[yes]<div class="profile_grad fl_r">{vuz2}</div>[/yes]
 <div class="status">
  <div>[owner]<a href="/" id="new_status" onClick="gStatus.open(); return false">[/owner][blacklist]{status-text}[/blacklist][owner]</a>[/owner]</div>
  [owner]<span id="tellBlockPos"></span>
  <div class="status_tell_friends no_display">
   <div class="status_str"></div>
   <div class="html_checkbox" id="tell_friends" onClick="myhtml.checkbox(this.id); gStatus.startTell()">{translate=page_statustell}</div>
  </div>[/owner]
  [owner]<a href="#" onClick="gStatus.open(); return false" id="status_link" [status]class="no_display"[/status]>{translate=page_installstatus}</a>[/owner]
 </div>
 [not-all-country]<div class="flpodtext">{translate=page_country}:</div> <div class="flpodinfo"><a href="/?go=search&country={country-id}" onClick="Page.Go(this.href); return false">{country}</a></div>[/not-all-country]
 [not-all-city]<div class="flpodtext">{translate=page_city}:</div> <div class="flpodinfo"><a href="/?go=search&country={country-id}&city={city-id}" onClick="Page.Go(this.href); return false">{city}</a></div>[/not-all-city]
 [blacklist][not-all-birthday]<div class="flpodtext">{translate=page_birthday}:</div> <div class="flpodinfo">{birth-day}</div>[/not-all-birthday]
 [privacy-info][sp]<div class="flpodtext">{translate=page_sp}:</div> <div class="flpodinfo">{sp}</div>[/sp][/privacy-info]
 <div class="flpodtext"></div>
 <div class="cursor_pointer" onClick="Profile.MoreInfo(); return false" id="moreInfoLnk"><div class="public_wall_all_comm profile_hide_opne" id="moreInfoText">{translate=page_fullinfo}</div></div>
 <div id="moreInfo" class="no_display">
 [privacy-info][not-block-contact]<div class="fieldset"><div class="w2_a" [owner]style="width:230px;"[/owner]>{translate=page_contactinfo} [owner]<span><a href="/edit&act=contact" onClick="Page.Go(this.href); return false;">{translate=page_edit2}</a></span>[/owner]</div></div>
 [not-contact-phonebook]<div class="flpodtext">{translate=page_phone}:</div> <div class="flpodinfo">{phonebook}</div>[/not-contact-phonebook]
 [not-contact-vk]<div class="flpodtext">{translate=page_vk}:</div> <div class="flpodinfo">{vk}</div>[/not-contact-vk]
 [not-contact-od]<div class="flpodtext">{translate=page_od}:</div> <div class="flpodinfo">{od}</div>[/not-contact-od]
 [not-contact-fb]<div class="flpodtext">FaceBook:</div> <div class="flpodinfo">{fb}</div>[/not-contact-fb]
 [not-contact-skype]<div class="flpodtext">Skype:</div> <div class="flpodinfo"><a href="skype:{skype}">{skype}</a></div>[/not-contact-skype]
 [not-contact-icq]<div class="flpodtext">ICQ:</div> <div class="flpodinfo">{icq}</div>[/not-contact-icq]
 [not-contact-site]<div class="flpodtext">{translate=page_web}:</div> <div class="flpodinfo">{site}</div>[/not-contact-site][/not-block-contact]
  [education]<div class="fieldset"><div class="w2_b" [owner]style="width:210px;"[/owner]>{translate=page_education} [owner]<span><a href="/edit&act=education" onClick="Page.Go(this.href); return false;">{translate=page_edit2}</a></span>[/owner]</div></div> 
   [countrysr]<div class="flpodtext">{translate=page_country}:</div> <div class="flpodinfo">{countrysr}</div>[/countrysr]
   [citysr]<div class="flpodtext">{translate=page_city}:</div> <div class="flpodinfo">{citysr}</div>[/citysr]
   [shkola]<div class="flpodtext">{translate=page_school}:</div> <div class="flpodinfo"><a href="/?go=search&shkola={shkola}" onClick="Page.Go(this.href); return false">{shkola}</a></div>[/shkola]
   [nacalosr]<div class="flpodtext">{translate=page_newob}:</div> <div class="flpodinfo">{nacalosr}</div>[/nacalosr]
   [konecsr]<div class="flpodtext">{translate=page_lastob}:</div> <div class="flpodinfo">{konecsr}</div>[/konecsr]
   [datasr]<div class="flpodtext">{translate=page_dateexit}:</div> <div class="flpodinfo">{datasr}</div>[/datasr]
   [klass]<div class="flpodtext">{translate=page_classes}:</div> <div class="flpodinfo">{klass}</div>[/klass]
   [spec]<div class="flpodtext">{translate=page_specialisation}:</div> <div class="flpodinfo"><a href="/?go=search&spec={spec}" onClick="Page.Go(this.href); return false">{spec}</a></div>[/spec]
 [/education]
[higher_education]<div class="fieldset"><div class="w2_b" [owner]style="width:210px;"[/owner]>{translate=page_higher_education} [owner]<span><a href="/edit&act=higher_education" onClick="Page.Go(this.href); return false;">{translate=page_edit2}</a></span>[/owner]</div></div> 
[countryvi]<div class="flpodtext">{translate=page_country}:</div> <div class="flpodinfo">{countryvi}</div>[/countryvi]
   [cityvi]<div class="flpodtext">{translate=page_city}:</div> <div class="flpodinfo">{cityvi}</div>[/cityvi]
   [vuz]<div class="flpodtext">{translate=page_college}:</div> <div class="flpodinfo"><a href="/?go=search&vuz={vuz}" onClick="Page.Go(this.href); return false">{vuz}</a></div>[/vuz]
   [fac]<div class="flpodtext">{translate=page_department}:</div> <div class="flpodinfo"><a href="/?go=search&fac={fac}" onClick="Page.Go(this.href); return false">{fac}</a></div>[/fac]
   [form]<div class="flpodtext">{translate=page_modeofstudy}:</div> <div class="flpodinfo">{form}</div>[/form]
   [statusvi]<div class="flpodtext">{translate=page_status}:</div> <div class="flpodinfo">{statusvi}</div>[/statusvi]
   [datavi]<div class="flpodtext">{translate=page_dateexit}:</div> <div class="flpodinfo">{datavi}</div>[/datavi]
 [/higher_education]
 
[career]<div class="fieldset"><div class="w2_b" [owner]style="width:200px;"[/owner]>{translate=page_career} [owner]<span><a href="/edit&act=career" onClick="Page.Go(this.href); return false;">{translate=page_edit2}</a></span>[/owner]</div></div> 
   [countryca]<div class="flpodtext">{translate=page_country}:</div> <div class="flpodinfo">{countryca}</div>[/countryca]
   [cityca]<div class="flpodtext">{translate=page_city}:</div> <div class="flpodinfo">{cityca}</div>[/cityca]
   [mesto]<div class="flpodtext">{translate=page_mestojob}:</div> <div class="flpodinfo"><a href="/?go=search&mesto={mesto}" onClick="Page.Go(this.href); return false">{mesto}</a></div>[/mesto]
   [nacaloca]<div class="flpodtext">{translate=page_newjob}:</div> <div class="flpodinfo">{nacaloca}</div>[/nacaloca]
   [konecca]<div class="flpodtext">{translate=page_lastjob}:</div> <div class="flpodinfo">{konecca}</div>[/konecca]
   [dolj]<div class="flpodtext">{translate=page_position}:</div> <div class="flpodinfo"><a href="/?go=search&dolj={dolj}" onClick="Page.Go(this.href); return false">{dolj}</a></div>[/dolj][/career]
 
 
 [military]<div class="fieldset"><div class="w2_b" [owner]style="width:200px;"[/owner]>{translate=page_military_service} [owner]<span><a href="/edit&act=military" onClick="Page.Go(this.href); return false;">{translate=page_edit2}</a></span>[/owner]</div></div> 
   [countrysl]<div class="flpodtext">{translate=page_country}:</div> <div class="flpodinfo">{countrysl}</div>[/countrysl]
   [citysl]<div class="flpodtext">{translate=page_city}:</div> <div class="flpodinfo">{citysl}</div>[/citysl]
   [chast]<div class="flpodtext">{translate=page_unit}:</div> <div class="flpodinfo"><a href="/?go=search&chast={chast}" onClick="Page.Go(this.href); return false">{chast}</a></div>[/chast]
   [zvanie]<div class="flpodtext">{translate=page_vzvanie}:</div> <div class="flpodinfo"><a href="/?go=search&zvanie={zvanie}" onClick="Page.Go(this.href); return false">{zvanie}</a></div>[/zvanie]
   [nacalosl]<div class="flpodtext">{translate=page_newmili}:</div> <div class="flpodinfo">{nacalosl}</div>[/nacalosl]
   [konecsl]<div class="flpodtext">{translate=page_lastmili}:</div> <div class="flpodinfo">{konecsl}</div>[/konecsl][/military]
   
     [personal]<div class="fieldset"><div class="w2_b" [owner]style="width:200px;"[/owner]>{translate=page_personalviews} [owner]<span><a href="/edit&act=personal" onClick="Page.Go(this.href); return false;">{translate=page_edit2}</a></span>[/owner]</div></div> 
   [pred]<div class="flpodtext">{translate=page_politicalviews}:</div> <div class="flpodinfo">{pred}</div>[/pred]
   [miro]<div class="flpodtext">{translate=page_worldview}:</div> <div class="flpodinfo"><a href="/?go=search&miro={miro}" onClick="Page.Go(this.href); return false">{miro}</a></div>[/miro]
   [jizn]<div class="flpodtext">{translate=page_personalpriority}:</div> <div class="flpodinfo">{jizn}</div>[/jizn]
   [ludi]<div class="flpodtext">{translate=page_importantinothers}:</div> <div class="flpodinfo">{ludi}</div>[/ludi]
   [kurenie]<div class="flpodtext">{translate=page_viewsonsmoking}:</div> <div class="flpodinfo">{kurenie}</div>[/kurenie]
   [alkogol]<div class="flpodtext">{translate=page_viewsonalcohol}:</div> <div class="flpodinfo">{alkogol}</div>[/alkogol]
   [vdox]<div class="flpodtext">{translate=page_inspiredby}:</div> <div class="flpodinfo">{vdox}</div>[/vdox]
 [/personal]
 <div class="fieldset"><div class="w2_b" [owner]style="width:200px;"[/owner]>{translate=page_personalinformation} [owner]<span><a href="/edit&act=interests" onClick="Page.Go(this.href); return false;">{translate=page_edit2}</a></span>[/owner]</div></div>
 [not-info-activity]<div class="flpodtext">{translate=page_activities}:</div> <div class="flpodinfo">{activity}</div>[/not-info-activity]
 [not-info-interests]<div class="flpodtext">{translate=page_interests}:</div> <div class="flpodinfo">{interests}</div>[/not-info-interests]
 [not-info-music]<div class="flpodtext">{translate=page_favoritemusic}:</div> <div class="flpodinfo">{music}</div>[/not-info-music]
 [not-info-kino]<div class="flpodtext">{translate=page_favoritemovies}:</div> <div class="flpodinfo">{kino}</div>[/not-info-kino]
 [not-info-books]<div class="flpodtext">{translate=page_favoritebooks}:</div> <div class="flpodinfo">{books}</div>[/not-info-books]
 [not-info-games]<div class="flpodtext">{translate=page_favoritegames}:</div> <div class="flpodinfo">{games}</div>[/not-info-games]
 [not-info-quote]<div class="flpodtext">{translate=page_favoritequotes}:</div> <div class="flpodinfo">{quote}</div>[/not-info-quote]
 [not-info-myinfo]<div class="flpodtext">{translate=page_aboutme}:</div> <div class="flpodinfo">{myinfo}</div>[/not-info-myinfo]
  [not-info-clubs]<div class="flpodtext">{translate=page_groups}:</div> <div class="flpodinfo">{clubs}</div>[/not-info-clubs]
 [/privacy-info]
 </div>
 [photos]
 <div class="module clear people_module" id="profile_friends">
 <a style="text-decoration: none;" href="/albums{user-id}" onclick="Page.Go(this.href); return false"><div class="albtitle" style="margin-top:5px">{translate=page_photos}[owner]<span class="fl_r" id="wall_rec_num">{translate=page_addphotos}</span>[/owner]</div></a>
 <div id="my_photo" class="" style="margin-top:5px;margin-left:7px;"><center>{photos_view_albums}</center></div><div class="clear"></div></div>[/photos]
 <a href="/wall{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none"><div class="albtitle" style="border-bottom:0px">{wall-rec-num}</div></a>
 [privacy-wall]<div class="newmes" id="wall_tab" style="border-bottom:0px;margin-bottom:-5px">
  <input type="hidden" value="[owner]{translate=page_whatnew}[/owner][not-owner]{translate=page_typeyourmessages}[/not-owner]" id="wall_input_text" />
  <input type="text" class="wall_inpst" value="[owner]{translate=page_whatnew}[/owner][not-owner]{translate=page_typeyourmessages}[/not-owner]" onMouseDown="wall.form_open(); return false" id="wall_input" style="margin:0px" />
  <div class="no_display" id="wall_textarea">
   <textarea id="wall_text" class="wall_inpst wall_fast_opened_texta" style="width:381px"
	onKeyUp="wall.CheckLinkText(this.value)"
	onBlur="wall.CheckLinkText(this.value, 1)"
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
   <div class="attach_link_block_ic fl_l"></div><div class="attach_link_block_te"><div class="fl_l">{translate=page_link}: <a href="/" id="attatch_link_url" target="_blank"></a></div><img class="fl_l cursor_pointer" style="margin-top:2px;margin-left:5px" src="{theme}/images/close_a.png" id="attach_lnk_1" onClick="wall.RemoveAttachLnk()" /></div>
   <input type="hidden" id="attach_lnk_stared" />
   <input type="hidden" id="teck_link_attach" />
   <span id="urlParseImgs" class="no_display"></span>
   </div>
   <div class="clear"></div>
   <div id="attach_block_vote" class="no_display">
   <div class="attach_link_bg">
	<div class="medadd_h medadd_h_poll inl_bl">{translate=page_themevote}<img class="fl_r cursor_pointer" style="margin-top:2px;margin-left:5px" src="/templates/Default/images/close_a.png" id="attach_vote_1" onClick="Votes.RemoveForAttach()" /></div><div class="mgclr"></div><input type="text" id="vote_title" class="inpst" maxlength="80" value="" style="width:330px;" 
		onKeyUp="$('#attatch_vote_title').text(this.value)"
	/><div class="mgclr"></div>
	<div class="medadd_h2 medadd_h_poll2">{translate=page_variantanw}<small class="fl_r"><span id="addNewAnswer" ><a class="cursor_pointer" onClick="Votes.AddInp()">{translate=page_addanw}</a></span> | <span id="addDelAnswer">{translate=page_delanw}</span></small></div><div class="mgclr"></div><input type="text" id="vote_answer_1" class="inpst" maxlength="80" value="" style="width:330px;" /><div class="mgclr"></div>
	<div class="texta">&nbsp;</div><input type="text" id="vote_answer_2" class="inpst" maxlength="80" value="" style="width:330px;" /><div class="mgclr"></div>
	<div id="addAnswerInp"></div>
	<div class="clear"></div>
   <input type="hidden" id="answerNum" value="2" />
   </div>  
   </div>
   <div class="clear"></div>
   <input id="vaLattach_files" type="hidden" />
   <div class="clear"></div>
   <div class="button_blue fl_l margin_top_10"><button onClick="wall.send(); return false" id="wall_send">{translate=page_wallsend}</button></div>
   <div class="wall_attach fl_r" onClick="wall.attach_menu('open', this.id, 'wall_attach_menu')" onMouseOut="wall.attach_menu('close', this.id, 'wall_attach_menu')" id="wall_attach">{translate=page_wallatt}</div>
   <div class="wall_attach_menu no_display" onMouseOver="wall.attach_menu('open', 'wall_attach', 'wall_attach_menu')" onMouseOut="wall.attach_menu('close', 'wall_attach', 'wall_attach_menu')" id="wall_attach_menu">
    <div class="wall_attach_icon_smile" id="wall_attach_link" onClick="wall.attach_addphoto()">{translate=page_attachph}</div>
    <div class="wall_attach_icon_video" id="wall_attach_link" onClick="wall.attach_addvideo()">{translate=page_attachvi}</div>
    <div class="wall_attach_icon_photo" id="wall_attach_link" onClick="wall.attach_addaudio()">{translate=page_attachau}</div>
    <div class="wall_attach_icon_graffity" id="wall_attach_link" onClick="wall.attach_addgraffiti('{user-id}')">{translate=page_attachgr}</div>
    <div class="wall_attach_icon_audio" id="wall_attach_link" onClick="wall.attach_addDoc()">{translate=page_attachdc}</div>
    <div class="wall_attach_icon_doc" id="wall_attach_link" onClick="$('#attach_block_vote').slideDown('fast');wall.attach_menu('close', 'wall_attach', 'wall_attach_menu');$('#vote_title').focus();$('#vaLattach_files').val($('#vaLattach_files').val()+'vote|start||')">{translate=page_attachvt}</div>
   </div>
  </div>
  <div class="clear"></div>
 </div>[/privacy-wall]
 <div id="wall_records">{records}[no-records]<div class="wall_none" [privacy-wall]style="border-top:0px"[/privacy-wall]>{translate=page_norecwall}</div>[/no-records]</div>
 [wall-link]<span id="wall_all_record"></span><div onClick="wall.page('{user-id}'); return false" id="wall_l_href" class="cursor_pointer"><div class="photo_all_comm_bg wall_upgwi" id="wall_link">{translate=page_allrecord}</div></div>[/wall-link][/blacklist]
 [not-blacklist]<div class="err_yellow" style="font-weight:normal;margin-top:5px">{name} {translate=page_blaclistyes}</div>[/not-blacklist]
</div>
<div class="clear"></div>