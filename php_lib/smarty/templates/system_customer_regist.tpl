
<html>
<head>
        <title>{$title}</title>
</head>

{$form.javascript}

[<A href ="system.php">戻る</A>]
<br>
<div align="center">
    
<form {$form.attributes}>    
<font size = "5">{$title}</font><br><br><br>

{if $message}
<font color="red">{$message}</font><br><br><br>
{/if}

<br>
<font size="2" color="red" >--基本情報--</font><br><br>
<table width="500" cellspacing="0" cellpadding="5" >

{if $form.company_name.error}        
<tr><td colspan="2" align="center"><font color="red">{$form.company_name.error}</font></td></tr>        
{/if}
<tr><td align="right">
<font color="blue">{$form.company_name.label}</font>：</td><td>{$form.company_name.html}
</td></tr>

{if $form.tel.error}        
<tr><td colspan="2" align="center"><font color="red">{$form.tel.error}</font></td></tr>        
{/if}
<tr><td align="right">
<font color="blue">{$form.tel.label}</font>：</td><td>{$form.tel.html}
</td></tr>

{if $form.address.error}        
<tr><td colspan="2" align="center"><font color="red">{$form.address.error}</font></td></tr>        
{/if}
<tr><td align="right">
<font color="blue">{$form.address.label}</font>：</td><td>{$form.address.html}
</td></tr>

<tr>
    <td></td>
</tr>

<tr><td colspan="2" align="left"><font color="blue">&nbsp;&nbsp;&nbsp;&nbsp;{$form.appeal.label}</font></td></tr>
{if $form.appeal.error}        
<tr><td colspan="2" align="center"><font color="red">{$form.appeal.error}</font></td></tr>        
{/if}
<tr><td colspan="2" align="center">{$form.appeal.html}</td></tr>
</table>

<br><br>

<font size="2" color="red" >--担当者情報--</font><br><br>
<table  border="0" width="500" cellspacing="0" cellpadding="5" >
{if $form.last_name.error}
<tr><td colspan="2" align="center" ><font color="red">{$form.last_name.error}</font></td></tr>
{/if}
<tr>
<td width="175" align="right"><font color="blue">{$form.last_name.label}</font>：</td>
<td>{$form.last_name.html}</td>
</tr>

{if $form.first_name.error}
<tr><td colspan="2" align="center" ><font color="red">{$form.first_name.error}</font></td></tr>
{/if}
<tr>
<td align="right"><font color="blue">{$form.first_name.label}</font>：</td>
<td>{$form.first_name.html}</td>
</tr>
</table>

<br><br>

<font size="2" color="red" >--アカウント情報--</font><br><br>
<table width="500" cellspacing="0" cellpadding="5" >    
{if $form.mail.error}        
<tr><td colspan="3" align="center"><font color="red">{$form.mail.error}</font></td></tr>        
{/if}
<tr>
    <td align="right"><font color="blue">{$form.mail.label}</font>：</td>
    <td colspan="2">{$form.mail.html}</td>
</tr>

{if $form.password.error}        
<tr><td colspan="3" align="center"><font color="red">{$form.password.error}</font></td></tr>        
{/if}
<tr>
    <td align="right"><font color="blue">{$form.password.label}</font>：</td>
    <td >{$form.password.html}</td>
    <td width="80" ><!--ここにパスを更新するボタンを入れてもOK--></td>
</tr>

</table>

<br><br>

{$form.submit1.html}&nbsp;
{if ($form.submit2.value != "")}
{$form.submit2.html}
{elseif ($form.reset.value != "")}
{$form.reset.html}
{else}
    <INPUT type="button" value="中止" onClick="history.go(-1);">
{/if}

<INPUT type="hidden"  name="type"   value={$type}>
<INPUT type="hidden"  name="action" value={$action}>
<INPUT type="hidden"  name="re"     value="re">


</div>
</form>

</html>




