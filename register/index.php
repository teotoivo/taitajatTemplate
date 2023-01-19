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
    <!--register-->
    <form class="registerLogin" action="" method="post" onsubmit="return verifyRegister()">
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
          if (!isset( $_POST['username'], $_POST['password'], $_POST['fullName'], $_POST['email'], $_POST['passwordRepeat'] )) {
            exit();
          }
          $required_fields = array('username', 'password', 'fullName', 'email', 'passwordRepeat');
          if (array_filter($required_fields, function($field) {
              return empty($_POST[$field]);
          })) {
              exit("please fill all fields");
          }
        
          if ($stm = $con->prepare('SELECT username FROM users WHERE username = ?')) {
            $stm->bind_param('s', $_POST['username']);
            $stm->execute();
            $stm->store_result();
          
            //check if exists
            if ($stm->num_rows > 0) {
              echo 'username already exists';
            } else {
              if ($_POST['password'] !== $_POST['passwordRepeat']) {
              echo 'passwords do not match';
              } else {
                if ($stm = $con->prepare('INSERT INTO users (username, password, fullName, email) VALUES (?, ?, ?, ?)')) {
                  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                  $stm->bind_param('ssss', $_POST['username'], $password, $_POST['fullName'], $_POST['email']);
                  $stm->execute();

                  session_regenerate_id();
                  $_SESSION['loggedin'] = TRUE;
                  $_SESSION['name'] = $_POST['username'];
                  $_SESSION['id'] = $id;
                  //redirect to main page
                  header('Location: ../');
                } else {
                  echo 'error';
                }
              }
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