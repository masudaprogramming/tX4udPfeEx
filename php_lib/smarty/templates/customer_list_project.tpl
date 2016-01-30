
<html>
<head>
        <title>{$title}</title>
</head>

{if $is_system}
[<a href="system.php?type=customer_list&{$add_pageID}">一覧へ</a>]<br><br>
{else}
[<a href="{$SCRIPT_NAME}">トップへ</a>]<br><br>
{/if}

<div align="center">
<font size='5'>{$title}</font><br>

{if $message}
<br><br>
<font color="red">{$message}</font>
<br>
{/if}

<br><br>

{if $is_system}
[<A href="system.php?type=regist_project"><font size="4">新規案件登録</font></A>]
{else}  
 [<A href="customer.php?type=regist_project"><font size="4">新規案件登録</font></A>]
 {/if}

<br><br><br>

<font size='4' >検索結果は&nbsp;<font color="red">{$count}</font>&nbsp;件です</font>
<br>

{if $data}
<br>    
<font size="2">「<font color="blue">勤務期間</font>」の開始日時が、本日以降の案件は<br>自動的に「<font color="blue">-非公開-</font>」に切り替わります</font>
<br><br>

{foreach item=item from=$data}
    <form {$form.attributes}>
    <table border="1" width="500" cellspacing="1" cellpadding="4">
 
    <tr>
        <td align="center" width="18%">
    <font color="blue">状態</font>
        </td>
        <td>
           {if $item.valid == 1}
               <font color="red">-公開中-&nbsp;&nbsp;&nbsp;</font>
           {else}
               -非公開- 
           {/if}     
        </td>
    </tr>  
        
    <tr><td align="center">
    <font color="blue">タイトル</font></td><td>{$item.title|escape:"html"}
    </td></tr>
    
    <tr><td align="center">
    <font color="blue">職種</font></td><td>{$item.project_type}
    </td></tr>
    
    <tr><td align="center">
    <font color="blue">勤務期間</font></td><td>{$item.t_start}～{$item.t_end}
    </td></tr>
    
    <tr><td align="center">
    <font color="blue">勤務時間</font></td><td>{$item.shift_start}～{$item.shift_end}
    </td></tr>
    
    <tr><td align="center">
    <font color="blue">時給</font></td><td>{$item.salary_per_hour}円
    </td></tr>
     
    <tr><td align="center">
    <font color="blue">交通費</font></td><td>{$item.transportation}円
    </td></tr>
    
    <tr><td align="center">
    <font color="blue">勤務地</font></td><td>{$item.area_type}
    </td></tr>
    
    <tr><td align="center">
    <font color="blue">登録時間</font></td><td>{$item.reg_date}
    </td></tr>
    
    <tr><td colspan="2"><font color="blue">&nbsp;&nbsp;お仕事の詳細</font></td></tr>
    <tr><td colspan="2">{$item.project_content}</td></tr>
      
    <tr><td colspan="2" align="center">
    <INPUT type="submit" name="modify" value="更新" >&nbsp;&nbsp;&nbsp;<INPUT type="submit" name="delete" value="削除" >
    </td></tr>
   
    <INPUT type="hidden" name="id" value="{$item.id}">
    <INPUT type="hidden" name="action" value="form">
    <INPUT type="hidden" name="type" value="modify_or_delete_project">
    
    </table><br><br><br>
    </form>
{/foreach}    

<font size='5'>{$links}</font>

<br><br><br>
</div>
{/if}
<form {$form.attributes}>
<INPUT type="hidden"  name="type"   value={$type}>
<INPUT type="hidden"  name="action" value={$action}>

</form>

</html>
