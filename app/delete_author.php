<?php
global $pdo;
require_once 'includes/dbconnect.php';

$sql = 'SELECT * FROM authors;';
$stmt = $pdo->query($sql);
$authors = $stmt->fetchAll();
$errorsMsg = $finalMsg = [];
// Delete logic code
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $btnDelete = trim($_POST['delete']);
    // Commande sql with try and catch
    try{
        $sql = 'DELETE FROM comments WHERE posts_id IN (SELECT id FROM posts WHERE authors_id = :author_id);';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':author_id', $btnDelete, PDO::PARAM_INT);
        $exec1 = $stmt->execute();

        $sql = 'DELETE FROM posts_categories WHERE posts_id IN (SELECT id FROM posts WHERE authors_id = :author_id);';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':author_id', $btnDelete, PDO::PARAM_INT);
        $exec2 = $stmt->execute();

        $sql = 'DELETE FROM posts WHERE authors_id = :author_id;';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':author_id', $btnDelete, PDO::PARAM_INT);
        $exec3 = $stmt->execute();

        $sql = 'DELETE FROM authors WHERE id = :author_id;';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':author_id', $btnDelete, PDO::PARAM_INT);
        $exec4 = $stmt->execute();

        if(!$exec1 || !$exec2 || !$exec3){
            $finalMsg['failed'] = 'Deleting failed !';
        }else{
            $finalMsg['success'] = 'Delete Done 💾👍 !!';
        }
    }catch(PDOException $e){
        $finalMsg['failed'] = $e->getMessage();
    }
}
require_once 'includes/header.php';
?>

<body>
<main class="container">
    <h2 class="fs-1 text-center text-uppercase my-3">Suppression des auteurs</h2>
    <?php require_once 'includes/options_list.php';?>
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
        <?php if(isset($errorsMsg) ?? isset($finalMsg)) : ;?>
            <p class="fs-1"><?= $errorsMsg['id'] ?? $finalMsg['failed'] ?? $finalMsg['success'] ?? '' ;?></p>
        <?php endif ;?>
    </div>
</main>
</body>
</html>