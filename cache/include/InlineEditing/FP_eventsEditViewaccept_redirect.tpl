
	{if !empty($fields.accept_redirect.value)}
	<input type='text' name='{$fields.accept_redirect.name}' id='{$fields.accept_redirect.name}' size='30' 
	   maxlength='255' value='{$fields.accept_redirect.value}' title='Insert the URL for the page that you want the event delegates to see when they accept the invitation from the email.' tabindex='1'  >
	{else}
	<input type='text' name='{$fields.accept_redirect.name}' id='{$fields.accept_redirect.name}' size='30' 
	   maxlength='255'	   	   {if $displayView=='advanced_search'||$displayView=='basic_search'}value=''{else}value='http://'{/if} 
	    title='Insert the URL for the page that you want the event delegates to see when they accept the invitation from the email.' tabindex='1'  >
	{/if}
