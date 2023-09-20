$(function(){
    $("#form-login").validate({
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
            password: {
                required: true
            }
        },
        messages: {
            username: {
                required: "Tidak Boleh Kosong"
            },
            password: {
                required: "Tidak Boleh Kosong"
            }
        },
        submitHandler: function(form) {
            form.preventDefault;
            var btn = $("#btn-login");
            var form = $("#form-login").attr('action');

            $.ajax({
                url: form,
                type: 'POST',
                data: $("#form-login").serialize(),
                dataType : "json",
                cache: false,
                beforeSend: function() {
                    btn.find('.loading').removeClass('d-none');
                    btn.attr('disabled', true);
                },
                success: function(data) {
                    if (data.code == 200)
                    {
                        window.location = BASEURL + "/home";
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

    $('#logout').on('click', function () {
        let url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function() {
            },
            success: function(data) {
                data = JSON.parse(data);
                if (data.code == 200)
                {
                    window.location = BASEURL;
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
            }
        })
    })
})