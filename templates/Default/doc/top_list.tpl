<div style="width:603px;margin-top:2px;"></div>
<script type="text/javascript">
$(document).ready(function(){		
	langNumric('langNumric', '{doc-num}', '��������', '���������', '����������', '��������', '����������');	
});
$(document).ready(function(){
	Xajax = new AjaxUpload('upload_2', {
		action: '/index.php?go=doc&act=upload',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
			if(!(ext && /^(doc|docx|xls|xlsx|ppt|pptx|rtf|pdf|png|jpg|gif|psd|mp3|djvu|fb2|ps|jpeg|txt|rar|zip|7zip)$/.test(ext))) {
				addAllErr('�������� ������ �����', 3300);
				return false;
			}
			Page.Loading('start');
		},
		onComplete: function (file, row){
			if(row == 1)
				addAllErr('�������� ������������ ������ ����� 10 ��', 3300);
			else {
				row = row.split('"');
				$('#loadedDocAjax').html('<div class="doc_block" style="margin-left:0px;margin-right:0px" id="doc_block'+row[1]+'"><a href="/index.php?go=doc&act=download&did='+row[1]+'"><div class="doc_format_bg cursor_pointer"><img src="{theme}/images/darr.gif" style="margin-right:5px" />'+row[3]+'</div></a><div id="data_doc'+row[1]+'"><a href="/index.php?go=doc&act=download&did='+row[1]+'"><div class="doc_name cursor_pointer" id="edit_doc_name'+row[1]+'" style="max-width:580px">'+row[0]+'</div></a><img class="fl_l cursor_pointer" style="margin-top:5px;margin-left:5px" src="{theme}/images/close_a.png" onClick="Doc.Del('+row[1]+')" onMouseOver="myhtml.title('+row[1]+', \'������� ��������\', \'wall_doc_\')" id="wall_doc_'+row[1]+'" /></div><div id="edit_doc_tab'+row[1]+'" class="no_display"><input type="text" class="inpst doc_input" value="'+row[0]+'" maxlength="60" id="edit_val'+row[1]+'" size="60" /><div class="clear" style="margin-top:5px;margin-bottom:35px;margin-left:62px"><div class="button_div fl_l"><button onClick="Doc.SaveEdit('+row[1]+', \'editLnkDoc'+row[1]+'\')">���������</button></div><div class="button_div_gray fl_l margin_left"><button onClick="Doc.CloseEdit('+row[1]+', \'editLnkDoc'+row[1]+'\')">������</button></div></div> </div><div class="doc_sel" onClick="Doc.ShowEdit('+row[1]+', this.id)" id="editLnkDoc'+row[1]+'">�������������</div><div class="doc_date clear">'+row[2]+', ��������� '+row[4]+'</div><div class="clear"></div></div>'+$('#loadedDocAjax').html());
				updateNum('#upDocNum', 1);
				langNumric('langNumric', $('#upDocNum').text(), '��������', '���������', '����������', '��������', '����������');
				if($('.doc_block').size() != $('#upDocNum').text())
					$('#'+$('.doc_block:last').attr('id')).remove();
			}
			Page.Loading('stop');
		}
	});
});
var page_cnt = 1;
function docAddedLoadAjax(){
	$('#wall_l_href_doc').attr('onClick', '');
	textLoad('wall_l_href_doc_load');
	$.post('/index.php?go=doc&act=list', {page_cnt: page_cnt}, function(d){
		$('#docAddedLoadAjax').append(d);
		$('#wall_l_href_doc').attr('onClick', 'docAddedLoadAjax()');
		$('#wall_l_href_doc_load').html('�������� ��� ���������');
		if(!d) $('#wall_l_href_doc').hide();
		page_cnt++;
	});
}
</script>
<div class="search_form_tab" style="margin-top:-13px;margin-bottom:10px;border-top: 1px solid #E4E7EB;width: 621px;padding:5px 10px">
<div style="padding:5px 0px;"><input type="text" style="width:430px;color:black" id="docsearch" placeholder="����� �� ����������" onkeydown="doc.search(1,1);" class="friends_se_search friends_s_search" value="">
<div class="docs_add_new fl_r" style="margin-top:10px;" id="upload_2">
    <span class="fl_l"></span>
   �������� ��������
  </div></div>
<div class="clear"></div>
</div>
<div style="margin-top:-5px;"></div>
<div class="summary_wrap" style="">
<div class="summary">� ��� <span id="upDocNum">{doc-num}</span> <span id="langNumric"></span></div>
</div>
<div style="height:15px"></div>
<div class="clear"></div>
<div id="loadedDocAjax"></div>