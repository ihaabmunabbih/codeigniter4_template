// $('#aksi').select2({
//     placeholder: "Silahkan Pilih Aksi",
//     width: "100%"
// });

var arrayDataMenu = [];
arrayDataMenu.push({
    id: "",
    text: "Silahkan Pilih Menu Parent"
});

if (typeof dataMenu != "undefined") {
    dataMenu.forEach(data => {
        arrayDataMenu.push({
            id: data.id,
            text: data.nama_modul,
            name: data.nama_modul,
            disabled: (typeof dataEdit != "undefined" && dataEdit.id == data.id) ? true : false
        })
    });
}
arrayDataMenu.push({
    id: "999",
    text: "Tidak ada parent"
});

$('#id_parent').select2({
    data: arrayDataMenu,
    width:'100%',
});

$('#id_parent').on('select2:select', function (e) {
    $('#nama_parent').val($(this).select2('data')[0].name);
});

//select modul action
var arrayAction = [];
modul_action.forEach(data => {
    arrayAction.push({
        id: data.nama_aksi,
        text: data.deskripsi
    })
});

$('#aksi').select2({
    data: arrayAction,
    width:'100%',
    placeholder: "Silahkan Pilih Aksi",
});

if (typeof dataEdit !== 'undefined') {
    $('#id').val(dataEdit.id);
    $('#nama_modul').val(dataEdit.nama_modul);
    $('#id_parent').val(dataEdit.id_parent).trigger('change');
    $('#id_parent_old').val(dataEdit.id_parent);
    $('#link').val(dataEdit.url_modul);
    $('#urutan').val(dataEdit.order_modul);
    $('#aksi').val(dataEdit.aksi).trigger('change');
}