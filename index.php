<?php session_start();
$current = "home";
?>
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
  <?php include_once("./components/header.php") ?>
  <main>
    <?php
    if (isset($_SESSION['loggedin'])): ?>
      <p>You are logged in!</p>
      <?php
    else: ?>
      <p>You are logged out!</p>
      <?php
    endif;
    ?>

  </main>

  <?php include_once("./components/footer.php") ?>
</body>


</html>