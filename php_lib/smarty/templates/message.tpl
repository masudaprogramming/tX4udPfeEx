
<html>
<head>
    <title>{$title}</title>
</head>

<div align="center">
<font color="red">{$title}</font>
<br><br><br>
{$message}
<br><br>
{if $URL}
[<a href="{$URL}">戻る</a>]
{else}
[<a href="{$SCRIPT_NAME}">トップへ</a>]
{/if}
</div>

</html>

