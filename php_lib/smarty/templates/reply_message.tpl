
<html>
<head>
        <title>{$title}</title>
</head>

{$form.javascript}

<br>
[ <A href="member.php">トップへ</A> ]

<br><br>
<div align="center">

<font size="5">{$title}</font>

<br><br>

{$message}

<br><br><br>

<form {$form.attributes}>
<table border="0" width="355" cellspacing="0" cellpadding="3">
    <tr>
        <td>
<font color="blue">{$form.subject.label}</font>：
        </td>
   </tr>
{if $form.subject.error}
   <tr>
       <td>
    <font color="red">{$form.subject.error}</font>
       </td>
   </tr>    
{/if} 
   <tr>
       <td>
{$form.subject.html}
       </td>
   </tr>
   <tr>
   <td>&nbsp;</td>
   </tr>
   <tr>
   <td>&nbsp;</td>
   </tr>
   <tr>
       <td>
<font color="blue">{$form.body.label}</font>：
       </td>
   </tr>    
{if $form.body.error}
    <tr>
        <td>
    <font color="red">{$form.body.error}</font>
        </td>
    </tr>    
{/if}
    <tr>
       <td>
{$form.body.html}
       </td>
    </tr>
</table>    
    
    
<br><br><br>

{$form.submit1.html}&nbsp;
{if ($form.submit2.value != "")}
{$form.submit2.html}
{elseif ($form.reset.value != "")}
{$form.reset.html}
{else}
    <INPUT type="button" value="戻る" onClick="history.go(-1);">
{/if}


<INPUT type="hidden"  name="type"   value="{$type}">
<INPUT type="hidden"  name="action" value="{$action}">

</div>
</form>

</html>

