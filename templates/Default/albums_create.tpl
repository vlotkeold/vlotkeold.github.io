<script type="text/javascript" src="{theme}/js/albums.create.js"></script>
<div class="videos_pad">
 <div class="videos_text">��������</div>
 <input type="text" class="videos_input" id="name" maxlength="100" style="width:375px;" />
 <div class="videos_text">��������</div>
 <textarea class="videos_input" id="descr" style="width:375px;height:70px"></textarea>
<div class="clear"></div>
<div class="fl_l" style="padding:3px">��� ����� ������������� ���� ������?</div>
<div class="sett_privacy" onClick="settings.privacyOpen('privacy')" id="privacy_lnk_privacy">��� ������������</div>
<div class="sett_openmenu no_display" id="privacyMenu_privacy" style="margin-top:-1px;margin-left:207px">
 <div id="selected_p_privacy_lnk_privacy" class="sett_selected" onClick="settings.privacyClose('privacy')">��� ������������</div>
 <div class="sett_hover" onClick="settings.setPrivacy('privacy', '��� ������������', '1', 'privacy_lnk_privacy')">��� ������������</div>
 <div class="sett_hover" onClick="settings.setPrivacy('privacy', '������ ������', '2', 'privacy_lnk_privacy')">������ ������</div>
 <div class="sett_hover" onClick="settings.setPrivacy('privacy', '������ �', '3', 'privacy_lnk_privacy')">������ �</div>
</div>
<input type="hidden" id="privacy" value="1" />
<div class="clear"></div>
<div class="fl_l" style="padding:3px">��� ����� �������������� ����������?</div>
<div class="sett_privacy" onClick="settings.privacyOpen('privacy_comment')" id="privacy_lnk_privacy_comment">��� ������������</div>
<div class="sett_openmenu no_display" id="privacyMenu_privacy_comment" style="margin-top:-1px;margin-left:215px">
 <div id="selected_p_privacy_lnk_privacy_comment" class="sett_selected" onClick="settings.privacyClose('privacy_comment')">��� ������������</div>
 <div class="sett_hover" onClick="settings.setPrivacy('privacy_comment', '��� ������������', '1', 'privacy_lnk_privacy_comment')">��� ������������</div>
 <div class="sett_hover" onClick="settings.setPrivacy('privacy_comment', '������ ������', '2', 'privacy_lnk_privacy_comment')">������ ������</div>
 <div class="sett_hover" onClick="settings.setPrivacy('privacy_comment', '������ �', '3', 'privacy_lnk_privacy_comment')">������ �</div>
</div>
<input type="hidden" id="privacy_comment" value="{privacy-comment}" />
</div>
<br />
<div class="clear"></div>