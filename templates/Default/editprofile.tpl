<script type="text/javascript" src="{theme}/js/profile_edit.js"></script>
[general]
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <div class="buttonsprofileSec2"><a href="/edit" onClick="Page.Go(this.href); return false;"><div>��������</div></a></div>
 <a href="/edit&act=contact" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=interests" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=education" onClick="Page.Go(this.href); return false;">�����������</a>
 <a href="/edit&act=career" onClick="Page.Go(this.href); return false;">�������</a>
 <a href="/edit&act=military" onClick="Page.Go(this.href); return false;">������</a>
 <a href="/edit&act=personal" onClick="Page.Go(this.href); return false;">��������� �������</a>
</div></div>
<div class="settings_general">
<div class="clear"></div>
<div class="err_yellow" id="info_save" style="display:none;font-weight:normal;"></div>

<div class="texta">���:</div><input type="text" id="name" class="inpst" maxlength="100" value="{name}" style="width:200px;" />
<div class="mgclr"></div>

<div class="texta">�������:</div><input type="text" id="lastname" class="inpst" maxlength="100" value="{lastname}" style="width:200px;" />
<div class="mgclr"></div>

<div class="clear"></div>
<div class="texta">���:</div>
 <div class="padstylej"><select id="sex" class="inpst" onChange="sp.check()" style="width:210px;">
  <option value="0">- �� ������� -</option>
  {sex}
 </select></div>
<div class="mgclr"></div>
<div class="[sp-all]no_display[/sp-all]" id="sp_block"><div class="texta">�������� ���������:</div>
 <div class="padstylej">
 <div class="[user-m]no_display[/user-m]" id="sp_sel_m"><select id="sp" class="inpst" onChange="sp.openfriends()" style="width:210px;">
  <option value="0">- �� ������� -</option>
  <option value="1" [instSelect-sp-1]>�� �����</option>
  <option value="2" [instSelect-sp-2]>���� �������</option>
  <option value="3" [instSelect-sp-3]>��������</option>
  <option value="4" [instSelect-sp-4]>�����</option>
  <option value="5" [instSelect-sp-5]>������</option>
  <option value="6" [instSelect-sp-6]>�� ������</option>
  <option value="7" [instSelect-sp-7]>� �������� ������</option>
 </select></div>
 <div class="[user-w]no_display[/user-w]" id="sp_sel_w"><select id="sp_w" class="inpst" onChange="sp.openfriends()" style="width:220px;">
  <option value="0">- �� ������� -</option>
  <option value="1" [instSelect-sp-1]>�� �������</option>
  <option value="2" [instSelect-sp-2]>���� ����</option>
  <option value="3" [instSelect-sp-3]>���������</option>
  <option value="4" [instSelect-sp-4]>�������</option>
  <option value="5" [instSelect-sp-5]>��������</option>
  <option value="6" [instSelect-sp-6]>�� ������</option>
  <option value="7" [instSelect-sp-7]>� �������� ������</option>
 </select></div>
 </div>
<div class="mgclr"></div></div>
<div class="[sp]no_display[/sp]" id="sp_type">
<div class="texta" id="sp_text">{sp-text}</div>
 <div class="padstylej fl_l"><div style="margin-top:3px;margin-bottom:10px;padding-left:1px;float:left"><a href="/" id="sp_name" onClick="sp.openfriends(); return false">{sp-name}</a></div><img src="{theme}/images/close_a_wall.png" class="sp_del" onClick="sp.del()" /></div>
<div class="mgclr"></div>
<input type="hidden" id="sp_val" />
</div>
<div class="texta">���� ��������:</div>
 <div class="padstylej"><select id="day" class="inpst" style="width:50px;">
  {user-day}
 </select>
 <select id="month" class="inpst">
  {user-month}
 </select>
 <select id="year" class="inpst">
 {user-year}
 </select></div>
<div class="mgclr"></div>
<div id="spx_block"><div class="texta"></div>
  
<select id="spx_w" class="inpst" onChange="sp.opendates()">
  {data-profiles}
 </select><span style="margin-left:10px">�� ���� ��������.</span></div>

<div class="mgclr"></div>

<!--<div class="texta">����:</div><input type="text" id="mother" class="inpst" maxlength="100" value="{mother}" style="width:200px;" />
<div class="mgclr"></div>

