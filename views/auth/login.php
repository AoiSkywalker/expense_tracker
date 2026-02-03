<div class="container">
     <?php if (!empty($message)): ?>
          <div class="alert <?php echo $msg_type;?>">
               <?php echo $message; ?>
          </div>
     <?php endif; ?>
     
     <?php if ($user_logged_in): ?>
          <div id="dashboard">
               <h1> Hello, <?php echo htmlspecialchars($user_name);?> </h1>
               <form method="GET" action="index.php">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" style="background:#e74c3c">Log out</button>
               </form> 
          </div>
     <?php else: ?>
          <form id="login-form" method="POST" action="index.php">
               <h2>Login</h2>
               <input type="hidden" name="action" value="login">
               <input type="text" name="username" placeholder="Please enter your username here !">
               <input type="password" name="password" plasceholder="Something secret should be hidden here">
               <button type="submit">Login</button>
               <span class="link" onclick="toggleView()">First time here ? Sign up now ! </span>
          </form>
     
          <form id="register-form" method="POST" action="index.php" class="hidden">
               <h2>Sign up</h2>
               <input type="hidden" name="action" value="register">
               <input type="text" name="username" placeholder="New username" required>
               <input type="password" name="password" placeholder="New password" required>
               <button type="submit">Sign Up</button>
               <span class="link" onclick="toggleView()">Back to login</span>
          </form>

          <script>
               function toggleView() {
                    document.getElementById('login-form').classList.toggle('hidden');
                    document.getElementById('register').classList.toggle('hidden');
               }
          </script>
     <?php endif; ?>
</div>

