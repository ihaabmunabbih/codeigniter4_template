<div class="login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="../../index2.html" class="h4">PT. TEMPO UTAMA FINANCE</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form class="login-form" id="form-login" action="<?php echo base_url('login/do_login'); ?>" method="post">
                    <div class="input-group-username mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="username" placeholder="Username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group-password mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">    
                        <div class="col-4" style="margin: 10px auto;">
                            <button type="submit" class="btn btn-primary btn-block" id="btn-login">Sign In</button>
                        </div>
    
                    </div>
                </form>    
                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $("#form-login").validate({
            errorElement: 'span', //default input error message container
            errorClass: 'error block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent());
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
                        btn.button('loading');
                    },
                    success: function(data) {
                        console.log(data.code);
                        if (data.code == 200)
                        {
                            window.location="<?php echo base_url('home'); ?>";
                        }
                        else 
                        {
                            $('.alert-danger', $('.login-form')).show();
                            $('#alert-message span').text(data.error);
                            let myData=new MyData();
                            myData.getChaptcha();
                            $('#password').val('');
                            $('#captcha').val('');
                        }
                    },
                    complete: function() {
                        btn.button('reset');
                    }
                })
                return false;
            }
        });
    })
</script>