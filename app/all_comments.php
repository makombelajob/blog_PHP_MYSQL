<?php

global $pdo;
require_once 'includes/dbconnect.php';
$sql = 'SELECT * FROM comments;';
$stmt = $pdo->query($sql);
$stmt->execute();
$comments = $stmt->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <header>
        <nav>
            <?php include_once 'includes/options_list.php';?>
        </nav>
    </header>
    <main class="container">
        <div class="row">
            <div class="text-center">
                <h1 class="fs-1 text-uppercase my-3">All comments</h1>
            </div>
            <?php foreach ($comments as $comment) : ;?>
                <article class="bg-success-subtle my-1 rounded-3">
                    <div class="fs-3"><?= $comment['content'];?></div>
                    <time datetime="<?= $comment['created_at'];?>"><?= $comment['created_at'];?></time>
                </article>
            <?php endforeach;?>
        </div>
    </main>
</body>
</html>
