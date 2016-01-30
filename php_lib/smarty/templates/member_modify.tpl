
<html>
<head>
    <title>{$title}</title>
</head>

{$form.javascript}

[<a href="{$SCRIPT_NAME}">トップへ</a>]<br><br><br>

<form {$form.attributes}>
<div align="center">
    {$title}<br><br><br>
    {if $message != ""}
        <font color="red">{$message}</font><br><br><br>
    {/if}
    
   {if $form.mail.error}
       <font color="red" size="2">{$form.mail.error}</font><br>
   {/if}

   <font color="blue">{$form.mail.label}</font>：{$form.mail.html}<br><br><br>
  
   
{if $form.last_name.error}
    <font color="red" size="2">{$form.last_name.error}</font><br>
{/if}

<font color="blue">{$form.last_name.label}</font>：{$form.last_name.html}<br><br>

{if $form.first_name.error}
    <font color="red" size="2">{$form.first_name.error}</font><br>
{/if}


<font color="blue">{$form.first_name.label}</font>：{$form.first_name.html}<br><br>

<font color="blue">{$form.birthday.label}</font>：{$form.birthday.html}<br><br>

 {if $form.gender.error}
    <font color="red" size="2">{$form.gender.error}</font><br>
{/if}   
<font color="blue">{$form.gender.label}</font>：{$form.gender.html}<br><br><br>


[<font color="blue">どこで働きたいですか？</font>]
{if $area_error}
    <font color="red">{$area_error}</font><br>
 {/if}
<br><br>
希望勤務地1&nbsp;{$form.area_type1.html}<br><br>
希望勤務地2&nbsp;{$form.area_type2.html}<br><br>
希望勤務地3&nbsp;{$form.area_type3.html}<br><br><br>

[<font color="blue">いつから働けますか？</font>]<br><br>{$form.hope_start.html}<br><br><br>

[<font color="blue">希望の職種をチェック！</font>]
{if $project_error}
   <font color="red">{$project_error}</font><br>
{/if}    
<br><br>
{$form.project_type1.html}&nbsp;&nbsp;
{$form.project_type2.html}&nbsp;&nbsp;
{$form.project_type3.html}&nbsp;&nbsp;
{$form.project_type4.html}<br><br>
{$form.project_type5.html}&nbsp;&nbsp;
{$form.project_type6.html}&nbsp;&nbsp;
{$form.project_type7.html}&nbsp;&nbsp;
{$form.project_type8.html}<br><br>
{$form.project_type9.html}&nbsp;&nbsp;
{$form.project_type10.html}&nbsp;&nbsp;
{$form.project_type11.html}&nbsp;&nbsp;
{$form.project_type12.html}<br><br>
{$form.project_type13.html}&nbsp;&nbsp;
{$form.project_type14.html}&nbsp;&nbsp;
{$form.project_type15.html}<br><br><br>


[<font color="blue">{$form.expe_appeal.label}</font>]
{if  $form.expe_appeal.error}
<font color="red">{$form.expe_appeal.error}</font>
{/if}


<br><br>{$form.expe_appeal.html}<br><br><br>


{$form.submit1.html}&nbsp;
{if ($form.submit2.value != "")}
{$form.submit2.html}
    {else}
{$form.reset.html}
{/if}

<INPUT type='hidden' name='type' value={$type}>
<INPUT type='hidden' name ='action' value ={$action}>
<INPUT type="hidden" name="re" value="re">

</div>

</form>

</html>

