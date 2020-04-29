
{if strlen($fields.amount_usdollar.value) <= 0}
{assign var="value" value=$fields.amount_usdollar.default_value }
{else}
{assign var="value" value=$fields.amount_usdollar.value }
{/if}  
<input type='text' name='{$fields.amount_usdollar.name}' 
id='{$fields.amount_usdollar.name}' size='30'  value='{sugar_number_format var=$value}' title='' tabindex='1'
 >