<html>
<head>
    <title>{$title}</title>
</head>

<form {$form.attributes}>

<div align="center">
<font color="red">{$title}</font>
<br><br><br>
{$message}
<br><br>

{if $form.submit1.value}
{$form.submit1.html}&nbsp;
{/if}

<INPUT type='hidden' name='type' value={$type}>
<INPUT type='hidden' name ='action' value ={$action}>

</form>

</div>

</html>
