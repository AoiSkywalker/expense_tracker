<DOCTYPE html>
<html>
     <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible">
          <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
          <title>Personal Expense Tracker</title>
          <link rel="stylesheet" href="/assets/stylesheet/style.css">
     </head>
     
     <body>
          <nav class="navbar">
               <div class="nav-brand">
                    <a href="/">Expense Tracker<span class="blink">_</span></a>
               </div>

               <div class="nav-links">
                    <?php if (isset($_SESSION['user_id'])): ?>
                         <a href="/home" class="nav-item">Dashboard</a>
                         <a href="/profile" class="nav-item">Profile</a>
                         <a href="/logout" class="nav-item">Logout</a>
                    <?php else: ?>
                         <a href="/login" class="nav-item">Login</a>
                         <a href="/register" class="nav-item">Sign up</a>
                    <?php endif ?>
               </div>
          </nav>
          <?= @$content ?>
     </body>
</html>
