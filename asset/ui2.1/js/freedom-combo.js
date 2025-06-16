var disableKabupaten = function() {
    $('#kabupaten, #id_kabupaten').val('').attr('disabled', 'disabled').addClass('disabled');
};

var disableKecamatan = function() {
    $('#kecamatan, #id_kecamatan').val('').attr('disabled', 'disabled').addClass('disabled');
};

$('#propinsi').change(function(e) {
    if ($(this).val() == '') {
        disableKabupaten();
        disableKecamatan();
        return;
    }

    $('#div_kecamatan > div').remove();
    disableKecamatan();
    load_kabupaten('propinsi', 'div_kabupaten', 'id_kabupaten', 'kecamatan');
});
function load_kabupaten(idpropinsi,container_kabupaten,nama_input_kabupaten)
{
    var propinsi             = $('#'+idpropinsi).val();
    $('#'+container_kabupaten).html("Loading...");
    $.ajax({
        type    : "POST",
        url     : base_url + 'lokasi/dropdown_kabupaten',
        data    : "id_propinsi="+propinsi+"&nama_input_kabupaten="+nama_input_kabupaten,
        success : function(result){
            $('#'+container_kabupaten).html(result);
        }
    });
}
function load_kecamatan(idkabupaten,container_kecamatan,nama_input_kecamatan)
{
    var kabupaten = $('#'+idkabupaten).val();
    $('#'+container_kecamatan).html("Loading...");
    $.ajax({
        type    : "POST",
        url     : base_url + 'lokasi/dropdown_kecamatan',
        data    : "id_kabupaten="+kabupaten+"&nama_input_kecamatan="+nama_input_kecamatan,
        success : function(result){
            $('#'+container_kecamatan).html(result);
        }
    });
}