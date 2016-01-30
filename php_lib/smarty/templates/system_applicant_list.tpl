

<html>
    <head>
        <title>{$title}</title>
    </head>

[<A href ="system.php">戻る</A>]<br>

<div align="center">
    
<br><br><br>    

<font size="4"><b>{$title}</b></font>

<br><br>

    <font color="red">{$message}</font>
    
<br><br><br><br>

{if $data}
    


<table border="1" width="" cellspacing="1" cellpadding="6">
    
<tr>
    <th><font color="blue" size="2">応募者</font></th>
    <th><font color="blue" size="2">年齢</font></th>
    <th><font color="blue" size="2">応募日時</font></th>
    <th><font color="blue" size="2">応募先の企業</font></th>
    <th><font color="blue" size="2">応募案件</font></th>
    <th><font color="blue" size="2">企業対応状況</font></th>
</tr>    

{foreach item=item from=$data}
    <form method="post" action="customer.php?type=applicant_detail">
<tr>
    <td align="center"><font size="2">{$item.member_name}</font></td>
    <td align="center"><font size="2">{$item.member_age}</font></td>
    <td><font size="2">{$item.project_reg_date}</font></td>
    <td><font size="2">{$item.company_name}</font></td>
    <td><font size="2"><a href="system.php?type=detail_project&project_id={$item.project_id}">{$item.project_title|truncate:15}</A></font></td>
    <td align="center"><font size="2">{$item.process}</font></td>
</tr>    
    </form>
{/foreach}

</table>
<br>{$links}


{else}
    <font color="red">--現在、応募者はいません--</font>
{/if}

</div>
</html>

