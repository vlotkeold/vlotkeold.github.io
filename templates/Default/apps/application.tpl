<script type="text/javascript">
$(document).ready(function(){
	if($('#app_container').width() > 647) {
		var wd = $('#app_container').width() - 647;
		$('.autowr').css('padding-left', wd + 'px').css('padding-right', wd + 'px').css('width', 814 + wd + 'px');
		$('.content').css('width', 654 + wd + 'px');
		$('#page_header .content').css('width', 799 + wd + 'px');
		$('.back').css('width', 799 + wd + 'px');
		$('.right').css('margin-left', 799 + wd + 'px');
		$('.cover_edit_title2').css('width', 631 + wd + 'px');
	}
});
</script>
<div class="cover_edit_title2 doc_full_pg_top2">
	<div class="fl_l margin_top_5 fl_l">
		<div><b>{title}</b></div>
	</div>
	
	<div class="clear"></div>
</div> <!-- // 1000 // -->
<div class="clear"></div>
<div class="apps_faslh_pos" style="padding-top:3px;">
<center>

[iframe]

[igames]<iframe id="app_container" name="fXD6c7b8" webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen="true" frameborder="0" src="{url}" scrolling="no" style="width: {width}px; height: {height}px;"></iframe>[/igames]

[noigames]<iframe id="app_container" name="fXD6c7b8" webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen="true" frameborder="0" src="{url}?api_url={site}api.php&amp;api_id={id}&amp;viewer_id={viewer_id}&amp;access_token=5e5c0a3dc3d5f9331b0d832ade9630260a0dd6965fd05a4df45cd9318c80e5574a1d8c37e2335fdae54b4&amp;user_id={viewer_id}&amp;auth_key={auth_key}&amp;hash=" scrolling="no" style="width: {width}px; height: {height}px;"></iframe>[/noigames]

[/iframe]

[flash]

<object width="{width}" height="{height}" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">

	<param value="sameDomain" name="allowScriptAccess">

	<param value="/uploads/apps/{id}/{flash}" name="movie">

	<param value="high" name="quality">

	<embed id="app_container" width="{width}" height="{height}" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" allowscriptaccess="sameDomain" quality="high" src="/uploads/apps/{id}/{flash}">

	</object>

[/flash]
	
</center>
</div>
<div class="clear"></div>