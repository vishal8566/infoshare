


jQuery(document).on('click', '#delete_template', function () {

    var deleteId = jQuery(this).attr("templateId");
    //OpenModalBox('Confirmation', 'Are you sure you want to delete this template ?', '<button class="btn close-link" id="cancel" data-dismiss="modalbox" aria-hidden="true" style="margin-right:5px">Cancel</button><a class="btn btn-primary" id="dataConfirmOK">Delete</a>')
    jQuery("#delete_template_open").trigger("click");
    jQuery('#dataConfirmOK').click(function () {
        jQuery("#delete_form_" + deleteId).submit();
    });
});
jQuery(document).ready(function () {
    if (jQuery('#datatable-1').length > 0) {
        jQuery('#datatable-1').dataTable({
            "aaSorting": [[0, "asc"]],
            "sDom": "<'box-content'<'col-sm-6'f><'col-sm-6 text-right'l><'clearfix'>>rt<'box-content'<'col-sm-6'i><'col-sm-6 text-right'p><'clearfix'>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sSearch": "",
                "sLengthMenu": '_MENU_'
            }
        });
        jQuery(".add_template_form").validate();
    }
////////////////////////////////////////////////////////////////////////Form Builder jQuery/////////////////////////////////////////////
    var start_count = 1;


    var field = "";
    var field_type = "";
    var help = "";
    var last_id = 1;

    jQuery(".select_option").change(function () {
        start_count = parseInt(jQuery("#start_count").val()) + start_count;
        appendNewField(jQuery(this).val());
            jQuery(this).val(0).blur();
            /*jQuery('html, body').animate({
             scrollTop: jQuery('#frm-' + (start_count - 1) + '-item').offset().top
             }, 500);*/
            
       
    });



    var appendNewField = function (type, values, options, required) {
        var count = start_count;
        
        field = '';
        field_type = type;

        if (typeof (values) === 'undefined') {
            values = '';
        }

        switch (type) {
            
            case 'form_name':
                appendFormName(values, required, count);
                break;
            case 'text':
                appendTextInput(values, required, count);
                break;
            case 'checkbox':
                appendCheckboxGroup(values, options, required, count);
                break;
            case 'radio':
                appendRadioGroup(values, options, required, count);
                break;
//            case 'select':
//                appendSelectList(values, options, required, count);
//                break;
        }
    };


    var appendFormName = function (values, required, count) {
        var weightage = '';
        field += '<label>Form Name</label>';
        field += '<input class="fld-title form-control" id="title-' + count + '" type="text" value="' + values + '" />';
        field += '<div style="clear:both;"></div>';
        field += '<label>Weightage</label>';
        field += '<input type="number" class="fld-weight form-control" name="weightage" id="weightage-' + count + '" value="' + weightage + '" />';
        help = '';
        appendFieldLi("Form Title", field, required, help, count);
    };
    // multi-line textarea
    var appendTextInput = function (values, required, count) {
        var weightage = '';
        field += '<label>Survey Question</label>';
        field += '<input class="fld-title form-control" id="title-' + count + '" type="text" value="' + values + '" />';
        field += '<div style="clear:both;"></div>';
        field += '<label>Weightage</label>';
        field += '<input type="number" class="fld-weight form-control" name="weightage" id="weightage-' + count + '" value="' + weightage + '" />';
        help = '';
        appendFieldLi("Question Group", field, required, help, count);
    };
    // adds a checkbox element
    var appendCheckboxGroup = function (values, options, required, count) {
        var title = '';
        var weightage = '';
        if (typeof (options) === 'object') {
            title = options[0];
        }
        field += '<div class="chk_group">';
        field += '<div class="frm-fld"><label>Title</label>';
        field += '<input type="text" class="fld-title form-control" name="title" id="title-' + count + '" value="' + title + '" /></br>';
        field += '<label>Weightage</label>';
        field += '<input type="text" class="fld-weight form-control" name="weightage" id="weightage-' + count + '" value="' + weightage + '" /></div>';
        field += '<div class="false-label">Select Options</div>';
        field += '<div class="fields">';

        field += '<div><ol class="ol_opt_sortable ui-sortable">';

        if (typeof (values) === 'object') {
            for (i = 0; i < values.length; i++) {
                field += checkboxFieldHtml(values[i]);
            }
        }
        else {
            field += checkboxFieldHtml('');
        }

        field += '<div class="add-area"><a href="#" class="add add_ck">Add</a></div>';
        field += '</ol></div>';
        field += '</div>';
        field += '</div>';
        help = '';
        appendFieldLi("Selection Group", field, required, help, count);

        //jQuery('.ol_opt_sortable').sortable(); // making the dynamically added option fields sortable.
    };
    // Checkbox field html, since there may be multiple
    var checkboxFieldHtml = function (values) {
        var checked = false;
        var value = '';
        if (typeof (values) === 'object') {
            value = values[0];
            checked = (values[1] === 'false' || values[1] === 'undefined') ? false : true;
        }
        field = '<li>';
        field += '<div>';
        field += '<input type="checkbox"' + (checked ? ' checked="checked"' : '') + ' />';
        field += '<input type="text" value="' + value + '" />';
        field += '<a href="#" class="remove" title="Remove">Remove</a>';
        field += '</div></li>';
        return field;
    };
    // adds a radio element
    var appendRadioGroup = function (values, options, required, count) {
        var title = '';
        var weightage = '';
        if (typeof (options) === 'object') {
            title = options[0];
        }
        field += '<div class="rd_group">';
        field += '<div class="frm-fld"><label>Title</label>';
        field += '<input type="text" class="fld-title form-control" name="title" id="title-' + count + '" value="' + title + '" /></br>';
        field += '<label>Weightage</label>';
        field += '<input type="text" class="fld-weight form-control" name="weightage" id="weightage-' + count + '" value="' + weightage + '" /></div>';
        field += '<div class="false-label">Select Options</div>';
        field += '<div class="fields">';

        field += '<div><ol class="ol_opt_sortable ui-sortable">';

        if (typeof (values) === 'object') {
            for (i = 0; i < values.length; i++) {
                field += radioFieldHtml(values[i], 'frm-' + count + '-fld');
            }
        }
        else {
            field += radioFieldHtml('', 'frm-' + count + '-fld');
        }

        field += '<div class="add-area"><a href="#" class="add add_rd">Add</a></div>';
        field += '</ol></div>';
        field += '</div>';
        field += '</div>';
        help = '';
        appendFieldLi("Yes/No Group", field, required, help, count);

        //jQuery('.ol_opt_sortable').sortable(); // making the dynamically added option fields sortable. 
    };
    // Radio field html, since there may be multiple
    var radioFieldHtml = function (values, name) {
        var checked = false;
        var value = '';
        if (typeof (values) === 'object') {
            value = values[0];
            checked = (values[1] === 'false' || values[1] === 'undefined') ? false : true;
        }
        field = '<li>';
        field += '<div>';
        field += '<input type="radio"' + (checked ? ' checked="checked"' : '') + ' name="radio_' + name + '" />';
        field += '<input type="text" value="' + value + '" />';
        field += '<a href="#" class="remove" title="Remove">Remove</a>';
        field += '</div></li>';

        return field;
    };
    // adds a select/option element
//    var appendSelectList = function (values, options, required, count) {
//        var multiple = false;
//        var title = '';
//        var weightage = '';
//        if (typeof (options) === 'object') {
//            title = options[0];
//            multiple = options[1] === 'true' || options[1] === 'checked' ? true : false;
//        }
//        field += '<div class="opt_group">';
//        field += '<div class="frm-fld"><label>Title</label>';
//        field += '<input type="text" class="fld-title form-control" name="title" id="title-' + count + '" value="' + title + '" /></br>';
//        field += '<label>Weightage</label>';
//        field += '<input type="text" class="fld-weight form-control" name="weightage" id="weightage-' + count + '" value="' + weightage + '" /></div>';
//        field += '';
//        field += '<div class="false-label">Select Options</div>';
//        field += '<div class="fields">';
//        field += '<input type="checkbox" name="multiple"' + (multiple ? 'checked="checked"' : '') + '>';
//        field += '<label class="auto">Allow Multiple Selections</label>';
//
//        field += '<div><ol class="ol_opt_sortable ui-sortable">';
//
//        if (typeof (values) === 'object') {
//            for (i = 0; i < values.length; i++) {
//                field += selectFieldHtml(values[i], multiple);
//            }
//        }
//        else {
//            field += selectFieldHtml('', multiple);
//        }
//
//        field += '<div class="add-area"><a href="#" class="add add_opt">Add</a></div>';
//        field += '</ol></div>';
//        field += '</div>';
//        field += '</div>';
//        help = '';
//        appendFieldLi("Select", field, required, help, count);
//
//        //jQuery('.ol_opt_sortable').sortable(); // making the dynamically added option fields sortable.  
//    };
//    // Select field html, since there may be multiple
//    var selectFieldHtml = function (values, multiple) {
//        if (multiple) {
//            return checkboxFieldHtml(values);
//        }
//        else {
//            return radioFieldHtml(values);
//        }
//    };


    // Appends the new field markup to the editor
    var appendFieldLi = function (title, field_html, required, help, count) {
        if (required) {
            required = required === 'checked' ? true : false;
        }
        if(field_type=="form_name"){
            field_type='form_name';
        }
        
        var li = '';
        li += '<li id="frm-' + count + '-item" class="' + field_type + '">';
        li += '<div class="legend">';
        li += '<a id="frm-' + count + '" class="toggle-form " href="#">Hide</a> ';
        li += '<a id="del_' + count + '" class="del-button delete-confirm" href="#" title="Remove"><span>Remove</span></a>';
        li += '<strong id="txt-title-' + count + '">' + title + '</strong></div>';
        li += '<div id="frm-' + count + '-fld" class="frm-holder">';
        li += '<div class="frm-elements">';
        if(title=="Label Group"){}else{
        li += '<div class="frm-fld"><label for="required-' + count + '">Required</label>';
        li += '<input class="required" type="checkbox" value="1" name="required-' + count + '" id="required-' + count + '"' + (required ? ' checked="checked"' : '') + ' /></div>';
        }
        li += field;
        li += '</div>';
        li += '</div>';
        li += '</li>';
        //alert('frm-' + count); return false;


        //jQuery(".form-builder-body").append(li);
        jQuery(".frmb").append(li);
      //  jQuery(".modal-header .close").trigger("click");

        jQuery('#frm-' + count + '-item').hide();
        jQuery('#frm-' + count + '-item').animate({
            opacity: 'show',
            height: 'show'
        }, 'slow');
        //jQuery("#my-form-builder").scrollTop(jQuery("#my-form-builder").scrollTop() + 300);
        jQuery(".save_btn").show();
        // last_id++;

   start_count++;
    };

 

//    var field = '';
//    var checkboxFieldHtml = function (values) {
//        var checked = false;
//        var value = '';
//
//        if (typeof (values) === 'object') {
//            value = values[0];
//            checked = (values[1] === 'false' || values[1] === 'undefined') ? false : true;
//        }
//        field = '<li>';
//        field += '<div>';
//        field += '<input type="checkbox"' + (checked ? ' checked="checked"' : '') + ' />';
//        field += '<input type="text" value="' + value + '" />';
//        field += '<a href="#" class="remove" title="Remove">Remove</a>';
//        field += '</div></li>';
//        return field;
//    };
//    // Radio field html, since there may be multiple
//    var radioFieldHtml = function (values, name) {
//        var checked = false;
//        var value = '';
//        if (typeof (values) === 'object') {
//            value = values[0];
//            checked = (values[1] === 'false' || values[1] === 'undefined') ? false : true;
//        }
//        field = '<li>';
//        field += '<div>';
//        field += '<input type="radio"' + (checked ? ' checked="checked"' : '') + ' name="radio_' + name + '" />';
//        field += '<input type="text" value="' + value + '" />';
//        field += '<a href="#" class="remove" title="Remove">Remove</a>';
//        field += '</div></li>';
//
//        return field;
//    };
//    var selectFieldHtml = function (values, multiple) {
//        if (multiple) {
//            return checkboxFieldHtml(values);
//        }
//        else {
//            return radioFieldHtml(values);
//        }
//    };


    // handle field display/hide
    jQuery('#my-form-builder ul').delegate('.toggle-form', 'click', function () {
        var target = jQuery(this).attr("id");
        if (jQuery(this).html() === "Hide") {
            jQuery(this).removeClass('open').addClass('closed').html("Show");
            jQuery('#' + target + '-fld').animate({
                opacity: 'hide',
                height: 'hide'
            }, 'slow');
            return false;
        }
        if (jQuery(this).html() === "Show") {
            jQuery(this).removeClass('closed').addClass('open').html("Hide");
            jQuery('#' + target + '-fld').animate({
                opacity: 'show',
                height: 'show'
            }, 'slow');
            return false;
        }
        return false;
    });
    // handle delete confirmation
    jQuery('#my-form-builder ul').delegate('.delete-confirm', 'click', function () {
        //jQuery(".select_option").prop("disabled", false)
        var delete_id = jQuery(this).attr("id").replace(/del_/, '');
        if (confirm(jQuery(this).attr('title'))) {
            jQuery('#frm-' + delete_id + '-item').animate({
                opacity: 'hide',
                height: 'hide',
                marginBottom: '0px'
            }, 'slow', function () {
                jQuery(this).remove();
            });
        }
        return false;
    });



    // Attach a callback to add new checkboxes
    jQuery('#my-form-builder ul').delegate('.add_ck', 'click', function () {
        jQuery(this).parent().before(checkboxFieldHtml());
        return false;
    });
    // Attach a callback to add new options
    jQuery('#my-form-builder ul').delegate('.add_opt', 'click', function () {
        jQuery(this).parent().before(selectFieldHtml('', false));
        return false;
    });
    // Attach a callback to add new radio fields
    jQuery('#my-form-builder ul').delegate('.add_rd', 'click', function () {
        jQuery(this).parent().before(radioFieldHtml(false, jQuery(this).parents('.frm-holder').attr('id')));
        return false;
    });


    // handle field delete links
    jQuery('#my-form-builder ul').delegate('.remove', 'click', function () {
        jQuery(this).parent('div').animate({
            opacity: 'hide',
            height: 'hide',
            marginBottom: '0px'
        }, 'fast', function () {
            jQuery(this).remove();
        });
        return false;
    });





    if (typeof jQuery("#my-form-builder ul") != "undefined") {
        //jQuery("#my-form-builder ul").sortable({opacity: 0.6, cursor: 'move'});
    }

    jQuery(".save_btn").click(function () {
        //alert();

        var id = jQuery(".temp_id").val();

        jQuery.ajax({
            type: "POST",
            url: Path + "template/saveTemplate",
            data: jQuery(".frmb").serializeFormList({prepend: "frmb"
            }) + "&form_id=" + id,
            success: function () {
                jQuery("#form_save_message").show();
            }
        });
    });


});

