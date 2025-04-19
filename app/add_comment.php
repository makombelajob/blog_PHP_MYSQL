<?php
global $pdo;
require_once 'includes/dbconnect.php';
$errorsInput = $finalMsg = [];
$idUser = 1;
$sql = 'SELECT name FROM categories WHERE id = :id_user;';
$stmt = $pdo->prepare($sql);

require_once 'includes/header.php';
?>
<body>
<main class="container">
    <h1 class="fs-1 text-center text-uppercase my-3">Modifier Une déscription</h1>
    <form action="" method="post" class="w-75 m-auto">
        <div  class="fs-1">
            <label class="form-label" for="name">Nom</label>
            <input class="form-control fs-5" type="text" id="name" name="category" placeholder="Entre la catégorie ici"/>
            <?php if(isset($errorsInput['categoryError'])) : ;?>
                <p class="fs-1 text-danger"><?= $errorsInput['categoryError'];?></p>
            <?php endif ;?>
        </div>
        <div class="fs-1">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" cols="30" rows="10" class="form-control fs-3" placeholder="Veuillez entré une catégorie"></textarea>
            <?php if(isset($errorsInput['descriptionError'])) : ;?>
                <p class="fs-1 text-danger"><?= $errorsInput['descriptionError'];?></p>
            <?php endif ;?>
        </div>
        <div class="text-center my-3">
            <button class="btn btn-primary" type="submit">Ajouter</button>
        </div>
    </form>
    <div class="text-center bg-warning rounded-3">
        <?php $msg = $finalMsg['success'] ?? $finalMsg['failed'] ?? '' ;
        if(!empty($msg)) : ?>
            <p class="fs-1"><?= $finalMsg['success'] ?? $finalMsg['failed'] ?? '' ;?></p>
        <?php endif ;?>
    </div>
</main>
</body>
</html>
