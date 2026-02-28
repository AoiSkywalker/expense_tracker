<div class="container">
     <?php if (!empty($message)): ?>
          <div class="alert <?php echo $msg_type;?>">
               <?php echo $message; ?>
          </div>
     <?php endif; ?>
     
     <?php if (isset($_SESSION['user_id'])): ?>
          <div id="dashboard">
               <h1> Hello, <?php echo htmlspecialchars($user_name);?> </h1>
               <form method="GET" action="index.php">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" style="background:#e74c3c">Log out</button>
               </form> 
          </div>
     <?php else: ?>
          <form id="login-form" method="POST" action="/login">
               <h2>Login</h2>
               <input type="hidden" name="action" value="login">
               <div style="margin-bottom: 15px;">
                    <label style="color: #0ff;">Username </label>
                    <input type="text" name="username" required autocomplete="off" placeholder="Please enter your username here !" style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px; box-sizing: border-box;">
               </div>
               
               <div style="margin-bottom: 15px;">
                    <label style="color: #0ff;">Password</label>
                    <input type="password" name="password" required placeholder="Something secret should be hidden here" style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444; border-radius: 4px; box-sizing: border-box;">
               </div>

               <div class="link">
                    <a href="/forgot_password" style="color: #0ff; text-decoration: none">Forget my password</a>
               </div>

               <button type="submit">LOGIN</button>
               <p class="link">
                    <a href="/register" style="color: #0ff; text-decoration: none">First time here ? Sign up here</a>
               </p>
          </form>
     
     <?php endif; ?>
</div>

