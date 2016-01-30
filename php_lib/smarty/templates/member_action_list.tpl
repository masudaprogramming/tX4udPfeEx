<html>
    <head>
        <title>{$title}</title>
    </head>
    

[<a href="http://localhost/member.php">戻る</a>]

<div align="center">
<br><br><br>    

<font size="5">{$title}</font>
<br><br>

{if ($data)}

{$links}

<br><br>

<table border="1" width="600" cellspacing="1" cellpadding="4">   
    <tr>
        <th width="25%" >応募したお仕事</th>
        <th>企業名</th>
        <th width="18%">応募時間</th>
        <th width="23%">状況</th>
   </tr>
{foreach item=item from=$data}
    <tr>
        
        <td>    
          <A href="index.php?type=detail_project&project_id={$item.project_id}">{$item.title|truncate:10|escape:"html"}</A>
        </td>
        
        <td align="center">
           {$item.company_name|escape:"html"}
        </td>
        
        <td align="center">    
           {$item.reg_date}
        </td>
           
        <td align="center">
           {if  $item.process == "appli"}
               <font size="3">--なし--</font>
           {else}
               <font size="3">メッセージあり</font>
           {/if}           
        </td>
        
   </tr>

<!--{$item.company_id} -->

{/foreach}

</table>

<br><br>

{$links}

<br><br>

企業からのメッセージ一覧は
[<A href="member.php?type=message_box&action=receive">メッセージBOX</A>]
から


<br><br><br>

{else}
<br><br>    
<font color="red">--応募履歴はありません--</font>
{/if}

</div>
</html>

