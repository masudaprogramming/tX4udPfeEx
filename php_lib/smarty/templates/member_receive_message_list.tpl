
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
    [<A href="member.php?type=message_box&action=transmit"><font size="4">送信BOXへ</font></A>]
    
     <br><br><br><br><br>
    
    <font color="red">{$message}</font>
    
    <br><br>
    
    {if $data}
    <table  border="1" width="700" cellspacing="1" cellpadding="4">
        <tr>
            <th><font color="blue">from</font></th>
            <th><font color="blue">件名</font></th>
            <th width="20%" ><font color="blue">本文</font></th>
            <th width="15%" ><font color="blue">受信日時</font></th>
            <th><font color="blue">対応</font></th>
        </tr>
    {foreach item=item from=$data}
        <tr>
            <td align="center">{$item.company_name|escape:"html"}</td>
            <td>{$item.subject}</td>
            <td><A href="member.php?type=detail_message&action=receive&message_id={$item.id}">{$item.body|truncate:10:' >>'|escape:"html"}</A></td>
            <td align="center">{$item.reg_date}</td>
            <td align="center">
                {if $item.re == "1"}
                    <font color="blue">返信済み</font>
                {else}
                    <font color="blue">未返信</font>
                {/if}    
            </td>    
        </tr>       
    {/foreach}
    
    </table>
    {$links}
    </div>
    
    <br><br><br>

    {else}
    
    <br><br><font color="red">受信したメッセージは０件です</font>
    
    {/if}

</html>
    


