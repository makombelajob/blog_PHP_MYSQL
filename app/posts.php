<?php
require_once 'includes/dbconnect.php';
global $pdo;
$sql = 'SELECT id, title, created_at, content FROM posts;';
$stmt = $pdo->query($sql);
$posts = $stmt->fetchAll();
require_once 'includes/header.php';
?>
<body>
    <main class="container my-5">
        <h1 class="fs-1 text-center text-uppercase my-5">Affichage des posts</h1>
        <?php require_once 'includes/options_list.php';?>
        <table class="row">
            <thead class="bg-danger col-12">
                <tr class="row">
                    <th class="col fs-5">Id</th>
                    <th class="col fs-5">Title</th>
                    <th class="col fs-5">Created_at</th>
                    <th class="col-6 fs-5">Content</th>
                </tr>
            </thead>
            <tbody class="col-12">
                <?php foreach($posts as $post) : ;?>
                    <tr class="row my-1 bg-primary rounded-3 my-1">
                        <td class="col fs-2"><?= $post['id'] ;?></td>
                        <td class="col fs-2 text-white"><?= $post['title'] ;?></td>
                        <td class="col fs-2 text-white"><?= $post['created_at'] ;?></td>
                        <td class="col-6 fs-2 text-white"><?= $post['content'] ;?></td>
                    </tr>
                <?php endforeach ;?>
            </tbody>
        </table>
    </main>
</body>
</html>
