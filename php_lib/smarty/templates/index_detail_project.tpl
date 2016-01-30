
<html>
    <head>
        <title>{$title}</title>
    </head>
    
    <form method="post" action="index.php?type=apply">
    <div align="center">
    
    <br><br>
    <font size="4">{$title}</font>
    
    <br><br>
    {if $is_system}
        <font color="red" size="2" >--応募案件の詳細表示--</font>
    {else}
               
       {if $data.action != 1}
           「<font color="red">下記のお仕事に応募をしますか？</font>」
       {else}
           <font color="red" size="4">--すでに下記のお仕事への応募は完了しています--</font>
       {/if}
     
    {/if}
   
    <br><br><br>
    
    {if !($is_system)}
    <table border="0" width="500" cellspacing="1" cellpadding="4">
    <tr>
        <td>
    <font size="5">{$data.title|escape:"html"}</font>
        </td>
    </tr>
    </table>
         <br>
    {/if}
   
    
    <table border="1" width="500" cellspacing="1" cellpadding="4">
    {if $is_system}    
    <tr><td align="center" width="20%">
    <font color="blue">タイトル</font></td><td>{$data.title|escape:"html"}
    </td></tr>       
    {/if}    
    <tr><td align="center" width="20%">
    <font color="blue">職種</font></td><td>{$data.project_type}
    </td></tr>
    
    <tr><td align="center">
    <font color="blue">勤務期間</font></td><td>{$data.t_start}～{$data.t_end}
    </td></tr>
    
    <tr><td align="center">
    <font color="blue">勤務時間</font></td><td>{$data.shift_start}～{$data.shift_end}
    </td></tr>
    
    <tr><td align="center">
    <font color="blue">時給</font></td><td>{$data.salary_per_hour}円
    </td></tr>
     
    <tr><td align="center">
    <font color="blue">交通費</font></td><td>{$data.transportation}円
    </td></tr>
    
    <tr><td align="center">
    <font color="blue">勤務地</font></td><td>{$data.area_type}
    </td></tr>
      
    <tr><td colspan="2"><font color="blue">&nbsp;&nbsp;お仕事の詳細</font></td></tr>
    <tr><td colspan="2">{$data.project_content|escape:"html"}</td></tr>

   </table>
    
    <br><be><br>

    <table border="1" width="500" cellspacing="1" cellpadding="4">
            <tr>
                <td colspan="2"><font color="blue">&nbsp;&nbsp;募集企業</font></td></tr>
                <tr><td colspan="2">{$data2.company_name|escape:"html"}</td>
            </tr>
            <tr>
                <td colspan="2"><font color="blue">&nbsp;&nbsp;住所</font></td></tr>
                <tr><td colspan="2">{$data2.address|escape:"html"}</td>
            </tr>
            <tr>
                <td colspan="2"><font color="blue">&nbsp;&nbsp;企業のアピール</font></td></tr>
                <tr><td colspan="2">{$data2.appeal|escape:"html"}</td>
            </tr>
    </table>
    
    <br><be>
            
    <table width="500" cellspacing="1" cellpadding="4">
     <tr>
        <td colspan="2" align="center">
    {if $data.action != 1 && !($is_system)}
            <INPUT type="submit" name="apply" value="応募する">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    {/if}  
            <INPUT type="button" value="戻る" onClick="history.go(-1);">
       </td>
    </tr>
    </table> 
     
    <INPUT type="hidden" name="project_id" value="{$data.id}">
    <INPUT type="hidden" name="company_id" value="{$data.company_id}">
    
<div>
        </form>
</html>    