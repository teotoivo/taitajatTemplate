<?php
  session_start();

  $DATABASE_HOST = 'localhost';
  $DATABASE_USER = 'root';
  $DATABASE_PASS = '';
  $DATABASE_NAME = 'taitajat';

  $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
  if ( mysqli_connect_errno() ) {
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
  }
  if (!isset($_POST['username'], $_POST['password']) ) {
    exit("please fill both fields");
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