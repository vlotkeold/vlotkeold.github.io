<link type="text/css" rel="stylesheet" href="/templates/Default/style/payment.css"></link>
<input type="file" name="uploadfile" style="position: absolute; margin: -5px 0px 0px -175px; padding: 0px; width: 220px; height: 30px; font-size: 14px; opacity: 0; cursor: pointer; display: none; z-index: 2147483583; top: 54px; left: 974px;"><div class="vii_box" id="newbox_miniaturepayment">
<div class="miniature_box">
 <div class="miniature_pos" style="width:500px">
  <div class="payment_title">
   <img src="{ava}" width="50" height="50" />
   <div class="fl_l">
   ���������� ����� ��������� SMS ���������.<br />
    ��� ������� ������: <b>{ubm} �����</b>
   </div>
   <div class="fl_r">
    <a class="cursor_pointer" onClick="viiBox.clos('mt_sms', 1)">�������</a>
   </div>
   <div class="clear"></div>
  </div>
  <div class="clear"></div>
 <div class="clear"></div> 
  <div class="payment_h2">�������� ������</div>
  <select id="payment_countr" onchange="payment.operator(this.value)" class="inpst payment_sel">
   <option value="0"></option>
   <option value="ru">������</option>
   <option value="ua">�������</option>
   <option value="az">�����������</option>
   <option value="ar">�������</option>
   <option value="by">����������</option>
   <option value="ger">��������</option>
   <option value="gru">������</option>
   <option value="iz">�������</option>
   <option value="kz">���������</option>
   <option value="kir">��������</option>
   <option value="lat">������</option>
   <option value="lit">�����</option>
   <option value="tad">�����������</option>
   <option value="est">�������</option>
  </select>
  <div class="payment_h2">��������</div>
  <select id="payment_oper" onchange="payment.cost(this.value)" class="inpst payment_sel" disabled="disabled">
   <option value="0"></option>
  </select>
  <div class="payment_h2">�� ������� ������ ���������</div>
  <select id="payment_cost" class="inpst payment_sel" onchange="payment.number(this.value)" disabled="disabled">
   <option value="0"></option>
  </select>
<br><div class="menuleft" style="margin-top:5px">
<a href="/" onClick="viiBox.clos('mt_sms', 1); payment.metodbox(); return false;" style="width:188px"><div>������� ������ ������ ������</div></a>
</div>
  <div class="no_display" id="smsblock">
  <div class="payment_block">
   ��� ��������� <b>������</b> �� ��� ����, ��������� ������� SMS ��������� c ������� <b><span id="smspref"></span>424qhscgk{user-id}</b> �� ����� <b id="smsnumber">9797</b><br /><br />
   ��������� ��������� ����� ����� ����������, �� ���� ������ ��������� �� 100 ���. �� SMS ����� ������ 100 ���.
  </div>
  <div class="clear"></div>
  <div class="playment_but"><b>�������� ��������</b>, ���� �� �� � ������, �� ����� ����� ���������� �� ����� � ��������� � ��� �� ����.</div>
  </div>
 </div>
 <div class="clear" style="height:50px"></div>
</div>
<!-- ��������� ������ -->
<div class="operatos no_display" id="ru">
 <option value="0"></option>
 <option value="ru1">������</option>
 <option value="ru2">���</option>
 <option value="ru3">�������</option>
 <option value="ru4">��� �������</option>
 <option value="ru5">����2</option>
 <option value="ru6">��������� GSM</option>
 <option value="ru7">���</option>
 <option value="ru8">�������������</option>
 <option value="ru9">����� GSM</option>
 <option value="ru10">��������� GSM</option>
 <option value="ru11">������</option>
 <option value="ru12">�������� GSM</option>
 <option value="ru13">���� GSM</option>
 <option value="ru14">�������������</option>
 <option value="ru15">�������������</option>
 <option value="ru16">����������</option>
 <option value="ru17">�����</option>
 <option value="ru18">��������� GSM</option>
 <option value="ru19">����</option>
 <option value="ru20">���������������</option>
 <option value="ru21">���</option>
