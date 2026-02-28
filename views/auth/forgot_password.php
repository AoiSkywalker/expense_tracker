<div class="container" style="color: white; padding: 20px; width: 400px; margin: 50px auto;">
    <h2 style="color: #ff9f1c; text-align: center; margin-bottom: 30px;">Forgot password ?</h2>
    
    <p style="text-align: center; color: #aaa; margin-bottom: 20px;">Please enter your registed username and email</p>

    <?php if (!empty($message)): ?>
        <div style="background: #ff6b6b; color: #fff; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/forgot_password" style="background: #1a1a1a; padding: 30px; border-radius: 10px;">
        <div style="margin-bottom: 15px;">
            <label style="color: #ff9f1c;">Username</label>
            <input type="text" name="username" required autocomplete="off" style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 25px;">
            <label style="color: #ff9f1c;">Email</label>
            <input type="email" name="email" required autocomplete="off" style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px; box-sizing: border-box;">
        </div>

        <button type="submit" style="background: transparent; color: #ff9f1c; border: 2px solid #ff9f1c; font-weight: bold; border-radius: 5px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#ff9f1c'; this.style.color='#000'" onmouseout="this.style.background='transparent'; this.style.color='#ff9f1c'">
            VERIFY ACCOUNT
        </button>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="/login" style="color: #888; text-decoration: none;">Back to Login</a>
        </div>
    </form>
</div>