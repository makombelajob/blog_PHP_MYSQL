<?php
require_once 'includes/dbconnect.php';
global $pdo;
$errorsInput = $finalMsg = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nameCategory = htmlspecialchars(trim($_POST['category'])) ?? '';
    if(empty($nameCategory) || strlen($nameCategory) < 5){
        $errorsInput['categoryError'] = 'Veuillez entrer un nom';
    }
    if(empty($errorsInput)){


        // Insert into database
        $sql = 'INSERT INTO categories(name) VALUES (:name_category);';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name_category', $nameCategory, PDO::PARAM_STR);
        $exec = $stmt->execute();
        if($exec){
            $finalMsg['success'] = 'Ajout réussit dans la base';
            header('Refresh:3; url=home.php');
        }
    }else{
        $finalMsg['failed'] = 'L\'ajout de la catégorie a échoué';
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">

    <title>Document</title>
</head>
<body>
    <main class="container">
        <h1 class="fs-1 text-center text-uppercase my-3">Ajouter une catégorie</h1>
        <form action="" method="post" class="w-75 m-auto">
            <div class="name">
                <label class="form-label" for="name">Nom</label>
                <input class="form-control fs-5" type="text" id="name" name="category" placeholder="Entre la catégorie ici"/>
                <?php if(isset($errorsInput['categoryError'])) : ;?>
                    <p class="fs-1 text-danger"><?= $errorsInput['categoryError'];?></p>
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