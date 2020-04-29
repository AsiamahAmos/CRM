
{if strlen($fields.segment_c.value) <= 0}
{assign var="value" value=$fields.segment_c.default_value }
{else}
{assign var="value" value=$fields.segment_c.value }
{/if}  
<input type='text' name='{$fields.segment_c.name}' 
    id='{$fields.segment_c.name}' size='30' 
    maxlength='255' 
    value='{$value}' title=''  tabindex='1'      >