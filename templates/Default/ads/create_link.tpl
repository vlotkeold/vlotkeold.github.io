<link media="screen" href="{theme}/style/ads_create.css" type="text/css" rel="stylesheet" />  
<div class="err_yellow no_display" id="result"></div> 

<div class="page_bg border_radius_5 margin_top_10"> 

<div class="texta" style="width:180px">��������:</div> 

<select id="category" class="inpst" style="width:250px"> 

<option value="0">�����</option> 

<option value="1">�����, �������</option> 

<option value="2">����������� � �������</option>

<option value="3">����, ������</option>

<option value="4">������ � ������������</option>

<option value="5">�������� � �����</option>

<option value="6">������������� � ������</option>

<option value="8">������, �����, ����������</option>

<option value="9">������������</option>

<option value="10">������, ���������</option>

<option value="11">������, ��������</option>

<option value="12">������������ �������</option>

<option value="13">�����, ��������, �������</option>

<option value="14">����</option>

<option value="15">�����</option>

<option value="16">���� � ����</option>

</select> 

<div class="mgclr"></div> 

<div class="texta" style="width:180px">���������:</div> 

<input type="text" id="title" class="inpst ads_inp" style="width:239px" /> 

<div class="mgclr"></div>

<div class="texta" style="width:180px">��������:</div> 

<input type="text" class="adsinpst" id="description" style="width:239px;padding-left:5px;padding-bottom:41px;" maxlength="25"/>
<div class="" style="color:#777;font-size:8px;margin-left: 185px">����� 25 ��������</div>
<div class="mgclr"></div>  

<div class="texta" style="width:180px">������ �� ����:</div> 

<input type="text" id="link_site" class="inpst ads_inp" style="width:239px" /> 

<div class="mgclr"></div> 

<div class="texta" style="width:180px">������ �� �����������:</div> 

<input type="text" id="link_photos" class="inpst ads_inp" style="width:239px" /> 

<div class="mgclr"></div> 

<div class="clear margin_top_10" style="margin-top:15px"></div>

<div class="texta" style="width:180px">������� ���������:</div> 

<input type="text" class="inpst ads_inp" id="transitions" style="width:40px" onKeyUp="ads.update()" maxlength="6" /><br /> 

<div class="mgclr"></div> 

<div class="texta" style="width:180px">� ������</div> 

<div style="margin-left:185px"><small><span id="cost_num">0</span> �����</small></div> 

<div class="mgclr"></div>

<div class="texta" style="width:180px">&nbsp;</div> 

<div class="button_blue fl_r"><button onClick="ads.send()" id="sending">��������</button></div> 

<div class="mgclr"></div> 

</div>