</div>
<!-- /��������� -> ������ -->
<!-- ��������� -> ������� -->
<div class="operatos no_display" id="ua">
 <option value="0"></option>
 <option value="ua1">MTC (UMC)</option>
 <option value="ua2">life:)</option>
 <option value="ua3">Kyivstar</option>
</div>
<!-- /��������� -> ������� -->
<!-- ��������� -> ����������� -->
<div class="operatos no_display" id="az">
 <option value="0"></option>
 <option value="az1">Bakcell</option>
 <option value="az2">Nar Mobile (Azerfon)</option>
 <option value="az3">Azercell Telekom</option>
</div>
<!-- /��������� -> ����������� -->
<!-- ��������� -> ������� -->
<div class="operatos no_display" id="ar">
 <option value="0"></option>
 <option value="ar1">��������</option>
 <option value="ar2">��������</option>
</div>
<!-- /��������� -> ������� -->
<!-- ��������� -> ���������� -->
<div class="operatos no_display" id="by">
 <option value="0"></option>
 <option value="by1">life :)</option>
 <option value="by2">��� ��������</option>
 <option value="by3">������</option>
 <option value="by4">diallog</option>
</div>
<!-- /��������� -> ���������� -->
<!-- ��������� -> �������� -->
<div class="operatos no_display" id="ger">
 <option value="0"></option>
 <option value="ger1">T-Mobile</option>
 <option value="ger2">Vodafone</option>
 <option value="ger3">ePlus</option>
 <option value="ger4">O2</option>
 <option value="ger5">Talkline</option>
 <option value="ger6">Debitel</option>
 <option value="ger7">Mobilcom</option>
</div>
<!-- /��������� -> �������� -->
<!-- ��������� -> �������� -->
<div class="operatos no_display" id="gru">
 <option value="0"></option>
 <option value="gru1">Magticom</option>
 <option value="gru2">Geocell</option>
</div>
<!-- /��������� -> �������� -->
<!-- ��������� -> ������� -->
<div class="operatos no_display" id="iz">
 <option value="0"></option>
 <option value="iz1">Orange</option>
 <option value="iz2">Cellcom</option>
 <option value="iz3">Pelephone</option>
 <option value="iz4">MIRS</option>
</div>
<!-- /��������� -> ������� -->
<!-- ��������� -> ��������� -->
<div class="operatos no_display" id="kz">
 <option value="0"></option>
 <option value="kz1">���-���</option>
 <option value="kz2">GSM ���������</option>
 <option value="kz3">�����</option>
 <option value="kz4">������ �������-������</option>
</div>
<!-- /��������� -> ��������� -->
<!-- ��������� -> �������� -->
<div class="operatos no_display" id="kir">
 <option value="0"></option>
 <option value="kir1">Fonex</option>
 <option value="kir2">Nexi (Sotel)</option>
 <option value="kir3">Katel</option>
 <option value="kir4">MegaCom</option>
 <option value="kir5">Beeline (Bitel. Mobi)</option>
</div>
<!-- /��������� -> �������� -->
<!-- ��������� -> ������ -->
<div class="operatos no_display" id="lat">
 <option value="0"></option>
 <option value="lat1">����2</option>
 <option value="lat2">LMT</option>
 <option value="lat3">Bite GSM</option>
</div>
<!-- /��������� -> ������ -->
<!-- ��������� -> ����� -->
<div class="operatos no_display" id="lit">
 <option value="0"></option>
 <option value="lit1">Omnitel</option>
 <option value="lit2">Bite GSM</option>
 <option value="lit3">����2</option>
</div>
<!-- /��������� -> ����� -->
<!-- ��������� -> ����������� -->
<div class="operatos no_display" id="tad">
 <option value="0"></option>
 <option value="tad1">MLT</option>
 <option value="tad2">Indigo Somonkom</option>
 <option value="tad3">TT Mobile</option>
 <option value="tad4">MTEKO</option>
 <option value="tad5">Indigo Tajikistan</option>
