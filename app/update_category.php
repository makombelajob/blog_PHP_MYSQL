<?php
global $pdo;
require_once 'includes/dbconnect.php';

$errorsInput = $finalMsg = [];
$idUser = $_GET['id'];
if(!is_numeric($idUser)){
    $finalMsg['noUrl'] = 'Url not found';
}else{
    $sql = 'SELECT name, description FROM categories WHERE id = :id_user;';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id_user', $idUser, PDO::PARAM_INT);
    $stmt->execute();
    $cat = $stmt->fetch();
    $finalMsg['url'] = 'Good url ! 🌏';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nameCategory = htmlspecialchars(trim($_POST['category_name']));
        $description = htmlspecialchars(trim($_POST['description']));

        // verification du contenu des champs
        if(empty($nameCategory) || strlen($nameCategory) > 50){
            $errorsInput['descriptionName'] = 'Le nom doit être correcte';
        }
        if(!empty($errorsInput)){
            $finalMsg['failed'] = 'Check all before modification';
        }else{
            $sql = 'UPDATE categories SET name = :name, description = :description WHERE id = :id_user;';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':name', $nameCategory, PDO::PARAM_STR);
            $stmt->bindValue(':description', $description, PDO::PARAM_STR);
            $stmt->bindValue(':id_user', $idUser, PDO::PARAM_INT);
            $exec = $stmt->execute();
            if(!$exec){
                $finalMsg['failed'] = 'Update failed !!!';
            }else{
                $finalMsg['success'] = 'Updated category';
            }
        }
    }

}
require_once 'includes/header.php';
?>

<body>
<main class="container">
    <h1 class="fs-1 text-center text-uppercase my-3">Modifier une catégorie</h1>
    <form action="" method="post" class="w-75 m-auto">
        <div  class="fs-1">
            <label class="form-label" for="name">Nom</label>
            <input class="form-control fs-5" type="text" id="name" name="category_name" placeholder="Entre la catégorie ici" value="<?= $cat['name'] ;?>"/>
            <?php if(isset($errorsInput['descriptionName'])) : ;?>
                <p class="fs-1 text-danger"><?= $errorsInput['descriptionName'];?></p>
            <?php endif ;?>
        </div>
        <div class="fs-1">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" cols="30" rows="10" class="form-control fs-3" placeholder="Veuillez entré une catégorie" value="<?= $cat['description'] ;?>"></textarea>
            <?php if(isset($errorsInput['description'])) : ;?>
                <p class="fs-1 text-danger"><?= $errorsInput['description'];?></p>
            <?php endif ;?>
        </div>
        <div class="text-center my-3">
            <button class="btn btn-primary" type="submit">Modifier</button>
        </div>
    </form>
    <div class="text-center bg-warning rounded-3">
        <?php $msg = $finalMsg['success'] ?? $finalMsg['failed'] ?? $finalMsg['noUrl'] ?? $finalMsg['url'] ?? '' ;
        if(!empty($msg)) : ?>
            <p class="fs-1"><?= $finalMsg['success'] ?? $finalMsg['failed'] ?? $finalMsg['noUrl'] ?? $finalMsg['url'] ?? '' ;?></p>
        <?php endif ;?>
    </div>
</main>
</body>
</html>
