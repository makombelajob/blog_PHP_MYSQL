<?php
global $pdo;
require_once 'includes/dbconnect.php';

$sql = 'SELECT * FROM authors;';
$stmt = $pdo->query($sql);
$authors = $stmt->fetchAll();
$finalMsg = [];
// Delete logic code
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $delete = $_POST['delete'];
    if($delete){
        // Prepare request post
        $sqlPost = 'DELETE FROM posts WHERE posts.authors_id = :id_author;';
        $stmtPost = $pdo->prepare($sql);
        $stmtPost->bindValue(':id_author', $delete, PDO::PARAM_INT);
        $stmtPost->execute();

        // Prepare request author
        $sqlAuthor = 'DELETE FROM authors WHERE id = :id_author;';
        $stmtAuthor = $pdo->prepare($sqlAuthor);
        $stmtAuthor->bindValue(':id_author', $delete, PDO::PARAM_INT);
        $stmtAuthor->execute();

        $pdo->commit();
        $finalMsg['deleted'] = 'Author was deleted';
        header('Refresh:1; url=delete_author.php');
        exit();
    }
}
require_once 'includes/header.php';
?>

<body>
<main class="container">
    <h2 class="fs-1 text-center text-uppercase my-3">Les noms des auteurs</h2>
    <table class="row">
        <thead class="col-12">
        <tr class="bg-warning row rounded-4 my-1">
            <th class="col fs-1">ID</th>
            <th class="col fs-1 me-5">lastname</th>
            <th class="col fs-1 me-5">firstname</th>
            <th class="col-5 fs-1">Email</th>
            <th class="col fs-1">Delete</th>
        </tr>
        </thead>
        <tbody class="col-12">
        <?php foreach($authors as $author) : ;?>
            <tr class="row bg-primary rounded-3 my-1">
                <td class="col fs-1 text-white"><?= $author['id'] ;?></td>
                <td class="col fs-1 text-white"><?= $author['lastname'] ;?></td>
                <td class="col fs-1 text-white"><?= $author['firstname'] ;?></td>
                <td class="col-5 fs-1 text-white"><?= $author['email'] ;?></td>
                <td class="col-1 fs-3">
                    <form action="" method="post">
                        <button name="delete" value="<?= $author['id'] ;?>" class="btn btn-danger text-black">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="my-5 text-center bg-danger rounded-3">
        <?php if(isset($finalMsg['deleted']) ?? isset($finalMsg['delFailed']) ?? '') : ;?>
            <p class="fs-1 text-white"><?= $finalMsg['deleted'] ?? $finalMsg['delFailed'] ?? '' ?></p>
        <?php endif ;?>
    </div>
</main>
</body>
</html>