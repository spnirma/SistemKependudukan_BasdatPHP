var selectPayment = document.getElementById("id_payment");
var selectedPaymentValue = selectPayment.options[selectPayment.selectedIndex].value;

if (selectedPaymentValue == 11) {
    document.getElementById("message8").style.display = "block";
}

function changeFunc() {
    var selectBox = document.getElementById("id_payment");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;

    if (selectedValue == 1) {
        document.getElementById('lanjutkan').removeAttribute('disabled');
        document.getElementById("message1").style.display = "block";
        document.getElementById("message2").style.display = "none";
        document.getElementById("message3").style.display = "none";
        document.getElementById("message4").style.display = "none";
        document.getElementById("message5").style.display = "none";
        document.getElementById("message6").style.display = "none";
        document.getElementById("message7").style.display = "none";
        document.getElementById("message9").style.display = "none";
        document.getElementById("message10").style.display = "none";
        document.getElementById("message11").style.display = "none";
    } else if (selectedValue == 5) {
        document.getElementById('lanjutkan').removeAttribute("disabled");
        document.getElementById("message2").style.display = "block";
        document.getElementById("message1").style.display = "none";
        document.getElementById("message3").style.display = "none";
        document.getElementById("message4").style.display = "none";
        document.getElementById("message5").style.display = "none";
        document.getElementById("message6").style.display = "none";
        document.getElementById("message7").style.display = "none";
        document.getElementById("message9").style.display = "none";
        document.getElementById("message10").style.display = "none";
        document.getElementById("message11").style.display = "none";
    } else if (selectedValue == 6) {
        document.getElementById('lanjutkan').removeAttribute("disabled");
        document.getElementById("message3").style.display = "block";
        document.getElementById("message2").style.display = "none";
        document.getElementById("message1").style.display = "none";
        document.getElementById("message4").style.display = "none";
        document.getElementById("message5").style.display = "none";
        document.getElementById("message6").style.display = "none";
        document.getElementById("message7").style.display = "none";
        document.getElementById("message9").style.display = "none";
        document.getElementById("message10").style.display = "none";
        document.getElementById("message11").style.display = "none";
    } else if (selectedValue == 7) {
        document.getElementById('lanjutkan').removeAttribute("disabled");
        document.getElementById("message4").style.display = "block";
        document.getElementById("message3").style.display = "none";
        document.getElementById("message2").style.display = "none";
        document.getElementById("message1").style.display = "none";
        document.getElementById("message5").style.display = "none";
        document.getElementById("message6").style.display = "none";
        document.getElementById("message9").style.display = "none";
        document.getElementById("message10").style.display = "none";
        document.getElementById("message11").style.display = "none";
    } else if (selectedValue == 8) {
        document.getElementById('lanjutkan').removeAttribute("disabled");
        document.getElementById("message5").style.display = "block";
        document.getElementById("message4").style.display = "none";
        document.getElementById("message3").style.display = "none";
        document.getElementById("message2").style.display = "none";
        document.getElementById("message1").style.display = "none";
        document.getElementById("message6").style.display = "none";
        document.getElementById("message7").style.display = "none";
        document.getElementById("message9").style.display = "none";
        document.getElementById("message10").style.display = "none";
        document.getElementById("message11").style.display = "none";
    } else if (selectedValue == 9) {
        document.getElementById('lanjutkan').removeAttribute("disabled");
        document.getElementById("message6").style.display = "block";
        document.getElementById("message5").style.display = "none";
        document.getElementById("message4").style.display = "none";
        document.getElementById("message3").style.display = "none";
        document.getElementById("message2").style.display = "none";
        document.getElementById("message1").style.display = "none";
        document.getElementById("message7").style.display = "none";
        document.getElementById("message9").style.display = "none";
        document.getElementById("message10").style.display = "none";
        document.getElementById("message11").style.display = "none";
    } else if (selectedValue == 12) {
        document.getElementById('lanjutkan').removeAttribute("disabled");
        document.getElementById("message9").style.display = "block";
        document.getElementById("message5").style.display = "none";
        document.getElementById("message4").style.display = "none";
        document.getElementById("message3").style.display = "none";
        document.getElementById("message2").style.display = "none";
        document.getElementById("message1").style.display = "none";
        document.getElementById("message7").style.display = "none";
        document.getElementById("message6").style.display = "none";
        document.getElementById("message8").style.display = "none";
        document.getElementById("message10").style.display = "none";
        document.getElementById("message11").style.display = "none";
    } else if (selectedValue == 13) {
        document.getElementById('lanjutkan').removeAttribute("disabled");
        document.getElementById("message10").style.display = "block";
        document.getElementById("message5").style.display = "none";
        document.getElementById("message4").style.display = "none";
        document.getElementById("message3").style.display = "none";
        document.getElementById("message2").style.display = "none";
        document.getElementById("message1").style.display = "none";
        document.getElementById("message7").style.display = "none";
        document.getElementById("message6").style.display = "none";
        document.getElementById("message8").style.display = "none";
        document.getElementById("message9").style.display = "none";
        document.getElementById("message11").style.display = "none";
    } else if (selectedValue == 14) {
        document.getElementById('lanjutkan').removeAttribute("disabled");
        document.getElementById("message11").style.display = "block";
        document.getElementById("message5").style.display = "none";
        document.getElementById("message4").style.display = "none";
        document.getElementById("message3").style.display = "none";
        document.getElementById("message2").style.display = "none";
        document.getElementById("message1").style.display = "none";
        document.getElementById("message7").style.display = "none";
        document.getElementById("message6").style.display = "none";
        document.getElementById("message8").style.display = "none";
        document.getElementById("message9").style.display = "none";
        document.getElementById("message10").style.display = "none";
    } else {
        document.getElementById('lanjutkan').removeAttribute("disabled");
        document.getElementById("message7").style.display = "block";
        document.getElementById("message5").style.display = "none";
        document.getElementById("message9").style.display = "none";
        document.getElementById("message4").style.display = "none";
        document.getElementById("message3").style.display = "none";
        document.getElementById("message2").style.display = "none";
        document.getElementById("message1").style.display = "none";
        document.getElementById("message6").style.display = "none";
        document.getElementById("message10").style.display = "none";
        document.getElementById("message11").style.display = "none";
    }

    if (selectedValue == 0) {
        document.getElementById("message1").style.display = "none";
        document.getElementById("message2").style.display = "none";
        document.getElementById("message3").style.display = "none";
        document.getElementById("message4").style.display = "none";
        document.getElementById("message5").style.display = "none";
        document.getElementById("message6").style.display = "none";
        document.getElementById("message7").style.display = "none";
        document.getElementById("message9").style.display = "none";
        document.getElementById("message10").style.display = "none";
        document.getElementById("message11").style.display = "none";
        document.getElementById('lanjutkan').setAttribute("disabled", "disabled");
    }
}
function get_card_numer() {
    var card = document.getElementById("card_number").value;
    document.getElementById("card_numbers").innerHTML = card.substr(6, 16);
}

