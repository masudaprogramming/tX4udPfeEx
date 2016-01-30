

<html>
    <head>
        <title>{$title}</title>
    </head>
    [<A href='javascript:history.back()'>戻る</A>]
    <div align="center">
    <form method="post" action="customer.php">
    <br><br><br>
    
        <font size="5">{$title}</font>
    
    <br><br>
    {$message}
    <br>  
        
    <table border="1" width="450" cellspacing="1" cellpadding="4">
        <tr>
           <td><font color="blue">日時</font></td>
       </tr>
       <tr>
           <td>{$data.reg_date}</td>
       </tr>
    </table>
       
    <br><br>
    
    <table border="1" width="450" cellspacing="1" cellpadding="4">       
        
       <tr><td><font color="blue">送信者</font></td></tr>
       {if $data.sender == "member"}
           <tr><td>{$data.member_name}</td></tr>
       {else if $data.sender == "customer"}
           <tr><td>{$data.company_name}</td></tr>
       {/if}
       <tr><td><font color="blue">受信者</font></td></tr>
       {if $data.sender == "member"}
           <tr><td>{$data.company_name}</td></tr>
       {else if $data.sender == "customer"}
           <tr><td>{$data.member_name}</td></tr>
       {/if}
    </table>
    
    <br><br>
    
    <table border="1" width="450" cellspacing="1" cellpadding="4">
       <tr>
           <td><font color="blue">件名</font></td>
       </tr>    
       <tr>    
          <td>{$data.subject}</td>
       </tr> 
       <tr>
          <td><font color="blue">本文</font></td>
       </tr>
       <tr>
          <td>{$data.body}</td>    
       </tr>
    </table>
           
       <br><br>
       
    <table border="1" width="450" cellspacing="1" cellpadding="4">
       <tr>  
          <td><font color="blue">{$data.member_name}</font>&nbsp;さんの応募案件</td>
       </tr>
       <tr>
          <td><A href="system.php?type=detail_project&project_id={$data.project_id}">{$data.title}</A></td>
       </tr>
       <tr>
          <td><font color="blue">応募日時</font></td>
       </tr>
       <tr>
          <td>{$data.action_reg_date}</td>
      </tr>
    </table>
      
    <br><br>  
    
    <div align='center'>
       <INPUT type="button" value="戻る" onClick="history.go(-1);">
    </div>   
    
    <br><br>
      
    </div>   
    </form>
    <br><br><br>
    
</html>



