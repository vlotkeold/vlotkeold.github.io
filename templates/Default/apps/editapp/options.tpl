<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
  <a href="/editapp/info_{id}" onClick="Page.Go(this.href); return false;"><div>����������</div></a>
  <div class="buttonsprofileSec2"><a href="/editapp/options_{id}" onClick="Page.Go(this.href); return false;"><div>���������</div></a></div>
  <a href="/editapp/payments_{id}" onClick="Page.Go(this.href); return false;"><div>�������</div></a>
  <a href="/editapp/admins_{id}" onClick="Page.Go(this.href); return false;"><div>��������������</div></a>
 </div>
</div>
<div class="settings_general" style="height:400px">

<div id="app_edit_error_wrap">

<div id="app_edit_error"></div>

</div>

<div id="apps_options_saved" class="apps_edit_success"></div>

<div class="texta_profileedit">ID ����������:</div>
   <b>{id}</b>

<input type="hidden" id="app_id" value="{id}">

<input type="hidden" id="app_hash" value="{hash}">

  <div class="mgclr"></div>

  <div class="texta_profileedit">���������� ����:</div>
   <input type="text" class="inpst" id="app_secret2"  style="width:256px;" value="{secret}" />
  <div class="mgclr"></div>
 

<div class="texta_profileedit">���������:</div>



<select name="status" id="status"  class="inpst" style="width:256px;">{option}</select>


<div class="apps_edit_header">��������� ����������</div>

<div class="texta_profileedit">��� ����������:</div>



<select id="type" name="type" class="inpst" onchange="AppsEdit.type()">{type} </select>


<div id="apps_edit_iframe_options" style="display: {siframe};">
<div class="texta_profileedit">����� IFrame:</div>
   <input type="text" class="inpst" id="app_iframe_url"  style="width:256px;" value="{url}" />
  <div class="mgclr"></div>

<div class="texta_profileedit">������ IFrame:</div>


<input type="text" class="inpst" id="app_iframe_width"  style="width:50px;" value="{width}" />
 <span class="apps_edit_iframe_res">x</span>
<input type="text" class="inpst" id="app_iframe_height"  style="width:50px;" value="{height}" />
<div class="texta_profileedit">&nbsp;</div>
</div>


<div id="apps_edit_flash_options" style="display: {sflash};">

<div class="apps_edit_header">�������� SWF-����������</div>



<a onclick="AppsEdit.updateSWF({id});" class="cursor_pointer">��������� ����������</a>


<div class="texta_profileedit">&nbsp;</div>
</div>







<div class="button_blue fl_l">
<div class="texta_profileedit"></div>
<button id="app_save_btn" onclick="AppsEdit.SaveOptions('save_options',{id});">��������� ���������</button>
</div>

<div style="margin-top:100px">
<div class="clear" style="margin: 10px 0;color: #2B587A;font-weight: bold;font-size: 14px;">�������� ����������</div>
<div class="clear" style="margin:10px 0;">���� �� ������� ��� ����������, �� ��� �� ������� ��� ������������.</div>

<div class="button_blue fl_l">

<button id="app_save_btn" onclick="AppsEdit.DeleteApp({id});">������� ����������</button>

</div>
</div>
</div>