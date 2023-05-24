<input type="hidden" id="type" value="1"/>
<div class="miniature_box">
<div class="miniature_pos" style="width:627px;padding:0px;margin-top:{top}px">
<a class="fl_r tb_close" onClick="viiBox.clos('open_free_cat1', 1)" style="cursor: pointer;">Закрыть</a>
<script type="text/javascript">
$(document).ready(function(){
	$('.miniature_box').scroll(function(){
		if($('.miniature_box').scrollTop()>=parseInt($('.miniature_pos').css('margin-top'))+51){
			$('#tb_tabs').addClass('tb_fixed');
			$('.tb_tabs').css('width', '607px');
		} else $('#tb_tabs').removeClass('tb_fixed');
	});
});
</script>
<div class="tb_title" id="tb_title">Смайлик</div>


<div id="tb_box_1"><div class="gifts_section clear_fix" id="open_free_cat1">{stikers}</div></div>

</div>
</div>