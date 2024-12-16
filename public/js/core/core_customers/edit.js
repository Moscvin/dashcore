const changeType = (value = 1) => {
    $(".save_btn").prop("disabled", false);
    if (value == 1) {
        $(".type_legal").removeClass("hidden");
        $(".type_individual").addClass("hidden");
        $(".label_street_address_sl").html("Sede Legale");
        $(".label_street_address_so").html("Sede operativa");
    } else {
        $(".form-control[name=company_name]").removeAttr("autofocus");
        $(".form-control[name=name]").trigger("focus");
        $(".type_legal").addClass("hidden");
        $(".type_individual").removeClass("hidden");
        $(".label_street_address_sl").html("Residenza");
        $(".label_street_address_so").html("Domicilio");
    }
};

const onChangeBirthCountry = (context) => {
    if ($(context).val() != "Italia") {
        $(".province_birth").addClass("hidden");
    } else {
        $(".province_birth").removeClass("hidden");
    }
};

const checkCodeFiscal = (code) => {
    const cf = code.toUpperCase();
    if (cf == "") {
        return false;
    }
    if (!/^[0-9A-Z]{16}$/.test(cf)) {
        return false;
    }
    var map = [
        1, 0, 5, 7, 9, 13, 15, 17, 19, 21, 1, 0, 5, 7, 9, 13, 15, 17, 19, 21, 2,
        4, 18, 20, 11, 3, 6, 8, 12, 14, 16, 10, 22, 25, 24, 23,
    ];
    var s = 0;
    for (var i = 0; i < 15; i++) {
        var c = cf.charCodeAt(i);
        if (c < 65) {
            c = c - 48;
        } else {
            c = c - 55;
        }

        if (i % 2 == 0) {
            s += map[c];
        } else {
            s += c < 10 ? c : c - 10;
        }
    }
    const expected = String.fromCharCode(65 + (s % 26));
    if (expected != cf.charAt(15)) return false;
    return true;
};

const checkZip = (pi) => {
    if (pi == "") return false;
    if (!/^[0-9]{11}$/.test(pi)) return false;
    var s = 0;
    for (i = 0; i <= 9; i += 2) s += pi.charCodeAt(i) - "0".charCodeAt(0);
    for (var i = 1; i <= 9; i += 2) {
        var c = 2 * (pi.charCodeAt(i) - "0".charCodeAt(0));
        if (c > 9) c = c - 9;
        s += c;
    }
    const expected = (10 - (s % 10)) % 10;
    if (expected != pi.charCodeAt(10) - "0".charCodeAt(0)) return false;
    return true;
};

const validateEmail = (email) => {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
};

const initSelect2Component = (postFix) => {
    $(`[name=city_${postFix}]`).select2({
        language: "it",
        theme: "dashcore",
        ajax: {
            url: "/filters/core_cities/ajaxFilter",
            dataType: "json",
            data: (params) => {
                const query = {
                    name: params.term,
                    zip: $(`[name=zip_${postFix}]`).val(),
                };
                return query;
            },
        },
        placeholder: "Comune",
    });

    $(`[name=city_${postFix}]`).on("select2:select", function (e) {
        var data = e.params.data;
        $(`[name=province_${postFix}]`).val(data.province);
    });

    $(`.form-control[name=zip_${postFix}]`).on("focusout", function () {
        $(`[name=city_${postFix}]`).select2("open");
    });
};


jQuery(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    initSelect2Component("sl");
    initSelect2Component("so");

    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    });
});

$("#print_client").on("click", (e) => {
    e.preventDefault();
    $.print(".print_customer", {
        noPrintSelector: ".no-print",
    });
});

$(".form-control[name=country_fiscal]").on("change", function () {
    $(".form-control[name=code_fiscal]")
        .parent()
        .removeClass("has-error has-success has-feedback");
    $(".form-control[name=zip]")
        .parent()
        .removeClass("has-error has-success has-feedback");
});

$(".form-control[name=code_fiscal]").on("keyup", function () {
    $(".save_btn").prop("disabled", false);
    if ($(".form-control[name=country_fiscal]").val() == "Italia") {
        $(this).val($(this).val().replace(/ /g, ""));
        if ($(this).val().length == 0) {
            $(this).parent().removeClass("has-error has-success has-feedback");
        } else if (checkCodeFiscal($(this).val()) || checkZip($(this).val())) {
            $(this).parent().removeClass("has-error");
            $(this).parent().addClass("has-success has-feedback");
        } else {
            $(this).parent().removeClass("has-success has-feedback");
            $(this).parent().addClass("has-error");
            $(".save_btn").prop("disabled", true);
        }
    }
});

$(".form-control[name=code_fiscal_individual]").on("keyup", function () {
    $(".save_btn").prop("disabled", false);
    if ($(".form-control[name=country_fiscal]").val() == "Italia") {
        $(this).val($(this).val().replace(/ /g, ""));

        if ($(this).val().length == 0) {
            $(this).parent().removeClass("has-error has-success has-feedback");
        } else if (checkCodeFiscal($(this).val())) {
            $(this).parent().removeClass("has-error");
            $(this).parent().addClass("has-success has-feedback");
        } else {
            $(this).parent().removeClass("has-success has-feedback");
            $(this).parent().addClass("has-error");
            $(".save_btn").prop("disabled", true);
        }
    }
});

$(".form-control[name=vat]").on("keyup", function () {
    $(".save_btn").prop("disabled", false);
    if ($(".form-control[name=country_fiscal]").val() == "Italia") {
        $(this).val($(this).val().replace(/ /g, ""));

        if ($(this).val().length == 0) {
            $(this).parent().removeClass("has-error has-success has-feedback");
        } else if (checkZip($(this).val())) {
            $(this).parent().removeClass("has-error");
            $(this).parent().addClass("has-success has-feedback");
        } else {
            $(this).parent().removeClass("has-success has-feedback");
            $(this).parent().addClass("has-error");
            $(".save_btn").prop("disabled", true);
        }
    }
});

$(".form-control[name=email],.form-control[name=pec],.form-control[name=rl_email],.form-control[name=referent_email]").on("keyup", function () {
    var value = $(this).val();

    if (value.length > 0) {
        if (validateEmail(value)) {
            $(this).parent().removeClass("has-error");
            $(this).parent().addClass("has-success has-feedback");
        } else {
            $(this).parent().removeClass("has-success has-feedback");
            $(this).parent().addClass("has-error");
        }
    } else {
        $(this).parent().removeClass("has-error");
        $(this).parent().removeClass("has-success has-feedback");
    }
});
