$(document).ready(function () {
    $('#usermanagement').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: BASEURL+'/usermanagement',
            type: 'POST',
        },
        columns: [
            {"data": "No", "orderable": false, "className": "text-center" , "width": 5},
            {"data": "username", "orderable": true, "className": "text-left"},
            {"data": "nama", "orderable": true, "className": "text-left"},
            {"data": "email", "orderable": true, "className": "text-right"},
            {"data": "nomor_telepon", "orderable": true, "className": "text-right"},
            {"data": "user_group", "orderable": true, "className": "text-right"},
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


    //add data user
    $("#addUser").validate({
        errorElement: 'span', //default input error message container
        errorClass: 'error block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        rules: {
            username: {
                required: true
            },
            nama_lengkap: {
                required: true
            },
            password: {
                required: true
            },
            level: {
                required: true
            }
        },
        messages: {
            username: {
                required: "Tidak Boleh Kosong"
            },
            nama_lengkap: {
                required: "Tidak Boleh Kosong"
            },
            level: {
                required: "Tidak Boleh Kosong"
            },
            password: {
                required: "Tidak Boleh Kosong"
            }
        },
        invalidHandler: function(form, validator) {

            if (!validator.numberOfInvalids())
                return;
    
            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top
            }, 0);
    
        },
        submitHandler: function(form) {
            form.preventDefault;
            var btn = $("#btn-add");
            var form = $("#addUser").attr('action');

            Swal.fire({
                title: "Yakin?",
                text: "Anda yakin melanjutkan proses ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, yakin!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form,
                        type: 'POST',
                        data: $("#addUser").serialize(),
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
                                        window.location = BASEURL + '/usermanagement';
                                    }
                                    window.location = BASEURL + '/usermanagement';
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
            })
        }
    });

    //edit data debitur
    $("#editUser").validate({
        errorElement: 'span', //default input error message container
        errorClass: 'error block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        rules: {
            username: {
                required: true
            },
            nama_lengkap: {
                required: true
            },
            password: {
                required: true
            },
            level: {
                required: true
            }
        },
        messages: {
            username: {
                required: "Tidak Boleh Kosong"
            },
            nama_lengkap: {
                required: "Tidak Boleh Kosong"
            },
            level: {
                required: "Tidak Boleh Kosong"
            },
            password: {
                required: "Tidak Boleh Kosong"
            }
        },
        invalidHandler: function(form, validator) {

            if (!validator.numberOfInvalids())
                return;
    
            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top
            }, 0);
    
        },
        submitHandler: function(form) {
            form.preventDefault;
            var btn = $("#btn-edit");
            var form = $("#editUser").attr('action');
            
            Swal.fire({
                title: "Yakin?",
                text: "Anda yakin melanjutkan proses ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, yakin!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form,
                        type: 'POST',
                        data: $("#editUser").serialize(),
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
                                        window.location = BASEURL + '/usermanagement';
                                    }
                                    window.location = BASEURL + '/usermanagement';
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
            })
        }
    });

    //select user group
    var arrayGroup = [];
    user_group.forEach(data => {
        arrayGroup.push({
            id: data.user_group,
            text: data.group_name
        })
    });

    $('#level').select2({
        data: arrayGroup,
        width:'100%',
    });

    if (typeof dataUser != "undefined") {
        $('#level').val(dataUser.user_group).trigger('change')
    }

    $('#edit-profil').on('click', function () {
        $('input').removeAttr("readonly");
        $('select').prop("disabled", false);
        $('.btn-submit').removeClass('d-none');
    });

    $('#btn-cancel').on('click', function () {
        $('input').attr("readonly", true);
        $('select').prop("disabled", true);
        $('.btn-submit').addClass('d-none');
    });
});