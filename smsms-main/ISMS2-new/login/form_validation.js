$(document).ready(function(){
    // Form validation setup
    $('#login_form').validate({
        rules:{
            email:{
                required: true,
                email: true
            },
            password:{
                required: true,
                minlength: 6
            }
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please enter your password",
                minlength: "Password must be at least 6 characters"
            }
        },
        highlight: function(element) {  
            $(element)
                .addClass('is-invalid')
                .closest('.form-floating')
                .addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element)
                .removeClass('is-invalid')
                .closest('.form-floating')
                .removeClass('is-invalid');
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element.closest('.form-floating'));
        },

        submitHandler: function(form) {
            var recaptchaResponse = grecaptcha.getResponse();
            
            if (recaptchaResponse.length === 0) {
                $('#recaptchaModal').modal('show');
                return false;
            } else {
                form.submit();
            }
        }
    });

    // Modal handling
    $('#recaptchaModal').on('shown.bs.modal', function () {
        $(this).find('button').focus();
    });

    $("#recaptchaModal button").click(function () {
        $("#recaptchaModal").modal('hide');
    });
});


$('#otpForm').validate({
    rules: {
        email: {
            required: true,
            email: true
        }
    },
    messages: {
        email: {
            required: "Please enter your email address",
            email: "Please enter a valid email address"
        }
    },
    highlight: function(element) {  
        $(element)
            .addClass('is-invalid')
            .closest('.form-floating')
            .addClass('is-invalid');
    },
    unhighlight: function(element) {
        $(element)
            .removeClass('is-invalid')
            .closest('.form-floating')
            .removeClass('is-invalid');
    },
    errorPlacement: function(error, element) {
        error.insertAfter(element.closest('.form-floating'));
    }
});

$(document).ready(function(){
    $('#new_password_form').validate({

        rules:{
            
            email:{
                required: true,
                email: true
            },

            password:{
                required: true,
                minlength: 6
            }

        },

        highlight: function(element) {  
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        }

    })
});


