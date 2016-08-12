/* delete functionality in saved search list in community tasting notes */
var domain = document.domain;
var Path = "http://" + domain + "/audit/trunk/audit/index.php/admin/";

/*---LEFT BAR ACCORDION----*/
$(function () {
    $('#nav-accordion').dcAccordion({
        eventType: 'click',
        autoClose: true,
        saveState: true,
        disableLink: true,
        speed: 'slow',
        showCount: false,
        autoExpand: true,
//        cookie: 'dcjq-accordion-1',
        classExpand: 'dcjq-current-parent'
    });
});
var CountryId = "";
$(document).ready(function () {
    if ($(".delete_client").length > 0) {
        $(".delete_client").click(function () {
            jQuery("#delete_template_open").trigger("click");
            var thisObj = $(this);

            jQuery('#dataConfirmOK').click(thisObj, function (event) {
                var deleteId = thisObj.attr("clientId");
                jQuery("#delete_form_" + deleteId).submit();
                //jQuery(".modal-header .close").trigger("click");
            });
        });
    }

    if ($("#submit-form").length > 0) {
        $("#submit-form").validate();
    }
    if (jQuery('#datatable-filter').lengfth > 0) {
        jQuery('#datatable-filter').dataTable({
            "aaSorting": [[1, "desc"]],
            "sDom": "<'box-content'<'col-sm-6'f><'col-sm-6 text-right'l><'clearfix'>>rt<'box-content'<'col-sm-6'i><'col-sm-6 text-right'p><'clearfix'>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sSearch": "",
                "sLengthMenu": '_MENU_'
            }
        });
    }
    CountryId = $("#country").val();
    loadStateData(true);
    jQuery("#country").change(function () {
        CountryId = $(this).val();
        loadStateData(false);
    });

    if ($("#add_client_license").length > 0) {
        $("#add_client_license").click(function () {
            jQuery('#add_new_license').show()
        });
    }
    if ($("#add_client_insurance").length > 0) {
        $("#add_client_insurance").click(function () {
            jQuery('#add_new_insurance').show();
        });
    }
    if ($('.date').length > 0) {
        $('.date').datetimepicker({
            pickTime: false,
            //format: 'DD/MM/YYYY',
            //defaultDate: new Date(),
        });
    }
    $("#lic_save").click(function () {
        var d = new Date($('#lic_valid_up_to').val());
        var date = moment(d); //Get the current date
        var uptoDate = date.format("YYYY-MM-DD");

        jQuery.ajax({
            url: Path + "clients/savelicense",
            type: 'POST',
            dataType: 'JSON',
            data: {'lic_clt_id': $("#clt_id").val(),
                'lic_lic_id': $("#lic_lic_id").val(),
                'lic_number': $("#lic_number").val(),
                'lic_issue_authority': $("#lic_issue_authority").val(),
                'lic_agent': $("#lic_agent").val(),
                'lic_contact_person': $("#lic_contact_person").val(),
                'lic_contact_no': $("#lic_contact_no").val(),
                'lic_valid_up_to': uptoDate,
                'lic_remark': $("#lic_remark").val()
            },
            beforeSend: function () {
                /* Logic before ajax request sent */
            },
            success: function (data, status) {
                $("#lic_number").val("");
                $("#lic_issue_authority").val("");
                $("#lic_agent").val("");
                $("#lic_contact_person").val("");
                $("#lic_contact_no").val("");
                $("#lic_valid_up_to").val("");
                $("#lic_remark").val("");
                $("#add_new_license").before('<tr id="clt_license_' + data.data.lic_id + '" class="clt_license_row"><td>' + data.data.lic_name + '</td><td>' + data.data.lic_number + '</td><td>' + data.data.lic_issue_authority + '</td><td>' + data.data.lic_agent + '</td><td>' + data.data.lic_contact_person + '</td><td>' + data.data.lic_contact_no + '</td><td>' + data.data.lic_valid_upto + '</td><td>' + data.data.lic_remark + '</td><td class="delete"><a alter="delete" class="delete_client_insurance" clt_ins="' + data.data.lic_id + '" id="delete_client_insurance" title="delete" href="javascript:void(0)" deletehref="' + data.data.href + '"><i class="fa fa-times "></i></a></td></tr>');

                $("#no_license_found").hide();
            },
            error: function (xhr, textStatus, errorThrown) {
            },
            complete: function () {
                // Perform any operation need on success/error
            }
        });
    });

    $("#ins_save").click(function () {
        var d = new Date($('#ins_valid_up_to').val());
        var date = moment(d); //Get the current date
        var uptoDate = date.format("YYYY-MM-DD");

        jQuery.ajax({
            url: Path + "clients/saveinsurance",
            type: 'POST',
            dataType: 'JSON',
            data: {'ins_clt_id': $("#clt_id").val(),
                'ins_ins_id': $("#ins_ins_id").val(),
                'ins_number': $("#ins_number").val(),
                'ins_company': $("#ins_company").val(),
                'ins_agent': $("#ins_agent").val(),
                'ins_contact_person': $("#ins_contact_person").val(),
                'ins_contact_no': $("#ins_contact_no").val(),
                'ins_valid_up_to': uptoDate,
                'ins_remark': $("#ins_remark").val()
            },
            beforeSend: function () {
                /* Logic before ajax request sent */
            },
            success: function (data, status) {
                $("#ins_number").val("");
                $("#ins_company").val("");
                $("#ins_agent").val("");
                $("#ins_contact_person").val("");
                $("#ins_contact_no").val("");
                $("#ins_valid_up_to").val("");
                $("#ins_remark").val("");
                $("#add_new_insurance").before('<tr id="clt_insurance_' + data.data.ins_id + '" class="clt_insurance_row"><td>' + data.data.ins_name + '</td><td>' + data.data.ins_number + '</td><td>' + data.data.ins_company + '</td><td>' + data.data.ins_agent + '</td><td>' + data.data.ins_contact_person + '</td><td>' + data.data.ins_contact_no + '</td><td>' + data.data.ins_valid_upto + '</td><td>' + data.data.ins_remark + '</td><td class="delete"><a alter="delete" class="delete_client_insurance" clt_ins="' + data.data.ins_id + '" id="delete_client_insurance" title="delete" href="javascript:void(0)" deletehref="' + data.data.href + '"><i class="fa fa-times "></i></a></td></tr>');
                $("#no_insurance_found").hide();
            },
            error: function (xhr, textStatus, errorThrown) {
            },
            complete: function () {
                // Perform any operation need on success/error
            }
        });
    });

    if ($(".delete_client_license").length > 0) {
        $(".delete_client_license").click(function () {
            var thisObj = $(this);
            jQuery("#delete_template_open").trigger("click");
            jQuery('#dataConfirmOK').click(thisObj, function (event) {
                var trId = thisObj.attr("clt_lic");
                jQuery.ajax({
                    url: thisObj.attr("deletehref"),
                    type: 'GET',
                    dataType: 'JSON',
                    beforeSend: function () {
                        /* Logic before ajax request sent */
                    },
                    success: function (data, status) {
                        $("#clt_license_" + trId).hide();
                        jQuery(".modal-header .close").trigger("click");
                    },
                    error: function (xhr, textStatus, errorThrown) {
                    },
                    complete: function () {
                        // Perform any operation need on success/error
                    }
                });
            });
        });
    }

    if ($(".delete_client_insurance").length > 0) {
        $(".delete_client_insurance").click(function () {
            var thisObj = $(this);
            jQuery("#delete_template_open").trigger("click");
            jQuery('#dataConfirmOK').click(thisObj, function (event) {
                var trId = thisObj.attr("clt_ins");
                jQuery.ajax({
                    url: thisObj.attr("deletehref"),
                    type: 'GET',
                    dataType: 'JSON',
                    beforeSend: function () {
                        // Logic before ajax request sent 
                    },
                    success: function (data, status) {
                        $("#clt_insurance_" + trId).hide();
                        jQuery(".modal-header .close").trigger("click");
                    },
                    error: function (xhr, textStatus, errorThrown) {
                    },
                    complete: function () {
                        // Perform any operation need on success/error
                    }
                });
            });
        });
    }
    
    if($("#ctp_tpl_id_select").length>0) {
        $("#ctp_tpl_id_select").change(function() {
            if($(this).val()!="") {
                location.href=Path+"clients/new/"+$("#ctp_clt_id").val()+"?tpl="+$(this).val();
            }
        });
    }
    if($("#print_template").length>0) {
        $("#print_template").click(function() {
            location.href=Path+"print/print/"+$("#template_id").val();
        });
    }
});
function loadStateData(setState) {
    if (CountryId != "") {
        jQuery.ajax({
            url: Path + "clients/getstate",
            type: 'POST',
            dataType: 'JSON',
            data: {'cnt_id': CountryId},
            beforeSend: function () {
                /* Logic before ajax request sent */
            },
            success: function (data, status) {
                $("#state option").remove();
                var state = $("#state");
                $.each(data.states, function () {
                    state.append($("<option />").val(this.sta_id).text(this.sta_name));
                });
                if (setState == true) {
                    var stateId = $('#country').find(":selected").attr("state_id");
                    $('#state option[value="' + stateId + '"]').attr("selected", "selected");
                }
            },
            error: function (xhr, textStatus, errorThrown) {
            },
            complete: function () {
                // Perform any operation need on success/error
            }
        });
    }
}
var Script = function () {


//    sidebar dropdown menu auto scrolling

    jQuery('#sidebar .sub-menu > a').click(function () {
        var o = ($(this).offset());
        diff = 250 - o.top;
        if (diff > 0)
            $("#sidebar").scrollTo("-=" + Math.abs(diff), 500);
        else
            $("#sidebar").scrollTo("+=" + Math.abs(diff), 500);
    });



//    sidebar toggle

    $(function () {
        function responsiveView() {
            var wSize = $(window).width();
            if (wSize <= 768) {
                $('#container').addClass('sidebar-close');
                $('#sidebar > ul').hide();
            }

            if (wSize > 768) {
                $('#container').removeClass('sidebar-close');
                $('#sidebar > ul').show();
            }
        }
        $(window).on('load', responsiveView);
        $(window).on('resize', responsiveView);
    });

    $('.fa-bars').click(function () {
        if ($('#sidebar > ul').is(":visible") === true) {
            $('#main-content').css({
                'margin-left': '0px'
            });
            $('#sidebar').css({
                'margin-left': '-210px'
            });
            $('#sidebar > ul').hide();
            $("#container").addClass("sidebar-closed");
        } else {
            $('#main-content').css({
                'margin-left': '210px'
            });
            $('#sidebar > ul').show();
            $('#sidebar').css({
                'margin-left': '0'
            });
            $("#container").removeClass("sidebar-closed");
        }
    });

// custom scrollbar
    $("#sidebar").niceScroll({styler: "fb", cursorcolor: "#ad103c", cursorwidth: '3', cursorborderradius: '10px', background: '#404040', spacebarenabled: false, cursorborder: ''});

    $("html").niceScroll({styler: "fb", cursorcolor: "#ad103c", cursorwidth: '6', cursorborderradius: '10px', background: '#404040', spacebarenabled: false, cursorborder: '', zindex: '1000'});

// widget tools

    jQuery('.panel .tools .fa-chevron-down').click(function () {
        var el = jQuery(this).parents(".panel").children(".panel-body");
        if (jQuery(this).hasClass("fa-chevron-down")) {
            jQuery(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
            el.slideUp(200);
        } else {
            jQuery(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
            el.slideDown(200);
        }
    });

    jQuery('.panel .tools .fa-times').click(function () {
        jQuery(this).parents(".panel").parent().remove();
    });


//    tool tips

    $('.tooltips').tooltip();

//    popovers

    $('.popovers').popover();



// custom bar chart

    if ($(".custom-bar-chart")) {
        $(".bar").each(function () {
            var i = $(this).find(".value").html();
            $(this).find(".value").html("");
            $(this).find(".value").animate({
                height: i
            }, 2000)
        })
    }


}();