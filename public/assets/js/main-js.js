// AOS.init({
//     once: true,
// });

// Password Show Hide Script
$(document).ready(function () {
    $(".toggle-password").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
});

// Dashboard Active Script
jQuery(function ($) {
    var validator = $('#basic-form').validate({
        rules: {
            first: {
                required: true
            },
            second: {
                required: true
            }
        },
        messages: {

        },
        errorElement: 'div',
        errorLabelContainer: '.errorTxt'
    });
});


// Login Page Validation
$(document).ready(function () {
    $("#basic-form").validate({
        rules: {
            username: {
                email: true,
                required: true,
                minlength: 3
            },
            password: {
                required: true,
                minlength: 3
            },
            captcha_code: {
                required: true,
                minlength: 6,
                number: true,
            },
            terms: {
                required: true,
            }
        }
    });
});


$(document).ready(function () {
    $("#registerForm").validate({
        ignore:'',
        rules: {
            fullName: {
                required: true,
            },
            fatherName: {
                required: true,
            },
            country: {
                required: true,
            },
            AddressLine1: {
                required: true,
            },
            AddressLine2: {
                required: true,
            },
            area: {
                required: true,
            },
            emirates: {
                required: true,
            },
            schoolName: {
                required: true,
            },
            board: {
                required: true,
            },
            CountryCode: {
                required: true,
            },
            mobile: {
                required: true,
            },
            class: {
                required: true,
            },
            gender: {
                required: true,
            },
            course: {
                required: true,
            },
            mode: {
                required: true,
            },
            location: {
                required: true,
            },
            aboutAllen: {
                required: true,
            },
            emailAddress: {
                required: true,
            },
            password: {
                required: true,
            },
            c_password: {
                required: true,
            },
            studyAbroad: {
                required: true,
            },
            terms: {
                required: true,
            },
        },
        errorElement: 'div',
        errorLabelContainer: '.errorTxt'
    });
});
