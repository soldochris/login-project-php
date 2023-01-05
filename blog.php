<?php
session_start();

//check if user is logged
if(isset($_SESSION['userId'])){
  require('./config/db.php');
  $userId = $_SESSION['userId'];

  //get user id
  $stmt = $pdo -> prepare('SELECT * from users WHERE id = ?');
  $stmt -> execute([$userId]);
  $user = $stmt -> fetch();

  //get posts
  $stmt = $pdo -> prepare('SELECT * from blog');
  $stmt -> execute();
  $posts = $stmt -> fetchAll();

  if(isset($_POST['createPost'])){
    $title = filter_var($_POST['postTitle'], FILTER_SANITIZE_STRING);
    $body = filter_var($_POST['postBody'], FILTER_SANITIZE_STRING);

    $stmt = $pdo -> prepare('INSERT INTO blog(title, body) VALUES(?, ?)');
    $stmt -> execute([$title, $body]);
    header('Location: http://localhost:8888/login-project-php/blog.php');
  }


}
?>

<?php require('./inc/header.html')?>
<?php if($user -> role == "moderator" || $user -> role =="admin"){
  require('./inc/newPost.html');
}?>

<div class="container">
  <?php if($user -> role == "moderator" || $user -> role =="admin"){?>
  <div class="row">
    <div class="col-sm-12">
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Create New Post</button>
    </div>
  </div>
  <?php }?>
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