<style>.speedbar{background:#fff;color:#5081b1;margin-top:-30px}</style>
<link media="screen" href="{theme}/style/photos.css" type="text/css" rel="stylesheet" /> 
[all-albums]
[admin-drag][owner]<script type="text/javascript">
$(document).ready(function(){
	Albums.Drag();
});
</script>[/owner][/admin-drag]
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <div class="buttonsprofileSec2"><a href="/albums{user-id}" onClick="Page.Go(this.href); return false;"><div>[not-owner]��� ������� {name}[/not-owner][owner]��� �������[/owner]</div></a></div>
 <a href="/albums/comments/{user-id}" onClick="Page.Go(this.href); return false;">����������� � ��������</a>
 [not-owner]<a href="/id{user-id}" onClick="Page.Go(this.href); return false;">� �������� {name}</a>[/not-owner]
 [new-photos]<a href="/albums/newphotos" onClick="Page.Go(this.href); return false;">����� ���������� �� ���� (<b>{num}</b>)</a>[/new-photos]
</div></div>
[owner]<div style="float:right;margin-top:-10px"><a href="" onClick="Albums.CreatAlbum(); return false;">������� ������</a></div>[/owner]
<div class="summary_wrap">
  <div class="summary">
    {num}
    </span>
  </div>
</div>
<div class="clear"></div>
<br>
[/all-albums]
[view]
<input type="hidden" id="all_p_num" value="{all_p_num}" />
<input type="hidden" id="aid" value="{aid}" />
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/albums{user-id}" onClick="Page.Go(this.href); return false;">[not-owner]��� ������� {name}[/not-owner][owner]��� �������[/owner]</a>
 <div class="buttonsprofileSec2"><a href="/album{aid}" onClick="Page.Go(this.href); return false;"><div>{album-name}</div></a></div>
 [not-owner]<a href="/id{user-id}" onClick="Page.Go(this.href); return false;">� �������� {name}</a>[/not-owner]
</div></div>
[owner][system]
<div style="margin-top:12px;"></div>
<div class="photos_album_page" style="margin-left:-12px;width:641px">
  <div id="photos_upload_area_wrap" style="position: relative;" >
  <a id="photos_upload_area" href="/albums/add/{aid}" onclick="Page.Go(this.href); return false;">
    <div class="photos_upload_area_upload">
      <span id="photo_upload_area_label" class="photos_upload_area_img">
        �������� ���������� � ������
      </span>
    </div>
  </a>
  <input id="photos_upload_input" class="file" type="file" size="28" onchange="Upload.onFileApiSend(cur.uplId, this.files);" multiple="true" name="photo" accept="image/jpeg,image/png,image/gif" style="visibility: hidden; position: absolute;"/>
</div>
</div>[/system][/owner]
<div class="summary_wrap" style="">
    <div class="summary">� ������� {photo-num} | <span><a href="/albums/view/{aid}/comments/" onClick="Page.Go(this.href); return false;" style="font-color:#21578b">����������� � �������</a></span> [owner][system]| <span><a href="/albums/editphotos/{aid}" onClick="Page.Go(this.href); return false;">�������� ������� ����������</a></span>[/system][/owner]</div>
 </div>
<div class="clear"></div><div style="margin-top:8px;"></div>
[/view]
[editphotos]
[admin-drag]<script type="text/javascript">
$(document).ready(function(){
	Photo.Drag();
});
</script>[/admin-drag]
<script type="text/javascript" src="{theme}/js/albums.view.js"></script>
<input type="hidden" id="all_p_num" value="{all_p_num}" />
<input type="hidden" id="aid" value="{aid}" />
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/albums{user-id}" onClick="Page.Go(this.href); return false;">��� �������</a>
 <a href="/album{aid}" onClick="Page.Go(this.href); return false;">{album-name}</a>
 <a href="/albums/view/{aid}/comments/" onClick="Page.Go(this.href); return false;">����������� � �������</a>
 <div class="buttonsprofileSec2"><a href="/albums/editphotos/{aid}" onClick="Page.Go(this.href); return false;"><div>�������� ������� ����������</div></a></div>
</div></div>
<br>
<div class="clear"></div><div style="margin-top:8px;"></div>
[/editphotos]
[comments]
<script type="text/javascript" src="{theme}/js/albums.view.js"></script>
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/albums{user-id}" onClick="Page.Go(this.href); return false;">[not-owner]��� ������� {name}[/not-owner][owner]��� �������[/owner]</a>
 <div class="buttonsprofileSec2"><a href="/albums/comments/{user-id}" onClick="Page.Go(this.href); return false;"><div>����������� � ��������</div></a></div>
 [not-owner]<a href="/id{user-id}" onClick="Page.Go(this.href); return false;">� �������� {name}</a>[/not-owner]
</div></div>
[owner]<div style="float:right;margin-top:-10px"><a href="" onClick="Albums.CreatAlbum(); return false;">������� ������</a></div>[/owner]
<div class="clear"></div>
[/comments]
[albums-comments]
<script type="text/javascript" src="{theme}/js/albums.view.js"></script>
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/albums{user-id}" onClick="Page.Go(this.href); return false;">[not-owner]��� ������� {name}[/not-owner][owner]��� �������[/owner]</a>
 <a href="/album{aid}" onClick="Page.Go(this.href); return false;">{album-name}</a>
 <div class="buttonsprofileSec2"><a href="/albums/view/{aid}/comments/" onClick="Page.Go(this.href); return false;"><div>����������� � �������</div></a></div>
 [not-owner]<a href="/id{user-id}" onClick="Page.Go(this.href); return false;">� �������� {name}</a>[/not-owner]
</div></div>
<div class="clear"></div>
[/albums-comments]
[all-photos]
<script type="text/javascript" src="{theme}/js/albums.view.js"></script>
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/albums{user-id}" onClick="Page.Go(this.href); return false;">[not-owner]��� ������� {name}[/not-owner][owner]��� �������[/owner]</a>
 <a href="/albums/comments/{user-id}" onClick="Page.Go(this.href); return false;">����������� � ��������</a>
 <div class="buttonsprofileSec2"><a href="/photos{user-id}" onClick="Page.Go(this.href); return false;"><div>����� ����������</div></a></div>
 [not-owner]<a href="/id{user-id}" onClick="Page.Go(this.href); return false;">� �������� {name}</a>[/not-owner]
</div></div>
[owner]<div style="float:right;margin-top:-10px"><a href="" onClick="Albums.CreatAlbum(); return false;">������� ������</a></div>[/owner]
<div class="clear"></div><div style="margin-top:8px;"></div>
[/all-photos]