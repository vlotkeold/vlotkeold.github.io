
<script type="text/javascript">
$( init );
function init() {

  $('.im_chats').draggable({
   containment: 'body',
    cursor: 'move',
    snap: 'body'
  
  });
}
</script>
<script type="text/javascript">
$(document).ready(function(){
	chat_interval_im = setInterval('im_chat.update(\'{for_user_id}\')', 10000);
	$('#im_chats{for_user_id}').resizable();
});			
		
</script>
<div class="im_chatform">
<div class="im_chatformava">
 <a href="/id{myuser-id}" onClick="Page.Go(this.href); return false"><img src="{my-ava}" style="border-radius:3px;" width="32" alt="" /></a>
</div>
<textarea 
	class="im_chatforntext" 
	id="msg_text{for_user_id}" 
	placeholder="������� ���� ���������.."
	onKeyUp="im.typograf('{for_user_id}')"
	onKeyPress="if(event.keyCode == 13) im_chat.send('{for_user_id}', '{my-name}', '{my-ava}')"
></textarea>
<div class="clear"></div>
</div>
<input type="hidden" id="status_sending{for_user_id}" value="1" />
<input type="hidden" id="for_user_id{for_user_id}" value="{for_user_id}" />