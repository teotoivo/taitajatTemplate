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
      <li><a href="../">Home</a></li>
      <li><a href="../phpmyadmin">php my admin</a></li>
      <li class="active"><a href="../login">login</a></li>
    </ul>
  </nav>
  <main>
    <!--register-->
    <form class="registerLogin" action="../authenticate/register.php" method="post" onsubmit="return verifyRegister()">
      <div>
        <label for="fullName">full name</label>
        <input type="text" id="fullName" name="fullName">
      </div>
      <div>
        <label for="username">username</label>
        <input type="text" id="username" name="username">
      </div>
      <div>
        <label for="email">email</label>
        <input type="text" id="email" name="email">
      </div>
      <div>
        <label for="password">password</label>
        <input type="password" id="password" name="password">
      </div>
      <div>
        <label for="passwordRepeat">repeat password</label>
        <input type="password" id="passwordRepeat" name="passwordRepeat">
      </div>
        <input type="submit" value="Register">
      <p>allready have an account? <a href="../login">login</a></p>
  </main>
  <footer></footer>
  <script src="script.js"></script>
</body>
</html>