

<html>
    <head>
        <title>{$title}</title>
    </head>
    [<A href='javascript:history.back()'>戻る</A>]
    <div align="center">
    <form method="post" action="member.php">
    <br><br>
    
        <font size="5">{$title}</font>
    
    <br><br><br>  
        
    <table border="1" width="450" cellspacing="1" cellpadding="4">
        <tr>
           <td><font color="blue">{$message}</font></td>
       </tr>
       <tr>
           <td>{$data.reg_date}</td>
       </tr>
    </table>
       
    <br><br>
    
    <table border="1" width="450" cellspacing="1" cellpadding="4">
       <tr>  
           <td><font color="blue">
               {if $data.sender == "customer"}from{else}to{/if}
               </font>
           </td>
       </tr>
       <tr>
           <td>{$data.company_name|escape:"html"}</td>
       </tr>
       <tr>
           <td><font color="blue">件名</font></td>
       </tr>    
       <tr>    
          <td>{$data.subject|escape:"html"}</td>
       </tr> 
       <tr>
          <td><font color="blue">本文</font></td>
       </tr>
       <tr>
          <td>{$data.body}</td>    
       </tr>
    </table>
       
    <br>
        {if $var == "transmit"}
        <INPUT type="button" value="戻る" onClick="history.go(-1);">
        {else if $var == "receive"}
            {if $process == "close"}        
        <br>
        <font size="2" >--不採用の場合、メッセージに返信することはできません--</font>
        <br><br>
        [<A href='javascript:history.back()'>戻る</A>]
            {else}    
        <INPUT type="submit" name="re_mess" value="返信">
        <INPUT type="hidden" name="message_id" value="{$data.id}">        
        <INPUT type="hidden" name="type"    value="{$type}">
        <INPUT type="hidden" name="action"  value="{$action}"><br>
            {/if} 
        {/if}
    <br><br>
       
    <table border="1" width="450" cellspacing="1" cellpadding="4">
      <tr>  
          <td align="center">
              応募した案件
          </td>
      </tr>
      <tr>  
          <td><font color="blue">応募案件</font></td>
      </tr>
      <tr>
          <td><A href="index.php?type=detail_project&project_id={$data.project_id}">{$data.title|truncate:18|escape:"html"}</A></td>
      </tr>
      <tr>
          <td><font color="blue">応募日時</font></td>
      </tr>
      <tr>
          <td>{$data.action_reg_date}</td>
      </tr>
    </table>
    <br>
      
      
    </div>   
    </form>
    <br><br><br>
    
</html>




