<div class="forum_msg_border2" id="{mid}" {style-new}>
<div class="forum_msg_ava">
 <a href="/id{user-id}" onClick="Page.Go(this.href); return false"><img src="{ava}" width="50" height="50" /></a><br />
 {online}
</div>
<div class="forum_text">
 <a href="/id{user-id}" onClick="Page.Go(this.href); return false"><b>{name}</b></a><br />
 <span style="font-size:12px">{text}</span><br />
 <span class="color777">{date} [admin-2]&nbsp;|&nbsp; <a href="/" onClick="Forum.DelMsg('{mid}'); return false">�������</a>[/admin-2] [not-owner]&nbsp;|&nbsp; <a href="/" onClick="wall.Answer('1', '{mid}', '{name}'); $(window).scrollTop(9999); return false">��������</a>[/not-owner]</span>
</div>
<div class="clear"></div>
</div>