
<html>
<head>
        <title>{$title}</title>
</head>

[ <A href="{$SCRIPT_NAME}">トップページへ</A> ]
<br>
<div align="center">
    
<br><br>
{if $message}
<font size="4" color="red">{$message}</font><br><br>
{/if}
<br><br>

<font color="blue">{$title}</font><br><br>
<font color="red" size="4">--会員の方はログインしてください--</font><br><br><br>

<form {$form.attributes}>

{$form.mail.label}{$form.mail.html}<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$form.password.label}{$form.password.html}<br>
<br><br>
{$form.submit.html}


<INPUT type="hidden" name="type" value="{$type}">
<INPUT type="hidden" name="action" value="{$action}">

<br><br><br><br><br><br>

<font color="blue">アカウントをお持ちでない方は下記よりご登録ください。</font>
<br><br><br>
<a href="index.php?type=regist">--新規会員登録--</a>

</form>
</div>

</html>
