$.ajax({
    url: base_url + 'ajax/get_active_payment',
    type: "GET",
    success: function (response)
    {
        try {
            var data = JSON.parse(response);
            if (data.show_mdr_installment) {
                $('.field-biaya-admin').css('display','table-row');
            } else {
                $('.field-biaya-admin').css('display','none');
            }
        } catch (e) {
            alert('Terjadi Kesalahan pada Pengecekan Payment');
        }
    }
});
$(".formGantiAlamatAjax").submit(function (e)
{
    var postData = $(this).serializeArray();
    var formURL = $(this).attr("action");
    var idMerchant = document.getElementById("id_merchant").value;

    $.ajax({
        url: base_url + 'ajax/change_address_shipping_member',
        type: "POST",
        data: postData,
        success: function (response)
        {
            try {
                var data = JSON.parse(response);

                if (data.status == 0) {
                    $(".formGantiAlamatAjaxError").empty();
                    $(".formGantiAlamatAjaxError").append("<p>" + data.error + "</p>");
                    $(".formGantiAlamatAjaxError").empty();
                    $(".formGantiAlamatAjaxError").append("<p>" + data.error + "</p>");
                } else if (data.status == 1) {
                    window.location.href = data.url;
                }
            } catch (e) {
                alert('Terjadi masalah saat proses penggantian alamat');
            }
        },
        error: function ()
        {
            alert('Terjadi masalah saat proses penggantian alamat');
        },
        complete: function () {
        }

    });
    e.preventDefault(); //STOP default action
    e.unbind(); //unbind. to stop multiple form submit.
});
$(".formGantiNomorTujuanAjax").submit(function (e)
{
    var postData = $(this).serializeArray();
    var formURL = $(this).attr("action");
    var idMerchant = document.getElementById("id_merchant").value;

    $.ajax({
        url: base_url + 'ajax/change_nomor_tujuan_member',
        type: "POST",
        data: postData,
        success: function (response)
        {
            try {
                var data = JSON.parse(response);

                if (data.status == 0) {
                    $(".formGantiNomorTujuanAjaxError").empty();
                    $(".formGantiNomorTujuanAjaxError").append("<p>" + data.error + "</p>");
                    $(".formGantiNomorTujuanAjaxError").empty();
                    $(".formGantiNomorTujuanAjaxError").append("<p>" + data.error + "</p>");
                } else if (data.status == 1) {
                    window.location.href = data.url;
                }
            } catch (e) {
                alert('Terjadi masalah saat proses penggantian alamat');
            }
        },
        error: function ()
        {
            alert('Terjadi masalah saat proses penggantian alamat');
        },
        complete: function () {
        }

    });
    e.preventDefault(); //STOP default action
    e.unbind(); //unbind. to stop multiple form submit.
});
$(".formGantiNomorPelangganAjax").submit(function (e)
{
    var postData = $(this).serializeArray();
    var formURL = $(this).attr("action");
    var idMerchant = document.getElementById("id_merchant").value;

    $.ajax({
        url: base_url + 'ajax/change_nomor_pelanggan_member',
        type: "POST",
        data: postData,
        success: function (response)
        {
            try {
                var data = JSON.parse(response);

                if (data.status == 0) {
                    $(".formGantiNomorPelangganAjaxError").empty();
                    $(".formGantiNomorPelangganAjaxError").append("<p>" + data.error + "</p>");
                    $(".formGantiNomorPelangganAjaxError").empty();
                    $(".formGantiNomorPelangganAjaxError").append("<p>" + data.error + "</p>");
                } else if (data.status == 1) {
                    window.location.href = data.url;
                }
            } catch (e) {
                alert('Terjadi masalah saat proses penggantian nomor pelanggan');
            }
        },
        error: function ()
        {
            alert('Terjadi masalah saat proses penggantian nomor pelanggan');
        },
        complete: function () {
        }

    });
    e.preventDefault(); //STOP default action
    e.unbind(); //unbind. to stop multiple form submit.
});
$('#reset-code-voucher').click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    var codeVoucher = $("#kode_voucher").val();
    $.ajax({
        url: base_url + 'ajax/reset_code_voucher',
        type: "POST",
        data: {
            'kode_voucher': codeVoucher,
        },
        success: function (response)
        {
            try {
                var data = JSON.parse(response);

                if (data.status == 0) {
                    $("#kode_voucher").val('');
                } else if (data.status == 1) {
                    $("#kode_voucher").val('');
                    $("#kode_voucher").removeAttr('disabled');
                    $("#confirm-code-voucher").removeAttr('disabled');
                    $("#kode-voucher-nominal").html('0');
                    window.location.href = data.url;
                }
            } catch (e) {
                alert('Terjadi masalah saat proses hapus kode voucher');
            }
        }
    });
});
$('#confirm-code-voucher').click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    var codeVoucher = $("#kode_voucher").val();
    $.ajax({
        url: base_url + 'ajax/confirm_code_voucher',
        type: "POST",
        data: {
            'kode_voucher': codeVoucher,
        },
        success: function (response)
        {
            try {
                var data = JSON.parse(response);

                if (data.status == 0) {
                    alert(data.error);
                } else if (data.status == 1) {
                    $("#kode_voucher").prop('disabled', 'disabled');
                    $("#confirm-code-voucher").prop('disabled', 'disabled');
                    $("#kode-voucher-nominal").html(data.nominal);
                    window.location.href = data.url;
                }
            } catch (e) {
                alert('Terjadi masalah saat proses pengecekan Kode Voucher');
            }
        }
    });
});

