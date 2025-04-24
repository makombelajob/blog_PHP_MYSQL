<?php
global $pdo;
$id = $_GET['id'];
if(is_numeric($id)){
    require_once 'includes/dbconnect.php';
    $sql = 'SELECT authors.*, posts.* FROM authors INNER JOIN posts ON authors.id = posts.authors_id WHERE authors.id = :id;';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll();
}
require_once 'includes/header.php';
?>
<body>
<main class="container my-5">
    <h1 class="fs-1 text-center text-uppercase my-5">Affichage des posts</h1>
    <h2 class="fs-1 text-center text-uppercase text-white bg-secondary rounded-3 w-50 m-auto my-3 py-2">🤷‍♂️🤷‍♂️<?= $posts[0]['lastname'];?> <?= $posts[0]['firstname'];?>🤷‍♂️🤷‍♂️</h2>
    <div class="">
        <?php require_once 'includes/options_list.php';?>
    </div>
    <?php foreach ($posts as $post) : ;?>
    <article class="row bg-warning p-1 my-2 rounded-3 text-center">
        <h2 class="col-12 fs-2"><?= $post['title'];?></h2>
        <time class="col-12 fs-4 text-secondary" datetime="<?= $post['created_at'];?>"><?= $post['created_at'];?></time>
        <h3 class="col fs-3 fw-bolder"></h3>
        <h4 class="col fs-3 fw-bolder"></h4>
    </article>
    <?php endforeach;?>
</main>
</body>
</html>
