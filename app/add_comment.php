<?php
session_start();
require_once 'includes/dbconnect.php';
global $pdo;
$id = $_GET['id'];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(is_numeric($id)){
        //var_dump($category);
        $title = htmlspecialchars(trim($_POST['title']));
        $comment = htmlspecialchars($_POST['comment']);
        if(empty($comment) || strlen($comment) > 250){
            $_SESSION['msg']['fieldEmpty'] = 'You must add a comment  !';
        }else{
            session_unset();
            $sql = 'UPDATE comments SET content = :comment WHERE id = :id;';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $exec = $stmt->execute();
            if(!$exec){
                $_SESSION['msg']['failed'] = 'Add comment failed !';
                header("Refresh:1, url=/add_comment.php/?id=$id");
            }else{
                session_unset();
                header("Refresh:2, url=/post_specific_category.php/?id=$id");
            }
            exit();
        }
    }

}
$sql = 'SELECT * FROM posts WHERE id = :id;';
$stmt = $pdo->prepare($sql);
$stmt->bindValue('id', $id, PDO::PARAM_INT);
$stmt->execute();
$category = $stmt->fetch();

require_once 'includes/header.php';
?>
<body>
    <header>
        <nav>
            <?php include_once 'includes/options_list.php';?>
        </nav>
    </header>
<main class="container">
    <h1 class="fs-1 text-center text-uppercase my-3">Add Comment</h1>
    <form action="" method="post" class="w-75 m-auto">
        <div  class="fs-1">
            <label class="form-label" for="title">Title</label>
            <input class="form-control fs-3" type="text" id="title" name="title" placeholder="" value="<?= $category['title'];?>"/>

        </div>
        <div class="fs-1">
            <label for="comment" class="form-label">Comment</label>
            <textarea name="comment" id="comment" cols="30" rows="10" class="form-control fs-3" placeholder="Add your comment here" ></textarea>
            <div class="text-center bg-danger my-3 rounded-3">
                <?php if(isset($_SESSION) ?? '') : ;?>
                    <p class="text-uppercase fs-1 text-white"><?= $_SESSION['msg']['fieldEmpty'] ?? '' ;?></p>
                <?php endif;?>
            </div>
        </div>
        <div class="text-center my-3">
            <button class="btn btn-primary" type="submit">Add</button>
        </div>
    </form>
    <div class="text-center bg-warning rounded-3">

    </div>
</main>
</body>
</html>
