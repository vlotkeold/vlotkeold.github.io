<style>.content{width:633px}</style>
<link media="screen" href="{theme}/style/ads.css" type="text/css" rel="stylesheet" />  
<div id="ads_{id}">

<div id="ads_sb">

<div class="ads_head">

<span id="edit_res_{id}" class="ads_title">

<a href="{links}" onClick="Page.Go(this.href); return false" id="settings_save_{id}">{settings}</a>

<div class="ads_set_hover fl_r" onClick="ads.edit_form('{id}')">������������� ����������</div><br />

</span>

<span id="edit_res_show_{id}" class="ads_title_editor" style="display:none;">�������� ��������� ����������</span>

</div>

<div id="image_view_{id}" class="ads_img_top">

<a href="{links}" target="_blank"><img src="{link}" /></a>

</div>

<div id="edit_info_{id}" class="ads_continfo">

<div class="ads_info"><b>��������:&nbsp;</b>&nbsp;{settings}</div>

<div class="ads_info"><b>���������:</b>&nbsp;<span id="category_save_{id}">{category}</span></div>

<div class="ads_info"><b>��������:</b>&nbsp;<span id="description_save_{id}">{description}</span></div>

<div class="ads_info"><b>�������� ����������:&nbsp;</b>&nbsp;{views}</div>

</div>

<div class="clear"></div>

<div id="edit_con_{id}" class="ads_edit_container no_display">

<div class="ads_info"><b>��������:&nbsp;</b></div>

<input type="text" class="videos_input" style="width:335px;" value="{settings}" id="settings_{id}" maxlength="50" size="50" />

<div class="ads_info"><b>������ �� �����������:&nbsp;</b></div>

<input type="text" class="videos_input" style="width:335px;"  value="{link}" id="link_{id}" />

<div class="ads_info"><b>������ �� ������:&nbsp;</b></div>

<input type="text" class="videos_input" style="width:335px;"  value="{links}" id="links_{id}" />

<br />

<div id="category_load_{id}" class="ads_info"><b>���������:&nbsp;</b>&nbsp;{category}</div>

<select id="category_{id}" class="inpst" style="width:250px"> 

<option value="0">�����</option> 

<option value="1">�����, �������</option> 

<option value="2">����������� � �������</option>

<option value="3">����, ������</option>

<option value="4">������ � ������������</option>

<option value="5">�������� � �����</option>

<option value="6">������������� � ������</option>

<option value="7">��������� ��������</option>

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

<div class="ads_info"><b>��������:&nbsp;</b></div>

<textarea type="text" class="videos_input" id="description_{id}" style="width:335px;"  maxlength="100" size="100">{description}</textarea>

<div class="clear" style="line-height:14px">

<div class="button_div fl_l"><button onClick="ads.edit_save('{id}')">���������</button></div>

<div class="button_div_gray margin_left_off" id="editClose"><button onClick="ads.edit_close('{id}')">������</button></div>

<div class="button_div_gray margin_left_delet"><button onclick="ads.delete_ads('{id}');">������� ���������</button></div>

</div>

<div class="clear"></div>

</div>

<div class="ads_err_yellow no_display" id="result_{id}"></div> 

</div>

</div>