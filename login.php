<?php
session_start();

//if the login button was clicked
if (isset($_POST['login'])) {
  require('./config/db.php');

  //take the data to save them
  $userEmail = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
  $userPassword = filter_var($_POST['userPassword'], FILTER_SANITIZE_STRING);

  //select rows from user with the determinated email
  $stmt = $pdo -> prepare('SELECT * FROM users WHERE email = ?');
  $stmt -> execute([$userEmail]);
  $user = $stmt -> fetch();

  if(isset($user)){
    //if the pass is correct
    if(password_verify($userPassword,$user -> password)){
      echo "The pass is correct";
      //create session form the user
      $_SESSION['userId'] = $user -> id;
      //redirect to index page
      header('Location: http://localhost:8888/login-project-php/index.php');
    }else{
      $wrongLogin = "Email or password is wrong";
    }
  }
}
?>

<?php require('./inc/header.html'); ?>

<div class="container">
  <div class="card bg-light mb-3">
    <div class="card-header">Login</div>
    <div class="card-body">
      <form action="login.php" method="POST">
        <div class="form-group">
          <label for="userEmail">User Email</label>
          <input required type="email" name="userEmail" class="form-control">
        </div>
        <div class="form-group">
          <label for="userPassword">User Password</label>
          <input required type="password" name="userPassword" class="form-control">
          <?php if(isset($wrongLogin)){ ?>
            <p class="link-danger"> <?php echo $wrongLogin ?> </p>
          <?php } ?>
        </div>
        <button name="login" type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>
</div>

<?php require('./inc/footer.html'); ?>