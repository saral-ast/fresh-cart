$(document).ready(function() {
    $('#register-form').validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
            },
            email: {
                required: true,
                email: true,
            },
            phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 15
            },
            password: {
                required: true,
                minlength: 6,
            },
            password_confirmation: { // Fixed name
                required: true,
                equalTo: "#password", // Ensures passwords match
            }
        },
        messages: {
            name: {
                required: 'Please enter your name',
                minlength: 'Name must be at least 2 characters',
            },
            email: {
                required: 'Please enter your email',
                email: 'Please enter a valid email',
            },
            phone: {
                required: 'Please enter your phone number',
                digits: 'Please enter a valid phone number',
                minlength: 'Phone number must be at least 10 digits',
                maxlength: 'Phone number cannot exceed 15 digits'
            },
            password: {
                required: 'Please enter your password',
                minlength: 'Password must be at least 6 characters',
            },
            password_confirmation: { // Fixed name
                required: 'Please confirm your password',
                equalTo: 'Passwords do not match',
            }
        },
        errorPlacement: function(error, element) { // Fixed function usage
            error.addClass('text-red-500');
            error.insertAfter(element);
        },
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    $('#login-form').validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 6,
            }
        },
        messages: {
            email: {
                required: 'Please enter your email',
                email: 'Please enter a valid email',
            },
            password: {
                required: 'Please enter your password',
                minlength: 'Password must be at least 6 characters',
            }
        },
        errorPlacement: function(error, element) { // Fixed function usage
            error.addClass('text-red-500');
            error.insertAfter(element);
        },
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $('#admin-login-form').validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 6,
            }
        },
        messages: {
            email: {
                required: 'Please enter your email',
                email: 'Please enter a valid email',
            },
            password: {
                required: 'Please enter your password',
                minlength: 'Password must be at least 6 characters',
            }
        },
        errorPlacement: function(error, element) { // Fixed function usage
            error.addClass('text-red-500');
            error.insertAfter(element);
        },
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
