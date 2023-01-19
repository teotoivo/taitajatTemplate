<?php session_start();
  //define database info
  $config = json_decode(file_get_contents('../config.json'), true);
  $DATABASE_HOST = $config['sqlInfo']['DATABASE_HOST']; 
  $DATABASE_USER = $config['sqlInfo']['DATABASE_USER'];
  $DATABASE_PASS = $config['sqlInfo']['DATABASE_PASS'];
  $DATABASE_NAME = $config['sqlInfo']['DATABASE_NAME'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="./settings.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<body>
  <nav>
    <ul>
      <li ><a href="../">Home</a></li>
      <li><a href="../phpmyadmin">php my admin</a></li>
      <?php
        if(isset($_SESSION['loggedin'])): ?>
          <li class="active"><a href="../settings">settings</a></li>
        <?php
        else: ?>
          <li><a href="../login">login</a></li>
        <?php
        endif;
      ?>
    </ul>
  </nav>
  <main>
    <?php
      if(isset($_SESSION['loggedin'])): ?>
        <p>You are logged in! <a href="../logout/index.php">log out</a></p>
		<div id="settings">
			<?php
        //get info from my sql
        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        if ( mysqli_connect_errno() ) {
          die('Failed to connect to MySQL: ' . mysqli_connect_error());
        }
      if ($stm = $con->prepare('SELECT * FROM users WHERE username = ?')) {
        $stm->bind_param('s', $_SESSION['name']);
        $stm->execute();
        $result = $stm->get_result();
        $user = $result->fetch_assoc();
        $stm->close();
        echo '<p>Username: ' . $user['username'] . '</p>';
        echo '<p>Email: ' . $user['email'] . '</p>';
        echo '<p>Full name: ' . $user['fullName'] . '</p>';
      }
      else {
        echo 'Could not prepare statement!';
      }
      ?>
		</div>
      <?php
      else: ?>
        <p>You are not logged in! <a href="../login">login</a></p>
      <?php
      endif;
    ?>
  </main>
  <footer></footer>
  <script src="script.js"></script>
</body>
</html>