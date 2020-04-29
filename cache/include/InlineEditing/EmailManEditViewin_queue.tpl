
{if strval($fields.in_queue.value) == "1" || strval($fields.in_queue.value) == "yes" || strval($fields.in_queue.value) == "on"} 
{assign var="checked" value='checked="checked"'}
{else}
{assign var="checked" value=""}
{/if}
<input type="hidden" name="{$fields.in_queue.name}" value="0"> 
<input type="checkbox" id="{$fields.in_queue.name}" 
name="{$fields.in_queue.name}" 
value="1" title='' tabindex="1" {$checked} >