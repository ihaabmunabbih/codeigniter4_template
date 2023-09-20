$(document).ready(function() {

    //select user group
    var arrayGroup = [];
    arrayGroup.push({
        id: "",
        text: ""
    });

    user_group.forEach(data => {
        arrayGroup.push({
            id: data.id,
            text: data.group_name
        })
    });

    $('#user_group').select2({
        data: arrayGroup,
        width:'100%',
        placeholder: "Silahkan Pilih User Group",
    });

    $('#user_group').on('select2:select', function (e) {
        // console.log($(this).val());
        gridPrivileges($(this).val())
    })

    function gridPrivileges(group_id) {
        $('#privilege').treegrid({
            url         :  BASEURL+'/privilege',
            queryParams : {
                group_id : group_id
            },
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
                { field: 'menu_id', title: 'Check All', width: 20},
                { field: 'nama_modul', title: 'Module', width: 80},
                { field: 'actions', title: 'Aksi', width: 200,align: 'center'},
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
    
                $('.menu').on('change', function () {
                    let id = ($(this).attr('id'));
                    if ($(this).is(":checked")) {
                        $('.act_'+id).prop("checked", true);
                    } else{
                        $('.act_'+id).prop("checked", false);
                    }
                });

                $('#btn-add').removeClass('d-none');
            }
        });
    }

    //insert data
    $("#privilegeForm").validate({
        errorElement: 'span', //default input error message container
        errorClass: 'error block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        rules: {
            user_group: {
                required: true
            },
        },
        messages: {
            user_group: {
                required: "Tidak Boleh Kosong"
            },
        },
        submitHandler: function(form) {
            form.preventDefault;
            var btn = $("#btn-add");
            var form = $("#privilegeForm").attr('action');

            act = $(".actions")
            arr = [];
            for (var i = 0; i < act.length; ++i) {
                action = $(act[i])[0];
                if(action.checked) {
                    p = action.dataset;
                    arr.push({
                        id_modul: p.id_modul,
                        id_privileges: p.id_privileges,
                        status: p.status,
                        name: p.name,
                    });
                }
            }
            
            $.ajax({
                url: form,
                type: 'POST',
                data: {
                        data: arr,
                        group_id: $('#user_group').val()
                      },
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
                                window.location = BASEURL + '/privilege';
                            }
                            window.location = BASEURL + '/privilege';
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
            user_group: {
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
            user_group: {
                required: "Tidak Boleh Kosong"
            },
            aksi: {
                required: "Tidak Boleh Kosong"
            }
        },
        submitHandler: function(form) {
            form.preventDefault;
            var btn = $("#btn-edit");
            var form = $("#editMenu").attr('action');

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
                                window.location = BASEURL + '/menumanagement';
                            }
                            window.location = BASEURL + '/menumanagement';
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