</div>
<!-- /��������� -> ����������� -->
<!-- ��������� -> ������� -->
<div class="operatos no_display" id="est">
 <option value="0"></option>
 <option value="est1">EMT</option>
 <option value="est2">Radiolinija Eesti</option>
 <option value="est3">����2</option>
</div>
<!-- /��������� -> ������� -->
<!-- ��������� -> ������ -> ������ -->
<div class="cost no_display" id="cost_ru1">
 <option value="0"></option>
 <option value="9797">169.49 ���.</option>
 <option value="8510">254.24 ���.</option>
 <option value="8503">93.22 ���.</option>
 <option value="8355">94.07 ���.</option>
 <option value="8155">65.91 ���.</option>
</div>
<!-- /��������� -> ������ -> ������ -->
<!-- ��������� -> ������ -> ��� -->
<div class="cost no_display" id="cost_ru2">
 <option value="0"></option>
 <option value="9797">177.97 ���.</option>
 <option value="8510">258.3 ���.</option>
 <option value="8503">100.45 ���.</option>
 <option value="8355">94.71 ���.</option>
 <option value="8155">59.32 ���.</option>
</div>
<!-- /��������� -> ������ -> ��� -->
<!-- ��������� -> ������ -> ������� -->
<div class="cost no_display" id="cost_ru3">
 <option value="0"></option>
 <option value="9797">170 ���.</option>
 <option value="8510">254.24 ���.</option>
 <option value="8503">100 ���.</option>
 <option value="8355">99 ���.</option>
 <option value="8155">66 ���.</option>
</div>
<!-- /��������� -> ������ -> ������� -->
<!-- ��������� -> ������ -> ��� ������� -->
<div class="cost no_display" id="cost_ru4">
 <option value="0"></option>
 <option value="9797">211.86 ���.</option>
 <option value="8510">254.24 ���.</option>
 <option value="8503">98.42 ���.</option>
 <option value="8355">84.36 ���.</option>
 <option value="8155">56.24 ���.</option>
</div>
<!-- /��������� -> ������ -> ��� ������� -->
<!-- ��������� -> ������ -> ����2 -->
<div class="cost no_display" id="cost_ru5">
 <option value="0"></option>
 <option value="9797">177 ���.</option>
 <option value="8510">211.86 ���.</option>
 <option value="8503">99 ���.</option>
 <option value="8355">99 ���.</option>
 <option value="8155">66 ���.</option>
</div>
<!-- /��������� -> ������ -> ����2 -->
<!-- ��������� -> ������ -> ��������� GSM -->
<div class="cost no_display" id="cost_ru6">
 <option value="0"></option>
 <option value="9797">211.86 ���.</option>
 <option value="8510">254.24 ���.</option>
 <option value="8503">98.42 ���.</option>
 <option value="8355">84.36 ���.</option>
 <option value="8155">56.24 ���.</option>
</div>
<!-- /��������� -> ������ -> ��������� GSM -->
<!-- ��������� -> ������ -> ��� -->
<div class="cost no_display" id="cost_ru7">
 <option value="0"></option>
 <option value="9797">211.86 ���.</option>
 <option value="8510">254.24 ���.</option>
 <option value="8503">98.42 ���.</option>
 <option value="8355">84.36 ���.</option>
 <option value="8155">56.24 ���.</option>
</div>
<!-- /��������� -> ������ -> ��� -->
<!-- ��������� -> ������ -> ������������� -->
<div class="cost no_display" id="cost_ru8">
 <option value="0"></option>
 <option value="9797">169.49 ���.</option>
 <option value="8510">287 ���.</option>
 <option value="8503">99 ���.</option>
 <option value="8355">99 ���.</option>
 <option value="8155">66 ���.</option>
</div>
<!-- /��������� -> ������ -> ������������� -->
<!-- ��������� -> ������ -> ����� GSM -->
<div class="cost no_display" id="cost_ru9">
 <option value="0"></option>
 <option value="9797">177 ���.</option>
 <option value="8510">296.61 ���.</option>
 <option value="8503">99 ���.</option>
 <option value="8355">90 ���.</option>
 <option value="8155">60 ���.</option>
