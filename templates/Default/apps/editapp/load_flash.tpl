
<script type="text/javascript">

$(document).ready(function(){
	Xajax = new AjaxUpload('upload', {
		action: '/index.php?go=editapp&act=flash&id={id}',
		id:'{id}',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
		if (!(ext && /^(swf)$/.test(ext))) {
			Box.Info('load_flash_er', lang_dd2f_no, '��������� ��������� ������ ���������� � ������� swf', 300);
				return false;
			}
			butloading('upload', '113', 'disabled', '');
		},
		onComplete: function (file, response) {
			if(response == 'bad_format')
				$('.err_red').show().text('��������� ��������� ������ ���������� � ������� swf');
			else if(response == 'big_size')
				$('.err_red').show().html(lang_bad_size);
			else if(response == 'bad')
				$('.err_red').show().text(lang_bad_aaa);
			else {
				Box.Close('flash');
				Box.Info('load_flash', lang_dd2f_no, '���������� ������� ���������.', 300);
				$('body, html').animate({scrollTop: 0}, 250);
			}
		}
	});
});

</script>

<div class="load_photo_pad">

<div class="err_red" style="display:none;font-weight:normal;"></div>

<div class="load_photo_but"><div class="button_div fl_l"><button id="upload">������� ����</button></div></div>

<small>���� �� ������ ��������� 5 M�. ���� � ��� ��������� �������� � ���������, ���������� ������������ swf ���� �������� �������.</small>

</div>
