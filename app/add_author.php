<?php
global $errorInput, $pdo;
require_once 'includes/dbconnect.php';
require_once 'includes/add_user.php';

$errorInput = $finalMsg =  [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $lastname = htmlspecialchars(trim($_POST['lastname'])) ?? '';
    $firstname = htmlspecialchars(trim($_POST['firstname'])) ?? '';
    $email = $_POST['email'] ?? '';

    // Verification du nom
    if (empty($lastname) || strlen($lastname) > 50) {
        $errorInput['lastNError'] = 'Le nom doit être valide';
    }

    // Verification of the firstname
    if (empty($firstname) || strlen($firstname) > 50) {
        $errorInput['firstNError'] = 'Le prénom doit être valide';
    }

    // Verification of email
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errorInput['emailError'] = 'Vous devez entrer un email valide';
    }
    // Query request code line
    if(empty($errorInput)){
        $sql = 'INSERT INTO authors (lastname, firstname, email) VALUES(:lastname, :firstname, :email);';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $exec = $stmt->execute();
        if($exec){
            $lastname = $firstname = $email = '';
            $finalMsg['success'] = 'Inscription réussie';
            header('Refresh:3; url=index.php');
        }else{
            $finalMsg['failed'] = 'L\'inscription a échoué';
        }
    }
} else {
    $finalErrors['failedConnect'] = 'Failed to connect';
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
        <h2 class="text-center text-uppercase fs-1">Ajouter un Auteur</h2>
        <form action="" method="post" class="w-75 m-auto">
            <div class="lastname">
                <label class="form-label fs-3 text-uppercase" for="lastname">Nom</label>
                <input class="form-control my-3" id="lastname" type="text" name="lastname" value="<?= $lastname ?? '' ;?>"/>
                <?php if(isset($errorInput['lastNError'])) : ;?>
                    <p class="fs-2 text-danger"><?= $errorInput['lastNError'] ;?></p>
                <?php endif ;?>
            </div>
            <div class="firstname">
                <label class="form-label fs-3 text-uppercase" for="firstname">Prénom</label>
                <input class="form-control my-3" id="firstname" type="text" name="firstname" value="<?= $firstname ?? '' ;?>"/>
                <?php if(isset($errorInput['firstNError'])) : ;?>
                    <p class="fs-2 text-danger"><?= $errorInput['firstNError'] ;?></p>
                <?php endif ;?>
            </div>
            <div class="email">
                <label class="form-label fs-3 text-uppercase" for="email">Email</label>
                <input class="form-control my-3" id="email" type="text" name="email" value="<?= $email ?? '' ;?>"/>
                <?php if(isset($errorInput['emailError'])) : ;?>
                    <p class="fs-2 text-danger"><?= $errorInput['emailError'] ;?></p>
                <?php endif ;?>
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
