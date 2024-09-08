<div class="row">
    <!-- left column -->
    <div class="col-12">
        <!-- form start -->
        <form id="save_form" action="<?= site_url("users/save") ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="card">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-lg-6 col-md-12">
                            <label for="first_name">First Name</label>
                            <input type="text" value="<?= $user['first_name'] ?? set_value('first_name') ?>" class="form-control form-control-sm" required id="first_name" name="first_name" placeholder="First Name">
                        </div>
                        <div class="form-group col-lg-6 col-md-12">
                            <label for="last_name">Last Name</label>
                            <input type="text" value="<?= $user['last_name'] ?? set_value('last_name') ?>" class="form-control form-control-sm" required id="last_name" name="last_name" placeholder="Last Name">
                        </div>
                        <div class="form-group col-lg-6 col-md-12">
                            <label for="email">Email address</label>
                            <input type="email" value="<?= $user['email'] ?? set_value('email') ?>" class="form-control form-control-sm" required id="email" name="email" placeholder="Email">
                        </div>
                        <div class="form-group col-lg-6 col-md-12">
                            <label for="phone">Phone</label>
                            <input type="text" value="<?= $user['phone'] ?? set_value('phone') ?>" id="phone" name="phone" class="form-control form-control-sm" required data-inputmask='"mask": "(999) 999-9999"' data-mask>
                        </div>
                        <div class="form-group col-lg-6 col-md-12">
                            <label for="password">Password</label>
                            <div class="input-group input-group-sm">
                                <input type="password" class="form-control form-control-sm" name="password" id="password" maxlength="18" minlength="8" placeholder="Add password">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i id="show_password" class="fa fa-eye-slash" aria-hidden="true" style="cursor: pointer;"></i></span>
                                </div>

                            </div>
                        </div>
                        <div class="form-group col-lg-6 col-md-12">
                            <label for="password">Confirm Password</label>
                            <div class="input-group input-group-sm">
                                <input type="password" class="form-control form-control-sm" name="confirm_password" id="confirm_password" maxlength="18" minlength="8" placeholder="Confirm password">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i id="show_password1" class="fa fa-eye-slash" aria-hidden="true" style="cursor: pointer;"></i></span>
                                </div>

                            </div>
                        </div>

                        <div class="form-group col-lg-6 col-md-12">

                            <label for="role_id">Role</label>
                            <select id="role_id" name="role_id" required class="form-control form-control-sm form-select-sm select2bs4">
                                <option value="" disabled selected><?= lang('main.selectOption') ?></option>
                                <?php
                                foreach ($roles as $role)
                                {
                                    ?>
                                    <option <?= $role['id'] == $user['role_id'] ? "selected" : "" ?> value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        


                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="form-row">
                        <div class="col-lg-6 col-md-12">
                            <a href="javascript:clearForm($('#save_form'));" class="btn btn-sm btn-secondary">Clear</a>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <button id="save_close" class="btn btn-sm btn-primary float-right">Save & Close</button>
                            <button id="save" class="btn btn-sm btn-primary float-right mx-2">Save</button>
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
    <!--/.col (left) -->

</div>
<!-- /.row -->
<script>

    $(function () {

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        $('[data-mask]').inputmask();

    });

    $("#show_password").click(function () {
        var val = $(this).val();


        var passwordField = document.getElementById('password');
        var value = passwordField.value;

        if (passwordField.type == 'password') {
            passwordField.type = 'text';
            $("#show_password").addClass('fa-eye')
            $("#show_password").removeClass('fa-eye-slash')

        } else {
            passwordField.type = 'password';

            $("#show_password").addClass('fa-eye-slash')
            $("#show_password").removeClass('fa-eye')
        }

        passwordField.value = value;


    });

    $("#show_password1").click(function () {
        var val = $(this).val();


        var passwordField = document.getElementById('confirm_password');
        var value = passwordField.value;

        if (passwordField.type == 'password') {
            passwordField.type = 'text';
            $("#show_password1").addClass('fa-eye')
            $("#show_password1").removeClass('fa-eye-slash')

        } else {
            passwordField.type = 'password';

            $("#show_password1").addClass('fa-eye-slash')
            $("#show_password1").removeClass('fa-eye')
        }

        passwordField.value = value;


    });

    $('#save').on('click', function (e) {
        e.preventDefault();
        submitForm();
    });

    $('#save_close').on('click', function (e) {
        e.preventDefault();
        submitForm();
        closeFormModal();
    });

    function submitForm() {
        var formData = new FormData($('#save_form')[0]);
        if ($('#save_form').valid()) {
            // Form is valid, proceed with form submission or other actions
            $.ajax({
                url: $('#save_form').attr("action"),
                type: $('#save_form').attr("method"),
                data: formData,
                success: function (data) {
                    $('.form_response').html(`
                            <div class="callout callout-success">
                                <h5>Success</h5>
                                <p>${data.message}</p>
                            </div>
                            `);
                    clearForm($('#save_form')[0]);
                },
                error: function (xhr) {
                    $('.form_response').html(`
                            <div class="callout callout-danger">
                                <h5>Errors</h5>
                                <p>${xhr.responseJSON.message}</p>
                            </div>
                            `);

                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

    }

    function clearForm(formSelector) {
        $(formSelector).find(':input').each(function () {
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