<div class="texta">����:</div><input type="text" id="father" class="inpst" maxlength="100" value="{father}" style="width:200px;" />
<div class="mgclr"></div>

<div class="texta">������ �����:</div><input type="text" id="rodgorod" class="inpst" maxlength="100" value="{rodgorod}" style="width:200px;" />
<div class="mgclr"></div>
<div class="texta">�������, �������:</div><input type="text" id="babushkadedushka" class="inpst" maxlength="100" value="{babushkadedushka}" style="width:200px;" />
<div class="mgclr"></div>
<div class="texta">��������:</div><input type="text" id="roditeli" class="inpst" maxlength="100" value="{roditeli}" style="width:200px;" />
<div class="mgclr"></div>
<div class="texta">������, ������:</div><input type="text" id="bratiasestry" class="inpst" maxlength="100" value="{bratiasestry}" style="width:200px;" />
<div class="mgclr"></div>
<div class="texta">����:</div><input type="text" id="deti" class="inpst" maxlength="100" value="{deti}" style="width:200px;" />
<div class="mgclr"></div>
<div class="texta">�����:</div><input type="text" id="vnuki" class="inpst" maxlength="100" value="{vnuki}" style="width:200px;" />
<div class="mgclr"></div>-->
<div class="pedit_controls_separator"></div><br>
<div class="texta">&nbsp;</div><div class="button_blue fl_l"><button id="saveform">���������</button></div><div class="mgclr"></div></div>
[/general]
[contact]
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/edit" onClick="Page.Go(this.href); return false;">��������</a>
 <div class="buttonsprofileSec2"><a href="/edit&act=contact" onClick="Page.Go(this.href); return false;"><div>��������</div></a></div>
 <a href="/edit&act=interests" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=education" onClick="Page.Go(this.href); return false;">�����������</a>
 <a href="/edit&act=career" onClick="Page.Go(this.href); return false;">�������</a>
 <a href="/edit&act=military" onClick="Page.Go(this.href); return false;">������</a>
 <a href="/edit&act=personal" onClick="Page.Go(this.href); return false;">��������� �������</a>
</div></div>
<div class="settings_general">
<div class="clear"></div>
<div class="err_yellow" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="clear"></div>
<div class="texta">������:</div>
 <div class="padstylej"><select id="country" style="width:210px;" class="inpst" onChange="Profile.LoadCity(this.value); return false;">
  <option value="0">- �� ������� -</option>
  {country}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div>

<span id="city"><div class="texta">�����:</div>
 <div class="padstylej"><select id="select_city" style="width:210px;" class="inpst">
  <option value="0">- �� ������� -</option>
  {city}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div></span>

<div class="texta">�����:</div><input type="text" id="rai" class="inpst" maxlength="100" value="{rai}" style="width:200px;" />
<div class="mgclr"></div>

<div class="texta">������� �����:</div><input type="text" id="metro" class="inpst" maxlength="100" value="{metro}" style="width:200px;" />
<div class="mgclr"></div>

<div class="texta">�����:</div><input type="text" id="ulica" class="inpst" maxlength="100" value="{ulica}" style="width:200px;" />
<div class="mgclr"></div>

<div class="texta">����� ����:</div><input type="text" id="nazvanie" class="inpst" maxlength="100" value="{nazvanie}" style="width:200px;" />
<div class="mgclr"></div>

</br>