</div>
<!-- /��������� -> ������ -> ����� GSM -->
<!-- ��������� -> ������ -> ��������� GSM -->
<div class="cost no_display" id="cost_ru10">
 <option value="0"></option>
 <option value="9797">211.86 ���.</option>
 <option value="8510">258.31 ���.</option>
 <option value="8503">99.15 ���.</option>
 <option value="8355">89.83 ���.</option>
 <option value="8155">60.17 ���.</option>
</div>
<!-- /��������� -> ������ -> ��������� GSM -->
<!-- ��������� -> ������ -> ������ -->
<div class="cost no_display" id="cost_ru11">
 <option value="0"></option>
 <option value="9797">177.97 ���.</option>
 <option value="8510">296.61 ���.</option>
 <option value="8503">99 ���.</option>
 <option value="8355">89.83 ���.</option>
 <option value="8155">60.17 ���.</option>
</div>
<!-- /��������� -> ������ -> ������ -->
<!-- ��������� -> ������ -> �������� GSM -->
<div class="cost no_display" id="cost_ru12">
 <option value="0"></option>
 <option value="9797">177 ���.</option>
 <option value="8510">254.24 ���.</option>
 <option value="8503">98.42 ���.</option>
 <option value="8355">84.36 ���.</option>
 <option value="8155">56.24 ���.</option>
</div>
<!-- /��������� -> ������ -> �������� GSM -->
<!-- ��������� -> ������ -> ���� GSM -->
<div class="cost no_display" id="cost_ru13">
 <option value="0"></option>
 <option value="9797">177 ���.</option>
 <option value="8355">99 ���.</option>
 <option value="8155">66 ���.</option>
</div>
<!-- /��������� -> ������ -> ���� GSM -->
<!-- ��������� -> ������ -> ������������� -->
<div class="cost no_display" id="cost_ru14">
 <option value="0"></option>
 <option value="9797">177 ���.</option>
 <option value="8510">296.61 ���.</option>
 <option value="8503">99 ���.</option>
 <option value="8355">99 ���.</option>
 <option value="8155">66 ���.</option>
</div>
<!-- /��������� -> ������ -> ������������� -->
<!-- ��������� -> ������ -> ������������� -->
<div class="cost no_display" id="cost_ru15">
 <option value="0"></option>
 <option value="9797">177 ���.</option>
 <option value="8510">296.61 ���.</option>
 <option value="8503">99 ���.</option>
 <option value="8355">90 ���.</option>
 <option value="8155">60 ���.</option>
</div>
<!-- /��������� -> ������ -> ������������� -->
<!-- ��������� -> ������ -> ���������� -->
<div class="cost no_display" id="cost_ru16">
 <option value="0"></option>
 <option value="9797">177 ���.</option>
 <option value="8355">99 ���.</option>
 <option value="8155">66 ���.</option>
</div>
<!-- /��������� -> ������ -> ���������� -->
<!-- ��������� -> ������ -> ����� -->
<div class="cost no_display" id="cost_ru17">
 <option value="0"></option>
 <option value="9797">177 ���.</option>
 <option value="8510">270 ���.</option>
 <option value="8503">99 ���.</option>
 <option value="8355">99 ���.</option>
 <option value="8155">66 ���.</option>
</div>
<!-- /��������� -> ������ -> ����� -->
<!-- ��������� -> ������ -> ��������� GSM -->
<div class="cost no_display" id="cost_ru18">
 <option value="0"></option>
 <option value="9797">177 ���.</option>
 <option value="8510">296.61 ���.</option>
 <option value="8503">99 ���.</option>
 <option value="8355">99 ���.</option>
 <option value="8155">66 ���.</option>
</div>
<!-- /��������� -> ������ -> ��������� GSM -->
<!-- ��������� -> ������ -> ���� -->
<div class="cost no_display" id="cost_ru19">
 <option value="0"></option>
 <option value="9797">177 ���.</option>
 <option value="8510">296.61 ���.</option>
 <option value="8503">99 ���.</option>
 <option value="8355">99 ���.</option>
 <option value="8155">66 ���.</option>
