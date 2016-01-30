
<html>
    <head>
        <title>{$title}</title>
    </head>
    
    [<a href="{$SCRIPT_NAME}">トップへ</a>]<br><br>
    
    <div align="center">
    <br><br>
    
    <font size="4">{$title}</font>        
     <br><br>    
    <font color="red">{$message}</font>    
     <br><br><br>
    
    {if $data}
    <table  border="1" width="650" cellspacing="0" cellpadding="4">
        <tr>
            <th><font color="blue" size="2">送信者</font></th>
            <th><font color="blue" size="2">受信者</font></th>
            <th><font color="blue" size="2">件名</font></th>
            <th><font color="blue" size="2">本文</font></th>
            <th><font color="blue" size="2">送信日時</font></th>
        </tr>
    {foreach item=item from=$data}
        <tr>
            {if $item.sender == "customer"}
            <td align="center"><font size="2">{$item.company_name|escape:"html"}</font></td>
            <td align="center"><font size="2">{$item.member_last_name|escape:"html"}&nbsp;{$item.member_last_name|escape:"html"}</font></td>
            {else if $item.sender == "member"}
            <td align="center"><font size="2">{$item.member_last_name|escape:"html"}&nbsp;{$item.member_last_name|escape:"html"}</font></td>      
            <td align="center"><font size="2">{$item.company_name|escape:"html"}</font></td> 
            {/if}    
            <td><font size="2">{$item.subject|truncate:20:'...'|escape:"html"}</font></td>
            <td><A href="system.php?type=detail_message&message_id={$item.id}"><font size="2">{$item.body|truncate:10:' >>'|escape:"html"}</font></A></td>
            <td align="center" ><font size="2">{$item.reg_date}</font></td>
        </tr>       
    {/foreach}
    
    </table>
    <br>    
    {$links}
    </div>
    
    <br><br><br>
    
    {else}
    
    <br><br><font color="red">メッセージは０件です</font>
    
    {/if}

</html>
    

