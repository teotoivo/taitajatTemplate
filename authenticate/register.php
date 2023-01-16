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
  print_r($_POST);
  if (!isset( $_POST['username'], $_POST['password'], $_POST['fullName'], $_POST['email'], $_POST['passwordRepeat'] )) {
    exit("please fill all fields");
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
          echo 'account created';
        } else {
          echo 'error';
        }
      }
    }
    $stm->close();
  }
?>