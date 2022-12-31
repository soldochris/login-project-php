<?php
session_start();

if(isset($_SESSION['userId'])){
  require('./config/db.php');
  $userId = $_SESSION['userId'];

  $stmt = $pdo -> prepare('SELECT * from users WHERE id = ?');
  $stmt -> execute([$userId]);
  $user = $stmt -> fetch();

  $stmt = $pdo -> prepare('SELECT * from blog');
  $stmt -> execute();
  $posts = $stmt -> fetchAll();

}
?>

<?php require('./inc/header.html')?>
<div class="container">
  <?php foreach($posts as $post){ ?>
  <div class="card">
    <div class="card-header bg-ligh mb-3"><?php echo $post -> title ?></div>
    <div class="card-body">
      <p><?php echo $post -> body ?></p>
    </div>
  </div>
  <?php } ?>
</div>
<?php require('./inc/footer.html')?>