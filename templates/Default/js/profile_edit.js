var sp = {
	openfriends: function(ifalse, page_num){
		var sex = $('#sex').val();
		if(sex == 1)
			var sp = $('#sp').val();
		else
			var sp = $('#sp_w').val();

		if(sp == 1 || sp == 0 || sp == 7){
			$('#sp_type').hide();
			$('#sp_val').val('');
		} else {
			if(page_num)
				var page = '&page='+page_num;
			else {
				var page = '';
				var page_num = 1;
			}

			if(sex == 1){
				if(sp == 2)
					lang_edit_sp = lang_editprof_text_1;
				else if(sp == 3)
					lang_edit_sp = lang_editprof_text_2;
				else if(sp == 4)
					lang_edit_sp = lang_editprof_text_3;
				else if(sp == 5)
					lang_edit_sp = lang_editprof_text_4;
				else
					lang_edit_sp = lang_editprof_text_5;
			} else {
				if(sp == 2)
					lang_edit_sp = lang_editprof_atext_1;
				else if(sp == 3)
					lang_edit_sp = lang_editprof_atext_2;
				else if(sp == 4)
					lang_edit_sp = lang_editprof_atext_3;
				else if(sp == 5)
					lang_edit_sp = lang_editprof_atext_4;
				else
					lang_edit_sp = lang_editprof_atext_5;
			}
			Box.Page('/index.php?go=friends&act=box', 'user_sex='+sex+page, 'friends_'+page_num, 600, lang_edit_sp, lang_msg_close, 0, 0, 345, 1, 1, 1, 0, 0);
		}
	},
	select: function(name, user_id){
		var sex = $('#sex').val();
		
		Box.Close();
		
		if(sex == 1){
			var sp = $('#sp').val();
			if(sp == 2)
				$('#sp_text').text(lang_editprof_sptext_1);
			else if(sp == 3)
				$('#sp_text').text(lang_editprof_sptext_2);
			else if(sp == 4)
				$('#sp_text').text(lang_editprof_sptext_3);
			else if(sp == 5)
				$('#sp_text').text(lang_editprof_sptext_4);
			else
				$('#sp_text').text(lang_editprof_sptext_5);
		} else {
			var sp = $('#sp_w').val();
			if(sp == 2)
				$('#sp_text').text(lang_editprof_asptext_1);
			else if(sp == 3)
				$('#sp_text').text(lang_editprof_asptext_2);
			else if(sp == 4)
				$('#sp_text').text(lang_editprof_asptext_3);
			else if(sp == 5)
				$('#sp_text').text(lang_editprof_asptext_4);
			else
				$('#sp_text').text(lang_editprof_asptext_5);
		}
		
		$('#sp_name').text(name);
		$('#sp_val').val(user_id);
		$('#sp_type').show();
	},
	check: function(){
		var sex = $('#sex').val();
		if(sex != 0){
			$('#sp_block').show();
			$('#sp_type').hide();
			$('#sp_val').val('');
			$('#sp_name').text('');
			
			if(sex == 1){
				$('#sp_sel_w').hide();
				$('#sp_sel_m').show();
			} else {
				$('#sp_sel_m').hide();
				$('#sp_sel_w').show();
			}
		} else {
			$('#sp_block, #sp_type').hide();
			$('#sp_type').hide();
			$('#sp_val').val('');
			$('#sp_name').text('');
		}
	},
	del: function(){
		$('#sp_type').hide();
		$('#sp_val').val('');
		$('#sp_name').text('');
	}
}
$(document).ready(function(){
	
	$('#activity, #interests, #myinfo').autoResize();

	//���������� �������� ����������
	$("#saveform").click(function(){
		var name = $("#name").val();
		var lastname = $("#lastname").val();
		var dev = $("#dev").val();
		var otcestvo = $("#otcestvo").val();
		var roditeli = $("#roditeli").val();
		var mother = $("#mother").val();
		var father = $("#father").val();
		var bratiasestry = $("#bratiasestry").val();
		var rodgorod = $("#rodgorod").val();
		var babushkadedushka = $("#babushkadedushka").val();
		var deti = $("#deti").val();
		var vnuki = $("#vnuki").val();
		var lange = $("#lange").val();
		var sex = $("#sex").val();
		var day = $("#day").val();
		var year = $("#year").val();
		var month = $("#month").val();
		var city = $("#select_city").val();
		var dprivacy = $("#spx_w").val();
		var sex = $('#sex').val();
		if(sex == 1)
			var sp = $('#sp').val();
		else
			var sp = $('#sp_w').val();
		var sp_val = $("#sp_val").val();
		
		butloading('saveform', '55', 'disabled', '');
		$.post('/index.php?go=editprofile&act=save_general', {name: name, lastname: lastname, dev: dev, otcestvo: otcestvo, roditeli: roditeli, mother: mother, father: father, bratiasestry: bratiasestry, rodgorod: rodgorod, babushkadedushka: babushkadedushka, deti: deti, vnuki: vnuki, lange: lange, sex: sex, day: day, month: month, year: year, sp: sp, sp_val: sp_val, dprivacy: dprivacy}, function(data){
			$('#info_save').hide();
			if(data == 'ok'){
				$('#info_save').show();
				$('#info_save').html(lang_infosave);
			} else {
				$('#info_save').show();
				$('#info_save').html(data);
			}
			butloading('saveform', '55', 'enabled', lang_box_save);
		});
	});
	
	//���������� ���������
	$('#saveform_contact').click(function(){
		var country = $("#country").val();
		var city = $("#select_city").val();
		var rai = $("#rai").val();
		var metro = $("#metro").val();
		var ulica = $("#ulica").val();
		var nazvanie = $("#nazvanie").val();
		var vk = $("#vk").val();
		var od = $("#od").val();
		var fb = $("#fb").val();
		var icq = $("#icq").val();
		var phonebook = $("#phonebook").val();
		var skype = $("#skype").val();
		var site = $("#site").val();

		//�������� VK
		if(vk != 0){
			if(isValidVk(vk)){
				$("#vk").css('background', '#fff');
				$("#validVk").html('');
				var errors_vk = 0;
			} else {
				$("#vk").css('background', '#ffefef');
				$("#validVk").html('<span class="form_error">'+lang_no_vk+'</span>');
				var errors_vk = 1;
			}
		} else {
			$("#vk").css('background', '#fff');
			$("#validVk").html('');
			var errors_vk = 0;
		}

		//�������� OD
		if(od != 0){
			if(isValidOd(od)){
				$("#od").css('background', '#fff');
				$("#validOd").html('');
				var errors_od = 0;
			} else {
				$("#od").css('background', '#ffefef');
				$("#validOd").html('<span class="form_error">'+lang_no_od+'</span>');
				var errors_od = 1;
			}
		} else {
			$("#od").css('background', '#fff');
			$("#validOd").html('');
			var errors_od = 0;
		}
		
		//�������� FB
		if(fb != 0){
			if(isValidFb(fb)){
				$("#fb").css('background', '#fff');
				$("#validFb").html('');
				var errors_fb = 0;
			} else {
				$("#fb").css('background', '#ffefef');
				$("#validFb").html('<span class="form_error">'+lang_no_fb+'</span>');
				var errors_fb = 1;
			}
		} else {
			$("#fb").css('background', '#fff');
			$("#validFb").html('');
			var errors_fb = 0;
		}
		
		//�������� ICQ
		if(icq != 0){
			if(isValidICQ(icq)){
				$("#icq").css('background', '#fff');
				$("#validIcq").html('');
				var errors_icq = 0;
			} else {
				$("#icq").css('background', '#ffefef');
				$("#validIcq").html('<span class="form_error">'+lang_no_icq+'</span>');
				var errors_icq = 1;
			}
		} else {
			$("#icq").css('background', '#fff');
			$("#validIcq").html('');
			var errors_icq = 0;
		}
		
		//��������, ���� ���� ������ �� ������ ���� � ���� ���, �� ����������
		if(errors_vk == 1 || errors_od == 1 || errors_fb == 1 || errors_icq == 1){
			return false;
		} else {
			butloading('saveform_contact', '55', 'disabled', '');
			$.post('/index.php?go=editprofile&act=save_contact', {country: country, city: city, rai: rai, metro: metro, ulica: ulica, nazvanie: nazvanie, phonebook: phonebook, vk: vk, od: od, skype: skype, fb: fb, icq: icq, site: site}, function(data){
				$('#info_save').hide();
				if(data == 'ok'){
					$('#info_save').show();
					$('#info_save').html(lang_infosave);
				} else {
					$('#info_save').show();
					$('#info_save').html(data);
				}
				butloading('saveform_contact', '55', 'enabled', lang_box_save);
			});
		}
	});
	
	//���������� �������� ����������� 
	$("#saveform_education").click(function(){
		var country = $("#country").val();
		var city = $("#select_city").val();
		var shkola = $("#shkola").val();
		var nacalosr = $("#nacalosr").val();
		var konecsr = $("#konecsr").val();
		var datasr = $("#datasr").val();
		var klass = $("#klass").val();
		var spec = $("#spec").val();	
		butloading('saveform_education', '55', 'disabled', '');
		$.post('/index.php?go=editprofile&act=save_education', {country: country, city: city, shkola: shkola, nacalosr: nacalosr, konecsr: konecsr, datasr: datasr, klass: klass, spec: spec}, function(data){
			$('#info_save').hide();
			if(data == 'ok'){
				$('#info_save').show();
				$('#info_save').html(lang_infosave);
			} else {
				$('#info_save').show();
				$('#info_save').html(data);
			}
			butloading('saveform_education', '55', 'enabled', lang_box_save);
		});
	});
	
	//���������� ������� �����������
	$("#saveform_higher_education").click(function(){
		var country = $("#country").val();
		var city = $("#select_city").val();
		var vuz = $("#vuz").val();
		var fac = $("#fac").val();
		var form = $("#form").val();
		var statusvi = $("#statusvi").val();
		var datavi = $("#datavi").val();	
	    butloading('saveform_higher_education', '55', 'disabled', '');
		$.post('/index.php?go=editprofile&act=save_higher_education', {country: country, city: city, vuz: vuz, fac: fac, form: form, statusvi: statusvi, datavi: datavi}, function(data){
			$('#info_save').hide();
			if(data == 'ok'){
				$('#info_save').show();
				$('#info_save').html(lang_infosave);
			} else {
				$('#info_save').show();
				$('#info_save').html(data);
			}
			butloading('saveform_higher_education', '55', 'enabled', lang_box_save);
		});
	});
	
	//���������� �������
	$("#saveform_career").click(function(){
		var country = $("#country").val();
		var city = $("#select_city").val();
		var mesto = $("#mesto").val();
		var nacaloca = $("#nacaloca").val();
		var konecca = $("#konecca").val();
		var dolj = $("#dolj").val();	
	    butloading('saveform_career', '55', 'disabled', '');
		$.post('/index.php?go=editprofile&act=save_career', {country: country, city: city, mesto: mesto, nacaloca: nacaloca, konecca: konecca, dolj: dolj}, function(data){
			$('#info_save').hide();
			if(data == 'ok'){
				$('#info_save').show();
				$('#info_save').html(lang_infosave);
			} else {
				$('#info_save').show();
				$('#info_save').html(data);
			}
			butloading('saveform_career', '55', 'enabled', lang_box_save);
		});
	});
	
	//���������� ������� ������
	$("#saveform_military").click(function(){
		var country = $("#country").val();
		var city = $("#select_city").val();
		var chast = $("#chast").val();
		var zvanie = $("#zvanie").val();
		var nacalosl = $("#nacalosl").val();
		var konecsl = $("#konecsl").val();	
	    butloading('saveform_military', '55', 'disabled', '');
		$.post('/index.php?go=editprofile&act=save_military', {country: country, city: city, chast: chast, zvanie: zvanie, nacalosl: nacalosl, konecsl: konecsl}, function(data){
			$('#info_save').hide();
			if(data == 'ok'){
				$('#info_save').show();
				$('#info_save').html(lang_infosave);
			} else {
				$('#info_save').show();
				$('#info_save').html(data);
			}
			butloading('saveform_military', '55', 'enabled', lang_box_save);
		});
	});
	
	//���������� ��������� �������
	$("#saveform_personal").click(function(){
		var pred = $("#pred").val();
		var miro = $("#miro").val();
		var jizn = $("#jizn").val();
		var ludi = $("#ludi").val();
		var kurenie = $("#kurenie").val();
		var alkogol = $("#alkogol").val();
		var narkotiki = $("#narkotiki").val();
		var vdox = $("#vdox").val();	
	
	
		
		butloading('saveform_personal', '55', 'disabled', '');
		$.post('/index.php?go=editprofile&act=save_personal', {pred: pred, miro: miro, jizn: jizn, ludi: ludi, kurenie: kurenie, alkogol: alkogol, narkotiki: narkotiki, vdox: vdox}, function(data){
			$('#info_save').hide();
			if(data == 'ok'){
				$('#info_save').show();
				$('#info_save').html(lang_infosave);
			} else {
				$('#info_save').show();
				$('#info_save').html(data);
			}
			butloading('saveform_personal', '55', 'enabled', lang_box_save);
		});
	});
	
	//���������� ���������
	$('#saveform_interests').click(function(){
		var activity = $("#activity").val();
		var interests = $("#interests").val();
		var myinfo = $("#myinfo").val();
		var music = $("#music").val();
		var kino = $("#kino").val();
		var books = $("#books").val();
		var games = $("#games").val();
		var quote = $("#quote").val();
		butloading('saveform_interests', '55', 'disabled', '');
		$.post('/index.php?go=editprofile&act=save_interests', {activity: activity, interests: interests, myinfo: myinfo, music: music, kino: kino, books: books, games: games, quote: quote}, function(data){
			$('#info_save').hide();
			if(data == 'ok'){
				$('#info_save').show();
				$('#info_save').html(lang_infosave);
			} else {
				$('#info_save').show();
				$('#info_save').html(data);
			}
			butloading('saveform_interests', '55', 'enabled', lang_box_save);
		});
	});
});
function CheckLength(name, infoname, num){
	var xname = $('#'+name).val().length;
	var valname = $('#'+name).val();
	if(xname >= num){
		$('#'+infoname).html('');
		var errors = 0;
	} else {
		$('#'+infoname).html('<span class="form_error">�� ����� '+num+' ��������</span>');
		$('#'+name).css('background', '#ffefef');	
		var errors = 1;
	}
	a = errors;
	return a;
}
function isValidName(xname){
	var pattern = new RegExp(/^[a-zA-Z�-��-�]+$/);
 	return pattern.test(xname);
}
function isValidVk(xname){
	var pattern = new RegExp(/http:\/\/vkontakte.ru|http:\/\/www.vkontakte.ru|http:\/\/vk.com|http:\/\/www.vk.com/i);
 	return pattern.test(xname);
}
function isValidFb(xname){
	var pattern = new RegExp(/http:\/\/facebook.com|http:\/\/www.facebook.com/i);
 	return pattern.test(xname);
}
function isValidICQ(xname){
	var pattern = new RegExp(/^[0-9]+$/);
 	return pattern.test(xname);
}
function isValidOd(xname){
	var pattern = new RegExp(/http:\/\/odnoklassniki.ru|http:\/\/www.odnoklassniki.ru|http:\/\/odnoklassniki.ua|http:\/\/www.odnoklassniki.ua/i);
 	return pattern.test(xname);
}