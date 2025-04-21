<?php
global $pdo;
require_once 'includes/dbconnect.php';
$errorsMsg = $finalMsg = [];
$id = $_GET['id'];
if(is_numeric($id)){
    try {
        // commande sql
        $sql = 'SELECT name, description FROM categories WHERE id = :category_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':category_id', $id, PDO::PARAM_INT);
        $exec = $stmt->execute();
        if($exec){
            $finalMsg['successBind'] = 'Category founded !';
            $category = $stmt->fetch();
        }

    }catch(PDOException $e){
        $errorsMsg['id'] = $e->getMessage();
        $finalMsg['failedBind'] = 'Category not found !';
    }

}

require_once 'includes/header.php';
?>
    <main class="container mt-3">
        <h1 class="text-uppercase text-center my-3">Supprimer une catégorie</h1>
        <form action="" method="post">
            <div class="name">
                <label class="form-label" for="name">Nom</label>
                <input class="form-control" type="text" name="name" placeholder="Veuillez Entrer le nom" value="<?= $category['name'] ;?>"/>
            </div>
            <div class="description">
                <label class="form-label" for="description">Description</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="10" value="<?= $category['description'] ;?>"></textarea>
            </div>
            <div class="text-center m-4">
                <button class="btn btn-danger" type="submit">Suppression</button>
            </div>
        </form>
        <div class="text-center bg-warning rounded-3">
            <?php if(isset($errorsMsg) || isset($finalMsg)) : ;?>
                <p><?= $errorsMsg['id'] ?? $finalMsg['successBind'] ?? $finalMsg['failedBind'] ?? '' ;?></p>
            <?php endif;?>
        </div>
    </main>
</body>
</html>