$('#lanjutkan').on("click", function(e) {

    if ($(this).hasClass("noclick")) {
        e.preventDefault();
        // alert('Tombol lanjutkan hanya dapat diklik 1 kali. Transaksi sedang diproses.');
        return;
    } else {
        $('#lanjutkan').addClass('noclick');
    }
    
    var selectBox = document.getElementById("id_payment");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    
    if (selectedValue != 13) {        
        return;
    }

    $.ajax({
        url: baseUrl + "cart/billing_payment",
        type: "POST",
        cache: false,
        data: {
            "format": "json",
            "id_payment": selectedValue,
            "nomer_hp": $('#nomer_hp2').val(),
            "submit": 1
        },
        beforeSend: function() {
            $("#dompetku-progress-modal").modal("show");
        },
        success: function(response) {

            try {
                var data = JSON.parse(response);

                if (data.status == 0) {
                    $('.ajax-error-response').remove();
                    $('<div class="alert alert-danger alert-dismissable ajax-error-response"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + data.error + '</div>')
                            .insertBefore('.form-checkout-payment');
                } else {
                    document.location.href = data.redirect_url;
                }
            } catch (e) {
                alert('Terjadi masalah saat proses pembayaran.');
            }
        },
        error: function(response) {
            alert('Terjadi masalah saat proses pembayaran');
        },
        complete: function() {
            $("#dompetku-progress-modal").modal("hide");
            $('#lanjutkan').removeAttr("disabled").removeClass('noclick');
        }
    });

    e.preventDefault();
});