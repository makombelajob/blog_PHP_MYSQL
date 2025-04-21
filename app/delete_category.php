<?php
global $pdo;
require_once 'includes/dbconnect.php';
$errorsMsg = $finalMsg = [];
$id = $_GET['id'];
if(!is_numeric($id)){
    $errorsMsg['idPlaced'] = 'Checking failed !!!';
}else{
    $sql = 'SELECT id,name FROM categories WHERE id = :category_id;';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':category_id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch();

    // verification of inputs
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $categoryName = htmlspecialchars(trim($_POST['name'])) ?? '';
        if(empty($categoryName) || strlen($categoryName) > 50){
            $errorsMsg['name'] = 'Le nom doit être valide !';
        }
        if(!empty($errorsMsg)){
            $finalMsg['failed'] = 'Veuillez suivre les instructions !';
        }else{
            // sql commande
            try{
                $sql = 'DELETE FROM posts_categories WHERE categories_id = :post_category_id;';
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':post_category_id', $id, PDO::PARAM_INT);
                $execPost = $stmt->execute();

                $sql = 'DELETE FROM categories WHERE id = :category_id;';
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':category_id', $id, PDO::PARAM_INT);
                $exeCategory = $stmt->execute();

                if(!$exeCategory || !$execPost){
                    $finalMsg['failedDelete'] = 'La suppression a échouée ! 🤦‍♂️';
                }else{
                    $finalMsg['successDelete'] = 'La suppression a réussit ! 👍💾🌏';
                    header('Refresh:3; url=index.php');
                }
            }catch (PDOException $e){
                $finalMsg['failedDelete'] = $e->getMessage();

            }

        }
    }
}

require_once 'includes/header.php';
?>
    <main class="container mt-3">
        <h1 class="text-uppercase text-center my-3">Supprimer une catégorie</h1>
        <form action="" method="post">
            <div class="name">
                <label class="form-label" for="name">Nom</label>
                <input id="<?= $category['id'] ;?>" class="form-control" type="text" name="name" placeholder="Veuillez Entrer le nom"  value="<?= $category['name'] ?? '' ;?>"/>
                <?php if(isset($errorsMsg) ?? '') : ;?>
                    <p class="text-center text-danger"><?= $errorsMsg['name'] ?? '';?></p>
                <?php endif;?>
            </div>
            <div class="my-2">
                <label class="form-label" for="description">Description</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
            </div>
            <div class="text-center m-4">
                <button class="btn btn-danger" type="submit">Suppression</button>
            </div>
        </form>
        <div class="text-center bg-warning rounded-3">
            <?php if(isset($errorsMsg) ?? isset($finalMsg) ?? '') : ;?>
                <p><?= $errorsMsg['idPlaced'] ?? $finalMsg['failed'] ?? $finalMsg['failedDelete'] ?? $finalMsg['successDelete'] ?? '' ;?></p>
            <?php endif;?>
        </div>
    </main>
</body>
</html>
