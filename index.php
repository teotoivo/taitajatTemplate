<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
  <script src="./jquery.js"></script>
  <script src="./main.js"></script>
</head>
<body>
  <header>
    <nav>
      <ul class="menu">
        <li class="menuBurger"><button><img src="./assets/menu.svg" alt="menu" width="50px" height="50px"></button></li>
        <li class="active"><a href="./">Home</a></li>
        <li><a href="../phpmyadmin">php my admin</a></li>
        <?php
          if(isset($_SESSION['loggedin'])): ?>
            <li><a href="./settings">settings</a></li>
          <?php
          else: ?>
            <li><a href="./login">login</a></li>
          <?php
          endif;
        ?>
      </ul>
    </nav>
  </header>
  <main>
    <?php
      if(isset($_SESSION['loggedin'])): ?>
        <p>You are logged in!</p>
      <?php
      else: ?>
        <p>You are logged out!</p>
      <?php
      endif;
    ?>
  </main>
  <footer>
    
  </footer>
  <script src="script.js"></script>
</body>
</html>