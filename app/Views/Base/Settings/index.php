<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= lang('main.systemSettings') ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><?= lang('main.home') ?></a></li>
                        <li class="breadcrumb-item active"><?= lang('main.systemSettings') ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">
                                <i class="fas fa-sliders-h mx-2"></i><?= lang('main.systemSettings') ?>
                            </h5>
                        </div>
                        <div class="card-body">

                            <!-- form start -->
                            <form id="save_form" action="<?= site_url("{$module}/{$class}/save") ?>" method="post" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-5 col-sm-3">
                                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                                    <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true"><?= lang('main.generalSettings') ?></a>
                                                    <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false"><?= lang('main.emailSettings') ?></a>
                                                    <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages" aria-selected="false"><?= lang('main.smsSettings') ?></a>
                                                </div>
                                            </div>
                                            <div class="col-7 col-sm-9">
                                                <div class="tab-content" id="vert-tabs-tabContent">
                                                    <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6 col-md-12">
                                                                <label for="default_language"><?= lang('main.defaultLanguage') ?></label>
                                                                <select id="default_language" name="default_language" class="select2bs4 form-control form-control-sm">
                                                                    <option <?= $settings['general_settings']['default_language'] == 'en' ? "selected" : "" ?> value="en"><?= lang('main.en') ?></option>
                                                                    <option <?= $settings['general_settings']['default_language'] == 'ar' ? "selected" : "" ?> value="ar"><?= lang('main.ar') ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6 col-md-12">
                                                                <label for="email_notifications"><?= lang('main.emailNotification') ?></label>
                                                                <p>
                                                                    <input <?= $settings['general_settings']['email_notifications'] == 'on' ? "checked" : "" ?> type="checkbox" id="email_notifications" name="email_notifications" data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6 col-md-12">
                                                                <label for="dark_mode"><?= lang('main.darkMode') ?></label>
                                                                <p>
                                                                    <input <?= $settings['general_settings']['dark_mode'] == 'on' ? "checked" : "" ?> type="checkbox" id="dark_mode" name="dark_mode" data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6 col-md-12">
                                                                <label for="clear_log_every"><?= lang('main.clearLogEvery') ?></label>
                                                                <select name="clear_log_every" id="clear_log_every" class="select2bs4 form-control form-control-sm">
                                                                    <option <?= isset($settings['general_settings']['clear_log_every']) && $settings['general_settings']['clear_log_every'] == 1 ? "selected" : "" ?> value="1"><?= lang('main.everyMonth') ?></option>
                                                                    <option <?= isset($settings['general_settings']['clear_log_every']) &&  $settings['general_settings']['clear_log_every'] == 3 ? "selected" : "" ?> value="3"><?= lang('main.every3Months') ?></option>
                                                                    <option <?= isset($settings['general_settings']['clear_log_every']) &&  $settings['general_settings']['clear_log_every'] == 6 ? "selected" : "" ?> value="6"><?= lang('main.every6Months') ?></option>
                                                                    <option <?= isset($settings['general_settings']['clear_log_every']) &&  $settings['general_settings']['clear_log_every'] == 100 ? "selected" : "" ?> value="100"><?= lang('main.never') ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6 col-md-12">
                                                                <label for="mail_server"><?= lang('main.mailServer') ?></label>
                                                                <input type="text" name="mail_server" id="mail_server" value="<?= $settings['email_settings']['mail_server'] ?? "" ?>" class="form-control form-control-sm">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6 col-md-12">
                                                                <label for="port_number"><?= lang('main.portNumber') ?></label>
                                                                <input type="text" name="port_number" id="port_number" value="<?= $settings['email_settings']['port_number'] ?? "" ?>" class="form-control form-control-sm">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6 col-md-12">
                                                                <label for="encryption"><?= lang('main.encryption') ?></label>
                                                                <select id="encryption" name="encryption" class="select2bs4 form-control form-control-sm">
                                                                    <option <?= $settings['email_settings']['encryption'] || $settings['email_settings']['encryption'] == 'ssl' ? "selected" : "" ?> value="ssl"><?= lang('main.ssl') ?></option>
                                                                    <option <?= $settings['email_settings']['encryption'] || $settings['email_settings']['encryption'] == 'tls' ? "selected" : "" ?> value="tls"><?= lang('main.tls') ?></option>
                                                                    <option <?= $settings['email_settings']['encryption'] || $settings['email_settings']['encryption'] == 'none' ? "selected" : "" ?> value="none"><?= lang('main.none') ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6 col-md-12">
                                                                <label for="email"><?= lang('main.email') ?></label>
                                                                <input type="text" name="email" id="email" value="<?= $settings['email_settings']['port_number'] ?? "" ?>" class="form-control form-control-sm">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6 col-md-12">
                                                                <label for="password"><?= lang('main.password') ?></label>
                                                                <input type="password" name="password" id="password" value="<?= $settings['email_settings']['password'] ?? "" ?>" class="form-control form-control-sm">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6 col-md-12">
                                                                <label for="api_url"><?= lang('main.apiUrl') ?></label>
                                                                <input type="text" name="api_url" id="api_url" value="<?= $settings['sms_settings']['api_url'] ?? "" ?>" class="form-control form-control-sm">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-lg-6 col-md-12">
                                                                <label for="api_key"><?= lang('main.apiKey') ?></label>
                                                                <input type="text" name="api_key" id="api_key" value="<?= $settings['sms_settings']['api_key'] ?? "" ?>" class="form-control form-control-sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <div class="form-row">
                                            <div class="col-lg-6 col-md-12">

                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <button id="save" class="btn btn-sm btn-primary float-right mx-2"><?= lang('main.btnSave') ?></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="form-row">
                                            <div class="form_response col-12">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(function() {
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })
    });

    $('#save').on('click', function(e) {
        e.preventDefault();
        submitForm();
    });

    function submitForm() {
        var formData = new FormData($('#save_form')[0]);
        if ($('#save_form').valid()) {
            // Form is valid, proceed with form submission or other actions
            $.ajax({
                url: $('#save_form').attr("action"),
                type: $('#save_form').attr("method"),
                data: formData,
                success: function(data) {
                    toastr.success(data.message)
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message)
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

    }

    function clearForm(formSelector) {
        $(formSelector).find(':input').each(function() {
            switch (this.type) {
                case 'text':
                case 'password':
                case 'textarea':
                case 'email':
                case 'number':
                    $(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
                    break;
                case 'select-one':
                case 'select-multiple':
                    $(this).prop('selectedIndex', 0);
                    break;
                default:
                    break;
            }
        });
        $('.select2bs4').val('').trigger('change');

    }

    function closeFormModal() {
        $('#form_modal').modal('hide');
        $('#form_fields').html('');
        $('#table').bootstrapTable('refresh');

    }
</script>