$('#get-voucher-phone-prefix-button').click(function () {
    $.ajax({
        url: base_url + 'ajax/get_voucher_phone_prefix',
        type: "POST",
        success: function (response)
        {
            try {
                var data = JSON.parse(response);

                if (data.status == 0) {
                    alert(data.error);
                } else if (data.status == 1) {
                    $("#get-voucher-phone-prefix").html(data.message);
                    alert(data.message);
                    $("#kode_voucher").prop('disabled', 'disabled');
                    $("#confirm-code-voucher").prop('disabled', 'disabled');
                    $("#kode-voucher-nominal").html(data.nominal);
                    $("#kode_voucher").val(data.kodevoucher);
                    window.location.href = data.url;
                }
            } catch (e) {
                alert('error');
            }
        }
    });
});

$('#accordion .panel-heading').on('click', function(e) {
    var $radio = $(this).find('input[type=radio]');

    $radio.attr('checked', 'checked');
    $radio.prop('checked', true);

    var paymentId = $radio.val();
    $('#input_id_payment').val(paymentId);

    $.ajax({
        url: base_url + 'ajax/confirm_payment',
        type: "POST",
        data: {
            'id_payment': paymentId,
        },
        success: function (response)
        {
            try {
                var data = JSON.parse(response);

                if (data.status == 0) {
                    alert(data.error);
                } else if (data.status == 1 && data.reload_page) {
                    if (data.show_mdr_installment) {
                        $('.field-biaya-admin').css('display','table-row');
                    } else {
                        $('.field-biaya-admin').css('display','none');
                    }
                    $("#biaya-admin-cicilan").html(data.mdr_installment_fee);
                    window.location.href = data.url;
                }
            } catch (e) {
                alert('Terjadi Kesalahan pada Penghitungan Biaya Administrasi');
            }
        }
    });
});

$("#accordion input:radio").click(function(){
    var id = $("input:radio[name='pilih_payment']:checked").val();
    $("#input_id_payment").val(id);

    $(this).parent().children('[data-toggle=collapse]').click();
});

function show_digit_cart_number()
{
    var card = document.getElementById("card_number_user").value;
    document.getElementById("card_number_user_digit").innerHTML = card.substr(6, 16);
}

