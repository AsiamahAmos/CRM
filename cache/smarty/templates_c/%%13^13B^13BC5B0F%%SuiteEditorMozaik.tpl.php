<?php /* Smarty version 2.6.31, created on 2019-11-02 00:46:30
         compiled from include/SuiteEditor/tpls/SuiteEditorMozaik.tpl */ ?>

<!-- [Mozaik Editor implementation] -->

<script>
    /**
     * Mozaik value getter function
     *
     * @returns string - Mozaik value
     */
    SuiteEditor.getValue = function() {
        return $('#<?php echo $this->_tpl_vars['elementId']; ?>
').getMozaikValue();
    };

    /**
     * Mozaik value setter function
     *
     * @param htmlCode
     */
    SuiteEditor.apply = function(htmlCode) {
        $('#<?php echo $this->_tpl_vars['elementId']; ?>
').html(htmlCode ? htmlCode : '');
        $('#<?php echo $this->_tpl_vars['elementId']; ?>
').mozaik(window.mozaikSettings.<?php echo $this->_tpl_vars['elementId']; ?>
);
    };

    /**
     * Mozaik value insert function
     *
     * @param text
     * @param elemId
     */
    SuiteEditor.insert = function(text, elemId) {
        if(typeof elemId === 'undefined') {
            elemId = '<?php echo $this->_tpl_vars['elementId']; ?>
';
        }
        if(elemId != '<?php echo $this->_tpl_vars['elementId']; ?>
') {
            throw 'incorrect editor element id (Mozaik id: '+elemId+')';
        }
        if($('#'+elemId+' .mozaik-list .mozaik-elem').length > 0) {
            // similar as the original insert_variable_html(text);
            tinyMCE.activeEditor.execCommand('mceInsertRawHTML', false, text);
        }
    };

</script>

<?php echo $this->_tpl_vars['mozaik']; ?>