<div class="texta">��������� �������:</div><input type="text" id="phonebook" class="inpst" maxlength="50" value="{phonebook}" style="width:200px;" /><span id="validPhonebook"></span><div class="mgclr"></div>
<div class="texta">� ��������:</div><input type="text" id="vk" class="inpst" maxlength="100" value="{vk}" style="width:200px;" /><span id="validVk"></span><div class="mgclr"></div>
<div class="texta">�������������:</div><input type="text" id="od" class="inpst" maxlength="100" value="{od}" style="width:200px;" /><span id="validOd"></span><div class="mgclr"></div>
<div class="texta">FaceBook:</div><input type="text" id="fb" class="inpst" maxlength="100" value="{fb}" style="width:200px;" /><span id="validFb"></span><div class="mgclr"></div>
<div class="texta">Skype:</div><input type="text" id="skype" class="inpst" maxlength="100" value="{skype}" style="width:200px;" /><span id="validSkype"></span><div class="mgclr"></div>
<div class="texta">ICQ:</div><input type="text" id="icq" class="inpst" maxlength="9" value="{icq}" style="width:200px;" /><span id="validIcq"></span><div class="mgclr"></div>
<div class="texta">������ ����:</div><input type="text" id="site" class="inpst" maxlength="100" value="{site}" style="width:200px;" /><span id="validSite"></span><div class="mgclr"></div>
<div class="pedit_controls_separator"></div><br>
<div class="texta">&nbsp;</div><div class="button_blue fl_l"><button name="save" id="saveform_contact">���������</button></div><div class="mgclr"></div>
</div>
[/contact]
[interests]
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/edit" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=contact" onClick="Page.Go(this.href); return false;">��������</a>
 <div class="buttonsprofileSec2"><a href="/edit&act=interests" onClick="Page.Go(this.href); return false;"><div>��������</div></a></div>
 <a href="/edit&act=education" onClick="Page.Go(this.href); return false;">�����������</a>
 <a href="/edit&act=career" onClick="Page.Go(this.href); return false;">�������</a>
 <a href="/edit&act=military" onClick="Page.Go(this.href); return false;">������</a>
 <a href="/edit&act=personal" onClick="Page.Go(this.href); return false;">��������� �������</a>
</div></div>
<div class="settings_general">
<div class="clear"></div>
<div class="err_yellow" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="clear"></div>
<div class="texta">������������:</div><textarea id="activity" class="inpst" style="width:300px;height:50px;overflow:hidden;">{activity}</textarea><div class="mgclr"></div>
<div class="texta">��������:</div><textarea id="interests" class="inpst" style="width:300px;height:50px;">{interests}</textarea><div class="mgclr"></div>
<div class="texta">������� ������:</div><textarea id="music" class="inpst" style="width:300px;height:50px;">{music}</textarea><div class="mgclr"></div>
<div class="texta">������� ������:</div><textarea id="kino" class="inpst" style="width:300px;height:50px;">{kino}</textarea><div class="mgclr"></div>
<div class="texta">������� �����:</div><textarea id="books" class="inpst" style="width:300px;height:50px;">{books}</textarea><div class="mgclr"></div>
<div class="texta">������� ����:</div><textarea id="games" class="inpst" style="width:300px;height:50px;">{games}</textarea><div class="mgclr"></div>
<div class="texta">������� ������:</div><textarea id="quote" class="inpst" style="width:300px;height:50px;">{quote}</textarea><div class="mgclr"></div>
<div class="texta">� ����:</div><textarea id="myinfo" class="inpst" style="width:300px;height:50px;">{myinfo}</textarea><div class="mgclr"></div>
<div class="pedit_controls_separator"></div><br>
<div class="texta">&nbsp;</div><div class="button_blue fl_l"><button name="save" id="saveform_interests">���������</button></div><div class="mgclr"></div>
</div>
[/interests]

[education]
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/edit" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=contact" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=interests" onClick="Page.Go(this.href); return false;">��������</a>
 <div class="buttonsprofileSec2"><a href="/edit&act=education" onClick="Page.Go(this.href); return false;"><div>�����������</div></a></div>
 <a href="/edit&act=career" onClick="Page.Go(this.href); return false;">�������</a>
 <a href="/edit&act=military" onClick="Page.Go(this.href); return false;">������</a>
 <a href="/edit&act=personal" onClick="Page.Go(this.href); return false;">��������� �������</a>
</div></div>
<div class="search_form_tab" style="margin-top:12px;height:20px">
<div class="clear"></div>
<div class="clear"></div>
<div class="buttonsprofile buttonsprofileSecond" style="margin-top:-1px;margin-left:-150px">
<div class="texta"></div><div class="buttonsprofileSec"><a href="/edit&act=education" onClick="Page.Go(this.href); return false;"><div><b>������� �����������</b></div></a></div>
<a href="/edit&act=higher_education" onClick="Page.Go(this.href); return false;"><b>������ �����������</b></a>
</div></div>
<div class="summary_wrap">
  <div id="summary" class="summary" style="padding-left:13px;margin-left:-15px">����� �� ������ ������� ������� ���������, � ������� �� ������� ��� �������.</div>
</div>
<div style="margin-top:-12px"></div>
<div class="settings_general">
<div class="err_yellow" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="header" style="margin-left:200px">������� �����������</div>
<div style="margin-top:10px"></div>
<div class="texta3">������:</div>
 <div class="padstylej"><select id="country" style="width:210px;" class="inpst" onChange="Profile.LoadCity(this.value); return false;">
  <option value="0">- �� ������� -</option>
  {country}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div>

