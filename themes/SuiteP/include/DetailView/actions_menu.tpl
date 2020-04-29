<ul id="act" class="dropdown-menu">
    {{if !isset($form.buttons)}}
    <li>{{sugar_button module="$module" id="EDIT" view="$view" form_id="formDetailView"}}</li>
    <li>{{sugar_button module="$module" id="DUPLICATE" view="EditView" form_id="formDetailView"}}</li>
    <li>{{sugar_button module="$module" id="DELETE" view="$view" form_id="formDetailView"}}</li>
    {{else}}
    {{counter assign="num_buttons" start=0 print=false}}
    {{foreach from=$form.buttons key=val item=button}}
    {{if !is_array($button) && in_array($button, $built_in_buttons)}}
    {{counter print=false}}
    <li>{{sugar_button module="$module" id="$button" view="EditView" form_id="formDetailView"}}</li>
    {{/if}}
    {{/foreach}}
    {{if count($form.buttons) > $num_buttons}}
    {{foreach from=$form.buttons key=val item=button}}
    {{if is_array($button) && $button.customCode}}
    <li>{{sugar_button module="$module" id="$button" view="EditView" form_id="formDetailView"}}</li>
    {{/if}}
    {{/foreach}}
    {{/if}}
    {{if empty($form.hideAudit) || !$form.hideAudit}}
    <li>{{sugar_button module="$module" id="Audit" view="EditView" form_id="formDetailView"}}</li>
    {{/if}}
    {{/if}}
</ul>
<script>
    // $('#act').append('<li ><input id="sms" onclick="sms();" class="button" value="Send SMS" type="button"></li>');
//////:::::::Compose-email button on the action menu of contacts details::://///////Code also in contacts/contacts.js
// var email = $('.email-link').attr('onclick');
// var id = $('.email-link').attr('data-record-id');
// var name = $('.email-link').attr('data-module-name');
// var address = $('.email-link').attr('data-email-address');

// var currentTab = $('#moduleTab_Contacts').text();
// //alert(currentTab);
// if(currentTab=='Contacts')
// $('#act').append('<li><input id="bb" class="button" onclick="'+email+'" type="button" data-email-address="'+address+'" data-module="Contacts" data-module-name="'+name+'" data-record-id="'+id+'"  value="Compose Email"></li> <li><input id="sms" onclick="sms();" class="button" value="Send SMS" type="button"></li>');
  
// ///////////End of the button NB: Send SMS button is also part/////////////////////////

</script>