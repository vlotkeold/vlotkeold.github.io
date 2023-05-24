<link href="/templates/Default/im_chat/im_chat.css" type="text/css" rel="stylesheet">

<script type="text/javascript" src="/templates/Default/js/icons.js"></script>
<script type="text/javascript">
$( init );
function init() {
  $('#im_chat_block');
}
</script>
<style>
::-webkit-scrollbar{
    width:6px;
	cursor: pointer;
}

::-webkit-scrollbar:hover{
    width:8px;
	cursor: pointer;
}

::-webkit-scrollbar-thumb{
    border-width:1px 1px 1px 2px;
border-radius:10px;
    border-color: #777;
    background-color: #dae1e8;
	cursor: pointer;
}

::-webkit-scrollbar-thumb:hover{
    border-width: 1px 1px 1px 2px;
    border-color: #555;
    background-color: #bec8d3;
	cursor: pointer;
}

::-webkit-scrollbar-track{
    border-width:0;
	cursor: pointer;
}

::-webkit-scrollbar-track:hover{
    background-color: #f6f6fa;
	cursor: pointer;
}
</style>
<div id="im_chat_block" class="im_chat_block rb_box_wrap fixed fc_fixed fc_tobottom rb_active" style="bottom: 0px; right: 68px; margin-right: 0px; display: block; z-index: 1101; top: auto; left: auto;">
<script type="text/javascript">
$(document).ready(function(){
	vii_interval = setInterval('im_chat.updateDialogs()', 2000);
});
</script>
<div id="fc_clist" class="fc_tab_wrap" style="width: 252px;">
<div class="fc_tab_head"><a class="fc_tab_close_wrap fl_r"><div class="chats_sp fc_tab_close" onclick="im_chat.close();"></div></a>
<div class="fc_tab_title noselect">{count-fr}</div></div>
<div><div class="fc_ctab fc_ctab_active"><div class="fc_contacts_wrap">
</div><div class="fc_clist_filter_wrap" onclick="elfocus('fc_clist_filter');">
<span id="updateDialogs"></span>
<div id="dialog" class="fc_contacts" style="height: 316px; overflow-y: auto;overflow-x: hidden;">
{dialogs}
</div>
<div class="fc_clist_filter">
</div></div></div></div></div>
<div class="fc_pointer_offset" style="bottom: 28px;"><div class="chats_sp fc_tab_pointer" style="margin-top: 0px;"></div></div></div></div>