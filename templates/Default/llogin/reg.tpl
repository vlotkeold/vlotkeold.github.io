<div class="photo_close" onClick="Profile.miniatureClose(''); return false;"></div>
<div style="margin-top:-30px"><h1 onClick="reg.step1(); return false" id="reg_lnk">������������ �����������</h1></div>
<div class="support_bg" id="step1">
<div style="padding-left:0px">
<input type="text" 
	class="videos_input fl_l" 
	style="width:150px;margin-top:10px" 
	maxlength="30" 
	id="name"
	placeholder="���� ���"
/><div class="clear"></div>
<div class="input_hr" style="width:163px"></div>
<input type="text" 
	class="videos_input fl_l" 
	style="width:150px" 
	maxlength="30" 
	id="lastname"
	placeholder="���� �������"
/><div class="clear"></div>
<div class="input_hr" style="width:163px"></div>
<div class="clear"></div>
<div class="button_blue fl_l"><button onClick="reg.step1(); return false" style="width:161px"><span class="ij_with_arr">������������������</span></button></div>
</div>
<div class="clear"></div>
</div>
<div class="support_bg no_display" id="step2" style="margin-top:-10px">
<div style="padding-left:0px">
<select id="sex" class="inpst sel_reg">
 <option value="0">������� ���</option>
 <option value="1">�������</option>
 <option value="2">�������</option>
</select>
<div class="clear"></div>
<select id="day" class="inpst sel_reg">
 <option>���� ��������</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>
</select>
<div class="clear"></div>
<select id="month" class="inpst sel_reg">
 <option>����� ��������</option><option value="1">������</option><option value="2">�������</option><option value="3">�����</option><option value="4">������</option><option value="5">���</option><option value="6">����</option><option value="7">����</option><option value="8">�������</option><option value="9">��������</option><option value="10">�������</option><option value="11">������</option><option value="12">�������</option>
</select>
<div class="clear"></div>
<select id="year" class="inpst sel_reg">
 <option>��� ��������</option><option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option>
</select>
<div class="clear"></div>
<select id="country" class="inpst sel_reg" onChange="Profile.LoadCity(this.value); return false;"><option value="0">������� ������</option>{country}
</select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" />
<div class="clear"></div>
<span id="city" style="display:none;">
<select name="city" id="select_city" class="inpst sel_reg"><option>������� �����</option></select>
<div class="clear"></div></span>
<div class="clear margin_top_10"></div>
<div class="button_blue fl_l"><button onClick="reg.step2(); return false" style="width:161px">��������� ���</button></div>
</div>
<div class="clear"></div>
</div>

<div class="support_bg no_display" id="step3" style="margin-top:-10px">
<div style="padding-left:0px">
<input type="text" 
	class="videos_input fl_l" 
	style="width:150px;margin-top:10px" 
	maxlength="30" 
	id="email"
	placeholder="����������� �����"
/><div class="clear"></div>
<div class="input_hr" style="width:163px"></div>
<input type="password" 
	class="videos_input fl_l" 
	style="width:150px" 
	maxlength="30" 
	id="new_pass"
	placeholder="������"
/><div class="clear"></div>
<div class="input_hr" style="width:163px"></div>
<input type="password" 
	class="videos_input fl_l" 
	style="width:150px" 
	maxlength="30" 
	id="new_pass2"
	placeholder="��� ��� ������"
/><div class="clear"></div>
<div class="input_hr" style="width:163px"></div>
<div class="clear"></div>
<div class="button_blue fl_l"><button onClick="reg.finish(); return false" style="width:161px">���������</button></div>
</div>
<div class="clear"></div>
</div>