<?php
global $pdo;
require_once 'includes/dbconnect.php';
$errorsInput = $finalMsg = [];
$id = $_GET['id'];
$sql = 'SELECT id, title, created_at, content FROM posts WHERE id = :post_id;';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':post_id', $id,PDO::PARAM_INT);
$stmt->execute();
$post = $stmt->fetch();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = htmlspecialchars(trim($_POST['category'])) ?? '';
    $description = htmlspecialchars($_POST['description']) ?? '';

    if(empty($name) || strlen($name) > 50) {
        $errorsInput['name'] = 'Le nom doit être valide !';
    }
    try{

    }catch (PDOException $e){
        $finalMsg['failed'] = $e->getMessage();
    }
}
require_once 'includes/header.php';
?>
<body>
<main class="container">
    <h1 class="fs-1 text-center text-uppercase my-3">Ajouter Une déscription</h1>
    <form action="" method="post" class="w-75 m-auto">
        <div  class="fs-1">
            <label class="form-label" for="name">Nom</label>
            <input class="form-control fs-3" type="text" id="name" name="category" placeholder="Entre la catégorie ici" value="<?= $post['title'] ;?>"/>
            <?php if(isset($errorsInput['categoryError'])) : ;?>
                <p class="fs-1 text-danger"><?= $errorsInput['categoryError'];?></p>
            <?php endif ;?>
        </div>
        <div class="fs-1">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" cols="30" rows="10" class="form-control fs-3" placeholder="Veuillez entré une catégorie" ><?= $post['content'] ;?></textarea>
            <?php if(isset($errorsInput['descriptionError'])) : ;?>
                <p class="fs-1 text-danger"><?= $errorsInput['descriptionError'];?></p>
            <?php endif ;?>
        </div>
        <div class="text-center my-3">
            <button class="btn btn-primary" type="submit">Ajouter</button>
        </div>
    </form>
    <div class="text-center bg-warning rounded-3">
        <?php if(isset($finalMsg) ?? '' ) : ;?>
            <p><?= $finalMsg['failed'] ?? $finalMsg['success'] ?? '';?></p>
        <?php endif ;?>
    </div>
</main>
</body>
</html>
