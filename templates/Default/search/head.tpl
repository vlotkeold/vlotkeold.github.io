<script type="text/javascript">
$(document).ready(function(){
	$('.search_sotrt_tabz2').css('min-height', ($('.search_sotrt_tabz2').height()+10)+'px').css('height', ($('.blog_left').height()+10)+'px');
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	music.jPlayerInc();
	[search-tab]$('#page').css('min-height', '444px');
	$(window).scroll(function(){
		if($(window).scrollTop() > 103)
			$('.search_sotrt_tab').css('position', 'fixed').css('margin-top', '-80px');
		else
			$('.search_sotrt_tab').css('position', 'absolute').css('margin-top', '39px');
	});[/search-tab]
	myhtml.checked(['{checked-online}', '{checked-user-photo}']);	
	var query = $('#query_full').val();
	if(query == 'Начните вводить любое слово или имя')
		$('#query_full').css('color', '#c1cad0');
	var miro = $('#miro').val();
	if(miro == 'Мировоззрение')
		$('#miro').css('color', '#777');

	var mesto = $('#mesto').val();
	if(mesto == 'Работа')
		$('#mesto').css('color', '#777');

	var dolj = $('#dolj').val();
	if(dolj == 'Должность')
		$('#dolj').css('color', '#777');

	var chast = $('#chast').val();
	if(chast == 'Воинская часть')
		$('#chast').css('color', '#777');

	var container1 = $('.container1').val();
	if(container1  != 'Выбор страны')
		$('#city').show('fast');

	var container1 = $('.container1').val();
	if(container1 == 'Выбор страны')
		$('.container1').css('color', '#777');

	var container2 = $('.container2').val();
	if(container2 == 'Выбор города')
		$('.container2').css('color', '#777');

	var container3 = $('.container3').val();
	if(container3 == 'Любой')
		$('.container3').css('color', '#777');

	var container4 = $('.container4').val();
	if(container4 == 'День рождения')
		$('.container4').css('color', '#777');

	var container5 = $('.container5').val();
	if(container5 == 'Месяц:')
		$('.container5').css('color', '#777');

	var container6 = $('.container6').val();
	if(container6 == 'Год рождения')
		$('.container6').css('color', '#777');

	var container7 = $('.container7').val();
	if(container7 == 'Выбор статуса')
		$('.container7').css('color', '#777');

	var container8 = $('.container8').val();
	if(container8 == 'Главное в жизни')
		$('.container8').css('color', '#777');

	var container9 = $('.container9').val();
	if(container9 == 'Главное в людях')
		$('.container9').css('color', '#777');

	var container10 = $('.container10').val();
	if(container10 == 'Отношение к курению')
		$('.container10').css('color', '#777');

	var container11 = $('.container11').val();
	if(container11 == 'Отношение к алкоголю')
		$('.container11').css('color', '#777');

	var container12 = $('.container12').val();
	if(container12 != 'Выбор страны')
		$('#sl').show('fast');

	var container12 = $('.container12').val();
	if(container12 == 'Выбор страны')
		$('.container12').css('color', '#777');

	var container13 = $('.container13').val();
	if(container13 == 'Год начала службы')
		$('.container13').css('color', '#777');
});
</script>
<div class="search_form_tab">
<input type="text" value="{query}" class="fave_input" id="query_full" 
	onBlur="if(this.value==''){this.value='Начните вводить любое слово или имя';this.style.color = '#c1cad0';}" 
	onFocus="if(this.value=='Начните вводить любое слово или имя'){this.value='';this.style.color = '#000'}" 
	onKeyPress="if(event.keyCode == 13)gSearch.go();" 
	style="width:500px;margin:0px;color:#000" 
