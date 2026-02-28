<div class="container" style="color: white; padding: 20px; width: 400px; margin: 50px auto;">
    <h2 style="color: #0ff; text-align: center; margin-bottom: 30px;">Sign Up</h2>

    <?php if (!empty($message)): ?>
        <div style="background: #ff6b6b; color: #fff; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form id="register-form" method="POST" action="/register" style="background: #1a1a1a; padding: 30px; border-radius: 10px;">
        
        <div style="margin-bottom: 15px;">
            <label style="color: #0ff;">Username </label>
            <input type="text" name="username" required autocomplete="off" placeholder="Jo_1234" style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="color: #0ff;">Real name</label>
            <input type="text" name="real_name" required autocomplete="off" placeholder="This will be used to change the password !" style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="color: #0ff;">Email</label>
            <input type="email" name="email" required autocomplete="off" placeholder="your@email.com" style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="color: #0ff;">Password</label>
            <input type="password" name="password" required placeholder="Something secret should not be uncovered." style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px; box-sizing: border-box;">
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="color: #0ff">Re-enter Password</label>
            <input type="password" name="confirm_password" placeholder="Re-enter password" required style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px; box-sizing: border-box;">
        </div>
        
        <button type="submit">
            REGISTER
        </button>

        <div class="link">
            <a href="/login" style="color: #aaa; text-decoration: none;">Already have account? Login here.</a>
        </div>
    </form>
</div>