</div>
<!-- /��������� -> ������ -> ���� -->
<!-- ��������� -> ������ -> ��������������� -->
<div class="cost no_display" id="cost_ru20">
 <option value="0"></option>
 <option value="9797">152.54 ���.</option>
 <option value="8510">260.17 ���.</option>
 <option value="8503">90.68 ���.</option>
 <option value="8355">90.68 ���.</option>
 <option value="8155">60.17 ���.</option>
</div>
<!-- /��������� -> ������ -> ��������������� -->
<!-- ��������� -> ������ -> ��� -->
<div class="cost no_display" id="cost_ru21">
 <option value="0"></option>
 <option value="9797">169 ���.</option>
 <option value="8510">260 ���.</option>
 <option value="8503">101.5 ���.</option>
 <option value="8355">86.71 ���.</option>
 <option value="8155">58 ���.</option>
</div>
<!-- /��������� -> ������ -> ��� -->
<!-- ��������� -> ������� -> MTC (UMC) -->
<div class="cost no_display" id="cost_ua1">
 <option value="0"></option>
 <option value="2855">25 ���.</option>
 <option value="3855">50 ���.</option>
 <option value="7204">12.4 ���.</option>
 <option value="7212">8 ���.</option>
</div>
<!-- /��������� -> ������� -> MTC (UMC) -->
<!-- ��������� -> ������� -> life:) -->
<div class="cost no_display" id="cost_ua2">
 <option value="0"></option>
 <option value="2855">25 ���.</option>
 <option value="3855">50 ���.</option>
 <option value="7204">12.4 ���.</option>
 <option value="7212">8 ���.</option>
</div>
<!-- /��������� -> ������� -> life:) -->
<!-- ��������� -> ������� -> Kyivstar -->
<div class="cost no_display" id="cost_ua3">
 <option value="0"></option>
 <option value="2855">25 ���.</option>
 <option value="3855">50 ���.</option>
 <option value="7204">12.4 ���.</option>
 <option value="7212">8 ���.</option>
</div>
<!-- /��������� -> ������� -> Kyivstar -->
<!-- ��������� -> ����������� -> Bakcell -->
<div class="cost no_display" id="cost_az1">
 <option value="0"></option>
 <option value="3301">0.9 AZN</option>
 <option value="3302">2 AZN</option>
 <option value="3303">3 AZN</option>
 <option value="3304">5 AZN</option>
</div>
<!-- /��������� -> ����������� -> Bakcell -->
<!-- ��������� -> ����������� -> Nar Mobile (Azerfon) -->
<div class="cost no_display" id="cost_az2">
 <option value="0"></option>
 <option value="3301">0.75 AZN</option>
 <option value="3302">1.99 AZN</option>
 <option value="3303">2.99 AZN</option>
 <option value="3304">4.99 AZN</option>
</div>
<!-- /��������� -> ����������� -> Nar Mobile (Azerfon) -->
<!-- ��������� -> ����������� -> Azercell Telekom -->
<div class="cost no_display" id="cost_az3">
 <option value="0"></option>
 <option value="4448">0.8 AZN</option>
 <option value="8171">4 AZN</option>
</div>
<!-- /��������� -> ����������� -> Azercell Telekom -->
<!-- ��������� -> ������� -> �������� -->
<div class="cost no_display" id="cost_ar1">
 <option value="0"></option>
 <option value="7122">1666.67 AMD</option>
 <option value="7132">833.33 AMD</option>
 <option value="8161">1416.67 AMD</option>
</div>
<!-- /��������� -> ������� -> �������� -->
<!-- ��������� -> ������� -> �������� -->
<div class="cost no_display" id="cost_ar2">
 <option value="0"></option>
 <option value="4446|dx">333.33 AMD</option>
 <option value="4449|dx">1000 AMD</option>
 <option value="7122">1666.67 AMD</option>
 <option value="7132">833.33 AMD</option>
 <option value="8161|dx">1416.67 AMD</option>