maxlength="65" />
<div class="button_blue fl_r"><button onClick="gSearch.go(); return false">{translate=search_search}</button></div>
<div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="margin-top:10px;height:22px">
 <div class="{activetab-1}"><a href="/?{query-people}" onClick="Page.Go(this.href); return false;"><div><b>{translate=search_people}</b></div></a></div>
 <div class="{activetab-7}"><a href="/?go=search&type=7&query=" onClick="Page.Go(this.href); return false;"><div><b>{translate=search_news}</b></div></a></div>
 [search-tab]<div class="{activetab-4}"><a href="/?go=search{query-groups}" onClick="Page.Go(this.href); return false;"><div><b>{translate=search_comm}</b></div></a></div>[/search-tab]
 [search-tabg]<div class="{activetab-4}"><a href="/?go=search{query-groups}" onClick="Page.Go(this.href); return false;"><div><b>{translate=search_comm}</b></div></a></div>[/search-tabg]
 [search-tabv]<div class="{activetab-4}"><a href="/?go=search{query-groups}" onClick="Page.Go(this.href); return false;"><div><b>{translate=search_comm}</b></div></a></div>[/search-tabv]
 [search-taba]<div class="{activetab-4}"><a href="/?go=search{query-groups}" onClick="Page.Go(this.href); return false;"><div><b>{translate=search_comm}</b></div></a></div>[/search-taba]
 [search-tabn]<div class="{activetab-4}"><a href="/?go=search{query-groups}" onClick="Page.Go(this.href); return false;"><div><b>{translate=search_comm}</b></div></a></div>[/search-tabn]

 [search-tabc]<div class="{activetab-6}"><a href="/?go=search{query-clubs}" onClick="Page.Go(this.href); return false;"><div><b>{translate=search_comm}</b></div></a></div>[/search-tabc]
 <div class="{activetab-5}"><a href="/?go=search{query-audios}" onClick="Page.Go(this.href); return false;"><div><b>{translate=search_audios}</b></div></a></div>
 <div class="{activetab-2}"><a href="/?go=search{query-videos}" onClick="Page.Go(this.href); return false;"><div><b>{translate=search_videos}</b></div></a></div>
</div>
<input type="hidden" value="{type}" id="se_type_full" />
</div>

[search-tab]
<div class="search_sotrt_tabz2">
 <b>Регион</b>
 <div class="search_clear"></div>
   

<div id="container1" class="selector_container dropdown_container selector_focused" style="width: 152px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected container1" readonly="true"  value="{country_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container1" >
							<input type="hidden" onChange="Profile.LoadCity(this.value); gSearch.go();" name="country" id="country" value="{country_id}" class="resultField" >
						
					</td>
					<td id="container1" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="gSearch.go();">{country}</ul></div>
		<div class="result_list_shadow" style="width: 152px; margin-top: 217px; " ><div class="shadow1"></div><div class="shadow2"></div></div></div></div>



 <div class="search_clear"></div>






<div id="city" class="no_display">
 <div class="padstylej">



<div id="container2" class="selector_container dropdown_container selector_focused" style="width: 152px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected container2" readonly="true"  value="{city_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container2" >
							<input type="hidden" onChange="gSearch.go();" name="city" id="select_city" value="{city_id}" class="resultField" >
						
					</td>
					<td id="container2" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="gSearch.go();">{city}</ul></div>
		<div class="result_list_shadow" style="width: 152px; margin-top: 217px; " ><div class="shadow1"></div><div class="shadow2"></div></div></div></div>

</div>

 <div class="search_clear"></div>
 </div>
 <b>Пол</b>
 <div class="search_clear"></div>
  
 <div class="padstylej">



<div id="container3" class="selector_container dropdown_container selector_focused" style="width: 152px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected container3" readonly="true"  value="{sex_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container3" >
							<input type="hidden" onChange="gSearch.go();" name="sex" id="sex" value="{sex_id}" class="resultField" >
						
					</td>
					<td id="container3" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="gSearch.go();">{sex}</ul></div>
		<div class="result_list_shadow" style="width: 152px; margin-top: 217px; " ><div class="shadow1"></div><div class="shadow2"></div></div></div></div>





</div>
<div class="search_clear"></div>
 
 <b>Семейное положение</b>
 <div class="search_clear"></div>

<div id="container7" class="selector_container dropdown_container selector_focused" style="width: 152px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected container7" readonly="true"  value="{sp_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container7" >
							<input type="hidden" onChange="Profile.LoadCity(this.value); gSearch.go();" name="sp" id="sp" value="{sp_id}" class="resultField" >
						
					</td>
					<td id="container7" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="gSearch.go();">{sp_list}</ul></div>
		<div class="result_list_shadow" style="width: 152px; margin-top: 217px; " ><div class="shadow1"></div><div class="shadow2"></div></div></div></div>
 <div class="search_clear"></div>
 <div class="html_checkbox" id="online" onClick="myhtml.checkbox(this.id); gSearch.go();">сейчас на сайте</div>
 <div class="html_checkbox" id="user_photo" onClick="myhtml.checkbox(this.id); gSearch.go();" style="margin-top:9px">с фотографией</div>
 <div class="search_clear"></div>
