
<html>
    <head>
        <title>{$title}</title>
    </head>    
 [<a href="system.php">戻る</a>]
    <div align="center">
        
        <br><br>
        
        <font size="4">{$title}</font>
        
        <br><br>
        --<font color="blue">{$count}</font>名の登録者がいます--
        <br><br><br>     
        
        {if $data}
         <table border="1" width="500" cellspacing="1" cellpadding="4">
            <tr> 
              <th>id</th>
              <th>氏名</th>
              <th>メール</th>
              <th>性別</th>
              <th>登録日時</th>
            </tr>
        {foreach item=item from=$data}
                <tr>
                    <td align="center">{$item.id}</td>
                    <td align="center"><A href = "system.php?type=member_detail&action=view&id={$item.id}">{$item.last_name|escape:"html"}&nbsp;{$item.first_name|escape:"html"}</A></td>
                    <td align="center">{$item.mail|escape:"html"}</td>
                    <td align="center">
                        {if $item.gender == 1}
                            男性
                        {else if $item.gender == 2}
                            女性
                        {/if}
                    </td>
                    <td align="center">{$item.reg_date}</td>
                </tr>         
        {/foreach}
        </table>
        <br><br>{$links}
        {else}
         <br><br><br><font color="red">--登録メンバーはいません--</font>
        {/if}    
    </div>
</html>