</div>
<!-- /��������� -> ������� -> �������� -->
<!-- ��������� -> ���������� -> life :) -->
<div class="cost no_display" id="cost_by1">
 <option value="0"></option>
 <option value="3336">15900 byr</option>
 <option value="3337">9900 byr</option>
 <option value="3338">6900 byr</option>
 <option value="3339">29900 byr</option>
</div>
<!-- /��������� -> ���������� -> life :) -->
<!-- ��������� -> ���������� -> ��� �������� -->
<div class="cost no_display" id="cost_by2">
 <option value="0"></option>
 <option value="3336">15900 byr</option>
 <option value="3337">9900 byr</option>
 <option value="3338">6900 byr</option>
 <option value="3339">29900 byr</option>
</div>
<!-- /��������� -> ���������� -> ��� �������� -->
<!-- ��������� -> ���������� -> ������ -->
<div class="cost no_display" id="cost_by3">
 <option value="0"></option>
 <option value="3336">15900 byr</option>
 <option value="3337">9900 byr</option>
 <option value="3338">6900 byr</option>
 <option value="3339">29900 byr</option>
</div>
<!-- /��������� -> ���������� -> ������ -->
<!-- ��������� -> ���������� -> diallog -->
<div class="cost no_display" id="cost_by4">
 <option value="0"></option>
 <option value="3336">9900 byr</option>
 <option value="3337">6900 byr</option>
 <option value="3338">2900 byr</option>
</div>
<!-- /��������� -> ���������� -> diallog -->
<!-- ��������� -> �������� -> T-Mobile -->
<div class="cost no_display" id="cost_ger1">
 <option value="0"></option>
 <option value="88088|WWWDX">8.39 EUR</option>
</div>
<!-- /��������� -> �������� -> T-Mobile -->
<!-- ��������� -> �������� -> Vodafone -->
<div class="cost no_display" id="cost_ger2">
 <option value="0"></option>
 <option value="88088|WWWDX">8.39 EUR</option>
</div>
<!-- /��������� -> �������� -> Vodafone -->
<!-- ��������� -> �������� -> ePlus -->
<div class="cost no_display" id="cost_ger3">
 <option value="0"></option>
 <option value="88088|WWWDX">8.39 EUR</option>
</div>
<!-- /��������� -> �������� -> ePlus -->
<!-- ��������� -> �������� -> O2 -->
<div class="cost no_display" id="cost_ger4">
 <option value="0"></option>
 <option value="88088|WWWDX">8.39 EUR</option>
</div>
<!-- /��������� -> �������� -> O2 -->
<!-- ��������� -> �������� -> Talkline -->
<div class="cost no_display" id="cost_ger5">
 <option value="0"></option>
 <option value="88088|WWWDX">8.39 EUR</option>
</div>
<!-- /��������� -> �������� -> Talkline -->
<!-- ��������� -> �������� -> Debitel -->
<div class="cost no_display" id="cost_ger6">
 <option value="0"></option>
 <option value="88088|WWWDX">8.39 EUR</option>
</div>
<!-- /��������� -> �������� -> Debitel -->
<!-- ��������� -> �������� -> Mobilcom -->
<div class="cost no_display" id="cost_ger7">
 <option value="0"></option>
 <option value="88088|WWWDX">8.39 EUR</option>
</div>
<!-- /��������� -> �������� -> Mobilcom -->
<!-- ��������� -> ������ -> Magticom -->
<div class="cost no_display" id="cost_gru1">
 <option value="0"></option>
 <option value="4107|dx">4.2 GEL</option>
 <option value="4161|dx">7.46 GEL</option>
 <option value="4445|dx">1.02 GEL</option>
</div>
<!-- /��������� -> ������ -> Magticom -->
<!-- ��������� -> ������ -> Geocell -->
<div class="cost no_display" id="cost_gru2">
 <option value="0"></option>
 <option value="4445|dx">1.02 GEL</option>
</div>
<!-- /��������� -> ������ -> Geocell -->
<!-- ��������� -> ������� -> Orange -->
<div class="cost no_display" id="cost_iz1">
 <option value="0"></option>
 <option value="5550|dx">17.35 ILS</option>
