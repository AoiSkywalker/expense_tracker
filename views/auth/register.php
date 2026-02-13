<div class="container" style="color: white; padding: 50px; text-align: center;">
    
    <?php if (isset($error)): ?>
        <p style="color: #ff6b6b; background: rgba(255,0,0,0.1); padding: 10px; border: 1px solid #ff6b6b;">
            <?= $error ?>
        </p>
    <?php endif; ?>

    <form id="register-form" method="POST" action="/register">
        <h2>Sign up</h2>
        <input type="hidden" name="action" value="register">
        <input type="text" name="username" placeholder="New username" required>
        <input type="password" name="password" placeholder="New password" required>
        <input type="password" name="confirm_password" placeholder="Re-enter password" required>
        <button type="submit">
            SIGN UP
        </button>
        <p class="link" >
            <a href="/login" style="color: #0ff; text-decoration: none">Already have an account ? Login here</a>
        </p>
    </form>
</div>