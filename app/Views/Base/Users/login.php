<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= lang('main.login') ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/ltr/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/ltr/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/ltr/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?= base_url() ?>assets/ltr/index2.html" class="h1"><b>Admin</b>Area</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg"><?= lang('main.signinToStartSession') ?></p>

                <div class="success_response"></div>

                <form id="login_form" action="<?= site_url("$module/$class/authenticate") ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="input-group input-group-sm mb-3">
                        <input type="email" name="email" id="email" class="form-control" placeholder="<?= lang('main.email') ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="<?= lang('main.password') ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    <?= lang('main.rememberMe') ?>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-sm btn-primary btn-block"><?= lang('main.signIn') ?></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!--                    <div class="social-auth-links text-center mt-2 mb-3">
                                            <a href="#" class="btn btn-block btn-primary">
                                                <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                                            </a>
                                            <a href="#" class="btn btn-block btn-danger">
                                                <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                                            </a>
                                        </div>-->
                <!-- /.social-auth-links -->
                <div class="error_response"></div>

                <p class="mb-1">
                    <a href="<?= site_url("users/forgotPassword") ?>"><?= lang('main.forgetPassword') ?></a>
                </p>
                <p class="mb-0">
                    <a href="<?= site_url("users/subscribe") ?>" class="text-center"><?= lang('main.registerMembership') ?></a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>assets/ltr/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>assets/ltr/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>assets/ltr/dist/js/adminlte.min.js"></script>

    <script>
        $('#login_form').on('submit', function(e) {
            e.preventDefault();
            form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    $('.error_response').html(``);
                    $('.success_response').html(`
                            <div class="callout callout-success">
                                <h5><?= lang('main.success') ?></h5>
                                <p>${response.message}</p>
                            </div>
                            `);

                    var destinationUrl = '<?= site_url('base/dashboard') ?>';
                    // Replace 'delay_in_milliseconds' with the desired delay before redirection (in milliseconds)
                    var delayInMilliseconds = 3000; // 3 seconds
                    setTimeout(function() {
                        window.location.href = destinationUrl;
                    }, delayInMilliseconds);

                },
                error: function(xhr) {
                    $('.error_response').html(`
                            <div class="callout callout-danger">
                                <h5><?= lang('msg.error') ?></h5>
                                <p>${xhr.responseJSON.message}</p>
                            </div>
                            `);
                }
            });

        });
    </script>


</body>

</html>
