<script type="text/javascript">
$(document).ready(function(){
	epage.drag();
});
</script>
<input id="page_cnt" value="1" type="hidden"/>
<input id="count" value="{count}" type="hidden"/>
<input id="pid" value="{pid}" type="hidden"/>
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/epage?act=edit&pid={pid}" onClick="Page.Go(this.href); return false;"><div>����������</div></a>
 [noadmin_red]<a href="/epage?act=users&pid={pid}" onClick="Page.Go(this.href); return false;"><div>���������</div></a>[/noadmin_red]
 [p_lastnews]<a href="/epage?act=lastnews&pid={pid}" onClick="Page.Go(this.href); return false;"><div>������ �������</div></a>[/p_lastnews]
 <!--<a href="/epage?act=blacklist&pid={pid}" onClick="Page.Go(this.href); return false;"><div>������ ������</div></a>-->
 <div class="buttonsprofileSec2"><a href="/epage?act=link&pid={pid}" onClick="Page.Go(this.href); return false;"><div>������</div></a></div>
</div>
</div>
<div style="margin-top:-120px"><a href="/{adres}" onClick="Page.Go(this.href); return false;" style="float:right;">�������� � ����������</a></div>
<div class="clear"></div>
<div class="search_form_tab" style="margin-top:1px">
<input type="text" onkeypress="if(event.keyCode == 10 || event.keyCode == 13) epage.gettingLink();" value="������� ������, ������� ������ ��������" class="fave_input" onblur="if(this.value=='') this.value='������� ������, ������� ������ ��������';this.style.color = '#777';" onfocus="if(this.value=='������� ������, ������� ������ ��������') this.value='';this.style.color = '#000'" id="link_input" style="margin: -1px 0px 0px 0px;width: 408px !important;">
<div class="button_blue fl_r"><button style="width:170px" onClick="epage.gettingLink(); return false" id="button_div_link">�������� ������</button></div></div>
<div id="gedit_users_summaryw_members" class="summary_wrap" style="margin-bottom:0px;"><div id="gedit_users_summary_members" class="summary">{title}</div></div>
[no_links]<div class="msg_none" style="background:#fff;margin-bottom:0px;">�� ������ �������� �� �������� ������ �� ����������<br>�������� ������� ��� �� ������� �����.</div>[/no_links]
<div class="err_red no_display" style="margin-top:10px;"><b>������������ ������.</b><br>���������� ������� ���������� ������ �� ���������� �������� ������� ��� ������� ����.</div>
<div class="err_fall no_display" style="margin-top:10px;line-height: 17px;"><b>������ ���������.</b><br>������ ��� ������ ����� ������������ �� ��������.</div>