</div>
<!-- /��������� -> ������� -> Orange -->
<!-- ��������� -> ������� -> Cellcom -->
<div class="cost no_display" id="cost_iz2">
 <option value="0"></option>
 <option value="5550|dx">17.35 ILS</option>
</div>
<!-- /��������� -> ������� -> Cellcom -->
<!-- ��������� -> ������� -> Pelephone -->
<div class="cost no_display" id="cost_iz3">
 <option value="0"></option>
 <option value="5550|dx">17.35 ILS</option>
</div>
<!-- /��������� -> ������� -> Pelephone -->
<!-- ��������� -> ������� -> MIRS -->
<div class="cost no_display" id="cost_iz4">
 <option value="0"></option>
 <option value="5550|dx">17.35 ILS</option>
</div>
<!-- /��������� -> ������� -> MIRS -->
<!-- ��������� -> ��������� -> ���-��� -->
<div class="cost no_display" id="cost_kz1">
 <option value="0"></option>
 <option value="7122">530.36 kzt</option>
 <option value="7132">265.18 kzt</option>
</div>
<!-- /��������� -> ��������� -> ���-��� -->
<!-- ��������� -> ��������� -> GSM ��������� -->
<div class="cost no_display" id="cost_kz2">
 <option value="0"></option>
 <option value="7122">530.36 kzt</option>
 <option value="7132">265.18 kzt</option>
</div>
<!-- /��������� -> ��������� -> GSM ��������� -->
<!-- ��������� -> ��������� -> ����� -->
<div class="cost no_display" id="cost_kz3">
 <option value="0"></option>
 <option value="7122">530.36 kzt</option>
 <option value="7132">265.18 kzt</option>
</div>
<!-- /��������� -> ��������� -> ����� -->
<!-- ��������� -> ��������� -> ������ �������-������ -->
<div class="cost no_display" id="cost_kz4">
 <option value="0"></option>
 <option value="7122">530.36 kzt</option>
 <option value="7132">265.18 kzt</option>
</div>
<!-- /��������� -> ��������� -> ������ �������-������ -->
<!-- ��������� -> �������� -> Fonex -->
<div class="cost no_display" id="cost_kir1">
 <option value="0"></option>
 <option value="7122">183.41 kgs</option>
 <option value="7132">91.7 kgs</option>
</div>
<!-- /��������� -> �������� -> Fonex -->
<!-- ��������� -> �������� -> Nexi (Sotel) -->
<div class="cost no_display" id="cost_kir2">
 <option value="0"></option>
 <option value="7122">183.41 kgs</option>
 <option value="7132">91.7 kgs</option>
</div>
<!-- /��������� -> �������� -> Nexi (Sotel) -->
<!-- ��������� -> �������� -> Katel -->
<div class="cost no_display" id="cost_kir3">
 <option value="0"></option>
 <option value="7122">183.41 kgs</option>
 <option value="7132">91.7 kgs</option>
</div>
<!-- /��������� -> �������� -> Katel -->
<!-- ��������� -> �������� -> MegaCom -->
<div class="cost no_display" id="cost_kir4">
 <option value="0"></option>
 <option value="7122">183.41 kgs</option>
 <option value="7132">91.7 kgs</option>
</div>
<!-- /��������� -> �������� -> MegaCom -->
<!-- ��������� -> �������� -> Beeline (Bitel. Mobi) -->
<div class="cost no_display" id="cost_kir5">
 <option value="0"></option>
 <option value="7122">2.62 usd</option>
 <option value="7132">2.18 usd</option>
</div>
<!-- /��������� -> �������� -> Beeline (Bitel. Mobi) -->
<!-- ��������� -> ������ -> ����2 -->
<div class="cost no_display" id="cost_lat1">
 <option value="0"></option>
 <option value="8385|XXXDX">4.1 LVL</option>
</div>
<!-- /��������� -> ������ -> ����2 -->
<!-- ��������� -> ������ -> LMT -->
<div class="cost no_display" id="cost_lat2">
 <option value="0"></option>
 <option value="8385|XXXDX">4.1 LVL</option>
