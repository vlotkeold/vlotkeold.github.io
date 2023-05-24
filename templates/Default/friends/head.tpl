[all-friends]
<div class="sft2" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:16px">
 <div class="buttonsprofileSec2"><a [owner]href="/friends&section=all"[/owner][not-owner]href="/friends&section=all&id{user-id}"[/not-owner] onClick="Page.Go(this.href); return false;"><div>{translate=fvk_allfr}</div></a></div>
 <a [owner]href="/friends&section=online"[/owner][not-owner]href="/friends&section=online&id{user-id}"[/not-owner] onClick="Page.Go(this.href); return false;">{translate=fvk_onlinefr}</a>
 [owner]<a href="/friends&section=requests" onClick="Page.Go(this.href); return false;">{translate=fvk_reqfr} {demands}</a>[/owner]
 [not-owner][common-friends]<a href="/friends&section=common&id{user-id}" onClick="Page.Go(this.href); return false;"><div>{translate=fvk_commonfr}</div></a>[/common-friends]
 <a href="/id{user-id}" onClick="Page.Go(this.href); return false;">{translate=fvk_back} {name}</a>[/not-owner]
</div></div>
<div class="clear"></div>
<div class="search_form_tab" style="margin-top:10px;margin-bottom:10px;border-top: 1px solid #E4E7EB;width: 621px;padding:5px 10px">
<div style="padding:5px 0px;"><input type="text" style="width:450px;color:black" id="friendsearch" placeholder="{translate=fvk_searchfr}" onkeydown="friends.search(1,1);" class="friends_se_search friends_s_search" value="">
<div class="button_blue fl_r" style="margin-top:10px;"><button onclick="Page.Go('/balance?act=invite'); return false">{translate=fvk_invitefr}</button></div></div>
<div class="clear"></div>
</div>
<div style="margin-top:-5px;"></div>
<div class="summary_wrap" style="">
<div class="summary">[owner]{translate=fvk_you}[/owner][not-owner]{translate=fvk_y} {name}[/not-owner] {friends-num}</div>
</div>
<div class="side_panel">
<a [owner]href="/friends&section=all"[/owner][not-owner]href="/friends&section=all&id{user-id}"[/not-owner] onClick="Page.Go(this.href); return false;" class="side_filter cur_section"><div>{translate=fvk_allfr}</div></a><br>
[owner]<a href="/friends&section=phonebook" onClick="Page.Go(this.href); return false;" class="side_filter"><div>{translate=fvk_phonebook}</div></a>[/owner]
</div>

<div style="margin-top:-115px;"></div>
<div id="searchbody" style="display:none;"></div>


[/all-friends]

[request-friends]
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/friends&section=all" onClick="Page.Go(this.href); return false;">{translate=fvk_allfr}</a>
 <a href="/friends&section=online" onClick="Page.Go(this.href); return false;">{translate=fvk_onlinefr}</a>
 <div class="buttonsprofileSec2"><a href="/friends&section=requests" onClick="Page.Go(this.href); return false;"><div>{translate=fvk_reqfr} {demands}</div></a></div>
</div></div>
<div class="search_form_tab" style="margin-top:12px;border-top: 1px solid #E4E7EB;">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:22px">
 <div class="buttonsprofileSec fl_l"><a href="/friends&section=requests" onclick="Page.Go(this.href); return false;"><div><b>{translate=fvk_allsub}</b></div></a></div>
 <div class="fl_l"><a href="/friends&section=myrequests" onclick="Page.Go(this.href); return false;"><div><b>{translate=fvk_myreq}</b></div></a></div>
</div>
</div>
<div class="clear"></div><div style="margin-top:10px;"></div>
<br>
[/request-friends]

[myrequest-friends]
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/friends&section=all" onClick="Page.Go(this.href); return false;">{translate=fvk_allfr}</a>
 <a href="/friends&section=online" onClick="Page.Go(this.href); return false;">{translate=fvk_onlinefr}</a>
 <div class="buttonsprofileSec2"><a href="/friends&section=requests" onClick="Page.Go(this.href); return false;"><div>{translate=fvk_reqfr} {demands}</div></a></div>
</div></div>
<div class="search_form_tab" style="margin-top:12px;border-top: 1px solid #E4E7EB;">
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:22px">
 <div class="fl_l"><a href="/friends&section=requests" onclick="Page.Go(this.href); return false;"><div><b>{translate=fvk_allsub}</b></div></a></div>
 <div class="buttonsprofileSec fl_l"><a href="/friends&section=myrequests" onclick="Page.Go(this.href); return false;"><div><b>{translate=fvk_myreq}</b></div></a></div>
</div>
</div>
<div class="clear"></div><div style="margin-top:10px;"></div>
<br>
[/myrequest-friends]

