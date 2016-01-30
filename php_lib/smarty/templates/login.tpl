
<html>
    <head>
        <title>{$title}</title>
    </head>
    
    
<br>
<div align="center"><br>
  
<br>
{$title}<br><br>
<font color="red">{$message}</font><br><br>

<form {$form.attributes}>

{$form.mail.label}{$form.mail.html}<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$form.password.label}{$form.password.html}<br>
<br><br>
{$form.submit.html}


<INPUT type="hidden" name="type" value="{$type}">
<INPUT type="hidden" name="action" value="{$action}">

</form>
</div>

</html>
