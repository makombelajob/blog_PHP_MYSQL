<?php
require_once 'includes/dbconnect.php';
global $pdo;
if(isset($_GET['id'])){
    if(is_numeric($_GET['id'])){
        $id = $_GET['id'];
        try{
            $sql = 'SELECT posts.*, posts_categories.* FROM posts INNER JOIN posts_categories ON posts.id = posts_categories.posts_id WHERE posts.id = :id;';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $posts = $stmt->fetchAll();
            $sql = 'SELECT authors.lastname, authors.firstname FROM authors INNER JOIN posts ON authors.id = posts.authors_id WHERE posts.id = :id ;';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $authorsPost = $stmt->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}

require_once 'includes/header.php';
?>
<body>
<main class="container my-5">
    <header class="row my-3">
        <nav class="text-center my-3">
            <a class="btn btn-warning fs-2 text-secondary" href="/">Home</a>
        </nav>
        <?php include_once 'includes/options_list.php';?>
    </header>
    <div class="row">
        <h1 class="text-center text-uppercase fs-1 fw-bolder text-white bg-secondary w-25 m-auto rounded-3">Post</h1>
        <?php if(count($posts) === 0) : ?>
            <div class="bg-danger rounded-3 my-3 p-2">
                <p class="text-center fs-1 text-uppercase text-white">Nos content for this post 🤷‍♂️🤦‍♂️</p>
            </div>
        <?php else : ;?>
            <?php foreach($posts as $post) : ;?>
                <article class="card my-5 p-4 bg-info bg-gradient">
                    <span class="fs-3"><?= $post['id'];?></span>
                    <h2 class="fs-1"><?= $authorsPost['lastname'] . ' ' . $authorsPost['firstname'];?></h2>
                    <div class="card-content fs-5"><?= $post['content'];?></div>
                    <time class="fs-3 text-center text-secondary" datetime="<?= $post['created_at'];?>"><?= $post['created_at'];?></time>
                </article>
            <?php endforeach;?>
        <?php endif; ?>
    </div>
    <div class="text-center my-3">
        <a class="btn btn-primary fs-2" href="/add_comment.php/?id=<?= $post['id'];?>">Add Comment</a>
    </div>
</main>
</body>
</html>