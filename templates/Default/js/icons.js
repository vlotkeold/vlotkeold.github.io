
var im_chat = {
	chatOpen:function(){
		if($('#im_chat_block').is('.im_chat_block')){
			$('#im_chat_block').show();
		}else{
			$.post('/index.php?go=im_chat',function(s){
				$('body').append(s);
			});
		}
		$('#ims').attr('onClick', 'im_chat.close();');
	},
	close:function(){
		$('#im_chat_block').hide();
		$('#ims').attr('onClick', 'im_chat.chatOpen();');
	},
	opens:function(uid,s,on){
		if($('#im_chats'+uid).is('.im_chats')){
			$('#im_chats'+uid).show();
		}else{
			$.post('/index.php?go=im_chat&act=history', {for_user_id: uid}, function(d){
				$('body').append('<div id="sc'+uid+'"><script type="text/javascript">$(document).ready(function(){chat_interval_im = setInterval(\'im_chat.update(\'{for_user_id}\')\', 10000);});</script></div><div id="im_chats'+uid+'" class="fc_tab_wrap" style="width: 252.000075px;"><div class="fc_tab_head clear_fix"><div class="fc_tab_close_wrap fl_r" onclick="im_chat.closes(\''+uid+'\');"><div class="chats_sp fc_tab_close"></div><div></div></div><div id="im_chatName'+uid+'" class="fc_tab_title noselect fl_l" style="max-width: 181px;" onclick="im_chat.hideShow(\''+uid+'\');">'+s+'</div></div> <div class="'+on+' fl_l" style="margin-top:12px"></div><div class="clear"></div><div id="imViewMsg'+uid+'">'+d+'</div></div>');
				$('.im_scroll'+uid).scrollTop(99999);
				var aco = $('.im_usactive').text().split(' ');
				$('#msg_text'+uid).focus();
			});
		}
	},
	search:function(){
		var name = $('#im_chatSearch').val();
		if(name.length == 0){
			$('.im_chatserch').hide();
			$('.im_chatbody2').hide();
			$('.im_chatbody').show();
		}else{
			$.post('/index.php?go=im_chat&act=search',{name:name},function(d){
				$('.im_chatserch').show().html(d);
				$('.im_chatbody').hide();
				$('.im_chatbody2').hide();
			});
		}
	},
	mail:function(){
		$.post('/index.php?go=im_chat&act=all',function(d){
			row = d.split('||');
			$('.im_chatbody2').html(row[0]).show();
			$('.im_chathead2').html(row[1]).show();
			$('.im_chatbody').hide();
			$('.im_chathead').hide();
			$('.fc_clist_online_wrap').attr('onClick', 'im_chat.fr();');
			$('#im_chatSearch').attr('onKeyDown', 'im_chat.serch();');
			$('.fc_clist_online_wrap').attr('onMouseOver', 'myhtml.title(\'\', \'Показать только друзей\', \'fc_clist_online_active\')');
		});
	},
	fr:function(){
		$('.im_chatbody').show();
		$('.im_chathead').show();
		$('.im_chatbody2').hide();
		$('.im_chathead2').hide();
		$('.fc_clist_online_wrap').attr('onClick', 'im_chat.ml();');
		$('#im_chatSearch').attr('onKeyDown', 'im_chat.search();');
		$('.fc_clist_online_wrap').attr('onMouseOver', 'myhtml.title(\'\', \'Показать только диалоги\', \'fc_clist_online_active\')');
	},
	ml:function(){
		$('.im_chatbody2').show();
		$('.im_chathead2').show();
		$('.im_chatbody').hide();
		$('.im_chathead').hide();
		$('#im_chatSearch').attr('onKeyDown', 'im_chat.serch();');
		$('.fc_clist_online_wrap').attr('onClick', 'im_chat.fr();');
	$('.fc_clist_online_wrap').attr('onMouseOver', 'myhtml.title(\'\', \'Показать только друзей\', \'fc_clist_online_active\')');
	},
	closes:function(id){
		$('#im_chats'+id).hide();
	},
	updateDialogs: function(){
		$.post('/index.php?go=im_chat&act=upDialogs', function(d){
			$('#updateDialogs').html(d);
		});
	},
	update: function(id){
		var for_user_id = $('#for_user_id'+id).val();
		var last_id = $('.im_msg:last').attr('id').replace('imMsg', '');
		$.post('/index.php?go=im_chat&act=update', {for_user_id: for_user_id, last_id: last_id}, function(d){
			if(d != 'no_new'){
				$('#im_scroll'+for_user_id).html(d);
				$('.im_scroll'+for_user_id).scrollTop(99999);
			}
		});
	},
	read: function(msg_id, auth_id, my_id){
		if(auth_id != my_id){
			var msg_num = parseInt($('#new_msg').text().replace(')', '').replace('(', ''))-1;
			$.post('/index.php?go=im_chat&act=read', {msg_id: msg_id}, function(){
				if(msg_num > 0)
					$('#new_msg').html("+"+msg_num);
				else
					$('#new_msg').html('');
				
				updateNum('#msg_num'+auth_id);
				if($('#msg_num'+auth_id).text() <= 0)
					$('#msg_num'+auth_id).hide();
				$('#imMsg'+msg_id).css('background', '#fff').attr('onMouseOver', '');
			});
		}
	},
	send: function(for_user_id, my_name, my_ava){
		var msg_text = $('#msg_text'+for_user_id).val();
		if(msg_text != 0 ){
			$.post('/index.php?go=im_chat&act=send', {for_user_id: for_user_id, my_name: my_name, my_ava: my_ava, msg: msg_text}, function(data){
				if(data == 'err_privacy')
					Box.Info('msg_info', lang_pr_no_title, lang_pr_no_msg, 400, 4000);
				else {
					$('#im_scroll'+for_user_id).append(data);
					$('.im_scroll'+for_user_id).scrollTop(99999);
					$('#msg_text'+for_user_id).val('');
					$('#msg_text'+for_user_id).focus();	
				}
			});
		} else{
		setErrorInputMsg('msg_text');
		}
	},
	hideShow:function(id){
		if($('#imViewMsg'+id).is('.no_display')){
			$('#imViewMsg'+id).removeClass('no_display');
			$('#im_chats'+id).css({'padding':'0 8px 8px','height':'344px'});
		}else{
			$('#imViewMsg'+id).addClass('no_display');
			$('#im_chats'+id).css({'padding':'0 8px','height':'30px'});
		}
	},
	page: function(for_user_id){
		var first_id = $('.im_msg:first').attr('id').replace('imMsg', '');
		$('#wall_all_records'+for_user_id).attr('onClick', '');
		if($('#load_wall_all_records'+for_user_id).text() == 'Показать предыдущие сообщения'){
			textLoad('load_wall_all_records');
			$.post('/index.php?go=im_chat&act=history', {first_id: first_id, for_user_id: for_user_id}, function(data){
				i++;
				var imHeiah = $('.im_scroll').height();
				$('#prevMsg'+for_user_id).html(data);
				$('.im_scroll').scrollTop($('#appMsgFScroll'+i).show().height()+imHeiah);
				if(!data){
					$('#wall_all_records'+for_user_id).hide();
				} else {
					$('#wall_all_records'+for_user_id).attr('onClick', 'im_chat.page('+for_user_id+')');
					$('#load_wall_all_records'+for_user_id).html('Показать предыдущие сообщения');
				}
			});
		}
	},
}