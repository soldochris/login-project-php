<?php 
    session_start();

    //if the user is logged in
    if(isset($_SESSION['userId'])){
        require('./config/db.php'); 

        $userId = $_SESSION['userId'];

        $stmt = $pdo -> prepare('SELECT * FROM users WHERE id = ?');
        $stmt -> execute([$userId]);
        $user = $stmt -> fetch();

        if($user -> role === "guest"){
            $message = "You are a Guest";
        }elseif($user->role == "moderator"){
            $message = "You are a moderator";
        }elseif($user->role == "admin"){
            $stmt = $pdo -> prepare('SELECT * FROM users');
            $stmt -> execute();
            $users = $stmt -> fetchAll();
        }

    }
?>

<?php require('./inc/header.html'); ?>

<div class="container">
    <div class="card bg-light mb-3">
        <div class="card-header">
            <?php if(isset($user)){ ?>
                <h5>Welcome <?php echo $user -> name ?></h5>
            <?php } else {?>
                <h5>Welcome Guest</h5>
            <?php }?>
        </div>
        <div class="card-body">
            <?php if(isset($message)){?>
                <h3><?php echo $message?></h3>
            <?php } elseif (isset($users)){ ?>
                <?php foreach($users as $loopUser){ ?>
                    <form action="adminUpdate.php" method="POST">
                        <ul class="list-group">
                            <?php if($loopUser->email != $user->email) {?>
                                <li class="list-group-item">
                                    <?php echo $loopUser->name ?>
                                    <select name="userInfo">
                                        <?php if($loopUser->role == "moderator"){?>
                                            <option selected="selected" value="moderator">Moderator</option>
                                            <option value="guest">Guest</option>
                                        <?php } elseif($loopUser->role == "guest") {?>
                                            <option value="moderator">Moderator</option>
                                            <option selected="selected" value="guest">Guest</option>
                                        <?php } ?>
                                    </select>
                                    <button class="btn btn-primary" type="submit" name="superEdit">Update</button>
                                </li>
                                <input type="hidden" name="targetUserId" value="<?php echo $loopUser->id ?>"/>
                            <?php }?>
                        </ul>
                    </form>
                <?php } ?>
                <?php if(isset($_GET['updated'])){ ?>
                    <p class="link-success"><?php echo $_GET['updated']?></p>
                <?php }?>
            <?php } ?>
            <?php if(isset($user)){ ?>
                <h5>This is a super secret content only for logged in people</h5>
            <?php } else {?>
                <h4>Please Login/Register to unlock all the content</h4>
            <?php }?>
        </div>
    </div>
</div>

<?php require('./inc/footer.html'); ?>