
{if strlen($fields.relation_officer_c.value) <= 0}
{assign var="value" value=$fields.relation_officer_c.default_value }
{else}
{assign var="value" value=$fields.relation_officer_c.value }
{/if}  
<input type='text' name='{$fields.relation_officer_c.name}' 
    id='{$fields.relation_officer_c.name}' size='30' 
    maxlength='255' 
    value='{$value}' title=''  tabindex='1'      >