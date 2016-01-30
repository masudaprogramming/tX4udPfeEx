
<html>
<head>
        <title>{$title}</title>
</head>

{$form.javascript}

[<a href="{$SCRIPT_NAME}">トップへ</a>]<br><br><br>

<form {$form.attributes}>
<div align="center">
    {$title}<br><br><br>
    {if $message != ""}
        <font color="red">{$message}</font><br><br><br>
    {/if}

   {if $form.password_old.error}
        <font color="red" size="2">{$form.password_old.error}</font><br>
   {/if}

&nbsp;&nbsp;&nbsp;&nbsp;<font color="blue">{$form.password_old.label}</font>：{$form.password_old.html}<br><br><br><br>
    
    
   {if $form.password_new1.error}
        <font color="red" size="2">{$form.password_new1.error}</font><br>
   {/if}

<font color="blue">{$form.password_new1.label}</font>：{$form.password_new1.html}
<br><br>


    {if $form.password_new2.error}
        <font color="red" size="2">{$form.password_new2.error}</font><br>
   {/if}

   <font color="blue">{$form.password_new2.label}</font>：{$form.password_new2.html}<br><br><br>


{$form.submit1.html}&nbsp;
{if ($form.submit2.value != "")}
{$form.submit2.html}
    {else}
{$form.reset.html}
{/if}
<INPUT type='hidden' name='type' value={$type}>
<INPUT  type='hidden' name ='action' value ={$action}>

</div>

</form>

</html>

