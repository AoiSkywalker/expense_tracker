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
               <input type="text" name="username" placeholder="Please enter your username here !">
               <input type="password" name="password" placeholder="Something secret should be hidden here">
               <button type="submit">Login</button>
               <p class="link">
                    <a href="/register" style="color: #0ff; text-decoration: none">First time here ? Sign up here</a>
               </p>
          </form>
     
     <?php endif; ?>
</div>

