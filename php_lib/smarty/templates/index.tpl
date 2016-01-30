<HTML>
    <HEAD>
        <title>{$title}</title>
    </HEAD>
    <div align="center">

<table border="0" width="380" cellspacing="0" cellpadding="3">
     <tr>
    <td align="center" ><A href="{$SCRIPT_NAME}?type=member"><font size="2">{if $login==1}マイページ{else}ログイン{/if}</font></A></td>
    <td align="center" ><A href="{$SCRIPT_NAME}?type=regist"><font size="2">サイトへ登録</font></A></td>
    <td align="center" ><A href="{$SCRIPT_NAME}?type=service"><font size="2">運営会社</font></A></td>
     </tr>
</table>

<br><br>

    <font size="5"><em>{$title}</em></font>
    
<br><br><br>
    
    {if $message}
      <font color="red">{$message}</font><br>
    {/if}
      
<form method="post" action="index.php">
    
<table border="0" width="500" cellspacing="0" cellpadding="3"> 
<tr>
    <td colspan="2" align="center"><font color="blue" size="2">--絞り込み--</font></td>
</tr>
<tr>    
    <td align="right">キーワード：</td><td><INPUT type="text" name="search_key" value="{$search_key}"></td>
</tr>
<tr>
    <td align="right">職種：</td><td>{$form.project_type.html}</td>
</tr>
<tr>
    <td align="right">勤務地：</td><td>{$form.area_type1.html}</td>
</tr> 
<tr>
    <td colspan="2" align="center"><INPUT type="submit" name="submit" value="絞り込み"></td>  
</tr>
</table>

</form>

<br>

<font size='4' >検索結果は&nbsp;<font color="blue">{$count}</font>&nbsp;件です</font><br><br>

<table border="0" width="" cellspacing="0" cellpadding="5">
    <tr>
<td><font size="3"><A href="{$SCRIPT_NAME}?type=tomorrow_project">明日のお仕事</A></font></td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td><font size="3"><A href="{$SCRIPT_NAME}?type=customer_list">掲載企業一覧</A></font></td>
    </tr>
</table>

<font size='4'>{$links}</font>

<br>

{if $data}
{foreach item=item from=$data}
    <form method="post" action="index.php?type=detail_project">
        
    {if $item.action == 1}
    <font color="red">--応募済み--</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    {/if}    
        
    <table border="1" width="500" cellspacing="1" cellpadding="4">
        
    <tr><td align="center" width="18%">
            <font color="blue">タイトル</font></td>
        <td><b>{$item.title|escape:"html"}</b></td>
    </tr>
    
    <tr><td align="center">
    <font color="blue">職種</font></td><td>{$item.project_type}
    </td></tr>    
    
    <tr><td align="center">
    <font color="blue">勤務期間</font></td><td>{$item.t_start|escape:"html"}～{$item.t_end|escape:"html"}
    </td></tr>
    
    <tr><td align="center">
    <font color="blue">勤務時間</font></td><td>{$item.shift_start|escape:"html"}～{$item.shift_end|escape:"html"}
    </td></tr>
       
    <tr><td align="center">
    <font color="blue">勤務地</font></td><td>{$item.area_type}
    </td></tr>
       
    <tr><td align="center">
    <font color="blue">条件</font></td><td>時給{$item.salary_per_hour}円＋交通費{$item.transportation}円
    </td></tr>
    
    <tr><td align="center">
    <font color="blue">募集企業</font></td><td>{$item.company_name|escape:"html"}
    </td></tr>
    
    <tr>
        <td colspan="2" align="center">
            <INPUT type="submit" name="detail" value="詳細確認">
        </td>
    </tr>
        
    <INPUT type="hidden" name="project_id" value="{$item.id}">
    <INPUT type="hidden" name="company_id" value="{$item.company_id}">

    </table><br>
    </form>
{/foreach}    

<font size='4'>{$links}</font>

<br><br><br>
</div>
{/if}

</HTML>

