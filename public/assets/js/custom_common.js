$(document).ready(function() {
    $(document).on('click', '.delete-button', function () {
    let stateId = $(this).data('id'); // Get the state ID
    $('.common_delete').attr('data_value', stateId); // Set data_value dynamically
});

    /*---------------------------------------------------------------------
    Select input
    -----------------------------------------------------------------------*/
    jQuery('.select2jsMultiSelect').select2({
        tags: true
    });

    /*---------------------------------------------------------------------
    Search input
    -----------------------------------------------------------------------*/

    var table = $(".bell_of_arms_table").DataTable({
        dom: "Bfrtip",
        iDisplayLength: 50,

        buttons: [
            { extend: "copyHtml5", footer: true },
            { extend: "excelHtml5", footer: true },
            { extend: "csvHtml5", footer: true },
            {
                extend: "pdfHtml5",
                footer: true,
                exportOptions: {
                    stripHtml: true,
                    stripNewlines: false,
                },

                orientation: "landscape",
                pageSize: "LEGAL",
                customize: function(doc) {
                    doc.styles.tableFooter = {
                        background: "white",
                    };
                },
            },

            // { extend: 'print', footer: true }
        ],
    });

    var table = $(".bell_of_arms_table_50").DataTable({
        dom: "Bfrtip",
        iDisplayLength: 50,

        buttons: [
            { extend: "copyHtml5", footer: true },
            { extend: "excelHtml5", footer: true },
            { extend: "csvHtml5", footer: true },
            {
                extend: "pdfHtml5",
                footer: true,
                exportOptions: {
                    stripHtml: true,
                    stripNewlines: false,
                },

                orientation: "landscape",
                pageSize: "LEGAL",
                customize: function(doc) {
                    doc.styles.tableFooter = {
                        background: "white",
                    };
                },
            },

            // { extend: 'print', footer: true }
        ],
    });

    $('.form-select2').select2();

    // Generic Form
    $("[id^=generic_form]").submit(function(e) {
        e.preventDefault();

        $("#processing_toast_message").show();
        $("#processing_toast_message").toast("show");

        var form = new FormData(this);
        var url = $(this).attr("action");

        // console.log(url);

        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(this),
            processData: false,
            contentType: false,
        }).done(function(data) {
            // log data to the console so we can see
            // console.log(data);
            data = $.parseJSON(data);

            $("#toast_message").empty().append(data.status_message);
            $("#processing_toast_message").hide();
            $("#alert_toast").toast("show");
            if (data.refresh_page == "Yes") {
                setTimeout(function() {
                    location.reload();
                }, 2000);
            }

            if (data.redirect_url != null) {
                setTimeout(function() {
                    window.location.href = data.redirect_url;
                }, 2000);
            }
        });
    });

  $('.common_delete').click(function (e) {
        e.preventDefault();
console.log('hello');
        // $("#processing_toast_message").show();
        $("#processing_toast_message").show();
        $("#processing_toast_message").toast("show");
        var value = $(this).attr('data_value');
        var url = $(this).attr("href");
        console.log(value);
        console.log(url);

        $.ajax({
            type: 'post', // define the type of HTTP verb we want to use (POST for our form)
            url: url, // the url where we want to POST
            data: { post_value: value },
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })

            // using the done promise callback
            .done(function (data) {
                // log data to the console so we can see
          $("#toast_message").empty().append(data.status_message);
            $("#processing_toast_message").hide();
            $("#alert_toast").toast("show");

                if (data.status_code == 200) {


                }

                if (data.refresh_page == 'Yes') {
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }

                if (data.redirect_url != null) {
                    setTimeout(function () {
                        window.location.href = data.redirect_url;
                    }, 2000);
                }
            });
        return false;
    });

    $(document).on("click", '[class^="edit_value"]', function(e) {
        e.preventDefault();
        $("#processing_toast_message").show();
        $("#processing_toast_message").toast("show");
        var url = $(this).attr("data_url");
        var edit_id = $(this).attr("data_id");

        if (edit_id !== null && edit_id !== undefined) {
            $.ajax({
                type: "post",
                url: url,
                data: { value: edit_id },
                dataType: "json",
                encode: true,
            }).done(function(data) {
                // log data to the console so we can see
                // console.log(data.response_data.edit_values);
                $("#toast_message").empty().append(data.status_message);
                $("#processing_toast_message").hide();
                $("#alert_toast").toast("show");
                if (data.status_code == 200) {
                    $("#edit_body").empty().append(data.response_data.edit_values);
                    if (
                        data.response_data.url !== undefined &&
                        data.response_data.url !== null
                    ) {
                        $("[id^=generic_form]").attr("action", data.response_data.url);
                    }
                    $("#modal-trigger").trigger("click");
                    $(".select2").select2();

                }

                if (data.refresh_page == "Yes") {
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }

                if (data.redirect_url != null) {
                    setTimeout(function() {
                        window.location.href = data.redirect_url;
                    }, 2000);
                }

            });
        }
        return false;
    });

    $(document).on("click", '[class^="delete_value"]', function(e) {
        e.preventDefault();
        $("#processing_toast_message").show();
        $("#processing_toast_message").toast("show");
        var url = $(this).attr("data_url");
        var delete_id = $(this).attr("data_id");

        if (delete_id !== null && delete_id !== undefined) {
            $.ajax({
                type: "post",
                url: url,
                data: { value: delete_id },
                dataType: "json",
                encode: true,
            }).done(function(data) {
                // log data to the console so we can see
                // console.log(data.response_data.edit_values);
                $("#toast_message").empty().append(data.status_message);
                $("#processing_toast_message").hide();
                $("#alert_toast").toast("show");
                if (data.status_code == 200) {
                    $("#delete_body").empty().append(data.response_data.delete_values);
                    if (
                        data.response_data.url !== undefined &&
                        data.response_data.url !== null
                    ) {
                        $("[id^=generic_form]").attr("action", data.response_data.url);
                    }
                    // $("#modal-trigger").trigger("click");
                }

                if (data.refresh_page == "Yes") {
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }

                if (data.redirect_url != null) {
                    setTimeout(function() {
                        window.location.href = data.redirect_url;
                    }, 2000);
                }

            });
        }
        return false;
    });

    $(document).on("click", '[class^="status_change"]', function(e) {
        e.preventDefault();
        $("#processing_toast_message").show();
        $("#processing_toast_message").toast("show");
        var url = $(this).attr("data_url");
        var status_id = $(this).attr("data_id");

        if (status_id !== null && status_id !== undefined) {
            $.ajax({
                type: "post",
                url: url,
                data: { value: status_id },
                dataType: "json",
                encode: true,
            }).done(function(data) {
                // log data to the console so we can see
                // console.log(data.response_data.edit_values);
                $("#toast_message").empty().append(data.status_message);
                $("#processing_toast_message").hide();
                $("#alert_toast").toast("show");
                if (data.status_code == 200) {
                    $("#status_body").empty().append(data.response_data.status_values);
                    if (
                        data.response_data.url !== undefined &&
                        data.response_data.url !== null
                    ) {
                        $("[id^=generic_form]").attr("action", data.response_data.url);
                    }
                    // $("#modal-trigger").trigger("click");
                }

                if (data.refresh_page == "Yes") {
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }

                if (data.redirect_url != null) {
                    setTimeout(function() {
                        window.location.href = data.redirect_url;
                    }, 2000);
                }

            });
        }
        return false;
    });

    $(document).on("change", "[id^=get_zone_wise_ps]", function() {
        console.log($(this).attr("data_url"));
        var url = $(this).attr("data_url");
        var ps_id = $(this).val();

        if (ps_id !== null && ps_id !== undefined) {
            $.ajax({
                type: "post",
                url: url,
                data: { value: ps_id },
                dataType: "json",
                encode: true,
            }).done(function(data) {
                // log data to the console so we can see
                // console.log("#task_name_body1");
                $("#toast_message").empty().append(data.status_message);
                $("#processing_toast_message").hide();
                $("#alert_toast").toast("show");
                if (data.status_code == 200) {
                    $("#ps_select_body")
                        .empty()
                        .append(data.response_data.ps_values);
                    $("#ps_select_edit_body")
                        .empty()
                        .append(data.response_data.ps_values);
                    $(".select2").select2();
                }
            });
        }
        return false;
    });

    $(document).on("change", "[id^=select_category_]", function() {
        var url = $(this).attr("data_url");
        var category_id = $(this).val();
        var target = $(this).data("target");
        var index = $(this).data("index");

        if (category_id) {
            $.ajax({
                type: "post",
                url: url,
                data: { value: category_id, index: index },
                dataType: "json",
                encode: true,
            }).done(function(data) {
                $("#toast_message").empty().append(data.status_message);
                $("#processing_toast_message").hide();
                $("#alert_toast").toast("show");

                if (data.status_code == 200) {
                    $("#" + target).empty().append(data.response_data.part_values);
                    $(".select2").select2();
                }
            });
        }
        return false;
    });

    $(document).on("change", "[id^=get_cat_wise_part_in_edit]", function() {
        var url = $(this).attr("data_url");
        var category_id = $(this).val();

        if (category_id !== null && category_id !== undefined) {
            $.ajax({
                type: "post",
                url: url,
                data: { value: category_id },
                dataType: "json",
                encode: true,
            }).done(function(data) {
                // log data to the console so we can see
                // console.log("#task_name_body1");
                $("#toast_message").empty().append(data.status_message);
                $("#processing_toast_message").hide();
                $("#alert_toast").toast("show");
                if (data.status_code == 200) {
                    $("#part_select_edit_body")
                        .empty()
                        .append(data.response_data.part_edit_values);
                    $(".select2").select2();
                }
            });
        }
        return false;
    });


});

