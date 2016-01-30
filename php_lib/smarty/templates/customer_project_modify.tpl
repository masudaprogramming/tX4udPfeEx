
<html>
<head>
        <title>{$title}</title>
</head>

{$form.javascript}
[<A href ="customer.php?type=list_project">戻る</A>]<br>
<div align="center">
    
<form {$form.attributes}>    

    <font size = "5">{$title}</font>
    <br><br><br>

{if $message}
<font color="red">{$message}</font><br><br><br>
{/if}

<font color="blue">{$form.title.label}</font><br>
{if  $form.title.error}
<font color="red">{$form.title.error}</font><br>
{/if}
{$form.title.html}<br><br>

{if $project_error}
    <font color="red">{$project_error}</font><br>
{/if}

<font color="blue">職種</font>&nbsp;：&nbsp;{$form.project_type.html}<br><br><br>

<font color="blue">お仕事の期間 (勤務スタート～終了)</font><br>
{if $t_error}
<font color="red">{$t_error}</font><br>
{/if}
{$form.t_start.html}～{$form.t_end.html}<br><br>


<font color="blue">勤務時間</font><br>
{if $shift_error}
<font color="red">{$shift_error}</font><br>
{/if}
{$form.shift_start.html}～{$form.shift_end.html}<br><br>

<font color="blue">{$form.salary_per_hour.label}</font>&nbsp;：&nbsp;{$form.salary_per_hour.html}<br><br>
<font color="blue">{$form.transportation.label}</font>&nbsp;：&nbsp;{$form.transportation.html}<br><br>

{if $area_error}
<font color="red">{$area_error}</font><br>
{/if}
<font color="blue">勤務地</font>&nbsp;：&nbsp;{$form.area_type1.html}<br><br><br>

<font color="blue">{$form.project_content.label}</font><br>
{if  $form.project_content.error}
<font color="red">{$form.project_content.error}</font><br>
{/if}
{$form.project_content.html}<br><br><br>

<font color="blue">{$form.valid.label}</font><br><br>
{$form.valid.html}

<br><br><br>
{$form.submit1.html}&nbsp;
{if ($form.submit2.value != "")}
{$form.submit2.html}
{else}
{$form.reset.html}    
{/if}

<INPUT type="hidden"  name="type"   value={$type}>
<INPUT type="hidden"  name="action" value={$action}>
<INPUT type="hidden"  name="re"     value="re">


</div>
</form>

</html>
