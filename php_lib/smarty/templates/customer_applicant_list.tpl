<html>
    <head>
        <title>{$title}</title>
    </head>

[<A href ="customer.php">戻る</A>]<br>

<div align="center">
    
<br><br><br>    

<font size="4"><b>{$title}</b></font>

<br><br>

<br>

{if $data}
    
    <font color="red">--未対応の候補者の対応をしてください--</font>
    
    <br><br><br>

<table border="1" width="" cellspacing="1" cellpadding="5">
    
<tr>
    <th><font size="2" color="blue">案件</font></th>
    <th><font size="2" color="blue">応募日時</font></th>
    <th><font size="2" color="blue">応募者</font></th>
    <th><font size="2" color="blue">年齢</font></th>
    <th><font size="2" color="blue">状態</font></th>
</tr>    

{foreach item=item from=$data}
    <form method="post" action="customer.php?type=applicant_detail">
<tr>
    <td><a href="index.php?type=detail_project&project_id={$item.project_id}">{$item.project_title|truncate:20|escape:"html"}</A></td>
    <td>{$item.project_reg_date}</td>
    <td align="center">{$item.member_last_name|escape:"html"}</td>
    <td align="center">{$item.member_age}</td>
    <td align="center">
        {if $item.process == "未対応"}
        <INPUT type="submit" name="open" value="未対応">
        {else}
        {$item.process}
        {/if}
    </td>
    <INPUT type="hidden" name="member_id" value="{$item.member_id}">
    <INPUT type="hidden" name="project_id" value="{$item.project_id}">
    <INPUT type="hidden" name="project_reg_date" value="{$item.project_reg_date}">
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