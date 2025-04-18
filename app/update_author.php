<?php
global $pdo;
require_once 'includes/dbconnect.php';
$sql = 'SELECT lastname, firstname, email FROM authors WHERE id = 1;';
$stmt = $pdo->query($sql);
$author = $stmt->fetch();

// Verification du formulaire avant toute modification et enregistrement
$errorInput = $finalMsg = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $lastName = htmlspecialchars(trim($_POST['lastname']));
    $firstName = htmlspecialchars(trim($_POST['firstname']));
    $email = $_POST['email'];

    // Verification of lastname
    if(empty($lastName) || strlen($lastName) > 50) {
        $errorInput['lastNError'] = 'Veuillez entre un nom valide';
    }

    // Verification of firstname
    if(empty($firstName) || strlen($firstName) > 50) {
        $errorInput['firstNError'] = 'Veuillez entre un prénom valide';
    }

    //Verification of email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errorInput['email'] = 'Le mail doit être valide';
    }
    if(empty($errorInput)){

        $sql = "UPDATE authors SET lastname = :last_name, firstname = :first_name, email = :email WHERE id = 1;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':last_name', $lastName, PDO::PARAM_STR);
        $stmt->bindValue(':first_name', $firstName, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $exec = $stmt->execute();
        if($exec){
            $finalMsg['success'] = 'Mise à jour réussit';
            header('Refresh:3; url=authors.php');
        }else{
            $finalMsg['failed'] = 'Mise à jour à échouer';
        }
    }else{
        $finalMsg['failedALL'] = 'Modification échouée';
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
        <h1 class="text-center text-uppercase fs-1">Ajouter un Auteur</h1>
        <form action="" method="post" class="w-75 m-auto">
            <div class="lastname">
                <label class="form-label fs-3 text-uppercase" for="lastname">Nom</label>
                <input class="form-control my-3" id="lastname" type="text" name="lastname" value="<?= $author['lastname'] ?? '' ;?>"/>
                <?php if(isset($errorInput['lastNError'])) : ;?>
                    <p class="text-danger"><?= $errorInput['lastNError'] ;?></p>
                <?php endif; ?>

            </div>
            <div class="firstname">
                <label class="form-label fs-3 text-uppercase" for="firstname">Prénom</label>
                <input class="form-control my-3" id="firstname" type="text" name="firstname" value="<?= $author['firstname'] ?? '' ;?>"/>
                <?php if(isset($errorInput['firstNError'])) : ;?>
                    <p class="text-danger"><?= $errorInput['firstNError'] ;?></p>
                <?php endif; ?>

            </div>
            <div class="email">
                <label class="form-label fs-3 text-uppercase" for="email">Email</label>
                <input class="form-control my-3" id="email" type="text" name="email" value="<?= $author['email'] ?? '' ;?>"/>
                <?php if(isset($errorInput['email'])) : ;?>
                    <p class="text-danger"><?= $errorInput['email'] ;?></p>
                <?php endif; ?>

            </div>
            <div class="text-center">
                <button class="btn btn-primary fs-1" type="submit">Ajouter</button>
            </div>
        </form>
        <div class="my-3 bg-warning rounded">
            <?php $message = $finalMsg['success'] ?? $finalMsg['failed'] ?? '';
            if(!empty($message)) : ?>
                <p class="fs-1 p-3"><?= $finalMsg['success'] ?? $finalMsg['failed'] ?? '';?></p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
