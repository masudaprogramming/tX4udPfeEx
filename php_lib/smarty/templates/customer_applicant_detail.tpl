<html>
<head>
        <title>{$title}</title>
</head>

{$form.javascript}
[<a href="customer.php?type=applicant_list&{$add_pageID}">一覧へ</a>]

<div align="center">

<br><br><br>

<font size="5">{$title}</font>

<br><br><br>

<font color="red">{$message}</font>

<br><br><br>

<form {$form.attributes}>
    
<table border="1" width="465" cellspacing="0" cellpadding="3">
    <tr>
        <td width="120" align="center"><font color="blue">応募日時</font></td>
        <td>{$data.project_reg_date}</td>
    </tr>
    <tr>
        <td align="center"><font color="blue">応募者名</font></td>
        <td>{$data.last_name|escape:"html"}&nbsp;{$data.first_name|escape:"html"}</td>
    </tr>
    <tr>
        <td align="center"><font color="blue">年齢</font></td>
        <td>{$data.age}</td>
    </tr>
    <tr>
        <td align="center"><font color="blue">性別</font></td>
        <td>{$data.gender}</td>
    </tr>
    <tr>
        <td align="center"><font color="blue">希望勤務開始</font></td>
        <td>{$data.hope_start}</td>
    </tr>
        <tr>
        <td align="center"><font color="blue">アピール</font></td>
        <td>{$data.expe_appeal|escape:"html"}</td>
    </tr>
</table>
    
    <br><br><br>

<table border="1" width="465" cellspacing="0" cellpadding="3">    
    <tr>
        <td align="center"><font color="blue">開発中</font></td>
    </tr>
    <tr>
        <td>開発中</td>
    </tr>
</table>

<br><br><br>

{$form.submit1.html}&nbsp;
{if ($form.submit2.value != "")}
{$form.submit2.html}
{elseif ($form.reset.value != "")}
{$form.reset.html}
{else}
    <INPUT type="button" value="前へ" onClick="history.go(-1);">
{/if}


<INPUT type="hidden"  name="type"   value={$type}>
<INPUT type="hidden"  name="action" value={$action}>

</form>
</div>

</html>
