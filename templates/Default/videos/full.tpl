<div id="video_show_{vid}" class="video_view" onClick="videos.setEvent(event, {owner-id}, '{close-link}')">
<div class="photo_close" onClick="videos.close({owner-id}, '{close-link}'); return false"></div>
 <div class="video_show_bg">
  <div class="video_show_object">
   <div class="video_show_title">
    <span id="video_full_title_{vid}">{title}</span>
	<div><a href="/" onClick="videos.close({owner-id}, '{close-link}'); return false">�������</a></div>
   </div>
   <div id="video_object">{video}</div>
   [not-owner]<div id="addok"><a href="/" onClick="videos.addmylist('{vid}'); return false">�������� � ��� �����������</a></div>[/not-owner]
  </div>
  <div class="video_show_panel" id="video_del_info">
   <div class="photo_leftcol video_show_left_col">
    <div class="video_show_descr" id="video_full_descr_{vid}">{descr}</div>
    <div class="video_show_date">��������� {date}</div><br />
	[all-comm]<a href="/" onClick="videos.allcomment({vid}, {comm-num}, {owner-id}); return false" id="all_href_lnk_comm"><div class="photo_all_comm_bg" id="all_lnk_comm">�������� {prev-text-comm}</div></a><span id="all_comments"></span>[/all-comm]
	[admin-comments]<span id="comments">{comments}</span>
    <div class="photo_com_title">��� �����������</div>
    <textarea id="comment" class="inpst" style="width:520px;height:70px;margin-bottom:10px;"></textarea>
    <div class="button_div fl_l"><button onClick="videos.addcomment({vid}); return false" id="add_comm">���������</button></div>[/admin-comments]
   </div>
   <div class="photo_rightcol">
    {views}
    �����������:<br /><a href="/id{uid}" onClick="Page.Go(this.href); return false">{author}</a><br /><br />
	<div class="menuleft" style="width:220px;">
     [owner]<a href="/" onClick="videos.editbox({vid}); return false"><img class="icon editphoto_ic" src="{theme}/images/spacer.gif" alt="" /><div>������������� �����������</div></a> 
	 <a href="/" onClick="videos.delet({vid}, 1); return false"><img class="icon del_photo_ic" src="{theme}/images/spacer.gif" alt="" /><div>������� �����������</div></a>[/owner]
	 <a onClick="Report.Box('video', '{vid}')"><img class="icon compla_ic" src="{theme}/images/spacer.gif" alt="" /><div>������������ �� �����������</div></a>
    </div>
   </div>
  <div class="clear"></div>
  </div>
 </div>
</div>