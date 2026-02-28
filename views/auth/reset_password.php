<div class="container" style="color: white; padding: 20px; width: 400px; margin: 50px auto;">
    <h2 style="color: #4ecdc4; text-align: center; margin-bottom: 30px;">New Password</h2>
    <p style="text-align: center; color: #4ecdc4; margin-bottom: 20px;">Successfully verify, please enter your password</p>

    <?php if (!empty($message)): ?>
        <div style="background: #ff6b6b; color: #fff; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/reset_password" style="background: #1a1a1a; padding: 30px; border-radius: 10px;">
        <div style="margin-bottom: 15px;">
            <label style="color: #4ecdc4;">New password</label>
            <input type="password" name="new_password" required placeholder="Don't lose your password again !" style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div>
            <label style="color: #4ecdc4;">Enter new password</label>
            <input type="password" name="confirm_password" required placeholder="Please enter the same as above." style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px; box-sizing: border-box;">
        </div>

        <button type="submit">
            SAVE PASSWORD
        </button>
    </form>
</div>