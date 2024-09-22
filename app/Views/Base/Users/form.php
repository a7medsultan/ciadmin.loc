<div class="row">
    <!-- left column -->
    <div class="col-12">
        <!-- form start -->
        <form id="save_form" action="<?= site_url("{$module}/{$class}/save") ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $user['id'] ?>" />
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
                            <label for="password">Password <span id="passwordFeedback" class="px-2 small"></span></label>
                            <div class="input-group input-group-sm">

                                <input type="password" class="form-control form-control-sm" name="password" id="password" placeholder="Add password">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i id="show_password" class="fa fa-eye-slash" aria-hidden="true" style="cursor: pointer;"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-6 col-md-12">
                            <label for="password">Confirm Password</label>
                            <div class="input-group input-group-sm">

                                <input type="password" class="form-control form-control-sm" name="password_confirmation" id="password_confirmation" placeholder="Confirm password">
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
                                foreach ($roles as $role) {
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
    $(function() {

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        $('[data-mask]').inputmask();

    });

    $("#show_password").click(function() {
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

    $("#show_password1").click(function() {
        var val = $(this).val();


        var passwordField = document.getElementById('password_confirmation');
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

    $('#save').on('click', function(e) {
        e.preventDefault();
        submitForm();
    });

    $('#save_close').on('click', function(e) {
        e.preventDefault();
        if (submitForm()) {
            closeFormModal();
        }

    });

    function submitForm() {
        var formData = new FormData($('#save_form')[0]);
        let password = $('#password').val();
        if ($('#save_form').valid() && validatePassword(password)) {
            // Form is valid, proceed with form submission or other actions
            $.ajax({
                url: $('#save_form').attr("action"),
                type: $('#save_form').attr("method"),
                data: formData,
                success: function(data) {

                    $('.form_response').html(`
                            <div class="callout callout-success">
                                <h5>Success</h5>
                                <p>${data.message}</p>
                            </div>
                            `);

                    toastr.success(data.message)


                    setTimeout(function() {
                        $('.form_response').fadeOut();
                    }, 4000);


                    if ($('#id').val() == '') {
                        clearForm($('#save_form')[0]);
                    }

                    return true;

                },
                error: function(xhr) {
                    if (xhr.responseJSON.message) {
                        handleErrors(xhr.responseJSON.message);
                    }

                    // General form response for errors
                    $('.form_response').html(`
                                                <div class="callout callout-danger">
                                                    <h5><?= lang('msg.error') ?></h5>
                                                    <p><?= lang('msg.invalidData') ?></p>
                                                </div>
                                            `);
                    toastr.error('<?= lang('msg.invalidData') ?>')

                    // Hide the message after 4 seconds
                    setTimeout(function() {
                        $('.form_response').fadeOut();
                    }, 4000);

                    return false;
                },

                cache: false,
                contentType: false,
                processData: false
            });
        } else {

            if (!validatePassword(password)) {
                event.preventDefault(); // Prevent form submission if password is not strong
                $('#passwordFeedback').html('<?= lang('msg.weekPassword') ?>').removeClass('text-success').addClass('text-warning');
            }

            return false;
        }



    }

    function handleErrors(errors) {
        Object.keys(errors).forEach(function(field) {
            let errorMessage = errors[field];
            let fieldElement = $('#' + field);
            console.log(field);
            // Special case for password and password confirmation (they have deeper nesting)
            if (field === 'password' || field === 'password_confirmation') {

                fieldElement.addClass('error');
                fieldElement.parent().parent().find('label.error').remove();
                fieldElement.parent().parent().append(`<label id="${field}-error" class="error" for="${field}">${errorMessage}.</label>`);
            } else {
                fieldElement.addClass('error');
                fieldElement.parent().find('label.error').remove();
                fieldElement.parent().append(`<label id="${field}-error" class="error" for="${field}">${errorMessage}.</label>`);
            }
        });
    }

    function clearForm(formSelector) {
        $(formSelector).find(':input').each(function() {
            switch (this.type) {
                case 'text':
                case 'password':
                case 'textarea':
                case 'email':
                case 'number':
                case 'hidden':
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

    function validatePassword(password) {
        let feedback = '';
        // Regex for at least one uppercase letter, one lowercase letter, one number, and one special character
        let regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        if (!regex.test(password)) {
            feedback = '<?= lang('msg.PasswordRules') ?>';
            return false;
        }

        feedback = '<?= lang('msg.strongPassword') ?>';
        return true;
    }

    $(document).on('keyup', '#password', function() {
        let password = $(this).val();
        if (validatePassword(password)) {
            $('#passwordFeedback').text('<?= lang('msg.strongPassword') ?>').removeClass('text-warning').addClass('text-success');
        } else {
            $('#passwordFeedback').text('<?= lang('msg.weekPassword') ?>').removeClass('text-success').addClass('text-warning');
        }
    });
</script>