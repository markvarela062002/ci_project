<h2>Update User Details</h2>

<?php if ($this->session->flashdata('success')): ?>
    <p style="color: green;"><?= $this->session->flashdata('success'); ?></p>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <p style="color: red;"><?= $this->session->flashdata('error'); ?></p>
<?php endif; ?>

<?= form_open('auth/update_user'); ?>
    <label>Username:</label>
    <input type="text" name="username" value="<?= set_value('username', $this->session->userdata('username')); ?>" required>
    <?= form_error('username', '<p style="color:red;">', '</p>'); ?>

    <label>Email:</label>
    <input type="email" name="email" value="<?= set_value('email', $this->session->userdata('email')); ?>" required>
    <?= form_error('email', '<p style="color:red;">', '</p>'); ?>

    <button type="submit">Update</button>
</form>

<h2>Change Password</h2>

<form id="changePasswordForm">
    <label>Current Password:</label>
    <input type="password" id="currentPassword" name="currentPassword" required>
    
    <label>New Password:</label>
    <input type="password" id="newPassword" name="newPassword" required>
    
    <label>Confirm New Password:</label>
    <input type="password" id="confirmPassword" name="confirmPassword" required>
    
    <button type="button" id="savePassword">Change Password</button>
</form>

<script>
    $(document).ready(function() {
        $("#savePassword").click(function() {
            var currentPassword = $("#currentPassword").val().trim();
            var newPassword = $("#newPassword").val().trim();
            var confirmPassword = $("#confirmPassword").val().trim();

            if (currentPassword === "" || newPassword === "" || confirmPassword === "") {
                alert("All fields are required!");
                return;
            }

            if (newPassword !== confirmPassword) {
                alert("New passwords do not match!");
                return;
            }

            $.ajax({
                url: '<?= site_url('auth/change_password'); ?>',
                type: 'POST',
                data: {
                    current_password: currentPassword,
                    new_password: newPassword,
                    confirm_password: confirmPassword
                },
                success: function(response) {
                    alert(response.message);
                    if (response.status === "success") {
                        location.reload();
                    }
                },
                error: function() {
                    alert("An error occurred while changing the password.");
                }
            });
        });
    });
</script>
