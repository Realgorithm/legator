<div class="container">
    <div class="row">
        <h2>Reset Password</h2>
    </div>
    <div class="row">
        <form action="auth/reset_password_action.php" method="post">
            <input type="hidden" name="token" value='<?php echo $_GET["token"]; ?>'>
            <label for="password">Enter your new password:</label><br>
            <input type="password" id="password" name="password" class="form-control"><br>
            <label for="confirm_password">Confirm new password:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required><br>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</div>