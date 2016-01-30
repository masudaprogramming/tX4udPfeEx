
<html>
    <head>
        <title>{$title}</title>
    </head>

{$form.javascript}

[<a href="{$SCRIPT_NAME}">トップへ</a>]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
{if !($is_system)}
[<a href="{$SCRIPT_NAME}?type=all_projects">お仕事一覧へ</a>]<br><br><br><br>
{/if}

<form {$form.attributes}>
    
<div align="center">
    {$title}<br><br><br>
    {if $message != ""}
        <font color="red">{$message}</font><br><br><br>
    {/if}
    
   {if $form.mail.error}
       <font color="red" size="2">{$form.mail.error}</font><br>
   {/if}

   <font color="blue">{$form.mail.label}</font>：{$form.mail.html}<br><br><br>
  
   {if $form.password.error}
        <font color="red" size="2">{$form.password.error}</font><br>
   {/if}

&nbsp;&nbsp;&nbsp;&nbsp;<font color="blue">{$form.password.label}</font>：{$form.password.html}<br><br>
   
   
    {if $form.password2.error}
        <font color="red" size="2">{$form.password2.error}</font><br>
   {/if}

   <font color="blue">{$form.password2.label}</font>：{$form.password2.html}<br><br><br>

  
{if $form.last_name.error}
    <font color="red" size="2">{$form.last_name.error}</font><br>
{/if}

<font color="blue">{$form.last_name.label}</font>：{$form.last_name.html}<br><br>

{if $form.first_name.error}
    <font color="red" size="2">{$form.first_name.error}</font><br>
{/if}


<font color="blue">{$form.first_name.label}</font>：{$form.first_name.html}<br><br>

<font color="blue">{$form.birthday.label}</font>：{$form.birthday.html}<br><br>

 {if $form.gender.error}
    <font color="red" size="2">{$form.gender.error}</font><br>
{/if}   
<font color="blue">{$form.gender.label}</font>：{$form.gender.html}<br><br><br>

{$form.submit1.html}&nbsp;
{if ($form.submit2.value != "")}
{$form.submit2.html}
{elseif ($form.reset.value != "")}
{$form.reset.html}
{else}
    <INPUT type="button" value="戻る" onClick="history.go(-1);">
{/if}


<INPUT type='hidden' name='type' value={$type}>
<INPUT  type='hidden' name ='action' value ={$action}>

</div>

</form>

</html>