function update_ongkir(idKeyMerchant)
{
    //    var id_ongkir = $('select.ongkir_sementara' + idKeyMerchant + ' option:selected').val();
    var str = $('input:radio[name="ongkir_sementara_'+idKeyMerchant+'"]:checked').val();
    var fields = str.split('|');
    var id_ongkir = fields[0];
    var key = fields[1];
    
//    alert ("idOngkir=" + id_ongkir + "&idMerchant=" + idKeyMerchant + "&idKey=" + key);
    $.ajax({
        type: "POST",
        url: base_url + 'ajax/change_ongkir_shipping_member',
        data: "idOngkir=" + id_ongkir + "&idMerchant=" + idKeyMerchant + "&idKey=" + key,
        success: function (result) {
            try {
                var data = JSON.parse(result);

                if (data.status == 0) {
                    alert(data.error);
                } else if (data.status == 1) {
                    window.location.href = data.url;
                }
            } catch (e) {
                alert('Terjadi masalah saat proses pemilihan ongkir');
            }
        }
    });
}

$('#lanjutkan').on("click", function (e) {
    if ($(this).hasClass("noclick")) {
        e.preventDefault();
        alert('Tombol lanjutkan hanya dapat diklik 1 kali. Transaksi sedang diproses.');
        return;
    } else {
        $('#lanjutkan').addClass('noclick');
    }

    var id_payment = $("#input_id_payment").val();
    return;
});
function checkFieldOnlyNumber(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if ((charCode > 47 && charCode < 58) || charCode == 44 || charCode == 46 || charCode == 8)
        return true;

    return false;
}
function ajax_load_kabupaten(idpropinsi, container_kabupaten, nama_input_kabupaten, key)
{
    var propinsi = $('.' + idpropinsi).val();
   
    $('.kecamatan' + key).html("");
    var optionTmp = $('<option value="">Silahkan Pilih Kecamatan</option>');
    $('.kecamatan' + key).append(optionTmp);
    
    $('.kecamatan' + key).attr('disabled','disabled');
    $.ajax({
        type: "POST",
        url: base_url + 'lokasi/ajax_dropdown_kabupaten/' + key,
        data: "id_propinsi=" + propinsi + "&nama_input_kabupaten=" + nama_input_kabupaten,
        success: function (result) {
            $('.' + container_kabupaten).html(result);
            $('.' + container_kabupaten).removeAttr('disabled');
        }
    });
}
function ajax_load_kecamatan(idkabupaten, container_kecamatan, nama_input_kecamatan, key)
{
    var kabupaten = $('.' + idkabupaten).val();
    $('.' + container_kecamatan).removeAttr('disabled');
    $.ajax({
        type: "POST",
        url: base_url + 'lokasi/ajax_dropdown_kecamatan/' + key,
        data: "id_kabupaten=" + kabupaten + "&nama_input_kecamatan=" + nama_input_kecamatan,
        success: function (result) {
            $('.' + container_kecamatan).html(result);
        }
    });
}
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if ((charCode > 47 && charCode < 58 ) || charCode == 44 || charCode == 46 || charCode == 8)
        return true;

    return false;
}
$('#reset-point-user').click(function () {
    var pointUserInput = $("#poin_input_user").val();
    $.ajax({
        url: base_url + 'ajax/reset_point_user',
        type: "POST",
        data: {
            'pointInputUser': pointUserInput,
        },
        success: function (response)
        {
            try {
                var data = JSON.parse(response);

                if (data.status == 0) {
                    $("#poin_input_user").val('');
                } else if (data.status == 1) {
                    $("#poin_input_user").val('');
                    $("#poin_input_user").removeAttr('disabled');
                    window.location.href = data.url;
                }
            } catch (e) {
                alert('Terjadi masalah saat proses hapus point');
            }
        }
    });
});
$('#confirm-point-user').click(function () {
    var pointUserInput = $("#poin_input_user").val();
    $.ajax({
        url: base_url + 'ajax/confirm_point_user',
        type: "POST",
        data: {
            'pointInputUser': pointUserInput,
        },
        success: function (response)
        {
            try {
                var data = JSON.parse(response);

                if (data.status == 0) {
                    alert(data.error);
                } else if (data.status == 1) {
                    $("#poin_input_user").prop('disabled', 'disabled');
                    window.location.href = data.url;
                }
            } catch (e) {
                alert('Terjadi masalah saat proses confirm point');
            }
        }
    });
});
