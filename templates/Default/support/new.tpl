<div id="data">
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
  <a href="/support" onClick="Page.Go(this.href); return false;"><div>[group=4]������� �� �������������[/group][not-group=4]��� �������[/not-group]</div></a>
<div class="buttonsprofileSec2">[not-group=4]<a href="/support?act=new" onClick="Page.Go(this.href); return false;"><div>����� ������</div></a>[/not-group]</div>
 </div>
</div>
[not-group=4]
<div style="margin-top:30px"></div>
<div class="note_add_bg support_bg">
����� �� ������ �������� ��� � ����� ��������, ��������� � <b>����� ������</b>.
<input type="text" 
	class="videos_input" 
	style="width:500px;margin-top:10px;color:#c1cad0" 
	maxlength="65" 
	id="title"
	value="����������, �������� ��������� � ������ �������.." 
	onblur="if(this.value==''){this.value='����������, �������� ��������� � ������ �������..';this.style.color = '#c1cad0';}" 
	onfocus="if(this.value=='����������, �������� ��������� � ������ �������..'){this.value='';this.style.color = '#000'}"
/>
<div class="input_hr" style="width:593px"></div>
<textarea 
	class="videos_input wysiwyg_inpt" 
	id="question" 
	style="width:500px;height:100px;color:#c1cad0"
	onblur="if(this.value==''){this.value='����������, ���������� � ����� �������� ���� ���������..';this.style.color = '#c1cad0';}" 
	onfocus="if(this.value=='����������, ���������� � ����� �������� ���� ���������..'){this.value='';this.style.color = '#000'}"
>����������, ���������� � ����� �������� ���� ���������..</textarea>
<div class="clear"></div>
<div class="button_blue fl_l"><button onClick="support.send(); return false" id="send">���������</button></div>
<div class="button_div_gray fl_l margin_left" id="cancel"><button onClick="Page.Go('/id{uid}'); return false;">������</button></div>
<div class="clear"></div>
</div>
[/not-group]
[group=4]<div class="info_center"><br /><br /><br />�� ������ �� �����.<br /><br /><br /></div>[/group]
</div>