<div class="pcont prof">
<div class="m" style="display:none;">
<div class="ok"></div>
</div>
<div class="panel prof_panel">
<img class="u" align="left" src="{ava}">
<div class="cont">
<h2>
{name} {lastname}</h2>
<div class="lv"></div>
<div class="status">
</div>
<div class="info"> {city}</div>
</div>
<div class="cb"></div>


<div class="clr" style="margin-top:10px"></div>
[not-owner]<div style="padding-left:40px;padding-right:40px;margin-bottom:30px;">
[blacklist][privacy-msg]<button class="button" onClick="messages.new_({user-id}); return false" style="width:49%">�������� ���������</button>[/privacy-msg][/blacklist]
[no-friends][blacklist]<button class="button" onClick="friends.add({user-id}); return false" style="width:50%">�������� � ������</button>[/blacklist][/no-friends]
[yes-friends]<button class="button" onClick="friends.goDelte({user-id}); return false" style="width:49%">������ �� ������</button>[/yes-friends]
</div>
[/not-owner]
</div>
<div style="margin-top:-12px"></div>
[privacy-info] <div class="prof_info">
<a class="h4"  href="/editmypage" onclick="Page.Go(this.href); return false" >
<h4>
<span>����������</span>
 <span class="rl">���.</span> 
<div class="cb"></div>
</h4>
</a>
<div class="cont">
<div>[not-all-birthday]
 <dl class="pinfo">
<dt>���� ��������:</dt><dd><a href="/?go=search&day=26&month=8&year=1993" onClick="Page.Go(this.href); return false">{birth-day}</a></dd>
</dl>[/not-all-birthday][sp]
 <dl class="pinfo">
<dt>�������� ���������:</dt><dd><a href="/?go=search&sp=1" onClick="Page.Go(this.href); return false">{sp}</a></dd>
</dl> [/sp]

[not-contact-phone]
 <dl class="pinfo">
<dt>���. �������: </dt><dd><a href="/" onClick="Page.Go(this.href); return false">{phone}</a></dd>
</dl> [/not-contact-phone]

 </div>
<br>
 </div>[/privacy-info] [not-owner]
<div class="prof_info">
<h4>��������</h4>
<ul class="page_menu">

<li>
<a onclick="gifts.box('{user-id}'); return false" href="/">
<i class="p gift"></i>
��������� �������
</a>
</li>
 [no-fave]

<li>
<a href="/" onClick="fave.add({user-id}); return false" id="addfave_but">
<b id="text_add_fave">�������� � ��������</b>
</a>
</li>
[/no-fave]
 [yes-fave]
<li>
<a href="/" onClick="fave.delet({user-id}); return false" id="addfave_but">
<b id="text_add_fave">������� �� ��������</b>
</a>
</li>
[/yes-fave]
 [no-subscription]
<li>
<a id="lnk_unsubscription" onclick="subscriptions.add({user-id}); return false" href="/"><b id="text_add_subscription">����������� �� ����������</b></a>
</li>
[/no-subscription]
 [yes-subscription]

<li>
<a id="lnk_unsubscription" onclick="subscriptions.del({user-id}); return false" href="/"><b id="text_add_subscription">���������� �� ����������</b></a>
</li>
[/yes-subscription][/not-owner]
 <div class="prof_info">
<h4>������</h4>
<ul class="page_menu">
 [friends]
<li>
<a href="/friends/{user-id}" onclick="Page.Go(this.href); return false">
������
<em>{friends-num}</em>
</a>
</li>
[/friends]


 [groups]

<li>
<a href="/" onclick="groups.all_groups_user('{user-id}'); return false">
���������� ��������
<em>{groups-num}</em>
</a>
</li>
[/groups]
 [gifts]

<li>
<a href="/gifts{user-id}" onclick="Page.Go(this.href); return false">
������� 
<em>{gifts-text}</em>
</a>
</li>
[/gifts]
</div>

<a class="h4" href="/" onclick="return false">
<h4>
<span>�����  {wall-rec-num} </span>
<div class="cb"></div>
</h4>
</a>

<div class="post_add">
<form onblur="return false">
<div class="iwrap">
<textarea id="wall_text" placeholder="[owner]��� � ��� ������?[/owner][not-owner]�������� ���������...[/not-owner]"></textarea>
</div>
<div class="near_box">
<input class="btn" type="submit" value="���������" onClick="wall.send({user-id}); return false" id="wall_send">
</div>
</form>
</div>


<div id="wall_records">{records}[no-records]<div class="wall_none" [privacy-wall]style="border-top:0px"[/privacy-wall]>�� ����� ���� ��� �� ����� ������.</div>[/no-records]</div>
[wall-link]<span id="wall_all_record"></span><div onClick="wall.page('{user-id}'); return false" id="wall_l_href" class="cursor_pointer"><div class="photo_all_comm_bg wall_upgwi" id="wall_link">� ���������� �������</div></div>[/wall-link]