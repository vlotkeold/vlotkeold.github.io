<form method="POST" action="" name="entryform">
<div class="note_add_bg">
<div class="videos_text">���������</div>
<input type="text" class="videos_input" style="width:700px" maxlength="65" id="title_n" value="{title}" />
<div class="input_hr"></div>
<div class="videos_text">�����</div>
<div class="wysiwyg_bbpanel">
 <div onClick="bbcodes.tag('[b]', '[/b]')" class="wysiwyg_icbold cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', '������', 'bb_bold_', '0')" id="bb_bold_1"></div>
 <div onClick="bbcodes.tag('[i]', '[/i]')" class="wysiwyg_ici cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', '���������', 'bb_i_', '0')" id="bb_i_1"></div>
 <div onClick="bbcodes.tag('[u]', '[/u]')" class="wysiwyg_icunderline cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', '������������', 'bb_underline_', '0')" id="bb_underline_1"></div>
 <div onClick="bbcodes.tag('[left]', '[/left]')" class="wysiwyg_icpleft cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', '��������� �� ������ ����', 'bb_pleft_', '0')" id="bb_pleft_1"></div>
 <div onClick="bbcodes.tag('[center]', '[/center]')" class="wysiwyg_icpcenter cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', '��������� �� ������', 'bb_pcenter_', '0')" id="bb_pcenter_1"></div>
 <div onClick="bbcodes.tag('[right]', '[/right]')" class="wysiwyg_icpright cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', '��������� �� ������� ����', 'bb_pright_', '0')" id="bb_pright_1"></div>
 <div onClick="bbcodes.tag('[quote]', '[/quote]')" class="wysiwyg_icquote cursor_pointer border_radius_3" onMouseOver="myhtml.title('1', '�������� ������', 'bb_quote_', '0')" id="bb_quote_1"></div>
 <div class="wysiwyg_icphoto cursor_pointer border_radius_3" onClick="wall.attach_addphoto(false, false, 1)" onMouseOver="myhtml.title('1', '�������� ����������', 'bb_photo_', '0')" id="bb_photo_1"></div>
 <div class="wysiwyg_icvideo cursor_pointer border_radius_3" onClick="wall.attach_addvideo(false, false, 1)" onMouseOver="myhtml.title('1', '�������� �����������', 'bb_video_', '0')" id="bb_video_1"></div>
 <div class="wysiwyg_iclink cursor_pointer border_radius_3" onClick="wysiwyg.linkBox()" onMouseOver="myhtml.title('1', '�������� ������', 'bb_link_', '0')" id="bb_link_1"></div>
 <div class="clear"></div>
</div>
<textarea class="videos_input wysiwyg_inpt" id="text" name="text">{text}</textarea>
<div class="input_hr"></div>
<div class="clear"></div>
<div class="button_div fl_l"><button onClick="notes.editsave({note-id}); return false" id="notes_sending">��������� ���������</button></div>
<div class="button_div_gray fl_l margin_left"><button onClick="notes.preview(); return false">��������</button></div>
<div class="clear"></div>
</div>
</form>