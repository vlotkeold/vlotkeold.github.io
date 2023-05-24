<link media="screen" href="{theme}/style/wk.css" type="text/css" rel="stylesheet" />
<link media="screen" href="{theme}/style/jobs.css" type="text/css" rel="stylesheet" />
<div class="err_yellow no_display" id="result"></div> 
      <form id="jobs_apply_form" class="jobs_form jobs_apply_form" onsubmit="return false">

        <h1>Расскажите нам о себе</h1>
        <div id="jobs_apply_main_error_holder"></div>
        <table cellpadding="0" cellspacing="0">
          <tbody>
		  <tr>
            <td class="labeled"><input type="hidden" class="text" id="namejob" name="namejob" value="{android}" maxlength="64"></td>
          </tr>
          <tr>
            <td class="label">Имя и фамилия:</td>
            <td class="labeled"><input autocomplete="off" type="text" class="text" id="name" name="name" value="{name_user}" maxlength="64"></td>
          </tr>
          <tr>
            <td class="label">Телефон:</td>
            <td class="labeled"><input autocomplete="off" type="text" class="text" id="phone" name="phone" maxlength="64"></td>
          </tr>
          <tr>
            <td class="label">Email:</td>
            <td class="labeled"><input autocomplete="off" type="text" class="text" id="email" name="email" maxlength="64"></td>
          </tr>
          <tr>
            <td class="label last">Расскажите о себе и своем опыте:</td>
            <td class="labeled last">
              <textarea name="description" class="jobs_apply_about" id="description" onkeyup="checkTextLength(3584, this, 'jobs_apply_about_text_warn')" maxlength="3584" style="overflow: hidden; resize: none; height: 100px;"></textarea>
              <div id="jobs_apply_about_text_warn" class="jobs_text_warn"></div>
            </td>
          </tr>
        </tbody></table>

        <table cellpadding="0" cellspacing="0" class="jobs_apply_submit_wrap">
          <tbody><tr><td class="label"></td>
          <td class="labeled">
            <div class="button_blue"><button type="submit" id="sending" onclick="Jobs.send()">Отправить</button></div>
          </td>
        </tr></tbody></table>
      </form>
    </div>
  </div>