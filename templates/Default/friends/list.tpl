 <b>Регион</b>
 <div class="search_clear"></div>
   

<div id="container1" class="selector_container dropdown_container selector_focused" style="width: 152px; ">
		<table cellspacing="0" cellpadding="0" class="selector_table">
			<tbody>
				<tr>
					<td class="selector">
						<span class="selected_items"></span>
							<input type="text" class="selector_input selected container1" readonly="true"  value="{country_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container1" >
							<input type="hidden" onChange="Profile.LoadCity(this.value);" name="country" id="country" value="{country_id}" class="resultField" >
						
					</td>
					<td id="container1" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="Profile.LoadCity(this.value); friends.search({user_id},1);" value="{country_id}" id="resultField1">{country}</ul></div>
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
							<input type="text" class="selector_input selected container2 resetvalue" readonly="true"  value="{city_name}" style="color: rgb(0, 0, 0); width: 115px; " id="container2" >
							<input type="hidden" onChange="gSearch.go();" name="city" id="select_city" value="{city_id}" class="resultField" >
						
					</td>
					<td id="container2" class="selector_dropdown" style="width: 16px; ">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<div class="results_container" style="display:none">
		<div class="result_list" style="opacity: 1; width: 152px; height: 218px; bottom: auto; visibility: visible;overflow-x: hidden; overflow-y: visible;"><ul onmousedown="friends.search({user_id},1);" id="select_city1">{city}</ul></div>
		<div class="result_list_shadow" style="width: 152px; margin-top: 217px; " ><div class="shadow1"></div><div class="shadow2"></div></div></div></div>

</div></div>

 <div class="search_clear"></div>
 <b>Пол</b>
  <input id="sex" type="hidden" value="0">
    <div>
      <div class="radiobtn settings_reason" onclick="friends.search({user_id},1); radiobtn.select('sex',2);" style="padding-top:10px;">
        <div></div>
       Женский
      </div>
    </div>
     <div class="mgclr"></div>  
    <div>
      <div class="radiobtn settings_reason" onclick="friends.search({user_id},1); radiobtn.select('sex',1);">
        <div></div>
        Мужской
      </div>
    </div>
     <div class="mgclr"></div>  
    <div>
      <div class="radiobtn settings_reason on" onclick="friends.search({user_id},1); radiobtn.select('sex',0);">
        <div></div>
        Любой
      </div>
    </div>
[owner]<div style="border-bottom: 1px solid #E4E7EB;margin-top:6px;margin-bottom:6px"></div>[/owner]
{all_friends}
<div style="border-bottom: 1px solid #E4E7EB;margin-top:6px;margin-bottom:6px"></div>
{list}
[owner]
    <a onClick="friends.newList('{user_id}'); return false">Создать список</a>
[/owner]