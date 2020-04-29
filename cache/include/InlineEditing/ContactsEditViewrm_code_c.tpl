
{if strlen($fields.rm_code_c.value) <= 0}
{assign var="value" value=$fields.rm_code_c.default_value }
{else}
{assign var="value" value=$fields.rm_code_c.value }
{/if}  
<input type='text' name='{$fields.rm_code_c.name}' 
    id='{$fields.rm_code_c.name}' size='30' 
    maxlength='255' 
    value='{$value}' title=''  tabindex='1'      >