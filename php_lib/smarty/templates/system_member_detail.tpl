
<html>
<head>
        <title>{$title}</title>
</head>

{$form.javascript}

[<a href="system.php?type=member_list">戻る</a>]
<div align = "center">  
<font size="4">{$title}</font>
<br><br>

<font size="2" color="red">{$message}</font>

<br><br><br>

<form method="post" action="system.php?type=modify_or_delete">
    
    <table border="0" cellspacing="0" cellpadding="5" >
<tr><td align="right"><font color="blue">member id</font>&nbsp;：</td><td>{$id}</td></tr>
<tr><td align="right"><font color="blue">{$form.mail.label}</font>&nbsp;：</td><td>{$form.mail.html}</td></tr>
<tr><td align="right"><font color="blue">{$form.last_name.label}</font>&nbsp;：</td><td>{$form.last_name.html}</td></tr>
<tr><td align="right"><font color="blue">{$form.first_name.label}</font>&nbsp;：</td><td>{$form.first_name.html}</td></tr>
<tr><td align="right"><font color="blue">{$form.birthday.label}</font>&nbsp;：</td><td>{$birthday}</td></tr>
<tr><td align="right"><font color="blue">{$form.gender.label}</font>&nbsp;：</td>
    <td>
        {if $gender == 1}
            男
        {else if $gender == 2}
            女
        {/if}
    </td>
</tr>
<tr><td align="right"><font color="blue">お仕事スタート</font>：&nbsp;</td><td>{$hope_start}</td></tr>
    </table>   

<br>

<table border="0" cellspacing="0" cellpadding="5" >    
<tr>
    <td colspan="2" align="center"><font color="blue">希望の勤務地</font></td>
</tr>
<tr>
    <td align="right">希望勤務地1：</td><td>{$form.area_type1.html}</td>
</tr>
{if ($form.area_type2.value != "")}
<tr>    
    <td align="right">希望勤務地2：</td><td>{$form.area_type2.html}</td>
</tr>
{/if}

{if ($form.area_type3.value != "")}
<tr>    
    <td align="right">希望勤務地3：</td><td>{$form.area_type3.html}</td>
</tr>
{/if}

</table>

<br>

<table border="0" cellspacing="0" cellpadding="5" >
    <tr>
        <td colspan="2" align="center"><font color="blue">希望の職種</font></td>  
    </tr>    
{foreach item=item from=$data}
    <tr>
      <td>*&nbsp;{$item}</td>  
    </tr>
{/foreach}
</table>
<br><br>

<font color="blue">お仕事への意気込み</font><br><br>{$form.expe_appeal.html}

<br><br><br>

<table border="0" cellspacing="0" cellpadding="1" >
    <tr>
<td>{$form.submit1.html}</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td>{$form.submit2.html}</td>
    </tr>
</table>

    <INPUT type="hidden" name="system_delete" value="on">    
   
</form>
</div>

</html>
