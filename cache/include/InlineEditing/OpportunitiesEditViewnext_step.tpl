
{if strlen($fields.next_step.value) <= 0}
{assign var="value" value=$fields.next_step.default_value }
{else}
{assign var="value" value=$fields.next_step.value }
{/if}  
<input type='text' name='{$fields.next_step.name}' 
    id='{$fields.next_step.name}' size='30' 
    maxlength='100' 
    value='{$value}' title=''  tabindex='1'      >