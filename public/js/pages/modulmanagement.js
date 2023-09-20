$(document).ready(function() {
    $('#menumanagement').treegrid({
        url         :  BASEURL+'/managementmodul',
        method      : 'POST',
        striped     : false,
        fitColumns  : true,
        treeField   : 'nama_modul',
        idField     : 'id_grid',
        emptyMsg    : 'Tidak Ada Data.',
        loadMsg     : 'Memproses, tunggu sebentar.',
        scrollbarSize: 0,
        nowrap      : true,
        sortable    : false,
        singleSelect: true,
        columns:[[
            { field: 'nama_modul', title: 'Nama Menu', width: 100},
            { field: 'url_modul', title: 'URL', width: 80},
            { field: 'Action', title: 'Aksi', width: 30,align: 'center'},
        ]],

        onLoadSuccess: function(row, data){
            $('.tree-folder').css('background','none');
            $('.tree-file').css('background','none');

            $('#grid').treegrid('resize')
            $('.sidebar-toggle').click(function(){
                $('#grid').treegrid('resize');
            });

            $(window).resize(function(){
                $('#grid').treegrid('resize');
            })

            r = data.rows;
            for(i in r){
                if(r[i].iconCls != ''){
                    $('.'+r[i].iconCls).html('<i class="'+r[i].iconCls+'"></i>');
                }
            }
        }
    });

    //insert data
    $("#addMenu").validate({
        errorElement: 'span', //default input error message container
        errorClass: 'error block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        rules: {
            nama_modul: {
                required: true
            },
            id_parent: {
                required: true
            },
            link: {
                required: true
            },
            urutan: {
                required: true
            },
            aksi: {
                required: true
            },
        },
        messages: {
            nama_modul: {
                required: "Tidak Boleh Kosong"
            },
            id_parent: {
                required: "Tidak Boleh Kosong"
            },
            link: {
                required: "Tidak Boleh Kosong"
            },
            urutan: {
                required: "Tidak Boleh Kosong"
            },
            aksi: {
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
            var form = $("#addMenu").attr('action');

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
                        data: $("#addMenu").serialize(),
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
                                        window.location = BASEURL + '/managementmodul';
                                    }
                                    window.location = BASEURL + '/managementmodul';
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

    //edit data
    $("#editMenu").validate({
        errorElement: 'span', //default input error message container
        errorClass: 'error block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        rules: {
            nama_modul: {
                required: true
            },
            id_parent: {
                required: true
            },
            link: {
                required: true
            },
            urutan: {
                required: true
            },
            aksi: {
                required: true
            },
        },
        messages: {
            nama_modul: {
                required: "Tidak Boleh Kosong"
            },
            id_parent: {
                required: "Tidak Boleh Kosong"
            },
            link: {
                required: "Tidak Boleh Kosong"
            },
            urutan: {
                required: "Tidak Boleh Kosong"
            },
            aksi: {
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
            var form = $("#editMenu").attr('action');

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
                        data: $("#editMenu").serialize(),
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
                                        window.location = BASEURL + '/managementmodul';
                                    }
                                    window.location = BASEURL + '/managementmodul';
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
});