<br>
 <b>Жизненная позиция</b>
 <div class="search_clear"></div>


<input type="text" id="miro" class="inpst" maxlength="100" value="{miro}" 

onBlur="if(this.value==''){this.value='Мировоззрение';this.style.color = '#777';}" 
	onFocus="if(this.value=='Мировоззрение'){this.value='';this.style.color = '#000'}" 
	onKeyPress="if(event.keyCode == 13)gSearch.go();"

style="width:142px;">
 <div class="search_clear"></div>
<div id="container8" class="selector_container dropdown_container selector_focused" style="width: 152px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected container8" readonly="true"  value="{jizn_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container8" >
							<input type="hidden" onChange="Profile.LoadCity(this.value); gSearch.go();" name="jizn" id="jizn" value="{jizn_id}" class="resultField" >
						
					</td>
					<td id="container8" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="gSearch.go();">{jizn}</ul></div>
		<div class="result_list_shadow" style="width: 152px; margin-top: 217px; " ><div class="shadow1"></div><div class="shadow2"></div></div></div></div>

 <div class="search_clear"></div>

<div id="container9" class="selector_container dropdown_container selector_focused" style="width: 152px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected container9" readonly="true"  value="{ludi_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container9" >
							<input type="hidden" onChange="Profile.LoadCity(this.value); gSearch.go();" name="ludi" id="ludi" value="{ludi_id}" class="resultField" >
						
					</td>
					<td id="container9" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="gSearch.go();">{ludi}</ul></div>
		<div class="result_list_shadow" style="width: 152px; margin-top: 217px; " ><div class="shadow1"></div><div class="shadow2"></div></div></div></div>

 <div class="search_clear"></div>

<div id="container10" class="selector_container dropdown_container selector_focused" style="width: 152px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected container10" readonly="true"  value="{kurenie_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container10" >
							<input type="hidden" onChange="Profile.LoadCity(this.value); gSearch.go();" name="kurenie" id="kurenie" value="{kurenie_id}" class="resultField" >
						
					</td>
					<td id="container10" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="gSearch.go();">{kurenie}</ul></div>
		<div class="result_list_shadow" style="width: 152px; margin-top: 217px; " ><div class="shadow1"></div><div class="shadow2"></div></div></div></div>

 <div class="search_clear"></div>

<div id="container11" class="selector_container dropdown_container selector_focused" style="width: 152px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected container11" readonly="true"  value="{alkogol_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container11" >
							<input type="hidden" onChange="Profile.LoadCity(this.value); gSearch.go();" name="alkogol" id="alkogol" value="{alkogol_id}" class="resultField" >
						
					</td>
					<td id="container11" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="gSearch.go();">{alkogol}</ul></div>
		<div class="result_list_shadow" style="width: 152px; margin-top: 217px; " ><div class="shadow1"></div><div class="shadow2"></div></div></div></div>
<br>
 <b>Работа</b>
 <div class="search_clear"></div>
<input type="text" id="mesto" class="inpst" maxlength="100" value="{mesto}" 

onBlur="if(this.value==''){this.value='Работа';this.style.color = '#777';}" 
	onFocus="if(this.value=='Работа'){this.value='';this.style.color = '#000'}" 
	onKeyPress="if(event.keyCode == 13)gSearch.go();"

style="width:142px;">
 <div class="search_clear"></div>
<input type="text" id="dolj" class="inpst" maxlength="100" value="{dolj}" 
onBlur="if(this.value==''){this.value='Должность';this.style.color = '#777';}" 
	onFocus="if(this.value=='Должность'){this.value='';this.style.color = '#000'}" 
	onKeyPress="if(event.keyCode == 13)gSearch.go();"
style="width:142px;">
 <div class="search_clear"></div>
<br>
<b>Военная служба</b>
 <div class="search_clear"></div>
