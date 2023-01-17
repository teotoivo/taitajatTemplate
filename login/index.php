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
      <?php
        if(isset($_SESSION['loggedin'])): ?>
          <li><a href="/settings">settings</a></li>
        <?php
        else: ?>
          <li class="active"><a href="/login">login</a></li>
        <?php
        endif;
      ?>
    </ul>
  </nav>
  <main>
    <!--login-->
    <form class="registerLogin" action="" method="post" onsubmit="return verifyLogin()">
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
    <div>
      <?php
        
        $config = json_decode(file_get_contents('../config.json'), true);

        $DATABASE_HOST = $config['sqlInfo']['DATABASE_HOST']; 
        $DATABASE_USER = $config['sqlInfo']['DATABASE_USER'];
        $DATABASE_PASS = $config['sqlInfo']['DATABASE_PASS'];
        $DATABASE_NAME = $config['sqlInfo']['DATABASE_NAME'];

        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        if ( mysqli_connect_errno() ) {
          die('Failed to connect to MySQL: ' . mysqli_connect_error());
        }
        if (!isset($_POST['username'], $_POST['password']) ) {
          exit();
        }
        $required_fields = array('username', 'password');
        if (array_filter($required_fields, function($field) {
            return empty($_POST[$field]);
        })) {
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
            header('Location: /');
            } else {
              echo 'incorrect password and/or password!';
            }
          } else {
            echo 'incorrect password and/or password!';
          }
        
          $stm->close();
        }
      ?>
    </div>
  </main>
  <footer></footer>
  <script src="script.js"></script>
</body>
</html>