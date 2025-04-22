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
    <h1 class="text-uppercase text-center my-3">Supprimer une catégorie</h1>
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
        </tr>
        </thead>
        <tbody class="col-12">
        <?php foreach($categories as $category) : ;?>
            <tr class="row bg-primary rounded-3 my-1">
                <td class="col fs-1 text-white"><?= $category['id'] ;?></td>
                <td class="col fs-1 text-white"><?= $category['name'] ;?></td>
                <td class="col fs-1 text-white"><?= $category['description'] ;?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</main>
</body>
</html>