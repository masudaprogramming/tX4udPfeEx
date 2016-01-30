
<html>
<head>
        <title>{$title}</title>
</head>

{$form.javascript}
<div align = "center">
{$title}
<br><br>{$message}<br><br><br>


<form {$form.attributes}>
    
    
[<font color="blue">希望の勤務地</font>]
{if $area_error}
    <font color="red">{$area_error}</font><br>
 {/if}
<br><br>
希望勤務地1:&nbsp;{$form.area_type1.html}<br><br>

{if ($form.area_type2.value != "1")}
希望勤務地2:&nbsp;{$form.area_type2.html}<br><br>
{/if}

{if ($form.area_type3.value != "1")}
希望勤務地3&nbsp;{$form.area_type3.html}<br><br><br>
{/if}


[<font color="blue">お仕事スタート</font>]<br><br>{$form.hope_start.html}<br><br><br>

[<font color="blue">希望の職種</font>]
{if $project_error}
   <font color="red">{$project_error}</font><br>
{/if}    
<br><br>
{if $form.project_type1.value != ""}
{$form.project_type1.html}<br><br>
{/if}
{if $form.project_type2.value != ""}
{$form.project_type2.html}<br><br>
{/if}
{if $form.project_type3.value != ""}
{$form.project_type3.html}<br><br>
{/if}
{if $form.project_type4.value != ""}
{$form.project_type4.html}<br><br>
{/if}
{if $form.project_type5.value != ""}
{$form.project_type5.html}<br><br>
{/if}
{if $form.project_type6.value != ""}
{$form.project_type6.html}<br><br>
{/if}
{if $form.project_type7.value != ""}
{$form.project_type7.html}<br><br>
{/if}
{if $form.project_type8.value != ""}
{$form.project_type8.html}<br><br>
{/if}
{if $form.project_type9.value != ""}
{$form.project_type9.html}<br><br>
{/if}
{if $form.project_type10.value != ""}
{$form.project_type10.html}<br><br>
{/if}
{if $form.project_type11.value != ""}
{$form.project_type11.html}<br><br>
{/if}
{if $form.project_type12.value != ""}
{$form.project_type12.html}<br><br>
{/if}
{if $form.project_type13.value != ""}
{$form.project_type13.html}<br><br>
{/if}
{if $form.project_type14.value != ""}
{$form.project_type14.html}<br><br>
{/if}
{if $form.project_type15.value != ""}
{$form.project_type15.html}<br><br>
{/if}
<br><br>
{if $form.expe_appeal.error}
<font color="red">{$form.expe_appeal.error}</font>
{/if}


[<font color="blue">お仕事への意気込み</font>]<br><br>{$form.expe_appeal.html}<br><br><br>

{$form.submit1.html}&nbsp;
{if ($form.submit2.value != "")}
{$form.submit2.html}
{else}
{$form.reset.html}
{/if}

<INPUT type="hidden" name="type" value="{$type}">
<INPUT type="hidden" name="action" value="{$action}">
<INPUT type="hidden" name="re" value="re">

</form>
</div>

</html>
