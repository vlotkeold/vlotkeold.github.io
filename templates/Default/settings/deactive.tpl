<div style="padding: 10px 40px 50px;">
<input id="value_reason" type="hidden"/>
<h1>����������, ������� ������� �������� ����� ��������</h1>

<div id="settings_deact_reasons">
    <div class="radiobtn settings_reason" onclick="deactive.changeReason(1);" style="padding-top:15px;">
      <div></div>� ���� ���� ������ ��������
      <div class="settings_reason_desc">�����-�� � ������ ��� �������� ��� ����� ������, �� ������ ��� ���� ������������������.</div>
    </div><br>
    <div class="radiobtn settings_reason" onclick="deactive.changeReason(2);">
      <div></div>������� �������� � ���� ������� ����� �������
      <div class="settings_reason_desc">� �� ���� ���� � ��������, ���� � ��������� ���� �������� � ���� ������. ��������� ����������, ���������� �����!</div>
    </div><br>
    <div class="radiobtn settings_reason" onclick="deactive.changeReason(3);">
      <div></div>������� ������� ����� ������������ ����������
      <div class="settings_reason_desc">� ����� ���������� ����������� � ���������� �������� � ������ �� ��� �����. ������ � �����.</div>
    </div><br>
    <div class="radiobtn settings_reason" onclick="deactive.changeReason(4);">
      <div></div>���� ��������� ������������ ���� ������
      <div class="settings_reason_desc">������ ������� �������������, ���������� � �������� �������� �� ����� ������� �������. � ����� � ��������.</div>
    </div><br>
    <div class="radiobtn settings_reason" onclick="deactive.changeReason(5);">
      <div></div>��� �������� �� ������������
      <div class="settings_reason_desc">���� �������� ����� ����������. ��� ������ �������� � ���� �����, �� ����� ������.</div>
    </div><br>
    <div class="radiobtn settings_reason" id="settings_reason_last" onclick="deactive.changeReason(6);">
      <div></div>������ �������
    </div><br>
    <textarea id="settings_reason_text" onblur="if(this.value=='') this.value='���� ���������..';this.style.color = '#777';" onfocus="if(this.value=='���� ���������..') this.value='';this.style.color = '#000'" class="text settings_reason_text">���� ���������..</textarea><div class="mgclr"></div>
	<div class="html_checkbox html_checked" id="deact" onclick="myhtml.checkbox(this.id)" style="margin-bottom:8px">���������� �������<div id="checknox_deact"><input type="hidden" id="deact"></div></div><div class="mgclr"></div><br>
	<div class="button_div fl_l"><button id="deact_page" onClick="deactive.Go(); return false">������� ��������</button></div>
  </div>


</div>