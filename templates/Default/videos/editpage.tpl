<div class="videos_pad">
 <div class="videos_text">��������</div>
 <input type="text" class="videos_input" id="title" maxlength="65" value="{title}" />
 <div class="videos_text">��������</div>
 <textarea class="videos_input" id="descr" style="height:70px">{descr}</textarea>
 <input type="hidden" id="good_video_lnk" />
<div class="clear"></div>
<div class="fl_l" style="padding:3px">��� ����� �������� ��� �����?</div>
<div class="sett_privacy" onClick="settings.privacyOpen('privacy')" id="privacy_lnk_privacy">{privacy-text}</div>
<div class="sett_openmenu no_display" id="privacyMenu_privacy" style="margin-top:-1px;margin-left:166px">
 <div id="selected_p_privacy_lnk_privacy" class="sett_selected" onClick="settings.privacyClose('privacy')">{privacy-text}</div>
 <div class="sett_hover" onClick="settings.setPrivacy('privacy', '��� ������������', '1', 'privacy_lnk_privacy')">��� ������������</div>
 <div class="sett_hover" onClick="settings.setPrivacy('privacy', '������ ������', '2', 'privacy_lnk_privacy')">������ ������</div>
 <div class="sett_hover" onClick="settings.setPrivacy('privacy', '������ �', '3', 'privacy_lnk_privacy')">������ �</div>
</div>
<input type="hidden" id="privacy" value="{privacy}" />
</div>
<div class="clear"></div>