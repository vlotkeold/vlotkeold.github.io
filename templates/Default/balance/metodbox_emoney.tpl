<link type="text/css" rel="stylesheet" href="/templates/Default/style/payment.css"></link>
<div class="miniature_box">
 <div class="miniature_pos" style="width:500px">
  <div class="payment_title">
   <img src="{ava}" width="50" height="50" />
   <div class="fl_l">
   ���������� ������� ����� ����������� ������.<br />
    ��� ������� ������: <b>{ubm}</b>
   </div>
   <div class="fl_r">
    <a class="cursor_pointer" onClick="viiBox.clos('mt_invite', 1)">�������</a>
   </div>
   <div class="clear"></div>
  </div>
  <div class="clear"></div>
 <center>
<form id=pay name=pay method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp"> 

<p>

<select type="text" name="LMI_PAYMENT_AMOUNT">  
<option value='5'>1 ����� / 5 ������</option>  
<option value='50'>10 ������� / 50 ������</option>  
<option value='100'>20 ������� / 100 ������</option> 
<option value='250'>50 ������� / 250 ������</option> 
</select>
  <input type="hidden" name="LMI_PAYMENT_DESC" value="FLYBEY | ���������� �������">
  <input type="hidden" name="LMI_PAYMENT_NO" value="{userid}">
  <input type="hidden" name="LMI_PAYEE_PURSE" value="R328580440455">
</p> 
<p>
<div class="button_div_gray fl_l" style="line-height:15px;margin-top:15px;margin-left:167px">
<button type="submit" value="submit" style="width:161px">��������� � Webmoney</button>
</div>
<div class="clear"></div>
 </p> 
</form> 




</center>
 </div>
 </div>