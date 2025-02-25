<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css'); ?>">

    <!-- ✅ Include jQuery First -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    
    <!-- ✅ jQuery Validation Plugin -->
    <script src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
</head>
<body>
<div class="register-container">
    <h2>Register</h2>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="error"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <?= validation_errors('<div class="error">', '</div>'); ?>

    <!-- ✅ Added ID for validation -->
    <?= form_open('auth/register', ['id' => 'registerForm']); ?>
        <label>Username:</label>
        <input type="text" name="username" id="username" value="<?= set_value('username'); ?>" required>
        <span id="username-error"></span>

        <label>Email:</label>
        <input type="email" name="email" id="email" value="<?= set_value('email'); ?>" required>
        <span id="email-error"></span>

        <label>Password:</label>
        <input type="password" name="password" id="password" required>

        <label>Confirm Password:</label>
        <input type="password" name="password_confirm" id="password_confirm" required>

        <button type="submit" id="register-btn">Register</button>
    </form>

    <p>Already have an account? <a href="<?= site_url('auth/login'); ?>">Login here</a></p>
</div>

<script>
$(document).ready(function () {
    // ✅ Check Username Availability
    $("#username").on("blur", function () {
        var username = $.trim($(this).val()); // Trim spaces
        if (username.length >= 3) {
            $.post("<?= site_url('auth/check_username') ?>", { username: username }, function (response) {
                response = response.trim(); // Ensure it's treated as a string
                if (response === "exists") {
                    $("#username-error").text("Username already taken").css("color", "red");
                } else {
                    $("#username-error").text(""); // Clear message
                }
            });
        } else {
            $("#username-error").text("Username must be at least 3 characters").css("color", "red");
        }
    });

    // ✅ Check Email Availability
    $("#email").on("blur", function () {
        var email = $.trim($(this).val()); // Trim spaces
        if (email.length > 5 && email.includes("@")) {
            $.post("<?= site_url('auth/check_email') ?>", { email: email }, function (response) {
                response = response.trim();
                if (response === "exists") {
                    $("#email-error").text("Email already taken").css("color", "red");
                } else {
                    $("#email-error").text("");
                }
            });
        } else {
            $("#email-error").text("Enter a valid email").css("color", "red");
        }
    });

    // ✅ Remove error messages when typing
    $("#username, #email").on("input", function () {
        $(this).next("span").text("");
    });

    // ✅ jQuery Validation for Full Form
    $("#registerForm").validate({
        rules: {
            username: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            password_confirm: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            username: {
                required: "Please enter a username",
                minlength: "Username must be at least 3 characters"
            },
            email: {
                required: "Please enter your email",
                email: "Enter a valid email"
            },
            password: {
                required: "Please enter a password",
                minlength: "Password must be at least 6 characters"
            },
            password_confirm: {
                required: "Please confirm your password",
                equalTo: "Passwords do not match"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
</script>
<script>
    console.log("Checking jQuery...");
    if (typeof jQuery !== "undefined") {
        console.log("✅ jQuery is loaded:", jQuery.fn.jquery);
    } else {
        console.log("❌ jQuery is NOT loaded!");
    }
</script>

</body>
</html>
