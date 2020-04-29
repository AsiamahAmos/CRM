<?php /* Smarty version 2.6.31, created on 2019-10-10 21:40:31
         compiled from modules/Spots/Dashlets/SpotsDashlet/SpotsDashlet.tpl */ ?>
<link rel="stylesheet" type="text/css" href="include/javascript/c3/c3.min.css">
<script type="text/javascript" src="include/javascript/touchPunch/jquery.ui.touch-punch.min.js"></script>
<link rel="stylesheet" type="text/css" href="include/javascript/pivottable/pivot.css">
<script type="text/javascript" src="include/javascript/suitespots/suitespots.js"></script>


<script type="text/javascript">
    <?php echo '
    $(function () {
        $(\'#bootstrap-container\').removeClass(\'col-sm-9 col-sm-offset-3 col-md-10\');
        var renderers = $.extend($.pivotUtilities.renderers, $.pivotUtilities.c3_renderers);

        var template = {
            renderers: renderers
        }
        function getDataForPivot(element, config, type, showUI)
        {
                $.getJSON("index.php",
                        {
                            \'module\': \'Spots\',
                            '; ?>

                            'action': type,
                            <?php echo '
                            \'to_pdf\':1
                        },
                        function (data) {
                            '; ?>

                            if("derivedAttributes" in config)
                                delete config["derivedAttributes"];
                            $(element)
                                    .pivotUI(data,$.extend(config,template),true);

                            if(showUI !== "1")
                                hideUI(element);

                            <?php echo '

                        });
        }
        function hideUI(element)
        {
            //This is to ascertain if the pivot ui is laying out the column options horizontally or vertically
            //It is vertically for larger data sets.  This allows us to hide the pivot ui appropriately
            var columnLayout = $(element+" table.pvtUi tr td:nth-child(3)").length;

            if(columnLayout > 0)
                $(element+" table.pvtUi tbody tr:lt(1),"+element+" table.pvtUi tbody tr:eq(1) td:lt(2)").hide();
            else
                $(element+" table.pvtUi tbody tr:lt(2),"+element+" table.pvtUi tbody tr:nth-child(3) td:nth-child(1)").hide();

        }
        '; ?>

        getDataForPivot(".output-<?php echo $this->_tpl_vars['id']; ?>
",JSON.parse($(".config-<?php echo $this->_tpl_vars['id']; ?>
").val()),$(".type-<?php echo $this->_tpl_vars['id']; ?>
").val(), $(".showUI-<?php echo $this->_tpl_vars['id']; ?>
").val());

        <?php echo '

    });

</script>
'; ?>


<input type="hidden" class="config-<?php echo $this->_tpl_vars['id']; ?>
" value="<?php echo $this->_tpl_vars['config']; ?>
">
<input type="hidden" class="type-<?php echo $this->_tpl_vars['id']; ?>
" value="<?php echo $this->_tpl_vars['type']; ?>
">
<input type="hidden" class="showUI-<?php echo $this->_tpl_vars['id']; ?>
" value="<?php echo $this->_tpl_vars['showUI']; ?>
">
<div class="output-<?php echo $this->_tpl_vars['id']; ?>
"></div>

