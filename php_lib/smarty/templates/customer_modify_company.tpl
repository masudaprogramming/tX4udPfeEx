<html>
<head>
        <title>{$title}</title>
</head>

{$form.javascript}
{if $is_system}
[<A href ="system.php?type=customer_list">戻る</A>]
{else}
[<A href ="customer.php">戻る</A>]
{/if}
<br>
<div align="center">
    
<form {$form.attributes}>    
<font size = "5">{$title}</font><br><br><br>

{if $message}
<font color="red">{$message}</font><br><br><br>
{/if}

<br>
＜基本情報＞<br><br>

<table width="500" cellspacing="0" cellpadding="5" >

{if $form.company_name.error}        
<tr><td colspan="2" align="center"><font color="red">{$form.company_name.error}</font></td></tr>        
{/if}
<tr><td align="right">
<font color="blue">{$form.company_name.label}</font>：</td><td>{$form.company_name.html}
</td></tr>

{if $form.mail.error}        
<tr><td colspan="2" align="center"><font color="red">{$form.mail.error}</font></td></tr>        
{/if}
<tr><td align="right">
<font color="blue">{$form.mail.label}</font>：</td><td>{$form.mail.html}
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

<tr><td colspan="2" align="center"><font color="blue">{$form.appeal.label}</font></td></tr>
{if $form.appeal.error}        
<tr><td colspan="2" align="center"><font color="red">{$form.appeal.error}</font></td></tr>        
{/if}
<tr><td colspan="2" align="center">{$form.appeal.html}</td></tr>

</table>

<br><br>
＜担当者情報＞<br><br>
{if $form.last_name.error}
<font color="red">{$form.last_name.error}</font><br>
{/if}
<font color="blue">{$form.last_name.label}</font>：{$form.last_name.html}<br><br>

{if $form.first_name.error}
<font color="red">{$form.first_name.error}</font><br>
{/if}
<font color="blue">{$form.first_name.label}</font>：{$form.first_name.html}<br>

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


