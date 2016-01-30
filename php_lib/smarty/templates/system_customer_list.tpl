

<html>
    <head>
        <title>{$title}</title>
    </head>    
 [<a href="system.php">戻る</a>]
 

    <div align="center">
        
        <br><br>
        
        <font size="4">{$title}</font>
        
        <br><br>
        --<font color="blue">{$count}</font>社の顧客--
        <br><br><br>     
        
        {if $data}
         <table border="1" width="650" cellspacing="1" cellpadding="4">
            <tr> 
              <th>id</th>
              <th>会社名</th>
              <th>電話番号</th>
              <th>担当者</th>
              <th>登録日時</th>
              <th>掲載案件</th>
            </tr>
        {foreach item=item from=$data}
            <form {$form.attributes}>
                <tr>
                    <td align="center">{$item.id}</td>
                    <td align="center"><A href = "system.php?type=customer_detail&action=view&id={$item.id}">{$item.company_name}</A></td>
                    <td align="center">{$item.tel}</td>
                    <td align="center">{$item.last_name}&nbsp;{$item.first_name}</td>
                    <td align="center">{$item.reg_date}</td>
                    <td align="center"><INPUT type="submit" name="project" value="表示"></td>
                    <INPUT type="hidden" name="id" value="{$item.id}">
                    <INPUT type="hidden" name="type"   value="{$type}">
                </tr>     
              </form>      
        {/foreach}
        </table>
        <br><br>{$links}
        {else}
         <br><br><br><font color="red">--顧客は０社です--</font>
        {/if}    
    </div>

    
</html>




