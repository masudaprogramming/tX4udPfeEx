
<html>
<head>
        <title>{$title}</title>
</head>
[<a href="{$SCRIPT_NAME}">トップへ</a>]
<div align="center">
    
     <br><br><br>
    <font size="4">{$title}</font>
     <br><br>
    <font color="red">{$message}</font>
     <br><br><br>
    
    <table border="1" width="" cellspacing="1" cellpadding="4">
     <tr>
        <th><font size="2">会社のアピール</font></th>
        <th><font size="2">会社名</font></th> 
        <th><font size="2">住所</font></th> 
     </tr>   
    {foreach item=item from=$data }
     <tr>
        <td>{$item.appeal}</td>
        <td>{$item.company_name}</td>
        <td>{$item.address}</td> 
     </tr>    
    {/foreach}
    </table>
</div>
    
</html>
