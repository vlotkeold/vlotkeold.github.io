<div class="friends_onefriend" id="friend_{user-id}" style="width:80%">
 <a href="/id{user-id}" onClick="Page.Go(this.href); return false"><div class="friends_ava"><img src="{ava}" alt="" id="ava_{user-id}" /></div></a>
 <div class="fl_l" style="width:46%">
  <a href="/id{user-id}" onClick="Page.Go(this.href); return false"><b>{name}</b></a> {age}<span class="fl_l" style="width:46%"></span>
  <div class="friends_clr"></div>
  {country}{city}<div class="friends_clr"></div><div class="friends_clr"></div>
  {phonebook}<div class="friends_clr"></div>
  <span class="online">{online}</span><div class="friends_clr"></div>
 </div>
 <div class="menuleft fl_r friends_m">
 [viewer]<div>
  <a href="/" onClick="messages.new_({user-id}); return false"><div>{translate=fvk_sendmsg}</div></a>
  <a href="/friends&section=all&id{user-id}" onClick=Page.Go(); return false"><div>{translate=fvk_viewfr}</div></a>
  [owner]<a href="/" onMouseDown="friends.delet({user-id}, 0); return false"><div>{translate=fvk_delfriend}</div></a>[/owner]
  </div>[/viewer]
 </div>
 </div>