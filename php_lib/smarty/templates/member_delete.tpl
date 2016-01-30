
[<a href="{$SCRIPT_NAME}">トップへ</a>]
<div align="center">
<form {$form.attributes}>
<br><br><br>
<font color="red">{$title}</font>
<br><br><br>
{$message}
<br><br><br><br>

{if $form.submit1.value}
{$form.submit1.html}&nbsp;
{/if}

<INPUT type='hidden' name='type' value={$type}>
<INPUT type='hidden' name ='action' value ={$action}>

</form>
</div>