<span id="city"><div class="texta3">�����:</div>
 <div class="padstylej"><select id="select_city" style="width:210px;" class="inpst">
  <option value="0">- �� ������� -</option>
  {city}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div></span>

<div class="texta3">�����:</div><input type="text" id="shkola" class="inpst" maxlength="100" value="{shkola}" style="width:200px;" />
<div class="mgclr"></div>

<div class="texta3">��� ������ ��������:</div>
 <div class="padstylej"><select id="nacalosr" class="inpst" onChange="sp.check()" style="width:210px;" >
  <option value="0">- �� ������� -</option>
  {nacalosr}
 </select></div>
<div class="mgclr"></div>

<div class="texta3">��� ��������� ��������:</div>
 <div class="padstylej"><select id="konecsr" class="inpst" onChange="sp.check()" style="width:210px;" >
  <option value="0">- �� ������� -</option>
  {konecsr}
 </select></div>
<div class="mgclr"></div>

<div class="texta3">���� �������:</div>
 <div class="padstylej"><select id="datasr" class="inpst" onChange="sp.check()" style="width:210px;" >
  <option value="0">- �� ������� -</option>
  {datasr}
 </select></div>
<div class="mgclr"></div>

<div class="texta3">�����:</div>
 <div class="padstylej"><select id="klass" class="inpst" onChange="sp.check()" style="width:210px;" >
  <option value="0">- �� ������� -</option>
  {klass}
 </select></div>
<div class="mgclr"></div>

<div class="texta3">�������������:</div><input type="text" id="spec" class="inpst" maxlength="100" value="{spec}" style="width:200px;" />
<div class="mgclr"></div>
<div class="pedit_controls_separator"></div><br>
<div class="texta3">&nbsp;</div><div class="button_blue fl_l"><button name="save" id="saveform_education">���������</button></div><div class="mgclr"></div>
</div>
[/education]

[higher_education]
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/edit" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=contact" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=interests" onClick="Page.Go(this.href); return false;">��������</a>
 <div class="buttonsprofileSec2"><a href="/edit&act=education" onClick="Page.Go(this.href); return false;"><div>�����������</div></a></div>
 <a href="/edit&act=career" onClick="Page.Go(this.href); return false;">�������</a>
 <a href="/edit&act=military" onClick="Page.Go(this.href); return false;">������</a>
 <a href="/edit&act=personal" onClick="Page.Go(this.href); return false;">��������� �������</a>
</div></div>
<div class="search_form_tab" style="margin-top:12px;height:20px">
<div class="buttonsprofile buttonsprofileSecond" style="margin-top:-1px;margin-left:-150px">
<div class="texta"></div><a href="/edit&act=education" onClick="Page.Go(this.href); return false;"><div><b>������� �����������</b></div></a>
<div class="buttonsprofileSec"><a href="/edit&act=higher_education" onClick="Page.Go(this.href); return false;"><b>������ �����������</b></a></div>
</div></div>
<div class="summary_wrap">
  <div id="summary" class="summary" style="padding-left:13px;margin-left:-15px">����� �� ������ ������� �������� � �������������� ������ �����������.</div>
</div>
<div style="margin-top:-12px"></div>
<div class="settings_general">
<div class="err_yellow" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="header" style="margin-left:200px">������ �����������</div>
<div class="settings_general">
<div style="margin-top:-12px;"></div>
<div class="texta3">������:</div>
 <div class="padstylej"><select id="country" style="width:210px;" class="inpst" onChange="Profile.LoadCity(this.value); return false;">
  <option value="0">- �� ������� -</option>
  {country}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div>

<span id="city"><div class="texta3">�����:</div>
 <div class="padstylej"><select id="select_city" style="width:210px;" class="inpst">
  <option value="0">- �� ������� -</option>
  {city}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div></span>

<div class="texta3">���:</div><input type="text" id="vuz" class="inpst" maxlength="100" value="{vuz}" style="width:200px;" />
<div class="mgclr"></div>

<div class="texta3">���������:</div><input type="text" id="fac" class="inpst" maxlength="100" value="{fac}" style="width:200px;" />
<div class="mgclr"></div>

