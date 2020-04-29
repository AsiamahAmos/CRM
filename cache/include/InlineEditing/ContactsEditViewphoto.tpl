


<script type="text/javascript">
    {literal}
        $( document ).ready(function() {
        $( "form#EditView" )
        .attr( "enctype", "multipart/form-data" )
        .attr( "encoding", "multipart/form-data" );
    });
{/literal}
</script>
<script type="text/javascript" src='include/SugarFields/Fields/Image/SugarFieldFile.js?v=ZJFH1Zg-iT402ZHXvhHGKg'></script>

{if !empty($fields.photo.value) }
    {assign var=showRemove value=true}
{else}
    {assign var=showRemove value=false}
{/if}

{assign var=noChange value=false}

<input type="hidden" name="deleteAttachment" value="0">
<input type="hidden" name="{$fields.photo.name}" id="{$fields.photo.name}" value="{$fields.photo.value}">
<input type="hidden" name="{$fields.photo.name}_record_id" id="{$fields.photo.name}_record_id" value="{$fields.id.value}">
<span id="{$fields.photo.name}_old" style="display:{if !$showRemove}none;{/if}">
  <a href="index.php?entryPoint=download&id={$fields.id.value}_{$fields.photo.name}&type={$module}&time={$fields.date_modified.value}" class="tabDetailViewDFLink">{$fields.photo.value}</a>

        {if !$noChange}
        <input type='button' class='button' id='remove_button' value='{$APP.LBL_REMOVE}' onclick='SUGAR.field.file.deleteAttachment("{$fields.photo.name}","",this);'>
    {/if}
</span>
{if !$noChange}
<span id="{$fields.photo.name}_new" style="display:{if $showRemove}none;{/if}">
<input type="hidden" name="{$fields.photo.name}_escaped">
<input id="{$fields.photo.name}_file" name="{$fields.photo.name}_file"
       type="file" title='' size="30"
                       maxlength='255'
                >

    {else}



{/if}

<script type="text/javascript">
$( "#{$fields.photo.name}_file{literal} " ).change(function() {
        $("#{/literal}{$fields.photo.name}{literal}").val($("#{/literal}{$fields.photo.name}_file{literal}").val());
});{/literal}
        </script>


</span>