///////////////////////////////// otp verification //////////////////// 
$("#sendOtpBtn").click(function() {
    $("#processing_toast_message").show();
    $("#processing_toast_message").toast("show");
    const mobile = $('#mobile_number').val();
    var url = $("#opt_generate_url").attr("href");
    $.ajax({
        type: "post", // define the type of HTTP verb we want to use (POST for our form)
        url: url, // the url where we want to POST
        data: { mobile: mobile },
        dataType: "json", // what type of data do we expect back from the server
        encode: true,
    })

    // using the done promise callback
    .done(function(data) {
        // log data to the console so we can see
        console.log(data);

        $("#toast_message").empty().append(data.status_message);
        $("#processing_toast_message").hide();
        $("#alert_toast").toast("show");

        if (data.status_code == 200) {
            $('#mobileInputGroup').hide();
            $('#sendOtpBtn').hide();
            $('#otpInputGroup').removeClass('d-none');
            $('#verifyOtpBtn').removeClass('d-none');
            $('#title').text('OTP Verification');
            $('#small-text').text('We have sent an OTP to your mobile number. Please enter it below to continue.');
        }

        if (data.refresh_page == "Yes") {
            setTimeout(function() {
                location.reload();
            }, 2000);
        }

        if (data.redirect_url != null) {
            setTimeout(function() {
                window.location.href = data.redirect_url;
            }, 2000);
        }
    });
    return false;
});
///////////////////////////////////////////////////////////////////// 
$("#verifyOtpBtn").click(function() {
    $("#processing_toast_message").show();
    $("#processing_toast_message").toast("show");
    const otp = $('#otp').val();
    var url = $("#opt_verifcation_url").attr("href");
    $.ajax({
        type: "post", // define the type of HTTP verb we want to use (POST for our form)
        url: url, // the url where we want to POST
        data: { otp: otp },
        dataType: "json", // what type of data do we expect back from the server
        encode: true,
    })

    // using the done promise callback
    .done(function(data) {
        // log data to the console so we can see
        console.log(data);
        console.log(data.redirect_url);

        $("#toast_message").empty().append(data.status_message);
        $("#processing_toast_message").hide();
        $("#alert_toast").toast("show");

        if (data.status_code == 200) {

        }

        if (data.refresh_page == "Yes") {
            setTimeout(function() {
                location.reload();
            }, 2000);
        }

        if (data.redirect_url != null) {
            setTimeout(function() {
                window.location.href = data.redirect_url;
            }, 2000);
        }
    });
    return false;
});


