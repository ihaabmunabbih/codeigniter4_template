$(document).ready(function () {
    $('#modulaksi').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: BASEURL+'/aksimodul',
            type: 'POST',
        },
        columns: [
            {"data": "No", "orderable": false, "className": "text-center" , "width": 5},
            {"data": "nama_aksi", "orderable": true, "className": "text-left"},
            {"data": "deskripsi", "orderable": true, "className": "text-right"},
            {"data": "Action", "orderable": false, "className": "text-center"},
        ],
        search: {
            return: true,
        },
        "language": {
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            },
                "processing": "Proses.....",
                "emptyTable": "Tidak ada data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                "infoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "lengthMenu": "Menampilkan _MENU_",
                "search": "Pencarian :",
                "zeroRecords": "Tidak ditemukan data yang sesuai",
                "paginate": {
                "previous": "Sebelumnya",
                "next": "Selanjutnya",
                "last": "Terakhir",
                "first": "Pertama"
            }
        },
        "lengthMenu": [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],
        "pageLength": 10,
        "order": [[ 0, "desc" ]],
    });


    //add data debitur
    $("#addGroup").validate({
        errorElement: 'span', //default input error message container
        errorClass: 'error block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        rules: {
            group_id: {
                required: true
            },
            name: {
                required: true
            }
        },
        messages: {
            group_id: {
                required: "Tidak Boleh Kosong"
            },
            name: {
                required: "Tidak Boleh Kosong"
            }
        },
        submitHandler: function(form) {
            form.preventDefault;
            var btn = $("#btn-add");
            var form = $("#addGroup").attr('action');

            $.ajax({
                url: form,
                type: 'POST',
                data: $("#addGroup").serialize(),
                dataType : "json",
                cache: false,
                beforeSend: function() {
                    btn.find('.loading').removeClass('d-none');
                    btn.attr('disabled', true);
                },
                success: function(data) {
                    if (data.code == 200)
                    {
                        Swal.fire({
                            title: 'Sukses',
                            html: data?.message,
                            icon: "success",
                            timer: 3000,
                            timerProgressBar: true,
                            confirmButtonText: 'Oke!',
                            allowEscapeKey: false,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = BASEURL + '/aksimodul';
                            }
                            window.location = BASEURL + '/aksimodul';
                        })
                    }
                    else 
                    {
                        Swal.fire({
                            title: 'Gagal',
                            html: data?.message,
                            icon: "error",
                            confirmButtonText: 'Oke!'
                        });
                    }
                },
                complete: function() {
                    btn.find('.loading').addClass('d-none');
                    btn.removeAttr('disabled');
                }
            })
            return false;
        }
    });

    //edit data debitur
    $("#editGroup").validate({
        errorElement: 'span', //default input error message container
        errorClass: 'error block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        rules: {
            group_id: {
                required: true
            },
            name: {
                required: true
            }
        },
        messages: {
            group_id: {
                required: "Tidak Boleh Kosong"
            },
            name: {
                required: "Tidak Boleh Kosong"
            }
        },
        submitHandler: function(form) {
            form.preventDefault;
            var btn = $("#btn-edit");
            var form = $("#editGroup").attr('action');

            $.ajax({
                url: form,
                type: 'POST',
                data: $("#editGroup").serialize(),
                dataType : "json",
                cache: false,
                beforeSend: function() {
                    btn.find('.loading').removeClass('d-none');
                    btn.attr('disabled', true);
                },
                success: function(data) {
                    if (data.code == 200)
                    {
                        Swal.fire({
                            title: 'Sukses',
                            html: data?.message,
                            icon: "success",
                            timer: 3000,
                            timerProgressBar: true,
                            confirmButtonText: 'Oke!',
                            allowEscapeKey: false,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = BASEURL + '/aksimodul';
                            }
                            window.location = BASEURL + '/aksimodul';
                        })
                    }
                    else 
                    {
                        Swal.fire({
                            title: 'Gagal',
                            html: data?.message,
                            icon: "error",
                            confirmButtonText: 'Oke!'
                        });
                    }
                },
                complete: function() {
                    btn.find('.loading').addClass('d-none');
                    btn.removeAttr('disabled');
                }
            })
            return false;
        }
    });
});