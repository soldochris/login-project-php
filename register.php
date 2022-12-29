<?php
//if the register button was clicked
if (isset($_POST['register'])) {
  require('./config/db.php');

  //take the data to save them
  $userName = filter_var($_POST['userName'], FILTER_SANITIZE_STRING);
  $userEmail = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
  $userPassword = filter_var($_POST['userPassword'], FILTER_SANITIZE_STRING);
  //hashing the pass
  $passwordHashed = password_hash($userPassword, PASSWORD_DEFAULT);

  //if the email is well formated
  if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    //select the rows for that email
    $stmt = $pdo -> prepare('SELECT * from USERS WHERE email = ?');
    $stmt-> execute([$userEmail]);
    $totalUsers = $stmt -> rowCount();

    //if there is a row 
    if ($totalUsers > 0) {
      $emailTaken = "Email already been taken";

    //if there is no a row save the data into the database 
    } else {
      $stmt = $pdo -> prepare('INSERT into users(name, email, password) VALUES(?, ?, ?) ');
      $stmt-> execute([$userName, $userEmail, $passwordHashed]);
      header('Location: http://localhost:8888/login-project-php/index.php');
    }
  }
  
}
?>

<?php require('./inc/header.html'); ?>

<div class="container">
  <div class="card bg-light mb-3">
    <div class="card-header">Register</div>
    <div class="card-body">
      <form action="register.php" method="POST">
        <div class="form-group">
          <label for="userName">User Name</label>
          <input required type="text" name="userName" class="form-control">
        </div>
        <div class="form-group">
          <label for="userEmail">User Email</label>
          <input required type="email" name="userEmail" class="form-control">
          <?php if(isset($emailTaken)){ ?>
            <p class="link-danger"> <?php echo $emailTaken ?> </p>
          <?php } ?>
        </div>
        <div class="form-group">
          <label for="userPassword">User Password</label>
          <input required type="password" name="userPassword" class="form-control">
        </div>
        <button name="register" type="submit" class="btn btn-primary">Register</button>
      </form>
    </div>
  </div>
</div>

<?php require('./inc/footer.html'); ?>