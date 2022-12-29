<?php
session_start();

//if the user is already logged
if(isset($_SESSION['userId'])){
  require('./config/db.php');

  $userId = $_SESSION['userId'];

  //if the user clicked update
  if(isset($_POST['edit'])){
    $userName = filter_var($_POST['userName'], FILTER_SANITIZE_STRING);
    $userEmail = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
    $stmt = $pdo -> prepare('UPDATE users SET name=?, email=? WHERE id = ?');
    $stmt -> execute([$userName, $userEmail, $userId]);
    $message = "Your information was updated";
  }

  //get his data
  $stmt = $pdo -> prepare('SELECT * from users WHERE id = ?');
  $stmt -> execute([$userId]);

  $user = $stmt -> fetch();
}



?>

<?php require('./inc/header.html'); ?>

<div class="container">
  <div class="card bg-light mb-3">
    <div class="card-header">Profile</div>
    <div class="card-body">
      <form action="profile.php" method="POST">
        <div class="form-group">
          <label for="userName">User Name</label>
          <input required type="text" name="userName" class="form-control" value="<?php echo $user->name ?>">
        </div>
        <div class="form-group">
          <label for="userEmail">User Email</label>
          <input required type="email" name="userEmail" class="form-control" value="<?php echo $user->email ?>">
        </div>
        <?php  if(isset($message)){ ?>
          <p class="link-success"><?php echo $message?></p>
        <?php }?>
        <button name="edit" type="submit" class="btn btn-primary">Update details</button>
      </form>
    </div>
  </div>
</div>

<?php require('./inc/footer.html'); ?>