<div id="container12" class="selector_container dropdown_container selector_focused" style="width: 152px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected container12" readonly="true"  value="{country_army_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container12" >
							<input type="hidden" onChange="Profile.LoadCity(this.value); gSearch.go();" name="country_army" id="country_army" value="{country_army_id}" class="resultField" >
						
					</td>
					<td id="container12" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="gSearch.go();">{country_army}</ul></div>
		<div class="result_list_shadow" style="width: 152px; margin-top: 217px; " ><div class="shadow1"></div><div class="shadow2"></div></div></div></div>

 <div class="search_clear"></div>
<div id="sl" class="no_display">
<input type="text" id="chast" class="inpst" maxlength="100" value="{chast}" style="width:142px;">
</div>
 <div id="container13" class="selector_container dropdown_container selector_focused" style="width: 152px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected container13" readonly="true"  value="{nacalosl_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container13" >
							<input type="hidden" onChange="gSearch.go();" name="nacalosl" id="nacalosl" value="{nacalosl_id}" class="resultField" >
						
					</td>
					<td id="container13" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="gSearch.go();">{nacalosl}</ul></div>
		<div class="result_list_shadow" style="width: 152px; margin-top: 217px; " ><div class="shadow1"></div><div class="shadow2"></div></div></div></div>

<br>
 <b>Дополнительно</b>
<br>
 <div class="search_clear"></div>

 <div class="padstylej">



<div id="container4" class="selector_container dropdown_container selector_focused" style="width: 152px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected container4" readonly="true"  value="{day_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container4" >
							<input type="hidden" onChange="gSearch.go();" name="day" id="day" value="{day_id}" class="resultField" >
						
					</td>
					<td id="container4" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="gSearch.go();">{day}</ul></div>
		<div class="result_list_shadow" style="width: 152px; margin-top: 217px; " ><div class="shadow1"></div><div class="shadow2"></div></div></div></div>



 <div class="search_clear"></div>
  
 <div id="container5" class="selector_container dropdown_container selector_focused" style="width: 152px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected container5" readonly="true"  value="{month_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container5" >
							<input type="hidden" onChange="gSearch.go();" name="month" id="month" value="{month_id}" class="resultField" >
						
					</td>
					<td id="container5" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="gSearch.go();">{month}</ul></div>
		<div class="result_list_shadow" style="width: 152px; margin-top: 217px; " ><div class="shadow1"></div><div class="shadow2"></div></div></div></div>



 <div class="search_clear"></div>
  
 <div id="container6" class="selector_container dropdown_container selector_focused" style="width: 152px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected container6" readonly="true"  value="{years_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container6" >
							<input type="hidden" onChange="gSearch.go();" name="year" id="year" value="{years_id}" class="resultField" >
						
					</td>
					<td id="container6" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="gSearch.go();">{years}</ul></div>
		<div class="result_list_shadow" style="width: 152px; margin-top: 217px; " ><div class="shadow1"></div><div class="shadow2"></div></div></div></div></div>
 <div class="search_clear"></div>

</div>
  [/search-tab]
[search-tabc]
<div class="search_sotrt_tabz2">
 <b>{translate=search_type}</b>
 <div class="search_clear"></div>
 <div class="padstylej"><input type="radio" checked="" id="club" name="type" onclick="Page.Go('/?go=search&type=6')"><label for="club" style="cursor:pointer">{translate=search_groups}</label></div>
<div class="mgclr"></div>
 <div class="padstylej"><input type="radio" id="public" name="type" onclick="Page.Go('/?go=search&type=4')"><label for="public" style="cursor:pointer">{translate=search_page}</label></div>
</div>
[/search-tabc]
[search-tabg]
<div class="search_sotrt_tabz2">
 <b>{translate=search_type}</b>
 <div class="search_clear"></div>
 <div class="padstylej"><input type="radio" id="club" name="type" onclick="Page.Go('/?go=search&type=6')"><label for="club" style="cursor:pointer">{translate=search_groups}</label></div>
<div class="mgclr"></div>
 <div class="padstylej"><input type="radio" checked="" id="public" name="type" onclick="Page.Go('/?go=search&type=4')"><label for="public" style="cursor:pointer">{translate=search_page}</label></div>
</div>
[/search-tabg]

<div class="clear"></div>
[yes]<div class="margin_top_10"></div><div class="search_result_title">{translate=search_found} {count}</div>[/yes]
<div id="jquery_jplayer"></div>
<input type="hidden" id="teck_id" value="0" />
<input type="hidden" id="typePlay" value="standart" />
<input type="hidden" id="teck_prefix" value="" />