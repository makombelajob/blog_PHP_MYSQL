<?php
global $pdo;
require_once 'includes/dbconnect.php';
$errorsMsg = $finalMsg = [];
$sql = 'SELECT * FROM categories;';
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll();
require_once 'includes/header.php';
?>
<main class="container mt-3">
    <h1 class="text-uppercase text-center my-3">All categories</h1>
    <ul class="list-unstyled d-flex justify-content-between">
        <li><a class="fs-2 text-secondary text-decoration-none" href="index.php">home</a></li>
        <li><a class="fs-2 text-secondary text-decoration-none" href="delete_category.php">delete category</a></li>
        <li><a class="text-decoration-none fs-2 text-secondary" href="all_categories.php">All categories</a></li>
        <li><a class="text-decoration-none fs-2 text-secondary" href="delete_category.php">Delete category</a></li>
        <li><a class="text-decoration-none fs-2 text-secondary" href="delete_author.php">Delete author</a></li>
        <li><a class="text-decoration-none fs-2 text-secondary" href="posts.php">Posts</a></li>

    </ul>

    <table class="row">
        <thead class="col-12">
        <tr class="bg-warning row rounded-4 my-1">
            <th class="col fs-1">ID</th>
            <th class="col fs-1 me-5">name</th>
            <th class="col fs-1 me-5">description</th>
            <th class="col-1 fs-1 me-5">Post</th>
        </tr>
        </thead>
        <tbody class="col-12">
        <?php foreach($categories as $category) : ;?>
            <tr class="row bg-primary rounded-3 my-1">
                <td class="col fs-1 text-white"><?= $category['id'] ;?></td>
                <td class="col fs-1 text-white"><?= $category['name'] ;?></td>
                <td class="col fs-1 text-white"><?= $category['description'] ;?></td>
                <td class="col-1 fs-1 text-white"><a class="btn btn-secondary text-white fs-4" href="post_specific_category.php/?id=<?= $category['id'];?>">Plus</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php require_once 'includes/up_button.php';?>
</main>
</body>
</html>