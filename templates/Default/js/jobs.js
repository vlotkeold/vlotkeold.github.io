var Jobs = {
  web:function(){
	$.post('/index.php?go=job&act=web',function(body){
		$('body').append('<div id="newbox_miniature"><div class="miniature_box"><div class="miniature_pos" style="width: 653px;padding:15px;"><div class="news_title fl_l" style="color: #2B587A;font-weight: bold;">���-�����������</div><a class="cursor_pointer fl_r" onclick="Profile.miniatureClose()">�������</a><div class="clear"></div><br>'+body+'</div></div>');
	});
  },
  sysadmin:function(){
	$.post('/index.php?go=job&act=sysadmin',function(body){
		$('body').append('<div id="newbox_miniature"><div class="miniature_box"><div class="miniature_pos" style="width: 653px;padding:15px;"><div class="news_title fl_l" style="color: #2B587A;font-weight: bold;">��������� �������������</div><a class="cursor_pointer fl_r" onclick="Profile.miniatureClose()">�������</a><div class="clear"></div><br>'+body+'</div></div>');
	});
  },
  ios:function(){
	$.post('/index.php?go=job&act=ios',function(body){
		$('body').append('<div id="newbox_miniature"><div class="miniature_box"><div class="miniature_pos" style="width: 653px;padding:15px;"><div class="news_title fl_l" style="color: #2B587A;font-weight: bold;">iOS-�����������</div><a class="cursor_pointer fl_r" onclick="Profile.miniatureClose()">�������</a><div class="clear"></div><br>'+body+'</div></div>');
	});
  },
  android:function(){
	$.post('/index.php?go=job&act=android',function(body){
		$('body').append('<div id="newbox_miniature"><div class="miniature_box"><div class="miniature_pos" style="width: 653px;padding:15px;"><div class="news_title fl_l" style="color: #2B587A;font-weight: bold;">Android-�����������</div><a class="cursor_pointer fl_r" onclick="Profile.miniatureClose()">�������</a><div class="clear"></div><br>'+body+'</div></div>');
	});
  },
  addweb:function(){
	$.post('/index.php?go=job&act=addweb',function(body){
		$('body').append('<div id="newbox_miniature"><div class="miniature_box"><div class="miniature_pos" style="width: 653px;padding:15px;"><div class="news_title fl_l" style="color: #2B587A;font-weight: bold;">���-�����������</div><a class="cursor_pointer fl_r" onclick="Profile.miniatureClose()">�������</a><div class="clear"></div><br>'+body+'</div></div>');
	});
  },
  addsysadmin:function(){
	$.post('/index.php?go=job&act=addsysadmin',function(body){
		$('body').append('<div id="newbox_miniature"><div class="miniature_box"><div class="miniature_pos" style="width: 653px;padding:15px;"><div class="news_title fl_l" style="color: #2B587A;font-weight: bold;">��������� �������������</div><a class="cursor_pointer fl_r" onclick="Profile.miniatureClose()">�������</a><div class="clear"></div><br>'+body+'</div></div>');
	});
  },
  addios:function(){
	$.post('/index.php?go=job&act=addios',function(body){
		$('body').append('<div id="newbox_miniature"><div class="miniature_box"><div class="miniature_pos" style="width: 653px;padding:15px;"><div class="news_title fl_l" style="color: #2B587A;font-weight: bold;">iOS-�����������</div><a class="cursor_pointer fl_r" onclick="Profile.miniatureClose()">�������</a><div class="clear"></div><br>'+body+'</div></div>');
	});
  },
  addandroid:function(){
	$.post('/index.php?go=job&act=addandroid',function(body){
		$('body').append('<div id="newbox_miniature"><div class="miniature_box"><div class="miniature_pos" style="width: 653px;padding:15px;"><div class="news_title fl_l" style="color: #2B587A;font-weight: bold;">Android-�����������</div><a class="cursor_pointer fl_r" onclick="Profile.miniatureClose()">�������</a><div class="clear"></div><br>'+body+'</div></div>');
	});
  },
  send: function(){
    var namejob = $('#namejob').val();
    var name = $('#name').val();
    var phone = $('#phone').val();
    var email = $('#email').val();
	var description = $('#description').val();
    butloading('sending', '56', 'disabled', '');
    $.post('/index.php?go=job&act=addjob', {namejob: namejob, name: name, phone: phone, email: email, description: description}, function(d){
        if(d == '1'){
            var result = '���� �������� ����� ����������� ��������������.';    
        }
        else if(d == '2'){
            var result = '��������! ��� ���� ����������� � ����������.';    
        }
			butloading('sending', '56', 'enabled', '������ ������ �� ��������');
			$('#result').show();
			$('#result').html(result);
		});
	}
}