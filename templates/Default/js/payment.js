 var pEnum = 0;
 var payment = {
  addbox: function(){
    viiBox.start();
	$.post('/index.php?go=balance&act=payment_2', function(d){
	  viiBox.win('payment_2', d);
	});
  },
   metodbox: function(){
    viiBox.start();
	$.post('/index.php?go=balance&act=metodbox', function(d){
	  viiBox.win('metodbox', d);
	});
  },
   mt_invite: function(){
    viiBox.start();
	$.post('/index.php?go=balance&act=metodbox_invite', function(d){
	  viiBox.win('mt_invite', d);
	});
  },
  offers: function(){
    viiBox.start();
	$.post('/index.php?go=balance&act=offers', function(d){
	  viiBox.win('offers', d);
	});
  },
    mt_sms: function(){
    viiBox.start();
 $.post('/index.php?go=balance&act=sms_buy', function(d){
   viiBox.win('mt_sms', d);
 });
  },
   invates: function(){
    viiBox.start();
 $.post('/index.php?go=balance&act=invates', function(d){
   viiBox.win('invates', d);
 });
  },
   mt_emoney: function(){
    viiBox.start();
	$.post('/index.php?go=balance&act=metodbox_emoney', function(d){
	  viiBox.win('mt_invite', d);
	});
  },
  nowork_mb:function(){
   $('#nowork').show();
  },
  save: function(u){
  	var numus = parseInt($('#num_balance').text()) - parseInt($('#payment_num').val());
	var add = $('#payment_num').val();
	var upage = $('#upage').val();
	var cnt = $('#cnt').val();
	var userid = $('#userid').val();
	if(parseInt($('#balance').val()) < parseInt($('#payment_num').val())){
	  setErrorInputMsg('payment_num');
	  return false;
	}
if(add != 0){
	if(parseInt($('#cnt').val()) >= parseInt($('#upage').val())){
	if(upage >= 1){
	if(userid != upage){
	  butloading('saverate', 50, 'disabled', '');
	  $.post('/index.php?go=balance&act=payment_2', {for_user_id: upage, num: add}, function(d){
	  $('#num_balance').text(numus);
		viiBox.clos('payment_2', 1);
		Box.Info('msg_info', 'Передача голосов', 'Голоса успешно переданы.' , 300, 1600);
	  });
	  }
	  else
		Box.Info('msg_info', 'Ошибка', 'Нельзя передавать голоса самому себе.' , 300, 1600);
}
	else
	setErrorInputMsg('upage');
}
	else
	setErrorInputMsg('upage');
}
	else
	setErrorInputMsg('payment_num');

  },
  username:function(){
   $('#num').text('Недостаточно');
  },
  update: function(){
    var add = $('#payment_num').val();
	var new_rate = $('#balance').val() - add;
	var pr = parseInt(add);
	if(!isNaN(pr)) $('#payment_num').val(parseInt(add));
	else $('#payment_num').val('');
	if(add && new_rate >= 0){
	  $('#num').text(new_rate);
	  $('#rt').show();
	} else if(new_rate <= 0 || $('#balance').val() <= 0){
	  $('#num').text('Недостаточно');
	  $('#rt').hide();
	} else {
	  $('#rt').show();
	  $('#num').text($('#balance').val());
	}
  },
   page: function(){
   var page_cnt_ = $('#page_cnt').val();
    if($('#load_history_prev_ubut').text() == 'Показать предыдущие операции'){
	  textLoad('load_history_prev_ubut');
	  $.post('/index.php?go=balance&act=b_history', {page_cnt: page_cnt_}, function(d){
		$('#load_history_prev_ubut').text('Показать предыдущие операции').attr('onClick','payment.page(); return false');
		if(d != 'no_history') $('table#settings_votes_history').find('tbody').append(d);
		$('#page_cnt').val(parseInt(page_cnt_)+1);
		if(d == 'no_history') $('.settings_votes_history_next').detach();
	  })
	}
  }
}
   //Вычесляем юзера по id
	var payments = {
  checkPaymentUser: function(){
	var upage = $('#upage').val();
	var pattern = new RegExp(/^[0-9]+$/);
	if(pattern.test(upage)){
		$.post('/index.php?go=balance&act=checkPaymentUser', {id: upage}, function(d){
		d = d.split('|');
	if(d[0]){
	if(d[1])
		$('#feedimg').attr('src', '/uploads/users/'+upage+'/50_'+d[1]);
	else
		$('#feedimg').attr('src', template_dir+'/images/50_no_ava.png');

	} else {
	  	setErrorInputMsg('upage');
		$('#feedimg').attr('src', template_dir+'/images/contact_info_50.png');
			}
			});
	} else
		$('#feedimg').attr('src', template_dir+'/images/contact_info_50.png');
  }

}