<div class="public_obefeed" id="f{user-id}" onMouseOver="ge('public_minilink{user-id}').style.opacity = '1'" onMouseOut="ge('public_minilink{user-id}').style.opacity = '0.4'">
 <a href="/u{user-id}" onClick="Page.Go(this.href); return false"><img src="{ava}" align="left" /></a>
 <a href="/u{user-id}" onClick="Page.Go(this.href); return false">{name}</a><div class="fl_r public_minilink" id="public_minilink{user-id}"><a href="/" onClick="messages.new_('{user-id}'); return false">���������</a>[admin] &nbsp;-&nbsp; <a href="/about{id}" onClick="about.editfeedback('{user-id}'); return false">�������������</a> &nbsp;-&nbsp; <a href="/" onClick="about.delfeedback('{id}', '{user-id}'); return false">�������</a>[/admin]</div><br />
 <div id="close_editf{user-id}"><span id="okoffice{user-id}">{office}</span><div class="color777"><span id="okphone{user-id}">{phone}</span><span id="okemail{user-id}">{email}</span></div></div>
 [admin]<div id="editf{user-id}" class="no_display">
  <input type="text" id="office{user-id}" value="{office}" class="inpst" style="width:120px;margin-bottom:5px;padding:2px" /><br />
  <input type="text" id="phone{user-id}" value="{phone}" class="inpst" style="width:120px;padding:2px" />
  <input type="text" id="email{user-id}" value="{email}" class="inpst" style="width:120px;padding:2px" />
  <a href="/about{id}" style="margin-left:10px;font-size:11px;font-weight:normal" onClick="about.editfeeddave('{id}', '{user-id}'); return false">���������</a>
 </div>[/admin]
 <div class="clear"></div>
</div>