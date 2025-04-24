<?php
global $pdo;
require_once 'includes/dbconnect.php';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $delete = $_POST['delete'];
    $sql = 'DELETE FROM posts_categories WHERE categories_id = :post_category_id;';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':post_category_id', $delete, PDO::PARAM_INT);
    $execPost = $stmt->execute();

    $sql = 'DELETE FROM categories WHERE id = :category_id;';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':category_id', $delete, PDO::PARAM_INT);
    $exeCategory = $stmt->execute();

    if(!$exeCategory || !$execPost){
        $finalMsg['failedDelete'] = 'La suppression a échouée ! 🤦‍♂️';
    }else{
        $finalMsg['successDelete'] = 'La suppression a réussit ! 👍💾🌏';
        header('Refresh:3, url=/');
    }
}
$errorsMsg = $finalMsg = [];
$sql = 'SELECT * FROM categories;';
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll();
require_once 'includes/header.php';
?>
    <main class="container mt-3">
        <div class="my-5 text-center bg-danger rounded-3">
            <?php if(isset($errorsMsg) ?? isset($finalMsg)) : ;?>
                <p class="fs-1"><?= $errorsMsg['id'] ?? $finalMsg['failedDelete'] ?? $finalMsg['successDelete'] ?? '' ;?></p>
            <?php endif ;?>
        </div>
        <h1 class="text-uppercase text-center my-3">Supprimer une catégorie</h1>
        <ul class="list-unstyled d-flex justify-content-between">
            <li><a class="text-decoration-none fs-2 text-secondary" href="all_categories.php">All categories</a></li>
            <li><a class="text-decoration-none fs-2 text-secondary" href="index.php">home</a></li>
            <li><a class="text-decoration-none fs-2 text-secondary" href="delete_author.php">Delete author</a></li>
            <li><a class="text-decoration-none fs-2 text-secondary" href="posts.php">Posts</a></li>
        </ul>
        <table class="row">
            <thead class="col-12">
            <tr class="bg-warning row rounded-4 my-1">
                <th class="col fs-1">ID</th>
                <th class="col fs-1 me-5">name</th>
                <th class="col fs-1 me-5">description</th>
                <th class="col fs-1">Delete</th>
            </tr>
            </thead>
            <tbody class="col-12">
            <?php foreach($categories as $category) : ;?>
                <tr class="row bg-primary rounded-3 my-1">
                    <td class="col fs-1 text-white"><?= $category['id'] ;?></td>
                    <td class="col fs-1 text-white"><?= $category['name'] ;?></td>
                    <td class="col fs-1 text-white"><?= $category['description'] ;?></td>
                    <td class="col-1 fs-3">
                        <form action="" method="post">
                            <button name="delete" value="<?= $category['id'] ;?>" class="btn btn-danger text-black">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php require_once 'includes/up_button.php';?>
    </main>
</body>
</html>