[online-friends]
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:16px">
 <a [owner]href="/friends&section=all"[/owner][not-owner]href="/friends&section=all&id{user-id}"[/not-owner] onClick="Page.Go(this.href); return false;">{translate=fvk_allfr}</a>
 <div class="buttonsprofileSec2"><a [owner]href="/friends&section=online"[/owner][not-owner]href="/friends&section=online&id{user-id}"[/not-owner] onClick="Page.Go(this.href); return false;"><div>{translate=fvk_onlinefr}</div></a></div>
 [owner]<a href="/friends&section=requests" onClick="Page.Go(this.href); return false;">{translate=fvk_reqfr} {demands}</a>[/owner]
 [not-owner][common-friends]<a href="/friends&section=common&id{user-id}" onClick="Page.Go(this.href); return false;"><div>{translate=fvk_commonfr}</div></a>[/common-friends]
 <a href="/id{user-id}" onClick="Page.Go(this.href); return false;">{translate=fvk_back} {name}</a>[/not-owner]
</div></div>
<div class="clear"></div>
<div class="search_form_tab" style="margin-top:10px;margin-bottom:10px;border-top: 1px solid #E4E7EB;width: 621px;padding:5px 10px">
<div style="padding:5px 0px;"><input type="text" style="width:450px;color:black" id="friendsearch" placeholder="{translate=fvk_searchfr}" onkeydown="friends.search(1,1);" class="friends_se_search friends_s_search" value="">
<div class="button_blue fl_r" style="margin-top:10px;"><button onclick="Page.Go('/balance?act=invite'); return false">{translate=fvk_invitefr}</button></div></div>
<div class="clear"></div>
</div>
<div style="margin-top:-5px;"></div>
<div class="summary_wrap" style="">
<div class="summary">[owner]{translate=fvk_you}[/owner][not-owner]{translate=fvk_y} {name}[/not-owner] {friends-num}</div>
</div>
<div class="side_panel">
<a [owner]href="/friends&section=all"[/owner][not-owner]href="/friends&section=all&id{user-id}"[/not-owner] onClick="Page.Go(this.href); return false;" class="side_filter cur_section"><div>{translate=fvk_allfr}</div></a><br>
[owner]<a href="/friends&section=phonebook" onClick="Page.Go(this.href); return false;" class="side_filter"><div>{translate=fvk_phonebook}</div></a>[/owner]
</div>

<div style="margin-top:-115px;"></div>
<div id="searchbody" style="display:none;"></div>


[/online-friends]

[phonebook-friends]
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:16px">
 <div class="buttonsprofileSec2"><a [owner]href="/friends&section=all"[/owner][not-owner]href="/friends&section=all&id{user-id}"[/not-owner] onClick="Page.Go(this.href); return false;">{translate=fvk_allfr}</a></div>
 <a [owner]href="/friends&section=all"[/owner][not-owner]href="/friends&section=all&id{user-id}"[/not-owner] onClick="Page.Go(this.href); return false;"><div>{translate=fvk_onlinefr}</div></a>
 [owner]<a href="/friends&section=requests" onClick="Page.Go(this.href); return false;">{translate=fvk_reqfr} {demands}</a>[/owner]
 [not-owner][common-friends]<a href="/friends&section=common&id{user-id}" onClick="Page.Go(this.href); return false;"><div>{translate=fvk_commonfr}</div></a>[/common-friends]
 <a href="/id{user-id}" onClick="Page.Go(this.href); return false;">{translate=fvk_back} {name}</a>[/not-owner]
</div></div>
<div class="clear"></div>
<div class="search_form_tab" style="margin-top:10px;margin-bottom:10px;border-top: 1px solid #E4E7EB;width: 621px;padding:5px 10px">
<div style="padding:5px 0px;"><input type="text" style="width:450px;color:black" id="friendsearch" placeholder="{translate=fvk_searchfr}" onkeydown="friends.search(1,1);" class="friends_se_search friends_s_search" value="">
<div class="button_blue fl_r" style="margin-top:10px;"><button onclick="Page.Go('/balance?act=invite'); return false">{translate=fvk_invitefr}</button></div></div>
<div class="clear"></div>
</div>
<div style="margin-top:-5px;"></div>
<div class="summary_wrap" style="">
<div class="summary">[owner]{translate=fvk_you}[/owner][not-owner]{translate=fvk_y} {name}[/not-owner] {friends-num}</div>
</div>
<div class="side_panel">
<a [owner]href="/friends&section=all"[/owner][not-owner]href="/friends&section=all&id{user-id}"[/not-owner] onClick="Page.Go(this.href); return false;" class="side_filter"><div>{translate=fvk_allfr}</div></a><br>
[owner]<a href="/friends&section=phonebook" onClick="Page.Go(this.href); return false;" class="side_filter cur_section"><div>{translate=fvk_phonebook}</div></a>[/owner]
</div>
<div class="clear"></div>
[no_ph_fr]<div style="margin-top:-6px;"></div>[/no_ph_fr]
[yes_ph_fr]<div style="margin-top:-128px;"></div>[/yes_ph_fr]
<br>
[/phonebook-friends]