
{if strlen($fields.product_image.value) <= 0}
{assign var="value" value=$fields.product_image.default_value }
{else}
{assign var="value" value=$fields.product_image.value }
{/if}  
<input type='text' name='{$fields.product_image.name}' 
    id='{$fields.product_image.name}' size='30' 
    maxlength='255' 
    value='{$value}' title=''  tabindex='1'      >