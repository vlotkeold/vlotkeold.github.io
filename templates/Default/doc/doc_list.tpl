<div class="doc_block" style="margin-left:0px;margin-right:0px" id="doc_block{did}">
 <a href="/index.php?go=doc&act=download&did={did}"><div class="doc_format_bg cursor_pointer">{format}</div></a>
 <div id="data_doc{did}"><a href="/index.php?go=doc&act=download&did={did}"><div class="doc_name cursor_pointer" id="edit_doc_name{did}" style="max-width:580px">{name}</div></a><img class="fl_l cursor_pointer" style="margin-top:5px;margin-left:5px" src="{theme}/images/close_a.png" onClick="Doc.Del('{did}')" onMouseOver="myhtml.title({did}, '������� ��������', 'wall_doc_')" id="wall_doc_{did}" /></div>
 <div id="edit_doc_tab{did}" class="no_display">
 <input type="text" class="inpst doc_input" value="{name}" maxlength="60" id="edit_val{did}" size="60" />
 <div class="clear" style="margin-top:5px;margin-bottom:35px;margin-left:62px">
 <div class="button_div fl_l"><button onClick="Doc.SaveEdit('{did}', 'editLnkDoc{did}')">���������</button></div>
 <div class="button_div_gray fl_l margin_left"><button onClick="Doc.CloseEdit('{did}', 'editLnkDoc{did}')">������</button></div>
 </div>
 </div>
 <div class="doc_sel" onClick="Doc.ShowEdit('{did}', this.id)" id="editLnkDoc{did}">�������������</div>
 <div class="doc_date clear">{size}, ��������� {date}</div>
 <div class="clear"></div>
</div>