function category_redirect(category) {
    const selected_value = category.value;

    // Skip if no value is selected (e.g., default "Select Category")
    if (!selected_value) return;

    const current_url = window.location.href;

    // Prevent reload loop: only redirect if value not already in URL
    if (!current_url.includes(selected_value)) {
        const base_url = window.location.origin + window.location.pathname.split("/").slice(0, 2).join("/");
        window.location.href = base_url + "/" + selected_value;
    }
}
function product_redirect(selectObj) {
    const product = selectObj.value;
    if (!product) return;

    const segments = window.location.pathname.split('/').filter(Boolean);
    // ["items"] OR ["items","service"] OR ["items","service","product"]

    // Service MUST exist
    if (segments.length < 2) {
        console.warn('Service not selected yet');
        return;
    }

    const service = segments[1];

    const newUrl = window.location.origin + '/items/' + service + '/' + product;

    // Prevent infinite reload
    if (window.location.href !== newUrl) {
        window.location.href = newUrl;
    }
}


function route_value_two_redirect(route_value_two) {
    const selected_value = route_value_two.value;
    // Skip if no value is selected (e.g., default "Select Category")
    if (!selected_value) return;

    const current_url = window.location.href;

    // Prevent reload loop: only redirect if value not already in URL
    if (!current_url.includes(selected_value)) {
        const base_url = window.location.origin + window.location.pathname.split("/").slice(0, 3).join("/");
        window.location.href = base_url + "/" + selected_value;
    }
}

