<?php
global $pdo;
require_once 'includes/dbconnect.php';

$sql = 'SELECT name, description FROM categories WHERE id = 5;';
$stmt = $pdo->query($sql);
$cat = $stmt->fetch();

$errorsInput = $finalMsg = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $descriptionName = htmlspecialchars(trim($_POST['category_name'])) ?? '';
    $description = htmlspecialchars($_POST['description']) ?? '';

    if(empty($descriptionName) || strlen($descriptionName) > 50){
        $errorsInput['descriptionName'] = 'Le nom doit être valide';
    }

    if(strlen($description) > 255){
        $errorsInput['description'] = 'Pas plus de 255 caractères';
    }

    if(empty($errorsInput)){

        $sql = "INSERT INTO categories(name, description) VALUES (:name,:description);";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $descriptionName, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $exec = $stmt->execute();
        if($exec){
            $finalMsg['success'] = 'Modification faites';
        }
    }else{
        $finalMsg['failed'] = 'Modification à échoué';
    }
}
require_once 'includes/header.php';
?>

<body>
<main class="container">
    <h1 class="fs-1 text-center text-uppercase my-3">Ajouter une catégorie</h1>
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
