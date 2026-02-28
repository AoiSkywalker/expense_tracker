<div class="container" style="color: white; padding: 20px; width: 80vw; margin: auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="color: #0ff;">Personal profile</h2>
        <div class="link">
            <a href="/dashboard" style="color: #0ff; text-decoration: none">Back to Dashboard</a>
        </div>
    </div>

    <?php if (!empty($message)): ?>
        <div style="background: #4ecdc4; color: #000; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; text-align: center;">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form action="/profile" method="POST" enctype="multipart/form-data" style="display: flex; gap: 30px; background: #1a1a1a; padding: 30px; border-radius: 10px;">
        
        <div style="width: 30%; text-align: center; border-right: 1px solid #333; padding-right: 30px;">
            <div style="width: 150px; height: 150px; margin: 0 auto 15px auto; border-radius: 50%; overflow: hidden; border: 3px solid #0ff;">
                <?php if (!empty($user->avatar)): ?>
                    <img src="<?= $user->avatar ?>" style="width: 100%; height: 100%; object-fit: cover;">
                <?php else: ?>
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user -> get_name()) ?>&background=random" style="width: 100%; height: 100%; object-fit: cover;">
                <?php endif; ?>
            </div>
            <label style="color: #off; font-size: 14px;">Avatar change</label>
            <input type="file" name="avatar" accept="image/*" style="width: 100%; margin-top: 10px; color: #fff; font-size: 12px;">
        </div>

        <div style="width: 70%;">
            <div style="margin-bottom: 15px;">
                <label style="color: #0ff;">Username</label>
                <input type="text" value="<?= $user -> get_name() ?>" disabled style="width: 100%; padding: 10px; margin-top: 5px; background: #333; color: #888; border: 1px solid #444; border-radius: 4px; cursor: not-allowed;">
            </div>

            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <label style="color: #0ff;">Real name</label>
                    <input type="text" name="real_name"  value="<?= $user -> get_real_name() ?>" disabled style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px;">
                </div>
                <div style="flex: 1;">
                    <label style="color: #0ff;">Date of birth</label>
                    <input type="date" name="dob" value="<?= $user -> get_dob() ?>" style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px;">
                </div>
            </div>

            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <label style="color: #0ff;">Email</label>
                    <input type="email" name="email" value="<?= $user -> get_email() ?>" style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px;">
                </div>
                <div style="flex: 1;">
                    <label style="color: #0ff;">Telephone number</label>
                    <input type="text" name="phone" value="<?= $user -> get_phone() ?>" style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px;">
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="color: #0ff;">Address</label>
                <input type="text" name="address" value="<?= $user -> get_address() ?>" style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px;">
            </div>

            <hr style="border-color: #333; margin: 25px 0;">

            <div style="margin-bottom: 20px;">
                <label style="color: #ff6b6b; font-weight: bold;">Change the password</label>
                <input type="password" name="new_password" placeholder="Enter new password..." style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px;">
            </div>

            <button type="submit" style="background: #0ff; color: #000; font-weight: bold; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; float: right;">SAVE THE CHANGES</button>
        </div>
    </form>

    <div style="margin-top: 30px; padding: 20px; background: #2a0000; border: 1px solid #ff4444; border-radius: 10px;">
        <h3 style="color: #ff4444; margin-top: 0;">Danger Zone</h3>
        <div style="color: #aaa; font-size: 14px;">
            This action will delete permanently <strong>ALL</strong> your history and cannot be undone.
        </div>
        
        <form action="/auth/delete_account" method="POST" onsubmit="return confirm('⚠️ FINAL ALERT\n\nAre you sure to DELETE your identity ? We don\'t want to lose you !');">
            <button type="submit" style="background: transparent; color: #ff4444; font-weight: bold; border: 2px solid #ff4444; border-radius: 5px; cursor: pointer; transition: 0.3s; margin:1em 0 0 0;" onmouseover="this.style.background='#ff4444'; this.style.color='white'" onmouseout="this.style.background='transparent'; this.style.color='#ff4444'">
                ☠️ PERMANENTLY DELETE ACCOUNT
            </button>
        </form>
    </div>
</div>