<script type="text/javascript">
$(document).ready(function(){
	$('#mi_left').val('50');
	$('#mi_top').val('50');
	$('#miniature_crop').imgAreaSelect({
		handles: true,
		aspectRatio: '4:4',
		minHeight: 100,
		minWidth: 100,
		x1: 50,
		y1: 50,
		x2: 100,
		y2: 100,
		onSelectEnd: function(img, selection){
			$('#mi_left').val(selection.x1);
			$('#mi_top').val(selection.y1);
			$('#mi_width').val(selection.width);
			$('#mi_height').val(selection.height);
		},
		onSelectChange: clubs.preview
	});
});
</script>
<div class="miniature_box">
 <div class="miniature_pos">
  <div class="miniature_title fl_l">����� ���������</div><a class="cursor_pointer fl_r" onClick="clubs.miniatureClose()">�������</a>
  <div class="miniature_text clear">�������� ������� ���������� ������� ��� ��������� ����������.<br />
  ��������� ��������� ����� �������������� � ��������, ������� ��������� � ������������.</div>
  <div class="miniature_img">
   <img src="/uploads/clubs/{pid}/{ava}" width="200" id="miniature_crop" class="fl_l" />
   <div id="miniature_crop_100" style="width:100px;height:100px;overflow:hidden"><img src="/uploads/clubs/{pid}/{ava}" /></div>
   <div id="miniature_crop_50" style="width:50px;height:50px;overflow:hidden"><img src="/uploads/clubs/{pid}/{ava}" /></div>
   <div class="button_blue fl_l" style="margin-top:15px;"><button onClick="eclub.miniatureSave('{pid}')" id="miniatureSave">��������� ���������</button></div>
  </div>
  <input type="hidden" id="mi_left" />
  <input type="hidden" id="mi_top" />
  <input type="hidden" id="mi_width" />
  <input type="hidden" id="mi_height" />
  <div class="clear"></div>
 </div>
</div>