<div class="texta3">����� ��������:</div>
 <div class="padstylej"><select id="form" class="inpst" onChange="sp.check()" style="width:210px;" >
  <option value="0">- �� ������� -</option>
  {form}
 </select></div>
<div class="mgclr"></div>

<div class="texta3">������:</div>
 <div class="padstylej"><select id="statusvi" class="inpst" onChange="sp.check()" style="width:210px;" >
  <option value="0">- �� ������� -</option>
  {statusvi}
 </select></div>
<div class="mgclr"></div>

<div class="texta3">���� �������:</div>
 <div class="padstylej"><select id="datavi" class="inpst" onChange="sp.check()" style="width:210px;" >
  <option value="0">- �� ������� -</option>
  {datavi}
 </select></div>
<div class="pedit_controls_separator" style="margin-left:-53px"></div><br>
<div class="texta3">&nbsp;</div><div class="button_blue fl_l"><button name="save" id="saveform_higher_education">���������</button></div><div class="mgclr"></div></div></div>

[/higher_education]

[career]
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/edit" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=contact" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=interests" onClick="Page.Go(this.href); return false;">��������</a>
  <a href="/edit&act=education" onClick="Page.Go(this.href); return false;">�����������</a>
 <div class="buttonsprofileSec2"><a href="/edit&act=career" onClick="Page.Go(this.href); return false;"><div>�������</div></a> </div>
 <a href="/edit&act=military" onClick="Page.Go(this.href); return false;">������</a>
 <a href="/edit&act=personal" onClick="Page.Go(this.href); return false;">��������� �������</a>
</div></div>
<div class="settings_general">
<div class="clear"></div>
<div class="err_yellow" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="clear"></div>
<div class="header" style="margin-left:200px">�������</div>
</br>
<div class="texta3">������:</div>
 <div class="padstylej"><select id="country" style="width:210px;" class="inpst" onChange="Profile.LoadCity(this.value); return false;">
  <option value="0">- �� ������� -</option>
  {country}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div>

<span id="city"><div class="texta3">�����:</div>
 <div class="padstylej"><select id="select_city" style="width:210px;" class="inpst">
  <option value="0">- �� ������� -</option>
  {city}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div></span>

<div class="texta3">����� ������:</div><input type="text" id="mesto" class="inpst" maxlength="100" value="{mesto}" style="width:200px;" />
<div class="mgclr"></div>

<div class="texta3">��� ������ ������:</div>
 <div class="padstylej"><select id="nacaloca" class="inpst" onChange="sp.check()" style="width:210px;" >
  <option value="0">- �� ������� -</option>
  {nacaloca}
 </select></div>
<div class="mgclr"></div>

<div class="texta3">��� ��������� ������:</div>
 <div class="padstylej"><select id="konecca" class="inpst" onChange="sp.check()" style="width:210px;" >
  <option value="0">- �� ������� -</option>
  {konecca}
 </select></div>
<div class="mgclr"></div>

<div class="texta3">���������:</div><input type="text" id="dolj" class="inpst" maxlength="100" value="{dolj}" style="width:200px;" />
<div class="mgclr"></div>
<div class="pedit_controls_separator"></div><br>
<div class="texta3">&nbsp;</div><div class="button_blue fl_l"><button name="save" id="saveform_career">���������</button></div><div class="mgclr"></div>
</div>
[/career]

[military]
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/edit" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=contact" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=interests" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=education" onClick="Page.Go(this.href); return false;">�����������</a>
 <a href="/edit&act=career" onClick="Page.Go(this.href); return false;">�������</a>
 <div class="buttonsprofileSec2"><a href="/edit&act=military" onClick="Page.Go(this.href); return false;"><div>������</div></a></div>
 <a href="/edit&act=personal" onClick="Page.Go(this.href); return false;">��������� �������</a>
</div></div>
<div class="settings_general">
<div class="clear"></div>
<div class="err_yellow" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="clear"></div>
<div class="header" style="margin-left:200px">������� ������</div>
</br>
<div class="texta3">������:</div>
 <div class="padstylej"><select id="country" style="width:210px;" class="inpst" onChange="Profile.LoadCity(this.value); return false;">
  <option value="0">- �� ������� -</option>
  {country}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div>

<span id="city"><div class="texta3">�����:</div>
 <div class="padstylej"><select id="select_city" style="width:210px;" class="inpst">
  <option value="0">- �� ������� -</option>
  {city}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div></span>

