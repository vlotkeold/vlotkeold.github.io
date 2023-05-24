
<div class="miniature_box">

<div class="miniature_pos" style="width:500px">

<div class="box_title" style="margin:-20px -20px 0 -20px">

<a class="cursor_pointer fl_r" onClick="viiBox.clos('vbalance', 1)">Закрыть</a>

<div class="fl_l">Вывод голосов</div>

<div class="clear"></div>

</div>

<div class="cover_edit_title" style="margin: 0 -20px;">Вывод</div>

<div class="apps_sett_section" style="margin:15px 0;line-height: 30px;">

<table class="apps_edit_vites_sett" cellpadding="0" cellspacing="0"><tbody>

<tr><td class="app_sett_pay_label" style="width:200px">Текущий баланс:</td><td id="app_new_votes">{app_balance}</td></tr>

<tr><td class="app_sett_pay_label" style="width:200px">Снять:</td><td style="width:150px">

<input type="text" name="add" id="app_pay_add" value="0" class="inpst" maxlength="8" style="width:40px; margin-right:10px;">голосов

</td></tr></tbody></table>

</div>

<input type="hidden" id="balance" value="{balance}" />

<input type="hidden" id="userid" value="{userid}" />
   

<div class="button_div fl_r" style="margin-left:210px;margin-top:15px"><button onClick="AppsEdit.saveVbalance('{id}','{hash}')" id="save">Cохранить</button></div>

<div class="clear"></div>

</div>

<div class="clear" style="height:50px"></div>

</div>
