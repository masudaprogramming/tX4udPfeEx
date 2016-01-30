
<html>
    <head>
        <title>{$title}</title>
    </head>
    
    <body>
        [<a href="system.php?type=logout">ログアウト</a>]
        <div align="center">
        <br><br>
    
    <font size="5">{$title}</font>
    
    <br><br>
    {$message}
    <br><br>
    
    <table border="0" width="" cellspacing="1" cellpadding="10">
      <tr>  
        <td align="center"><font color="red" size="2">--会員管理機能--</font></td>
      </tr>
      <tr>
        <td align="center">[<a href="system.php?type=regist">新規会員発行</a>]</td>
      </tr>
      <tr>
        <td align="center">[<a href="system.php?type=member_list">会員一覧</a>]</td>
      </tr>
    </table>
    
    <br><br>
    
    <table border="0" width="" cellspacing="1" cellpadding="10">
      <tr>
        <td align="center"><font color="red" size="2">--顧客管理機能--</font></td>
      </tr>  
      <tr>
        <td align="center">[<a href="system.php?type=customer_regist">新規顧客発行</a>]</td>
      </tr>  
      <tr>
        <td align="center">[<a href="system.php?type=customer_list">顧客一覧</a>]</td>
      </tr>
    </table> 
      
    <br><br>
    
    <table border="0" width="" cellspacing="1" cellpadding="10">
      <tr> 
          <td align="center"><font color="red" size="2">-サイト内アクション管理--</font></td>
      </tr>
      <tr>
         <td align="center"><a href="system.php?type=message_box">メッセージ</a></td>
      </tr>
      <tr>
         <td align="center"><a href="system.php?type=applicant_list">応募履歴</a></td>
      </tr> 
    </table>
    
        </div>
    </body>
    
</html>

