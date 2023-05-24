<script>
			$('.box_footer').hide();
			$('.bg_show_bottom').hide();
</script>
<link media="screen" href="{theme}/style/photos.css" type="text/css" rel="stylesheet" /> 
[top]<script type="text/javascript">
$(document).ready(function(){
	Xajax = new AjaxUpload('upload', {
		action: '/index.php?go=attach',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
			if (!(ext && /^(jpg|png|jpeg|gif|jpe)$/.test(ext))) {
				addAllErr(lang_bad_format, 3300);
				return false;
			}
			Page.Loading('start');
		},
		onComplete: function (file, response){
			if(response == 'big_size'){
				addAllErr(lang_max_size, 3300);
				Page.Loading('stop');
			} else {
				var response = response.split('|||');
				var imgname = response[1].split('/');
				wall.attach_insert('photo', response[1], 'attach|'+imgname[6].replace('c_', ''), response[2]);
				Page.Loading('stop');
			}
		}
	});
});
</script>
<div class="photos_album_page" style="margin-top:-4px;cursor:pointer" id="upload">
  <div id="photos_upload_area_wrap" style="position: relative;" >
  <a id="photos_upload_area" onclick="Page.Go(this.href); return false;">
    <div class="photos_upload_area_upload">
      <span class="photos_upload_area_img">
        Загрузить фотографию
      </span>
    </div>
  </a>
</div>
</div>
<div class="clear"></div>
<div style="padding:10px;padding-bottom:15px;">[/top]
[bottom]<div class="clear"></div></div>[/bottom]