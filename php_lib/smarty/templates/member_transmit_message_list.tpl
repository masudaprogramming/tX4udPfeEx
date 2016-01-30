
<html>
    <head>
        <title>{$title}</title>
    </head>
    
    [<a href="{$SCRIPT_NAME}">トップへ</a>]
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    [<a href="member.php?type=action">応募履歴へ</a>]
    
    <br><br>   
    
    <div align="center">
    <br><br>
    
    <font size="5">{$title}</font>
    <br><br>
    [<A href="member.php?type=message_box&action=receive"><font size="4">受信BOXへ</font></A>]
    
     <br><br><br><br><br>
    
    <font color="red">{$message}</font>
    
    <br><br>
    
    {if $data}
    <table  border="1" width="650" cellspacing="1" cellpadding="4">
        <tr>
            <th><font color="blue">to</font></th>
            <th><font color="blue">件名</font></th>
            <th width="25%" ><font color="blue">本文</font></th>
            <th width="22%" ><font color="blue">送信日時</font></th>
        </tr>
    {foreach item=item from=$data}
        <tr>
            <td align="center">{$item.company_name|escape:"html"}</td>
            <td>{$item.subject|escape:"html"}</td>
            <td><A href="member.php?type=detail_message&action=transmit&message_id={$item.id}">{$item.body|truncate:10:' >>'|escape:"html"}</A></td>
            <td align="center" >{$item.reg_date}</td>
        </tr>       
    {/foreach}
    
    </table>
    <br>
    {$links}
    </div>
    
    <br><br><br>
    
    {else}
    
    <br><br><font color="red">送信したメッセージは０件です</font>
    
    {/if}

</html>
    

