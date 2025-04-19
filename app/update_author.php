<?php
global $pdo;
require_once 'includes/dbconnect.php';
$errorInput = $finalMsg = [];
// Recupération de l'id dans un url
$idUser = $_GET['id'];
if(!is_numeric($idUser)){
    $finalMsg['bad_request'] = 'l\'url n\'est pas valide';
}else{
    $sql = 'SELECT * FROM authors WHERE id = :id_user;';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id_user', $idUser, PDO::PARAM_INT);
    $stmt->execute();
    /** @var array $author */
    $author = $stmt->fetch();
    if(!$author){
        $finalMsg['noAuthor'] = 'Author not found !';
    }else{
        $finalMsg['author'] = 'Author found !!!';
        // Verification du changement de l'auteur
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $lastname = htmlspecialchars(trim($_POST['lastname']));
            $firstname = htmlspecialchars(trim($_POST['firstname']));
            $email = $_POST['email'];
            if(empty($lastname) || strlen($lastname) > 50) {
                $errorInput['lastNError'] = 'Le nom doit être valide';
            }
            if(empty($firstname) || strlen($firstname) > 50) {
                $errorInput['firstNError'] = 'Le prénom doit être valide';
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errorInput['email'] = 'L\'email doit être valide';
            }
            if(empty($errorInput)){
                // Modification de l'auteur
                $sql = 'UPDATE authors SET lastname = :last_name, firstname = :first_name, email = :email WHERE id = :id_user;';
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':last_name', $lastname, PDO::PARAM_STR);
                $stmt->bindValue(':first_name', $firstname, PDO::PARAM_STR);
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->bindValue('id_user', $idUser, PDO::PARAM_INT);
                $exec = $stmt->execute();

                $finalMsg['success'] = 'Updated authors';
            }else{
                $finalMsg['failed'] = 'Updated Failed';
            }
        }

    }

    // Verification de champs avant la modification

}
require_once 'includes/header.php';
?>
<body>
    <main class="container my-5">
        <div class="my-3 bg-warning rounded">
            <?php if(isset($finalMsg['bad_request']))  : ;?>
                <p class="text-danger fs-2 px-3"><?= $finalMsg ? $finalMsg['bad_request'] : '' ;?></p>
            <?php endif; ?>
        </div>
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
            <div class="hidden">
                <input type="hidden" name="id" value="<?= $author['id'] ;?>">
            </div>
            <div class="text-center">
                <button class="btn btn-primary fs-1" type="submit">Modifier</button>
            </div>
        </form>
        <div class="my-3 bg-warning rounded">
            <?php $message = $finalMsg['success'] ?? $finalMsg['failed'] ?? $finalMsg['noAuthor'] ?? $finalMsg['author'] ?? '';
            if(!empty($message)) : ?>
                <p class="fs-1 p-3"><?= $finalMsg['success'] ?? $finalMsg['failed'] ?? $finalMsg['noAuthor'] ?? $finalMsg['author']  ?? '';?></p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