</div>
<!-- /��������� -> ������ -> LMT -->
<!-- ��������� -> ������ -> Bite GSM -->
<div class="cost no_display" id="cost_lat3">
 <option value="0"></option>
 <option value="8385|XXXDX">4.1 LVL</option>
</div>
<!-- /��������� -> ������ -> Bite GSM -->
<!-- ��������� -> ������ -> Omnitel -->
<div class="cost no_display" id="cost_lit1">
 <option value="0"></option>
 <option value="1896|MMMDX">9.92 ltl</option>
</div>
<!-- /��������� -> ������ -> Omnitel -->
<!-- ��������� -> ������ -> Bite GSM -->
<div class="cost no_display" id="cost_lit2">
 <option value="0"></option>
 <option value="1896|MMMDX">9.92 ltl</option>
</div>
<!-- /��������� -> ������ -> Bite GSM -->
<!-- ��������� -> ������ -> ����2 -->
<div class="cost no_display" id="cost_lit3">
 <option value="0"></option>
 <option value="1896|MMMDX">9.92 ltl</option>
</div>
<!-- /��������� -> ������ -> ����2 -->
<!-- ��������� -> ����������� -> MLT -->
<div class="cost no_display" id="cost_tad1">
 <option value="0"></option>
 <option value="4161|dx">5 USD</option>
 <option value="4446|dx">2 USD</option>
 <option value="4449|dx">3 USD</option>
</div>
<!-- /��������� -> ����������� -> MLT -->
<!-- ��������� -> ����������� -> Indigo Somonkom -->
<div class="cost no_display" id="cost_tad2">
 <option value="0"></option>
 <option value="4161|dx">5 USD</option>
 <option value="4446|dx">2 USD</option>
 <option value="4449|dx">3 USD</option>
</div>
<!-- /��������� -> ����������� -> Indigo Somonkom -->
<!-- ��������� -> ����������� -> TT Mobile -->
<div class="cost no_display" id="cost_tad3">
 <option value="0"></option>
 <option value="4161|dx">5 USD</option>
 <option value="4446|dx">2 USD</option>
 <option value="4449|dx">3 USD</option>
</div>
<!-- /��������� -> ����������� -> TT Mobile -->
<!-- ��������� -> ����������� -> MTEKO -->
<div class="cost no_display" id="cost_tad4">
 <option value="0"></option>
 <option value="4161|dx">5 USD</option>
 <option value="4446|dx">2 USD</option>
 <option value="4449|dx">3 USD</option>
</div>
<!-- /��������� -> ����������� -> MTEKO -->
<!-- ��������� -> ����������� -> Indigo Tajikistan -->
<div class="cost no_display" id="cost_tad5">
 <option value="0"></option>
 <option value="4161|dx">5 USD</option>
 <option value="4446|dx">2 USD</option>
 <option value="4449|dx">3 USD</option>
</div>
<!-- /��������� -> ����������� -> Indigo Tajikistan -->
<!-- ��������� -> ������� -> EMT -->
<div class="cost no_display" id="cost_est1">
 <option value="0"></option>
 <option value="13015|dx">2.08 EUR</option>
 <option value="13017|dx">2.67 EUR</option>
 <option value="15330|dx">0.8 EUR</option>
</div>
<!-- /��������� -> ������� -> EMT -->
<!-- ��������� -> ������� -> Radiolinija Eesti -->
<div class="cost no_display" id="cost_est2">
 <option value="0"></option>
 <option value="13015|dx">2.08 EUR</option>
 <option value="13017|dx">2.67 EUR</option>
 <option value="15330|dx">0.8 EUR</option>
</div>
<!-- /��������� -> ������� -> Radiolinija Eesti -->
<!-- ��������� -> ������� -> ����2 -->
<div class="cost no_display" id="cost_est3">
 <option value="0"></option>
 <option value="13015|dx">2.08 EUR</option>
 <option value="13017|dx">2.67 EUR</option>
 <option value="15330|dx">0.8 EUR</option>
</div>

<!-- /��������� -> ������� -> ����2 --></div>
 </div>



 </div><div id="loading" style="margin-top:287.5px"><div class="loadstyle"></div></div>