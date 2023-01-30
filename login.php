<?php session_start();
$current = "login"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./style.css">
  <script src="./jquery.js"></script>
  <script src="./main.js"></script>
  <link rel="stylesheet" href="./login.css">
</head>

<body>
  <?php include_once("./components/header.php") ?>
  <main>
    <!--check if logged in-->
    <?php
    if (isset($_SESSION['loggedin'])): ?>
      <p>you are logged in</p>
      <?php
    else: ?>
      <!--login-->
      <form class="registerLogin" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"
        onsubmit="return verifyLogin()">
        <div>
          <label for="username">username</label>
          <input required type="text" name="username" id="username">
        </div>
        <div>
          <label for="password">password</label>
          <input required type="password" id="password" name="password">
        </div>
        <input type="submit" value="Login">
        <p>Don't have an account? <a href="./register.php">register</a></p>
      </form>
      <?php
    endif;
    ?>
    <div>
      <?php

      $config = json_decode(file_get_contents('./config.json'), true);

      $DATABASE_HOST = $config['sqlInfo']['DATABASE_HOST'];
      $DATABASE_USER = $config['sqlInfo']['DATABASE_USER'];
      $DATABASE_PASS = $config['sqlInfo']['DATABASE_PASS'];
      $DATABASE_NAME = $config['sqlInfo']['DATABASE_NAME'];

      $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
      if (mysqli_connect_errno()) {
        die('Failed to connect to MySQL: ' . mysqli_connect_error());
      }
      if (isset($_POST['username'], $_POST['password'])) {

        $required_fields = array('username', 'password');
        if (
          array_filter($required_fields, function ($field) {
            return empty($_POST[$field]);
          })
        ) {
          exit("please fill all fields");
        }

        if ($stm = $con->prepare('SELECT id, password FROM users WHERE username = ?')) {
          $stm->bind_param('s', $_POST['username']);
          $stm->execute();
          $stm->store_result();

          if ($stm->num_rows > 0) {
            $stm->bind_result($id, $password);
            $stm->fetch();
            if (password_verify($_POST['password'], $password)) {
              session_regenerate_id();
              $_SESSION['loggedin'] = TRUE;
              $_SESSION['name'] = $_POST['username'];
              $_SESSION['id'] = $id;
              header('Location: ./');
            } else {
              echo 'incorrect password and/or password!';
            }
          } else {
            echo 'incorrect password and/or password!';
          }

          $stm->close();
        }
      }
      ?>
    </div>
  </main>
  <?php include_once("./components/footer.php") ?>
</body>

</html>