<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<body>
  <nav>
    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="/phpmyadmin">php my admin</a></li>
      <li><a href="/login">login</a></li>
    </ul>
  </nav>
  <main>
    <!--login-->
    <form class="registerLogin" action="../authenticate/index.php" method="post" onsubmit="return verifyLogin()">
      <div>  
        <label for="username">username</label>
        <input type="text" name="username" id="username">
      </div>
      <div>
        <label for="password">password</label>
        <input type="password" id="password" name="password">
      </div>
        <input type="submit" value="Login">
      <p>Don't have an account? <a href="../register">register</a></p>
    </form>
  </main>
  <footer></footer>
  <script src="script.js"></script>
</body>
</html>