/////////////////////////////////////////////////////////////////////////////////////// For Serialize Data//////////////////////////////////////


jQuery(document).ready(function () {
    jQuery.fn.serializeFormList = function (options) {
        // Extend the configuration options with user-provided
        var defaults = {
            prepend: 'ul',
            is_child: false,
            attributes: ['class']
        };
        var opts = jQuery.extend(defaults, options);
        if (!opts.is_child) {
            opts.prepend = '&' + opts.prepend;
        }
        var serialStr = '';
        // Begin the core plugin
        this.each(function () {
            var ul_obj = this;
            var li_count = 0;
            var c = 1;
            jQuery(this).children().each(function () {
                for (att = 0; att < opts.attributes.length; att++) {
                    var key = (opts.attributes[att] === 'class' ? 'type' : opts.attributes[att]);
                    serialStr += opts.prepend + '[' + li_count + '][' + key + ']=' + encodeURIComponent(jQuery(this).attr(opts.attributes[att]));
                    // append the form field values
                    if (opts.attributes[att] === 'class') {
                        serialStr += opts.prepend + '[' + li_count + '][required]=' + encodeURIComponent(jQuery('#' + jQuery(this).attr('id') + ' input.required').is(':checked'));
                        switch (jQuery(this).attr(opts.attributes[att])) {
                            case 'form_name':
                                serialStr += opts.prepend + '[' + li_count + '][title]=' + encodeURIComponent(jQuery('#' + jQuery(this).attr('id') + ' input[type=text]').val());
                                serialStr += opts.prepend + '[' + li_count + '][weightage]=' + encodeURIComponent(jQuery('#' + jQuery(this).attr('id') + ' input[type=number]').val());
                                break;
                            case 'text':
                                serialStr += opts.prepend + '[' + li_count + '][title]=' + encodeURIComponent(jQuery('#' + jQuery(this).attr('id') + ' input[type=text]').val());
                                serialStr += opts.prepend + '[' + li_count + '][weightage]=' + encodeURIComponent(jQuery('#' + jQuery(this).attr('id') + ' input[type=number]').val());
                                break;
                            case 'checkbox':
                                c = 1;
                                jQuery('#' + jQuery(this).attr('id') + ' input[type=text]').each(function () {
                                    if (jQuery(this).attr('name') === 'title') {
                                        serialStr += opts.prepend + '[' + li_count + '][title]=' + encodeURIComponent(jQuery(this).val());
                                    } else if (jQuery(this).attr('name') === 'weightage') {
                                        serialStr += opts.prepend + '[' + li_count + '][weightage]=' + encodeURIComponent(jQuery(this).val());
                                    }
                                    else {
                                        serialStr += opts.prepend + '[' + li_count + '][options][' + c + '][label]=' + encodeURIComponent(jQuery(this).val());
                                        //serialStr += opts.prepend + '[' + li_count + '][label][' + c + '][baseline]=' + jQuery(this).prev().is(':checked');
                                    }
                                    c++;
                                });
                                break;
                            case 'radio':
                                c = 1;
                                jQuery('#' + jQuery(this).attr('id') + ' input[type=text]').each(function () {
                                    if (jQuery(this).attr('name') === 'title') {
                                        serialStr += opts.prepend + '[' + li_count + '][title]=' + encodeURIComponent(jQuery(this).val());
                                    } else if (jQuery(this).attr('name') === 'weightage') {
                                        serialStr += opts.prepend + '[' + li_count + '][weightage]=' + encodeURIComponent(jQuery(this).val());
                                    }
                                    else {
                                        serialStr += opts.prepend + '[' + li_count + '][options][' + c + '][label]=' + encodeURIComponent(jQuery(this).val());
                                        //serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][baseline]=' + jQuery(this).prev().is(':checked');
                                    }
                                    c++;
                                });
                                break;
                            case 'select':
                                c = 1;
                                serialStr += opts.prepend + '[' + li_count + '][multiple]=' + jQuery('#' + jQuery(this).attr('id') + ' input[name=multiple]').is(':checked');
                                jQuery('#' + jQuery(this).attr('id') + ' input[type=text]').each(function () {
                                    if (jQuery(this).attr('name') === 'title') {
                                        serialStr += opts.prepend + '[' + li_count + '][title]=' + encodeURIComponent(jQuery(this).val());
                                    } else if (jQuery(this).attr('name') === 'weightage') {
                                        serialStr += opts.prepend + '[' + li_count + '][weightage]=' + encodeURIComponent(jQuery(this).val());
                                    }
                                    else {
                                        serialStr += opts.prepend + '[' + li_count + '][options][' + c + '][label]=' + encodeURIComponent(jQuery(this).val());
                                        //serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][baseline]=' + jQuery(this).prev().is(':checked');
                                    }
                                    c++;
                                });
                                break;
                        }
                    }
                }
                li_count++;
            });
        });
        return (serialStr);
    };
});

