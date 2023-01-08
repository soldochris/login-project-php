<?php
  session_start();

  if(isset($_SESSION['userId'])){
    require('./config/db.php');
    $userId = $_SESSION['userId'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if($user->role === "admin"){
      $role = $_POST['userInfo'];

      $targetUserId = $_POST['targetUserId'];

      if(isset($_POST['superEdit'])){
        $stmt = $pdo-> prepare('UPDATE users SET role = ? WHERE id = ?');
        $stmt ->execute([$role,$targetUserId]);
        $updated = "The information was correctly updated";
      }

      //redirect and send the message to index
      header("Location: http://localhost:8888/login-project-php/index.php?updated=".$updated);
    }
  }
?>