<div class="texta3">��������� �����:</div><input type="text" id="chast" class="inpst" maxlength="100" value="{chast}" style="width:200px;" />
<div class="mgclr"></div>

<div class="texta3">�������� ������:</div><input type="text" id="zvanie" class="inpst" maxlength="100" value="{zvanie}" style="width:200px;" />
<div class="mgclr"></div>

<div class="texta3">��� ������ ������:</div>
 <div class="padstylej"><select id="nacalosl" class="inpst" onChange="sp.check()" style="width:210px;" >
  <option value="0">- �� ������� -</option>
  {nacalosl}
 </select></div>
<div class="mgclr"></div>

<div class="texta3">��� ��������� ������:</div>
 <div class="padstylej"><select id="konecsl" class="inpst" onChange="sp.check()" style="width:210px;" >
  <option value="0">- �� ������� -</option>
  {konecsl}
 </select></div>
<div class="mgclr"></div>
<div class="pedit_controls_separator"></div><br>
<div class="texta3">&nbsp;</div><div class="button_blue fl_l"><button name="save" id="saveform_military">���������</button></div><div class="mgclr"></div>
</div>
[/military]

[personal]
<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
 <a href="/edit" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=contact" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=interests" onClick="Page.Go(this.href); return false;">��������</a>
 <a href="/edit&act=education" onClick="Page.Go(this.href); return false;">�����������</a>
 <a href="/edit&act=career" onClick="Page.Go(this.href); return false;">�������</a>
 <a href="/edit&act=military" onClick="Page.Go(this.href); return false;">������</a>
 <div class="buttonsprofileSec2"><a href="/edit&act=personal" onClick="Page.Go(this.href); return false;"><div>��������� �������</div></a></div>
</div></div>
<div class="settings_general">
<div class="clear"></div>
<div class="err_yellow" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="clear"></div>
</br>
<div class="texta3">�����. ������������:</div>
 <div class="padstylej"><select id="pred" class="inpst" onChange="sp.check()" style="width:200px;" >
  <option value="0">- �� ������� -</option>
  {pred}
 </select></div>
<div class="mgclr"></div>

 <div class="texta3">������������:</div>
<input type="text" list="list"  id="miro" value="{miro}" class="inpst" maxlength="100"  style="width:190px;" />
<datalist id="list">
	<option  value="�������" />
	<option  value="�����������" />
	<option  value="����������" />
	<option  value="�������������" />
	<option  value="�����" />
	<option  value="�������" />
	<option  value="�������������" />
	<option  value="�������� ��������" />
</datalist>
<div class="mgclr"></div>


<div class="texta3">������� � �����:</div>
 <div class="padstylej"><select id="jizn" class="inpst" onChange="sp.check()" style="width:200px;" >
  <option value="0">- �� ������� -</option>
  {jizn}
 </select></div>
<div class="mgclr"></div>

<div class="texta3">������� � �����:</div>
 <div class="padstylej"><select id="ludi" class="inpst" onChange="sp.check()" style="width:200px;" >
  <option value="0">- �� ������� -</option>
  {ludi}
 </select></div>
<div class="mgclr"></div>

<div class="texta3">��������� � �������:</div>
 <div class="padstylej"><select id="kurenie" class="inpst" onChange="sp.check()" style="width:200px;" >
  <option value="0">- �� ������� -</option>
  {kurenie}
 </select></div>
<div class="mgclr"></div>

<div class="texta3">��������� � ��������:</div>
 <div class="padstylej"><select id="alkogol" class="inpst" onChange="sp.check()" style="width:200px;" >
  <option value="0">- �� ������� -</option>
  {alkogol}
 </select></div>
<div class="mgclr"></div>

<div class="texta3">��������� � ����������:</div>
 <div class="padstylej"><select id="narkotiki" class="inpst" onChange="sp.check()" style="width:200px;" >
  <option value="0">- �� ������� -</option>
  {narkotiki}
 </select></div>
<div class="mgclr"></div>

<div class="texta3">��������� �����������:</div><input type="text" id="vdox" class="inpst" maxlength="100" value="{vdox}" style="width:190px;" /><div class="mgclr"></div>


<div class="pedit_controls_separator"></div><br>
<div class="texta3">&nbsp;</div><div class="button_blue fl_l"><button id="saveform_personal">���������</button></div><div class="mgclr"></div>
</div>
[/personal]