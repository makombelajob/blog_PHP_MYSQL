<?php
require_once 'includes/dbconnect.php';
global $pdo;
$sql = 'SELECT name FROM categories WHERE id = 3;';
$stmt = $pdo->query($sql);
$category = $stmt->fetch();

$errorsInput = $finalMsg = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nameCategory = htmlspecialchars(trim($_POST['category'])) ?? '';
    if(empty($nameCategory) || strlen($nameCategory) < 5){
        $errorsInput['categoryError'] = 'Veuillez entrer un nom';
    }

    $description = htmlspecialchars($_POST['description']);
    if(strlen($description) > 255){
        $errorsInput['descriptionError'] = 'la description ne doit pas être > 255';
    }
    if(empty($errorsInput)){

        // Insert into database
        $sql = 'INSERT INTO categories(name, description) VALUES (:name_category, :description);';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name_category', $nameCategory, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $exec = $stmt->execute();
        if($exec){
            $finalMsg['success'] = 'Ajout réussit dans la base';
            header('Refresh:3; url=home.php');
        }
    }else{
        $finalMsg['failed'] = 'L\'ajout de la catégorie a échoué';
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
                <input class="form-control fs-5" type="text" id="name" name="category" placeholder="Entre la catégorie ici" value="<?= $category['name'] ;?>"/>
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