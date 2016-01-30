
<HTML>
    <HEAD>
        <title>{$title}</title>
    </HEAD>

[<A href="customer.php?type=logout">ログアウト</A>]

<div align="center">
    
<br><br><br>

<font size="5">{$title}</font>

<br><br>

 ようこそ！&nbsp;<font color="red">{$company}</font>様

<br><br>

<font color="red">{$message}</font>
        
<br>
　　<table  border="0" width="" cellspacing="0" cellpadding="10">
     <tr>   
      <td colspan="2" align="center"><font size="2" color="blue">>></font><font size="2" color="blue">案件の管理と登録</font></td>
     </tr>
     <tr>
      <td colspan="2" align="center">[<A href="customer.php?type=list_project"><font size="3">案件一覧</font></A>]</td>
     </tr>
     <tr>
      <td colspan="2" align="center">[<A href="customer.php?type=regist_project"><font size="3">新規登録</font></A>]</td>
     </tr>
     <tr><td>&nbsp;</td></tr>
     <tr>
       <td colspan="2" align="center"><font size="2" color="blue">>></font><font size="2" color="blue">応募者の管理</font></td>
     </tr>
     <tr>
      <td colspan="2" align="center"><A href="customer.php?type=applicant_list"><font size="3">応募者一覧</font></A></td>
     </tr> 
     <tr><td>&nbsp;</td></tr>
     <tr>      
      <td colspan="2" align="center"><font size="2" color="blue">>></font><font size="2" color="blue">メッセージの送受信</font></td>
     </tr>
     <tr>
      <td align="center">[<A href="customer.php?type=message_box&action=receive"><font size="3">受信BOX</font></A>]</td>
      <td align="center">[<A href="customer.php?type=message_box&action=transmit"><font size="3">送信BOX</font></A>]</td>
     </tr> 
    </table>
      <br><br>
      <br><br>
      <A href="customer.php?type=company&action=form"><font size="2">登録情報の修正</font></A>
      <br>
    </div>

</HTML>


