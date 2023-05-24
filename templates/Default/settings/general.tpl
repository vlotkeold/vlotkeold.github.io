<div class="sft" style="margin-top:-6px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond2" style="height:15px">
  <div class="buttonsprofileSec2"><a href="/settings" onClick="Page.Go(this.href); return false;"><div>{translate=setting_general}</div></a></div>
  <a href="/settings&act=privacy" onClick="Page.Go(this.href); return false;"><div>{translate=setting_privacy}</div></a>
  <a href="/settings&act=blacklist" onClick="Page.Go(this.href); return false;"><div>{translate=setting_blacklist}</div></a>
  <a href="/settings&act=mobile" onClick="Page.Go(this.href); return false;"><div>{translate=setting_mobservice}</div></a>
  [stikers]<a href="/settings&act=stikers" onClick="Page.Go(this.href); return false;"><div>Стикеры</div></a>[/stikers]
  <a href="/settings&act=balance" onClick="Page.Go(this.href); return false;"><div>{translate=setting_mybalance}</div></a>
 </div>
</div>
<div class="settings_general">
<div class="settings_section">
<div class="err_yellow name_errors {code-1}" style="font-weight:normal;margin-top:25px">{translate=setting_yesnewemail}</div>
<div class="err_yellow name_errors {code-2}" style="font-weight:normal;margin-top:25px">{translate=setting_yesemail}</div>
<div class="err_yellow name_errors {code-3}" style="font-weight:normal;margin-top:25px">{translate=setting_yesanewemail}</div>
<div class="margin_top_10"></div><div class="allbar_title">{translate=setting_changepass}</div>
<div class="err_red no_display pass_errors" id="err_pass_1" style="font-weight:normal;">{translate=setting_errpass}</div>
<div class="err_red no_display pass_errors" id="err_pass_2" style="font-weight:normal;">{translate=setting_errpass2}</div>
<div class="err_yellow no_display pass_errors" id="ok_pass" style="font-weight:normal;">{translate=setting_yesnewpass}</div>
<div class="texta">{translate=setting_currentpass}:</div><input type="password" id="old_pass" class="inpst" maxlength="100" style="width:150px;" /><span id="validOldpass"></span><div class="mgclr"></div>
<div class="texta">{translate=setting_newpass}:</div><input type="password" id="new_pass" class="inpst" maxlength="100" style="width:150px;" /><span id="validNewpass"></span><div class="mgclr"></div>
<div class="texta">{translate=setting_repeatnewpass}:</div><input type="password" id="new_pass2" class="inpst" maxlength="100" style="width:150px;" /><span id="validNewpass2"></span><div class="mgclr"></div>
<div class="texta">&nbsp;</div><div class="button_blue fl_l"><button onClick="settings.saveNewPwd(); return false" id="saveNewPwd">{translate=setting_changepass}</button></div><div class="mgclr"></div>
<div class="margin_top_10"></div><div class="allbar_title">{translate=setting_youremailadress}</div>
<div class="err_yellow name_errors no_display" id="ok_email" style="font-weight:normal;">{translate=setting_confyesemail}</div>
<div class="err_red no_display name_errors" id="err_email" style="font-weight:normal;">{translate=setting_erroremail}</div>
<div class="texta">{translate=setting_currentemail}:</div><div style="color:#555;margin-top:13px;margin-bottom:10px">{email}</div><div class="mgclr"></div>
<div class="texta">{translate=setting_newemail}:</div><input type="text" id="email" class="inpst" maxlength="100" style="width:150px;" /><span id="validName"></span><div class="mgclr"></div>
<div class="texta">&nbsp;</div><div class="button_blue fl_l"><button onClick="settings.savenewmail(); return false" id="saveNewEmail">{translate=setting_saveemail}</button></div><div class="mgclr"></div>
<div class="margin_top_10"></div><div class="allbar_title">{translate=setting_yourprid}</div>
<div class="err_yellow no_display name_errors" id="ok_alias" style="font-weight:normal;">{translate=setting_yespridnew}</div>
<div class="err_red no_display name_errors" id="err_alias_str" style="font-weight:normal;">{translate=setting_errpridnew}</div>
<div class="err_red no_display name_errors" id="err_alias_name" style="font-weight:normal;">{translate=setting_err2pridnew}</div>
<div class="texta" >{translate=setting_profilelink}: </div><span style="border: 1px solid #C6D4DC;  border-right: 0px;padding: 3px 4px;margin-right: -4px;color: #777;" onclick="settings.elfocus('alias')">http://ivinete.ru/</span><input type="text" id="alias" class="inpst" maxlength="10"  style="width:66px;border-left:0px;" value="{alias}" /><div class="mgclr"></div><div class="texta">&nbsp;</div><div class="button_blue fl_l"><button onClick="settings.savealias(); return false" id="saveAlias">{translate=setting_save}</button></div><div class="mgclr"></div>
<div class="margin_top_10"></div><!--<div class="allbar_title">Безопасность Вашей страницы</div>
<div class="texta">Последняя активность:</div>
<div style="margin:4px 0" class="fl_l" id="acts" onmouseover="myhtml.title('', 'IP последнего посещения {ip}', 'acts')">{log-user}</div>
<div class="margin_top_10"></div>
<div class="margin_top_10"></div>
<div class="mgclr"></div>
<div class="texta">&nbsp;</div>
<a onClick="settings.logs();" style="cursor:pointer">Посмотреть историю активности</a>-->
<div class="mgclr"></div>
<div class="allbar_title">{translate=setting_regionsett}</div>
<div class="texta">{translate=setting_language}:</div><select id="city" class="inpst" style="width:161px"> 
  <option value="0">{lang}</option> </select><div class="mgclr"></div>
</div>
</div>
<br>
<div class="settings_view_as_text clear_fix" align="center">
  {translate=setting_youcan} <a href="/settings&act=deactivate">{translate=setting_delpage}</a>.
</div>